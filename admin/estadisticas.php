<?php
  include_once "php/db_cookingshop.php";
  $conn = mysqli_connect($host, $user, $clave, $db, $port);

  $queryNumVentas = "SELECT COUNT(id) AS num FROM ventas 
      WHERE fecha BETWEEN DATE(DATE_SUB(NOW(), INTERVAL 7 DAY)) AND NOW();";
  $resNumVentas = mysqli_query($conn, $queryNumVentas);
  $rowNumVentas = mysqli_fetch_assoc($resNumVentas);

  $queryNumUsuarios = "SELECT COUNT(id) AS num FROM usuarios;";
  $resNumUsuarios = mysqli_query($conn, $queryNumUsuarios);
  $rowNumUsuarios = mysqli_fetch_assoc($resNumUsuarios);

  $queryVentasDia= "SELECT
    sum(detalleventas.sub) AS total,
    ventas.fecha
    FROM
    ventas
    INNER JOIN detalleventas ON detalleventas.idVenta = ventas.id
    GROUP BY DAY(ventas.fecha);";
  $resVentasDia=mysqli_query($conn,$queryVentasDia);
  $labelVentas="";
  $datosVentas="";

  while($rowVentasDia=mysqli_fetch_assoc($resVentasDia)){
    $labelVentas=$labelVentas."'".date_format(date_create($rowVentasDia['fecha']),"Y-m-d")."',";
    $datosVentas=$datosVentas.$rowVentasDia['total'].",";
  }
  $labelVentas=rtrim($labelVentas, ",");
  $datosVentas=rtrim($datosVentas,",");
?>
<script>
  var labelVentas=[<?php echo $labelVentas; ?>];
  var datosVentas=[<?php echo $datosVentas; ?>];
</script>
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Dashboard</h3>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    <div class="row">
      <!-- Ventas -->
      <div class="col-6">
        <div class="small-box text-bg-primary">
          <div class="inner">
            <h3><?php echo number_format($rowNumVentas['num']); ?></h3>
            <p>Ventas en los últimos 7 días</p>
          </div>
          <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
           xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
          </svg>
        </div>
      </div>

      <!-- Usuarios -->
      <div class="col-6">
        <div class="small-box text-bg-warning">
          <div class="inner">
            <h3><?php echo number_format($rowNumUsuarios['num']); ?></h3>
            <p>Usuarios registrados</p>
          </div>
          <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
           xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Gráfico de ventas -->
    <div class="row">
      <section class="col-12 connectedSortable">
        <div class="card mb-4">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-line"></i>
                Ventas por dia
            </h3>
          </div>
          <div class="card-body">
            <div class="tab-content p-0">
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                <canvas id="revenue-chart-canvas" style="position: absolute;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div> <!-- Fin row de gráfico -->
  </div>
</div>