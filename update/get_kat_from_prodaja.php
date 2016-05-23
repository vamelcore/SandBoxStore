<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	 
$mag = $_REQUEST['mag'];

if ($mag <> '') {
$result = mysql_query("SELECT DISTINCT `kategoria` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE `ID` = '$mag' ) AND `sec_data` NOT LIKE '%_rollback' ORDER BY `kategoria`",$db);
 			
if (mysql_num_rows($result) > 0){
  printf("<option value=''>Выберите категорию</option>");
  while ($myrow = mysql_fetch_array($result)){
  printf ("<option value='%s'>%s</option>" , $myrow["kategoria"], $myrow["kategoria"]);
	}		
}
}
}
?>