<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET);  $id = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID`='$id'",$db);
$myrow = mysql_fetch_array($result);

if ($myrow['kolichestvo'] == '0') { ?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы товаров</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
		
	
<div align="center">	
	<p>Количество товара <strong><? echo $myrow['tovar']; ?></strong> в этом магазине равно <strong>0</strong>, его нельзя переместить! <a href="../sklad.php">Вернуться на Остатки</a></p>
</div>
</body>
</html>	
<?php 	

}

else {

$result_mag = mysql_query("SELECT `ID`, `name` FROM magazinu",$db);

$myarray_mag = array(); $index_mag = 0;
while ($myrow_mag = mysql_fetch_assoc($result_mag)) {
foreach($myrow_mag as $key => $value) {
$myarray_mag[$key][$index_mag] = $value;
}
$index_mag++;
}

for ($no=0; $no<$index_mag; $no++) {
if ($myarray_mag['ID'][$no] == $myrow['ID_magazina']) {$id_mag_from = $myarray_mag['ID'][$no]; $name_mag_from = $myarray_mag['name'][$no];}
}


$result_br = mysql_query("SELECT `ID`, `brend` FROM `sklad_brendu` WHERE `ID` = '{$myrow['ID_brenda']}'",$db);
$myrow_br = mysql_fetch_array($result_br);

$result_kat = mysql_query("SELECT `ID`, `kateg` FROM `sklad_kategorii` WHERE `ID` = '{$myrow['ID_kategorii']}'",$db);
$myrow_kat = mysql_fetch_array($result_kat);

$result_tov = mysql_query("SELECT `ID`, `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID` = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы товаров</title>
<link href="../style.css" rel="stylesheet" type="text/css" />

</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="replace_tovar.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Перемещение товара</p></b></td>
    </tr>
  
  <tr bgcolor="#dce6ee">
	<td><p>Из магазина:</p><input name="id_replace_tov" type="hidden" value="<?php echo $id; ?>"></td>
  	<td><p><?php echo $name_mag_from;?></p><input name="from_mag_name" type="hidden" value="<?php echo $name_mag_from; ?>"><input name="from_mag" type="hidden" value="<?php echo $id_mag_from; ?>"></td>
  
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>В магазин:</p></td> 	
  	<td>
  		<select name="to_mag"> 			
<?php

for ($no=0; $no<$index_mag; $no++) {
if ($myarray_mag['ID'][$no] == $myrow['ID_magazina']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_mag['ID'][$no],$myarray_mag['name'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_mag['ID'][$no],$myarray_mag['name'][$no]);}
}

 ?></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Категория товара:</p></td>
  	<td><p><?php echo $myrow_kat['kateg']; ?></p><input name="kategorya_name" type="hidden" value="<?php echo htmlspecialchars($myrow_kat['kateg']); ?>"><input name="kategorya" type="hidden" value="<?php echo $myrow_kat['ID']; ?>"></td>
  </tr>
  
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td><p><?php echo $myrow_br['brend']; ?></p><input name="brend_name" type="hidden" value="<?php echo htmlspecialchars($myrow_br['brend']); ?>"><input name="brend" type="hidden" value="<?php echo $myrow_br['ID']; ?>"></td>
    </tr>  
  
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td><p><?php echo $myrow_tov['nomer_mod']; ?></p><input name="nomer_mod_name" type="hidden" value="<?php echo htmlspecialchars($myrow_tov['nomer_mod']); ?>"><input name="nomer_mod" type="hidden" value="<?php echo $myrow_tov['ID']; ?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td><p><?php echo $myrow_tov['razmer']; ?><input name="razmer" type="hidden" value="<?php echo htmlspecialchars($myrow_tov['razmer']); ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Цвет:</p></td>
  	<td><p><?php echo $myrow_tov['cvet']; ?><input name="cvet" type="hidden" value="<?php echo htmlspecialchars($myrow_tov['cvet']); ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Материал:</p></td>
  	<td><p><?php echo $myrow_tov['material']; ?><input name="material" type="hidden" value="<?php echo htmlspecialchars($myrow_tov['material']); ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Количество:</p></td>
  	<td><select name="kolichestvo"><?php 
if ($myrow['kolichestvo'] > '0'){
$i=1;
do {

printf("<option value=\"%s\">%s</option>",$i,$i);	
$i++;	

} while ($i <= $myrow['kolichestvo']);
}
  	
?></select></td>
    </tr>  
  
 </table>
 
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ></td>
  </tr>
 </table>
 
 </form>
 
 </td></tr></table>
 
</div>

</body>
</html>

<?php

}

}
else {

header("Location: ../index.php");
die();
}
 ?>