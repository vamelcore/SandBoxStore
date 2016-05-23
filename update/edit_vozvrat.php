<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();


if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_voz'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_vozvrat'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM `vozvratu` WHERE `ID`='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы возвратов</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<style type="text/css">
   SELECT {width: 205px;}
   TEXTAREA {width: 200px;}
   INPUT {width: 200px;}
  </style>

</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_vozvrat.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактировать возврат</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Дата приема:</p></td>
  	<td><input name="data_priema" type="text" value="<?php echo $myrow['data'] ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Магазин:</p></td>
  	<td><select name="magazine" id="magaz">
  			
<?php
//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 0;	
do {
$no = $no +1;
	
if ($myrow['magazin'] == $_SESSION['name_mag'][$no])	{
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}		
}
while($no < $_SESSION['count_mag'] - 1);

 ?>
</select></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Категория:</p></td>
  	<td>
  	<select name="kategory_ed" id="kateg">
  			<?php 
$result_kateg = mysql_query("SELECT `ID`,`kateg` FROM `sklad_kategorii` ORDER BY `kateg`",$db);	
$myrow_kateg = mysql_fetch_array($result_kateg);  			

do {
	if ($myrow_kateg['kateg'] == $myrow['kategoria']) {printf ("<option selected=\"selected\" value='%s'>%s</option>" , $myrow_kateg["ID"], $myrow_kateg["kateg"]); $kategor = $myrow_kateg["ID"];}
	else {printf ("<option value='%s'>%s</option>" , $myrow_kateg["ID"], $myrow_kateg["kateg"]);}   
    }
while ($myrow_kateg = mysql_fetch_array($result_kateg));  			
  			?>
  		</select>
  </td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Бренд:</p></td>
  	<td>
  	<select name="brend_ed" id="brend">
		<?php 
$result_br = mysql_query("SELECT `ID`, `brend` FROM `sklad_brendu` WHERE `ID_kategorii` = '$kategor'",$db);
$myrow_br = mysql_fetch_array($result_br);

 do {
 	if ($myrow_br['brend'] == $myrow['brend']) {printf ("<option selected=\"selected\" value='%s'>%s</option>" , $myrow_br["ID"], $myrow_br["brend"]); $brenda = $myrow_br["ID"];}
	else {printf ("<option value='%s'>%s</option>" , $myrow_br["ID"], $myrow_br["brend"]);} 	    
    }
 while ($myrow_br = mysql_fetch_array($result_br));			
		?>
	</select>
 </td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Номер модели:</p></td>
  	<td>
  	<select name="nomer_mod_ed" id="nomer_mod">
		<?php 
$result_tov = mysql_query("SELECT `ID`, `nomer_mod` FROM `prase` WHERE `ID_kategorii` = '$kategor' AND `ID_brenda` = '$brenda'",$db);
$myrow_tov = mysql_fetch_array($result_tov);

 do {
 	if ($myrow_tov['nomer_mod'] == $myrow['nomer_mod']) {printf ("<option selected=\"selected\" value='%s'>%s</option>" , $myrow_tov["nomer_mod"], $myrow_tov["nomer_mod"]);}
	else {printf ("<option value='%s'>%s</option>" , $myrow_tov["nomer_mod"], $myrow_tov["nomer_mod"]);} 	    
    }
 while ($myrow_tov = mysql_fetch_array($result_tov));			
		?>
	</select>
 </td>
    </tr>

  <tr bgcolor="#dce6ee">
    <td><p>Размер:</p></td>
  	<td><input name="razmer" type="text" value="<?php echo htmlspecialchars($myrow['razmer']) ?>"></td>
  </tr>
   <tr bgcolor="#ecf2f6">
    <td><p>Цвет:</p></td>
  	<td><input name="cvet" type="text" value="<?php echo htmlspecialchars($myrow['cvet']) ?>"></td>
  </tr>
   <tr bgcolor="#dce6ee">
    <td><p>Материал:</p></td>
  	<td><input name="material" type="text" value="<?php echo htmlspecialchars($myrow['material']) ?>"></td>
  </tr>

  <tr bgcolor="#ecf2f6">
  	<td><p>Дата покупки:</p></td>
  	<td><input name="data_pokupki" type="text" value="<?php echo $myrow['data_pokupki'] ?>"><input type="hidden" name="sec_data" value="<?php echo $myrow['sec_data'];?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Количество:</p></td>
  	<td><input name="kolichestvo" type="text" value="<?php echo $myrow['kolichestvo'] ?>"></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Стоимость:</p></td>
  	<td><input name="cena" type="text" value="<?php echo $myrow['stoimost'] ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Скидка:</p></td>
  	<td><input name="skidka" type="text" value="<?php echo $myrow['skidka'] ?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Причина возврата:</p></td>
  	<td><textarea name="prichina_vozv" cols="30" rows="1"><?php echo htmlspecialchars($myrow['prichina_vozvrata']) ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Период 14 дней:</p></td>
  	<td><select name="per14dn"><?php
  	if ($myrow['per_14_dney'] == 'Да') {printf('<option value="Да" selected="selected">Да</option><option value="Нет">Нет</option>');}
  	else {printf('<option value="Да">Да</option><option value="Нет" selected="selected">Нет</option>');}  	
  	 ?></select>
  	</td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Действие с возвратом:</p></td>
  	<td><input name="obmen" type="text" value="<?php echo htmlspecialchars($myrow['obmen_na']) ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Дальнейшее движение:</p></td>
  	<td><select name="daln_dvizhen"><?php
  	if ($myrow['daln_dvijenie'] == 'Не определено') {printf("<option selected=\"selected\" value=\"Не определено\">Не определено</option>");} else {printf("<option value=\"Не определено\">Не определено</option>");}
	if ($myrow['daln_dvijenie'] == 'Отправлен в ремонт') {printf("<option selected=\"selected\" value=\"Отправлен в ремонт\">Отправлен в ремонт</option>");} else {printf("<option value=\"Отправлен в ремонт\">Отправлен в ремонт</option>");}
	if ($myrow['daln_dvijenie'] == 'Поставлен на приход') {printf("<option selected=\"selected\" value=\"Поставлен на приход\">Поставлен на приход</option>");} else {printf("<option value=\"Поставлен на приход\">Поставлен на приход</option>");}
  	 ?></select></td>
    </tr>    
  <tr bgcolor="#ecf2f6">
	<td><p>Примечаниe:</p></td>
  	<td><textarea name="primechanie" cols="30" rows="1"><?php echo htmlspecialchars($myrow['primechanie']) ?></textarea></td>
    </tr>
  <?php 
  if (isset($_SESSION['admin_priv']) && ($_SESSION['admin_priv'] == 1)) {
  printf("<tr bgcolor=\"#dce6ee\"><td><p>Кто принял:</p></td><td><select name = 'kto_pvinyal'>");
  $res_usr = mysql_query("SELECT `login` FROM `users`",$db);
  $myr_usr = mysql_fetch_array($res_usr);
  do {
  	if ($myr_usr['login'] == $myrow['kto_pvinyal']) {printf ("<option selected='selected' value='%s'>%s</option>" , $myr_usr["login"], $myr_usr["login"]);}
  	else {printf ("<option value='%s'>%s</option>" , $myr_usr["login"], $myr_usr["login"]);}  	
  	} while ($myr_usr = mysql_fetch_array($res_usr));
  printf("<td></tr>");
  } else {
  	printf("<tr bgcolor=\"#dce6ee\"><td><p>Кто принял:</p></td><td><input type='text' name='kto_pvinyal' readonly value='%s'><td></tr>",$myrow['kto_pvinyal']);
  	} 
  ?>   
 </table>
 
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" type="submit" style="width:100px;" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" type="button" style="width:100px;" value="Отмена" onclick="top.location.href='../vozvratu.php'" ></td>
  </tr>
 </table>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
$(document).ready(function(){
         $("#magaz").change(function(){		 		
         $("#kateg").load("./get_kat_from_sklad.php", { mag: $("#magaz option:selected").val() },
         function (){
         	$("#brend").load("./get_br_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val() },
         	function () {
         $("#nomer_mod").load("./get_tov_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val(), bren: $("#brend option:selected").val() });	
         	}
         	);
         	});
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#kateg").change(function(){		 		
         $("#brend").load("./get_br_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val() },
         function () {
         $("#nomer_mod").load("./get_tov_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val(), bren: $("#brend option:selected").val() });	
         	}        
         );
         });
});
		 </script>
		 	 
<script type="text/javascript">
$(document).ready(function(){
         $("#brend").change(function(){		 		
         $("#nomer_mod").load("./get_tov_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val(), bren: $("#brend option:selected").val() });
         });
});
		 </script>


</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>