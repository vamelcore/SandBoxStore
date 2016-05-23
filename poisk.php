<?php include ("config.php"); include ("update/functions.php");
header('Content-Type: text/html; charset=utf-8');
session_start();

if (isset($_POST['poisk'])) {

$_SESSION['poisk_view'] = $_POST['poisk'];

$_POST=defender_xss_full($_POST);	
$_POST=apostroff_repl($_POST);
$_POST=defender_sql($_POST);

$search = $_POST['poisk'];
 
	if ($search == '') {unset ($search); unset($_SESSION['poisk']); unset($_SESSION['poisk_view']); unset($_POST['poisk']);}
	else {$_SESSION['poisk'] = $search; unset($_POST['poisk']);}
}
if (isset($_POST['clear'])) {unset($_SESSION['poisk']); unset($_SESSION['poisk_view']);}

header("Location: praice.php");
?>