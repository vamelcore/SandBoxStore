<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $bren = $_REQUEST['bren']; $mod = $_REQUEST['mod'];

if (($mag <> '') && ($kat <> '') && ($bren <> '') && ($mod <> '')) {
$result = mysql_query("SELECT DISTINCT `razmer` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE ID = '$mag' ) AND `kategoria` = '$kat' AND `brend` = '$bren' AND `nomer_mod` = '$mod' AND `sec_data` NOT LIKE '%_rollback' ORDER BY `razmer`",$db);

if (mysql_num_rows($result) > 0) {
  printf("<option value=''>Выберите размер</option>");	
  while ($myrow = mysql_fetch_array($result)){
  printf ("<option value='%s'>%s</option>" , $myrow["razmer"], $myrow["razmer"]);
	}
}
}
}
?>
