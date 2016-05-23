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
<title>Удаление записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_zarplata.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Вы действительно хотите удалить эту запись?</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Магазин:</p></td>
  	<td width="200"><p><?php
$res_mag =mysql_query("SELECT `name` FROM magazinu WHERE ID ='{$myrow['ID_magazina']}'");
$myr_mag = mysql_fetch_array($res_mag);
echo $myr_mag['name'];  	
?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Продавец:</p></td>
  	<td><p><?php
$res_us=mysql_query("SELECT `login` FROM users WHERE ID = '{$myrow['ID_usera']}'");
$myr_us=mysql_fetch_array($res_us);  	
echo $myr_us['login'] 
?></p></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Дата:</p></td>
  	<td><p><?php echo $myrow['data'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Время:</p></td>
  	<td><p><?php echo $myrow['vremya'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Полный день:</p></td>
  	<td><p><?php echo $myrow['polniy_den'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Пол дня:</p></td>
  	<td><p><?php echo $myrow['polov_dnya'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Вознаг.:</p></td>
  	<td><p><?php echo $myrow['prodaja'] ?></p></td>
  </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Процент:</p></td>
  	<td><p><?php echo $myrow['procent'] ?></p></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>К оплате:</p></td>
  	<td><p><?php echo $myrow['k_oplate'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Выданно:</p></td>
  	<td><p><?php echo $myrow['vudano'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ШТРАФЫ:</p></td>
  	<td><p><?php echo $myrow['shtraf'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Бонусы:</p></td>
  	<td><p><?php echo $myrow['bonus'] ?></p></td>
    </tr> 
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="delete" style="width:100px;" type="submit" value="Удалить" ></td>
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