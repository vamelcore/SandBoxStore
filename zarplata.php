<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}

if (!isset($_SESSION['user_zp'])) {$_SESSION['user_zp'] = $_SESSION['user_id'];}
else {
	if (isset($_POST['user'])) {$_SESSION['user_zp'] = $_POST['user'];}
}

$_SESSION['lastpagevizitmag'] = 'zarplata.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Зарплата</title>
<link rel="stylesheet" href="style.css" />
<script language="JavaScript" src="js/jquery-1.3.2.js"></script>

<link rel="stylesheet" type="text/css" href="form/style_zp_info.css"/>
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
<script type="text/javascript">
            var windowSizeArray = [ "width=400,height=650",
                                    "width=400,height=650,scrollbars=yes" ];
 
            $(document).ready(function(){
                $('.newWindow').click(function (event){
 
                    var url = $(this).attr("href");
                    var windowName = "popUp";//$(this).attr("name");
                    var windowSize = "width=400,height=650,scrollbars=yes";
 
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
	
	
?></select></td><td><a href="chat/index.php" class="newWindow" ><img src='images/mail.png'></a></td></tr></table></form><table cellspacing="5"><tr><td><a class="like_button" href="page.php">Общая</a></td><td><a class="like_button" href="praice.php">Прайс</a></td><td><a class="like_button" href="sklad.php">Остатки</a></td><td><a class="like_button" href="peremeschenie.php">Перемещение</a></td><td><a class="like_button" href="prodaja.php">Продажи</a></td><td><a class="like_button_use" href="zarplata.php">Зарплата</a></td><?php if  ($_SESSION['tabl_store_show'][0] == '1') {printf('<td><a class="like_button" href="vozvratu.php">Возвраты</a></td>');}?>
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
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table cellpadding="0" cellspacing="5" border="0"><tr>
<?php if($_SESSION['add_priv_zar'] == 1) {
printf("<td align=\"center\">Продавец</td><td align=\"center\">Выдано</td><td align=\"center\">Штрафы</td><td align=\"center\">Бонусы</td></tr><tr><td><form method=\"post\"><select name=\"user\" onChange=\"javascript:form.submit()\">");
	$res_u = mysql_query("SELECT `ID`, `login` FROM users",$db);
	$myr_u = mysql_fetch_array($res_u);
	
	do {
			if ($myr_u['ID'] == $_SESSION['user_zp']) {printf("<option selected=\"selected\" value=%s>%s</option>",$myr_u['ID'],$myr_u['login']); $_SESSION['user_zp'] = $myr_u['ID'];}
			else {printf("<option value=%s>%s</option>",$myr_u['ID'],$myr_u['login']);}
	}
	while ($myr_u = mysql_fetch_array($res_u));
printf("</select></form></td><td><form method=\"post\" action=\"/update/insert_zar_adm.php\"><input name=\"vudano\" type=\"text\" style=\"width: 100px;\"></td><td><input name=\"shtraf\" type=\"text\" style=\"width: 100px;\"></td><td><input name=\"bonus\" type=\"text\" style=\"width: 100px;\"></td><td><input type=\"submit\" value=\"Добавить\"></form></td>");
}?>
<td><input name="update" type="button" value="Сортировка по дате" onclick="top.location.href='zarplata.php'" ></td><td> <p style="font-size:10pt;">Таблица: "Зарплата". </p><td><p style="font-size:10pt; color: red;">К оплате:
<?php	
$res_zap = mysql_query("SELECT `k_oplate` FROM zarplata WHERE ID_usera = '{$_SESSION['user_zp']}' ORDER BY `ID` DESC LIMIT 1");	
$myr_zap = mysql_fetch_array($res_zap);
echo $myr_zap['k_oplate'];		
?>
грн.</p></td></td></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
			 <th class="nosort"><h3>Inf</h3></th>
				<?php if($_SESSION['ed_priv_zar'] == 1) {
				printf("<th class=\"nosort\"><h3><strong>E</strong></h3></th>");
				printf("<th class=\"nosort\"><h3><strong>D</strong></h3></th>");
				} 
				if ($_SESSION['id_mag_selected'] == 'all') {
					printf("<th><h3>Магазин</h3></th>");
				}
				?>
				<th class="nosort"><h3>Продавец</h3></th>
				<th class="nosort"><h3>Дата</h3></th>
				<th class="nosort"><h3>Время</h3></th>
				<th><h3>Полный день</h3></th>
				<th><h3>Пол дня</h3></th>
				<th><h3>Вознаг.</h3></th>
				<th><h3>Процент</h3></th>
				<th><h3>К оплате</h3></th>
				<th><h3>Выданно</h3></th>
				<th><h3>ШТРАФЫ</h3></th>
				<th><h3>Бонусы</h3></th>
				<th><h3>Кто выдал</h3></th>
			</tr>
		</thead>
		<tbody>
<?php

if ($_SESSION['id_mag_selected'] == 'all') {$result = mysql_query("SELECT * FROM zarplata WHERE ID_usera = '{$_SESSION['user_zp']}' ORDER BY ID DESC",$db);}
else {$result = mysql_query("SELECT * FROM zarplata WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' AND ID_usera = '{$_SESSION['user_zp']}' ORDER BY ID DESC",$db);}

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)

{
$myrow = mysql_fetch_array($result);



do { 

$res_mag =mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$myrow['ID_magazina']}'");
$myr_mag = mysql_fetch_array($res_mag);

$res_us=mysql_query("SELECT `login` FROM users WHERE ID = '{$myrow['ID_usera']}'");
$myr_us=mysql_fetch_array($res_us);

if ($myrow['ID_prodaja'] <> '0') {printf("<tr><td width=15 align='center'><a href='form/page_zp_info.php?id=%s' rel='#overlay'><img src='images/info_icon.png' width='20' height='20' border='0'></a></td>",$myrow['ID_prodaja']);}
else {
printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td>");	
	}

if ($_SESSION['ed_priv_zar'] == 1) {
printf("<td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_zarplata.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/del_zarplata.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td>",$myrow['ID'],$myrow['ID']);}


if ($_SESSION['id_mag_selected'] == 'all') {printf("<td>%s</td>",$myr_mag['name']);}

printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td><strong>%s</strong></td><td><strong>%s</strong></td><td><strong>%s</strong></td><td>%s</td></tr>",$myr_us['login'],$myrow['data'],$myrow['vremya'],$myrow['polniy_den'],$myrow['polov_dnya'],$myrow['prodaja'],$myrow['procent'],$myrow['k_oplate'],$myrow['vudano'],$myrow['shtraf'],$myrow['bonus'],$myrow['user']);

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