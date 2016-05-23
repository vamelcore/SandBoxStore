<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

//Проверка масивов переменных.	
$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['id_roll'])) {$id_roll = $_POST['id_roll']; if ($id_roll == '') {unset ($id_roll);}}		   
if (isset($_POST['sdata'])) {$sdata = $_POST['sdata']; if ($sdata == '') {unset ($sdata);}}
if (isset($_POST['id_print'])) {$id_print = $_POST['id_print']; if ($id_print == '') {unset ($id_print);}}	
if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset ($magazine);}}
if (isset($_POST['magazine_name'])) {$magazine_name = $_POST['magazine_name']; if ($magazine_name == '') {unset ($magazine_name);}}
if (isset($_POST['kategory'])) {$kategory = $_POST['kategory']; if ($kategory == '') {unset ($kategory);}}
if (isset($_POST['brend'])) {$brend = $_POST['brend']; if ($brend == '') {unset ($brend);}}
if (isset($_POST['nomer_mod'])) {$nomer_mod = $_POST['nomer_mod'];if ($nomer_mod == '') {unset ($nomer_mod);}}
if (isset($_POST['cena'])) {$cena = $_POST['cena']; if ($cena == '') {unset ($cena);}}
if (isset($_POST['voznag'])) {$voznag = $_POST['voznag']; if ($voznag == '') {unset ($voznag);}}
if (isset($_POST['procent'])) {$procent = $_POST['procent']; if ($procent == '') {unset($procent);}}
if (isset($_POST['skidka'])) {$skidka = $_POST['skidka']; if ($skidka == '') {unset($skidka);}}
if (isset($_POST['user'])) {$user = $_POST['user'];if ($user == '') {unset($user);}}
if (isset($_POST['user_id'])) {$user_id = $_POST['user_id'];if ($user_id == '') {unset($user_id);}}
	  
if (isset($_POST['ID_sklada'])) {$ID_sklada = $_POST['ID_sklada'];if ($ID_sklada == '') {unset($ID_sklada);}}
if (isset($_POST['Kol_na_sklade'])) {$Kol_na_sklade = $_POST['Kol_na_sklade'];if ($Kol_na_sklade == '') {unset($Kol_na_sklade);}}
if (isset($_POST['Add_sklad'])) {$Add_sklad = $_POST['Add_sklad'];if ($Add_sklad == '') {unset($Add_sklad);}}
if (isset($_POST['Kassa'])) {$Kassa = $_POST['Kassa'];if ($Kassa == '') {unset($Kassa);}}
if (isset($_POST['Zarplata'])) {$Zarplata = $_POST['Zarplata'];if ($Zarplata == '') {unset($Zarplata);}}

if (isset($_POST['debet_from'])) {$debet_from = $_POST['debet_from'];if ($debet_from == '') {unset($debet_from);}}		
if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset($kolichestvo);}}

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));

if ((isset($ID_sklada)) && (isset($Kol_na_sklade))) {
$summa_sklad = $Kol_na_sklade+$kolichestvo;
$res_sklad=mysql_query("UPDATE `sklad_tovaru` SET `kol_posl_prihoda` = '+$kolichestvo', `data_posl_prihoda` = '$dat $vremya', `kolichestvo` = '$summa_sklad' WHERE `ID` = '$ID_sklada' ",$db);

$res_arch_sklad=mysql_query("INSERT INTO `prihodu` SET `data` = '$dat $vremya', `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '$nomer_mod', `kol_prihoda` = '+$kolichestvo', `primech` = 'Отмена продажи', `user` = '{$_SESSION['login']}', `sec_data` = '$sec_dat'",$db);
} else {
	if ((isset($Add_sklad)) && ($Add_sklad == 'true')) {
$res_sklad=mysql_query("INSERT INTO `sklad_tovaru` SET `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '$nomer_mod', `kol_posl_prihoda` = '+$kolichestvo', `data_posl_prihoda` = '$dat $vremya', `kolichestvo` = '$kolichestvo'",$db);

$res_arch_sklad=mysql_query("INSERT INTO `prihodu` SET `data` = '$dat $vremya', `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '$nomer_mod', `kol_prihoda` = '+$kolichestvo', `primech` = 'Отмена продажи', `user` = '{$_SESSION['login']}', sec_data = '$sec_dat'",$db);	
		}	
	}
	
if (isset($Zarplata)) {

$res_max_zap = mysql_query("SELECT `k_oplate` FROM `zarplata` WHERE `ID_usera` = '$user_id' ORDER BY `ID` DESC LIMIT 1");
$myr_max_zap = mysql_fetch_array($res_max_zap);	
$max_zap = $myr_max_zap['k_oplate'] - $Zarplata;	
		
$res_zar = mysql_query("INSERT INTO `zarplata` SET `ID_magazina` = '$magazine', `ID_usera` = '$user_id', `data` = '$dat', `vremya` = '$vremya', `polniy_den` = '----', `polov_dnya` = '----', `prodaja` = '----', `procent` = '----', `k_oplate` = '$max_zap', `vudano` = '0', `shtraf` = '$Zarplata', `bonus` = '0', `user` = '{$_SESSION['login']}: Отмена продажи'",$db);
}

if (isset($Kassa) && isset($debet_from)) {

if ($debet_from == 'kassa') {

$res_vkasse = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '$magazine_name' ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_vkasse = mysql_fetch_array($res_vkasse);
$summa_vkasse = $myr_vkasse['vkasse'] - $Kassa;

$res_kassa = mysql_query("INSERT INTO `kassa` SET `ID_prodaja` = '0', `data` = '$dat $vremya', `magazine` = '$magazine_name', `vkasse` = '$summa_vkasse', `inkas` = '$Kassa', `user` = '{$_SESSION['login']}: Отмена продажи'",$db);}

elseif ($debet_from == 'schet') {

$res_naschetu = mysql_query("SELECT `summa` FROM `beznal` ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_naschetu = mysql_fetch_array($res_naschetu);
$summa_naschetu = $myr_naschetu['summa'] - $Kassa;

$res_naschetu = mysql_query("INSERT INTO `beznal` SET `ID_scheta` = '1', `ID_prodaja` = '0', `data` = '$dat $vremya', `magazine` = '$magazine_name', `summa` = '$summa_naschetu', `izmenenie` = '-$Kassa', `user` = '{$_SESSION['login']}: Отмена продажи'",$db);}

}

//$res = mysql_query("DELETE FROM prodaja WHERE ID='$id'",$db); unset ($_POST['delete']);

$data = $sdata.'_rollback';
$res=mysql_query("UPDATE `prodaja` SET `add` = 'Отмена прадажи!', `sec_data` = '$data' WHERE `ID`='$id_roll'",$db);	

header("Location: ../prodaja.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>