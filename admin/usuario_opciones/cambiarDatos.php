<?php 
include_once "php/db_cookingshop.php";
$con = mysqli_connect($host, $user, $clave, $db, $port);

if (isset($_REQUEST['guardar'])) {
    $id = mysqli_real_escape_string($con, $_REQUEST['id'] ?? '');

    // Obtener la contraseña actual de la base de datos
    $query = "SELECT pass FROM usuarios WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $currentPass = $row['pass'] ?? '';

    // Verificar si se ingresó una nueva contraseña
    if (!empty($_REQUEST['pass'])) {
        $pass = md5(mysqli_real_escape_string($con, $_REQUEST['pass']));
    } else {
        $pass = $currentPass; // Mantener la contraseña actual si no se envió una nueva
    }

    $nombre = mysqli_real_escape_string($con, $_REQUEST['nombre'] ?? '');
    $admin = mysqli_real_escape_string($con, $_REQUEST['admin'] ?? '0');

    // Actualizar los datos del usuario
    $query = "UPDATE usuarios SET pass=?, nombre=?, admin=? WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssii", $pass, $nombre, $admin, $id);
    $res = $stmt->execute();

    if ($res) {
        echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=perfil&mensaje=Datos de ' . $nombre . ' editados con éxito&sentencia=success" />';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=perfil&mensaje=Los datos de ' . $nombre . ' no han sido editados&sentencia=danger" />';
    }
}

// Obtener los datos del usuario
$id = mysqli_real_escape_string($con, $_REQUEST['id'] ?? '');
$query = "SELECT id, email, pass, nombre FROM usuarios WHERE id=?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
?>
<a href="panel.php?modulo=perfil" class="volver-enlace" id="boton">
  <img src="assets/imagenes/anterior.png" alt="Volver a mi perfil" id="imagen-boton" width="50px">
</a>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="app-content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cambiar datos</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <form action="panel.php?modulo=cambiarDatos" method="post">
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="nombre" class="form-control"  value="<?php echo $row['nombre'] ?>" required="required" >
                </div>
                <div class="form-group">
                  <label>Contraseña</label>
                  <input type="password" name="pass" class="form-control">
                </div>
                <?php if($_SESSION['admin']==1): ?>
                <div class="form-group">
                  <label for="admin">Admin:</label><br>
                  <input type="radio" name="admin" id="admin" value="1" checked> Sí <br>
                  <input type="radio" name="admin" id="admin" value="0"> No <br>
                </div>
                <?php endif;?>
                <div class="form-group">
                  <input type="hidden" name="id" value="<?php echo $row['id'] ?>" >
                  <input type="submit" class="btn btn-primary" name="guardar" value="Guardar">
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  // Obtener el botón de la imagen y la imagen
  var botonImagen = document.getElementById('boton');
  var imagenBoton = document.getElementById('imagen-boton');

  // Cambiar la imagen cuando el botón es presionado
  botonImagen.addEventListener('mousedown', function() {
    imagenBoton.src = 'assets/imagenes/anterior_click.png'; // Cambia la imagen
  });

  // Restaurar la imagen cuando el botón es soltado
  botonImagen.addEventListener('mouseup', function() {
    imagenBoton.src = 'assets/imagenes/anterior.png'; // Restaurar la imagen original
  });

  // También restaurar la imagen si el mouse sale del área del enlace sin soltar el botón
  botonImagen.addEventListener('mouseleave', function() {
    imagenBoton.src = 'assets/imagenes/anterior.png'; // Restaurar la imagen original
  });
</script>