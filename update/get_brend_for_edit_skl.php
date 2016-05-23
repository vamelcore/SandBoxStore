<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat=$_REQUEST['kateg'];
if ($kat <> '') {
$result = mysql_query("SELECT `ID`,`brend` FROM `sklad_brendu` WHERE `ID_kategorii` = '$kat' ORDER BY `brend`",$db);
printf("<option value=''>Выберите бренд</option>");
 while ($myrow = mysql_fetch_array($result)) {	
     printf ("<option value='%s'>%s</option>" , $myrow['ID'], $myrow['brend']);
    }
   }
   else {
   	printf("<option value=''></option>"); 	
   	} 
 }
?>