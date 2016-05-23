<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $brend = $_REQUEST['brend']; $kolich = $_REQUEST['kolich'];
	  
if (($mag <> '') && ($kat <> '') && ($brend <> '')) {

$result = mysql_query("SELECT `ID`, `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID` IN ( SELECT `ID_tovara` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` IN ( SELECT `ID` FROM `sklad_kategorii` WHERE `kateg` = '$kat' ) AND `ID_brenda` = '$brend' AND `kolichestvo` >= '$kolich' ) ORDER BY `nomer_mod`",$db);

$myarray_tovar = array(); $index_tov = 0;	
while ($myrow = mysql_fetch_array($result)) {
foreach($myrow as $key => $value) {
$myarray_tovar[$key][$index_tov] = $value;
}	
$index_tov++;
}
session_start();	
$_SESSION['myarray_tovar'] = $myarray_tovar;
$_SESSION['myarray_tovar_ind'] = $index_tov;

$result = mysql_query("SELECT DISTINCT `nomer_mod` FROM `prase` WHERE `ID` IN ( SELECT `ID_tovara` FROM `sklad_tovaru` WHERE `ID_magazina` = '$mag' AND `ID_kategorii` IN ( SELECT `ID` FROM `sklad_kategorii` WHERE `kateg` = '$kat' ) AND `ID_brenda` = '$brend' AND `kolichestvo` >= '$kolich' ) ORDER BY `nomer_mod`",$db);
	
printf("<option value=''>Выберите номер модели</option>");
while ($myrow = mysql_fetch_array($result)) {	
	printf ("<option value='%s'>%s</option>" , $myrow["nomer_mod"], $myrow["nomer_mod"]);	
	} 	
	} 
}
?>