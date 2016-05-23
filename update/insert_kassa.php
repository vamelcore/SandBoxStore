<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && (($_SESSION['admin_priv'] == 1) || ($_POST['get_priv_for_prod'] == 1001))) {

if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}
if (isset($id)) {$res_kassa=mysql_query("DELETE FROM kassa WHERE ID = '$id'",$db);}
else {
	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);	
	
	  if (isset($_POST['magaz'])) {$magaz = $_POST['magaz'];if ($magaz == '') {unset($magaz);}}
	  if (isset($_POST['vkasse'])) {$vkasse = $_POST['vkasse'];if ($vkasse == '') {unset($vkasse);}}
	  if (isset($_POST['inkas'])) {$inkas = $_POST['inkas'];if ($inkas == '') {unset($inkas);}}
    if (isset($_POST['prichina'])) {$prichina = $_POST['prichina'];if ($prichina == '') {unset($prichina);}}
$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y H:i:s', mktime ($hours));
$vkassein = $vkasse - $inkas;

if (isset($prichina)) {$user_inkas = $_SESSION['login'].': '.$prichina;}
else {$user_inkas = $_SESSION['login'];}

$res_kassa=mysql_query("INSERT INTO kassa SET ID_prodaja = '0', data = '$dat', magazine = '$magaz', vkasse = '$vkassein', inkas = '$inkas', user = '$user_inkas' ",$db);	
}
if ((isset($_POST['get_priv_for_prod'])) && ($_POST['get_priv_for_prod'] == 1001)) {header("Location: ../prodaja.php");}
else {header("Location: ../kassa.php");}

//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>