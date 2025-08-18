<?php require_once("../../functions.php"); //Funciones

//Conexión
$serverName = "200.66.68.173";
$connectionInfo = array("Database" => "COMERCIAL_LAT", "UID" => "nikkcomer", "PWD" => "C0m3rCial$");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn){ die(print_r(sqlsrv_errors(), true)); }
//Conexión

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = letterCountrie($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodo = $_POST["periodo"]; echo $periodo;
//Vars

//Others
$accesorios_1_2020 = "0";
$accesorios_1_2021 = "0";
$accesorios_1_2022 = "0";

$agua_1_2020 = "0";
$agua_1_2021 = "0";
$agua_1_2022 = "0";

$accesorios_2_2020 = "0";
$accesorios_2_2021 = "0";
$accesorios_2_2022 = "0";

$agua_2_2020 = "0";
$agua_2_2021 = "0";
$agua_2_2022 = "0";

$accesorios_3_2020 = "0";
$accesorios_3_2021 = "0";
$accesorios_3_2022 = "0";

$agua_3_2020 = "0";
$agua_3_2021 = "0";
$agua_3_2022 = "0";

$accesorios_4_2020 = "0";
$accesorios_4_2021 = "0";
$accesorios_4_2022 = "0";

$agua_4_2020 = "0";
$agua_4_2021 = "0";
$agua_4_2022 = "0";
//Others

$sql = "EXEC ps_producto_3_1_usa'$codeUser'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[0]);
	$product = trim($row_sap[1]);

	$total = trim($row_sap[2]) == "" ? 0 : $row_sap[2];
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_1_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_1_2021 = $total; }
	if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_1_2022 = $total; }

	if($product == "PIMAG" && $period == "2020"){ $agua_1_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $agua_1_2021 = $total; }
	if($product == "PIMAG" && $period == "2022"){ $agua_1_2022 = $total; }
}

$sql = "EXEC ps_producto_3_2_usa '$codeUser'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[0]);
	$product = trim($row_sap[1]);

	$total = trim($row_sap[2]) == "" ? 0 : $row_sap[2];
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_2_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_2_2021 = $total; }
	if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_2_2022 = $total; }

	if($product == "PIMAG" && $period == "2020"){ $agua_2_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $agua_2_2021 = $total; }
	if($product == "PIMAG" && $period == "2022"){ $agua_2_2022 = $total; }
}

$sql = "EXEC ps_producto_3_3_usa '$codeUser'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[0]);
	$product = trim($row_sap[1]);

	$total = trim($row_sap[2]) == "" ? 0 : $row_sap[2];
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_3_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_3_2021 = $total; }
	if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_3_2022 = $total; }

	if($product == "PIMAG" && $period == "2020"){ $agua_3_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $agua_3_2021 = $total; }
	if($product == "PIMAG" && $period == "2022"){ $agua_3_2022 = $total; }
}

$sql = "EXEC ps_producto_3_4_usa '$codeUser'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[0]);
	$product = trim($row_sap[1]);

	$total = trim($row_sap[2]) == "" ? 0 : $row_sap[2];
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_4_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_4_2021 = $total; }
	if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_4_2022 = $total; }

	if($product == "PIMAG" && $period == "2020"){ $agua_4_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $agua_4_2021 = $total; }
	if($product == "PIMAG" && $period == "2022"){ $agua_4_2022 = $total; }
}

?>

<!-- Mostrar logo -->
<img src="custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Informe Variables Comerciales por Influencer</div>
			<div class="h6 mb-0"><span class="fw-bold">Periodo de Medición:</span> Enero 2020 a Agosto 2022</div>
			<div class="h6"><span class="fw-bold">País:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Código:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold">Rango:</span> <?php echo $rangos_usa[$rankUser] ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="mt-4 pt-4">
		<div class="row mb-2">
			<div class="col-6 text-center">
				<div class="h6 fw-bold mb-0">COMPARATIVO VENTA PIMAG VS ACCESORIOS<br/>UNIDADES (Personal)</div>
			</div>

			<div class="col-6 text-center">
				<div class="h6 fw-bold mb-0">COMPARATIVO VENTA PIMAG VS ACCESORIOS<br/>US$ x MILES (Personal)</div>
			</div>
		</div>

		<div class="row gx-5">
			<div class="col-6">
				<!-- Gráfica composición compra por paquetes unidades personal -->
				<canvas id="viewChart7" class="w-100" height="505"></canvas>
				<!-- Gráfica composición compra por paquetes unidades personal -->
			</div>

			<div class="col-6">
				<!-- Gráfica tendencia compra por paquetes us$ x miles personal -->
				<canvas id="viewChart77" class="w-100" height="505"></canvas>
				<!-- Gráfica tendencia compra por paquetes us$ x miles personal -->
			</div>
		</div>

		<div class="row mb-2 mt-4">
			<div class="col-6 text-center">
				<div class="h6 fw-bold mb-0">Organización</div>
			</div>

			<div class="col-6 text-center">
				<div class="h6 fw-bold mb-0">Organización</div>
			</div>
		</div>

		<div class="row gx-5">
			<div class="col-6">
				<!-- Gráfica composición compra por paquetes unidades organización -->
				<canvas id="viewChart777" class="w-100" height="510"></canvas>
				<!-- Gráfica composición compra por paquetes unidades organización -->
			</div>

			<div class="col-6">
				<!-- Gráfica tendencia compra por paquetes us$ x miles organización -->
				<canvas id="viewChart7777" class="w-100" height="510"></canvas>
				<!-- Gráfica tendencia compra por paquetes us$ x miles organización -->
			</div>
		</div>
	</div>
<!-- Gráficas -->

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica

	//Gráfica composición compra por familia de producto unidades personal
		var viewChart7 = document.getElementById('viewChart7').getContext('2d');
		var viewChart7Detail = new Chart(viewChart7, {
		    type: 'bar',
		    data: {
		        labels: ['2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_1_2020 ?>, <?php echo $accesorios_1_2021 ?>, <?php echo $accesorios_1_2022 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_1_2020 ?>, <?php echo $agua_1_2021 ?>, <?php echo $agua_1_2022 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
		    	plugins:{
		    		legend:{
		    			position: 'right',
		    		},
		    		datalabels: {
				        color: 'black',
				        formatter: function(value){
				            return value + '% ';
				        }
				    }
		    	},
		    	scales: {
					x: {
						stacked: true,
					},
					y: {
						stacked: true
					}
				}
			},
			plugins: [ChartDataLabels],
		});
	//Gráfica composición compra por familia de producto unidades personal

	//Gráfica tendencia compra por familia de producto US$ x Miles personal
		var viewChart77 = document.getElementById('viewChart77').getContext('2d');
		var viewChart77Detail = new Chart(viewChart77, {
		    type: 'bar',
		    data: {
		        labels: ['2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_2_2020 ?>, <?php echo $accesorios_2_2021 ?>, <?php echo $accesorios_2_2022 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_2_2020 ?>, <?php echo $agua_2_2021 ?>, <?php echo $agua_2_2022 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
		    	plugins:{
		    		legend:{
		    			position: 'right',
		    		},
		    		datalabels: {
				        color: 'black',
				    }
		    	},
		    	scales: {
					x: {
						stacked: true,
						ticks: {
				          beginAtZero:true
				        },
					},
					y: {
						stacked: true,
						ticks: {
				          beginAtZero:true
				        },
					}
				},
			},
			plugins: [ChartDataLabels],
		});
	//Gráfica tendencia compra por familia de producto US$ x Miles personal

	//Gráfica composición compra por familia de producto unidades organización
		var viewChart777 = document.getElementById('viewChart777').getContext('2d');
		var viewChart777Detail = new Chart(viewChart777, {
		    type: 'bar',
		    data: {
		        labels: ['2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_3_2020 ?>, <?php echo $accesorios_3_2021 ?>, <?php echo $accesorios_3_2022 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_3_2020 ?>, <?php echo $agua_3_2021 ?>, <?php echo $agua_3_2022 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
		    	plugins:{
		    		legend:{
		    			position: 'right',
		    		},
		    		datalabels: {
				        color: 'black',
				        formatter: function(value){
				            return value + '% ';
				        }
				    }
		    	},
		    	scales: {
					x: {
						stacked: true,
					},
					y: {
						stacked: true
					}
				}
			},
			plugins: [ChartDataLabels],
		});
	//Gráfica composición compra por familia de producto unidades organización

	//Gráfica tendencia compra por familia de producto US$ x Miles organización
		var viewChart7777 = document.getElementById('viewChart7777').getContext('2d');
		var viewChart7777Detail = new Chart(viewChart7777, {
		    type: 'bar',
		    data: {
		        labels: ['2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_4_2020 ?>, <?php echo $accesorios_4_2021 ?>, <?php echo $accesorios_4_2022 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_4_2020 ?>, <?php echo $agua_4_2021 ?>, <?php echo $agua_4_2022 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
		    	plugins:{
		    		legend:{
		    			position: 'right',
		    		},
		    		datalabels: {
				        color: 'black',
				    }
		    	},
		    	scales: {
					x: {
						stacked: true,
						ticks: {
				          beginAtZero:true
				        },
					},
					y: {
						stacked: true,
						ticks: {
				          beginAtZero:true
				        },
					}
				},
			},
			plugins: [ChartDataLabels],
		});
	//Gráfica tendencia compra por familia de producto US$ x Miles organización

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>