<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}
if (isset($id)) {$res_kassa=mysql_query("DELETE FROM `beznal` WHERE `ID` = '$id'",$db);}
else {
	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);	
	
	if (isset($_POST['summa'])) {$summa = $_POST['summa'];if ($summa == '') {unset($summa);}}
	if (isset($_POST['izmenenie'])) {$izmenenie = $_POST['izmenenie'];if ($izmenenie == '') {unset($izmenenie);}}
   
$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y H:i:s', mktime ($hours));

if (isset($_POST['plus'])) {
$beznal_summa = $summa + $izmenenie;
$izm = '+'.$izmenenie;
}
elseif (isset($_POST['minus'])) {
$beznal_summa = $summa - $izmenenie;
$izm = '-'.$izmenenie;
}
else {$beznal_summa = 0;}
$res_beznal = mysql_query("INSERT INTO `beznal` SET `ID_scheta` = '1', `ID_prodaja` = '0', `data` = '$dat', `magazine` = '----', `summa` = '$beznal_summa', `izmenenie` = '$izm', user = '{$_SESSION['login']}' ",$db);	
}

header("Location: ../beznal.php");

//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>
