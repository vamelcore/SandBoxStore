<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_ost'] == 1)) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {
				if ($_SESSION['id_mag_selected'] == 'all') {$_POST['selector_of_stores'] =$_SESSION['id_mag']['1'];}
				else {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}
			}
		
	}


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

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Добавить в остатки</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>

<style type="text/css">
   SELECT {width: 210px;}
   INPUT {width: 205px;}
  </style>

</head>

<body onload='onLoad()'>
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_sklad.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Добавить товар на Остатки</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Магазин:</p></td>
  	<td>
  		<select name="magazine">
  			
<?php
//if ($_SESSION['count_flag'] == true) {$i='1';} else {$i='0';}

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
if ($_SESSION['id_mag'][$no+1] == 'all') {$no++;}		
}
while($no < $_SESSION['count_mag']);

 ?>

		</select>
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Категория товара:</p></td>
  	<td>  		
  	<select name="sklad_kat" id="skladkat" style="width:210px"><option value="">Выберите категорию</option><?php 

for ($no=0; $no<$index_kat; $no++) {
if ($myarray_kateg['ID'][$no] == $_SESSION['sklad_add_kat']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_kateg['ID'][$no],$myarray_kateg['kateg'][$no]);}
}

?></select>	
  		
  	</td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td>
  	<select name="sklad_br" id="skladbr" style="width:210px"><?php
if (isset($_SESSION['sklad_add_br'])) {
for ($no=0; $no<$index_br; $no++) {
if ($myarray_brend['ID_kategorii'][$no] == $_SESSION['sklad_add_kat']) {
if ($myarray_brend['ID'][$no] == $_SESSION['sklad_add_br']) {printf ("<option value=\"%s\" selected=\"selected\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
else {printf ("<option value=\"%s\">%s</option>",$myarray_brend['ID'][$no],$myarray_brend['brend'][$no]);}
}
}
}
?></select>  	
  	
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td>
   <select name="tovar" id="tov"> <?php 
if (isset($_SESSION['sklad_add_br']) && isset($_SESSION['sklad_add_kat'])) {
$res_nomer_tov = mysql_query("SELECT DISTINCT `nomer_mod` FROM `prase` WHERE `ID_kategorii`='{$_SESSION['sklad_add_kat']}' AND `ID_brenda`='{$_SESSION['sklad_add_br']}' ORDER BY `nomer_mod` ASC", $db);	
while ($myr_nomer_tov = mysql_fetch_array($res_nomer_tov)) {
if ($myr_nomer_tov["nomer_mod"] == $_SESSION['sklad_add_mod']) {printf (" <option value='%s' selected=\"selected\">%s</option>" , $myr_nomer_tov["nomer_mod"], $myr_nomer_tov["nomer_mod"]);}
  else {printf (" <option value='%s'>%s</option>" , $myr_nomer_tov["nomer_mod"], $myr_nomer_tov["nomer_mod"]);}
  }	
}
?></select></td>

  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td>
   <select name="razmer" id="raz"> <?php 
if (isset($_SESSION['sklad_add_br']) && isset($_SESSION['sklad_add_kat']) && isset($_SESSION['sklad_add_mod'])) {
$res_nomer_raz = mysql_query("SELECT DISTINCT `razmer` FROM `prase` WHERE `ID_kategorii`='{$_SESSION['sklad_add_kat']}' AND `ID_brenda`='{$_SESSION['sklad_add_br']}' AND `nomer_mod` = '{$_SESSION['sklad_add_mod']}' ORDER BY `razmer` ASC", $db);	
 while ($myr_nomer_raz = mysql_fetch_array($res_nomer_raz)) {
 	if ($myr_nomer_raz["razmer"] == $_SESSION['sklad_add_razmer']) {printf (" <option value='%s' selected=\"selected\">%s</option>" , $myr_nomer_raz["razmer"], $myr_nomer_raz["razmer"]);}
  else {printf (" <option value='%s'>%s</option>" , $myr_nomer_raz["razmer"], $myr_nomer_raz["razmer"]);}   
    }	
	}
?></select></td>

    </tr>
    
<tr bgcolor="#dce6ee">
	<td><p>Цвет:</p></td>
  	<td>
   <select name="cvet" id="cv"> <?php 
if (isset($_SESSION['sklad_add_br']) && isset($_SESSION['sklad_add_kat']) && isset($_SESSION['sklad_add_mod']) && isset($_SESSION['sklad_add_razmer'])) {
$res_nomer_cv = mysql_query("SELECT DISTINCT `cvet` FROM `prase` WHERE `ID_kategorii`='{$_SESSION['sklad_add_kat']}' AND `ID_brenda`='{$_SESSION['sklad_add_br']}' AND `nomer_mod` = '{$_SESSION['sklad_add_mod']}' AND `razmer` = '{$_SESSION['sklad_add_razmer']}' ORDER BY `cvet`", $db);	
 while ($myr_nomer_cv = mysql_fetch_array($res_nomer_cv)) {
 	if ($myr_nomer_cv['cvet'] == $_SESSION['sklad_add_cvet']) {printf (" <option value='%s' selected=\"selected\">%s</option>" , $myr_nomer_cv["cvet"], $myr_nomer_cv["cvet"]);}
 	else {printf (" <option value='%s'>%s</option>" , $myr_nomer_cv["cvet"], $myr_nomer_cv["cvet"]);}     
    }	
	}
?></select></td>

    </tr>
    
<tr bgcolor="#ecf2f6">
	<td><p>Материал:</p></td>
  	<td>
   <select name="mater" id="mat"> <?php 
if (isset($_SESSION['sklad_add_br']) && isset($_SESSION['sklad_add_kat']) && isset($_SESSION['sklad_add_mod']) && isset($_SESSION['sklad_add_razmer']) && isset($_SESSION['sklad_add_cvet'])) {
$res_nomer_mat = mysql_query("SELECT DISTINCT `material` FROM `prase` WHERE `ID_kategorii`='{$_SESSION['sklad_add_kat']}' AND `ID_brenda`='{$_SESSION['sklad_add_br']}' AND `nomer_mod` = '{$_SESSION['sklad_add_mod']}' AND `razmer` = '{$_SESSION['sklad_add_razmer']}' AND `cvet` = '{$_SESSION['sklad_add_cvet']}' ORDER BY `material`", $db);	
 while ($myr_nomer_mat = mysql_fetch_array($res_nomer_mat)) {
 	 if ($myr_nomer_mat['material'] == $_SESSION['sklad_add_mater']){printf (" <option value='%s' selected=\"selected\">%s</option>" , $myr_nomer_mat["material"], $myr_nomer_mat["material"]);}
 	 else {printf (" <option value='%s'>%s</option>" , $myr_nomer_mat["material"], $myr_nomer_mat["material"]);}     
    }	
	}
?></select></td>

    </tr>    
        
    
<tr bgcolor="#dce6ee">
	<td><p>Количество, шт:</p></td>
  	<td><input type="text" name="kolichestvo" id="kolich" onkeyup="onLoad();" onclick="onLoad();" onchange="onLoad();"></td>
    </tr>
 
 </table>
 <div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Сохранить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ></td>
  </tr></table></div>
 
 </form>
 
 </td></tr></table>
 
</div>

<script type="text/javascript">
$(document).ready(function () {
         $("#skladkat").change(function(){		 		
         $("#skladbr").load("./get_brend_for_add_skl.php", { kateg: $("#skladkat option:selected").val() },
             function () {
    	         var getKategVal = document.getElementById('skladkat').value;
    	         if (getKategVal == '') {window.location = 'add_sklad.php';}
    	         else {onLoad();}
    	         }                  
         );        
         });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
         $("#skladbr").change(function(){		 		
         $("#tov").load("./get_mod_for_add_skl.php", { kateg: $("#skladkat option:selected").val(), brend: $("#skladbr option:selected").val() },
             function () {
    	         onLoad();
    	         }
          );       
         });
});
		 </script>

<script type="text/javascript">
$(document).ready(function () {
         $("#tov").change(function(){
         $("#raz").load("./get_razmer_for_add_skl.php", { kateg: $("#skladkat option:selected").val(), brend: $("#skladbr option:selected").val(), mod: $("#tov option:selected").val() }, 
             function () {onLoad();} );    	                            
         });
});
</script>


<script type="text/javascript">
$(document).ready(function () {
         $("#raz").change(function(){
         $("#cv").load("./get_cvet_for_add_skl.php", { kateg: $("#skladkat option:selected").val(), brend: $("#skladbr option:selected").val(), mod: $("#tov option:selected").val(), razm: $("#raz option:selected").val() }, 
         function () {onLoad();} );    	                            
         });
});
</script>

<script type="text/javascript">
$(document).ready(function () {
         $("#cv").change(function(){
         $("#mat").load("./get_mater_for_add_skl.php", { kateg: $("#skladkat option:selected").val(), brend: $("#skladbr option:selected").val(), mod: $("#tov option:selected").val(), razm: $("#raz option:selected").val(), cvet: $("#cv option:selected").val() }, 
         function () {onLoad();} );    	                            
         });
});
</script>

<script type="text/javascript">
function onLoad(){
var getKategVal = document.getElementById('skladkat').value;	 		
var getBrendVal = document.getElementById('skladbr').value;        
var getTovarVal = document.getElementById('tov').value;
var getRazmVal = document.getElementById('raz').value;	 		
var getCvetVal = document.getElementById('cv').value;        
var getMaterVal = document.getElementById('mat').value;
var getTovarKol = document.getElementById('kolich').value;		
if ((getTovarVal != '') && (getBrendVal != '') && (getKategVal != '') && (getTovarKol != '') && (getRazmVal != '') && (getCvetVal != '') && (getMaterVal != '')) {$("input[type=submit]").removeAttr("disabled");}
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