<?php
@session_start();

// variables de sesión
$user      = $_SESSION['usuario']      ?? null;
$tipo_user = $_SESSION['tipo_usuario'] ?? null;
?>

<nav>
  <div class="nav-container contenedor-margenes">
    <a href="index.php" class="logo">
      <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo" />
    </a>

    <div class="hamburguesa" id="hamburguesa">☰</div>

    <ul>
      <li><a href="energizantes.php">Energizantes</a></li>
      <li class="nav-has-mega">
        <a href="productos.php">Productos</a>
        <?php include 'mega-menu.php'; ?>
      </li>
      <li><a href="eventosYdeportes.php">Eventos</a></li>
      <li><a href="contacto.php">Contacto</a></li>

      <!--  Mostrar Usuarios solo si el tipo_user es 1 o 2 -->
      <?php if ($tipo_user === '1' || $tipo_user === '2'): ?>
        <li><a href="usuarios-admin.php">Usuarios</a></li>
        <li><a href="productos-admin.php">Productos-admin</a></li>
        <li><a href="categorias-admin.php">Categorias</a></li>
      <?php endif; ?>

      <!--  Mostrar nombre de usuario si hay sesión -->
      <?php if ($user): ?>
        <li><a href="profile.php"><?php echo htmlspecialchars($user); ?></a></li>
      <?php endif; ?>
    </ul>

    <!-- Carrito -->
    <div class="nav-icons">
      <a href="#" onclick="toggleCarrito(event)" class="carrito-link">
        <img src="imagenes/shopping-cart.png" alt="Carrito" class="icono-carrito" />
        <span id="contador-carrito" class="contador-carrito oculto">0</span>
      </a>

      <!-- Ícono de usuario (solo si NO hay sesión) -->
      <?php if (!$user): ?>
        <a href="#" class="link-usuario">
          <i class="fa-solid fa-user"></i>
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>
