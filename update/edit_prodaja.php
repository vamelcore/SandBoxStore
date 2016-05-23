<?php include ("../config.php"); include ("functions.php");

header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['ed_priv_pro'] == 1)) {

 if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id']; $_SESSION['id_prodaja'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM prodaja WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактор таблицы продаж</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<style type="text/css">
   SELECT {width: 205px;}
   INPUT {width: 200px;}
   TEXTAREA {width: 200px;}
  </style>
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_prodaja.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактировать продажу</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="200"><p>Дата:</p></td>
  	<td><input name="data" type="text" value="<?php echo $myrow['data'] ?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
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
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>	
	<td>
		<select name="kategory" id="kateg">
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
<tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
	<td><select name="brend" id="brend">
		<?php 
$result_br = mysql_query("SELECT `ID`, `brend` FROM `sklad_brendu` WHERE `ID_kategorii` = '$kategor'",$db);
$myrow_br = mysql_fetch_array($result_br);

 do {
 	if ($myrow_br['brend'] == $myrow['brend']) {printf ("<option selected=\"selected\" value='%s'>%s</option>" , $myrow_br["ID"], $myrow_br["brend"]); $brenda = $myrow_br["ID"];}
	else {printf ("<option value='%s'>%s</option>" , $myrow_br["ID"], $myrow_br["brend"]);} 	    
    }
 while ($myrow_br = mysql_fetch_array($result_br));			
		?>
	</select></td>
    </tr>       
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
	<td><select name="nomer_mod" id="nomer_mod">
		<?php 
$result_tov = mysql_query("SELECT `ID`, `nomer_mod` FROM `prase` WHERE `ID_kategorii` = '$kategor' AND `ID_brenda` = '$brenda'",$db);
$myrow_tov = mysql_fetch_array($result_tov);

 do {
 	if ($myrow_tov['nomer_mod'] == $myrow['nomer_mod']) {printf ("<option selected=\"selected\" value='%s'>%s</option>" , $myrow_tov["nomer_mod"], $myrow_tov["nomer_mod"]);}
	else {printf ("<option value='%s'>%s</option>" , $myrow_tov["nomer_mod"], $myrow_tov["nomer_mod"]);} 	    
    }
 while ($myrow_tov = mysql_fetch_array($result_tov));			
		?>
	</select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td id="razmer"><input name="razmer" type="text" value="<?php echo htmlspecialchars($myrow['razmer']) ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Цвет:</p></td>
  	<td id="cvet"><input name="cvet" type="text" value="<?php echo htmlspecialchars($myrow['cvet']) ?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Материал:</p></td>
  	<td id="mater"><input name="mater" type="text" value="<?php echo htmlspecialchars($myrow['material']) ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Цена, грн:</p></td>
  	<td id="cena_edit"><input name="cena" type="text" value="<?php echo $myrow['cena'] ?>"></td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Вознаграждение, грн:</p></td>
  	<td id="voznag_edit"><input name="voznag" type="text" value="<?php echo $myrow['voznag'] ?>"></td>
    </tr>
    <tr bgcolor="#dce6ee">
	<td><p>Процент:</p></td>
  	<td><input name="procent" type="text" value="<?php echo $myrow['procent'] ?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО:</p></td>
  	<td><input name="fio" type="text" value="<?php echo htmlspecialchars($myrow['FIO']) ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Контактный номер телефона:</p></td>
  	<td><input name="kontakt_nom_tel" type="text" value="<?php echo $myrow['kontakt_nomer_tel'] ?>"></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Скидка:</p></td>
  	<td><input name="skidka" type="text" value="<?php echo $myrow['skidka'] ?>"></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Примечание:</p></td>
  	<td><input name="primech" type="text" value="<?php echo htmlspecialchars($myrow['add']) ?>"></td>
    </tr>    
  <?php 
  if (isset($_SESSION['admin_priv']) && ($_SESSION['admin_priv'] == 1)) {
  printf("<tr bgcolor=\"#ecf2f6\"><td><p>Продавец:</p></td><td><select name = 'user'>");
  $res_usr = mysql_query("SELECT `ID`, `login` FROM `users`",$db);
  $myr_usr = mysql_fetch_array($res_usr);
  do {
  	if ($myr_usr['login'] == $myrow['user']) {printf ("<option selected='selected' value='%s'>%s</option>" , $myr_usr["ID"], $myr_usr["login"]);}
  	else {printf ("<option value='%s'>%s</option>" , $myr_usr["ID"], $myr_usr["login"]);}  	
  	} while ($myr_usr = mysql_fetch_array($res_usr));
  printf("<td></tr>");
  } else {
  	printf("<input type='hidden' name='user' value='%s'>",$_SESSION['user_id']);
  	} 
  ?>   
 </table>
 
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="save" style="width:100px;" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px;" type="button" value="Отмена" onclick="top.location.href='../prodaja.php'" ></td>
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

<!--<script type="text/javascript">
$(document).ready(function(){
         $("#nomer_mod").change(function(){		 		
         $("#razmer").load("./get_tov_for_prodaja.php", { tov: $("#nomer_mod option:selected").val(), tov_kat: 'razmer' });
         $("#cvet").load("./get_tov_for_prodaja.php", { tov: $("#nomer_mod option:selected").val(), tov_kat: 'cvet' });
         $("#mater").load("./get_tov_for_prodaja.php", { tov: $("#nomer_mod option:selected").val(), tov_kat: 'mater' });
         $("#cena_edit").load("./get_tov_for_prodaja.php", { tov: $("#nomer_mod option:selected").val(), tov_kat: 'cena_edit' });
         $("#voznag_edit").load("./get_tov_for_prodaja.php", { tov: $("#nomer_mod option:selected").val(), tov_kat: 'voznag_edit' });
         });
});
		 </script>-->

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>