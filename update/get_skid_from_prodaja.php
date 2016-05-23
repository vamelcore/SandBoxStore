<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

$mag = $_REQUEST['mag']; $kat = $_REQUEST['kat']; $bren = $_REQUEST['bren']; $mod = $_REQUEST['mod']; $pokup = $_REQUEST['pokup'];

if (($mag <> '') && ($kat <> '') && ($bren <> '') && ($mod <> '') && ($pokup <> '')) {
$result = mysql_query("SELECT `kolichestvo`, `summa`, `skidka` FROM `prodaja` WHERE `magazin` IN ( SELECT `name` FROM `magazinu` WHERE ID = '$mag' ) AND `kategoria` = '$kat' AND `brend` = '$bren' AND `nomer_mod` = '$mod' AND `data` = '$pokup'",$db);

$myrow = mysql_fetch_array($result);  			
$singl_skid = $myrow['skidka']/$myrow['kolichestvo'];
printf("<input type=\"text\" name=\"skidka\" id=\"skidka_kol\" readonly=\"true\" value=\"%s\"><input type=\"hidden\" name=\"kolich_all\" id=\"kolichestvo\" value=\"%s\"><input type=\"hidden\" name=\"summa_all\" id=\"summa_all\" value=\"%s\"><input type=\"hidden\" name=\"skidka_all\" id=\"skidka_all\" value=\"%s\">",$singl_skid, $myrow['kolichestvo'],$myrow['summa'],$myrow['skidka']);
 }
}
?>