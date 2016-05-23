<?php include ("config.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<title>test page</title>
</head>
<body>
<form method="post"><table><tr><td><select name="price_kat" id="pricekat" style="width:200px"><option value="">Все</option><?php 
$res_kat = mysql_query("SELECT `ID`, `kateg` FROM `sklad_kategorii` ORDER BY `kateg` ASC",$db);	
$myr_kat = mysql_fetch_array($res_kat);
if (isset($_POST['price_kat'])) {
do {
if ($myr_kat['ID'] == $_POST['price_kat']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);}	
}		
while ($myr_kat = mysql_fetch_array($res_kat));
}
else {
do {
printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
}		
while ($myr_kat = mysql_fetch_array($res_kat));	
}	
?></select></td><td><select name="price_br" id="pricebr" onchange="javascript:form.submit()" style="width:200px"><?php

if (isset($_POST['price_br'])) {
$res_tov = mysql_query("SELECT `ID`,`brend` FROM `sklad_brendu` WHERE `ID_kategorii` = '{$_POST['price_kat']}' ORDER BY `brend` ASC",$db);	
$myr_tov = mysql_fetch_array($res_tov);
do {

if ($myr_tov['ID'] == $_POST['price_br']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_tov['ID'],$myr_tov['brend']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_tov['ID'],$myr_tov['brend']);}	
}		
while ($myr_tov = mysql_fetch_array($res_tov));
}

?></select></td></tr></table></form>
<script type="text/javascript">
$(document).ready(function () {
         $("#pricekat").change(function(){		 		
         $("#pricebr").load("./update/get_brend_for_edit_tov.php", { kateg: $("#pricekat option:selected").val() });        
         });
});

$(document).ready(function () {
         $("#pricekat").change(function(){		 		
         if (document.getElementById("pricekat").value == '') {location.reload();}
         });
});
</script>
</body>
</html>