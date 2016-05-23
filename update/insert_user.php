<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {
	
if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}

//Проверка масивов переменных.	
$_POST=defender_xss_min($_POST);
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);
	
if (isset($_POST['ID'])) {$user_id = $_POST['ID']; if ($user_id == '') {unset ($user_id);}}
if (isset($_POST['login'])) {$login = $_POST['login']; if ($login == '') {unset ($login);}}
if (isset($_POST['password'])) {$password = $_POST['password']; if ($password == '') {unset ($password);}}
if (isset($_POST['fio_usera'])) {$fio_usera = $_POST['fio_usera']; if ($fio_usera == '') {unset ($fio_usera);}}
if (isset($_POST['stavka'])) {$stavka = $_POST['stavka']; if ($stavka == '') {$stavka = '0';}}
if (isset($_POST['bonus_stavka'])) {$bonus_stavka = $_POST['bonus_stavka']; if ($bonus_stavka == '') {$bonus_stavka = '0';}}
if (isset($_POST['proc_stavka'])) {$proc_stavka = $_POST['proc_stavka']; if ($proc_stavka == '') {$proc_stavka = '0';}}

if (isset($_POST['add_user'])) {
	$pass = md5($_POST['password']);
	$res_test_user = mysql_query("SELECT * FROM `users` WHERE `ID` = '$user_id'",$db);
 
	$res_user = mysql_query("INSERT INTO `users` SET `ID` = '$user_id', `login` = '$login', `password` = '$pass', `AED` = '00000000', `storepriv` = '0', `allpriv` = '0', `kassapriv` = '0', `rollpriv` = '0', `adminpriv` = '0', `rootpriv` = '0', `fio_usera` = '$fio_usera', `stavka` = '$stavka', `bonus_stavka` = '$bonus_stavka', `proc_stavka` = '$proc_stavka'",$db);
} else {
if (isset($user_id) && isset($_POST['edit_user'])) {
	
	$res_user = mysql_query("UPDATE `users` SET `login` = '$login', `fio_usera` = '$fio_usera', `stavka` = '$stavka', `bonus_stavka` = '$bonus_stavka', `proc_stavka` = '$proc_stavka' WHERE `ID` ='$user_id'",$db);
	if (isset($password)) {
		$pass = md5($_POST['password']);	
		$res_user = mysql_query("UPDATE `users` SET `password` = '$pass' WHERE `ID` ='$user_id'",$db);
		}
}
else {
	if ((isset($id)) && ($id <> '1001')) {$res_user = mysql_query("DELETE FROM `users` WHERE `ID`='$id'",$db);
					 $res_zarp = mysql_query("DELETE FROM `zarplata` WHERE `ID_usera`='$id'",$db);}
}
}
header("Location: ../users.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>