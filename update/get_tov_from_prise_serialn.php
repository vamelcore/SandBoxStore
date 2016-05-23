<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat=$_REQUEST['kateg'];

if ($kat == 'all') {
printf("<option value=''>Выберите товар</option>");
printf("<option value=''>Все</option>");	
}
else {
$result = mysql_query("SELECT `ID`,`tovar` FROM `prase` WHERE `ID_kategorii` = '$kat' ORDER BY `tovar`",$db);
$myrow = mysql_fetch_array($result);
printf("<option value=''>Выберите товар</option>");
 do {	
     printf ("<option value='%s'>%s</option>" , $myrow['ID'], $myrow['tovar']);
    }
 while ($myrow = mysql_fetch_array($result));}
}
?>