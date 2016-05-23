<?php include ("config.php"); include ("update/functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Остатки</title>
<link rel="stylesheet" href="style_main_page.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
            var windowSizeArray = [ "width=400,height=650",
                                    "width=400,height=650,scrollbars=yes" ];
 
            $(document).ready(function(){
                $('.newWindow').click(function (event){
 
                    var url = $(this).attr("href");
                    var windowName = "popUp";//$(this).attr("name");
                    var windowSize = windowSizeArray[$(this).attr("rel")];
 
                    window.open(url, windowName, windowSize);
 
                    event.preventDefault();
 
                });
            });
        </script>

</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><form method="post"><table><tr><td><p style="font-size:10pt;">Магазин:</p></td><td><select name="selector_of_stores" onChange="javascript:form.submit()"><?php
	
$no = 0;	
do {
$no = $no +1;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}		
}
while($no < $_SESSION['count_mag']);

$_GET=defender_xss_full($_GET);
$_GET=defender_sql($_GET);

if (isset($_GET['id_1'])) {$id1 = $_GET['id_1']; if ($id1 == '') {unset ($id1);}}
if (isset($_GET['id_2'])) {$id2 = $_GET['id_2']; if ($id2 == '') {unset ($id2);}}
if (isset($_GET['id_3'])) {$id3 = $_GET['id_3']; if ($id3 == '') {unset ($id3);}}
	
?></select></td><td><a href="chat/index.php" rel="1" class="newWindow" ><img src='images/mail.png'></a></td></tr></table></form><table cellspacing="5"><tr><td><a class="like_button" href="page.php">Общая</a></td><td><a class="like_button" href="praice.php">Прайс</a></td><td><a class="like_button_use" href="sklad.php">Остатки</a></td><td><a class="like_button" href="peremeschenie.php">Перемещение</a></td><td><a class="like_button" href="prodaja.php">Продажи</a></td><td><a class="like_button" href="zarplata.php">Зарплата</a></td><?php if ($_SESSION['tabl_store_show'][0] == '1') {printf('<td><a class="like_button" href="vozvratu.php">Возвраты</a></td>');}?>
	<?php 
if (isset($_SESSION['admin_priv']) && ($_SESSION['admin_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"%s\">Админ</a></td>",$_SESSION['lastpagevizitadm']);
}
if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}
 ?>

<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"><table cellpadding="0" cellspacing="5" border="0"><tr><td><p style="font-size:10pt;">Архив изменения количества товаров на складе. Дата: </p></td>
<td>
<form method="post"><select name="sk_sec_data" onchange="javascript:form.submit()"><option value="All">Все</option>
	<?php
	if ((isset($id1)) && (isset($id2)) && (isset($id3))) {
	$result_date = mysql_query("SELECT DISTINCT `sec_data` FROM `prihodu` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' AND ID_kategorii = '$id1' AND `ID_brenda` = '$id2' AND ID_tovara = '$id3' ORDER BY `ID` DESC",$db);
	$myrow_date = mysql_fetch_array($result_date);
	if (isset($_POST['sk_sec_data'])) {$_SESSION['sk_sec_data'] = $_POST['sk_sec_data'];}
	do {
if (!isset($_SESSION['sk_sec_data'])) {$_SESSION['sk_sec_data'] = $myrow_date['sec_data'];}
	if ($_SESSION['sk_sec_data'] == $myrow_date['sec_data']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}
	}
	while ($myrow_date = mysql_fetch_array($result_date));
}	
		?></select></form>
</td>
<td>
<?php

if ((isset($id1)) && (isset($id2)) && (isset($id3))) {
	if ($_SESSION['sk_sec_data'] == 'All') {$result = mysql_query("SELECT * FROM `prihodu` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' AND `ID_kategorii` = '$id1' AND `ID_brenda` = '$id2' AND `ID_tovara` = '$id3' ORDER BY `ID` DESC",$db);}
	else {$result = mysql_query("SELECT * FROM `prihodu` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' AND `ID_kategorii` = '$id1' AND `ID_brenda` = '$id2' AND `ID_tovara` = '$id3' AND `sec_data` = '{$_SESSION['sk_sec_data']}' ORDER BY `ID` DESC",$db);}
	
	$myrow = mysql_fetch_array($result);

$result_kat = mysql_query("SELECT `kateg` FROM sklad_kategorii WHERE ID = '$id1'",$db);
$myrow_kat = mysql_fetch_array($result_kat);

$result_br = mysql_query("SELECT `brend` FROM sklad_brendu WHERE ID = '$id2'",$db);
$myrow_br = mysql_fetch_array($result_br);

$result_tov = mysql_query("SELECT `nomer_mod`, `razmer`, `cvet`, `material` FROM prase WHERE ID = '$id3'",$db);
$myrow_tov = mysql_fetch_array($result_tov);	

printf("<p style=\"font-size:10pt;\">Категория: <strong>%s</strong> Бренд: <strong>%s</strong> Номер модели: <strong>%s</strong></p>",$myrow_kat['kateg'],$myrow_br['brend'],$myrow_tov['nomer_mod']);	
	}

?>

</td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
			
				<th class="nosort"><h3><></h3></th>
				<th class="nosort"><h3>Дата</h3></th>
				<th><h3>Размер</h3></th>
				<th><h3>Цвет</h3></th>
				<th><h3>Материал</h3></th>
				<th><h3>Действие</h3></th>
				<th><h3>Количество едениц, (остаток)</h3></th>
				<th><h3>Кем выполнено</h3></th>
								
			</tr>
		</thead>
		<tbody>
<?php
if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)
//$num_rows = mysql_num_rows($result);
{
	
do { 

printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td>%s</td></tr>",$myrow['data'],$myrow_tov['razmer'],$myrow_tov['cvet'],$myrow_tov['material'],$myrow['primech'],$myrow['kol_prihoda'],$myrow['user']);

}
while($myrow = mysql_fetch_array($result));	
	
}

else
{
echo "<p>В таблице нет записей</p>";
//exit();
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