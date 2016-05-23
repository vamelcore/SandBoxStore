<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $operator=$_REQUEST['operator'];

$result_tp = mysql_query("SELECT `ID`, `tarifplan` FROM `tarifplan` WHERE `ID_oper` = '$operator' ORDER BY `tarifplan`",$db);
$myrow_tp = mysql_fetch_array($result_tp);
print ("<option>Выберите ТП</option>");
do {
printf("<option value=\"%s\">%s</option>",$myrow_tp['ID'], $myrow_tp['tarifplan']);
}
while ($myrow_tp = mysql_fetch_array($result_tp));

}
?>