<?php
@session_start();

$user      = $_SESSION['usuario']      ?? null;
$tipo_user = $_SESSION['tipo_usuario'] ?? null;

if (!$tipo_user || !in_array($tipo_user, ['1','2'], true)) {
  header('Location: login.php');
  exit;
}

require 'db_conn.php';

/* ======= CRUD ======= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Alta
  if (isset($_POST['crear_categoria'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $padre  = ($_POST['padre'] ?? '0') === '0' ? null : (int)$_POST['padre'];

    if ($nombre !== '') {
      $stmt = $conexion->prepare("INSERT INTO categoria (nombre, padre_id) VALUES (?, ?)");
      $stmt->bind_param("si", $nombre, $padre);
      $ok = $stmt->execute();
      $stmt->close();
    }
    header('Location: categorias-admin.php?msg=' . ($ok ? 'creada' : 'error'));
    exit;
  }

  // Edición
  if (isset($_POST['id_editar'])) {
    $id     = (int)($_POST['id_editar'] ?? 0);
    $nombre = trim($_POST['nombreEditar'] ?? '');
    $padre  = ($_POST['padreEditar'] ?? '0') === '0' ? null : (int)$_POST['padreEditar'];

    if ($id > 0 && $nombre !== '') {
      $stmt = $conexion->prepare("UPDATE categoria SET nombre = ?, padre_id = ? WHERE id = ?");
      $stmt->bind_param("sii", $nombre, $padre, $id);
      $ok = $stmt->execute();
      $stmt->close();
    }
    header('Location: categorias-admin.php?msg=' . ($ok ? 'editada' : 'error'));
    exit;
  }

  // Eliminación
  if (isset($_POST['id_eliminar'])) {
    $id = (int)($_POST['id_eliminar'] ?? 0);
    if ($id > 0) {
      $stmt = $conexion->prepare("DELETE FROM categoria WHERE id = ?");
      $stmt->bind_param("i", $id);
      $ok = $stmt->execute();
      $stmt->close();
    }
    header('Location: categorias-admin.php?msg=' . ($ok ? 'eliminada' : 'error'));
    exit;
  }
}

/* ======= LISTADO ======= */
$sql = "
  SELECT c.id, c.nombre, c.padre_id, p.nombre AS padre_nombre
  FROM categoria c
  LEFT JOIN categoria p ON p.id = c.padre_id
  ORDER BY c.id ASC
";
$res = $conexion->query($sql);
$categorias = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
$res?->close();
$padres = $categorias;
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
        <p class="rb-flash <?= $_GET['msg']==='error' ? 'rb-flash--error':'rb-flash--ok' ?>">
          <?= htmlspecialchars($_GET['msg']) ?>
        </p>
      <?php endif; ?>
      <button type="button" class="rb-btn rb-btn--primary" onclick="openModal('modalCreate')">
        Nueva Categoría
      </button>
    </div>

    <!-- TABLA -->
    <section class="rb-card">
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
            <?php if (count($categorias) === 0): ?>
              <tr><td colspan="4" class="rb-empty">No hay categorías cargadas.</td></tr>
            <?php else: ?>
              <?php foreach ($categorias as $cat): ?>
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
    </section>
  </main>

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


  <!-- JS -->
  <script>
    function openModal(id){ document.getElementById(id).classList.add('is-open'); }
    function closeModal(id){ document.getElementById(id).classList.remove('is-open'); }

    function prefillEdit(id, nombre, padre_id){
      document.getElementById('id_editar').value = id;
      document.getElementById('nombreEditar').value = nombre;
      document.getElementById('padreEditar').value = padre_id || 0;
      openModal('modalEdit');
    }

    function prefillDelete(id, nombre){
      document.getElementById('del_id').textContent = id;
      document.getElementById('del_nombre').textContent = nombre;
      document.getElementById('id_eliminar').value = id;
      openModal('modalDelete');
    }
  </script>
      <!-- GSAP -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <!-- ScrollTrigger (para animar con el scroll) -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Scripts -->
    <script defer src="js/global.js"></script>
    <script defer src="js/modal-carrito.js"></script>
    <script defer src="js/gsap-nav.js"></script>

</body>
</html>
