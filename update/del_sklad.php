<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_ost'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_tovara'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID`='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Удаление записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_sklad.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Вы действительно хотите удалить эту запись?</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Магазин:</p></td>
  	<td width="200"><p><?php
  	
$result_mag = mysql_query("SELECT `name` FROM `magazinu` WHERE `ID` = '{$myrow['ID_magazina']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag); 	
echo $myrow_mag['name'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Категория:</p></td>
  	<td><p><?php 
  	
$result_kat = mysql_query("SELECT `kateg` FROM `sklad_kategorii` WHERE `ID` = '{$myrow['ID_kategorii']}'",$db);
$myrow_kat = mysql_fetch_array($result_kat); 	
echo $myrow_kat['kateg'] ?></p></td>
  </tr>
  
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td><p><?php 
$result_br = mysql_query("SELECT `brend` FROM `sklad_brendu` WHERE `ID` = '{$myrow['ID_brenda']}'",$db);
$myrow_br = mysql_fetch_array($result_br);  	
echo $myrow_br['brend'] ?></p></td>
    </tr>  
  
  <tr bgcolor="#ecf2f6">
	<td><p>Номер модели:</p></td>
  	<td><p><?php 
$result_tov = mysql_query("SELECT `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID` = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);  	
echo $myrow_tov['nomer_mod'] ?></p></td>
    </tr>
      <tr bgcolor="#dce6ee">
	<td><p>Размер:</p></td>
  	<td><p><?php   	
echo $myrow_tov['razmer'] ?></p></td>
    </tr>
      <tr bgcolor="#ecf2f6">
	<td><p>Цвет:</p></td>
  	<td><p><?php   	
echo $myrow_tov['cvet'] ?></p></td>
    </tr>
      <tr bgcolor="#dce6ee">
	<td><p>Материал:</p></td>
  	<td><p><?php  	
echo $myrow_tov['material'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Количество:</p></td>
  	<td><p><?php echo $myrow['kolichestvo'] ?></p></td>
    </tr>
  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="delete" type="submit" value="Удалить" style="width:100px"></td>
    <td width="200" align="center"><input name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" style="width:100px"></td>
  </tr>
 	</table>
 
 
 </form>
 
 </td></tr></table>
 
</div>

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>