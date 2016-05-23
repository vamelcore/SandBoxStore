<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

$result = mysql_query("SELECT `ID`, `data` FROM `prodaja` WHERE `sec_data` NOT LIKE '%_rollback' ORDER BY `ID` DESC LIMIT 0 , 50",$db);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Удаление записи</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
</head>

<body onload="onLoad()">
		
	
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="insert_rollback_prodaja.php" method="post" name="formroll">
	
<table width="400" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Откат продажи</p></b></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td width="150"><p>ID транзакции / Дата:</p></td>
  	<td width="250"><select id="id_data" name='id'><option value="">Выберите запись</option>
<?php while($myrow = mysql_fetch_array($result)) {
printf("<option value=%s>ID: %s/Дата: %s</option>",$myrow['ID'],$myrow['ID'],$myrow['data']);	
	}?>  	
  	</select></td>
    </tr>
    <tr><td colspan="2" id="roll_info"><table>

  <tr bgcolor="#ecf2f6">
	<td width="200"><p>Магазин:</p></td>
  	<td width="200"><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Категория:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Бренд:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Номер модели:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Размер:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
  	<td><p>Цвет:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
    <td><p>Материал:</p></td>
  	<td><p></p></td>
  </tr> 
  <tr bgcolor="dce6ee">
    <td><p>Количество, шт:</p></td>
  	<td><p></p></td>
  </tr> 
  <tr bgcolor="#ecf2f6">
	<td><p>Цена, грн:</p></td>
  	<td><p></p></td>
    </tr>	
  <tr bgcolor="#dce6ee">
    <td><p>Сумма, грн:</p></td>
  	<td><p></p></td>
  </tr>	
  <tr bgcolor="#ecf2f6">
	<td><p>Вознаг, грн:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Процент, грн:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>ФИО:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Контактний номер телефона:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Скидка:</p></td>
  	<td><p></p></td>
    </tr>
  <tr bgcolor="#dce6ee">
	<td><p>Примечание:</p></td>
  	<td><p></p></td>
    </tr>
    <tr bgcolor="#ecf2f6">
 <td><p>Кем продано:</p></td>
  	<td><p></p></td>
    </tr> 

</table></td></tr> 
  </table>
 <table width="400" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input name="otkat" style="width:100px" type="submit" value="Отмена продаж" ></td>
    <td width="200" align="center"><input name="cansel" style="width:100px" type="button" value="Отмена" onclick="top.location.href='../prodaja.php'" ></td>
  </tr>
 	</table>
 
 
 </form>
 
 </td></tr></table>
 
</div>
<script type="text/javascript">
$(document).ready(function(){ 
         $("#id_data").change(function(){		 		
         $("#roll_info").load("./get_prodaja_for_rollback.php", { id_roll: $("#id_data option:selected").val() }, function()
    {
    var selectorprod = document.getElementById('id_data').value;     	                
    if (( $("#dissubmit").length ) || ( selectorprod == '' )) {
        $("input[type=submit]").attr("disabled", "disabled");
    }
    else {
        $("input[type=submit]").removeAttr("disabled");
    }          
    });        
});
});

function onLoad(){   
    var selectorprod = document.getElementById('id_data').value;            
    if ( selectorprod == '' ) {
        $("input[type=submit]").attr("disabled", "disabled");
    }
    else {
        $("input[type=submit]").removeAttr("disabled");
    }  
         
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