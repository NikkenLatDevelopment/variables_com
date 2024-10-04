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
$dataIncorporacionesCiPer = array();
$dataIncorporacionesCbPer = array();
$dataIncorporacionesCiOrg = array();
$dataIncorporacionesCbOrg = array();
$dataIncorporacionesTotales = array();
$dataActivosMensuales = array();
$dataActivosTrimestral = array();
$dataReactivaciones = array();
$dataIncActividad = array();
$dataPorcentaje = array();
$dataIncorActivo = array();
//Others

$period = new DateTime('2020-04-01');
$counter = 0;

while($counter < 24){
	$periodQuery = $period->format('Ym');

	$sql = "SELECT * FROM SD_DIAPOSITIVA4_5 WHERE VASS_CODIGO = '$code' AND PERIODO = '$periodQuery'";
    $recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
    while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$codigo = $row_sap[0];
		$periodo = $row_sap[1];

		$incorporacionesCiPer = trim($row_sap[2]);
		//if($incorporacionesCiPer == ""){ $incorporacionesCiPer = 0; }

		$incorporacionesCbPer = trim($row_sap[3]);
		//if($incorporacionesCbPer == ""){ $incorporacionesCbPer = 0; }

		$incorporacionesCiOrg = trim($row_sap[4]);
		//if($incorporacionesCiOrg == ""){ $incorporacionesCiOrg = 0; }

		$incorporacionesCbOrg = trim($row_sap[5]);
		//if($incorporacionesCbOrg == ""){ $incorporacionesCbOrg = 0; }

		$incorporacionesTotales = trim($row_sap[6]);
		//if($incorporacionesTotales == ""){ $incorporacionesTotales = 0; }

		$activosMensuales = trim($row_sap[7]);
		//if($activosMensuales == ""){ $activosMensuales = 0; }

		$activosTrimestral = trim($row_sap[8]);
		//if($activosTrimestral == ""){ $activosTrimestral = 0; }

		$reactivaciones = trim($row_sap[9]);
		//if($reactivaciones == ""){ $reactivaciones = 0; }

		$incActividad = trim($row_sap[10]);
		//if($incActividad == ""){ $incActividad = 0; }

		$porcentaje = trim($row_sap[11]);
		//if($porcentaje == ""){ $porcentaje = 0; }

		$incorActivo = trim($row_sap[12]);
		//if($incorActivo == ""){ $incorActivo = 0; }

		//Llenar array
		    $dataIncorporacionesCiPer = array_merge($dataIncorporacionesCiPer, array($incorporacionesCiPer));
		    $dataIncorporacionesCbPer = array_merge($dataIncorporacionesCbPer, array($incorporacionesCbPer));
		    $dataIncorporacionesCiOrg = array_merge($dataIncorporacionesCiOrg, array($incorporacionesCiOrg));
		    $dataIncorporacionesCbOrg = array_merge($dataIncorporacionesCbOrg, array($incorporacionesCbOrg));
		    $dataIncorporacionesTotales = array_merge($dataIncorporacionesTotales, array($incorporacionesTotales));
		    $dataActivosMensuales = array_merge($dataActivosMensuales, array($activosMensuales));
		    $dataActivosTrimestral = array_merge($dataActivosTrimestral, array($activosTrimestral));
		    $dataReactivaciones = array_merge($dataReactivaciones, array($reactivaciones));
		    $dataIncActividad = array_merge($dataIncActividad, array($incActividad));
		    $dataPorcentaje = array_merge($dataPorcentaje, array($porcentaje));
		    $dataIncorActivo = array_merge($dataIncorActivo, array($incorActivo));
		//Llenar array
	}

	$period->modify('+1 month');
	$period = $period->format('Y-m-01');
	$period = new DateTime($period);
	$counter++;
}

//Convertir array
	$dataIncorporacionesCiPerChart = json_encode($dataIncorporacionesCiPer);
	$dataIncorporacionesCbPerChart = json_encode($dataIncorporacionesCbPer);
	$dataIncorporacionesCiOrgChart = json_encode($dataIncorporacionesCiOrg);
	$dataIncorporacionesCbOrgChart = json_encode($dataIncorporacionesCbOrg);
	$dataIncorporacionesTotalesChart = json_encode($dataIncorporacionesTotales);
	$dataActivosMensualesChart = json_encode($dataActivosMensuales);
	$dataActivosTrimestralChart = json_encode($dataActivosTrimestral);
	$dataReactivacionesChart = json_encode($dataReactivaciones);
	$dataIncActividadChart = json_encode($dataIncActividad);
	$dataPorcentajeChart = json_encode($dataPorcentaje);
//Convertir array

?>

<!-- Header -->
	<div class="mb-4">
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

<div class="table-responsive mb-3">
	<table class="table align-middle table-bordered ">
		<thead>
			<tr class="text-center">
				<th scope="col" class="custom-width-2"></th>
						
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
			<!-- Inscripciones CIs Frontales -->
				<tr>
					<th scope="row" class="custom-width-2">Inscripciones CIs Frontales</th>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiPer[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncorporacionesCiPer as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Inscripciones CIs Frontales -->

			<!-- Inscripciones CPs Frontales -->
				<tr>
					<th scope="row" class="custom-width-2">Inscripciones CPs Frontales</th>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbPer[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncorporacionesCbPer as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Inscripciones CPs Frontales -->

			<!-- Inscripciones CIs Organización -->
				<tr>
					<th scope="row" class="custom-width-2">Inscripciones CIs Organización</th>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCiOrg[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncorporacionesCiOrg as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Inscripciones CIs Organización -->

			<!-- Inscripciones CPs Organización -->
				<tr>
					<th scope="row" class="custom-width-2">Inscripciones CPs Organización</th>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesCbOrg[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncorporacionesCbOrg as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Inscripciones CPs Organización -->

			<!-- Inscripciones Totales -->
				<tr>
					<th scope="row" class="custom-width-2">Inscripciones Totales</th>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncorporacionesTotales as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Inscripciones Totales -->

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

			<!-- Activos Trimestrales -->
				<tr>
					<th scope="row" class="custom-width-2">Activos Trimestrales</th>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataActivosTrimestral[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataActivosTrimestral as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- Activos Trimestrales -->

			<!-- Reactivaciones -->
				<tr>
					<th scope="row" class="custom-width-2">Reactivaciones</th>
					<td class="text-center"><?php echo number_format($dataReactivaciones[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataReactivaciones[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataReactivaciones as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- Reactivaciones -->

			<!-- Otras Variables -->
				<tr>
					<td colspan="3"><strong>Crecimiento de la incorporación <br/>personal de los últimos 12 meses %</strong></td>
					<td colspan="3" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataIncorporacionesCiPer as $value){
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

					<td colspan="4"></td>
					<td colspan="4"><strong>Crecimiento de incorporaciones<br/>Por activo %</strong></td>
					<td colspan="4" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataIncorActivo as $value){
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
					<td colspan="4"><strong>Incorporaciones Personales<br/>del Último Año</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataIncorporacionesCiPer as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							echo number_format($total_next, 0);

							?>
						</strong>
					</td>
				</tr>

				<tr>
					<td colspan="3"><strong>Crecimiento de la incorporación de la<br/>organización de los últimos 12 meses %</strong></td>
					<td colspan="3" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataIncorporacionesCiOrg as $value){
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

					<td colspan="14"></td>
					<td colspan="4"><strong>Incorporaciones de la organización<br/>en el último año</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$total_prev = 0;
							$total_next = 0;
							$counter = 0;

							foreach ($dataIncorporacionesCiOrg as $value){
								if($counter < 12){ $total_prev = $total_prev + $value;
								}else{ $total_next = $total_next + $value; }
								$counter++;
							}

							echo number_format($total_next, 0);

							?>
						</strong>
					</td>
				</tr>
			<!-- Otras Variables -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="row my-2">
		<div class="col-12 col-md-6 text-center">
			<!-- Gráfica compra promedio por activos - dolares -->
			<canvas id="viewChart2" class="w-100" height="500"></canvas>
			<!-- Gráfica compra promedio por activos - dolares -->
		</div>

		<div class="col-12 col-md-6 text-center">
			<!-- Gráfica comportamiento y calidad de las incorporaciones -->
			<canvas id="viewChart22" class="w-100" height="500"></canvas>
			<!-- Gráfica comportamiento y calidad de las incorporaciones -->
		</div>
	</div>
<!-- Gráficas -->

<div class="table-responsive mt-4 pt-3">
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
			<!-- Incorporaciones Totales -->
				<tr>
					<th scope="row" class="custom-width-2">Incorporaciones Totales</th>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorporacionesTotales[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncorporacionesTotales as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones Totales -->

			<!-- Incorporaciones con Actividad Trimestral -->
				<tr>
					<th scope="row" class="custom-width-2">Incorporaciones con Actividad<br/>Trimestral</th>
					<td class="text-center"><?php echo number_format($dataIncActividad[0], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[1], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[2], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[3], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[4], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[5], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[6], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[7], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[8], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[9], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[10], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[11], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[12], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[13], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[14], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[15], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[16], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[17], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[18], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[19], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[20], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[21], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[22], 0) ?></td>
					<td class="text-center"><?php echo number_format($dataIncActividad[23], 0) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncActividad as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones con Actividad Trimestral -->

			<!-- % Incorporados con Actividad Trimestral -->
				<tr>
					<th scope="row" class="custom-width-2">% Incorporados con Actividad<br/>Trimestral</th>
					<td class="text-center"><?php echo number_format($dataPorcentaje[0], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[1], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[2], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[3], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[4], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[5], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[6], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[7], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[8], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[9], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[10], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[11], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[12], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[13], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[14], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[15], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[16], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[17], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[18], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[19], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[20], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[21], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[22], 0) ?>%</td>
					<td class="text-center"><?php echo number_format($dataPorcentaje[23], 0) ?>%</td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataPorcentaje as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0) . "%";

						?>
					</td>
				</tr>
			<!-- % Incorporados con Actividad Trimestral -->
		</tbody>
	</table>
</div>

<script>
	Chart.defaults.font.size = 16;
	//Gráfica compra promedio por activos - dolares
		var viewChart2 = document.getElementById('viewChart2').getContext('2d');
		var viewChart2Detail = new Chart(viewChart2, {
		    type: 'line',
		    data: {
		        labels: [ 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene','Feb', '22'],
		        datasets: [
			        {
			            label: 'Activos Mensuales',
			            data: <?php echo $dataActivosMensualesChart ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 1)', ],
			            borderColor: [ 'rgba(255, 99, 132, 1)', ],
			        },
			        {
			            label: 'Reactivaciones',
			            data: <?php echo $dataReactivacionesChart ?>,
			            backgroundColor: [ 'rgba(54, 162, 235, 1)', ],
			            borderColor: [ 'rgba(54, 162, 235, 1)', ],
			        },
			        {
			            label: 'Activos Trimestrales',
			            data: <?php echo $dataActivosTrimestralChart ?>,
			            backgroundColor: [ 'rgba(109, 85, 125, 1)', ],
			            borderColor: [ 'rgba(109, 85, 125, 1)', ],
			        },
			        {
			            label: 'Incorporaciones',
			            data: <?php echo $dataIncorporacionesTotalesChart ?>,
			            backgroundColor: [ 'rgba(255, 206, 86, 1)', ],
			            borderColor: [ 'rgba(255, 206, 86, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Comportamiento de Compras e Incorporaciones'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'No. de Personas'
			        	},
			      	}
			    }
			},
		});
	//Gráfica compra promedio por activos - dolares

	//Gráfica comportamiento y calidad de las incorporaciones
		var viewChart22 = document.getElementById('viewChart22').getContext('2d');
		var viewChart22Detail = new Chart(viewChart22, {
		    type: 'bar',
		    data: {
		        labels: [ 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene','Feb', '22'],
		        datasets: [
		        	{
			            label: '% Incorporados con Actividad Trimestral',
			            data: <?php echo $dataPorcentajeChart ?>,
			            backgroundColor: [ 'rgba(0, 0, 0, 1)', ],
			            borderColor: [ 'rgba(0, 0, 0, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			        },
			        {
			            label: 'Incorporaciones',
			            data: <?php echo $dataIncorporacionesTotalesChart ?>,
			            backgroundColor: [ 'rgba(255, 206, 86, 1)', ],
			            borderColor: [ 'rgba(255, 206, 86, 1)', ],
	      				yAxisID: 'y',
			        },
			        {
			            label: 'Incorporados con Actividad Trimestral',
			            data: <?php echo $dataIncActividadChart ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 1)', ],
			            borderColor: [ 'rgba(255, 99, 132, 1)', ],
	      				yAxisID: 'y',
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Comportamiento y Calidad de las Incorporaciones'
					},
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
						title: {
				          	display: true,
				          	text: 'No. de Incorporaciones'
				        },
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
						title: {
				          	display: true,
				          	text: '%'
				        },
					},
				}
			},
		});
	//Gráfica comportamiento y calidad de las incorporaciones
</script>
