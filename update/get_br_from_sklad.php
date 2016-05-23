<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat=$_REQUEST['kat']; $mag = $_REQUEST['mag'];

if (($kat <> '') && ($mag <> '')) {
$result_br = mysql_query("SELECT `ID`,`brend` FROM `sklad_brendu` WHERE `ID` IN ( SELECT DISTINCT `ID_brenda` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` = '$kat' ) ORDER BY `brend`",$db);	

printf("<option value=''>Выберите бренд</option>");
while ($myrow_br = mysql_fetch_array($result_br)) {
	
	 printf ("<option value='%s'>%s</option>" , $myrow_br["ID"], $myrow_br["brend"]);
	
	}
}
}
?>