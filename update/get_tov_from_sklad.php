<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	  $kat=$_REQUEST['kat']; $mag = $_REQUEST['mag']; $bren = $_REQUEST['bren'];

if (($kat <> '') && ($mag <> '') && ($bren <> '')) {
$result_tov = mysql_query("SELECT `ID`,`nomer_mod`, `razmer`, `cvet`, `material`, `cena`, `voznag` FROM `prase` WHERE `ID` IN ( SELECT `ID_tovara` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` = '$kat' AND `ID_brenda` = '$bren' ) ORDER BY `nomer_mod`",$db);


$myarray_tovar = array(); $index_tov = 0;	
while ($myr_tov = mysql_fetch_array($result_tov)) {
foreach($myr_tov as $key => $value) {
$myarray_tovar[$key][$index_tov] = $value;
}	
$index_tov++;
}
session_start();	
$_SESSION['myarray_tovar'] = $myarray_tovar;
$_SESSION['myarray_tovar_ind'] = $index_tov;

$result_tov = mysql_query("SELECT DISTINCT `nomer_mod` FROM `prase` WHERE `ID` IN ( SELECT `ID_tovara` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` = '$kat' AND `ID_brenda` = '$bren' ) ORDER BY `nomer_mod`",$db);

printf("<option value=''>Выберите номер модели</option>");
while ($myrow_tov = mysql_fetch_array($result_tov)) {
	
	 printf ("<option value='%s'>%s</option>" , $myrow_tov["nomer_mod"], $myrow_tov["nomer_mod"]);
	
	}
}
}
?>