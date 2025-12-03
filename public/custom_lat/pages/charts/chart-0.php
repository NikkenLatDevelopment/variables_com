<?php require_once("../../functions.php"); //Funciones

$prod = $_POST["prod"];

if(trim($prod) === 'NO'){
	$serverName75 = "172.24.16.75";
}
else{
	$serverName75 = "104.130.46.73";
}

$connectionInfo75 = array("Database" => "LAT_MyNIKKEN", "UID" => "Latamti", "PWD" => 'L8$aQ7mZ!pR42^Tx');
$conn75 = sqlsrv_connect($serverName75, $connectionInfo75);
if(!$conn75){ die(print_r(sqlsrv_errors(), true)); }

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = $_POST["countrieUser"];
$rankUser = $_POST["rankUser"];
$periodoPost = $_POST["periodo"];
//Vars
// exit($periodoPost);

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
	$sql = "EXEC LAT_MyNIKKEN.dbo.ConteoComercialD1 $codeUser, $periodoPost";
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
		$nivelesProfundidad = trim($rowSap[19]);
		$comprasUltimoAno = trim($rowSap[20]) == "" ? 0 : trim($rowSap[20]);

		// $periodotoShow = trim($rowSap[23]);
		// $x++;
		// $monthToShow[$x] = $rowSap[23];
	}

	//Cerrar conexión
	//sqlsrv_close($conn);
	sqlsrv_close($conn75);
	//Cerrar conexión
//Consulta

$templateFont = '../../pages/charts/chart/arial.ttf';
$templateFontBold = '../../pages/charts/chart/arial_bold.ttf';
$templateFontRoboto = '../../pages/charts/chart/roboto.ttf';
$templateFontRobotoBold = '../../pages/charts/chart/roboto_bold.ttf';

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
		$color = imagecolorallocatealpha($template, 0, 0, 0, 127);
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
	}else{
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
	$template = imagecreatetruecolor(460, 65);
	imagesavealpha($template, true);
	$color = imagecolorallocatealpha($template, 0, 0, 0, 127);
	imagefill($template, 0, 0, $color);

	if(str_replace(" ", "-", strtolower($rankUser)) == "plata"){ $color = imagecolorallocate($template, 102, 102, 102);
	}elseif(str_replace(" ", "-", strtolower($rankUser)) == "oro"){ $color = imagecolorallocate($template, 115, 92, 62);
	}elseif(str_replace(" ", "-", strtolower($rankUser)) == "platino"){ $color = imagecolorallocate($template, 11, 83, 148);
	}elseif(str_replace(" ", "-", strtolower($rankUser)) == "diamante"){ $color = imagecolorallocate($template, 116, 27, 71);
	}elseif(str_replace(" ", "-", strtolower($rankUser)) == "directo"){ $color = imagecolorallocate($template, 70, 0, 85);
	}elseif(str_replace(" ", "-", strtolower($rankUser)) == "ejecutivo"){ $color = imagecolorallocate($template, 21, 62, 30);
	}else{ $color = imagecolorallocate($template, 11, 83, 148); }

	if($widthBox > 457){
		$nameFirst = "";
		$nameLast = "";
		$name = explode(" ", $nameUser);
		$nameTemp = "";

		$count = 0;
		$countVal = 0;
		$countName = 0;
		while($countVal == 0){
			if(isset($name[$count])){
				$nameTemp = $nameTemp . $name[$count] . " ";

				$boundingBox = imagettfbbox(25, 0, $templateFontRobotoBold, $nameTemp);
				$widthBox = $boundingBox[2] - $boundingBox[0];

				if($widthBox <= 457 && $countName == 0){
					$nameFirst = $nameFirst . $name[$count] . " ";
				}else{
					$nameLast = $nameLast . $name[$count] . " ";
					$countName++;
				}

			}else{ $countVal++; }

			$count++;
		}

		$boundingBox = imagettfbbox(25, 0, $templateFontRobotoBold, $nameFirst);
		$widthBoxNameFirst = $boundingBox[2] - $boundingBox[0];
		$widthBoxNameFirst = (457 - $widthBoxNameFirst) / 2;

		$boundingBox = imagettfbbox(25, 0, $templateFontRobotoBold, $nameLast);
		$widthBoxNameLast = $boundingBox[2] - $boundingBox[0];
		$widthBoxNameLast = (457 - $widthBoxNameLast) / 2;

		//Doble
		imagettftext($template, 25, 0, $widthBoxNameFirst, 27, $color, $templateFontRobotoBold, $nameFirst);
		imagettftext($template, 25, 0, $widthBoxNameLast, 60, $color, $templateFontRobotoBold, $nameLast);
		//Doble
	}else{
		@$boundingBox = imagettfbbox(25, 0, $templateFontRobotoBold, $nameUser);
        @$widthBoxNameFirst = $boundingBox[2] - $boundingBox[0];
        $widthBoxNameFirst = (457 - $widthBoxNameFirst) / 2;

		//Simple
		@imagettftext($template, 25, 0, $widthBoxNameFirst, 43, $color, $templateFontRobotoBold, $nameUser);
		//Simple
	}

	imagepng($template, "../../pages/charts/chart/$codeUser-text.png");
	imagedestroy($template);
//Generar nombre del Influencer

//Unir texto y foto
	//Obtener medidas de la imagen
	list($imgWidth, $imgHeight) = getimagesize('../../pages/charts/chart/' . $codeUser . '-text.png');
	//Obtener medidas de la imagen

	$template = imagecreatetruecolor(800, 800);
	imagesavealpha($template, true);
	$color = imagecolorallocatealpha($template, 255, 255, 255, 127);
	imagefill($template, 0, 0, $color);

	$photo = imagecreatefrompng('../../pages/charts/chart/' . $codeUser . '-min.png');
	$text = imagecreatefrompng('../../pages/charts/chart/' . $codeUser . '-text.png');

	imagecopy($template, $photo, 0, 0, 0, 0, 800, 800);
	imagecopy($template, $text, 299, 625, 0, 0, $imgWidth, $imgHeight);
	//Unir plantilla y foto

	//Guardar imagen
	imagepng($template, "../../pages/charts/chart/$codeUser-min.png");
	imagedestroy($template);
	//Guardar imagen
//Unir texto y foto

$template = imagecreatefrompng('../../img/general/plantilla.png');
$photo = imagecreatefrompng("../../pages/charts/chart/$codeUser-min.png");
$logo = imagecreatefromjpeg("../../img/general/logo-nikken.jpg");

@imagettftext($template, 18, 0, 395, 160, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Directo:");
@imagettftext($template, 18, 0, 520, 160, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesDirecto);

@imagettftext($template, 18, 0, 380, 190, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Superior:");
@imagettftext($template, 18, 0, 520, 190, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesSuperior);

@imagettftext($template, 18, 0, 370, 220, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Ejecutivo:");
@imagettftext($template, 18, 0, 520, 220, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesEjecutivo);

@imagettftext($template, 18, 0, 413, 250, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Plata:");
@imagettftext($template, 18, 0, 520, 250, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesPlata);

@imagettftext($template, 18, 0, 427, 280, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Oro:");
@imagettftext($template, 18, 0, 520, 280, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesOro);

@imagettftext($template, 18, 0, 390, 310, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Platino:");
@imagettftext($template, 18, 0, 520, 310, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesPlatino);

@imagettftext($template, 18, 0, 362, 340, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Diamante:");
@imagettftext($template, 18, 0, 520, 340, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesDiamante);

@imagettftext($template, 18, 0, 308, 370, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Diamante Real:");
@imagettftext($template, 18, 0, 520, 370, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, $avancesDiamanteReal);

#################################################################################################################################################

@imagettftext($template, 25, 0, 440, 559, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Plata:");
@imagettftext($template, 23, 0, 540, 559, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresPlata, 0));

@imagettftext($template, 25, 0, 458, 601, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Oro:");
@imagettftext($template, 23, 0, 540, 601, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresOro, 0));

@imagettftext($template, 25, 0, 408, 645, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Platino:");
@imagettftext($template, 23, 0, 540, 645, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresPlatino, 0));

@imagettftext($template, 25, 0, 370, 687, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Diamante:");
@imagettftext($template, 23, 0, 540, 687, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresDiamante, 0));

@imagettftext($template, 25, 0, 294, 727, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Diamante Real:");
@imagettftext($template, 23, 0, 540, 727, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($lideresDiamanteReal, 0));

#################################################################################################################################################

@imagettftext($template, 25, 0, 200, 963, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "No. de Socio Independiente:");
@imagettftext($template, 23, 0, 640, 963, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($numeroInfluencers, 0));

@imagettftext($template, 25, 0, 200, 1014, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "No. de Clientes Preferentes:");
@imagettftext($template, 23, 0, 640, 1014, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($numeroClientesPreferentes, 0));

@imagettftext($template, 25, 0, 147, 1065, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Activos Mensuales (Promedio):");
@imagettftext($template, 23, 0, 640, 1065, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($activosMensuales, 0));

@imagettftext($template, 25, 0, 160, 1114, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Incorporados Mes (Promedio):");
@imagettftext($template, 23, 0, 640, 1114, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($incorporadosMes, 0));

@imagettftext($template, 25, 0, 120, 1165, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Socios Independientes Frontales:");
@imagettftext($template, 23, 0, 640, 1165, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($influencersFrontales, 0));

@imagettftext($template, 25, 0, 262, 1214, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Niveles de Profundidad:");
@imagettftext($template, 23, 0, 640, 1214, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, number_format($nivelesProfundidad, 0));

@imagettftext($template, 25, 0, 99, 1265, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Compras del Último Año (Dólares):");
@imagettftext($template, 23, 0, 640, 1265, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, '$' . number_format($comprasUltimoAno, 0) . ' USD');

#################################################################################################################################################

@imagettftext($template, 25, 0, 950, 1250, imagecolorallocate($template, 102, 51, 102), $templateFontRobotoBold, "Informe Variables Comerciales por Socio Independiente");
@imagettftext($template, 20, 0, 950, 1280, imagecolorallocate($template, 102, 51, 102), $templateFontRoboto, "Periodo de Medición: " . $monthsYear[$periodoPost - 99] . " a " . $monthsYear[$periodoPost]);

imagecopymerge($template, $photo, 986, 192, 0, 0, 800, 800, 100);

imagepng($template, "../../pages/charts/chart/$codeUser.png");
imagedestroy($template);

?>
<img src="custom_lat/pages/charts/chart/<?php echo $codeUser ?>.png?<?php echo date("YmdHis") ?>" class="img-fluid mt-4 pt-4">
<!-- <img src="custom/img/logo-black.png?<?php echo date("YmdHis") ?>" class="img-fluid mt-4 pt-4 pull-right w-25" style="float: right;opacity: 0.5;margin-top: -10px !important;"> -->
