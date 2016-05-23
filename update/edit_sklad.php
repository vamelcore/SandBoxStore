<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_ost'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_tovara'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);

$res_kateg = mysql_query("SELECT * FROM `sklad_kategorii` ORDER BY `kateg` ASC",$db);

$myarray_kateg = array(); $index_kat = 0;
while ($myr_kateg = mysql_fetch_assoc($res_kateg)) {
foreach($myr_kateg as $key => $value) {
$myarray_kateg[$key][$index_kat] = $value;
}
$index_kat++;
}	

$res_brend = mysql_query("SELECT * FROM `sklad_brendu` ORDER BY `brend` ASC",$db);

$myarray_brend = array(); $index_br = 0;
while ($myr_brend = mysql_fetch_assoc($res_brend)) {
foreach($myr_brend as $key => $value) {
$myarray_brend[$key][$index_br] = $value;
}
$index_br++;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы товаров</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<style type="text/css">
   SELECT {width: 210px;}
   INPUT {width: 200px;}
  </style>

</head>

<body onload='onLoad()'>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_sklad.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактировать товар на Остаткие</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Магазин:</p></td>
  	<td>
  		<select name="magazine">
  			
<?php
$result_mag = mysql_query("SELECT `ID`, `name` FROM magazinu",$db);
$myrow_mag = mysql_fetch_array($result_mag);

do { 

if ($myrow['ID_magazina'] == $myrow_mag['ID']) {printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_mag['ID'],$myrow_mag['name']);}
else {
printf("<option value=\"%s\">%s</option>",$myrow_mag['ID'],$myrow_mag['name']);}
}
while($myrow_mag = mysql_fetch_array($result_mag));

 ?>

			</select>
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Категория товара:</p></td>
  	<td>
  		
  	<select name="sklad_kat" id="skladkat" style="width:210px"><?php 

for ($no=0; $no<$index_kat; $no++) {
if ($myarray_kateg['ID'][$no] == $myrow['ID_kategorii']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
}

?></select>	
  		
  	</td>
  </tr>
  
<tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td>
  	<select name="sklad_br" id="skladbr" style="width:210px"><?php
for ($no=0; $no<$index_br; $no++) {
if ($myarray_brend['ID_kategorii'][$no] == $myrow['ID_kategorii']) {
if ($myarray_brend['ID'][$no] == $myrow['ID_brenda']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
}
}
?></select>  	
  	
  	</td>
    </tr>  
 
  <tr bgcolor="#dce6ee">
	<td><p>Ном. мод./разм./цвет/матер.:</p></td>
  	<td><select name="tovar" id="tov">
  		
<?php
$result_tov = mysql_query("SELECT `ID`, `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID_kategorii` ='{$myrow['ID_kategorii']}' AND `ID_brenda` = '{$myrow['ID_brenda']}' ORDER BY `nomer_mod` ASC , `razmer` ASC , `cvet` ASC , `material` ASC",$db);
$myrow_tov = mysql_fetch_array($result_tov);

do { 

if ($myrow['ID_tovara'] == $myrow_tov['ID']) {printf("<option value=\"%s\" selected=\"selected\">%s / %s / %s / %s</option>",$myrow_tov['ID'],$myrow_tov['nomer_mod'],$myrow_tov['razmer'],$myrow_tov['cvet'],$myrow_tov['material']);}
else {
printf("<option value=\"%s\">%s / %s / %s / %s</option>",$myrow_tov['ID'],$myrow_tov['nomer_mod'],$myrow_tov['razmer'],$myrow_tov['cvet'],$myrow_tov['material']);}
}
while($myrow_tov = mysql_fetch_array($result_tov));

 ?>
  		 		
  	</select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Количество:</p></td>
  	<td><input type="text" name="kolichestvo" value="<?php echo $myrow['kolichestvo'] ?>" id="kolich" onkeyup="onLoad();" onclick="onLoad();" onchange="onLoad();"></td>
    </tr>
 
 </table>
 <div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ></td>
  </tr>
 </table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
$(document).ready(function () {
         $("#skladkat").change(function(){		 		
         $("#skladbr").load("./get_brend_for_edit_skl.php", { kateg: $("#skladkat option:selected").val() },
function () {onLoad();} );        
         });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
         $("#skladbr").change(function(){		 		
         $("#tov").load("./get_tov.php", { kateg: $("#skladkat option:selected").val(), brend: $("#skladbr option:selected").val() }, function () {onLoad();} );
         
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function () {
         $("#tov").change(function(){
         	    onLoad();    	                            
         });
});

function onLoad(){
var getKategVal = document.getElementById('skladkat').value;	 		
var getBrendVal = document.getElementById('skladbr').value;        
var getTovarVal = document.getElementById('tov').value;
var getTovarKol = document.getElementById('kolich').value;		
if ((getTovarVal != '') && (getBrendVal != '') && (getKategVal != '') && (getTovarKol != '')) {$("input[type=submit]").removeAttr("disabled");}
else {$("input[type=submit]").attr("disabled", "disabled");}	    
}

		 </script>

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>