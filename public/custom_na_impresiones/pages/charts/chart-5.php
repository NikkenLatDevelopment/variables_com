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

<hr>
<span id="txtMont1"><?php echo $shortMonthYear[$monthToShow[24]] ?></span>
<span id="txtMont2"><?php echo $shortMonthYear[$monthToShow[23]] ?></span>
<span id="txtMont3"><?php echo $shortMonthYear[$monthToShow[22]] ?></span>
<span id="txtMont4"><?php echo $shortMonthYear[$monthToShow[21]] ?></span>
<span id="txtMont5"><?php echo $shortMonthYear[$monthToShow[20]] ?></span>
<span id="txtMont6"><?php echo $shortMonthYear[$monthToShow[19]] ?></span>
<span id="txtMont7"><?php echo $shortMonthYear[$monthToShow[18]] ?></span>
<span id="txtMont8"><?php echo $shortMonthYear[$monthToShow[17]] ?></span>
<span id="txtMont9"><?php echo $shortMonthYear[$monthToShow[16]] ?></span>
<span id="txtMont10"><?php echo $shortMonthYear[$monthToShow[15]] ?></span>
<span id="txtMont11"><?php echo $shortMonthYear[$monthToShow[14]] ?></span>
<span id="txtMont12"><?php echo $shortMonthYear[$monthToShow[13]] ?></span>

<span id="txtMont13"><?php echo $shortMonthYear[$monthToShow[12]] ?></span>
<span id="txtMont14"><?php echo $shortMonthYear[$monthToShow[11]] ?></span>
<span id="txtMont15"><?php echo $shortMonthYear[$monthToShow[10]] ?></span>
<span id="txtMont16"><?php echo $shortMonthYear[$monthToShow[9]] ?></span>
<span id="txtMont17"><?php echo $shortMonthYear[$monthToShow[8]] ?></span>
<span id="txtMont18"><?php echo $shortMonthYear[$monthToShow[7]] ?></span>
<span id="txtMont19"><?php echo $shortMonthYear[$monthToShow[6]] ?></span>
<span id="txtMont20"><?php echo $shortMonthYear[$monthToShow[5]] ?></span>
<span id="txtMont21"><?php echo $shortMonthYear[$monthToShow[4]] ?></span>
<span id="txtMont22"><?php echo $shortMonthYear[$monthToShow[3]] ?></span>
<span id="txtMont23"><?php echo $shortMonthYear[$monthToShow[2]] ?></span>
<span id="txtMont24"><?php echo $shortMonthYear[$monthToShow[1]] ?></span>

<?php echo $periodoPost ?>

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
