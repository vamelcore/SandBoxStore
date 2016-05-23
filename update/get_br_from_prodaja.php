<?php include ("../config.php"); include ("functions.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat'];

if (($mag <> '') && ($kat <> '')) {
$result = mysql_query("SELECT DISTINCT `brend` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE `ID` = '$mag' ) AND `kategoria` = '$kat' AND `sec_data` NOT LIKE '%_rollback' ORDER BY `brend`",$db);

if (mysql_num_rows($result) > 0){
  printf("<option value=''>Выберите бренд</option>");
  while ($myrow = mysql_fetch_array($result)){
  printf ("<option value='%s'>%s</option>" , $myrow["brend"], $myrow["brend"]);
	}		
}
}  			
}
?>