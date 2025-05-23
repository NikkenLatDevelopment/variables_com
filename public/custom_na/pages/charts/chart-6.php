<?php require_once("../../functions.php"); //Funciones

//Conexión 75
$serverName75 = "104.130.46.73";
// $serverName75 = "172.24.16.75";
$connectionInfo75 = array("Database" => "LAT_MyNIKKEN_TEST", "UID" => "Latamti", "PWD" => "N1k3N$17!");
$conn75 = sqlsrv_connect($serverName75, $connectionInfo75);
if(!$conn75){ die(print_r(sqlsrv_errors(), true)); }

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = letterCountrie($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodoPost = $_POST["periodo"];
$lang = $_POST["lang"];
// $periodoPost = 202310;
//Vars

// $periodoPost = substr($periodoPost, 0, -2) . '12';

//Others
$dataCompras = array();
$dataComprasOrganizacion2021 = array();
$dataComprasOrganizacion2022 = array();
$dataIncorporaciones = array();
$dataGenealogia = array();
$dataIncorporacionOrganizacion2021 = array();
$dataIncorporacionOrganizacion2022 = array();
$dataIncorporacionActividad2021 = array();
$dataIncorporacionActividad2022 = array();
//Others

//Consulta
	//$sql = "EXEC Compras $codeUser, $periodoPost";
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Compras_org_anual_usa $codeUser, $periodoPost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	$periodotoSho = "";
	$aniosDif = [];
	$monthToShow = [];
	$x = 0;
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$compraTotal = trim($rowSap[1]);
		$periodo = trim($rowSap[2]);

		$periodotoShow = trim($rowSap[2]);
		$x++;
		$monthToShow[$x] = $rowSap[2];
		$aniosDif[$x] = $rowSap[3];

		//Guardar datos en array
		$dataCompras[$periodo] = array("compraTotal" => $compraTotal);
		//Guardar datos en array
	}

	$aniosDif = array_unique($aniosDif);
	$i = 1;

	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_usa_24m $codeUser, $periodoPost";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$incorporacionesCisFrontales = trim($rowSap[1]);
		$inscripcionesTotales = trim($rowSap[5]);
		$totalActivosMensuales = trim($rowSap[8]);
		$periodo = trim($rowSap[14]);

		//Guardar datos en array
		$dataIncorporaciones[$periodo] = array("incorporacionesCisFrontales" => $incorporacionesCisFrontales, "inscripcionesTotales" => $inscripcionesTotales, "totalActivosMensuales" => $totalActivosMensuales);
		//Guardar datos en array
	}

	//$sql = "SELECT Periodo, Conteo from TotalORG_ReporteVariables where asociateid = $codeUser";
	$sql = "EXEC LAT_MyNIKKEN_TEST.dbo.Incorporaciones_aual_parametrizacion_usa $codeUser, $periodoPost;";
	$recordSet = sqlsrv_query($conn75, $sql) or die( print_r( sqlsrv_errors(), true));
	while($rowSap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
		$periodoGenealogia = trim($rowSap[2]);
		$totalGenealogia = trim($rowSap[1]);

		//Guardar datos en array
		$dataGenealogia[$periodoGenealogia] = array("periodo" => $periodoGenealogia, "total" => $totalGenealogia);
		//Guardar datos en array
	}
	

	//Cerrar conexión
	sqlsrv_close($conn75);
	//Cerrar conexión
//Consulta

// $monthLabelGraph = [];
$monthLabelGraph = array();

(intval($monthToShow[12]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Jan') : null;
(intval($monthToShow[11]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Feb') : null;
(intval($monthToShow[10]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Mar') : null;
(intval($monthToShow[9]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Apr') : null;
(intval($monthToShow[8]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'May') : null;
(intval($monthToShow[7]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Jun') : null;
(intval($monthToShow[6]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Jul') : null;
(intval($monthToShow[5]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Aug') : null;
(intval($monthToShow[4]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Sep') : null;
(intval($monthToShow[3]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Oct') : null;
(intval($monthToShow[2]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Nov') : null;
(intval($monthToShow[1]) <= intval($periodoPost)) ? array_push($monthLabelGraph, 'Dec') : null;

(intval($monthToShow[12]) <= intval($periodoPost)) ? $classEne = "" : $classEne = "hidden";
(intval($monthToShow[11]) <= intval($periodoPost)) ? $classFeb = "" : $classFeb = "hidden";
(intval($monthToShow[10]) <= intval($periodoPost)) ? $classMar = "" : $classMar = "hidden";
(intval($monthToShow[9]) <= intval($periodoPost)) ? $classAbr = "" : $classAbr = "hidden";
(intval($monthToShow[8]) <= intval($periodoPost)) ? $classMay = "" : $classMay = "hidden";
(intval($monthToShow[7]) <= intval($periodoPost)) ? $classJun = "" : $classJun = "hidden";
(intval($monthToShow[6]) <= intval($periodoPost)) ? $classJul = "" : $classJul = "hidden";
(intval($monthToShow[5]) <= intval($periodoPost)) ? $classAgo = "" : $classAgo = "hidden";
(intval($monthToShow[4]) <= intval($periodoPost)) ? $classSep = "" : $classSep = "hidden";
(intval($monthToShow[3]) <= intval($periodoPost)) ? $classOct = "" : $classOct = "hidden";
(intval($monthToShow[2]) <= intval($periodoPost)) ? $classNov = "" : $classNov = "hidden";
(intval($monthToShow[1]) <= intval($periodoPost)) ? $classDic = "" : $classDic = "hidden";

//Graficas
	// if($classEne == ""){$price = isset($dataCompras[$monthToShow[24]]) ? $dataCompras[$monthToShow[24]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classFeb == ""){$price = isset($dataCompras[$monthToShow[23]]) ? $dataCompras[$monthToShow[23]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classMar == ""){$price = isset($dataCompras[$monthToShow[22]]) ? $dataCompras[$monthToShow[22]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classAbr == ""){$price = isset($dataCompras[$monthToShow[21]]) ? $dataCompras[$monthToShow[21]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classMay == ""){$price = isset($dataCompras[$monthToShow[20]]) ? $dataCompras[$monthToShow[20]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classJun == ""){$price = isset($dataCompras[$monthToShow[19]]) ? $dataCompras[$monthToShow[19]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classJul == ""){$price = isset($dataCompras[$monthToShow[18]]) ? $dataCompras[$monthToShow[18]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classAgo == ""){$price = isset($dataCompras[$monthToShow[17]]) ? $dataCompras[$monthToShow[17]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classSep == ""){$price = isset($dataCompras[$monthToShow[16]]) ? $dataCompras[$monthToShow[16]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classOct == ""){$price = isset($dataCompras[$monthToShow[15]]) ? $dataCompras[$monthToShow[15]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classNov == ""){$price = isset($dataCompras[$monthToShow[14]]) ? $dataCompras[$monthToShow[14]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}
	// if($classDic == ""){$price = isset($dataCompras[$monthToShow[13]]) ? $dataCompras[$monthToShow[13]]["compraTotal"] : 0; $dataComprasOrganizacion2021 = array_merge($dataComprasOrganizacion2021, array($price));}

	if($classEne == ""){$price = isset($dataCompras[$monthToShow[12]]) ? $dataCompras[$monthToShow[12]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classFeb == ""){$price = isset($dataCompras[$monthToShow[11]]) ? $dataCompras[$monthToShow[11]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classMar == ""){$price = isset($dataCompras[$monthToShow[10]]) ? $dataCompras[$monthToShow[10]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classAbr == ""){$price = isset($dataCompras[$monthToShow[9]]) ? $dataCompras[$monthToShow[9]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classMay == ""){$price = isset($dataCompras[$monthToShow[8]]) ? $dataCompras[$monthToShow[8]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classJun == ""){$price = isset($dataCompras[$monthToShow[7]]) ? $dataCompras[$monthToShow[7]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classJul == ""){$price = isset($dataCompras[$monthToShow[6]]) ? $dataCompras[$monthToShow[6]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classAgo == ""){$price = isset($dataCompras[$monthToShow[5]]) ? $dataCompras[$monthToShow[5]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classSep == ""){$price = isset($dataCompras[$monthToShow[4]]) ? $dataCompras[$monthToShow[4]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classOct == ""){$price = isset($dataCompras[$monthToShow[3]]) ? $dataCompras[$monthToShow[3]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classNov == ""){$price = isset($dataCompras[$monthToShow[2]]) ? $dataCompras[$monthToShow[2]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}
	if($classDic == ""){$price = isset($dataCompras[$monthToShow[1]]) ? $dataCompras[$monthToShow[1]]["compraTotal"] : 0; $dataComprasOrganizacion2022 = array_merge($dataComprasOrganizacion2022, array($price));}

	// if($classEne == ""){$price = isset($dataIncorporaciones[$monthToShow[24]]) ? $dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classFeb == ""){$price = isset($dataIncorporaciones[$monthToShow[23]]) ? $dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classMar == ""){$price = isset($dataIncorporaciones[$monthToShow[22]]) ? $dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classAbr == ""){$price = isset($dataIncorporaciones[$monthToShow[21]]) ? $dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classMay == ""){$price = isset($dataIncorporaciones[$monthToShow[20]]) ? $dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classJun == ""){$price = isset($dataIncorporaciones[$monthToShow[19]]) ? $dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classJul == ""){$price = isset($dataIncorporaciones[$monthToShow[18]]) ? $dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classAgo == ""){$price = isset($dataIncorporaciones[$monthToShow[17]]) ? $dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classSep == ""){$price = isset($dataIncorporaciones[$monthToShow[16]]) ? $dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classOct == ""){$price = isset($dataIncorporaciones[$monthToShow[15]]) ? $dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classNov == ""){$price = isset($dataIncorporaciones[$monthToShow[14]]) ? $dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}
	// if($classDic == ""){$price = isset($dataIncorporaciones[$monthToShow[13]]) ? $dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2021 = array_merge($dataIncorporacionOrganizacion2021, array($price));}

	if($classEne == ""){$price = isset($dataIncorporaciones[$monthToShow[12]]) ? $dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classFeb == ""){$price = isset($dataIncorporaciones[$monthToShow[11]]) ? $dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classMar == ""){$price = isset($dataIncorporaciones[$monthToShow[10]]) ? $dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classAbr == ""){$price = isset($dataIncorporaciones[$monthToShow[9]]) ? $dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classMay == ""){$price = isset($dataIncorporaciones[$monthToShow[8]]) ? $dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classJun == ""){$price = isset($dataIncorporaciones[$monthToShow[7]]) ? $dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classJul == ""){$price = isset($dataIncorporaciones[$monthToShow[6]]) ? $dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classAgo == ""){$price = isset($dataIncorporaciones[$monthToShow[5]]) ? $dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classSep == ""){$price = isset($dataIncorporaciones[$monthToShow[4]]) ? $dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classOct == ""){$price = isset($dataIncorporaciones[$monthToShow[3]]) ? $dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classNov == ""){$price = isset($dataIncorporaciones[$monthToShow[2]]) ? $dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}
	if($classDic == ""){$price = isset($dataIncorporaciones[$monthToShow[1]]) ? $dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"] : 0; $dataIncorporacionOrganizacion2022 = array_merge($dataIncorporacionOrganizacion2022, array($price));}

	// if($classEne == ""){$price = isset($dataIncorporaciones[$monthToShow[24]]) ? $dataIncorporaciones[$monthToShow[24]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classFeb == ""){$price = isset($dataIncorporaciones[$monthToShow[23]]) ? $dataIncorporaciones[$monthToShow[23]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classMar == ""){$price = isset($dataIncorporaciones[$monthToShow[22]]) ? $dataIncorporaciones[$monthToShow[22]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classAbr == ""){$price = isset($dataIncorporaciones[$monthToShow[21]]) ? $dataIncorporaciones[$monthToShow[21]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classMay == ""){$price = isset($dataIncorporaciones[$monthToShow[20]]) ? $dataIncorporaciones[$monthToShow[20]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classJun == ""){$price = isset($dataIncorporaciones[$monthToShow[19]]) ? $dataIncorporaciones[$monthToShow[19]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classJul == ""){$price = isset($dataIncorporaciones[$monthToShow[18]]) ? $dataIncorporaciones[$monthToShow[18]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classAgo == ""){$price = isset($dataIncorporaciones[$monthToShow[17]]) ? $dataIncorporaciones[$monthToShow[17]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classSep == ""){$price = isset($dataIncorporaciones[$monthToShow[16]]) ? $dataIncorporaciones[$monthToShow[16]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classOct == ""){$price = isset($dataIncorporaciones[$monthToShow[15]]) ? $dataIncorporaciones[$monthToShow[15]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classNov == ""){$price = isset($dataIncorporaciones[$monthToShow[14]]) ? $dataIncorporaciones[$monthToShow[14]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}
	// if($classDic == ""){$price = isset($dataIncorporaciones[$monthToShow[13]]) ? $dataIncorporaciones[$monthToShow[13]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2021 = array_merge($dataIncorporacionActividad2021, array($price));}

	if($classEne == ""){$price = isset($dataIncorporaciones[$monthToShow[12]]) ? $dataIncorporaciones[$monthToShow[12]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classFeb == ""){$price = isset($dataIncorporaciones[$monthToShow[11]]) ? $dataIncorporaciones[$monthToShow[11]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classMar == ""){$price = isset($dataIncorporaciones[$monthToShow[10]]) ? $dataIncorporaciones[$monthToShow[10]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classAbr == ""){$price = isset($dataIncorporaciones[$monthToShow[9]]) ? $dataIncorporaciones[$monthToShow[9]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classMay == ""){$price = isset($dataIncorporaciones[$monthToShow[8]]) ? $dataIncorporaciones[$monthToShow[8]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classJun == ""){$price = isset($dataIncorporaciones[$monthToShow[7]]) ? $dataIncorporaciones[$monthToShow[7]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classJul == ""){$price = isset($dataIncorporaciones[$monthToShow[6]]) ? $dataIncorporaciones[$monthToShow[6]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classAgo == ""){$price = isset($dataIncorporaciones[$monthToShow[5]]) ? $dataIncorporaciones[$monthToShow[5]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classSep == ""){$price = isset($dataIncorporaciones[$monthToShow[4]]) ? $dataIncorporaciones[$monthToShow[4]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classOct == ""){$price = isset($dataIncorporaciones[$monthToShow[3]]) ? $dataIncorporaciones[$monthToShow[3]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classNov == ""){$price = isset($dataIncorporaciones[$monthToShow[2]]) ? $dataIncorporaciones[$monthToShow[2]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
	if($classDic == ""){$price = isset($dataIncorporaciones[$monthToShow[1]]) ? $dataIncorporaciones[$monthToShow[1]]["totalActivosMensuales"] : 0; $dataIncorporacionActividad2022 = array_merge($dataIncorporacionActividad2022, array($price));}
//Graficas

?>

<!-- Mostrar logo -->
<img src="src/img/logo-black.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1"><?php echo $laguaje[$lang]['Variables de negocio Informe del consultor']; ?></div>
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Periodo de medición']; ?>:</span> <?php echo getMontPeriodPast($periodoPost) . " " . $laguaje[$lang]['a'] .  " " .getMontPeriod($periodoPost); ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['País']; ?>:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Código']; ?>:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['Rango']; ?>:</span> <?php echo $rangos_usa[$rankUser] ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Compras Organización -->
			<canvas id="chart6Graph1" class="w-100" height="420"></canvas>
			<!-- Gráfica Compras Organización -->
		</div>
	</div>
<!-- Gráficas -->

<div class="table-responsive mt-4">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"><?php echo $laguaje[$lang]['Compras de la organización']; ?></th>

				<?php
					(intval($monthToShow[12]) <= intval($periodoPost)) ? $classEne = "" : $classEne = "hidden";
					(intval($monthToShow[11]) <= intval($periodoPost)) ? $classFeb = "" : $classFeb = "hidden";
					(intval($monthToShow[10]) <= intval($periodoPost)) ? $classMar = "" : $classMar = "hidden";
					(intval($monthToShow[9]) <= intval($periodoPost)) ? $classAbr = "" : $classAbr = "hidden";
					(intval($monthToShow[8]) <= intval($periodoPost)) ? $classMay = "" : $classMay = "hidden";
					(intval($monthToShow[7]) <= intval($periodoPost)) ? $classJun = "" : $classJun = "hidden";
					(intval($monthToShow[6]) <= intval($periodoPost)) ? $classJul = "" : $classJul = "hidden";
					(intval($monthToShow[5]) <= intval($periodoPost)) ? $classAgo = "" : $classAgo = "hidden";
					(intval($monthToShow[4]) <= intval($periodoPost)) ? $classSep = "" : $classSep = "hidden";
					(intval($monthToShow[3]) <= intval($periodoPost)) ? $classOct = "" : $classOct = "hidden";
					(intval($monthToShow[2]) <= intval($periodoPost)) ? $classNov = "" : $classNov = "hidden";
					(intval($monthToShow[1]) <= intval($periodoPost)) ? $classDic = "" : $classDic = "hidden";
				?>

				<?php if($classEne == "") { ?><th scope="col">Jan</th><?php } ?>
				<?php if($classFeb == "") { ?><th scope="col">Feb</th><?php } ?>
				<?php if($classMar == "") { ?><th scope="col">Mar</th><?php } ?>
				<?php if($classAbr == "") { ?><th scope="col">Apr</th><?php } ?>
				<?php if($classMay == "") { ?><th scope="col">May</th><?php } ?>
				<?php if($classJun == "") { ?><th scope="col">Jun</th><?php } ?>
				<?php if($classJul == "") { ?><th scope="col">Jul</th><?php } ?>
				<?php if($classAgo == "") { ?><th scope="col">Aug</th><?php } ?>
				<?php if($classSep == "") { ?><th scope="col">Sep</th><?php } ?>
				<?php if($classOct == "") { ?><th scope="col">Oct</th><?php } ?>
				<?php if($classNov == "") { ?><th scope="col">Nov</th><?php } ?>
				<?php if($classDic == "") { ?><th scope="col">Dec</th><?php } ?>

				<th scope="col"><?php echo $laguaje[$lang]['Total']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Compras Organización 2021 -->
				<tr>
					<th scope="row"><span id="mes2"><?php echo $aniosDif[$i + 12]; ?></span></th>

					<?php if($classEne == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[24]]) ? number_format($dataCompras[$monthToShow[24]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[23]]) ? number_format($dataCompras[$monthToShow[23]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[22]]) ? number_format($dataCompras[$monthToShow[22]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[21]]) ? number_format($dataCompras[$monthToShow[21]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[20]]) ? number_format($dataCompras[$monthToShow[20]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[19]]) ? number_format($dataCompras[$monthToShow[19]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[18]]) ? number_format($dataCompras[$monthToShow[18]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[17]]) ? number_format($dataCompras[$monthToShow[17]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[16]]) ? number_format($dataCompras[$monthToShow[16]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[15]]) ? number_format($dataCompras[$monthToShow[15]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[14]]) ? number_format($dataCompras[$monthToShow[14]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[13]]) ? number_format($dataCompras[$monthToShow[13]]["compraTotal"], 0) : 0 ?></td><?php } ?>

					<td class="text-center">
						<?php

						$anio2 = 0;

						if($classEne == ""){$anio2 += $dataCompras[$monthToShow[24]]["compraTotal"];}
						if($classFeb == ""){$anio2 += $dataCompras[$monthToShow[23]]["compraTotal"];}
						if($classMar == ""){$anio2 += $dataCompras[$monthToShow[22]]["compraTotal"];}
						if($classAbr == ""){$anio2 += $dataCompras[$monthToShow[21]]["compraTotal"];}
						if($classMay == ""){$anio2 += $dataCompras[$monthToShow[20]]["compraTotal"];}
						if($classJun == ""){$anio2 += $dataCompras[$monthToShow[19]]["compraTotal"];}
						if($classJul == ""){$anio2 += $dataCompras[$monthToShow[18]]["compraTotal"];}
						if($classAgo == ""){$anio2 += $dataCompras[$monthToShow[17]]["compraTotal"];}
						if($classSep == ""){$anio2 += $dataCompras[$monthToShow[16]]["compraTotal"];}
						if($classOct == ""){$anio2 += $dataCompras[$monthToShow[15]]["compraTotal"];}
						if($classNov == ""){$anio2 += $dataCompras[$monthToShow[14]]["compraTotal"];}
						if($classDic == ""){$anio2 += $dataCompras[$monthToShow[13]]["compraTotal"];}

						echo number_format($anio2, 0);

						?>
					</td>
				</tr>
			<!-- Compras Organización 2021 -->

			<!-- Compras Organización 2022 -->
				<tr>
					<th scope="row"><span id="mes1"><?php echo $aniosDif[$i]; ?></th>

					<?php if($classEne == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[12]]) ? number_format($dataCompras[$monthToShow[12]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[11]]) ? number_format($dataCompras[$monthToShow[11]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[10]]) ? number_format($dataCompras[$monthToShow[10]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[9]]) ? number_format($dataCompras[$monthToShow[9]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[8]]) ? number_format($dataCompras[$monthToShow[8]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[7]]) ? number_format($dataCompras[$monthToShow[7]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[6]]) ? number_format($dataCompras[$monthToShow[6]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[5]]) ? number_format($dataCompras[$monthToShow[5]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[4]]) ? number_format($dataCompras[$monthToShow[4]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[3]]) ? number_format($dataCompras[$monthToShow[3]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[2]]) ? number_format($dataCompras[$monthToShow[2]]["compraTotal"], 0) : 0 ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo isset($dataCompras[$monthToShow[1]]) ? number_format($dataCompras[$monthToShow[1]]["compraTotal"], 0) : 0 ?></td><?php } ?>

					<td class="text-center">
						<?php

						$anio1 = 0;

						if($classEne == ""){$anio1 += $dataCompras[$monthToShow[12]]["compraTotal"];}
						if($classFeb == ""){$anio1 += $dataCompras[$monthToShow[11]]["compraTotal"];}
						if($classMar == ""){$anio1 += $dataCompras[$monthToShow[10]]["compraTotal"];}
						if($classAbr == ""){$anio1 += $dataCompras[$monthToShow[9]]["compraTotal"];}
						if($classMay == ""){$anio1 += $dataCompras[$monthToShow[8]]["compraTotal"];}
						if($classJun == ""){$anio1 += $dataCompras[$monthToShow[7]]["compraTotal"];}
						if($classJul == ""){$anio1 += $dataCompras[$monthToShow[6]]["compraTotal"];}
						if($classAgo == ""){$anio1 += $dataCompras[$monthToShow[5]]["compraTotal"];}
						if($classSep == ""){$anio1 += $dataCompras[$monthToShow[4]]["compraTotal"];}
						if($classOct == ""){$anio1 += $dataCompras[$monthToShow[3]]["compraTotal"];}
						if($classNov == ""){$anio1 += $dataCompras[$monthToShow[2]]["compraTotal"];}
						if($classDic == ""){$anio1 += $dataCompras[$monthToShow[1]]["compraTotal"];}

						echo number_format($anio1, 0);

						?>
					</td>
				</tr>
			<!-- Compras Organización 2022 -->

			<!-- Compras Organización 2021 - 2022 -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['% de crecimiento de las compras de la organización']; ?></th>

					<?php if($classEne == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[24]]) ? $dataCompras[$monthToShow[24]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[12]]) ? $dataCompras[$monthToShow[12]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[23]]) ? $dataCompras[$monthToShow[23]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[11]]) ? $dataCompras[$monthToShow[11]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[22]]) ? $dataCompras[$monthToShow[22]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[10]]) ? $dataCompras[$monthToShow[10]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[21]]) ? $dataCompras[$monthToShow[21]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[9]]) ? $dataCompras[$monthToShow[9]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[20]]) ? $dataCompras[$monthToShow[20]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[8]]) ? $dataCompras[$monthToShow[8]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[19]]) ? $dataCompras[$monthToShow[19]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[7]]) ? $dataCompras[$monthToShow[7]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[18]]) ? $dataCompras[$monthToShow[18]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[6]]) ? $dataCompras[$monthToShow[6]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[17]]) ? $dataCompras[$monthToShow[17]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[5]]) ? $dataCompras[$monthToShow[5]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[16]]) ? $dataCompras[$monthToShow[16]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[4]]) ? $dataCompras[$monthToShow[4]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[15]]) ? $dataCompras[$monthToShow[15]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[3]]) ? $dataCompras[$monthToShow[3]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[14]]) ? $dataCompras[$monthToShow[14]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[2]]) ? $dataCompras[$monthToShow[2]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataCompras[$monthToShow[13]]) ? $dataCompras[$monthToShow[13]]["compraTotal"] : 0;
						$price2022 = isset($dataCompras[$monthToShow[1]]) ? $dataCompras[$monthToShow[1]]["compraTotal"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>

					<td class="text-center">
						<?php

						echo ($anio2 == 0 || $anio1 == 0) ? "0%" : number_format(($anio1 / ($anio2) - 1) * 100, 2) . "%";

						?>
					</td>
				</tr>
			<!-- Compras Organización 2021 - 2022 -->
		</tbody>
	</table>
</div>

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Incorporación Organización -->
			<canvas id="chart6Graph2" class="w-100" height="420"></canvas>
			<!-- Gráfica Incorporación Organización -->
		</div>
	</div>
<!-- Gráficas -->

<div class="table-responsive mt-4">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"><?php echo $laguaje[$lang]['Inscripciones (Consultores y Clientes)']; ?></th>

				<?php
					(intval($monthToShow[12]) <= intval($periodoPost)) ? $classEne = "" : $classEne = "hidden";
					(intval($monthToShow[11]) <= intval($periodoPost)) ? $classFeb = "" : $classFeb = "hidden";
					(intval($monthToShow[10]) <= intval($periodoPost)) ? $classMar = "" : $classMar = "hidden";
					(intval($monthToShow[9]) <= intval($periodoPost)) ? $classAbr = "" : $classAbr = "hidden";
					(intval($monthToShow[8]) <= intval($periodoPost)) ? $classMay = "" : $classMay = "hidden";
					(intval($monthToShow[7]) <= intval($periodoPost)) ? $classJun = "" : $classJun = "hidden";
					(intval($monthToShow[6]) <= intval($periodoPost)) ? $classJul = "" : $classJul = "hidden";
					(intval($monthToShow[5]) <= intval($periodoPost)) ? $classAgo = "" : $classAgo = "hidden";
					(intval($monthToShow[4]) <= intval($periodoPost)) ? $classSep = "" : $classSep = "hidden";
					(intval($monthToShow[3]) <= intval($periodoPost)) ? $classOct = "" : $classOct = "hidden";
					(intval($monthToShow[2]) <= intval($periodoPost)) ? $classNov = "" : $classNov = "hidden";
					(intval($monthToShow[1]) <= intval($periodoPost)) ? $classDic = "" : $classDic = "hidden";
				?>

				<?php if($classEne == "") { ?><th scope="col">Jan</th><?php } ?>
				<?php if($classFeb == "") { ?><th scope="col">Feb</th><?php } ?>
				<?php if($classMar == "") { ?><th scope="col">Mar</th><?php } ?>
				<?php if($classAbr == "") { ?><th scope="col">Apr</th><?php } ?>
				<?php if($classMay == "") { ?><th scope="col">May</th><?php } ?>
				<?php if($classJun == "") { ?><th scope="col">Jun</th><?php } ?>
				<?php if($classJul == "") { ?><th scope="col">Jul</th><?php } ?>
				<?php if($classAgo == "") { ?><th scope="col">Aug</th><?php } ?>
				<?php if($classSep == "") { ?><th scope="col">Sep</th><?php } ?>
				<?php if($classOct == "") { ?><th scope="col">Oct</th><?php } ?>
				<?php if($classNov == "") { ?><th scope="col">Nov</th><?php } ?>
				<?php if($classDic == "") { ?><th scope="col">Dec</th><?php } ?>

				<th scope="col"><?php echo $laguaje[$lang]['Total']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Incorporaciones Organización 2021 -->
				<tr>
					<th scope="row"><?php echo $aniosDif[$i + 12]; ?>
				<?php echo sizeof($dataIncorporaciones); ?></th>

					<?php if($classEne == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>

					<td class="text-center">
						<?php

						$total2021 = 0;

						if($classEne == ""){$total2021 += $dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"];}
						if($classFeb == ""){$total2021 += $dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"];}
						if($classMar == ""){$total2021 += $dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"];}
						if($classAbr == ""){$total2021 += $dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"];}
						if($classMay == ""){$total2021 += $dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"];}
						if($classJun == ""){$total2021 += $dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"];}
						if($classJul == ""){$total2021 += $dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"];}
						if($classAgo == ""){$total2021 += $dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"];}
						if($classSep == ""){$total2021 += $dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"];}
						if($classOct == ""){$total2021 += $dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"];}
						if($classNov == ""){$total2021 += $dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"];}
						if($classDic == ""){$total2021 += $dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"];}

						echo number_format($total2021, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones Organización 2021 -->

			<!-- Incorporaciones Organización 2022 -->
				<tr>
					<th scope="row"><?php echo $aniosDif[$i]; ?></th>

					<?php if($classEne == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"], 0) : 0 ?></td><?php } ?>

					<td class="text-center">
						<?php

						$total2022 = 0;

						if($classEne == ""){@$total2022 += $dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"];}
						if($classFeb == ""){@$total2022 += $dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"];}
						if($classMar == ""){@$total2022 += $dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"];}
						if($classAbr == ""){@$total2022 += $dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"];}
						if($classMay == ""){@$total2022 += $dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"];}
						if($classJun == ""){@$total2022 += $dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"];}
						if($classJul == ""){@$total2022 += $dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"];}
						if($classAgo == ""){@$total2022 += $dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"];}
						if($classSep == ""){@$total2022 += $dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"];}
						if($classOct == ""){@$total2022 += $dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"];}
						if($classNov == ""){@$total2022 += $dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"];}
						if($classDic == ""){@$total2022 += $dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"];}

						echo number_format($total2022, 0);

						?>
					</td>
				</tr>
			<!-- Incorporaciones Organización 2022 -->

			<!-- Incorporaciones Organización 2021 - 2022 -->
				<tr>
					<th scope="row">Organization Sign Ups Growth %</th>

					<?php if($classEne == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[24]]) ? $dataIncorporaciones[$monthToShow[24]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[12]]) ? $dataIncorporaciones[$monthToShow[12]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[23]]) ? $dataIncorporaciones[$monthToShow[23]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[11]]) ? $dataIncorporaciones[$monthToShow[11]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[22]]) ? $dataIncorporaciones[$monthToShow[22]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[10]]) ? $dataIncorporaciones[$monthToShow[10]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[21]]) ? $dataIncorporaciones[$monthToShow[21]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[9]]) ? $dataIncorporaciones[$monthToShow[9]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[20]]) ? $dataIncorporaciones[$monthToShow[20]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[8]]) ? $dataIncorporaciones[$monthToShow[8]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[19]]) ? $dataIncorporaciones[$monthToShow[19]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[7]]) ? $dataIncorporaciones[$monthToShow[7]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[18]]) ? $dataIncorporaciones[$monthToShow[18]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[6]]) ? $dataIncorporaciones[$monthToShow[6]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[17]]) ? $dataIncorporaciones[$monthToShow[17]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[5]]) ? $dataIncorporaciones[$monthToShow[5]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[16]]) ? $dataIncorporaciones[$monthToShow[16]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[4]]) ? $dataIncorporaciones[$monthToShow[4]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[15]]) ? $dataIncorporaciones[$monthToShow[15]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[3]]) ? $dataIncorporaciones[$monthToShow[3]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[14]]) ? $dataIncorporaciones[$monthToShow[14]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[2]]) ? $dataIncorporaciones[$monthToShow[2]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[13]]) ? $dataIncorporaciones[$monthToShow[13]]["inscripcionesTotales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[1]]) ? $dataIncorporaciones[$monthToShow[1]]["inscripcionesTotales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";

						?>
					</td><?php } ?>

					<td class="text-center">
						<?php

						echo ($total2022 == 0 || $total2021 == 0) ? "0%" : number_format(($total2022 / ($total2021) - 1) * 100, 2) . "%";

						?>
					</td>
				</tr>
			<!-- Incorporaciones Organización 2021 - 2022 -->
		</tbody>
	</table>
</div>

<!-- Mostrar logo -->
<img src="src/img/logo-black.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1"><?php echo $laguaje[$lang]['Variables de negocio Informe del consultor']; ?></div>
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Periodo de medición']; ?>:</span> <?php echo getMontPeriodPast($periodoPost) . " " . $laguaje[$lang]['a'] .  " " .getMontPeriod($periodoPost); ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['País']; ?>:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold"><?php echo $laguaje[$lang]['Código']; ?>:</span> <?php echo $codeUser ?></div>
			<div class="h6"><span class="fw-bold"><?php echo $laguaje[$lang]['Rango']; ?>:</span> <?php echo $rangos_usa[$rankUser] ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="row">
		<div class="col text-center">
			<!-- Gráfica Actividad -->
			<canvas id="chart6Graph3" class="w-100" height="410"></canvas>
			<!-- Gráfica Actividad -->
		</div>
	</div>
<!-- Gráficas -->

<div class="table-responsive mt-4">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"><?php echo $laguaje[$lang]['Organización Activos']; ?></th>

				<?php
					(intval($monthToShow[12]) <= intval($periodoPost)) ? $classEne = "" : $classEne = "hidden";
					(intval($monthToShow[11]) <= intval($periodoPost)) ? $classFeb = "" : $classFeb = "hidden";
					(intval($monthToShow[10]) <= intval($periodoPost)) ? $classMar = "" : $classMar = "hidden";
					(intval($monthToShow[9]) <= intval($periodoPost)) ? $classAbr = "" : $classAbr = "hidden";
					(intval($monthToShow[8]) <= intval($periodoPost)) ? $classMay = "" : $classMay = "hidden";
					(intval($monthToShow[7]) <= intval($periodoPost)) ? $classJun = "" : $classJun = "hidden";
					(intval($monthToShow[6]) <= intval($periodoPost)) ? $classJul = "" : $classJul = "hidden";
					(intval($monthToShow[5]) <= intval($periodoPost)) ? $classAgo = "" : $classAgo = "hidden";
					(intval($monthToShow[4]) <= intval($periodoPost)) ? $classSep = "" : $classSep = "hidden";
					(intval($monthToShow[3]) <= intval($periodoPost)) ? $classOct = "" : $classOct = "hidden";
					(intval($monthToShow[2]) <= intval($periodoPost)) ? $classNov = "" : $classNov = "hidden";
					(intval($monthToShow[1]) <= intval($periodoPost)) ? $classDic = "" : $classDic = "hidden";
				?>

				<?php if($classEne == "") { ?><th scope="col">Jan</th><?php } ?>
				<?php if($classFeb == "") { ?><th scope="col">Feb</th><?php } ?>
				<?php if($classMar == "") { ?><th scope="col">Mar</th><?php } ?>
				<?php if($classAbr == "") { ?><th scope="col">Apr</th><?php } ?>
				<?php if($classMay == "") { ?><th scope="col">May</th><?php } ?>
				<?php if($classJun == "") { ?><th scope="col">Jun</th><?php } ?>
				<?php if($classJul == "") { ?><th scope="col">Jul</th><?php } ?>
				<?php if($classAgo == "") { ?><th scope="col">Aug</th><?php } ?>
				<?php if($classSep == "") { ?><th scope="col">Sep</th><?php } ?>
				<?php if($classOct == "") { ?><th scope="col">Oct</th><?php } ?>
				<?php if($classNov == "") { ?><th scope="col">Nov</th><?php } ?>
				<?php if($classDic == "") { ?><th scope="col">Dec</th><?php } ?>

				<th scope="col"><?php echo $laguaje[$lang]['Average']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- Actividad 2021 -->
				<tr>
					<th scope="row" id="lasrYearLastGraph"><?php echo $aniosDif[$i + 12]; ?></th>

					<?php if($classEne == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[24]]) ? number_format($dataIncorporaciones[$monthToShow[24]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[23]]) ? number_format($dataIncorporaciones[$monthToShow[23]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[22]]) ? number_format($dataIncorporaciones[$monthToShow[22]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[21]]) ? number_format($dataIncorporaciones[$monthToShow[21]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[20]]) ? number_format($dataIncorporaciones[$monthToShow[20]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[19]]) ? number_format($dataIncorporaciones[$monthToShow[19]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[18]]) ? number_format($dataIncorporaciones[$monthToShow[18]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[17]]) ? number_format($dataIncorporaciones[$monthToShow[17]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[16]]) ? number_format($dataIncorporaciones[$monthToShow[16]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[15]]) ? number_format($dataIncorporaciones[$monthToShow[15]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[14]]) ? number_format($dataIncorporaciones[$monthToShow[14]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[13]]) ? number_format($dataIncorporaciones[$monthToShow[13]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>

					<td class="text-center">
						<?php

						$total2021 = 0;
						$months = 0;
						if($classEne == "") {@$total2021 += $dataIncorporaciones[$monthToShow[24]]["totalActivosMensuales"]; $months = 1;}
						if($classFeb == "") {@$total2021 += $dataIncorporaciones[$monthToShow[23]]["totalActivosMensuales"]; $months = 2;}
						if($classMar == "") {@$total2021 += $dataIncorporaciones[$monthToShow[22]]["totalActivosMensuales"]; $months = 3;}
						if($classAbr == "") {@$total2021 += $dataIncorporaciones[$monthToShow[21]]["totalActivosMensuales"]; $months = 4;}
						if($classMay == "") {@$total2021 += $dataIncorporaciones[$monthToShow[20]]["totalActivosMensuales"]; $months = 5;}
						if($classJun == "") {@$total2021 += $dataIncorporaciones[$monthToShow[19]]["totalActivosMensuales"]; $months = 6;}
						if($classJul == "") {@$total2021 += $dataIncorporaciones[$monthToShow[18]]["totalActivosMensuales"]; $months = 7;}
						if($classAgo == "") {@$total2021 += $dataIncorporaciones[$monthToShow[17]]["totalActivosMensuales"]; $months = 8;}
						if($classSep == "") {@$total2021 += $dataIncorporaciones[$monthToShow[16]]["totalActivosMensuales"]; $months = 9;}
						if($classOct == "") {@$total2021 += $dataIncorporaciones[$monthToShow[15]]["totalActivosMensuales"]; $months = 10;}
						if($classNov == "") {@$total2021 += $dataIncorporaciones[$monthToShow[14]]["totalActivosMensuales"]; $months = 11;}
						if($classDic == "") {@$total2021 += $dataIncorporaciones[$monthToShow[13]]["totalActivosMensuales"]; $months = 12;}

						echo number_format($total2021 / $months, 2);

						?>
					</td>
				</tr>
			<!-- Actividad 2021 -->

			<!-- Actividad 2022 -->
				<tr>
					<th scope="row" id="curYearLastGraph"><?php echo $aniosDif[$i]; ?></th>
					<?php if($classEne == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[12]]) ? number_format($dataIncorporaciones[$monthToShow[12]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[11]]) ? number_format($dataIncorporaciones[$monthToShow[11]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[10]]) ? number_format($dataIncorporaciones[$monthToShow[10]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[9]]) ? number_format($dataIncorporaciones[$monthToShow[9]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[8]]) ? number_format($dataIncorporaciones[$monthToShow[8]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[7]]) ? number_format($dataIncorporaciones[$monthToShow[7]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[6]]) ? number_format($dataIncorporaciones[$monthToShow[6]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[5]]) ? number_format($dataIncorporaciones[$monthToShow[5]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[4]]) ? number_format($dataIncorporaciones[$monthToShow[4]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[3]]) ? number_format($dataIncorporaciones[$monthToShow[3]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[2]]) ? number_format($dataIncorporaciones[$monthToShow[2]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo isset($dataIncorporaciones[$monthToShow[1]]) ? number_format($dataIncorporaciones[$monthToShow[1]]["totalActivosMensuales"], 0) : 0 ?></td><?php } ?>

					<td class="text-center">
						<?php

						$total2022 = 0;
						$months = 0;
						if($classEne == "") {@$total2022 += $dataIncorporaciones[$monthToShow[12]]["totalActivosMensuales"]; $months = 1;}
						if($classFeb == "") {@$total2022 += $dataIncorporaciones[$monthToShow[11]]["totalActivosMensuales"]; $months = 2;}
						if($classMar == "") {@$total2022 += $dataIncorporaciones[$monthToShow[10]]["totalActivosMensuales"]; $months = 3;}
						if($classAbr == "") {@$total2022 += $dataIncorporaciones[$monthToShow[9]]["totalActivosMensuales"]; $months = 4;}
						if($classMay == "") {@$total2022 += $dataIncorporaciones[$monthToShow[8]]["totalActivosMensuales"]; $months = 5;}
						if($classJun == "") {@$total2022 += $dataIncorporaciones[$monthToShow[7]]["totalActivosMensuales"]; $months = 6;}
						if($classJul == "") {@$total2022 += $dataIncorporaciones[$monthToShow[6]]["totalActivosMensuales"]; $months = 7;}
						if($classAgo == "") {@$total2022 += $dataIncorporaciones[$monthToShow[5]]["totalActivosMensuales"]; $months = 8;}
						if($classSep == "") {@$total2022 += $dataIncorporaciones[$monthToShow[4]]["totalActivosMensuales"]; $months = 9;}
						if($classOct == "") {@$total2022 += $dataIncorporaciones[$monthToShow[3]]["totalActivosMensuales"]; $months = 10;}
						if($classNov == "") {@$total2022 += $dataIncorporaciones[$monthToShow[2]]["totalActivosMensuales"]; $months = 11;}
						if($classDic == "") {@$total2022 += $dataIncorporaciones[$monthToShow[1]]["totalActivosMensuales"]; $months = 12;}

						echo number_format($total2022 / $months, 2);

						?>
					</td>
				</tr>
			<!-- Actividad 2022 -->

			<!-- Actividad 2021 - 2022 -->
				<tr>
					<th scope="row">Monthly Actives Growth %</th>
					<?php $months = 0; ?>
					<?php if($classEne == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[24]]) ? $dataIncorporaciones[$monthToShow[24]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[12]]) ? $dataIncorporaciones[$monthToShow[12]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 1;
						?>
					</td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[23]]) ? $dataIncorporaciones[$monthToShow[23]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[11]]) ? $dataIncorporaciones[$monthToShow[11]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 2;
						?>
					</td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[22]]) ? $dataIncorporaciones[$monthToShow[22]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[10]]) ? $dataIncorporaciones[$monthToShow[10]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 3;
						?>
					</td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[21]]) ? $dataIncorporaciones[$monthToShow[21]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[9]]) ? $dataIncorporaciones[$monthToShow[9]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 4;
						?>
					</td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[20]]) ? $dataIncorporaciones[$monthToShow[20]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[8]]) ? $dataIncorporaciones[$monthToShow[8]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 5;
						?>
					</td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[19]]) ? $dataIncorporaciones[$monthToShow[19]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[7]]) ? $dataIncorporaciones[$monthToShow[7]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 6;
						?>
					</td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[18]]) ? $dataIncorporaciones[$monthToShow[18]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[6]]) ? $dataIncorporaciones[$monthToShow[6]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 7;
						?>
					</td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[17]]) ? $dataIncorporaciones[$monthToShow[17]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[5]]) ? $dataIncorporaciones[$monthToShow[5]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 8;
						?>
					</td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[16]]) ? $dataIncorporaciones[$monthToShow[16]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[4]]) ? $dataIncorporaciones[$monthToShow[4]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 9;
						?>
					</td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[15]]) ? $dataIncorporaciones[$monthToShow[15]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[3]]) ? $dataIncorporaciones[$monthToShow[3]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 10;
						?>
					</td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[14]]) ? $dataIncorporaciones[$monthToShow[14]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[2]]) ? $dataIncorporaciones[$monthToShow[2]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 11;
						?>
					</td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center">
						<?php

						$price2021 = isset($dataIncorporaciones[$monthToShow[13]]) ? $dataIncorporaciones[$monthToShow[13]]["totalActivosMensuales"] : 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[1]]) ? $dataIncorporaciones[$monthToShow[1]]["totalActivosMensuales"] : 0;

						echo ($price2021 == 0 || $price2022 == 0) ?  "0%" : number_format(($price2022 / ($price2021) - 1) * 100, 2) . "%";
						$months = 12;
						?>
					</td><?php } ?>

					<td class="text-center">
						<?php

						echo ($total2022 == 0 || $total2021 == 0) ? "0%" : number_format(($total2022 / ($total2021) - 1) * 100, 2) . "%";

						?>
					</td>
				</tr>
			<!-- Actividad 2021 - 2022 -->
		</tbody>
	</table>
</div>

<div class="table-responsive mt-2">
	<table class="table align-middle table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="c-mw-1"></th>

				<?php
					$totalInfluencersOptimoEne = 0;
					$totalInfluencersOptimoFeb = 0;
					$totalInfluencersOptimoMar = 0;
					$totalInfluencersOptimoAbr = 0;
					$totalInfluencersOptimoMay = 0;
					$totalInfluencersOptimoJun = 0;
					$totalInfluencersOptimoJul = 0;
					$totalInfluencersOptimoAgo = 0;
					$totalInfluencersOptimoSep = 0;
					$totalInfluencersOptimoOct = 0;
					$totalInfluencersOptimoNov = 0;
					$totalInfluencersOptimoDic = 0;

					$totalActivosEne = 0;
					$totalActivosFeb = 0;
					$totalActivosMar = 0;
					$totalActivosAbr = 0;
					$totalActivosMay = 0;
					$totalActivosJun = 0;
					$totalActivosJul = 0;
					$totalActivosAgo = 0;
					$totalActivosSep = 0;
					$totalActivosOct = 0;
					$totalActivosNov = 0;
					$totalActivosDic = 0;

					$totalActivosInfluencersEne = 0;
					$totalActivosInfluencersFeb = 0;
					$totalActivosInfluencersMar = 0;
					$totalActivosInfluencersAbr = 0;
					$totalActivosInfluencersMay = 0;
					$totalActivosInfluencersJun = 0;
					$totalActivosInfluencersJul = 0;
					$totalActivosInfluencersAgo = 0;
					$totalActivosInfluencersSep = 0;
					$totalActivosInfluencersOct = 0;
					$totalActivosInfluencersNov = 0;
					$totalActivosInfluencersDic = 0;

					(intval($monthToShow[12]) <= intval($periodoPost)) ? $classEne = "" : $classEne = "hidden";
					(intval($monthToShow[11]) <= intval($periodoPost)) ? $classFeb = "" : $classFeb = "hidden";
					(intval($monthToShow[10]) <= intval($periodoPost)) ? $classMar = "" : $classMar = "hidden";
					(intval($monthToShow[9]) <= intval($periodoPost)) ? $classAbr = "" : $classAbr = "hidden";
					(intval($monthToShow[8]) <= intval($periodoPost)) ? $classMay = "" : $classMay = "hidden";
					(intval($monthToShow[7]) <= intval($periodoPost)) ? $classJun = "" : $classJun = "hidden";
					(intval($monthToShow[6]) <= intval($periodoPost)) ? $classJul = "" : $classJul = "hidden";
					(intval($monthToShow[5]) <= intval($periodoPost)) ? $classAgo = "" : $classAgo = "hidden";
					(intval($monthToShow[4]) <= intval($periodoPost)) ? $classSep = "" : $classSep = "hidden";
					(intval($monthToShow[3]) <= intval($periodoPost)) ? $classOct = "" : $classOct = "hidden";
					(intval($monthToShow[2]) <= intval($periodoPost)) ? $classNov = "" : $classNov = "hidden";
					(intval($monthToShow[1]) <= intval($periodoPost)) ? $classDic = "" : $classDic = "hidden";
				?>

				<?php if($classEne == "") { ?><th scope="col">Jan</th><?php } ?>
				<?php if($classFeb == "") { ?><th scope="col">Feb</th><?php } ?>
				<?php if($classMar == "") { ?><th scope="col">Mar</th><?php } ?>
				<?php if($classAbr == "") { ?><th scope="col">Apr</th><?php } ?>
				<?php if($classMay == "") { ?><th scope="col">May</th><?php } ?>
				<?php if($classJun == "") { ?><th scope="col">Jun</th><?php } ?>
				<?php if($classJul == "") { ?><th scope="col">Jul</th><?php } ?>
				<?php if($classAgo == "") { ?><th scope="col">Aug</th><?php } ?>
				<?php if($classSep == "") { ?><th scope="col">Sep</th><?php } ?>
				<?php if($classOct == "") { ?><th scope="col">Oct</th><?php } ?>
				<?php if($classNov == "") { ?><th scope="col">Nov</th><?php } ?>
				<?php if($classDic == "") { ?><th scope="col">Dec</th><?php } ?>

				<th scope="col"><?php echo $laguaje[$lang]['Average']; ?></th>
			</tr>
		</thead>

		<tbody>
			<!-- No. de Influencers -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Total Organización (Consultores y Clientes)']; ?></th>

					<?php if($classEne == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[12]]) ? $dataGenealogia[$monthToShow[12]]["total"] : 0;

						$totalInfluencersEne = $price2022 + $price2021;
						$totalInfluencersOptimoEne = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersEne, 0);

						?>
					</td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[11]]) ? $dataGenealogia[$monthToShow[11]]["total"] : 0;

						$totalInfluencersFeb = $price2022 + $price2021;
						$totalInfluencersOptimoFeb = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersFeb, 0);

						?>
					</td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[10]]) ? $dataGenealogia[$monthToShow[10]]["total"] : 0;

						$totalInfluencersMar = $price2022 + $price2021;
						$totalInfluencersOptimoMar = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersMar, 0);

						?>
					</td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[9]]) ? $dataGenealogia[$monthToShow[9]]["total"] : 0;

						$totalInfluencersAbr = $price2022 + $price2021;
						$totalInfluencersOptimoAbr = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersAbr, 0);

						?>
					</td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[8]]) ? $dataGenealogia[$monthToShow[8]]["total"] : 0;

						$totalInfluencersMay = $price2022 + $price2021;
						$totalInfluencersOptimoMay = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersMay, 0);

						?>
					</td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[7]]) ? $dataGenealogia[$monthToShow[7]]["total"] : 0;

						$totalInfluencersJun = $price2022 + $price2021;
						$totalInfluencersOptimoJun = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersJun, 0);

						?>
					</td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[6]]) ? $dataGenealogia[$monthToShow[6]]["total"] : 0;

						$totalInfluencersJul = $price2022 + $price2021;
						$totalInfluencersOptimoJul = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersJul, 0);

						?>
					</td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[5]]) ? $dataGenealogia[$monthToShow[5]]["total"] : 0;

						$totalInfluencersAgo = $price2022 + $price2021;
						$totalInfluencersOptimoAgo = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersAgo, 0);

						?>
					</td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[4]]) ? $dataGenealogia[$monthToShow[4]]["total"] : 0;

						$totalInfluencersSep = $price2022 + $price2021;
						$totalInfluencersOptimoSep = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersSep, 0);

						?>
					</td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[3]]) ? $dataGenealogia[$monthToShow[3]]["total"] : 0;

						$totalInfluencersOct = $price2022 + $price2021;
						$totalInfluencersOptimoOct = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersOct, 0);

						?>
					</td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[2]]) ? $dataGenealogia[$monthToShow[2]]["total"] : 0;

						$totalInfluencersNov = $price2022 + $price2021;
						$totalInfluencersOptimoNov = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersNov, 0);

						?>
					</td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataGenealogia[$monthToShow[1]]) ? $dataGenealogia[$monthToShow[1]]["total"] : 0;

						$totalInfluencersDic = $price2022 + $price2021;
						$totalInfluencersOptimoDic = (($price2022 + $price2021) * 30) / 100;

						echo number_format($totalInfluencersDic, 0);

						?>
					</td><?php } ?>

					<td class="text-center">-</td>
				</tr>
			<!-- No. de Influencers -->

			<!-- Activos Mensuales -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Activos Mensuales (Consultores y Clientes)']; ?></th>

					<?php if($classEne == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[12]]) ? $dataIncorporaciones[$monthToShow[12]]["totalActivosMensuales"] : 0;

						$totalActivosEne = $price2022 + $price2021;
						echo number_format($totalActivosEne, 0);

						?>
					</td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[11]]) ? $dataIncorporaciones[$monthToShow[11]]["totalActivosMensuales"] : 0;

						$totalActivosFeb = $price2022 + $price2021;
						echo number_format($totalActivosFeb, 0);

						?>
					</td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[10]]) ? $dataIncorporaciones[$monthToShow[10]]["totalActivosMensuales"] : 0;

						$totalActivosMar = $price2022 + $price2021;
						echo number_format($totalActivosMar, 0);

						?>
					</td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[9]]) ? $dataIncorporaciones[$monthToShow[9]]["totalActivosMensuales"] : 0;

						$totalActivosAbr = $price2022 + $price2021;
						echo number_format($totalActivosAbr, 0);

						?>
					</td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[8]]) ? $dataIncorporaciones[$monthToShow[8]]["totalActivosMensuales"] : 0;

						$totalActivosMay = $price2022 + $price2021;
						echo number_format($totalActivosMay, 0);

						?>
					</td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[7]]) ? $dataIncorporaciones[$monthToShow[7]]["totalActivosMensuales"] : 0;

						$totalActivosJun = $price2022 + $price2021;
						echo number_format($totalActivosJun, 0);

						?>
					</td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[6]]) ? $dataIncorporaciones[$monthToShow[6]]["totalActivosMensuales"] : 0;

						$totalActivosJul = $price2022 + $price2021;
						echo number_format($totalActivosJul, 0);

						?>
					</td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[5]]) ? $dataIncorporaciones[$monthToShow[5]]["totalActivosMensuales"] : 0;

						$totalActivosAgo = $price2022 + $price2021;
						echo number_format($totalActivosAgo, 0);

						?>
					</td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[4]]) ? $dataIncorporaciones[$monthToShow[4]]["totalActivosMensuales"] : 0;

						$totalActivosSep = $price2022 + $price2021;
						echo number_format($totalActivosSep, 0);

						?>
					</td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[3]]) ? $dataIncorporaciones[$monthToShow[3]]["totalActivosMensuales"] : 0;

						$totalActivosOct = $price2022 + $price2021;
						echo number_format($totalActivosOct, 0);

						?>
					</td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[2]]) ? $dataIncorporaciones[$monthToShow[2]]["totalActivosMensuales"] : 0;

						$totalActivosNov = $price2022 + $price2021;
						echo number_format($totalActivosNov, 0);

						?>
					</td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center">
						<?php

						$price2021 = 0;
						$price2022 = isset($dataIncorporaciones[$monthToShow[1]]) ? $dataIncorporaciones[$monthToShow[1]]["totalActivosMensuales"] : 0;

						$totalActivosDic = $price2022 + $price2021;
						echo number_format($totalActivosDic, 0);

						?>
					</td><?php } ?>

					<td class="text-center">-</td>
				</tr>
			<!-- Activos Mensuales -->

			<!-- No. de Influencers - Activos Mensuales -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['% Actividad de la Organización']; ?></th>

					<?php if($classEne == "") { ?><td class="text-center">
						<?php

						($totalActivosEne == 0 || $totalInfluencersEne == 0) ? $totalActivosInfluencersEne = 0 : $totalActivosInfluencersEne = $totalActivosEne / $totalInfluencersEne;
						echo number_format($totalActivosInfluencersEne * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center">
						<?php

						($totalActivosFeb == 0 || $totalInfluencersFeb == 0) ? $totalActivosInfluencersFeb = 0 : $totalActivosInfluencersFeb = $totalActivosFeb / $totalInfluencersFeb;
						echo number_format($totalActivosInfluencersFeb * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center">
						<?php

						($totalActivosMar == 0 || $totalInfluencersMar == 0) ? $totalActivosInfluencersMar = 0 : $totalActivosInfluencersMar = $totalActivosMar / $totalInfluencersMar;
						echo number_format($totalActivosInfluencersMar * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center">
						<?php

						($totalActivosAbr == 0 || $totalInfluencersAbr == 0) ? $totalActivosInfluencersAbr = 0 : $totalActivosInfluencersAbr = $totalActivosAbr / $totalInfluencersAbr;
						echo number_format($totalActivosInfluencersAbr * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center">
						<?php

						($totalActivosMay == 0 || $totalInfluencersMay == 0) ? $totalActivosInfluencersMay = 0 : $totalActivosInfluencersMay = $totalActivosMay / $totalInfluencersMay;
						echo number_format($totalActivosInfluencersMay * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center">
						<?php

						($totalActivosJun == 0 || $totalInfluencersJun == 0) ? $totalActivosInfluencersJun = 0 : $totalActivosInfluencersJun = $totalActivosJun / $totalInfluencersJun;
						echo number_format($totalActivosInfluencersJun * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center">
						<?php

						($totalActivosJul == 0 || $totalInfluencersJul == 0) ? $totalActivosInfluencersJul = 0 : $totalActivosInfluencersJul = $totalActivosJul / $totalInfluencersJul;
						echo number_format($totalActivosInfluencersJul * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center">
						<?php

						($totalActivosAgo == 0 || $totalInfluencersAgo == 0) ? $totalActivosInfluencersAgo = 0 : $totalActivosInfluencersAgo = $totalActivosAgo / $totalInfluencersAgo;
						echo number_format($totalActivosInfluencersAgo * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center">
						<?php

						($totalActivosSep == 0 || $totalInfluencersSep == 0) ? $totalActivosInfluencersSep = 0 : $totalActivosInfluencersSep = $totalActivosSep / $totalInfluencersSep;
						echo number_format($totalActivosInfluencersSep * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center">
						<?php

						($totalActivosOct == 0 || $totalInfluencersOct == 0) ? $totalActivosInfluencersOct = 0 : $totalActivosInfluencersOct = $totalActivosOct / $totalInfluencersOct;
						echo number_format($totalActivosInfluencersOct * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center">
						<?php

						($totalActivosNov == 0 || $totalInfluencersNov == 0) ? $totalActivosInfluencersNov = 0 : $totalActivosInfluencersNov = $totalActivosNov / $totalInfluencersNov;
						echo number_format($totalActivosInfluencersNov * 100, 2) . '%';

						?>
					</td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center">
						<?php

						($totalActivosDic == 0 || $totalInfluencersDic == 0) ? $totalActivosInfluencersDic = 0 : $totalActivosInfluencersDic = $totalActivosDic / $totalInfluencersDic;
						echo number_format($totalActivosInfluencersDic * 100, 2) . '%';

						?>
					</td><?php } ?>

					<td class="text-center">
						<?php

						($totalActivosInfluencersEne == 0 && $totalActivosInfluencersFeb == 0 && $totalActivosInfluencersMar == 0 && $totalActivosInfluencersAbr == 0 && $totalActivosInfluencersMay == 0 && $totalActivosInfluencersJun == 0 && $totalActivosInfluencersJul == 0 && $totalActivosInfluencersAgo == 0 && $totalActivosInfluencersSep == 0 && $totalActivosInfluencersOct == 0 && $totalActivosInfluencersNov == 0 && $totalActivosInfluencersDic == 0) ? $promedioTotalActivos = 0 : $promedioTotalActivos = ($totalActivosInfluencersEne + $totalActivosInfluencersFeb + $totalActivosInfluencersMar + $totalActivosInfluencersAbr + $totalActivosInfluencersMay + $totalActivosInfluencersJun + $totalActivosInfluencersJul + $totalActivosInfluencersAgo + $totalActivosInfluencersSep + $totalActivosInfluencersOct + $totalActivosInfluencersNov + $totalActivosInfluencersDic);
						echo number_format(($promedioTotalActivos / $months) * 100, 2) . '%';

						?>
					</td>
				</tr>
			<!-- No. de Influencers - Activos Mensuales -->

			<!-- Optimo (30%) -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Óptimo (30%) de la Organización']; ?></th>
					<?php if($classEne == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoEne, 0); ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoFeb, 0); ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoMar, 0); ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoAbr, 0); ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoMay, 0); ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoJun, 0); ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoJul, 0); ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoAgo, 0); ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoSep, 0); ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoOct, 0); ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoNov, 0); ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoDic, 0); ?></td><?php } ?>

					<td class="text-center">
						<?php

						(($totalInfluencersOptimoEne) == 0 && ($totalInfluencersOptimoFeb) == 0 && ($totalInfluencersOptimoMar) == 0 && ($totalInfluencersOptimoAbr) == 0 && ($totalInfluencersOptimoMay) == 0 && ($totalInfluencersOptimoJun) == 0 && ($totalInfluencersOptimoJul) == 0 && ($totalInfluencersOptimoAgo) == 0 && ($totalInfluencersOptimoSep) == 0 && ($totalInfluencersOptimoOct) == 0 && ($totalInfluencersOptimoNov) == 0 && ($totalInfluencersOptimoDic) == 0) ? $promedioActivosFaltaron = 0 : $promedioActivosFaltaron = (($totalInfluencersOptimoEne) + ($totalInfluencersOptimoFeb) + ($totalInfluencersOptimoMar) + ($totalInfluencersOptimoAbr) + ($totalInfluencersOptimoMay) + ($totalInfluencersOptimoJun) + ($totalInfluencersOptimoJul) + ($totalInfluencersOptimoAgo) + ($totalInfluencersOptimoSep) + ($totalInfluencersOptimoOct) + ($totalInfluencersOptimoNov) + ($totalInfluencersOptimoDic));
						echo number_format($promedioActivosFaltaron / $months, 2);

						//echo "30.00%"

						?>
					</td>
				</tr>
			<!-- Optimo (30%) -->

			<!-- Activos que Faltaron -->
				<tr>
					<th scope="row"><?php echo $laguaje[$lang]['Activos que no alcanzaron el Óptimo ']; ?></th>

					<?php if($classEne == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoEne - $totalActivosEne < 0 ? 0 : $totalInfluencersOptimoEne - $totalActivosEne, 0); ?></td><?php } ?>
					<?php if($classFeb == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoFeb - $totalActivosFeb < 0 ? 0 : $totalInfluencersOptimoFeb - $totalActivosFeb, 0); ?></td><?php } ?>
					<?php if($classMar == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoMar - $totalActivosMar < 0 ? 0 : $totalInfluencersOptimoMar - $totalActivosMar, 0); ?></td><?php } ?>
					<?php if($classAbr == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoAbr - $totalActivosAbr < 0 ? 0 : $totalInfluencersOptimoAbr - $totalActivosAbr, 0); ?></td><?php } ?>
					<?php if($classMay == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoMay - $totalActivosMay < 0 ? 0 : $totalInfluencersOptimoMay - $totalActivosMay, 0); ?></td><?php } ?>
					<?php if($classJun == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoJun - $totalActivosJun < 0 ? 0 : $totalInfluencersOptimoJun - $totalActivosJun, 0); ?></td><?php } ?>
					<?php if($classJul == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoJul - $totalActivosJul < 0 ? 0 : $totalInfluencersOptimoJul - $totalActivosJul, 0); ?></td><?php } ?>
					<?php if($classAgo == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoAgo - $totalActivosAgo < 0 ? 0 : $totalInfluencersOptimoAgo - $totalActivosAgo, 0); ?></td><?php } ?>
					<?php if($classSep == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoSep - $totalActivosSep < 0 ? 0 : $totalInfluencersOptimoSep - $totalActivosSep, 0); ?></td><?php } ?>
					<?php if($classOct == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoOct - $totalActivosOct < 0 ? 0 : $totalInfluencersOptimoOct - $totalActivosOct, 0); ?></td><?php } ?>
					<?php if($classNov == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoNov - $totalActivosNov < 0 ? 0 : $totalInfluencersOptimoNov - $totalActivosNov, 0); ?></td><?php } ?>
					<?php if($classDic == "") { ?><td class="text-center"><?php echo number_format($totalInfluencersOptimoDic - $totalActivosDic < 0 ? 0 : $totalInfluencersOptimoDic - $totalActivosDic, 0); ?></td><?php } ?>

					<td class="text-center">
						<?php

						(($totalInfluencersOptimoEne - $totalActivosEne) == 0 && ($totalInfluencersOptimoFeb - $totalActivosFeb) == 0 && ($totalInfluencersOptimoMar - $totalActivosMar) == 0 && ($totalInfluencersOptimoAbr - $totalActivosAbr) == 0 && ($totalInfluencersOptimoMay - $totalActivosMay) == 0 && ($totalInfluencersOptimoJun - $totalActivosJun) == 0 && ($totalInfluencersOptimoJul - $totalActivosJul) == 0 && ($totalInfluencersOptimoAgo - $totalActivosAgo) == 0 && ($totalInfluencersOptimoSep - $totalActivosAgo) == 0 && ($totalInfluencersOptimoOct - $totalActivosOct) == 0 && ($totalInfluencersOptimoNov - $totalActivosNov) == 0 && ($totalInfluencersOptimoDic - $totalActivosDic) == 0) ? $promedioActivosFaltaron = 0 : $promedioActivosFaltaron = (($totalInfluencersOptimoEne - $totalActivosEne) + ($totalInfluencersOptimoFeb - $totalActivosFeb) + ($totalInfluencersOptimoMar - $totalActivosMar) + ($totalInfluencersOptimoAbr - $totalActivosAbr) + ($totalInfluencersOptimoMay - $totalActivosMay) + ($totalInfluencersOptimoJun - $totalActivosJun) + ($totalInfluencersOptimoJul - $totalActivosJul) + ($totalInfluencersOptimoAgo - $totalActivosAgo) + ($totalInfluencersOptimoSep - $totalActivosSep) + ($totalInfluencersOptimoOct - $totalActivosOct) + ($totalInfluencersOptimoNov - $totalActivosNov) + ($totalInfluencersOptimoDic - $totalActivosDic));
						echo number_format($promedioActivosFaltaron / $months, 2);

						//echo number_format(30 - (($promedioTotalActivos / 8) * 100), 2) . '%';

						?>
					</td>
				</tr>
			<!-- Activos que Faltaron -->
		</tbody>
	</table>
</div>

<?php
	$graphTexts = [
		'es' => [
			'Organization Purchases' => 'Compras Organización',
			'Organization Sign Ups' => 'Incorporación Organización',
			'Actives' => 'Actividad',
			'No. of Sign Ups' => 'No. de Incorporaciones',
		],
		'en' => [
			'Organization Purchases' => 'Organization Purchases',
			'Organization Sign Ups' => 'Organization Sign Ups',
			'Actives' => 'Actives',
			'No. of Sign Ups' => 'No. of Sign Ups',
		],
		'fr' => [
			'Organization Purchases' => 'Achats d\'organisation',
			'Organization Sign Ups' => 'Inscriptions à l\'organisation',
			'Actives' => 'Actifs',
			'No. of Sign Ups' => 'Nombre d\'inscriptions',
		],
	];
?>

<input type="hidden" id="Organization_Purchases">
<input type="hidden" id="Organization_Sign_Ups">
<input type="hidden" id="Actives">
<input type="hidden" id="No_of_Sign_Ups">

<script>
	var Organization_Purchases = $("#Organization_Purchases").val();
	var Organization_Sign_Ups = $("#Organization_Sign_Ups").val();
	var Actives = $("#Actives").val();
	var No_of_Sign_Ups = $("#No_of_Sign_Ups").val();

	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica
	var lasrYearLastGraph = $("#lasrYearLastGraph").text();
	var curYearLastGraph = $("#curYearLastGraph").text();
	//Compras Organización
		var chart6Graph1 = document.getElementById('chart6Graph1').getContext('2d');
		var chart6Graph1Detail = new Chart(chart6Graph1, {
		    type: 'line',
		    data: {
		        labels: <?php echo json_encode($monthLabelGraph) ?>,
		        datasets: [
			        {
			            label: lasrYearLastGraph,
			            data: <?php echo json_encode($dataComprasOrganizacion2021) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: curYearLastGraph,
			            data: <?php echo json_encode($dataComprasOrganizacion2022) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: Organization_Purchases
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: 'USD'
			        	},
			        	beginAtZero: true
			      	}
			    }
			},
		});
	//Compras Organización

	//Incorporación Organización
		var chart6Graph2 = document.getElementById('chart6Graph2').getContext('2d');
		var chart6Graph2Detail = new Chart(chart6Graph2, {
		    type: 'line',
		    data: {
		        labels: <?php echo json_encode($monthLabelGraph) ?>,
		        datasets: [
			        {
			            label: lasrYearLastGraph,
			            data: <?php echo json_encode($dataIncorporacionOrganizacion2021) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: curYearLastGraph,
			            data: <?php echo json_encode($dataIncorporacionOrganizacion2022) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: Organization_Sign_Ups
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: No_of_Sign_Ups
			        	},
			        	beginAtZero: true
			      	}
			    }
			},
		});
	//Incorporación Organización

	//Actividad
		var chart6Graph3 = document.getElementById('chart6Graph3').getContext('2d');
		var chart6Graph3Detail = new Chart(chart6Graph3, {
		    type: 'line',
		    data: {
		        labels: <?php echo json_encode($monthLabelGraph) ?>,
		        datasets: [
			        {
			            label: lasrYearLastGraph,
			            data: <?php echo json_encode($dataIncorporacionActividad2021) ?>,
			            backgroundColor: [ 'rgba(51, 51, 153, 1)', ],
			            borderColor: [ 'rgba(51, 51, 153, 1)', ],
			        },
			        {
			            label: curYearLastGraph,
			            data: <?php echo json_encode($dataIncorporacionActividad2022) ?>,
			            backgroundColor: [ 'rgba(102, 153, 102, 1)', ],
			            borderColor: [ 'rgba(102, 153, 102, 1)', ],
			        }
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: Actives
					},
				},
				scales: {
			      	y: {
			        	display: true,
			        	title: {
			          		display: true,
			          		text: Actives
			        	},
			        	beginAtZero: true
			      	}
			    }
			},
		});
	//Actividad

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>
