<?php
// php ini 動態設定
header("Content-Type:Text/html;charset=utf-8");
ini_set("display_errors","On");
error_reporting(E_ALL);
ini_set("memory_limit","512M");
date_default_timezone_set('Asia/Taipei');
ini_set("default_charset", "UTF-8");
mb_internal_encoding("UTF-8");

// 環境變數 動態設定
include('dev_coder.php');
use DevCoder\DotEnv;
(new DotEnv(__DIR__ . '/../.env'))->load();

// 取得環境變數
$dataBaseHost = getenv('DB_HOST');
$dataBaseName = getenv('DB_DATABASE');
$dataBaseAccount = getenv('DB_USERNAME');
$dataBasePassword = getenv('DB_PASSWORD');

try {
	//使用PDO建立SQL Server連線 $pdo
	//array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 為資料庫的編碼
	$pdo = new PDO("mysql:host=".$dataBaseHost.";port=3306;Database=".$dataBaseName , $dataBaseAccount, $dataBasePassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
	
	//發生錯誤時，出現錯誤提醒
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	
} catch (PDOException $e) {
	//發生錯誤，結束資料庫連線並印出錯誤訊息
	die($e->getMessage());
}

?>