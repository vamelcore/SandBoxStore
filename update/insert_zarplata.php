<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

$_POST=defender_xss_full($_POST);
$_POST=defender_sql($_POST);	
		
	  if (isset($_POST['magazin'])) {$magazin = $_POST['magazin']; if ($magazin == '') {unset ($magazin);}}
     if (isset($_POST['prodav'])) {$prodav = $_POST['prodav'];if ($prodav == '') {unset ($prodav);}}
     if (isset($_POST['data'])) {$data = $_POST['data'];if ($data == '') {$data='----';}}
     if (isset($_POST['vremya'])) {$vremya = $_POST['vremya'];if ($vremya == '') {$vremya='----';}}
     if (isset($_POST['povnden'])) {$povnden = $_POST['povnden'];if ($povnden == '') {$povnden='----';}}
     if (isset($_POST['polden'])) {$polden = $_POST['polden'];if ($polden == '') {$polden='----';}}
	  if (isset($_POST['prodaja'])) {$prodaja = $_POST['prodaja'];if ($prodajao == '') {$prodaja='----';}}
	  if (isset($_POST['koplate'])) {$koplate = $_POST['koplate'];if ($koplate == '') {$koplate='----';}}
	  if (isset($_POST['vudano'])) {$vudano = $_POST['vudano'];if ($vudano == '') {$vudano='----';}}
	  if (isset($_POST['shtraf'])) {$shtraf = $_POST['shtraf'];if ($shtraf == '') {$shtraf='----';}}
	  if (isset($_POST['bonus'])) {$bonus = $_POST['bonus'];if ($bonus == '') {$bonus='----';}}

if (isset($_SESSION['id_zarplata'])) {

 if ($_SESSION['ed_priv_zar'] == 1) {
		
	$id = $_SESSION['id_zarplata'];
	unset ($_SESSION['id_zarplata']);
    if ($id == '') {unset ($id);}
    if (isset($_POST['delete'])) {$res = mysql_query("DELETE FROM zarplata WHERE ID='$id'",$db); unset ($_POST['delete']);}

     else {

$res=mysql_query("UPDATE zarplata SET ID_magazina = '$magazin', ID_usera = '$prodav', data = '$data', vremya = '$vremya', polniy_den = '$povnden', polov_dnya = '$polden', prodaja = '$prodaja', k_oplate = '$koplate', vudano = '$vudano', shtraf = '$shtraf', bonus = '$bonus' WHERE ID='$id'",$db);	
}
}
}
header("Location: ../zarplata.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>