<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {

 if (isset($_GET['id'])) {$id = $_GET['id'];  if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT `ID`, `login`, `fio_usera`, `stavka`, `bonus_stavka`, `proc_stavka` FROM users WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактирование записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
   INPUT {width: 200px;}
   TEXTAREA {width: 200px;}
</style>
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_user.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>ID пользователя:</p></td>
  	<td width="200"><input type="text" name="ID" readonly="readonly" value="<?php echo $myrow['ID'] ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Логин:</p></td>
  	<td><textarea name="login" cols="30" rows="1"><?php echo $myrow['login'] ?></textarea></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Новый пароль (оставте пустым, если не хотите изменять):</p></td>
  	<td><textarea name="password" cols="30" rows="1"></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>ФИО:</p></td>
  	<td><textarea name="fio_usera" cols="30" rows="1"><?php echo $myrow['fio_usera'] ?></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Ставка, грн.:</p></td>
  	<td><textarea name="stavka" cols="30" rows="1"><?php echo $myrow['stavka'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Зачисление вознаграждений:</p></td>
  	<td><select name="bonus_stavka" style="width:55px;"><?php if ($myrow['bonus_stavka'] == 1) {printf("<option value='0'>Нет</option><option value='1' selected='selected'>Есть</option>");} else {printf("<option value='0' selected='selected'>Нет</option><option value='1'>Есть</option>");}?></select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Процент, %:</p></td>
  	<td><select name="proc_stavka" style="width:55px;"><?php for ($i=0; $i<=50; $i++) {if  (strval($i) == $myrow['proc_stavka']) {printf("<option value='%s' selected='selected'>%s</option>",$i,$i);} else {printf("<option value='%s'>%s</option>",$i,$i);}} ?></select></td>
    </tr>  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="edit_user" type="submit" style="width:100px;" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" type="button" style="width:100px;" value="Отмена" onclick="top.location.href='../users.php'" ></td>
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