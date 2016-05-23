<?php include ("../config.php");

if   ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){$id_roll = $_REQUEST['id_roll'];}

//Определние продажи
$result = mysql_query("SELECT * FROM `prodaja` WHERE ID = '$id_roll'",$db);
$myrow = mysql_fetch_array($result);

//Определене ID магазина
if  (!empty($myrow['magazin'])) {
$res_mag=mysql_query("SELECT ID FROM magazinu WHERE name = '{$myrow['magazin']}'",$db);
$myr_mag=mysql_fetch_array($res_mag);}

//Определение ID категории
if  (!empty($myrow['kategoria'])) {
$res_kat=mysql_query("SELECT ID FROM sklad_kategorii WHERE  kateg = '{$myrow['kategoria']}'",$db);
$myr_kat=mysql_fetch_array($res_kat);}

//Определение ID бренда
if (!empty($myrow['brend'])) {
$res_br=mysql_query("SELECT ID FROM sklad_brendu WHERE brend = '{$myrow['brend']}' AND ID_kategorii = '{$myr_kat['ID']}'",$db);
$myr_br=mysql_fetch_array($res_br);	}

//Определение ID товара
if (!empty($myrow['nomer_mod'])) {
$res_tov=mysql_query("SELECT ID FROM prase WHERE ID_kategorii = '{$myr_kat['ID']}' AND ID_brenda = '{$myr_br['ID']}' AND nomer_mod = '{$myrow['nomer_mod']}' AND razmer = '{$myrow['razmer']}' AND cvet = '{$myrow['cvet']}' AND material = '{$myrow['material']}'",$db);
$myr_tov=mysql_fetch_array($res_tov);}

//Определение юзера
if (!empty($myrow['user'])) {
$res_usr=mysql_query("SELECT ID FROM users WHERE login = '{$myrow['user']}'",$db);
$myr_usr=mysql_fetch_array($res_usr);}
 ?>

 <table>
  <tr bgcolor="#ecf2f6">
	<td width="200"><p>Магазин:</p></td>
  	<td width="200"><p><?php echo $myrow['magazin'] ?></p><input name="magazine" type="hidden" value="<?php echo $myr_mag['ID'] ?>"><input name="magazine_name" type="hidden" value="<?php echo $myrow['magazin'] ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>
  	<td><p><?php echo $myrow['kategoria'] ?><input name="kategory" type="hidden" value="<?php echo $myr_kat['ID'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td><p><?php echo $myrow['brend'] ?><input name="brend" type="hidden" value="<?php echo $myr_br['ID'] ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td><p><?php echo $myrow['nomer_mod'] ?><input name="nomer_mod" type="hidden" value="<?php echo $myr_tov['ID'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td><p><?php echo $myrow['razmer'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td><p>Цвет:</p></td>
  	<td><p><?php echo $myrow['cvet'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Материал:</p></td>
  	<td><p><?php echo $myrow['material'] ?></p></td>
  </tr> 
  <tr bgcolor="#dce6ee">
    <td><p>Количество, шт:</p></td>
  	<td><p><?php echo $myrow['kolichestvo'] ?><input name="kolichestvo" type="hidden" value="<?php echo $myrow['kolichestvo'] ?>"></p></td>
  </tr> 
  <tr bgcolor="#ecf2f6">
	<td><p>Цена, грн:</p></td>
  	<td><p><?php echo $myrow['cena'] ?><input name="cena" type="hidden" value="<?php echo $myrow['cena'] ?>"></p></td>
    </tr>	
  <tr bgcolor="#dce6ee">
    <td><p>Сумма, грн:</p></td>
  	<td><p><?php echo $myrow['summa'] ?><input name="summa" type="hidden" value="<?php echo $myrow['summa'] ?>"></p></td>
  </tr>	
  <tr bgcolor="#ecf2f6">
	<td><p>Вознаг, грн:</p></td>
  	<td><p><?php echo $myrow['voznag'] ?><input name="voznag" type="hidden" value="<?php echo $myrow['voznag'] ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Процент, грн:</p></td>
  	<td><p><?php echo $myrow['procent'] ?><input name="procent" type="hidden" value="<?php echo $myrow['procent'] ?>"></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО:</p></td>
  	<td><p><?php echo $myrow['FIO'] ?></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Контактний номер телефона:</p></td>
  	<td><p><?php echo $myrow['kontakt_nomer_tel'] ?></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Скидка:</p></td>
  	<td><p><?php echo $myrow['skidka'] ?><input name="skidka" type="hidden" value="<?php echo $myrow['skidka'] ?>"></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Примечание:</p></td>
  	<td><p><?php echo $myrow['add'] ?></p></td>
    </tr>
    <tr bgcolor="#ecf2f6">
 <td><p>Кем продано:</p></td>
  	<td><p><?php echo $myrow['user'] ?><input name="user" type="hidden" value="<?php echo $myrow['user'] ?>"><input name="user_id" type="hidden" value="<?php echo $myr_usr['ID'] ?>"></p></td>
    </tr> 
<tr><td><input name="sdata" type="hidden" value="<?php echo $myrow['sec_data'] ?>"><input name="id_print" type="hidden" value="<?php echo $myrow['printer_ID'] ?>"><input name="id_roll" type="hidden" value="<?php echo $id_roll ?>"><br></td><td><br></td></tr>
<tr><td colspan="2">
<table width="100%">
<tr><td align="center" colspan="2"><strong>Выполняемые дествия:</strong></td></tr>    
<tr><td width="80%"></td><td width="20%"></td></tr>   
<?php 
//Определение наличия товара в остатках 
if  ((!empty($myrow['magazin'])) && (!empty($myrow['kategoria'])) && (!empty($myrow['brend'])) && (!empty($myrow['nomer_mod']))) {
if  ((!empty($myr_mag['ID'])) && (!empty($myr_kat['ID'])) && (!empty($myr_br['ID'])) && (!empty($myr_tov['ID']))) {
	
$res_sklad=mysql_query("SELECT `ID`, `kolichestvo` FROM `sklad_tovaru` WHERE `ID_magazina` = '{$myr_mag['ID']}' AND `ID_kategorii` = '{$myr_kat['ID']}' AND `ID_brenda` = '{$myr_br['ID']}' AND ID_tovara = '{$myr_tov['ID']}'",$db);
$myr_sklad=mysql_fetch_array($res_sklad);
if  (!empty($myr_sklad['ID'])) {printf ("<tr><td>Возврат товара на остатки:<input name='ID_sklada' type='hidden' value='%s'></td><td><strong>+%s</strong> шт<input name='Kol_na_sklade' type='hidden' value='%s'></td></tr>",$myr_sklad['ID'],$myrow['kolichestvo'],$myr_sklad['kolichestvo']);}
else {printf("<tr><td>Создание товара на остатках с количеством:<input name='Add_sklad' type='hidden' value='true'></td><td><strong>+%s</strong> шт</td></tr>",$myrow['kolichestvo']);}
} else {
	if  (empty($myr_mag['ID'])) {printf("<tr><td id='dissubmit' collspan=2><p style='color:red;'>В базе данных отсутствует такой магазин!</p></td></tr>");}
	if  (empty($myr_kat['ID'])) {printf("<tr><td id='dissubmit' collspan=2><p style='color:#078c17;'>В базе данных отсутствуют сведенья о такой категории!</p></td></tr>");}
	if  (empty($myr_br['ID'])) {printf("<tr><td id='dissubmit' collspan=2><p style='color:#078c17;'>В базе данных отсутствуют сведенья о таком бренде!</p></td></tr>");}
	if  (empty($myr_tov['ID'])) {printf("<tr><td id='dissubmit' collspan=2><p style='color:#078c17;'>В базе данных отсутствуют сведенья о таком товаре!</p></td></tr>");}
	}
}

if (isset($myrow['cena']) || isset($myrow['skidka'])) {
$summa_vkasse = $myrow['cena']*$myrow['kolichestvo'] - $myrow['skidka'];
$res_kassa = mysql_query("SELECT * FROM `kassa` WHERE `ID_prodaja` = '$id_roll'");
if (mysql_num_rows($res_kassa) > 0) {
printf("<tr><td>Уменьшение суммы в кассе магазина <strong>%s</strong>:</td><td><strong>%s</strong> грн<input name='Kassa' type='hidden' value='%s'><input name='debet_from' type='hidden' value='kassa'></td></tr>",$myrow['magazin'],$summa_vkasse,$summa_vkasse);}
else {
$res_beznal = mysql_query("SELECT * FROM `beznal` WHERE `ID_prodaja` = '$id_roll'");
if (mysql_num_rows($res_beznal) > 0) {printf("<tr><td>Уменьшение суммы на счету:</td><td><strong>%s</strong> грн<input name='Kassa' type='hidden' value='%s'><input name='debet_from' type='hidden' value='schet'></td></tr>",$summa_vkasse,$summa_vkasse);}
}
}

if (isset($myrow['voznag']) && is_numeric($myrow['voznag'])) {$voznag = $myrow['voznag'];}
if (isset($myrow['procent']) && is_numeric($myrow['procent'])) {$procent = $myrow['procent'];}

if (isset($voznag) || isset($procent)) {
	$summa_zarplata = $voznag + $procent;
	printf("<tr><td>Уменьшение суммы зарплаты <strong>%s</strong>:</td><td><strong>%s</strong> грн<input name='Zarplata' type='hidden' value='%s'></td></tr>",$myrow['user'],$summa_zarplata,$summa_zarplata);	
	}
 
?>
</table>
</td></tr>
</table>