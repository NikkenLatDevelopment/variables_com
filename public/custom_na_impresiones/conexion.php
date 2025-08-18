<?php

$dbHost = '104.130.46.73:3306';
//$dbHost = '172.24.16.75:3306';
$dbName = 'nikkenla_panel';
$dbUser = 'nikkenla_mkrt';
$dbPass = 'NNikken2011$$';

try{
	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (Exception $e){ exit($e->getMessage() . " - 104.130.46.73:3306"); }

?>