<?php require_once("../../functions.php"); //Funciones

// echo getcwd() . "<br>";

//Conexión 75
$serverName75 = "104.130.46.73";
// $serverName75 = "172.24.16.75";
$connectionInfo75 = array("Database" => "LAT_MyNIKKEN", "UID" => "Latamti", "PWD" => 'L8$aQ7mZ!pR42^Tx');
$conn75 = sqlsrv_connect($serverName75, $connectionInfo75);
if(!$conn75){ die(print_r(sqlsrv_errors(), true)); }

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = letterCountrie($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodoPost = $_POST["periodo"];
$lang = $_POST["lang"];
// $periodoPost = 202310;
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
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.varCom_bonificaciones_usa $codeUser, $periodoPost;";
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
	$periodoIni = strval($periodMonthsByGraph[$monthToShow[12]]);
	$period = new DateTime("$periodoIni");
	//Periodo inicial de consulta

	while($count < 12){
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
<hr>
<img src="src/img/logo-black.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1"><?php echo $laguaje[$lang]['Variables de negocio Informe del consultor']; ?></div>
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Periodo de medición']; ?>:</span> <?php echo getMontPeriodPast($periodoPost) . " " . $laguaje[$lang]['a'] .  " " .getMontPeriod($periodoPost); ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['País']; ?>:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Código']; ?>:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['Rango']; ?>:</span> <?php echo $rangos_usa[$rankUser] ?></div>
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

<span hidden id="txtMont13"><?php echo getMontPeriodShortLang($monthToShow[12], $lang) ?></span>
<span hidden id="txtMont14"><?php echo getMontPeriodShortLang($monthToShow[11], $lang) ?></span>
<span hidden id="txtMont15"><?php echo getMontPeriodShortLang($monthToShow[10], $lang) ?></span>
<span hidden id="txtMont16"><?php echo getMontPeriodShortLang($monthToShow[9], $lang) ?></span>
<span hidden id="txtMont17"><?php echo getMontPeriodShortLang($monthToShow[8], $lang) ?></span>
<span hidden id="txtMont18"><?php echo getMontPeriodShortLang($monthToShow[7], $lang) ?></span>
<span hidden id="txtMont19"><?php echo getMontPeriodShortLang($monthToShow[6], $lang) ?></span>
<span hidden id="txtMont20"><?php echo getMontPeriodShortLang($monthToShow[5], $lang) ?></span>
<span hidden id="txtMont21"><?php echo getMontPeriodShortLang($monthToShow[4], $lang) ?></span>
<span hidden id="txtMont22"><?php echo getMontPeriodShortLang($monthToShow[3], $lang) ?></span>
<span hidden id="txtMont23"><?php echo getMontPeriodShortLang($monthToShow[2], $lang) ?></span>
<span hidden id="txtMont24"><?php echo getMontPeriodShortLang($monthToShow[1], $lang) ?></span>

<?php
	$graphTexts = [
		'es' => [
			'Personal Rebate and Override Bonus' => "Reembolso personal y bonificación por anulación",
			'Leadership Bonus' => "Bonificación por liderazgo",
			'Retail Bonus' => "Bonificación por venta al por menor",
			'WE Acelerate Bonus' => "Bonificación WE Acelera",
			'Lifestyle Bonus' => "Bonificación por estilo de vida",
		],
		'en' => [
			'Personal Rebate and Override Bonus' => "Personal Rebate and Override Bonus",
			'Leadership Bonus' => "Leadership Bonus",
			'Retail Bonus' => "Retail Bonus",
			'WE Acelerate Bonus' => "WE Acelerate Bonus",
			'Lifestyle Bonus' => "Lifestyle Bonus",
		],
		'fr' => [
			'Personal Rebate and Override Bonus' => "Remise personnelle et prime de dépassement",
			'Leadership Bonus' => "Prime de leadership",
			'Retail Bonus' => "Prime de vente au détail",
			'WE Acelerate Bonus' => "Prime WE Acelerate",
			'Lifestyle Bonus' => "Prime de style de vie",
		],
	];
?>

<input type="hidden" id="Personal_Rebate_and_Override_Bonus" value="<?php echo $graphTexts[$lang]['Personal Rebate and Override Bonus']?>">
<input type="hidden" id="Leadership_Bonus" value="<?php echo $graphTexts[$lang]['Leadership Bonus']?>">
<input type="hidden" id="Retail_Bonus" value="<?php echo $graphTexts[$lang]['Retail Bonus']?>">
<input type="hidden" id="WE_Acelerate_Bonus" value="<?php echo $graphTexts[$lang]['WE Acelerate Bonus']?>">
<input type="hidden" id="Lifestyle_Bonus" value="<?php echo $graphTexts[$lang]['Lifestyle Bonus']?>">

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

	var Personal_Rebate_and_Override_Bonus = $("#Personal_Rebate_and_Override_Bonus").val();
	var Leadership_Bonus = $("#Leadership_Bonus").val();
	var Retail_Bonus = $("#Retail_Bonus").val();
	var WE_Acelerate_Bonus = $("#WE_Acelerate_Bonus").val();
	var Lifestyle_Bonus = $("#Lifestyle_Bonus").val();

	//Gráfica bonificaciones
		var chart5Graph1 = document.getElementById('chart5Graph1').getContext('2d');
		var chart5Graph1Detail = new Chart(chart5Graph1, {
		    type: 'bar',
		    data: {
		        labels: [txtMont13, txtMont14, txtMont15, txtMont16, txtMont17, txtMont18, txtMont19, txtMont20, txtMont21, txtMont22, txtMont23, txtMont24],
		        datasets: [
			        {
			            label: Personal_Rebate_and_Override_Bonus,
			            data: <?php echo json_encode($dataBonificacionespersonal) ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            borderColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            type: 'line',
			            yAxisID: 'y1',
			        },
			        {
			            label: Leadership_Bonus,
			            data: <?php echo json_encode($dataBonificacionesleadership_bonus) ?>,
			            backgroundColor: [ 'rgba(109, 85, 125, 0.8)', ],
			            borderColor: [ 'rgba(109, 85, 125, 0.8)', ],
			        },
			        {
			            label: Retail_Bonus,
			            data: <?php echo json_encode($dataBonificacionesretail_bonus) ?>,
			            backgroundColor: [ 'rgba(54, 162, 235, 0.8)', ],
			            borderColor: [ 'rgba(54, 162, 235, 0.8)', ],
			        },
			        {
			            label: WE_Acelerate_Bonus,
			            data: <?php echo json_encode($dataBonificacioneswe_acelerate_bonus) ?>,
			            backgroundColor: [ 'rgba(213, 229, 178, 0.8)', ],
			            borderColor: [ 'rgba(213, 229, 178, 0.8)', ],
			        },
			        {
			            label: Lifestyle_Bonus,
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
