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
$dataIncorActivo = array();
$dataBonificacionesPer = array();
$dataBonificacionesOrg = array();
//Others

$period = new DateTime('2020-04-01');
$counter = 0;

while($counter < 24){
	$periodQuery = $period->format('Ym');

	$sql = "SELECT * FROM SD_DIAPOSITIVA4_5 WHERE VASS_CODIGO = '$code' AND PERIODO = '$periodQuery'";
    $recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
    while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$codigo = $row_sap[0];
		$periodo = $row_sap[1];

		$incorActivo = trim($row_sap[12]);
		if($incorActivo == ""){ $incorActivo = 0; }

		//Llenar array
		$dataIncorActivo = array_merge($dataIncorActivo, array($incorActivo));
		//Llenar array
	}

	$period->modify('+1 month');
	$period = $period->format('Y-m-01');
	$period = new DateTime($period);
	$counter++;
}

//Convertir array
$dataIncorActivoChart = json_encode($dataIncorActivo);
//Convertir array

$period = new DateTime('2020-04-01');
$counter = 0;

while($counter < 24){
	$periodQuery = $period->format('Ym');

	$sql = "EXEC ps_SD_Diapositiva5_6 $code, $periodQuery";
    $recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
    while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	    $codigo = $row_sap[0];
	    $periodo = $row_sap[1];

	    $tasa = 20;

	    if($periodQuery >= "202108"){
	    	$bonificacionesPer = trim($row_sap[8]);
		    if($bonificacionesPer == ""){ $bonificacionesPer = 0; }else{ $bonificacionesPer = $bonificacionesPer / $tasa; }

		    $bonificacionesOrg = trim($row_sap[9]);
		    if($bonificacionesOrg == ""){ $bonificacionesOrg = 0; }else{ $bonificacionesOrg = $bonificacionesOrg / $tasa; }
	    }else{
	    	$bonificacionesPer = trim($row_sap[8]);
		    if($bonificacionesPer == ""){ $bonificacionesPer = 0; }

		    $bonificacionesOrg = trim($row_sap[9]);
		    if($bonificacionesOrg == ""){ $bonificacionesOrg = 0; }
	    }

	    //Llenar array
		    $dataBonificacionesPer = array_merge($dataBonificacionesPer, array($bonificacionesPer));
		    $dataBonificacionesOrg = array_merge($dataBonificacionesOrg, array($bonificacionesOrg));
	    //Llenar array
	}

	$period->modify('+1 month');
	$period = $period->format('Y-m-01');
	$period = new DateTime($period);
	$counter++;
}

//Convertir array
	$dataBonificacionesPerChart = json_encode($dataBonificacionesPer);
	$dataBonificacionesOrgChart = json_encode($dataBonificacionesOrg);
//Convertir array

?>

<!-- Header -->
	<div class="mb-4">
		<img src="custom/img/general/logo-nikken.png" alt="Logo NIKKEN">
		<h2 class="fw-bold text-uppercase h4 mt-3 mb-3">NIKKEN Latinoamérica</h2>

		<div class="row d-flex align-items-center">
			<div class="col-4">
				<div><strong>Periodo de Medición:</strong> Abril 2020 a Marzo 2022</div>
				<div><strong>País:</strong> <?php echo $country ?></div>
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

<div class="table-responsive">
	<table class="table align-middle table-bordered ">
		<thead>
			<tr class="text-center">
				<th scope="col"></th>
				
				
				<th scope="col">abr20</th>
				<th scope="col">may20</th>
				<th scope="col">jun20</th>
				<th scope="col">jul20</th>
				<th scope="col">ago20</th>
				<th scope="col">sep20</th>
				<th scope="col">oct20</th>
				<th scope="col">nov20</th>
				<th scope="col">dic20</th>
				<th scope="col">ene21</th>
				<th scope="col">feb21</th>
				<th scope="col">mar21</th>
				<th scope="col">abr21</th>
				<th scope="col">may21</th>
				<th scope="col">jun21</th>
				<th scope="col">jul21</th>
				<th scope="col">ago21</th>
				<th scope="col">sep21</th>
				<th scope="col">oct21</th>
				<th scope="col">nov21</th>
				<th scope="col">dic21</th>
				<th scope="col">ene22</th>
				<th scope="col">feb22</th>
				<th scope="col">mar22</th>
				<th scope="col" class="custom-width-1">Total 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- Inscripciones por Activo -->
				<tr>
					<th scope="row" class="custom-width-2">Inscripciones por Activo</th>
					<td class="text-center"><?php echo number_format($dataIncorActivo[0], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[1], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[2], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[3], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[4], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[5], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[6], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[7], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[8], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[9], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[10], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[11], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[12], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[13], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[14], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[15], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[16], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[17], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[18], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[19], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[20], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[21], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[22], 2) ?></td>
					<td class="text-center"><?php echo number_format($dataIncorActivo[23], 2) ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataIncorActivo as $value){ $total = $total + $value; }
						echo number_format($total / 24, 2);

						?>
					</td>
				</tr>
			<!-- Inscripciones por Activo -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="my-2">
		<!-- Gráfica inscripciones por activo -->
		<canvas id="viewChart3" class="w-100" height="420"></canvas>
		<!-- Gráfica inscripciones por activo -->
	</div>
<!-- Gráficas -->

<div class="table-responsive mt-5">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col"></th>
			
				
				<th scope="col">abr20</th>
				<th scope="col">may20</th>
				<th scope="col">jun20</th>
				<th scope="col">jul20</th>
				<th scope="col">ago20</th>
				<th scope="col">sep20</th>
				<th scope="col">oct20</th>
				<th scope="col">nov20</th>
				<th scope="col">dic20</th>
				<th scope="col">ene21</th>
				<th scope="col">feb21</th>
				<th scope="col">mar21</th>
				<th scope="col">abr21</th>
				<th scope="col">may21</th>
				<th scope="col">jun21</th>
				<th scope="col">jul21</th>
				<th scope="col">ago21</th>
				<th scope="col">sep21</th>
				<th scope="col">oct21</th>
				<th scope="col">nov21</th>
				<th scope="col">dic21</th>
				<th scope="col">ene22</th>
				<th scope="col">feb22</th>
				<th scope="col">mar22</th>
				<th scope="col" class="custom-width-1">Total 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- Bonificaciones Personales -->
				<tr>
					<th scope="row" class="custom-width-2">Bonificaciones Personales</th>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[0])){ echo number_format($dataBonificacionesPer[0], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[1])){ echo number_format($dataBonificacionesPer[1], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[2])){ echo number_format($dataBonificacionesPer[2], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[3])){ echo number_format($dataBonificacionesPer[3], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[4])){ echo number_format($dataBonificacionesPer[4], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[5])){ echo number_format($dataBonificacionesPer[5], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[6])){ echo number_format($dataBonificacionesPer[6], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[7])){ echo number_format($dataBonificacionesPer[7], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[8])){ echo number_format($dataBonificacionesPer[8], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[9])){ echo number_format($dataBonificacionesPer[9], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[10])){ echo number_format($dataBonificacionesPer[10], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[11])){ echo number_format($dataBonificacionesPer[11], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[12])){ echo number_format($dataBonificacionesPer[12], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[13])){ echo number_format($dataBonificacionesPer[13], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[14])){ echo number_format($dataBonificacionesPer[14], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[15])){ echo number_format($dataBonificacionesPer[15], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[16])){ echo number_format($dataBonificacionesPer[16], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[17])){ echo number_format($dataBonificacionesPer[17], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[18])){ echo number_format($dataBonificacionesPer[18], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[19])){ echo number_format($dataBonificacionesPer[19], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[20])){ echo number_format($dataBonificacionesPer[20], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[21])){ echo number_format($dataBonificacionesPer[21], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[22])){ echo number_format($dataBonificacionesPer[22], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataBonificacionesPer[23])){ echo number_format($dataBonificacionesPer[23], 0); }else{ echo "0"; } ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataBonificacionesPer as $value){ $total = $total + $value; }
						echo number_format($total, 0);

						?>
					</td>
				</tr>
			<!-- Bonificaciones Personales -->

			<!-- Bonificaciones de la Organización -->
				<tr>
					<th scope="row" class="custom-width-2"></th>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
					<td class="text-center"></td>
				</tr>
			<!-- Bonificaciones de la Organización -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="my-2">
		<!-- Gráfica bonificaciones -->
		<canvas id="viewChart33" class="w-100" height="420"></canvas>
		<!-- Gráfica bonificaciones -->
	</div>
<!-- Gráficas -->

<script>
	Chart.defaults.font.size = 16;
	//Gráfica inscripciones por activo
		var viewChart3 = document.getElementById('viewChart3').getContext('2d');
		var viewChart3Detail = new Chart(viewChart3, {
		    type: 'line',
		    data: {
		        labels: ['Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene', 'Feb',  '22'],
		        datasets: [
			        {
			            label: 'Incorporaciones por Activo',
			            data: <?php echo $dataIncorActivoChart ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 1)', ],
			            borderColor: [ 'rgba(255, 99, 132, 1)', ],
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Inscripciones por Activo'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'No. Incorporaciones Activo'
			        	},
			      	}
			    }
			},
		});
	//Gráfica inscripciones por activo

	//Gráfica bonificaciones
		var viewChart33 = document.getElementById('viewChart33').getContext('2d');
		var viewChart33Detail = new Chart(viewChart33, {
		    type: 'line',
		    data: {
		        labels: ['Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene', 'Feb',  '22'],
		        datasets: [
			        {
			            label: 'Bonificaciones Personales',
			            data: <?php echo $dataBonificacionesPerChart ?>,
			            backgroundColor: [ 'rgba(54, 162, 235, 1)', ],
			            borderColor: [ 'rgba(54, 162, 235, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Bonificaciones'
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'Dólares'
			        	},
			      	}
			    }
			},
		});
	//Gráfica bonificaciones
</script>
