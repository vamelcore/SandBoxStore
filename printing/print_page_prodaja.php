<?php include ("../config.php");

header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (isset($_GET['id'])) {$id = $_GET['id']; if ($id == '') {unset ($id);}}

$result = mysql_query("SELECT * FROM `prodaja` WHERE `ID` = '$id'",$db);
$myrow = mysql_fetch_array($result);

$res_fio = mysql_query("SELECT `fio_usera` FROM `users` WHERE login = '{$myrow['user']}'");
$myr_fio = mysql_fetch_array($res_fio);
 
$dat = explode(" ",$myrow['data']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title></title>	
	</head>
	<body>
<table width="700">
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td style="border-bottom: 1px solid black;" width="700"><h3>Товарний чек № <?php $num = str_pad($myrow['ID'], 8, '0', STR_PAD_LEFT); printf("%s %s", $num, $dat[0]); ?></h3></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td><table>
		<tr><td width="150">Постачальник:</td><td>_______________________________________________</td></tr>
		<tr><td>Покупець:</td><td>_______________________________________________</td></tr>
		<tr><td>Склад:</td><td>СКЛАД "<?php echo $myrow['magazin'];?>"</td></tr>
		<tr><td>Примітка:</td><td>_______________________________________________</td></tr>
	</table></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td><table width="700" style="border-collapse: collapse;">
		<tr>
		    <td style="border: 1px solid black; padding: 5px;" width="50">№</td>
		    <td style="border: 1px solid black; padding: 5px;" width="350">Товар</td>
		    <td style="border: 1px solid black; padding: 5px;" width="100">Кількість</td>
		    <td style="border: 1px solid black; padding: 5px;" width="100">Цiна за шт.</td>
		    <td style="border: 1px solid black; padding: 5px;" width="100">Сума грн.</td>
		</tr>		
		    <?php	    
		    $stoimost = 0;
		    $no = 1;
		    if ($myrow['printer_ID'] == $myrow['ID']) {
	     $res_group = mysql_query("SELECT * FROM `prodaja` WHERE `printer_ID` = '{$myrow['ID']}' ORDER BY `ID` ASC",$db);    	     	     
	     while ($myr_group = mysql_fetch_array($res_group)) {	     		     	
       $stoimost_group = $myr_group['summa'] - $myr_group['skidka'];
	     	printf("<tr><td style='border: 1px solid black; padding: 5px;'>%s</td><td style='border: 1px solid black; padding: 5px;'>%s, %s, %s, %s, %s, %s</td><td style='border: 1px solid black; padding: 5px;'>%s</td><td style='border: 1px solid black; padding: 5px;'>%s</td><td style='border: 1px solid black; padding: 5px;'>%s</td></tr>",$no,$myr_group['kategoria'],$myr_group['brend'],$myr_group['nomer_mod'],$myr_group['razmer'],$myr_group['cvet'],$myr_group['material'],$myr_group['kolichestvo'],$myr_group['cena'],$stoimost_group);
	     	$stoimost = $stoimost + $stoimost_group;
	     	$no++;	    
	     	}	     
	     }
      else {      	
       $stoimost = $myrow['summa'] - $myrow['skidka'];
      	printf("<tr><td style='border: 1px solid black; padding: 5px;'>1</td><td style='border: 1px solid black; padding: 5px;'>%s, %s, %s, %s, %s, %s</td><td style='border: 1px solid black; padding: 5px;'>%s</td><td style='border: 1px solid black; padding: 5px;'>%s</td><td style='border: 1px solid black; padding: 5px;'>%s</td></tr>",$myrow['kategoria'],$myrow['brend'],$myrow['nomer_mod'],$myrow['razmer'],$myrow['cvet'],$myrow['material'],$myrow['kolichestvo'],$myrow['cena'],$stoimost);
      	    	
      	}		    
		    ?>		
	</table></td></tr>
	<tr><td></td></tr>
	<tr><td></td></tr>
	<tr><td><table width="700">
		<tr><td colspan="2"><strong>Відпущено на суму: <?php echo $stoimost;?></strong></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td width="400">Відпустив: <?php echo $myr_fio['fio_usera'];?> _________</td><td align="right">Отримав: <?php echo $myrow['FIO'];?> _________</td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2"></td></tr>
		<tr><td colspan="2">Претензій по якості не маю _________</td></tr>
	</table></td></tr>
	<tr><td></td></tr>
</table>

	</body>
</html>

<?php } ?>