<?php
$idProducto = intval($_REQUEST['id']); // Id del producto que se pasa por GET
$idUsuario = $_SESSION['id']; // Id del usuario
// Verifica si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Captura los valores del formulario
  $comentario = mysqli_real_escape_string($con,$_REQUEST['comentario']??'');
  $puntuacion = intval($_POST['puntuacion']); // Convierte a entero la puntuación
  
  // Verifica que los datos necesarios estén presentes
  if (empty($comentario) || $puntuacion == 0) {
    echo "Por favor, asegúrate de llenar todos los campos correctamente.";
  } else {
    // Inserta los datos en la base de datos
    $stmt = $con->prepare("INSERT INTO valoracion (idUsuario, idProducto, comentario, puntuacion, fecha) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisi", $idUsuario, $idProducto, $comentario, $puntuacion);
    $result = $stmt->execute();

    if ($result) {
      $mensaje="La valoración ha sido subida con éxito";
      $sentencia = "success";
      echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=descripcionProducto&id='.$idProducto.'&mensaje='.$mensaje.'&sentencia='.$sentencia.'" /> ';    
      exit();
    } else {
      $mensaje = "Fallo en la valoración";
      $sentencia = "danger";
      echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=descripcionProducto&id='.$idProducto.'&mensaje='.$mensaje.'&sentencia='.$sentencia.'" /> ';
      exit();
    }
    
  }
}


?>