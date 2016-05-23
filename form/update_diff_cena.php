<?php include ("../config.php"); include ("../update/functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_ost'] == 1)) { 

$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

if (isset($_POST['id_tov'])) {$id_tov = $_POST['id_tov']; if ($id_tov == '') {unset($id_tov);}}

$result_mag = mysql_query("SELECT `ID` FROM magazinu ORDER BY `ID` ASC",$db);

while ($myrow_mag = mysql_fetch_array($result_mag)) {

$name_cena = 'new_cena_'.$myrow_mag['ID'];
if (isset($_POST[$name_cena])) {$new_cena = $_POST[$name_cena]; if ($new_cena == '') {unset($new_cena);}}
$name_bonus = 'new_bonus_'.$myrow_mag['ID'];
if (isset($_POST[$name_bonus])) {$new_bonus = $_POST[$name_bonus]; if ($new_bonus == '') {unset($new_bonus);}}
$name_delete = 'delete_diff_'.$myrow_mag['ID'];
if (isset($_POST[$name_delete])) {$delete_diff = $_POST[$name_delete]; if ($delete_diff == '') {unset($delete_diff);}} else {unset($delete_diff);}
$name_id_diff = 'id_diff_c_'.$myrow_mag['ID'];
if (isset($_POST[$name_id_diff])) {$id_diff = $_POST[$name_id_diff]; if ($id_diff == '') {unset($id_diff);}}

if (($id_diff == '0') && (isset($new_cena) || isset($new_bonus))) {$res = mysql_query("INSERT INTO `diff_cena` SET `ID_magazina` = '{$myrow_mag['ID']}', `ID_tovara` = '$id_tov', `new_cena` = '$new_cena', `new_bonus` = '$new_bonus'",$db);}
elseif (isset($delete_diff)) {$res = mysql_query("DELETE FROM `diff_cena` WHERE `ID` = '$id_diff'",$db);}
elseif (isset($new_cena) || isset($new_bonus)) {$res = mysql_query("UPDATE `diff_cena` SET `ID_magazina` = '{$myrow_mag['ID']}', `ID_tovara` = '$id_tov', `new_cena` = '$new_cena', `new_bonus` = '$new_bonus' WHERE `ID` = '$id_diff'",$db);}
else {$res = mysql_query("DELETE FROM `diff_cena` WHERE `ID` = '$id_diff'",$db);}
}

//print_r($_POST);
header("Location: ../prase.php");
} else {header("Location: ../prase.php");}
?>
