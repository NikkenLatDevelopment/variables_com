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
$periodoPost = $_POST["periodo"];
//Vars

//Others
$dataVolumenes = array();
$dataVolumenesVp = array();
$dataVolumenesVgp = array();
$dataVolumenesVo = array();
$dataVolumenesVoldp = array();
$dataVolumenesVoldpys = array();
//Others

//Consulta
	// $sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Sp_Volumenes_usa $codeUser, '$periodoPost'";
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Sp_Volumenes_usa_24 $codeUser, '$periodoPost'";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$monthToShow = [];
	$x = 0;
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$vp = trim($rowSap[1]);
		$vgp = trim($rowSap[2]);
		$vo = trim($rowSap[3]);
		$voldp = trim($rowSap[4]);
		$voldpys = trim($rowSap[5]);
		$periodo = trim($rowSap[6]);

		$periodotoShow = trim($rowSap[6]);
		$x++;
		$monthToShow[$x] = $rowSap[6];

		//Guardar datos en array
		$dataVolumenes[$periodo] = array("vp" => $vp, "vgp" => $vgp, "vo" => $vo, "voldp" => $voldp, "voldpys" => $voldpys);
		//Guardar datos en array
	}
	// sqlsrv_free_stmt($recordSet);

	// echo "<pre>";
	// print_r($dataVolumenes);
	// echo "</pre>";
	// exit;

	//Cerrar conexión
	sqlsrv_close($conn75);
	//Cerrar conexión
//Consulta

//Graficas
	// $count = 0;

	// //Periodo inicial de consulta
	// $periodoIni = $periodMonthsByGraph[$monthToShow[24]];
	// $period = new DateTime("$periodoIni");
	// //Periodo inicial de consulta

	// while($count < 24){
	// 	$periodQuery = $period->format('Ym');

	// 	//Guardar vp
	// 	$price = isset($dataVolumenes[$periodQuery]) ? $dataVolumenes[$periodQuery]["vp"] : 0;
	// 	$dataVolumenesVp = array_merge($dataVolumenesVp, array($price));
	// 	//Guardar vp

	// 	//Guardar vgp
	// 	$price = isset($dataVolumenes[$periodQuery]) ? $dataVolumenes[$periodQuery]["vgp"] : 0;
	// 	$dataVolumenesVgp = array_merge($dataVolumenesVgp, array($price));
	// 	//Guardar vgp

	// 	//Guardar vo
	// 	$price = isset($dataVolumenes[$periodQuery]) ? $dataVolumenes[$periodQuery]["vo"] : 0;
	// 	$dataVolumenesVo = array_merge($dataVolumenesVo, array($price));
	// 	//Guardar vo

	// 	//Guardar voldp
	// 	$price = isset($dataVolumenes[$periodQuery]) ? $dataVolumenes[$periodQuery]["voldp"] : 0;
	// 	$dataVolumenesVoldp = array_merge($dataVolumenesVoldp, array($price));
	// 	//Guardar voldp

	// 	//Guardar voldpys
	// 	$price = isset($dataVolumenes[$periodQuery]) ? $dataVolumenes[$periodQuery]["voldpys"] : 0;
	// 	$dataVolumenesVoldpys = array_merge($dataVolumenesVoldpys, array($price));
	// 	//Guardar voldpys

	//     //Cambiar a periodo siguiente
	// 	$period->modify('+1 month');
	// 	$period = $period->format('Y-m-01');
	// 	$period = new DateTime($period);
	// 	//Cambiar a periodo siguiente

	// 	$count++;
	// }
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

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Volúmenes -->
			<canvas id="chart4Graph1" class="w-100" height="430"></canvas>
			<!-- Gráfica Volúmenes -->
		</div>
	</div>

	<?php
		$jsonVp = [
			$dataVolumenes[$monthToShow[12]]["vp"],
			$dataVolumenes[$monthToShow[11]]["vp"],
			$dataVolumenes[$monthToShow[10]]["vp"],
			$dataVolumenes[$monthToShow[9]]["vp"],
			$dataVolumenes[$monthToShow[8]]["vp"],
			$dataVolumenes[$monthToShow[7]]["vp"],
			$dataVolumenes[$monthToShow[6]]["vp"],
			$dataVolumenes[$monthToShow[5]]["vp"],
			$dataVolumenes[$monthToShow[16]]["vp"],
			$dataVolumenes[$monthToShow[15]]["vp"],
			$dataVolumenes[$monthToShow[14]]["vp"],
			$dataVolumenes[$monthToShow[13]]["vp"],

			$dataVolumenes[$monthToShow[12]]["vp"],
			$dataVolumenes[$monthToShow[11]]["vp"],
			$dataVolumenes[$monthToShow[10]]["vp"],
			$dataVolumenes[$monthToShow[9]]["vp"],
			$dataVolumenes[$monthToShow[8]]["vp"],
			$dataVolumenes[$monthToShow[7]]["vp"],
			$dataVolumenes[$monthToShow[6]]["vp"],
			$dataVolumenes[$monthToShow[5]]["vp"],
			$dataVolumenes[$monthToShow[4]]["vp"],
			$dataVolumenes[$monthToShow[3]]["vp"],
			$dataVolumenes[$monthToShow[2]]["vp"],
			$dataVolumenes[$monthToShow[1]]["vp"]
		];
		
		$jsonVgp = [
			$dataVolumenes[$monthToShow[12]]["vgp"],
			$dataVolumenes[$monthToShow[11]]["vgp"],
			$dataVolumenes[$monthToShow[10]]["vgp"],
			$dataVolumenes[$monthToShow[9]]["vgp"],
			$dataVolumenes[$monthToShow[8]]["vgp"],
			$dataVolumenes[$monthToShow[7]]["vgp"],
			$dataVolumenes[$monthToShow[6]]["vgp"],
			$dataVolumenes[$monthToShow[5]]["vgp"],
			$dataVolumenes[$monthToShow[16]]["vgp"],
			$dataVolumenes[$monthToShow[15]]["vgp"],
			$dataVolumenes[$monthToShow[14]]["vgp"],
			$dataVolumenes[$monthToShow[13]]["vgp"],

			$dataVolumenes[$monthToShow[12]]["vgp"],
			$dataVolumenes[$monthToShow[11]]["vgp"],
			$dataVolumenes[$monthToShow[10]]["vgp"],
			$dataVolumenes[$monthToShow[9]]["vgp"],
			$dataVolumenes[$monthToShow[8]]["vgp"],
			$dataVolumenes[$monthToShow[7]]["vgp"],
			$dataVolumenes[$monthToShow[6]]["vgp"],
			$dataVolumenes[$monthToShow[5]]["vgp"],
			$dataVolumenes[$monthToShow[4]]["vgp"],
			$dataVolumenes[$monthToShow[3]]["vgp"],
			$dataVolumenes[$monthToShow[2]]["vgp"],
			$dataVolumenes[$monthToShow[1]]["vgp"]
		];
	?>

	<!-- <?php echo json_encode($dataVolumenesVp);?>
	<?php echo json_encode($dataVolumenesVgp);?> -->

	<div class="row mt-4">
		<div class="col text-center">
			<!-- Gráfica Rango de Pago -->
			<canvas id="chart4Graph2" class="w-100" height="430"></canvas>
			<!-- Gráfica Rango de Pago -->
		</div>
	</div>
<!-- Gráficas -->

	<?php 
		$jsonVo = [
			$dataVolumenes[$monthToShow[12]]["vo"],
			$dataVolumenes[$monthToShow[11]]["vo"],
			$dataVolumenes[$monthToShow[10]]["vo"],
			$dataVolumenes[$monthToShow[9]]["vo"],
			$dataVolumenes[$monthToShow[8]]["vo"],
			$dataVolumenes[$monthToShow[7]]["vo"],
			$dataVolumenes[$monthToShow[6]]["vo"],
			$dataVolumenes[$monthToShow[5]]["vo"],
			$dataVolumenes[$monthToShow[16]]["vo"],
			$dataVolumenes[$monthToShow[15]]["vo"],
			$dataVolumenes[$monthToShow[14]]["vo"],
			$dataVolumenes[$monthToShow[13]]["vo"],

			$dataVolumenes[$monthToShow[12]]["vo"],
			$dataVolumenes[$monthToShow[11]]["vo"],
			$dataVolumenes[$monthToShow[10]]["vo"],
			$dataVolumenes[$monthToShow[9]]["vo"],
			$dataVolumenes[$monthToShow[8]]["vo"],
			$dataVolumenes[$monthToShow[7]]["vo"],
			$dataVolumenes[$monthToShow[6]]["vo"],
			$dataVolumenes[$monthToShow[5]]["vo"],
			$dataVolumenes[$monthToShow[4]]["vo"],
			$dataVolumenes[$monthToShow[3]]["vo"],
			$dataVolumenes[$monthToShow[2]]["vo"],
			$dataVolumenes[$monthToShow[1]]["vo"]
		];

		$jsonvoldp = [
			$dataVolumenes[$monthToShow[12]]["voldp"],
			$dataVolumenes[$monthToShow[11]]["voldp"],
			$dataVolumenes[$monthToShow[10]]["voldp"],
			$dataVolumenes[$monthToShow[9]]["voldp"],
			$dataVolumenes[$monthToShow[8]]["voldp"],
			$dataVolumenes[$monthToShow[7]]["voldp"],
			$dataVolumenes[$monthToShow[6]]["voldp"],
			$dataVolumenes[$monthToShow[5]]["voldp"],
			$dataVolumenes[$monthToShow[16]]["voldp"],
			$dataVolumenes[$monthToShow[15]]["voldp"],
			$dataVolumenes[$monthToShow[14]]["voldp"],
			$dataVolumenes[$monthToShow[13]]["voldp"],

			$dataVolumenes[$monthToShow[12]]["voldp"],
			$dataVolumenes[$monthToShow[11]]["voldp"],
			$dataVolumenes[$monthToShow[10]]["voldp"],
			$dataVolumenes[$monthToShow[9]]["voldp"],
			$dataVolumenes[$monthToShow[8]]["voldp"],
			$dataVolumenes[$monthToShow[7]]["voldp"],
			$dataVolumenes[$monthToShow[6]]["voldp"],
			$dataVolumenes[$monthToShow[5]]["voldp"],
			$dataVolumenes[$monthToShow[4]]["voldp"],
			$dataVolumenes[$monthToShow[3]]["voldp"],
			$dataVolumenes[$monthToShow[2]]["voldp"],
			$dataVolumenes[$monthToShow[1]]["voldp"]
		];

		$jsonvoldpys = [
			$dataVolumenes[$monthToShow[12]]["voldpys"],
			$dataVolumenes[$monthToShow[11]]["voldpys"],
			$dataVolumenes[$monthToShow[10]]["voldpys"],
			$dataVolumenes[$monthToShow[9]]["voldpys"],
			$dataVolumenes[$monthToShow[8]]["voldpys"],
			$dataVolumenes[$monthToShow[7]]["voldpys"],
			$dataVolumenes[$monthToShow[6]]["voldpys"],
			$dataVolumenes[$monthToShow[5]]["voldpys"],
			$dataVolumenes[$monthToShow[16]]["voldpys"],
			$dataVolumenes[$monthToShow[15]]["voldpys"],
			$dataVolumenes[$monthToShow[14]]["voldpys"],
			$dataVolumenes[$monthToShow[13]]["voldpys"],

			$dataVolumenes[$monthToShow[12]]["voldpys"],
			$dataVolumenes[$monthToShow[11]]["voldpys"],
			$dataVolumenes[$monthToShow[10]]["voldpys"],
			$dataVolumenes[$monthToShow[9]]["voldpys"],
			$dataVolumenes[$monthToShow[8]]["voldpys"],
			$dataVolumenes[$monthToShow[7]]["voldpys"],
			$dataVolumenes[$monthToShow[6]]["voldpys"],
			$dataVolumenes[$monthToShow[5]]["voldpys"],
			$dataVolumenes[$monthToShow[4]]["voldpys"],
			$dataVolumenes[$monthToShow[3]]["voldpys"],
			$dataVolumenes[$monthToShow[2]]["voldpys"],
			$dataVolumenes[$monthToShow[1]]["voldpys"]
		];
	?>

<div class="table-responsive mt-4">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1">POINTS</th>
				<th scope="col"><span id="txtMont1"><?php echo $shortMonthYear[$monthToShow[12]] ?></span></th>
				<th scope="col"><span id="txtMont2"><?php echo $shortMonthYear[$monthToShow[11]] ?></span></th>
				<th scope="col"><span id="txtMont3"><?php echo $shortMonthYear[$monthToShow[10]] ?></span></th>
				<th scope="col"><span id="txtMont4"><?php echo $shortMonthYear[$monthToShow[9]] ?></span></th>
				<th scope="col"><span id="txtMont5"><?php echo $shortMonthYear[$monthToShow[8]] ?></span></th>
				<th scope="col"><span id="txtMont6"><?php echo $shortMonthYear[$monthToShow[7]] ?></span></th>
				<th scope="col"><span id="txtMont7"><?php echo $shortMonthYear[$monthToShow[6]] ?></span></th>
				<th scope="col"><span id="txtMont8"><?php echo $shortMonthYear[$monthToShow[5]] ?></span></th>
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
				<th scope="col" class="c-mw-2">Average 24<br/>Months</th>
			</tr>
		</thead>

		<tbody>
			<!-- VP (Volumen Personal) -->
				<tr>
					<th scope="row">PPV Personal Point Volume</th>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[16]]) ? number_format($dataVolumenes[$monthToShow[16]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[15]]) ? number_format($dataVolumenes[$monthToShow[15]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[14]]) ? number_format($dataVolumenes[$monthToShow[14]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[13]]) ? number_format($dataVolumenes[$monthToShow[13]]["vp"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[4]]) ? number_format($dataVolumenes[$monthToShow[4]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[3]]) ? number_format($dataVolumenes[$monthToShow[3]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[2]]) ? number_format($dataVolumenes[$monthToShow[2]]["vp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[1]]) ? number_format($dataVolumenes[$monthToShow[1]]["vp"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataVolumenes[$monthToShow[12]]["vp"];
						$total += $dataVolumenes[$monthToShow[11]]["vp"];
						$total += $dataVolumenes[$monthToShow[10]]["vp"];
						$total += $dataVolumenes[$monthToShow[9]]["vp"];
						$total += $dataVolumenes[$monthToShow[8]]["vp"];
						$total += $dataVolumenes[$monthToShow[7]]["vp"];
						$total += $dataVolumenes[$monthToShow[6]]["vp"];
						$total += $dataVolumenes[$monthToShow[5]]["vp"];
						$total += $dataVolumenes[$monthToShow[16]]["vp"];
						$total += $dataVolumenes[$monthToShow[15]]["vp"];
						$total += $dataVolumenes[$monthToShow[14]]["vp"];
						$total += $dataVolumenes[$monthToShow[13]]["vp"];

						$total += $dataVolumenes[$monthToShow[12]]["vp"];
						$total += $dataVolumenes[$monthToShow[11]]["vp"];
						$total += $dataVolumenes[$monthToShow[10]]["vp"];
						$total += $dataVolumenes[$monthToShow[9]]["vp"];
						$total += $dataVolumenes[$monthToShow[8]]["vp"];
						$total += $dataVolumenes[$monthToShow[7]]["vp"];
						$total += $dataVolumenes[$monthToShow[6]]["vp"];
						$total += $dataVolumenes[$monthToShow[5]]["vp"];
						$total += $dataVolumenes[$monthToShow[4]]["vp"];
						$total += $dataVolumenes[$monthToShow[3]]["vp"];
						$total += $dataVolumenes[$monthToShow[2]]["vp"];
						$total += $dataVolumenes[$monthToShow[1]]["vp"];

						echo number_format($total / 24, 2);

						?>
					</td>
				</tr>
			<!-- VP (Volumen Personal) -->

			<!-- VGP (Volumen Grupo Personal) -->
				<tr>
					<th scope="row">PGPV Personal Group Point Volume</th>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[16]]) ? number_format($dataVolumenes[$monthToShow[16]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[15]]) ? number_format($dataVolumenes[$monthToShow[15]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[14]]) ? number_format($dataVolumenes[$monthToShow[14]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[13]]) ? number_format($dataVolumenes[$monthToShow[13]]["vgp"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[4]]) ? number_format($dataVolumenes[$monthToShow[4]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[3]]) ? number_format($dataVolumenes[$monthToShow[3]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[2]]) ? number_format($dataVolumenes[$monthToShow[2]]["vgp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[1]]) ? number_format($dataVolumenes[$monthToShow[1]]["vgp"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						
						$total += $dataVolumenes[$monthToShow[12]]["vgp"];
						$total += $dataVolumenes[$monthToShow[11]]["vgp"];
						$total += $dataVolumenes[$monthToShow[10]]["vgp"];
						$total += $dataVolumenes[$monthToShow[9]]["vgp"];
						$total += $dataVolumenes[$monthToShow[8]]["vgp"];
						$total += $dataVolumenes[$monthToShow[7]]["vgp"];
						$total += $dataVolumenes[$monthToShow[6]]["vgp"];
						$total += $dataVolumenes[$monthToShow[5]]["vgp"];
						$total += $dataVolumenes[$monthToShow[16]]["vgp"];
						$total += $dataVolumenes[$monthToShow[15]]["vgp"];
						$total += $dataVolumenes[$monthToShow[14]]["vgp"];
						$total += $dataVolumenes[$monthToShow[13]]["vgp"];

						$total += $dataVolumenes[$monthToShow[12]]["vgp"];
						$total += $dataVolumenes[$monthToShow[11]]["vgp"];
						$total += $dataVolumenes[$monthToShow[10]]["vgp"];
						$total += $dataVolumenes[$monthToShow[9]]["vgp"];
						$total += $dataVolumenes[$monthToShow[8]]["vgp"];
						$total += $dataVolumenes[$monthToShow[7]]["vgp"];
						$total += $dataVolumenes[$monthToShow[6]]["vgp"];
						$total += $dataVolumenes[$monthToShow[5]]["vgp"];
						$total += $dataVolumenes[$monthToShow[4]]["vgp"];
						$total += $dataVolumenes[$monthToShow[3]]["vgp"];
						$total += $dataVolumenes[$monthToShow[2]]["vgp"];
						$total += $dataVolumenes[$monthToShow[1]]["vgp"];

						echo number_format($total / 24, 2);

						?>
					</td>
				</tr>
			<!-- VGP (Volumen Grupo Personal) -->

			<!-- VO (Volumen Organizacional) -->
				<tr>
					<th scope="row">OPV Organizational Point Volume</th>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[16]]) ? number_format($dataVolumenes[$monthToShow[16]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[15]]) ? number_format($dataVolumenes[$monthToShow[15]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[14]]) ? number_format($dataVolumenes[$monthToShow[14]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[13]]) ? number_format($dataVolumenes[$monthToShow[13]]["vo"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[4]]) ? number_format($dataVolumenes[$monthToShow[4]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[3]]) ? number_format($dataVolumenes[$monthToShow[3]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[2]]) ? number_format($dataVolumenes[$monthToShow[2]]["vo"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[1]]) ? number_format($dataVolumenes[$monthToShow[1]]["vo"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataVolumenes[$monthToShow[12]]["vo"];
						$total += $dataVolumenes[$monthToShow[11]]["vo"];
						$total += $dataVolumenes[$monthToShow[10]]["vo"];
						$total += $dataVolumenes[$monthToShow[9]]["vo"];
						$total += $dataVolumenes[$monthToShow[8]]["vo"];
						$total += $dataVolumenes[$monthToShow[7]]["vo"];
						$total += $dataVolumenes[$monthToShow[6]]["vo"];
						$total += $dataVolumenes[$monthToShow[5]]["vo"];
						$total += $dataVolumenes[$monthToShow[16]]["vo"];
						$total += $dataVolumenes[$monthToShow[15]]["vo"];
						$total += $dataVolumenes[$monthToShow[14]]["vo"];
						$total += $dataVolumenes[$monthToShow[13]]["vo"];

						$total += $dataVolumenes[$monthToShow[12]]["vo"];
						$total += $dataVolumenes[$monthToShow[11]]["vo"];
						$total += $dataVolumenes[$monthToShow[10]]["vo"];
						$total += $dataVolumenes[$monthToShow[9]]["vo"];
						$total += $dataVolumenes[$monthToShow[8]]["vo"];
						$total += $dataVolumenes[$monthToShow[7]]["vo"];
						$total += $dataVolumenes[$monthToShow[6]]["vo"];
						$total += $dataVolumenes[$monthToShow[5]]["vo"];
						$total += $dataVolumenes[$monthToShow[4]]["vo"];
						$total += $dataVolumenes[$monthToShow[3]]["vo"];
						$total += $dataVolumenes[$monthToShow[2]]["vo"];
						$total += $dataVolumenes[$monthToShow[1]]["vo"];

						echo number_format($total / 24, 2);

						?>
					</td>
				</tr>
			<!-- VO (Volumen Organizacional) -->

			<!-- VO-LDP (Volumen Organizacional Línea Diferente a la Primaria) -->
				<tr>
					<th scope="row">OPV-OPL Organizational Point Volume Outside Primary Leg</th>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[16]]) ? number_format($dataVolumenes[$monthToShow[16]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[15]]) ? number_format($dataVolumenes[$monthToShow[15]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[14]]) ? number_format($dataVolumenes[$monthToShow[14]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[13]]) ? number_format($dataVolumenes[$monthToShow[13]]["voldp"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[4]]) ? number_format($dataVolumenes[$monthToShow[4]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[3]]) ? number_format($dataVolumenes[$monthToShow[3]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[2]]) ? number_format($dataVolumenes[$monthToShow[2]]["voldp"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[1]]) ? number_format($dataVolumenes[$monthToShow[1]]["voldp"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataVolumenes[$monthToShow[12]]["voldp"];
						$total += $dataVolumenes[$monthToShow[11]]["voldp"];
						$total += $dataVolumenes[$monthToShow[10]]["voldp"];
						$total += $dataVolumenes[$monthToShow[9]]["voldp"];
						$total += $dataVolumenes[$monthToShow[8]]["voldp"];
						$total += $dataVolumenes[$monthToShow[7]]["voldp"];
						$total += $dataVolumenes[$monthToShow[6]]["voldp"];
						$total += $dataVolumenes[$monthToShow[5]]["voldp"];
						$total += $dataVolumenes[$monthToShow[16]]["voldp"];
						$total += $dataVolumenes[$monthToShow[15]]["voldp"];
						$total += $dataVolumenes[$monthToShow[14]]["voldp"];
						$total += $dataVolumenes[$monthToShow[13]]["voldp"];

						$total += $dataVolumenes[$monthToShow[12]]["voldp"];
						$total += $dataVolumenes[$monthToShow[11]]["voldp"];
						$total += $dataVolumenes[$monthToShow[10]]["voldp"];
						$total += $dataVolumenes[$monthToShow[9]]["voldp"];
						$total += $dataVolumenes[$monthToShow[8]]["voldp"];
						$total += $dataVolumenes[$monthToShow[7]]["voldp"];
						$total += $dataVolumenes[$monthToShow[6]]["voldp"];
						$total += $dataVolumenes[$monthToShow[5]]["voldp"];
						$total += $dataVolumenes[$monthToShow[4]]["voldp"];
						$total += $dataVolumenes[$monthToShow[3]]["voldp"];
						$total += $dataVolumenes[$monthToShow[2]]["voldp"];
						$total += $dataVolumenes[$monthToShow[1]]["voldp"];

						echo number_format($total / 24, 2);

						?>
					</td>
				</tr>
			<!-- VO-LDP (Volumen Organizacional Línea Diferente a la Primaria) -->

			<!-- VO-LDPYS (Volumen Organizacional Línea Diferente a la Primaria y Secundaria) -->
				<tr>
					<th scope="row">OPV-OP&SL Organizational Point Volume Outside<br> Primary & Secondary Leg Leg</th>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[16]]) ? number_format($dataVolumenes[$monthToShow[16]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[15]]) ? number_format($dataVolumenes[$monthToShow[15]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[14]]) ? number_format($dataVolumenes[$monthToShow[14]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[13]]) ? number_format($dataVolumenes[$monthToShow[13]]["voldpys"], 0) : 0 ?></td>

					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[12]]) ? number_format($dataVolumenes[$monthToShow[12]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[11]]) ? number_format($dataVolumenes[$monthToShow[11]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[10]]) ? number_format($dataVolumenes[$monthToShow[10]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[9]]) ? number_format($dataVolumenes[$monthToShow[9]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[8]]) ? number_format($dataVolumenes[$monthToShow[8]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[7]]) ? number_format($dataVolumenes[$monthToShow[7]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[6]]) ? number_format($dataVolumenes[$monthToShow[6]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[5]]) ? number_format($dataVolumenes[$monthToShow[5]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[4]]) ? number_format($dataVolumenes[$monthToShow[4]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[3]]) ? number_format($dataVolumenes[$monthToShow[3]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[2]]) ? number_format($dataVolumenes[$monthToShow[2]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center"><?php echo isset($dataVolumenes[$monthToShow[1]]) ? number_format($dataVolumenes[$monthToShow[1]]["voldpys"], 0) : 0 ?></td>
					<td class="text-center">
						<?php

						$total = 0;

						$total += $dataVolumenes[$monthToShow[12]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[11]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[10]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[9]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[8]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[7]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[6]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[5]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[16]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[15]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[14]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[13]]["voldpys"];

						$total += $dataVolumenes[$monthToShow[12]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[11]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[10]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[9]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[8]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[7]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[6]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[5]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[4]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[3]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[2]]["voldpys"];
						$total += $dataVolumenes[$monthToShow[1]]["voldpys"];

						echo number_format($total / 24, 2);

						?>
					</td>
				</tr>
			<!-- VO-LDPYS (Volumen Organizacional Línea Diferente a la Primaria y Secundaria) -->
		</tbody>
	</table>
</div>

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 11;
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

	//Gráfica Volúmenes
		var chart4Graph1 = document.getElementById('chart4Graph1').getContext('2d');
		var chart4Graph1Detail = new Chart(chart4Graph1, {
		    type: 'line',
		    data: {
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: 'PPV',
			            data: <?php echo json_encode($jsonVp) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: 'PGPV',
			            data: <?php echo json_encode($jsonVgp) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        }
		        ]
		    },
		    options: { responsive: false }
		});
	//Gráfica Volúmenes

	//Gráfica Volúmenes
		var chart4Graph2 = document.getElementById('chart4Graph2').getContext('2d');
		var chart4Graph2Detail = new Chart(chart4Graph2, {
		    type: 'line',
		    data: {
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: 'OPV',
			            data: <?php echo json_encode($jsonVo) ?>,
			            backgroundColor: [ 'rgba(220, 123, 79, 1)', ],
			            borderColor: [ 'rgba(220, 123, 79, 1)', ],
			        },
			        {
			            label: 'OPV-OPL',
			            data: <?php echo json_encode($jsonvoldp) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        },
			        {
			            label: 'OPV-OP&SL',
			            data: <?php echo json_encode($jsonvoldpys) ?>,
			            backgroundColor: [ 'rgba(241, 185, 42, 1)', ],
			            borderColor: [ 'rgba(241, 185, 42, 1)', ],
			        }
		        ]
		    },
		    options: { responsive: false }
		});
	//Gráfica Volúmenes

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>
