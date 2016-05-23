<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['0'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}

$_SESSION['lastpagevizitmag'] = 'vozvratu.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Возвраты</title>
<link rel="stylesheet" href="style.css" />
<script language="JavaScript" src="js/jquery-1.3.2.js"></script>

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
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no]; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}		
}
while($no < $_SESSION['count_mag']);
	
if ($_SESSION['tabl_store_show'][0] <> '1') {header("Location: index.php"); die();}	
?></select></td><td><a href="chat/index.php" rel="1" class="newWindow" ><img src='images/mail.png'></a></td></tr></table></form><table cellspacing="5"><tr><td><a class="like_button" href="page.php">Общая</a></td><td><a class="like_button" href="praice.php">Прайс</a></td><td><a class="like_button" href="sklad.php">Остатки</a></td><td><a class="like_button" href="peremeschenie.php">Перемещение</a></td><td><a class="like_button" href="prodaja.php">Продажи</a></td><td><a class="like_button" href="zarplata.php">Зарплата</a></td><?php if  ($_SESSION['tabl_store_show'][0] == '1') {printf('<td><a class="like_button_use" href="vozvratu.php">Возвраты</a></td>');}?>
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
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table cellpadding="0" cellspacing="5" border="0"><tr><td><?php if($_SESSION['add_priv_voz'] == 1) {printf("<input name=\"add\" type=\"button\" value=\"Добавить запись\" onclick=\"top.location.href='update/add_vozvrat.php'\">");} ?> </td><td><input name="update" type="button" value="Сортировка по дате" onclick="top.location.href='vozvratu.php'" ></td><td> <p style="font-size:10pt;">Таблица: "Возвраты" из базы данных </p></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<?php if($_SESSION['ed_priv_voz'] == 1) {
				printf("<th class=\"nosort\"><h3><strong>E</strong></h3></th>");
				printf("<th class=\"nosort\"><h3><strong>D</strong></h3></th>");
				}  else {
					printf("<th class=\"nosort\"><h3><></h3></th>");
				}
				?>
				<th class="nosort"><h3>Дата приема</h3></th>
				<?php 
				if ($_SESSION['id_mag_selected'] == 'all') {
					printf("<th><h3>Магазин</h3></th>");
				}
				?>				
				<th><h3>Категория</h3></th>
				<th><h3>Бренд</h3></th>
				<th><h3>Номер модели</h3></th>
				<th><h3>Размер</h3></th>
				<th><h3>Цвет</h3></th>
				<th><h3>Материал</h3></th>
				<th><h3>Кол, шт</h3></th>
				<th><h3>Дата покупки</h3></th>
				<th><h3>Стоим, грн</h3></th>
				<th><h3>Скидка, грн</h3></th>
				<th><h3>Причина возврата</h3></th>
				<th><h3>Период 14 дней</h3></th>
				<th><h3>Действие с возвратом</h3></th>
				<th><h3>Дальнейшее действие</h3></th>
				<th><h3>Примечание</h3></th>
				<th><h3>Кто принял</h3></th>
			</tr>
		</thead>
		<tbody>
<?php

if ($_SESSION['id_mag_selected'] == 'all') {$result = mysql_query("SELECT * FROM `vozvratu` ORDER BY `ID` DESC",$db);}
else {
		
$result_mag = mysql_query("SELECT `name` FROM `magazinu` WHERE `ID` = '{$_SESSION['id_mag_selected']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag);		
		
$result = mysql_query("SELECT * FROM `vozvratu` WHERE `magazin` = '{$myrow_mag['name']}' ORDER BY `ID` DESC",$db);
}

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)

{
	
$myrow = mysql_fetch_array($result);

do { 


if ($_SESSION['ed_priv_voz'] == 1) {
	printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_vozvrat.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/del_vozvrat.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td>",$myrow['ID'],$myrow['ID']);}	
else {
	printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td>");
}

printf("<td>%s</td>",$myrow['data']);

if ($_SESSION['id_mag_selected'] == 'all') {printf("<td>%s</td>",$myrow['magazin']);}

printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>",$myrow['kategoria'],$myrow['brend'],$myrow['nomer_mod'],$myrow['razmer'],$myrow['cvet'],$myrow['material'],$myrow['kolichestvo'],$myrow['data_pokupki'],$myrow['stoimost'],$myrow['skidka'],$myrow['prichina_vozvrata'],$myrow['per_14_dney'],$myrow['obmen_na'],$myrow['daln_dvijenie'],$myrow['primechanie'],$myrow['kto_pvinyal']);
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