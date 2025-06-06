<?php
  include_once "php/db_cookingshop.php";
  if (isset($_REQUEST['idBorrar'])) {
    $idBorrar=mysqli_real_escape_string($conn,$_REQUEST['idBorrar']??'');
    $queryBorrar="DELETE from valoracion where id='".$idBorrar."';";
    $resBorrar=mysqli_query($conn,$queryBorrar);
    if ($resBorrar) {
?>
  <div class="alert alert-warning float-right" role="alert">
    Valoración borrada con éxito
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
          <h1>Gestor de valoraciones</h1>
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
                  <th>Id</th>
                  <th>Producto</th>
                  <th>Usuario</th>
                  <th>Comentario</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    $query = "SELECT v.id, v.comentario, u.nombre AS user_name, p.nombre AS product_name 
                              FROM valoracion AS v
                              JOIN usuarios AS u ON v.idUsuario = u.id
                              JOIN productos AS p ON v.idProducto = p.id
                              ";
                    $res = mysqli_query($conn, $query);
                    
                    while($row = mysqli_fetch_assoc($res)){
                  ?>
                  <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['product_name'] ?></td>
                    <td><?php echo $row['user_name'] ?></td>
                    <td><?php echo $row['comentario'] ?></td>

                    <td>
                      <a href="panel.php?modulo=gestorValoraciones&idBorrar=<?php echo $row['id'] ?>"
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