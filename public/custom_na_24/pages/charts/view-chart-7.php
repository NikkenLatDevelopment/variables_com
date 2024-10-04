<?php //TERMINADA

//Conexión
$serverName = "200.66.68.173";
$connectionInfo = array("Database" => "COMERCIAL_LAT", "UID" => "nikkcomer", "PWD" => "C0m3rCial$");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn){ die(print_r(sqlsrv_errors(), true)); }
//Conexión

//Vars
$code = $_POST["code"];
$name = trim($_POST["name"]);
$nameCotitular = $_POST["nameCotitular"];
$country = $_POST["country"];
$rank = $_POST["rank"];
//Vars

//Others
$accesorios_1_2016 = "0";
$accesorios_1_2017 = "0";
$accesorios_1_2018 = "0";
$accesorios_1_2019 = "0";
$accesorios_1_2020 = "0";
$accesorios_1_2021 = "0";

$agua_1_2016 = "0";
$agua_1_2017 = "0";
$agua_1_2018 = "0";
$agua_1_2019 = "0";
$agua_1_2020 = "0";
$agua_1_2021 = "0";

$accesorios_2_2016 = "0";
$accesorios_2_2017 = "0";
$accesorios_2_2018 = "0";
$accesorios_2_2019 = "0";
$accesorios_2_2020 = "0";
$accesorios_2_2021 = "0";

$agua_2_2016 = "0";
$agua_2_2017 = "0";
$agua_2_2018 = "0";
$agua_2_2019 = "0";
$agua_2_2020 = "0";
$agua_2_2021 = "0";

$accesorios_3_2016 = "0";
$accesorios_3_2017 = "0";
$accesorios_3_2018 = "0";
$accesorios_3_2019 = "0";
$accesorios_3_2020 = "0";
$accesorios_3_2021 = "0";

$agua_3_2016 = "0";
$agua_3_2017 = "0";
$agua_3_2018 = "0";
$agua_3_2019 = "0";
$agua_3_2020 = "0";
$agua_3_2021 = "0";

$accesorios_4_2016 = "0";
$accesorios_4_2017 = "0";
$accesorios_4_2018 = "0";
$accesorios_4_2019 = "0";
$accesorios_4_2020 = "0";
$accesorios_4_2021 = "0";

$agua_4_2016 = "0";
$agua_4_2017 = "0";
$agua_4_2018 = "0";
$agua_4_2019 = "0";
$agua_4_2020 = "0";
$agua_4_2021 = "0";
//Others

$sql = "EXEC [dbo].[ps_producto_3_1] @CODE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[0]);
	$period = trim($row_sap[1]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2017"){ $accesorios_1_2017 = $total; }
	if($product == "ACCESORIOS" && $period == "2018"){ $accesorios_1_2018 = $total; }
	if($product == "ACCESORIOS" && $period == "2019"){ $accesorios_1_2019 = $total; }
	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_1_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_1_2021 = $total; }
		if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_1_2016 = $total; }


	if($product == "AGUA" && $period == "2017"){ $agua_1_2017 = $total; }
	if($product == "AGUA" && $period == "2018"){ $agua_1_2018 = $total; }
	if($product == "AGUA" && $period == "2019"){ $agua_1_2019 = $total; }
	if($product == "AGUA" && $period == "2020"){ $agua_1_2020 = $total; }
	if($product == "AGUA" && $period == "2021"){ $agua_1_2021 = $total; }
		if($product == "AGUA" && $period == "2022"){ $agua_1_2016 = $total; }

}

$sql = "EXEC [dbo].[ps_producto_3_2] @NOMBRE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[1]);
	$period = trim($row_sap[0]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2017"){ $accesorios_2_2017 = $total; }
	if($product == "ACCESORIOS" && $period == "2018"){ $accesorios_2_2018 = $total; }
	if($product == "ACCESORIOS" && $period == "2019"){ $accesorios_2_2019 = $total; }
	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_2_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_2_2021 = $total; }
	if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_2_2016 = $total; }

	if($product == "AGUA" && $period == "2017"){ $agua_2_2017 = $total; }
	if($product == "AGUA" && $period == "2018"){ $agua_2_2018 = $total; }
	if($product == "AGUA" && $period == "2019"){ $agua_2_2019 = $total; }
	if($product == "AGUA" && $period == "2020"){ $agua_2_2020 = $total; }
	if($product == "AGUA" && $period == "2021"){ $agua_2_2021 = $total; }
		if($product == "AGUA" && $period == "2022"){ $agua_2_2016 = $total; }

}

$sql = "EXEC [dbo].[ps_producto_3_3] @CODE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[0]);
	$period = trim($row_sap[1]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2017"){ $accesorios_3_2017 = $total; }
	if($product == "ACCESORIOS" && $period == "2018"){ $accesorios_3_2018 = $total; }
	if($product == "ACCESORIOS" && $period == "2019"){ $accesorios_3_2019 = $total; }
	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_3_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_3_2021 = $total; }
	if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_3_2016 = $total; }

	if($product == "AGUA" && $period == "2017"){ $agua_3_2017 = $total; }
	if($product == "AGUA" && $period == "2018"){ $agua_3_2018 = $total; }
	if($product == "AGUA" && $period == "2019"){ $agua_3_2019 = $total; }
	if($product == "AGUA" && $period == "2020"){ $agua_3_2020 = $total; }
	if($product == "AGUA" && $period == "2021"){ $agua_3_2021 = $total; }
		if($product == "AGUA" && $period == "2022"){ $agua_3_2016 = $total; }

}

$sql = "EXEC [dbo].[ps_producto_3_4] @CODE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[1]);
	$period = trim($row_sap[0]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "ACCESORIOS" && $period == "2017"){ $accesorios_4_2017 = $total; }
	if($product == "ACCESORIOS" && $period == "2018"){ $accesorios_4_2018 = $total; }
	if($product == "ACCESORIOS" && $period == "2019"){ $accesorios_4_2019 = $total; }
	if($product == "ACCESORIOS" && $period == "2020"){ $accesorios_4_2020 = $total; }
	if($product == "ACCESORIOS" && $period == "2021"){ $accesorios_4_2021 = $total; }
		if($product == "ACCESORIOS" && $period == "2022"){ $accesorios_4_2016 = $total; }


	if($product == "AGUA" && $period == "2017"){ $agua_4_2017 = $total; }
	if($product == "AGUA" && $period == "2018"){ $agua_4_2018 = $total; }
	if($product == "AGUA" && $period == "2019"){ $agua_4_2019 = $total; }
	if($product == "AGUA" && $period == "2020"){ $agua_4_2020 = $total; }
	if($product == "AGUA" && $period == "2021"){ $agua_4_2021 = $total; }
		if($product == "AGUA" && $period == "2022"){ $agua_4_2016 = $total; }

}

?>

<!-- Header -->
	<div class="mb-4">
		<img src="custom/img/general/logo-nikken.png" alt="Logo NIKKEN">
		<h2 class="fw-bold text-uppercase h4 mt-3 mb-3">NIKKEN Latinoamérica</h2>

		<div class="row d-flex align-items-center">
			<div class="col-4">
				<div class="row">
					<div class="col"><strong>Periodo de Medición:</strong></div>
					<div class="col">2017 - 2021 Enero a Diciembre</div>
				</div>

				<div class="row">
					<div class="col"></div>
					<div class="col">2022 Enero a Marzo</div>
				</div>

				<div class="row"><div class="col"><strong>País:</strong> <?php echo $country ?></div></div>
			</div>

			<div class="col-4">
				<div class="h3 fw-bold"><?php echo $name ?></div>
			</div>
			<div class="col-4">
				<div><strong>Código:</strong> <?php echo $code ?></div>
				<div><strong>Rango:</strong> <?php echo $rank ?></div>
			</div>
		</div>
	</div>
<!-- Header -->

<!-- Gráficas -->
	<div class="my-2 pt-4">
		<div class="row mb-4">
			<div class="col-6 text-center">
				<div>COMPARATIVO VENTA PIMAG VS ACCESORIOS<br/>UNIDADES (Personal)</div>
			</div>

			<div class="col-6 text-center">
				<div>COMPARATIVO VENTA PIMAG VS ACCESORIOS<br/>US$ x MILES (Personal)</div>
			</div>
		</div>

		<div class="row gx-5">
			<div class="col-6">
				<!-- Gráfica composición compra por paquetes unidades personal -->
				<canvas id="viewChart7" class="w-100" height="460"></canvas>
				<!-- Gráfica composición compra por paquetes unidades personal -->
			</div>

			<div class="col-6">
				<!-- Gráfica tendencia compra por paquetes us$ x miles personal -->
				<canvas id="viewChart77" class="w-100" height="460"></canvas>
				<!-- Gráfica tendencia compra por paquetes us$ x miles personal -->
			</div>
		</div>

		<div class="row mt-5">
			<div class="col-6 text-center">
				<div class="mb-3">Organización</div>
			</div>

			<div class="col-6 text-center">
				<div class="mb-3">Organización</div>
			</div>
		</div>

		<div class="row gx-5 mt-1">
			<div class="col-6">
				<!-- Gráfica composición compra por paquetes unidades organización -->
				<canvas id="viewChart777" class="w-100" height="460"></canvas>
				<!-- Gráfica composición compra por paquetes unidades organización -->
			</div>

			<div class="col-6">
				<!-- Gráfica tendencia compra por paquetes us$ x miles organización -->
				<canvas id="viewChart7777" class="w-100" height="460"></canvas>
				<!-- Gráfica tendencia compra por paquetes us$ x miles organización -->
			</div>
		</div>
	</div>
<!-- Gráficas -->

<script>
	Chart.defaults.font.size = 16;
	//Gráfica composición compra por familia de producto unidades personal
		var viewChart7 = document.getElementById('viewChart7').getContext('2d');
		var viewChart7Detail = new Chart(viewChart7, {
		    type: 'bar',
		    data: {
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_1_2016 ?>, <?php echo $accesorios_1_2017 ?>, <?php echo $accesorios_1_2018 ?>, <?php echo $accesorios_1_2019 ?>, <?php echo $accesorios_1_2020 ?>, <?php echo $accesorios_1_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_1_2016 ?>, <?php echo $agua_1_2017 ?>, <?php echo $agua_1_2018 ?>, <?php echo $agua_1_2019 ?>, <?php echo $agua_1_2020 ?>, <?php echo $agua_1_2021 ?>],
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
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_2_2016 ?>, <?php echo $accesorios_2_2017 ?>, <?php echo $accesorios_2_2018 ?>, <?php echo $accesorios_2_2019 ?>, <?php echo $accesorios_2_2020 ?>, <?php echo $accesorios_2_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_2_2016 ?>, <?php echo $agua_2_2017 ?>, <?php echo $agua_2_2018 ?>, <?php echo $agua_2_2019 ?>, <?php echo $agua_2_2020 ?>, <?php echo $agua_2_2021 ?>],
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
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_3_2016 ?>, <?php echo $accesorios_3_2017 ?>, <?php echo $accesorios_3_2018 ?>, <?php echo $accesorios_3_2019 ?>, <?php echo $accesorios_3_2020 ?>, <?php echo $accesorios_3_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_3_2016 ?>, <?php echo $agua_3_2017 ?>, <?php echo $agua_3_2018 ?>, <?php echo $agua_3_2019 ?>, <?php echo $agua_3_2020 ?>, <?php echo $agua_3_2021 ?>],
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
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'ACCESORIOS',
			            data: [<?php echo $accesorios_4_2016 ?>, <?php echo $accesorios_4_2017 ?>, <?php echo $accesorios_4_2018 ?>, <?php echo $accesorios_4_2019 ?>, <?php echo $accesorios_4_2020 ?>, <?php echo $accesorios_4_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'AGUA',
			            data: [<?php echo $agua_4_2016 ?>, <?php echo $agua_4_2017 ?>, <?php echo $agua_4_2018 ?>, <?php echo $agua_4_2019 ?>, <?php echo $agua_4_2020 ?>, <?php echo $agua_4_2021 ?>],
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
</script>
