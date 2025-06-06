<?php
  session_start();
  include_once "../admin/php/db_cookingshop.php";
  $con = mysqli_connect($host, $user, $clave, $db, $port);

  $queryUsuario = "SELECT email, nombre FROM usuarios WHERE id='".$_SESSION['id']."'";
  $resUsuario = mysqli_query($con, $queryUsuario);
  $rowUsuario = mysqli_fetch_assoc($resUsuario);

  $queryCliente = "SELECT nickname, direccion, email FROM clientes WHERE idUsuario='".$_SESSION['id']."'";
  $resCliente = mysqli_query($con, $queryCliente);
  $rowCliente = mysqli_fetch_assoc($resCliente);

  $idVenta=mysqli_real_escape_string($con, $_REQUEST['idVenta']);
  $queryVenta = "SELECT v.id, v.fecha 
  FROM ventas AS v WHERE v.id='".$idVenta."';";
  $resVenta = mysqli_query($con, $queryVenta);
  $rowVenta = mysqli_fetch_assoc($resVenta);
?>
<?php
  ob_start();

  $imagePath = realpath('../admin/dist/assets/img/cs_logo.png');
  $imageData = base64_encode(file_get_contents($imagePath));
  $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
  $base64 = "data:image/{$imageType};base64,{$imageData}";
?>
<style>
  .watermark {
    position: absolute;
      top: 50%;
      left: 50%;
      width: 210mm;
      height: 210mm;
      transform: translate(-50%, -50%);
      background-image: url('<?php echo $base64; ?>');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
      opacity: 0.08; /* Marca de agua suave */
      border-radius: 50%;
      pointer-events: none;
  }
  .logo {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 2.5em;
    font-weight: bold;
  }

  .logo .cooking {
    color: #FF5722; /* Naranja tipo cocina */
  }

  .logo .shop {
    color: #4CAF50; /* Verde tipo ecológico, mercado */
  }
</style>
<div class="watermark"></div>
<div class="logo">
  <span class="cooking">Cooking</span><span class="shop">SHOP</span>
</div>
<table style="width: 750px; margin-top: 20px;">
  <thead>
    <tr>
      <th>Cliente</th>
      <th>Recibe</th>
      <th>Datos de la factura</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <strong>Nombre: </strong><?php echo $rowUsuario['nombre'] ?><br>
        <strong>Email: </strong><?php echo $rowUsuario['email'] ?><br>
      </td>
      <td>
        <strong>Nombre: </strong><?php echo $rowCliente['nickname'] ?><br>
        <strong>Email: </strong><?php echo $rowCliente['email'] ?><br>
        <strong>Dirección: </strong><?php echo $rowCliente['direccion'] ?><br>
      </td>
      <td>
        <strong>Id: </strong><?php echo $rowVenta['id'] ?><br>
        <strong>Fecha: </strong><?php echo $rowVenta['fecha'] ?><br>
      </td>
    </tr>
  </tbody>
</table>
<?php
$queryDetalle = "
  SELECT p.nombre, dv.cantidad, dv.precio, dv.sub
  FROM detalleventas AS dv
  INNER JOIN productos AS p ON p.id = dv.idProduc
  WHERE dv.idVenta = '$idVenta'";
$resDetalle = mysqli_query($con, $queryDetalle);
$total = 0;
?>
<table style="width: 750px; margin-top: 30px;">
  <thead>
    <tr>
      <th colspan="4" class="text-center">Datos del pedido</th>
    </tr>
    <tr>
      <th>Nombre</th>
      <th>Cantidad</th>
      <th>Precio</th>
      <th>SubTotal</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($resDetalle)) {
      $total += $row['sub']; ?>
    <tr>
      <td><?php echo htmlspecialchars($row['nombre']); ?></td>
      <td><?php echo $row['cantidad']; ?></td>
      <td><?php echo $row['precio']; ?>€</td>
      <td><?php echo $row['sub']; ?>€</td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="3" class="text-right"><strong>Total:</strong></td>
      <td><?php echo $total; ?>€</td>
    </tr>
  </tbody>
</table>
<?php $html=ob_get_clean(); ?>
<?php
  include_once "../dompdf/autoload.inc.php";
  use Dompdf\Dompdf;
  $pdf=new Dompdf();
  $pdf->loadHtml($html);
  $pdf->setPaper("A4", "landingscape");
  $pdf->render();
  $pdf->stream();
?>