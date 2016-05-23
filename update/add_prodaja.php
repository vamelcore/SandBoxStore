<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_pro'] == 1)) {

if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {
				if ($_SESSION['id_mag_selected'] == 'all') {$_POST['selector_of_stores'] =$_SESSION['id_mag']['1'];}
				else {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
			}
		
	}


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

<body onload='onLoad()'>
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_prodaja.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Добавить продажу</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="200"><p>Дата:</p></td>
  	<td align="center"><p align="ceenter"><?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?></p><input name="data" type="hidden" value="<?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?>"><input name="prnt_id" type="hidden" value="<?php if (isset($_GET['prnt_id'])) {echo $_GET['prnt_id'];} ?>"><p id="tov_id"><p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Магазин:</p></td>
  	<td>
 <select name="magazine" id="magaz"> 			
<?php
if ((isset($_GET['prnt_id'])) && ($_GET['prnt_id'] <> '')) {printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_magaz'],$_SESSION['name_magaz']); unset($_SESSION['id_magaz']); unset($_SESSION['name_magaz']);}
else {

//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 0;	
do {
$no = $no+1;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}
if ($_SESSION['id_mag'][$no+1] == 'all') {$no++;}		
}
while($no < $_SESSION['count_mag']);
}
 ?>
</select>
  	</td>
    </tr>          
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>
  	<td>
  		<select name="kategory" id="kateg"><option value="">Выберите категорию</option>
  			<?php 
			
$result_kat = mysql_query("SELECT `ID`,`kateg` FROM `sklad_kategorii` WHERE `ID` IN ( SELECT DISTINCT `ID_kategorii` FROM `sklad_tovaru` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' ) ORDER BY `kateg`",$db);	

while ($myrow_kat = mysql_fetch_array($result_kat)) {
	
	 printf ("<option value='%s'>%s</option>" , $myrow_kat["ID"], $myrow_kat["kateg"]);
	
	}
  			?>
  		</select>
  	</td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td><select name="brend" id="brend"></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td><select name="nomer_mod" id="nomer_mod"></select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td><select name="razmer" id="razmer"></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Цвет:</p></td>
  	<td><select name="cvet" id="cvet"></select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Материал:</p></td>
  	<td><select name="mater" id="mater"></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Количество:</p></td>
  	<td id="kolich"><select name="kolich" disabled="disabled"><option value="0">0 шт.</option></select></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td height="20"><p>Цена, грн:</p></td>
  	<td id="cena"></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td height="20"><p>Вознаграждение, грн:</p></td>
  	<td id="voznag"></td>
    </tr>	
  <tr id="not_singl_c" style="display: none;" bgcolor="#ecf2f6">
	<td height="20"><p>Сумма с учетом колич., грн:</p></td>
  	<td><input id="new_cena" readonly="readonly" value=""></td>
    </tr>
  <tr id="not_singl_v" style="display: none;" bgcolor="#dce6ee">
  	<td height="20"><p>Вознаг. с учетом колич., грн:</p></td>
  	<td><input id="new_voznag" readonly="readonly" value=""></td>
    </tr>		
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО покупателя:</p></td>
  	<td><input type="text" name="fio" value="<?php if (isset($_SESSION['pokupfio'])) {echo $_SESSION['pokupfio']; unset($_SESSION['pokupfio']);}?>"></td>
    </tr> 
  <tr bgcolor="#dce6ee">
	<td><p>Контактный номер телефона:</p></td>
  	<td><input type="text" name="kontakt_nom_tel" value="<?php if (isset($_SESSION['kontakt_nom_tel'])) {echo $_SESSION['kontakt_nom_tel']; unset($_SESSION['kontakt_nom_tel']);}?>"></td>
    </tr>  
  <tr bgcolor="#ecf2f6">
	<td><p id="skidka_header">Скидка, грн:</p></td>
  	<td><input type="text" name="skidka" value=""></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Примечание:</p></td>
  	<td><textarea cols="30" rows="1" name="primech" value=""></textarea>
  	</td>
    </tr>

  <?php 
  if (isset($_SESSION['admin_priv']) && ($_SESSION['admin_priv'] == 1)) {
  printf("<tr bgcolor=\"#ecf2f6\"><td><p>Продавец:</p></td><td><select name = 'user'>");
  $res_usr = mysql_query("SELECT `ID`, `login` FROM `users`",$db);
  $myr_usr = mysql_fetch_array($res_usr);
  do {
  	if ($myr_usr['login'] == $_SESSION['login']) {printf ("<option selected='selected' value='%s'>%s</option>" , $myr_usr["ID"], $myr_usr["login"]);}
  	else {printf ("<option value='%s'>%s</option>" , $myr_usr["ID"], $myr_usr["login"]);}  	
  	} while ($myr_usr = mysql_fetch_array($res_usr));
  printf("<td></tr>");
  } else {
  	printf("<input type='hidden' name='user' value='%s'>",$_SESSION['user_id']);
  	} 

  $res_check_beznal = mysql_query("SELECT `terminal` FROM `magazinu` WHERE `ID` = '{$_SESSION['id_mag_selected']}'",$db);
  $myr_check_beznal = mysql_fetch_array($res_check_beznal);
  if ($myr_check_beznal['terminal'] <> 'no') {
  printf("<tr bgcolor=\"#dce6ee\"><td><p>Способ оплаты:</p></td><td><select name= 'sposob_oplatu'>");
  if ($myr_check_beznal['terminal'] == 'k') {printf("<option selected='selected' value='k'>Оплата наличкой</option>");} else {printf("<option value='k'>Оплата наличкой</option>");}
  if ($myr_check_beznal['terminal'] == 't') {printf("<option selected='selected' value='t'>Безналичный расчет</option>");} else {printf("<option value='t'>Безналичный расчет</option>");}
  printf("</td></tr>"); 
  }
  ?>

 </table>
<div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="100" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="100" align="center"><input style="width:100px;" name="save_add" type="submit" value="Добавить еще" ></td>
    <td width="100" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../prodaja.php'" ></td>
  </tr></table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
$(document).ready(function(){
         $("#magaz").change(function(){		 		
         $("#kateg").load("./get_kat_from_sklad.php", { mag: $("#magaz option:selected").val() },
		 function () {
    	         onLoad();
    	         }
		 );
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#kateg").change(function(){		 		
         $("#brend").load("./get_br_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val() },
         function () {
    	         var getKategVal = document.getElementById('kateg').value;
    	         if (getKategVal == '') {window.location = 'add_prodaja.php';}
    	         else {onLoad();}		 
		 }        
         );
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#brend").change(function(){		 		
         $("#nomer_mod").load("./get_tov_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val(), bren: $("#brend option:selected").val() },
		 function () {
    	         onLoad();
    	         }		 
		 );
         });
});
		 </script>
		 
<script type="text/javascript">
$(document).ready(function(){
         $("#nomer_mod").change(function(){		 		
         $("#razmer").load("./get_raz_for_prodaja.php", { nom: $("#nomer_mod option:selected").val() },
		 function () {
    	         onLoad();
    	         }		 
		 );
         });
});
		 </script>
		 	 
<script type="text/javascript">
$(document).ready(function(){
         $("#razmer").change(function(){		 		
         $("#cvet").load("./get_cvet_for_prodaja.php", { nom: $("#nomer_mod option:selected").val(), raz: $("#razmer option:selected").val() },
		 function () {
    	         onLoad();
    	         }		 
		 );
         });
});
		 </script> 
		 
<script type="text/javascript">
$(document).ready(function(){
         $("#cvet").change(function(){		 		
         $("#mater").load("./get_mat_for_prodaja.php", { nom: $("#nomer_mod option:selected").val(), raz: $("#razmer option:selected").val(), cvet: $("#cvet option:selected").val() },
		 function () {
    	         onLoad();
    	         }		 
		 );
         });
});
		 </script> 

<script type="text/javascript">
$(document).ready(function(){
         $("#mater").change(function(){		 		
         $("#cena").load("./get_tov_for_prodaja.php", { nom: $("#nomer_mod option:selected").val(), raz: $("#razmer option:selected").val(), cvet: $("#cvet option:selected").val(), mat: $("#mater option:selected").val(), tov_kat: 'cena', mag: $("#magaz option:selected").val() },
		 function() {
		 $("#voznag").load("./get_tov_for_prodaja.php", { nom: $("#nomer_mod option:selected").val(), raz: $("#razmer option:selected").val(), cvet: $("#cvet option:selected").val(), mat: $("#mater option:selected").val(), tov_kat: 'voznag', mag: $("#magaz option:selected").val() },
		 function(){
		 $("#tov_id").load("./get_tov_for_prodaja.php", { nom: $("#nomer_mod option:selected").val(), raz: $("#razmer option:selected").val(), cvet: $("#cvet option:selected").val(), mat: $("#mater option:selected").val(), tov_kat: 'tov_id' },
		 function () {		 
		 $("#kolich").load("./get_kol_from_sklad.php", { kat: $("#kateg option:selected").val(), mag: $("#magaz option:selected").val(), bren: $("#brend option:selected").val(), tovar: $("#ident_tovar").val() },
		 function () {
		 onLoad();

		 });		 
    	 });		 
		 });
		 });         
         });
});
		 </script> 

<script type="text/javascript">
$(document).ready(function(){
  $("#kolich").change(function(){
  var cena_kol = +document.getElementById('index_cena').value;
  if (!isNumber(cena_kol)) {cena_kol = 0;}
  var voznag_kol = +document.getElementById('index_voznag').value;
  if (!isNumber(voznag_kol)) {voznag_kol = 0;}
  var kol = +document.getElementById('index_kolich').value;
  document.getElementById('new_cena').value = cena_kol*kol;
  document.getElementById('new_voznag').value = voznag_kol*kol;
  
  var result_style_c = document.getElementById('not_singl_c').style;
  var result_style_v = document.getElementById('not_singl_v').style;
  if (kol > 1) {result_style_c.display = 'table-row'; result_style_v.display = 'table-row'; document.getElementById('skidka_header').innerHTML = 'Скидка на единицу товара, грн:';}
  else {result_style_c.display = 'none'; result_style_v.display = 'none'; document.getElementById('skidka_header').innerHTML = 'Скидка, грн:';} 
   
  });
});

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
</script>
		 
<script type="text/javascript">
function onLoad(){
var getKategVal = document.getElementById('kateg').value;	 		
var getBrendVal = document.getElementById('brend').value;        
var getTovarVal = document.getElementById('nomer_mod').value;
var getRazmVal = document.getElementById('razmer').value;	 		
var getCvetVal = document.getElementById('cvet').value;        
var getMaterVal = document.getElementById('mater').value;
		
if ((getTovarVal != '') && (getBrendVal != '') && (getKategVal != '') && (getRazmVal != '') && (getCvetVal != '') && (getMaterVal != '')) {$("input[type=submit]").removeAttr("disabled");}
else {$("input[type=submit]").attr("disabled", "disabled");}	    
}

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