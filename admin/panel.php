<?php
    session_start();
    if(isset($_SESSION['id']) == false){
        header("location: lr-index.php");
    }
    session_regenerate_id(true);

  $modulo=$_REQUEST['modulo']??'';
?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->


<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Panel de control de CookigSHOP</title><!--begin::Primary Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="AdminLTE v4 | Dashboard">
  <meta name="author" content="ColorlibHQ">
  <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
  <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5
   charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable,
   colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256
   -tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" 
   integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party
   Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
   integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin
   (Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
   integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
   integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="icon" href="dist/assets/icons/CookingIcon.ico" type="image/x-icon">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/2.1.0/css/select.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.4/css/dataTables.dateTime.min.css">
  <link rel="stylesheet" href="css/editor.dataTables.min.css">
  <!-- Enlace a Font Awesome para los íconos -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    .menuIzq {
      background-color: #3b83bd;
    }

    .opcionesUser:hover {
      background-color: gray;
    }

  </style>
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
  <div class="app-wrapper"> <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
      <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav me-auto sidebar-menu flex-column"> <!-- Mueve los elementos de la lista a la izquierda -->
          <li class="nav-item">
            <a class="nav-link iconLista" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i> <!-- Ícono de la lista -->
            </a>
          </li>
        </ul> <!--end::Navbar Links-->
                
        <!--begin::User Menu Dropdown (Alineado a la derecha)-->
        <ul class="navbar-nav ms-auto"> <!-- Mueve este ícono a la derecha -->
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <i class="bi bi-people-fill"></i> <!-- Ícono del usuario -->
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <?php if (!isset($_SESSION['id'])): ?>
                <li><a class="btn btn-default btn-flat" href="admin/lr-index.php">Crea tu cuenta o inicia sesión</a></li>
              <?php else: ?> 
                <li class="user-header text-bg-primary">
              <?php
                // Dentro del bloque que muestra la imagen de perfil:
                if (isset($_SESSION['imagen_perfil']) && !empty($_SESSION['imagen_perfil'])) {
                  // Si hay una imagen de perfil, se muestra
                  echo '
                    <img src="../usuario_opciones/fotos_perfiles/' . htmlspecialchars($_SESSION['imagen_perfil']) . '"
                    alt="Imagen de perfil" class="rounded-circle" width="50" height="50">
                  ';
                } else {
                  // Si no hay imagen de perfil, se muestra el icono por defecto
                  echo '<i class="fas fa-user-circle" style="font-size: 50px;"></i>';
                }
              ?>
                <p>Bienvenido <?php echo htmlspecialchars($_SESSION["nombre"]); ?> </p>
              </li>

              <li class="user-body navbar-nav text-center">
                <?php if($_SESSION['admin'] == 1): ?>
                  <a href="../index.php" class="nav-link">Ir a catálogo</a>
                <?php endif; ?>
                  <a href="panel.php?modulo=perfil" class="nav-link">Mi perfil</a>
              </li>
              <li class="user-footer text-center">
                <a href="php/cerrar_sesion.php" class="btn btn-default btn-flat">Cerrar sesión</a>
              </li>
                <?php endif; ?>
            </ul>
          </li>
        </ul> <!--end::User Menu Dropdown-->
      </div> <!--end::Container-->
    </nav> <!--end::Header-->



    <aside class="app-sidebar shadow menuIzq" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
      <div class="sidebar-brand"> <!--begin::Brand Link-->
        <a href="panel.php" class="brand-link"> <!--begin::Brand Image-->
          <img src="dist/assets/img/cs_logo.png" style="border-radius: 50%;"
           alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text-->
          <span class="brand-text fw-light">CookingSHOP</span> <!--end::Brand Text-->
        </a> <!--end::Brand Link-->
      </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>CookingSHOP</p>
              </a>
              <ul class="nav nav-treeview">
                <?php if(isset($_SESSION['id'])): ?>
                  <li class="nav-item">
                    <a href="panel.php?modulo=estadisticas" class="nav-link <?php echo
                     ($modulo=="estadisticas" || $modulo=="")?" active ":" "; ?>">
                      <i class="fa fa-chart-bar nav-icon"></i>
                      <p>Estadísticas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="panel.php?modulo=usuarios" class="nav-link <?php echo
                     ($modulo=="usuarios" || $modulo=="crearUsuario"
                     || $modulo=="editarUsuario")?" active ":" ";?>">
                      <i class="nav-icon bi bi-people-fill"></i>
                      <p>Usuarios</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="panel.php?modulo=productos" class="nav-link <?php echo
                     ($modulo=="productos" || $modulo=="crearProducto" ||
                      $modulo=="editarProducto" || $modulo=="subirImagenesProducto" ||
                      $modulo=="borrarImagenesProducto")?" active ":" "; ?>">
                      <i class="bi bi-cart-fill"></i>
                      <p>Productos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="panel.php?modulo=gestorValoraciones" class="nav-link <?php echo
                     ($modulo=="gestorValoraciones" )?" active ":" "; ?>">
                      <i class="nav-icon bi bi-chat-dots "></i>
                      <p>Gestor de valoraciones</p>
                    </a>
                  </li>
                <?php endif?>
              </ul>
            </li>
          </ul> <!--end::Sidebar Menu-->
        </nav>
      </div> <!--end::Sidebar Wrapper-->
    </aside> <!--end::Sidebar--> <!--begin::App Main-->
    <main class="app-main"> <!--begin::App Content Header-->
      <?php if (isset($_REQUEST['mensaje'])): ?>
        <div class="alert alert-primary alert-dismissible fade show float-right" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <?php echo htmlspecialchars($_REQUEST['mensaje']); ?>
        </div>
      <?php endif; ?>



      <?php
        if($modulo=="estadisticas" || $modulo==""){
          include_once "estadisticas.php";
        }
        if($modulo=="usuarios"){
          include_once "usuarios.php";
        }
        if($modulo=="productos"){
          include_once "productos.php";
        }
        if($modulo=="ventas"){
          include_once "ventas.php";
        }
        if($modulo=="crearUsuario"){
          include_once "usuario_opciones/crearUsuario.php";
        }
        if($modulo=="editarUsuario") {
          include_once "usuario_opciones/editarUsuario.php";
        }
        if($modulo=="crearProducto"){
          include_once "producto_opciones/crearProducto.php";
        }
        if($modulo=="editarProducto") {
          include_once "producto_opciones/editarProducto.php";
        }
        if($modulo=="subirImagenesProducto"){
          include_once "producto_opciones/subirImagenesProducto.php";
        }
        if($modulo=="borrarImagenesProducto"){
          include_once "producto_opciones/borrarImagenesProducto.php";
        }
        if($modulo=="gestorValoraciones"){
          include_once "gestorValoraciones.php";
        }
        if($modulo=="perfil"){
          include_once "usuario_opciones/perfil.php";
        }
        if($modulo=="cerrarSesion"){
          include_once "php/cerrar_sesion.php";
        }
        if($modulo=="cambiarDatos"){
          include_once "usuario_opciones/cambiarDatos.php";
        }
        if($modulo=="subirFoto"){
          include_once "usuario_opciones/subir_foto.php";
        }
      ?>
    </main> <!--end::App Main-->
    
  </div> <!--end::App Wrapper-->

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
  
  <script>
    $('#tablaProductos').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  </script>
  <script>
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  </script>

    

  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"
   integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
   integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
   integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
  <script src="dist/js/adminlte.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
   integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
   integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
   
  <!-- Dashboard -->
  <script src="dist/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
   integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
   integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
   integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
    
  <script>
    $(document).ready(function () {
      $(".borrar").click(function (e) {
        e.preventDefault();
        var res=confirm('¿Realment quieres eliminar esto?');
        if (res==true) {
          var link=$(this).attr("href");
          window.location=link;
        }
      });
    });
  </script>
  <!-- Incluye jQuery (necesario para que funcione el cierre) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <!-- Incluye el archivo JS de Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body><!--end::Body-->
</html>