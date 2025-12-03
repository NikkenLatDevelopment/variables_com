<?php require_once("../../functions.php"); //Funciones

$prod = $_GET["prod"];

if(trim($prod) === 'NO'){
	$serverName75 = "172.24.16.75";
}
else{
	$serverName75 = "104.130.46.73";
}

$connectionInfo75 = array("Database" => "LAT_MyNIKKEN", "UID" => "Latamti", "PWD" => 'L8$aQ7mZ!pR42^Tx');
$conn75 = sqlsrv_connect($serverName75, $connectionInfo75);
if(!$conn75){ die(print_r(sqlsrv_errors(), true)); }

//Vars
$codeUser = $_GET["codeUser"];
$nameUser = $_GET["nameUser"];
$countrieUser = letterCountrie($_GET["countrieUser"]);
$rankUser = $_GET["rankUser"];
$periodopost = $_GET["periodo"];
//Vars

//Others
$dataIncorporaciones = array();
$dataIncorporacionesActivosMensuales = array();
$dataCompras = array();
$dataComprasCompraTotal = array();
$dataComprasCompraPromedio = array();
//Others

//Consulta
	$sql = "EXEC LAT_MyNIKKEN.dbo.Compras_usa_24 $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$monthToShow = [];
	$x = 0;
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$compraPersonal = trim($rowSap[2]);
		$compraClientePreferente = trim($rowSap[3]);
		$compraOrganizacion = trim($rowSap[4]);
		$compraTotal = trim($rowSap[5]);
		$compraPromedio = trim($rowSap[6]);
		$periodo = trim($rowSap[7]);
		$periodotoShow = trim($rowSap[7]);
		$x++;
		$monthToShow[$x] = $rowSap[7];

		//Guardar datos en array
		$dataCompras[$periodo] = array("compraPersonal" => $compraPersonal, "compraClientePreferente" => $compraClientePreferente, "compraOrganizacion" => $compraOrganizacion, "compraTotal" => $compraTotal, "compraPromedio" => $compraPromedio);
		//Guardar datos en array
	}

	$sql = "EXEC LAT_MyNIKKEN.dbo.Incorporaciones_usa_24m $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$totalActivosMensuales = trim($rowSap[8]);
		$periodo = trim($rowSap[14]);

		//Guardar datos en array
		$dataIncorporaciones[$periodo] = array("totalActivosMensuales" => $totalActivosMensuales);
		//Guardar datos en array
	}

	$comprasUltimoAno = 0;

	//$sql = "EXEC ConteoComercialD1_test $codeUser, $periodopost";
	$sql = "EXEC LAT_MyNIKKEN.dbo.ConteoComercialD1_usa $codeUser, $periodopost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC);
	if($rowSap > 0) { $comprasUltimoAno = trim($rowSap[20]) == "" ? 0 : trim($rowSap[21]); }

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

		//Guardar compras total
		$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraTotal"] : 0;
		$dataComprasCompraTotal = array_merge($dataComprasCompraTotal, array($price));
		//Guardar compras total

		//Guardar compra promedio
		$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraPromedio"] : 0;
		$dataComprasCompraPromedio = array_merge($dataComprasCompraPromedio, array($price));
		//Guardar compra promedio

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
			<div class="h5 fw-bold mb-1">Business Variables Report By Consultant</div>
			<div class="h6 mb-0"><span class="fw-bold">Measurement Period:</span> September 2022 to August 2024</div>
			<div class="h6"><span class="fw-bold">Country:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Code:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold">Rank:</span> <?php echo $rangos_usa[$rankUser] ?></div>
		</div>
	</div>
<!-- Cabecera -->

<div class="table-responsive">
	<table class="table table-bordered align-middle">
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
				<th scope="col" class="c-mw-2">Total 24<br/>Months</th>
			</tr>
		</thead>

		<tbody>
			<!-- Compras Personales (Dólares) -->
				<tr>
					<th scope="row">Personal Purchases (USD)</th>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[24]]) ? number_format($dataCompras[$monthToShow[24]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[23]]) ? number_format($dataCompras[$monthToShow[23]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[22]]) ? number_format($dataCompras[$monthToShow[22]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[21]]) ? number_format($dataCompras[$monthToShow[21]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[20]]) ? number_format($dataCompras[$monthToShow[20]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[19]]) ? number_format($dataCompras[$monthToShow[19]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[18]]) ? number_format($dataCompras[$monthToShow[18]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[17]]) ? number_format($dataCompras[$monthToShow[17]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[16]]) ? number_format($dataCompras[$monthToShow[16]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[15]]) ? number_format($dataCompras[$monthToShow[15]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[14]]) ? number_format($dataCompras[$monthToShow[14]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[13]]) ? number_format($dataCompras[$monthToShow[13]]["compraPersonal"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[12]]) ? number_format($dataCompras[$monthToShow[12]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[11]]) ? number_format($dataCompras[$monthToShow[11]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[10]]) ? number_format($dataCompras[$monthToShow[10]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[9]]) ? number_format($dataCompras[$monthToShow[9]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[8]]) ? number_format($dataCompras[$monthToShow[8]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[7]]) ? number_format($dataCompras[$monthToShow[7]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[6]]) ? number_format($dataCompras[$monthToShow[6]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[5]]) ? number_format($dataCompras[$monthToShow[5]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[4]]) ? number_format($dataCompras[$monthToShow[4]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[3]]) ? number_format($dataCompras[$monthToShow[3]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[2]]) ? number_format($dataCompras[$monthToShow[2]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[1]]) ? number_format($dataCompras[$monthToShow[1]]["compraPersonal"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataCompras[$monthToShow[24]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[23]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[22]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[21]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[20]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[19]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[18]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[17]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[16]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[15]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[14]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[13]]["compraPersonal"];

						$total += $dataCompras[$monthToShow[12]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[11]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[10]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[9]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[8]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[7]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[6]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[5]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[4]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[3]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[2]]["compraPersonal"];
						$total += $dataCompras[$monthToShow[1]]["compraPersonal"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Compras Personales (Dólares) -->

			<!-- Compras de Clientes Preferentes (Dólares) -->
				<tr>
					<th scope="row">Customer Purchases (USD)</th>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[24]]) ? number_format($dataCompras[$monthToShow[24]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[23]]) ? number_format($dataCompras[$monthToShow[23]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[22]]) ? number_format($dataCompras[$monthToShow[22]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[21]]) ? number_format($dataCompras[$monthToShow[21]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[20]]) ? number_format($dataCompras[$monthToShow[20]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[19]]) ? number_format($dataCompras[$monthToShow[19]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[18]]) ? number_format($dataCompras[$monthToShow[18]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[17]]) ? number_format($dataCompras[$monthToShow[17]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[16]]) ? number_format($dataCompras[$monthToShow[16]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[15]]) ? number_format($dataCompras[$monthToShow[15]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[14]]) ? number_format($dataCompras[$monthToShow[14]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[13]]) ? number_format($dataCompras[$monthToShow[13]]["compraClientePreferente"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[12]]) ? number_format($dataCompras[$monthToShow[12]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[11]]) ? number_format($dataCompras[$monthToShow[11]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[10]]) ? number_format($dataCompras[$monthToShow[10]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[9]]) ? number_format($dataCompras[$monthToShow[9]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[8]]) ? number_format($dataCompras[$monthToShow[8]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[7]]) ? number_format($dataCompras[$monthToShow[7]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[6]]) ? number_format($dataCompras[$monthToShow[6]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[5]]) ? number_format($dataCompras[$monthToShow[5]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[4]]) ? number_format($dataCompras[$monthToShow[4]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[3]]) ? number_format($dataCompras[$monthToShow[3]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[2]]) ? number_format($dataCompras[$monthToShow[2]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[1]]) ? number_format($dataCompras[$monthToShow[1]]["compraClientePreferente"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataCompras[$monthToShow[24]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[23]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[22]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[21]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[20]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[19]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[18]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[17]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[16]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[15]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[14]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[13]]["compraClientePreferente"];

						$total += $dataCompras[$monthToShow[12]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[11]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[10]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[9]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[8]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[7]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[6]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[5]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[4]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[3]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[2]]["compraClientePreferente"];
						$total += $dataCompras[$monthToShow[1]]["compraClientePreferente"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Compras de Clientes Preferentes (Dólares) -->

			<!-- Compras Organizacional (Dólares) -->
				<tr>
					<th scope="row">Organizational Purchases(USD)</th>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[24]]) ? number_format($dataCompras[$monthToShow[24]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[23]]) ? number_format($dataCompras[$monthToShow[23]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[22]]) ? number_format($dataCompras[$monthToShow[22]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[21]]) ? number_format($dataCompras[$monthToShow[21]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[20]]) ? number_format($dataCompras[$monthToShow[20]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[19]]) ? number_format($dataCompras[$monthToShow[19]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[18]]) ? number_format($dataCompras[$monthToShow[18]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[17]]) ? number_format($dataCompras[$monthToShow[17]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[16]]) ? number_format($dataCompras[$monthToShow[16]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[15]]) ? number_format($dataCompras[$monthToShow[15]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[14]]) ? number_format($dataCompras[$monthToShow[14]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[13]]) ? number_format($dataCompras[$monthToShow[13]]["compraOrganizacion"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[12]]) ? number_format($dataCompras[$monthToShow[12]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[11]]) ? number_format($dataCompras[$monthToShow[11]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[10]]) ? number_format($dataCompras[$monthToShow[10]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[9]]) ? number_format($dataCompras[$monthToShow[9]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[8]]) ? number_format($dataCompras[$monthToShow[8]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[7]]) ? number_format($dataCompras[$monthToShow[7]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[6]]) ? number_format($dataCompras[$monthToShow[6]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[5]]) ? number_format($dataCompras[$monthToShow[5]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[4]]) ? number_format($dataCompras[$monthToShow[4]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[3]]) ? number_format($dataCompras[$monthToShow[3]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[2]]) ? number_format($dataCompras[$monthToShow[2]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[1]]) ? number_format($dataCompras[$monthToShow[1]]["compraOrganizacion"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						
						$total += $dataCompras[$monthToShow[24]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[23]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[22]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[21]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[20]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[19]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[18]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[17]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[16]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[15]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[14]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[13]]["compraOrganizacion"];

						$total += $dataCompras[$monthToShow[12]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[11]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[10]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[9]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[8]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[7]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[6]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[5]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[4]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[3]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[2]]["compraOrganizacion"];
						$total += $dataCompras[$monthToShow[1]]["compraOrganizacion"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Compras Organizacional (Dólares) -->

			<!-- Compra Total (Dólares) -->
				<tr>
					<th scope="row">Total Purchases (USD)</th>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[24]]) ? number_format($dataCompras[$monthToShow[24]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[23]]) ? number_format($dataCompras[$monthToShow[23]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[22]]) ? number_format($dataCompras[$monthToShow[22]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[21]]) ? number_format($dataCompras[$monthToShow[21]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[20]]) ? number_format($dataCompras[$monthToShow[20]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[19]]) ? number_format($dataCompras[$monthToShow[19]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[18]]) ? number_format($dataCompras[$monthToShow[18]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[17]]) ? number_format($dataCompras[$monthToShow[17]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[16]]) ? number_format($dataCompras[$monthToShow[16]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[15]]) ? number_format($dataCompras[$monthToShow[15]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[14]]) ? number_format($dataCompras[$monthToShow[14]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[13]]) ? number_format($dataCompras[$monthToShow[13]]["compraTotal"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[12]]) ? number_format($dataCompras[$monthToShow[12]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[11]]) ? number_format($dataCompras[$monthToShow[11]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[10]]) ? number_format($dataCompras[$monthToShow[10]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[9]]) ? number_format($dataCompras[$monthToShow[9]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[8]]) ? number_format($dataCompras[$monthToShow[8]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[7]]) ? number_format($dataCompras[$monthToShow[7]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[6]]) ? number_format($dataCompras[$monthToShow[6]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[5]]) ? number_format($dataCompras[$monthToShow[5]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[4]]) ? number_format($dataCompras[$monthToShow[4]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[3]]) ? number_format($dataCompras[$monthToShow[3]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[2]]) ? number_format($dataCompras[$monthToShow[2]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[1]]) ? number_format($dataCompras[$monthToShow[1]]["compraTotal"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataCompras[$monthToShow[24]]["compraTotal"];
						$total += $dataCompras[$monthToShow[23]]["compraTotal"];
						$total += $dataCompras[$monthToShow[22]]["compraTotal"];
						$total += $dataCompras[$monthToShow[21]]["compraTotal"];
						$total += $dataCompras[$monthToShow[20]]["compraTotal"];
						$total += $dataCompras[$monthToShow[19]]["compraTotal"];
						$total += $dataCompras[$monthToShow[18]]["compraTotal"];
						$total += $dataCompras[$monthToShow[17]]["compraTotal"];
						$total += $dataCompras[$monthToShow[16]]["compraTotal"];
						$total += $dataCompras[$monthToShow[15]]["compraTotal"];
						$total += $dataCompras[$monthToShow[14]]["compraTotal"];
						$total += $dataCompras[$monthToShow[13]]["compraTotal"];

						$total += $dataCompras[$monthToShow[12]]["compraTotal"];
						$total += $dataCompras[$monthToShow[11]]["compraTotal"];
						$total += $dataCompras[$monthToShow[10]]["compraTotal"];
						$total += $dataCompras[$monthToShow[9]]["compraTotal"];
						$total += $dataCompras[$monthToShow[8]]["compraTotal"];
						$total += $dataCompras[$monthToShow[7]]["compraTotal"];
						$total += $dataCompras[$monthToShow[6]]["compraTotal"];
						$total += $dataCompras[$monthToShow[5]]["compraTotal"];
						$total += $dataCompras[$monthToShow[4]]["compraTotal"];
						$total += $dataCompras[$monthToShow[3]]["compraTotal"];
						$total += $dataCompras[$monthToShow[2]]["compraTotal"];
						$total += $dataCompras[$monthToShow[1]]["compraTotal"];

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Compra Total (Dólares) -->

			<!-- Compra Promedio por Activo (Dólares) -->
				<tr>
					<th scope="row">Average purchase by Active (USD)</th>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[24]]) ? number_format($dataCompras[$monthToShow[24]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[23]]) ? number_format($dataCompras[$monthToShow[23]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[22]]) ? number_format($dataCompras[$monthToShow[22]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[21]]) ? number_format($dataCompras[$monthToShow[21]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[20]]) ? number_format($dataCompras[$monthToShow[20]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[19]]) ? number_format($dataCompras[$monthToShow[19]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[18]]) ? number_format($dataCompras[$monthToShow[18]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[17]]) ? number_format($dataCompras[$monthToShow[17]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[16]]) ? number_format($dataCompras[$monthToShow[16]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[15]]) ? number_format($dataCompras[$monthToShow[15]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[14]]) ? number_format($dataCompras[$monthToShow[14]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[13]]) ? number_format($dataCompras[$monthToShow[13]]["compraPromedio"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[12]]) ? number_format($dataCompras[$monthToShow[12]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[11]]) ? number_format($dataCompras[$monthToShow[11]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[10]]) ? number_format($dataCompras[$monthToShow[10]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[9]]) ? number_format($dataCompras[$monthToShow[9]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[8]]) ? number_format($dataCompras[$monthToShow[8]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[7]]) ? number_format($dataCompras[$monthToShow[7]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[6]]) ? number_format($dataCompras[$monthToShow[6]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[5]]) ? number_format($dataCompras[$monthToShow[5]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[4]]) ? number_format($dataCompras[$monthToShow[4]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[3]]) ? number_format($dataCompras[$monthToShow[3]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[2]]) ? number_format($dataCompras[$monthToShow[2]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataCompras[$monthToShow[1]]) ? number_format($dataCompras[$monthToShow[1]]["compraPromedio"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataCompras[$monthToShow[24]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[23]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[22]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[21]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[20]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[19]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[18]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[17]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[16]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[15]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[14]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[13]]["compraPromedio"];

						$total += $dataCompras[$monthToShow[12]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[11]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[10]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[9]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[8]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[7]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[6]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[5]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[4]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[3]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[2]]["compraPromedio"];
						$total += $dataCompras[$monthToShow[1]]["compraPromedio"];

						echo number_format($total / 24, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Compra Promedio por Activo (Dólares) -->

			<!-- Otras Variables -->
				<tr>
					<!-- <td colspan="3"><strong>Personal Purchases Growth <br> last 16 months (USD) %</strong></td>
					<td colspan="2" class="text-center">
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
								$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraPersonal"] : 0;
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
								$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraPersonal"] : 0;
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
					</td> -->

					<!-- <td colspan="2"></td>
					<td colspan="4"><strong>Average Purchase by <br> Active Growth (USD) %</strong></td>
					<td colspan="2" class="text-center">
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
								$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraPromedio"] : 0;
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
								$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraPromedio"] : 0;
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
					</td> -->

					<!-- <td colspan="2"></td> -->
					<td colspan="2"><strong>Personal Purchases Last 12 months (USD)</strong></td>
					<td colspan="16" class="">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[24]];
							// echo $periodoIni . "<br>";
							$periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
							// echo $periodoIni . "<br>";
							$period = new DateTime("$periodoIni");
							//Periodo inicial de consulta

							while($count < 12){
								$periodQuery = $period->format('Ym');

								//Guardar total
								$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraPersonal"] : 0;
								$totalPrevious = $totalPrevious + $price;
								//Guardar total

							    //Cambiar a periodo siguiente
								$period->modify('+1 month');
								$period = $period->format('Y-m-01');
								$period = new DateTime($period);
								//Cambiar a periodo siguiente

								$count++;
							}

							echo number_format($totalPrevious, 0);

							?>
						</strong>
					</td>
					<!-- <td colspan="14"></td> -->
					<!-- <td colspan="3"><strong>Actives Growth</strong></td>
					<td colspan="2" class="text-center">
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
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["totalActivosMensuales"] : 0;
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
								$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["totalActivosMensuales"] : 0;
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
					</td> -->
				</tr>

				<tr>
					<!-- <td colspan="3"><strong>Organizational Purchases Growth <br> last 16 months (USD) %</strong></td>
					<td colspan="2" class="text-center">
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
								$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraOrganizacion"] : 0;
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
								$price = isset($dataCompras[$periodQuery]) ? $dataCompras[$periodQuery]["compraOrganizacion"] : 0;
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
					</td> -->

					<!-- <td colspan="10"></td> -->
					<td colspan="2"><strong>Total Purchases Last 12 months (USD)</strong></td>
					<td colspan="16" class="">
						<strong>
							<?php

							echo number_format($comprasUltimoAno, 0);

							?>
						</strong>
					</td>
					<!-- <td colspan="14"></td> -->
				</tr>
			<!-- Otras Variables -->
		</tbody>
	</table>
</div>

<div class="table-responsive mt-2">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1">Monthly Actives</th>
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
				<th scope="col" class="c-mw-2">Average 24 months</th>
			</tr>
		</thead>

		<tbody>
			<!-- Activos Mensuales (ABIs + CPs) -->
				<tr>
					<th scope="row">Monthly Actives (Consultants and Customers)</th>
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
						$count = 0;

						//Periodo inicial de consulta
						$periodoIni = $periodMonthsByGraph[$monthToShow[16]];
						$period = new DateTime("$periodoIni");
						//Periodo inicial de consulta

						while($count < 16){
							$periodQuery = $period->format('Ym');

							//Guardar total
							$price = isset($dataIncorporaciones[$periodQuery]) ? $dataIncorporaciones[$periodQuery]["totalActivosMensuales"] : 0;
							$total = $total + $price;
							//Guardar total

						    //Cambiar a periodo siguiente
							$period->modify('+1 month');
							$period = $period->format('Y-m-01');
							$period = new DateTime($period);
							//Cambiar a periodo siguiente

							$count++;
						}

						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- Activos Mensuales (ABIs + CPs) -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Comportamiento de Compras VS Activos Mensuales -->
			<canvas id="chart1Graph1" class="w-100" height="700"></canvas>
			<!-- Gráfica Comportamiento de Compras VS Activos Mensuales -->
		</div>

		<div class="col text-center">
			<!-- Gráfica Compra Promedio por Activos - Dolares -->
			<canvas id="chart1Graph2" class="w-100" height="700"></canvas>
			<!-- Gráfica Compra Promedio por Activos - Dolares -->
		</div>
	</div>
<!-- Gráficas -->

<!-- Notas -->
<!-- <div class="fw-bold mt-4" style="color: red;">* Compras antes de impuestos de NIKKEN Latinoamérica - Retail.</div> -->
<div class="fw-bold mb-4" style="color: red;">* Calculated Average</div>
<!-- Notas -->

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 12;
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
	
	//Gráfica Comportamiento de Compras VS Activos Mensuales
	var chart1Graph1 = document.getElementById('chart1Graph1').getContext('2d');
	var chart1Graph1Detail = new Chart(chart1Graph1, {
		type: 'bar',
		data: {
			labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
			datasets: [
				{
					label: 'Monthly Actives',
					data: <?php echo json_encode($dataIncorporacionesActivosMensuales) ?>,
					backgroundColor: [ 'rgba(220, 123, 79, 1)', ],
					borderColor: [ 'rgba(220, 123, 79, 1)', ],
					yAxisID: 'y1',
					type: 'line',
				},
				{
					label: 'Purchases (USD)',
					data: <?php echo json_encode($dataComprasCompraTotal) ?>,
					backgroundColor: [ 'rgba(241, 185, 42, 1)', ],
					borderColor: [ 'rgba(241, 185, 42, 1)', ],
					yAxisID: 'y',
				}
			]
		},
		options: {
			responsive: false,
			plugins: {
				title: {
					display: true,
					text: 'Purchasing behaviour vs Monthly Actives',
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
						text: 'USD'
					},
				},
				y1: {
					type: 'linear',
					display: true,
					position: 'right',
					title: {
						display: true,
						text: 'Monthly Actives'
					},
				},
			}
		},
	});
	//Gráfica Comportamiento de Compras VS Activos Mensuales

	//Gráfica Compra Promedio por Activos - Dolares
	var chart1Graph2 = document.getElementById('chart1Graph2').getContext('2d');
	var chart1Graph2Detail = new Chart(chart1Graph2, {
		type: 'line',
		data: {
			labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
			datasets: [
				{
					label: 'Average Purchase by Active (USD)',
					data: <?php echo json_encode($dataComprasCompraPromedio) ?>,
					backgroundColor: [ 'rgba(220, 123, 79, 1)', ],
					borderColor: [ 'rgba(220, 123, 79, 1)', ],
				}
			]
		},
		options: {
			responsive: false,
			plugins: {
				title: {
					display: true,
					text: 'Average Purchase by Active (USD)'
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
	//Gráfica Compra Promedio por Activos - Dolares

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>
