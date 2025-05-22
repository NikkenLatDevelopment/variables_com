<?php 

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
$paises = "";
$date = new DateTime();
//Others

$sql = "EXEC ps_SD_Diapositiva1 202203";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	if($row_sap[0] == $code){
		$paises = trim($row_sap[19]);
	}
}

//Obtener tamaño genealogia
	list($width, $height) = getimagesize("/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/img/genealogy/$code.png");
	$heightNew = round(($height * 1800) / $width);
//Obtener tamaño genealogia

$template = imagescale(imagecreatefrompng('/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/img/general/background.png'), 2000, 1417);
$photo = imagescale(imagecreatefrompng("/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/img/clients/$code.png"), 500, 500);
$genealogy = imagescale(imagecreatefrompng("/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/img/genealogy/$code.png"), 1800, $heightNew);

$color = imagecolorallocate($template, 102, 51, 102);
$font = '/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/pages/charts/arial.ttf';
$fontBold = '/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/pages/charts/arial_bold.ttf';

imagecopymerge($template, $genealogy, 300, 0, 0, 0, 1800, $heightNew, 100);
imagecopymerge($template, $photo, 50, 700, 0, 0, 500, 500, 100);
imagettftext($template, 30, 0, 50, 1260, $color, $fontBold, 'Países');

$counter = 0;
$countryHistory = '';
$dataCountry = explode(',', $paises);
$top = 1300;
foreach ($dataCountry as $values){
	if($counter >= 8){
		imagettftext($template, 25, 0, 50, $top, $color, $font, substr($countryHistory, 0, -2));

		$top = $top + 40;
		$countryHistory = "";
		$counter = 0;
	}else{
		$countryHistory = $countryHistory . $values . ", ";
		$counter++;
	}
}

if($countryHistory != ""){ imagettftext($template, 25, 0, 50, $top, $color, $font, substr($countryHistory, 0, -2)); }

imagepng($template, "/home/forge/panelmrkt.nikkenlatam.com/seminario-diamante-graficas/custom/pages/charts/view-chart-9/$code.png");
imagedestroy($template);

?>
<img src="custom/pages/charts/view-chart-9/<?php echo $code ?>.png?<?php echo $date->getTimestamp(); ?>" class="img-fluid">
