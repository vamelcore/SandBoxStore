<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_voz'] == 1)) {

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
<title>Редактор таблицы возвратов</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<script type="text/javascript">

function show(){
if (document.getElementById('dvozv_vozv').value == 'obmen')	{
 document.getElementById('hide_brend').style.display = '';
 document.getElementById('hide_mod').style.display = '';
 document.getElementById('hide_skidka').style.display = '';
 document.getElementById('hide_raz').style.display = '';
 document.getElementById('hide_cv').style.display = '';
 document.getElementById('hide_mat').style.display = '';
	}
else {
 document.getElementById('hide_brend').style.display = 'none';
 document.getElementById('hide_mod').style.display = 'none';
 document.getElementById('hide_skidka').style.display = 'none';
 document.getElementById('hide_raz').style.display = 'none';
 document.getElementById('hide_cv').style.display = 'none';
 document.getElementById('hide_mat').style.display = 'none';
	}
}
</script>

<style type="text/css">
   SELECT {width: 205px;}
   INPUT {width: 200px;}
   TEXTAREA {width: 200px;}
  </style>

</head>

<body onLoad="onLoad();">
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_vozvrat.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Добавить запись</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="200"><p>Дата приема:</p></td>
  	<td align="center"><p align="ceenter"><?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?></p><input name="data_priema" type="hidden" value="<?php $hours = date('H') + $_SESSION['time_zone']; echo date ('d.m.Y H:i:s', mktime ($hours)); ?>"></td>
    </tr>
    <tr bgcolor="#ecf2f6">
	<td><p>Магазин:</p></td>
  	<td>
  		<select name="magazine" id="mag_vozv">
  			
<?php
//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

$no = 0;	
do {
$no = $no +1;
	
if ($_POST['selector_of_stores'] == $_SESSION['id_mag'][$no])	{
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag'][$no];
	$_SESSION['magazin_selected'] = $_SESSION['name_mag'][$no];
	printf("<option value=\"%s\" selected=\"selected\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}	
else {
	
	printf("<option value=\"%s\">%s</option>",$_SESSION['id_mag'][$no],$_SESSION['name_mag'][$no]);
}
if ($_SESSION['id_mag'][$no+1] == 'all') {$no++;}		
}
while($no < $_SESSION['count_mag']);

 ?>
</select>
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>
  	<td>
  		<select name="kategory" id="kat_vozv"><option value="">Выберите категорию</option>
  			<?php
$result_kat = mysql_query("SELECT DISTINCT `kategoria` FROM `prodaja` WHERE `magazin` = '{$_SESSION['magazin_selected']}' AND `sec_data` NOT LIKE '%_rollback' ORDER BY `kategoria`",$db);  			
if (mysql_num_rows($result_kat) > 0)
{
  while ($myrow_kat = mysql_fetch_array($result_kat)){
  printf ("<option value='%s'>%s</option>" , $myrow_kat["kategoria"], $myrow_kat["kategoria"]);
	}		
}
?>
  		</select> 		
  	</td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td>
  		<select name="brend" id="bren_vozv"></select>
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td>
  		<select name="nomer_mod" id="mod_vozv"></select>
  	</td>
    </tr>

  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td>
  		<select name="razmer" id="raz_vozv"></select>
  	</td>
    </tr>
	
  <tr bgcolor="#dce6ee">
	<td><p>Цвет:</p></td>
  	<td>
  		<select name="cvet" id="cvet_vozv"></select>
  	</td>
    </tr>
	
  <tr bgcolor="#ecf2f6">
	<td><p>Материал:</p></td>
  	<td>
  		<select name="material" id="mater_vozv"></select>
  	</td>
    </tr>

  <tr bgcolor="#dce6ee">
  	<td><p>Дата покупки:</p></td>
  	<td>
  		<select name="data_pokupki" id="pokup_vozv"></select>
  	</td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Количество:</p></td>
  	<td id="kolich"><select name="kolichestvo" disabled="disabled"><option value="0">0 шт.</option></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Стоимость:</p></td>
  	<td id="stoim_vozv"><input type="text" name="cena" value=""></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Скидка:</p></td>
  	<td id="skid_vozv"><input type="text" name="skidka" value=""></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Причина возврата:</p></td>
  	<td><textarea name="prichina_vozv"></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td><p>Период 14 дней:</p></td>
  	<td><select name="per14dn"><option value="Да">Да</option><option value="Нет">Нет</option></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Действие с возвратом:</p></td>
  	<td>
  		<select name="dvozv" id="dvozv_vozv" onchange="show()"><option value="dengi">Возврат денег</option><option value="obmen">Обмен</option></select>
  	</td>
    </tr>   
    <tr id="hide_brend" style="display: none;" bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td>
  	<select name="obmen_brend" id="obmen_brend"><option value="">Выберите категорию</option></select>
  	</td>
    </tr> 
    <tr id="hide_mod" style="display: none;" bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td>
  		<select name="obmen_mod" id="obmen_mod"></select>
  	</td>
    </tr>
	
    <tr id="hide_raz" style="display: none;" bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td>
  		<select name="obmen_raz" id="obmen_raz"></select>
  	</td>
    </tr>
	
    <tr id="hide_cv" style="display: none;" bgcolor="#dce6ee">
	<td><p>Цвет:</p></td>
  	<td>
  		<select name="obmen_cv" id="obmen_cv"></select>
  	</td>
    </tr>
	
	
    <tr id="hide_mat" style="display: none;" bgcolor="#ecf2f6">
	<td><p>Материал:</p></td>
  	<td>
  		<select name="obmen_mat" id="obmen_mat"></select>
  	</td>
    </tr>

    <tr id="hide_obmen_id" style="display: none;" ><td></td><td id="tov_obmen_id"></td></tr>	
	 
  <tr id="hide_skidka" style="display: none;" bgcolor="#dce6ee">
	<td><p>Скидка:</p></td>
  	<td>
  		<input type="text" name="obmen_skidka" value="">
  	</td>
    </tr>           
  <tr bgcolor="#ecf2f6">
  	<td><p>Дальнейшее действие:</p></td>
  	<td><select name="daln_dvizhen"><option value="Не определено">Не определено</option><option value="Отправлен в ремонт">Отправлен в ремонт</option><option value="Поставлен на приход">Поставлен на приход</option></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Примечаниe:</p></td>
  	<td><textarea name="primechanie"></textarea></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Кто принял:</p></td>
  	<td><input type="text" name="kto_pvinyal" readonly="true" value="<?php echo $_SESSION['login'];?>"></td>
    </tr>   
 </table>
<div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../vozvratu.php'" ></td>
  </tr></table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
$(document).ready(function(){
         $("#mag_vozv").change(function(){		 		
         $("#kat_vozv").load("./get_kat_from_prodaja.php", { mag: $("#mag_vozv option:selected").val() },
         function (){
         	  onLoad();
         	});
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#kat_vozv").change(function(){		 		
         $("#bren_vozv").load("./get_br_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val() },
         function () {
             	 var getKategVal = document.getElementById('kat_vozv').value;
    	         if (getKategVal == '') {window.location = 'add_vozvrat.php';}
    	         else {onLoad();}	
         	});
         });
});
		 </script>
		 	 
<script type="text/javascript">
$(document).ready(function(){
         $("#bren_vozv").change(function(){		 		
         $("#mod_vozv").load("./get_naim_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val(), bren: $("#bren_vozv option:selected").val() },
         function () {
          	    onLoad();
          	 });
         });
});
		 </script>
		 		 
<script type="text/javascript">
$(document).ready(function(){
         $("#mod_vozv").change(function(){		 		
         $("#raz_vozv").load("./get_razm_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val(), bren: $("#bren_vozv option:selected").val(), mod: $("#mod_vozv option:selected").val() },
		 function () {
          	    onLoad();
          	 }
		 );
         });
});
		 </script>
		 
<script type="text/javascript">
$(document).ready(function(){
         $("#raz_vozv").change(function(){		 		
         $("#cvet_vozv").load("./get_cvet_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val(), bren: $("#bren_vozv option:selected").val(), mod: $("#mod_vozv option:selected").val(), raz: $("#raz_vozv option:selected").val() },
		 function () {
          	    onLoad();
          	 }
		 );
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#cvet_vozv").change(function(){		 		
         $("#mater_vozv").load("./get_mat_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val(), bren: $("#bren_vozv option:selected").val(), mod: $("#mod_vozv option:selected").val(), raz: $("#raz_vozv option:selected").val(), cvet: $("#cvet_vozv option:selected").val() },
		 function () {
          	    onLoad();
          	 }
		 );
         });
});
		 </script>		 
		 
<script type="text/javascript">
$(document).ready(function(){
         $("#mater_vozv").change(function(){		 		
         $("#pokup_vozv").load("./get_pokup_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val(), bren: $("#bren_vozv option:selected").val(), mod: $("#mod_vozv option:selected").val(), raz: $("#raz_vozv option:selected").val(), cvet: $("#cvet_vozv option:selected").val(), mat: $("#mater_vozv option:selected").val() },
		 function () {
          	    onLoad();
          	 }
		 );
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#pokup_vozv").change(function(){		 		
         $("#stoim_vozv").load("./get_summa_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val(), bren: $("#bren_vozv option:selected").val(), mod: $("#mod_vozv option:selected").val(), pokup: $("#pokup_vozv option:selected").val() },
		 function(){
		 $("#skid_vozv").load("./get_skid_from_prodaja.php", { kat: $("#kat_vozv option:selected").val(), mag: $("#mag_vozv option:selected").val(), bren: $("#bren_vozv option:selected").val(), mod: $("#mod_vozv option:selected").val(), pokup: $("#pokup_vozv option:selected").val() },
		 function (){
		 $("#kolich").load("./get_kol_from_prodaja.php", { kolichestvo: $("#kolichestvo").val() },
		 function (){
		       onLoad();
			  
		 }); 	    
         });
		 });         
         });
});
		 </script>


<script type="text/javascript">
$(document).ready(function(){
  $("#kolich").change(function(){
  var summa_kol = +document.getElementById('summa_all').value;
  var skidka_kol = +document.getElementById('skidka_all').value;
  var kol = +document.getElementById('kolichestvo').value;
  var kol_dyn = +document.getElementById('kolich_vozv').value;
 
  document.getElementById('cena_kol').value = (summa_kol/kol)*kol_dyn;
  document.getElementById('skidka_kol').value = (skidka_kol/kol)*kol_dyn;     
  });
});
</script>


<script type="text/javascript">
function onLoad(){
var getKategVal = document.getElementById('kat_vozv').value;	 		
var getBrendVal = document.getElementById('bren_vozv').value;        
var getTovarVal = document.getElementById('mod_vozv').value;
var getRazmVal = document.getElementById('raz_vozv').value;	 		
var getCvetVal = document.getElementById('cvet_vozv').value;        
var getMaterVal = document.getElementById('mater_vozv').value;
var getDataVal = document.getElementById('pokup_vozv').value;
		
if ((getTovarVal != '') && (getBrendVal != '') && (getKategVal != '') && (getRazmVal != '') && (getCvetVal != '') && (getMaterVal != '') && (getDataVal != '')) {$("input[type=submit]").removeAttr("disabled");}
else {$("input[type=submit]").attr("disabled", "disabled");}	    
}

		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#kat_vozv").change(function(){
         $("#obmen_brend").load("./get_obmen_from_sklad_brendu.php", { mag: $("#mag_vozv option:selected").val(), kat: $("#kat_vozv option:selected").val(), kolich: $("#kolich_vozv option:selected").val() });
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#obmen_brend").change(function(){
         $("#obmen_mod").load("./get_obmen_from_sklad_tovaru.php", { mag: $("#mag_vozv option:selected").val(), kat: $("#kat_vozv option:selected").val(), brend: $("#obmen_brend option:selected").val(), kolich: $("#kolich_vozv option:selected").val() });
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#obmen_mod").change(function(){
         $("#obmen_raz").load("./get_raz_for_prodaja.php", { nom: $("#obmen_mod option:selected").val() });
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#obmen_raz").change(function(){
         $("#obmen_cv").load("./get_cvet_for_prodaja.php", { nom: $("#obmen_mod option:selected").val(), raz: $("#obmen_raz option:selected").val() });
         });
});
		 </script>
		 
<script type="text/javascript">
$(document).ready(function(){
         $("#obmen_cv").change(function(){
         $("#obmen_mat").load("./get_mat_for_prodaja.php", { nom: $("#obmen_mod option:selected").val(), raz: $("#obmen_raz option:selected").val(), cvet: $("#obmen_cv option:selected").val() });
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function(){
         $("#obmen_mat").change(function(){		 		       
		 $("#tov_obmen_id").load("./get_tov_for_prodaja.php", { nom: $("#obmen_mod option:selected").val(), raz: $("#obmen_raz option:selected").val(), cvet: $("#obmen_cv option:selected").val(), mat: $("#obmen_mat option:selected").val(), tov_kat: 'tov_id' });		 
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