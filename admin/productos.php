<?php
  include_once "php/db_cookingshop.php";
  if (isset($_REQUEST['idBorrar'])) {
    $id=mysqli_real_escape_string($conn,$_REQUEST['idBorrar']??'');
    $query="DELETE from productos where id='".$id."';";
    $res=mysqli_query($conn,$query);
    if ($res) {
?>
  <div class="alert alert-warning float-right" role="alert">
    Producto borrado con éxito
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php
  } else {
?>
  <div class="alert alert-danger float-right" role="alert">
    Error al borrar <?php echo mysqli_error($conn); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php
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
          <h1>Productos</h1>
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
              <table id="tablaProductos" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Existencias</th>
                  <th>Imagen(es)</th>
                  <th>Acciones
                  <a href="panel.php?modulo=crearProducto"><i class="bi bi-plus"></i></a>
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    //$conn = mysqli_connect($host, $user, $clave, $db);
                    $query = "select id,nombre,precio,existencias from productos";
                    $res = mysqli_query($conn, $query);
                    
                    while($row = mysqli_fetch_assoc($res)){
                      // Obtener el número de imágenes asociadas a un producto
                      $query_imagenes = "
                        SELECT count(*) as total_imagenes FROM imagenes WHERE idProduct = " .$row['id']
                      ; // Número total de imágenes asociadas al producto
                      $res_imagenes = mysqli_query($conn, $query_imagenes);
                      $row_imagenes = mysqli_fetch_assoc($res_imagenes);
                      $total_imagenes = $row_imagenes['total_imagenes'];
                  ?>
                  <tr>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['precio'] ?></td>
                    <td><?php echo $row['existencias'] ?></td>
                    <td>
                      <?php
                        if($total_imagenes==0){
                          echo "No hay imágenes";
                        } else if($total_imagenes==1){
                          echo "Hay ".$total_imagenes." imagen.";
                        } else {
                          echo "Hay ".$total_imagenes." imágenes.";
                        }
                      ?>
                    </td>
                    <td>
                      <a href="panel.php?modulo=editarProducto&id=<?php echo $row['id'] ?>"
                       style="margin-right: 15px">
                        <img src="assets/imagenes/editar.png" width="20px">
                      </a>
                      <a href="panel.php?modulo=subirImagenesProducto&id=<?php echo $row['id'] ?>"
                       style="margin-right: 15px">
                        <img src="assets/imagenes/subir-imagen.png" width="20px">
                      </a>
                      <a href="panel.php?modulo=borrarImagenesProducto&id=<?php echo $row['id'] ?>"
                       style="margin-right: 15px">
                        <img src="assets/imagenes/borrar_imagen.png" width="20px">
                      </a>
                      <a href="panel.php?modulo=productos&idBorrar=<?php echo $row['id'] ?>"
                       class="borrar text-danger">
                        <img src="assets/imagenes/borrar.png" width="20px">
                      </a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
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