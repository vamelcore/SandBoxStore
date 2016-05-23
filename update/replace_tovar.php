<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
if (isset($_POST['id_replace_tov'])) {
$id = $_POST['id_replace_tov']; unset ($_POST['id_replace_tov']);
if ($id == '') {unset ($id);}

$_POST=defender_xss_min($_POST);    
$_POST=defender_sql($_POST);    
 
    
      if (isset($_POST['from_mag'])) {$from_mag = $_POST['from_mag']; if ($from_mag == '') {unset ($from_mag);}}
      if (isset($_POST['from_mag_name'])) {$from_mag_name = $_POST['from_mag_name']; if ($from_mag_name == '') {unset ($from_mag_name);}}
      if (isset($_POST['to_mag'])) {$to_mag = $_POST['to_mag']; if ($to_mag == '') {unset ($to_mag);}}
      if (isset($_POST['kategorya'])) {$kategorya = $_POST['kategorya'];if ($kategorya == '') {unset ($kategorya);}}
      if (isset($_POST['kategorya_name'])) {$kategorya_name = $_POST['kategorya_name'];if ($kategorya_name == '') {unset ($kategorya_name);}}
      if (isset($_POST['brend'])) {$brend = $_POST['brend'];if ($brend == '') {unset ($brend);}}
      if (isset($_POST['brend_name'])) {$brend_name = $_POST['brend_name'];if ($brend_name == '') {unset ($brend_name);}}
      if (isset($_POST['nomer_mod'])) {$nomer_mod = $_POST['nomer_mod'];if ($nomer_mod == '') {unset ($nomer_mod);}}
      if (isset($_POST['nomer_mod_name'])) {$nomer_mod_name = $_POST['nomer_mod_name'];if ($nomer_mod_name == '') {unset ($nomer_mod_name);}}

if (isset($_POST['razmer'])) {$razmer = $_POST['razmer'];if ($razmer == '') {unset ($razmer);}}
if (isset($_POST['cvet'])) {$cvet = $_POST['cvet'];if ($cvet == '') {unset ($cvet);}}
if (isset($_POST['material'])) {$material = $_POST['material'];if ($material == '') {unset ($material);}}

      if (isset($_POST['kolichestvo'])) {$kolichestvo = $_POST['kolichestvo'];if ($kolichestvo == '') {unset ($kolichestvo);}}



$hours = date('H') + $_SESSION['time_zone'];
$data = date ('d.m.Y H:i:s',mktime ($hours));
$sec_data = date ('m.Y',mktime ($hours));

$result_mag_to = mysql_query("SELECT `name` FROM magazinu WHERE ID = '$to_mag'",$db);
$myrow_mag_to = mysql_fetch_array($result_mag_to);


$res_per=mysql_query("INSERT INTO `peremeschenie` SET `data` = '$data', `kateg` = '$kategorya_name', `brend` = '$brend_name', `tovar` = '$nomer_mod_name', `razmer` = '$razmer', `cvet` = '$cvet', `material` = '$material', `kolichestvo` = '$kolichestvo', `peremescheno_otkuda` = '$from_mag_name', `peremescheno_kuda` = '{$myrow_mag_to['name']}'",$db);		


$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID_magazina` = '$to_mag'",$db);

unset($flag);
while($myrow = mysql_fetch_array($result)) { 
if (($myrow['ID_kategorii'] == $kategorya) && ($myrow['ID_brenda'] == $brend) && ($myrow['ID_tovara'] == $nomer_mod)) {$flag=$myrow['ID'];}
}


if (isset($flag)) {

$result_old = mysql_query("SELECT `kolichestvo` FROM `sklad_tovaru` WHERE `ID` = '$id'",$db);
$myrow_old = mysql_fetch_array($result_old); 
$myrow_old['kolichestvo'] = $myrow_old['kolichestvo'] - $kolichestvo;
$kol_pos_prihoda = '-'.$kolichestvo;
$result_old=mysql_query("UPDATE `sklad_tovaru` SET `kolichestvo` = '{$myrow_old['kolichestvo']}', `kol_posl_prihoda` = '$kol_pos_prihoda', `data_posl_prihoda` = '$data'  WHERE `ID` = '$id'",$db);

$result_new = mysql_query("SELECT `kolichestvo` FROM sklad_tovaru WHERE `ID` = '$flag'",$db);
$myrow_new = mysql_fetch_array($result_new); 
$myrow_new['kolichestvo'] = $myrow_new['kolichestvo'] + $kolichestvo;
$kol_pos_prihoda = '+'.$kolichestvo;
$result_new=mysql_query("UPDATE `sklad_tovaru` SET `kolichestvo` = '{$myrow_new['kolichestvo']}', `kol_posl_prihoda` = '$kol_pos_prihoda', `data_posl_prihoda` = '$data' WHERE `ID` = '$flag'",$db);

}
else {
$result_old = mysql_query("SELECT `kolichestvo` FROM `sklad_tovaru` WHERE `ID` = '$id'",$db);
$myrow_old = mysql_fetch_array($result_old); 
$myrow_old['kolichestvo'] = $myrow_old['kolichestvo'] - $kolichestvo;
$kol_pos_prihoda = '-'.$kolichestvo;
$result_old=mysql_query("UPDATE `sklad_tovaru` SET `kolichestvo` = '{$myrow_old['kolichestvo']}', `kol_posl_prihoda` = '$kol_pos_prihoda', `data_posl_prihoda` = '$data' WHERE `ID` = '$id'",$db);

$kol_pos_prihoda = '+'.$kolichestvo;	
$res=mysql_query("INSERT INTO `sklad_tovaru` SET `ID_magazina` = '$to_mag', `ID_kategorii` = '$kategorya', `ID_brenda` = '$brend', `ID_tovara` = '$nomer_mod', `kol_posl_prihoda` = '$kol_pos_prihoda', `data_posl_prihoda` = '$data', `kolichestvo` = '$kolichestvo'",$db);		
}
//Добавление записи в архив
$res_arch=mysql_query("INSERT INTO `prihodu` SET `data` = '$data', `ID_magazina` = '$from_mag', `ID_kategorii` = '$kategorya', `ID_brenda` = '$brend', `ID_tovara` = '$nomer_mod', `kol_prihoda` = '-$kolichestvo', `primech` = 'Перемещение товара из магазина', `user` = '{$_SESSION['login']}', `sec_data` = '$sec_data'",$db);	

$res_arch=mysql_query("INSERT INTO `prihodu` SET `data` = '$data', `ID_magazina` = '$to_mag', `ID_kategorii` = '$kategorya', `ID_brenda` = '$brend', `ID_tovara` = '$nomer_mod', `kol_prihoda` = '+$kolichestvo', `primech` = 'Перемещение товара в магазин', `user` = '{$_SESSION['login']}', `sec_data` = '$sec_data'",$db);

}

header("Location: ../sklad.php");	

}
else {

header("Location: ../index.php");
die();
}
 ?>