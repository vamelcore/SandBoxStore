<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");
session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$res_check_beznal = mysql_query("SELECT `terminal` FROM `magazinu` WHERE `terminal` = 't' OR `terminal` = 'k'",$db);

if (mysql_num_rows($res_check_beznal) > 0) {
	
$_SESSION['lastpagevizitadm'] = 'beznal.php';	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Касса</title>
<link rel="stylesheet" href="style_main_page.css" />

<style type="text/css">
   INPUT {width: 110px;}
  </style>

</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="brendu.php">Бренды</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button" href="plan.php">План</a></td>
<?php if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>
<tr><td align="center"><table><tr><td><p style="font-size:10pt;">Сумма на счету:</p></td><td><p style="font-size:10pt; color:#078c17;"><?php

	$res_summ = mysql_query("SELECT `summa` FROM `beznal` ORDER BY `ID` DESC LIMIT 1",$db);
	$myr_summ = mysql_fetch_array($res_summ);
	echo ' '.$myr_summ['summa'].' грн. ';
	
	?></p></td><td><p style="font-size:10pt;"> </p></td><td><form action="update/insert_beznal.php" method="post"><input type="hidden" name="summa" value="<?php echo $myr_summ['summa']; ?>"><input type="text" name="izmenenie"><input type="submit" value="Вычесть" name="minus"><input type="submit" value="Прибавить" name="plus"></form></td>	
</tr></table></td></tr>  
<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="600">
		<thead>
			<tr>
				<th width="40" class="nosort"><h3>Удалить</h3></th>
				<th width="120" class="nosort"><h3>Дата</h3></th>
				<th width="120" class="nosort"><h3>Магазин</h3></th>
				<th width="120" class="nosort"><h3>На счету, грн</h3></th>
				<th width="120" class="nosort"><h3>Изменение, грн</h3></th>
				<th width="120" class="nosort"><h3>Кто выполнил/ Примечание</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT * FROM `beznal` ORDER BY `ID` DESC LIMIT 500",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
 
do {
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_beznal.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td><strong>%s</strong></td></tr>",$myrow['ID'],$myrow['data'],$myrow['magazine'],$myrow['summa'],$myrow['izmenenie'],$myrow['user']);
	
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
  </table>
</div>

  </body>
</html>

<?php
}
else {
header("Location: kassa.php");
}
 
}
else {

header("Location: index.php");
die();
}

?>