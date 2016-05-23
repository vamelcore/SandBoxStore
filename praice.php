<?php include ("config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1']; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
		
	}

$_SESSION['lastpagevizitmag'] = 'praice.php';


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

if (isset($_POST['price_kat'])) {$price_kat = $_POST['price_kat']; unset($_POST['price_kat']);}
if (isset($_POST['price_br'])) {$price_br = $_POST['price_br']; unset($_POST['price_br']);}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Прайс</title>
<link rel="stylesheet" href="style.css" />
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
$no++;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no]; $_SESSION['tabl_store_show'] = $_SESSION['tabl_st_show'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}		
}
while($no < $_SESSION['count_mag']);
	
?></select></td><td><a href="chat/index.php" rel="1" class="newWindow" ><img src='images/mail.png'></a></td></tr></table></form><table cellspacing="5"><tr><td><a class="like_button" href="page.php">Общая</a></td><td><a class="like_button_use" href="praice.php">Прайс</a></td><td><a class="like_button" href="sklad.php">Остатки</a></td><td><a class="like_button" href="peremeschenie.php">Перемещение</a></td><td><a class="like_button" href="prodaja.php">Продажи</a></td><td><a class="like_button" href="zarplata.php">Зарплата</a></td><?php if  ($_SESSION['tabl_store_show'][0] == '1') {printf('<td><a class="like_button" href="vozvratu.php">Возвраты</a></td>');}?>
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
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><table><tr><td><p style="font-size:10pt;">Категоря/Бренд:</p></td><td>
<form method="post"><table><tr><td><select name="price_kat" id="pricekat" style="width:200px"><option value="">Все</option><?php 

for ($no=0; $no<$index_kat; $no++) {
if ($myarray_kateg['ID'][$no] == $price_kat) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
}

?></select></td><td><select name="price_br" id="pricebr" onchange="javascript:form.submit()" style="width:200px"><?php
if (isset($price_br)) {
for ($no=0; $no<$index_br; $no++) {
if ($myarray_brend['ID_kategorii'][$no] == $price_kat) {
if ($myarray_brend['ID'][$no] == $price_br) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
}
}
}
?></select></td></tr></table></form></td></td><td><p style="font-size:10pt;">Таблица: "Прайс" из базы данных </p></td><td><form action="praice_to_xls.php" method="post"><input type="hidden" name="price_kat" value="<?php echo $price_kat;?>"><input type="hidden" name="price_br" value="<?php echo $price_br;?>"><input type="submit" value="Сохранить в XLS"></form></td></tr><tr><td colspan="3"><table><tr><td><form method="post" action="poisk.php"><table><tr><td><input type="text" name="poisk" style="width: 300px;" value="<?php if (isset($_SESSION['poisk'])) {echo $_SESSION['poisk_view'];}?>"></td><td><input type="submit" value="Искать"></td></tr></table></form></td><td><form method="post" action="poisk.php"><input type="submit" value="Очистить" name="clear"></form></td></tr></table></td></tr></table></td></tr>
<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<th class="nosort"><h3><></h3></th> 			
				<th><h3>Категория</h3></th>
				<th><h3>Бренд</h3></th>
				<th><h3>Номер модели</h3></th>
				<th><h3>Размер</h3></th>
				<th><h3>Цвет</h3></th>
				<th><h3>Материал</h3></th>
				<th><h3>Цена</h3></th>
				<th><h3>Вознаг.</h3></th>
			</tr>
		</thead>
		<tbody>
<?php

	if (isset($_SESSION['poisk'])) {
$result = mysql_query("SELECT * FROM `prase` WHERE `nomer_mod` LIKE '%{$_SESSION['poisk']}%' OR `razmer` LIKE '%{$_SESSION['poisk']}%' OR `cvet` LIKE '%{$_SESSION['poisk']}%' OR `material` LIKE '%{$_SESSION['poisk']}%' OR `ID_kategorii` IN ( SELECT `ID` FROM `sklad_kategorii` WHERE `kateg` LIKE '%{$_SESSION['poisk']}%' ) OR `ID_brenda` IN ( SELECT `ID` FROM `sklad_brendu` WHERE `brend` LIKE '%{$_SESSION['poisk']}%' )",$db);} 
else {
		if ($price_kat == '') {$result = mysql_query("SELECT * FROM `prase`",$db);} else {
		$result = mysql_query("SELECT * FROM `prase` WHERE ID_kategorii ='$price_kat' AND `ID_brenda` = '$price_br'",$db);	
		}
	}

if (!$result)
{
echo "<p>Нет соединения с БД</p>";
exit(mysql_error());
}

if (mysql_num_rows($result) > 0)

{

if ($_SESSION['id_mag_selected'] <> 'all') {

$res_diff_cena = mysql_query("SELECT * FROM `diff_cena` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' ORDER BY `ID_tovara` ASC",$db);

$myarray_diff_cena = array(); $index_cena = 0;
while ($myr_diff_cena = mysql_fetch_assoc($res_diff_cena)) {
foreach($myr_diff_cena as $key => $value) {
$myarray_diff_cena[$key][$index_cena] = $value;
}
$index_cena++;
}
//print_r($myarray_diff_cena);
}

$myrow = mysql_fetch_array($result);

do { 

for ($no=0; $no<=$index_kat; $no++) {if ($myarray_kateg['ID'][$no] == $myrow['ID_kategorii']) {$kategoriya = $myarray_kateg['kateg'][$no];}}	
for ($no=0; $no<=$index_br; $no++) {if ($myarray_brend['ID'][$no] == $myrow['ID_brenda']) {$brend = $myarray_brend['brend'][$no];}}

$cena = $myrow['cena'];
$vaznag = $myrow['voznag'];
if ($_SESSION['id_mag_selected'] <> 'all') {
for ($no=0; $no<=$index_cena; $no++) {if ($myarray_diff_cena['ID_tovara'][$no] == $myrow['ID']) {$cena = $myarray_diff_cena['new_cena'][$no]; $vaznag =$myarray_diff_cena['new_bonus'][$no];}}}

printf("<tr><td width=15 align='center'><img src='images/ok.png' width='20' height='20' border='0'></td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><strong>%s</strong></td><td>%s</td></tr>",$kategoriya,$brend,$myrow['nomer_mod'],$myrow['razmer'],$myrow['cvet'],$myrow['material'],$cena,$vaznag);

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
				<option value="10" >10</option>
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
	sorter.init("table",<?php if (isset($price_kat) && isset($price_br)) {echo '3';} else {echo '1';} ?>);
  </script>
</td></tr>

<tr><td style="border-bottom:1px solid #c6d5e1;">
<p>Всего записей на этой странице: <?php echo $num_rows; ?></p>
</td></tr>
  
  </table>
</div>

<script type="text/javascript">
$(document).ready(function () {
         $("#pricekat").change(function(){		 		
         $("#pricebr").load("./update/get_brend_for_edit_tov.php", { kateg: $("#pricekat option:selected").val() },
             function () {
    	         var getKategVal = document.getElementById('pricekat').value;
    	         if (getKategVal == '') {window.location = 'praice.php';}
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