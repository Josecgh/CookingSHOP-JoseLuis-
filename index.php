<?php
  session_start();
  session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Catálogo de CookingSHOP</title>

  <!-- Meta Tags -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="AdminLTE v4 | Dashboard">
  <meta name="author" content="ColorlibHQ">
  <meta name="description" content="AdminLTE es un panel de administración gratuito basado en Bootstrap 5">
  <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">

  <!-- Fuentes -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
   integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Estilos de Terceros -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css"
   integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css"
   integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
  <link rel="stylesheet" href="admin/dist/css/adminlte.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
   integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
   integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
  <!-- Solo Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="icon" href="admin/dist/assets/icons/CookingIcon.ico" type="image/x-icon">
  <link rel="stylesheet" href="admin/css/stripe.css">

  <style>
    /* Aseguramos que la altura de la página ocupe todo el espacio disponible */
    html, body {
      height: 100%;  /* Establece que la altura del documento sea 100% */
      margin: 0;     /* Elimina el margen por defecto */
    }

    /* Aseguramos que las imágenes mantengan el tamaño y se recorten adecuadamente */
    .card-img-top {
      width: 100%;
      height: 250px; /* Tamaño estándar para todas las imágenes */
      object-fit: cover; /* Esto asegura que la imagen no se distorsione */
      object-position: center; /* Centra la imagen en el contenedor */
      background-color: white; /* Fondo blanco en caso de que la imagen sea más pequeña */
    }
    
    /* Aplicar márgenes a los lados cuando la resolución es mayor a 1200px */
    @media (min-width: 1200px) {
      .contenedor-todo {
        margin-left: 50px;  /* Margen izquierdo */
        margin-right: 50px; /* Margen derecho */
      }
    }

    /* Dar un fondo al botón */
    .ver-producto{
      background-color:hsl(47, 90.30%, 71.80%);
    }

    /* Cambiar el estilo del botón al pasar el ratón */
    .ver-producto:hover{
      background-color: hsl(47, 90.30%, 60%); /* Cambio en el color de fondo al pasar el ratón */
      transform: scale(1.05); /* Aumenta ligeramente el tamaño del botón */
    }

    /* Ajustar tamaño de iconos */
    .bi {
      font-size: 1.5rem; /* Ajusta el tamaño de los iconos */
    }

    #listaCarrito .opcionCarrito{
      text-align: center;
    }
  </style>
</head>

<body class="layout-fixed sidebar-expand-lg" style="background-color: #f4f4f4;">
  <!-- jQuery -->
  <script src="admin/plugins/jquery/jquery.min.js"></script>
  <?php
  include_once "admin/php/db_cookingshop.php";
  $con = mysqli_connect($host, $user, $clave, $db, $port);
  ?>
  <div class="contenedor-todo">
    <?php
    include_once "menu.php";
    $modulo=$_REQUEST['modulo']??'';
    if($modulo=="productos" || $modulo==""){
      include_once "producto_opciones/productos.php";
    }
    if($modulo=="descripcionProducto"){
      include_once "producto_opciones/descripcionProducto.php";
    }
    if($modulo=="valoracion"){
      include_once "producto_opciones/valoracion.php";
    }
    if($modulo=="subirValoracion"){
      include_once "producto_opciones/subirValoracion.php";
    }
    if($modulo=="perfil"){
      include_once "usuario_opciones/perfil.php";
    }
    if($modulo=="cambiarDatos"){
      include_once "usuario_opciones/cambiarDatos.php";
    }
    if($modulo=="subirFoto"){
      include_once "usuario_opciones/subir_foto.php";
    }
    if($modulo=="pruebaPedido"){
      include_once "producto_opciones/pruebaPedido.php";
    }
    if($modulo=="verCarrito"){
      include_once "usuario_opciones/carrito.php";
    }
    if($modulo=="registroEnvio"){
      include_once "pedido_opciones/registroDatosEnvio.php";
    }
    if($modulo=="procesarDatosEnvio"){
      include_once "pedido_opciones/procesarDatosEnvio.php";
    }
    if($modulo=="pasarela"){
      include_once "pedido_opciones/pasarela.php";
    }
    if($modulo=="factura"){
      include_once "pedido_opciones/factura.php";
    }
    if($modulo=="verPedidos"){
      include_once "pedido_opciones/verPedidos.php";
    }
    if($modulo=="recordatorioFactura"){
      include_once "pedido_opciones/ticket.php";
    }
    ?>
  </div>
  <?php
  if($modulo!="verCarrito" && $modulo!="pasarela" && $modulo!="factura" && $modulo!="verPedidos"){
  ?>
  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
      <!-- Texto central del footer -->
      <p>&copy; 2025 CookingSHOP. Todos los derechos reservados.</p>
      <p>Creado por <strong>Jose Luis Castro García</strong></p>
      <p><small>CookingSHOP™ es una marca registrada.</small></p>
      <!-- Aclaración sobre el proyecto -->
      <p>
        <small>
          <em>Nota: Ni la web ni la empresa existen. Este es solo un ejemplo para un proyecto académico.</em>
        </small>
      </p>
    </div>
  </footer>
  <!-- /Footer -->
  <?php
  }
  ?>
  <!-- Scripts -->
  
 
  
  <script src="admin/dist/js/adminlte.js"></script>

  <!-- Incluye los scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Incluye jQuery (necesario para que funcione el cierre) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <!-- Incluye el archivo JS de Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- Incluir jQuery desde un CDN (asegúrate de que la versión sea correcta) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://js.stripe.com/v3/"></script>
  <script src="admin/js/stripe.js"></script>

  <!-- Incluye los archivos para hacer el carrito de compra -->
  <script src="admin/js/cookingshop.js"></script>
</body>
</html>
