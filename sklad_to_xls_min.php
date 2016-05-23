<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
 
if (isset($_SESSION['sklad_kat']) && isset($_SESSION['sklad_br'])) {$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' AND `ID_kategorii` = '{$_SESSION['sklad_kat']}' AND `ID_brenda` = '{$_SESSION['sklad_br']}' ORDER BY `ID_kategorii` ASC",$db);}
else {$result = mysql_query("SELECT * FROM `sklad_tovaru` WHERE `ID_magazina` = '{$_SESSION['id_mag_selected']}' ORDER BY `ID_kategorii` ASC",$db);}

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

$res_tovar = mysql_query("SELECT `ID`, `nomer_mod`, `razmer`, `cvet`, `material` FROM prase ORDER BY `nomer_mod` ASC",$db);

$myarray_tovar = array(); $index_tov = 0;
while ($myr_tovar = mysql_fetch_assoc($res_tovar)) {
foreach($myr_tovar as $key => $value) {
$myarray_tovar[$key][$index_tov] = $value;
}
$index_tov++;
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
$page->setCellValue("G1", "Количество последненго прихода")->getStyle('G1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("H1", "Дата последненго прихода")->getStyle('H1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("I1", "Количество")->getStyle('I1')->applyFromArray($boldFont)->applyFromArray($center);	

$page->getColumnDimension("A")->setAutoSize(true);
$page->getColumnDimension("B")->setAutoSize(true);
$page->getColumnDimension("C")->setAutoSize(true);
$page->getColumnDimension("D")->setAutoSize(true);
$page->getColumnDimension("E")->setAutoSize(true);
$page->getColumnDimension("F")->setAutoSize(true);
$page->getColumnDimension("G")->setAutoSize(true);
$page->getColumnDimension("H")->setAutoSize(true);
$page->getColumnDimension("I")->setAutoSize(true);

$no_row=2;
do {
	
for ($no=0; $no<$index_kat; $no++) {
if ($myarray_kateg['ID'][$no] == $myrow['ID_kategorii']) {$mykateg = $myarray_kateg['kateg'][$no];}
}	

for ($no=0; $no<$index_br; $no++) {
if ($myarray_brend['ID'][$no] == $myrow['ID_brenda']) {$mybrend = $myarray_brend['brend'][$no];}
}	

for ($no=0; $no<$index_tov; $no++) {
if ($myarray_tovar['ID'][$no] == $myrow['ID_tovara']) {$mytovar = $myarray_tovar['nomer_mod'][$no]; $myrazmer = $myarray_tovar['razmer'][$no]; $mycvet = $myarray_tovar['cvet'][$no]; $mymaterial = $myarray_tovar['material'][$no];}
}		

$page->setCellValue("A".$no_row, $mykateg);
$page->setCellValue("B".$no_row, $mybrend);
$page->setCellValue("C".$no_row, $mytovar);
$page->setCellValue("D".$no_row, $myrazmer);
$page->setCellValue("E".$no_row, $mycvet);
$page->setCellValue("F".$no_row, $mymaterial);
$page->setCellValue("G".$no_row, $myrow['kol_posl_prihoda']);
$page->setCellValue("H".$no_row, $myrow['data_posl_prihoda']);	
$page->setCellValue("I".$no_row, $myrow['kolichestvo']);
$no_row++;
}
while ($myrow = mysql_fetch_array($result));

$page->setTitle("Остатки");

$hours = date('H') + $_SESSION['time_zone']; 
$dat = date ('d.m.Y', mktime ($hours));

$result_mag = mysql_query("SELECT `name` FROM magazinu WHERE ID = '{$_SESSION['id_mag_selected']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag);		

$filename='Остатки из '.' '.$myrow_mag['name'].' на '.$dat.'.xlsx';
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