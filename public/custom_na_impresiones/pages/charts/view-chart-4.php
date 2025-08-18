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
$dataVp = array();
$dataVgp = array();
$dataVo = array();
$dataVoldp = array();
$dataRangoPago = array();
$dataRangoActual = array();
//Others

$period = new DateTime('2020-04-01');
$counter = 0;

while($counter < 24){
	$periodQuery = $period->format('Ym');

	$sql = "EXEC ps_SD_Diapositiva5_6 $code, $periodQuery";
    $recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
    while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	    $codigo = $row_sap[0];
	    $periodo = $row_sap[1];

	    $vp = trim($row_sap[2]);
	    if($vp == ""){ $vp = 0; }

	    $vgp = trim($row_sap[3]);
	    if($vgp == ""){ $vgp = 0; }

	    $vo = trim($row_sap[4]);
	    if($vo == ""){ $vo = 0; }

	    $voldp = trim($row_sap[5]);
	    if($voldp == ""){ $voldp = 0; }

	    $rangoPago = trim($row_sap[6]);
	    $rangoActual = trim($row_sap[7]);

	    //Llenar array
		    $dataVp = array_merge($dataVp, array($vp));
		    $dataVgp = array_merge($dataVgp, array($vgp));
		    $dataVo = array_merge($dataVo, array($vo));
		    $dataVoldp = array_merge($dataVoldp, array($voldp));
		    $dataRangoPago = array_merge($dataRangoPago, array($rangoPago));
		    $dataRangoActual = array_merge($dataRangoActual, array($rangoActual));
	    //Llenar array
	}

	$period->modify('+1 month');
	$period = $period->format('Y-m-01');
	$period = new DateTime($period);
	$counter++;
}

//Convertir array
	$dataVpChart = json_encode($dataVp);
	$dataVgpChart = json_encode($dataVgp);
	$dataVoChart = json_encode($dataVo);
	$dataVoldpChart = json_encode($dataVoldp);
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
	//<div class="my-2">
		//<!-- Gráfica inscripciones por activo -->
	//	<canvas id="viewChart4" class="w-100" height="390"></canvas>
	//	<!-- Gráfica inscripciones por activo -->
	//</div>

	<div class="my-4">
		<!-- Gráfica bonificaciones -->
		<canvas id="viewChart44" class="w-100" height="390"></canvas>
		<!-- Gráfica bonificaciones -->
	</div>
<!-- Gráficas -->

<div class="table-responsive">
	<table class="table align-middle table-bordered ">
		<thead>
			<tr class="text-center">
				<th scope="col">PUNTOS</th>
						
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
				<th scope="col" class="custom-width-1">Promedio 24 Meses</th>
			</tr>
		</thead>

		<tbody>
			<!-- VP (Volumen Personal) -->
				<tr>
					<th scope="row" class="custom-width-2">VP (Volumen Personal)</th>
					<td class="text-center"><?php if(isset($dataVp[0])){ echo number_format($dataVp[0], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[1])){ echo number_format($dataVp[1], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[2])){ echo number_format($dataVp[2], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[3])){ echo number_format($dataVp[3], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[4])){ echo number_format($dataVp[4], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[5])){ echo number_format($dataVp[5], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[6])){ echo number_format($dataVp[6], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[7])){ echo number_format($dataVp[7], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[8])){ echo number_format($dataVp[8], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[9])){ echo number_format($dataVp[9], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[10])){ echo number_format($dataVp[10], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[11])){ echo number_format($dataVp[11], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[12])){ echo number_format($dataVp[12], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[13])){ echo number_format($dataVp[13], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[14])){ echo number_format($dataVp[14], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[15])){ echo number_format($dataVp[15], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[16])){ echo number_format($dataVp[16], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[17])){ echo number_format($dataVp[17], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[18])){ echo number_format($dataVp[18], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[19])){ echo number_format($dataVp[19], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[20])){ echo number_format($dataVp[20], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[21])){ echo number_format($dataVp[21], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[22])){ echo number_format($dataVp[22], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVp[23])){ echo number_format($dataVp[23], 0); }else{ echo "0"; } ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataVp as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- VP (Volumen Personal) -->

			<!-- VGP (Volumen Grupo Personal) -->
				<tr>
					<th scope="row" class="custom-width-2">VGP (Volumen Grupo Personal)</th>
					<td class="text-center"><?php if(isset($dataVgp[0])){ echo number_format($dataVgp[0], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[1])){ echo number_format($dataVgp[1], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[2])){ echo number_format($dataVgp[2], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[3])){ echo number_format($dataVgp[3], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[4])){ echo number_format($dataVgp[4], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[5])){ echo number_format($dataVgp[5], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[6])){ echo number_format($dataVgp[6], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[7])){ echo number_format($dataVgp[7], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[8])){ echo number_format($dataVgp[8], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[9])){ echo number_format($dataVgp[9], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[10])){ echo number_format($dataVgp[10], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[11])){ echo number_format($dataVgp[11], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[12])){ echo number_format($dataVgp[12], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[13])){ echo number_format($dataVgp[13], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[14])){ echo number_format($dataVgp[14], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[15])){ echo number_format($dataVgp[15], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[16])){ echo number_format($dataVgp[16], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[17])){ echo number_format($dataVgp[17], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[18])){ echo number_format($dataVgp[18], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[19])){ echo number_format($dataVgp[19], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[20])){ echo number_format($dataVgp[20], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[21])){ echo number_format($dataVgp[21], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[22])){ echo number_format($dataVgp[22], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVgp[23])){ echo number_format($dataVgp[23], 0); }else{ echo "0"; } ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataVgp as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- VGP (Volumen Grupo Personal) -->

			<!-- VO (Volumen Organizacional) -->
				<tr>
					<th scope="row" class="custom-width-2">VO (Volumen Organizacional)</th>
					<td class="text-center"><?php if(isset($dataVo[0])){ echo number_format($dataVo[0], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[1])){ echo number_format($dataVo[1], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[2])){ echo number_format($dataVo[2], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[3])){ echo number_format($dataVo[3], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[4])){ echo number_format($dataVo[4], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[5])){ echo number_format($dataVo[5], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[6])){ echo number_format($dataVo[6], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[7])){ echo number_format($dataVo[7], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[8])){ echo number_format($dataVo[8], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[9])){ echo number_format($dataVo[9], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[10])){ echo number_format($dataVo[10], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[11])){ echo number_format($dataVo[11], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[12])){ echo number_format($dataVo[12], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[13])){ echo number_format($dataVo[13], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[14])){ echo number_format($dataVo[14], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[15])){ echo number_format($dataVo[15], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[16])){ echo number_format($dataVo[16], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[17])){ echo number_format($dataVo[17], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[18])){ echo number_format($dataVo[18], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[19])){ echo number_format($dataVo[19], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[20])){ echo number_format($dataVo[20], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[21])){ echo number_format($dataVo[21], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[22])){ echo number_format($dataVo[22], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVo[23])){ echo number_format($dataVo[23], 0); }else{ echo "0"; } ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataVo as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- VO (Volumen Organizacional) -->

			<!-- VO-LDP (Volumen Organizacional Linea Diferente a la Primaria) -->
				<tr>
					<th scope="row" class="custom-width-2">VO-LDP (Volumen<br/>Organizacional Linea<br/>Diferente a la Primaria)</th>
					<td class="text-center"><?php if(isset($dataVoldp[0])){ echo number_format($dataVoldp[0], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[1])){ echo number_format($dataVoldp[1], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[2])){ echo number_format($dataVoldp[2], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[3])){ echo number_format($dataVoldp[3], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[4])){ echo number_format($dataVoldp[4], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[5])){ echo number_format($dataVoldp[5], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[6])){ echo number_format($dataVoldp[6], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[7])){ echo number_format($dataVoldp[7], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[8])){ echo number_format($dataVoldp[8], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[9])){ echo number_format($dataVoldp[9], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[10])){ echo number_format($dataVoldp[10], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[11])){ echo number_format($dataVoldp[11], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[12])){ echo number_format($dataVoldp[12], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[13])){ echo number_format($dataVoldp[13], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[14])){ echo number_format($dataVoldp[14], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[15])){ echo number_format($dataVoldp[15], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[16])){ echo number_format($dataVoldp[16], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[17])){ echo number_format($dataVoldp[17], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[18])){ echo number_format($dataVoldp[18], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[19])){ echo number_format($dataVoldp[19], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[20])){ echo number_format($dataVoldp[20], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[21])){ echo number_format($dataVoldp[21], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[22])){ echo number_format($dataVoldp[22], 0); }else{ echo "0"; } ?></td>
					<td class="text-center"><?php if(isset($dataVoldp[23])){ echo number_format($dataVoldp[23], 0); }else{ echo "0"; } ?></td>
					<td class="text-center">
						<?php

						$total = 0;
						foreach ($dataVoldp as $value){ $total = $total + $value; }
						echo number_format($total / 24, 0);

						?>
					</td>
				</tr>
			<!-- VO-LDP (Volumen Organizacional Linea Diferente a la Primaria) -->
		</tbody>
	</table>
</div>

<div class="table-responsive mt-3">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col">RANGO DE PAGO</th>
					
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
			</tr>
		</thead>

		<tbody>
			<!-- Rango Pagado -->
				<tr>
					<th scope="row" class="custom-width-2">Rango Pagado</th>
					<td class="text-center"><?php if(isset($dataRangoPago[0])){ echo $dataRangoPago[0]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[1])){ echo $dataRangoPago[1]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[2])){ echo $dataRangoPago[2]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[3])){ echo $dataRangoPago[3]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[4])){ echo $dataRangoPago[4]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[5])){ echo $dataRangoPago[5]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[6])){ echo $dataRangoPago[6]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[7])){ echo $dataRangoPago[7]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[8])){ echo $dataRangoPago[8]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[9])){ echo $dataRangoPago[9]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[10])){ echo $dataRangoPago[10]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[11])){ echo $dataRangoPago[11]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[12])){ echo $dataRangoPago[12]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[13])){ echo $dataRangoPago[13]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[14])){ echo $dataRangoPago[14]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[15])){ echo $dataRangoPago[15]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[16])){ echo $dataRangoPago[16]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[17])){ echo $dataRangoPago[17]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[18])){ echo $dataRangoPago[18]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[19])){ echo $dataRangoPago[19]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[20])){ echo $dataRangoPago[20]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[21])){ echo $dataRangoPago[21]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[22])){ echo $dataRangoPago[22]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoPago[23])){ echo $dataRangoPago[23]; }else{ echo "-"; } ?></td>
				</tr>
			<!-- Rango Pagado -->

			<!-- Rango Final -->
				<tr>
					<th scope="row" class="custom-width-2">Rango Final</th>
					<td class="text-center"><?php if(isset($dataRangoActual[0])){ echo $dataRangoActual[0]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[1])){ echo $dataRangoActual[1]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[2])){ echo $dataRangoActual[2]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[3])){ echo $dataRangoActual[3]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[4])){ echo $dataRangoActual[4]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[5])){ echo $dataRangoActual[5]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[6])){ echo $dataRangoActual[6]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[7])){ echo $dataRangoActual[7]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[8])){ echo $dataRangoActual[8]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[9])){ echo $dataRangoActual[9]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[10])){ echo $dataRangoActual[10]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[11])){ echo $dataRangoActual[11]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[12])){ echo $dataRangoActual[12]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[13])){ echo $dataRangoActual[13]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[14])){ echo $dataRangoActual[14]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[15])){ echo $dataRangoActual[15]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[16])){ echo $dataRangoActual[16]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[17])){ echo $dataRangoActual[17]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[18])){ echo $dataRangoActual[18]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[19])){ echo $dataRangoActual[19]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[20])){ echo $dataRangoActual[20]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[21])){ echo $dataRangoActual[21]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[22])){ echo $dataRangoActual[22]; }else{ echo "-"; } ?></td>
					<td class="text-center"><?php if(isset($dataRangoActual[23])){ echo $dataRangoActual[23]; }else{ echo "-"; } ?></td>
				</tr>
			<!-- Rango Final -->
		</tbody>
	</table>
</div>

<script>
	Chart.defaults.font.size = 16;
	//Gráfica puntos
		var viewChart4 = document.getElementById('viewChart4').getContext('2d');
		var viewChart4Detail = new Chart(viewChart4, {
		    type: 'line',
		    data: {
		        labels: [ 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene','Feb', '22'],
		        datasets: [
			        {
			            label: 'VP',
			            data: <?php echo $dataVpChart ?>,
			            backgroundColor: [ 'rgba(255, 206, 86, 1)', ],
			            borderColor: [ 'rgba(255, 206, 86, 1)', ],
			        },
			        {
			            label: 'VGP',
			            data: <?php echo $dataVgpChart ?>,
			            backgroundColor: [ 'rgba(255, 99, 132, 1)', ],
			            borderColor: [ 'rgba(255, 99, 132, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
			},
		});
	//Gráfica puntos

	//Gráfica Rango de Pago
		var viewChart44 = document.getElementById('viewChart44').getContext('2d');
		var viewChart44Detail = new Chart(viewChart44, {
		    type: 'line',
		    data: {
		        labels: [ 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic', '21', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic','Ene','Feb', '22'],
		        datasets: [
			        {
			            label: 'VO',
			            data: <?php echo $dataVoChart ?>,
			            backgroundColor: [ 'rgba(54, 162, 235, 1)', ],
			            borderColor: [ 'rgba(54, 162, 235, 1)', ],
			        },
			        {
			            label: 'VOLDP',
			            data: <?php echo $dataVoldpChart ?>,
			            backgroundColor: [ 'rgba(75, 192, 192, 1)', ],
			            borderColor: [ 'rgba(75, 192, 192, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
			},
		});
	//Gráfica Rango de Pago
</script>
