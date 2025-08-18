<?php require_once("../../functions.php"); //Funciones

//Conexión 75
$serverName75 = "104.130.46.73";
// $serverName75 = "172.24.16.75";
$connectionInfo75 = array("Database" => "LAT_MyNIKKEN_TEST", "UID" => "Latamti", "PWD" => "N1k3N$17!");
$conn75 = sqlsrv_connect($serverName75, $connectionInfo75);
if(!$conn75){ die(print_r(sqlsrv_errors(), true)); }

//Vars
$codeUser = $_GET["codeUser"];
$nameUser = $_GET["nameUser"];
$countrieUser = letterCountrie($_GET["countrieUser"]);
$rankUser = $_GET["rankUser"];
$periodopost = $_GET["periodo"];
$lang = $_GET["lang"];
//Vars

//Others
$dataIncorporaciones = array();
$dataIncorporacionesActivosMensuales = array();
$dataCompras = array();
$dataComprasCompraTotal = array();
$dataComprasCompraPromedio = array();
//Others

//Consulta
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Compras_usa $codeUser, $periodopost";
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

	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_usa $codeUser, $periodopost";
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
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.ConteoComercialD1_usa $codeUser, $periodopost";
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
	$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
	$period = new DateTime("$periodoIni");
	//Periodo inicial de consulta
	while($count < 12){
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
 <hr>
<img src="src/img/logo-black.png" srcset="custom_na/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN">
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
	<table class="table table-bordered align-middle">
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
				<th scope="col" class="c-mw-2"><?php echo $laguaje[$lang]['Total 12 meses']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Compras Personales (Dólares) -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Personal Purchases (USD)']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Compras de clientes (USD)']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Compras de la organización (USD)']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Compras totales (USD)']; ?></th>
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
					<th scope="row"><?php echo $laguaje[$lang]['Compra media por Activo (USD)']; ?></th>
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

						echo number_format($total / 12, 0) . "*";

						?>
					</td>
				</tr>
			<!-- Compra Promedio por Activo (Dólares) -->

			<!-- Otras Variables -->
				<tr>
					<td><strong><?php echo $laguaje[$lang]['Compras Personales Crecimiento últimos 12 meses (USD) %']; ?></strong></td>
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
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
							// $periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
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
					</td>

					<td colspan="2"><strong><?php echo $laguaje[$lang]['Compra media por Activo Crecimiento (USD) %']; ?></strong></td>
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
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
							// $periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
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
					</td>

					<td colspan="2"><strong><?php echo $laguaje[$lang]['Compras personales últimos 12 meses (USD)']; ?></strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							$totalPrevious = 0;
							$count = 0;

							//Periodo inicial de consulta
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
							// echo $periodoIni . "<br>";
							// $periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
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

					<td colspan="2"><strong><?php echo $laguaje[$lang]['Crecimiento Activos']; ?></strong></td>
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
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
							// $periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
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
					</td>
				</tr>

				<tr>
					<td><strong><?php echo $laguaje[$lang]['Compras Organizativas Crecimiento últimos 12 meses (USD) %']; ?></strong></td>
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
							$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
							// $periodoIni = date('Y-m-d', strtotime($periodoIni. ' + 1 years'));
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
					</td>

					<td colspan="3"></td>
					<td colspan="4"><strong><?php echo $laguaje[$lang]['Compras totales últimos 12 meses (USD)']; ?></strong></td>
					<td colspan="2" class="text-center">
						<strong>
							<?php

							echo number_format($comprasUltimoAno, 0);

							?>
						</strong>
					</td>

					<td colspan="5"></td>
				</tr>
			<!-- Otras Variables -->
		</tbody>
	</table>
</div>

<div class="table-responsive mt-2">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"><?php echo $laguaje[$lang]['Activos Mensuales']; ?></th>
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
				<th scope="col" class="c-mw-2"><?php echo $laguaje[$lang]['Media 12 meses']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Activos Mensuales (ABIs + CPs) -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Activos mensuales (Consultores y Clientes)']; ?></th>
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
						$periodoIni = $periodMonthsByGraph[$monthToShow[12]];
						$period = new DateTime("$periodoIni");
						//Periodo inicial de consulta

						while($count < 12){
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

						echo number_format($total / 12, 0);

						?>
					</td>
				</tr>
			<!-- Activos Mensuales (ABIs + CPs) -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="row">
		<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
			<!-- Gráfica Comportamiento de Compras VS Activos Mensuales -->
			<canvas id="chart1Graph1" class="w-100" height="700"></canvas>
			<!-- Gráfica Comportamiento de Compras VS Activos Mensuales -->
		</div>

		<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center">
			<!-- Gráfica Compra Promedio por Activos - Dolares -->
			<canvas id="chart1Graph2" class="w-100" height="700"></canvas>
			<!-- Gráfica Compra Promedio por Activos - Dolares -->
		</div>
	</div>
<!-- Gráficas -->

<!-- Notas -->
<!-- <div class="fw-bold mt-4" style="color: red;">* Compras antes de impuestos de NIKKEN Latinoamérica - Retail.</div> -->
<div class="fw-bold mb-4" style="color: red;">* <?php echo $laguaje[$lang]['Media calculada']; ?></div>
<!-- Notas -->

<?php
	$graphTexts = [
		'es' => [
			'Monthly Actives' => 'Activos Mensuales',
			'Purchases (USD)' => 'Compras (USD)',
			'Average Purchase by Active (USD)' => 'Compra Promedio por Activo (USD)',
			'Purchasing behaviour vs Monthly Actives' => 'Comportamiento de Compras VS Activos Mensuales',
		],
		'en' => [
			'Monthly Actives' => 'Monthly Actives',
			'Purchases (USD)' => 'Purchases (USD)',
			'Average Purchase by Active (USD)' => 'Average Purchase by Active (USD)',
			'Purchasing behaviour vs Monthly Actives' => 'Purchasing behaviour vs Monthly Actives',
		],
		'fr' => [
			'Monthly Actives' => 'Actifs Mensuels',
			'Purchases (USD)' => 'Achats (USD)',
			'Average Purchase by Active (USD)' => 'Achat moyen par actif (USD)',
			'Purchasing behaviour vs Monthly Actives' => 'Comportement d\'achat par rapport aux actifs mensuels',
		],
	];
?>

<input type="hidden" id="Monthly_Actives" value="<?php echo $graphTexts[$lang]['Monthly Actives']; ?>">
<input type="hidden" id="Purchases_USD" value="<?php echo $graphTexts[$lang]['Purchases (USD)']; ?>">
<input type="hidden" id="Average_Purchase_by_Active_USD" value="<?php echo $graphTexts[$lang]['Average Purchase by Active (USD)']; ?>">
<input type="hidden" id="Purchasing_behaviour_vs_Monthly_Actives" value="<?php echo $graphTexts[$lang]['Purchasing behaviour vs Monthly Actives']; ?>">

<script>
	var Monthly_Actives = $("#Monthly_Actives").val();
	var Purchases_USD = $("#Purchases_USD").val();
	var Average_Purchase_by_Active_USD = $("#Average_Purchase_by_Active_USD").val();
	var Purchasing_behaviour_vs_Monthly_Actives = $("#Purchasing_behaviour_vs_Monthly_Actives").val();

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

	//Gráfica Comportamiento de Compras VS Activos Mensuales
	var chart1Graph1 = document.getElementById('chart1Graph1').getContext('2d');
	var chart1Graph1Detail = new Chart(chart1Graph1, {
		type: 'bar',
		data: {
			labels: [txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
			datasets: [
				{
					label: Monthly_Actives,
					data: <?php echo json_encode($dataIncorporacionesActivosMensuales) ?>,
					backgroundColor: [ 'rgba(220, 123, 79, 1)', ],
					borderColor: [ 'rgba(220, 123, 79, 1)', ],
					yAxisID: 'y1',
					type: 'line',
				},
				{
					label: Purchases_USD,
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
					text: Purchasing_behaviour_vs_Monthly_Actives,
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
						text: Monthly_Actives
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
			labels: [txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
			datasets: [
				{
					label: Average_Purchase_by_Active_USD,
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
					text: Average_Purchase_by_Active_USD
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
