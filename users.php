<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {
	
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
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitadm'];?>">Назад в админку...</a></td><td><a class="like_button_use" href="users.php">Пользователи</a></td><td><a class="like_button" href="prava.php">Привилегии</a></td><td><a class="like_button" href="magazinu.php">Магазины</a></td><td><a class="like_button" href="timezone.php">Время</a></td><td><a class="like_button" href="backuper.php">Бэкап</a></td><td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>
<tr>
<td style="border-bottom:1px solid #c6d5e1;" align="center"><form action="update/insert_user.php" method="post"><table><tr><td align="center">ID пользователя</td><td align="center">Логин</td><td align="center">Пароль</td><td align="center">ФИО</td><td align="center">Ставка</td><td align="center">Вознаграждение</td><td align="center">Процент</td></tr><tr><td><input type="text" name="ID" size="11" value=""></td><td><input type="text" name="login" value=""></td><td><input type="text" name="password" value=""></td><td><input type="text" name="fio_usera" value=""></td><td><input type="text" name="stavka" size="4" value="0"></td><td align="center"><select name="bonus_stavka" style="width:100px;"><option value="0">Нет</option><option value="1">Есть</option></select></td><td align="center"><select name="proc_stavka" style="width:55px;"><?php for ($i=0; $i<=50; $i++) {printf("<option value='%s'>%s</option>",$i,$i);}?></select></td><td><input type="submit" name="add_user" value="Добавить"></td></tr></table></form></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="350">
		<thead>
			<tr>
				<th width="25" class="nosort"><h3>Редакт.</h3></th>
				<th width="25" class="nosort"><h3>Удалить</h3></th>
				<th width="50"><h3>ID польз.</h3></th>
				<th width="100"><h3>Логин</h3></th>
				<th width="100"><h3>ФИО</h3></th>
				<th width="50"><h3>Ставка, грн</h3></th>
				<th width="50"><h3>Вознаг-раждение</h3></th>
				<th width="50"><h3>Процент, %</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT ID, login, fio_usera, stavka, bonus_stavka, proc_stavka FROM users ORDER BY ID ASC",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
do {

$bonus_show = $myrow['bonus_stavka'];

	if ($bonus_show[0] == '1') {$bonus = 'images/check-icon.png';} else {$bonus = 'images/uncheck-icon.png';}	
	
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_user.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_user.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td width=15 align='center'><img id='info' src='%s' width='20' height='20' border='0'></td><td>%s</td></tr>",$myrow['ID'],$myrow['ID'],$myrow['ID'],$myrow['login'],$myrow['fio_usera'],$myrow['stavka'],$bonus,$myrow['proc_stavka']);
	}
while($myrow = mysql_fetch_array($result));

} 

?>



</tbody></table>

	<div id="controls">
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50" selected="selected">50</option>
				<option value="100">100</option>
				<option value="<?php $num_rows = mysql_num_rows($result); echo $num_rows; ?>" >Все</option>
			</select>
			<span>Записей на страницу</span>
		</div>
		<div id="navigation">
			<img src="images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
			<img src="images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
			<img src="images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
			<img src="images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
		</div>
		<div id="text">Страница <span id="currentpage"></span> из <span id="pagelimit"></span></div>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
  var sorter = new TINY.table.sorter("sorter");
	sorter.head = "head";
	sorter.asc = "asc";
	sorter.desc = "desc";
	sorter.even = "evenrow";
	sorter.odd = "oddrow";
	sorter.evensel = "evenselected";
	sorter.oddsel = "oddselected";
	sorter.paginate = true;
	sorter.currentid = "currentpage";
	sorter.limitid = "pagelimit";
	sorter.init("table",<?php if ($_SESSION['user_brouser'] != 'chrome') {echo '0';} else {echo '-1';}?>);
  </script>

</td></tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
<p>Всего записей на этой странице: <?php echo $num_rows; ?></p>
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