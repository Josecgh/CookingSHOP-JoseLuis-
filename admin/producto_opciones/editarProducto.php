<?php 
  include_once "php/db_cookingshop.php";
  $id = $_REQUEST['id'];
  $con = mysqli_connect($host, $user,$clave, $db, $port);
  if(isset($_REQUEST['guardar'])){
    $nombre=mysqli_real_escape_string($con,$_REQUEST['nombre']??'');
    $precio=mysqli_real_escape_string($con,$_REQUEST['precio']??'');
    $existencias=mysqli_real_escape_string($con,$_REQUEST['existencias']??'');
    if($_REQUEST['existencias']<1){
      $existencias=0;
    }
    $descripcion=mysqli_real_escape_string($conn,$_REQUEST['descripcion']??'');

    $query = "UPDATE productos set nombre='$nombre', precio='$precio',
    existencias='$existencias',descripcion='$descripcion' where id='$id';";

    $res = mysqli_query($con, $query);
    if ($res) {
      echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=productos&mensaje=Producto '.$nombre.' editado exitosamente" /> ';
    } else {
      echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=productos&mensaje=Error al editar el producto" /> ';
    }
  }
  $id=mysqli_real_escape_string($con, $_REQUEST['id']??'');
  $query="select id, nombre, precio, existencias, descripcion from productos where id='".$id."'; ";
  $res=mysqli_query($con,$query);
  $row=mysqli_fetch_assoc($res);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="app-content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar producto</h1>
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
              <form action="panel.php?modulo=editarProducto" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="nombre" class="form-control"
                   value="<?php echo $row['nombre'] ?>" required="required" >
                </div>
                <div class="form-group">
                  <label>Precio</label>
                  <input type="text" name="precio" class="form-control"
                   value="<?php echo $row['precio'] ?>" required="required" >
                </div>
                <div class="form-group">
                  <label>Existencias</label>
                  <input type="text" name="existencias" class="form-control"
                   value="<?php echo $row['existencias'] ?>" required="required" >
                </div>
                <div class="form-group">
                  <label>Descripción</label>
                  <textarea id="descripcion" name="descripcion" class="form-control">
                    <?php echo $row['descripcion'] ?>
                  </textarea>
                </div>
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