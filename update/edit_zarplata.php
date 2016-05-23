<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_zar'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_zarplata'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM zarplata WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактирование записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
   SELECT {width: 205px;}
   TEXTAREA {width: 200px;}
  </style>
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_zarplata.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Магазин:</p></td>
  	<td width="200"><select name="magazin"><?php 
$res_mag =mysql_query("SELECT `ID`,`name` FROM magazinu");
$myr_mag = mysql_fetch_array($res_mag);
do {
if ($myr_mag['ID'] ==  $myrow['ID_magazina']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_mag['ID'],$myr_mag['name']);
} else {
	printf("<option value=\"%s\">%s</option>",$myr_mag['ID'],$myr_mag['name']);
}	
}
while ($myr_mag = mysql_fetch_array($res_mag));
?></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Продавец:</p></td>
  	<td><select name="prodav"><?php
$res_us=mysql_query("SELECT `ID`,`login` FROM users");
$myr_us=mysql_fetch_array($res_us);
do {
if ($myr_us['ID'] ==  $myrow['ID_usera']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_us['ID'],$myr_us['login']);
} else {
	printf("<option value=\"%s\">%s</option>",$myr_us['ID'],$myr_us['login']);
}	
}
while ($myr_us=mysql_fetch_array($res_us));
?></select></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Дата:</p></td>
  	<td><textarea name="data" cols="30" rows="1"><?php echo $myrow['data'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Время:</p></td>
  	<td><textarea name="vremya" cols="30" rows="1"><?php echo $myrow['vremya'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Полный день:</p></td>
  	<td><textarea name="povnden" cols="30" rows="1"><?php echo $myrow['polniy_den'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Пол дня:</p></td>
  	<td><textarea name="polden" cols="30" rows="1"><?php echo $myrow['polov_dnya'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Вознаг.:</p></td>
  	<td><textarea name="prodaja" cols="30" rows="1"><?php echo $myrow['prodaja'] ?></textarea></td>
  </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Процент:</p></td>
  	<td><textarea name="procent" cols="30" rows="1"><?php echo $myrow['procent'] ?></textarea></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>К оплате:</p></td>
  	<td><textarea name="koplate" cols="30" rows="1"><?php echo $myrow['k_oplate'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Выданно:</p></td>
  	<td><textarea name="vudano" cols="30" rows="1"><?php echo $myrow['vudano'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ШТРАФЫ:</p></td>
  	<td><textarea name="shtraf" cols="30" rows="1"><?php echo $myrow['shtraf'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Бонусы:</p></td>
  	<td><textarea name="bonus" cols="30" rows="1"><?php echo $myrow['bonus'] ?></textarea></td>
    </tr>
  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input type="submit" style="width:100px;" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../zarplata.php'" ></td>
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