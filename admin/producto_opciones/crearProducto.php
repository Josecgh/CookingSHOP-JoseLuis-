<?php 
  if(isset($_REQUEST['guardar'])){
    include_once "php/db_cookingshop.php";
    $nombre=mysqli_real_escape_string($conn,$_REQUEST['nombre']??'');
    $precio=mysqli_real_escape_string($conn,$_REQUEST['precio']??'');
    $existencias=mysqli_real_escape_string($conn,$_REQUEST['existencias']??'');
    if($_REQUEST['existencias']<1){
      $existencias=0;
    }
    $descripcion=mysqli_real_escape_string($conn,$_REQUEST['descripcion']??'');

    $query = "INSERT INTO productos (nombre,precio,existencias,descripcion) values 
    ('".$nombre."','".$precio."','".$existencias."','".$descripcion."')";

    $res = mysqli_query($conn, $query);
    if ($res) {
      echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=productos&mensaje=Producto creado exitosamente" /> ';
    } else {
      echo '<meta http-equiv="refresh" content="0; url=panel.php?modulo=productos&mensaje=Error al crear el producto" /> ';
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
          <h1>Crear producto</h1>
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
              <form action="panel.php?modulo=crearProducto" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="nombre" class="form-control">
                </div>
                <div class="form-group">
                  <label>Precio</label>
                  <input type="text" name="precio" class="form-control">
                </div>
                <div class="form-group">
                  <label>Existencias</label>
                  <input type="text" name="existencias" class="form-control">
                </div>
                <div class="form-group">
                  <label>Descripción</label>
                  <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
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