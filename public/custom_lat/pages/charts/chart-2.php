<?php require_once("../../functions.php"); //Funciones

$prod = $_POST["prod"];

if(trim($prod) === 'NO'){
	$serverName75 = "172.24.16.75";
}
else{
	$serverName75 = "104.130.46.73";
}

$connectionInfo75 = array("Database" => "LAT_MyNIKKEN_TEST", "UID" => "Latamti", "PWD" => 'L8$aQ7mZ!pR42^Tx');
$conn75 = sqlsrv_connect($serverName75, $connectionInfo75);
if(!$conn75){ die(print_r(sqlsrv_errors(), true)); }

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = letterCountrie($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodopost = $_POST["periodo"];
//Vars

//Others
$dataIncorporaciones = array();
$dataIncorporacionesActivosMensuales = array();
$dataIncorporacionesReactivaciones = array();
$dataIncorporacionesActivosTrimestrales = array();
$dataIncorporacionesIncorporaciones = array();
$dataIncorporacionesPorcentajeIncorporadosActividadTrimestral = array();
$dataIncorporacionesIncorporadosActividadTrimestral = array();
//Others

//Consulta
	$sql = "EXEC LAT_MyNIKKEN.dbo.Incorporaciones $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$monthToShow = [];
	$x = 0;
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$incorporacionesCisFrontales = trim($rowSap[1]);
		$incorporacionesCpsFrontales = trim($rowSap[2]);
		$incorporacionesCisOrganizacion = trim($rowSap[3]);
		$incorporacionesCpsOrganizacion = trim($rowSap[4]);
		$inscripcionesTotales = trim($rowSap[5]);
		$activosMensualesCis = trim($rowSap[6]);
		$activosMensualesCps = trim($rowSap[7]);
		$totalActivosMensuales = trim($rowSap[8]);
		$activosTrimestrales = trim($rowSap[9]);
		$reactivaciones = trim($rowSap[10]);
		$incorporacionesActividadTrimestral = trim($rowSap[11]);
		$porcentajeIncorporacionesActividadTrimestral = trim($rowSap[12]);
		$inscripcionesActivo = trim($rowSap[13]);
		$periodo = trim($rowSap[14]);

		$periodotoShow = trim($rowSap[14]);
		$x++;
		$monthToShow[$x] = $rowSap[14];

		//Guardar datos en array
		$dataIncorporaciones[$periodo] = array("incorporacionesCisFrontales" => $incorporacionesCisFrontales, "incorporacionesCpsFrontales" => $incorporacionesCpsFrontales, "incorporacionesCisOrganizacion" => $incorporacionesCisOrganizacion, "incorporacionesCpsOrganizacion" => $incorporacionesCpsOrganizacion, "inscripcionesTotales" => $inscripcionesTotales, "activosMensualesCis" => $activosMensualesCis, "activosMensualesCps" => $activosMensualesCps, "totalActivosMensuales" => $totalActivosMensuales, "activosTrimestrales" => $activosTrimestrales, "reactivaciones" => $reactivaciones, "incorporacionesActividadTrimestral" => $incorporacionesActividadTrimestral, "porcentajeIncorporacionesActividadTrimestral" => $porcentajeIncorporacionesActividadTrimestral, "inscripcionesActivo" => $inscripcionesActivo);
		//Guardar datos en array
	}

	//Cerrar conexión
	sqlsrv_close($conn75);
	//Cerrar conexión
//Consulta

//Graficas
	$count = 0;

	//Periodo inicial de consulta
	$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
	$period = new DateTime("$periodoIni");
	//Periodo inicial de consulta

	while($count < 24){
		$periodQuery = $period->format('Ym');

		//Guardar activos mensuales
		$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["totalActivosMensuales"] : 0;
		$dataIncorporacionesActivosMensuales = array_merge($dataIncorporacionesActivosMensuales, array($price));
		//Guardar activos mensuales

		//Guardar reactivaciones
		$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["reactivaciones"] : 0;
		$dataIncorporacionesReactivaciones = array_merge($dataIncorporacionesReactivaciones, array($price));
		//Guardar reactivaciones

		//Guardar activos trimestrales
		$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["activosTrimestrales"] : 0;
		$dataIncorporacionesActivosTrimestrales = array_merge($dataIncorporacionesActivosTrimestrales, array($price));
		//Guardar activos trimestrales

		//Guardar incorporaciones
		$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["inscripcionesTotales"] : 0;
		$dataIncorporacionesIncorporaciones = array_merge($dataIncorporacionesIncorporaciones, array($price));
		//Guardar incorporaciones

		if($count < 24){
			//Guardar porcentaje incorporaciones con actividad trimestral
			$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["porcentajeIncorporacionesActividadTrimestral"] : 0;
			$dataIncorporacionesPorcentajeIncorporadosActividadTrimestral = array_merge($dataIncorporacionesPorcentajeIncorporadosActividadTrimestral, array($price));
			//Guardar porcentaje incorporaciones con actividad trimestral
		}

		//Guardar incorporaciones con actividad trimestral
		$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesActividadTrimestral"] : 0;
		$dataIncorporacionesIncorporadosActividadTrimestral = array_merge($dataIncorporacionesIncorporadosActividadTrimestral, array($price));
		//Guardar incorporaciones con actividad trimestral

	    //Cambiar a periodo siguiente
		$period->modify('+1 month');
		$period = $period->format('Y-m-01');
		$period = new DateTime($period);
		//Cambiar a periodo siguiente

		$count++;
	}
//Graficas

?>

<!-- Mostrar logo -->
<img src="https://mi.nikkenlatam.com/custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Informe Variables Comerciales por Socio Independiente</div>
			<div class="h6 mb-0"><span class="fw-bold">Periodo de Medición:</span> <?php echo $monthsYear[$periodotoShow] ?> a <?php echo $monthsYear[$periodopost] ?></div>
			<div class="h6"><span class="fw-bold">País:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Código:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold">Rango:</span> <?php echo $rankUser ?></div>
		</div>
	</div>
<!-- Cabecera -->

<div class="table-responsive">
	<table class="table align-middle table-bordered ">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"></th>
				<th scope="col"><span id="txtMont1"><?php echo $shortMonthYear[$monthToShow[24]] ?></span></th>
				<th scope="col"><span id="txtMont2"><?php echo $shortMonthYear[$monthToShow[23]] ?></span></th>
				<th scope="col"><span id="txtMont3"><?php echo $shortMonthYear[$monthToShow[22]] ?></span></th>
				<th scope="col"><span id="txtMont4"><?php echo $shortMonthYear[$monthToShow[21]] ?></span></th>
				<th scope="col"><span id="txtMont5"><?php echo $shortMonthYear[$monthToShow[20]] ?></span></th>
				<th scope="col"><span id="txtMont6"><?php echo $shortMonthYear[$monthToShow[19]] ?></span></th>
				<th scope="col"><span id="txtMont7"><?php echo $shortMonthYear[$monthToShow[18]] ?></span></th>
				<th scope="col"><span id="txtMont8"><?php echo $shortMonthYear[$monthToShow[17]] ?></span></th>
				<th scope="col"><span id="txtMont9"><?php echo $shortMonthYear[$monthToShow[16]] ?></span></th>
				<th scope="col"><span id="txtMont10"><?php echo $shortMonthYear[$monthToShow[15]] ?></span></th>
				<th scope="col"><span id="txtMont11"><?php echo $shortMonthYear[$monthToShow[14]] ?></span></th>
				<th scope="col"><span id="txtMont12"><?php echo $shortMonthYear[$monthToShow[13]] ?></span></th>
				<th scope="col"><span id="txtMont13"><?php echo $shortMonthYear[$monthToShow[12]] ?></span></th>
				<th scope="col"><span id="txtMont14"><?php echo $shortMonthYear[$monthToShow[11]] ?></span></th>
				<th scope="col"><span id="txtMont15"><?php echo $shortMonthYear[$monthToShow[10]] ?></span></th>
				<th scope="col"><span id="txtMont16"><?php echo $shortMonthYear[$monthToShow[9]] ?></span></th>
				<th scope="col"><span id="txtMont17"><?php echo $shortMonthYear[$monthToShow[8]] ?></span></th>
				<th scope="col"><span id="txtMont18"><?php echo $shortMonthYear[$monthToShow[7]] ?></span></th>
				<th scope="col"><span id="txtMont19"><?php echo $shortMonthYear[$monthToShow[6]] ?></span></th>
				<th scope="col"><span id="txtMont20"><?php echo $shortMonthYear[$monthToShow[5]] ?></span></th>
				<th scope="col"><span id="txtMont21"><?php echo $shortMonthYear[$monthToShow[4]] ?></span></th>
				<th scope="col"><span id="txtMont22"><?php echo $shortMonthYear[$monthToShow[3]] ?></span></th>
				<th scope="col"><span id="txtMont23"><?php echo $shortMonthYear[$monthToShow[2]] ?></span></th>
				<th scope="col"><span id="txtMont24"><?php echo $shortMonthYear[$monthToShow[1]] ?></span></th>
				<th scope="col" class="c-mw-2">Total 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- Incorporaciones ABIs Frontales -->
				<tr>
					<th scope="row">Incorporaciones ABIs Frontales</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["incorporacionesCisFrontales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[23]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[22]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[21]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[20]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[19]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[18]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[17]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[16]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[15]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[14]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[13]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[12]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[11]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[10]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[9]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[8]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[7]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[6]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[5]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[4]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[3]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[2]]["incorporacionesCisFrontales"];
						$total += $dataIncorporaciones[$monthToShow[1]]["incorporacionesCisFrontales"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones ABIs Frontales -->

			<!-- Incorporaciones CPs Frontales -->
				<tr>
					<th scope="row">Incorporaciones CPs Frontales</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["incorporacionesCpsFrontales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[23]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[22]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[21]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[20]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[19]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[18]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[17]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[16]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[15]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[14]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[13]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[12]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[11]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[10]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[9]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[8]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[7]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[6]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[5]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[4]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[3]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[2]]["incorporacionesCpsFrontales"];
						$total += $dataIncorporaciones[$monthToShow[1]]["incorporacionesCpsFrontales"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones CPs Frontales -->

			<!-- Incorporaciones ABIs Organización -->
				<tr>
					<th scope="row">Incorporaciones ABIs Organización</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["incorporacionesCisOrganizacion"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[23]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[22]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[21]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[20]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[19]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[18]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[17]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[16]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[15]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[14]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[13]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[12]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[11]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[10]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[9]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[8]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[7]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[6]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[5]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[4]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[3]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[2]]["incorporacionesCisOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[1]]["incorporacionesCisOrganizacion"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones ABIs Organización -->

			<!-- Incorporaciones CPs Organización -->
				<tr>
					<th scope="row">Incorporaciones CPs Organización</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["incorporacionesCpsOrganizacion"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[23]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[22]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[21]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[20]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[19]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[18]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[17]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[16]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[15]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[14]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[13]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[12]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[11]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[10]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[9]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[8]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[7]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[6]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[5]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[4]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[3]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[2]]["incorporacionesCpsOrganizacion"];
						$total += $dataIncorporaciones[$monthToShow[1]]["incorporacionesCpsOrganizacion"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones CPs Organización -->

			<!-- Incorporaciones Totales -->
				<tr>
					<th scope="row">Incorporaciones Totales</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones Totales -->

			<!-- Activos Mensuales ABIs -->
				<tr>
					<th scope="row">Activos Mensuales ABIs</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["activosMensualesCis"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[23]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[22]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[21]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[20]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[19]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[18]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[17]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[16]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[15]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[14]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[13]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[12]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[11]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[10]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[9]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[8]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[7]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[6]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[5]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[4]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[3]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[2]]["activosMensualesCis"];
						$total += $dataIncorporaciones[$monthToShow[1]]["activosMensualesCis"];

						echo number_format($total / 24, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Mensuales ABIs -->

			<!-- Activos Mensuales CPs -->
				<tr>
					<th scope="row">Activos Mensuales CPs</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["activosMensualesCps"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[23]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[22]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[21]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[20]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[19]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[18]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[17]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[16]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[15]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[14]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[13]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[12]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[11]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[10]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[9]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[8]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[7]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[6]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[5]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[4]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[3]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[2]]["activosMensualesCps"];
						$total += $dataIncorporaciones[$monthToShow[1]]["activosMensualesCps"];

						echo number_format($total / 24, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Mensuales CPs -->

			<!-- Activos Mensuales (ABIs + CPs) -->
				<tr>
					<th scope="row">Activos Mensuales (ABIs + CPs)</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["totalActivosMensuales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[23]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[22]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[21]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[20]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[19]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[18]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[17]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[16]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[15]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[14]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[13]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[12]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[11]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[10]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[9]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[8]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[7]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[6]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[5]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[4]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[3]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[2]]["totalActivosMensuales"];
						$total += $dataIncorporaciones[$monthToShow[1]]["totalActivosMensuales"];

						echo number_format($total / 24, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Mensuales (ABIs + CPs) -->

			<!-- Activos Trimestrales -->
				<tr>
					<th scope="row">Activos Trimestrales (ABIs + CPs)</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["activosTrimestrales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[23]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[22]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[21]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[20]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[19]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[18]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[17]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[16]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[15]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[14]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[13]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[12]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[11]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[10]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[9]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[8]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[7]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[6]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[5]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[4]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[3]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[2]]["activosTrimestrales"];
						$total += $dataIncorporaciones[$monthToShow[1]]["activosTrimestrales"];

						echo number_format($total / 24, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Trimestrales -->

			<!-- Reactivaciones -->
				<tr>
					<th scope="row">Reactivaciones (ABIs + CPs)</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["reactivaciones"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[23]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[22]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[21]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[20]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[19]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[18]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[17]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[16]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[15]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[14]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[13]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[12]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[11]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[10]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[9]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[8]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[7]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[6]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[5]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[4]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[3]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[2]]["reactivaciones"];
						$total += $dataIncorporaciones[$monthToShow[1]]["reactivaciones"];

						echo number_format($total / 24, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Reactivaciones -->

			<!-- Otras Variables -->
				<tr>
					<td colspan="3"><strong>Crecimiento de la Incorporación <br/>Personal de los Últimos 12 Meses %</strong></td>
					<td colspan="3" class="text-center">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
							$period = new DateTime("$periodoIni");
							//Periodo inicial de consulta

							while($count < 12){
								$periodQuery = $period->format('Ym');

								//Guardar total
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesCisFrontales"] : 0;
								$totalPrevious = $totalPrevious + $price;
								//Guardar total

							    //Cambiar a periodo siguiente
								$period->modify('+1 month');
								$period = $period->format('Y-m-01');
								$period = new DateTime($period);
								//Cambiar a periodo siguiente

								$count++;
							}

							$totalNext = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
							$periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
							$period = new DateTime("$periodoIni");
							//Periodo inicial de consulta

							while($count < 12){
								$periodQuery = $period->format('Ym');

								//Guardar total
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesCisFrontales"] : 0;
								$totalNext = $totalNext + $price;
								//Guardar total

							    //Cambiar a periodo siguiente
								$period->modify('+1 month');
								$period = $period->format('Y-m-01');
								$period = new DateTime($period);
								//Cambiar a periodo siguiente

								$count++;
							}

							if($totalNext == 0 || $totalPrevious == 0){ echo "0%";
							}else{ echo number_format(($totalNext / ($totalPrevious) - 1) * 100, 2) . "%"; }

							?>
						</strong>
					</td>

					<td colspan="4"></td>
					<td colspan="4"><strong>Crecimiento de Incorporaciones<br/>por Activo %</strong></td>
					<td colspan="4" class="text-center">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
							$period = new DateTime("$periodoIni");
							//Periodo inicial de consulta

							while($count < 12){
								$periodQuery = $period->format('Ym');

								//Guardar total
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["inscripcionesActivo"] : 0;
								$totalPrevious = $totalPrevious + $price;
								//Guardar total

							    //Cambiar a periodo siguiente
								$period->modify('+1 month');
								$period = $period->format('Y-m-01');
								$period = new DateTime($period);
								//Cambiar a periodo siguiente

								$count++;
								// echo "price: $price | totalPrevious: $totalPrevious <br>";
							}

							$totalNext = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
							$periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
							$period = new DateTime("$periodoIni");
							//Periodo inicial de consulta

							while($count < 12){
								$periodQuery = $period->format('Ym');

								//Guardar total
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["inscripcionesActivo"] : 0;
								$totalNext = $totalNext + $price;
								//Guardar total

							    //Cambiar a periodo siguiente
								$period->modify('+1 month');
								$period = $period->format('Y-m-01');
								$period = new DateTime($period);
								//Cambiar a periodo siguiente

								$count++;
								// echo "price: $price | totalNext: $totalNext <br>";
							}

							if($totalNext == 0 || $totalPrevious == 0){ echo "0%";
							}else{ echo number_format(($totalNext / ($totalPrevious) - 1) * 100, 2) . "%"; }

							?>
						</strong>
					</td>

					<td colspan="2"></td>
					<td colspan="4"><strong>Incorporaciones Personales<br/>del Último Año</strong></td>
					<td colspan="4" class="text-center">
						<strong>
							<?php

								$totalPrevious = 0;
								$count = 0;

								//Periodo inicial de consulta
								$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
								$period = new DateTime("$periodoIni");
								//Periodo inicial de consulta

								while($count < 12){
									$periodQuery = $period->format('Ym');

									//Guardar total
									$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesCisFrontales"] : 0;
									$totalPrevious = $totalPrevious + $price;
									//Guardar total

									//Cambiar a periodo siguiente
									$period->modify('+1 month');
									$period = $period->format('Y-m-01');
									$period = new DateTime($period);
									//Cambiar a periodo siguiente

									$count++;
								}

								$totalNext = 0;
								$count = 0;

								//Periodo inicial de consulta
								$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
								$periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
								$period = new DateTime("$periodoIni");
								//Periodo inicial de consulta

								while($count < 12){
									$periodQuery = $period->format('Ym');

									//Guardar total
									$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesCisFrontales"] : 0;
									$totalNext = $totalNext + $price;
									//Guardar total

									//Cambiar a periodo siguiente
									$period->modify('+1 month');
									$period = $period->format('Y-m-01');
									$period = new DateTime($period);
									//Cambiar a periodo siguiente

									$count++;
								}

								if($totalNext == 0 || $totalPrevious == 0){
									echo "0%";
								}
								else{
									//echo number_format(($totalNext / ($totalPrevious) - 1) * 100, 2) . "%";
									// echo number_format($totalPrevious);
								}

								$grantotal = 0;
								$datosArray = $dataIncorporaciones;
								foreach (array_slice($datosArray, 0, 12) as $datos) {
									// Verificar si la clave "incorporacionesCisFrontales" existe en la posición actual
									if (isset($datos['incorporacionesCisFrontales'])) {
										// Sumar el valor de "incorporacionesCisFrontales" al acumulador
										$grantotal += $datos['incorporacionesCisFrontales'];
									}
								}
								echo $grantotal;

							?>
						</strong>
					</td>
				</tr>

				<tr>
					<td colspan="3"><strong>Crecimiento de la Incorporación de la<br/>Organización de los Últimos 12 Meses %</strong></td>
					<td colspan="3" class="text-center">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
							$period = new DateTime("$periodoIni");
							//Periodo inicial de consulta

							while($count < 12){
								$periodQuery = $period->format('Ym');

								//Guardar total
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesCisOrganizacion"] : 0;
								$totalPrevious = $totalPrevious + $price;
								//Guardar total

							    //Cambiar a periodo siguiente
								$period->modify('+1 month');
								$period = $period->format('Y-m-01');
								$period = new DateTime($period);
								//Cambiar a periodo siguiente

								$count++;
							}

							$totalNext = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
							$periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
							$period = new DateTime("$periodoIni");
							//Periodo inicial de consulta

							while($count < 12){
								$periodQuery = $period->format('Ym');

								//Guardar total
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesCisOrganizacion"] : 0;
								$totalNext = $totalNext + $price;
								//Guardar total

							    //Cambiar a periodo siguiente
								$period->modify('+1 month');
								$period = $period->format('Y-m-01');
								$period = new DateTime($period);
								//Cambiar a periodo siguiente

								$count++;
							}

							if($totalNext == 0 || $totalPrevious == 0){ echo "0%";
							}else{ echo number_format(($totalNext / ($totalPrevious) - 1) * 100, 2) . "%"; }

							?>
						</strong>
					</td>

					<td colspan="14"></td>
					<td colspan="4"><strong>Incorporaciones de la Organización<br/>en el Último Año</strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

								$totalPrevious = 0;
								$count = 0;

								//Periodo inicial de consulta
								$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
								$periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
								$period = new DateTime("$periodoIni");
								//Periodo inicial de consulta

								while($count < 12){
									$periodQuery = $period->format('Ym');

									//Guardar total
									$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["incorporacionesCisOrganizacion"] : 0;
									$totalPrevious = $totalPrevious + $price;
									//Guardar total

								    //Cambiar a periodo siguiente
									$period->modify('+1 month');
									$period = $period->format('Y-m-01');
									$period = new DateTime($period);
									//Cambiar a periodo siguiente

									$count++;
								}

								// echo number_format($totalPrevious, 0);

								$grantotal = 0;
								$datosArray = $dataIncorporaciones;
								foreach (array_slice($datosArray, 0, 12) as $datos) {
									// Verificar si la clave "incorporacionesCisOrganizacion" existe en la posición actual
									if (isset($datos['incorporacionesCisOrganizacion'])) {
										// Sumar el valor de "incorporacionesCisOrganizacion" al acumulador
										$grantotal += $datos['incorporacionesCisOrganizacion'];
									}
								}
								foreach (array_slice($datosArray, 0, 12) as $datos) {
									// Verificar si la clave "incorporacionesCpsOrganizacion" existe en la posición actual
									if (isset($datos['incorporacionesCpsOrganizacion'])) {
										// Sumar el valor de "incorporacionesCpsOrganizacion" al acumulador
										$grantotal += $datos['incorporacionesCpsOrganizacion'];
									} 
								}
								echo number_format($grantotal, 0);

								// $granTotalLastYear = 0;
								
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"];
								// $granTotalLastYear += $dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"];

								// echo number_format($granTotalLastYear, 0);
							?>
						</strong>
					</td>
				</tr>
			<!-- Otras Variables -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Comportamiento de Compras e Incorporaciones -->
			<canvas id="chart2Graph1" class="w-100" height="510"></canvas>
			<!-- Gráfica Comportamiento de Compras e Incorporaciones -->
		</div>

		<div class="col text-center">
			<!-- Gráfica Comportamiento y Calidad de las Incorporaciones -->
			<canvas id="chart2Graph2" class="w-100" height="510"></canvas>
			<!-- Gráfica Comportamiento y Calidad de las Incorporaciones -->
		</div>
	</div>
<!-- Gráficas -->

<div class="table-responsive mt-4">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[24]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[23]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[22]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[21]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[20]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[19]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[18]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[17]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[16]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[15]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[14]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[13]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[12]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[11]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[10]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[9]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[8]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[7]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[6]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[5]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[4]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[3]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[2]] ?></th>
				<th scope="col"><?php echo $shortMonthYear[$monthToShow[1]] ?></th>
				<th scope="col" class="c-mw-2">Total 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- Incorporaciones Totales -->
				<tr>
					<th scope="row">Incorporaciones Totales</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"];
						$total += $dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones Totales -->

			<!-- Incorporaciones con Actividad Trimestral -->
				<tr>
					<th scope="row">Incorporaciones con Actividad<br/>Trimestral</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["incorporacionesActividadTrimestral"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[23]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[22]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[21]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[20]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[19]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[18]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[17]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[16]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[15]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[14]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[13]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[12]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[11]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[10]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[9]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[8]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[7]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[6]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[5]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[4]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[3]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[2]]["incorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[1]]["incorporacionesActividadTrimestral"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones con Actividad Trimestral -->

			<!-- % Incorporados con Actividad Trimestral -->
				<tr>
					<th scope="row">% Incorporados con Actividad<br/>Trimestral</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["porcentajeIncorporacionesActividadTrimestral"], 2) : 0 ?>%</td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[24]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[23]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[22]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[21]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[20]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[19]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[18]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[17]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[16]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[15]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[14]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[13]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[12]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[11]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[10]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[9]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[8]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[7]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[6]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[5]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[4]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[3]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[2]]["porcentajeIncorporacionesActividadTrimestral"];
						$total += $dataIncorporaciones[$monthToShow[1]]["porcentajeIncorporacionesActividadTrimestral"];

						echo number_format($total / 24, 2) . "%";

						?>
					</td>
				</tr>
			<!-- % Incorporados con Actividad Trimestral -->
		</tbody>
	</table>
</div>

<!-- Notas -->
<div class="fw-bold mt-2 mb-4" style="color: red;">* Lo que se encuentra con asterisco (*) su cálculo es promedio.</div>
<!-- Notas -->

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica

	txtMont1 = $("#txtMont1").text();
	txtMont2 = $("#txtMont2").text();
	txtMont3 = $("#txtMont3").text();
	txtMont4 = $("#txtMont4").text();
	txtMont5 = $("#txtMont5").text();
	txtMont6 = $("#txtMont6").text();
	txtMont7 = $("#txtMont7").text();
	txtMont8 = $("#txtMont8").text();
	txtMont9 = $("#txtMont9").text();
	txtMont10 = $("#txtMont10").text();
	txtMont11 = $("#txtMont11").text();
	txtMont12 = $("#txtMont12").text();
	txtMont13 = $("#txtMont13").text();
	txtMont14 = $("#txtMont14").text();
	txtMont15 = $("#txtMont15").text();
	txtMont16 = $("#txtMont16").text();
	txtMont17 = $("#txtMont17").text();
	txtMont18 = $("#txtMont18").text();
	txtMont19 = $("#txtMont19").text();
	txtMont20 = $("#txtMont20").text();
	txtMont21 = $("#txtMont21").text();
	txtMont22 = $("#txtMont22").text();
	txtMont23 = $("#txtMont23").text();
	txtMont24 = $("#txtMont24").text();

	//Gráfica Comportamiento de Compras e Incorporaciones
		var chart2Graph1 = document.getElementById('chart2Graph1').getContext('2d');
		var chart2Graph1Detail = new Chart(chart2Graph1, {
		    type: 'line',
		    data: {
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: 'Activos Mensuales',
			            data: <?php echo json_encode($dataIncorporacionesActivosMensuales) ?>,
			            backgroundColor: [ 'rgba(220, 123, 79, 1)', ],
			            borderColor: [ 'rgba(220, 123, 79, 1)', ],
			        },
			        {
			            label: 'Reactivaciones',
			            data: <?php echo json_encode($dataIncorporacionesReactivaciones) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: 'Activos Trimestrales',
			            data: <?php echo json_encode($dataIncorporacionesActivosTrimestrales) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        },
			        {
			            label: 'Incorporaciones',
			            data: <?php echo json_encode($dataIncorporacionesIncorporaciones) ?>,
			            backgroundColor: [ 'rgba(241, 185, 42, 1)', ],
			            borderColor: [ 'rgba(241, 185, 42, 1)', ],
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
						beginAtZero: true
			      	}
			    }
			},
		});
	//Gráfica Comportamiento de Compras e Incorporaciones

	//Gráfica Comportamiento y Calidad de las Incorporaciones
		var chart2Graph2 = document.getElementById('chart2Graph2').getContext('2d');
		var chart2Graph2Detail = new Chart(chart2Graph2, {
		    type: 'bar',
		    data: {
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
		        	{
			            label: '% Incorporados con Actividad Trimestral',
			            data: <?php echo json_encode($dataIncorporacionesPorcentajeIncorporadosActividadTrimestral) ?>,
			            backgroundColor: [ 'rgba(0, 0, 0, 1)', ],
			            borderColor: [ 'rgba(0, 0, 0, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			        },
			        {
			            label: 'Incorporaciones',
			            data: <?php echo json_encode($dataIncorporacionesIncorporaciones) ?>,
			            backgroundColor: [ 'rgba(241, 185, 42, 1)', ],
			            borderColor: [ 'rgba(241, 185, 42, 1)', ],
	      				yAxisID: 'y',
			        },
			        {
			            label: 'Incorporados con Actividad Trimestral',
			            data: <?php echo json_encode($dataIncorporacionesIncorporadosActividadTrimestral) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
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
	//Gráfica Comportamiento y Calidad de las Incorporaciones

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>
