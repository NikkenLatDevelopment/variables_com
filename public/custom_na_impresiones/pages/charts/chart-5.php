<?php require_once("../../functions.php"); //Funciones

$prod = $_POST["prod"];

if(trim($prod) === 'NO'){
	$serverName75 = "172.24.16.75";
}
else{
	$serverName75 = "104.130.46.73";
}

$connectionInfo75 = array("Database" => "LAT_MyNIKKEN", "UID" => "Latamti", "PWD" => "N1k3N$17!");
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
$dataBonificaciones = array();
$dataBonificacionesRetail = array();
$dataBonificacionesRebate = array();
$dataBonificacionesOveride = array();
$dataBonificacionesLeadership = array();
$dataBonificacionesClub = array();
$dataBonificacionesAhlsb = array();
$dataBonificacionesPi = array();
// $dataBonificacionesSuma = array();

$dataBonificacionespersonal = array();
$dataBonificacionesleadership_bonus = array();
$dataBonificacionesretail_bonus = array();
$dataBonificacionespib_bonus = array();
$dataBonificacioneswe_acelerate_bonus = array();
$dataBonificacioneslifestyle_bonus = array();
$dataBonificacionessuma = array();
//Others

//Consulta
	// $sql = "EXEC Bonificaciones_SD_usa $codeUser, $periodoPost";
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.varCom_bonificaciones_usa_24m $codeUser, $periodoPost;";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$monthToShow = [];
	$x = 0;
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$periodo = trim($rowSap[11]);
		$rangoPago = trim($rowSap[1]);
		$rangoActual = trim($rowSap[2]);

		$personal = trim($rowSap[3]);
		$leadership_bonus = trim($rowSap[4]);
		$retail_bonus = trim($rowSap[5]);
		$pib_bonus = trim($rowSap[6]);
		$we_acelerate_bonus = trim($rowSap[7]);
		$lifestyle_bonus = trim($rowSap[8]);
		$suma = trim($rowSap[9]);

		// $retail = trim($rowSap[3]);
		// // $rebate = trim($rowSap[4]);
		// // $overide = trim($rowSap[5]);
		// $leadership = trim($rowSap[4]);
		// $club = trim($rowSap[5]);
		// $ahlsb = trim($rowSap[8]);
		// // $pi = trim($rowSap[9]);
		// $suma = trim($rowSap[9]);

		$periodotoShow = trim($rowSap[11]);
		$x++;
		$monthToShow[$x] = trim($rowSap[11]);

		//Guardar datos en array
		$dataBonificaciones[$periodo] = array(
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
	}

	//Cerrar conexión
	sqlsrv_close($conn75);
	//Cerrar conexión
//Consulta

//Graficas
	$count = 0;

	//Periodo inicial de consulta
	$periodoIni = strval($periodMonthsByGraph[$monthToShow[24]]);
	$period = new DateTime("$periodoIni");
	//Periodo inicial de consulta

	while($count < 24){
		$periodQuery = $period->format('Ym');
		
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["personal"] : 0;
		$dataBonificacionespersonal = array_merge($dataBonificacionespersonal, array($price));

		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["leadership_bonus"] : 0;
		$dataBonificacionesleadership_bonus = array_merge($dataBonificacionesleadership_bonus, array($price));

		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["retail_bonus"] : 0;
		$dataBonificacionesretail_bonus = array_merge($dataBonificacionesretail_bonus, array($price));

		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["pib_bonus"] : 0;
		$dataBonificacionespib_bonus = array_merge($dataBonificacionespib_bonus, array($price));

		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["we_acelerate_bonus"] : 0;
		$dataBonificacioneswe_acelerate_bonus = array_merge($dataBonificacioneswe_acelerate_bonus, array($price));

		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["lifestyle_bonus"] : 0;
		$dataBonificacioneslifestyle_bonus = array_merge($dataBonificacioneslifestyle_bonus, array($price));

		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["suma"] : 0;
		$dataBonificacionessuma = array_merge($dataBonificacionessuma, array($price));

		//Guardar retail
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["retail"] : 0;
		// $dataBonificacionesRetail = array_merge($dataBonificacionesRetail, array($price));
		//Guardar retail

		//Guardar rebate
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["rebate"] : 0;
		// $dataBonificacionesRebate = array_merge($dataBonificacionesRebate, array($price));
		//Guardar rebate

		//Guardar override
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["overide"] : 0;
		// $dataBonificacionesOveride = array_merge($dataBonificacionesOveride, array($price));
		//Guardar override

		//Guardar leadership
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["leadership"] : 0;
		// $dataBonificacionesLeadership = array_merge($dataBonificacionesLeadership, array($price));
		//Guardar leadership

		//Guardar club
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["club"] : 0;
		// $dataBonificacionesClub = array_merge($dataBonificacionesClub, array($price));
		//Guardar club

		//Guardar ahlsb
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["ahlsb"] : 0;
		// $dataBonificacionesAhlsb = array_merge($dataBonificacionesAhlsb, array($price));
		//Guardar ahlsb

		//Guardar pi
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["pi"] : 0;
		// $dataBonificacionesPi = array_merge($dataBonificacionesPi, array($price));
		//Guardar pi

		//Guardar suma
		// $price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["suma"] : 0;
		// $dataBonificacionesSuma = array_merge($dataBonificacionesSuma, array($price));
		//Guardar suma

	    //Cambiar a periodo siguiente
		$period->modify('+1 month');
		$period = $period->format('Y-m-01');
		$period = new DateTime($period);
		//Cambiar a periodo siguiente

		$count++;
	}
//Graficas

// echo "monthToShow: <br><pre>"; print_r($monthToShow); echo "</pre>"; 

?>

<!-- Mostrar logo -->
<img src="https://mi.nikkenlatam.com/custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Business Variables Report By Consultant</div>
			<div class="h6 mb-0"><span class="fw-bold">Measurement Period:</span> September 2023 to August 2025</div>
			<div class="h6"><span class="fw-bold">Country:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">ID:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold">Rank:</span> <?php echo $rangos_usa[$rankUser] ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica bonificaciones -->
			<canvas id="chart5Graph1" class="w-100" height="1190"></canvas>
			<!-- Gráfica bonificaciones -->
		</div>
	</div>
<!-- Gráficas -->

<input hidden id="txtMont1_chart5" value="<?php echo $shortMonthYear[$monthToShow[24]] ?>" type="text">
<input hidden id="txtMont2_chart5" value="<?php echo $shortMonthYear[$monthToShow[23]] ?>" type="text">
<input hidden id="txtMont3_chart5" value="<?php echo $shortMonthYear[$monthToShow[22]] ?>" type="text">
<input hidden id="txtMont4_chart5" value="<?php echo $shortMonthYear[$monthToShow[21]] ?>" type="text">
<input hidden id="txtMont5_chart5" value="<?php echo $shortMonthYear[$monthToShow[20]] ?>" type="text">
<input hidden id="txtMont6_chart5" value="<?php echo $shortMonthYear[$monthToShow[19]] ?>" type="text">
<input hidden id="txtMont7_chart5" value="<?php echo $shortMonthYear[$monthToShow[18]] ?>" type="text">
<input hidden id="txtMont8_chart5" value="<?php echo $shortMonthYear[$monthToShow[17]] ?>" type="text">
<input hidden id="txtMont9_chart5" value="<?php echo $shortMonthYear[$monthToShow[16]] ?>" type="text">
<input hidden id="txtMont10_chart5" value="<?php echo $shortMonthYear[$monthToShow[15]] ?>" type="text">
<input hidden id="txtMont11_chart5" value="<?php echo $shortMonthYear[$monthToShow[14]] ?>" type="text">
<input hidden id="txtMont12_chart5" value="<?php echo $shortMonthYear[$monthToShow[13]] ?>" type="text">

<input hidden id="txtMont13_chart5" value="<?php echo $shortMonthYear[$monthToShow[12]] ?>" type="text">
<input hidden id="txtMont14_chart5" value="<?php echo $shortMonthYear[$monthToShow[11]] ?>" type="text">
<input hidden id="txtMont15_chart5" value="<?php echo $shortMonthYear[$monthToShow[10]] ?>" type="text">
<input hidden id="txtMont16_chart5" value="<?php echo $shortMonthYear[$monthToShow[9]] ?>" type="text">
<input hidden id="txtMont17_chart5" value="<?php echo $shortMonthYear[$monthToShow[8]] ?>" type="text">
<input hidden id="txtMont18_chart5" value="<?php echo $shortMonthYear[$monthToShow[7]] ?>" type="text">
<input hidden id="txtMont19_chart5" value="<?php echo $shortMonthYear[$monthToShow[6]] ?>" type="text">
<input hidden id="txtMont20_chart5" value="<?php echo $shortMonthYear[$monthToShow[5]] ?>" type="text">
<input hidden id="txtMont21_chart5" value="<?php echo $shortMonthYear[$monthToShow[4]] ?>" type="text">
<input hidden id="txtMont22_chart5" value="<?php echo $shortMonthYear[$monthToShow[3]] ?>" type="text">
<input hidden id="txtMont23_chart5" value="<?php echo $shortMonthYear[$monthToShow[2]] ?>" type="text">
<input hidden id="txtMont24_chart5" value="<?php echo $shortMonthYear[$monthToShow[1]] ?>" type="text">

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica

	txtMont1 = $("#txtMont1_chart5").val();
	txtMont2 = $("#txtMont2_chart5").val();
	txtMont3 = $("#txtMont3_chart5").val();
	txtMont4 = $("#txtMont4_chart5").val();
	txtMont5 = $("#txtMont5_chart5").val();
	txtMont6 = $("#txtMont6_chart5").val();
	txtMont7 = $("#txtMont7_chart5").val();
	txtMont8 = $("#txtMont8_chart5").val();
	txtMont9 = $("#txtMont9_chart5").val();
	txtMont10 = $("#txtMont10_chart5").val();
	txtMont10 = $("#txtMont10_chart5").val();
	txtMont11 = $("#txtMont11_chart5").val();
	txtMont12 = $("#txtMont12_chart5").val();

	txtMont13 = $("#txtMont13_chart5").val();
	txtMont14 = $("#txtMont14_chart5").val();
	txtMont15 = $("#txtMont15_chart5").val();
	txtMont16 = $("#txtMont16_chart5").val();
	txtMont17 = $("#txtMont17_chart5").val();
	txtMont18 = $("#txtMont18_chart5").val();
	txtMont19 = $("#txtMont19_chart5").val();
	txtMont20 = $("#txtMont20_chart5").val();
	txtMont21 = $("#txtMont21_chart5").val();
	txtMont22 = $("#txtMont22_chart5").val();
	txtMont23 = $("#txtMont23_chart5").val();
	txtMont24 = $("#txtMont24_chart5").val();

	//Gráfica bonificaciones
		var chart5Graph1 = document.getElementById('chart5Graph1').getContext('2d');
		var chart5Graph1Detail = new Chart(chart5Graph1, {
		    type: 'bar',
		    data: {
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            // label: 'Personal Bonus',
			            label: 'Personal Rebate and Override Bonus',
			            data: <?php echo json_encode($dataBonificacionespersonal) ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            borderColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            type: 'line',
			            yAxisID: 'y1',
			        },
			        {
			            // label: 'Leadership Bonus',
			            label: 'Leadership Bonus',
			            data: <?php echo json_encode($dataBonificacionesleadership_bonus) ?>,
			            backgroundColor: [ 'rgba(109, 85, 125, 0.8)', ],
			            borderColor: [ 'rgba(109, 85, 125, 0.8)', ],
			        },
			        {
			            // label: 'Retail Bonus',
			            label: 'Retail Bonus',
			            data: <?php echo json_encode($dataBonificacionesretail_bonus) ?>,
			            backgroundColor: [ 'rgba(54, 162, 235, 0.8)', ],
			            borderColor: [ 'rgba(54, 162, 235, 0.8)', ],
			        },
			        // {
			        //     // label: 'PIB Bonus',
			        //     label: 'PIB Bonus',
			        //     data: <?php echo json_encode($dataBonificacionespib_bonus) ?>,
			        //     backgroundColor: [ 'rgba(75, 192, 192, 0.8)', ],
			        //     borderColor: [ 'rgba(75, 192, 192, 0.8)', ],
			        // },
			        {
			            // label: 'WE Acelerate Bonus',
			            label: 'WE Acelerate Bonus',
			            data: <?php echo json_encode($dataBonificacioneswe_acelerate_bonus) ?>,
			            backgroundColor: [ 'rgba(213, 229, 178, 0.8)', ],
			            borderColor: [ 'rgba(213, 229, 178, 0.8)', ],
			        },
			        {
			            // label: 'Lifestyle Bonus',
			            label: 'Lifestyle Bonus',
			            data: <?php echo json_encode($dataBonificacioneslifestyle_bonus) ?>,
			            backgroundColor: [ 'rgba(154, 181, 194, 0.8)', ],
			            borderColor: [ 'rgba(154, 181, 194, 0.8)', ],
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
		    	scales: {
		    		x: {
						stacked: true,
					},
					y: {
						display: false,
						stacked: true,
						position: 'left',
						title: {
				          	display: true,
				          	text: '%'
				        },
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
						title: {
				          	display: true,
				          	text: 'USD'
				        },
					},
				}
			},
		});
	//Gráfica bonificaciones

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>
