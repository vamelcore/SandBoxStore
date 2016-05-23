<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_zar'] == 1)) {
		
$_POST=defender_xss_full($_POST);
$_POST=defender_sql($_POST);			
		
	   if (isset($_POST['vudano'])) {$vudano = $_POST['vudano']; if ($vudano == '') {$vudano='0';}}
      if (isset($_POST['shtraf'])) {$shtraf = $_POST['shtraf'];if ($shtraf == '') {$shtraf='0';}}
      if (isset($_POST['bonus'])) {$bonus = $_POST['bonus'];if ($bonus == '') {$bonus='0';}}

$res_zap = mysql_query("SELECT * FROM zarplata WHERE ID_usera = '{$_SESSION['user_zp']}' ORDER BY `ID` DESC LIMIT 1");	
$myr_zap = mysql_fetch_array($res_zap);
$zarplata = $myr_zap['k_oplate'] - $vudano - $shtraf + $bonus;

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));

$res=mysql_query("INSERT INTO zarplata SET ID_prodaja = '0', ID_magazina = '{$myr_zap['ID_magazina']}', ID_usera = '{$myr_zap['ID_usera']}', data = '$dat', vremya = '$vremya', polniy_den = '----', polov_dnya = '----', prodaja = '----', procent = '----', k_oplate = '$zarplata', vudano = '$vudano', shtraf = '$shtraf', bonus = '$bonus', user = '{$_SESSION['login']}'",$db);	


header("Location: ../zarplata.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>