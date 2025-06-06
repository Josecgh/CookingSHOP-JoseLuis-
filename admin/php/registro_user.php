<?php
  include 'db_cookingshop.php';

  if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['pass'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $pass = md5($_POST['pass']);

    
    if(empty($nombre) || empty($email) || empty($pass)){
      echo '
        <script>
          window.location = "../lr-index.php?error=campos_vacios";
          alert("Rellenar los campos, por favor");
        </script>
      ';
      
    } else {
      $query = "INSERT INTO usuarios (email, pass, nombre)
        VALUES ('$email', '$pass', '$nombre')";

      //Verificar  que el correo no se repita en la base de datos//
      $consulta = "SELECT * FROM usuarios WHERE email='$email' ";
      $verificar_correo = mysqli_query($conn, $consulta);

      if(mysqli_num_rows($verificar_correo) > 0){
        echo '
          <script>
            window.location = "../lr-index.php?error=correo_repetido";
            alert("Este correo ya está registrado, inténtalo con otro");
          </script>
        ';
        exit();
      }


      $ejecutar = mysqli_query($conn, $query);
  
      if($ejecutar){
        echo '
          <script>
            window.location = "../lr-index.php?succes=usuario_registrado";
            alert("Usuario registrado con éxito");
          </script>
        ';
      } else {
        echo '
          <script>
            window.location = "../lr-index.php?error=registro_fallido";
            alert("Ha habido un error, vuelva a intentarlo");
          </script>
        ';
      }

      mysqli_close($conn);
    }
  }
?>