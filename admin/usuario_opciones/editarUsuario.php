<?php 
  include_once "php/db_cookingshop.php";
  $con = mysqli_connect($host, $user,$clave, $db, $port);
    if(isset($_REQUEST['guardar'])){
      $email=mysqli_real_escape_string($con,$_REQUEST['email']??'');
      $pass=md5(mysqli_real_escape_string($con,$_REQUEST['pass']??''));
      $nombre=mysqli_real_escape_string($con,$_REQUEST['nombre']??'');
      $id=mysqli_real_escape_string($con, $_REQUEST['id']??'');
      $admin=mysqli_real_escape_string($con, $_REQUEST['admin']??'0');

      $query = "UPDATE usuarios set email='".$email."', pass='".$pass."',nombre='".$nombre."',admin='".$admin."' where id='".$id."';";
      $res = mysqli_query($con, $query);
      if ($res) {
        echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=usuarios&mensaje=Usuario '.$nombre.' editado exitosamente" /> ';
      } else {
        echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=usuarios&mensaje=Error al editar el usuario" /> ';
      }
    }
  $id=mysqli_real_escape_string($con, $_REQUEST['id']??'');
  $query="select id, email, pass, nombre, admin from usuarios where id='".$id."'; ";
  $res=mysqli_query($con,$query);
  $row=mysqli_fetch_assoc($res);
?>
<div class="content-wrapper">
  <section class="app-content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar usuario</h1>
        </div>
      </div>
    </div>
  </section>
  <section class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form action="panel.php?modulo=editarUsuario" method="post">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control"
                    value="<?php echo $row['email'] ?>" required="required" >
                </div>
                <div class="form-group">
                  <label>Contraseña</label>
                  <input type="password" name="pass" class="form-control" required="required" >
                </div>
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="nombre" class="form-control"
                    value="<?php echo $row['nombre'] ?>" required="required" >
                </div>
                <div class="form-group">
                  <label for="admin">Admin:</label><br>
                  <input type="radio" name="admin" id="admin" value="1"
                    <?php if($row['admin']==1):?>checked<?php endif ?>> Sí <br>
                  <input type="radio" name="admin" id="admin" value="0"
                    <?php if($row['admin']==0):?>checked<?php endif ?>> No <br>
                </div>
                <div class="form-group">
                  <input type="hidden" name="id" value="<?php echo $row['id'] ?>" >
                  <input type="submit" class="btn btn-primary" name="guardar" value="Guardar">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>