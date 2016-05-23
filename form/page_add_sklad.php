<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891')) && ($_SESSION['add_priv_ost'] == 1)) {


function defender_sql($arr){
    $counter= 0;
    $copy_arr = $arr;
    $filter = array("update","select","group by","from","where","into","set","union","char","order"); 
     foreach($copy_arr as $num=>$xss){
     	  $xss=mysql_real_escape_string($xss);
     	  $xss = strtolower($xss);
        $copy_arr[$num]=str_replace($filter, "WARNING_SQL_INGECT_WORD", $xss, $counter);
     }
     if ($counter == 0) {
     	     foreach($arr as $num=>$xss){
           $arr[$num]=mysql_real_escape_string($xss);
           }
     return $arr;
     }
     else {return $copy_arr;}      
}

if (isset($_GET['id'])) {$_GET=defender_sql($_GET); $id = $_GET['id'];} unset ($_GET['id']);

$result = mysql_query("SELECT `ID_kategorii`, `ID_brenda`, `ID_tovara`, `kolichestvo` FROM `sklad_tovaru` WHERE `ID` = '$id'",$db);
$myrow = mysql_fetch_array($result);

$result_kat = mysql_query("SELECT `kateg` FROM `sklad_kategorii` WHERE `ID` = '{$myrow['ID_kategorii']}'",$db);
$myrow_kat = mysql_fetch_array($result_kat);

$result_br = mysql_query("SELECT `brend` FROM `sklad_brendu` WHERE `ID` = '{$myrow['ID_brenda']}'",$db);
$myrow_br = mysql_fetch_array($result_br);

$result_tov = mysql_query("SELECT `nomer_mod`, `razmer`, `cvet`, `material` FROM `prase` WHERE `ID` = '{$myrow['ID_tovara']}'",$db);
$myrow_tov = mysql_fetch_array($result_tov);

	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Добавление на склад</title>
<link href="../style.css" rel="stylesheet" type="text/css" />




</head>

<body>
		
<div align="center">
	
	<table border="0" style="border:1px solid #ccc; background:#f6f6f6; padding:5px; align:center; valign:center;">
		<tr><td>
	
<form action="update_sklad.php" method="post">
	
<table width="420" cellpadding="10" cellspacing="0" style="border:1px solid #fff;">
  <tr>
    <td colspan="2" align="center" style="background:url(../images/header-bg.gif); text-align:center; color:#cfdce7; border:1px solid #fff; border-right:none"><b><p>Добавить товар на Остатки</p></b></td>
    </tr>
  <tr bgcolor="#ecf2f6">
  	<td width="200px"><p>Категория:</p></td>
  	<td height="20px"><p><?php echo htmlspecialchars($myrow_kat['kateg']);?></p>
<input type="hidden" name="kategory" value="<?php echo htmlspecialchars($myrow_kat['kateg']);?>">
<input type="hidden" name="id_kat" value="<?php echo $myrow['ID_kategorii'];?>"> 		
  	</td>
    </tr>
  <tr bgcolor="#dce6ee">
    <td><p>Бренд:</p></td>
  	<td height="20px"><p><?php echo htmlspecialchars($myrow_br['brend']);?></p>
<input type="hidden" name="brend" value="<?php echo htmlspecialchars($myrow_br['brend']);?>">
<input type="hidden" name="id_br" value="<?php echo $myrow['ID_brenda'];;?>">			
  	</td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Номер модели:</p></td>
  	<td height="20px"><p><?php echo htmlspecialchars($myrow_tov['nomer_mod']);?></p>
<input type="hidden" name="schet" value="<?php echo $myrow_tov['nomer_mod'];?>">
<input type="hidden" name="id_tov" value="<?php echo $myrow['ID_tovara'];?>">
	</td>
    </tr>

  <tr bgcolor="#dce6ee">
    <td><p>Размер:</p></td>
  	<td height="20px"><p><?php echo htmlspecialchars($myrow_tov['razmer']);?></p>			
  	</td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Цвет:</p></td>
  	<td height="20px"><p><?php echo htmlspecialchars($myrow_tov['cvet']);?></p>
	</td>
    </tr>
	
  <tr bgcolor="#dce6ee">
    <td><p>Материал:</p></td>
  	<td height="20px"><p><?php echo htmlspecialchars($myrow_tov['material']);?></p>			
  	</td>
  </tr>
  <tr bgcolor="#ecf2f6">
	<td><p>Текущее кол-во, шт:</p></td>
  	<td height="20px"><p><?php echo $myrow['kolichestvo'];?></p>
<input type="hidden" name="kolich" value="<?php echo $myrow['kolichestvo'];?>">
<input type="hidden" name="skl_id" value="<?php echo $id;?>">
	</td>
    </tr>

  <tr bgcolor="#dce6ee">
	<td><p>Добавить, шт:</p></td>
  	<td>
<input type="text" name="add_kolich" style="width:210px;" value="">
	</td>
    </tr>
 </table>
 <div align="center">
 <table width="420" cellpadding="10" cellspacing="0" border="0">
 	<tr>
    <td width="200" align="center"><input style="width:100px;" name="save" type="submit" value="Добавить" ></td>
    <td width="200" align="center"><input style="width:100px;" name="cansel" type="button" value="Отмена" onclick="top.location.href='../sklad.php'" ></td>
  </tr></table></div>
 
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
