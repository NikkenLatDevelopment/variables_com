<?php require_once("../../functions.php"); //Funciones

//Conexión
$serverName = "200.66.68.166";
$connectionInfo = array("Database" => "SIP", "UID" => "nikkenmk", "PWD" => "M4rk3t1n$");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn){ die(print_r(sqlsrv_errors(), true)); }
//Conexión

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = letterCountrie($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodo = $_POST["periodo"];
//Vars

//Others
$kenkoSleep_1_2022 = "0";
$kenkoSleep_1_2023 = "0";
$kenkoSleep_1_2024 = "0";

$pimag_1_2022 = "0";
$pimag_1_2023 = "0";
$pimag_1_2024 = "0";

$kenkoAir_1_2022 = "0";
$kenkoAir_1_2023 = "0";
$kenkoAir_1_2024 = "0";

$otros_1_2022 = "0";
$otros_1_2023 = "0";
$otros_1_2024 = "0";

$kenkoSleep_2_2022 = "0";
$kenkoSleep_2_2023 = "0";
$kenkoSleep_2_2024 = "0";

$pimag_2_2022 = "0";
$pimag_2_2023 = "0";
$pimag_2_2024 = "0";

$kenkoAir_2_2022 = "0";
$kenkoAir_2_2023 = "0";
$kenkoAir_2_2024 = "0";

$otros_2_2022 = "0";
$otros_2_2023 = "0";
$otros_2_2024 = "0";

$kenkoSleep_3_2022 = "0";
$kenkoSleep_3_2023 = "0";
$kenkoSleep_3_2024 = "0";

$pimag_3_2022 = "0";
$pimag_3_2023 = "0";
$pimag_3_2024 = "0";

$kenkoAir_3_2022 = "0";
$kenkoAir_3_2023 = "0";
$kenkoAir_3_2024 = "0";

$otros_3_2022 = "0";
$otros_3_2023 = "0";
$otros_3_2024 = "0";

$kenkoSleep_4_2022 = "0";
$kenkoSleep_4_2023 = "0";
$kenkoSleep_4_2024 = "0";

$pimag_4_2022 = "0";
$pimag_4_2023 = "0";
$pimag_4_2024 = "0";

$kenkoAir_4_2022 = "0";
$kenkoAir_4_2023 = "0";
$kenkoAir_4_2024 = "0";

$otros_4_2022 = "0";
$otros_4_2023 = "0";
$otros_4_2024 = "0";
//Others

$sql = "SELECT *
		FROM [SIP].[dbo].[sd_1_1_1]
		WHERE Codigo = $codeUser;";
		
$recordSet = sqlsrv_query($conn, $sql) or die(print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[1]);
	$product = trim($row_sap[2]);

	$total = trim($row_sap[3]) == "" ? 0 : $row_sap[3];
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_1_2022 = $total; }
	if($product == "KENKO SLEEP" && $period == "2023"){ $kenkoSleep_1_2023 = $total; }
	if($product == "KENKO SLEEP" && $period == "2024"){ $kenkoSleep_1_2024 = $total; }

	if($product == "PIMAG" && $period == "2022"){ $pimag_1_2022 = $total; }
	if($product == "PIMAG" && $period == "2023"){ $pimag_1_2023 = $total; }
	if($product == "PIMAG" && $period == "2024"){ $pimag_1_2024 = $total; }

	if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_1_2022 = $total; }
	if($product == "KENKO AIR" && $period == "2023"){ $kenkoAir_1_2023 = $total; }
	if($product == "KENKO AIR" && $period == "2024"){ $kenkoAir_1_2024 = $total; }

	if($product == "OTROS" && $period == "2022"){ $otros_1_2022 = $total; }
	if($product == "OTROS" && $period == "2023"){ $otros_1_2023 = $total; }
	if($product == "OTROS" && $period == "2024"){ $otros_1_2024 = $total; }
}

$sql = "SELECT * FROM [SIP].[dbo].[sd_1_1_2] WHERE Codigo = $codeUser";
$recordSet = sqlsrv_query($conn, $sql) or die('hola -->' . print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[1]);
	$product = trim($row_sap[2]);

	$total = trim($row_sap[3]) == "" ? 0 : $row_sap[3];
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_2_2022 = $total; }
	if($product == "KENKO SLEEP" && $period == "2023"){ $kenkoSleep_2_2023 = $total; }
	if($product == "KENKO SLEEP" && $period == "2024"){ $kenkoSleep_2_2024 = $total; }

	if($product == "PIMAG" && $period == "2022"){ $pimag_2_2022 = $total; }
	if($product == "PIMAG" && $period == "2023"){ $pimag_2_2023 = $total; }
	if($product == "PIMAG" && $period == "2024"){ $pimag_2_2024 = $total; }

	if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_2_2022 = $total; }
	if($product == "KENKO AIR" && $period == "2023"){ $kenkoAir_2_2023 = $total; }
	if($product == "KENKO AIR" && $period == "2024"){ $kenkoAir_2_2024 = $total; }

	if($product == "OTROS" && $period == "2022"){ $otros_2_2022 = $total; }
	if($product == "OTROS" && $period == "2023"){ $otros_2_2023 = $total; }
	if($product == "OTROS" && $period == "2024"){ $otros_2_2024 = $total; }
}

$sql = "SELECT * FROM [SIP].[dbo].[sd_1_2_1] WHERE Codigo = $codeUser";
$recordSet = sqlsrv_query($conn, $sql) or die('hola -->' . print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[1]);
	$product = trim($row_sap[2]);

	$total = trim($row_sap[3]) == "" ? 0 : $row_sap[3];
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_3_2022 = $total; }
	if($product == "KENKO SLEEP" && $period == "2023"){ $kenkoSleep_3_2023 = $total; }
	if($product == "KENKO SLEEP" && $period == "2024"){ $kenkoSleep_3_2024 = $total; }

	if($product == "PIMAG" && $period == "2022"){ $pimag_3_2022 = $total; }
	if($product == "PIMAG" && $period == "2023"){ $pimag_3_2023 = $total; }
	if($product == "PIMAG" && $period == "2024"){ $pimag_3_2024 = $total; }

	if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_3_2022 = $total; }
	if($product == "KENKO AIR" && $period == "2023"){ $kenkoAir_3_2023 = $total; }
	if($product == "KENKO AIR" && $period == "2024"){ $kenkoAir_3_2024 = $total; }

	if($product == "OTROS" && $period == "2022"){ $otros_3_2022 = $total; }
	if($product == "OTROS" && $period == "2023"){ $otros_3_2023 = $total; }
	if($product == "OTROS" && $period == "2024"){ $otros_3_2024 = $total; }
}

$sql = "SELECT * FROM [SIP].[dbo].[sd_1_2_2] WHERE Codigo = $codeUser";
$recordSet = sqlsrv_query($conn, $sql) or die('hola -->' . print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$period = trim($row_sap[1]);
	$product = trim($row_sap[2]);

	$total = trim($row_sap[3]) == "" ? 0 : $row_sap[3];
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_4_2022 = $total; }
	if($product == "KENKO SLEEP" && $period == "2023"){ $kenkoSleep_4_2023 = $total; }
	if($product == "KENKO SLEEP" && $period == "2024"){ $kenkoSleep_4_2024 = $total; }

	if($product == "PIMAG" && $period == "2022"){ $pimag_4_2022 = $total; }
	if($product == "PIMAG" && $period == "2023"){ $pimag_4_2023 = $total; }
	if($product == "PIMAG" && $period == "2024"){ $pimag_4_2024 = $total; }

	if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_4_2022 = $total; }
	if($product == "KENKO AIR" && $period == "2023"){ $kenkoAir_4_2023 = $total; }
	if($product == "KENKO AIR" && $period == "2024"){ $kenkoAir_4_2024 = $total; }

	if($product == "OTROS" && $period == "2022"){ $otros_4_2022 = $total; }
	if($product == "OTROS" && $period == "2023"){ $otros_4_2023 = $total; }
	if($product == "OTROS" && $period == "2024"){ $otros_4_2024 = $total; }
}

?>

<!-- <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> -->

<!-- Mostrar logo -->
<img src="https://mi.nikkenlatam.com/custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Informe Variables Comerciales por Socio Independiente</div>
			<div class="h6 mb-0"><span class="fw-bold">Periodo de Medición:</span> Enero 2022 a Agosto 2024</div>
			<div class="h6"><span class="fw-bold">País:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Código:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold">Rango:</span> <?php echo $rankUser ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="mt-4 pt-4">
		<div class="row mb-2">
			<div class="col-6 text-center">
				<div class="h6 fw-bold mb-0">COMPOSICIÓN COMPRA POR LÍNEA DE PRODUCTO<br/>UNIDADES (Personal)</div>
			</div>

			<div class="col-6 text-center">
				<div class="h6 fw-bold mb-0">TENDENCIA COMPRA POR LÍNEA DE PRODUCTO<br/>US$ x MILES (Personal)</div>
			</div>
		</div>

		<div class="row gx-5">
			<div class="col-6">
				<!-- Gráfica composición compra por linea de producto unidades personal -->
				<canvas id="viewChart6" class="w-100" height="495"></canvas>
				<!-- Gráfica composición compra por linea de producto unidades personal -->
			</div>

			<div class="col-6">
				<!-- Gráfica composición compra por linea de producto us$ x miles personal -->
				<canvas id="viewChart66" class="w-100" height="495"></canvas>
				<!-- Gráfica composición compra por linea de producto us$ x miles personal -->
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
				<!-- Gráfica composición compra por linea de producto unidades organización -->
				<canvas id="viewChart666" class="w-100" height="495"></canvas>
				<!-- Gráfica composición compra por linea de producto unidades organización -->
			</div>

			<div class="col-6">
				<!-- Gráfica composición compra por linea de producto us$ x miles organización -->
				<canvas id="viewChart6666" class="w-100" height="495"></canvas>
				<!-- Gráfica composición compra por linea de producto us$ x miles organización -->
			</div>
		</div>
	</div>
<!-- Gráficas -->

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica

	//Gráfica composición compra por linea de producto unidades personal
		var viewChart6 = document.getElementById('viewChart6').getContext('2d');
		var viewChart6Detail = new Chart(viewChart6, {
		    type: 'bar',
		    data: {
		        labels: ['2022', '2023','2024'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_1_2022 ?>, <?php echo $kenkoSleep_1_2023 ?>, <?php echo $kenkoSleep_1_2024 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_1_2022 ?>, <?php echo $pimag_1_2023 ?>, <?php echo $pimag_1_2024 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_1_2022 ?>, <?php echo $kenkoAir_1_2023 ?>, <?php echo $kenkoAir_1_2024 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_1_2022 ?>, <?php echo $otros_1_2023 ?>, <?php echo $otros_1_2024 ?>],
			            backgroundColor: [ 'rgba(146, 196, 100, 1)', ],
			            borderColor: [ 'rgba(146, 196, 100, 1)', ],
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
	//Gráfica composición compra por linea de producto unidades personal

	//Gráfica composición compra por linea de producto us$ x miles personal
		var viewChart66 = document.getElementById('viewChart66').getContext('2d');
		var viewChart66Detail = new Chart(viewChart66, {
		    type: 'bar',
		    data: {
		        labels: ['2022', '2023','2024'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_2_2022 ?>, <?php echo $kenkoSleep_2_2023 ?>, <?php echo $kenkoSleep_2_2024 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_2_2022 ?>, <?php echo $pimag_2_2023 ?>, <?php echo $pimag_2_2024 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_2_2022 ?>, <?php echo $kenkoAir_2_2023 ?>, <?php echo $kenkoAir_2_2024 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_2_2022 ?>, <?php echo $otros_2_2023 ?>, <?php echo $otros_2_2024 ?>],
			            backgroundColor: [ 'rgba(146, 196, 100, 1)', ],
			            borderColor: [ 'rgba(146, 196, 100, 1)', ],
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
	//Gráfica composición compra por linea de producto us$ x miles personal

	//Gráfica composición compra por linea de producto unidades organización
		var viewChart666 = document.getElementById('viewChart666').getContext('2d');
		var viewChart666Detail = new Chart(viewChart666, {
		    type: 'bar',
		    data: {
		        labels: ['2022', '2023','2024'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_3_2022 ?>, <?php echo $kenkoSleep_3_2023 ?>, <?php echo $kenkoSleep_3_2024 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_3_2022 ?>, <?php echo $pimag_3_2023 ?>, <?php echo $pimag_3_2024 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_3_2022 ?>, <?php echo $kenkoAir_3_2023 ?>, <?php echo $kenkoAir_3_2024 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_3_2022 ?>, <?php echo $otros_3_2023 ?>, <?php echo $otros_3_2024 ?>],
			            backgroundColor: [ 'rgba(146, 196, 100, 1)', ],
			            borderColor: [ 'rgba(146, 196, 100, 1)', ],
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
	//Gráfica composición compra por linea de producto unidades organización

	//Gráfica composición compra por linea de producto us$ x miles organización
		var viewChart6666 = document.getElementById('viewChart6666').getContext('2d');
		var viewChart6666Detail = new Chart(viewChart6666, {
		    type: 'bar',
		    data: {
		        labels: ['2022', '2023','2024'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_4_2022 ?>, <?php echo $kenkoSleep_4_2023 ?>, <?php echo $kenkoSleep_4_2024 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_4_2022 ?>, <?php echo $pimag_4_2023 ?>, <?php echo $pimag_4_2024 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_4_2022 ?>, <?php echo $kenkoAir_4_2023 ?>, <?php echo $kenkoAir_4_2024 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_4_2022 ?>, <?php echo $otros_4_2023 ?>, <?php echo $otros_4_2024 ?>],
			            backgroundColor: [ 'rgba(146, 196, 100, 1)', ],
			            borderColor: [ 'rgba(146, 196, 100, 1)', ],
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
	//Gráfica composición compra por linea de producto us$ x miles organización

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>
