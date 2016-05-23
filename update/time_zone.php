<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

if (isset($_POST['group1'])) {$tz = $_POST['group1'];}
	
$timez = mysql_query("UPDATE timezone SET time_zone = '$tz' WHERE ID = '1'",$db);
if ($tz == 'winter') {$_SESSION['time_zone'] = '8';} else {$_SESSION['time_zone'] = '9';}

header("Location: ../timezone.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>