<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_POST=defender_xss($_POST);
$_POST=defender_sql($_POST);

      if (isset($_POST['term']) && is_numeric($_POST['term'])) {$term = $_POST['term'];if ($term == '') {unset($term);}}
      if (isset($_POST['acses']) && is_numeric($_POST['acses'])) {$acses = $_POST['acses'];if ($acses == '') {unset($acses);}}
      if (isset($_POST['ustan']) && is_numeric($_POST['ustan'])) {$ustan = $_POST['ustan'];if ($ustan == '') {unset($ustan);}}
	  if (isset($_POST['podkl']) && is_numeric($_POST['podkl'])) {$podkl = $_POST['podkl'];if ($podkl == '') {unset($podkl);}}
	  if (isset($_POST['starpak']) && is_numeric($_POST['starpak'])) {$starpak = $_POST['starpak'];if ($starpak == '') {unset($starpak);}}
	  if (isset($_POST['bonus']) && is_numeric($_POST['bonus'])) {$bonus = $_POST['bonus'];if ($bonus == '') {unset($bonus);}}
	

$result = mysql_query("UPDATE plan SET plane = $term WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' AND name = 'term'",$db);
$result = mysql_query("UPDATE plan SET plane = $acses WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' AND name = 'acses'",$db);
$result = mysql_query("UPDATE plan SET plane = $ustan WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' AND name = 'ustan'",$db);
$result = mysql_query("UPDATE plan SET plane = $podkl WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' AND name = 'podkl'",$db);
$result = mysql_query("UPDATE plan SET plane = $starpak WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' AND name = 'starpak'",$db);
$result = mysql_query("UPDATE plan SET plane = $bonus WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' AND name = 'bonus'",$db);

header("Location: ../plan.php");	
//echo '<meta http-equiv="refresh" content="0; url=http://multiservice.org.ua/prodaja.php">';
}
else {

header("Location: ../index.php");
die();
}
 ?>