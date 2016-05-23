<?php include ("config.php"); 
header('Content-Type: text/html; charset=utf-8');

session_start();
if ((isset($_SESSION['user_id'])) && ($_SESSION['password_secret_id_string'] == md5($_SERVER['REMOTE_ADDR'].$_SESSION['user_id'].session_id().'6891'))) {
 
if ($_SESSION['id_mag_selected'] == 'all') {
	$magazin_n = 'всех магазинах';
		if ($_SESSION['pr_sec_data'] == 'All') {
			$data_n = 'все время';
	$result = mysql_query("SELECT * FROM `prodaja` ORDER BY ID DESC",$db);
		}
        else {
        	$data_n = $_SESSION['pr_sec_data'];
	$result = mysql_query("SELECT * FROM `prodaja` WHERE `sec_data` = '{$_SESSION['pr_sec_data']}' ORDER BY `ID` DESC",$db);	
	        }
}
else {
		
$result_mag = mysql_query("SELECT `name` FROM `magazinu` WHERE `ID` = '{$_SESSION['id_mag_selected']}'",$db);
$myrow_mag = mysql_fetch_array($result_mag);		
	$magazin_n = $myrow_mag['name'];
	if ($_SESSION['pr_sec_data'] == 'All') {
		$data_n = 'все время';
	$result = mysql_query("SELECT * FROM `prodaja` WHERE `magazin` = '{$myrow_mag['name']}' ORDER BY `ID` DESC",$db);
		}
    else {
    	$data_n = $_SESSION['pr_sec_data'];
	$result = mysql_query("SELECT * FROM `prodaja` WHERE `magazin` = '{$myrow_mag['name']}' AND `sec_data` = '{$_SESSION['pr_sec_data']}' ORDER BY `ID` DESC",$db);	
	        }
}
$myrow = mysql_fetch_array($result);
 
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


$page->setCellValue("A1", "Дата")->getStyle('A1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("B1", "Магазин")->getStyle('B1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("C1", "Категория")->getStyle('C1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("D1", "Бренд")->getStyle('D1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("E1", "Номер модели")->getStyle('E1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("F1", "Размер")->getStyle('F1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("G1", "Цвет")->getStyle('G1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("H1", "Материал")->getStyle('H1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("I1", "Кол, шт")->getStyle('I1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("J1", "Цена, грн")->getStyle('J1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("K1", "Сумма, грн")->getStyle('K1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("L1", "Вознаг, грн")->getStyle('L1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("M1", "Процент, грн")->getStyle('M1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("N1", "ФИО покупателя")->getStyle('N1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("O1", "Контактний номер телефона")->getStyle('O1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("P1", "Скидка")->getStyle('P1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("Q1", "Примечание")->getStyle('Q1')->applyFromArray($boldFont)->applyFromArray($center);
$page->setCellValue("R1", "Кем продано")->getStyle('R1')->applyFromArray($boldFont)->applyFromArray($center);

$page->getColumnDimension("A")->setAutoSize(true);
$page->getColumnDimension("B")->setAutoSize(true);
$page->getColumnDimension("C")->setAutoSize(true);
$page->getColumnDimension("D")->setAutoSize(true);
$page->getColumnDimension("E")->setAutoSize(true);
$page->getColumnDimension("F")->setAutoSize(true);
$page->getColumnDimension("G")->setAutoSize(true);
$page->getColumnDimension("H")->setAutoSize(true);
$page->getColumnDimension("I")->setAutoSize(true);
$page->getColumnDimension("J")->setAutoSize(true);
$page->getColumnDimension("K")->setAutoSize(true);
$page->getColumnDimension("L")->setAutoSize(true);
$page->getColumnDimension("M")->setAutoSize(true);
$page->getColumnDimension("N")->setAutoSize(true);
$page->getColumnDimension("O")->setAutoSize(true);
$page->getColumnDimension("P")->setAutoSize(true);
$page->getColumnDimension("Q")->setAutoSize(true);
$page->getColumnDimension("R")->setAutoSize(true);

$no=2;
do {
$page->setCellValue("A".$no, $myrow['data']);
$page->setCellValue("B".$no, $myrow['magazin']);
$page->setCellValue("C".$no, $myrow['kategoria']);
$page->setCellValue("D".$no, $myrow['brend']);
$page->setCellValue("E".$no, $myrow['nomer_mod']);
$page->setCellValue("F".$no, $myrow['razmer']);
$page->setCellValue("G".$no, $myrow['cvet']);
$page->setCellValue("H".$no, $myrow['material']);
$page->setCellValue("I".$no, $myrow['kolichestvo']);
$page->setCellValue("J".$no, $myrow['cena']);
$page->setCellValue("K".$no, $myrow['summa']);
$page->setCellValue("L".$no, $myrow['voznag']);
$page->setCellValue("M".$no, $myrow['procent']);
$page->setCellValue("N".$no, $myrow['FIO']);
$page->setCellValue("O".$no, $myrow['kontakt_nomer_tel']);
$page->setCellValue("P".$no, $myrow['skidka']);
$page->setCellValue("Q".$no, $myrow['add']);
$page->setCellValue("R".$no, $myrow['user']);

$no++;
}
while ($myrow = mysql_fetch_array($result));
$page->setTitle("Отчет");

$filename='Отчет продаж по'.' '.$magazin_n.' за '.$data_n.'.xlsx';
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