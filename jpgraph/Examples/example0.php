<?php include ("config.php");
// content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
$result = mysql_query("SELECT vkasse FROM kassa ORDER BY ID ASC LIMIT 200",$db);


$ydata = array();

while($myrow = mysql_fetch_array($result)){
    $ydata[] = $myrow['vkasse'];
}



// Some data




//$ydata = array(110,3,8,12,5,1,9,130,5,7);

// Create the graph. These two calls are always required
$graph = new Graph(1300,800);
$graph->SetScale('textlin');

// Create the linear plot
$lineplot=new LinePlot($ydata);
$lineplot->SetColor('blue');

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
?>
