<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {

if (isset($_POST['price_kat'])) {$price_kat = $_POST['price_kat']; unset($_POST['price_kat']);} else {$price_kat = '';}
if (isset($_POST['price_br'])) {$price_br = $_POST['price_br']; unset($_POST['price_br']);}	else {$price_br = '';}

 
	if (isset($_SESSION['poisk'])) {
$result = mysql_query("SELECT * FROM `prase` WHERE `nomer_mod` LIKE '%{$_SESSION['poisk']}%' OR `razmer` LIKE '%{$_SESSION['poisk']}%' OR `cvet` LIKE '%{$_SESSION['poisk']}%' OR `material` LIKE '%{$_SESSION['poisk']}%' OR `ID_kategorii` IN ( SELECT `ID` FROM `sklad_kategorii` WHERE `kateg` LIKE '%{$_SESSION['poisk']}%' ) OR `ID_brenda` IN ( SELECT `ID` FROM `sklad_brendu` WHERE `brend` LIKE '%{$_SESSION['poisk']}%' ) ORDER BY `ID_kategorii`",$db);} 
else {
		if ($price_kat == '') {$result = mysql_query("SELECT * FROM `prase` ORDER BY `ID_kategorii`",$db);} else {
		$result = mysql_query("SELECT * FROM `prase` WHERE ID_kategorii ='$price_kat' AND `ID_brenda` = '$price_br' ORDER BY `ID_kategorii`",$db);	
		}
	}

$myrow = mysql_fetch_array($result);

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
 
require_once 'PHPExcel.php';
$phpexcel = new PHPExcel();
$page = $phpexcel->setActiveSheetIndex(0);

//настройки для шрифтов
$baseFont = array(
	'font'=>array(
		'name'=>'Arial',
		'size'=>'10',
		'bold'=>false
	)
);
$boldFont = array(
	'font'=>array(
		'name'=>'Arial',
		'size'=>'12',
		'bold'=>true
	)
);
//и позиционирование
$center = array(
	'alignment'=>array(
		'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'=>PHPExcel_Style_Alignment::VERTICAL_TOP
	)
);

$page->setCellValue("A1", "Категория")->getStyle('A1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("B1", "Бренд")->getStyle('B1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("C1", "Номер модели")->getStyle('C1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("D1", "Размер")->getStyle('D1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("E1", "Цвет")->getStyle('E1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("F1", "Материал")->getStyle('F1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("G1", "Цена")->getStyle('G1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("H1", "Вознаг.")->getStyle('H1')->applyFromArray($boldFont)->applyFromArray($center);	

$page->getColumnDimension("A")->setAutoSize(true);
$page->getColumnDimension("B")->setAutoSize(true);
$page->getColumnDimension("C")->setAutoSize(true);
$page->getColumnDimension("D")->setAutoSize(true);
$page->getColumnDimension("E")->setAutoSize(true);
$page->getColumnDimension("F")->setAutoSize(true);
$page->getColumnDimension("G")->setAutoSize(true);
$page->getColumnDimension("H")->setAutoSize(true);

$no_row=2;

do {
	
for ($no=0; $no<=$index_kat; $no++) {if ($myarray_kateg['ID'][$no] == $myrow['ID_kategorii']) {$kategoriya = $myarray_kateg['kateg'][$no];}}	
for ($no=0; $no<=$index_br; $no++) {if ($myarray_brend['ID'][$no] == $myrow['ID_brenda']) {$brend = $myarray_brend['brend'][$no];}}

$page->setCellValue("A".$no_row, $kategoriya);
$page->setCellValue("B".$no_row, $brend);
$page->setCellValue("C".$no_row, $myrow['nomer_mod']);
$page->setCellValue("D".$no_row, $myrow['razmer']);	
$page->setCellValue("E".$no_row, $myrow['cvet']);
$page->setCellValue("F".$no_row, $myrow['material']);
$page->setCellValue("G".$no_row, $myrow['cena']);
$page->setCellValue("H".$no_row, $myrow['voznag']);
$no_row++;
}
while ($myrow = mysql_fetch_array($result));

$page->setTitle("Прайс");

$hours = date('H') + $_SESSION['time_zone'];
$date_price = date ('d.m.Y', mktime ($hours));

$filename='Прайс на '.' '.$date_price.'.xlsx';
header('Content-Type: application/vnd.ms-excel'); 
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
//$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');  
$objWriter->save('php://output');
}
else {

header("Location: index.php");
die();
}
?>