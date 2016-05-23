<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $tarpl = $_REQUEST['tarpl']; $tov = $_REQUEST['tov'];

$result = mysql_query("SELECT * FROM akciya WHERE ID_tp = '$tarpl' AND ID_tov = '$tov'",$db);
if (mysql_num_rows($result) > 0) {
	printf ("<p>Акционное оборудование!</p><input type=\"hidden\" name=\"akciya\" value=\"true\" id=\"akciyaf\">");
} else {
	printf ("<input type=\"hidden\" name=\"akciya\" value=\"\" id=\"akciyaf\">");
}

}
?>