<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');
mysql_query("SET NAMES utf8");
session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {
	
	
		if (!isset($_SESSION['id_mag_selected'])) {$_POST['magaz'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['magaz'])) {
				if ($_SESSION['id_mag_selected'] == 'all') {$_POST['magaz'] =$_SESSION['id_mag']['1'];}
				else {$_POST['magaz'] = $_SESSION['id_mag_selected'];}
			}
		
	}
	
$_SESSION['lastpagevizitadm'] = 'kassa.php';	
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
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button_use" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="brendu.php">Бренды</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button" href="plan.php">План</a></td>
<?php if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>
<tr><td align="center"><table align="left"><tr><td width="330px" align="center"><?php 
$res_check_beznal = mysql_query("SELECT `terminal` FROM `magazinu` WHERE `terminal` = 't' OR `terminal` = 'k'",$db);
if (mysql_num_rows($res_check_beznal) > 0) {printf('<a class="like_button" href="beznal.php">Состояние счета</a>');}
?></td><td><p style="font-size:10pt;">Магазин:</p></td><td><form method="post"><select name="magaz" onChange="javascript:form.submit()"><?php

//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 1;	
do {
	
if ($_POST['magaz'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}
$no++;
if ($_SESSION['id_mag'][$no] == 'all') {$no++;}		
}
while(isset($_SESSION['id_mag'][$no]));

?></select></form></td><td><p style="font-size:10pt;">Сумма в кассе:</p></td><td><p style="font-size:10pt; color:#078c17;"><?php
$res_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myr_mag = mysql_fetch_array($res_mag);

	$res_max = mysql_query("SELECT MAX(ID) AS `ID` FROM kassa WHERE magazine = '{$myr_mag['name']}'",$db);
	$myr_max = mysql_fetch_array($res_max, MYSQL_ASSOC);

	$res_summ = mysql_query("SELECT `vkasse` FROM kassa WHERE ID = '{$myr_max['ID']}'",$db);
	$myr_summ = mysql_fetch_array($res_summ);
	echo ' '.$myr_summ['vkasse'].' грн. ';
	
	?></p></td><td><p style="font-size:10pt;"> </p></td><td><form action="update/insert_kassa.php" method="post"><input type="hidden" name="magaz" value="<?php echo $myr_mag['name']; ?>"><input type="hidden" name="vkasse" value="<?php echo $myr_summ['vkasse']; ?>"><input type="text" name="inkas"><input type="submit" value="Инкассировать"></form></td>	
</tr></table></td></tr>  
<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="400">
		<thead>
			<tr>
				<th width="40" class="nosort"><h3>Удалить</h3></th>
				<th width="120" class="nosort"><h3>Дата</h3></th>
				<th width="120" class="nosort"><h3>В кассе, грн</h3></th>
				<th width="120" class="nosort"><h3>Инкасcированно, грн</h3></th>
				<th width="120" class="nosort"><h3>Кто инкасcировал/ Примечание</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT * FROM kassa WHERE magazine = '{$myr_mag['name']}' ORDER BY ID DESC LIMIT 500",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
 
do {
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_kassa.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td><strong>%s</strong></td></tr>",$myrow['ID'],$myrow['data'],$myrow['vkasse'],$myrow['inkas'],$myrow['user']);
	
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

header("Location: index.php");
die();
}

?>