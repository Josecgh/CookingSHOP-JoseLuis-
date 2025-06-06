<?php
  $id = isset($_REQUEST['id']) ? mysqli_real_escape_string($con, $_REQUEST['id']) : null;

  $query = "SELECT p.nombre, p.precio, p.existencias, p.descripcion, i.url
            FROM productos AS p
            LEFT JOIN imagenes AS i ON p.id = i.idProduct
            WHERE p.id = '$id'";
  $res = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($res);
  $query_images = "SELECT url FROM imagenes WHERE idProduct = '$id'";
  $res_images = mysqli_query($con, $query_images);

  $images = mysqli_fetch_all($res_images, MYSQLI_ASSOC);

  if (isset($_REQUEST['idBorrarVal'])) {
      $idBorrar = mysqli_real_escape_string($con, $_REQUEST['idBorrarVal']);
      $queryBorrar = "DELETE FROM valoracion WHERE id = '$idBorrar' AND idProducto = '$id'";
      $resBorrar = mysqli_query($con, $queryBorrar);

      if ($resBorrar) {
          $mensaje = "La valoración ha sido borrada con éxito";
          $sentencia = "success";
          echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=descripcionProducto&id=' .
           $id . '&mensaje=' . $mensaje . '&sentencia=' . $sentencia . '" />';
      } else {
          $mensaje = "Ha habido un error al borrar la valoración.";
          $sentencia = "danger";
          echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=descripcionProducto&id=' .
           $id . '&mensaje=' . $mensaje . '&sentencia=' . $sentencia . '" />';
      }
  }
?>

<div class="row container">  
  <div class="col-md-5">
    <?php if (count($images) > 0): ?>
      <div id="carouselExampleControls" class="carousel slide"
       style="margin-top: 40px; border: 4px solid orange; border-radius: 20px;" data-bs-ride="carousel">
        <div class="carousel-inner" <?php if(count($images) == 1){?> style="height: 400px;" <?php } ?> >
          <?php 
            $isActive = true;
            $firstImageUrl = $images[0]['url'];
            foreach ($images as $image): 
          ?>
            <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>"
             <?php if(count($images) == 1) {?>
              style="display: flex; justify-content: center; height: 400px;"
              <?php }?> >
              <img src="<?php echo htmlspecialchars($image['url']); ?>"
               style="border-radius: 20px;" class="d-block <?php if(count($images) > 1):?>
               w-100<?php endif ?>" alt="Imagen del producto">
            </div>
          <?php 
            $isActive = false;
            endforeach; 
          ?>
        </div>
        <?php if(count($images) > 1): ?>
        <button class="carousel-control-prev" type="button"
         data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button"
         data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <p>No hay imágenes disponibles.</p>
    <?php endif; ?>
  </div>
  <div class="col-md-7">
    <h1 class="h3"><?php echo htmlspecialchars($row['nombre']); ?></h1>
    <div class="container">
      <nav class="w-100">
        <div class="nav nav-tabs" id="product-tab" role="tablist">
          <a class="nav-item nav-link active" id="product-desc-tab"
           data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc"
           aria-selected="true">Descripción</a>
          <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
           href="#product-comments" role="tab" aria-controls="product-comments"
           aria-selected="false">Valoraciones</a>
        </div>
      </nav>
      <div class="tab-content p-3" id="nav-tabContent">
        <div class="tab-pane fade show <?php if(!isset($_REQUEST['pagina_comentarios'])): ?>
           active <?php endif; ?>" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
          <p>
          <?php 
            if (isset($row['descripcion']) && $row['descripcion']){ 
              echo htmlspecialchars($row['descripcion']); 
            }else{ 
              echo 'Este producto no tiene una descripción.'; 
            }
          ?>
          </p>
        </div>
        <div class="tab-pane fade <?php if(isset($_REQUEST['pagina_comentarios'])): ?>
           show active <?php endif; ?>" id="product-comments" role="tabpanel"
           aria-labelledby="product-comments-tab"
           style="border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px; padding: 0px 10px 0px 10px;">
          <?php
          $comentariosPorPagina = 3;
          $queryContadorComentarios = "SELECT COUNT(*) AS cuenta FROM valoracion WHERE idProducto = '$id'";
          $resContadorComentarios = mysqli_query($con, $queryContadorComentarios);
          $rowContadorComentarios = mysqli_fetch_assoc($resContadorComentarios);
          $totalComentarios = $rowContadorComentarios['cuenta'];

          // Calcular el número total de páginas
          $totalPaginasComentarios = ceil($totalComentarios / $comentariosPorPagina);
          // Página seleccionada, por defecto será la primera si no está definida
          $paginaSelComentarios = $_REQUEST['pagina_comentarios'] ?? 1;
          // Calcular el OFFSET para la consulta
          $inicioLimiteComentarios = ($paginaSelComentarios - 1) * $comentariosPorPagina;
          // Consulta para obtener los comentarios con el límite y el OFFSET
          $queryComentarios = "SELECT u.nombre, u.admin, v.id, v.idUsuario, v.idProducto, v.comentario, v.puntuacion, v.fecha
                              FROM valoracion AS v
                              LEFT JOIN usuarios AS u ON v.idUsuario = u.id
                              WHERE v.idProducto = '$id'  
                              LIMIT $inicioLimiteComentarios, $comentariosPorPagina";
          $resComentarios = mysqli_query($con, $queryComentarios);
          // Mostrar los comentarios
          if (mysqli_num_rows($resComentarios) > 0) {
              while ($rowComentario = mysqli_fetch_assoc($resComentarios)) {
                  ?>
                  <div class="container" style="border: 1px solid orange; margin: 10px 0px 10px 0px; border-radius: 15px;">
                    <div class="review-header" style="border-bottom: 1px solid orange; background-color: hsl(47, 90.30%, 71.80%); width: 100%; padding: 10px;">
                        <strong><?php echo htmlspecialchars($rowComentario['nombre']); ?></strong> 
                        <span class="text-muted"> - <?php echo date('d/m/Y', strtotime($rowComentario['fecha'])); ?></span>
                        <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1 ||
                         isset($_SESSION['id']) && $_SESSION['id'] == $rowComentario['idUsuario']){ ?>
                          <a href="index.php?modulo=descripcionProducto&id=<?php echo $id ?>
                          &idBorrarVal=<?php echo $rowComentario['id'] ?>" class="trash-icon">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        <?php } ?>
                    </div>
                    <div class="review-body" style="margin-top: 20px">
                      <p><strong>Puntuación:</strong> <?php echo $rowComentario['puntuacion']; ?> ★</p>
                      <p><strong>Comentario:</strong>
                       <?php echo nl2br(htmlspecialchars($rowComentario['comentario'])); ?></p>
                    </div>
                  </div>
                  <?php
              }
          } else {
            echo '<p>No hay comentarios.</p>';
          }
          // Paginación de comentarios
          if ($totalPaginasComentarios > 1) {
              ?>
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <?php if ($paginaSelComentarios > 1) { ?>
                    <li class="page-item">
                      <a class="page-link" href="index.php?modulo=descripcionProducto&id=
                      <?php echo $id; ?>&pagina_comentarios=<?php echo $paginaSelComentarios - 1; ?>"
                      aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                  <?php } ?>

                  <?php for ($i = 1; $i <= $totalPaginasComentarios; $i++) { ?>
                    <li class="page-item <?php echo ($paginaSelComentarios == $i) ? "active" : ""; ?>">
                      <a class="page-link" href="index.php?modulo=descripcionProducto&id=
                      <?php echo $id; ?>&pagina_comentarios=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                  <?php } ?>

                  <?php if ($paginaSelComentarios < $totalPaginasComentarios) { ?>
                    <li class="page-item">
                      <a class="page-link" href="index.php?modulo=descripcionProducto&id=
                      <?php echo $id; ?>&pagina_comentarios=<?php echo $paginaSelComentarios + 1; ?>" 
                      aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </nav>
              <?php
          }
          ?>
        </div>
      </div>

      <p><?php echo ($row['existencias'] < 1) ? "No quedan existencias" : "Hay " . $row['existencias'] .
       " existencias"; ?></p>
      <h4 class="price text-danger"><?php echo number_format($row['precio'], 2); ?>€</h4>

      <div class="form-group d-flex flex-column mt-4">
        <div class="mt-4">
          <button 
              <?php if(!isset($_SESSION['id'])){ ?> 
                  onclick="window.location.href='admin/lr-index.php'" 
              <?php } ?> 
              <?php if ($row['existencias'] == 0): ?> 
                  disabled 
              <?php endif; ?> 
              class="btn btn-warning btn-lg" 
              id="agregarCarrito" 
              data-id="<?php echo $_REQUEST['id'] ?>" 
              data-nombre="<?php echo $row['nombre'] ?>" 
              data-web_path="<?php echo htmlspecialchars($firstImageUrl) ?>"
              data-precio="<?php echo $row['precio'] ?>"
              data-existencias="<?php echo $row['existencias'] ?>"
          >
              <i class="fas fa-cart-plus fa-lg mr-2"></i>
              Añadir al carrito
          </button>
          <div class="mt-4">
            Cantidad:
            <input type="number" class="form-control" id="cantidadProducto" value="1">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <button onclick="window.location.href='<?php if (!isset($_SESSION['id'])): ?>admin/lr-index.php<?php else: ?>index.php?modulo=valoracion&id=<?php echo $id ?><?php endif; ?>';"
     class="btn btn-primary btn-lg" style="margin-top: 30px;">Valorar este producto</button>
  </div>
</div>
