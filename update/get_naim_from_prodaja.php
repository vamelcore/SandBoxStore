<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $bren = $_REQUEST['bren'];

if (($mag <> '') && ($kat <> '') && ($bren <> '')) {
$result = mysql_query("SELECT DISTINCT `nomer_mod` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE ID = '$mag' ) AND `kategoria` = '$kat' AND `brend` = '$bren' AND `sec_data` NOT LIKE '%_rollback' ORDER BY `nomer_mod`",$db);

if (mysql_num_rows($result) > 0) {
  printf("<option value=''>Выберите номер модели</option>");	
  while ($myrow = mysql_fetch_array($result)){
  printf ("<option value='%s'>%s</option>" , $myrow["nomer_mod"], $myrow["nomer_mod"]);
	}
}
}
}
?>