<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $kolich = $_REQUEST['kolich'];
	  
if (($mag <> '') && ($kat <> '')) {
	
$result = mysql_query("SELECT `ID`, `brend` FROM `sklad_brendu` WHERE `ID` IN ( SELECT DISTINCT `ID_brenda` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` IN ( SELECT `ID` FROM `sklad_kategorii` WHERE `kateg` = '$kat' ) AND `kolichestvo` >= '$kolich' ) ORDER BY `brend`",$db);
printf ("<option value=''>Выберите бренд</option>");
while ($myrow = mysql_fetch_array($result)) {	
	printf ("<option value='%s'>%s</option>" , $myrow["ID"], $myrow["brend"]);	
	}
	}	   
}
?>