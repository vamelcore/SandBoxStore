<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat=$_REQUEST['kat']; $tov = $_REQUEST['tov'];

$result_sn = mysql_query("SELECT `ID`, `serial_number` FROM serialnum WHERE ID_ketegorii = '$kat' AND ID_tovara = '$tov'",$db);
$myrow_sn = mysql_fetch_array($result_sn);
if (mysql_num_rows($result_sn) > 0){
printf("<option value=''>Выберите серийный номер</option>");
 do {
     printf ("<option value='%s'>%s</option>" , $myrow_sn["ID"], $myrow_sn["serial_number"]);
    }
 while ($myrow_sn = mysql_fetch_array($result_sn));}
else {printf ("<option value=''>Нет</option>");}
}
?>