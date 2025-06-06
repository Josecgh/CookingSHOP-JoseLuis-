<?php
  include_once "php/db_cookingshop.php";
  if (isset($_REQUEST['idBorrar'])) {
    $id=mysqli_real_escape_string($conn,$_REQUEST['idBorrar']??'');
    $query="DELETE from usuarios where id='".$id."';";
    $res=mysqli_query($conn,$query);
    if ($res) {
?>
  <div class="alert alert-warning float-right" role="alert">
    Usuario borrado con éxito
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
          <h1>Usuarios</h1>
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
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Acciones
                    <a href="panel.php?modulo=crearUsuario"><i class="bi bi-plus"></i></a>
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    //$conn = mysqli_connect($host, $user, $clave, $db);
                    $query = "select id,email,nombre from usuarios";
                    $res = mysqli_query($conn, $query);
                    
                    while($row = mysqli_fetch_assoc($res)){
                  ?>
                  <tr>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td>
                      <a href="panel.php?modulo=editarUsuario&id=<?php echo $row['id'] ?>"
                       style="margin-right: 15px"><img src="assets/imagenes/editar.png" width="20px"></a>
                      <a href="panel.php?modulo=usuarios&idBorrar=<?php echo $row['id'] ?>"
                       class="borrar text-danger"><img src="assets/imagenes/borrar.png" width="20px"></a>
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