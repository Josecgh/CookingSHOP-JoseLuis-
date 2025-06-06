<?php
  include_once "../php/db_cookingshop.php";
  $con = mysqli_connect($host, $user, $clave, $db, $port);

  if (isset($_POST['guardar']) && !empty($_POST['idProd'])) {
    $idProd = mysqli_real_escape_string($con, $_POST['idProd']);
    $ficheros = $_FILES['imagenes'];

    // Definir tipos permitidos y tamaño máximo
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    // Iteramos sobre los archivos subidos
    for ($i = 0; $i < count($ficheros['name']); $i++) {
      $tmp_name = $ficheros['tmp_name'][$i];
      $name = $ficheros['name'][$i];
      $error = $ficheros['error'][$i];
      $size = $ficheros['size'][$i];

      if ($error === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($tmp_name);
        $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes) && in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
          if ($size <= $maxSize) {
            // Generamos un nombre único manteniendo la extensión original
            $uniqueName = uniqid() . '.' . $fileExt;
            $destino = "../../uploads/" . $uniqueName;

            if (move_uploaded_file($tmp_name, $destino)) {
              // Insertar en la base de datos usando una consulta preparada
              $query = "INSERT INTO imagenes (idProduct, url, tipo) VALUES (?, ?, ?)";
              if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt, "sss", $idProd, $destino, $fileType);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
              } else {
                error_log("Error al preparar la consulta: " . mysqli_error($con));
              }
            } else {
              error_log("Error al mover el archivo: $name");
            }
          } else {
            error_log("El archivo es demasiado grande: $name");
          }
        } else {
          error_log("El archivo no es un formato permitido: $name");
        }
      } else {
        error_log("Error al subir el archivo: $name (Código de error: $error)");
      }
    }

    // Redirigir solo una vez después de procesar todos los archivos
    header("Location: ../panel.php?modulo=subirImagenesProducto");
    exit;
  }

  mysqli_close($con);
?>
