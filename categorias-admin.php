<?php
@session_start(); //@session_start(); inicia la sesión para poder usar $_SESSION.

$user      = $_SESSION['usuario']      ?? null; //nombrre de usuario
$tipo_user = $_SESSION['tipo_usuario'] ?? null; //tipo(0,1,2)

//solo usuarios tipo 1 o 2 pueden entrar
if (!$tipo_user || !in_array($tipo_user, ['1','2'], true)) {
  header('Location: login.php');
  exit;
}

require 'db_conn.php';

// ABM

if ($_SERVER['REQUEST_METHOD'] === 'POST') {//Solo entra si fue enviado por POST

  // Alta
  if (isset($_POST['crear_categoria'])) { //isset para comprobar si una variable esta definida y tiene valor distinto de null
    $nombre = trim($_POST['nombre'] ?? '');
    $padre  = ($_POST['padre'] ?? '0') === '0' ? null : (int)$_POST['padre'];// si el valor de padre es 0 es "sin padre" si no, se castea a int

    if ($nombre !== '') { // si el nombre no esta vacio, prepara el INSERT con placeholders ?
      $stmt = $conexion->prepare("INSERT INTO categoria (nombre, padre_id) VALUES (?, ?)");
      $stmt->bind_param("si", $nombre, $padre); //string e int, bind_param vincula una variable a un marcador de posicion en una consulta sql
      $ok = $stmt->execute();
      $stmt->close();
    }
    header('Location: categorias-admin.php?msg=' . ($ok ? 'creada' : 'error'));
    exit;
  }

  // modificacion
  if (isset($_POST['id_editar'])) {
    $id     = (int)($_POST['id_editar'] ?? 0);
    $nombre = trim($_POST['nombreEditar'] ?? '');
    $padre  = ($_POST['padreEditar'] ?? '0') === '0' ? null : (int)$_POST['padreEditar'];

    if ($id > 0 && $nombre !== '') { //solo actualiza si el id es valido y el nombre no esta vacio 
      $stmt = $conexion->prepare("UPDATE categoria SET nombre = ?, padre_id = ? WHERE id = ?");
      $stmt->bind_param("sii", $nombre, $padre, $id);
      $ok = $stmt->execute();
      $stmt->close();
    }
    header('Location: categorias-admin.php?msg=' . ($ok ? 'editada' : 'error'));
    exit;
  }

  // baja
  if (isset($_POST['id_eliminar'])) {
    $id = (int)($_POST['id_eliminar'] ?? 0);
    $ok = false;

    if ($id > 0) {
        // 1) Ver si tiene hijos
        $stmt = $conexion->prepare("SELECT COUNT(*) FROM categoria WHERE padre_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($hijas);
        $stmt->fetch();
        $stmt->close();

        if ($hijas > 0) {
            // Tiene categorías hijos -> no borramos
            header('Location: categorias-admin.php?msg=tiene_hijas');
            exit;
        }

        // 2) Si no tiene hijas, recién ahí borramos
        $stmt = $conexion->prepare("DELETE FROM categoria WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
    }

    header('Location: categorias-admin.php?msg=' . ($ok ? 'eliminada' : 'error'));
    exit;
  }
}

// FILTROS + PAGINADO (GET) 

$buscar    = trim($_GET['buscar'] ?? '');
$tipoPadre = $_GET['tipo_padre'] ?? ''; // '', 'raiz', 'sub'

$porPagina = 10; //10 registros por página
$pagina    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($pagina < 1) { $pagina = 1; }

$where = " WHERE 1=1 ";

// Buscar por nombre o ID
if ($buscar !== '') {
  $buscarSql = $conexion->real_escape_string($buscar); //real_escape_string para escapar caracteres especiales
  $where .= " AND (c.nombre LIKE '%$buscarSql%' OR c.id LIKE '%$buscarSql%')";
}

// Filtrar por tipo de categoría
// raiz = sin padre  sub = tiene padre
if ($tipoPadre === 'raiz') {
  $where .= " AND c.padre_id IS NULL";
} elseif ($tipoPadre === 'sub') {
  $where .= " AND c.padre_id IS NOT NULL";
}

// Total de registros para paginado, $where para saber cuantas filas hay
$sqlCount = "SELECT COUNT(*) AS total
             FROM categoria c
             $where";
$resCount = $conexion->query($sqlCount);
$totalReg = $resCount ? (int)$resCount->fetch_assoc()['total'] : 0;
$resCount?->close();

//calcula cuantas paginas hay en total
$totalPaginas = max(1, (int)ceil($totalReg / $porPagina)); // ceil redondea hacia arriba
if ($pagina > $totalPaginas) {
  $pagina = $totalPaginas;
}
$offset = ($pagina - 1) * $porPagina;


/*  LISTADO con filtros + paginación */
$sql = "
  SELECT c.id, c.nombre, c.padre_id, p.nombre AS padre_nombre
  FROM categoria c
  LEFT JOIN categoria p ON p.id = c.padre_id
  $where
  ORDER BY c.id ASC
  LIMIT $porPagina OFFSET $offset
";
$res = $conexion->query($sql);
$categorias = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
$res?->close();

// Para los selects de padre uso todas las categorías (sin paginar)
$sqlPadres = "
  SELECT id, nombre
  FROM categoria
  ORDER BY id ASC
";
$resPadres = $conexion->query($sqlPadres);
$padres = $resPadres ? $resPadres->fetch_all(MYSQLI_ASSOC) : [];
$resPadres?->close();

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/categorias-admin.css">
  <link rel="stylesheet" href="css/modal-carrito.css" />
  <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap"
      rel="stylesheet"
  />
  <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
    <!-- fontawesome para los iconos -->
  <link rel="icon" href="imagenes/favicon.redbull.jpg.png" />
    <!-- icono pestaña navegador -->
  <title>Administrador de Categorías</title>
</head>
<body class="rb-body">
  <?php include 'nav.php'; ?>
  <div class="rb-nav-spacer"></div>
  <main class="rb-container">

    
    <div class="rb-topbar">
      <h1 class="rb-title">Administrador de Categorías</h1>
      <?php if (isset($_GET['msg'])): ?>
        <p class="rb-flash 
              <?= $_GET['msg'] === 'error' || $_GET['msg'] === 'tiene_hijas' ? 'rb-flash--error' : 'rb-flash--ok' ?>">
          <?php if ($_GET['msg'] === 'tiene_hijas'): ?>
            No podés eliminar una categoría que tiene subcategorías.
          <?php else: ?>
            <?= htmlspecialchars($_GET['msg']) ?>
          <?php endif; ?>
        </p>
      <?php endif; ?>
      <button type="button" class="rb-btn rb-btn--primary" onclick="openModal('modalCreate')">
        Nueva Categoría
      </button>
    </div>

    <!-- TABLA -->
    <section class="rb-card">
       <!-- Filtros -->
      <form method="get" class="rb-filtros">
        <div class="rb-filtros__row">
          <div class="rb-filtros__field">
            <label for="buscar">Buscar</label>
            <input
              type="text"
              id="buscar"
              name="buscar"
              placeholder="Nombre o ID..."
              value="<?= htmlspecialchars($buscar, ENT_QUOTES, 'UTF-8') ?>"
            >
          </div>

          <div class="rb-filtros__field">
            <label for="tipo_padre">Tipo de categoría</label>
            <select id="tipo_padre" name="tipo_padre">
              <option value="">Todas</option>
              <option value="raiz" <?= $tipoPadre === 'raiz' ? 'selected' : '' ?>>Solo raíz (sin padre)</option>
              <option value="sub"  <?= $tipoPadre === 'sub'  ? 'selected' : '' ?>>Solo subcategorías</option>
            </select>
          </div>

          <div class="rb-filtros__actions">
            <button type="submit" class="rb-btn rb-btn--primary">Filtrar</button>
            <a href="categorias-admin.php" class="rb-btn">Limpiar</a>
          </div>
        </div>
      </form>
      <div class="rb-table-wrap">
        <table class="rb-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Padre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($categorias) === 0): ?> <!-- si no hay categorias, muestra un mensaje que dice "no hay categorías cargadas" -->
              <tr><td colspan="4" class="rb-empty">No hay categorías cargadas.</td></tr>
            <?php else: ?>
              <?php foreach ($categorias as $cat): ?> <!-- si hay, un foreach de cada categoria -->
                <tr>
                  <td><?= (int)$cat['id'] ?></td>
                  <td><?= htmlspecialchars($cat['nombre']) ?></td>
                  <td><?= $cat['padre_id'] ?: '—' ?></td>
                  <td class="rb-actions">
                    <button class="rb-icon-btn" onclick="prefillEdit(<?= (int)$cat['id'] ?>,'<?= htmlspecialchars($cat['nombre'], ENT_QUOTES) ?>',<?= $cat['padre_id'] ? (int)$cat['padre_id'] : 0 ?>)">✎</button>
                    <button class="rb-icon-btn rb-danger" onclick="prefillDelete(<?= (int)$cat['id'] ?>,'<?= htmlspecialchars($cat['nombre'], ENT_QUOTES) ?>')">🗑</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
        <?php if ($totalPaginas > 1): ?> <!--solo muestra paginación si hay más de una página -->
        <div class="rb-paginacion">
          <?php
            // mantener filtros en los links
            $queryBase = [];
            if ($buscar !== '') {
              $queryBase['buscar'] = $buscar;
            }
            if ($tipoPadre !== '') {
              $queryBase['tipo_padre'] = $tipoPadre;
            }

            // botón "Anterior"
            if ($pagina > 1) {
              $queryBase['page'] = $pagina - 1;
              echo '<a class="rb-pag-link" href="categorias-admin.php?' . http_build_query($queryBase) . '">&laquo; Anterior</a>';
            }

            // números
            for ($p = 1; $p <= $totalPaginas; $p++) {
              $queryBase['page'] = $p;
              $clase = $p == $pagina ? 'rb-pag-link rb-pag-link--activa' : 'rb-pag-link';
              echo '<a class="' . $clase . '" href="categorias-admin.php?' . http_build_query($queryBase) . '">' . $p . '</a>';
            }

            // botón "Siguiente"
            if ($pagina < $totalPaginas) {
              $queryBase['page'] = $pagina + 1;
              echo '<a class="rb-pag-link" href="categorias-admin.php?' . http_build_query($queryBase) . '">Siguiente &raquo;</a>';
            }
          ?>
        </div>
      <?php endif; ?>
    </section>
  </main>

  
<!-- footer -->
    <?php
        include 'footer.php';
    ?>

  <!-- MODAL NUEVA -->
  <div id="modalCreate" class="rb-modal">
    <div class="rb-modal__dialog">
      <div class="rb-modal__header">
        <h3>Nueva Categoría</h3>
        <button class="rb-close" onclick="closeModal('modalCreate')">×</button>
      </div>
      <form method="post" class="rb-form">
        <input type="hidden" name="crear_categoria" value="1">
        <label class="rb-field">
          <span>Nombre</span>
          <input type="text" name="nombre" required>
        </label>
        <label class="rb-field">
          <span>Padre</span>
          <select name="padre">
            <option value="0">— Sin padre —</option>
            <?php foreach ($padres as $p): ?>
              <option value="<?= (int)$p['id'] ?>">
                <?= (int)$p['id'] ?> — <?= htmlspecialchars($p['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>
        <div class="rb-modal__actions">
          <button type="button" class="rb-btn" onclick="closeModal('modalCreate')">Cancelar</button>
          <button type="submit" class="rb-btn rb-btn--primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL EDITAR -->
  <div id="modalEdit" class="rb-modal">
    <div class="rb-modal__dialog">
      <div class="rb-modal__header">
        <h3>Editar Categoría</h3>
        <button class="rb-close" onclick="closeModal('modalEdit')">×</button>
      </div>
      <form method="post" class="rb-form">
        <input type="hidden" name="id_editar" id="id_editar">
        <label class="rb-field">
          <span>Nombre</span>
          <input type="text" name="nombreEditar" id="nombreEditar" required>
        </label>
        <label class="rb-field">
          <span>Padre</span>
          <select name="padreEditar" id="padreEditar">
            <option value="0">— Sin padre —</option>
            <?php foreach ($padres as $p): ?>
              <option value="<?= (int)$p['id'] ?>">
                <?= (int)$p['id'] ?> — <?= htmlspecialchars($p['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>
        <div class="rb-modal__actions">
          <button type="button" class="rb-btn" onclick="closeModal('modalEdit')">Cancelar</button>
          <button type="submit" class="rb-btn rb-btn--primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL ELIMINAR -->
  <div id="modalDelete" class="rb-modal">
    <div class="rb-modal__dialog">
      <div class="rb-modal__header">
        <h3>Eliminar Categoría</h3>
        <button class="rb-close" onclick="closeModal('modalDelete')">×</button>
      </div>
      <form method="post" class="rb-form">
        <p class="rb-warning">
          ¿Seguro que querés eliminar la categoría
          <strong id="del_nombre">...</strong> (ID <span id="del_id">...</span>)?
        </p>
        <input type="hidden" name="id_eliminar" id="id_eliminar">
        <div class="rb-modal__actions">
          <button type="button" class="rb-btn" onclick="closeModal('modalDelete')">Cancelar</button>
          <button type="submit" class="rb-btn rb-btn--danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>

      <!-- MODAL DE DETALLE DE PRODUCTO -->
    <div id="modal-detalle" class="modal oculto">
      <div class="modal-producto">
        <span class="cerrar" onclick="cerrarModal()">&times;</span>

        <div class="modal-izq">
          <div class="galeria-miniaturas" id="miniaturas"></div>
          <img id="modal-imagen" class="imagen-grande" src="" alt="Imagen principal del producto" />
        </div>
        <div class="modal-der">
          <h2 id="modal-nombre"></h2>
          <p id="modal-descripcion" class="modal-descripcion"></p>
          <p id="modal-precio" class="modal-precio"></p>
          <button onclick="agregarAlCarrito()" class="boton-agregar">
            Agregar al carrito
          </button>
        </div>
      </div>
    </div>

    <!-- CARRITO LATERAL -->
    <div id="carrito-container" class="carrito oculto">
      <div class="carrito-header">
        <h3>Tu Carrito</h3>
        <button class="cerrar-carrito" onclick="toggleCarrito(event)">
          X
        </button>
      </div>
      <div id="lista-carrito" class="contenido-carrito"></div>
      <p id="carrito-vacio" class="carrito-vacio oculto">
        TU CARRITO ESTÁ VACÍO
      </p>
      <p id="total-carrito" class="carrito-total"></p>
      <button id="boton-finalizar" class="boton-finalizar oculto" onclick="finalizarCompra()">
        Finalizar compra
      </button>
    </div>

    <!-- MENSAJE DE COMPRA REALIZADA CON EXITO  -->
    <div id="mensaje-compra" class="modal-compra oculto">
      <div class="modal-compra-contenido">
        <h2>¡Gracias por tu compra!</h2>
        <p>Tu pedido fue procesado con éxito.</p>
        <button onclick="cerrarMensajeCompra()">Cerrar</button>
      </div>
    </div>
  </main>



      <!-- GSAP -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <!-- ScrollTrigger (para animar con el scroll) -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Scripts -->
  <script defer src="js/categorias.js"></script>
  <script defer src="js/global.js"></script>
  <script defer src="js/modal-carrito.js"></script>
  <script defer src="js/gsap-nav.js"></script>

</body>
</html>
