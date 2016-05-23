<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['admin_priv'] == 1)) {

 if (isset($_GET['id'])) {$id = $_GET['id']; $_SESSION['id_prase'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM prase WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактирование записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<style type="text/css">
   SELECT {width: 205px;}
   TEXTAREA {width: 200px;}
  </style>
</head>

<body>
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_prase.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200"><p>Категория:</p></td>
  	<td align="center"><select name="kateg" id="kateg"><?php 
$res_kat =mysql_query("SELECT `ID`,`kateg` FROM `sklad_kategorii` ORDER BY `kateg`",$db);
while ($myr_kat = mysql_fetch_array($res_kat)) {
if ($myr_kat['ID'] ==  $myrow['ID_kategorii']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);
} else {
	printf("<option value=\"%s\">%s</option>",$myr_kat['ID'],$myr_kat['kateg']);
}	
}
?></select></td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Бренд:</p></td>
  	<td><select name="brend" id="brend"><?php
$res_br =mysql_query("SELECT `ID`,`brend` FROM sklad_brendu WHERE ID_kategorii = '{$myrow['ID_kategorii']}' ORDER BY `brend`",$db);
while ($myr_br = mysql_fetch_array($res_br)) {
if ($myr_br['ID'] ==  $myrow['ID_brenda']) {
	printf("<option selected=\"selected\" value=\"%s\">%s</option>",$myr_br['ID'],$myr_br['brend']);
} else {
	printf("<option value=\"%s\">%s</option>",$myr_br['ID'],$myr_br['brend']);
}	
}
?></select></td>
  </tr>  
  <tr bgcolor="#ecf2f6">
	<td><p>Номер модели:</p></td>
  	<td><textarea name="nomer_mod" cols="30" rows="1"><?php echo $myrow['nomer_mod'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Размер:</p></td>
  	<td><textarea name="razmer" cols="30" rows="1"><?php echo $myrow['razmer'] ?></textarea></td>
    </tr>  
  <tr bgcolor="#ecf2f6">
	<td><p>Цвет:</p></td>
  	<td><textarea name="cvet" cols="30" rows="1"><?php echo $myrow['cvet'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Материал:</p></td>
  	<td><textarea name="material" cols="30" rows="1"><?php echo $myrow['material'] ?></textarea></td>
    </tr>  
  <tr bgcolor="#ecf2f6">
	<td><p>Цена:</p></td>
  	<td><textarea name="cena" cols="30" rows="1"><?php echo $myrow['cena'] ?></textarea></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Вознаграждение:</p></td>
  	<td><textarea name="voznag" cols="30" rows="1"><?php echo $myrow['voznag'] ?></textarea></td>
    </tr>
  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="edit" type="submit" value="Сохранить" style="width:100px"></td>
    <td width="200" align="center"><input name="cansel" type="button" value="Отмена" onclick="top.location.href='../prase.php'" style="width:100px"></td>
  </tr>
 	</table>
 
 
 </form>
 
 </td></tr></table>
 
</div>


<script type="text/javascript">
$(document).ready(function () {
         $("#kateg").change(function(){		 		
         $("#brend").load("./get_brend_for_edit_tov.php", { kateg: $("#kateg option:selected").val() });        
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