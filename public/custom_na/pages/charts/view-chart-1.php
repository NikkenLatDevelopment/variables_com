<?php //TERMINADA

//Conexión
$serverName = "200.66.68.173";
$connectionInfo = array("Database" => "COMERCIAL_LAT", "UID" => "nikkcomer", "PWD" => "C0m3rCial$");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn){ die(print_r(sqlsrv_errors(), true)); }
//Conexión

//Vars
$code = $_POST["code"];
$name = trim($_POST["name"]);
$nameCotitular = $_POST["nameCotitular"];
$country = $_POST["country"];
$rank = $_POST["rank"];
//Vars

//Others
$dataComprasPersonal = array();
$dataComprasOrganizacion = array();
$dataComprasTotales = array();
$dataActivosMensuales = array();
$dataCompraPromActivo = array();
//Others

$period = new DateTime('2020-04-01');
$counter = 0;

while($counter < 24){
	$periodQuery = $period->format('Ym');
	$sql = "SELECT * FROM SD_DIAPOSITIVA3 WHERE VASS_CODIGO = '$code' AND PERIODO = '$periodQuery'";
    $recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
    while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$codigo = $row_sap[0];
		$periodo = $row_sap[1];

		$comprasPersonal = trim($row_sap[2]);
		if($comprasPersonal == ""){ $comprasPersonal = 0; }

		$comprasOrganizacion = trim($row_sap[3]);
		if($comprasOrganizacion == ""){ $comprasOrganizacion = 0; }

		$comprasTotales = trim($row_sap[4]);
		if($comprasTotales == ""){ $comprasTotales = 0; }

		$activosMensuales = trim($row_sap[5]);
		if($activosMensuales == ""){ $activosMensuales = 0; }

		$compraPromActivo = trim($row_sap[6]);
		if($compraPromActivo == ""){ $compraPromActivo = 0; }

		//Llenar array
		    $dataComprasPersonal = array_merge($dataComprasPersonal, array($comprasPersonal));
		    $dataComprasOrganizacion = array_merge($dataComprasOrganizacion, array($comprasOrganizacion));
		    $dataComprasTotales = array_merge($dataComprasTotales, array($comprasTotales));
		    $dataActivosMensuales = array_merge($dataActivosMensuales, array($activosMensuales));
		    $dataCompraPromActivo = array_merge($dataCompraPromActivo, array($compraPromActivo));
		//Llenar array
	}

	$period->modify('+1 month');
	$period = $period->format('Y-m-01');
	$period = new DateTime($period);
	$counter++;
}

//Convertir array
	$dataComprasPersonalChart = json_encode($dataComprasPersonal);
	$dataComprasOrganizacionChart = json_encode($dataComprasOrganizacion);
	$dataComprasTotalesChart = json_encode($dataComprasTotales);
	$dataActivosMensualesChart = json_encode($dataActivosMensuales);
	$dataCompraPromActivoChart = json_encode($dataCompraPromActivo);
//Convertir array

?>

<!-- Header -->
	<div class="mb-4 mt-5">
		<img src="custom/img/general/logo-nikken.png" alt="Logo NIKKEN">
		<h2 class="fw-bold text-uppercase h4 mt-3 mb-3">NIKKEN Latinoamérica</h2>

		<div class="row d-flex align-items-center">
			<div class="col-4">
				<div><strong>Periodo de Medición:</strong> Abril 2020 a Marzo 2022</div>
				<div><strong>País:</strong> <?php echo $country ?></div>
			</div>

			<div class="col-4">
				<div class="h3 fw-bold"><?php echo $name ?></div>
			</div>
			<div class="col-4">
				<div><strong>Código:</strong> <?php echo $code ?></div>
				<div><strong>Rango:</strong> <?php echo $rank ?></div>
			</div>
		</div>
	</div>
<!-- Header -->

<div class="table-responsive">
	<table class="table align-middle table-bordered ">
		<thead>
			<tr class="text-center">
				<th scope="col"></th>
				<th scope="col">abr20</th>
				<th scope="col">may20</th>
				<th scope="col">jun20</th>
				<th scope="col">jul20</th>
				<th scope="col">ago20</th>
				<th scope="col">sep20</th>
				<th scope="col">oct20</th>
				<th scope="col">nov20</th>
				<th scope="col">dic20</th>
				<th scope="col">ene21</th>
				<th scope="col">feb21</th>
				<th scope="col">mar21</th>
				<th scope="col">abr21</th>
				<th scope="col">may21</th>
				<th scope="col">jun21</th>
				<th scope="col">jul21</th>
				<th scope="col">ago21</th>
				<th scope="col">sep21</th>
				<th scope="col">oct21</th>
				<th scope="col">nov21</th>
				<th scope="col">dic21</th>
				<th scope="col">ene22</th>
				<th scope="col">feb22</th>
				<th scope="col">mar22</th>
				<th scope="col" class="custom-width-1">Total 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- Compra personal (Dólares) -->
				<tr>
					<th scope="row" class="custom-width-2">Compra Personal (Dólares)</th>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasPersonal[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataComprasPersonal as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Compra personal (Dólares) -->

			<!-- Compra organización (Dólares) -->
				<tr>
					<th scope="row" class="custom-width-2">Compra Organización (Dólares)</th>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasOrganizacion[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataComprasOrganizacion as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Compra organización (Dólares) -->

			<!-- Compra Total (Dólares) -->
				<tr>
					<th scope="row" class="custom-width-2">Compra Total (Dólares)</th>
					<td class="text-center"><?php echo number_format($dataComprasTotales[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataComprasTotales[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataComprasTotales as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Compra Total (Dólares) -->

			<!-- Compra Promedio por Activo (Dólares) -->
				<tr>
					<th scope="row" class="custom-width-2">Compra Promedio por Activo<br/>(Dólares)</th>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataCompraPromActivo[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataCompraPromActivo as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- Compra Promedio por Activo (Dólares) -->

			<!-- Otras Variables -->
				<tr>
					<td colspan="3"><strong>Crecimiento de la Compra Personal de los<br/>últimos 12 meses (Dólares) %</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataComprasPersonal as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							if($total_next == 0 || $total_prev == 0){
								echo "0%";
							}else{
								echo number_format(($total_next / ($total_prev) - 1) * 100, 2) . "%";
							}

							?>
						</strong>
					</td>

					<td colspan="2"></td>
					<td colspan="4"><strong>Crecimiento Compra Promedio<br/>Por Activo (Dolares) %</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataCompraPromActivo as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							if($total_next == 0 || $total_prev == 0){
								echo "0%";
							}else{
								echo number_format(($total_next / ($total_prev) - 1) * 100, 2) . "%";
							}

							?>
						</strong>
					</td>

					<td colspan="2"></td>
					<td colspan="4"><strong>Compras Personales del Último <br/>Año en Dolares</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataComprasPersonal as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							echo number_format($total_next, 2);

							?>
						</strong>
					</td>

					<td colspan="3"><strong>Crecimiento Activos</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataActivosMensuales as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							if($total_next == 0 || $total_prev == 0){
								echo "0%";
							}else{
								echo number_format(($total_next / ($total_prev) - 1) * 100, 2) . "%";
							}

							?>
						</strong>
					</td>
				</tr>

				<tr>
					<td colspan="3"><strong>Crecimiento de la Compra Organización de<br/>los últimos 12 meses (Dólares) %</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataComprasOrganizacion as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							if($total_next == 0 || $total_prev == 0){
								echo "0%";
							}else{
								echo number_format(($total_next / ($total_prev) - 1) * 100, 2) . "%";
							}

							?>
						</strong>
					</td>

					<td colspan="10"></td>
					<td colspan="4"><strong>Compras Organización del Último<br/>Año en Dolares</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataComprasOrganizacion as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							echo number_format($total_next, 2);

							?>
						</strong>
					</td>

					<td colspan="5"></td>
				</tr>
			<!-- Otras Variables -->
		</tbody>
	</table>
</div>

<div class="table-responsive mt-3">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col"></th>
				<th scope="col">abr20</th>
				<th scope="col">may20</th>
				<th scope="col">jun20</th>
				<th scope="col">jul20</th>
				<th scope="col">ago20</th>
				<th scope="col">sep20</th>
				<th scope="col">oct20</th>
				<th scope="col">nov20</th>
				<th scope="col">dic20</th>
				<th scope="col">ene21</th>
				<th scope="col">feb21</th>
				<th scope="col">mar21</th>
				<th scope="col">abr21</th>
				<th scope="col">may21</th>
				<th scope="col">jun21</th>
				<th scope="col">jul21</th>
				<th scope="col">ago21</th>
				<th scope="col">sep21</th>
				<th scope="col">oct21</th>
				<th scope="col">nov21</th>
				<th scope="col">dic21</th>
				<th scope="col">ene22</th>
				<th scope="col">feb22</th>
				<th scope="col">mar22</th>
				<th scope="col" class="custom-width-1">Total 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- Activos Mensuales -->
				<tr>
					<th scope="row" class="custom-width-2">Activos Mensuales</th>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosMensuales[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataActivosMensuales as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- Activos Mensuales -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="row mt-5">
		<div class="col-12 col-md-6 text-center">
			<!-- Gráfica comportamiento de compras vs activos mensuales -->
			<canvas id="viewChart1" class="w-100" height="660"></canvas>
			<!-- Gráfica comportamiento de compras vs activos mensuales -->
		</div>

		<div class="col-12 col-md-6 text-center">
			<!-- Gráfica compra promedio por activos - dolares -->
			<canvas id="viewChart11" class="w-100" height="660"></canvas>
			<!-- Gráfica compra promedio por activos - dolares -->
		</div>
	</div>
<!-- Gráficas -->

<div class="row mt-2"><div class="col-12 small">*Compras antes de impuestos- fletes- menudeo comisión</div></div>

<script>
	Chart.defaults.font.size = 16;
	//Gráfica comportamiento de compras vs activos mensuales
		var viewChart1 = document.getElementById('viewChart1').getContext('2d');
		var viewChart1Detail = new Chart(viewChart1, {
		    type: 'bar',
		    data: {
		        labels: ['Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene','Feb' ,'22'],
		        datasets: [
		        	{
			            label: 'Activos Mensuales',
			            data: <?php echo $dataActivosMensualesChart ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 1)', ],
			            borderColor: [ 'rgba(255, 99, 132, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			        },
			        {
			            label: 'Compra (Dólares)',
			            data: <?php echo $dataComprasTotalesChart ?>,
			            backgroundColor: [ 'rgba(255, 206, 86, 1)', ],
			            borderColor: [ 'rgba(255, 206, 86, 1)', ],
	      				yAxisID: 'y',
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Comportamiento de Compras VS Activos Mensuales',
						fontColor:'#000000'
					},
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
						title: {
				          	display: true,
				          	text: 'Dólares'
				        },
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
						title: {
				          	display: true,
				          	text: 'Activos Mensuales'
				        },
					},
				}
			},
		});
	//Gráfica comportamiento de compras vs activos mensuales

	//Gráfica compra promedio por activos - dolares
		var viewChart11 = document.getElementById('viewChart11').getContext('2d');
		var viewChart11Detail = new Chart(viewChart11, {
		    type: 'line',
		    data: {
		        labels: ['Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene','Feb', '22'],
		        datasets: [
			        {
			            label: 'Compra Promedio por Activos - Dólares',
			            data: <?php echo $dataCompraPromActivoChart ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 1)', ],
			            borderColor: [ 'rgba(255, 99, 132, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Compra Promedio por Activos - Dólares'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'Dólares'
			        	},
			      	}
			    }
			},
		});
	//Gráfica compra promedio por activos - dolares
</script>
