<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}

$_SESSION['lastpagevizitmag'] = 'sklad.php';


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

if (isset($_POST['sklad_kat'])) {$_SESSION['sklad_kat'] = $_POST['sklad_kat']; unset($_POST['sklad_kat']);}
if (isset($_POST['sklad_br'])) {$_SESSION['sklad_br'] = $_POST['sklad_br']; unset($_POST['sklad_br']);}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Остатки</title>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" type="text/css" href="form/style_popolnenie.css"/>
<script language="JavaScript" src="js/jquery-1.3.2.js"></script>

<!--/*//<script language="JavaScript" src="form/jquery.js"></script> 
//<script>
//
//$(function() {
//	$("a[rel]").overlay(function test() {		
//   $('#overlay').html('<div class="wrap"></div>');
//		var wrap = this.getContent().find("div.wrap");
//		if (wrap.is(":empty")) {
//			wrap.load(this.getTrigger().attr("href"));
//		}
//	});
//});
//
//</script>*/-->

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
$last_mag_no = $no;

	
?></select></td><td><a href="chat/index.php" class="newWindow" ><img src='images/mail.png'></a></td></tr></table></form><table cellspacing="5"><tr><td><a class="like_button" href="page.php">Общая</a></td><td><a class="like_button" href="praice.php">Прайс</a></td><td><a class="like_button_use" href="sklad.php">Остатки</a></td><td><a class="like_button" href="peremeschenie.php">Перемещение</a></td><td><a class="like_button" href="prodaja.php">Продажи</a></td><td><a class="like_button" href="zarplata.php">Зарплата</a></td><?php if  ($_SESSION['tabl_store_show'][0] == '1') {printf('<td><a class="like_button" href="vozvratu.php">Возвраты</a></td>');}?>
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
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table cellpadding="0" cellspacing="5" border="0"><tr><td><?php if($_SESSION['add_priv_ost'] == 1) {printf("<input name=\"add\" type=\"button\" value=\"Добавить запись\" onclick=\"top.location.href='update/add_sklad.php'\">");} ?> </td><td><p style="font-size:10pt;">Категоря/Бренд:</p></td><td><form method="post">

<table><tr><td><select name="sklad_kat" id="skladkat" style="width:200px"><option value="">Все</option><?php 

for ($no=0; $no<$index_kat; $no++) {
if ($myarray_kateg['ID'][$no] == $_SESSION['sklad_kat']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
}

?></select></td><td><select name="sklad_br" id="skladbr" onchange="javascript:form.submit()" style="width:200px"><?php
if (isset($_SESSION['sklad_br'])) {
for ($no=0; $no<$index_br; $no++) {
if ($myarray_brend['ID_kategorii'][$no] == $_SESSION['sklad_kat']) {
if ($myarray_brend['ID'][$no] == $_SESSION['sklad_br']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
}
}
}
?></select></td></tr></table>



</form></td><td> <p style="font-size:10pt;">Таблица: "Остатки" из базы данных </p></td><?php if ($_SESSION['id_mag_selected'] == 'all') {printf("<td><form action=\"sklad_to_xls.php\"><input type=\"submit\" value=\"Сохранить в XLS\"></form></td>");} else {printf("<td><form action=\"sklad_to_xls_min.php\"><input type=\"submit\" value=\"Сохранить в XLS\"></form></td>");} if ($_SESSION['id_mag'][$last_mag_no] <> 'all') {printf("<td><a class=\"like_button\" href=\"sklad_all.php\">Все остатки</a></td>");}?></tr></table></td>
</tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<?php 
				if ($_SESSION['id_mag_selected'] == 'all')
				{
					printf("<th><h3>Номер модели</h3></th><th><h3>Размер</h3></th><th><h3>Цвет</h3></th><th><h3>Материал</h3></th>");
					$i = 1;
					do {
						printf("<th class=\"nosort\"><h3>%s, количество</h3></th>", $_SESSION['name_mag'][$i]);
						$i++;
						if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}
					} while (isset($_SESSION['name_mag'][$i]));
					printf("<th class=\"nosort\"><h3>Суммарное количество</h3></th>");
				}
				else 
				{
				printf("<th class=\"nosort\"><h3>A</h3></th>");
				printf("<th class=\"nosort\"><h3>R</h3></th>");
				if($_SESSION['ed_priv_ost'] == 1) {
				printf("			
				<th class=\"nosort\"><h3><strong>E</strong></h3></th>
				<th class=\"nosort\"><h3><strong>D</strong></h3></th>
				<th class=\"nosort\"><h3><strong>P</strong></h3></th>
				");
				}
				printf("
				<th><h3>Категория</h3></th>
				<th><h3>Бренд</h3></th>
				<th><h3>Номер модели</h3></th>
				<th><h3>Размер</h3></th>
				<th><h3>Цвет</h3></th>
				<th><h3>Материал</h3></th>
				<th><h3>Количество последненго прихода</h3></th>
				<th><h3>Дата последненго прихода</h3></th>
				<th><h3>Количество</h3></th>
				");	
				}				
				?>				
			</tr>
		</thead>
		<tbody>
<?php

if ($_SESSION['id_mag_selected'] == 'all') {
		if (isset($_SESSION['sklad_kat']) && isset($_SESSION['sklad_br'])) {$result = mysql_query("SELECT DISTINCT `ID_tovara` FROM `sklad_tovaru` WHERE `ID_kategorii` = '{$_SESSION['sklad_kat']}' AND `ID_brenda` = '{$_SESSION['sklad_br']}' ORDER BY `ID_kategorii` ASC",$db);}
		else {$result = mysql_query("SELECT DISTINCT `ID_tovara` FROM `sklad_tovaru` ORDER BY `ID_kategorii` ASC",$db);}}
else {
		if (isset($_SESSION['sklad_kat']) && isset($_SESSION['sklad_br'])) {$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' AND `ID_kategorii` = '{$_SESSION['sklad_kat']}' AND `ID_brenda` = '{$_SESSION['sklad_br']}' ORDER BY `ID_kategorii` ASC",$db);}
		else {$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' ORDER BY `ID_kategorii` ASC",$db);}
	}

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)

{
$myrow = mysql_fetch_array($result);

if ($_SESSION['id_mag_selected'] == 'all') 
{

do {
$result_tov = mysql_query("SELECT `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID` = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);	
printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",$myrow_tov['nomer_mod'],$myrow_tov['razmer'],$myrow_tov['cvet'],$myrow_tov['material']);

   $i = 1; $summa = 0;
   do {
   	$res_kolich = mysql_query("SELECT `kolichestvo` FROM `sklad_tovaru` WHERE `ID_magazina` = '{$_SESSION['id_mag'][$i]}' AND `ID_tovara` = '{$myrow['ID_tovara']}'",$db);
	if (mysql_num_rows($res_kolich) > 0) {
		$myr_kolich = mysql_fetch_array($res_kolich);
		printf("<td>%s</td>",$myr_kolich['kolichestvo']);
		$summa = $summa + $myr_kolich['kolichestvo'];
	} else {printf("<td>----</td>");}	
	$i++;
	if ($_SESSION['id_mag'][$i] == 'all') {$i++;}
   } while (isset($_SESSION['id_mag'][$i]));

printf("<td><strong>%s</strong></td></tr>",$summa);	
} 
while ($myrow = mysql_fetch_array($result));	
	
}
else {
	
do { 

for ($no=0; $no<=$index_kat; $no++) {if ($myarray_kateg['ID'][$no] == $myrow['ID_kategorii']) {$kategoriya = $myarray_kateg['kateg'][$no];}}	
for ($no=0; $no<=$index_br; $no++) {if ($myarray_brend['ID'][$no] == $myrow['ID_brenda']) {$brend = $myarray_brend['brend'][$no];}}

$result_tov = mysql_query("SELECT `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID` = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);

printf("<tr><td width=15 align='center'><img id='info' onClick=\"top.location.href='archive_sklad.php?id_1=%s&id_2=%s&id_3=%s';\" src='images/archive.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/peremechenie.php?id=%s';\" src='images/send_icon.png' width='20' height='20' border='0'></td>",$myrow['ID_kategorii'],$myrow['ID_brenda'],$myrow['ID_tovara'],$myrow['ID']);

if ($_SESSION['ed_priv_ost'] == 1) {
printf("<td width=15 align='center'><img id='info' onClick=\"top.location.href='update/edit_sklad.php?id=%s';\" src='images/edit_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img id='info' onClick=\"top.location.href='update/del_sklad.php?id=%s';\" src='images/del_icon.png' width='20' height='20' border='0'></td><td width=15 align='center'><img onClick=\"top.location.href='form/page_add_sklad.php?id=%s';\" src='images/plus_icon.png' width='20' height='20' border='0'></td>",$myrow['ID'],$myrow['ID'],$myrow['ID']);
}


printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td></tr>",$kategoriya,$brend,$myrow_tov['nomer_mod'],$myrow_tov['razmer'],$myrow_tov['cvet'],$myrow_tov['material'],$myrow['kol_posl_prihoda'],$myrow['data_posl_prihoda'],$myrow['kolichestvo']);

}
while($myrow = mysql_fetch_array($result));	
}
}

else
{
echo "<p>В таблице нет записей</p>";
//exit();
}
?>

</tbody></table>

<!--<div class="overlay" id="overlay">
<div class="wrap"></div></div>-->

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
	sorter.init("table",<?php if ($_SESSION['id_mag_selected'] == 'all') {echo 0;} else {echo 5;}?>);
  </script>
</td></tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
<p>Всего записей на этой странице: <?php echo $num_rows; ?></p>
</td></tr>
  
</table>
</div>

<script type="text/javascript">
$(document).ready(function () {
         $("#skladkat").change(function(){		 		
         $("#skladbr").load("./update/get_brend_for_skl.php", { kateg: $("#skladkat option:selected").val() },
             function () {
    	         var getKategVal = document.getElementById('skladkat').value;
    	         if (getKategVal == '') {window.location = 'sklad.php';}
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