<?php
  session_start();
  include('db_cookingshop.php');
  if(empty($_POST["btn_ingresar"])){
    if (empty($_POST["email"]) and empty($_POST["pass"])) {
      echo '
        <script>
          window.location = "../lr-index.php";
          alert("Los campos están vacios");
        </script>
      ';
    } else {
      $email = $_POST["email"];
      $pass = md5($_POST["pass"]);
      $sql = $conn->query("select * from usuarios where email='$email' and pass='$pass' ");
      if ($datos=$sql->fetch_object()){
        $_SESSION['id'] = $datos->id;
        $_SESSION['nombre'] = $datos->nombre;
        $_SESSION['admin'] = $datos->admin;
        $_SESSION['imagen_perfil'] = $datos->imagen_perfil;
        // Redirigir según el tipo de usuario (admin o no)
        if ($_SESSION['admin'] == 1) {
          // Si es administrador, redirigir a la página de administración
          header("Location: ../panel.php");
        } else {
          // Si no es administrador, redirigir al panel de usuario regular
          header("Location: ../../index.php");
        }
        exit();
      } else {
        echo '
          <script>
            window.location = "../lr-index.php";
            alert("Los datos son incorectos");
          </script>
        ';
      }
    }
  }
?>