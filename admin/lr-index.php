<?php
  session_start();
  include_once "php/db_cookingshop.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y registro</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  </head>

  <body>
    <div>
      <a href="../index.php"><img src="assets/imagenes/inicio.png" alt="inicio" width="50px"></a>
    </div>
    <main>
      <div class="contenedor__todo">
        <div class="caja__trasera">
          <div class="caja__trasera-login">
            <h3>¿Ya tienes una cuenta?</h3>
            <p>Inicia sesión para entrar en la página</p>
            <button id="btn__iniciar-sesion">Iniciar sesión</button>
          </div>
          <div class="caja__trasera-register">
            <h3>¿Aun no tienes una cuenta?</h3>
            <p>Regístrate para que puedas iniciar sesión</p>
            <button id="btn__registrarse">Registrarse</button>
          </div>
        </div>
        <!--Formulario de login y register-->
        <div class="contenedor__login-register">
          <!--Login-->
      
          <form action="php/login_user.php" method="post" class="formulario__login">
            
            <h2>Iniciar sesión</h2>
            <input type="email" name="email" placeholder="Correo electrónico">
            <input type="password" name="pass" placeholder="Contraseña">
            <button type="submit" name="btn_ingresar">Entrar</button>

          </form>
          <!--Register-->
          
          <form action="php/registro_user.php" method="post" class="formulario__register">
            <h2>Registrarse</h2>
            <input type="text" placeholder="Nombre" name="nombre">
            <input type="text" placeholder="Correo eletrónico" name="email">
            <input type="password" placeholder="Contraseña" name="pass">
            <button>Registrarse</button>
          </form>
        </div>
      </div>
    </main>
    <script src="assets/js/script.js"></script>
  </body>
</html>