<?php

// Validar sesión
if (!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])) {
  die("Acceso denegado");
}

$idUsuario = (int) $_SESSION['id'];
$nickname = $_POST['nickname'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$guardar = isset($_POST['guardar']) ? 1 : 0;

if ($guardar) {
  // Verificar si ya hay datos para este usuario
  $stmt_check = $conn->prepare("SELECT id FROM clientes WHERE idUsuario = ?");
  $stmt_check->bind_param("i", $idUsuario);
  $stmt_check->execute();
  $stmt_check->store_result();

  if ($stmt_check->num_rows > 0) {
    // Ya existe, actualizamos
    $stmt_update = $conn->prepare("UPDATE clientes SET fecha = NOW(), nickname = ?, direccion = ?, telefono = ?, email = ? WHERE idUsuario = ?");
    $stmt_update->bind_param("ssssi", $nickname, $direccion, $telefono, $email, $idUsuario);
    $result = $stmt_update->execute();
    $stmt_update->close();
  } else {
    // No existe, insertamos
    $stmt_insert = $conn->prepare("INSERT INTO clientes (idUsuario, fecha, nickname, direccion, telefono, email) VALUES (?, NOW(), ?, ?, ?, ?)");
    $stmt_insert->bind_param("issss", $idUsuario, $nickname, $direccion, $telefono, $email);
    $result = $stmt_insert->execute();
    $stmt_insert->close();
  }

  $stmt_check->close();

  // Redirigir según resultado
  if ($result) {
    echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=registroEnvio&mensaje=Datos de envío procesados con éxito&sentencia=success" />';
  } else {
    echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=registroEnvio&mensaje=Error al guardar en la base de datos&sentencia=danger" />';
  }
} else {
  echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=registroEnvio&mensaje=No marcaste la opción para guardar los datos&sentencia=danger" />';
}

$conn->close();
?>
