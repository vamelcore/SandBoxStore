<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
$hours = date('H') + $_SESSION['time_zone'];
$data = date ('d.m.Y H:i:s',mktime ($hours));
$sec_data = date ('m.Y',mktime ($hours));	
if (isset($_SESSION['id_tovara'])) {

if ($_SESSION['ed_priv_ost'] == 1) {		
	$id = $_SESSION['id_tovara'];
	unset ($_SESSION['id_tovara']);
    if ($id == '') {unset ($id);}
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM sklad_tovaru WHERE ID='$id'",$db); unset ($_POST['delete']);}

else {

$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

      if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset ($magazine);}}
      if (isset($_POST['sklad_kat'])) {$kategory = $_POST['sklad_kat'];if ($kategory == '') {unset ($kategory);}}
      if (isset($_POST['sklad_br'])) {$brend = $_POST['sklad_br'];if ($brend == '') {unset ($brend);}}
      if (isset($_POST['tovar'])) {$tovar = $_POST['tovar'];if ($tovar == '') {unset ($tovar);}}    
      if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset ($kolichestvo);} else {if (!is_numeric($kolichestvo)) {$kolichestvo = 0;}}}

//$res_sklad_arch = mysql_query("SELECT `ID` FROM `prase` WHERE `ID_kategorii` = '$kategory' AND `ID_brenda` = '$brend' AND `nomer_mod` = '$tovar' AND `razmer` = '$razmer' AND `cvet` = '$cvet' AND `material` = '$mater'",$db);
//$myr_sklad_arch = mysql_fetch_array($res_sklad_arch);
//$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID_magazina` = '$magazine' AND `ID_kategorii` = '$kategory' AND `ID_brenda` = '$brend' AND `ID_tovara` = '$tovar'",$db);

//if (mysql_num_rows($result) == 0) {
$kol_posl_prihoda='+'.$kolichestvo;	
$res=mysql_query("UPDATE `sklad_tovaru` SET `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '$tovar', `kol_posl_prihoda` = '$kol_posl_prihoda', `data_posl_prihoda` = '$data', `kolichestvo` = '$kolichestvo' WHERE `ID`='$id'",$db);		
//	}
//else {
//$myrow = mysql_fetch_array($result);
//$edit_kolich = $myrow['kolichestvo'] + $kolichestvo;
//$kol_posl_prihoda='+'.$kolichestvo;
//	$res=mysql_query("UPDATE `sklad_tovaru` SET `kol_posl_prihoda` = '$kol_posl_prihoda', `data_posl_prihoda` = '$data', `kolichestvo` = '$edit_kolich' WHERE `ID`='{$myrow['ID']}'",$db);
//	$res_last=mysql_query("DELETE FROM `sklad_tovaru` WHERE ID='$id'",$db);
//	}

 //Добавление записи в архив
$res_arch=mysql_query("INSERT INTO `prihodu` SET `data` = '$data', `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '$tovar', `kol_prihoda` = '$kolichestvo', `primech` = 'Редактирование записи, утсановка значения', `user` = '{$_SESSION['login']}', `sec_data` = '$sec_data'",$db);     	
}
} 
}
else {

if ($_SESSION['add_priv_ost'] == 1) {
	
$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);	
		
     if (isset($_POST['magazine'])) {$magazine = $_POST['magazine']; if ($magazine == '') {unset ($magazine);}}
     if (isset($_POST['sklad_kat'])) {$kategory = $_POST['sklad_kat']; $_SESSION['sklad_add_kat'] = $_POST['sklad_kat']; if ($kategory == '') {unset ($kategory); unset($_SESSION['sklad_add_kat']);}}
     if (isset($_POST['sklad_br'])) {$brend = $_POST['sklad_br']; $_SESSION['sklad_add_br'] = $_POST['sklad_br']; if ($brend == '') {unset ($brend); unset($_SESSION['sklad_add_br']);}}
     
if (isset($_POST['tovar'])) {$tovar = $_POST['tovar']; $_SESSION['sklad_add_mod'] = $_POST['tovar']; if ($tovar == '') {unset ($tovar); unset($_SESSION['sklad_add_mod']);}}
if (isset($_POST['razmer'])) {$razmer = $_POST['razmer']; $_SESSION['sklad_add_razmer'] = $_POST['razmer']; if ($razmer == '') {unset ($razmer); unset($_SESSION['sklad_add_razmer']);}}
if (isset($_POST['cvet'])) {$cvet = $_POST['cvet']; $_SESSION['sklad_add_cvet'] = $_POST['cvet']; if ($cvet == '') {unset ($cvet); unset($_SESSION['sklad_add_cvet']);}}
if (isset($_POST['mater'])) {$mater = $_POST['mater']; $_SESSION['sklad_add_mater'] = $_POST['mater']; if ($mater == '') {unset ($mater); unset($_SESSION['sklad_add_mater']);}}     
         
     if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset ($kolichestvo);} else {if (!is_numeric($kolichestvo)) {$kolichestvo = 0;}}}

$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID_magazina` = '$magazine' AND `ID_kategorii` = '$kategory' AND `ID_brenda` = '$brend' AND `ID_tovara` IN ( SELECT `ID` FROM `prase` WHERE `ID_kategorii` = '$kategory' AND `ID_brenda` = '$brend' AND `nomer_mod` = '$tovar' AND `razmer` = '$razmer' AND `cvet` = '$cvet' AND `material` = '$mater' )",$db);

if (mysql_num_rows($result) == 0) {
	
$res_sklad_arch = mysql_query("SELECT `ID` FROM `prase` WHERE `ID_kategorii` = '$kategory' AND `ID_brenda` = '$brend' AND `nomer_mod` = '$tovar' AND `razmer` = '$razmer' AND `cvet` = '$cvet' AND `material` = '$mater'",$db);
$myr_sklad_arch = mysql_fetch_array($res_sklad_arch);	

$kol_posl_prihoda='+'.$kolichestvo;	
$res=mysql_query("INSERT INTO `sklad_tovaru` SET `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '{$myr_sklad_arch['ID']}', kol_posl_prihoda = '$kol_posl_prihoda', data_posl_prihoda = '$data', kolichestvo = '$kolichestvo'",$db);	
//Добавление записи в архив
$res_arch=mysql_query("INSERT INTO `prihodu` SET `data` = '$data', `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '{$myr_sklad_arch['ID']}', `kol_prihoda` = '$kolichestvo', `primech` = 'Добавление записи о товаре в остатки', `user` = '{$_SESSION['login']}', `sec_data` = '$sec_data'",$db);
}
else { ?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">Вы пытаетесь добавить товар, который уже присутствует на остатках в этом магазине. <a href="./add_sklad.php">На страницу добавления</a> || <a href="../sklad.php">На страницу товаров</a>.</p>
</body>
</html>


<?php 
die();
}
}
}
header("Location: ../sklad.php");	
}
else {

header("Location: ../index.php");
die();
}
 ?>