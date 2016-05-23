<?php include("config.php");

//$res = mysql_query("CREATE TEMPORARY TABLE tmptable SELECT ID, magazin, kategoria, kontakt_nomer_tel, FIO FROM prodaja WHERE ID = '108'",$db);

$test = mysql_query("SELECT ID FROM prodaja WHERE ID = '108'",$db);
$test = mysql_fetch_array($test);
echo ($test['ID']);
$magazin = 2;

$res = mysql_query("INSERT INTO `prodaja` ( `magazin`, `kategoria`, `kontakt_nomer_tel`, `FIO` ) SELECT '$magazin', `kategoria`, `kontakt_nomer_tel`, `FIO` FROM `prodaja` WHERE `ID` = '108'",$db);

?>
