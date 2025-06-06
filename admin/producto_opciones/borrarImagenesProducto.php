<?php
  include_once "php/db_cookingshop.php";

  $con = mysqli_connect($host, $user, $clave, $db, $port);
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idProd = $_GET['id'];  // Obtener el ID del producto desde la URL
    
    // Consulta preparada para obtener las imágenes
    $query = "SELECT * FROM imagenes WHERE idProduct = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $idProd); // 'i' indica que estamos usando un entero
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Insertar los estilos dentro de la etiqueta <style> en el echo
    echo "<style>
            .image-container {
              display: flex;
              flex-direction: column;
              align-items: center;
              margin-bottom: 20px;
            }

            .image-container img {
              max-width: 100%;
              height: auto;
              width: 200px;
            }

            .image-container form {
              margin-top: 10px;
            }

            .image-container button {
              padding: 10px 20px;
            }
          </style>";

    // Mostrar las imágenes
    while ($row = mysqli_fetch_assoc($result)) {
      $imgURL = $row['url'];
      $imgID = $row['id'];  // ID de la imagen en la base de datos

      // Mostrar la imagen y el formulario con el botón de eliminación
      echo "<div class='image-container'>
              <!-- Imagen -->
              <img src='$imgURL' alt='Imagen del producto' width='200'>
              
              <!-- Formulario de eliminación -->
              <form action='producto_opciones/borrarImagen.php' method='post'>
                <input type='hidden' name='imgID' value='" . htmlspecialchars($imgID) . "'>
                <input type='hidden' name='idProd' value='" . htmlspecialchars($idProd) . "'>
                <input type='hidden' name='imgURL' value='" . htmlspecialchars($imgURL) . "'>
                <button type='submit' class='btn btn-danger'>Eliminar</button>
              </form>
            </div>";
    }
    mysqli_stmt_close($stmt);  // Cerrar el statement
  } else {
    echo "ID de producto inválido.";
  }

  // Cerrar la conexión a la base de datos
  mysqli_close($con);
?>
