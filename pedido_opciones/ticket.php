<?php

  $idUsuario = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
  $idVenta = isset($_REQUEST['idPedido']) ? intval($_REQUEST['idPedido']) : 0;


  // Obtenemos el ID del cliente a partir del idUsuario
  $queryClienteID = "SELECT id FROM clientes WHERE idUsuario = '$idUsuario'";
  $resClienteID = mysqli_query($con, $queryClienteID);
  $rowClienteID = mysqli_fetch_assoc($resClienteID);
  $idCliente = $rowClienteID['id'];
?>
<div class='container mt-4 mb-4'>
  <div class='row'>
    <div class='col-12 col-md-6 mb-4'>
      <?php muestraRecibe($con, $idUsuario); ?>
    </div>
    <div class='col-12 col-md-6 mb-4'>
      <?php muestraDetalle($con, $idVenta); ?>
    </div>
  </div>
</div>
<?php

// Mostrar recibo
  function muestraRecibe($con, $idUsuario) {
    $queryCliente = "SELECT nickname, direccion, email FROM clientes WHERE idUsuario='$idUsuario'";
    $resCliente = mysqli_query($con, $queryCliente);
    $row = mysqli_fetch_assoc($resCliente);

    if (!$row) {
      echo "<p>Error al obtener los datos del cliente.</p>";
      return;
    }
?>
   <table class="table">
    <thead>
      <tr>
        <th colspan="3" style="background-color: rgba(161, 161, 161, 0.72);" class="text-center">
          Persona que recibe
        </th>
      </tr>
      <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Dirección</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo htmlspecialchars($row['nickname']) ?></td>
        <td><?php echo htmlspecialchars($row['email']) ?></td>
        <td><?php echo htmlspecialchars($row['direccion']) ?></td>
      </tr>
    </tbody>
  </table>
  <?php
    }

  // Mostrar detalle
  function muestraDetalle($con, $idVenta) {
    $queryDetalle = "
      SELECT p.nombre, dv.cantidad, dv.precio, dv.sub
      FROM detalleventas AS dv
      INNER JOIN productos AS p ON p.id = dv.idProduc
      WHERE dv.idVenta = '$idVenta'";
    $resDetalle = mysqli_query($con, $queryDetalle);

    if (!$resDetalle) {
      echo "<p>Error al obtener detalles del pedido.</p>";
      return;
    }

  $total = 0;
  ?>
  <table class="table">
    <thead>
      <tr>
        <th colspan="4" style="background-color: rgba(161, 161, 161, 0.72);" class="text-center">Datos del pedido</th>
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
          <td colspan="3" class="text-right">Total:</td>
          <td><?php echo $total; ?>€</td>
        </tr>
    </tbody>
  </table>
  <a class="btn btn-secondary float-end" target="_blank" href="pedido_opciones/imprimirFactura.php?idVenta=
  <?php echo $idVenta; ?>" role="button">
    <i class="fas fa-file-pdf"></i> Imprimir factura
  </a>
<?php
  }
?>