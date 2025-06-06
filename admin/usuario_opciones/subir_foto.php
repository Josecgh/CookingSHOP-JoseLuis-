<?php
  include('php/db_cookingshop.php');

  $id = $_SESSION['id'];
  $mensaje = "";

  // Procesar la subida de la imagen
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["imagen"])) {
    $archivo = $_FILES["imagen"];
    $extensiones_permitidas = ["jpg", "jpeg", "png", "gif"];
    $extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));

    // Validar la extensión
    if (!in_array($extension, $extensiones_permitidas)) {
      $mensaje = "Formato no permitido. Usa JPG, JPEG, PNG o GIF.";
    } elseif ($archivo["size"] > 5000000) { // Límite de 5MB
      $mensaje = "El archivo es demasiado grande. Máximo 5MB.";
    } else {
      // Crear carpeta si no existe
      $carpeta_destino = "../usuario_opciones/fotos_perfiles/";  

      // Nombre único basado en el ID del usuario
      $nuevo_nombre = "perfil_" . $id . "." . $extension;
      $ruta_destino = $carpeta_destino . $nuevo_nombre;

      // Mover el archivo a la carpeta de destino
      if (move_uploaded_file($archivo["tmp_name"], $ruta_destino)) {
        // Guardar en la base de datos
        $query = "UPDATE usuarios SET imagen_perfil = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $nuevo_nombre, $id);

        if (mysqli_stmt_execute($stmt)) {
          $mensaje = "Imagen actualizada correctamente.";
        } else {
          $mensaje = "Error al actualizar la base de datos.";
        }
      } else {
        $mensaje = "Error al mover la imagen.";
      }
    }
  }

  // Obtener la imagen actual del usuario
  $query = "SELECT imagen_perfil FROM usuarios WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  $imagen_actual = $row['imagen_perfil'] ?? '';
?>
  
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f4f9;
    text-align: center;
    margin: 0;
    padding: 0;
  }
  .container {
    width: 50%;
    margin: 50px auto;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }
  h2 {
    color: #3498db;
  }
  .perfil-img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #3498db;
  }
  .mensaje {
    margin: 15px 0;
    font-weight: bold;
    color: red;
  }
  input[type="file"] {
    margin-top: 10px;
  }
  button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  button:hover {
    background-color: #2980b9;
  }
  .volver {
    display: inline-block;
    margin-top: 15px;
    color: #333;
    text-decoration: none;
    font-weight: bold;
  }
  .volver:hover {
    color: #3498db;
  }
</style>
<body>
  <div class="container">
    <h2>Cambiar Imagen de Perfil</h2>
    <?php if ($imagen_actual): ?>
      <img src="../usuario_opciones/fotos_perfiles/<?php echo htmlspecialchars($imagen_actual); ?>"
       class="perfil-img" alt="Imagen de perfil">
    <?php else: ?>
      <p>No tienes una imagen de perfil.</p>
    <?php endif; ?>

    <form action="panel.php?modulo=subirFoto" method="POST" enctype="multipart/form-data">
      <input type="file" name="imagen" accept="image/*" required>
      <br>
      <button type="submit">Subir Imagen</button>
    </form>
    <?php if (!empty($mensaje)): ?>
      <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>
    <a href="panel.php?modulo=perfil" class="volver">Volver al perfil</a>
  </div>
</body>