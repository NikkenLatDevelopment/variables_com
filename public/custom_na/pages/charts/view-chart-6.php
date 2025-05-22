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
$kenkoSleep_1_2016 = "0";
$kenkoSleep_1_2017 = "0";
$kenkoSleep_1_2018 = "0";
$kenkoSleep_1_2019 = "0";
$kenkoSleep_1_2020 = "0";
$kenkoSleep_1_2021 = "0";

$pimag_1_2016 = "0";
$pimag_1_2017 = "0";
$pimag_1_2018 = "0";
$pimag_1_2019 = "0";
$pimag_1_2020 = "0";
$pimag_1_2021 = "0";

$kenkoAir_1_2016 = "0";
$kenkoAir_1_2017 = "0";
$kenkoAir_1_2018 = "0";
$kenkoAir_1_2019 = "0";
$kenkoAir_1_2020 = "0";
$kenkoAir_1_2021 = "0";

$otros_1_2016 = "0";
$otros_1_2017 = "0";
$otros_1_2018 = "0";
$otros_1_2019 = "0";
$otros_1_2020 = "0";
$otros_1_2021 = "0";

$kenkoSleep_2_2016 = "0";
$kenkoSleep_2_2017 = "0";
$kenkoSleep_2_2018 = "0";
$kenkoSleep_2_2019 = "0";
$kenkoSleep_2_2020 = "0";
$kenkoSleep_2_2021 = "0";

$pimag_2_2016 = "0";
$pimag_2_2017 = "0";
$pimag_2_2018 = "0";
$pimag_2_2019 = "0";
$pimag_2_2020 = "0";
$pimag_2_2021 = "0";

$kenkoAir_2_2016 = "0";
$kenkoAir_2_2017 = "0";
$kenkoAir_2_2018 = "0";
$kenkoAir_2_2019 = "0";
$kenkoAir_2_2020 = "0";
$kenkoAir_2_2021 = "0";

$otros_2_2016 = "0";
$otros_2_2017 = "0";
$otros_2_2018 = "0";
$otros_2_2019 = "0";
$otros_2_2020 = "0";
$otros_2_2021 = "0";

$kenkoSleep_3_2016 = "0";
$kenkoSleep_3_2017 = "0";
$kenkoSleep_3_2018 = "0";
$kenkoSleep_3_2019 = "0";
$kenkoSleep_3_2020 = "0";
$kenkoSleep_3_2021 = "0";

$pimag_3_2016 = "0";
$pimag_3_2017 = "0";
$pimag_3_2018 = "0";
$pimag_3_2019 = "0";
$pimag_3_2020 = "0";
$pimag_3_2021 = "0";

$kenkoAir_3_2016 = "0";
$kenkoAir_3_2017 = "0";
$kenkoAir_3_2018 = "0";
$kenkoAir_3_2019 = "0";
$kenkoAir_3_2020 = "0";
$kenkoAir_3_2021 = "0";

$otros_3_2016 = "0";
$otros_3_2017 = "0";
$otros_3_2018 = "0";
$otros_3_2019 = "0";
$otros_3_2020 = "0";
$otros_3_2021 = "0";

$kenkoSleep_4_2016 = "0";
$kenkoSleep_4_2017 = "0";
$kenkoSleep_4_2018 = "0";
$kenkoSleep_4_2019 = "0";
$kenkoSleep_4_2020 = "0";
$kenkoSleep_4_2021 = "0";

$pimag_4_2016 = "0";
$pimag_4_2017 = "0";
$pimag_4_2018 = "0";
$pimag_4_2019 = "0";
$pimag_4_2020 = "0";
$pimag_4_2021 = "0";

$kenkoAir_4_2016 = "0";
$kenkoAir_4_2017 = "0";
$kenkoAir_4_2018 = "0";
$kenkoAir_4_2019 = "0";
$kenkoAir_4_2020 = "0";
$kenkoAir_4_2021 = "0";

$otros_4_2016 = "0";
$otros_4_2017 = "0";
$otros_4_2018 = "0";
$otros_4_2019 = "0";
$otros_4_2020 = "0";
$otros_4_2021 = "0";
//Others

$sql = "EXEC [dbo].[ps_producto_2_1] @CODE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[0]);
	$period = trim($row_sap[1]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2017"){ $kenkoSleep_1_2016 = $total; }
	if($product == "KENKO SLEEP" && $period == "2018"){ $kenkoSleep_1_2017 = $total; }
	if($product == "KENKO SLEEP" && $period == "2019"){ $kenkoSleep_1_2018 = $total; }
	if($product == "KENKO SLEEP" && $period == "2020"){ $kenkoSleep_1_2019 = $total; }
	if($product == "KENKO SLEEP" && $period == "2021"){ $kenkoSleep_1_2020 = $total; }
	if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_1_2021 = $total; }

	if($product == "PIMAG" && $period == "2017"){ $pimag_1_2017 = $total; }
	if($product == "PIMAG" && $period == "2018"){ $pimag_1_2018 = $total; }
	if($product == "PIMAG" && $period == "2019"){ $pimag_1_2019 = $total; }
	if($product == "PIMAG" && $period == "2020"){ $pimag_1_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $pimag_1_2021 = $total; }
	if($product == "PIMAG" && $period == "2022"){ $pimag_1_2016 = $total; }

	if($product == "KENKO AIR" && $period == "2017"){ $kenkoAir_1_2017 = $total; }
	if($product == "KENKO AIR" && $period == "2018"){ $kenkoAir_1_2018 = $total; }
	if($product == "KENKO AIR" && $period == "2019"){ $kenkoAir_1_2019 = $total; }
	if($product == "KENKO AIR" && $period == "2020"){ $kenkoAir_1_2020 = $total; }
	if($product == "KENKO AIR" && $period == "2021"){ $kenkoAir_1_2021 = $total; }
	if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_1_2016 = $total; }

	if($product == "OTROS" && $period == "2017"){ $otros_1_2017 = $total; }
	if($product == "OTROS" && $period == "2018"){ $otros_1_2018 = $total; }
	if($product == "OTROS" && $period == "2019"){ $otros_1_2019 = $total; }
	if($product == "OTROS" && $period == "2020"){ $otros_1_2020 = $total; }
	if($product == "OTROS" && $period == "2021"){ $otros_1_2021 = $total; }
		if($product == "OTROS" && $period == "2022"){ $otros_1_2021 = $total; }

}

$sql = "EXEC [dbo].[ps_producto_2_2] @CODE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[1]);
	$period = trim($row_sap[0]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2017"){ $kenkoSleep_2_2017 = $total; }
	if($product == "KENKO SLEEP" && $period == "2018"){ $kenkoSleep_2_2018 = $total; }
	if($product == "KENKO SLEEP" && $period == "2019"){ $kenkoSleep_2_2019 = $total; }
	if($product == "KENKO SLEEP" && $period == "2020"){ $kenkoSleep_2_2020 = $total; }
	if($product == "KENKO SLEEP" && $period == "2021"){ $kenkoSleep_2_2021 = $total; }
		if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_2_2016 = $total; }


	if($product == "PIMAG" && $period == "2017"){ $pimag_2_2017 = $total; }
	if($product == "PIMAG" && $period == "2018"){ $pimag_2_2018 = $total; }
	if($product == "PIMAG" && $period == "2019"){ $pimag_2_2019 = $total; }
	if($product == "PIMAG" && $period == "2020"){ $pimag_2_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $pimag_2_2021 = $total; }
		if($product == "PIMAG" && $period == "2022"){ $pimag_2_2016 = $total; }


	if($product == "KENKO AIR" && $period == "2017"){ $kenkoAir_2_2017 = $total; }
	if($product == "KENKO AIR" && $period == "2018"){ $kenkoAir_2_2018 = $total; }
	if($product == "KENKO AIR" && $period == "2019"){ $kenkoAir_2_2019 = $total; }
	if($product == "KENKO AIR" && $period == "2020"){ $kenkoAir_2_2020 = $total; }
	if($product == "KENKO AIR" && $period == "2021"){ $kenkoAir_2_2021 = $total; }
	if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_2_2016 = $total; }

	if($product == "OTROS" && $period == "2017"){ $otros_2_2017 = $total; }
	if($product == "OTROS" && $period == "2018"){ $otros_2_2018 = $total; }
	if($product == "OTROS" && $period == "2019"){ $otros_2_2019 = $total; }
	if($product == "OTROS" && $period == "2020"){ $otros_2_2020 = $total; }
	if($product == "OTROS" && $period == "2021"){ $otros_2_2021 = $total; }
		if($product == "OTROS" && $period == "2022"){ $otros_2_2016 = $total; }

}

$sql = "EXEC [dbo].[ps_producto_2_3] @CODE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[0]);
	$period = trim($row_sap[1]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total * 100, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2017"){ $kenkoSleep_3_2017 = $total; }
	if($product == "KENKO SLEEP" && $period == "2018"){ $kenkoSleep_3_2018 = $total; }
	if($product == "KENKO SLEEP" && $period == "2019"){ $kenkoSleep_3_2019 = $total; }
	if($product == "KENKO SLEEP" && $period == "2020"){ $kenkoSleep_3_2020 = $total; }
	if($product == "KENKO SLEEP" && $period == "2021"){ $kenkoSleep_3_2021 = $total; }
	if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_3_2016 = $total; }

	if($product == "PIMAG" && $period == "2017"){ $pimag_3_2017 = $total; }
	if($product == "PIMAG" && $period == "2018"){ $pimag_3_2018 = $total; }
	if($product == "PIMAG" && $period == "2019"){ $pimag_3_2019 = $total; }
	if($product == "PIMAG" && $period == "2020"){ $pimag_3_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $pimag_3_2021 = $total; }	
	if($product == "PIMAG" && $period == "2022"){ $pimag_3_2016 = $total; }


	if($product == "KENKO AIR" && $period == "2017"){ $kenkoAir_3_2017 = $total; }
	if($product == "KENKO AIR" && $period == "2018"){ $kenkoAir_3_2018 = $total; }
	if($product == "KENKO AIR" && $period == "2019"){ $kenkoAir_3_2019 = $total; }
	if($product == "KENKO AIR" && $period == "2020"){ $kenkoAir_3_2020 = $total; }
	if($product == "KENKO AIR" && $period == "2021"){ $kenkoAir_3_2021 = $total; }
		if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_3_2016 = $total; }


	if($product == "OTROS" && $period == "2017"){ $otros_3_2017 = $total; }
	if($product == "OTROS" && $period == "2018"){ $otros_3_2018 = $total; }
	if($product == "OTROS" && $period == "2019"){ $otros_3_2019 = $total; }
	if($product == "OTROS" && $period == "2020"){ $otros_3_2020 = $total; }
	if($product == "OTROS" && $period == "2021"){ $otros_3_2021 = $total; }
		if($product == "OTROS" && $period == "2022"){ $otros_3_2016 = $total; }

}

$sql = "EXEC [dbo].[ps_producto_2_4] @CODE_ABI = '$code'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[1]);
	$period = trim($row_sap[0]);
	$total = trim($row_sap[2]);
	if($total == ""){ $total = 0; }
	$total = trim(str_replace(",", "", number_format($total, 1, '.', '')));

	if($product == "KENKO SLEEP" && $period == "2017"){ $kenkoSleep_4_2017 = $total; }
	if($product == "KENKO SLEEP" && $period == "2018"){ $kenkoSleep_4_2018 = $total; }
	if($product == "KENKO SLEEP" && $period == "2019"){ $kenkoSleep_4_2019 = $total; }
	if($product == "KENKO SLEEP" && $period == "2020"){ $kenkoSleep_4_2020 = $total; }
	if($product == "KENKO SLEEP" && $period == "2021"){ $kenkoSleep_4_2021 = $total; }
		if($product == "KENKO SLEEP" && $period == "2022"){ $kenkoSleep_4_2016 = $total; }


	if($product == "PIMAG" && $period == "2017"){ $pimag_4_2017 = $total; }
	if($product == "PIMAG" && $period == "2018"){ $pimag_4_2018 = $total; }
	if($product == "PIMAG" && $period == "2019"){ $pimag_4_2019 = $total; }
	if($product == "PIMAG" && $period == "2020"){ $pimag_4_2020 = $total; }
	if($product == "PIMAG" && $period == "2021"){ $pimag_4_2021 = $total; }
		if($product == "PIMAG" && $period == "2022"){ $pimag_4_2016 = $total; }


	if($product == "KENKO AIR" && $period == "2017"){ $kenkoAir_4_2017 = $total; }
	if($product == "KENKO AIR" && $period == "2018"){ $kenkoAir_4_2018 = $total; }
	if($product == "KENKO AIR" && $period == "2019"){ $kenkoAir_4_2019 = $total; }
	if($product == "KENKO AIR" && $period == "2020"){ $kenkoAir_4_2020 = $total; }
	if($product == "KENKO AIR" && $period == "2021"){ $kenkoAir_4_2021 = $total; }
		if($product == "KENKO AIR" && $period == "2022"){ $kenkoAir_4_2016 = $total; }


	if($product == "OTROS" && $period == "2017"){ $otros_4_2017 = $total; }
	if($product == "OTROS" && $period == "2018"){ $otros_4_2018 = $total; }
	if($product == "OTROS" && $period == "2019"){ $otros_4_2019 = $total; }
	if($product == "OTROS" && $period == "2020"){ $otros_4_2020 = $total; }
	if($product == "OTROS" && $period == "2021"){ $otros_4_2021 = $total; }
		if($product == "OTROS" && $period == "2022"){ $otros_4_2016 = $total; }

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
				<div>COMPOSICIÓN COMPRA POR LINEA DE PRODUCTO<br/>UNIDADES (Personal)</div>
			</div>

			<div class="col-6 text-center">
				<div>TENDENCIA COMPRA POR LINEA DE PRODUCTO<br/>US$ x MILES (Personal)</div>
			</div>
		</div>

		<div class="row gx-5">
			<div class="col-6">
				<!-- Gráfica composición compra por linea de producto unidades personal -->
				<canvas id="viewChart6" class="w-100" height="460"></canvas>
				<!-- Gráfica composición compra por linea de producto unidades personal -->
			</div>

			<div class="col-6">
				<!-- Gráfica composición compra por linea de producto us$ x miles personal -->
				<canvas id="viewChart66" class="w-100" height="460"></canvas>
				<!-- Gráfica composición compra por linea de producto us$ x miles personal -->
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
				<!-- Gráfica composición compra por linea de producto unidades organización -->
				<canvas id="viewChart666" class="w-100" height="460"></canvas>
				<!-- Gráfica composición compra por linea de producto unidades organización -->
			</div>

			<div class="col-6">
				<!-- Gráfica composición compra por linea de producto us$ x miles organización -->
				<canvas id="viewChart6666" class="w-100" height="460"></canvas>
				<!-- Gráfica composición compra por linea de producto us$ x miles organización -->
			</div>
		</div>
	</div>
<!-- Gráficas -->

<script>
	Chart.defaults.font.size = 16;
	//Gráfica composición compra por linea de producto unidades personal
		var viewChart6 = document.getElementById('viewChart6').getContext('2d');
		var viewChart6Detail = new Chart(viewChart6, {
		    type: 'bar',
		    data: {
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_1_2016 ?>, <?php echo $kenkoSleep_1_2017 ?>, <?php echo $kenkoSleep_1_2018 ?>, <?php echo $kenkoSleep_1_2019 ?>, <?php echo $kenkoSleep_1_2020 ?>, <?php echo $kenkoSleep_1_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_1_2016 ?>, <?php echo $pimag_1_2017 ?>, <?php echo $pimag_1_2018 ?>, <?php echo $pimag_1_2019 ?>, <?php echo $pimag_1_2020 ?>, <?php echo $pimag_1_2021 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_1_2016 ?>, <?php echo $kenkoAir_1_2017 ?>, <?php echo $kenkoAir_1_2018 ?>, <?php echo $kenkoAir_1_2019 ?>, <?php echo $kenkoAir_1_2020 ?>, <?php echo $kenkoAir_1_2021 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_1_2016 ?>, <?php echo $otros_1_2017 ?>, <?php echo $otros_1_2018 ?>, <?php echo $otros_1_2019 ?>, <?php echo $otros_1_2020 ?>, <?php echo $otros_1_2021 ?>],
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
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_2_2016 ?>, <?php echo $kenkoSleep_2_2017 ?>, <?php echo $kenkoSleep_2_2018 ?>, <?php echo $kenkoSleep_2_2019 ?>, <?php echo $kenkoSleep_2_2020 ?>, <?php echo $kenkoSleep_2_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_2_2016 ?>, <?php echo $pimag_2_2017 ?>, <?php echo $pimag_2_2018 ?>, <?php echo $pimag_2_2019 ?>, <?php echo $pimag_2_2020 ?>, <?php echo $pimag_2_2021 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_2_2016 ?>, <?php echo $kenkoAir_2_2017 ?>, <?php echo $kenkoAir_2_2018 ?>, <?php echo $kenkoAir_2_2019 ?>, <?php echo $kenkoAir_2_2020 ?>, <?php echo $kenkoAir_2_2021 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_2_2016 ?>, <?php echo $otros_2_2017 ?>, <?php echo $otros_2_2018 ?>, <?php echo $otros_2_2019 ?>, <?php echo $otros_2_2020 ?>, <?php echo $otros_2_2021 ?>],
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
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_3_2016 ?>, <?php echo $kenkoSleep_3_2017 ?>, <?php echo $kenkoSleep_3_2018 ?>, <?php echo $kenkoSleep_3_2019 ?>, <?php echo $kenkoSleep_3_2020 ?>, <?php echo $kenkoSleep_3_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_3_2016 ?>, <?php echo $pimag_3_2017 ?>, <?php echo $pimag_3_2018 ?>, <?php echo $pimag_3_2019 ?>, <?php echo $pimag_3_2020 ?>, <?php echo $pimag_3_2021 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_3_2016 ?>, <?php echo $kenkoAir_3_2017 ?>, <?php echo $kenkoAir_3_2018 ?>, <?php echo $kenkoAir_3_2019 ?>, <?php echo $kenkoAir_3_2020 ?>, <?php echo $kenkoAir_3_2021 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_3_2016 ?>, <?php echo $otros_3_2017 ?>, <?php echo $otros_3_2018 ?>, <?php echo $otros_3_2019 ?>, <?php echo $otros_3_2020 ?>, <?php echo $otros_3_2021 ?>],
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
		        labels: [ '2017', '2018', '2019', '2020', '2021','2022'],
		        datasets: [
			        {
			            label: 'KENKO SLEEP',
			            data: [<?php echo $kenkoSleep_4_2016 ?>, <?php echo $kenkoSleep_4_2017 ?>, <?php echo $kenkoSleep_4_2018 ?>, <?php echo $kenkoSleep_4_2019 ?>, <?php echo $kenkoSleep_4_2020 ?>, <?php echo $kenkoSleep_4_2021 ?>],
			            backgroundColor: [ 'rgb(147, 169, 216, 1)', ],
			            borderColor: [ 'rgba(147, 169, 216, 1)', ],
			        },
			        {
			            label: 'PIMAG',
			            data: [<?php echo $pimag_4_2016 ?>, <?php echo $pimag_4_2017 ?>, <?php echo $pimag_4_2018 ?>, <?php echo $pimag_4_2019 ?>, <?php echo $pimag_4_2020 ?>, <?php echo $pimag_4_2021 ?>],
			            backgroundColor: [ 'rgba(75, 155, 213, 1)', ],
			            borderColor: [ 'rgba(75, 155, 213, 1)', ],
			        },
			        {
			            label: 'KENKO AIR',
			            data: [<?php echo $kenkoAir_4_2016 ?>, <?php echo $kenkoAir_4_2017 ?>, <?php echo $kenkoAir_4_2018 ?>, <?php echo $kenkoAir_4_2019 ?>, <?php echo $kenkoAir_4_2020 ?>, <?php echo $kenkoAir_4_2021 ?>],
			            backgroundColor: [ 'rgba(39, 112, 48, 1)', ],
			            borderColor: [ 'rgba(39, 112, 48, 1)', ],
			        },
			        {
			            label: 'OTROS',
			            data: [<?php echo $otros_4_2016 ?>, <?php echo $otros_4_2017 ?>, <?php echo $otros_4_2018 ?>, <?php echo $otros_4_2019 ?>, <?php echo $otros_4_2020 ?>, <?php echo $otros_4_2021 ?>],
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
</script>
