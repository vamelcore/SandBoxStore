<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $tov=$_REQUEST['tov'];

$result_tov = mysql_query("SELECT `cena` FROM prase WHERE ID = '$tov'",$db);
$myrow_tov = mysql_fetch_assoc($result_tov);

printf("<input type=\"text\" value=\"%s\" readonly=\"true\" name=\"stoimost\">", $myrow_tov['cena']);


}
?>