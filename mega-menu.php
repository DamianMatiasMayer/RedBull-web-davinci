<?php

//asegurar conexion a la base
if (!isset($conexion)) { //la variable conexion existe?
    require __DIR__ . '/db_conn.php';
}

// helper de escape
if (!function_exists('h')) {
    function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}

// Traer todas las categorías
$sql  = "SELECT id, nombre, padre_id FROM categoria ORDER BY padre_id IS NULL DESC, padre_id, nombre";
$res  = $conexion->query($sql);
$rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
$res?->close();

// Separar padres e hijos
$padres        = [];
$hijosPorPadre = [];

foreach ($rows as $row) {
    // padre_id NULL => categoría padre
    if ($row['padre_id'] === null) {
        $padres[$row['id']] = $row;
    } else {
        $hijosPorPadre[$row['padre_id']][] = $row;
    }
}

// Si no hay padres, no mostramos nada
if (!$padres) {
    return;
}
?>

<div class="mega-menu">
  <div class="mega-menu-inner">
    <?php foreach ($padres as $padre): ?>
      <div class="mega-col">

        <!-- PADRE clickeable: padre + hijos (deep=1) -->
        <div class="mega-col-title">
          <a href="productos.php?cat=<?= (int)$padre['id']; ?>&deep=1">
            <?= h($padre['nombre']); ?>
          </a>
        </div>

        <div class="mega-col-list">
          <?php if (!empty($hijosPorPadre[$padre['id']])): ?>
            <?php foreach ($hijosPorPadre[$padre['id']] as $hijo): ?>
              <!-- HIJO: solo esa categoría -->
              <a href="productos.php?cat=<?= (int)$hijo['id']; ?>">
                <?= h($hijo['nombre']); ?>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <!-- Padre sin hijos: link directo a sus productos (deep=1 igual) -->
            <a href="productos.php?cat=<?= (int)$padre['id']; ?>&deep=1">
              Ver productos
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
