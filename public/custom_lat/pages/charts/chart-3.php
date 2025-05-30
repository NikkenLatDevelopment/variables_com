<?php require_once("../../functions.php"); //Funciones

$prod = $_POST["prod"];

if(trim($prod) === 'NO'){
	$serverName75 = "172.24.16.75";
}
else{
	$serverName75 = "104.130.46.73";
}

$connectionInfo75 = array("Database" => "LAT_MyNIKKEN_TEST", "UID" => "Latamti", "PWD" => "N1k3N$17!");
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
$dataIncorporacionesActivo = array();
$dataBonificaciones = array();
$dataBonificacionesPersonales = array();
$dataBonificacionesOrganizacion = array();
//Others

//Consulta
	$sql = "EXEC LAT_MyNIKKEN.dbo.Incorporaciones $codeUser, $periodopost";
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

	$sql = "EXEC LAT_MyNIKKEN.dbo.Bonificaciones_SD $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$periodo = trim($rowSap[12]);
		$rangoPago = trim($rowSap[1]);
		$rangoActual = trim($rowSap[2]);
		$retail = trim($rowSap[3]);
		$rebate = trim($rowSap[4]);
		$overide = trim($rowSap[5]);
		$leadership = trim($rowSap[6]);
		$club = trim($rowSap[7]);
		$ahlsb = trim($rowSap[8]);
		$pi = trim($rowSap[9]);
		$suma = trim($rowSap[10]);
		$bonificacionesOrganizacion = 0; //Pendiente

		//Guardar datos en array
		$dataBonificaciones[$periodo] = array("rangoPago" => $rangoPago, "rangoActual" => $rangoActual, "retail" => $retail, "rebate" => $rebate, "overide" => $overide, "leadership" => $leadership, "club" => $club, "ahlsb" => $ahlsb, "pi" => $pi, "suma" => $suma, "bonificacionesOrganizacion" => $bonificacionesOrganizacion);
		//Guardar datos en array
	}

	$sql = "EXEC LAT_MyNIKKEN.dbo.Bonificaciones_SD_ORG $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$periodo = trim($rowSap[12]);
		$suma = trim($rowSap[10]);

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
	$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
	$period = new DateTime("$periodoIni");
	//Periodo inicial de consulta

	while($count < 24){
		$periodQuery = $period->format('Ym');

		//Guardar incorporaciones activo
		$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["inscripcionesActivo"] : 0;
		$dataIncorporacionesActivo = array_merge($dataIncorporacionesActivo, array($price));
		//Guardar incorporaciones activo

		//Guardar bonificaciones personales
		$price = isset($dataBonificaciones[$periodQuery]) ? @$dataBonificaciones[$periodQuery]["suma"] : 0;
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
	<table class="table align-middle table-bordered">
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
				<th scope="col" class="c-mw-2">Promedio 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- Incorporaciones por Activo -->
				<tr>
					<th scope="row">Incorporaciones por Activo</th>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["inscripcionesActivo"], 2) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["inscripcionesActivo"], 2) : 0 ?></td>
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

						$total += $dataIncorporaciones[$monthToShow[24]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[23]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[22]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[21]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[20]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[19]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[18]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[17]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[16]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[15]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[14]]["inscripcionesActivo"];
						$total += $dataIncorporaciones[$monthToShow[13]]["inscripcionesActivo"];
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

						echo number_format($total / 24, 2);

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
			<!-- Bonificaciones Personales -->
				<tr>
					<th scope="row">Cheque Personal Mensual - No Incluye Descuentos (Dólares)</th>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[24]]) ? @number_format($dataBonificaciones[$monthToShow[24]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[23]]) ? @number_format($dataBonificaciones[$monthToShow[23]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[22]]) ? @number_format($dataBonificaciones[$monthToShow[22]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[21]]) ? @number_format($dataBonificaciones[$monthToShow[21]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[20]]) ? @number_format($dataBonificaciones[$monthToShow[20]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[19]]) ? @number_format($dataBonificaciones[$monthToShow[19]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[18]]) ? @number_format($dataBonificaciones[$monthToShow[18]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[17]]) ? @number_format($dataBonificaciones[$monthToShow[17]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[16]]) ? @number_format($dataBonificaciones[$monthToShow[16]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[15]]) ? @number_format($dataBonificaciones[$monthToShow[15]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[14]]) ? @number_format($dataBonificaciones[$monthToShow[14]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[13]]) ? @number_format($dataBonificaciones[$monthToShow[13]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[12]]) ? @number_format($dataBonificaciones[$monthToShow[12]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[11]]) ? @number_format($dataBonificaciones[$monthToShow[11]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[10]]) ? @number_format($dataBonificaciones[$monthToShow[10]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[9]]) ? @number_format($dataBonificaciones[$monthToShow[9]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[8]]) ? @number_format($dataBonificaciones[$monthToShow[8]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[7]]) ? @number_format($dataBonificaciones[$monthToShow[7]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[6]]) ? @number_format($dataBonificaciones[$monthToShow[6]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[5]]) ? @number_format($dataBonificaciones[$monthToShow[5]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[4]]) ? @number_format($dataBonificaciones[$monthToShow[4]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[3]]) ? @number_format($dataBonificaciones[$monthToShow[3]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[2]]) ? @number_format($dataBonificaciones[$monthToShow[2]]["suma"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[1]]) ? @number_format($dataBonificaciones[$monthToShow[1]]["suma"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataBonificaciones[$monthToShow[24]]["suma"];
						$total += $dataBonificaciones[$monthToShow[23]]["suma"];
						$total += $dataBonificaciones[$monthToShow[22]]["suma"];
						$total += $dataBonificaciones[$monthToShow[21]]["suma"];
						$total += $dataBonificaciones[$monthToShow[20]]["suma"];
						$total += $dataBonificaciones[$monthToShow[19]]["suma"];
						$total += $dataBonificaciones[$monthToShow[18]]["suma"];
						$total += $dataBonificaciones[$monthToShow[17]]["suma"];
						$total += $dataBonificaciones[$monthToShow[16]]["suma"];
						$total += $dataBonificaciones[$monthToShow[15]]["suma"];
						$total += $dataBonificaciones[$monthToShow[14]]["suma"];
						$total += $dataBonificaciones[$monthToShow[13]]["suma"];
						$total += $dataBonificaciones[$monthToShow[12]]["suma"];
						$total += $dataBonificaciones[$monthToShow[11]]["suma"];
						$total += $dataBonificaciones[$monthToShow[10]]["suma"];
						$total += $dataBonificaciones[$monthToShow[9]]["suma"];
						$total += $dataBonificaciones[$monthToShow[8]]["suma"];
						$total += $dataBonificaciones[$monthToShow[7]]["suma"];
						$total += $dataBonificaciones[$monthToShow[6]]["suma"];
						$total += $dataBonificaciones[$monthToShow[5]]["suma"];
						$total += $dataBonificaciones[$monthToShow[4]]["suma"];
						$total += $dataBonificaciones[$monthToShow[3]]["suma"];
						$total += $dataBonificaciones[$monthToShow[2]]["suma"];
						$total += $dataBonificaciones[$monthToShow[1]]["suma"];

						echo @number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Bonificaciones Personales -->

			<!-- Bonificaciones de la Organización -->
				<tr>
					<th scope="row">Bonificaciones Pagadas a la Organización (Dólares)</th>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[24]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[24]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[23]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[23]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[22]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[22]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[21]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[21]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[20]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[20]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[19]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[19]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[18]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[18]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[17]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[17]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[16]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[16]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[15]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[15]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[14]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[14]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[13]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[13]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[12]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[12]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[11]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[11]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[10]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[10]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[9]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[9]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[8]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[8]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[7]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[7]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[6]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[6]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[5]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[5]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[4]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[4]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[3]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[3]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[2]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[2]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center"><?php echo ($dataBonificaciones[$monthToShow[1]]["bonificacionesOrganizacion"] > 0) ? number_format($dataBonificaciones[$monthToShow[1]]["bonificacionesOrganizacion"], 2) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += ($dataBonificaciones[$monthToShow[24]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[24]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[23]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[23]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[22]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[22]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[21]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[21]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[20]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[20]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[19]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[19]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[18]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[18]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[17]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[17]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[16]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[16]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[15]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[15]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[14]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[14]]["bonificacionesOrganizacion"] : 0;
						$total += ($dataBonificaciones[$monthToShow[13]]["bonificacionesOrganizacion"] > 0) ? $dataBonificaciones[$monthToShow[13]]["bonificacionesOrganizacion"] : 0;
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
			<p style="color: red !important;">* Se contemplan todas las ventas ha sugerido en el cálculo del retail.</p>
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
				<th scope="col" class="c-mw-1">RANGO DE PAGO</th>
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
			</tr>
		</thead>

		<tbody>
			<!-- Rango Pagado -->
				<tr>
					<th scope="row">Rango Pagado</th>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[24]]) ? $dataBonificaciones[$monthToShow[24]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[23]]) ? $dataBonificaciones[$monthToShow[23]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[22]]) ? $dataBonificaciones[$monthToShow[22]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[21]]) ? $dataBonificaciones[$monthToShow[21]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[20]]) ? $dataBonificaciones[$monthToShow[20]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[19]]) ? $dataBonificaciones[$monthToShow[19]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[18]]) ? $dataBonificaciones[$monthToShow[18]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[17]]) ? $dataBonificaciones[$monthToShow[17]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[16]]) ? $dataBonificaciones[$monthToShow[16]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[15]]) ? $dataBonificaciones[$monthToShow[15]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[14]]) ? $dataBonificaciones[$monthToShow[14]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[13]]) ? $dataBonificaciones[$monthToShow[13]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[12]]) ? $dataBonificaciones[$monthToShow[12]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[11]]) ? $dataBonificaciones[$monthToShow[11]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[10]]) ? $dataBonificaciones[$monthToShow[10]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[9]]) ? $dataBonificaciones[$monthToShow[9]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[8]]) ? $dataBonificaciones[$monthToShow[8]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[7]]) ? $dataBonificaciones[$monthToShow[7]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[6]]) ? $dataBonificaciones[$monthToShow[6]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[5]]) ? $dataBonificaciones[$monthToShow[5]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[4]]) ? $dataBonificaciones[$monthToShow[4]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[3]]) ? $dataBonificaciones[$monthToShow[3]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[2]]) ? $dataBonificaciones[$monthToShow[2]]["rangoPago"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[1]]) ? $dataBonificaciones[$monthToShow[1]]["rangoPago"] : "-" ?></td>
				</tr>
			<!-- Rango Pagado -->

			<!-- Rango Final -->
				<tr>
					<th scope="row">Rango Final</th>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[24]]) ? $dataBonificaciones[$monthToShow[24]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[23]]) ? $dataBonificaciones[$monthToShow[23]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[22]]) ? $dataBonificaciones[$monthToShow[22]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[21]]) ? $dataBonificaciones[$monthToShow[21]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[20]]) ? $dataBonificaciones[$monthToShow[20]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[19]]) ? $dataBonificaciones[$monthToShow[19]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[18]]) ? $dataBonificaciones[$monthToShow[18]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[17]]) ? $dataBonificaciones[$monthToShow[17]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[16]]) ? $dataBonificaciones[$monthToShow[16]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[15]]) ? $dataBonificaciones[$monthToShow[15]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[14]]) ? $dataBonificaciones[$monthToShow[14]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[13]]) ? $dataBonificaciones[$monthToShow[13]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[12]]) ? $dataBonificaciones[$monthToShow[12]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[11]]) ? $dataBonificaciones[$monthToShow[11]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[10]]) ? $dataBonificaciones[$monthToShow[10]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[9]]) ? $dataBonificaciones[$monthToShow[9]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[8]]) ? $dataBonificaciones[$monthToShow[8]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[7]]) ? $dataBonificaciones[$monthToShow[7]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[6]]) ? $dataBonificaciones[$monthToShow[6]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[5]]) ? $dataBonificaciones[$monthToShow[5]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[4]]) ? $dataBonificaciones[$monthToShow[4]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[3]]) ? $dataBonificaciones[$monthToShow[3]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[2]]) ? $dataBonificaciones[$monthToShow[2]]["rangoActual"] : "-" ?></td>
					<td class="text-center"><?php echo isset($dataBonificaciones[$monthToShow[1]]) ? $dataBonificaciones[$monthToShow[1]]["rangoActual"] : "-" ?></td>
				</tr>
			<!-- Rango Final -->
		</tbody>
	</table>
</div>

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

	//Gráfica Incorporaciones por Activo
		var chart3Graph1 = document.getElementById('chart3Graph1').getContext('2d');
		var chart3Graph1Detail = new Chart(chart3Graph1, {
		    type: 'line',
		    data: {
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: 'Incorporaciones por Activo',
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
						text: 'Incorporaciones por Activo'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'No. Incorporaciones Activo'
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
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: 'Cheque Personal Mensual - No Incluye Descuentos (Dólares)',
			            data: <?php echo json_encode($dataBonificacionesPersonales) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: 'Bonificaciones Pagadas a la Organización (Dólares)',
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
						text: 'Bonificaciones'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'Dólares'
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
