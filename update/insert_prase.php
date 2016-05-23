<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['kateg'])) {$kateg = $_POST['kateg']; $_SESSION['selected_kat_tov'] = $_POST['kateg']; if ($kateg == '') {unset ($kateg); unset($_SESSION['selected_kat_tov']);}}
if (isset($_POST['brend'])) {$brend = $_POST['brend']; $_SESSION['selected_br_tov'] = $_POST['brend']; if ($brend == '') {unset ($brend); unset($_SESSION['selected_br_tov']);}}

if (isset($_POST['nomer_mod'])) {$nomer_mod = $_POST['nomer_mod']; if ($nomer_mod == '') {unset ($nomer_mod);}}
if (isset($_POST['razmer'])) {$razmer = $_POST['razmer']; if ($razmer == '') {unset ($razmer);}}
if (isset($_POST['cvet'])) {$cvet = $_POST['cvet']; if ($cvet == '') {unset ($cvet);}}
if (isset($_POST['material'])) {$material = $_POST['material']; if ($material == '') {unset ($material);}}
if (isset($_POST['cena'])) {$cena = $_POST['cena']; if ($cena == '') {$cena='----';}}
if (isset($_POST['voznag'])) {$voznag = $_POST['voznag']; if ($voznag == '') {$voznag='----';}}

	if (isset($id)) {
	$result = mysql_query("SELECT * FROM sklad_tovaru WHERE `ID_tovara` = '$id'",$db);	
	if (mysql_num_rows($result) > 0) {?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">На остатках есть запись о этом товаре. <a href="../sklad.php">Остатки</a> || <a href="../prase.php">Назад</a></p>
</body>
</html>			
			
<?php		die();}	
		
	else {$res = mysql_query("DELETE FROM `prase` WHERE `ID`='$id'",$db); $res_diff = mysql_query("DELETE FROM `diff_cena` WHERE `ID_tovara`='$id'",$db);}
}

else {
	
if (isset($_SESSION['id_prase'])) {	
$res=mysql_query("UPDATE `prase` SET `ID_kategorii` = '$kateg', `ID_brenda` = '$brend', `nomer_mod` = '$nomer_mod', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$material', cena = '$cena', voznag = '$voznag' WHERE ID = '{$_SESSION['id_prase']}'",$db); unset($_SESSION['id_prase']);	
} else {	
if (isset($_POST['add_tovar'])){	
$res=mysql_query("INSERT INTO prase SET `ID_kategorii` = '$kateg', `ID_brenda` = '$brend', `nomer_mod` = '$nomer_mod', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$material', cena = '$cena', voznag = '$voznag'",$db);}	
}

}

header("Location: ../prase.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>