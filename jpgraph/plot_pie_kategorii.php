<?php include ("../config.php");
// content="text/plain; charset=utf-8"

require_once ("jpgraph.php");
require_once ("jpgraph_pie.php");
require_once ('jpgraph_pie3d.php');

session_start();

$result = mysql_query("SELECT kategoria FROM prodaja WHERE sec_data = '{$_SESSION['plot_month']}' AND kategoria <> '' ORDER BY ID ASC",$db);
//$myrow = mysql_fetch_array($result);
$num_count = mysql_num_rows($result);
$result_kateg = mysql_query("SELECT kateg FROM sklad_kategorii ORDER BY ID ASC",$db);
//$myrow_oper = mysql_fetch_array($result_oper);
$num_count_kateg = mysql_num_rows($result_kateg);


$kategory_array = array();
while($myrow = mysql_fetch_array($result)) {
	$kategory_array[] = $myrow['kategoria'];	
	} 

$data = array();
$labels = array();

while ($myrow_kateg = mysql_fetch_array($result_kateg)) {

$plot_summa = 0;
for ($j=0; $j<=$num_count; $j++)	{

if ($myrow_kateg['kateg'] == $kategory_array[$j]) {$plot_summa++;}
   
}
if  ($plot_summa <> 0) {
$data[] = $plot_summa;
//$name_kateg = substr($myrow_kateg['kateg'], 0, 33);
$name_kateg = explode(" ",$myrow_kateg['kateg']);
$labels[] = $name_kateg[0]."\n(%.1f%%)";
}
}

if (empty($data)) {$data['0'] = 1; $labels[] = "Пока нет \nданных";}

// Some data and the labels
//$data   = array(19,12,4,7,3,12,3);
//$labels = array("First\n(%.1f%%)",
//                "Second\n(%.1f%%)","Third\n(%.1f%%)",
//                "Fourth\n(%.1f%%)","Fifth\n(%.1f%%)",
//                "Sixth\n(%.1f%%)","Seventh\n(%.1f%%)");

// Create the Pie Graph.
$graph = new PieGraph(520,450);
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set('Соотношение продаж');
$graph->subtitle->Set('(за '.$_SESSION['plot_month'].')');
//$graph->title->SetFont(FF_FONT1,FS_BOLD,12);
$graph->title->SetColor('black');

// Create pie plot
$p1 = new PiePlot3D($data);
$p1->SetCenter(0.5,0.5);
$p1->SetSize(0.35);

// Setup the labels to be displayed
$p1->SetLabels($labels);

// This method adjust the position of the labels. This is given as fractions
// of the radius of the Pie. A value < 1 will put the center of the label
// inside the Pie and a value >= 1 will pout the center of the label outside the
// Pie. By default the label is positioned at 0.5, in the middle of each slice.
$p1->SetLabelPos(1);
//$p1->SetLabelMargin(15);
//$p1->SetShadow(true);

//$p1->SetGuideLines(true,false);
//$p1->SetGuideLinesAdjust(1.5);

// Setup the label formats and what value we want to be shown (The absolute)
// or the percentage.
$p1->SetLabelType(PIE_VALUE_PER);
$p1->value->Show();
//$p1->SetStartAngle(270);
$p1->value->SetColor('darkgray');
//$p1->SetAngle(60);
// Add and stroke
$graph->Add($p1);

mysqli_free_result($result);
mysqli_free_result($result_kateg);
mysqli_close($db);
$graph->Stroke();


?>


