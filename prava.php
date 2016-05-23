<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {
	
	if (isset($_POST['user'])) {$_SESSION['selected_user'] = $_POST['user'];}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Пользователи</title>
<link rel="stylesheet" href="style_main_page.css" />
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitadm'];?>">Назад в админку...</a></td><td><a class="like_button" href="users.php">Пользователи</a></td><td><a class="like_button_use" href="prava.php">Привилегии</a></td><td><a class="like_button" href="magazinu.php">Магазины</a></td><td><a class="like_button" href="timezone.php">Время</a></td><td><a class="like_button" href="backuper.php">Бэкап</a></td><td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1;" align="center"><table><tr><td><form action="prava.php" method="post"><table><tr><td><p style="font-size:10pt;">Выберите пользователя</p></td><td><select name="user" onChange="this.form.submit();">
	<?php
	
$res_user = mysql_query("SELECT `ID`, `login` FROM users ORDER BY ID ASC",$db);	
$myr_user = mysql_fetch_array($res_user);
if (isset($_SESSION['selected_user'])) {
do {

if ($myr_user['ID'] == $_SESSION['selected_user']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_user['ID'],$myr_user['login']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_user['ID'],$myr_user['login']);}	
}		
while ($myr_user = mysql_fetch_array($res_user));
}
else {
do {
if (!isset($_SESSION['selected_user'])) {$_SESSION['selected_user'] = $myr_user['ID'];}
printf ("<option value=\"%s\">%s</option>",$myr_user['ID'],$myr_user['login']);	
}		
while ($myr_user = mysql_fetch_array($res_user));	
}
	?></select></td></tr></table></form></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;" align="center">
	
<form action="update/insert_users.php" method="post"><table><tr><td>	
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="300">
		<thead>
		<tr><th colspan="3"><p align="center" style="font-size:10pt;">Привилегии редактирования таблиц:</p></th></tr>
			<tr>
				<th width="100" class="nosort"><h3>Таблица</h3></th>
				<th width="100" class="nosort"><h3>Добавление</h3></th>
				<th width="100" class="nosort"><h3>Редактирование</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT * FROM users WHERE ID = '{$_SESSION['selected_user']}'",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}

if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);

$priv_aed = $myrow['AED'];
}
?>
<tr><td>Остатки</td><td><?php if ($priv_aed[0]==1) {printf("<input type=\"checkbox\" name=\"add_priv_ost\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"add_priv_ost\">");};?></td>
	<td><?php if ($priv_aed[1]==1) {printf("<input type=\"checkbox\" name=\"ed_priv_ost\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"ed_priv_ost\">");};?></td></tr>
<tr><td>Продажи</td><td><?php if ($priv_aed[2]==1) {printf("<input type=\"checkbox\" name=\"add_priv_pro\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"add_priv_pro\">");};?></td>
	<td><?php if ($priv_aed[3]==1) {printf("<input type=\"checkbox\" name=\"ed_priv_pro\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"ed_priv_pro\">");};?></td></tr>
<tr><td>Зарплата</td><td><?php if ($priv_aed[4]==1) {printf("<input type=\"checkbox\" name=\"add_priv_zar\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"add_priv_zar\">");};?></td>
	<td><?php if ($priv_aed[5]==1) {printf("<input type=\"checkbox\" name=\"ed_priv_zar\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"ed_priv_zar\">");};?></td></tr>
<tr><td>Возвраты</td><td><?php if ($priv_aed[6]==1) {printf("<input type=\"checkbox\" name=\"add_priv_voz\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"add_priv_voz\">");};?></td>
	<td><?php if ($priv_aed[7]==1) {printf("<input type=\"checkbox\" name=\"ed_priv_voz\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"ed_priv_voz\">");};?></td></tr>
</tbody></table>
</td></tr><tr><td>
	
<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="200">
		<thead>
		<tr><th colspan="2"><p align="center" style="font-size:10pt;">Привилегии отображения магазинов:</p></th></tr>
			<tr>
				<th width="100" class="nosort"><h3>Магазин</h3></th>
				<th width="100" class="nosort"><h3>Доступ</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$priv_store = $myrow['storepriv'];
$priv_store_all = $myrow['allpriv'];

$res = mysql_query("SELECT `ID`, `name` FROM magazinu ORDER BY ID ASC",$db);
$myr = mysql_fetch_array($res);
$no=0;
do{
if ($priv_store[$no]==1) {printf("<tr><td>%s</td><td><input type=\"checkbox\" name=\"mag_%s\" value=\"1\" checked></td></tr>",$myr['name'],$myr['ID']);}
else {printf("<tr><td>%s</td><td><input type=\"checkbox\" name=\"mag_%s\"></td></tr>",$myr['name'],$myr['ID']);}
$no++;	
}while ($myr = mysql_fetch_array($res));
?>

<tr><td>Отображать "Все" в списке магазинов</td><td><?php if ($priv_store_all==1) {printf("<input type=\"checkbox\" name=\"allpriv\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"allpriv\">");};?></td></tr>
</tbody></table>

</td></tr>
<tr><td>
	
<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="200">
		<thead>
		<tr><th colspan="2"><p align="center" style="font-size:10pt;">Привилегии администрирования:</p></th></tr>
		</thead><tbody>
<tr><td>Админка</td><td>
<?php
$priv_admin = $myrow['adminpriv'];
if ($_SESSION['selected_user'] == '1001') {printf("<input type=\"checkbox\" name=\"priv_admin\" value=\"1\" disabled=\"disabled\" checked>");} 
else {
if ($priv_admin == 1) {printf("<input type=\"checkbox\" name=\"priv_admin\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"priv_admin\">");}}
?>
</tr>
<tr><td>Настройки</td><td>
<?php
$priv_root = $myrow['rootpriv'];
if ($_SESSION['selected_user'] == '1001') {printf("<input type=\"checkbox\" name=\"priv_root\" value=\"1\" disabled=\"disabled\" checked>");}
else {
if ($priv_root == 1) {printf("<input type=\"checkbox\" name=\"priv_root\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"priv_root\">");}}
?>
</tr>
<tr>
<td>Инкассация в таблице Продаж</td><td>
<?php 
$priv_inkas = $myrow['kassapriv'];
if ($priv_inkas == 1) {printf("<input type=\"checkbox\" name=\"priv_inkas\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"priv_inkas\">");}
?>
</td>
</tr>
<tr>
<td>Отмена продажи в таблице Продаж</td><td>
<?php 
$priv_roll = $myrow['rollpriv'];
if ($priv_roll == 1) {printf("<input type=\"checkbox\" name=\"priv_roll\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"priv_roll\">");}
?>
</td>
</tr>
   </tbody></table>
</td></tr>

<tr><td align="center"><input type="submit" value="Сохранить"></td></tr></table></form>
	
</td></tr> 
  </table>
</div>

  </body>
</html>

<?php 
}
else {

header("Location: index.php");
die();
}

?>