<!-- Navbar -->
<nav class="app-header navbar navbar-expand" style="background-color:hsl(47, 90.30%, 71.80%);">
  <div class="container-fluid">
    <!-- Logo o nombre de la marca -->
    <a class="navbar-brand" href="index.php">
      <img src="admin/dist/assets/img/cs_logo.png" alt="cookingshop_logo" width="50px" style="border-radius: 50%;">
      CookingSHOP
    </a>

    <!-- Enlace "Contacto" -->
    <a class="navbar-brand ms-3" href="#">Contacto</a>

    <!-- Barra de búsqueda -->
    <form class="d-flex ms-auto" action="index.php">
      <input class="form-control form-control-navbar me-2 bg-gray" type="search"
       placeholder="Buscar productos" aria-label="Buscar"
       name="nombre" value="<?php echo $_REQUEST['nombre']??''; ?>">
      <input type="hidden" name="modulo" value="productos">
      <button class="btn btn-outline-success" type="submit">
        <i class="bi bi-search"></i>
      </button>
    </form>
    

    <!-- Menú de usuario desplegable -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown user-menu">
        <?php if (isset($_SESSION['id'])): ?>
        <!-- Carrito de compras -->
        <div class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" id="iconoCarrito">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
            <span class="badge bg-danger navbar-badge" id="badgeProducto" style="border-radius: 50%;"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
           id="listaCarrito" style="left: -84px; width: 200px;">
            <p>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>, tu carrito está vacío.</p>
          </div>
        </div>
        <?php endif; ?>
      </li>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <i class="bi bi-people-fill"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="width: 450px;">
          <?php if (!isset($_SESSION['id'])): ?>
            <li>
              <a class="btn btn-default btn-flat" href="admin/lr-index.php">Crea tu cuenta o inicia sesión</a>
            </li>
          <?php else: ?> 
            <li class="user-header text-bg-primary">
            <?php
              // Dentro del bloque que muestra la imagen de perfil:
              if (isset($_SESSION['imagen_perfil']) && !empty($_SESSION['imagen_perfil'])) {
                  // Si hay una imagen de perfil, se muestra
                  echo '<img src="usuario_opciones/fotos_perfiles/' . htmlspecialchars($_SESSION['imagen_perfil']) . 
                  '" alt="Imagen de perfil" class="rounded-circle" width="50" height="50">';
              } else {
                  // Si no hay imagen de perfil, se muestra el icono por defecto
                  echo '<i class="fas fa-user-circle" style="font-size: 50px;"></i>';
              }
            ?>
              <p>Bienvenido <?php echo htmlspecialchars($_SESSION["nombre"]); ?> </p>
            </li>

            <li class="user-body navbar-nav text-center">
              <?php if($_SESSION['admin'] == 1): ?>
                <a href="admin/panel.php" class="nav-link">Ir al panel</a>
              <?php endif; ?>
              <a href="index.php?modulo=perfil" class="nav-link">Mi perfil</a>
              <a href="index.php?modulo=verPedidos" class="nav-link">Mis pedidos</a>
            </li>
            <li class="user-footer text-center">
              <a href="cerrar_sesion_client.php" class="btn btn-default btn-flat">Cerrar sesión</a>
            </li>
          <?php endif; ?>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<!-- /Navbar -->
<?php if (isset($_REQUEST['mensaje']) && !empty($_REQUEST['mensaje'])): ?>
  <div class="alert alert-<?php echo $_REQUEST['sentencia']; ?> alert-dismissible fade show float-right"
   role="alert">
    <?php echo htmlspecialchars($_REQUEST['mensaje']); ?>
    <span type="button" class="close" data-dismiss="alert" aria-label="Close"
     style="position: absolute; right: 20px;">
      <span aria-hidden="true">&times;</span>
      <span class="sr-only"></span>
    </span>
  </div>
<?php endif; ?>

