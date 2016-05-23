<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);	
//Получение всех переменных.		
if (isset($_POST['data'])) {$data = $_POST['data']; if ($data == '') {unset ($data);}}

if (isset($_POST['magazine'])) {     		
      	$magazine = $_POST['magazine'];
      	if ($magazine == '') {unset ($magazine);}
      	else {
      		$res_mag=mysql_query("SELECT `name` FROM magazinu WHERE ID = '$magazine'",$db);
         $myr_mag=mysql_fetch_array($res_mag);

      		}
}
      
if (isset($_POST['kategory'])) {      		
      	$kategory = $_POST['kategory'];
      	if ($kategory == '') {unset ($kategory);}
      	else {
      		$res_kat=mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '$kategory'",$db);
         $myr_kat=mysql_fetch_array($res_kat);
 
      		}
}

if (isset($_POST['brend'])) {      		
      	$brend = $_POST['brend'];
      	if ($brend == '') {unset ($brend);}
      	else {
      		$res_br=mysql_query("SELECT `brend` FROM sklad_brendu WHERE ID = '$brend'",$db);
         $myr_br=mysql_fetch_array($res_br);
	
      		}
}

if (isset($_POST['tovar_id'])) {$tovar_id = $_POST['tovar_id']; if ($tovar_id == '') {unset($tovar_id);}}      
      
if (isset($_POST['nomer_mod'])) {$nomer_mod = $_POST['nomer_mod']; if ($nomer_mod == '') {unset ($nomer_mod);}}

if (isset($_POST['razmer'])) {$razmer = $_POST['razmer'];if ($razmer == '') {unset ($razmer);}}

if (isset($_POST['cvet'])) {$cvet = $_POST['cvet'];if ($cvet == '') {unset ($cvet);}}

if (isset($_POST['mater'])) {$mater = $_POST['mater'];if ($mater == '') {unset ($mater);}}
      
if (isset($_POST['cena'])) {$cena = $_POST['cena'];if ($cena == '') {unset($cena);}}

if (isset($_POST['voznag'])) {$voznag = $_POST['voznag'];if ($voznag == '') {unset($voznag);}}

if (isset($_POST['procent'])) {$procent = $_POST['procent'];if ($procent == '') {unset($procent);}}

if (isset($_POST['fio'])) {$fio = $_POST['fio'];if ($fio == '') {unset($fio);}}

if (isset($_POST['kontakt_nom_tel'])) {$kontakt_nom_tel = $_POST['kontakt_nom_tel'];if ($kontakt_nom_tel == '') {unset($kontakt_nom_tel);}}

if (isset($_POST['skidka'])) {$skidka = $_POST['skidka'];if ($skidka == '') {unset ($skidka);}}

if (isset($_POST['primech'])) {$primech = $_POST['primech'];if ($primech == '') {unset($primech);}}
	  
if (isset($_POST['user'])) {
	  	$user = $_POST['user'];
	  	if ($user == '') {unset($user);}
	  	else {
	  		$res_usr = mysql_query("SELECT `ID`, `login`, `bonus_stavka`, `proc_stavka` FROM `users` WHERE ID = '$user'",$db);
      $myr_usr = mysql_fetch_array($res_usr);
 
	  		} 
}

if (isset($_POST['prnt_id'])) {$printer_id = $_POST['prnt_id']; if ($printer_id == '') {unset($printer_id);}}

if (isset($_POST['sposob_oplatu'])) {$sposob_oplatu = $_POST['sposob_oplatu']; if ($sposob_oplatu == '') {unset($sposob_oplatu);}}

if (isset($_POST['kolich'])) {$kolich = $_POST['kolich']; if ($kolich == '') {unset($kolich);}}

		
if (isset($_SESSION['id_prodaja'])) {
	
  if ($_SESSION['ed_priv_pro'] == 1) {	
		
	$id = $_SESSION['id_prodaja'];
	unset ($_SESSION['id_prodaja']);
    if ($id == '') {unset ($id);}
//Удаление записи о продаже!!!
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM `prodaja` WHERE `ID`='$id'",$db); unset ($_POST['delete']);}

     else {
//Обновление записи о продаже.
      $res=mysql_query("UPDATE `prodaja` SET `data` = '$data', `magazin` = '{$myr_mag['name']}', `kategoria` = '{$myr_kat['kateg']}', `brend` = '{$myr_br['brend']}', `nomer_mod` = '$nomer_mod', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$mater', `cena` = '$cena', `voznag` = '$voznag', `procent` = '$procent', `kontakt_nomer_tel` = '$kontakt_nom_tel', `FIO` = '$fio', `skidka` = '$skidka', `add` = '$primech', `user` = '{$myr_usr['login']}' WHERE `ID`='$id'",$db);	
}
}
}
else {

if ($_SESSION['add_priv_pro'] == 1) {

if (isset($_SESSION['myarray_tovar'])) {unset($_SESSION['myarray_tovar']);}
if (isset($_SESSION['myarray_tovar_ind'])) {unset($_SESSION['myarray_tovar_ind']);}

if  ((isset($magazine)) && (isset($kategory)) && (isset($brend)) && (isset($nomer_mod))) {
//Получение информации о товаре на складе.
$res_sklad=mysql_query("SELECT `ID`, `kolichestvo` FROM `sklad_tovaru` WHERE `ID_magazina` = '$magazine' AND `ID_kategorii` = '$kategory' AND `ID_brenda` = '$brend' AND ID_tovara = '$tovar_id'",$db);
$myr_sklad=mysql_fetch_array($res_sklad);	
}

if ($myr_sklad['kolichestvo'] > 0) {

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));
//Определение зарплаты продавца
if ($myr_usr['bonus_stavka'] == 1) {$bonus_zp = $voznag*$kolich;} else {$bonus_zp = 0;}
$proc_zp = round((($cena - $skidka)*$kolich*($myr_usr['proc_stavka']/100)), 2);
$summa_cena = $cena*$kolich;
$summa_skidka = $skidka*$kolich;
//Если количество товара на складе не 0, добавляем запись о продаже в базу.		
$result=mysql_query("INSERT INTO `prodaja` SET `data` = '$data', `magazin` = '{$myr_mag['name']}', `kategoria` = '{$myr_kat['kateg']}', `brend` = '{$myr_br['brend']}', `nomer_mod` = '$nomer_mod', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$mater', `kolichestvo` = '$kolich', `cena` = '$cena', `summa` = '$summa_cena', `voznag` = '$bonus_zp', `procent` = '$proc_zp', `kontakt_nomer_tel` = '$kontakt_nom_tel', `FIO` = '$fio', `skidka` = '$summa_skidka', `add` = '$primech', `user` = '{$myr_usr['login']}', `printer_ID` = '$printer_id', `sec_data` = '$sec_dat'",$db);
//Получаем Идентификатор текущей продажы
$res_max_prodaja = mysql_query("SELECT MAX(ID) AS `ID` FROM `prodaja` WHERE `magazin` = '{$myr_mag['name']}'",$db);
$myr_max_prodaja = mysql_fetch_array($res_max_prodaja, MYSQL_ASSOC);
//Обновляем количество товара на складе
$myr_sklad['kolichestvo']=$myr_sklad['kolichestvo'] - $kolich;
$res_sklad=mysql_query("UPDATE `sklad_tovaru` SET `kol_posl_prihoda` = '-$kolich', `data_posl_prihoda` = '$data', `kolichestvo` = '{$myr_sklad['kolichestvo']}' WHERE `ID` = '{$myr_sklad['ID']}' ",$db);
//Добавление записи в архив склада
$osnatok_archiv='-'.$kolich.' ('.$myr_sklad['kolichestvo'].')';
$res_arch_sklad=mysql_query("INSERT INTO `prihodu` SET `data` = '$data', `ID_magazina` = '$magazine', `ID_kategorii` = '$kategory', `ID_brenda` = '$brend', `ID_tovara` = '$tovar_id', `kol_prihoda` = '$osnatok_archiv', `primech` = 'Продажа!', `user` = '{$myr_usr['login']}', `sec_data` = '$sec_dat'",$db);
//Обновляем состояние зарплаты для продавца
$res_max_zap = mysql_query("SELECT `k_oplate` FROM `zarplata` WHERE `ID_usera` = '$user' ORDER BY `ID` DESC LIMIT 1");
$myr_max_zap = mysql_fetch_array($res_max_zap);

$myr_max_zap['k_oplate'] = $myr_max_zap['k_oplate'] + $bonus_zp + $proc_zp;

$res_zar = mysql_query("INSERT INTO `zarplata` SET `ID_prodaja` = '{$myr_max_prodaja['ID']}', `ID_magazina` = '$magazine', `ID_usera` = '$user', `data` = '$dat', `vremya` = '$vremya', `polniy_den` = '----', `polov_dnya` = '----', `prodaja` = '$bonus_zp', `procent` = '$proc_zp', `k_oplate` = '{$myr_max_zap['k_oplate']}', `vudano` = '----', `shtraf` = '----', `bonus` = '----', `user` = '----'",$db);

//Обновляем состояние кассы магазина
if ($sposob_oplatu == 't') {
$res_summa = mysql_query("SELECT `summa` FROM `beznal` ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_summa = mysql_fetch_array($res_summa);
$summa_beznal = $myr_summa['summa'] + ($cena - $skidka)*$kolich;
$izm = ($cena - $skidka)*$kolich;
$res_beznal = mysql_query("INSERT INTO `beznal` SET `ID_scheta` = '1', `ID_prodaja` = '{$myr_max_prodaja['ID']}', `data` = '$dat $vremya', `magazine` = '{$myr_mag['name']}', `summa` = '$summa_beznal', `izmenenie` = '+$izm', `user` = '{$myr_usr['login']}: Продажа!'",$db);
}
else {
$res_vkasse = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '{$myr_mag['name']}' ORDER BY `ID` DESC LIMIT 1",$db);  
$myr_vkasse = mysql_fetch_array($res_vkasse);
$summa_vkasse = $myr_vkasse['vkasse'] + ($cena - $skidka)*$kolich;
$izm = ($cena - $skidka)*$kolich;
$res_kassa = mysql_query("INSERT INTO `kassa` SET `ID_prodaja` = '{$myr_max_prodaja['ID']}', `data` = '$dat $vremya', `magazine` = '{$myr_mag['name']}', `vkasse` = '$summa_vkasse', `inkas` = '+$izm', `user` = '{$myr_usr['login']}: Продажа!'",$db);
}


}	
else {?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">Этот товар нельзя продать, поскольку его нет в наличии. <a href="../sklad.php">На страницу остатков</a>.</p>
</body>
</html>	
	
<?php
die();
}
}
}
//Добавить еще
if (isset($_POST['save_add'])) {
	if (isset($printer_id)) {$last_result = mysql_query("UPDATE `prodaja` SET `printer_ID` = '$printer_id' WHERE `ID` = '{$myr_max_prodaja['ID']}'",$db);}
	else {$last_result = mysql_query("UPDATE `prodaja` SET `printer_ID` = '{$myr_max_prodaja['ID']}' WHERE `ID` = '{$myr_max_prodaja['ID']}'",$db); $printer_id = $myr_max_prodaja['ID'];}	
	header("Location: ./add_prodaja.php?prnt_id={$printer_id}");
	$_SESSION['kontakt_nom_tel'] = $kontakt_nom_tel;
	$_SESSION['pokupfio'] = $fio;
	$_SESSION['id_magaz'] = $magazine;
	$_SESSION['name_magaz'] = $myr_mag['name'];
	}
else {header("Location: ../prodaja.php");}	
 //echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>