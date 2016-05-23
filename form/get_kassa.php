<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	                        $mag=$_REQUEST['mag'];
	  
$result = mysql_query("SELECT `vkasse` FROM `kassa` WHERE `magazine` = '$mag' ORDER BY `ID` DESC LIMIT 1",$db);

if (mysql_num_rows($result) > 0) {
	$myrow = mysql_fetch_array($result);
	printf("<th align = 'right'>Сумма в кассе: </th><td align = 'center'><strong>%s грн.</strong><input type = 'hidden' name = 'vkasse_mag' value = '%s'></td>", $myrow['vkasse'], $myrow['vkasse']);
}else {
	printf("<th></th><td><br></td>");
}

}
?>