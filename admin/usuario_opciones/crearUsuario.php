<?php 
  if(isset($_REQUEST['guardar'])){
    include_once "php/db_cookingshop.php";
    $email=mysqli_real_escape_string($conn,$_REQUEST['email']??'');
    $pass=md5(mysqli_real_escape_string($conn,$_REQUEST['pass']??''));
    $nombre=mysqli_real_escape_string($conn,$_REQUEST['nombre']??'');
    
    $query = "INSERT INTO usuarios (email,pass,nombre) values 
    ('".$email."','".$pass."','".$nombre."')";
    $res = mysqli_query($conn, $query);
    if ($res) {
      echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=usuarios&mensaje=Usuario creado exitosamente" /> ';
    } else {
      echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=usuarios&mensaje=Error al crear el usuario" /> ';
    }
  }
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="app-content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Crear usuario</h1>
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
                <form action="panel.php?modulo=crearUsuario" method="post">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="pass" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control">
                  </div>
                  <div class="form-group">
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