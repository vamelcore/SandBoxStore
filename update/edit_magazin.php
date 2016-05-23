<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['root_priv'] == 1)) {

 if (isset($_GET['id'])) {$id = $_GET['id']; $_SESSION['id_edit_magazina'] = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM magazinu WHERE ID='$id'",$db);
$myrow = mysql_fetch_array($result);

$priv_aed = $myrow['tab_show'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Редактирование записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_magazine.php" method="post">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Редактирование записи</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee" height="20">
  	<td width="200"><p>Имя магазина:</p></td>
  	<td width="200"><p><?php echo $myrow['name'];?></p></td>
    </tr> 
  <tr bgcolor="#ecf2f6" height="20">
	<td><p>Таблица "Возвраты":</p></td>
  	<td> 	
  	<?php if ($priv_aed[0]==1) {printf("<input type=\"checkbox\" name=\"vozvrat\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"vozvrat\">");};?> 	
  	</td>
    </tr>  
  <tr bgcolor="#dce6ee" height="20">
	<td><p>Первый продавец в магазине:</p></td>
  	<td> 	
  	<?php if ($myrow['perv_prod']==1) {printf("<input type=\"checkbox\" name=\"perv_prod\" value=\"1\" checked>");} else {printf("<input type=\"checkbox\" name=\"perv_prod\">");};?> 	
  	</td>
    </tr>
  <tr bgcolor="#ecf2f6" height="20">
	<td><p>Наличие терминала в магазине:</p></td>
  	<td><select name='terminal' style="width:200px"> 	
  	<?php if ($myrow['terminal']=='k') {printf("<option selected='selected' value='k'>Касса магазина по умолчанию</option>");} else {printf("<option value='k'>Касса магазина по умолчанию</option>");}
	      if ($myrow['terminal']=='t') {printf("<option selected='selected' value='t'>Банковский счет по умолчанию</option>");} else {printf("<option value='t'>Банковский счет по умолчанию</option>");}
          if ($myrow['terminal']=='no') {printf("<option selected='selected' value='no'>Нет</option>");} else {printf("<option value='no'>Нет</option>");}
	?> 	
  	</select></td>
    </tr>  
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="edit" type="submit" value="Сохранить" style="width:100px;"></td>
    <td width="200" align="center"><input name="cansel" type="button" value="Отмена" onclick="top.location.href='../magazinu.php'" style="width:100px;"></td>
  </tr>
 	</table>

 </form>
 
 </td></tr></table>
 
</div>

</body>
</html>

<?php
}
else {

header("Location: ../index.php");
die();
}
 ?>