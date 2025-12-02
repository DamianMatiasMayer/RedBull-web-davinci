<?php
@session_start();

$user      = $_SESSION['usuario']      ?? null;
$tipo_user = $_SESSION['tipo_usuario'] ?? null;

if (!$tipo_user || !in_array($tipo_user, ['1','2'], true)) {
  header('Location: login.php');
  exit;
}

require 'db_conn.php';

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/**
 * Devuelve la ruta relativa de la imagen principal del producto (si existe),
 * buscando en uploads/products/{id}/ main.webp|jpg|png o 1.webp|jpg|png.
 * Si no hay, devuelve un placeholder.
 */
function imagen_principal(int $id): string {
  $baseAbs = __DIR__ . "/uploads/products/$id/";
  $baseRel = "uploads/products/$id/";
  $candidatas = ['main.webp','main.jpg','main.png','1.webp','1.jpg','1.png'];
  foreach ($candidatas as $f) {
    if (is_file($baseAbs.$f)) return $baseRel.$f;
  }
  return 'imagenes/placeholder.webp';
}

/** Guarda la imagen subida (input "imagen") como main.{ext} para el producto $id */
function guardar_imagen_main(int $id, array &$errores): void {
  if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE) return;

  $f = $_FILES['imagen'];
  if ($f['error'] !== UPLOAD_ERR_OK) { $errores[] = 'Error al subir la imagen.'; return; }

  $permitidas = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
  $mime = @mime_content_type($f['tmp_name']);
  if (!$mime || !isset($permitidas[$mime])) { $errores[] = 'Formato no permitido (JPG/PNG/WEBP).'; return; }

  if ($f['size'] > 3*1024*1024) { $errores[] = 'La imagen no puede superar 3 MB.'; return; }

  $dirAbs = __DIR__ . "/uploads/products/$id";
  if (!is_dir($dirAbs)) { @mkdir($dirAbs, 0775, true); }

  // borrar main.* previo si existe
  foreach (['webp','jpg','jpeg','png'] as $e) {
    $old = "$dirAbs/main.$e";
    if (is_file($old)) @unlink($old);
  }

  $ext = $permitidas[$mime];
  $destAbs = "$dirAbs/main.$ext";

  if (!@move_uploaded_file($f['tmp_name'], $destAbs)) {
    $errores[] = 'No se pudo guardar la imagen en disco.';
  }
}

/* Cargar categorías para el select */
$categorias = [];
if ($resCat = $conexion->query("SELECT id, nombre FROM categoria ORDER BY nombre")) {
  $categorias = $resCat->fetch_all(MYSQLI_ASSOC);
}

/* Acciones  */
$errores = [];
$msg = $_GET['msg'] ?? null;

/* ====== FILTROS Y PAGINACIÓN (GET) ====== */
$busqueda        = trim($_GET['busqueda'] ?? '');
$filtroCategoria = $_GET['filtro_categoria'] ?? '';
$filtroEstado    = $_GET['filtro_estado'] ?? ''; // '', '1', '0'

$pagina    = max(1, (int)($_GET['pagina'] ?? 1));
$porPagina = 8; // productos por página

// Armamos el WHERE dinámico
$where = " WHERE 1=1 ";

if ($busqueda !== '') {
  $busqEsc = $conexion->real_escape_string($busqueda);
  $where .= " AND (p.nombre LIKE '%$busqEsc%' OR p.descripcion LIKE '%$busqEsc%')";
}

if ($filtroCategoria !== '' && ctype_digit($filtroCategoria)) {
  $catId = (int)$filtroCategoria;

  // 1) arrancamos con el ID elegido
  $ids = [$catId];

  // 2) buscamos hijos directos de esa categoría
  $stmt = $conexion->prepare("SELECT id FROM categoria WHERE padre_id = ?");
  $stmt->bind_param("i", $catId);
  $stmt->execute();
  $resHijos = $stmt->get_result();

  while ($row = $resHijos->fetch_assoc()) {
    $ids[] = (int)$row['id'];
  }
  $stmt->close();

  // 3) armamos la lista para el IN (ej: 3,5,7)
  $listaIds = implode(',', $ids);

  // 4) filtramos por esa lista (padre + hijos)
  $where .= " AND p.categoria_id IN ($listaIds)";
}


if ($filtroEstado === '1' || $filtroEstado === '0') {
  $est = (int)$filtroEstado;
  $where .= " AND p.activo = $est";
}

// Total de registros con esos filtros
$sqlTotal = "SELECT COUNT(*) AS total FROM producto p $where";
$resTotal = $conexion->query($sqlTotal);
$totalReg = $resTotal ? (int)$resTotal->fetch_assoc()['total'] : 0;

$totalPaginas = max(1, (int)ceil($totalReg / $porPagina));
if ($pagina > $totalPaginas) {
  $pagina = $totalPaginas;
}
$offset = ($pagina - 1) * $porPagina;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  /* Alta */
  if (isset($_POST['crear_producto'])) {
    $nombre      = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio      = (float)($_POST['precio'] ?? 0);
    $stock       = (int)($_POST['stock'] ?? 0);
    $activo      = isset($_POST['activo']) ? 1 : 0;

    // categoria_id (nullable) -> dos variantes de consulta
    $catRaw = $_POST['categoria_id'] ?? '';
    $categoria = ($catRaw === '' ? null : (int)$catRaw);

    if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
    if ($precio < 0)    $errores[] = 'El precio no puede ser negativo.';
    if ($stock < 0)     $errores[] = 'El stock no puede ser negativo.';

    if (!$errores) {
      if ($categoria === null) {
        $stmt = $conexion->prepare(
          "INSERT INTO producto (nombre, descripcion, precio, stock, categoria_id, activo)
           VALUES (?, ?, ?, ?, NULL, ?)"
        );
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $activo);
      } else {
        $stmt = $conexion->prepare(
          "INSERT INTO producto (nombre, descripcion, precio, stock, categoria_id, activo)
           VALUES (?, ?, ?, ?, ?, ?)"
        );
         $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $stock, $categoria, $activo);
      }

      $ok = $stmt->execute();
      $newId = $stmt->insert_id;
      $stmt->close();

      if ($ok && $newId > 0) {
        guardar_imagen_main($newId, $errores); // opcional: si subieron imagen
        if (!$errores) {
          header('Location: productos-admin.php?msg=creado');
          exit;
        }
      }
      if (!$ok) $errores[] = 'No se pudo crear el producto.';
    }
  }

  /* ---- Edición ---- */
  if (isset($_POST['editar_producto'])) {
    $id          = (int)($_POST['id'] ?? 0);
    $nombre      = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio      = (float)($_POST['precio'] ?? 0);
    $stock       = (int)($_POST['stock'] ?? 0);
    $activo      = isset($_POST['activo']) ? 1 : 0;

    $catRaw    = $_POST['categoria_id'] ?? '';
    $categoria = ($catRaw === '' ? null : (int)$catRaw);

    if ($id <= 0)       $errores[] = 'ID inválido.';
    if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
    if ($precio < 0)    $errores[] = 'El precio no puede ser negativo.';
    if ($stock < 0)     $errores[] = 'El stock no puede ser negativo.';

    if (!$errores) {
      if ($categoria === null) {
        $stmt = $conexion->prepare(
          "UPDATE producto
             SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=NULL, activo=?
           WHERE id=?"
        );
        $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $stock, $activo, $id);
      } else {
        $stmt = $conexion->prepare(
          "UPDATE producto
             SET nombre=?, descripcion=?, precio=?, stock=?, categoria_id=?, activo=?
           WHERE id=?"
        );
        $stmt->bind_param("ssdiiii", $nombre, $descripcion, $precio, $stock, $categoria, $activo, $id);
      }

      $ok = $stmt->execute();
      $stmt->close();

      if ($ok) {
        // si subieron nueva imagen, reemplaza main.*
        guardar_imagen_main($id, $errores);
        if (!$errores) {
          header('Location: productos-admin.php?msg=editado');
          exit;
        }
      } else {
        $errores[] = 'No se pudo editar el producto.';
      }
    }
  }

  /*  Activar / Desactivar (baja lógica)  */
  if (isset($_POST['toggle_activo'])) {
    $id = (int)($_POST['id'] ?? 0);
    $nuevoEstado = (int)($_POST['nuevo_estado'] ?? 0);
    if ($id > 0) {
      $stmt = $conexion->prepare("UPDATE producto SET activo=? WHERE id=?");
      $stmt->bind_param("ii", $nuevoEstado, $id);
      $ok = $stmt->execute();
      $stmt->close();

      header('Location: productos-admin.php?msg=' . ($ok ? 'estado' : 'error'));
      exit;
    } else {
      $errores[] = 'ID inválido para cambiar estado.';
    }
  }
}

/*  Cargar producto para edición  */
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editProd = null;
if ($editId > 0) {
  $stmt = $conexion->prepare("SELECT * FROM producto WHERE id=?");
  $stmt->bind_param("i", $editId);
  $stmt->execute();
  $editProd = $stmt->get_result()->fetch_assoc();
  $stmt->close();
}


/*  Listado con filtros + paginación  */
$sqlListado = "SELECT p.*, c.nombre AS categoria_nombre
               FROM producto p
               LEFT JOIN categoria c ON c.id = p.categoria_id
               $where
               ORDER BY p.id DESC
               LIMIT $porPagina OFFSET $offset";
$resListado = $conexion->query($sqlListado);
$productos = $resListado ? $resListado->fetch_all(MYSQLI_ASSOC) : [];


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Productos - Admin</title>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/productos-admin.css" />
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
  <?php include 'nav.php'; ?>

  <main class="container">
    <h1>Productos – Admin</h1>

    <?php if ($msg === 'creado'):   ?><div class="msg ok">✅ Producto creado.</div><?php endif; ?>
    <?php if ($msg === 'editado'):  ?><div class="msg ok">✅ Producto editado.</div><?php endif; ?>
    <?php if ($msg === 'estado'):   ?><div class="msg ok">🔁 Estado actualizado.</div><?php endif; ?>
    <?php if ($msg === 'error'):    ?><div class="msg err"> Ocurrió un error.</div><?php endif; ?>

    <?php if ($errores): ?>
      <div class="msg err">
        <?php foreach ($errores as $e) echo '<div>'.h($e).'</div>'; ?>
      </div>
    <?php endif; ?>

    <div class="grid">
      <!-- ====== Formulario ====== -->
      <form class="card" method="post" enctype="multipart/form-data" action="productos-admin.php<?php echo $editProd ? '?edit='.$editProd['id'] : '' ?>">
        <h2><?php echo $editProd ? 'Editar producto #'.h($editProd['id']) : 'Crear producto'; ?></h2>

        <?php if ($editProd): ?>
          <input type="hidden" name="id" value="<?php echo (int)$editProd['id']; ?>">
        <?php endif; ?>

        <div class="row">
          <div>
            <label>Nombre *</label>
            <input type="text" name="nombre" required value="<?php echo h($editProd['nombre'] ?? '') ?>">
          </div>
          <div>
            <label>Categoría</label>
            <select name="categoria_id">
              <option value="">(Sin categoría)</option>
              <?php foreach ($categorias as $c): ?>
                <option value="<?php echo (int)$c['id']; ?>"
                  <?php if (($editProd['categoria_id'] ?? '') == $c['id']) echo 'selected'; ?>>
                  <?php echo h($c['nombre']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div>
          <label>Descripción</label>
          <textarea name="descripcion" rows="3"><?php echo h($editProd['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="row-3">
          <div>
            <label>Precio *</label>
            <input type="number" name="precio" step="0.01" min="0" required value="<?php echo h($editProd['precio'] ?? '0') ?>">
          </div>
          <div>
            <label>Stock *</label>
            <input type="number" name="stock" min="0" required value="<?php echo h($editProd['stock'] ?? '0') ?>">
          </div>
          <div style="display:flex;align-items:center;gap:8px;margin-top:24px">
            <input type="checkbox" id="activo" name="activo" <?php echo (($editProd['activo'] ?? 1) ? 'checked':''); ?>>
            <label for="activo">Activo</label>
          </div>
        </div>

        <div class="row">
          <div>
            <label>Imagen principal (JPG/PNG/WEBP, máx 3MB)</label>
            <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp">
          </div>
          <div>
            <?php if ($editProd): ?>
              <label>Vista actual</label>
              <img class="thumb" src="<?php echo h(imagen_principal((int)$editProd['id'])); ?>" alt="Imagen actual">
            <?php endif; ?>
          </div>
        </div>

        <div style="display:flex;gap:8px;margin-top:12px">
          <?php if ($editProd): ?>
            <button class="btn btn-primary" type="submit" name="editar_producto">Guardar cambios</button>
            <a class="btn btn-secondary" href="productos-admin.php">Cancelar</a>
          <?php else: ?>
            <button class="btn btn-primary" type="submit" name="crear_producto">Crear</button>
            <button class="btn" type="reset">Limpiar</button>
          <?php endif; ?>
        </div>
      </form>

      <!-- ====== Listado ====== -->
      <div class="card">
        <h2>Listado</h2>
        <!-- Filtros -->
        <form class="filtros" method="get" action="productos-admin.php">
          <div class="row">
            <div>
              <label for="busqueda">Buscar</label>
              <input
                type="text"
                id="busqueda"
                name="busqueda"
                placeholder="Nombre o descripción"
                value="<?php echo h($busqueda); ?>"
              >
            </div>

            <div>
              <label for="filtro_categoria">Categoría</label>
              <select id="filtro_categoria" name="filtro_categoria">
                <option value="">Todas</option>
                <?php foreach ($categorias as $c): ?>
                  <option value="<?php echo (int)$c['id']; ?>"
                    <?php if ($filtroCategoria !== '' && (int)$filtroCategoria === (int)$c['id']) echo 'selected'; ?>>
                    <?php echo h($c['nombre']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label for="filtro_estado">Estado</label>
              <select id="filtro_estado" name="filtro_estado">
                <option value="">Todos</option>
                <option value="1" <?php if ($filtroEstado === '1') echo 'selected'; ?>>Activos</option>
                <option value="0" <?php if ($filtroEstado === '0') echo 'selected'; ?>>Inactivos</option>
              </select>
            </div>
          </div>

          <div class="row" style="margin-top:10px; gap:8px;">
            <button class="btn btn-primary" type="submit">Aplicar filtros</button>
            <a class="btn btn-secondary" href="productos-admin.php">Limpiar</a>
          </div>
        </form>

        <?php if (!$productos): ?>
          <p>No hay productos cargados.</p>
        <?php else: ?>
          <table>

            <thead>
              <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Img</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $p): ?>
              <tr>
                <td><?php echo (int)$p['id']; ?></td>
                <td>
                  <strong><?php echo h($p['nombre']); ?></strong><br>
                  <small><?php echo h(mb_strimwidth($p['descripcion'] ?? '', 0, 90, '…')); ?></small>
                </td>
                <td><?php echo h($p['categoria_nombre'] ?? '—'); ?></td>
                <td>$<?php echo number_format((float)$p['precio'], 2, ',', '.'); ?></td>
                <td><?php echo (int)$p['stock']; ?></td>
                <td>
                  <?php if ((int)$p['activo'] === 1): ?>
                    <span class="badges ok">Activo</span>
                  <?php else: ?>
                    <span class="badges off">Inactivo</span>
                  <?php endif; ?>
                </td>
                <td>
                  <img class="thumb" src="<?php echo h(imagen_principal((int)$p['id'])); ?>" alt="img">
                </td>
                <td class="actions">
                  <a class="btn btn-secondary" href="productos-admin.php?edit=<?php echo (int)$p['id']; ?>">Editar</a>
                  <form action="productos-admin.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>">
                    <input type="hidden" name="nuevo_estado" value="<?php echo (int)!$p['activo']; ?>">
                    <button class="btn <?php echo $p['activo'] ? 'btn-warning' : 'btn-success'; ?>" type="submit" name="toggle_activo">
                      <?php echo $p['activo'] ? 'Desactivar' : 'Activar'; ?>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
        
        <!-- Paginación -->
        <?php if ($totalPaginas > 1): ?>
          <div class="paginacion">
            <?php
              // mantenemos filtros en los links
              $paramsBase = $_GET;
              unset($paramsBase['pagina']); // la seteamos nosotros
            ?>
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
              <?php
                $paramsBase['pagina'] = $i;
                $urlPagina = 'productos-admin.php?' . http_build_query($paramsBase);
              ?>
              <a
                href="<?php echo h($urlPagina); ?>"
                class="<?php echo ($i === $pagina) ? 'activa' : ''; ?>"
              >
                <?php echo $i; ?>
              </a>
            <?php endfor; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
  
  <!-- Inicio Footer -->

    <?php
        include 'footer.php';
    ?>

  <!-- Fin Footer -->

  <!-- Modal de inicio de sesion/registro   -->

  <!-- Overlay oscuro -->
  <div id="overlay-login" class="overlay oculto"></div>

  <!-- Modal de Login -->

  <?php include 'login.php'; ?>

  <!--Fin Modal de inicio de sesion/registro   -->


  <!-- Aviso emergente en trabajo  -->

  <div id="aviso-trabajo" class="aviso-trabajo oculto">
    🔧 Esta sección está en desarrollo. ¡Pronto estará disponible!
  </div>

  <!-- fin Aviso emergente en trabajo  -->


  <!-- GSAP -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <!-- ScrollTrigger (para animar con el scroll) -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>


  <!-- Scritps -->


  <script defer src="js/global.js"></script>
  <script defer src="js/gsap-nav.js"></script>
  <script defer src="js/login.js"></script>

</body>
</html>
