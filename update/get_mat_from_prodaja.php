<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $bren = $_REQUEST['bren']; $mod = $_REQUEST['mod']; $raz = $_REQUEST['raz']; $cvet = $_REQUEST['cvet'];

if (($mag <> '') && ($kat <> '') && ($bren <> '') && ($mod <> '') && ($raz <> '') && ($cvet <> '')) {
$result = mysql_query("SELECT DISTINCT `material` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE ID = '$mag' ) AND `kategoria` = '$kat' AND `brend` = '$bren' AND `nomer_mod` = '$mod' AND `razmer` = '$raz' AND `cvet` = '$cvet' AND `sec_data` NOT LIKE '%_rollback' ORDER BY `material`",$db);

if (mysql_num_rows($result) > 0) {
  printf("<option value=''>Выберите материал</option>");	
  while ($myrow = mysql_fetch_array($result)){
  printf ("<option value='%s'>%s</option>" , $myrow["material"], $myrow["material"]);
	}
}
}
}
?>