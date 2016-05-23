<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'brendu.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Бренды товаров</title>
<link rel="stylesheet" href="style_main_page.css" />
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button_use" href="brendu.php">Бренды</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button" href="plan.php">План</a></td>
<?php if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?><td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1;" align="center"><form action="update/insert_brend.php" method="post"><table><tr><td align="center">Категория товара</td><td align="center">Бренд</td><td></td></tr><tr><td><select name="kateg" style="width:200px;" onChange="this.form.submit();"><option value="">Все</option>
<?php 
$res_kat = mysql_query("SELECT `ID`, `kateg` FROM `sklad_kategorii` ORDER BY `kateg` ASC",$db);	
$myr_kat = mysql_fetch_array($res_kat);
if (isset($_SESSION['selected_kat'])) {
do {

if ($myr_kat['ID'] == $_SESSION['selected_kat']) {
	printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
	}	
else {
	printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);}	
}		
while ($myr_kat = mysql_fetch_array($res_kat));
}
else {
do {
//if (!isset($_SESSION['selected_kat'])) {$_SESSION['selected_kat'] = $myr_kat['ID'];}
printf ("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);	
}		
while ($myr_kat = mysql_fetch_array($res_kat));	
}
?>
</select></td><td><input type="text" name="brend" style="width:200px;" <?php if (!isset($_SESSION['selected_kat'])) {echo 'disabled';} ?>></td><td><input type="submit" name="add_brend" value="Добавить" <?php if (!isset($_SESSION['selected_kat'])) {echo 'disabled';} ?>></td></tr></table></form></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="200">
		<thead>
			<tr>
				
				<th width="20" class="nosort"><h3>Удалить</h3></th>
				<th width="150"><h3>Категория</h3></th>
				<th width="150"><h3>Бренд</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
if (isset($_SESSION['selected_kat'])) {
$result = mysql_query("SELECT * FROM `sklad_brendu` WHERE ID_kategorii = '{$_SESSION['selected_kat']}' ORDER BY `brend` ASC",$db);
$res = mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '{$_SESSION['selected_kat']}'",$db);
$myr = mysql_fetch_array($res);	
	
	}
else {
$result = mysql_query("SELECT * FROM `sklad_brendu` ORDER BY `brend` ASC",$db);
$res_kateg = mysql_query("SELECT * FROM sklad_kategorii ORDER BY `kateg` ASC",$db);

$myarray_kateg = array(); $index = 0;
while ($myr_kateg = mysql_fetch_assoc($res_kateg)) {
foreach($myr_kateg as $key => $value) {
$myarray_kateg[$key][$index] = $value;
}
$index++;
}	
	}


//$result = mysql_query("SELECT * FROM `sklad_brendu` ORDER BY `brend` ASC",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
do {
	
if (isset($_SESSION['selected_kat'])) {
	$kategogiya = $myr['kateg'];
	}	
	else {
for ($no=0; $no<=$index; $no++) {if ($myarray_kateg['ID'][$no] == $myrow['ID_kategorii']) {$kategogiya = $myarray_kateg['kateg'][$no];}}		
		}
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_brend.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td></tr>",$myrow['ID'],$kategogiya,$myrow['brend']);
	
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
				<option value="<?php $num_rows = mysql_num_rows($result); echo $num_rows; ?>">Все</option>
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
	sorter.init("table",1);
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