<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_pro'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_prodaja'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM prodaja WHERE ID='$id'",$db);
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
	
<form action="insert_prodaja.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Вы действительно хотите удалить эту запись?</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="200"><p>Дата:</p></td>
  	<td width="200"><p><?php echo $myrow['data'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Магазин:</p></td>
  	<td><p><?php echo $myrow['magazin'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>
  	<td><p><?php echo $myrow['kategoria'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td><p><?php echo $myrow['brend'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td><p><?php echo $myrow['nomer_mod'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td><p><?php echo $myrow['razmer'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td><p>Цвет:</p></td>
  	<td><p><?php echo $myrow['cvet'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Материал:</p></td>
  	<td><p><?php echo $myrow['material'] ?></p></td>
  </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Цена, грн:</p></td>
  	<td><p><?php echo $myrow['cena'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Вознаграждение, грн:</p></td>
  	<td><p><?php echo $myrow['voznag'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Процент:</p></td>
  	<td><p><?php echo $myrow['procent'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО:</p></td>
  	<td><p><?php echo $myrow['FIO'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Контактний номер телефона:</p></td>
  	<td><p><?php echo $myrow['kontakt_nomer_tel'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Скидка:</p></td>
  	<td><p><?php echo $myrow['skidka'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Примечание:</p></td>
  	<td><p><?php echo $myrow['add'] ?></p></td>
    </tr>
    <tr bgcolor="#ecf2f6">
 <td ><p>Продавец:</p></td>
  	<td><p><?php echo $myrow['user'] ?></p></td>
    </tr>  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="delete" type="submit" value="Удалить" style="width:100px" ></td>
    <td width="200" align="center"><input name="cansel" type="button" value="Отмена" style="width:100px" onclick="top.location.href='../prodaja.php'" ></td>
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