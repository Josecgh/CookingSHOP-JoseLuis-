<div class="contenedor-principal">
  <div class="container mt-4">
    <div class="row">
      <?php
      $nombre = mysqli_real_escape_string($conn, $_REQUEST['nombre'] ?? ''); // Valor de búsqueda

      // Determinamos el número total de productos y calculamos las páginas necesarias
      $queryContador = "SELECT COUNT(*) AS cuenta FROM productos WHERE nombre LIKE '%$nombre%'";
      $resContador = mysqli_query($conn, $queryContador);
      $rowContador = mysqli_fetch_assoc($resContador);
      $totalProductos = $rowContador['cuenta'];

      $elementosPorPagina = 8;
      $totalPaginas = ceil($totalProductos / $elementosPorPagina);
      $paginaSel = $_REQUEST['pagina'] ?? 1;

      $inicioLimite = ($paginaSel - 1) * $elementosPorPagina;
      $limite = "LIMIT $inicioLimite, $elementosPorPagina";

      // Consulta para obtener los productos
      $query = "SELECT p.id, p.nombre, p.precio, p.existencias, p.descripcion, i.url 
                FROM productos AS p
                INNER JOIN imagenes AS i ON p.id = i.idProduct
                WHERE p.nombre LIKE '%$nombre%'
                GROUP BY i.idProduct
                ORDER BY p.id DESC
                $limite";
      $res = mysqli_query($conn, $query);

      // Verificamos si se encontraron productos
      if (mysqli_num_rows($res) > 0) {
        // Mostrar los productos
        while ($row = mysqli_fetch_assoc($res)) {
      ?>
          <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card" style="border-color: yellow;">
              <h5 class="text-center"><?php echo $row['nombre']; ?></h5>
              <img class="card-img-top img-thumbnail" src="<?php echo $row['url']; ?>" style="border-radius: 10px;" alt="Imagen de producto">
              <div class="card-body">
                <p class="card-text"><strong>Precio:</strong> <?php echo $row['precio']; ?>€</p>
                <p class="card-text"><strong>Existencias:</strong> <?php echo $row['existencias']; ?></p>
                <a href="index.php?modulo=descripcionProducto&id=<?php echo $row['id']; ?>"
                 class="btn ver-producto">Ver producto</a>
              </div>
            </div>
          </div>
      <?php
        }
      } else {
        // Si no se encuentran productos
        echo '<div class="col-12 text-center"><p><strong>No se encontraron productos.</strong></p></div>';
      }
      ?>
    </div>

    <!-- Paginación -->
    <?php if ($totalPaginas > 0 && $totalProductos > 0) { ?>
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <!-- Botón "Anterior" -->
          <?php if ($paginaSel > 1) { ?>
            <li class="page-item">
              <a class="page-link" href="index.php?modulo=productos&pagina=
              <?php echo $paginaSel - 1; ?>&nombre=<?php echo $nombre; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
          <?php } ?>

          <!-- Páginas -->
          <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
            <li class="page-item <?php echo ($paginaSel == $i) ? "active" : ""; ?>">
              <a class="page-link" href="index.php?modulo=productos&pagina=
              <?php echo $i; ?>&nombre=<?php echo $nombre; ?>"><?php echo $i; ?></a>
            </li>
          <?php } ?>

          <!-- Botón "Siguiente" -->
          <?php if ($paginaSel < $totalPaginas) { ?>
            <li class="page-item">
              <a class="page-link" href="index.php?modulo=productos&pagina=
              <?php echo $paginaSel + 1; ?>&nombre=<?php echo $nombre; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
    <?php } ?>
  </div>
</div>
