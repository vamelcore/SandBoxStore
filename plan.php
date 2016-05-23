<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

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
	
$_SESSION['lastpagevizitadm'] = 'plan.php';	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>План</title>
<link rel="stylesheet" href="style_main_page.css" />
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="brendu.php">Бренды</a></td><td><a class="like_button" href="prase.php">Товары</a></td><td><a class="like_button_use" href="plan.php">План</a></td>
<?php if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>
<tr><td align="center"><form method="post"><table><tr><td><p style="font-size:10pt;">Магазин:</p></td><td><select name="magaz" onChange="javascript:form.submit()"><?php

$no = 0;	
do {
$no = $no +1;
		
if ($_POST['magaz'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
}
while($no < $_SESSION['count_mag'] - 1);

?></select></td>	
</tr></table></form></td></tr>
<tr><td style="border-bottom:1px solid #c6d5e1;"><form action="/update/insert_plan.php" method="post">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="200">
		<thead>
			<tr>
				<th width="150" class="nosort"><h3>Наименование</h3></th>
				<th width="50" class="nosort"><h3>План</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
$result = mysql_query("SELECT * FROM plan WHERE ID_magazina = '{$_SESSION['id_mag_selected']}' ORDER BY ID ASC",$db);

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
 
do {
	printf("<tr><td>%s</td><td><input type='text' name='%s' value='%s'></td></tr>",$myrow['naimenov'],$myrow['name'],$myrow['plane']);
	
}
while($myrow = mysql_fetch_array($result));

} 

?>

</tbody></table>
<div align="center"><input type="submit" value="Сохранить"></div>
</form>

<br>

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