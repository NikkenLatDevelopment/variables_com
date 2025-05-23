<?php require_once("../../functions.php"); //Funciones

//Conexión 75
// $serverName75 = "104.130.46.73";
$serverName75 = "172.24.16.75";
$connectionInfo75 = array("Database" => "LAT_MyNIKKEN_TEST", "UID" => "Latamti", "PWD" => "N1k3N$17!");
$conn75 = sqlsrv_connect($serverName75, $connectionInfo75);
if(!$conn75){ die(print_r(sqlsrv_errors(), true)); }

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = letterCountrie($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodopost = $_POST["periodo"];
$lang = $_POST["lang"];
// $periodopost = 202310;
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
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_usa $codeUser, $periodopost";
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
	$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
	$period = new DateTime("$periodoIni");
	//Periodo inicial de consulta

	while($count < 12){
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

		if($count < 12){
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
<img src="src/img/logo-black.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1"><?php echo $laguaje[$lang]['Variables de negocio Informe del consultor']; ?></div>
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Periodo de medición']; ?>:</span> <?php echo getMontPeriodPast($periodopost) . " " . $laguaje[$lang]['a'] .  " " .getMontPeriod($periodopost); ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['País']; ?>:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Código']; ?>:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['Rango']; ?>:</span> <?php echo $rangos_usa[$rankUser] ?></div>
		</div>
	</div>
<!-- Cabecera -->

<div class="table-responsive">
	<table class="table align-middle table-bordered ">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"></th>
				<th scope="col"><span id="txtMont13"><?php echo getMontPeriodShortLang($monthToShow[12], $lang) ?></span></th>
				<th scope="col"><span id="txtMont14"><?php echo getMontPeriodShortLang($monthToShow[11], $lang) ?></span></th>
				<th scope="col"><span id="txtMont15"><?php echo getMontPeriodShortLang($monthToShow[10], $lang) ?></span></th>
				<th scope="col"><span id="txtMont16"><?php echo getMontPeriodShortLang($monthToShow[9], $lang) ?></span></th>
				<th scope="col"><span id="txtMont17"><?php echo getMontPeriodShortLang($monthToShow[8], $lang) ?></span></th>
				<th scope="col"><span id="txtMont18"><?php echo getMontPeriodShortLang($monthToShow[7], $lang) ?></span></th>
				<th scope="col"><span id="txtMont19"><?php echo getMontPeriodShortLang($monthToShow[6], $lang) ?></span></th>
				<th scope="col"><span id="txtMont20"><?php echo getMontPeriodShortLang($monthToShow[5], $lang) ?></span></th>
				<th scope="col"><span id="txtMont21"><?php echo getMontPeriodShortLang($monthToShow[4], $lang) ?></span></th>
				<th scope="col"><span id="txtMont22"><?php echo getMontPeriodShortLang($monthToShow[3], $lang) ?></span></th>
				<th scope="col"><span id="txtMont23"><?php echo getMontPeriodShortLang($monthToShow[2], $lang) ?></span></th>
				<th scope="col"><span id="txtMont24"><?php echo getMontPeriodShortLang($monthToShow[1], $lang) ?></span></th>
				<th scope="col" class="c-mw-2"><?php echo $laguaje[$lang]['Total 12 Months']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Incorporaciones ABIs Frontales -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Inscripciones de Consultores Frontales']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Inscripciones de Clientes Frontales']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Inscripciones de consultores de organizaciones']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Inscripciones de clientes de la organización']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Total de inscripciones']; ?> </th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Consultores activos mensualmente']; ?></th>
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

						echo number_format($total / 12, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Mensuales ABIs -->

			<!-- Activos Mensuales CPs -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Clientes activos mensuales']; ?></th>
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

						echo number_format($total / 12, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Mensuales CPs -->

			<!-- Activos Mensuales (ABIs + CPs) -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Activos mensuales (consultores y clientes)']; ?></th>
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

						echo number_format($total / 12, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Mensuales (ABIs + CPs) -->

			<!-- Activos Trimestrales -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Activos Trimestrales (Consultores y Clientes)']; ?></th>
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

						echo number_format($total / 12, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Activos Trimestrales -->

			<!-- Reactivaciones -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Reactivaciones (Consultores y Clientes)']; ?></th>
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

						echo number_format($total / 12, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Reactivaciones -->

			<!-- Otras Variables -->
				<tr>
					<td ><strong><?php echo $laguaje[$lang]['Últimos 12 meses Crecimiento de registros personales %']; ?></strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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

					<td colspan="4"><strong><?php echo $laguaje[$lang]['Contratación por Activo crecimiento %']; ?></strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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

					<td></td>
					<td colspan="3"><strong><?php echo $laguaje[$lang]['Inscripciones personal Últimos 12 meses']; ?></strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

								$totalPrevious = 0;
								$count = 0;

								//Periodo inicial de consulta
								$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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
								$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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
									// echo "0%";
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
					<td><strong><?php echo $laguaje[$lang]['Inscripciones personal Últimos 12 meses %']; ?></strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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

					<td colspan="6"></td>
					<td colspan="4"><strong><?php echo $laguaje[$lang]['Inscripciones de organización Últimos 12 meses']; ?></strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

								$totalPrevious = 0;
								$count = 0;

								//Periodo inicial de consulta
								$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
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
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[12], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[11], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[10], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[9], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[8], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[7], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[6], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[5], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[4], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[3], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[2], $lang) ?></th>
				<th scope="col"><?php echo getMontPeriodShortLang($monthToShow[1], $lang) ?></th>
				<th scope="col" class="c-mw-2"><?php echo $laguaje[$lang]['Total 12 Months']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Incorporaciones Totales -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Total de inscripciones']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Inscripciones con actividad trimestral']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['% Sign ups with quarterly activity']; ?></th>
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

						echo number_format($total / 12, 2) . "%";

						?>
					</td>
				</tr>
			<!-- % Incorporados con Actividad Trimestral -->
		</tbody>
	</table>
</div>

<!-- Notas -->
<div class="fw-bold mt-2 mb-4" style="color: red;">* <?php echo $laguaje[$lang]['is calculated Average']; ?></div>
<!-- Notas -->

<?php
	$graphTexts = [
		'es' => [
			'Monthly Active' => "Activos Mensuales",
			'Reactivations' => "Reactivaciones",
			'Quarterly Active' => "Activos Trimestrales",
			'Sign Ups' => "Incorporaciones",
			'Purchasing Behaviour and Sign ups' =>	"Comportamiento de Compras e Incorporaciones",
			'No. of People' => "No. de Personas",
			'% Sign ups with quarterly activity' => "% de Incorporaciones con Actividad Trimestral",
			'Sign ups with quarterly activity' => "Incorporaciones con Actividad Trimestral",
			'Purchasing Behaviour vs Sign ups' => "Comportamiento de Compras vs Incorporaciones",
			'No. of Sign ups' => "No. de Incorporaciones",
		],
		'en' => [
			'Monthly Active' => "Monthly Active",
			'Reactivations' => "Reactivations",
			'Quarterly Active' => "Quarterly Active",
			'Sign Ups' => "Sign Ups",
			'Purchasing Behaviour and Sign ups' => "Purchasing Behaviour and Sign ups",
			'No. of People' => "No. of People",
			'% Sign ups with quarterly activity' => "% Sign ups with quarterly activity",
			'Sign ups with quarterly activity' => "Sign ups with quarterly activity",
			'Purchasing Behaviour vs Sign ups' => "Purchasing Behaviour vs Sign ups",
			'No. of Sign ups' => "No. of Sign ups",
		],
		'fr' => [
			'Monthly Active' => "Actifs Mensuels",
			'Reactivations' => "Réactivations",
			'Quarterly Active' => "Actifs Trimestriels",
			'Sign Ups' => "Incorporations",
			'Purchasing Behaviour and Sign ups' => "Comportement d'Achat et Inscription",
			'No. of People' => "No. de personnes",
			'% Sign ups with quarterly activity' => "% d'Inscriptions avec Activité Trimestrielle",
			'Sign ups with quarterly activity' => "Inscriptions avec Activité Trimestrielle",
			'Purchasing Behaviour vs Sign ups' => "Comportement d'Achat vs Inscriptions",
			'No. of Sign ups' => "No. d'Inscriptions",
		],
	];
?>

<input type="hidden" id="Monthly_Active" value="<?php echo $graphTexts[$lang]['Monthly Active'];?>">
<input type="hidden" id="Reactivations" value="<?php echo $graphTexts[$lang]['Reactivations'];?>">
<input type="hidden" id="Quarterly_Active" value="<?php echo $graphTexts[$lang]['Quarterly Active'];?>">
<input type="hidden" id="Sign_Ups" value="<?php echo $graphTexts[$lang]['Sign Ups'];?>">
<input type="hidden" id="Purchasing_Behaviour_and_Sign_ups" value="<?php echo $graphTexts[$lang]['Purchasing Behaviour and Sign ups'];?>">
<input type="hidden" id="No_of_People" value="<?php echo $graphTexts[$lang]['No. of People'];?>">
<input type="hidden" id="_Sign_ups_with_quarterly_activity" value="<?php echo $graphTexts[$lang]['% Sign ups with quarterly activity'];?>">
<input type="hidden" id="Sign_ups_with_quarterly_activity" value="<?php echo $graphTexts[$lang]['Sign ups with quarterly activity'];?>">
<input type="hidden" id="Purchasing_Behaviour_vs_Sign_ups" value="<?php echo $graphTexts[$lang]['Purchasing Behaviour vs Sign ups'];?>">
<input type="hidden" id="No_of_Sign_ups" value="<?php echo $graphTexts[$lang]['No. of Sign ups'];?>">

<script>
	var Monthly_Active = $("#Monthly_Active").val();
	var Reactivations = $("#Reactivations").val();
	var Quarterly_Active = $("#Quarterly_Active").val();
	var Sign_Ups = $("#Sign_Ups").val();
	var Purchasing_Behaviour_and_Sign_ups = $("#Purchasing_Behaviour_and_Sign_ups").val();
	var No_of_People = $("#No_of_People").val();
	var _Sign_ups_with_quarterly_activity = $("#_Sign_ups_with_quarterly_activity").val();
	var Sign_ups_with_quarterly_activity = $("#Sign_ups_with_quarterly_activity").val();
	var Purchasing_Behaviour_vs_Sign_ups = $("#Purchasing_Behaviour_vs_Sign_ups").val();
	var No_of_Sign_ups = $("#No_of_Sign_ups").val();

	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica

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
		        labels: [txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: Monthly_Active,
			            data: <?php echo json_encode($dataIncorporacionesActivosMensuales) ?>,
			            backgroundColor: [ 'rgba(220, 123, 79, 1)', ],
			            borderColor: [ 'rgba(220, 123, 79, 1)', ],
			        },
			        {
			            label: Reactivations,
			            data: <?php echo json_encode($dataIncorporacionesReactivaciones) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: Quarterly_Active,
			            data: <?php echo json_encode($dataIncorporacionesActivosTrimestrales) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        },
			        {
			            label: Sign_Ups,
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
						text: Purchasing_Behaviour_and_Sign_ups
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: No_of_People
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
		        labels: [txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
		        	{
			            label: _Sign_ups_with_quarterly_activity,
			            data: <?php echo json_encode($dataIncorporacionesPorcentajeIncorporadosActividadTrimestral) ?>,
			            backgroundColor: [ 'rgba(0, 0, 0, 1)', ],
			            borderColor: [ 'rgba(0, 0, 0, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			        },
			        {
			            label: Sign_Ups,
			            data: <?php echo json_encode($dataIncorporacionesIncorporaciones) ?>,
			            backgroundColor: [ 'rgba(241, 185, 42, 1)', ],
			            borderColor: [ 'rgba(241, 185, 42, 1)', ],
	      				yAxisID: 'y',
			        },
			        {
			            label: Sign_ups_with_quarterly_activity,
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
						text: Purchasing_Behaviour_vs_Sign_ups
					},
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
						title: {
				          	display: true,
				          	text: No_of_Sign_ups
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
