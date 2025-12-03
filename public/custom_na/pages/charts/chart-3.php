<?php require_once("../../functions.php"); //Funciones

//Conexión 75
$serverName75 = "104.130.46.73";
// $serverName75 = "172.24.16.75";
$connectionInfo75 = array("Database" => "LAT_MyNIKKEN_TEST", "UID" => "Latamti", "PWD" => 'L8$aQ7mZ!pR42^Tx');
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
$dataIncorporacionestable2 = array();
$dataIncorporacionesActivo = array();
$dataBonificaciones = array();
$dataBonificacionesPersonales = array();
$dataBonificacionesOrganizacion = array();
//Others

//Consulta
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_usa $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$monthToShow = [];
	$x = 0;
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$inscripcionesActivo = trim($rowSap[13]);
		$periodo = trim($rowSap[14]);

		$periodotoShow = trim($rowSap[14]);
		$x++;
		$monthToShow[$x] = $rowSap[14];

		//Guardar datos en array
		$dataIncorporaciones[$periodo] = array("inscripcionesActivo" => $inscripcionesActivo);
		//Guardar datos en array
	}

	// $sql = "EXEC Bonificaciones_SD_usa $codeUser, $periodopost";
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.varCom_bonificaciones_usa $codeUser, '$periodopost'";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$periodo = trim($rowSap[11]);
		$rangoPago = trim($rowSap[1]);
		$rangoActual = trim($rowSap[2]);
		$retail = trim($rowSap[3]);
		// $rebate = trim($rowSap[4]);
		// $overide = trim($rowSap[5]);
		$leadership = trim($rowSap[4]);
		$club = trim($rowSap[5]);
		$ahlsb = trim($rowSap[6]);
		// $pi = trim($rowSap[9]);
		$suma = trim($rowSap[7]);
		$bonificacionesOrganizacion = 0; //Pendiente

		$personal = trim($rowSap[3]);
		$leadership_bonus = trim($rowSap[4]);
		$retail_bonus = trim($rowSap[5]);
		$pib_bonus = trim($rowSap[6]);
		$we_acelerate_bonus = trim($rowSap[7]);
		$lifestyle_bonus = trim($rowSap[8]);
		$suma = trim($rowSap[9]);

		$dataIncorporacionestable2[$periodo] = array(
			"rangoPago" => $rangoPago, 
			"rangoActual" => $rangoActual, 
			"personal" => $personal,
			"leadership_bonus" => $leadership_bonus,
			"retail_bonus" => $retail_bonus,
			"pib_bonus" => $pib_bonus,
			"we_acelerate_bonus" => $we_acelerate_bonus,
			"lifestyle_bonus" => $lifestyle_bonus,
			"suma" => $suma
		);

		//Guardar datos en array
		// $dataIncorporacionestable2[$periodo] = array(
		// 	"rangoPago" => $rangoPago, 
		// 	"rangoActual" => $rangoActual, 
		// 	"retail" => $retail, 
		// 	// "rebate" => $rebate, 
		// 	// "overide" => $overide, 
		// 	"leadership" => $leadership, 
		// 	"club" => $club, 
		// 	"ahlsb" => $ahlsb, 
		// 	// "pi" => $pi, 
		// 	"suma" => $suma, 
		// 	"bonificacionesOrganizacion" => $bonificacionesOrganizacion
		// );
		//Guardar datos en array
	}

	// echo '<pre>'; print_r($dataIncorporacionestable2); echo '</pre>';

	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Bonificaciones_SD_ORG_usa $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$periodo = trim($rowSap[8]);
		$suma = trim($rowSap[7]);

		//Guardar datos en array
		$dataBonificaciones[$periodo]["bonificacionesOrganizacion"] = $suma;
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

		//Guardar incorporaciones activo
		$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["inscripcionesActivo"] : 0;
		$dataIncorporacionesActivo = array_merge($dataIncorporacionesActivo, array($price));
		//Guardar incorporaciones activo

		//Guardar bonificaciones personales
		$price = isset($dataIncorporacionestable2[$periodQuery]) ? @$dataIncorporacionestable2[$periodQuery]["suma"] : 0;
		$dataBonificacionesPersonales = array_merge($dataBonificacionesPersonales, array($price));
		//Guardar bonificaciones personales

		//Guardar bonificaciones organización
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["bonificacionesOrganizacion"] : 0;
		$dataBonificacionesOrganizacion = array_merge($dataBonificacionesOrganizacion, array($price));
		//Guardar bonificaciones organización

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
<hr>
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
	<table class="table align-middle table-bordered">
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
				<th scope="col" class="c-mw-2"><?php echo $laguaje[$lang]['Media 12 meses']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Incorporaciones por Activo -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Sign Ups by actives']; ?></th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporaciones[$monthToShow[12]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[11]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[10]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[9]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[8]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[7]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[6]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[5]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[4]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[3]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[2]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[1]]["inscripcionesActivo"];

						echo number_format($total / 12, 2);

						?>
					</td>
				</tr>
			<!-- Incorporaciones por Activo -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Incorporaciones por Activo -->
			<canvas id="chart3Graph1" class="w-100" height="430"></canvas>
			<!-- Gráfica Incorporaciones por Activo -->
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
			<!-- Bonificaciones Personales -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Cheque personal mensual (descuentos no incluidos)']; ?></th>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[12]]) ? @number_format($dataIncorporacionestable2[$monthToShow[12]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[11]]) ? @number_format($dataIncorporacionestable2[$monthToShow[11]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[10]]) ? @number_format($dataIncorporacionestable2[$monthToShow[10]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[9]]) ? @number_format($dataIncorporacionestable2[$monthToShow[9]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[8]]) ? @number_format($dataIncorporacionestable2[$monthToShow[8]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[7]]) ? @number_format($dataIncorporacionestable2[$monthToShow[7]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[6]]) ? @number_format($dataIncorporacionestable2[$monthToShow[6]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[5]]) ? @number_format($dataIncorporacionestable2[$monthToShow[5]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[4]]) ? @number_format($dataIncorporacionestable2[$monthToShow[4]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[3]]) ? @number_format($dataIncorporacionestable2[$monthToShow[3]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[2]]) ? @number_format($dataIncorporacionestable2[$monthToShow[2]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[1]]) ? @number_format($dataIncorporacionestable2[$monthToShow[1]]["suma"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataIncorporacionestable2[$monthToShow[12]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[11]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[10]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[9]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[8]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[7]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[6]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[5]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[4]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[3]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[2]]["suma"];
						$total += $dataIncorporacionestable2[$monthToShow[1]]["suma"];

						echo @number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Bonificaciones Personales -->

			<!-- Bonificaciones de la Organización -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Comisiones pagadas a la organización (USD)']; ?></th>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[12]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[12]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[11]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[11]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[10]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[10]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[9]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[9]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[8]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[8]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[7]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[7]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[6]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[6]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[5]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[5]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[4]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[4]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[3]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[3]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[2]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[2]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[1]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[1]]["bonificacionesOrganizacion"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += ($dataBonificaciones[$monthToShow[12]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[12]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[11]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[11]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[10]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[10]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[9]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[9]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[8]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[8]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[7]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[7]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[6]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[6]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[5]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[5]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[4]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[4]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[3]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[3]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[2]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[2]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[1]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[1]]["bonificacionesOrganizacion"] : 0;

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Bonificaciones de la Organización -->
		</tbody>
	</table>
	<?php
		if(trim($countrieUser) == 'Colombia'){?>
			<p style="color: red !important;">* <?php echo $laguaje[$lang]['Se contemplan todas las ventas ha sugerido en el cálculo del retail']; ?>.</p>
		<?php }
	?>
</div>

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Bonificaciones -->
			<canvas id="chart3Graph2" class="w-100" height="430"></canvas>
			<!-- Gráfica Bonificaciones -->
		</div>
	</div>
<!-- Gráficas -->
<div class="table-responsive mt-2">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"><?php echo $laguaje[$lang]['Rango de pago']; ?></th>
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
			</tr>
		</thead>

		<tbody>
			<!-- Rango Pagado -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Rango de Pago']; ?></th>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[12]]) ? $dataIncorporacionestable2[$monthToShow[12]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[11]]) ? $dataIncorporacionestable2[$monthToShow[11]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[10]]) ? $dataIncorporacionestable2[$monthToShow[10]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[9]]) ? $dataIncorporacionestable2[$monthToShow[9]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[8]]) ? $dataIncorporacionestable2[$monthToShow[8]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[7]]) ? $dataIncorporacionestable2[$monthToShow[7]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[6]]) ? $dataIncorporacionestable2[$monthToShow[6]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[5]]) ? $dataIncorporacionestable2[$monthToShow[5]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[4]]) ? $dataIncorporacionestable2[$monthToShow[4]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[3]]) ? $dataIncorporacionestable2[$monthToShow[3]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[2]]) ? $dataIncorporacionestable2[$monthToShow[2]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[1]]) ? $dataIncorporacionestable2[$monthToShow[1]]["rangoPago"] : "-" ?></td>
				</tr>
			<!-- Rango Pagado -->

			<!-- Rango Final -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Rango PIN']; ?></th>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[12]]) ? $dataIncorporacionestable2[$monthToShow[12]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[11]]) ? $dataIncorporacionestable2[$monthToShow[11]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[10]]) ? $dataIncorporacionestable2[$monthToShow[10]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[9]]) ? $dataIncorporacionestable2[$monthToShow[9]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[8]]) ? $dataIncorporacionestable2[$monthToShow[8]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[7]]) ? $dataIncorporacionestable2[$monthToShow[7]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[6]]) ? $dataIncorporacionestable2[$monthToShow[6]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[5]]) ? $dataIncorporacionestable2[$monthToShow[5]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[4]]) ? $dataIncorporacionestable2[$monthToShow[4]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[3]]) ? $dataIncorporacionestable2[$monthToShow[3]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[2]]) ? $dataIncorporacionestable2[$monthToShow[2]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataIncorporacionestable2[$monthToShow[1]]) ? $dataIncorporacionestable2[$monthToShow[1]]["rangoActual"] : "-" ?></td>
				</tr>
			<!-- Rango Final -->
		</tbody>
	</table>
</div>

<?php
	$graphTexts = [
		'es' => [
			'Sign Ups by active' => "Incorporaciones por Activo",
			'No. Sign Ups by active' => "No. Incorporaciones por Activo",
			'Monthly Personal Check - Does Not Include Discounts (USD)' => "Cheque personal mensual - descuentos no incluidos (USD)",
			'Commissions paid to the Organization' => "Comisiones pagadas a la organización (USD)",
			'Commissions' => "Comisiones",
		],
		'en' => [
			'Sign Ups by active' => 'Sign Ups by active',
			'No. Sign Ups by active' => 'No. Sign Ups by active',
			'Monthly Personal Check - Does Not Include Discounts (USD)' => 'Monthly Personal Check - Does Not Include Discounts (USD)',
			'Commissions paid to the Organization' => 'Commissions paid to the Organization',
			'Commissions' => 'Commissions',
		],
		'fr' => [
			'Sign Ups by active' => 'Incorporations par actif',
			'No. Sign Ups by active' => 'Non. Incorporations par actif',
			'Monthly Personal Check - Does Not Include Discounts (USD)' => 'Chèque personnel mensuel - ne comprend pas les réductions (USD)',
			'Commissions paid to the Organization' => 'Commissions versées à l\'organisation',
			'Commissions' => 'Commissions',
		],
	];
?>

<input type="hidden" id="Sign_Ups_by_active" value="<?php echo $graphTexts[$lang]['Sign Ups by active'];?>">
<input type="hidden" id="No_Sign_Ups_by_active" value="<?php echo $graphTexts[$lang]['No. Sign Ups by active']?>">
<input type="hidden" id="Monthly_Personal_Check_Does_Not_Include_Discounts_USD" value="<?php echo $graphTexts[$lang]['Monthly Personal Check - Does Not Include Discounts (USD)']?>">
<input type="hidden" id="Commissions_paid_to_the_Organization" value="<?php echo $graphTexts[$lang]['Commissions paid to the Organization']?>">
<input type="hidden" id="Commissions" value="<?php echo $graphTexts[$lang]['Commissions']?>">

<script>
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

	var Sign_Ups_by_active = $("#Sign_Ups_by_active").val();
	var No_Sign_Ups_by_active = $("#No_Sign_Ups_by_active").val();
	var Monthly_Personal_Check_Does_Not_Include_Discounts_USD = $("#Monthly_Personal_Check_Does_Not_Include_Discounts_USD").val();
	var Commissions_paid_to_the_Organization = $("#Commissions_paid_to_the_Organization").val();
	var Commissions = $("#Commissions").val();

	//Gráfica Incorporaciones por Activo
		var chart3Graph1 = document.getElementById('chart3Graph1').getContext('2d');
		var chart3Graph1Detail = new Chart(chart3Graph1, {
		    type: 'line',
		    data: {
		        labels: [txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: Sign_Ups_by_active,
			            data: <?php echo json_encode($dataIncorporacionesActivo) ?>,
			            backgroundColor: [ 'rgba(241, 185, 42, 1)', ],
			            borderColor: [ 'rgba(241, 185, 42, 1)', ],
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: Sign_Ups_by_active
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: No_Sign_Ups_by_active
			        	},
						beginAtZero: true
			      	}
			    }
			},
		});
	//Gráfica Incorporaciones por Activo

	//Gráfica Bonificaciones
		var chart3Graph2 = document.getElementById('chart3Graph2').getContext('2d');
		var chart3Graph2Detail = new Chart(chart3Graph2, {
		    type: 'line',
		    data: {
		        labels: [txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: Monthly_Personal_Check_Does_Not_Include_Discounts_USD,
			            data: <?php echo json_encode($dataBonificacionesPersonales) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: Commissions_paid_to_the_Organization,
			            data: <?php echo json_encode($dataBonificacionesOrganizacion) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: Commissions
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'USD'
			        	},
						beginAtZero: true
			      	}
			    }
			},
		});
	//Gráfica Bonificaciones

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>
