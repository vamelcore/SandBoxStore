<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $tarpl=$_REQUEST['tarpl'];

$result_tp = mysql_query("SELECT `voznagtp` FROM tarifplan WHERE ID = '$tarpl'",$db);
$myrow_tp = mysql_fetch_assoc($result_tp);

printf("<input type=\"text\" value=\"%s\" readonly=\"true\" name=\"voznag_za_tp\">", $myrow_tp['voznagtp']);


}
?>