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
$countrieUser = trim($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodoPost = $_POST["periodo"];
$finalName = $_POST["nameUser"];

//Consulta
$avancesPlata = 0;
$avancesOro = 0;
$avancesPlatino = 0;
$avancesDiamante = 0;
$avancesDiamanteReal = 0;
$lideresPlata = 0;
$lideresOro = 0;
$lideresPlatino = 0;
$lideresDiamante = 0;
$lideresDiamanteReal = 0;
$numeroInfluencers = 0;
$numeroClientesPreferentes = 0;
$activosMensuales = 0;
$incorporadosMes = 0;
$influencersFrontales = 0;
$nivelesProfundidad = 0;
$comprasUltimoAno = 0;

//$sql = "EXEC ConteoComercialD1_test $codeUser, $periodoPost";
$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.ConteoComercialD1_usa $codeUser, $periodoPost";
$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
$periodotoShow = "";
$monthToShow = [];
$x = 0;
$rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC);
if($rowSap > 0) {
	$avancesDirecto = trim($rowSap[1]) == "0" ? "" : trim($rowSap[1]);
	$avancesSuperior = trim($rowSap[2]) == "0" ? "" : trim($rowSap[2]);
	$avancesEjecutivo = trim($rowSap[3]) == "0" ? "" : trim($rowSap[3]);
	$avancesPlata = trim($rowSap[4]) == "0" ? "" : trim($rowSap[4]);
	$avancesOro = trim($rowSap[5]) == "0" ? "" : trim($rowSap[5]);
	$avancesPlatino = trim($rowSap[6]) == "0" ? "" : trim($rowSap[6]);
	$avancesDiamante = trim($rowSap[7]) == "0" ? "" : trim($rowSap[7]);
	$avancesDiamanteReal = trim($rowSap[8]) == "0" ? "" : trim($rowSap[8]);
	$lideresPlata = trim($rowSap[9]);
	$lideresOro = trim($rowSap[10]);
	$lideresPlatino = trim($rowSap[11]);
	$lideresDiamante = trim($rowSap[12]);
	$lideresDiamanteReal = trim($rowSap[13]);
	$numeroInfluencers = trim($rowSap[14]);
	$numeroClientesPreferentes = trim($rowSap[15]);
	$activosMensuales = trim($rowSap[16]);
	$incorporadosMes = trim($rowSap[17]);
	$influencersFrontales = trim($rowSap[18]);
	$nivelesProfundidad = trim($rowSap[20]);
	$comprasUltimoAno = trim($rowSap[21]) == "" ? 0 : trim($rowSap[21]);

	$monthActiveConsultant = trim($rowSap[16]);
	$monthActiveCustomer = trim($rowSap[26]);
	$monthConsultantSignUps = trim($rowSap[24]);
	$monthCustomerSignUp = trim($rowSap[25]);

	$frontLineConsultant = trim($rowSap[18]);
	$frontLineCustomers = trim($rowSap[19]);
}

//Cerrar conexión
sqlsrv_close($conn75);
//Cerrar conexión

// echo "<pre>";
// print_r($rowSap);
// echo "</pre>";
// exit;

$templateFont = '../../pages/charts/chart/arial.ttf';
$templateFontBold = '../../pages/charts/chart/arial_bold.ttf';
$templateFontRoboto = '../../pages/charts/chart/roboto.ttf';
$templateFontRobotoBold = '../../pages/charts/chart/roboto_bold.ttf';
$templateFontLatoBold = '../../pages/charts/chart/Lato-Black.ttf';

//Generar imagen de Influencer
if (file_exists('../../img/codes/' . $codeUser . '-min.jpg')) {
	//Obtener medidas de la imagen
	list($imgWidth, $imgHeight) = getimagesize('../../img/codes/' . $codeUser . '-min.jpg');
	//Obtener medidas de la imagen

	//Obtener nuevas medidas de la imagen
	$newImgWidth = 800;
	$newImgHeight = ($imgHeight * (($newImgWidth * 100) / $imgWidth)) / 100;
	//Obtener nuevas medidas de la imagen

	$template = imagecreatetruecolor(800, 800);
	imagesavealpha($template, true);
	$color = imagecolorallocatealpha($template, 0, 0, 0, 107);
	imagefill($template, 0, 0, $color);

	$photo = imagescale(imagecreatefromjpeg('../../img/codes/' . $codeUser . '-min.jpg'), $newImgWidth, $newImgHeight);
	$templatePhoto = imagecreatefrompng('../../img/ranks/' . str_replace(" ", "-", strtolower($rankUser)) . '/' . $countrieUser . '.png');

	imagecopy($template, $photo, 0, 0, 0, 0, $newImgWidth, 800);
	imagecopy($template, $templatePhoto, 0, 0, 0, 0, 800, 800);
	//Unir plantilla y foto

	//Guardar imagen
	imagepng($template, "../../pages/charts/chart/$codeUser-min.png");
	imagedestroy($template);
	//Guardar imagen
}
else{
	$template = imagecreatetruecolor(800, 800);
	imagesavealpha($template, true);
	$color = imagecolorallocatealpha($template, 0, 0, 0, 127);
	imagefill($template, 0, 0, $color);

	$templatePhoto = imagecreatefrompng('../../img/ranks/' . str_replace(" ", "-", strtolower($rankUser)) . '/' . $countrieUser . '.png');

	imagecopy($template, $templatePhoto, 0, 0, 0, 0, 800, 800);
	//Unir plantilla y foto

	//Guardar imagen
	imagepng($template, "../../pages/charts/chart/$codeUser-min.png");
	imagedestroy($template);
	//Guardar imagen
}
//Generar imagen de Influencer

//Generar nombre del Influencer
@$boundingBox = imagettfbbox(25, 0, $templateFontRobotoBold, $nameUser);
@$widthBox = $boundingBox[2] - $boundingBox[0];
$template = imagecreatetruecolor(775, 65);
imagesavealpha($template, true);
$color = imagecolorallocatealpha($template, 0, 0, 0, 127);
// $color = imagecolorallocatealpha($template, 0, 0, 0, 0);
imagefill($template, 0, 0, $color);

if(str_replace(" ", "-", strtolower($rankUser)) == "plata"){ $color = imagecolorallocate($template, 102, 102, 102);
}elseif(str_replace(" ", "-", strtolower($rankUser)) == "oro"){ $color = imagecolorallocate($template, 115, 92, 62);
}elseif(str_replace(" ", "-", strtolower($rankUser)) == "platino"){ $color = imagecolorallocate($template, 11, 83, 148);
}elseif(str_replace(" ", "-", strtolower($rankUser)) == "diamante"){ $color = imagecolorallocate($template, 116, 27, 71);
}elseif(str_replace(" ", "-", strtolower($rankUser)) == "directo"){ $color = imagecolorallocate($template, 70, 0, 85);
}elseif(str_replace(" ", "-", strtolower($rankUser)) == "ejecutivo"){ $color = imagecolorallocate($template, 21, 62, 30);
}else{ $color = imagecolorallocate($template, 255, 255, 255); }

$color = imagecolorallocate($template, 255, 255, 255);

// if($widthBox > 457){
// 	$nameFirst = "";
// 	$nameLast = "";
// 	$name = explode(" ", $nameUser);
// 	$nameTemp = "";

// 	$count = 0;
// 	$countVal = 0;
// 	$countName = 0;
// 	while($countVal == 0){
// 		if(isset($name[$count])){
// 			$nameTemp = $nameTemp . $name[$count] . " ";

// 			$boundingBox = imagettfbbox(25, 0, $templateFontLatoBold, $nameTemp);
// 			// $widthBox = $boundingBox[2] - $boundingBox[0];
// 			$widthBox = $boundingBox[2];

// 			if($widthBox <= 457 && $countName == 0){
// 				$nameFirst = $nameFirst . $name[$count] . " ";
// 			}else{
// 				$nameLast = $nameLast . $name[$count] . " ";
// 				$countName++;
// 			}

// 		}else{ $countVal++; }

// 		$count++;
// 	}

// 	$boundingBox = imagettfbbox(25, 0, $templateFontLatoBold, $nameFirst);
// 	$widthBoxNameFirst = $boundingBox[2] - $boundingBox[0];
// 	$widthBoxNameFirst = (457 - $widthBoxNameFirst) / 2;

// 	$boundingBox = imagettfbbox(25, 0, $templateFontLatoBold, $nameLast);
// 	$widthBoxNameLast = $boundingBox[2] - $boundingBox[0];
// 	$widthBoxNameLast = (457 - $widthBoxNameLast) / 2;

// 	//Doble
// 	imagettftext($template, 25, 0, $widthBoxNameFirst, 27, $color, $templateFontLatoBold, $nameFirst);
// 	imagettftext($template, 25, 0, $widthBoxNameLast, 60, $color, $templateFontLatoBold, $nameLast);
// 	//Doble
// }
// else{
// 	@$boundingBox = imagettfbbox(25, 0, $templateFontLatoBold, $nameUser);
// 	@$widthBoxNameFirst = $boundingBox[2] - $boundingBox[0];
// 	$widthBoxNameFirst = (457 - $widthBoxNameFirst) / 2;

// 	//Simple
// 	@imagettftext($template, 25, 0, $widthBoxNameFirst, 43, $color, $templateFontLatoBold, $nameUser);
// 	//Simple
// }

//Simple
// @imagettftext($template, 25, 0, $widthBoxNameFirst, 43, $color, $templateFontLatoBold, $nameUser);
@imagettftext($template, 25, 0, $widthBoxNameFirst, 43, $color, $templateFontLatoBold, $nameUser);

imagepng($template, "../../pages/charts/chart/$codeUser-text.png");
imagedestroy($template);
//Generar nombre del Influencer

//Unir texto y foto
//Obtener medidas de la imagen
list($imgWidth, $imgHeight) = getimagesize('../../pages/charts/chart/' . $codeUser . '-text.png');
//Obtener medidas de la imagen

$template = imagecreatetruecolor(800, 800);
imagesavealpha($template, true);
$color = imagecolorallocatealpha($template, 0, 0, 0, 127);
imagefill($template, 0, 0, $color);

$photo = imagecreatefrompng('../../pages/charts/chart/' . $codeUser . '-min.png');
$text = imagecreatefrompng('../../pages/charts/chart/' . $codeUser . '-text.png');

imagecopy($template, $photo, 0, 0, 0, 0, 800, 800);
imagecopy($template, $text, 10, 710, 0, 0, $imgWidth, $imgHeight);
//Unir plantilla y foto

//Guardar imagen
imagepng($template, "../../pages/charts/chart/$codeUser-min.png");
imagedestroy($template);
//Guardar imagen
//Unir texto y foto

$template = imagecreatefrompng('../../img/general/plantilla.png');
$photo = imagecreatefrompng("../../pages/charts/chart/$codeUser-min.png");
$logo = imagecreatefromjpeg("../../img/general/logo-nikken.jpg");

@imagettftext($template, 16, 0, 250, 170, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesDirecto));

@imagettftext($template, 16, 0, 250, 205, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesSuperior));

@imagettftext($template, 16, 0, 250, 240, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesEjecutivo));

@imagettftext($template, 16, 0, 250, 275, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesPlata));

@imagettftext($template, 16, 0, 250, 310, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesOro));

@imagettftext($template, 16, 0, 250, 345, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesPlatino));

@imagettftext($template, 16, 0, 250, 380, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesDiamante));

@imagettftext($template, 16, 0, 250, 415, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, reformatDate($avancesDiamanteReal));

#################################################################################################################################################

// @imagettftext($template, 25, 0, 440, 559, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Plata:");
@imagettftext($template, 18, 0, 250, 599, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresPlata, 0));

// @imagettftext($template, 25, 0, 458, 601, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Oro:");
@imagettftext($template, 18, 0, 250, 636, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresOro, 0));

// @imagettftext($template, 25, 0, 408, 645, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Platino:");
@imagettftext($template, 18, 0, 250, 670, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresPlatino, 0));

// @imagettftext($template, 25, 0, 370, 687, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Diamante:");
@imagettftext($template, 18, 0, 250, 707, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresDiamante, 0));

// @imagettftext($template, 25, 0, 294, 727, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Diamante Real:");
@imagettftext($template, 18, 0, 250, 743, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresDiamanteReal, 0));

#################################################################################################################################################

// @imagettftext($template, 25, 0, 360, 963, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "No. de Influencer:");
@imagettftext($template, 16, 0, 455, 933, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($numeroInfluencers, 0));

// @imagettftext($template, 25, 0, 200, 1014, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "No. de Clientes Preferentes:");
@imagettftext($template, 16, 0, 455, 970, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($numeroClientesPreferentes, 0));

// @imagettftext($template, 25, 0, 147, 1065, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Activos Mensuales (Promedio):");
@imagettftext($template, 16, 0, 455, 1005, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($monthActiveConsultant, 0));

// @imagettftext($template, 25, 0, 147, 1065, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Activos Mensuales (Promedio):");
@imagettftext($template, 16, 0, 455, 1040, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($monthActiveCustomer, 0));

// @imagettftext($template, 25, 0, 147, 1065, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Activos Mensuales (Promedio):");
@imagettftext($template, 16, 0, 455, 1075, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($monthConsultantSignUps, 0));

// @imagettftext($template, 25, 0, 160, 1114, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Incorporados Mes (Promedio):");
@imagettftext($template, 16, 0, 455, 1110, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($monthCustomerSignUp, 0));

// @imagettftext($template, 25, 0, 293, 1165, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Influencers Frontales:");
@imagettftext($template, 16, 0, 455, 1143, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($frontLineConsultant, 0));

// @imagettftext($template, 25, 0, 293, 1165, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Influencers Frontales:");
@imagettftext($template, 16, 0, 455, 1178, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($frontLineCustomers, 0));

// @imagettftext($template, 25, 0, 262, 1214, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Niveles de Profundidad:");
@imagettftext($template, 16, 0, 455, 1214, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($nivelesProfundidad, 0));

// @imagettftext($template, 25, 0, 99, 1265, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Compras del Último Año (Dólares):");
@imagettftext($template, 16, 0, 455, 1249, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, '$' . number_format($comprasUltimoAno, 0) . ' USD');

#################################################################################################################################################

// @imagettftext($template, 25, 0, 950, 1250, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Informe Variables Comerciales por Influencer");
@imagettftext($template, 24, 0, 1350, 270, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, "September 2022 to August 2024");

imagecopymerge($template, $photo, 830, 470, 0, 0, 800, 800, 100);

imagepng($template, "../../pages/charts/chart/$codeUser.png");
imagedestroy($template);

?>
<img src="custom_na_24/pages/charts/chart/<?php echo $codeUser ?>.png?v=<?php echo Date('YmdHis') ?>" class="img-fluid mt-4 pt-4">

