<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

if (isset($_GET['id'])) { $_GET=defender_sql($_GET); $id = $_GET['id']; if ($id == '') {unset ($id);}}
	
if (isset($id)) {
	$result = mysql_query("SELECT * FROM prase WHERE `ID_kategorii` = '$id'",$db);	
	if (mysql_num_rows($result) > 0) {?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница</title>
<link rel="stylesheet" href="../style.css" />
</head>
<body>
<p align="center">Есть товары, которые привязаны к этой категории. <a href="../prase.php">Товары</a> || <a href="../kategorii.php">Назад</a></p>
</body>
</html>			
			
<?php		die();}	
		
	else {$res = mysql_query("DELETE FROM sklad_kategorii WHERE ID='$id'",$db);}
}

else {

if (isset($_POST['kategory'])) {$_POST=defender_xss_min($_POST); $_POST=apostroff_repl($_POST); $_POST=defender_sql($_POST); $kategory = $_POST['kategory']; if ($kategory == '') {unset ($kategory);}} 
$res=mysql_query("INSERT INTO sklad_kategorii SET kateg = '$kategory'",$db);	
}



header("Location: ../kategorii.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>