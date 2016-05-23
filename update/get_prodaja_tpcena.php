<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $tarpl=$_REQUEST['tarpl'];

$result_tpc = mysql_query("SELECT `stoim_podkl` FROM tarifplan WHERE ID = '$tarpl'",$db);
$myrow_tpc = mysql_fetch_assoc($result_tpc);

printf("<input type=\"text\" value=\"%s\" readonly=\"true\" name=\"oplata_tp_podkl\">", $myrow_tpc['stoim_podkl']);


}
?>