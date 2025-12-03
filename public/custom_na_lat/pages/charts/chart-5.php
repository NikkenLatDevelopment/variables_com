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
$periodoPost = $_POST["periodo"];
//Vars

$rankUser = $rangos_usa[$rankUser];

//Others
$dataBonificaciones = array();
$dataBonificacionesRetail = array();
$dataBonificacionesRebate = array();
$dataBonificacionesOveride = array();
$dataBonificacionesLeadership = array();
$dataBonificacionesClub = array();
$dataBonificacionesAhlsb = array();
$dataBonificacionesPi = array();
$dataBonificacionesSuma = array();
//Others

//Consulta
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Bonificaciones_SD $codeUser, $periodoPost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$monthToShow = [];
	$x = 0;
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

		$periodotoShow = trim($rowSap[12]);
		$x++;
		$monthToShow[$x] = $rowSap[12];

		//Guardar datos en array
		$dataBonificaciones[$periodo] = array("rangoPago" => $rangoPago, "rangoActual" => $rangoActual, "retail" => $retail, "rebate" => $rebate, "overide" => $overide, "leadership" => $leadership, "club" => $club, "ahlsb" => $ahlsb, "pi" => $pi, "suma" => $suma);
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

		//Guardar retail
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["retail"] : 0;
		$dataBonificacionesRetail = array_merge($dataBonificacionesRetail, array($price));
		//Guardar retail

		//Guardar rebate
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["rebate"] : 0;
		$dataBonificacionesRebate = array_merge($dataBonificacionesRebate, array($price));
		//Guardar rebate

		//Guardar override
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["overide"] : 0;
		$dataBonificacionesOveride = array_merge($dataBonificacionesOveride, array($price));
		//Guardar override

		//Guardar leadership
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["leadership"] : 0;
		$dataBonificacionesLeadership = array_merge($dataBonificacionesLeadership, array($price));
		//Guardar leadership

		//Guardar club
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["club"] : 0;
		$dataBonificacionesClub = array_merge($dataBonificacionesClub, array($price));
		//Guardar club

		//Guardar ahlsb
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["ahlsb"] : 0;
		$dataBonificacionesAhlsb = array_merge($dataBonificacionesAhlsb, array($price));
		//Guardar ahlsb

		//Guardar pi
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["pi"] : 0;
		$dataBonificacionesPi = array_merge($dataBonificacionesPi, array($price));
		//Guardar pi

		//Guardar suma
		$price = isset($dataBonificaciones[$periodQuery]) ? $dataBonificaciones[$periodQuery]["suma"] : 0;
		$dataBonificacionesSuma = array_merge($dataBonificacionesSuma, array($price));
		//Guardar suma

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
			<div class="h6 mb-0"><span class="fw-bold">Measurement Period:September 2022 to August 2024</div>
			<div class="h6"><span class="fw-bold">Country:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<!-- <div class="h6 mb-0"><span class="fw-bold">Code:</span> 5863024600</div> -->
			<div class="h6"><span class="fw-bold">Rank:</span> <?php echo $rankUser ?></div>
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

<span hidden id="txtMont1"><?php echo $shortMonthYear[$monthToShow[24]] ?></span>
<span hidden id="txtMont2"><?php echo $shortMonthYear[$monthToShow[23]] ?></span>
<span hidden id="txtMont3"><?php echo $shortMonthYear[$monthToShow[22]] ?></span>
<span hidden id="txtMont4"><?php echo $shortMonthYear[$monthToShow[21]] ?></span>
<span hidden id="txtMont5"><?php echo $shortMonthYear[$monthToShow[20]] ?></span>
<span hidden id="txtMont6"><?php echo $shortMonthYear[$monthToShow[19]] ?></span>
<span hidden id="txtMont7"><?php echo $shortMonthYear[$monthToShow[18]] ?></span>
<span hidden id="txtMont8"><?php echo $shortMonthYear[$monthToShow[17]] ?></span>
<span hidden id="txtMont9"><?php echo $shortMonthYear[$monthToShow[16]] ?></span>
<span hidden id="txtMont10"><?php echo $shortMonthYear[$monthToShow[15]] ?></span>
<span hidden id="txtMont11"><?php echo $shortMonthYear[$monthToShow[14]] ?></span>
<span hidden id="txtMont12"><?php echo $shortMonthYear[$monthToShow[13]] ?></span>
<span hidden id="txtMont13"><?php echo $shortMonthYear[$monthToShow[12]] ?></span>
<span hidden id="txtMont14"><?php echo $shortMonthYear[$monthToShow[11]] ?></span>
<span hidden id="txtMont15"><?php echo $shortMonthYear[$monthToShow[10]] ?></span>
<span hidden id="txtMont16"><?php echo $shortMonthYear[$monthToShow[9]] ?></span>
<span hidden id="txtMont17"><?php echo $shortMonthYear[$monthToShow[8]] ?></span>
<span hidden id="txtMont18"><?php echo $shortMonthYear[$monthToShow[7]] ?></span>
<span hidden id="txtMont19"><?php echo $shortMonthYear[$monthToShow[6]] ?></span>
<span hidden id="txtMont20"><?php echo $shortMonthYear[$monthToShow[5]] ?></span>
<span hidden id="txtMont21"><?php echo $shortMonthYear[$monthToShow[4]] ?></span>
<span hidden id="txtMont22"><?php echo $shortMonthYear[$monthToShow[3]] ?></span>
<span hidden id="txtMont23"><?php echo $shortMonthYear[$monthToShow[2]] ?></span>
<span hidden id="txtMont24"><?php echo $shortMonthYear[$monthToShow[1]] ?></span>

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

	//Gráfica bonificaciones
		var chart5Graph1 = document.getElementById('chart5Graph1').getContext('2d');
		var chart5Graph1Detail = new Chart(chart5Graph1, {
		    type: 'bar',
		    data: {
		        labels: [txtMont1, txtMont2, txtMont3, txtMont4, txtMont5, txtMont6, txtMont7, txtMont8, txtMont9, txtMont10, txtMont11, txtMont12, txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: 'Monthly Personal Check - Does Not Include Discounts (Dollars)',
			            data: <?php echo json_encode($dataBonificacionesSuma) ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            borderColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            type: 'line',
			            yAxisID: 'y1',
			        },
			        {
			            label: 'Earnings at Suggested Price',
			            data: <?php echo json_encode($dataBonificacionesRetail) ?>,
			            backgroundColor: [ 'rgba(109, 85, 125, 0.8)', ],
			            borderColor: [ 'rgba(109, 85, 125, 0.8)', ],
			        },
			        {
			            label: 'Refund',
			            data: <?php echo json_encode($dataBonificacionesRebate) ?>,
			            backgroundColor: [ 'rgba(54, 162, 235, 0.8)', ],
			            borderColor: [ 'rgba(54, 162, 235, 0.8)', ],
			        },
			        {
			            label: 'Group Bonus',
			            data: <?php echo json_encode($dataBonificacionesOveride) ?>,
			            backgroundColor: [ 'rgba(75, 192, 192, 0.8)', ],
			            borderColor: [ 'rgba(75, 192, 192, 0.8)', ],
			        },
			        {
			            label: 'Leadership',
			            data: <?php echo json_encode($dataBonificacionesLeadership) ?>,
			            backgroundColor: [ 'rgba(213, 229, 178, 0.8)', ],
			            borderColor: [ 'rgba(213, 229, 178, 0.8)', ],
			        },
			        {
			            label: 'Lifestyle Bonus',
			            data: <?php echo json_encode($dataBonificacionesAhlsb) ?>,
			            backgroundColor: [ 'rgba(154, 181, 194, 0.8)', ],
			            borderColor: [ 'rgba(154, 181, 194, 0.8)', ],
			        },
			        {
			            label: 'Shopping Club',
			            data: <?php echo json_encode($dataBonificacionesClub) ?>,
			            backgroundColor: [ 'rgba(247, 177, 147, 0.8)', ],
			            borderColor: [ 'rgba(247, 177, 147, 0.8)', ],
			        }
			        ,
			        {
			            label: 'Earnings by Influence Plan',
			            data: <?php echo json_encode($dataBonificacionesPi) ?>,
			            backgroundColor: [ 'rgba(255, 206, 86, 0.8)', ],
			            borderColor: [ 'rgba(255, 206, 86, 0.8)', ],
			        }
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
