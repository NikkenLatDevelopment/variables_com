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
$dataRetail = array();
$dataClubBienestar = array();
$dataPlanInfluencia = array();
$dataReembolso = array();
$dataBonificacionGrupo = array();
$dataLiderazgo = array();
$dataEstiloVida = array();
$dataIngresosTotales = array();
//Others

$period = new DateTime('2020-04-01');
$counter = 0;

while($counter < 24){
	$periodQuery = $period->format('Ym');

	$sql = "EXEC ps_SD_Diapositiva7 $code, $periodQuery";
    $recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
    while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
    	$codigo = $row_sap[0];
	    $periodo = $row_sap[1];

	    $retail = trim($row_sap[2]);
	    if($retail == ""){ $retail = 0; }elseif($retail <= 0){ $retail = 0; }

	    $clubBienestar = trim($row_sap[3]);
	    if($clubBienestar == ""){ $clubBienestar = 0; }elseif($clubBienestar <= 0){ $clubBienestar = 0; }

	    $planInfluencia = trim($row_sap[4]);
	    if($planInfluencia == ""){ $planInfluencia = 0; }elseif($planInfluencia <= 0){ $planInfluencia = 0; }

	    $reembolso = trim($row_sap[5]);
	    if($reembolso == ""){ $reembolso = 0; }elseif($reembolso <= 0){ $reembolso = 0; }

	    $bonificacionGrupo = trim($row_sap[6]);
	    if($bonificacionGrupo == ""){ $bonificacionGrupo = 0; }elseif($bonificacionGrupo <= 0){ $bonificacionGrupo = 0; }

	    $liderazgo = trim($row_sap[7]);
	    if($liderazgo == ""){ $liderazgo = 0; }elseif($liderazgo <= 0){ $liderazgo = 0; }

	    $bonoEstiloVida = trim($row_sap[8]);
	    if($bonoEstiloVida == ""){ $bonoEstiloVida = 0; }elseif($bonoEstiloVida <= 0){ $bonoEstiloVida = 0; }

	    $ingresosTotales = trim($row_sap[9]);
	    if($ingresosTotales == ""){ $ingresosTotales = 0; }elseif($ingresosTotales <= 0){ $ingresosTotales = 0; }

	    $tasa = 20;

	    if($periodQuery >= "202108"){
	    	$retail = trim($row_sap[2]);
		    if($retail == ""){ $retail = 0; }elseif($retail <= 0){ $retail = 0; }else{ $retail = $retail / $tasa; }

		    $clubBienestar = trim($row_sap[3]);
		    if($clubBienestar == ""){ $clubBienestar = 0; }elseif($clubBienestar <= 0){ $clubBienestar = 0; }else{ $clubBienestar = $clubBienestar / $tasa; }

		    $planInfluencia = trim($row_sap[4]);
		    if($planInfluencia == ""){ $planInfluencia = 0; }elseif($planInfluencia <= 0){ $planInfluencia = 0; }else{ $planInfluencia = $planInfluencia / $tasa; }

		    $reembolso = trim($row_sap[5]);
		    if($reembolso == ""){ $reembolso = 0; }elseif($reembolso <= 0){ $reembolso = 0; }else{ $reembolso = $reembolso / $tasa; }

		    $bonificacionGrupo = trim($row_sap[6]);
		    if($bonificacionGrupo == ""){ $bonificacionGrupo = 0; }elseif($bonificacionGrupo <= 0){ $bonificacionGrupo = 0; }else{ $bonificacionGrupo = $bonificacionGrupo / $tasa; }

		    $liderazgo = trim($row_sap[7]);
		    if($liderazgo == ""){ $liderazgo = 0; }elseif($liderazgo <= 0){ $liderazgo = 0; }else{ $liderazgo = $liderazgo / $tasa; }

		    $bonoEstiloVida = trim($row_sap[8]);
		    if($bonoEstiloVida == ""){ $bonoEstiloVida = 0; }elseif($bonoEstiloVida <= 0){ $bonoEstiloVida = 0; }else{ $bonoEstiloVida = $bonoEstiloVida / $tasa; }

		    $ingresosTotales = trim($row_sap[9]);
		    if($ingresosTotales == ""){ $ingresosTotales = 0; }elseif($ingresosTotales <= 0){ $ingresosTotales = 0; }else{ $ingresosTotales = $ingresosTotales / $tasa; }
	    }else{
	    	$retail = trim($row_sap[2]);
		    if($retail == ""){ $retail = 0; }elseif($retail <= 0){ $retail = 0; }else{ $retail = $retail / $tasa; }

		    $clubBienestar = trim($row_sap[3]);
		    if($clubBienestar == ""){ $clubBienestar = 0; }elseif($clubBienestar <= 0){ $clubBienestar = 0; }else{ $retail = $retail / $tasa; }

		    $planInfluencia = trim($row_sap[4]);
		    if($planInfluencia == ""){ $planInfluencia = 0; }elseif($planInfluencia <= 0){ $planInfluencia = 0; }else{ $retail = $retail / $tasa; }

		    $reembolso = trim($row_sap[5]);
		    if($reembolso == ""){ $reembolso = 0; }elseif($reembolso <= 0){ $reembolso = 0; }else{ $retail = $retail / $tasa; }

		    $bonificacionGrupo = trim($row_sap[6]);
		    if($bonificacionGrupo == ""){ $bonificacionGrupo = 0; }elseif($bonificacionGrupo <= 0){ $bonificacionGrupo = 0; }else{ $retail = $retail / $tasa; }

		    $liderazgo = trim($row_sap[7]);
		    if($liderazgo == ""){ $liderazgo = 0; }elseif($liderazgo <= 0){ $liderazgo = 0; }else{ $retail = $retail / $tasa; }

		    $bonoEstiloVida = trim($row_sap[8]);
		    if($bonoEstiloVida == ""){ $bonoEstiloVida = 0; }elseif($bonoEstiloVida <= 0){ $bonoEstiloVida = 0; }else{ $retail = $retail / $tasa; }

		    $ingresosTotales = trim($row_sap[9]);
		    if($ingresosTotales == ""){ $ingresosTotales = 0; }elseif($ingresosTotales <= 0){ $ingresosTotales = 0; }else{ $retail = $retail / $tasa; }
	    }

	    //Llenar array
		    $dataRetail = array_merge($dataRetail, array($retail));
		    $dataClubBienestar = array_merge($dataClubBienestar, array($clubBienestar));
		    $dataPlanInfluencia = array_merge($dataPlanInfluencia, array($planInfluencia));
		    $dataReembolso = array_merge($dataReembolso, array($reembolso));
		    $dataBonificacionGrupo = array_merge($dataBonificacionGrupo, array($bonificacionGrupo));
		    $dataLiderazgo = array_merge($dataLiderazgo, array($liderazgo));
		    $dataEstiloVida = array_merge($dataEstiloVida, array($bonoEstiloVida));
		    $dataIngresosTotales = array_merge($dataIngresosTotales, array($ingresosTotales));
	    //Llenar array
	}

	$period->modify('+1 month');
	$period = $period->format('Y-m-01');
	$period = new DateTime($period);
	$counter++;
}

//Convertir array
	$dataRetailChart = json_encode($dataRetail);
	$dataClubBienestarChart = json_encode($dataClubBienestar);
	$dataPlanInfluenciaChart = json_encode($dataPlanInfluencia);
	$dataReembolsoChart = json_encode($dataReembolso);
	$dataBonificacionGrupoChart = json_encode($dataBonificacionGrupo);
	$dataLiderazgoChart = json_encode($dataLiderazgo);
	$dataEstiloVidaChart = json_encode($dataEstiloVida);
	$dataIngresosTotalesChart = json_encode($dataIngresosTotales);
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

<!-- Gráficas -->
	<div class="my-2">
		<!-- Gráfica inscripciones por activo -->
		<canvas id="viewChart5" class="w-100" height="1110"></canvas>
		<!-- Gráfica inscripciones por activo -->
	</div>
<!-- Gráficas -->

<script>
	Chart.defaults.font.size = 16;
	//Gráfica bonificaciones
		console.log();
		var viewChart5 = document.getElementById('viewChart5').getContext('2d');
		var viewChart5Detail = new Chart(viewChart5, {
		    type: 'bar',
		    data: {
		        labels: [ 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene','Feb', '22'],
		        datasets: [
			        {
			            label: 'Ingresos Totales',
			            data: <?php echo $dataIngresosTotalesChart ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            borderColor: [ 'rgba(255, 99, 132, 0.8)', ],
			            type: 'line',
			            yAxisID: 'y1',
			        },
			        {
			            label: 'Ganancia Precio Sugerido',
			            data: <?php echo $dataRetailChart ?>,
			            backgroundColor: [ 'rgba(109, 85, 125, 0.8)', ],
			            borderColor: [ 'rgba(109, 85, 125, 0.8)', ],
			        },
			        {
			            label: 'Reembolso',
			            data: <?php echo $dataReembolsoChart ?>,
			            backgroundColor: [ 'rgba(54, 162, 235, 0.8)', ],
			            borderColor: [ 'rgba(54, 162, 235, 0.8)', ],
			        },
			        {
			            label: 'Bonificación de Grupo',
			            data: <?php echo $dataBonificacionGrupoChart ?>,
			            backgroundColor: [ 'rgba(75, 192, 192, 0.8)', ],
			            borderColor: [ 'rgba(75, 192, 192, 0.8)', ],
			        },
			        {
			            label: 'Liderazgo',
			            data: <?php echo $dataLiderazgoChart ?>,
			            backgroundColor: [ 'rgba(213, 229, 178, 0.8)', ],
			            borderColor: [ 'rgba(213, 229, 178, 0.8)', ],
			        },
			        {
			            label: 'Bono Estilo de Vida',
			            data: <?php echo $dataEstiloVidaChart ?>,
			            backgroundColor: [ 'rgba(154, 181, 194, 0.8)', ],
			            borderColor: [ 'rgba(154, 181, 194, 0.8)', ],
			        },
			        {
			            label: 'Club de Compras',
			            data: <?php echo $dataClubBienestarChart ?>,
			            backgroundColor: [ 'rgba(247, 177, 147, 0.8)', ],
			            borderColor: [ 'rgba(247, 177, 147, 0.8)', ],
			        }
			        ,
			        {
			            label: 'Plan Influencia',
			            data: <?php echo $dataPlanInfluenciaChart ?>,
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
				          	text: 'Dólares'
				        },
					},
				}
			},
		});
	//Gráfica bonificaciones
</script>
