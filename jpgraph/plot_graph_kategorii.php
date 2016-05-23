<?php include ("../config.php");
// content="text/plain; charset=utf-8"
require_once ('jpgraph.php');
require_once ('jpgraph_line.php');

session_start();
// Some data
//${'ydata'.$ind} = array(110,3,8,12,5,1,9,130,5,7);
// Create the graph. These two calls are always required
$graph = new Graph(600,450);
$graph->SetScale('textint');

// Setup margin and titles
$graph->SetMargin(40,10,10,10);
$graph->SetFrame(false);
$graph->title->Set('График подключений по операторам');
$graph->subtitle->Set('(за '.$_SESSION['plot_month'].')');
$graph->xaxis->title->Set('Дни месяца');
$graph->yaxis->title->Set('Количество подключений');
$graph->xaxis->SetTextLabelInterval(1);
$graph->xgrid->Show();

//$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$graph->legend->SetLayout(LEGEND_VERT);
$graph->legend->SetColumns(4);
$graph->legend->Pos(0.5,0.9999,"center","bottom");
$graph->legend->SetFillColor('white@0.99');

if (isset($_GET['plot_kateg'])) {$plot_kateg = $_GET['plot_kateg'];}

$result = mysql_query("SELECT data, kategoria FROM prodaja WHERE sec_data = '{$_SESSION['plot_month']}' AND kategoria <> '' ORDER BY ID ASC",$db);
$myrow = mysql_fetch_array($result);
$num_count = mysql_num_rows($result);
if ((isset($plot_kateg)) && ($plot_kateg <> 'all')) {$result_kateg = mysql_query("SELECT kateg FROM sklad_kategorii WHERE ID = '$plot_kateg'",$db);}
else {$result_kateg = mysql_query("SELECT kateg FROM sklad_kategorii ORDER BY ID ASC",$db);}

//$myrow_oper = mysql_fetch_array($result_oper);
$num_count_kateg = mysql_num_rows($result_kateg);

$string_t = $_SESSION['plot_month'];
$date_t = substr($string_t, 3, 6).'-'. substr($string_t, 0, 2);
$day_index = date("t", strtotime($date_t));

$date_array = array();
$kategory_array = array();
do {
	$date_array[] = substr($myrow['data'], 0, 10);
	$kategory_array[] = $myrow['kategoria'];	
	} while($myrow = mysql_fetch_array($result));

$ind = 1;

while ($myrow_kateg = mysql_fetch_array($result_kateg)) {

${'ydata'.$ind} = array();

for ($i=1; $i<=$day_index; $i++) { 

$num = str_pad($i, 2, '0', STR_PAD_LEFT);
$compare_data = $num.'.'.$_SESSION['plot_month'];
$plot_summa = 0;

for ($j=0; $j<=$num_count; $j++)	{

if  (($date_array[$j] == $compare_data) && ($kategory_array[$j] == $myrow_kateg['kateg'])) {$plot_summa++;}
   
}

${'ydata'.$ind}[] = $plot_summa;

} 
$graph->img->SetAntiAliasing(false); 
// Create the linear plot
//$lineplot1=new LinePlot($ydata1);
${'lineplot'.$ind}=new LinePlot(${'ydata'.$ind});
//$lineplot->SetColor('blue');
// Add the plot to the graph
//$graph->Add($lineplot1);
$graph->Add(${'lineplot'.$ind});
// Display the graph

${'lineplot'.$ind}->SetWeight(2);

$name_kateg = substr($myrow_kateg['kateg'], 0, 33);

${'lineplot'.$ind}->SetLegend($name_kateg);


$ind++;
}
mysqli_free_result($result);
mysqli_free_result($result_kateg);
mysqli_close($db);
$graph->Stroke();
?>
