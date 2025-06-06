<?php
  $idUsuario = $_SESSION['id'];
  $query = "select id,idUsuario,nickname,direccion,telefono,email from clientes where idUsuario=$idUsuario";
  $res = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($res);
?>
<div class="container" style="margin-top: 25px;">
  <h1>Datos de envío</h1>
  <form action="index.php?modulo=procesarDatosEnvio" method="post">
    <!-- Nickname -->
    <div class="mb-3">
      <label for="nickname" class="form-label">Nickname</label>
      <input type="text" name="nickname" class="form-control" id="nickname" placeholder="Ingresa tu nickname" <?php if(isset($row['nickname'])){ ?> value="<?php echo $row['nickname']?>" <?php } ?> required>
    </div>

    <!-- Teléfono -->
    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono de contacto</label>
      <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="+34 600 123 456" <?php if(isset($row['telefono'])){ ?> value="<?php echo $row['telefono']?>" <?php } ?> required>
    </div>

    <!-- Correo -->
    <div class="mb-3">
      <label for="email" class="form-label">Correo de contacto</label>
      <input type="email" name="email" class="form-control" id="email" placeholder="correo@ejemplo.com" <?php if(isset($row['email'])){ ?> value="<?php echo $row['email']?>" <?php } ?> required>
    </div>

    <!-- Dirección -->
    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección de envío <span class="text-muted">(ej. Calle... 123, Ciudad, Comunidad autónoma, CP 00000)</span></label>
      <textarea class="form-control" name="direccion" id="direccion" rows="3" placeholder="Calle, número, ciudad, código postal" required><?php if(isset($row['direccion'])){?><?php echo $row['direccion']?><?php } ?></textarea>
    </div>

    <!-- Guardar datos -->
    .<div class="form-check" style="margin-bottom: 15px;;">
      <label class="form-check-label">
        <input type="checkbox" class="form-check-input"  id="guardar" name="guardar">
        Estos datos serán registrados para posteriores compras
      </label>
    </div>

    <!-- Botón enviar -->
    <a class="btn btn-warning" href="index.php?modulo=verCarrito" role="button">Regresar a carrito</a>
    <div class="float-end">
      <?php if(isset($row['id'])){ ?>
        <a class="btn btn-primary" href="index.php?modulo=pasarela">Ir a pagar</a>
      <?php }?>
      <button type="submit" class="btn btn-primary">Registrar datos</button>
    </div>
  </form>
</div>