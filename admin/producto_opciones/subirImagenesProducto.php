<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="app-content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Subir imágenes de producto</h1>
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
            <div class="card-body">
              <form action="producto_opciones/imagenesProducto.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="imagenes">Seleccionar imágenes:</label>
                  <input type="file" name="imagenes[]" id="imagenes" multiple accept="image/*" class="form-control">

                  <?php
                    $id = "";
                    if (!empty($_GET['id'])) {
                      $id = htmlspecialchars($_GET['id']); // Evita inyección XSS
                    } elseif (!empty($_POST['idProd'])) {
                      $id = htmlspecialchars($_POST['idProd']);
                    }
                  ?>

                  <input type="hidden" name="idProd" value="<?php echo $id; ?>">

                  <button type="submit" class="btn btn-primary mt-2" name="guardar">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>