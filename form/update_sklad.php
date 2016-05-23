<?php include ("../config.php"); include ("../update/functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_ost'] == 1)) { 

$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['skl_id'])) {$id = $_POST['skl_id']; if ($id == '') {unset($id);} }
if (isset($_POST['kolich'])) {$kolich = $_POST['kolich']; if (!is_numeric($kolich)) {$kolich = 0;}}
if (isset($_POST['add_kolich'])) {$add_kolich = $_POST['add_kolich']; if (!is_numeric($add_kolich)) {$add_kolich = 0;}}
if (isset($_POST['id_kat'])) {$id_kat = $_POST['id_kat']; if ($id_kat == '') {unset($id_kat);}}
if (isset($_POST['id_br'])) {$id_br = $_POST['id_br']; if ($id_br == '') {unset($id_br);}}
if (isset($_POST['id_tov'])) {$id_tov = $_POST['id_tov']; if ($id_tov == '') {unset($id_tov);}}

$summa = $kolich + $add_kolich;

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y H:i:s', mktime ($hours));
$sec_dat = date ('m.Y', mktime ($hours));

$result = mysql_query("UPDATE sklad_tovaru SET kol_posl_prihoda = '+$add_kolich', data_posl_prihoda = '$dat', kolichestvo = '$summa' WHERE ID = '$id'",$db);
// Добавление записи в архив
$res_arch=mysql_query("INSERT INTO `prihodu` SET `data` = '$dat', `ID_magazina` = '{$_SESSION['id_mag_selected']}', `ID_kategorii` = '$id_kat', `ID_brenda` = '$id_br', `ID_tovara` = '$id_tov', `kol_prihoda` = '+$add_kolich', `primech` = 'Добавление на склад', `user` = '{$_SESSION['login']}', `sec_data` = '$sec_dat'",$db);


header("Location: ../sklad.php");
} else {header("Location: ../sklad.php");} 
?>