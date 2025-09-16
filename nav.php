    <nav>
      <div class="nav-container contenedor-margenes">
        <a href="index.php" class="logo">
          <img src="imagenes/redbullcom-logo_double-with-text.svg" alt="Red Bull Logo" />
        </a>

        <div class="hamburguesa" id="hamburguesa">☰</div>

        <ul>
          <li><a href="energizantes.php">Energizantes</a></li>
          <li><a href="productos.php">Productos</a></li>
          <li><a href="eventosYdeportes.php">Eventos y Deportes</a></li>
          <li><a href="contacto.php">Contacto</a></li>
          <li><a href="usuarios-admin.php">Usuarios</a></li>
        </ul>

        <!-- Carrito -->
        <div class="nav-icons">
          <a href="#" onclick="toggleCarrito(event)" class="carrito-link">
            <img src="imagenes/shopping-cart.png" alt="Carrito" class="icono-carrito" />
            <span id="contador-carrito" class="contador-carrito oculto">0</span>
          </a>

          <a href="registro.php" class="link-usuario">
            <i class="fa-solid fa-user"></i>
          </a>
        </div>
      </div>
    </nav>