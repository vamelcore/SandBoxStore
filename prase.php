<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

$_SESSION['lastpagevizitadm'] = 'prase.php';


$res_kateg = mysql_query("SELECT * FROM sklad_kategorii ORDER BY `kateg` ASC",$db);

$myarray_kateg = array(); $index_kat = 0;
while ($myr_kateg = mysql_fetch_assoc($res_kateg)) {
foreach($myr_kateg as $key => $value) {
$myarray_kateg[$key][$index_kat] = $value;
}
$index_kat++;
}	

$res_brend = mysql_query("SELECT * FROM sklad_brendu ORDER BY `brend` ASC",$db);

$myarray_brend = array(); $index_br = 0;
while ($myr_brend = mysql_fetch_assoc($res_brend)) {
foreach($myr_brend as $key => $value) {
$myarray_brend[$key][$index_br] = $value;
}
$index_br++;
}	


$res_diff_cena = mysql_query("SELECT DISTINCT `ID_tovara` FROM `diff_cena` ORDER BY `ID_tovara` ASC",$db);

$myarray_diff_cena = array(); $index_cena = 0;
while ($myr_diff_cena = mysql_fetch_assoc($res_diff_cena)) {
foreach($myr_diff_cena as $key => $value) {
$myarray_diff_cena[$key][$index_cena] = $value;
}
$index_cena++;
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Товары</title>
<link rel="stylesheet" href="style_main_page.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>

<link rel="stylesheet" type="text/css" href="form/style_diff_cena.css"/>
<script src="form/jquery.js"></script> 
<script>

$(function() {
	$("a[rel]").overlay(function test() {		
   $('#overlay').html('<div class="wrap"></div>');
		var wrap = this.getContent().find("div.wrap");
		if (wrap.is(":empty")) {
			wrap.load(this.getTrigger().attr("href"));
		}
	});
});

</script>
</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellspacing="5"><tr><td><a class="like_button_adm" href="<?php echo $_SESSION['lastpagevizitmag'];?>">Назад в магазин...</a></td><td>||</td><td><a class="like_button" href="kassa.php">Касса</a></td><td><a class="like_button" href="kategorii.php">Категории</a></td><td><a class="like_button" href="brendu.php">Бренды</a></td><td><a class="like_button_use" href="prase.php">Товары</a></td><td><a class="like_button" href="plan.php">План</a></td>
<?php if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
?>
<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1;" align="center"><table><tr><td><form action="update/insert_prase.php" method="post"><table><tr><td align="center">Категория</td><td align="center">Бренд</td><td align="center">Номер модели</td><td align="center">Размер</td><td align="center">Цвет</td><td align="center">Материал</td><td align="center">Цена</td><td align="center">Вознаг.</td></tr><tr><td><select name="kateg" id="kateg" style="width:200px"><option value="">Все</option><?php

for ($no=0; $no<$index_kat; $no++) {
if ($myarray_kateg['ID'][$no] == $_SESSION['selected_kat_tov']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
}
?></select></td><td><select name="brend" id="brend" onChange="this.form.submit();" style="width:200px"><?php

if (isset($_SESSION['selected_br_tov'])) {
for ($no=0; $no<$index_br; $no++) {
if ($myarray_brend['ID_kategorii'][$no] == $_SESSION['selected_kat_tov']) {
if ($myarray_brend['ID'][$no] == $_SESSION['selected_br_tov']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
}
}	
}
?></select></td><td><input style="width:200px" type="text" name="nomer_mod" <?php if (!isset($_SESSION['selected_kat_tov']) || !isset($_SESSION['selected_br_tov'])) {echo 'disabled';} ?>></td><td><input style="width:50px" type="text" name="razmer" <?php if (!isset($_SESSION['selected_kat_tov']) || !isset($_SESSION['selected_br_tov'])) {echo 'disabled';} ?>></td><td><input style="width:100px" type="text" name="cvet" <?php if (!isset($_SESSION['selected_kat_tov']) || !isset($_SESSION['selected_br_tov'])) {echo 'disabled';} ?>></td><td><input style="width:100px" type="text" name="material" <?php if (!isset($_SESSION['selected_kat_tov']) || !isset($_SESSION['selected_br_tov'])) {echo 'disabled';} ?>></td><td><input style="width:40px" type="text" name="cena" <?php if (!isset($_SESSION['selected_kat_tov']) || !isset($_SESSION['selected_br_tov'])) {echo 'disabled';} ?>></td><td><input style="width:40px" type="text" name="voznag" <?php if (!isset($_SESSION['selected_kat_tov']) || !isset($_SESSION['selected_br_tov'])) {echo 'disabled';} ?>></td><td colspan="2" align="center" valign="center"><input type="submit" name="add_tovar" value="Добавить" <?php if (!isset($_SESSION['selected_kat_tov']) || !isset($_SESSION['selected_br_tov'])) {echo 'disabled';} ?>></td></tr></table></form></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable" width="500">
		<thead>
			<tr>
				<th width="20" class="nosort"><h3>Редакт.</h3></th>
				<th width="20" class="nosort"><h3>Удалить</h3></th>
				<th width="150" ><h3>Категория</h3></th>
				<th width="150" ><h3>Бренд</h3></th>
				<th width="150" ><h3>Номер модели</h3></th>
				<th width="150" ><h3>Размер</h3></th>
				<th width="150" ><h3>Цвет</h3></th>
				<th width="150" ><h3>Материал</h3></th>
				<th width="40" ><h3>Цена</h3></th>
				<th width="40" ><h3>Вознаг.</h3></th>
				<th width="40" ><h3>Разн. цены</h3></th>
			</tr>
		</thead>
		<tbody>
<?php
if (isset($_SESSION['selected_kat_tov']) && isset($_SESSION['selected_br_tov'])) {

$result = mysql_query("SELECT * FROM prase WHERE ID_kategorii = '{$_SESSION['selected_kat_tov']}' AND ID_brenda = '{$_SESSION['selected_br_tov']}' ORDER BY ID ASC",$db);
$res_kat = mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '{$_SESSION['selected_kat_tov']}'",$db);
$myr_kat = mysql_fetch_array($res_kat);
$res_br = mysql_query("SELECT `brend` FROM sklad_brendu WHERE ID = '{$_SESSION['selected_br_tov']}'",$db);
$myr_br = mysql_fetch_array($res_br);	
	}
else {

$result = mysql_query("SELECT * FROM prase ORDER BY ID ASC",$db);

}

if (!$result)
{	
echo "<p>Нет соединения с БД</p>";
exit();
}


if (mysql_num_rows($result) > 0) {$myrow = mysql_fetch_array($result);
do {

if (isset($_SESSION['selected_kat_tov']) && isset($_SESSION['selected_br_tov'])) {
	$kategoriya = $myr_kat['kateg'];
	$brend = $myr_br['brend'];
	}
else {

for ($no=0; $no<=$index_kat; $no++) {if ($myarray_kateg['ID'][$no] == $myrow['ID_kategorii']) {$kategoriya = $myarray_kateg['kateg'][$no];}}	
for ($no=0; $no<=$index_br; $no++) {if ($myarray_brend['ID'][$no] == $myrow['ID_brenda']) {$brend = $myarray_brend['brend'][$no];}}		
	}	
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_prase.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/insert_prase.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td>%s</td>",$myrow['ID'],$myrow['ID'],$kategoriya,$brend,$myrow['nomer_mod'],$myrow['razmer'],$myrow['cvet'],$myrow['material'],$myrow['cena'],$myrow['voznag']);

$img_diff_cena = 'images/plus_no_gr.png';
for ($no=0; $no<=$index_cena; $no++) {if ($myarray_diff_cena['ID_tovara'][$no] == $myrow['ID']) {$img_diff_cena = 'images/plus.png';}}
	
printf("<td width=15 align='center'><a href='form/different_cena.php?id=%s' rel='#overlay'><img src='%s' width='20' height='20' border='0'></a></td></tr>",$myrow['ID'],$img_diff_cena);
	
}
while($myrow = mysql_fetch_array($result));

} 

?>

</tbody></table>

<div class="overlay" id="overlay">
<div class="wrap"></div></div>

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
	sorter.init("table",<?php if (isset($_SESSION['selected_kat_tov']) && isset($_SESSION['selected_br_tov'])) {echo '4';} else {echo '2';} ?>);
  </script>
	
</td></tr> 


<tr><td style="border-bottom:1px solid #c6d5e1;">
<p>Всего записей на этой странице: <?php echo $num_rows; ?></p>
</td></tr>

  </table>
</div>

<script type="text/javascript">
$(document).ready(function () {
         $("#kateg").change(function(){		 		
         $("#brend").load("./update/get_brend_for_tov.php", { kateg: $("#kateg option:selected").val() },
             function () {
    	         var getKategVal = document.getElementById('kateg').value;
    	         if (getKategVal == '') {location.reload(true);}
    	         }              
         );        
         });
});
</script>

  </body>
</html>

<?php 
}
else {

header("Location: index.php");
die();
}

?>