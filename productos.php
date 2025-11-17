<?php
@session_start();
require 'db_conn.php';

/* Helper para imagen */
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function imagen_principal(int $id): string {
  $baseAbs = __DIR__ . "/uploads/products/$id/";
  $baseRel = "uploads/products/$id/";
  $candidatas = ['main.webp','main.jpg','main.png','1.webp','1.jpg','1.png'];
  foreach ($candidatas as $f) {
    if (is_file($baseAbs.$f)) return $baseRel.$f;
  }
  return 'imagenes/placeholder.webp';
}

/* Parámetros de búsqueda */
$buscar = trim($_GET['q'] ?? '');
$pag    = max(1, (int)($_GET['p'] ?? 1));
$porPag = 12;
$offset = ($pag - 1) * $porPag;

$where = "p.activo = 1";
$params = [];
$types  = '';

if ($buscar !== '') {
  $where .= " AND (p.nombre LIKE CONCAT('%', ?, '%') OR p.descripcion LIKE CONCAT('%', ?, '%'))";
  $params[] = $buscar;
  $params[] = $buscar;
  $types   .= 'ss';
}

/* Conteo total */
$stmt = $conexion->prepare("SELECT COUNT(*) FROM producto p WHERE $where");
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$totalPaginas = ceil($total / $porPag);

/* Consulta principal */
$sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, c.nombre AS categoria
        FROM producto p
        LEFT JOIN categoria c ON c.id = p.categoria_id
        WHERE $where
        ORDER BY p.id DESC
        LIMIT ? OFFSET ?";
$stmt = $conexion->prepare($sql);

if ($types !== '') {
    // Agregamos los tipos de LIMIT y OFFSET
    $types2  = $types . 'ii';
    // Sumamos los valores a bindear
    $params2 = array_merge($params, [$porPag, $offset]);

    // bind_param requiere referencias -> las construimos
    $bind = [];
    $bind[] = &$types2;
    foreach ($params2 as $k => $v) {
        $bind[] = &$params2[$k];
    }
    call_user_func_array([$stmt, 'bind_param'], $bind);
} else {
    $stmt->bind_param('ii', $porPag, $offset);
}


$stmt->execute();
$res = $stmt->get_result();
$productos = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos - RedBull Store</title>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/productos-publico.css">
  <link rel="stylesheet" href="css/modal-carrito.css" />
  <link rel="stylesheet" href="css/modal-login.css">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="icon" href="imagenes/favicon.redbull.jpg.png" />
</head>
<body>
  <?php include 'nav.php'; ?>

<section class="banner">
  <img src="imagenes/redbullcompras.avif" alt="Red Bull Shop" />
</section>

  <main class="contenedor">
    <h1>Tienda oficial</h1>

    <form class="buscador" method="get" action="productos.php">
      <input type="text" name="q" placeholder="Buscar producto..." value="<?= h($buscar) ?>">
      <button type="submit">Buscar</button>
    </form>

    <?php if (!$productos): ?>
      <p class="sin-resultados">No se encontraron productos.</p>
    <?php else: ?>
      <section class="grid-productos">
        <?php foreach ($productos as $p): ?>
          <article class="card">
            <img src="<?= h(imagen_principal((int)$p['id'])) ?>" alt="<?= h($p['nombre']) ?>">
            <div class="info">
              <h3><?= h($p['nombre']) ?></h3>
              <p class="categoria"><?= h($p['categoria'] ?? 'Sin categoría') ?></p>
              <div class="precio">$<?= number_format((float)$p['precio'], 2, ',', '.') ?></div>
              <?php if ($p['stock'] > 0): ?>
                <div class="stock ok">Stock: <?= (int)$p['stock'] ?></div>
              <?php else: ?>
                <div class="stock no">Sin stock</div>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </section>

      <!-- Paginación -->
      <?php if ($totalPaginas > 1): ?>
        <div class="paginacion">
          <?php for ($i=1; $i <= $totalPaginas; $i++): ?>
            <a href="?q=<?= urlencode($buscar) ?>&p=<?= $i ?>" class="<?= $i === $pag ? 'activa' : '' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
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

  <script defer src="js/productos.js"></script>
  <script defer src="js/global.js"></script>
  <script defer src="js/filtros.js"></script>
  <script defer src="js/cargarMas.js"></script>
  <script defer src="js/modal-carrito.js"></script>
  <script defer src="js/gsap-nav.js"></script>
  <script defer src="js/login.js"></script>



</body>
</html>
