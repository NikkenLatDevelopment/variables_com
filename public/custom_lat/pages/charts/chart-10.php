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
$countrieUser = $_POST["countrieUser"];
$rankUser = $_POST["rankUser"];
$periodoPost = $_POST["periodo"];
//Vars

//Consulta
	$countries = "";

	$sql = "SELECT DISTINCT LTRIM(RTRIM (Country)) from TreePerId_ORG_PER_Comercial_gen ($codeUser,$periodoPost) ORDER BY  ltrim(rtrim(country)) ASC";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) { 
		if(letterCountrieGenealogy(trim($rowSap[0])) != ""){
			$countries = $countries . letterCountrieGenealogy(trim($rowSap[0])) . ", "; 
		}
	}

	$countries = substr($countries, 0, -2);

    $sql = "EXEC ConteoComercialD1 $codeUser, $periodoPost";
    //$sql = "EXEC ConteoComercialD1_test $codeUser, $periodoPost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoShow = "";
	$monthToShow = [];
	$x = 0;
	$rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC);
	if($rowSap > 0) {
		$periodotoShow = trim($rowSap[19]);
		$x++;
		$monthToShow[$x] = $rowSap[19];
	}
//Consulta

?>

<div style="padding-top: 100px;">
	<div style="width: 100%; height: 1300px; position: relative;">
		<!-- <div style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; background: transparent;"></div> -->
		<iframe src="https://testmy.nikkenlatam.com/getRadialGen/<?php echo base64_encode($codeUser) ?>/<?php echo $periodoPost ?>" frameborder="0" style="width: 90%; height: 1300px; margin-left: 10%;" id="radialGraph"></iframe>
		
		<div style="position: absolute; bottom: 150px; left: 50px; max-width: 450px;">
			<img src="custom_lat/pages/charts/chart/<?php echo $codeUser ?>-min.png?<?php echo date("YmdHis") ?>" class="img-fluid mt-2">

			<div class="h5 fw-bold mt-3 c-c-1">Informe Variables Comerciales por Socio Independiente</div>
			<div class="h4 fw-bold mt-3 mb-0 c-c-1">Países:</div>
			<div class="h6 c-c-1"><?php echo $countries ?></div>
			<!-- <div class="h6 mt-3 c-c-1"><span class="fw-bold">Periodo de Medición:</span> <?php echo $monthsYear[$monthToShow[1]] ?> a <?php echo $monthsYear[$periodoPost] ?>.</div> -->
			<div class="h6 mt-3 c-c-1"><span class="fw-bold">Periodo de cierre: </span><?php echo $monthsYear[$periodoPost] ?>.</div>
		</div>
		<img src="custom_lat/img/logo-black.png?<?php echo date("YmdHis") ?>" class="img-fluid mt-4 pt-4 pull-right w-25" style="float: right;opacity: 0.5;margin-top: -200px !important;">
	</div>
</div>