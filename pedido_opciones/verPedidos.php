<?php
  $idUsuario = $_SESSION['id'];

  $queryClientes = "SELECT id FROM clientes where idUsuario=$idUsuario;";
  $resClientes = mysqli_query($conn,$queryClientes);
  $rowClientes = mysqli_fetch_assoc($resClientes);
  $idCliente = $rowClientes['id'];

  $query = "select id from ventas where idCli=$idCliente";
  $res = mysqli_query($conn, $query);
  

  $botones = [];
  while($row = mysqli_fetch_assoc($res)){
    $botones[] = $row['id'];
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pedidos del Cliente</title>
  <style>
    .boton-pedido {
      margin: 10px;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }
    .boton-pedido:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <h2>Pedidos del Cliente</h2>
  
  <?php $contador = 1; ?>
  <?php foreach ($botones as $idPedido): ?>
    <form method="POST" action="index.php?modulo=recordatorioFactura&idPedido=<?php echo $idPedido ?>" style="display:inline; margin: 10px;">
      <button type="submit" class="boton-pedido" style="width: 150px; margin-bottom: 15px;">Ver pedido <?php echo $contador ?></button>
    </form>
    <?php $contador++; ?>
  <?php endforeach; ?>
</body>
</html>