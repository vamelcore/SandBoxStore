<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	
$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $bren = $_REQUEST['bren']; $mod = $_REQUEST['mod']; $pokup = $_REQUEST['pokup'];

if (($mag <> '') && ($kat <> '') && ($bren <> '') && ($mod <> '') && ($pokup <> '')) {
$result = mysql_query("SELECT `cena`, `user`, `voznag`, `procent`, `ID` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE ID = '$mag' ) AND `kategoria` = '$kat' AND `brend` = '$bren' AND `nomer_mod` = '$mod' AND `data` = '$pokup'",$db);	

$myrow = mysql_fetch_array($result); 	

printf("<input type=\"text\" name=\"cena\" id=\"cena_kol\" readonly=\"true\" value=\"%s\"><input type=\"hidden\" name=\"user\" value=\"%s\"><input type=\"hidden\" name=\"voznag\" value=\"%s\"><input type=\"hidden\" name=\"procent\" value=\"%s\"><input type=\"hidden\" name=\"ID_prodaja\" value=\"%s\">",$myrow['cena'], $myrow['user'], $myrow['voznag'], $myrow['procent'], $myrow['ID']);	
	}
}
?>