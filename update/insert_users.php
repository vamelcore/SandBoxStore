<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {
	
if (isset($_SESSION['selected_user'])) {$id = $_SESSION['selected_user']; if ($id == '') {unset ($id);}}
	
if (isset($_POST['add_priv_ost'])) {$add_priv_ost = 1;} else {$add_priv_ost = 0;}
if (isset($_POST['ed_priv_ost'])) {$ed_priv_ost = 1;} else {$ed_priv_ost = 0;}
if (isset($_POST['add_priv_pro'])) {$add_priv_pro = 1;} else {$add_priv_pro = 0;}
if (isset($_POST['ed_priv_pro'])) {$ed_priv_pro = 1;} else {$ed_priv_pro = 0;}
if (isset($_POST['add_priv_zar'])) {$add_priv_zar = 1;} else {$add_priv_zar = 0;}
if (isset($_POST['ed_priv_zar'])) {$ed_priv_zar = 1;} else {$ed_priv_zar = 0;}
if (isset($_POST['add_priv_voz'])) {$add_priv_voz = 1;} else {$add_priv_voz = 0;}
if (isset($_POST['ed_priv_voz'])) {$ed_priv_voz = 1;} else {$ed_priv_voz = 0;}

if (isset($_POST['allpriv'])) {$allpriv = 1;} else {$allpriv = 0;}

if ($id == '1001') {$priv_admin = 1; $priv_root = 1;} else {
if (isset($_POST['priv_admin'])) {$priv_admin = 1;} else {$priv_admin = 0;}
if (isset($_POST['priv_root'])) {$priv_root = 1;} else {$priv_root = 0;}
}

if (isset($_POST['priv_inkas'])) {$priv_inkas = 1;} else {$priv_inkas = 0;}
if (isset($_POST['priv_roll'])) {$priv_roll = 1;} else {$priv_roll = 0;}

$store_pr = $add_priv_ost.$ed_priv_ost.$add_priv_pro.$ed_priv_pro.$add_priv_zar.$ed_priv_zar.$add_priv_voz.$ed_priv_voz;

$res = mysql_query("SELECT `ID` FROM magazinu ORDER BY ID ASC",$db);
$myr = mysql_fetch_array($res);

$magaz_pr='';

do {
	$st_mn = "mag_".$myr['ID'];
if (isset($_POST[$st_mn])) {$magaz_pr=$magaz_pr."1";} else {$magaz_pr=$magaz_pr."0";}	
}while ($myr = mysql_fetch_array($res));

if (isset($id)) {
$res=mysql_query("UPDATE users SET AED = '$store_pr', storepriv = '$magaz_pr', allpriv = '$allpriv', kassapriv = '$priv_inkas', rollpriv = '$priv_roll', adminpriv = '$priv_admin', rootpriv = '$priv_root'  WHERE ID = '$id'",$db);	unset($id);
} 

header("Location: ../prava.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>