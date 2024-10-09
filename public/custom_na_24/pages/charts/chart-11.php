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
// $periodopost = 202408;
//Vars

//Others
$dataIncorporaciones = array();
$dataIncorporacionesTotal = array();
$dataIncorporacionesInscripciones = array();
$dataIncorporacionesActivos = array();
$dataIncorporacionesActivosTotales = array();
$datagraph1 = [];
$datagraph2 = [];
//Others

//Consulta
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_anual_usa $codeUser, $periodopost;";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$aniosDif = [];
	$monthToShow = [];
	$x = 0;
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$inscripcionesTotales = trim($rowSap[1]);
		$periodo = trim($rowSap[2]);
		//Guardar datos en array
		$dataIncorporaciones[$periodo] = array("inscripcionesTotales" => $inscripcionesTotales);
		//Guardar datos en array

		$periodotoShow = trim($rowSap[2]);
		$x++;
		$monthToShow[$x] = $rowSap[2];
		$aniosDif[$x] = $rowSap[3];
	}
	
	$aniosDif = array_unique($aniosDif);
	$i = 1;

	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_activos_anual_usa $codeUser, $periodopost;";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$activosTotales = trim($rowSap[1]);
		$periodo = trim($rowSap[2]);
		//Guardar datos en array
		$dataIncorporacionesActivosTotales[$periodo] = array("activosTotales" => $activosTotales);
		//Guardar datos en array
	}

	//Cerrar conexión
	sqlsrv_close($conn75);
	//Cerrar conexión
//Consulta

//Graficas
//Graficas

?>

<!-- Mostrar logo -->
<img src="https://mi.nikkenlatam.com/custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Business Variables Report By Consultant</div>
			<div class="h6 mb-0"><span class="fw-bold">Measurement Period:</span> January 2020 to August 2024</div>
			<div class="h6"><span class="fw-bold">Country:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Code:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold">Rank:</span> <?php echo $rangos_usa[$rankUser] ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Incorporaciones totales -->
			<canvas id="chart11Graph1" class="w-100" height="380"></canvas>
			<!-- Gráfica Incorporaciones totales -->
		</div>
	</div>
<!-- Gráficas -->
<div class="table-responsive mt-4">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1">Total Sign ups</th>
				<?php echo (intval($monthToShow[12]) <= intval($periodopost)) ? '<th scope="col">Jan</th>' : '<th scope="col" hidden>Jan</th>'; ?>
				<?php echo (intval($monthToShow[11]) <= intval($periodopost)) ? '<th scope="col">Feb</th>' : '<th scope="col" hidden>Feb</th>'; ?>
				<?php echo (intval($monthToShow[10]) <= intval($periodopost)) ? '<th scope="col">Mar</th>' : '<th scope="col" hidden>Mar</th>'; ?>
				<?php echo (intval($monthToShow[9]) <= intval($periodopost)) ? '<th scope="col">Apr</th>' : '<th scope="col" hidden>Apr</th>'; ?>
				<?php echo (intval($monthToShow[8]) <= intval($periodopost)) ? '<th scope="col">May</th>' : '<th scope="col" hidden>May</th>'; ?>
				<?php echo (intval($monthToShow[7]) <= intval($periodopost)) ? '<th scope="col">Jun</th>' : '<th scope="col" hidden>Jun</th>'; ?>
				<?php echo (intval($monthToShow[6]) <= intval($periodopost)) ? '<th scope="col">Jul</th>' : '<th scope="col" hidden>Jul</th>'; ?>
				<?php echo (intval($monthToShow[5]) <= intval($periodopost)) ? '<th scope="col">Aug</th>' : '<th scope="col" hidden>Aug</th>'; ?>
				<?php echo (intval($monthToShow[4]) <= intval($periodopost)) ? '<th scope="col">Sep</th>' : '<th scope="col" hidden>Sep</th>'; ?>
				<?php echo (intval($monthToShow[3]) <= intval($periodopost)) ? '<th scope="col">Oct</th>' : '<th scope="col" hidden>Oct</th>'; ?>
				<?php echo (intval($monthToShow[2]) <= intval($periodopost)) ? '<th scope="col">Nov</th>' : '<th scope="col" hidden>Nov</th>'; ?>
				<?php echo (intval($monthToShow[1]) <= intval($periodopost)) ? '<th scope="col">Dec</th>' : '<th scope="col" hidden>Dec</th>'; ?>
				<th scope="col">Total</th>
			</tr>
		</thead>

		<tbody>
			<!-- 2019 -->
				<tr>
					<th class="text-center" scope="row"><span id="mes5"><?php echo $aniosDif[$i + 48] ?></span></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[60]]) ? number_format($dataIncorporaciones[$monthToShow[60]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[59]]) ? number_format($dataIncorporaciones[$monthToShow[59]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[58]]) ? number_format($dataIncorporaciones[$monthToShow[58]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[57]]) ? number_format($dataIncorporaciones[$monthToShow[57]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[56]]) ? number_format($dataIncorporaciones[$monthToShow[56]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[55]]) ? number_format($dataIncorporaciones[$monthToShow[55]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[54]]) ? number_format($dataIncorporaciones[$monthToShow[54]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[53]]) ? number_format($dataIncorporaciones[$monthToShow[53]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[52]]) ? number_format($dataIncorporaciones[$monthToShow[52]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[51]]) ? number_format($dataIncorporaciones[$monthToShow[51]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[50]]) ? number_format($dataIncorporaciones[$monthToShow[50]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[49]]) ? number_format($dataIncorporaciones[$monthToShow[49]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[60]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[59]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[58]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[57]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[56]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[55]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[54]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[53]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[52]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[51]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[50]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[49]]["inscripcionesTotales"] : $total += 0;

						$datagraph1[0] = $total;

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- 2019 -->

			<!-- 2020 -->
				<tr>
					<th class="text-center" scope="row"><span id="mes4"><?php echo $aniosDif[$i + 36]; ?></span></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[48]]) ? number_format($dataIncorporaciones[$monthToShow[48]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[47]]) ? number_format($dataIncorporaciones[$monthToShow[47]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[46]]) ? number_format($dataIncorporaciones[$monthToShow[46]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[45]]) ? number_format($dataIncorporaciones[$monthToShow[45]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[44]]) ? number_format($dataIncorporaciones[$monthToShow[44]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[43]]) ? number_format($dataIncorporaciones[$monthToShow[43]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[42]]) ? number_format($dataIncorporaciones[$monthToShow[42]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[41]]) ? number_format($dataIncorporaciones[$monthToShow[41]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[40]]) ? number_format($dataIncorporaciones[$monthToShow[40]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[39]]) ? number_format($dataIncorporaciones[$monthToShow[39]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[38]]) ? number_format($dataIncorporaciones[$monthToShow[38]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[37]]) ? number_format($dataIncorporaciones[$monthToShow[37]]["inscripcionesTotales"], 0) : 0 ?></td>

					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[48]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[47]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[46]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[45]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[44]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[43]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[42]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[41]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[40]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[39]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[38]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[37]]["inscripcionesTotales"] : $total += 0;

						$datagraph1[1] = $total;

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- 2020 -->

			<!-- 2021 -->
				<tr>
					<th class="text-center" scope="row"><span id="mes3"><?php echo $aniosDif[$i + 24]; ?></span></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[36]]) ? number_format($dataIncorporaciones[$monthToShow[36]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[35]]) ? number_format($dataIncorporaciones[$monthToShow[35]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[34]]) ? number_format($dataIncorporaciones[$monthToShow[34]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[33]]) ? number_format($dataIncorporaciones[$monthToShow[33]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[32]]) ? number_format($dataIncorporaciones[$monthToShow[32]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[31]]) ? number_format($dataIncorporaciones[$monthToShow[31]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[30]]) ? number_format($dataIncorporaciones[$monthToShow[30]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[29]]) ? number_format($dataIncorporaciones[$monthToShow[29]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[28]]) ? number_format($dataIncorporaciones[$monthToShow[28]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[27]]) ? number_format($dataIncorporaciones[$monthToShow[27]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[56]]) ? number_format($dataIncorporaciones[$monthToShow[56]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[25]]) ? number_format($dataIncorporaciones[$monthToShow[25]]["inscripcionesTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[36]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[35]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[34]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[33]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[32]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[31]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[30]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[29]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[28]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[27]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[56]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[25]]["inscripcionesTotales"] : $total += 0;

						
						$datagraph1[2] = $total;

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- 2021 -->

			<!-- 2022 -->
				<tr>
					<th class="text-center" scope="row"><span id="mes2"><?php echo $aniosDif[$i+12]; ?></span></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"], 0) : 0 ?></td>

					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"] : $total += 0;

						$datagraph1[3] = $total;

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- 2022 -->

			<!-- 2022 -->
				<tr>
					<th class="text-center" scope="row"><span id="mes1"><?php echo $aniosDif[$i]; ?></span></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"], 0) : 0 ?></td>

					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"] : $total += 0;

						$datagraph1[4] = $total;

						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- 2022 -->
		</tbody>
	</table>
</div>


<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Incorporaciones totales -->
			<canvas id="chart11Graph2" class="w-100" height="380"></canvas>
			<!-- Gráfica Incorporaciones totales -->
		</div>
	</div>
<!-- Gráficas -->

<div class="table-responsive mt-4">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1">Monthly Active (Consultants and Customers)</th>
				<?php echo (intval($monthToShow[12]) <= intval($periodopost)) ? '<th scope="col">Jan</th>' : '<th scope="col" hidden>Jan</th>'; ?>
				<?php echo (intval($monthToShow[11]) <= intval($periodopost)) ? '<th scope="col">Feb</th>' : '<th scope="col" hidden>Feb</th>'; ?>
				<?php echo (intval($monthToShow[10]) <= intval($periodopost)) ? '<th scope="col">Mar</th>' : '<th scope="col" hidden>Mar</th>'; ?>
				<?php echo (intval($monthToShow[9]) <= intval($periodopost)) ? '<th scope="col">Apr</th>' : '<th scope="col" hidden>Apr</th>'; ?>
				<?php echo (intval($monthToShow[8]) <= intval($periodopost)) ? '<th scope="col">May</th>' : '<th scope="col" hidden>May</th>'; ?>
				<?php echo (intval($monthToShow[7]) <= intval($periodopost)) ? '<th scope="col">Jun</th>' : '<th scope="col" hidden>Jun</th>'; ?>
				<?php echo (intval($monthToShow[6]) <= intval($periodopost)) ? '<th scope="col">Jul</th>' : '<th scope="col" hidden>Jul</th>'; ?>
				<?php echo (intval($monthToShow[5]) <= intval($periodopost)) ? '<th scope="col">Aug</th>' : '<th scope="col" hidden>Aug</th>'; ?>
				<?php echo (intval($monthToShow[4]) <= intval($periodopost)) ? '<th scope="col">Sep</th>' : '<th scope="col" hidden>Sep</th>'; ?>
				<?php echo (intval($monthToShow[3]) <= intval($periodopost)) ? '<th scope="col">Oct</th>' : '<th scope="col" hidden>Oct</th>'; ?>
				<?php echo (intval($monthToShow[2]) <= intval($periodopost)) ? '<th scope="col">Nov</th>' : '<th scope="col" hidden>Nov</th>'; ?>
				<?php echo (intval($monthToShow[1]) <= intval($periodopost)) ? '<th scope="col">Dec</th>' : '<th scope="col" hidden>Dec</th>'; ?>
				<th scope="col">Promedio</th>
			</tr>
		</thead>

		<tbody>
			<!-- 2019 -->
				<tr>
					<th class="text-center" scope="row"><?php echo $aniosDif[$i + 48] ?></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[60]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[60]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[59]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[59]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[58]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[58]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[57]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[57]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[56]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[56]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[55]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[55]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[54]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[54]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[56]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[56]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[52]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[52]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[51]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[51]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[50]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[50]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[49]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[49]]["activosTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[60]]["activosTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[59]]["activosTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[58]]["activosTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[57]]["activosTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[56]]["activosTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[55]]["activosTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[54]]["activosTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[56]]["activosTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[52]]["activosTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[51]]["activosTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[50]]["activosTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[49]]["activosTotales"] : $total += 0;

						$datagraph2[0] = $total/8;

						echo number_format($total/8, 0);

						?>
					</td>
				</tr>
			<!-- 2019 -->

			<!-- 2020 -->
				<tr>
					<th class="text-center" scope="row"><?php echo $aniosDif[$i + 36]; ?></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[48]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[48]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[47]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[47]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[46]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[46]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[45]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[45]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[44]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[44]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[43]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[43]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[42]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[42]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[41]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[41]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[40]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[40]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[39]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[39]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[38]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[38]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[37]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[37]]["activosTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[48]]["activosTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[47]]["activosTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[46]]["activosTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[45]]["activosTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[44]]["activosTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[43]]["activosTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[42]]["activosTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[41]]["activosTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[40]]["activosTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[39]]["activosTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[38]]["activosTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[37]]["activosTotales"] : $total += 0;

						$datagraph2[1] = $total/8;

						echo number_format($total/8, 0);

						?>
					</td>
				</tr>
			<!-- 2020 -->

			<!-- 2021 -->
				<tr>
					<th class="text-center" scope="row"><?php echo $aniosDif[$i + 24]; ?></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[36]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[36]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[35]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[35]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[34]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[34]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[33]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[33]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[32]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[32]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[31]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[31]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[30]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[30]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[29]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[29]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[28]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[28]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[27]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[27]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[26]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[26]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[25]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[25]]["activosTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[36]]["activosTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[35]]["activosTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[34]]["activosTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[33]]["activosTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[32]]["activosTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[31]]["activosTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[30]]["activosTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[29]]["activosTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[28]]["activosTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[27]]["activosTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[26]]["activosTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[25]]["activosTotales"] : $total += 0;

						$datagraph2[2] = $total/8;

						echo number_format($total/8, 0);

						?>
					</td>
				</tr>
			<!-- 2021 -->

			<!-- 2022 -->
				<tr>
					<th class="text-center" scope="row"><?php echo $aniosDif[$i+12]; ?></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[24]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[24]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[23]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[23]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[22]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[22]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[21]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[21]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[20]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[20]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[19]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[19]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[18]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[18]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[17]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[17]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[16]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[16]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[15]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[15]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[14]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[14]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[13]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[13]]["activosTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[24]]["activosTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[23]]["activosTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[22]]["activosTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[21]]["activosTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[20]]["activosTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[19]]["activosTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[18]]["activosTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[17]]["activosTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[16]]["activosTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[15]]["activosTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[14]]["activosTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[13]]["activosTotales"] : $total += 0;

						$datagraph2[3] = $total/8;

						echo number_format($total/8, 0);

						?>
					</td>
				</tr>
			<!-- 2022 -->

			<!-- 2022 -->
				<tr>
					<th class="text-center" scope="row"><?php echo $aniosDif[$i]; ?></th>
					<?php (intval($monthToShow[12]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[12]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[12]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[11]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[11]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[11]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[10]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[10]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[10]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[9]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[9]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[9]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[8]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[8]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[8]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[7]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[7]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[7]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[6]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[6]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[6]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[5]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[5]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[5]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[4]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[4]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[4]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[3]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[3]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[3]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[2]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[2]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[2]]["activosTotales"], 0) : 0 ?></td>
					<?php (intval($monthToShow[1]) <= intval($periodopost)) ? $class = "" : $class = "hidden"; ?>
					<td class="text-center" <?php echo $class; ?>><?php echo isset($dataIncorporacionesActivosTotales[$monthToShow[1]]) ? number_format($dataIncorporacionesActivosTotales[$monthToShow[1]]["activosTotales"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						(intval($monthToShow[12]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[12]]["activosTotales"] : $total += 0;
						(intval($monthToShow[11]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[11]]["activosTotales"] : $total += 0;
						(intval($monthToShow[10]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[10]]["activosTotales"] : $total += 0;
						(intval($monthToShow[9]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[9]]["activosTotales"] : $total += 0;
						(intval($monthToShow[8]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[8]]["activosTotales"] : $total += 0;
						(intval($monthToShow[7]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[7]]["activosTotales"] : $total += 0;
						(intval($monthToShow[6]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[6]]["activosTotales"] : $total += 0;
						(intval($monthToShow[5]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[5]]["activosTotales"] : $total += 0;
						(intval($monthToShow[4]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[4]]["activosTotales"] : $total += 0;
						(intval($monthToShow[3]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[3]]["activosTotales"] : $total += 0;
						(intval($monthToShow[2]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[2]]["activosTotales"] : $total += 0;
						(intval($monthToShow[1]) <= intval($periodopost)) ? $total += $dataIncorporacionesActivosTotales[$monthToShow[1]]["activosTotales"] : $total += 0;

						$datagraph2[4] = $total/8;

						echo number_format($total/8, 0);

						?>
					</td>
				</tr>
			<!-- 2022 -->
		</tbody>
	</table>
</div>

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica

	var txtMes1 = $("#mes1").text();
	var txtMes2 = $("#mes2").text();
	var txtMes3 = $("#mes3").text();
	var txtMes4 = $("#mes4").text();
	var txtMes5 = $("#mes5").text();

	//Gráfica Totales
		var chart11Graph1 = document.getElementById('chart11Graph1').getContext('2d');
		var chart11Graph1Detail = new Chart(chart11Graph1, {
		    type: 'line',
		    data: {
		        labels: [txtMes5, txtMes4, txtMes3, txtMes2, txtMes1],
		        datasets: [
			        {
			            label: 'Total Sign ups',
			            data: <?php echo /*json_encode($dataIncorporacionesInscripciones)*/ json_encode($datagraph1) ?>,
			            backgroundColor: [ 'rgba(220, 123, 79, 1)', ],
			            borderColor: [ 'rgba(220, 123, 79, 1)', ],
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Total Sign ups'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'No. Total Sign ups'
			        	},
						beginAtZero: true
			      	}
			    }
			},
		});
	//Gráfica Totales

	//Gráfica Activos
		var chart11Graph2 = document.getElementById('chart11Graph2').getContext('2d');
		var chart11Graph2Detail = new Chart(chart11Graph2, {
		    type: 'line',
		    data: {
		        labels: [txtMes5, txtMes4, txtMes3, txtMes2, txtMes1],
		        datasets: [
			        {
			            label: 'Monthly Active (Consultants and Customers)',
			            data: <?php echo /*json_encode($dataIncorporacionesActivos)*/ json_encode($datagraph2) ?>,
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
						text: 'Monthly Active (Consultants and Customers)'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'No. Monthly Active (Consultants and Customers)'
			        	},
						beginAtZero: true
			      	}
			    }
			},
		});
	//Gráfica Activos

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>