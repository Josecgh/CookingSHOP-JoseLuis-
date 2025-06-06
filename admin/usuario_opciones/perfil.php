<?php
include('php/db_cookingshop.php');
$id = $_SESSION['id'];

$query = "SELECT id, email, nombre, imagen_perfil FROM usuarios WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);  // "i" para entero
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verificar si se encontró al usuario
if ($row = mysqli_fetch_assoc($result)) {
  // Usuario encontrado, proceder con la visualización del perfil
} else {
  echo "Usuario no encontrado";
  exit;
}
?>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
<style>
  body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
  }

  .container {
    width: 80%;
    max-width: 1200px;
    margin: 50px auto;
    padding: 30px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  h1 {
    text-align: center;
    color: #2c3e50;
  }

  /* Estilos para el perfil */
  .perfil {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin-bottom: 30px;
    position: relative; /* Añadido para posicionar el icono dentro de la imagen */
  }

  .perfil img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #3498db;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .perfil i {
    font-size: 150px;
    color: #ccc;
  }

  .perfil h2 {
    margin-top: 20px;
    color: #3498db;
  }

  /* Icono del lápiz */
  .perfil .edit-icon {
    height: 40px; 
    width: 40px;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    bottom: 10px; /* Ajuste base */
    right: 10px;
  }

  .perfil .edit-icon i {
    font-size: 20px;
  }

  /* Pantallas de sobremesa (mayores a 1200px) */
  @media (min-width: 1200px) {
    .perfil .edit-icon {
      height: 45px;
      width: 45px;
      bottom: 70px;
      right: 480px;
    }
    .perfil .edit-icon i {
      font-size: 22px;
    }
  }

  /* Portátiles y pantallas medianas (entre 768px y 1199px) */
  @media (max-width: 1199px) {
    .perfil .edit-icon {
      height: 40px;
      width: 40px;
      bottom: 70px;
      right: 440px;
    }
    .perfil .edit-icon i {
      font-size: 20px;
    }
  }

  /* Tablets (entre 480px y 767px) */
  @media (max-width: 767px) {
    .perfil .edit-icon {
      height: 35px;
      width: 35px;
      bottom: 59px;
      right: 220px;
    }
    .perfil .edit-icon i {
      font-size: 18px;
    }
  }

  /* Móviles (menos de 480px) */
  @media (max-width: 480px) {
    .perfil .edit-icon {
      height: 30px;
      width: 30px;
      bottom: 58px;
      right: 111px;
    }
    .perfil .edit-icon i {
      font-size: 16px;
    }
  }

  .perfil-info {
    text-align: center;
    font-size: 18px;
  }

  .perfil-info p {
    margin: 10px 0;
    font-weight: 500;
  }

  /* Botón de cerrar sesión */
  .logout-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #e74c3c;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    transition: background-color 0.3s ease;
  }

  .logout-btn:hover {
    background-color: #c0392b;
  }

  /* Estilos responsivos */
  @media (max-width: 768px) {
    .container {
      width: 90%;
      padding: 20px;
    }
  }
</style>
<body>
<div class="container">
  <!-- Perfil de usuario -->
  <div class="perfil">
    <p>Imagen de perfil:</p>
    <?php if ($row['imagen_perfil']) { ?>
      <img src="../usuario_opciones/fotos_perfiles/<?php echo htmlspecialchars($row['imagen_perfil']); ?>"
       alt="Imagen de perfil">
    <?php } else { ?>
      <i class="fas fa-user-circle"></i>
    <?php } ?>
    
    <a href="panel.php?modulo=subirFoto" class="edit-icon">
      <i class="fas fa-pencil-alt"></i>
    </a>

    <h2>Bienvenido, <?php echo htmlspecialchars($row['nombre']); ?></h2>
  </div>

  <!-- Información de perfil -->
  <div class="perfil-info">
    <h3>Datos de tu perfil</h3>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($row['nombre']); ?></p>
    <p><strong>Correo electrónico:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
  </div>

  <!-- Botón de cambiar  -->
  <div style="text-align: center; margin-top: 20px;">
    <a href="panel.php?modulo=cambiarDatos&id=<?php echo $_SESSION['id'] ?>" class="logout-btn">Editar usuario</a>
  </div>

  <input type="hidden" name="idUser" value="<?php $_SESSION['id'] ?>">
</div>