<?php include ("config.php");
header('Content-Type: text/html; charset=utf-8');

session_start();

if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
	
	if (!isset($_SESSION['id_mag_selected'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag']['1'];
	$_SESSION['id_mag_selected'] = $_SESSION['id_mag']['1'];}
	else {
		if (!isset($_POST['selector_of_stores'])) {$_POST['selector_of_stores'] = $_SESSION['id_mag_selected'];}		
	}

$_SESSION['lastpagevizitmag'] = 'archive_prodaj.php';

$hours = date('H') + $_SESSION['time_zone']; 
$data = date ('d.m.Y', mktime ($hours));
$vremya = date ('H:i:s', mktime ($hours));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Главная страница. Архив</title>
<link rel="stylesheet" href="style_main_page.css" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
            var windowSizeArray = [ "width=400,height=650",
                                    "width=400,height=650,scrollbars=yes" ];
 
            $(document).ready(function(){
                $('.newWindow').click(function (event){
 
                    var url = $(this).attr("href");
                    var windowName = "popUp";//$(this).attr("name");
                    var windowSize = windowSizeArray[$(this).attr("rel")];
 
                    window.open(url, windowName, windowSize);
 
                    event.preventDefault();
 
                });
            });
        </script>

</head>
<body>

<div align="center">

<table width="1220" border="0" style='border:1px solid #ccc; background:#f6f6f6; padding:5px;'>

<tr>
<td style="border-bottom:1px solid #c6d5e1;"> <form method="post"><table><tr><td><p style="font-size:10pt;">Магазин:</p></td><td><select name="selector_of_stores" onChange="javascript:form.submit()"><?php

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
}
while($no < $_SESSION['count_mag']);
if ($_SESSION['id_mag_selected'] <> 'all') {
$res_plan = mysql_query("SELECT * FROM plan WHERE ID_magazina = '{$_SESSION['id_mag_selected']}'");
$myr_plan = mysql_fetch_array($res_plan);
do {
	${'plan_'.$myr_plan['name']} = $myr_plan['plane'];
} while ($myr_plan = mysql_fetch_array($res_plan));
}
?></select></td><td><a href="chat/index.php" rel="1" class="newWindow" ><img id='new_mes' src='images/mail.png'></a></td></table></form> <table cellspacing="5"><tr><td><a class="like_button_use" href="page.php">Общая</a></td><td><a class="like_button"  href="praice.php">Прайс</a></td><td><a class="like_button" href="sklad.php">Остатки</a></td><td><a class="like_button" href="peremeschenie.php">Перемещение</a></td><td><a class="like_button" href="prodaja.php">Продажи</a></td><td><a class="like_button" href="zarplata.php">Зарплата</a></td><?php if  ($_SESSION['tabl_store_show'][0] == '1') {printf('<td><a class="like_button" href="vozvratu.php">Возвраты</a></td>');} ?>
	<?php 
if (isset($_SESSION['admin_priv']) && ($_SESSION['admin_priv'] == 1)) {
	printf("<td>||</td><td><a class=\"like_button_adm\" href=\"%s\">Админ</a></td>",$_SESSION['lastpagevizitadm']);
}
if (isset($_SESSION['root_priv']) && ($_SESSION['root_priv'] == 1)) {
	printf("<td><a class=\"like_button_adm\" href=\"users.php\">Настройки</a></td>");}

 ?>

<td>||</td><td><?php printf("<p style=\"font-size:10pt; color: green;\">Пользователь: %s</p>",$_SESSION['login']);?></td><td><a href="index.php?logout" title="ВЫХОД"><img src='/images/exit.png' width='20' height='20' border='0'></a></td></tr></table></td>
</tr>

<tr>
<td height="30px" style="border-bottom:1px solid #c6d5e1;"><form action="" method="post"><p style="font-size:10pt;">Таблица: "Архив продаж".  Дата: <select name="arch_pr_sec_data" onchange="javascript:form.submit()">
	<?php
	$result_date = mysql_query("SELECT DISTINCT `sec_data` FROM prodaja WHERE `sec_data` NOT LIKE '%_rollback' ORDER BY `ID` DESC LIMIT 0 , 24",$db);
	$myrow_date = mysql_fetch_array($result_date);
	if (isset ($_POST['arch_pr_sec_data'])) {$_SESSION['arch_pr_sec_data'] = $_POST['arch_pr_sec_data'];}
	do {
	if (!isset($_SESSION['arch_pr_sec_data'])) {$_SESSION['arch_pr_sec_data'] = $myrow_date['sec_data']; $_POST['arch_pr_sec_data'] = $myrow_date['sec_data'];}
	if ($_SESSION['arch_pr_sec_data'] == $myrow_date['sec_data']){
		printf("<option value=\"%s\" selected=\"selected\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);  $_SESSION['arch_pr_sec_data'] = $myrow_date['sec_data'];
	}	else {
		printf("<option value=\"%s\">%s</option>",$myrow_date['sec_data'],$myrow_date['sec_data']);
	}
	}
	while ($myrow_date = mysql_fetch_array($result_date));
	
		?></select></p></form></td>
</tr>
<?php

if ($_SESSION['id_mag_selected'] == 'all') {
	printf("<tr><td style=\"border-bottom:1px solid #c6d5e1;\" align=\"center\"><table cellspacing=\"10\"><tr>");
	
	printf("<td valign=top align=center><table bgcolor=#c6d5e1 border=0 cellpadding=2 cellspacing=1 width=200><tr><td colspan='2' bgcolor=#f6f6f6 align='center'><strong>Прибыль за %s, грн</strong></td></tr>",$_SESSION['arch_pr_sec_data']);

$no = 0;	
do {
$no = $no +1;
	$res_stoimost = mysql_query("SELECT `cena`, `skidka` FROM prodaja WHERE magazin = '{$_SESSION['name_mag'][$no]}' AND sec_data = '{$_SESSION['arch_pr_sec_data']}'",$db);
	$myr_stoimost = mysql_fetch_array($res_stoimost);
	$summa_soim = 0;
	do {$summa_soim=$summa_soim+$myr_stoimost['cena']-$myr_stoimost['skidka'];} while ($myr_stoimost = mysql_fetch_array($res_stoimost));	
  printf("<tr><td bgcolor=#f6f6f6>%s</td><td bgcolor=#f6f6f6>%s</td></tr>",$_SESSION['name_mag'][$no],$summa_soim);				
}
while($no < $_SESSION['count_mag'] - 1);
printf("</table></td>");
	
$res_kateg = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii",$db);
	
$_SESSION['plot_month'] = $_SESSION['arch_pr_sec_data'];	

printf("<tr><td colspan='4' align='left'><select id='tupe1_graph' name='tupe1_graph'><option value='bar'>Бар</option><option value='graph'>График</option></select> <select id='plot_kategory' name='plot_kategory'><option value='all'>Все</option>");
while ($myr_kateg = mysql_fetch_array($res_kateg)) {
printf("<option value=%s>%s</option>",$myr_kateg['ID'],$myr_kateg['kateg']);}
printf("</select></td></tr>");

printf("<tr><td colspan='4' align='center'><table><tr><td><img id='plot_kateg' src='/jpgraph/plot_bar_kategorii.php'></td><td colspan='2' align='center'><img src='/jpgraph/plot_pie_kategorii.php'></td></tr></table></td></tr>");

printf("</tr></table></td></tr>");	
}
?>
<tr><td style="border-bottom:1px solid #c6d5e1;">
	<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
		<thead>
			<tr>
				<?php
				if ($_SESSION['id_mag_selected'] == 'all')
				{
					printf("<th class=\"nosort\"><h3>Наименование</h3></th>");
					$i = 1;
					do {
						printf("<th class=\"nosort\"><h3>%s</h3></th>", $_SESSION['name_mag'][$i]);
						$i++;
						if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}
					} while (isset($_SESSION['name_mag'][$i]));
					printf("<th class=\"nosort\"><h3>Суммарное количество</h3></th>");
				} else {
					printf("<th width=\"300\" class=\"nosort\"><h3>Наименование</h3></th>
							<th width=\"100\" class=\"nosort\"><h3>Результат за месяц:</h3></th>
							<th width=\"100\"class=\"nosort\"><h3>План:</h3></th>
							");
				}
				?>				
			</tr>
		</thead>
		<tbody>
<?php
if ($_SESSION['id_mag_selected'] <> 'all') {
$res_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myr_mag = mysql_fetch_array($res_mag);
}

$res_podkl = mysql_query("SELECT `ID`, `oper` FROM operatoru",$db);
$myr_podkl = mysql_fetch_array($res_podkl); 

$res_kat = mysql_query("SELECT `ID`, `kateg` FROM sklad_kategorii",$db);
$myr_kat = mysql_fetch_array($res_kat);

?>
   
  <tr bgcolor="#dce6ee">
	<td><p>ПРОДАЖИ ПО КАТЕГОРИЯМ, ВСЕГО</p></td>
  	<?php
  	if ($_SESSION['id_mag_selected'] <> 'all') { 
  		$res_summ_prodaj_K = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE kategoria != '' AND magazin = '{$myr_mag['name']}' AND sec_data = '{$_SESSION['arch_pr_sec_data']}' GROUP BY magazin",$db);
  	$summa_prodaj_K = mysql_fetch_array($res_summ_prodaj_K);
	if ($summa_prodaj_K['COUNT(ID)'] == '') {$summa_prodaj_K['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_prodaj_K['COUNT(ID)']); }
	else {		
		$i = 1; $summa = 0;
		do {
		$res_summ_prodaj_K = mysql_query("SELECT magazin, COUNT(ID) FROM prodaja WHERE kategoria != '' AND magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '{$_SESSION['arch_pr_sec_data']}' GROUP BY magazin",$db);	
		$summa_prodaj_K = mysql_fetch_array($res_summ_prodaj_K);
	    if ($summa_prodaj_K['COUNT(ID)'] == '') {$summa_prodaj_K['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_prodaj_K['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_prodaj_K['COUNT(ID)']);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);		
	} 		  	
  	?>  	
    </tr>
    <?php
    if ($_SESSION['id_mag_selected'] <> 'all') {
    do {
   $res_kateg_count = mysql_query("SELECT kategoria, COUNT(ID) FROM prodaja WHERE magazin = '{$myr_mag['name']}' AND sec_data = '{$_SESSION['arch_pr_sec_data']}' AND kategoria = '{$myr_kat['kateg']}' GROUP BY kategoria",$db);
	$myr_kateg_count = mysql_fetch_array($res_kateg_count);
 	if ($myr_kateg_count['COUNT(ID)'] == '') {$summ = 0;} else {$summ = $myr_kateg_count['COUNT(ID)'];}   
 printf ("<tr bgcolor=\"#ecf2f6\"><td><p>%s:</p></td><td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td></tr>",$myr_kat['kateg'],$summ);
	} while ($myr_kat = mysql_fetch_array($res_kat));}
	else {
		
	do {
		printf ("<tr bgcolor=\"#ecf2f6\"><td><p>%s:</p></td>",$myr_kat['kateg']);
	    $i = 1; $summa = 0;
		do {
		$res_kateg_count = mysql_query("SELECT kategoria, COUNT(ID) FROM prodaja WHERE magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '{$_SESSION['arch_pr_sec_data']}' AND kategoria = '{$myr_kat['kateg']}' GROUP BY kategoria",$db);	
		$myr_kateg_count = mysql_fetch_array($res_kateg_count);
	    if ($myr_kateg_count['COUNT(ID)'] == '') {$summ = 0;} else {$summ = $myr_kateg_count['COUNT(ID)'];}
		$summa = $summa + $myr_kateg_count['COUNT(ID)'];		
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summ);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td></tr>",$summa);	
	} while ($myr_kat = mysql_fetch_array($res_kat));		
				
	}
    ?>

<tr bgcolor="#dce6ee">
	<td><p>ВОЗВРАТЫ:</p></td>
  	<?php
    if ($_SESSION['id_mag_selected'] <> 'all') {  	 
  		$res_summ_vozv = mysql_query("SELECT magazin, COUNT(ID) FROM vozvratu WHERE magazin = '{$myr_mag['name']}' AND sec_data = '{$_SESSION['arch_pr_sec_data']}' GROUP BY magazin",$db);
  	$summa_vozv = mysql_fetch_array($res_summ_vozv);
	if ($summa_vozv['COUNT(ID)'] == '') {$summa_vozv['COUNT(ID)'] = 0;}
	printf("<td><p align=\"center\"><strong>%s</strong></p></td><td><p align=\"center\"></p></td>",$summa_vozv['COUNT(ID)']);}
	else {		
		$i = 1; $summa = 0;
		do {
		$res_summ_vozv = mysql_query("SELECT magazin, COUNT(ID) FROM vozvratu WHERE magazin = '{$_SESSION['name_mag'][$i]}' AND sec_data = '{$_SESSION['arch_pr_sec_data']}' GROUP BY magazin",$db);	
		$summa_vozv = mysql_fetch_array($res_summ_vozv);
	    if ($summa_vozv['COUNT(ID)'] == '') {$summa_vozv['COUNT(ID)'] = 0;}
		$summa = $summa + $summa_vozv['COUNT(ID)'];
		printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa_vozv['COUNT(ID)']);
		$i++;
		if ($_SESSION['name_mag'][$i] == 'Все') {$i++;}	
		} while (isset($_SESSION['name_mag'][$i]));
	printf("<td><p align=\"center\"><strong>%s</strong></p></td>",$summa);				
	}  		
  	?>  	
    </tr>

</tbody></table>

	
</td></tr>
<tr><td align="center">SandBOX Market &reg; &copy;</td></tr> 
  </table>
</div>

<script type='text/javascript'> 
$(document).ready(function(){ 
  $("#plot_kategory").change(function(event){
    event.preventDefault();
    var kategoria=$("#plot_kategory").val();
    var tupe1=$("#tupe1_graph").val();
    if (tupe1 == 'bar') {$("#plot_kateg").attr("src","./jpgraph/plot_bar_kategorii.php?plot_kateg="+kategoria);}
    if (tupe1 == 'graph') {$("#plot_kateg").attr("src","./jpgraph/plot_graph_kategorii.php?plot_kateg="+kategoria);}
     
});
});
</script>
<script type='text/javascript'> 
$(document).ready(function(){ 
  $("#tupe1_graph").change(function(event){
    event.preventDefault();
    $("#plot_kategory").val("all");
    if ($(this).val() == 'bar') {$("#plot_kateg").attr("src","./jpgraph/plot_bar_kategorii.php");}
    if ($(this).val() == 'graph') {$("#plot_kateg").attr("src","./jpgraph/plot_graph_kategorii.php");}
});
});
</script>

  </body>
</html>

<?php 
}
else {

header("Location: index.php");
die();
}

?>