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
$cassRango = "";
$cassPais = "";
$rangoPla = "";
$rangoOro = "";
$rangoPlo = "";
$rangoDia = "";
$rangoDrl = "";
$lidPla = "";
$lidOro = "";
$lidPlo = "";
$lidDia = "";
$lidDrl = "";
$totalAsesores = "";
$activos = "";
$incorporaciones = "";
$frontalidad = "";
$profundidad = "";
$compraMes = "";

$date = new DateTime();
$dataComprasOrganizacion = array();
//Others

$sql = "EXEC ps_SD_Diapositiva1 202204";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	if($row_sap[0] == $code){
		$codigo = trim($row_sap[0]);
		$cassRango = trim($row_sap[1]);
		$cassPais = trim($row_sap[2]);
		$rangoPla = trim($row_sap[3]);
		$rangoOro = trim($row_sap[4]);
		$rangoPlo = trim($row_sap[5]);
		$rangoDia = trim($row_sap[6]);
		$rangoDrl = trim($row_sap[7]);
		$lidPla = trim($row_sap[8]);
		$lidOro = trim($row_sap[9]);
		$lidPlo = trim($row_sap[10]);
		$lidDia = trim($row_sap[11]);
		$lidDrl = trim($row_sap[12]);
		$totalAsesores = trim($row_sap[13]);
		$activos = trim($row_sap[14]);
		$incorporaciones = trim($row_sap[15]);
		$frontalidad = trim($row_sap[16]);
		$profundidad = trim($row_sap[17]);
		$compraMes = trim($row_sap[18]);

		if($compraMes == ""){ $compraMes = 0; }
		$compraMes = number_format($compraMes, 0);
	}
}

$period = new DateTime('2022-04-01');
$counter = 0;

while($counter < 24){
	$periodQuery = $period->format('Ym');

	$sql = "SELECT * FROM SD_DIAPOSITIVA3 WHERE VASS_CODIGO = '$code' AND PERIODO = '$periodQuery'";
    $recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
    while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$codigo = $row_sap[0];
		$periodo = $row_sap[1];

		$comprasOrganizacion = trim($row_sap[3]);
		if($comprasOrganizacion == ""){ $comprasOrganizacion = 0; }

		//Llenar array
	    $dataComprasOrganizacion = array_merge($dataComprasOrganizacion, array($comprasOrganizacion));
		//Llenar array
	}

	$period->modify('+1 month');
	$period = $period->format('Y-m-01');
	$period = new DateTime($period);
	$counter++;
}

$total_prev = 0;
$total_next = 0;
$counter = 0;

foreach ($dataComprasOrganizacion as $value){
	if($counter < 12){ $total_prev = $total_prev + $value;
	}else{ $total_next = $total_next + $value; }
	$counter++;
}

$compraMes = number_format($total_next, 2);

//$template = imagecreatefrompng('/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/img/general/plantilla.png');
$template = imagecreatefrompng('../../img/general/plantilla.png');
//$photo = imagescale(imagecreatefrompng("/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/img/clients/$code.png"), 793, 793);
$photo = imagescale("https://panelmkt.nikkenlatam.com/TEMPORAL/informe-variables-comerciales-asesor/custom/img/codes/21590503-min.jpg", 793, 793);
$color = imagecolorallocate($template, 102, 51, 102);
$font = '/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/pages/charts/arial.ttf';


imagettftext($template, 23, 0, 530, 228, $color, $font, $rangoPla);
imagettftext($template, 23, 0, 530, 272, $color, $font, $rangoOro);
imagettftext($template, 23, 0, 530, 314, $color, $font, $rangoPlo);
imagettftext($template, 23, 0, 530, 358, $color, $font, $rangoDia);
imagettftext($template, 23, 0, 530, 402, $color, $font, $rangoDrl);


imagettftext($template, 23, 0, 575, 628, $color, $font, '58');
imagettftext($template, 23, 0, 575, 674, $color, $font, '9');
imagettftext($template, 23, 0, 575, 718, $color, $font, '6');
imagettftext($template, 23, 0, 575, 762, $color, $font, '0');
imagettftext($template, 23, 0, 575, 805, $color, $font, $lidDrl);


imagettftext($template, 23, 0, 620, 1052, $color, $font, '1320');
imagettftext($template, 23, 0, 620, 1096, $color, $font, '259');
imagettftext($template, 23, 0, 620, 1138, $color, $font, '58');
imagettftext($template, 23, 0, 620, 1182, $color, $font, '68');
imagettftext($template, 23, 0, 620, 1226, $color, $font, '8');
imagettftext($template, 23, 0, 620, 1270, $color, $font,  '1,126,111.00' );

imagettftext($template, 23, 0, 1229, 1320, $color, $font, 'Periodo: Abril 2020 a Marzo 2022');

imagecopymerge($template, $photo, 1040, 269, 0, 0, 793, 790, 100);

imagepng($template, "/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/pages/charts/view-chart-0/$code.png");
imagedestroy($template);

?>
<img src="custom/pages/charts/view-chart-0/<?php echo $code ?>.png?<?php echo $date->getTimestamp(); ?>" class="img-fluid">
