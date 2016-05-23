<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $mag = $_REQUEST['mag'];
	  
if ($mag <> '') {
$result_kat = mysql_query("SELECT `ID`,`kateg` FROM `sklad_kategorii` WHERE `ID` IN ( SELECT DISTINCT `ID_kategorii` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' ) ORDER BY `kateg`",$db);	

printf("<option value=''>Выберите категорию</option>");
while ($myrow_kat = mysql_fetch_array($result_kat)) {
	
	 printf ("<option value='%s'>%s</option>" , $myrow_kat["ID"], $myrow_kat["kateg"]);
	
	}
}
}
?>