<?php require_once("../../functions.php"); //Funciones

$prod = $_POST["prod"];

if(trim($prod) === 'NO'){
	$serverName75 = "172.24.16.75";
}
else{
	$serverName75 = "104.130.46.73";
}

$connectionInfo = array("Database" => "SIP", "UID" => "nikkenmk", "PWD" => "M4rk3t1n$");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if(!$conn){ die(print_r(sqlsrv_errors(), true)); }
//Conexión

//Vars
$codeUser = $_POST["codeUser"];
$nameUser = $_POST["nameUser"];
$countrieUser = letterCountrie($_POST["countrieUser"]);
$rankUser = $_POST["rankUser"];
$periodo = $_POST["periodo"]; echo $periodo;
//Vars

//Others
$waterfallVtaProducto2013 = "0";
$waterfallVtaRepuestos2013 = "0";
$waterfallVtaIdeal2013 = "0";
$waterfallCumplimiento2013 = "0";

$waterfallVtaProducto2014 = "0";
$waterfallVtaRepuestos2014 = "0";
$waterfallVtaIdeal2014 = "0";
$waterfallCumplimiento2014 = "0";

$waterfallVtaProducto2015 = "0";
$waterfallVtaRepuestos2015 = "0";
$waterfallVtaIdeal2015 = "0";
$waterfallCumplimiento2015 = "0";

$waterfallVtaProducto2016 = "0";
$waterfallVtaRepuestos2016 = "0";
$waterfallVtaIdeal2016 = "0";
$waterfallCumplimiento2016 = "0";

$waterfallVtaProducto2017 = "0";
$waterfallVtaRepuestos2017 = "0";
$waterfallVtaIdeal2017 = "0";
$waterfallCumplimiento2017 = "0";

$waterfallVtaProducto2018 = "0";
$waterfallVtaRepuestos2018 = "0";
$waterfallVtaIdeal2018 = "0";
$waterfallCumplimiento2018 = "0";

$waterfallVtaProducto2019 = "0";
$waterfallVtaRepuestos2019 = "0";
$waterfallVtaIdeal2019 = "0";
$waterfallCumplimiento2019 = "0";

$waterfallVtaProducto2020 = "0";
$waterfallVtaRepuestos2020 = "0";
$waterfallVtaIdeal2020 = "0";
$waterfallCumplimiento2020 = "0";

$waterfallVtaProducto2021 = "0";
$waterfallVtaRepuestos2021 = "0";
$waterfallVtaIdeal2021 = "0";
$waterfallCumplimiento2021 = "0";

$waterfallVtaProducto2022 = "0";
$waterfallVtaRepuestos2022 = "0";
$waterfallVtaIdeal2022 = "0";
$waterfallCumplimiento2022 = "0";

$piWaterVtaProducto2013 = "0";
$piWaterVtaRepuestos2013 = "0";
$piWaterVtaIdeal2013 = "0";
$piWaterCumplimiento2013 = "0";

$piWaterVtaProducto2014 = "0";
$piWaterVtaRepuestos2014 = "0";
$piWaterVtaIdeal2014 = "0";
$piWaterCumplimiento2014 = "0";

$piWaterVtaProducto2015 = "0";
$piWaterVtaRepuestos2015 = "0";
$piWaterVtaIdeal2015 = "0";
$piWaterCumplimiento2015 = "0";

$piWaterVtaProducto2016 = "0";
$piWaterVtaRepuestos2016 = "0";
$piWaterVtaIdeal2016 = "0";
$piWaterCumplimiento2016 = "0";

$piWaterVtaProducto2017 = "0";
$piWaterVtaRepuestos2017 = "0";
$piWaterVtaIdeal2017 = "0";
$piWaterCumplimiento2017 = "0";

$piWaterVtaProducto2018 = "0";
$piWaterVtaRepuestos2018 = "0";
$piWaterVtaIdeal2018 = "0";
$piWaterCumplimiento2018 = "0";

$piWaterVtaProducto2019 = "0";
$piWaterVtaRepuestos2019 = "0";
$piWaterVtaIdeal2019 = "0";
$piWaterCumplimiento2019 = "0";

$piWaterVtaProducto2020 = "0";
$piWaterVtaRepuestos2020 = "0";
$piWaterVtaIdeal2020 = "0";
$piWaterCumplimiento2020 = "0";

$piWaterVtaProducto2021 = "0";
$piWaterVtaRepuestos2021 = "0";
$piWaterVtaIdeal2021 = "0";
$piWaterCumplimiento2021 = "0";

$piWaterVtaProducto2022 = "0";
$piWaterVtaRepuestos2022 = "0";
$piWaterVtaIdeal2022 = "0";
$piWaterCumplimiento2022 = "0";

$kenkoAirVtaProducto2013 = "0";
$kenkoAirVtaRepuestos2013 = "0";
$kenkoAirVtaIdeal2013 = "0";
$kenkoAirCumplimiento2013 = "0";

$kenkoAirVtaProducto2014 = "0";
$kenkoAirVtaRepuestos2014 = "0";
$kenkoAirVtaIdeal2014 = "0";
$kenkoAirCumplimiento2014 = "0";

$kenkoAirVtaProducto2015 = "0";
$kenkoAirVtaRepuestos2015 = "0";
$kenkoAirVtaIdeal2015 = "0";
$kenkoAirCumplimiento2015 = "0";

$kenkoAirVtaProducto2016 = "0";
$kenkoAirVtaRepuestos2016 = "0";
$kenkoAirVtaIdeal2016 = "0";
$kenkoAirCumplimiento2016 = "0";

$kenkoAirVtaProducto2017 = "0";
$kenkoAirVtaRepuestos2017 = "0";
$kenkoAirVtaIdeal2017 = "0";
$kenkoAirCumplimiento2017 = "0";

$kenkoAirVtaProducto2018 = "0";
$kenkoAirVtaRepuestos2018 = "0";
$kenkoAirVtaIdeal2018 = "0";
$kenkoAirCumplimiento2018 = "0";

$kenkoAirVtaProducto2019 = "0";
$kenkoAirVtaRepuestos2019 = "0";
$kenkoAirVtaIdeal2019 = "0";
$kenkoAirCumplimiento2019 = "0";

$kenkoAirVtaProducto2020 = "0";
$kenkoAirVtaRepuestos2020 = "0";
$kenkoAirVtaIdeal2020 = "0";
$kenkoAirCumplimiento2020 = "0";

$kenkoAirVtaProducto2021 = "0";
$kenkoAirVtaRepuestos2021 = "0";
$kenkoAirVtaIdeal2021 = "0";
$kenkoAirCumplimiento2021 = "0";

$kenkoAirVtaProducto2022 = "0";
$kenkoAirVtaRepuestos2022 = "0";
$kenkoAirVtaIdeal2022 = "0";
$kenkoAirCumplimiento2022 = "0";

$optimizerVtaProducto2013 = "0";
$optimizerVtaRepuestos2013 = "0";
$optimizerVtaIdeal2013 = "0";
$optimizerCumplimiento2013 = "0";

$optimizerVtaProducto2014 = "0";
$optimizerVtaRepuestos2014 = "0";
$optimizerVtaIdeal2014 = "0";
$optimizerCumplimiento2014 = "0";

$optimizerVtaProducto2015 = "0";
$optimizerVtaRepuestos2015 = "0";
$optimizerVtaIdeal2015 = "0";
$optimizerCumplimiento2015 = "0";

$optimizerVtaProducto2016 = "0";
$optimizerVtaRepuestos2016 = "0";
$optimizerVtaIdeal2016 = "0";
$optimizerCumplimiento2016 = "0";

$optimizerVtaProducto2017 = "0";
$optimizerVtaRepuestos2017 = "0";
$optimizerVtaIdeal2017 = "0";
$optimizerCumplimiento2017 = "0";

$optimizerVtaProducto2018 = "0";
$optimizerVtaRepuestos2018 = "0";
$optimizerVtaIdeal2018 = "0";
$optimizerCumplimiento2018 = "0";

$optimizerVtaProducto2019 = "0";
$optimizerVtaRepuestos2019 = "0";
$optimizerVtaIdeal2019 = "0";
$optimizerCumplimiento2019 = "0";

$optimizerVtaProducto2020 = "0";
$optimizerVtaRepuestos2020 = "0";
$optimizerVtaIdeal2020 = "0";
$optimizerCumplimiento2020 = "0";

$optimizerVtaProducto2021 = "0";
$optimizerVtaRepuestos2021 = "0";
$optimizerVtaIdeal2021 = "0";
$optimizerCumplimiento2021 = "0";

$optimizerVtaProducto2022 = "0";
$optimizerVtaRepuestos2022 = "0";
$optimizerVtaIdeal2022 = "0";
$optimizerCumplimiento2022 = "0";

$duchaManualVtaProducto2013 = "0";
$duchaManualVtaRepuestos2013 = "0";
$duchaManualVtaIdeal2013 = "0";
$duchaManualCumplimiento2013 = "0";

$duchaManualVtaProducto2014 = "0";
$duchaManualVtaRepuestos2014 = "0";
$duchaManualVtaIdeal2014 = "0";
$duchaManualCumplimiento2014 = "0";

$duchaManualVtaProducto2015 = "0";
$duchaManualVtaRepuestos2015 = "0";
$duchaManualVtaIdeal2015 = "0";
$duchaManualCumplimiento2015 = "0";

$duchaManualVtaProducto2016 = "0";
$duchaManualVtaRepuestos2016 = "0";
$duchaManualVtaIdeal2016 = "0";
$duchaManualCumplimiento2016 = "0";

$duchaManualVtaProducto2017 = "0";
$duchaManualVtaRepuestos2017 = "0";
$duchaManualVtaIdeal2017 = "0";
$duchaManualCumplimiento2017 = "0";

$duchaManualVtaProducto2018 = "0";
$duchaManualVtaRepuestos2018 = "0";
$duchaManualVtaIdeal2018 = "0";
$duchaManualCumplimiento2018 = "0";

$duchaManualVtaProducto2019 = "0";
$duchaManualVtaRepuestos2019 = "0";
$duchaManualVtaIdeal2019 = "0";
$duchaManualCumplimiento2019 = "0";

$duchaManualVtaProducto2020 = "0";
$duchaManualVtaRepuestos2020 = "0";
$duchaManualVtaIdeal2020 = "0";
$duchaManualCumplimiento2020 = "0";

$duchaManualVtaProducto2021 = "0";
$duchaManualVtaRepuestos2021 = "0";
$duchaManualVtaIdeal2021 = "0";
$duchaManualCumplimiento2021 = "0";

$duchaManualVtaProducto2022 = "0";
$duchaManualVtaRepuestos2022 = "0";
$duchaManualVtaIdeal2022 = "0";
$duchaManualCumplimiento2022 = "0";

$duchaParedVtaProducto2013 = "0";
$duchaParedVtaRepuestos2013 = "0";
$duchaParedVtaIdeal2013 = "0";
$duchaParedCumplimiento2013 = "0";

$duchaParedVtaProducto2014 = "0";
$duchaParedVtaRepuestos2014 = "0";
$duchaParedVtaIdeal2014 = "0";
$duchaParedCumplimiento2014 = "0";

$duchaParedVtaProducto2015 = "0";
$duchaParedVtaRepuestos2015 = "0";
$duchaParedVtaIdeal2015 = "0";
$duchaParedCumplimiento2015 = "0";

$duchaParedVtaProducto2016 = "0";
$duchaParedVtaRepuestos2016 = "0";
$duchaParedVtaIdeal2016 = "0";
$duchaParedCumplimiento2016 = "0";

$duchaParedVtaProducto2017 = "0";
$duchaParedVtaRepuestos2017 = "0";
$duchaParedVtaIdeal2017 = "0";
$duchaParedCumplimiento2017 = "0";

$duchaParedVtaProducto2018 = "0";
$duchaParedVtaRepuestos2018 = "0";
$duchaParedVtaIdeal2018 = "0";
$duchaParedCumplimiento2018 = "0";

$duchaParedVtaProducto2019 = "0";
$duchaParedVtaRepuestos2019 = "0";
$duchaParedVtaIdeal2019 = "0";
$duchaParedCumplimiento2019 = "0";

$duchaParedVtaProducto2020 = "0";
$duchaParedVtaRepuestos2020 = "0";
$duchaParedVtaIdeal2020 = "0";
$duchaParedCumplimiento2020 = "0";

$duchaParedVtaProducto2021 = "0";
$duchaParedVtaRepuestos2021 = "0";
$duchaParedVtaIdeal2021 = "0";
$duchaParedCumplimiento2021 = "0";

$duchaParedVtaProducto2022 = "0";
$duchaParedVtaRepuestos2022 = "0";
$duchaParedVtaIdeal2022 = "0";
$duchaParedCumplimiento2022 = "0";

$sql = "EXEC [dbo].[grafica_cambio_ideal] '$codeUser'";
$recordSet = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
while ($row_sap = sqlsrv_fetch_array($recordSet, SQLSRV_FETCH_NUMERIC)) {
	$product = trim($row_sap[0]);
	$period = trim($row_sap[1]);

	$vtaProducto = trim($row_sap[2]) == "" ? 0 : $row_sap[2];
	$vtaProducto = trim(str_replace(",", "", number_format($vtaProducto, 0, '.', '')));

	$vtaRepuestos = trim($row_sap[3]) == "" ? 0 : $row_sap[3];
	$vtaRepuestos = trim(str_replace(",", "", number_format($vtaRepuestos, 0, '.', '')));

	$vtaIdeal = trim($row_sap[4]) == "" ? 0 : $row_sap[4];
	$vtaIdeal = trim(str_replace(",", "", number_format($vtaIdeal, 0, '.', '')));

	$cumplimiento = trim($row_sap[5]) == "" ? 0 : $row_sap[5];
	$cumplimiento = trim(str_replace(",", "", number_format($cumplimiento * 100, 1, '.', '')));

	if($product == "Ducha Manual" && $period == "2013"){
		$duchaManualVtaProducto2013 = $vtaProducto;
		$duchaManualVtaRepuestos2013 = $vtaRepuestos;
		$duchaManualVtaIdeal2013 = $vtaIdeal;
		$duchaManualCumplimiento2013 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2014"){
		$duchaManualVtaProducto2014 = $vtaProducto;
		$duchaManualVtaRepuestos2014 = $vtaRepuestos;
		$duchaManualVtaIdeal2014 = $vtaIdeal;
		$duchaManualCumplimiento2014 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2015"){
		$duchaManualVtaProducto2015 = $vtaProducto;
		$duchaManualVtaRepuestos2015 = $vtaRepuestos;
		$duchaManualVtaIdeal2015 = $vtaIdeal;
		$duchaManualCumplimiento2015 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2016"){
		$duchaManualVtaProducto2016 = $vtaProducto;
		$duchaManualVtaRepuestos2016 = $vtaRepuestos;
		$duchaManualVtaIdeal2016 = $vtaIdeal;
		$duchaManualCumplimiento2016 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2017"){
		$duchaManualVtaProducto2017 = $vtaProducto;
		$duchaManualVtaRepuestos2017 = $vtaRepuestos;
		$duchaManualVtaIdeal2017 = $vtaIdeal;
		$duchaManualCumplimiento2017 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2018"){
		$duchaManualVtaProducto2018 = $vtaProducto;
		$duchaManualVtaRepuestos2018 = $vtaRepuestos;
		$duchaManualVtaIdeal2018 = $vtaIdeal;
		$duchaManualCumplimiento2018 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2019"){
		$duchaManualVtaProducto2019 = $vtaProducto;
		$duchaManualVtaRepuestos2019 = $vtaRepuestos;
		$duchaManualVtaIdeal2019 = $vtaIdeal;
		$duchaManualCumplimiento2019 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2020"){
		$duchaManualVtaProducto2020 = $vtaProducto;
		$duchaManualVtaRepuestos2020 = $vtaRepuestos;
		$duchaManualVtaIdeal2020 = $vtaIdeal;
		$duchaManualCumplimiento2020 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2021"){
		$duchaManualVtaProducto2021 = $vtaProducto;
		$duchaManualVtaRepuestos2021 = $vtaRepuestos;
		$duchaManualVtaIdeal2021 = $vtaIdeal;
		$duchaManualCumplimiento2021 = $cumplimiento;
	}

	if($product == "Ducha Manual" && $period == "2022"){
		$duchaManualVtaProducto2022 = $vtaProducto;
		$duchaManualVtaRepuestos2022 = $vtaRepuestos;
		$duchaManualVtaIdeal2022 = $vtaIdeal;
		$duchaManualCumplimiento2022 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2013"){
		$duchaParedVtaProducto2013 = $vtaProducto;
		$duchaParedVtaRepuestos2013 = $vtaRepuestos;
		$duchaParedVtaIdeal2013 = $vtaIdeal;
		$duchaParedCumplimiento2013 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2014"){
		$duchaParedVtaProducto2014 = $vtaProducto;
		$duchaParedVtaRepuestos2014 = $vtaRepuestos;
		$duchaParedVtaIdeal2014 = $vtaIdeal;
		$duchaParedCumplimiento2014 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2015"){
		$duchaParedVtaProducto2015 = $vtaProducto;
		$duchaParedVtaRepuestos2015 = $vtaRepuestos;
		$duchaParedVtaIdeal2015 = $vtaIdeal;
		$duchaParedCumplimiento2015 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2016"){
		$duchaParedVtaProducto2016 = $vtaProducto;
		$duchaParedVtaRepuestos2016 = $vtaRepuestos;
		$duchaParedVtaIdeal2016 = $vtaIdeal;
		$duchaParedCumplimiento2016 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2017"){
		$duchaParedVtaProducto2017 = $vtaProducto;
		$duchaParedVtaRepuestos2017 = $vtaRepuestos;
		$duchaParedVtaIdeal2017 = $vtaIdeal;
		$duchaParedCumplimiento2017 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2018"){
		$duchaParedVtaProducto2018 = $vtaProducto;
		$duchaParedVtaRepuestos2018 = $vtaRepuestos;
		$duchaParedVtaIdeal2018 = $vtaIdeal;
		$duchaParedCumplimiento2018 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2019"){
		$duchaParedVtaProducto2019 = $vtaProducto;
		$duchaParedVtaRepuestos2019 = $vtaRepuestos;
		$duchaParedVtaIdeal2019 = $vtaIdeal;
		$duchaParedCumplimiento2019 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2020"){
		$duchaParedVtaProducto2020 = $vtaProducto;
		$duchaParedVtaRepuestos2020 = $vtaRepuestos;
		$duchaParedVtaIdeal2020 = $vtaIdeal;
		$duchaParedCumplimiento2020 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2021"){
		$duchaParedVtaProducto2021 = $vtaProducto;
		$duchaParedVtaRepuestos2021 = $vtaRepuestos;
		$duchaParedVtaIdeal2021 = $vtaIdeal;
		$duchaParedCumplimiento2021 = $cumplimiento;
	}

	if($product == "Ducha Pared" && $period == "2022"){
		$duchaParedVtaProducto2022 = $vtaProducto;
		$duchaParedVtaRepuestos2022 = $vtaRepuestos;
		$duchaParedVtaIdeal2022 = $vtaIdeal;
		$duchaParedCumplimiento2022 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2013"){
		$kenkoAirVtaProducto2013 = $vtaProducto;
		$kenkoAirVtaRepuestos2013 = $vtaRepuestos;
		$kenkoAirVtaIdeal2013 = $vtaIdeal;
		$kenkoAirCumplimiento2013 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2014"){
		$kenkoAirVtaProducto2014 = $vtaProducto;
		$kenkoAirVtaRepuestos2014 = $vtaRepuestos;
		$kenkoAirVtaIdeal2014 = $vtaIdeal;
		$kenkoAirCumplimiento2014 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2015"){
		$kenkoAirVtaProducto2015 = $vtaProducto;
		$kenkoAirVtaRepuestos2015 = $vtaRepuestos;
		$kenkoAirVtaIdeal2015 = $vtaIdeal;
		$kenkoAirCumplimiento2015 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2016"){
		$kenkoAirVtaProducto2016 = $vtaProducto;
		$kenkoAirVtaRepuestos2016 = $vtaRepuestos;
		$kenkoAirVtaIdeal2016 = $vtaIdeal;
		$kenkoAirCumplimiento2016 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2017"){
		$kenkoAirVtaProducto2017 = $vtaProducto;
		$kenkoAirVtaRepuestos2017 = $vtaRepuestos;
		$kenkoAirVtaIdeal2017 = $vtaIdeal;
		$kenkoAirCumplimiento2017 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2018"){
		$kenkoAirVtaProducto2018 = $vtaProducto;
		$kenkoAirVtaRepuestos2018 = $vtaRepuestos;
		$kenkoAirVtaIdeal2018 = $vtaIdeal;
		$kenkoAirCumplimiento2018 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2019"){
		$kenkoAirVtaProducto2019 = $vtaProducto;
		$kenkoAirVtaRepuestos2019 = $vtaRepuestos;
		$kenkoAirVtaIdeal2019 = $vtaIdeal;
		$kenkoAirCumplimiento2019 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2020"){
		$kenkoAirVtaProducto2020 = $vtaProducto;
		$kenkoAirVtaRepuestos2020 = $vtaRepuestos;
		$kenkoAirVtaIdeal2020 = $vtaIdeal;
		$kenkoAirCumplimiento2020 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2021"){
		$kenkoAirVtaProducto2021 = $vtaProducto;
		$kenkoAirVtaRepuestos2021 = $vtaRepuestos;
		$kenkoAirVtaIdeal2021 = $vtaIdeal;
		$kenkoAirCumplimiento2021 = $cumplimiento;
	}

	if($product == "Kenko Air Purifier" && $period == "2022"){
		$kenkoAirVtaProducto2022 = $vtaProducto;
		$kenkoAirVtaRepuestos2022 = $vtaRepuestos;
		$kenkoAirVtaIdeal2022 = $vtaIdeal;
		$kenkoAirCumplimiento2022 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2013"){
		$optimizerVtaProducto2013 = $vtaProducto;
		$optimizerVtaRepuestos2013 = $vtaRepuestos;
		$optimizerVtaIdeal2013 = $vtaIdeal;
		$optimizerCumplimiento2013 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2014"){
		$optimizerVtaProducto2014 = $vtaProducto;
		$optimizerVtaRepuestos2014 = $vtaRepuestos;
		$optimizerVtaIdeal2014 = $vtaIdeal;
		$optimizerCumplimiento2014 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2015"){
		$optimizerVtaProducto2015 = $vtaProducto;
		$optimizerVtaRepuestos2015 = $vtaRepuestos;
		$optimizerVtaIdeal2015 = $vtaIdeal;
		$optimizerCumplimiento2015 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2016"){
		$optimizerVtaProducto2016 = $vtaProducto;
		$optimizerVtaRepuestos2016 = $vtaRepuestos;
		$optimizerVtaIdeal2016 = $vtaIdeal;
		$optimizerCumplimiento2016 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2017"){
		$optimizerVtaProducto2017 = $vtaProducto;
		$optimizerVtaRepuestos2017 = $vtaRepuestos;
		$optimizerVtaIdeal2017 = $vtaIdeal;
		$optimizerCumplimiento2017 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2018"){
		$optimizerVtaProducto2018 = $vtaProducto;
		$optimizerVtaRepuestos2018 = $vtaRepuestos;
		$optimizerVtaIdeal2018 = $vtaIdeal;
		$optimizerCumplimiento2018 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2019"){
		$optimizerVtaProducto2019 = $vtaProducto;
		$optimizerVtaRepuestos2019 = $vtaRepuestos;
		$optimizerVtaIdeal2019 = $vtaIdeal;
		$optimizerCumplimiento2019 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2020"){
		$optimizerVtaProducto2020 = $vtaProducto;
		$optimizerVtaRepuestos2020 = $vtaRepuestos;
		$optimizerVtaIdeal2020 = $vtaIdeal;
		$optimizerCumplimiento2020 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2021"){
		$optimizerVtaProducto2021 = $vtaProducto;
		$optimizerVtaRepuestos2021 = $vtaRepuestos;
		$optimizerVtaIdeal2021 = $vtaIdeal;
		$optimizerCumplimiento2021 = $cumplimiento;
	}

	if($product == "Pimag Optimizer" && $period == "2022"){
		$optimizerVtaProducto2022 = $vtaProducto;
		$optimizerVtaRepuestos2022 = $vtaRepuestos;
		$optimizerVtaIdeal2022 = $vtaIdeal;
		$optimizerCumplimiento2022 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2013"){
		$piWaterVtaProducto2013 = $vtaProducto;
		$piWaterVtaRepuestos2013 = $vtaRepuestos;
		$piWaterVtaIdeal2013 = $vtaIdeal;
		$piWaterCumplimiento2013 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2014"){
		$piWaterVtaProducto2014 = $vtaProducto;
		$piWaterVtaRepuestos2014 = $vtaRepuestos;
		$piWaterVtaIdeal2014 = $vtaIdeal;
		$piWaterCumplimiento2014 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2015"){
		$piWaterVtaProducto2015 = $vtaProducto;
		$piWaterVtaRepuestos2015 = $vtaRepuestos;
		$piWaterVtaIdeal2015 = $vtaIdeal;
		$piWaterCumplimiento2015 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2016"){
		$piWaterVtaProducto2016 = $vtaProducto;
		$piWaterVtaRepuestos2016 = $vtaRepuestos;
		$piWaterVtaIdeal2016 = $vtaIdeal;
		$piWaterCumplimiento2016 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2017"){
		$piWaterVtaProducto2017 = $vtaProducto;
		$piWaterVtaRepuestos2017 = $vtaRepuestos;
		$piWaterVtaIdeal2017 = $vtaIdeal;
		$piWaterCumplimiento2017 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2018"){
		$piWaterVtaProducto2018 = $vtaProducto;
		$piWaterVtaRepuestos2018 = $vtaRepuestos;
		$piWaterVtaIdeal2018 = $vtaIdeal;
		$piWaterCumplimiento2018 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2019"){
		$piWaterVtaProducto2019 = $vtaProducto;
		$piWaterVtaRepuestos2019 = $vtaRepuestos;
		$piWaterVtaIdeal2019 = $vtaIdeal;
		$piWaterCumplimiento2019 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2020"){
		$piWaterVtaProducto2020 = $vtaProducto;
		$piWaterVtaRepuestos2020 = $vtaRepuestos;
		$piWaterVtaIdeal2020 = $vtaIdeal;
		$piWaterCumplimiento2020 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2021"){
		$piWaterVtaProducto2021 = $vtaProducto;
		$piWaterVtaRepuestos2021 = $vtaRepuestos;
		$piWaterVtaIdeal2021 = $vtaIdeal;
		$piWaterCumplimiento2021 = $cumplimiento;
	}

	if($product == "Pimag Pi Water" && $period == "2022"){
		$piWaterVtaProducto2022 = $vtaProducto;
		$piWaterVtaRepuestos2022 = $vtaRepuestos;
		$piWaterVtaIdeal2022 = $vtaIdeal;
		$piWaterCumplimiento2022 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2013"){
		$waterfallVtaProducto2013 = $vtaProducto;
		$waterfallVtaRepuestos2013 = $vtaRepuestos;
		$waterfallVtaIdeal2013 = $vtaIdeal;
		$waterfallCumplimiento2013 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2014"){
		$waterfallVtaProducto2014 = $vtaProducto;
		$waterfallVtaRepuestos2014 = $vtaRepuestos;
		$waterfallVtaIdeal2014 = $vtaIdeal;
		$waterfallCumplimiento2014 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2015"){
		$waterfallVtaProducto2015 = $vtaProducto;
		$waterfallVtaRepuestos2015 = $vtaRepuestos;
		$waterfallVtaIdeal2015 = $vtaIdeal;
		$waterfallCumplimiento2015 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2016"){
		$waterfallVtaProducto2016 = $vtaProducto;
		$waterfallVtaRepuestos2016 = $vtaRepuestos;
		$waterfallVtaIdeal2016 = $vtaIdeal;
		$waterfallCumplimiento2016 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2017"){
		$waterfallVtaProducto2017 = $vtaProducto;
		$waterfallVtaRepuestos2017 = $vtaRepuestos;
		$waterfallVtaIdeal2017 = $vtaIdeal;
		$waterfallCumplimiento2017 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2018"){
		$waterfallVtaProducto2018 = $vtaProducto;
		$waterfallVtaRepuestos2018 = $vtaRepuestos;
		$waterfallVtaIdeal2018 = $vtaIdeal;
		$waterfallCumplimiento2018 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2019"){
		$waterfallVtaProducto2019 = $vtaProducto;
		$waterfallVtaRepuestos2019 = $vtaRepuestos;
		$waterfallVtaIdeal2019 = $vtaIdeal;
		$waterfallCumplimiento2019 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2020"){
		$waterfallVtaProducto2020 = $vtaProducto;
		$waterfallVtaRepuestos2020 = $vtaRepuestos;
		$waterfallVtaIdeal2020 = $vtaIdeal;
		$waterfallCumplimiento2020 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2021"){
		$waterfallVtaProducto2021 = $vtaProducto;
		$waterfallVtaRepuestos2021 = $vtaRepuestos;
		$waterfallVtaIdeal2021 = $vtaIdeal;
		$waterfallCumplimiento2021 = $cumplimiento;
	}

	if($product == "Pimag Waterfall" && $period == "2022"){
		$waterfallVtaProducto2022 = $vtaProducto;
		$waterfallVtaRepuestos2022 = $vtaRepuestos;
		$waterfallVtaIdeal2022 = $vtaIdeal;
		$waterfallCumplimiento2022 = $cumplimiento;
	}
}

?>

<!-- Mostrar logo -->
<img src="https://mi.nikkenlatam.com/custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Business Variables Report By Consultant</div>
			<div class="h6 mb-0"><span class="fw-bold">Periodo de Medición:</span> Enero 2013 a Agosto 2022</div>
			<div class="h6"><span class="fw-bold">Country:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Código:</span> 5863024600</div>
			<div class="h6"><span class="fw-bold">Rank:</span> <?php echo $rankUser ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="h6 fw-bold mb-2 mt-4 pt-4">COMPORTAMIENTO DE COMPRA DE PRODUCTO VS COMPRA DE REPUESTOS (PERSONAL)</div>

	<div class="row d-flex align-items-center mt-4">
		<div class="col-12 text-center">
			<!-- Pimag Waterfall -->
			<canvas id="viewChart8" class="w-100" height="510"></canvas>
			<!-- Pimag Waterfall -->
		</div>
	</div>

	<div class="row mt-5">
		<div class="col-12 text-center">
			<!-- Pimag Pi Water -->
			<canvas id="viewChart88" class="w-100" height="510"></canvas>
			<!-- Pimag Pi Water -->
		</div>
	</div>
<!-- Gráficas -->

<!-- Mostrar logo -->
<img src="custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Business Variables Report By Consultant</div>
			<div class="h6 mb-0"><span class="fw-bold">Periodo de Medición:</span> Enero 2013 a Agosto 2022</div>
			<div class="h6"><span class="fw-bold">Country:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Código:</span> 5863024600</div>
			<div class="h6"><span class="fw-bold">Rank:</span> <?php echo $rankUser ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="h6 fw-bold mb-2 mt-4 pt-4">COMPORTAMIENTO DE COMPRA DE PRODUCTO VS COMPRA DE REPUESTOS (PERSONAL)</div>

	<div class="row mt-4">
		<div class="col-12 text-center">
			<!-- Kenko Air Purifier -->
			<canvas id="viewChart888" class="w-100" height="510"></canvas>
			<!-- Kenko Air Purifier -->
		</div>
	</div>

	<div class="row mt-5">
		<div class="col-12 text-center">
			<!-- Pimag Optimizer -->
			<canvas id="viewChart8888" class="w-100" height="510"></canvas>
			<!-- Pimag Optimizer -->
		</div>
	</div>
<!-- Gráficas -->

<!-- Mostrar logo -->
<img src="custom/img/general/logo-nikken.png" srcset="custom/img/general/logo-nikken-2x.png 2x" class="img-fluid mt-4 mb-3" alt="NIKKEN Latinoamérica">
<!-- Mostrar logo -->

<!-- Cabecera -->
	<div class="row mb-3">
		<div class="col-auto">
			<div class="h5 fw-bold mb-1">Business Variables Report By Consultant</div>
			<div class="h6 mb-0"><span class="fw-bold">Periodo de Medición:</span> Enero 2013 a Agosto 2022</div>
			<div class="h6"><span class="fw-bold">Country:</span> <?php echo $countrieUser ?></div>
		</div>

		<div class="col-auto"><div class="h2 fw-bold px-5 mx-5"><?php echo $nameUser ?></div></div>

		<div class="col-auto">
			<div class="h6 mb-0"><span class="fw-bold">Código:</span> 5863024600</div>
			<div class="h6"><span class="fw-bold">Rank:</span> <?php echo $rankUser ?></div>
		</div>
	</div>
<!-- Cabecera -->

<!-- Gráficas -->
	<div class="h6 fw-bold mb-2 mt-4 pt-4">COMPORTAMIENTO DE COMPRA DE PRODUCTO VS COMPRA DE REPUESTOS (PERSONAL)</div>

	<div class="row mt-4">
		<div class="col-12 text-center">
			<!-- Ducha Manual -->
			<canvas id="viewChart88888" class="w-100" height="510"></canvas>
			<!-- Ducha Manual -->
		</div>
	</div>

	<div class="row mt-5">
		<div class="col-12 text-center">
			<!-- Ducha Pared -->
			<canvas id="viewChart888888" class="w-100" height="510"></canvas>
			<!-- Ducha Pared -->
		</div>
	</div>
<!-- Gráficas -->

<script>
	//Fuente de la gráfica
	Chart.defaults.font.size = 13;
	//Fuente de la gráfica

	//Pimag Waterfall
		var viewChart8 = document.getElementById('viewChart8').getContext('2d');
		var viewChart8Detail = new Chart(viewChart8, {
		    type: 'bar',
		    data: {
		        labels: ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022'],
		        datasets: [
			        {
			            label: 'Cumplimiento',
			            data: [<?php echo $waterfallCumplimiento2013 ?>, <?php echo $waterfallCumplimiento2014 ?>, <?php echo $waterfallCumplimiento2015 ?>, <?php echo $waterfallCumplimiento2016 ?>, <?php echo $waterfallCumplimiento2017 ?>, <?php echo $waterfallCumplimiento2018 ?>, <?php echo $waterfallCumplimiento2019 ?>, <?php echo $waterfallCumplimiento2020 ?>, <?php echo $waterfallCumplimiento2021 ?>, <?php echo $waterfallCumplimiento2022 ?>],
			            backgroundColor: [ 'rgba(27, 62, 115, 1)', ],
			            borderColor: [ 'rgba(27, 62, 115, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			            datalabels: {
							align: 'end',
							anchor: 'end',
							formatter: function(value){
					            return value + '% ';
					        }
						}
			        },
			        {
			            label: 'vta_producto',
			            data: [<?php echo $waterfallVtaProducto2013 ?>, <?php echo $waterfallVtaProducto2014 ?>, <?php echo $waterfallVtaProducto2015 ?>, <?php echo $waterfallVtaProducto2016 ?>, <?php echo $waterfallVtaProducto2017 ?>, <?php echo $waterfallVtaProducto2018 ?>, <?php echo $waterfallVtaProducto2019 ?>, <?php echo $waterfallVtaProducto2020 ?>, <?php echo $waterfallVtaProducto2021 ?>, <?php echo $waterfallVtaProducto2022 ?>],
			            backgroundColor: [ 'rgba(235, 125, 60, 1)', ],
			            borderColor: [ 'rgba(235, 125, 60, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_repuestos',
			            data: [<?php echo $waterfallVtaRepuestos2013 ?>, <?php echo $waterfallVtaRepuestos2014 ?>, <?php echo $waterfallVtaRepuestos2015 ?>, <?php echo $waterfallVtaRepuestos2016 ?>, <?php echo $waterfallVtaRepuestos2017 ?>, <?php echo $waterfallVtaRepuestos2018 ?>, <?php echo $waterfallVtaRepuestos2019 ?>, <?php echo $waterfallVtaRepuestos2020 ?>, <?php echo $waterfallVtaRepuestos2021 ?>, <?php echo $waterfallVtaRepuestos2022 ?>],
			            backgroundColor: [ 'rgba(165, 165, 165, 1)', ],
			            borderColor: [ 'rgba(165, 165, 165, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_ideal',
			            data: [<?php echo $waterfallVtaIdeal2013 ?>, <?php echo $waterfallVtaIdeal2014 ?>, <?php echo $waterfallVtaIdeal2015 ?>, <?php echo $waterfallVtaIdeal2016 ?>, <?php echo $waterfallVtaIdeal2017 ?>, <?php echo $waterfallVtaIdeal2018 ?>, <?php echo $waterfallVtaIdeal2019 ?>, <?php echo $waterfallVtaIdeal2020 ?>, <?php echo $waterfallVtaIdeal2021 ?>, <?php echo $waterfallVtaIdeal2022 ?>],
			            backgroundColor: [ 'rgba(253, 191, 45, 1)', ],
			            borderColor: [ 'rgba(253, 191, 45, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Pimag Waterfall'
					}
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
					},
				}
			},
			plugins: [ChartDataLabels],
		});
	//Pimag Waterfall

	//Pimag Pi Water
		var viewChart88 = document.getElementById('viewChart88').getContext('2d');
		var viewChart88Detail = new Chart(viewChart88, {
		    type: 'bar',
		    data: {
		        labels: ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022'],
		        datasets: [
			        {
			            label: 'Cumplimiento',
			            data: [<?php echo $piWaterCumplimiento2013 ?>, <?php echo $piWaterCumplimiento2014 ?>, <?php echo $piWaterCumplimiento2015 ?>, <?php echo $piWaterCumplimiento2016 ?>, <?php echo $piWaterCumplimiento2017 ?>, <?php echo $piWaterCumplimiento2018 ?>, <?php echo $piWaterCumplimiento2019 ?>, <?php echo $piWaterCumplimiento2020 ?>, <?php echo $piWaterCumplimiento2021 ?>, <?php echo $piWaterCumplimiento2022 ?>],
			            backgroundColor: [ 'rgba(27, 62, 115, 1)', ],
			            borderColor: [ 'rgba(27, 62, 115, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			            datalabels: {
							align: 'end',
							anchor: 'end',
							formatter: function(value){
					            return value + '% ';
					        }
						}
			        },
			        {
			            label: 'vta_producto',
			            data: [<?php echo $piWaterVtaProducto2013 ?>, <?php echo $piWaterVtaProducto2014 ?>, <?php echo $piWaterVtaProducto2015 ?>, <?php echo $piWaterVtaProducto2016 ?>, <?php echo $piWaterVtaProducto2017 ?>, <?php echo $piWaterVtaProducto2018 ?>, <?php echo $piWaterVtaProducto2019 ?>, <?php echo $piWaterVtaProducto2020 ?>, <?php echo $piWaterVtaProducto2021 ?>, <?php echo $piWaterVtaProducto2022 ?>],
			            backgroundColor: [ 'rgba(235, 125, 60, 1)', ],
			            borderColor: [ 'rgba(235, 125, 60, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_repuestos',
			            data: [<?php echo $piWaterVtaRepuestos2013 ?>, <?php echo $piWaterVtaRepuestos2014 ?>, <?php echo $piWaterVtaRepuestos2015 ?>, <?php echo $piWaterVtaRepuestos2016 ?>, <?php echo $piWaterVtaRepuestos2017 ?>, <?php echo $piWaterVtaRepuestos2018 ?>, <?php echo $piWaterVtaRepuestos2019 ?>, <?php echo $piWaterVtaRepuestos2020 ?>, <?php echo $piWaterVtaRepuestos2021 ?>, <?php echo $piWaterVtaRepuestos2022 ?>],
			            backgroundColor: [ 'rgba(165, 165, 165, 1)', ],
			            borderColor: [ 'rgba(165, 165, 165, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_ideal',
			            data: [<?php echo $piWaterVtaIdeal2013 ?>, <?php echo $piWaterVtaIdeal2014 ?>, <?php echo $piWaterVtaIdeal2015 ?>, <?php echo $piWaterVtaIdeal2016 ?>, <?php echo $piWaterVtaIdeal2017 ?>, <?php echo $piWaterVtaIdeal2018 ?>, <?php echo $piWaterVtaIdeal2019 ?>, <?php echo $piWaterVtaIdeal2020 ?>, <?php echo $piWaterVtaIdeal2021 ?>, <?php echo $piWaterVtaIdeal2022 ?>],
			            backgroundColor: [ 'rgba(253, 191, 45, 1)', ],
			            borderColor: [ 'rgba(253, 191, 45, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Pimag Pi Water'
					}
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
					},
				}
			},
			plugins: [ChartDataLabels],
		});
	//Pimag Pi Water

	//Kenko Air Purifier
		var viewChart888 = document.getElementById('viewChart888').getContext('2d');
		var viewChart888Detail = new Chart(viewChart888, {
		    type: 'bar',
		    data: {
		        labels: ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022'],
		        datasets: [
			        {
			            label: 'Cumplimiento',
			            data: [<?php echo $kenkoAirCumplimiento2013 ?>, <?php echo $kenkoAirCumplimiento2014 ?>, <?php echo $kenkoAirCumplimiento2015 ?>, <?php echo $kenkoAirCumplimiento2016 ?>, <?php echo $kenkoAirCumplimiento2017 ?>, <?php echo $kenkoAirCumplimiento2018 ?>, <?php echo $kenkoAirCumplimiento2019 ?>, <?php echo $kenkoAirCumplimiento2020 ?>, <?php echo $kenkoAirCumplimiento2021 ?>, <?php echo $kenkoAirCumplimiento2022 ?>],
			            backgroundColor: [ 'rgba(27, 62, 115, 1)', ],
			            borderColor: [ 'rgba(27, 62, 115, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			            datalabels: {
							align: 'end',
							anchor: 'end',
							formatter: function(value){
					            return value + '% ';
					        }
						}
			        },
			        {
			            label: 'vta_producto',
			            data: [<?php echo $kenkoAirVtaProducto2013 ?>, <?php echo $kenkoAirVtaProducto2014 ?>, <?php echo $kenkoAirVtaProducto2015 ?>, <?php echo $kenkoAirVtaProducto2016 ?>, <?php echo $kenkoAirVtaProducto2017 ?>, <?php echo $kenkoAirVtaProducto2018 ?>, <?php echo $kenkoAirVtaProducto2019 ?>, <?php echo $kenkoAirVtaProducto2020 ?>, <?php echo $kenkoAirVtaProducto2021 ?>, <?php echo $kenkoAirVtaProducto2022 ?>],
			            backgroundColor: [ 'rgba(235, 125, 60, 1)', ],
			            borderColor: [ 'rgba(235, 125, 60, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_repuestos',
			            data: [<?php echo $kenkoAirVtaRepuestos2013 ?>, <?php echo $kenkoAirVtaRepuestos2014 ?>, <?php echo $kenkoAirVtaRepuestos2015 ?>, <?php echo $kenkoAirVtaRepuestos2016 ?>, <?php echo $kenkoAirVtaRepuestos2017 ?>, <?php echo $kenkoAirVtaRepuestos2018 ?>, <?php echo $kenkoAirVtaRepuestos2019 ?>, <?php echo $kenkoAirVtaRepuestos2020 ?>, <?php echo $kenkoAirVtaRepuestos2021 ?>, <?php echo $kenkoAirVtaRepuestos2022 ?>],
			            backgroundColor: [ 'rgba(165, 165, 165, 1)', ],
			            borderColor: [ 'rgba(165, 165, 165, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_ideal',
			            data: [<?php echo $kenkoAirVtaIdeal2013 ?>, <?php echo $kenkoAirVtaIdeal2014 ?>, <?php echo $kenkoAirVtaIdeal2015 ?>, <?php echo $kenkoAirVtaIdeal2016 ?>, <?php echo $kenkoAirVtaIdeal2017 ?>, <?php echo $kenkoAirVtaIdeal2018 ?>, <?php echo $kenkoAirVtaIdeal2019 ?>, <?php echo $kenkoAirVtaIdeal2020 ?>, <?php echo $kenkoAirVtaIdeal2021 ?>, <?php echo $kenkoAirVtaIdeal2022 ?>],
			            backgroundColor: [ 'rgba(253, 191, 45, 1)', ],
			            borderColor: [ 'rgba(253, 191, 45, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Kenko Air Purifier'
					}
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
					},
				}
			},
			plugins: [ChartDataLabels],
		});
	//Kenko Air Purifier

	//Pimag Optimizer
		var viewChart8888 = document.getElementById('viewChart8888').getContext('2d');
		var viewChart8888Detail = new Chart(viewChart8888, {
		    type: 'bar',
		    data: {
		        labels: ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022'],
		        datasets: [
			        {
			            label: 'Cumplimiento',
			            data: [<?php echo $optimizerCumplimiento2013 ?>, <?php echo $optimizerCumplimiento2014 ?>, <?php echo $optimizerCumplimiento2015 ?>, <?php echo $optimizerCumplimiento2016 ?>, <?php echo $optimizerCumplimiento2017 ?>, <?php echo $optimizerCumplimiento2018 ?>, <?php echo $optimizerCumplimiento2019 ?>, <?php echo $optimizerCumplimiento2020 ?>, <?php echo $optimizerCumplimiento2021 ?>, <?php echo $optimizerCumplimiento2022 ?>],
			            backgroundColor: [ 'rgba(27, 62, 115, 1)', ],
			            borderColor: [ 'rgba(27, 62, 115, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			            datalabels: {
							align: 'end',
							anchor: 'end',
							formatter: function(value){
					            return value + '% ';
					        }
						}
			        },
			        {
			            label: 'vta_producto',
			            data: [<?php echo $optimizerVtaProducto2013 ?>, <?php echo $optimizerVtaProducto2014 ?>, <?php echo $optimizerVtaProducto2015 ?>, <?php echo $optimizerVtaProducto2016 ?>, <?php echo $optimizerVtaProducto2017 ?>, <?php echo $optimizerVtaProducto2018 ?>, <?php echo $optimizerVtaProducto2019 ?>, <?php echo $optimizerVtaProducto2020 ?>, <?php echo $optimizerVtaProducto2021 ?>, <?php echo $optimizerVtaProducto2022 ?>],
			            backgroundColor: [ 'rgba(235, 125, 60, 1)', ],
			            borderColor: [ 'rgba(235, 125, 60, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_repuestos',
			            data: [<?php echo $optimizerVtaRepuestos2013 ?>, <?php echo $optimizerVtaRepuestos2014 ?>, <?php echo $optimizerVtaRepuestos2015 ?>, <?php echo $optimizerVtaRepuestos2016 ?>, <?php echo $optimizerVtaRepuestos2017 ?>, <?php echo $optimizerVtaRepuestos2018 ?>, <?php echo $optimizerVtaRepuestos2019 ?>, <?php echo $optimizerVtaRepuestos2020 ?>, <?php echo $optimizerVtaRepuestos2021 ?>, <?php echo $optimizerVtaRepuestos2022 ?>],
			            backgroundColor: [ 'rgba(165, 165, 165, 1)', ],
			            borderColor: [ 'rgba(165, 165, 165, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_ideal',
			            data: [<?php echo $optimizerVtaIdeal2013 ?>, <?php echo $optimizerVtaIdeal2014 ?>, <?php echo $optimizerVtaIdeal2015 ?>, <?php echo $optimizerVtaIdeal2016 ?>, <?php echo $optimizerVtaIdeal2017 ?>, <?php echo $optimizerVtaIdeal2018 ?>, <?php echo $optimizerVtaIdeal2019 ?>, <?php echo $optimizerVtaIdeal2020 ?>, <?php echo $optimizerVtaIdeal2021 ?>, <?php echo $optimizerVtaIdeal2022 ?>],
			            backgroundColor: [ 'rgba(253, 191, 45, 1)', ],
			            borderColor: [ 'rgba(253, 191, 45, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Pimag Optimizer'
					}
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
					},
				}
			},
			plugins: [ChartDataLabels],
		});
	//Pimag Optimizer

	//Ducha Manual
		var viewChart88888 = document.getElementById('viewChart88888').getContext('2d');
		var viewChart88888Detail = new Chart(viewChart88888, {
		    type: 'bar',
		    data: {
		        labels: ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022'],
		        datasets: [
			        {
			            label: 'Cumplimiento',
			            data: [<?php echo $duchaManualCumplimiento2013 ?>, <?php echo $duchaManualCumplimiento2014 ?>, <?php echo $duchaManualCumplimiento2015 ?>, <?php echo $duchaManualCumplimiento2016 ?>, <?php echo $duchaManualCumplimiento2017 ?>, <?php echo $duchaManualCumplimiento2018 ?>, <?php echo $duchaManualCumplimiento2019 ?>, <?php echo $duchaManualCumplimiento2020 ?>, <?php echo $duchaManualCumplimiento2021 ?>, <?php echo $duchaManualCumplimiento2022 ?>],
			            backgroundColor: [ 'rgba(27, 62, 115, 1)', ],
			            borderColor: [ 'rgba(27, 62, 115, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			            datalabels: {
							align: 'end',
							anchor: 'end',
							formatter: function(value){
					            return value + '% ';
					        }
						}
			        },
			        {
			            label: 'vta_producto',
			            data: [<?php echo $duchaManualVtaProducto2013 ?>, <?php echo $duchaManualVtaProducto2014 ?>, <?php echo $duchaManualVtaProducto2015 ?>, <?php echo $duchaManualVtaProducto2016 ?>, <?php echo $duchaManualVtaProducto2017 ?>, <?php echo $duchaManualVtaProducto2018 ?>, <?php echo $duchaManualVtaProducto2019 ?>, <?php echo $duchaManualVtaProducto2020 ?>, <?php echo $duchaManualVtaProducto2021 ?>, <?php echo $duchaManualVtaProducto2022 ?>],
			            backgroundColor: [ 'rgba(235, 125, 60, 1)', ],
			            borderColor: [ 'rgba(235, 125, 60, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_repuestos',
			            data: [<?php echo $duchaManualVtaRepuestos2013 ?>, <?php echo $duchaManualVtaRepuestos2014 ?>, <?php echo $duchaManualVtaRepuestos2015 ?>, <?php echo $duchaManualVtaRepuestos2020 ?>, <?php echo $duchaManualVtaRepuestos2020 ?>, <?php echo $duchaManualVtaRepuestos2020 ?>, <?php echo $duchaManualVtaRepuestos2020 ?>, <?php echo $duchaManualVtaRepuestos2020 ?>, <?php echo $duchaManualVtaRepuestos2021 ?>, <?php echo $duchaManualVtaRepuestos2022 ?>],
			            backgroundColor: [ 'rgba(165, 165, 165, 1)', ],
			            borderColor: [ 'rgba(165, 165, 165, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_ideal',
			            data: [<?php echo $duchaManualVtaIdeal2013 ?>, <?php echo $duchaManualVtaIdeal2014 ?>, <?php echo $duchaManualVtaIdeal2015 ?>, <?php echo $duchaManualVtaIdeal2016 ?>, <?php echo $duchaManualVtaIdeal2017 ?>, <?php echo $duchaManualVtaIdeal2018 ?>, <?php echo $duchaManualVtaIdeal2019 ?>, <?php echo $duchaManualVtaIdeal2020 ?>, <?php echo $duchaManualVtaIdeal2021 ?>, <?php echo $duchaManualVtaIdeal2022 ?>],
			            backgroundColor: [ 'rgba(253, 191, 45, 1)', ],
			            borderColor: [ 'rgba(253, 191, 45, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Ducha Manual'
					}
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
					},
				}
			},
			plugins: [ChartDataLabels],
		});
	//Ducha Manual

	//Ducha Pared
		var viewChart888888 = document.getElementById('viewChart888888').getContext('2d');
		var viewChart888888Detail = new Chart(viewChart888888, {
		    type: 'bar',
		    data: {
		        labels: ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022'],
		        datasets: [
			        {
			            label: 'Cumplimiento',
			            data: [<?php echo $duchaParedCumplimiento2013 ?>, <?php echo $duchaParedCumplimiento2014 ?>, <?php echo $duchaParedCumplimiento2015 ?>, <?php echo $duchaParedCumplimiento2016 ?>, <?php echo $duchaParedCumplimiento2017 ?>, <?php echo $duchaParedCumplimiento2018 ?>, <?php echo $duchaParedCumplimiento2019 ?>, <?php echo $duchaParedCumplimiento2020 ?>, <?php echo $duchaParedCumplimiento2021 ?>, <?php echo $duchaParedCumplimiento2022 ?>],
			            backgroundColor: [ 'rgba(27, 62, 115, 1)', ],
			            borderColor: [ 'rgba(27, 62, 115, 1)', ],
			            yAxisID: 'y1',
			            type: 'line',
			            datalabels: {
							align: 'end',
							anchor: 'end',
							formatter: function(value){
					            return value + '% ';
					        }
						}
			        },
			        {
			            label: 'vta_producto',
			            data: [<?php echo $duchaParedVtaProducto2013 ?>, <?php echo $duchaParedVtaProducto2014 ?>, <?php echo $duchaParedVtaProducto2015 ?>, <?php echo $duchaParedVtaProducto2016 ?>, <?php echo $duchaParedVtaProducto2017 ?>, <?php echo $duchaParedVtaProducto2018 ?>, <?php echo $duchaParedVtaProducto2019 ?>, <?php echo $duchaParedVtaProducto2020 ?>, <?php echo $duchaParedVtaProducto2021 ?>, <?php echo $duchaParedVtaProducto2022 ?>],
			            backgroundColor: [ 'rgba(235, 125, 60, 1)', ],
			            borderColor: [ 'rgba(235, 125, 60, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_repuestos',
			            data: [<?php echo $duchaParedVtaRepuestos2013 ?>, <?php echo $duchaParedVtaRepuestos2014 ?>, <?php echo $duchaParedVtaRepuestos2015 ?>, <?php echo $duchaParedVtaRepuestos2016 ?>, <?php echo $duchaParedVtaRepuestos2017 ?>, <?php echo $duchaParedVtaRepuestos2018 ?>, <?php echo $duchaParedVtaRepuestos2019 ?>, <?php echo $duchaParedVtaRepuestos2020 ?>, <?php echo $duchaParedVtaRepuestos2021 ?>, <?php echo $duchaParedVtaRepuestos2022 ?>],
			            backgroundColor: [ 'rgba(165, 165, 165, 1)', ],
			            borderColor: [ 'rgba(165, 165, 165, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
			        {
			            label: 'vta_ideal',
			            data: [<?php echo $duchaParedVtaIdeal2013 ?>, <?php echo $duchaParedVtaIdeal2014 ?>, <?php echo $duchaParedVtaIdeal2015 ?>, <?php echo $duchaParedVtaIdeal2016 ?>, <?php echo $duchaParedVtaIdeal2017 ?>, <?php echo $duchaParedVtaIdeal2018 ?>, <?php echo $duchaParedVtaIdeal2019 ?>, <?php echo $duchaParedVtaIdeal2020 ?>, <?php echo $duchaParedVtaIdeal2021 ?>, <?php echo $duchaParedVtaIdeal2022 ?>],
			            backgroundColor: [ 'rgba(253, 191, 45, 1)', ],
			            borderColor: [ 'rgba(253, 191, 45, 1)', ],
			            yAxisID: 'y',
			            datalabels: {
							align: 'end',
							anchor: 'end'
						}
			        },
		        ]
		    },
		    options: {
		    	responsive: false,
				plugins: {
					title: {
						display: true,
						text: 'Ducha Pared'
					}
				},
				scales: {
					y: {
						type: 'linear',
						display: true,
						position: 'left',
					},
					y1: {
						type: 'linear',
						display: true,
						position: 'right',
					},
				}
			},
			plugins: [ChartDataLabels],
		});
	//Ducha Pared

	//Configuración Impresión
	window.addEventListener('beforeprint', () => { for (let id in Chart.instances) { Chart.instances[id].resize(); }});
	//Configuración Impresión
</script>