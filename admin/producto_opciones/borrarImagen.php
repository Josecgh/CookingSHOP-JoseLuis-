<?php
  include_once "../php/db_cookingshop.php";

  // Verificar la conexión a la base de datos
  $con = mysqli_connect($host, $user, $clave, $db, $port);

  if (!empty($_POST['imgID']) && !empty($_POST['imgURL']) && !empty($_POST['idProd'])) {
    $idProd = $_POST['idProd'];
    $imgID = $_POST['imgID'];
    $imgURL = $_POST['imgURL'];

    // Escapar variables para prevenir inyecciones SQL
    $idProd = mysqli_real_escape_string($con, $idProd);
    $imgID = mysqli_real_escape_string($con, $imgID);
    $imgURL = mysqli_real_escape_string($con, $imgURL);

    // Borrar la imagen de la base de datos con una sentencia preparada
    $query = "DELETE FROM imagenes WHERE id = ?";
    if ($stmt = mysqli_prepare($con, $query)) {
      mysqli_stmt_bind_param($stmt, "i", $imgID);  // "i" indica que es un entero
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);

        // Verificar y eliminar el archivo del servidor
        if (file_exists($imgURL)) {
          if (@unlink($imgURL)) {  // Suprimir errores con @
            error_log("Imagen eliminada correctamente: $imgURL");
          } else {
            error_log("Error al eliminar la imagen: $imgURL");
          }
        } else {
          error_log("El archivo no existe: $imgURL");
        }

        header("Location: ../panel.php?modulo=borrarImagenesProducto&id=" . urlencode($idProd));
          exit;
      } else {
        error_log("Error al ejecutar la consulta: " . mysqli_error($con));
      }
    } else {
      error_log("Error al preparar la consulta: " . mysqli_error($con));
    }
  } else {
    error_log("Datos insuficientes para eliminar la imagen.");
  }

  mysqli_close($con);
?>