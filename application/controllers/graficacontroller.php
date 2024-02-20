<?php

class GraficaController extends Controller {

	protected $link;
	
	function __construct($model, $controller, $action, $type = 0) {

		parent::__construct($model, $controller, $action, $type);

		$this->link = $this->Grafica->getDBHandle();
	}
	
	function multifuente($arr) {
		$this->set('array',$arr);
	}

	function multifuente_op($arr,$ticks) {
		$p_location = ROOT.'/public/'; 

		$datay=$arr;
		$datay=rawurldecode($datay);
		$datay=unserialize($datay);

		require_once ($p_location.'jpgraph/jpgraph.php');
		require_once ($p_location.'jpgraph/jpgraph_line.php');

		$datay1 = $datay[0];
		$datay2 = $datay[1];
		$datay3 = $datay[2];
		$datay4 = $datay[3];

		//validadores
		$val1 = array_filter($datay[0]);
		$val2 = array_filter($datay[1]);
		$val3 = array_filter($datay[2]);
		$val4 = array_filter($datay[3]);
		
		$val5=array();

		foreach ($datay[4] as $key => $value) {
			if($ticks)
				array_push($val5, $this->Grafica->get_tema($value)["tema"]);
			else
				array_push($val5, $value);

		}

		// Setup the graph
		$graph = new Graph(450,600);
		//$graph = new Graph(600,450);
		$graph->SetScale("intlin",0,5);

		//$graph->img->SetCenter(floor(270/2),floor(170/2));

		$theme_class=new UniversalTheme;

		$graph->SetTheme($theme_class);
		$graph->img->SetAntiAliasing(false);
		$graph->title->Set("Visión 360 Grados");
		$graph->SetBox(false);

		$graph->img->SetAntiAliasing(false);
		$graph->img->SetAngle(90);

		$graph->yaxis->SetTickPositions(array(0,1,2,3,4,5), array(0.5,1.5,2.5,3.5,4.5));
		$graph->yaxis->HideZeroLabel();
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false,false);
		$graph->xaxis->scale->ticks->SetSide(SIDE_DOWN); 
		$graph->xaxis->SetTickLabels($val5);

		$graph->xgrid->Show();
		$graph->xgrid->SetLineStyle("solid");
		$graph->xgrid->SetWeight(1);
		//$graph->xaxis->SetTickLabels(array('A','B','C','D'));
		$graph->xgrid->SetColor('#E3E3E3');

		$col = 0;
		// Create the first line
		if($val1){
			$p1 = new LinePlot($datay1);
			$graph->Add($p1);
		    $p1->SetWeight(2); 
			$p1->SetColor("orange");
			$p1->SetLegend('Auto');
			$p1->value->Show();
			$p1->value->SetFormat('%01.2f'); 
			$col++;
		}

		// Create the second line
		if($val2){
			$p2 = new LinePlot($datay2);
			$graph->Add($p2);
		    $p2->SetWeight(2); 
			$p2->SetColor("blue");
			$p2->SetLegend('Gerente');
			$p2->value->Show();
			$p2->value->SetFormat('%01.2f'); 
			$col++;
		}

		// Create the third line
		if($val3){
			$p3 = new LinePlot($datay3);
			$graph->Add($p3);
		    $p3->SetWeight(2); 
			$p3->SetColor("red");
			$p3->SetLegend('Pares');
			$p3->value->Show();
			$p3->value->SetFormat('%01.2f'); 
			$col++;
		}


		// Create the fourth line
		if($val4){
			$p4 = new LinePlot($datay4);
			$graph->Add($p4);
		    $p4->SetWeight(2); 
			$p4->SetColor("green");
			$p4->SetLegend('Subalterno');
			$p4->value->Show();
			$p4->value->SetFormat('%01.2f'); 	
			$col++;
		}


		$graph->legend->SetFrameWeight(1);
		$graph->legend->SetColumns($col);

		$graph->Stroke(_IMG_HANDLER); 
		$fileName = $p_location."img/tmp/tmpres.png";
		$graph->img->Stream($fileName);
		return $fileName;
	}

	function gaficoPDFHorizontal($datos = array(), $nombres = array(), $nombreGrafico = NULL,$titulo = NULL){ 
		$p_location = ROOT.'/public/'; 
		include ($p_location."jpgraph/jpgraph.php");
		include ($p_location."jpgraph/jpgraph_bar.php");
		// Create the graph. These two calls are always required
		if(!is_array($datos) || !is_array($nombres) ){
			echo "los datos del grafico y la ubicacion deben de ser arreglos";
		}elseif($nombreGrafico == NULL){
			echo "debe indicar el nombre del grafico a crear";
		}else{ 
			#obtenemos los datos del grafico  
			foreach ($datos as $key => $value){
				$nombres[] = $key; 
			}
			// Se define el array de datos
			$datosy=$datos;
			$labels=$nombres;

			// Creamos el grafico
			$grafico = new Graph(700,500,'auto');
			$grafico->SetScale('textlin');

			// Ajustamos los margenes del grafico-----    (left,right,top,bottom)
			$grafico->SetMargin(40,30,30,40);
			$grafico->SetShadow();

			// Creamos barras de datos a partir del array de datos
			$bplot = new BarPlot($datosy);

			//Añadimos barra de datos al grafico
			$grafico->Add($bplot);

			// Configuramos color de las barras
			foreach ($datosy as $key => $value) {
				if ($value <= 1.65 ) $color[] = 'darkred';
				if (($value > 1.66) && ($value <= 3.32)) $color[]= 'yellow';
				if ($value > 3.32) $color[]= 'green';
			}
			$bplot->SetFillColor($color);
			$bplot->SetColor('black');
			
			// Queremos mostrar el valor numerico de la barra
			$bplot->value->Show();
			$bplot->value->SetFormat('%01.2f');


			// Configuracion de los titulos
			//$grafico->title->Set('Mi primer grafico de barras');
			//$grafico->xaxis->title->Set('Titulo eje X');
			//$grafico->yaxis->title->Set('Titulo eje Y');
			$grafico->xaxis->SetTickLabels($labels);

			$grafico->title->SetFont(FF_FONT1,FS_BOLD);
			$grafico->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
			$grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
			//mostramos el grafico en pantalla
			$grafico->Stroke(_IMG_HANDLER); 
			$fileName = $p_location."img/tmp/".$nombreGrafico.".png";
			$grafico->img->Stream($fileName);
		} 

	}
	
	function gaficoPDFVertical($datos = array(), $nombres = array(), $nombreGrafico = NULL,$j=NULL,$titulo = NULL){ 
		$p_location = ROOT.'/public/'; 
	//construccion de los arrays de los ejes x e y
		if(!is_array($datos) ||  !is_array($nombres) ){
			echo "los datos del grafico y la ubicacion deben de ser arreglos";
		}elseif($nombreGrafico == NULL){
			echo "debe indicar el nombre del grafico a crear";
		}else{ 
			#obtenemos los datos del grafico
			foreach ($datos as $key => $value){	
				$datos_g[]=$value[$j];
			}  
			foreach ($nombres as $a => $value) {
				$value = reset($value);
				$noms[] = $value;
			}
			// Se define el array de datos
			$datosy=$datos_g;
			$labels=$noms;
			// Creamos el grafico
			$grafico = new Graph(400,700);
			$grafico->SetAngle(90);
			$grafico->SetScale('textlin');

			// Ajustamos los margenes del grafico-----    (left,right,top,bottom)
			// The negative margins are necessary since we
			// have rotated the image 90 degress and shifted the 
			// meaning of width, and height. This means that the 
			// left and right margins now becomes top and bottom
			// calculated with the image width and not the height.
			$grafico->SetMargin(-80,-80,210,210);
			$grafico->SetShadow();

			// Creamos barras de datos a partir del array de datos
			$bplot = new BarPlot($datosy);
			// Configuramos color de las barras
			$bplot->SetFillColor('#479CC9');

			//$bplot->SetFillColor('red');

			//Añadimos barra de datos al grafico
			$grafico->Add($bplot);

			// Queremos mostrar el valor numerico de la barra
			$bplot->value->Show();
			$bplot->value->SetFormat('%01.2f');

			// Configuracion de los titulos
			$grafico->title->Set("$nombreGrafico");
			//$grafico->xaxis->title->Set('Titulo eje X','left');
			//$grafico->yaxis->title->Set('Titulo eje Y','right'); 
			$grafico->xaxis->SetTickLabels($labels);
			$grafico->xaxis->SetLabelAlign('left');
			//$grafico->xaxis->SetColor('red');

			$grafico->title->SetFont(FF_FONT1,FS_BOLD);
			$grafico->yaxis->title->SetFont(FF_FONT2,FS_BOLD);
			$grafico->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
			//mostramos el grafico en pantalla

			$grafico->Stroke(_IMG_HANDLER); 
			$fileName = $p_location."img/tmp/".$nombreGrafico.".png";
			$grafico->img->Stream($fileName);  
		} 
	}	



}






