<?php
  include_once "admin/stripe/init.php";
  // Obtenemos el ID de usuario de la sesión
  $idUsuario = $_SESSION['id'];
  // Obtenemos el ID del cliente a partir del idUsuario
  $queryClienteID = "SELECT id FROM clientes WHERE idUsuario = '$idUsuario'";
  $resClienteID = mysqli_query($con, $queryClienteID);
  if (!$resClienteID || mysqli_num_rows($resClienteID) == 0) {
    die("Error: Cliente no encontrado.");
  }
  $rowClienteID = mysqli_fetch_assoc($resClienteID);
  $idCliente = $rowClienteID['id'];

  // Total del pago
  $total = isset($_REQUEST['total']) ? floatval($_REQUEST['total']) : 0;
  $amount = intval($total * 100); // En centavos

  // Stripe
  // Clave secreta
  \Stripe\Stripe::setApiKey("sk_test_51RHW9TRkQiaPbbYGnIlmQI7H9658kiIJeTQ0rfvz7d3Bivi2ZVGSTXk12UcgqWSMuKKpUQuHqPZA7jHFzc0pTF8q002VTPxauf");
  $token = $_POST['stripeToken'];

  try {
      $charge = \Stripe\Charge::create([
          'amount' => $amount,
          'currency' => 'usd',
          'description' => 'Pago de CookingSHOP',
          'source' => $token
      ]);

      if ($charge['captured']) {
          // Insertar venta
          $queryVenta = "INSERT INTO ventas (idCli, idPago, fecha) VALUES ('$idCliente', '{$charge['id']}', NOW())";
          $resVenta = mysqli_query($con, $queryVenta);

          if ($resVenta) {
              $idVenta = mysqli_insert_id($con);
              $insertaDetalle = "";
              $cantProd = count($_REQUEST['id']);

              for ($i = 0; $i < $cantProd; $i++) {
                  $idProd = mysqli_real_escape_string($con, $_REQUEST['id'][$i]);
                  $cantidad = mysqli_real_escape_string($con, $_REQUEST['cantidad'][$i]);
                  $precio = mysqli_real_escape_string($con, $_REQUEST['precio'][$i]);
                  $subTotal = $precio * $cantidad;

                  $insertaDetalle .= "('$idProd','$idVenta','$cantidad','$precio','$subTotal'),";
              }

              $insertaDetalle = rtrim($insertaDetalle, ",");
              $queryDetalle = "INSERT INTO detalleventas (idProduc, idVenta, cantidad, precio, sub)
               VALUES $insertaDetalle";
              $resDetalle = mysqli_query($con, $queryDetalle);
              if ($resDetalle) {
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
                  borrarCarrito();
              } else {
                  echo "Error al guardar detalles de venta.";
              }
          } else {
              echo "Error al registrar la venta.";
          }
      } else {
          echo "El cargo no fue capturado.";
      }
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
  }

  // Borrar carrito
  function borrarCarrito(){
    ?>
    <script>
      $.ajax({
        type: "post",
        url: "ajax/borrarCarrito.php",
        dataType: "json",
        success: function (response) {
          $("#badgeProducto").text("");
          $("#listaCarrito").text("");
        }
      });
    </script>
    <?php
  }

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
              <tr><th colspan="3" style="background-color: rgba(161, 161, 161, 0.72);" class="text-center">
                Persona que recibe</th>
              </tr>
              <tr><th>Nombre</th><th>Email</th><th>Dirección</th></tr>
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
            <tr><th colspan="4" style="background-color: rgba(161, 161, 161, 0.72);" class="text-center">
                Datos del pedido</th></tr>
            <tr><th>Nombre</th><th>Cantidad</th><th>Precio</th><th>SubTotal</th></tr>
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
    <a class="btn btn-secondary float-end" target="_blank"
     href="pedido_opciones/imprimirFactura.php?idVenta=<?php echo $idVenta; ?>" role="button">
      <i class="fas fa-file-pdf"></i> Imprimir factura
    </a>
    <?php
  }

?>