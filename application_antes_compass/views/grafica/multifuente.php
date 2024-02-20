<?php
$p_location = ROOT.'/public/'; 
include ($p_location."jpgraph/jpgraph.php");
include ($p_location."jpgraph/jpgraph_bar.php");// Some data
//$imageName='./temp/'.'img'.time().'.jpg';//aqui guarda las imagenes creadas dinamicamente en el directorio _temp/img(tiempounix).png
$datay=$array;
$datay=stripslashes($datay);
$datay=unserialize($datay);

// Create the graph. These two calls are always required
$graph = new Graph(594,310,'auto');
$graph->SetScale("textlin");

//$theme_class=new UniversalTheme;
//$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
$graph->SetBox(true);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('Auto','Gerente','Pares','Subalt'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$bplot = new BarPlot($datay);
$graph->Add($bplot);

if ($datay[0] <= 1.65 ) $color = 'darkred';
if (($datay[0] > 1.66) && ($datay[0] <= 3.32)) $color= 'yellow';
if ($datay[0] > 3.32) $color= 'green';if ($datay[1] <= 1.65 ) $color1= 'darkred';
if (($datay[1] > 1.66)&& ($datay[1] <= 3.32)) $color1= 'yellow';
if ($datay[1] > 3.32) $color1= 'green';
if ($datay[2] <= 1.65 ) $color2= 'darkred';
if (($datay[2] > 1.66)&& ($datay[2] <= 3.32)) $color2= 'yellow';  
if ($datay[2] > 3.32) $color2= 'green';
if ($datay[3] <= 1.65 ) $color3= 'darkred';
if (($datay[3] > 1.66)&& ($datay[3] <= 3.32)) {$color3= 'yellow';}
if ($datay[3] > 3.32) {$color3= 'green'; }

$bplot->SetFillColor(array($color,$color1,$color2,$color3));
//$bplot->SetFillColor(array('red','blue','green')); 
$bplot->SetColor('black');
$bplot->SetWidth(0.4);
$bplot->SetShadow('darkgray');// Setup the values that are displayed on top of each bar
$bplot->value->Show();
$bplot->value->SetFormat('%7.2f');
// Black color for positive values and darkred for negative values
$bplot->value->SetColor("black","darkred");


$graph->title->Set("Visión 360 Grados");

// Display the graph
$graph->Stroke();
?>