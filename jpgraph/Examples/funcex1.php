<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_utils.inc.php');

include ("config.php");

$result = mysql_query("SELECT vkasse FROM kassa ORDER BY ID ASC LIMIT 52",$db);
$y3data = array();
while($myrow = mysql_fetch_array($result)){
    $y3data[] = $myrow['vkasse'];
}

//$f = new FuncGenerator('cos($x)*$x');
//list($xdata,$ydata) = $f->E(-1.2*M_PI,1.2*M_PI);

//$f = new FuncGenerator('$x*$x');
//list($x2data,$y2data) = $f->E(-15,15);

// Setup the basic graph
$graph = new Graph(1000,1000);
$graph->SetScale("linlin");
$graph->SetShadow();
$graph->img->SetMargin(50,50,60,40);	
$graph->SetBox(true,'black',2);	
$graph->SetMarginColor('white');
$graph->SetColor('lightyellow');

// ... and titles
$graph->title->Set('Example of Function plot');
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->subtitle->Set("(With some more advanced axis formatting\nHiding first and last label)");
$graph->subtitle->SetFont(FF_FONT1,FS_NORMAL);
$graph->xgrid->Show();

$graph->yaxis->SetPos(0);
$graph->yaxis->SetWeight(2);
$graph->yaxis->HideZeroLabel();
$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black','darkblue');
$graph->yaxis->HideTicks(true,false);
$graph->yaxis->HideFirstLastLabel();

$graph->xaxis->SetWeight(2);
$graph->xaxis->HideZeroLabel();
$graph->xaxis->HideFirstLastLabel();
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black','darkblue');

//$lp1 = new LinePlot($ydata,$xdata);
//$lp1->SetColor('blue');
//$lp1->SetWeight(2);

//$lp2 = new LinePlot($y2data,$x2data);

//$lp2->SetColor('red');
//$lp2->SetWeight(2);

$lp1 = new LinePlot($y3data,$xdata);
list($xm,$ym)=$lp1->Max();
$lp1->SetColor('green');
$lp1->SetWeight(2);

$graph->Add($lp1);
//$graph->Add($lp2);
$graph->Stroke();

?>


