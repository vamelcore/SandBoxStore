<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_voz'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_vozvrat'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM `vozvratu` WHERE `ID`='$id'",$db);
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
	
<form action="insert_vozvrat.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Вы действительно хотите удалить эту запись?</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Дата приема:</p></td>
  	<td width="200"><p><?php echo $myrow['data'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Магазин:</p></td>
  	<td><p><?php echo $myrow['magazin'] ?></p></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Категория:</p></td>
  	<td><p><?php echo $myrow['kategoria'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Бренд:</p></td>
  	<td><p><?php echo $myrow['brend'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Номер модели:</p></td>
  	<td><p><?php echo $myrow['nomer_mod'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Размер:</p></td>
  	<td><p><?php echo $myrow['razmer'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Цвет:</p></td>
  	<td><p><?php echo $myrow['cvet'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Материал:</p></td>
  	<td><p><?php echo $myrow['material'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Дата покупки:</p></td>
  	<td><p><?php echo $myrow['data_pokupki'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Количество:</p></td>
  	<td><p><?php echo $myrow['kolichestvo'] ?></p></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Стоимость:</p></td>
  	<td><p><?php echo $myrow['stoimost'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Скидка:</p></td>
  	<td><p><?php echo $myrow['skidka'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Причина возврата:</p></td>
  	<td><p><?php echo $myrow['prichina_vozvrata'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Период 14 дней:</p></td>
  	<td><p><?php echo $myrow['per_14_dney'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Действие с возвратом:</p></td>
  	<td><p><?php echo $myrow['obmen_na'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Дальнейшее движение:</p></td>
  	<td><p><?php echo $myrow['daln_dvijenie'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Примечания:</p></td>
  	<td><p><?php echo $myrow['primechanie'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Кто принял:</p></td>
  	<td><p><?php echo $myrow['kto_pvinyal']?></p></td>
    </tr>
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="delete" type="submit" style="width:100px;" value="Удалить" ></td>
    <td width="200" align="center"><input name="cansel" type="button" style="width:100px;" value="Отмена" onclick="top.location.href='../vozvratu.php'" ></td>
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