<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat = $_REQUEST['kat']; $mag = $_REQUEST['mag']; $bren = $_REQUEST['bren']; $tov = $_REQUEST['tovar'];

$res_kol = mysql_query("SELECT `kolichestvo` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` = '$kat' AND `ID_brenda` = '$bren' AND `ID_tovara` = '$tov'",$db);

if (mysql_num_rows($res_kol) > 0) {
$myr_kol = mysql_fetch_array($res_kol);
if ($myr_kol['kolichestvo'] == '0') {printf("<select name=\"kolich\" disabled=\"disabled\"><option value=\"0\">0 шт.</option></select>");}
else {	  
printf("<select name=\"kolich\" id=\"index_kolich\">");
$i = 1;
while ($i <= $myr_kol['kolichestvo']) {
printf("<option value=\"%s\">%s шт.</option>",$i,$i);
$i++;
if ($i > 100) {break;}
}

printf("</select>");
}
}
}

?>
