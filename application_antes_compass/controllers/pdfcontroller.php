<?php



class PdfController extends Controller {



	protected $link;

	protected $grafica;

	protected $location;

	protected $dir;

	

	function __construct($model, $controller, $action, $type = 0) {

		parent::__construct($model, $controller, $action, $type);

		$this->link = $this->Pdf->getDBHandle();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

	}



	function multifuente($id,$eval){

		Util::sessionStart();

		$this->dir=$this->location.'multifuente'.DS.str_replace(" ", "_", $_SESSION['Empresa']['nombre']);

		$id  = mysqli_real_escape_string($this->link,$id);

		$eval = mysqli_real_escape_string($this->link,$eval);

		$pdf = new pdf_multifuente();

		self::paginas_inicio($id,$eval,$pdf);

		self::addPage($id,$eval,$pdf); 

		$res = $this->Pdf->query_('SELECT `cod_evaluado`, `cod_test`,`resuelto`,`fecha` FROM `multifuente_evaluado` WHERE `id_personal`='.$id.' AND `cod_evaluado`="'.$eval.'" ',1);

		// $res = reset($res);

		$cod_test = $res['cod_test'];

		$cod_evaluado = $res['cod_evaluado'];

		$res = $this->Pdf->query("SELECT DISTINCT cod_tema from multifuente_respuestas where cod_test ='".$cod_test."' and cod_evaluado = '".$cod_evaluado."' order by cod_tema asc");

		if($res){

			$contador=1;

			foreach ($res as $a => $b) {

				$b=reset($b);

				$b=reset($b);

				if ($contador%12 == 0 ){

					$pdf->Rect(10,74,190,(15*($contador-1)),'D') ; 

					$contador=1;

					self::addPage($id,$eval,$pdf); 

					$pdf->Cell(190,10,"Competencias Evaluadas",1,0,'C'); 

					$pdf->Line(10,74,200,74); 

				}

				$pdf->SetY(60+(15*$contador)); 

				$temas = $this->Pdf->get_tema($b);

				$tema = $this->Pdf->htmlprnt_win($temas['tema']);

				$pdf->Multicell(40,3,$tema,0,'L',false);    

				$pdf->SetY(60+(15*$contador));  

				$pdf->SetX(50);  

				$pdf->SetFont('Times','',10);

				$desc = str_replace(".- ","",$temas['descripcion']);

				$desc = $this->Pdf->htmlprnt_win($desc);

				$pdf->Multicell((150),3,$desc,0,'L',false);   

				$pdf->Line(10,74+(15*$contador),200,74+(15*$contador));

				$contador++;

			}

			$pdf->Rect(10,74,190,(15*($contador-1)),'D');

			self::addPage($id,$eval,$pdf); 

			$res_rango = $this->Pdf->query('Select distinct rango from multifuente_respuestas where cod_evaluado ="'.$eval.'" order by rango');

			$tot_rango = sizeof($res_rango)+1;

			$array_valores = array();

			$array_valores_num  = array();

			$array_valores_numfijo  = array();

			foreach ($res_rango as $c => $d) {

				$d=reset($d);

				$array_nombres[] = $d['rango'];

				$array_valores[] = $this->Pdf->getAvg_test_eval_rango($eval,$d['rango']);

				$array_valores_numfijo[]= $this->Pdf->getNum_eval_rango($eval,$d['rango']);

				$array_valores_num[]= $this->Pdf->getNum_eval_rango($eval,$d['rango']);



			}

			$array_nombres[] = "GPS";

			$array_valores[] = $this->Pdf->getAvg_test_eval($eval);

			$pdf->SetFont('Times','B',8);

			$pdf->Multicell(40,30,"RESULTADO GENERAL",1,'L',false); 

			$pdf->SetY(64);  

			$pdf->SetX(50); 

			$pdf->Multicell(75,5,'RESULTADOS POR CATEGORÍA DE EVALUADORES O RESPONDENTES',1,'L');

			$pdf->SetY(64);  

			$pdf->SetX(125);

			$pdf->Multicell(75,5,'NÚMERO DE EVALUADORES O RESPONDENTES POR CATEGORÍA',1,'L');

			$pdf->SetY(74);  

			$pdf->SetX(50); 

			$ancho = 75/$tot_rango;

			$ancho2 = 75/($tot_rango-1);

			self::listar_evaluadores($array_nombres,$pdf,$ancho,$ancho2);

			$pdf->SetY(84);   

			$pdf->SetX(50);

			foreach ( $array_valores as $key => $value ){

				self::setColor($value,$pdf,$ancho);

			}

			foreach ( $array_valores_num as $key => $value ){

				$pdf->cell($ancho2,10,"$value",1,0,'C',false); 

			}	

			$grafica = new GraficaController('Grafica','grafica','gaficoPDFHorizontal');

			$grafico_barra = "Grafica";

			$grafica->gaficoPDFHorizontal($array_valores, $array_nombres ,$grafico_barra,'grafico');

			$ubicacionTamamo=array(30,122,150,100);

			$x = $ubicacionTamamo[0];

			$y = $ubicacionTamamo[1]; 

			$ancho_img = $ubicacionTamamo[2];  

			$altura = $ubicacionTamamo[3];  

			$pdf->Image("./img/tmp/".$grafico_barra.".png",$x,$y,$ancho_img,$altura); 

			//PAGINA 7

			self::addPage($id,$eval,$pdf); 

			$pdf->SetFont('Times','B',8);

			$pdf->Multicell(60,20,"COMPETENCIAS ",1,'L',false); 

			$pdf->SetY(64);  

			$pdf->SetX(70); 

			$pdf->Multicell(65,10,'RESULTADOS POR COMPETENCIA',1,'L');

			$pdf->SetY(64);  

			$pdf->SetX(135); 

			$pdf->Multicell(65,5,'NÚMERO DE EVALUADORES O RESPONDENTES POR CATEGORÍA',1,'L');

			$pdf->SetY(74);  

			$pdf->SetX(70); 

			$ancho = 65/$tot_rango ;

			$ancho2 = 65/($tot_rango-1) ;

			self::listar_evaluadores($array_nombres,$pdf,$ancho,$ancho2);

			$pdf->Ln(10);

			$salyo_y = 42;

			foreach ( $res as $key => $cod ){

				$cod=reset($cod);

				$cod=reset($cod);

				$temas = $this->Pdf->get_tema($cod);

				$tema = $this->Pdf->htmlprnt_win($temas['tema']);

				$pdf->cell(60,10,"$tema",1,0,'L',false); 

				// Buscara los rangos en las respuestas correspondientes

				$array_valores2 = array();

				$array_valores_num2 = array();

				foreach ($res_rango as $none => $rango) {

					$rango=reset($rango);

					$rango=reset($rango);

					// Se sacaran los valores por cada rango encontrado

					$res_rango_val = $this->Pdf->getAvg_tema_eval_rango($cod,$eval,$rango);

					$array_valores2[]= $res_rango_val;

					$array_test[$key][] = $res_rango_val;

				} 

				$array_test_name[$key][] = $tema;

				$t = $key++;

				$array_test[$t][] = $this->Pdf->getAvg_tema_eval($cod,$eval);

				$array_valores2[]=$this->Pdf->getAvg_tema_eval($cod,$eval);

				foreach ( $array_valores2 as $key => $value ){

					self::setColor($value,$pdf,$ancho);

				}

				foreach ( $array_valores_numfijo as $key => $value){

					$pdf->cell($ancho2,10,"$value",1,0,'C',false); 

				} 

				$pdf->Ln(10);

			} 

			//PAGINA 8

			self::addPage($id,$eval,$pdf); 

			$k=0;

			$l=0;

			$tamanio = (sizeof($array_nombres));

			for ( $j=0; $j<$tamanio; $j++){

				if ($k==0){

					$y =  62; 

					$x =  15;  

				}elseif ($k==1){

					$y =  62; 

					$x = (60*1) + 15;  

				}elseif ($k==2){

					$y =  62; 

					$x = (60*2) + 15;   

				}elseif ($k==3){

					$y = (110*1) + 62; 

					$x =  15;  

				}elseif ($k==4) {

					$y = (110*1) + 62;

					$x = (60*1) + 15; 

				}

				$ancho_img = 50;  

				$altura = 100; 

				$grafica->gaficoPDFVertical($array_test, $array_test_name ,$array_nombres[$j],$j,'2');

				$pdf->Image("./img/tmp/".$array_nombres[$j].".png",$x,$y,$ancho_img,$altura); 

				$k++;

			}

			//PAGINA POR PREGUNTAS DE COMPETENCIA

			foreach ( $res as $key => $cod ){

				$cod=reset($cod);

				$cod=reset($cod);

				self::addPage($id,$eval,$pdf); 

				$pdf->SetFont('Times','B',8);

				$pdf->Multicell(60,10,"COMPORTAMIENTOS OBSERVABLES POR PREGUNTAS  ",1,'L',false); 

				$pdf->SetY(64);  

				$pdf->SetX(70); 

				$pdf->Multicell(65,5,'RESULTADOS POR COMPORTAMIENTO OBSERVABLE ',1,'L');

				$pdf->SetY(64);  

				$pdf->SetX(135); 

				$pdf->Multicell(65,5,'NÚMERO DE EVALUADORES O RESPONDENTES POR CATEGORÍA',1,'L');

				$pdf->SetY(74);  

				$pdf->SetX(70); 

				self::listar_evaluadores($array_nombres,$pdf,$ancho,$ancho2);

				$pdf->Ln(10);

				$salyo_y = 42;

				$temas = $this->Pdf->get_tema($cod);

				$tema = $this->Pdf->htmlprnt_win($temas['tema']);

				$pdf->cell(60,10,"$tema",1,0,'L',false); 

				// Buscara los rangos en las respuestas correspondientes

				$res_rango;

				$array_valores2 = array();

				$array_valores_num2 = array();

				foreach ($res_rango as $none => $rango) {

					$rango=reset($rango);

					$rango=reset($rango);

					// Se sacaran los valores por cada rango encontrado

					$res_rango_val = $this->Pdf->getAvg_tema_eval_rango($cod,$eval,$rango);

					$array_valores2[]= $res_rango_val;

					$array_test[$key][] = $res_rango_val;

				} 

				$array_test_name[$key][] = $tema;

				$t = $key++;

				$array_test[$t][] = $this->Pdf->getAvg_tema_eval($cod,$eval);

				$array_valores2[]=$this->Pdf->getAvg_tema_eval($cod,$eval);

				foreach ( $array_valores2 as $key => $value ){

					self::setColor($value,$pdf,$ancho);

				}

				foreach ( $array_valores_numfijo as $key => $value){

					$pdf->cell($ancho2,10,"$value",1,0,'C',false); 

				} 

				$pdf->Ln(10);

				//PREGUNTAS

				$cod_preguntas =  $this->Pdf->query("Select DISTINCT cod_pregunta from multifuente_respuestas where cod_tema = '".$cod."' AND cod_test ='".$cod_test."' and cod_evaluado = '".$eval."'");

				$pdf->SetFont('Times','B',8);

				foreach ($cod_preguntas as $c => $d) {

					$d = reset($d);

					$preg = $d['cod_pregunta'];

					$pregunta = $this->Pdf->get_pregPDF($preg);

					$pregunta = $this->Pdf->htmlprnt_win($pregunta);

					$current_y = $pdf->GetY();

					$current_x = $pdf->GetX();

					$h = $pdf->GetMultiCellHeight(60,5,"$pregunta",1,'L',false);

					$pdf->Multicell(60,5,"$pregunta",1,'L',false);

					$cell_width = 60;

					$pdf->SetXY($current_x + $cell_width, $current_y);	

					// Buscara los rangos en las respuestas correspondientes

					$array_valores3 = array();

					foreach ($res_rango as $none => $rango) {

						$rango=reset($rango);

						$rango=reset($rango);

						// Se sacaran los valores por cada rango encontrado

						$res_rango_val = $this->Pdf->getAvg_preg_rang($preg,$eval,$rango);

						$array_valores3[]= $res_rango_val;

					}

					$array_valores3[]=$this->Pdf->getAvg_preg_eval($preg,$eval);

					foreach ( $array_valores3 as $key => $value ){

						self::setColor($value,$pdf,$ancho,$h);

					}

					foreach ( $array_valores_numfijo as $key => $value){

						$pdf->cell($ancho2,$h,"$value",1,0,'C',false); 

					}

					$pdf->SetY($h + $current_y);

					$pdf->Ln(0);

				}

			} 

			$preguntas = $this->Pdf->query('SELECT DISTINCT a.cod_pregunta

				FROM `multifuente_respuestas` as a

				INNER JOIN `preguntas_360` as b

				ON a.cod_pregunta = b.cod_pregunta

				WHERE a.cod_evaluado="'.$cod_evaluado.'"');

			$fortalezas=array();

			foreach ($preguntas as $a => $b) {

				$b = reset($b);

				$b = reset($b);

				foreach ($array_nombres as $c => $rango) {

					$res_fortaleza = $this->Pdf->getAvg_preg_rang($b,$eval,$rango);

					$fortalezas[$rango]['respuesta'][$a] = $res_fortaleza; 

					$fortalezas[$rango]['cod_preguna'][$a] = $b; 

				}

			}

			$oportunidades = $fortalezas;

			array_pop($array_nombres);

			$tot_rango = sizeof($array_nombres);

			$ancho3 = 190/$tot_rango ;

			$pdf->Ln(5);

			$algo = 7;

			$cell_width = $ancho3-$algo;	

			$table_width=array();

			for ($y=0; $y < $tot_rango; $y++) {

				array_push($table_width,$algo);

				array_push($table_width,$cell_width);

			}

			//PAGINA FORTALEZAS

			self::addPage($id,$eval,$pdf); 

			$pdf->SetFont("Arial","B",9);

			$pdf->cell(190,5,"RESUMEN DE LOS 10 COMPORTAMIENTOS DE MÁS ALTO PUNTAJE POR CATEGORÍA DE EVALUADOR O RESPONDENTE:",1,'L',false); 

			$pdf->Ln(5);

			foreach ($array_nombres as $c => $rango) {

				$pdf->cell($ancho3,5,$rango,1,'R',false);

				arsort($fortalezas[$rango]['respuesta']);

				$count=0;

				foreach ($fortalezas[$rango]['respuesta'] as $key => $value) {

					$final[$rango][$count] = array('preg' => $fortalezas[$rango]['cod_preguna'][$key],'val' => $value);

					if($count==9)

						break;

					$count++;

				}

			}

			$pdf->Ln(5);

			$pdf->SetFont("Arial","",6);

			$pdf->SetWidths($table_width);

			for ($i=0; $i < 10; $i++) {

				$val=$final[$rango][$i]['val'];

				$row=array();

				foreach ($array_nombres as $c => $rango) {

					if ($val > 3.33){

						$preg = $final[$rango][$i]['preg'];

						$pregunta = $this->Pdf->get_pregPDF($preg);

						$pregunta = $this->Pdf->htmlprnt_win($pregunta);

						if($pregunta != ''){

							array_push($row,round($val,2));	

							array_push($row,$pregunta);	

						}else{

							array_push($row,"");	

							array_push($row,"");	

						}

					}

				}

				$pdf->Row($row,4);

			}

			//PAGINA OPORTUNIDADES

			$pdf->Ln(10);

			$pdf->SetFont("Arial","B",9);

			$pdf->cell(190,5,"RESUMEN DE LOS 10 COMPORTAMIENTOS DE PUNTAJE MÁS BAJO POR CATEGORÍA DE EVALUADOR O RESPONDENTE:",1,'L',false); 

			$pdf->Ln(5);

			foreach ($array_nombres as $c => $rango) {

				$pdf->cell($ancho3,5,$rango,1,'R',false);

				asort($oportunidades[$rango]['respuesta']);

				$count=0;

				foreach ($oportunidades[$rango]['respuesta'] as $key => $value) {

					$final[$rango][$count] = array('preg' => $oportunidades[$rango]['cod_preguna'][$key],'val' => $value);

					if($count==9)

						break;

					$count++;

				}

			}

			$pdf->Ln(5);

			$pdf->SetFont("Arial","",6);

			for ($i=0; $i < 10; $i++) {

				$val=$final[$rango][$i]['val'];

				$row=array();

				foreach ($array_nombres as $c => $rango) {

					if ($val < 3.33){

						$preg = $final[$rango][$i]['preg'];

						$pregunta = $this->Pdf->get_pregPDF($preg);

						$pregunta = $this->Pdf->htmlprnt_win($pregunta);

						if($pregunta != ''){

							array_push($row,round($val,2));	

							array_push($row,$pregunta);	

						}else{

							array_push($row,"");	

							array_push($row,"");	

						}

					}

				}

				$pdf->Row($row,4);

			}

			self::addPage($id,$eval,$pdf);  

			$pdf->SetFont("Arial","B",9);

			$pdf->cell(190,5,"Comentarios del Evaluado:",0,'L',false); 

			$pdf->Ln(10);

			$fortalezas=$this->Pdf->query_('SELECT distinct(fortalezas) FROM `multifuente_respuestas` where cod_evaluado="'.$eval.'";');

			if($fortalezas){

				$pdf->SetFont("Arial","B",9);

				$pdf->cell(190,5,"Fortalezas:",0,'L',false); 

				$pdf->Ln(10);

				$pdf->SetFont("Arial","",8);

				foreach ($fortalezas as $key => $value) {

					$pdf->cell(190,5,$this->Pdf->htmlprnt_win($value['fortalezas']),0,'L',false); 

					$pdf->Ln(5);

				}

			}

			$debilidades=$this->Pdf->query_('SELECT distinct(debilidades) FROM `multifuente_respuestas` where cod_evaluado="'.$eval.'";');

			if($debilidades){

				$pdf->SetFont("Arial","B",9);

				$pdf->cell(190,5,"Debilidades:",0,'L',false); 

				$pdf->Ln(10);

				$pdf->SetFont("Arial","",8);

				foreach ($debilidades as $key => $value) {

					$pdf->cell(190,5,$this->Pdf->htmlprnt_win($value['debilidades']),0,'L',false); 

					$pdf->Ln(5);

				}

			}

			$comentarios=$this->Pdf->query_('SELECT distinct(comentarios) FROM `multifuente_respuestas` where cod_evaluado="'.$eval.'";');

			if($comentarios){

				$pdf->SetFont("Arial","B",9);

				$pdf->cell(190,5,"Comentarios:",0,'L',false); 

				$pdf->Ln(10);

				$pdf->SetFont("Arial","",8);

				foreach ($comentarios as $key => $value) {

					$pdf->cell(190,5,$this->Pdf->htmlprnt_win($value['comentarios']),0,'L',false); 

					$pdf->Ln(5);

				}

			}

		}

		$nombre = $this->Pdf->get_pname($id);

		$nombre = str_replace(" ", "", $nombre);

		self::makeDir($this->dir);

		$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');

	}



	function paginas_inicio($id,$eval,$pdf){

		Util::sessionStart();

		$d_emp = $this->Pdf->get_empdat($id,$eval);

		$evaluado_preguntas =  $eval;



		$nameCab = $d_emp[0];

		$fechaCab = $d_emp[4];

		//$usernameCab = 

		$cargoCab = $d_emp[1];

		$departamentoCab = $d_emp[2];

		$empresaCab = $_SESSION['Empresa']['nombre'];



		$fechaCab = $this->Pdf->print_fecha($d_emp[4]);

		$supervisorCab = $d_emp[3];





		//Hoja Presentacion

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12); 

		$pdf->Ln(12);

		$pdf->Image(BASEURL.'public/img/primera.png',45,50,112,44);

		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'C');

		$pdf->Ln(70);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"PERSONA:",0,0,'L');

		$pdf->Cell(100,10,"$nameCab",0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"CARGO:",0,0,'L');

		$pdf->Cell(100,10,"$cargoCab",0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"EMPRESA:",0,0,'L');

		$pdf->Cell(100,10,"$empresaCab",0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"FECHA:",0,0,'L');

		$pdf->Cell(100,10,"$fechaCab",0,0,'L');



		//Primera Hoja

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Ln(12);

		$pdf->Cell(190,10,"CONTENIDO DEL REPORTE",0,0,'C');

		$pdf->Ln(20);

		$pdf->Cell(190,10,"GUIA PARA EL MEJOR APROVECHAMIENTO DE ESTE REPORTE",0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(190,10,"RESULTADO GENERAL",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"RESULTADOS POR COMPETENCIA",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"NÚMERO DE EVALUADORES O RESPONDENTES POR CATEGORÍA",0,0,'L');

		$pdf->Ln(20);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(190,10,"COMPORTAMIENTOS OBSERVABLES Ó PREGUNTAS",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"RESULTADOS POR COMPORTAMIENTO OBSERVABLE",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"NÚMERO DE EVALUADORES O RESPONDENTES POR CATEGORÍA",0,0,'L');

		$pdf->Ln(20);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(190,5,"RESUMEN DE LOS 10 COMPORTAMIENTOS DE MÁS BAJO PUNTAJE POR CATEGORÍA",0,0,'L');

		$pdf->Ln(5);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(190,10,"DE EVALUADOR O RESPONDENTE:",0,0,'L');

		$pdf->Ln(20);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(190,5,"COMENTARIOS VOLUNTARIOS DE LOS EVALUADORES O RESPONDENTES:",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"FORTALEZAS",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"ÁREA DE MEJORA",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"COSAS QUE AYUDARÍAN",0,0,'L');

		//Aquí escribimos lo que deseamos mostrar...





		//Segunda Hoka

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Ln(12);

		$pdf->Cell(190,10,"GUIA PARA EL MEJOR APROVECHAMIENTO DE ESTE REPORTE",0,0,'L');

		$pdf->Ln(15);

		$pdf->SetFont('Times','',10);

		$pdf->Cell(190,10,"Esta sección le ayudará a observar de una forma más eficaz los datos que resumen la retroalimentación que el personal que",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"interactúa con usted cotidianamente le ha dado ha través de este sistema.",0,0,'L');

		$pdf->Ln(15);

		$pdf->Cell(190,10,"Tenga presente en todo momento que la retroalimentación aquí proporcionada por sus colegas está basada en la madurez",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"y el profesionalismo y está orientada ha mostrarle de una manera objetiva sus oportunidades de mejorar su efectividad",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"personal y desarrollar su potencial.",0,0,'L');

		$pdf->Ln(15);

		$pdf->Cell(190,10,"Escala de Calificación.- La escala es de 1 a 5 y los resultados que usted apreciará son todos promedios excepto en el caso de",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"la Autoevaluación y la evaluación de su Jefe ya que en ambos casos solo hay un Evaluador (usted y su jefe).",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"Se ha utilizado el sistema internacional de codificación de colores del semáforo para destacar los datos según las siguientes",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"categorías:",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->SetFillColor(0,250,0);

		$pdf->Cell(10,10,"",1,0,'L',true);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(30,10,"Favorable",0,0,'L');

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(80,10,"Rango de puntaje entre 3,3331 y 5.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->SetFillColor(250,250,0);

		$pdf->Cell(10,10,"",1,0,'L',true);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(30,10,"Requiere atención",0,0,'L');

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(80,10,"Rango de puntaje entre 1,6666 y 3,3330.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->SetFillColor(250,0,0);

		$pdf->Cell(10,10,"",1,0,'L',true);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(30,10,"Clara oportunidad",0,0,'L');

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(80,10,"Rango de puntaje entre 1 y 1,6665.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"Las competencias evaluadas son un conjunto de Conocimientos y Habilidades que con la correspondiente motivación, son",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"puestas en práctica cotidianamente y generan resultados deseables para la organización.",0,0,'L');

		$pdf->Ln(15);

		$pdf->Cell(190,10,"Cada una de estas competencias está conformada por un grupo de conductas o comportamientos y cada una de estas tiene",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"un puntaje de acuerdo a las calificaciones dadas por cada evaluador. Por consiguiente el puntaje para cada Competencia es",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"el promedio de los puntajes de cada pregunta/comportamiento observable correspondiente y el puntaje General es el",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"promedio de los puntajes de cada Competencia.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"Todos los resultados se muestran en 5 columnas y corresponden a:",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(180,10,"Autoevaluación, Gerente, Pares, Subalernos y GPS (Gerente, Pares y Subalternos)",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"Como puede apreciarse, el Promedio GPS excluye la califiación correspondiente a la Autoevaluación. En todo caso, para",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"efectos de determinación de consistencia en general, ha de compararse la Autoevaluación contra el Promedio GPS, y en la",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"medida en que estos datos coincidan o se aproximen, se tendrá como un mayor estado de conciencia del Autoevaluado con",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"respecto a la competencia y/o comportamiento evaluado y viceversa, la falta de coincidencia solo implica una falta de",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"conciencia sobre la competencia evaluada y sobre todo de cómo es percibida por otros.",0,0,'L');







		//Tercera Hoja

		$pdf->AddPage();

		$pdf->Ln(12);

		$pdf->Cell(190,10,"Se puede apreciar tambien el número promedio de Evaluadores por categoría (Autoevaluación, Gerente, Pares y Subalternos)",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"Un número fraccionado indica que alguna pregunta no fue respondida por no poseer el Evaluador suficiente experiencia",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"como para contestar. Los \"ceros\" (0) con un fondo blanco en el reporte de datos en las columnas correspondientes a",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"Autoevaluación y Gerente (por corresponder solo a un Evaluador) indican que esa pregunta fue dejada sin contestar por la",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"razón ya indicada (aun por el Autoevaluado) o que no hay esa categoría de Evaluadores (Subalternos en muchos casos).",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"A manera de resumen, se muestran los 10 comportamientos con puntajes más altos y los 10 con puntajes más bajos.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"Adicionalmente, se muestran los comentarios escritos por los Evaluadores sobre sus Fortalezas y Debilidades así como las",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"Recomendaciones de ellos para usted.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"Finalmente, este reporte es solo un documento parcial; la verdadera riqueza de la Retroalimentación y la consecuencia de",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"la misma es el Plan de Acción que usted y su jefe deben desarrollar. Para este propósito, debe ingresar al sitio web",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"www.altodesempenio.com con su Usuario y Contraseña a fin de trabajar esta información y general el indicado plan de acción.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"En caso de requerir asistencia adicional por favor no dude en contactarnos.",0,0,'L');

	}



	function cabecera($id,$eval,$pdf){

		Util::sessionStart();

		$d_emp = $this->Pdf->get_empdat($id,$eval);

		$evaluado_preguntas =  $eval;



		$nameCab = $d_emp[0];

		$fechaCab = $d_emp[4];

		$cargoCab = $d_emp[1];

		$departamentoCab = $d_emp[2];

		$empresaCab = $_SESSION['Empresa']['nombre'];



		$fechaCab = $this->Pdf->print_fecha($d_emp[4]);

		$supervisorCab = $d_emp[3];

		$pdf->SetX(80); 

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(150,10,"REPORTE DE RESULTADOS ",0,0,'L');

		$pdf->Ln(12);

		$pdf->SetFont('Times','B',8);

		$pdf->Cell(60,10,"PERSONA: $nameCab",1,0,'L');

		$pdf->Cell(60,10,"CARGO: $cargoCab",1,0,'L');

		$pdf->Cell(70,10,"SUPERVISOR DIRECTO: $supervisorCab",1,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(60,10,"EMPRESA: $empresaCab",1,0,'L');

		$pdf->Cell(60,10,"DEPARTAMENTO: $departamentoCab",1,0,'L');

		$pdf->Cell(70,10,"FECHA DE EVALUACION: $fechaCab",1,0,'L');

		$pdf->Ln(20);

	}



	function addPage($id=null,$eval=null,$pdf){

		$pdf->AddPage();

		$pdf->Ln(12);

		if($id != null){

			self::cabecera($id,$eval,$pdf);

		}

		$pdf->SetFont('Times','B',10);

	}



	function listar_evaluadores($array_nombres,$pdf,$ancho,$ancho2){

		foreach ( $array_nombres as $key => $value ){

			$pdf->cell($ancho,10,"$value",1,0,'C',false);

		}

		foreach ( $array_nombres as $key => $value ){

			if (strcmp($value,"GPS")!=0){

				$pdf->cell($ancho2,10,"$value",1,0,'C',false);

			}

		}

	}



	function setColor($valor,$pdf,$ancho,$h=10){

		$valor = round($valor,2); 

		if ( $valor >0 ) {

			if ( ($valor>3.3331) ) $pdf->SetFillColor(0,250,0);

			if ( ($valor>1.6666)&&($valor<3.3330) ) $pdf->SetFillColor(250,250,0);

			if ( ($valor<1.6665) ) $pdf->SetFillColor(250,0,0);

			$pdf->cell($ancho,$h,"$valor",1,0,'C',true);

		}else{

			$pdf->cell($ancho,$h,"",1,0,'C',false);

		}

	}



	function sonda($id_s, $filtros="", $arrTema=""){

		$arrTema = stripslashes($arrTema);
		$arrTema = urldecode($arrTema );
		$arrTema = unserialize($arrTema);

		Util::sessionStart();

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$pdf = new pdf_sonda();

		self::paginas_inicio_sonda($pdf);

		//PAGINA FILTROS

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"FILTROS SELECCIONADOS",0,0,'C');

		$pdf->SetFont('Times','',12);

		$filtros = str_replace("'", "", $filtros);

		$filtros = str_replace("*", "/", $filtros);

		$filtros = str_replace("+", " ", $filtros);

		$filtros = ($filtros=="''") ? "Todos" : $filtros;

		$filtros = explode("<br>", $filtros);

		foreach ($filtros as $fil_key => $fil_val) {

			if ($fil_val != 'Todos') {

				$fil_true_key = explode(":", $fil_val);

				if (array_filter($fil_true_key)) {

					$pdf->SetFont('Times','B',12);

					$pdf->Ln(15);

					$pdf->Cell(60,10,$fil_true_key[0].":",0,0,'L');

					$pdf->SetFont('Times','',12);

					$fil_true_key[1] = explode(",", $fil_true_key[1]);

					foreach ($fil_true_key[1] as $ftk_key => $ftk_val) {	

						if($ftk_key!=0)

							$pdf->Cell(60,10,"",0,0,'L');

						$pdf->Cell(120,10,$ftk_val,0,0,'L');

						$pdf->Ln(5);

					}

				}
			}else{

				$pdf->SetFont('Times','B',12);

				$pdf->Ln(15);
				
				$pdf->Cell(60,10,$fil_val,0,0,'L');
			}

		}
		
		//REPORTE RESULTADOS

		$pdf->SetMargins(10,25,0);

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

		$pdf->SetFont('Times','',8);

		$sonda = new Sonda();

		$sonda->select_($_SESSION['Empresa']['id'], $id_s);

		$seg = $sonda->getSegmentacion();

		$z = new Sonda_user();

		$x = new Sonda_tema();

		$y = new Sonda_pregunta();

		$w = new Sonda_respuesta();

		$args=$_SESSION['args'];

		$ids = $z->get_id_x_empresa($id_s, $_SESSION['Empresa']['id'],$args);

		$c_e=$z->count_evaluados($args);

		$temas = $sonda->getTemas();

		$indice = 1;

		$promedio_general = array();

		$preguntas = $preguntas_general = '';

		// Resultados test general

		foreach ($temas as $key => $value) {

			if (isset($arrTema) && is_array($arrTema)) {
				if (in_array($key, $arrTema)) {

					$x->select($key);

					$tema_nombre = ucfirst($x->getTema_());

					$tema_id = $x->getId();

					if ($indice==1){

						$pdf->SetY(45+(10*$indice));

						$pdf->SetFont('Times','B',10);

						$pdf->Cell(190,10,'Factores',1,0,'L');

						$pdf->Ln();
					}

					$pdf->Cell(10,25,$indice,1,0,'C');

					$yy = $pdf->GetY();

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(105,10,$tema_nombre,0,2,'L');

					$pdf->SetFont('Times','',10);

					$pdf->Multicell(105,5,$x->getDescripcion_(),0,'L',false);

					$pdf->Line(20,25+($yy),200,25+($yy));

					$preguntas = implode(",", $temas[$key]);

					$preguntas_general .= implode(",", $temas[$key]).',';

					$promedio = $w->get_avg_x_tema($ids,$preguntas);

					$porcentajes = $w->get_percent($ids,$preguntas);

					array_push($promedio_general, $promedio);

					if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetY($yy);

					$pdf->SetX(125);

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

					$pdf->SetFillColor(250,250,250);

					$pdf->SetFont('Times','',9);
					$pdf->SetY($yy);

					for ($i=0; $i < count($porcentajes); $i++) {
						$ancho = ($porcentajes[$i] * 60) / 100;
						$ancho = ($ancho == 0) ? 0.5 : $ancho;

						if($i==0)
							$pdf->SetFillColor(255,0,0);
						if($i==1)
							$pdf->SetFillColor(255,255,0);
						if($i==2)
							$pdf->SetFillColor(50,205,50);
						if($i==3)
							$pdf->SetFillColor(204,204,204);

						$pdf->SetX(135);
						$pdf->Cell($ancho,6.25,'',1,0,'L',true);

						$pdf->SetFillColor(250,250,250);
						$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
					}

					$pdf->SetY($yy + 25);

					$indice++;
				}
			}else{
				
				$x->select($key);

				$tema_nombre = ucfirst($x->getTema_());

				$tema_id = $x->getId();

				if ($indice==1){

					$pdf->SetY(45+(10*$indice));

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(190,10,'Factores',1,0,'L');

					$pdf->Ln();
				}

				

				$pdf->Cell(10,25,$indice,1,0,'C');

				$yy = $pdf->GetY();
				
				$pdf->SetFont('Times','B',10);

				$pdf->Cell(105,10,$tema_nombre,0,2,'L');
				
				$pdf->SetFont('Times','',10);

				$pdf->Multicell(105,5,$x->getDescripcion_(),0,'L',false);
				
				$pdf->Line(20,25+($yy),200,25+($yy));
				
				$preguntas = implode(",", $temas[$key]);

				$preguntas_general .= implode(",", $temas[$key]).',';

				$promedio = $w->get_avg_x_tema($ids,$preguntas);

				$porcentajes = $w->get_percent($ids,$preguntas);

				array_push($promedio_general, $promedio);

				if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

				if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

				if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

				$pdf->SetY($yy);

				$pdf->SetX(125);

				$pdf->SetFont('Times','B',10);

				$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

				$pdf->SetFillColor(250,250,250);
				
				$pdf->SetFont('Times','',9);
				$pdf->SetY($yy);

				for ($i=0; $i < count($porcentajes); $i++) {
					$ancho = ($porcentajes[$i] * 60) / 100;
					$ancho = ($ancho == 0) ? 0.5 : $ancho;

					if($i==0)
						$pdf->SetFillColor(255,0,0);
					if($i==1)
						$pdf->SetFillColor(255,255,0);
					if($i==2)
						$pdf->SetFillColor(50,205,50);
					if($i==3)
						$pdf->SetFillColor(204,204,204);

					$pdf->SetX(135);
					$pdf->Cell($ancho,6.25,'',1,0,'L',true);

					$pdf->SetFillColor(250,250,250);
					$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
				}
				
				$pdf->SetY($yy + 25);
				
				$indice++;
			}
		}
		
		$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

		if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

		if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

		if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

		$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

		$pdf->SetFillColor(250,250,250);

		$pdf->SetFont('Times','',9);

		$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

		$preguntas_general = substr($preguntas_general, 0, -1);
		$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
		$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

		for ($i=0; $i < count($porcentajes_generales); $i++) {
			$ancho = ($porcentajes_generales[$i] * 60) / 100;
			$ancho = ($ancho == 0) ? 0.5 : $ancho;

			if($i==0)
				$pdf->SetFillColor(255,0,0);
			if($i==1)
				$pdf->SetFillColor(255,255,0);
			if($i==2)
				$pdf->SetFillColor(50,205,50);
			if($i==3)
				$pdf->SetFillColor(204,204,204);

			$pdf->SetX(135);
			$pdf->Cell($ancho,6.25,'',1,0,'L',true);
			
			$pdf->SetFillColor(250,250,250);
			$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
		}

		

		// RESULTADOS POR TEMAS Y PREGUNTAS

		foreach ($temas as $key => $value) {

			$x->select($key);

			$tema_nombre = ucfirst($x->getTema_());

			if (isset($arrTema) && is_array($arrTema)) {
				
				if (in_array($key, $arrTema)) {

					$indice=1;
					
					$pdf->AddPage();

					$pdf->SetFont('Times','B',12);

					$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

					$pdf->Ln(15);

					$pdf->Cell(170,10,"RESULTADOS POR TEMAS",0,0,'C');

					$pdf->SetY(45+(10*$indice));

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(190,10,$tema_nombre,1,0,'L');

					$pdf->Ln();

					$preguntas = $temas[$key];

					$promedio_general=array();

					foreach ($preguntas as $p_key => $p_value) {

						$y->select($p_value);

						$id_p = $y->getId();

						$promedio = $w->get_avg_x_pregunta($ids,$id_p);

						array_push($promedio_general, $promedio);

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

						$preguntas_general .= $p_value.',';

						//

						$pdf->SetFont('Times','',10);

						$pdf->Cell(10,25,$indice,1,0,'C');

						$yy = $pdf->GetY();

						$pdf->Multicell(105,5,$y->getPregunta_(),0,'L',false);

						$pdf->Line(20,25+($yy),200,25+($yy));

						if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

						if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

						if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

						$pdf->SetY($yy);

						$pdf->SetX(125);

						$pdf->SetFont('Times','B',10);

						$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

						$pdf->SetFillColor(250,250,250);

						$pdf->SetFont('Times','',9);
						$pdf->SetY($yy);

						for ($i=0; $i < count($porcentajes); $i++) {
							$ancho = ($porcentajes[$i] * 60) / 100;
							$ancho = ($ancho == 0) ? 0.5 : $ancho;

							if($i==0)
								$pdf->SetFillColor(255,0,0);
							if($i==1)
								$pdf->SetFillColor(255,255,0);
							if($i==2)
								$pdf->SetFillColor(50,205,50);
							if($i==3)
								$pdf->SetFillColor(204,204,204);

							$pdf->SetX(135);
							$pdf->Cell($ancho,6.25,'',1,0,'L',true);

							$pdf->SetFillColor(250,250,250);
							$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
						}

						//
						$pdf->SetY($yy + 25);

						$indice++;

					}

					$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

					if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetFont('Times','B',12);

					$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

					$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

					$pdf->SetFillColor(250,250,250);

					$pdf->SetFont('Times','',9);

					$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

					$preguntas_general = substr($preguntas_general, 0, -1);
					$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
					$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

					for ($i=0; $i < count($porcentajes_generales); $i++) {
						$ancho = ($porcentajes_generales[$i] * 60) / 100;
						$ancho = ($ancho == 0) ? 0.5 : $ancho;

						if($i==0)
							$pdf->SetFillColor(255,0,0);
						if($i==1)
							$pdf->SetFillColor(255,255,0);
						if($i==2)
							$pdf->SetFillColor(50,205,50);
						if($i==3)
							$pdf->SetFillColor(204,204,204);

						$pdf->SetX(135);
						$pdf->Cell($ancho,6.25,'',1,0,'L',true);
						
						$pdf->SetFillColor(250,250,250);
						$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
					}
				}

			}else{

				$indice=1;

				$pdf->AddPage();

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

				$pdf->Ln(15);

				$pdf->Cell(170,10,"RESULTADOS POR TEMAS",0,0,'C');

				$pdf->SetY(55+(10*$indice));

				$pdf->SetFont('Times','B',10);

				$pdf->Cell(190,10,$tema_nombre,1,0,'L');

				$pdf->Ln();

				$preguntas = $temas[$key];

				$promedio_general=array();

				$preguntas_general = '';

				foreach ($preguntas as $p_key => $p_value) {

					$y->select($p_value);

					$id_p = $y->getId();

					$promedio = $w->get_avg_x_pregunta($ids,$id_p);

					array_push($promedio_general, $promedio);

					$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

					$preguntas_general .= $p_value.',';

					//

					$pdf->SetFont('Times','',10);

					$pdf->Cell(10,25,$indice,1,0,'C');

					$yy = $pdf->GetY();

					$pdf->Multicell(105,5,$y->getPregunta_(),0,'L',false);

					$pdf->Line(20,25+($yy),200,25+($yy));

					if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetY($yy);

					$pdf->SetX(125);

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

					$pdf->SetFillColor(250,250,250);

					$pdf->SetFont('Times','',9);
					$pdf->SetY($yy);

					for ($i=0; $i < count($porcentajes); $i++) {
						$ancho = ($porcentajes[$i] * 60) / 100;
						$ancho = ($ancho == 0) ? 0.5 : $ancho;

						if($i==0)
							$pdf->SetFillColor(255,0,0);
						if($i==1)
							$pdf->SetFillColor(255,255,0);
						if($i==2)
							$pdf->SetFillColor(50,205,50);
						if($i==3)
							$pdf->SetFillColor(204,204,204);

						$pdf->SetX(135);
						$pdf->Cell($ancho,6.25,'',1,0,'L',true);

						$pdf->SetFillColor(250,250,250);
						$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
					}

					//
					$pdf->SetY($yy + 25);

					$indice++;

				}

				$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

				if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

				if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

				if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

				$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

				$pdf->SetFillColor(250,250,250);

				$pdf->SetFont('Times','',9);

				$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

				$preguntas_general = substr($preguntas_general, 0, -1);
				$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
				$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

				for ($i=0; $i < count($porcentajes_generales); $i++) {
					$ancho = ($porcentajes_generales[$i] * 60) / 100;
					$ancho = ($ancho == 0) ? 0.5 : $ancho;

					if($i==0)
						$pdf->SetFillColor(255,0,0);
					if($i==1)
						$pdf->SetFillColor(255,255,0);
					if($i==2)
						$pdf->SetFillColor(50,205,50);
					if($i==3)
						$pdf->SetFillColor(204,204,204);

					$pdf->SetX(135);
					$pdf->Cell($ancho,6.25,'',1,0,'L',true);
					
					$pdf->SetFillColor(250,250,250);
					$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
				}

			}
		}

		// RESULTADOS PREGUNTAS PUNTAJES

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$top=$w->get_top($ids,10,"DESC");

		$pdf->Cell(190,10,"LAS 10 PREGUNTAS CON PUNTAJE MAS ALTO",1,1,'L');

		$pdf->SetFont('Times','',12);

		foreach ($top as $top_key => $top_value) {
			
			$y1 = $pdf->GetY();
			$pdf->SetFont('Times','',12);
			
			$pdf->Multicell(180,10,$w->htmlprnt_win($top_value['pregunta']),1,'L',false);
			
			$y2 = $pdf->GetY();			
			$height = $y1 - $y2;

			$pdf->SetX(190);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(10,$height,number_format($top_value['res'], 2, '.', ''),1,2,'C');
			
			$pdf->SetY($y2);
		}

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$top=$w->get_top($ids,10,"ASC");

		$pdf->Cell(190,10,"LAS 10 PREGUNTAS CON PUNTAJE MAS BAJO",1,1,'L');

		foreach ($top as $top_key => $top_value) {

			$y1 = $pdf->GetY();
			$pdf->SetFont('Times','',12);
			
			$pdf->Multicell(180,10,$w->htmlprnt_win($top_value['pregunta']),1,'L',false);
			
			$y2 = $pdf->GetY();			
			$height = $y1 - $y2;

			$pdf->SetX(190);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(10,$height,number_format($top_value['res'], 2, '.', ''),1,2,'C');
			
			$pdf->SetY($y2);

		}
		
		// RESULTADOS COMENTARIOS FODA

		$result = $z->comentariosFODA($id_s);
		
		if(is_array($result))
		{
			
			foreach ($result as $nombre => $arrValores) {

				$indice = 1;

				$pdf->AddPage();

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

				$pdf->Ln(15);

				$pdf->Cell(170,10,"COMENTARIOS FODA",0,0,'C');

				$pdf->SetY(45+(10*$indice));

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(190,10,$nombre,1,0,'L');

				$pdf->Ln();

				foreach ($arrValores as $key => $comentario) {

					$pdf->SetFont('Times','',10);
					
					$pdf->Multicell(190,8,$comentario,1,'L',false);

					$indice++;
				}
			}
			
		}
		
		//
		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');

	}

	
	function sonda_compara($id_s, $filtros="", $arrTema=""){

		$arrTema = stripslashes($arrTema);
		$arrTema = urldecode($arrTema );
		$arrTema = unserialize($arrTema);

		Util::sessionStart();

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$pdf = new pdf_sonda();

		self::paginas_inicio_sonda($pdf);

		//PAGINA FILTROS

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"FILTROS SELECCIONADOS",0,0,'C');

		$pdf->SetFont('Times','',12);

		$filtros = str_replace("'", "", $filtros);

		$filtros = str_replace("*", "/", $filtros);

		$filtros = str_replace("+", " ", $filtros);

		$filtros = ($filtros=="''") ? "Todos" : $filtros;

		$filtros = explode("<br>", $filtros);

		foreach ($filtros as $fil_key => $fil_val) {

			if ($fil_val != 'Todos') {

				$fil_true_key = explode(":", $fil_val);

				if (array_filter($fil_true_key)) {

					$pdf->SetFont('Times','B',12);

					$pdf->Ln(15);

					$pdf->Cell(60,10,$fil_true_key[0].":",0,0,'L');

					$pdf->SetFont('Times','',12);

					$fil_true_key[1] = explode(",", $fil_true_key[1]);

					foreach ($fil_true_key[1] as $ftk_key => $ftk_val) {	

						if($ftk_key!=0)

							$pdf->Cell(60,10,"",0,0,'L');

						$pdf->Cell(120,10,$ftk_val,0,0,'L');

						$pdf->Ln(5);

					}

				}
			}else{
				$pdf->SetFont('Times','B',12);

				$pdf->Ln(15);
				
				$pdf->Cell(60,10,$fil_val,0,0,'L');
			}

		}

		//REPORTE RESULTADOS

		$pdf->SetMargins(10,25,0);

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

		$pdf->SetFont('Times','',8);

		$sonda = new Sonda();

		$sondas = $_SESSION['sondas'];

		$sonda->select_compara($_SESSION['Empresa']['id'], $id_s);

		$seg = $sonda->getSegmentacion();

		$z = new Sonda_user();

		$x = new Sonda_tema();

		$y = new Sonda_pregunta();

		$w = new Sonda_respuesta();

		$args=$_SESSION['args'];

		$c_e=$z->get_evaluados($args,$id_s,'C');

		$temas = $sonda->getTemas();

		$indice = 1;

		$promedio_general = array();

		$preguntas = $preguntas_general = '';

		// Resultados test general

		foreach ($temas as $key => $value) {

			if (isset($arrTema) && is_array($arrTema)) {

				if (in_array($key, $arrTema)) {
					
					$x->select($key);

					$tema_nombre = ucfirst($x->getTema_());

					$tema_id = $x->getId();

					$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_s, $key, $args);

					if ($indice==1){

						$pdf->SetY(45+(10*$indice));

						$pdf->SetFont('Times','B',10);

						$pdf->Cell(190,10,'Factores',1,0,'L');

						$pdf->Ln();
					}

					$pdf->Cell(10,25,$indice,1,0,'C');

					$yy = $pdf->GetY();

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(105,10,$tema_nombre,0,2,'L');

					$pdf->SetFont('Times','',10);

					$pdf->Multicell(105,5,$x->getDescripcion_(),0,'L',false);

					$pdf->Line(20,25+($yy),200,25+($yy));

					$preguntas = implode(",", $temas[$key]);

					$preguntas_general .= implode(",", $temas[$key]).',';

					$promedio = $w->get_avg_x_tema($ids,$preguntas);

					$porcentajes = $w->get_percent($ids,$preguntas);

					if($promedio == '')
						$promedio = 0;

					if($promedio != 0)
						array_push($promedio_general, $promedio);

					if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetY($yy);

					$pdf->SetX(125);

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

					$pdf->SetFillColor(250,250,250);

					$pdf->SetFont('Times','',9);
					$pdf->SetY($yy);

					for ($i=0; $i < count($porcentajes); $i++) {
						$ancho = ($porcentajes[$i] * 60) / 100;
						$ancho = ($ancho == 0) ? 0.5 : $ancho;

						if($i==0)
							$pdf->SetFillColor(255,0,0);
						if($i==1)
							$pdf->SetFillColor(255,255,0);
						if($i==2)
							$pdf->SetFillColor(50,205,50);
						if($i==3)
							$pdf->SetFillColor(204,204,204);

						$pdf->SetX(135);
						$pdf->Cell($ancho,6.25,'',1,0,'L',true);

						$pdf->SetFillColor(250,250,250);
						$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
					}

					$pdf->SetY($yy + 25);

					$indice++;
				}
			}else{
				
				$x->select($key);

				$tema_nombre = ucfirst($x->getTema_());

				$tema_id = $x->getId();

				$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_s, $key, $args);

				if ($indice==1){

					$pdf->SetY(45+(10*$indice));

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(190,10,'Factores',1,0,'L');

					$pdf->Ln();

				}

				$pdf->Cell(10,25,$indice,1,0,'C');

				$yy = $pdf->GetY();
				
				$pdf->SetFont('Times','B',10);

				$pdf->Cell(105,10,$tema_nombre,0,2,'L');

				$pdf->SetFont('Times','',10);

				$pdf->Multicell(105,5,$x->getDescripcion_(),0,'L',false);
				
				$pdf->Line(20,25+($yy),200,25+($yy));

				$preguntas = implode(",", $temas[$key]);

				$preguntas_general .= implode(",", $temas[$key]).',';

				$promedio = $w->get_avg_x_tema($ids,$preguntas);

				$porcentajes = $w->get_percent($ids,$preguntas);

				if($promedio == '')
					$promedio = 0;

				if($promedio != 0)
					array_push($promedio_general, $promedio);

				if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

				if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

				if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

				$pdf->SetY($yy);

				$pdf->SetX(125);

				$pdf->SetFont('Times','B',10);

				$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

				$pdf->SetFillColor(250,250,250);

				$pdf->SetFont('Times','',9);
				$pdf->SetY($yy);

				for ($i=0; $i < count($porcentajes); $i++) {
					$ancho = ($porcentajes[$i] * 60) / 100;
					$ancho = ($ancho == 0) ? 0.5 : $ancho;

					if($i==0)
						$pdf->SetFillColor(255,0,0);
					if($i==1)
						$pdf->SetFillColor(255,255,0);
					if($i==2)
						$pdf->SetFillColor(50,205,50);
					if($i==3)
						$pdf->SetFillColor(204,204,204);

					$pdf->SetX(135);
					$pdf->Cell($ancho,6.25,'',1,0,'L',true);

					$pdf->SetFillColor(250,250,250);
					$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
				}
				
				$pdf->SetY($yy + 25);

				$indice++;
			}
		}

		$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

		if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

		if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

		if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

		$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

		$pdf->SetFillColor(250,250,250);

		$pdf->SetFont('Times','',9);

		$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

		$preguntas_general = substr($preguntas_general, 0, -1);
		$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
		$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

		for ($i=0; $i < count($porcentajes_generales); $i++) {
			$ancho = ($porcentajes_generales[$i] * 60) / 100;
			$ancho = ($ancho == 0) ? 0.5 : $ancho;

			if($i==0)
				$pdf->SetFillColor(255,0,0);
			if($i==1)
				$pdf->SetFillColor(255,255,0);
			if($i==2)
				$pdf->SetFillColor(50,205,50);
			if($i==3)
				$pdf->SetFillColor(204,204,204);

			$pdf->SetX(135);
			$pdf->Cell($ancho,6.25,'',1,0,'L',true);
			
			$pdf->SetFillColor(250,250,250);
			$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
		}


		// RESULTADOS POR TEMAS Y PREGUNTAS

		foreach ($temas as $key => $value) {

			$x->select($key);

			$tema_nombre = ucfirst($x->getTema_());

			if (isset($arrTema) && is_array($arrTema)) {

				if (in_array($key, $arrTema)) {
					
					$indice=1;
					
					$pdf->AddPage();

					$pdf->SetFont('Times','B',12);

					$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

					$pdf->Ln(15);

					$pdf->Cell(170,10,"RESULTADOS POR TEMAS",0,0,'C');

					$pdf->SetY(45+(10*$indice));

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(190,10,$tema_nombre,1,0,'L');

					$pdf->Ln();

					$preguntas = $temas[$key];

					$promedio_general=array();

					foreach ($preguntas as $p_key => $p_value) {

						$y->select($p_value);

						$id_p = $y->getId();

						$promedio = $w->get_avg_x_pregunta($ids,$id_p);

						array_push($promedio_general, $promedio);

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

						$preguntas_general .= $p_value.',';

						//

						$pdf->SetFont('Times','',10);

						$pdf->Cell(10,25,$indice,1,0,'C');

						$yy = $pdf->GetY();

						$pdf->Multicell(105,5,$y->getPregunta_(),0,'L',false);

						$pdf->Line(20,25+($yy),200,25+($yy));

						if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

						if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

						if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

						$pdf->SetY($yy);

						$pdf->SetX(125);

						$pdf->SetFont('Times','B',10);

						$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

						$pdf->SetFillColor(250,250,250);

						$pdf->SetFont('Times','',9);
						$pdf->SetY($yy);

						for ($i=0; $i < count($porcentajes); $i++) {
							$ancho = ($porcentajes[$i] * 60) / 100;
							$ancho = ($ancho == 0) ? 0.5 : $ancho;

							if($i==0)
								$pdf->SetFillColor(255,0,0);
							if($i==1)
								$pdf->SetFillColor(255,255,0);
							if($i==2)
								$pdf->SetFillColor(50,205,50);
							if($i==3)
								$pdf->SetFillColor(204,204,204);

							$pdf->SetX(135);
							$pdf->Cell($ancho,6.25,'',1,0,'L',true);

							$pdf->SetFillColor(250,250,250);
							$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
						}

						//
						$pdf->SetY($yy + 25);

						$indice++;

					}

					$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

					if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetFont('Times','B',12);

					$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

					$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

					$pdf->SetFillColor(250,250,250);

					$pdf->SetFont('Times','',9);

					$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

					$preguntas_general = substr($preguntas_general, 0, -1);
					$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
					$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

					for ($i=0; $i < count($porcentajes_generales); $i++) {
						$ancho = ($porcentajes_generales[$i] * 60) / 100;
						$ancho = ($ancho == 0) ? 0.5 : $ancho;

						if($i==0)
							$pdf->SetFillColor(255,0,0);
						if($i==1)
							$pdf->SetFillColor(255,255,0);
						if($i==2)
							$pdf->SetFillColor(50,205,50);
						if($i==3)
							$pdf->SetFillColor(204,204,204);

						$pdf->SetX(135);
						$pdf->Cell($ancho,6.25,'',1,0,'L',true);
						
						$pdf->SetFillColor(250,250,250);
						$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
					}
				}
			}else{
				
				$indice=1;

				$pdf->AddPage();

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

				$pdf->Ln(15);

				$pdf->Cell(170,10,"RESULTADOS POR TEMAS",0,0,'C');

				$pdf->SetY(55+(10*$indice));

				$pdf->SetFont('Times','B',10);

				$pdf->Cell(190,10,$tema_nombre,1,0,'L');

				$pdf->Ln();

				$preguntas = $temas[$key];

				$promedio_general=array();

				$preguntas_general = '';

				foreach ($preguntas as $p_key => $p_value) {

					$y->select($p_value);

					$id_p = $y->getId();

					$promedio = $w->get_avg_x_pregunta($ids,$id_p);

					array_push($promedio_general, $promedio);

					$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

					$preguntas_general .= $p_value.',';

					//

					$pdf->SetFont('Times','',10);

					$pdf->Cell(10,25,$indice,1,0,'C');

					$yy = $pdf->GetY();

					$pdf->Multicell(105,5,$y->getPregunta_(),0,'L',false);

					$pdf->Line(20,25+($yy),200,25+($yy));

					if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetY($yy);

					$pdf->SetX(125);

					$pdf->SetFont('Times','B',10);

					$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

					$pdf->SetFillColor(250,250,250);

					$pdf->SetFont('Times','',9);
					$pdf->SetY($yy);

					for ($i=0; $i < count($porcentajes); $i++) {
						$ancho = ($porcentajes[$i] * 60) / 100;
						$ancho = ($ancho == 0) ? 0.5 : $ancho;

						if($i==0)
							$pdf->SetFillColor(255,0,0);
						if($i==1)
							$pdf->SetFillColor(255,255,0);
						if($i==2)
							$pdf->SetFillColor(50,205,50);
						if($i==3)
							$pdf->SetFillColor(204,204,204);

						$pdf->SetX(135);
						$pdf->Cell($ancho,6.25,'',1,0,'L',true);

						$pdf->SetFillColor(250,250,250);
						$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
					}

					//
					$pdf->SetY($yy + 25);

					$indice++;

				}

				$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

				if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

				if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

				if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

				$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

				$pdf->SetFillColor(250,250,250);

				$pdf->SetFont('Times','',9);

				$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

				$preguntas_general = substr($preguntas_general, 0, -1);
				$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
				$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

				for ($i=0; $i < count($porcentajes_generales); $i++) {
					$ancho = ($porcentajes_generales[$i] * 60) / 100;
					$ancho = ($ancho == 0) ? 0.5 : $ancho;

					if($i==0)
						$pdf->SetFillColor(255,0,0);
					if($i==1)
						$pdf->SetFillColor(255,255,0);
					if($i==2)
						$pdf->SetFillColor(50,205,50);
					if($i==3)
						$pdf->SetFillColor(204,204,204);

					$pdf->SetX(135);
					$pdf->Cell($ancho,6.25,'',1,0,'L',true);
					
					$pdf->SetFillColor(250,250,250);
					$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
				}
			}
		}

		
		// RESULTADOS PREGUNTAS PUNTAJES

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$top=$w->get_top($ids,10,"DESC");

		$pdf->Cell(190,10,"LAS 10 PREGUNTAS CON PUNTAJE MAS ALTO",1,1,'L');

		$pdf->SetFont('Times','',12);

		foreach ($top as $top_key => $top_value) {
			
			$y1 = $pdf->GetY();
			$pdf->SetFont('Times','',12);
			
			$pdf->Multicell(180,10,$w->htmlprnt_win($top_value['pregunta']),1,'L',false);
			
			$y2 = $pdf->GetY();			
			$height = $y1 - $y2;

			$pdf->SetX(190);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(10,$height,number_format($top_value['res'], 2, '.', ''),1,2,'C');
			
			$pdf->SetY($y2);
		}

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$top=$w->get_top($ids,10,"ASC");

		$pdf->Cell(190,10,"LAS 10 PREGUNTAS CON PUNTAJE MAS BAJO",1,1,'L');

		foreach ($top as $top_key => $top_value) {

			$y1 = $pdf->GetY();
			$pdf->SetFont('Times','',12);
			
			$pdf->Multicell(180,10,$w->htmlprnt_win($top_value['pregunta']),1,'L',false);
			
			$y2 = $pdf->GetY();			
			$height = $y1 - $y2;

			$pdf->SetX(190);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(10,$height,number_format($top_value['res'], 2, '.', ''),1,2,'C');
			
			$pdf->SetY($y2);

		}

		// RESULTADOS COMENTARIOS FODA

		$result = $z->comentariosFODA($id_s);

		if (is_array($result)) {
			foreach ($result as $nombre => $arrValores) {

				$indice = 1;

				$pdf->AddPage();

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

				$pdf->Ln(15);

				$pdf->Cell(170,10,"COMENTARIOS FODA",0,0,'C');

				$pdf->SetY(45+(10*$indice));

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(190,10,$nombre,1,0,'L');

				$pdf->Ln();

				foreach ($arrValores as $key => $comentario) {

					$pdf->SetFont('Times','',10);
					
					$pdf->Multicell(190,8,$comentario,1,'L',false);

					$indice++;
				}
			}
		}

		//
		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');

	}

	function sonda_seg($id_s, $campo, $valor, $filtros=""){

		Util::sessionStart();

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$pdf = new pdf_sonda();

		self::paginas_inicio_sonda($pdf);

		//PAGINA FILTROS

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"FILTROS SELECCIONADOS",0,0,'C');

		$pdf->SetFont('Times','',12);

		$filtros = str_replace("'", "", $filtros);

		$filtros = str_replace("*", "/", $filtros);

		$filtros = str_replace("+", " ", $filtros);

		$filtros = ($filtros=="''") ? "Todos" : $filtros;

		$filtros = explode("<br>", $filtros);

		foreach ($filtros as $fil_key => $fil_val) {

			if ($fil_val != 'Todos') {

				$fil_true_key = explode(":", $fil_val);

				if (array_filter($fil_true_key)) {

					$pdf->SetFont('Times','B',12);

					$pdf->Ln(15);

					$pdf->Cell(60,10,$fil_true_key[0].":",0,0,'L');

					$pdf->SetFont('Times','',12);

					$fil_true_key[1] = explode(",", $fil_true_key[1]);

					foreach ($fil_true_key[1] as $ftk_key => $ftk_val) {	

						if($ftk_key!=0)

							$pdf->Cell(60,10,"",0,0,'L');

						$pdf->Cell(120,10,$ftk_val,0,0,'L');

						$pdf->Ln(5);

					}

				}

			}else{

				$pdf->SetFont('Times','B',12);

				$pdf->Ln(15);
				
				$pdf->Cell(60,10,$fil_val,0,0,'L');
			}

		}

		//REPORTE RESULTADOS

		$pdf->SetMargins(10,25,0);

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','',8);

		$sonda = new Sonda();

		$sondas = $_SESSION['sondas'];

		$sonda->select_($_SESSION['Empresa']['id'], $id_s);

		$seg = $sonda->getSegmentacion();

		$z = new Sonda_user();

		$x = new Sonda_tema();

		$y = new Sonda_pregunta();

		$w = new Sonda_respuesta();

		$args=$_SESSION['args'];

		$c_e=$z->get_evaluados($args,$id_s,'C');

		$temas = $sonda->getTemas();

		$indice = 1;

		$promedio_general = array();

		$preguntas = $preguntas_general = '';

		// Resultados test general

		foreach ($temas as $key => $value) {

			$x->select($key);

			$tema_nombre = ucfirst($x->getTema_());

			$tema_id = $x->getId();

			$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $id_s, $key, $campo, $valor);

			if ($indice==1){

				$pdf->SetY(45+(10*$indice));

				$pdf->SetFont('Times','B',10);

				$pdf->Cell(190,10,'Factores',1,0,'L');

				$pdf->Ln();
			}

			$pdf->Cell(10,25,$indice,1,0,'C');

			$yy = $pdf->GetY();
				
			$pdf->SetFont('Times','B',10);

			$pdf->Cell(105,10,$tema_nombre,0,2,'L');
			
			$pdf->SetFont('Times','',10);

			$pdf->Multicell(105,5,$x->getDescripcion_(),0,'L',false);
			
			$pdf->Line(20,25+($yy),200,25+($yy));

			$preguntas = implode(",", $temas[$key]);

			$preguntas_general .= implode(",", $temas[$key]).',';

			$promedio = $w->get_avg_x_tema($ids,$preguntas);

			$porcentajes = $w->get_percent($ids,$preguntas);

			if($promedio == '')
				$promedio = 0;

			if($promedio != 0)
				array_push($promedio_general, $promedio);

			if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

			if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

			if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

			$pdf->SetY($yy);

			$pdf->SetX(125);

			$pdf->SetFont('Times','B',10);

			$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

			$pdf->SetFillColor(250,250,250);
			
			$pdf->SetFont('Times','',9);
			$pdf->SetY($yy);

			for ($i=0; $i < count($porcentajes); $i++) {
				$ancho = ($porcentajes[$i] * 60) / 100;
				$ancho = ($ancho == 0) ? 0.5 : $ancho;

				if($i==0)
					$pdf->SetFillColor(255,0,0);
				if($i==1)
					$pdf->SetFillColor(255,255,0);
				if($i==2)
					$pdf->SetFillColor(50,205,50);
				if($i==3)
					$pdf->SetFillColor(204,204,204);

				$pdf->SetX(135);
				$pdf->Cell($ancho,6.25,'',1,0,'L',true);

				$pdf->SetFillColor(250,250,250);
				$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
			}
			
			$pdf->SetY($yy + 25);

			$indice++;

		}

		$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

		if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

		if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

		if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

		$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

		$pdf->SetFillColor(250,250,250);

		$pdf->SetFont('Times','',9);

		$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

		$preguntas_general = substr($preguntas_general, 0, -1);
		$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
		$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

		for ($i=0; $i < count($porcentajes_generales); $i++) {
			$ancho = ($porcentajes_generales[$i] * 60) / 100;
			$ancho = ($ancho == 0) ? 0.5 : $ancho;

			if($i==0)
				$pdf->SetFillColor(255,0,0);
			if($i==1)
				$pdf->SetFillColor(255,255,0);
			if($i==2)
				$pdf->SetFillColor(50,205,50);
			if($i==3)
				$pdf->SetFillColor(204,204,204);

			$pdf->SetX(135);
			$pdf->Cell($ancho,6.25,'',1,0,'L',true);
			
			$pdf->SetFillColor(250,250,250);
			$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
		}

		
		// RESULTADOS POR TEMAS Y PREGUNTAS

		foreach ($temas as $key => $value) {

			$x->select($key);

			$tema_nombre = ucfirst($x->getTema_());

			$indice=1;

			$pdf->AddPage();

			$pdf->SetFont('Times','B',12);

			$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

			$pdf->Ln(15);

			$pdf->Cell(170,10,"RESULTADOS POR TEMAS",0,0,'C');

			$pdf->SetY(55+(10*$indice));

			$pdf->SetFont('Times','B',10);

			$pdf->Cell(190,10,$tema_nombre,1,0,'L');

			$pdf->Ln();

			$preguntas = $temas[$key];

			$promedio_general=array();

			$preguntas_general = '';

			foreach ($preguntas as $p_key => $p_value) {

				$y->select($p_value);

				$id_p = $y->getId();

				$promedio = $w->get_avg_x_pregunta($ids,$id_p);

				array_push($promedio_general, $promedio);

				$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

				$preguntas_general .= $p_value.',';

				//

				$pdf->SetFont('Times','',10);

				$pdf->Cell(10,25,$indice,1,0,'C');

				$yy = $pdf->GetY();

				$pdf->Multicell(105,5,$y->getPregunta_(),0,'L',false);

				$pdf->Line(20,25+($yy),200,25+($yy));

				if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

				if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

				if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

				$pdf->SetY($yy);

				$pdf->SetX(125);

				$pdf->SetFont('Times','B',10);

				$pdf->Cell(10,25,number_format($promedio,2),1,0,'C',true);

				$pdf->SetFillColor(250,250,250);

				$pdf->SetFont('Times','',9);
				$pdf->SetY($yy);

				for ($i=0; $i < count($porcentajes); $i++) {
					$ancho = ($porcentajes[$i] * 60) / 100;
					$ancho = ($ancho == 0) ? 0.5 : $ancho;

					if($i==0)
						$pdf->SetFillColor(255,0,0);
					if($i==1)
						$pdf->SetFillColor(255,255,0);
					if($i==2)
						$pdf->SetFillColor(50,205,50);
					if($i==3)
						$pdf->SetFillColor(204,204,204);

					$pdf->SetX(135);
					$pdf->Cell($ancho,6.25,'',1,0,'L',true);

					$pdf->SetFillColor(250,250,250);
					$pdf->Cell((65-$ancho),6.25,$porcentajes[$i].'%','R',2,'R',false);
				}

				//
				$pdf->SetY($yy + 25);

				$indice++;

			}

			$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

			if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

			if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

			if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

			$pdf->SetFont('Times','B',12);

			$pdf->Cell(115,25,"Promedio general:",1,0,'L',false); 

			$pdf->Cell(10,25,number_format($p_gen,2),1,0,'L',true);

			$pdf->SetFillColor(250,250,250);

			$pdf->SetFont('Times','',9);

			$pdf->Line(20,25+($pdf->GetY()),200,25+($pdf->GetY()));

			$preguntas_general = substr($preguntas_general, 0, -1);
			$p_gen = @(array_sum($promedio_general)/sizeof($promedio_general)); 
			$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

			for ($i=0; $i < count($porcentajes_generales); $i++) {
				$ancho = ($porcentajes_generales[$i] * 60) / 100;
				$ancho = ($ancho == 0) ? 0.5 : $ancho;

				if($i==0)
					$pdf->SetFillColor(255,0,0);
				if($i==1)
					$pdf->SetFillColor(255,255,0);
				if($i==2)
					$pdf->SetFillColor(50,205,50);
				if($i==3)
					$pdf->SetFillColor(204,204,204);

				$pdf->SetX(135);
				$pdf->Cell($ancho,6.25,'',1,0,'L',true);
				
				$pdf->SetFillColor(250,250,250);
				$pdf->Cell((65-$ancho),6.25,$porcentajes_generales[$i].'%','R',2,'R',false);
			}

		}

		
		// RESULTADOS PREGUNTAS PUNTAJES

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$top=$w->get_top($ids,10,"DESC");

		$pdf->Cell(190,10,"LAS 10 PREGUNTAS CON PUNTAJE MAS ALTO",1,1,'L');

		$pdf->SetFont('Times','',12);

		foreach ($top as $top_key => $top_value) {
			
			$y1 = $pdf->GetY();
			$pdf->SetFont('Times','',12);
			
			$pdf->Multicell(180,10,$w->htmlprnt_win($top_value['pregunta']),1,'L',false);
			
			$y2 = $pdf->GetY();			
			$height = $y1 - $y2;

			$pdf->SetX(190);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(10,$height,number_format($top_value['res'], 2, '.', ''),1,2,'C');
			
			$pdf->SetY($y2);
		}

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$top=$w->get_top($ids,10,"ASC");

		$pdf->Cell(190,10,"LAS 10 PREGUNTAS CON PUNTAJE MAS BAJO",1,1,'L');

		foreach ($top as $top_key => $top_value) {

			$y1 = $pdf->GetY();
			$pdf->SetFont('Times','',12);
			
			$pdf->Multicell(180,10,$w->htmlprnt_win($top_value['pregunta']),1,'L',false);
			
			$y2 = $pdf->GetY();			
			$height = $y1 - $y2;

			$pdf->SetX(190);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(10,$height,number_format($top_value['res'], 2, '.', ''),1,2,'C');
			
			$pdf->SetY($y2);

		}
		
		// RESULTADOS COMENTARIOS FODA

		$result = $z->comentariosFODA($id_s);
		
		if ($result != "") {
			
			foreach ($result as $nombre => $arrValores) {

				$indice = 1;

				$pdf->AddPage();

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

				$pdf->Ln(15);

				$pdf->Cell(170,10,"COMENTARIOS FODA",0,0,'C');

				$pdf->SetY(45+(10*$indice));

				$pdf->SetFont('Times','B',12);

				$pdf->Cell(190,10,$nombre,1,0,'L');

				$pdf->Ln();

				foreach ($arrValores as $key => $comentario) {

					$pdf->SetFont('Times','',10);
					
					$pdf->Multicell(190,8,$comentario,1,'L',false);

					$indice++;
				}
			}
			
		}

		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');

	}

	function promedios_bajos($id_e, $id_sonda){
		$rendimiento = new Rendimiento();
		$x = new Sonda_tema();
		$y = new Sonda_pregunta();
		$z = new Sonda_user();
		$w = new Sonda_respuesta();

		$rendimiento->select($id_e);
		
		$ids = $z->get_id_x_empresa($rendimiento->getId(),$id_e);
		
		$temas = $rendimiento->getTemas();

		foreach ($temas as $key => $value) {
			$preguntas = implode(",", $temas[$key]);
			$rendimiento->calculo_prom_bajos($ids,$key,$preguntas);
		}

		$rendimiento->promedios_bajos($id_e);

		$arrDatos = $rendimiento->arrDatos;

		if (is_array($arrDatos)) {
			$i = 0;
			foreach ($arrDatos as $key => $arrValores) {
				$unserialize = unserialize($key);
				foreach ($unserialize as $tipo => $valor) {
					if ($tipo != 'c_e') {
						$filtro["tipo"] = $tipo;
						$filtro["valor"] = $valor;
						$rendimiento->filtros_criterios($filtro);
						$rendimiento->get_criterios();
					}
				}
				$rendimiento->resetVariables();
				$arrFiltros[$i] = $rendimiento->criterios;
				$i++;
			}
		}

		Util::sessionStart();

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$pdf = new pdf_sonda();

		self::paginas_inicio_sonda($pdf);

		//PAGINA FILTROS

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"FILTROS SELECCIONADOS",0,0,'C');

		$pdf->SetFont('Times','',12);

		if (is_array($arrFiltros)) {
			foreach ($arrFiltros as $key => $filtros) {
				$filtros = explode("<br>", $filtros);

				foreach ($filtros as $fil_key => $fil_val) {

					$fil_true_key = explode(":", $fil_val);

					if (array_filter($fil_true_key)) {

						$pdf->SetFont('Times','B',12);

						$pdf->Ln(15);

						$pdf->Cell(60,10,$fil_true_key[0].":",0,0,'L');

						$pdf->SetFont('Times','',12);

						$fil_true_key[1] = explode(",", $fil_true_key[1]);

						foreach ($fil_true_key[1] as $ftk_key => $ftk_val) {	

							if($ftk_key!=0)

								$pdf->Cell(60,10,"",0,0,'L');

							$pdf->Cell(120,10,$ftk_val,0,0,'L');

							$pdf->Ln(0);

						}

					}

				}
				$pdf->Ln(15);
			}
		}

		//REPORTE RESULTADOS

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','',8);

		$z = new Sonda_user();

		$x = new Sonda_tema();

		$y = new Sonda_pregunta();

		$w = new Sonda_respuesta();

		$indice = 1;

		$promedio_general = array();

		// Resultados test general
		if (is_array($arrDatos)) {
			foreach ($arrDatos as $key => $arrValores) {
				foreach ($arrValores as $id_tema => $arrTema) {
					$x->select($id_tema);
					$tema_nombre = ucfirst($x->getTema());
					$tema_id = $x->getId();
					$arrUsers = $arrTema['id_suser'];
					$arrPreguntas = $arrTema['preguntas'];

					//
					$pdf->Ln();

					if ($indice==1)

						$pdf->SetY(45+(10*$indice));

					$pdf->Cell(10,10,$indice,1,0,'C');

					$pdf->Cell(55,10,$tema_nombre,1,0,'L');

					$pdf->SetY(46+(10*$indice));

					$pdf->SetX(85);

					$pdf->Multicell(95,3,$x->getDescripcion_(),0,'L',false);

					$pdf->Line(20,55+(10*$indice),185,55+(10*$indice));

					$promedio = $arrTema['promedio'];

					array_push($promedio_general, $promedio);

					if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetY(45+(10*$indice));

					$pdf->SetX(180);

					$pdf->Cell(10,10,round($promedio,2),1,0,'C',true);

					$pdf->SetFillColor(250,250,250);

					$indice++;
				}
			}

			$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

			if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

			if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

			if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

			$pdf->Ln();

			$pdf->SetFont('Times','B',12);

			$pdf->Cell(170,5,"Promedio general:",1,0,'L',false); 

			$pdf->Cell(10,5,round($p_gen,2),1,0,'L',true);

			$pdf->SetFillColor(250,250,250);  
		}

		// Resultados general grafica

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','',12);

		$indice = 1;

		if (is_array($arrDatos)) {
			foreach ($arrDatos as $key => $arrValores) {
				foreach ($arrValores as $id_tema => $arrTema) {
					$x->select($id_tema);
					$tema_nombre = ucfirst($x->getTema());
					$tema_id = $x->getId();
					$promedio = $arrTema['promedio'];

					$pdf->Cell(10,10,$indice,1,0,'C');

					$preguntas = implode(",", $arrTema['preguntas']);
					$ids = implode(",", $arrTema['id_suser']);

					$porcentajes = $w->get_percent($ids,$preguntas, $promedio);

					$pdf->SetFillColor(250,0,0);

					$pdf->SetTextColor(250,250,250);

					$pdf->Cell(60,10,number_format($porcentajes[0], 2, '.', ''),1,0,'C',true);

					$pdf->SetTextColor(0,0,0);

					$pdf->SetFillColor(250,250,0);

					$pdf->Cell(60,10,number_format($porcentajes[1], 2, '.', ''),1,0,'C',true);

					$pdf->SetFillColor(0,250,0);

					$pdf->Cell(60,10,number_format($porcentajes[2], 2, '.', ''),1,0,'C',true);

					$pdf->Ln(10);

					$indice++;
				}
			}
		}


		if (is_array($arrDatos)) {
			foreach ($arrDatos as $key => $arrValores) {
				foreach ($arrValores as $id_tema => $arrTema) {
					$x->select($id_tema);
					$tema_nombre = ucfirst($x->getTema());
					$tema_id = $x->getId();
					$promedio = $arrTema['promedio'];
					$arrUsers = $arrTema['id_suser'];
					$arrPreguntas = $arrTema['preguntas'];
					$ids = implode(",", $arrUsers);
					$preguntas = implode(",", $arrPreguntas);

					$pdf->AddPage();

					$pdf->SetFont('Times','B',12);

					$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

					$pdf->Ln(15);

					$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

					$pdf->Ln(15);

					$pdf->SetFont('Times','',8);

					$indice=1;

					$promedio_general=array();

					foreach ($arrPreguntas as $p_key => $p_value) {

						$y->select($p_value);

						$id_p = $y->getId();

						$promedio = $w->get_avg_x_pregunta($ids,$id_p, $rendimiento->min_avg);

						// echo $key."<br>";

						array_push($promedio_general, $promedio);

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_p, $rendimiento->min_avg);

						$x->select($id_tema);

						$tema_nombre = ucfirst($x->getTema_());

						$tema_id = $x->getId();

						if ($indice==1){

							$pdf->SetFont('Times','B',12);

							// $pdf->SetY(45+(10*$indice));

							$pdf->Cell(190,10,$tema_nombre,1,0,'L');

							$pdf->Ln();

							$pdf->SetFont('Times','',8);

						}

						$pdf->Cell(10,10,$indice,1,0,'C');

						$pdf->Cell(170,10,$y->getPregunta_(),1,0,'L');

						if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

						if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

						if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

						$pdf->Cell(10,10,round($promedio,2),1,0,'C',true);

						$pdf->SetFillColor(250,250,250);

						$indice++;

						$pdf->Ln();

					}

					$p_gen = array_sum($promedio_general)/sizeof($promedio_general);

					if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

					if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

					if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

					$pdf->SetFont('Times','B',12);

					$pdf->Cell(180,5,"Promedio",1,0,'L',false); 

					$pdf->Cell(10,5,round($p_gen,2),1,0,'C',true);

					$pdf->SetFillColor(250,250,250);



					$pdf->AddPage();

					$pdf->SetFont('Times','B',12);

					$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

					$pdf->Ln(15);

					$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

					$pdf->Ln(15);

					$pdf->SetFont('Times','',12);

					$indice = 1;


					foreach ($arrPreguntas as $p_key => $p_value) {

						if ($indice==1){

							$pdf->SetFont('Times','B',12);

							$pdf->Cell(190,10,$tema_nombre,1,0,'L');

							$pdf->Ln();

							$pdf->SetFont('Times','',12);

						}

						$y->select($p_value);

						$id_p = $y->getId();

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_p, $rendimiento->min_avg);

						$pdf->Cell(10,10,$indice,1,0,'C');

						$pdf->SetFillColor(250,0,0);

						$pdf->SetTextColor(250,250,250);

						$pdf->Cell(60,10,number_format($porcentajes[0], 2, '.', ''),1,0,'C',true);

						$pdf->SetTextColor(0,0,0);

						$pdf->SetFillColor(250,250,0);

						$pdf->Cell(60,10,number_format($porcentajes[1], 2, '.', ''),1,0,'C',true);

						$pdf->SetFillColor(0,250,0);

						$pdf->Cell(60,10,number_format($porcentajes[2], 2, '.', ''),1,0,'C',true);

						$pdf->Ln(10);

						$indice++;
					}
				}
			}
		}

		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');

	}

	function promedios_bajos_xls($id_e, $id_sonda){

		$rendimiento = new Rendimiento();
		$x = new Sonda_tema();
		$y = new Sonda_pregunta();
		$z = new Sonda_user();
		$w = new Sonda_respuesta();

		$rendimiento->select($id_e);
		
		$ids = $z->get_id_x_empresa($rendimiento->getId(),$id_e);
		
		$temas = $rendimiento->getTemas();

		$preguntas = '';

		$c_e = '';

		foreach ($temas as $key => $value) {
			$preguntas = implode(",", $temas[$key]);
			$rendimiento->calculo_prom_bajos($ids,$key,$preguntas);
		}

		$rendimiento->promedios_bajos($id_e);

		if (is_array($rendimiento->arrDatos)) {
			$i = 1;
			$arrIds = array();
			foreach ($rendimiento->arrDatos as $key => $arrValores) {
				$unserialize = unserialize($key);
				foreach ($unserialize as $tipo => $valor) {
					if ($tipo == 'c_e') {
						$c_e += (int)$unserialize['c_e'];
					}
				}

				foreach ($arrValores as $tema => $arrTema) {
					foreach ($arrTema['id_suser'] as $cont => $id_suser) {
						if (!in_array($id_suser, $arrIds))
							array_push($arrIds, $id_suser);
					}
				}
			}
		}

		$ids = implode(',', $arrIds);

		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$ea = new PHPExcel();

		$ea->getProperties()

		->setCreator('Alto Desempeño')

		->setTitle('Clima Laboral')

		->setLastModifiedBy('Alto Desempeño')

		->setDescription('DIAGNÓSTICO DE CLIMA ORGANIZACIONAL')

		->setSubject('Resultados')

		->setKeywords('sonda clima laboral aldesis saegth')

		->setCategory('-');

		$ews = $ea->getSheet(0);

		$ews->setTitle('Resumen general');

		$ews->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

		$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$ews->mergeCells('a1:g1');

		$ews->getStyle('a1')->applyFromArray($style);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$ews->setCellValue('a3', 'Evaluados en proceso: ');

		$ews->mergeCells('a3:b3');

		$ews->getStyle('a3')->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$ews->setCellValue('c3', $c_e);

		$ews->getStyle('c3')->applyFromArray($style2);

		$ews->setCellValue('a6', 'Factores'); 

		$ews->mergeCells('a6:b6');

		$indice = 7;

		$promedio_general = array();

		$preguntas = $preguntas_general = '';

		
		if (is_array($rendimiento->arrDatos)) {
			foreach ($rendimiento->arrDatos as $key => $arrValores) {
				foreach ($arrValores as $id_tema => $arrTema) {

					$x->select($id_tema);
					$tema_nombre = ucfirst($x->getTema());
					$tema_id = $x->getId();
					$promedio = $arrTema['promedio'];

					$ews->setCellValue('a'.$indice, $indice-6);

					$ews->setCellValue('b'.$indice, $tema_nombre);

					$preguntas = implode(",", $arrTema['preguntas']);

					$preguntas_general .= implode(",", $arrTema['preguntas']).',';

					$porcentajes = $w->get_percent($ids,$preguntas, $rendimiento->min_avg);

					$ews->setCellValue('c'.$indice, $promedio);

					if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

					$ews->getStyle('c'.$indice)->applyFromArray($style3);

					$ews->setCellValue('e'.$indice, $porcentajes[0]."%");

					$ews->setCellValue('f'.$indice, $porcentajes[1]."%");

					$ews->setCellValue('g'.$indice, $porcentajes[2]."%");

					array_push($promedio_general, $promedio);

					$indice++;
				}
			}

			$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

			if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

			if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

			if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}
			
			$ews->setCellValue('b'.$indice, "Promedio general");

			$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$ews->getStyle('c'.$indice)->applyFromArray($style3);

			$ews->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			$ews->setCellValue('c'.$indice, $p_gen);

			$ews->setCellValue('d'.$indice, '');
			//		
			$preguntas_general = substr($preguntas_general, 0, -1);

			$porcentajes_generales = $w->get_percent($ids,$preguntas_general, $rendimiento->min_avg);

			$letra = '';

			if (is_array($porcentajes_generales)) {
				for ($i=0; $i < sizeof($porcentajes_generales) ; $i++) {
					if($i == 0){
						$letra = 'e';
						$color='00ff0000';
						$fc=array('rgb' => 'FFFFFF');
					}
					elseif($i == 1){
						$letra = 'f';
						$color='00ffff00';
						$fc=array('rgb' => '000000');
					}
					else{
						$letra = 'g';
						$color='0000ff00';
						$fc=array('rgb' => '000000');
					}

					$style3 = array('font' => array('size'=>12,'color' => $fc,'bold'  => true),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
					
					$ews->getStyle($letra.$indice)
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB($color);

					$ews->getStyle($letra.$indice)->applyFromArray($style3);

					$ews->setCellValue($letra.$indice, $porcentajes_generales[$i].'%');
				}
			}
			

			$indice--;

			$ews->getStyle('e7:g'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			$header = 'a6:g6';

			$ews->getStyle($header)->applyFromArray($style3);

			for ($i=0; $i < 3; $i++) { 

				$red = chr(101+$i).'7:'.chr(101+$i).$indice;

				switch ($i) {

					case 0:

					$color = '00ff0000';

					$fc = array('rgb' => 'FFFFFF');

					break;

					case 1:

					$color = '00ffff00';

					$fc = array('rgb' => '000000');

					break;

					case 2:

					$color = '0000ff00';

					$fc = array('rgb' => '000000');

					break;

				}

				$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

				$ews->getStyle($red)->applyFromArray($style);

			}

			for ($col = ord('a'); $col <= ord('h'); $col++){

				$ews->getColumnDimension(chr($col))->setAutoSize(true);

			}

			$ews2 = new PHPExcel_Worksheet($ea, 'Factores');

			$ea->addSheet($ews2, 1);

			$ews2->setTitle('Factores');

			$ews2->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

			$ews2->mergeCells('a1:g1');

			$ews2->getStyle('a1')->applyFromArray($style);

			$indice=4;

			foreach ($rendimiento->arrDatos as $key => $arrValores) {
				foreach ($arrValores as $id_tema => $arrTema) {

					$arrUsers = $arrTema['id_suser'];

					$ids = implode(",", $arrUsers);

					$preguntas = $arrTema['preguntas'];

					$promedio_general=array();

					$x->select($id_tema);

					$tema_nombre = trim(ucfirst($x->getTema_()));

					$ews2->setCellValue('b'.$indice, $tema_nombre);

					$indice++;

					$start_row=$indice;

					foreach ($preguntas as $p_key => $p_value) {

						$y->select($p_value);

						$id_p = $y->getId();

						$pregunta_nombre = trim($y->getPregunta_());

						$ews2->setCellValue('a'.$indice, $p_key+1);

						$ews2->setCellValue('b'.$indice, $pregunta_nombre);

						$promedio = $w->get_avg_x_pregunta($ids,$id_p,$rendimiento->min_avg);

						array_push($promedio_general, $promedio);

						$ews2->setCellValue('c'.$indice, $promedio);

						if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

						if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

						if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

						$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

						$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

						$ews2->getStyle('c'.$indice)->applyFromArray($style3);

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_p,$rendimiento->min_avg);

						$ews2->setCellValue('e'.$indice, $porcentajes[0]."%");

						$ews2->setCellValue('f'.$indice, $porcentajes[1]."%");

						$ews2->setCellValue('g'.$indice, $porcentajes[2]."%");

						$indice++;

					}

					for ($i=0; $i < 3; $i++) { 

						$red = chr(101+$i).$start_row.':'.chr(101+$i).($indice-1);

						switch ($i) {   case 0:   $color = '00ff0000';   $fc = array('rgb' => 'FFFFFF');   break;   case 1:   $color = '00ffff00';   $fc = array('rgb' =>

							'000000');   break;   case 2:   $color = '0000ff00';   $fc = array('rgb' => '000000');   break; }

						$ews2->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

						$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

						$ews2->getStyle($red)->applyFromArray($style);

					}

					$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

					if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews2->setCellValue('b'.$indice, "Promedio del factor	");

					$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$ews2->getStyle('c'.$indice)->applyFromArray($style3);

					$ews2->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

					$ews2->setCellValue('c'.$indice, $p_gen);

					$indice+=3;
				}
			}

			$ews2->getStyle('c5:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			for ($col = ord('c'); $col <= ord('g'); $col++){

				$ews2->getColumnDimension(chr($col))->setAutoSize(true);

			}

			$ews2->getColumnDimension('a')->setWidth(2);

			$ews2->getColumnDimension('b')->setWidth(130);
		}
		

		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$ea->setActiveSheetIndex(0);

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');        

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		exit();

	}

	function grupos_criticos($id_e, $id_sonda, $arrSondas){
		$arrSondas = stripslashes($arrSondas);
		$arrSondas = urldecode($arrSondas );
		$arrSondas = unserialize($arrSondas);
		//
		$rendimiento = new Rendimiento();
		$x = new Sonda_tema();
		$y = new Sonda_pregunta();
		$z = new Sonda_user();
		$w = new Sonda_respuesta();
		$sonda = new Sonda();

		$rendimiento->select($id_e);
		
		$ids = $z->get_id_x_empresa($rendimiento->getId(),$id_e);
		
		$temas = $rendimiento->getTemas();
		$last_id = $rendimiento->getId();

		foreach ($temas as $key => $value) {
			$preguntas = implode(",", $temas[$key]);
			$rendimiento->calculo_prom_bajos($ids,$key,$preguntas);
		}

		$rendimiento->promedios_bajos($id_e);

		if (is_array($rendimiento->arrDatos)) {

			Util::sessionStart();

			$nemp = $_SESSION['Empresa']['nombre'];

			$nemp = str_replace(" ", "_", $nemp);

			$this->dir=$this->location.'sonda'.DS.$nemp;

			$pdf = new pdf_sonda();

			self::paginas_inicio_sonda($pdf);

			//
			foreach ($rendimiento->arrDatos as $key => $arrValores) {
				$unserialize = unserialize($key);
				foreach ($unserialize as $tipo => $valor) {
					if ($tipo != 'c_e') {
						$filtro["tipo"] = $tipo;
						$filtro["valor"] = $valor;
						$rendimiento->filtros_criterios($filtro);
						$rendimiento->get_criterios();
					}else{
						$c_e = $unserialize['c_e'];
					}
				}
				$rendimiento->resetVariables();
				$args = $rendimiento->getArgs();
				$filtros = $rendimiento->criterios;

				//PAGINA FILTROS

				$filtros = explode("<br>", $filtros);

				if (is_array($arrSondas)) {
					foreach ($arrSondas as $cont_s => $id_sonda) {
						$fecha_sonda = $sonda->get_fecha_x_id($id_e, $id_sonda);
						//
						$pdf->AddPage();
						
						$pdf->SetFont('Times','B',12);

						$pdf->Cell(170,10,"FILTROS SELECCIONADOS",0,0,'C');

						$pdf->Ln(15);

						$pdf->Cell(61,5,"Fecha Sonda:",0,0,'L');

						$pdf->SetFont('Times','',12);

						$pdf->Cell(120,5,$fecha_sonda,0,0,'L');

						if (is_array($filtros)) {
							foreach ($filtros as $fil_key => $fil_val) {

								$fil_true_key = explode(":", $fil_val);

								if (array_filter($fil_true_key)) {

									$pdf->SetFont('Times','B',12);

									$pdf->Ln(5);

									$pdf->Cell(60,5,$fil_true_key[0].":",0,0,'L');

									$pdf->SetFont('Times','',12);

									$fil_true_key[1] = explode(",", $fil_true_key[1]);

									foreach ($fil_true_key[1] as $ftk_key => $ftk_val) {	

										if($ftk_key!=0)

											$pdf->Cell(60,5,"",0,0,'L');

										$pdf->Cell(120,5,$ftk_val,0,0,'L');
									}

								}
							}
						}
						
						// PROMEDIOS POR TEMAS
						$pdf->Ln(15);
						
						$pdf->SetFont('Times','B',12);

						$pdf->Cell(170,10,"RESULTADOS POR TEMAS",0,0,'C');

						$pdf->SetFont('Times','',12);

						$pdf->Ln(15);

						$indice = 1;

						$promedio_general = array();
						//
						foreach ($arrValores as $id_tema => $arrTema) {
							$x->select($id_tema);
							$tema_nombre = ucfirst($x->getTema());
							$tema_id = $x->getId();
							$arrUsers = $arrTema['id_suser'];
							$arrPreguntas = $arrTema['preguntas'];
							$preguntas = implode(',', $arrPreguntas);

							if($id_sonda == $last_id){
								$ids = implode(",", $arrUsers);
								$promedio = $arrTema['promedio'];
								$porcentajes = $w->get_percent($ids,$preguntas, $promedio);
							}else{
								$ids = $z->get_id_x_sonda($args, $id_e, $id_sonda);
								$promedio = $w->get_avg_x_tema($ids,$preguntas);
								$porcentajes = $w->get_percent($ids,$preguntas);
							}

							array_push($promedio_general, $promedio);

							$pdf->Ln();

							$pdf->Cell(10,10,$indice,1,0,'C');

							$pdf->Cell(70,10,$tema_nombre,1,0,'L');

							if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

							if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

							if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

							$pdf->Cell(10,10,number_format($promedio,2),1,0,'C',true);

							$pdf->SetFillColor(250,0,0);

							$pdf->SetTextColor(250,250,250);

							$pdf->Cell(25,10,number_format($porcentajes[0], 2, '.', ''),1,0,'C',true);

							$pdf->SetTextColor(0,0,0);

							$pdf->SetFillColor(250,250,0);

							$pdf->Cell(25,10,number_format($porcentajes[1], 2, '.', ''),1,0,'C',true);

							$pdf->SetFillColor(0,250,0);

							$pdf->Cell(25,10,number_format($porcentajes[2], 2, '.', ''),1,0,'C',true);

							$pdf->SetFillColor(229, 229, 229);

							$pdf->Cell(25,10,number_format($porcentajes[3], 2, '.', ''),1,0,'C',true);

							$pdf->SetFillColor(250,250,250);

							$indice++;
						}

						$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

						if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

						if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

						if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

						$pdf->Ln();

						$pdf->SetFont('Times','B',12);

						$pdf->Cell(80,5,"Promedio general:",1,0,'L',false);

						$pdf->Cell(10,5,number_format($p_gen,2),1,0,'L',true);

						$pdf->Cell(100,5,'',1,0,'L',false);

						$pdf->SetFillColor(250,250,250);
						
						//	RESULTADOS POR PREGUNTA
						$pdf->AddPage();

						$pdf->SetFont('Times','B',12);

						$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

						$pdf->Ln(15);

						$pdf->Cell(170,10,"RESULTADOS POR PREGUNTAS",0,0,'C');

						$pdf->Ln(15);

						$pdf->SetFont('Times','',8);

						foreach ($arrValores as $id_tema => $arrTema) {
							$x->select($id_tema);
							$tema_nombre = ucfirst($x->getTema());
							$arrUsers = $arrTema['id_suser'];
							$arrPreguntas = $arrTema['preguntas'];

							$indice=1;

							$promedio_general=array();

							foreach ($arrPreguntas as $p_key => $p_value) {

								$y->select($p_value);

								$id_p = $y->getId();

								if($id_sonda == $last_id){
									$ids = implode(",", $arrUsers);
									$promedio = $w->get_avg_x_pregunta($ids,$id_p, 3);
									$porcentajes = $w->get_percent_x_pregunta($ids,$id_p, 3);
								}else{
									$ids = $z->get_id_x_sonda($args, $id_e, $id_sonda);
									$promedio = $w->get_avg_x_pregunta($ids,$id_p);
									$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);
								}

								array_push($promedio_general, $promedio);

								$x->select($id_tema);

								$tema_nombre = ucfirst($x->getTema_());

								$tema_id = $x->getId();

								if ($indice==1){

									$pdf->SetFont('Times','B',12);

									// $pdf->SetY(45+(10*$indice));

									$pdf->Cell(190,10,$tema_nombre,1,0,'L');

									$pdf->Ln();

									$pdf->SetFont('Times','',8);

								}

								$pdf->Cell(10,10,$indice,1,0,'C');

								$pdf->Cell(110,10,$y->getPregunta_(),1,0,'L');

								if ( ($promedio>3.3331) ) $pdf->SetFillColor(0,250,0);

								if ( ($promedio>1.6666)&&($promedio<3.3330) ) $pdf->SetFillColor(250,250,0);

								if ( ($promedio<1.6665) ) $pdf->SetFillColor(250,0,0);

								$pdf->Cell(10,10,number_format($promedio,2),1,0,'C',true);

								$pdf->SetFillColor(250,0,0);

								$pdf->SetTextColor(250,250,250);

								$pdf->Cell(15,10,number_format($porcentajes[0], 2, '.', ''),1,0,'C',true);

								$pdf->SetTextColor(0,0,0);

								$pdf->SetFillColor(250,250,0);

								$pdf->Cell(15,10,number_format($porcentajes[1], 2, '.', ''),1,0,'C',true);

								$pdf->SetFillColor(0,250,0);

								$pdf->Cell(15,10,number_format($porcentajes[2], 2, '.', ''),1,0,'C',true);

								$pdf->SetFillColor(229, 229, 229);

								$pdf->Cell(15,10,number_format($porcentajes[2], 2, '.', ''),1,0,'C',true);

								$pdf->SetFillColor(250,250,250);

								$indice++;

								$pdf->Ln();
							}

							$p_gen = array_sum($promedio_general)/sizeof($promedio_general);

							if ( ($p_gen>3.3331) ) $pdf->SetFillColor(0,250,0);

							if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) $pdf->SetFillColor(250,250,0);

							if ( ($p_gen<1.6665) ) $pdf->SetFillColor(250,0,0);

							$pdf->SetFont('Times','B',12);

							$pdf->Cell(120,5,"Promedio",1,0,'L',false);

							$pdf->Cell(10,5,number_format($p_gen,2),1,0,'C',true);

							$pdf->Cell(60,5,"",1,0,'L',false);

							$pdf->SetFillColor(250,250,250);

							$pdf->Ln(15);
						}
					}
				}
			}
			//
			$nombre = $nemp.date('d-m-Y');

			self::makeDir($this->dir);

			$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

			$pdf->Output($nombre.'.pdf','D');
		}
	}

	function grupos_criticos_xls($id_e, $id_sonda, $arrSondas){
		$arrSondas = stripslashes($arrSondas);
		$arrSondas = urldecode($arrSondas );
		$arrSondas = unserialize($arrSondas);
		//
		$rendimiento = new Rendimiento();
		$sonda = new Sonda();
		$x = new Sonda_tema();
		$y = new Sonda_pregunta();
		$z = new Sonda_user();
		$w = new Sonda_respuesta();

		$rendimiento->select($id_e);
		
		$ids = $z->get_id_x_empresa($rendimiento->getId(),$id_e);
		
		$temas = $rendimiento->getTemas();

		$preguntas = '';

		$c_e = '';

		$last_sonda = $rendimiento->getId();

		$arrIdsLastSonda = array();

		$arrIdsSondas = array();

		foreach ($temas as $key => $value) {
			$preguntas = implode(",", $temas[$key]);
			$rendimiento->calculo_prom_bajos($ids,$key,$preguntas);
		}

		$rendimiento->promedios_bajos($id_e);
		//
		if (is_array($rendimiento->arrDatos)) {

			Util::sessionStart();

			$this->location=ROOT.DS.'public'.DS.'files'.DS;

			$nemp = $_SESSION['Empresa']['nombre'];

			$nemp = str_replace(" ", "_", $nemp);

			$this->dir=$this->location.'sonda'.DS.$nemp;

			$ea = new PHPExcel();

			$ea->getProperties()

			->setCreator('Alto Desempeño')

			->setTitle('Clima Laboral')

			->setLastModifiedBy('Alto Desempeño')

			->setDescription('DIAGNÓSTICO DE CLIMA ORGANIZACIONAL')

			->setSubject('Resultados')

			->setKeywords('sonda clima laboral aldesis saegth')

			->setCategory('-');

			$count_grupo = 0;

			foreach ($rendimiento->arrDatos as $key => $arrValores) {
				$unserialize = unserialize($key);
				foreach ($unserialize as $tipo => $valor) {
					if ($tipo != 'c_e') {
						$filtro["tipo"] = $tipo;
						$filtro["valor"] = $valor;
						$rendimiento->filtros_criterios($filtro);
						$rendimiento->get_criterios();
					}else{
						$c_e = $unserialize['c_e'];
					}
				}
				$rendimiento->resetVariables();
				$args = $rendimiento->getArgs();
				$count_grupo++;

				if ($count_grupo == 1) {
					$ews = $ea->getSheet(0);
				}else{
					$ews = new PHPExcel_Worksheet($ea, 'Grupo');

					$ea->addSheet($ews, 1);
				}

				$ews->setTitle('Grupo '.$count_grupo);

				$ews->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

				$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

				$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

				$ews->mergeCells('a1:h1');

				$ews->getStyle('a1')->applyFromArray($style);

				$ews->getColumnDimension('a')->setAutoSize(true);

				$indice = 3;

				if (is_array($arrSondas)) {
					foreach ($arrSondas as $key => $id_sonda) {
						$fecha_sonda = 'SONDA: '.$sonda->get_fecha_x_id($id_e, $id_sonda);
						$promedio_general = array();
						$preguntas_general = '';

						if ($id_sonda != $last_sonda) {
							$c_e=$z->get_evaluados($args,$id_sonda);
						}
						//
						$ews->setCellValue('a'.($indice), $fecha_sonda);

						$ews->mergeCells('a'.($indice).':b'.($indice));

						$ews->getStyle('a'.($indice))->applyFromArray($style2);

						$indice = $indice + 3;
						
						$ews->setCellValue('a'.($indice), 'RESULTADOS POR TEMAS');

						$ews->mergeCells('a'.($indice).':d'.($indice));

						$ews->getStyle('a'.($indice))->applyFromArray($style2);

						$ews->getColumnDimension('a')->setAutoSize(true);

						$indice = $indice + 2;
						
						$ews->setCellValue('a'.($indice), 'Evaluados en proceso: '.$c_e);

						$ews->mergeCells('a'.($indice).':b'.($indice));

						$ews->getStyle('a'.($indice))->applyFromArray($style2);

						$ews->getColumnDimension('a')->setAutoSize(true);

						$indice = $indice + 2;

						$ews->setCellValue('a'.($indice), 'Factores');

						$ews->getStyle('a'.($indice))->applyFromArray($style2);

						$ews->mergeCells('a'.($indice).':b'.($indice));

						$indice++;
						$count = 1;
						
						foreach ($arrValores as $id_tema => $arrTema) {

							$x->select($id_tema);
							$tema_nombre = ucfirst($x->getTema());
							$arrUsers = $arrTema['id_suser'];
							$arrPreguntas = $arrTema['preguntas'];
							$preguntas = implode(',', $arrPreguntas);
							$preguntas_general .= implode(",", $arrTema['preguntas']).',';


							if($id_sonda == $last_sonda){
								$ids = implode(",", $arrUsers);
								$promedio = $arrTema['promedio'];
								$porcentajes = $w->get_percent($ids,$preguntas, $promedio);
							}else{
								$ids = $z->get_id_x_sonda($args, $id_e, $id_sonda);
								$promedio = $w->get_avg_x_tema($ids,$preguntas);
								$porcentajes = $w->get_percent($ids,$preguntas);
							}

							if (!$promedio)
								$promedio = 0;

							$ews->setCellValue('a'.$indice, $count);

							$ews->setCellValue('b'.$indice, $tema_nombre);

							$ews->setCellValue('c'.$indice, $promedio);

							$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

							if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

							if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

							if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

							$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

							$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

							$ews->getStyle('c'.$indice)->applyFromArray($style3);

							$ews->setCellValue('e'.$indice, $porcentajes[0]."%");
							$red = 'e'.$indice;
							$color = '00ff0000';
							$fc = array('rgb' => 'FFFFFF');
							$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
							$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
							$ews->getStyle($red)->applyFromArray($style);

							//
							$ews->setCellValue('f'.$indice, $porcentajes[1]."%");
							$red = 'f'.$indice;
							$color = '00ffff00';
							$fc = array('rgb' => '000000');
							$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
							$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
							$ews->getStyle($red)->applyFromArray($style);
							//
							$ews->setCellValue('g'.$indice, $porcentajes[2]."%");
							$red = 'g'.$indice;
							$color = '0000ff00';
							$fc = array('rgb' => '000000');
							$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
							$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
							$ews->getStyle($red)->applyFromArray($style);
							//
							$ews->setCellValue('h'.$indice, $porcentajes[3]."%");
							$red = 'h'.$indice;
							$color = 'c0c0c0';
							$fc = array('rgb' => '000000');
							$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);
							$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
							$ews->getStyle($red)->applyFromArray($style);
							//
							array_push($promedio_general, $promedio);
							$indice++;
							$count++;
						}

						$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

						if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

						if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

						if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}
						
						$ews->setCellValue('b'.$indice, "Promedio general");

						$ews->getStyle('b'.$indice)->applyFromArray($style2);

						$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

						$ews->getStyle('c'.$indice)->applyFromArray($style3);

						$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

						$ews->setCellValue('c'.$indice, $p_gen);

						$ews->setCellValue('d'.$indice, '');
						//		
						$preguntas_general = substr($preguntas_general, 0, -1);
						
						if($id_sonda == $last_sonda)
							$porcentajes_generales = $w->get_percent($ids,$preguntas_general, 3);
						else
							$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

						$letra = '';

						if (is_array($porcentajes_generales)) {
							for ($i=0; $i < sizeof($porcentajes_generales) ; $i++) {
								if($i == 0){
									$letra = 'e';
									$color='00ff0000';
									$fc=array('rgb' => 'FFFFFF');
								}
								elseif($i == 1){
									$letra = 'f';
									$color='00ffff00';
									$fc=array('rgb' => '000000');
								}
								elseif($i == 2){
									$letra = 'g';
									$color='0000ff00';
									$fc=array('rgb' => '000000');
								}
								else{
									$letra = 'h';
									$color='c0c0c0';
									$fc=array('rgb' => '000000');
								}

								$style3 = array('font' => array('size'=>12,'color' => $fc,'bold'  => true),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
								
								$ews->getStyle($letra.$indice)
								->getFill()
								->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
								->getStartColor()
								->setARGB($color);

								$ews->getStyle($letra.$indice)->applyFromArray($style3);

								$ews->setCellValue($letra.$indice, $porcentajes_generales[$i].'%');

								$ews->getStyle('e'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
							}
						}

						// RESULTADOS POR PREGUNTAS
						$indice = $indice + 3;
						
						$ews->setCellValue('a'.($indice), 'RESULTADOS POR PREGUNTAS');

						$ews->mergeCells('a'.($indice).':d'.($indice));

						$ews->getStyle('a'.($indice))->applyFromArray($style2);

						$ews->getColumnDimension('a')->setAutoSize(true);

						$indice = $indice + 2;

						//
						foreach ($arrValores as $id_tema => $arrTema) {

							if ($id_sonda == $last_sonda){
								$arrUsers = $arrTema['id_suser'];
								$ids = implode(",", $arrUsers);
							}else{
								$ids = $z->get_id_x_sonda($args, $id_e, $id_sonda);
							}

							$preguntas = $arrTema['preguntas'];

							$promedio_general=array();

							$preguntas_general = '';

							$x->select($id_tema);

							$tema_nombre = trim(ucfirst($x->getTema_()));

							$ews->setCellValue('b'.$indice, $tema_nombre);

							$ews->getStyle('b'.$indice)->applyFromArray($style2);

							$indice++;

							$start_row=$indice;

							foreach ($preguntas as $p_key => $p_value) {

								$y->select($p_value);

								$id_p = $y->getId();

								$pregunta_nombre = trim($y->getPregunta_());

								$ews->setCellValue('a'.$indice, $p_key+1);

								$ews->setCellValue('b'.$indice, $pregunta_nombre);

								if($id_sonda == $last_sonda){
									$promedio = $w->get_avg_x_pregunta($ids,$id_p,3);
									$porcentajes = $w->get_percent_x_pregunta($ids,$id_p,3);
								}else{
									$promedio = $w->get_avg_x_pregunta($ids,$id_p);
									$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);
								}

								if(!$promedio)
									$promedio = 0;

								array_push($promedio_general, $promedio);

								$preguntas_general .= $id_p.',';

								$ews->setCellValue('c'.$indice, $promedio);

								if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

								if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

								if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

								$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

								$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

								$ews->getStyle('c'.$indice)->applyFromArray($style3);

								$ews->setCellValue('e'.$indice, $porcentajes[0]."%");

								$ews->setCellValue('f'.$indice, $porcentajes[1]."%");

								$ews->setCellValue('g'.$indice, $porcentajes[2]."%");

								$ews->setCellValue('h'.$indice, $porcentajes[3]."%");

								$indice++;
							}

							for ($i=0; $i < 4; $i++) { 

								$red = chr(101+$i).$start_row.':'.chr(101+$i).($indice-1);

								switch ($i) {   case 0:   $color = '00ff0000';   $fc = array('rgb' => 'FFFFFF');   break;   case 1:   $color = '00ffff00';   $fc = array('rgb' =>

									'000000');   break;   case 2:   $color = '0000ff00';   $fc = array('rgb' => '000000');   break; case 3:   $color = 'c0c0c0';   $fc = array('rgb' => '000000');   break;}

								$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

								$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

								$ews->getStyle($red)->applyFromArray($style);

							}

							$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

							if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

							if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

							if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

							$ews->setCellValue('b'.$indice, "Promedio general");

							$ews->getStyle('b'.$indice)->applyFromArray($style2);

							$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

							$ews->getStyle('c'.$indice)->applyFromArray($style3);

							$ews->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

							$ews->setCellValue('c'.$indice, $p_gen);
							//		
							$preguntas_general = substr($preguntas_general, 0, -1);
							
							if($id_sonda == $last_sonda)
								$porcentajes_generales = $w->get_percent($ids,$preguntas_general, 3);
							else
								$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

							$letra = '';

							if (is_array($porcentajes_generales)) {
								for ($i=0; $i < sizeof($porcentajes_generales) ; $i++) {
									if($i == 0){
										$letra = 'e';
										$color='00ff0000';
										$fc=array('rgb' => 'FFFFFF');
									}
									elseif($i == 1){
										$letra = 'f';
										$color='00ffff00';
										$fc=array('rgb' => '000000');
									}
									elseif($i == 2){
										$letra = 'g';
										$color='0000ff00';
										$fc=array('rgb' => '000000');
									}
									else{
										$letra = 'h';
										$color='c0c0c0';
										$fc=array('rgb' => '000000');
									}

									$style3 = array('font' => array('size'=>12,'color' => $fc,'bold'  => true),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
									
									$ews->getStyle($letra.$indice)
									->getFill()
									->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
									->getStartColor()
									->setARGB($color);

									$ews->getStyle($letra.$indice)->applyFromArray($style3);

									$ews->setCellValue($letra.$indice, $porcentajes_generales[$i].'%');

									$ews->getStyle('e'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
								}
							}

							$indice+=3;
						}

						$ews->getStyle('c5:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

						for ($col = ord('c'); $col <= ord('h'); $col++){

							$ews->getColumnDimension(chr($col))->setAutoSize(true);

						}

						$ews->getColumnDimension('a')->setWidth(2);

						$ews->getColumnDimension('b')->setWidth(80);
						//
						$indice = $indice + 5;
					}
				}
			}
			//
			$nombre = $nemp.date('d-m-Y');

			self::makeDir($this->dir);

			$ea->setActiveSheetIndex(0);

			$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');        

			$writer->save($this->dir.DS.$nombre.".xlsx");

			header('Content-type: application/vnd.ms-excel');

			header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

			header('Cache-Control: max-age=0');

			$writer->save('php://output');

			exit();
		}
	}

	//***********************************



	function paginas_inicio_sonda($pdf){

		Util::sessionStart();

		$empresaCab =$this->Pdf->htmlprnt_win($_SESSION['Empresa']['nombre']);



		//Hoja Presentacion

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12); 

		$pdf->Ln(12);

		$pdf->Image(BASEURL.DS.'public/img/Sonda.png',45,50,122,34.25);

		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'C');

		$pdf->Ln(80);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"EMPRESA:",0,0,'L');

		$pdf->Cell(100,10,"$empresaCab",0,0,'L');



		//Primera Hoja

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Ln(12);

		$pdf->Cell(190,10,"CONTENIDO DEL REPORTE",0,0,'C');

		$pdf->Ln(20);

		$pdf->Cell(190,10,"GUIA PARA EL MEJOR APROVECHAMIENTO DE ESTE REPORTE",0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(190,10,"1.- RESULTADO GENERAL",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'L');

		$pdf->Ln(20);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(190,10,"2.- COMPORTAMIENTOS OBSERVABLES Ó PREGUNTAS",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"RESULTADOS POR PREGUNTAS",0,0,'L');

		$pdf->Ln(20);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(190,5,"3.- PREGUNTAS CON PROMEDIO MÁS ALTO Y PROMEDIO MAS BAJO, DE LOS EVALUADORES",0,0,'L');

		$pdf->Ln(20);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(190,5,"4.- DETALLE FODA SEGÚN LOS ENCUESTADOS:",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"FORTALEZAS",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"OPORTUNIDADES",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"DEBILIDADES",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(20,10,"-",0,0,'R');

		$pdf->Cell(170,10,"AMENAZAS",0,0,'L');

		//Aquí escribimos lo que deseamos mostrar...





		//Segunda Hoka

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Ln(12);

		$pdf->Cell(190,10,"GUIA PARA EL MEJOR APROVECHAMIENTO DE ESTE REPORTE",0,0,'L');

		$pdf->Ln(15);

		$pdf->SetFont('Times','',10);

		$pdf->Cell(190,10,"Esta sección le ayudará a observar de una forma resumida y gráfica la retroalimentación que el personal que proporcionó a la empresa.",0,0,'L');

		$pdf->Ln(15);

		$pdf->Cell(190,10,"Hay que tener presente en todo momento que el Clima Organizacional es el modelador del comportamiento humano en la empresa.",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"También evidencia las falencias en el clima de trabajo ocasionadas por diversos aspectos que van desde la disponibilidad de recursos físicos",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"hasta el estilo de dirección.",0,0,'L');

		$pdf->Ln(15);

		$pdf->Cell(190,10,"Escala de Calificación.- La escala es de 1 a 6 y los resultados que usted apreciará se ven reflejados en un promedio general.",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"Se ha utilizado el sistema internacional de codificación de colores del semáforo para destacar los datos según las siguientes",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"categorías:",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->SetFillColor(0,250,0);

		$pdf->Cell(10,10,"",1,0,'L',true);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(30,10,"Favorable",0,0,'L');

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(80,10,"Rango de puntaje entre 3,3331 y 5.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->SetFillColor(250,250,0);

		$pdf->Cell(10,10,"",1,0,'L',true);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(30,10,"Requiere atención",0,0,'L');

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(80,10,"Rango de puntaje entre 1,6666 y 3,3330.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->SetFillColor(250,0,0);

		$pdf->Cell(10,10,"",1,0,'L',true);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(30,10,"Clara oportunidad",0,0,'L');

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(80,10,"Rango de puntaje entre 1 y 1,6665.",0,0,'L');


		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->SetFillColor(229, 229, 229);

		$pdf->Cell(10,10,"",1,0,'L',true);

		$pdf->Cell(10,10,"",0,0,'L');

		$pdf->Cell(30,10,"NO SE",0,0,'L');

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(80,10,"NO SE",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"El Informe general nos muestra un cuadro en el cual podemos ver el promedio de cada una de las categorías evaluadas, este puntaje va",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"de acuerdo  a las calificaciones dadas por cada uno de los evaluadores, así mismo encontraremos una columna donde nos muestra el",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"promedio general, el número de encuestas programadas y el número de encuestas contestadas.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"De igual forma encontraremos los cuadros que muestran cada una de las categorías evaluadas con sus respectivas preguntas, mostrando el",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"puntaje que los evaluadores le han puesto a cada una de ellas.",0,0,'L');



		//$pdf->Ln(15);
		$pdf->Ln(12);

		$pdf->Cell(190,10,"A manera de resumen se pueden observar las 10 preguntas con puntaje más alto y las 10 preguntas con puntajes más bajos.",0,0,'L');





		//Tercera Hoja

		//$pdf->AddPage();

		$pdf->Ln(12);

		$pdf->Cell(190,10,"Adicionalmente se muestran los comentarios escritos por cada uno de los evaluadores en forma de análisis FODA  \"Fortalezas,",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"Oportunidades de Mejora, Debilidades y Amenazas\".",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"Finalmente, nuestro sistema informático permite elaborar el plan de acción para gestionar su Diagnostico de Clima Laboral en base",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"a la selección de temas/preguntas que considere de mayor urgencia y/o prioridad para lo cual se recomienda segmentar los resultados",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(190,10,"a fin de asignar las acciones apropiadas según las características demográficas.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(190,10,"En caso de requerir asistencia adicional por favor no dude en contactarnos.",0,0,'L');

	}



	function sonda_xls($id_s, $arrTema=""){

		$arrTema = stripslashes($arrTema);
		$arrTema = urldecode($arrTema );
		$arrTema = unserialize($arrTema);

		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$ea = new PHPExcel();

		$ea->getProperties()

		->setCreator('Alto Desempeño')

		->setTitle('Clima Laboral')

		->setLastModifiedBy('Alto Desempeño')

		->setDescription('DIAGNÓSTICO DE CLIMA ORGANIZACIONAL')

		->setSubject('Resultados')

		->setKeywords('sonda clima laboral aldesis saegth')

		->setCategory('-');

		$ews = $ea->getSheet(0);

		$ews->setTitle('Resumen general');

		$ews->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

		$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$ews->mergeCells('a1:h1');

		$ews->getStyle('a1')->applyFromArray($style);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$ews->setCellValue('a3', 'Evaluados en proceso: ');

		$ews->mergeCells('a3:b3');

		$ews->getStyle('a3')->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$sonda = new Sonda();

		$sonda->select_($_SESSION['Empresa']['id'], $id_s);

		$seg = $sonda->getSegmentacion();

		$z = new Sonda_user();

		$x = new Sonda_tema();

		$y = new Sonda_pregunta();

		$w = new Sonda_respuesta();

		$args=$_SESSION['args'];

		$ids = $z->get_id_x_empresa($id_s, $_SESSION['Empresa']['id'],$args);

		$c_e=$z->get_evaluados($args,$id_s,'C');

		$ews->setCellValue('c3', $c_e);

		$ews->getStyle('c3')->applyFromArray($style2);

		$ews->setCellValue('a6', 'Factores'); 

		$ews->mergeCells('a6:b6');

		$temas = $sonda->getTemas();

		$indice = 7;

		$promedio_general = array();

		$preguntas = $preguntas_general = '';

		foreach ($temas as $key => $value) {

			if (isset($arrTema) && is_array($arrTema)) {
				if (in_array($key, $arrTema)) {
					$x->select($key);

					$tema_nombre = trim(ucfirst($x->getTema_()));

					$tema_id = $x->getId();

					$ews->setCellValue('a'.$indice, $indice-6);

					$ews->setCellValue('b'.$indice, $tema_nombre);

					$preguntas = implode(",", $temas[$key]);

					$preguntas_general .= implode(",", $temas[$key]).',';

					$promedio = $w->get_avg_x_tema($ids,$preguntas);

					$porcentajes = $w->get_percent($ids,$preguntas);

					$ews->setCellValue('c'.$indice, $promedio);

					if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

					$ews->getStyle('c'.$indice)->applyFromArray($style3);

					$ews->setCellValue('e'.$indice, $porcentajes[0]."%");

					$ews->setCellValue('f'.$indice, $porcentajes[1]."%");

					$ews->setCellValue('g'.$indice, $porcentajes[2]."%");

					$ews->setCellValue('h'.$indice, $porcentajes[3]."%");

					array_push($promedio_general, $promedio);

					$indice++;
				}
			}else{
				$x->select($key);

				$tema_nombre = trim(ucfirst($x->getTema_()));

				$tema_id = $x->getId();

				$ews->setCellValue('a'.$indice, $indice-6);

				$ews->setCellValue('b'.$indice, $tema_nombre);

				$preguntas = implode(",", $temas[$key]);

				$preguntas_general .= implode(",", $temas[$key]).',';

				$promedio = $w->get_avg_x_tema($ids,$preguntas);

				$porcentajes = $w->get_percent($ids,$preguntas);

				$ews->setCellValue('c'.$indice, $promedio);

				if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

				if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

				if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

				$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

				$ews->getStyle('c'.$indice)->applyFromArray($style3);

				$ews->setCellValue('e'.$indice, $porcentajes[0]."%");

				$ews->setCellValue('f'.$indice, $porcentajes[1]."%");

				$ews->setCellValue('g'.$indice, $porcentajes[2]."%");

				$ews->setCellValue('h'.$indice, $porcentajes[3]."%");

				array_push($promedio_general, $promedio);

				$indice++;
			}
		}

		$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

		if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

		if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

		if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}
		
		$ews->setCellValue('b'.$indice, "Promedio general");

		$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

		$ews->getStyle('c'.$indice)->applyFromArray($style3);

		$ews->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$ews->setCellValue('c'.$indice, $p_gen);

		$ews->setCellValue('d'.$indice, '');
		//		
		$preguntas_general = substr($preguntas_general, 0, -1);

		$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

		$letra = '';

		if (is_array($porcentajes_generales)) {
			for ($i=0; $i < sizeof($porcentajes_generales) ; $i++) {
				if($i == 0){
					$letra = 'e';
					$color='00ff0000';
					$fc=array('rgb' => 'FFFFFF');
				}
				elseif($i == 1){
					$letra = 'f';
					$color='00ffff00';
					$fc=array('rgb' => '000000');
				}
				elseif($i == 2){
					$letra = 'g';
					$color='0000ff00';
					$fc=array('rgb' => '000000');
				}
				else{
					$letra = 'h';
					$color='c0c0c0';
					$fc=array('rgb' => '000000');
				}

				$style3 = array('font' => array('size'=>12,'color' => $fc,'bold'  => true),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
				
				$ews->getStyle($letra.$indice)
		        ->getFill()
		        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		        ->getStartColor()
		        ->setARGB($color);

		        $ews->getStyle($letra.$indice)->applyFromArray($style3);

				$ews->setCellValue($letra.$indice, $porcentajes_generales[$i].'%');
			}
		}
		

		$indice--;

		$ews->getStyle('e7:h'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$header = 'a6:h6';

		$ews->getStyle($header)->applyFromArray($style3);

		for ($i=0; $i < 4; $i++) { 

			$red = chr(101+$i).'7:'.chr(101+$i).$indice;

			switch ($i) {

				case 0:

				$color = '00ff0000';

				$fc = array('rgb' => 'FFFFFF');

				break;

				case 1:

				$color = '00ffff00';

				$fc = array('rgb' => '000000');

				break;

				case 2:

				$color = '0000ff00';

				$fc = array('rgb' => '000000');

				break;

				case 3:

				$color = 'c0c0c0';

				$fc = array('rgb' => '000000');

				break;

			}

			$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

			$ews->getStyle($red)->applyFromArray($style);

		}

		for ($col = ord('a'); $col <= ord('h'); $col++){

			$ews->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews2 = new PHPExcel_Worksheet($ea, 'Factores');

		$ea->addSheet($ews2, 1);

		$ews2->setTitle('Factores');

		$ews2->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

		$ews2->mergeCells('a1:h1');

		$ews2->getStyle('a1')->applyFromArray($style);

		$indice=4;

		foreach ($temas as $key => $value) {

			if (isset($arrTema) && is_array($arrTema)) {
				if (in_array($key, $arrTema)) {
					$preguntas = $temas[$key];

					$promedio_general=array();

					$x->select($key);

					$tema_nombre = trim(ucfirst($x->getTema_()));

					$ews2->setCellValue('b'.$indice, $tema_nombre);

					$indice++;

					$start_row=$indice;

					foreach ($preguntas as $p_key => $p_value) {

						$y->select($p_value);

						$id_p = $y->getId();

						$pregunta_nombre = trim($y->getPregunta_());

						$ews2->setCellValue('a'.$indice, $p_key+1);

						$ews2->setCellValue('b'.$indice, $pregunta_nombre);

						$promedio = $w->get_avg_x_pregunta($ids,$id_p);

						array_push($promedio_general, $promedio);

						$ews2->setCellValue('c'.$indice, $promedio);

						if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

						if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

						if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

						$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

						$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

						$ews2->getStyle('c'.$indice)->applyFromArray($style3);

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

						$ews2->setCellValue('e'.$indice, $porcentajes[0]."%");

						$ews2->setCellValue('f'.$indice, $porcentajes[1]."%");

						$ews2->setCellValue('g'.$indice, $porcentajes[2]."%");

						$ews2->setCellValue('h'.$indice, $porcentajes[3]."%");

						$indice++;

					}

					for ($i=0; $i < 4; $i++) { 

						$red = chr(101+$i).$start_row.':'.chr(101+$i).($indice-1);

						switch ($i) {   case 0:   $color = '00ff0000';   $fc = array('rgb' => 'FFFFFF');   break;   case 1:   $color = '00ffff00';   $fc = array('rgb' =>

							'000000');   break;   case 2:   $color = '0000ff00';   $fc = array('rgb' => '000000');   break; case 3:   $color = 'c0c0c0';   $fc = array('rgb' => '000000');   break;}

						$ews2->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

						$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

						$ews2->getStyle($red)->applyFromArray($style);

					}

					$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

					if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews2->setCellValue('b'.$indice, "Promedio del factor	");

					$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$ews2->getStyle('c'.$indice)->applyFromArray($style3);

					$ews2->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

					$ews2->setCellValue('c'.$indice, $p_gen);

					$indice+=3;
				}
			}else{
				$preguntas = $temas[$key];

				$promedio_general=array();

				$x->select($key);

				$tema_nombre = trim(ucfirst($x->getTema_()));

				$ews2->setCellValue('b'.$indice, $tema_nombre);

				$indice++;

				$start_row=$indice;

				foreach ($preguntas as $p_key => $p_value) {

					$y->select($p_value);

					$id_p = $y->getId();

					$pregunta_nombre = trim($y->getPregunta_());

					$ews2->setCellValue('a'.$indice, $p_key+1);

					$ews2->setCellValue('b'.$indice, $pregunta_nombre);

					$promedio = $w->get_avg_x_pregunta($ids,$id_p);

					array_push($promedio_general, $promedio);

					$ews2->setCellValue('c'.$indice, $promedio);

					if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

					$ews2->getStyle('c'.$indice)->applyFromArray($style3);

					$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

					$ews2->setCellValue('e'.$indice, $porcentajes[0]."%");

					$ews2->setCellValue('f'.$indice, $porcentajes[1]."%");

					$ews2->setCellValue('g'.$indice, $porcentajes[2]."%");

					$ews2->setCellValue('h'.$indice, $porcentajes[3]."%");

					$indice++;

				}

				for ($i=0; $i < 4; $i++) { 

					$red = chr(101+$i).$start_row.':'.chr(101+$i).($indice-1);

					switch ($i) {   case 0:   $color = '00ff0000';   $fc = array('rgb' => 'FFFFFF');   break;   case 1:   $color = '00ffff00';   $fc = array('rgb' =>

						'000000');   break;   case 2:   $color = '0000ff00';   $fc = array('rgb' => '000000');   break; case 3:   $color = 'c0c0c0';   $fc = array('rgb' => '000000');   break;}

					$ews2->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

					$ews2->getStyle($red)->applyFromArray($style);

				}

				$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

				if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

				if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

				if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

				$ews2->setCellValue('b'.$indice, "Promedio del factor	");

				$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$ews2->getStyle('c'.$indice)->applyFromArray($style3);

				$ews2->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

				$ews2->setCellValue('c'.$indice, $p_gen);

				$indice+=3;
			}
		}

		$ews2->getStyle('c5:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		for ($col = ord('c'); $col <= ord('h'); $col++){

			$ews2->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews2->getColumnDimension('a')->setWidth(2);

		$ews2->getColumnDimension('b')->setWidth(130);

		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$ea->setActiveSheetIndex(0);

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');        

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		exit();

	}

	function sonda_xls_compara($id_s, $arrTema=""){

		$arrTema = stripslashes($arrTema);
		$arrTema = urldecode($arrTema );
		$arrTema = unserialize($arrTema);

		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$ea = new PHPExcel();

		$ea->getProperties()

		->setCreator('Alto Desempeño')

		->setTitle('Clima Laboral')

		->setLastModifiedBy('Alto Desempeño')

		->setDescription('DIAGNÓSTICO DE CLIMA ORGANIZACIONAL')

		->setSubject('Resultados')

		->setKeywords('sonda clima laboral aldesis saegth')

		->setCategory('-');

		$ews = $ea->getSheet(0);

		$ews->setTitle('Resumen general');

		$ews->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

		$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$ews->mergeCells('a1:h1');

		$ews->getStyle('a1')->applyFromArray($style);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$ews->setCellValue('a3', 'Evaluados en proceso: ');

		$ews->mergeCells('a3:b3');

		$ews->getStyle('a3')->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$sonda = new Sonda();

		$sonda->select_compara($_SESSION['Empresa']['id'], $id_s);

		$seg = $sonda->getSegmentacion();

		$z = new Sonda_user();

		$x = new Sonda_tema();

		$y = new Sonda_pregunta();

		$w = new Sonda_respuesta();

		$args=$_SESSION['args'];

		$c_e=$z->get_evaluados($args,$id_s,'C');

		$ews->setCellValue('c3', $c_e);

		$ews->getStyle('c3')->applyFromArray($style2);

		$ews->setCellValue('a6', 'Factores'); 

		$ews->mergeCells('a6:b6');

		$temas = $sonda->getTemas();

		$indice = 7;

		$promedio_general = array();

		$preguntas = $preguntas_general = '';

		foreach ($temas as $key => $value) {

			if (isset($arrTema) && is_array($arrTema)) {
				if (in_array($key, $arrTema)) {
					$x->select($key);

					$tema_nombre = trim(ucfirst($x->getTema_()));

					$tema_id = $x->getId();

					$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_s, $key, $args);

					$ews->setCellValue('a'.$indice, $indice-6);

					$ews->setCellValue('b'.$indice, $tema_nombre);

					$preguntas = implode(",", $temas[$key]);

					$preguntas_general .= implode(",", $temas[$key]).',';

					$promedio = $w->get_avg_x_tema($ids,$preguntas);
					if($promedio == '')
						$promedio = 0;

					$porcentajes = $w->get_percent($ids,$preguntas);

					$ews->setCellValue('c'.$indice, $promedio);

					if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

					$ews->getStyle('c'.$indice)->applyFromArray($style3);

					$ews->setCellValue('e'.$indice, $porcentajes[0]."%");

					$ews->setCellValue('f'.$indice, $porcentajes[1]."%");

					$ews->setCellValue('g'.$indice, $porcentajes[2]."%");

					$ews->setCellValue('h'.$indice, $porcentajes[2]."%");

					if($promedio != 0)
						array_push($promedio_general, $promedio);

					$indice++;
				}
			}else{
				$x->select($key);

				$tema_nombre = trim(ucfirst($x->getTema_()));

				$tema_id = $x->getId();

				$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_s, $key, $args);

				$ews->setCellValue('a'.$indice, $indice-6);

				$ews->setCellValue('b'.$indice, $tema_nombre);

				$preguntas = implode(",", $temas[$key]);

				$preguntas_general .= implode(",", $temas[$key]).',';

				$promedio = $w->get_avg_x_tema($ids,$preguntas);
				if($promedio == '')
					$promedio = 0;

				$porcentajes = $w->get_percent($ids,$preguntas);

				$ews->setCellValue('c'.$indice, $promedio);

				if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

				if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

				if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

				$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

				$ews->getStyle('c'.$indice)->applyFromArray($style3);

				$ews->setCellValue('e'.$indice, $porcentajes[0]."%");

				$ews->setCellValue('f'.$indice, $porcentajes[1]."%");

				$ews->setCellValue('g'.$indice, $porcentajes[2]."%");

				$ews->setCellValue('h'.$indice, $porcentajes[2]."%");

				if($promedio != 0)
					array_push($promedio_general, $promedio);

				$indice++;
			}

		}

		$p_gen = 0;

		if(sizeof($promedio_general) > 0)
			$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

		if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

		if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

		if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

		$ews->setCellValue('b'.$indice, "Promedio general");

		$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

		$ews->getStyle('c'.$indice)->applyFromArray($style3);

		$ews->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$ews->setCellValue('c'.$indice, $p_gen);

		//		
		$preguntas_general = substr($preguntas_general, 0, -1);

		$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_s, '', $args);

		$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

		$letra = '';

		if (is_array($porcentajes_generales)) {
			for ($i=0; $i < sizeof($porcentajes_generales) ; $i++) {
				if($i == 0){
					$letra = 'e';
					$color='00ff0000';
					$fc=array('rgb' => 'FFFFFF');
				}
				elseif($i == 1){
					$letra = 'f';
					$color='00ffff00';
					$fc=array('rgb' => '000000');
				}
				elseif($i == 2){
					$letra = 'g';
					$color='0000ff00';
					$fc=array('rgb' => '000000');
				}
				else{
					$letra = 'h';
					$color='c0c0c0';
					$fc=array('rgb' => '000000');
				}

				$style3 = array('font' => array('size'=>12,'color' => $fc,'bold'  => true),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
				
				$ews->getStyle($letra.$indice)
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setARGB($color);

				$ews->getStyle($letra.$indice)->applyFromArray($style3);

				$ews->setCellValue($letra.$indice, $porcentajes_generales[$i].'%');
			}
		}

		$indice--;

		$ews->getStyle('e7:h'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$header = 'a6:h6';

		$ews->getStyle($header)->applyFromArray($style3);

		for ($i=0; $i < 4; $i++) { 

			$red = chr(101+$i).'7:'.chr(101+$i).$indice;

			switch ($i) {

				case 0:

				$color = '00ff0000';

				$fc = array('rgb' => 'FFFFFF');

				break;

				case 1:

				$color = '00ffff00';

				$fc = array('rgb' => '000000');

				break;

				case 2:

				$color = '0000ff00';

				$fc = array('rgb' => '000000');

				break;

				case 3:

				$color = 'c0c0c0';

				$fc = array('rgb' => '000000');

				break;

			}

			$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

			$ews->getStyle($red)->applyFromArray($style);

		}

		for ($col = ord('a'); $col <= ord('h'); $col++){

			$ews->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews2 = new PHPExcel_Worksheet($ea, 'Factores');

		$ea->addSheet($ews2, 1);

		$ews2->setTitle('Factores');

		$ews2->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

		$ews2->mergeCells('a1:h1');

		$ews2->getStyle('a1')->applyFromArray($style);

		$indice=4;

		foreach ($temas as $key => $value) {

			if (isset($arrTema) && is_array($arrTema)) {
				if (in_array($key, $arrTema)) {
					$preguntas = $temas[$key];

					$promedio_general=array();

					$x->select($key);

					$tema_nombre = trim(ucfirst($x->getTema_()));

					$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_s, $key, $args);

					$ews2->setCellValue('b'.$indice, $tema_nombre);

					$indice++;

					$start_row=$indice;

					foreach ($preguntas as $p_key => $p_value) {

						$y->select($p_value);

						$id_p = $y->getId();

						$pregunta_nombre = trim($y->getPregunta_());

						$ews2->setCellValue('a'.$indice, $p_key+1);

						$ews2->setCellValue('b'.$indice, $pregunta_nombre);

						$promedio = $w->get_avg_x_pregunta($ids,$id_p);

						if($promedio == '')
							$promedio = 0;

						if($promedio != 0)
							array_push($promedio_general, $promedio);

						$ews2->setCellValue('c'.$indice, $promedio);

						if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

						if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

						if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

						$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

						$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

						$ews2->getStyle('c'.$indice)->applyFromArray($style3);

						$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

						$ews2->setCellValue('e'.$indice, $porcentajes[0]."%");

						$ews2->setCellValue('f'.$indice, $porcentajes[1]."%");

						$ews2->setCellValue('g'.$indice, $porcentajes[2]."%");

						$ews2->setCellValue('h'.$indice, $porcentajes[3]."%");

						$indice++;

					}

					for ($i=0; $i < 4; $i++) { 

						$red = chr(101+$i).$start_row.':'.chr(101+$i).($indice-1);

						switch ($i) {   case 0:   $color = '00ff0000';   $fc = array('rgb' => 'FFFFFF');   break;   case 1:   $color = '00ffff00';   $fc = array('rgb' =>

							'000000');   break;   case 2:   $color = '0000ff00';   $fc = array('rgb' => '000000');   break; case 3:   $color = 'c0c0c0';   $fc = array('rgb' => '000000');   break;}

						$ews2->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

						$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

						$ews2->getStyle($red)->applyFromArray($style);

					}
					
					$p_gen = 0;

					if(sizeof($promedio_general) > 0)
						$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

					if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews2->setCellValue('b'.$indice, "Promedio del factor	");

					$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$ews2->getStyle('c'.$indice)->applyFromArray($style3);

					$ews2->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

					$ews2->setCellValue('c'.$indice, $p_gen);

					$indice+=3;
				}
			}else{
				$preguntas = $temas[$key];

				$promedio_general=array();

				$x->select($key);

				$tema_nombre = trim(ucfirst($x->getTema_()));

				$ids = $z->get_id_compara($_SESSION['Empresa']['id'], $id_s, $key, $args);

				$ews2->setCellValue('b'.$indice, $tema_nombre);

				$indice++;

				$start_row=$indice;

				foreach ($preguntas as $p_key => $p_value) {

					$y->select($p_value);

					$id_p = $y->getId();

					$pregunta_nombre = trim($y->getPregunta_());

					$ews2->setCellValue('a'.$indice, $p_key+1);

					$ews2->setCellValue('b'.$indice, $pregunta_nombre);

					$promedio = $w->get_avg_x_pregunta($ids,$id_p);

					if($promedio == '')
						$promedio = 0;

					if($promedio != 0)
						array_push($promedio_general, $promedio);

					$ews2->setCellValue('c'.$indice, $promedio);

					if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

					if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

					if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

					$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

					$ews2->getStyle('c'.$indice)->applyFromArray($style3);

					$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

					$ews2->setCellValue('e'.$indice, $porcentajes[0]."%");

					$ews2->setCellValue('f'.$indice, $porcentajes[1]."%");

					$ews2->setCellValue('g'.$indice, $porcentajes[2]."%");

					$ews2->setCellValue('h'.$indice, $porcentajes[3]."%");

					$indice++;

				}

				for ($i=0; $i < 4; $i++) { 

					$red = chr(101+$i).$start_row.':'.chr(101+$i).($indice-1);

					switch ($i) {   case 0:   $color = '00ff0000';   $fc = array('rgb' => 'FFFFFF');   break;   case 1:   $color = '00ffff00';   $fc = array('rgb' =>

						'000000');   break;   case 2:   $color = '0000ff00';   $fc = array('rgb' => '000000');   break; case 3:   $color = 'c0c0c0';   $fc = array('rgb' => '000000');   break;}

					$ews2->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

					$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

					$ews2->getStyle($red)->applyFromArray($style);

				}
				
				$p_gen = 0;

				if(sizeof($promedio_general) > 0)
					$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

				if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

				if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

				if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

				$ews2->setCellValue('b'.$indice, "Promedio del factor	");

				$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$ews2->getStyle('c'.$indice)->applyFromArray($style3);

				$ews2->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

				$ews2->setCellValue('c'.$indice, $p_gen);

				$indice+=3;
			}
		}

		$ews2->getStyle('c5:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		for ($col = ord('c'); $col <= ord('h'); $col++){

			$ews2->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews2->getColumnDimension('a')->setWidth(2);

		$ews2->getColumnDimension('b')->setWidth(130);

		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$ea->setActiveSheetIndex(0);

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');        

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		exit();

	}

	function sonda_xls_seg($id_s, $campo, $valor){

		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'sonda'.DS.$nemp;

		$ea = new PHPExcel();

		$ea->getProperties()

		->setCreator('Alto Desempeño')

		->setTitle('Clima Laboral')

		->setLastModifiedBy('Alto Desempeño')

		->setDescription('DIAGNÓSTICO DE CLIMA ORGANIZACIONAL')

		->setSubject('Resultados')

		->setKeywords('sonda clima laboral aldesis saegth')

		->setCategory('-');

		$ews = $ea->getSheet(0);

		$ews->setTitle('Resumen general');

		$ews->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

		$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$ews->mergeCells('a1:h1');

		$ews->getStyle('a1')->applyFromArray($style);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$ews->setCellValue('a3', 'Evaluados en proceso: ');

		$ews->mergeCells('a3:b3');

		$ews->getStyle('a3')->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$sonda = new Sonda();

		$sonda->select_($_SESSION['Empresa']['id'], $id_s);

		$seg = $sonda->getSegmentacion();

		$z = new Sonda_user();

		$x = new Sonda_tema();

		$y = new Sonda_pregunta();

		$w = new Sonda_respuesta();

		$args=$_SESSION['args'];

		$c_e=$z->get_evaluados($args,$id_s,'C');

		$ews->setCellValue('c3', $c_e);

		$ews->getStyle('c3')->applyFromArray($style2);

		$ews->setCellValue('a6', 'Factores'); 

		$ews->mergeCells('a6:b6');

		$temas = $sonda->getTemas();

		$indice = 7;

		$promedio_general = array();

		$preguntas = $preguntas_general = '';

		foreach ($temas as $key => $value) {

			$x->select($key);

			$tema_nombre = trim(ucfirst($x->getTema_()));

			$tema_id = $x->getId();

			$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $id_s, $key, $campo, $valor);

			$ews->setCellValue('a'.$indice, $indice-6);

			$ews->setCellValue('b'.$indice, $tema_nombre);

			$preguntas = implode(",", $temas[$key]);

			$preguntas_general .= implode(",", $temas[$key]).',';

			$promedio = $w->get_avg_x_tema($ids,$preguntas);
			if($promedio == '')
				$promedio = 0;

			$porcentajes = $w->get_percent($ids,$preguntas);

			$ews->setCellValue('c'.$indice, $promedio);

			if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

			if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

			if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

			$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

			$ews->getStyle('c'.$indice)->applyFromArray($style3);

			$ews->setCellValue('e'.$indice, $porcentajes[0]."%");

			$ews->setCellValue('f'.$indice, $porcentajes[1]."%");

			$ews->setCellValue('g'.$indice, $porcentajes[2]."%");

			$ews->setCellValue('h'.$indice, $porcentajes[3]."%");

			if($promedio != 0)
				array_push($promedio_general, $promedio);

			$indice++;

		}

		$p_gen = 0;

		if(sizeof($promedio_general) > 0)
			$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

		if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

		if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

		if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

		$ews->setCellValue('b'.$indice, "Promedio general");

		$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

		$ews->getStyle('c'.$indice)->applyFromArray($style3);

		$ews->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$ews->setCellValue('c'.$indice, $p_gen);

		//		
		$preguntas_general = substr($preguntas_general, 0, -1);

		$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $id_s, '', $campo, $valor);

		$porcentajes_generales = $w->get_percent($ids,$preguntas_general);

		$letra = '';

		if (is_array($porcentajes_generales)) {
			for ($i=0; $i < sizeof($porcentajes_generales) ; $i++) {
				if($i == 0){
					$letra = 'e';
					$color='00ff0000';
					$fc=array('rgb' => 'FFFFFF');
				}
				elseif($i == 1){
					$letra = 'f';
					$color='00ffff00';
					$fc=array('rgb' => '000000');
				}
				elseif($i == 2){
					$letra = 'g';
					$color='0000ff00';
					$fc=array('rgb' => '000000');
				}
				else{
					$letra = 'h';
					$color='c0c0c0';
					$fc=array('rgb' => '000000');
				}

				$style3 = array('font' => array('size'=>12,'color' => $fc,'bold'  => true),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
				
				$ews->getStyle($letra.$indice)
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()
				->setARGB($color);

				$ews->getStyle($letra.$indice)->applyFromArray($style3);

				$ews->setCellValue($letra.$indice, $porcentajes_generales[$i].'%');
			}
		}

		$indice--;

		$ews->getStyle('e7:h'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$header = 'a6:h6';

		$ews->getStyle($header)->applyFromArray($style3);

		for ($i=0; $i < 4; $i++) { 

			$red = chr(101+$i).'7:'.chr(101+$i).$indice;

			switch ($i) {

				case 0:

				$color = '00ff0000';

				$fc = array('rgb' => 'FFFFFF');

				break;

				case 1:

				$color = '00ffff00';

				$fc = array('rgb' => '000000');

				break;

				case 2:

				$color = '0000ff00';

				$fc = array('rgb' => '000000');

				break;

				case 3:

				$color = 'c0c0c0';

				$fc = array('rgb' => '000000');

				break;

			}

			$ews->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

			$ews->getStyle($red)->applyFromArray($style);

		}

		for ($col = ord('a'); $col <= ord('h'); $col++){

			$ews->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews2 = new PHPExcel_Worksheet($ea, 'Factores');

		$ea->addSheet($ews2, 1);

		$ews2->setTitle('Factores');

		$ews2->setCellValue('a1', 'DIAGNÓSTICO DE CLIMA ORGANIZACIONAL');

		$ews2->mergeCells('a1:h1');

		$ews2->getStyle('a1')->applyFromArray($style);

		$indice=4;

		foreach ($temas as $key => $value) {

			$preguntas = $temas[$key];

			$promedio_general=array();

			$x->select($key);

			$tema_nombre = trim(ucfirst($x->getTema_()));

			$ids = $z->get_id_x_segmentacion($_SESSION['Empresa']['id'], $id_s, $key, $campo, $valor);

			$ews2->setCellValue('b'.$indice, $tema_nombre);

			$indice++;

			$start_row=$indice;

			foreach ($preguntas as $p_key => $p_value) {

				$y->select($p_value);

				$id_p = $y->getId();

				$pregunta_nombre = trim($y->getPregunta_());

				$ews2->setCellValue('a'.$indice, $p_key+1);

				$ews2->setCellValue('b'.$indice, $pregunta_nombre);

				$promedio = $w->get_avg_x_pregunta($ids,$id_p);

				if($promedio == '')
					$promedio = 0;

				if($promedio != 0)
					array_push($promedio_general, $promedio);

				$ews2->setCellValue('c'.$indice, $promedio);

				if ( ($promedio>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

				if ( ($promedio>1.6666)&&($promedio<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

				if ( ($promedio<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

				$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

				$ews2->getStyle('c'.$indice)->applyFromArray($style3);

				$porcentajes = $w->get_percent_x_pregunta($ids,$id_p);

				$ews2->setCellValue('e'.$indice, $porcentajes[0]."%");

				$ews2->setCellValue('f'.$indice, $porcentajes[1]."%");

				$ews2->setCellValue('g'.$indice, $porcentajes[2]."%");

				$ews2->setCellValue('h'.$indice, $porcentajes[3]."%");

				$indice++;

			}

			for ($i=0; $i < 4; $i++) { 

				$red = chr(101+$i).$start_row.':'.chr(101+$i).($indice-1);

				switch ($i) {   case 0:   $color = '00ff0000';   $fc = array('rgb' => 'FFFFFF');   break;   case 1:   $color = '00ffff00';   $fc = array('rgb' =>

					'000000');   break;   case 2:   $color = '0000ff00';   $fc = array('rgb' => '000000');   break; case 3:   $color = 'c0c0c0';   $fc = array('rgb' => '000000');   break;}

				$ews2->getStyle($red)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$style = array('font' => array('bold' => true,'size'=>12,'color' => $fc), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

				$ews2->getStyle($red)->applyFromArray($style);

			}
			
			$p_gen = 0;

			if(sizeof($promedio_general) > 0)
				$p_gen = array_sum($promedio_general)/sizeof($promedio_general);	

			if ( ($p_gen>3.3331) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

			if ( ($p_gen>1.6666)&&($p_gen<3.3330) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

			if ( ($p_gen<1.6665) ) {$color='00ff0000';$fc=array('rgb' => 'FFFFFF');}

			$ews2->setCellValue('b'.$indice, "Promedio del factor	");

			$ews2->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$ews2->getStyle('c'.$indice)->applyFromArray($style3);

			$ews2->getStyle('c7:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			$ews2->setCellValue('c'.$indice, $p_gen);

			$indice+=3;

		}

		$ews2->getStyle('c5:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		for ($col = ord('c'); $col <= ord('h'); $col++){

			$ews2->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews2->getColumnDimension('a')->setWidth(2);

		$ews2->getColumnDimension('b')->setWidth(130);

		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$ea->setActiveSheetIndex(0);

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');        

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		exit();

	}

	function rp($id_e, $id_riesgo, $args_url, $filtros_url){
		$filtros = $args = '';

		$args_url = stripslashes($args_url);
		$args_url = urldecode($args_url );
		$args = unserialize($args_url);

		$filtros_url = stripslashes($filtros_url);
		$filtros_url = urldecode($filtros_url );
		$filtros = unserialize($filtros_url);
		/////////////////////////////////////////
		Util::sessionStart();

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'rp'.DS.$nemp;

		$pdf = new pdf_rp();

		self::paginas_inicio_rp($pdf);

		$riesgo = new Riesgo_psicosocial();

		$fecha_riesgo = $riesgo->get_fecha_x_id($id_e, $id_riesgo);



		//PAGINA FILTROS

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"FILTROS SELECCIONADOS",0,0,'C');

		$pdf->Ln(15);

		$filtros = str_replace(" ", "+", $filtros);

		$filtros = str_replace("/", "*", $filtros);

		$filtros = str_replace("*", "/", $filtros);

		$filtros = str_replace("+", " ", $filtros);

		$filtros = ($filtros=="''") ? "Todos" : $filtros;

		foreach ($filtros as $fil_key => $fil_val) {

			$fil_true_key = explode(":", $fil_val);

			if (array_filter($fil_true_key)) {

				$pdf->SetFont('Times','B',12);

				$pdf->Ln(2);

				$pdf->Cell(60,5,$fil_true_key[0].":",0,0,'L');

				$pdf->SetFont('Times','',12);

				$fil_true_key[1] = explode(",", $fil_true_key[1]);

				foreach ($fil_true_key[1] as $ftk_key => $ftk_val) {	

					if($ftk_key!=0)

						$pdf->Cell(60,5,"",0,0,'L');

					$pdf->Cell(120,5,$ftk_val,0,0,'L');

					$pdf->Ln(5);

				}
			}

		}

		//REPORTE RESULTADOS

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','',8);

		$rp = new riesgo_psicosocial();

		$rp->select($id_e);

		$seg = $rp->getSegmentacion();

		$z = new rp_user();

		$x = new rp_tema();

		$y = new rp_pregunta();

		$w = new rp_respuesta();

		$ids = $z->get_id_x_riesgo($args, $id_riesgo);

		$c_e=$z->get_evaluados($args,$id_riesgo);

		$temas = $x->select_all_();

		$indice = 1;

		$preguntas = $preguntas_general = '';

		foreach ($temas as $key => $value) {
			$id_t = $value['id'];
			$preguntas = $y->select_ids_x_tema($id_t);
			$preguntas_general .= $preguntas.',';
			$porcentajes = number_format($w->get_percent($ids,$preguntas), 2);
			//
			$newX = $pdf->GetX();

			$newY = $pdf->GetY();

			$pdf->SetFont('Times','',11);

			$h = $pdf->calculaHeightMulticell(85,5,ucwords(html_entity_decode($value['tema']))."\n\n".html_entity_decode($value['descripcion']),1,'L',false);

			$pdf->Cell(10,$h,$key+1,1,0,'C');

			$pdf->MultiCell(85,5,ucwords(html_entity_decode($value['tema']))."\n\n".html_entity_decode($value['descripcion']),1,'L',false);			

			$aux_newY = $pdf->GetY();

			if($aux_newY < $newY){
				$newY = $pdf->tMargin;
			}

			$pdf->setY($newY);

			$pdf->setX($newX + 95);

			$pdf->SetFillColor(250,250,250);

			if ( ($porcentajes>=85) ) {
				$pdf->SetFillColor(250,0,0);
			}

			if ( ($porcentajes>=75)&&($porcentajes<85) ){
				$pdf->SetFillColor(250, 95, 0);
			}

			if ( ($porcentajes>=65)&&($porcentajes<75) ){
				$pdf->SetFillColor(250,250,0);
			}

			if ( ($porcentajes<65) ){
				$pdf->SetFillColor(0,250,0);
			}

			//$pdf->SetTextColor(250,250,250);

			//$pdf->SetFont('Times','B',15);

			$pdf->Cell((100*$porcentajes)/100,$h,$porcentajes,1,1,'C',true);
			
			//$pdf->SetTextColor(0,0,0);

			//$pdf->SetFont('Times','',11);

		}

		$preguntas_general = substr($preguntas_general, 0, -1);
		$porcentajes = number_format($w->get_percent($ids,$preguntas_general), 2);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(95,10,'Promedio general',1,0,'L');

		if ( ($porcentajes>=85) ) {
			$pdf->SetFillColor(250,0,0);
		}

		if ( ($porcentajes>=75)&&($porcentajes<85) ){
			$pdf->SetFillColor(250, 95, 0);
		}

		if ( ($porcentajes>=65)&&($porcentajes<75) ){
			$pdf->SetFillColor(250,250,0);
		}

		if ( ($porcentajes<65) ){
			$pdf->SetFillColor(0,250,0);
		}

		$pdf->Cell((100*$porcentajes)/100,10,$porcentajes,1,1,'C',true);

		//
		$indice=0;

		foreach ($temas as $valor){

			$indice=0;

			$pdf->AddPage();

			$pdf->SetFont('Times','B',12);

			$pdf->Cell(170,10,"RESULTADOS POR PREGUNTA",0,0,'C');

			$pdf->Ln(15);

			$pdf->SetFont('Times','B',12);

			$pdf->SetX(10);

			$pdf->Cell(0,10,html_entity_decode(ucwords($valor['tema'])),0,0,'L'); 

			$pdf->Ln(15);

			$preg = $y->select_x_tema_($valor['id'], $ids);

			$pdf->SetFont('Times','',10);

			$pregunta = $preguntas_general = '';

			foreach ($preg as $key => $value) {

				$id_pregunta = $value['id'];

				$preguntas_general .= $id_pregunta.',';

				//
				if ($indice>10){

					$pdf->AddPage();

					$pdf->SetFont('Times','B',12);

					$pdf->SetX(10);

					$pdf->Cell(0,10,html_entity_decode(ucwords($valor['tema'])),0,0,'L');  

					$pdf->SetFont('Times','',10);

					$pdf->Ln(10);

					$indice=0;

				}

				$pdf->Ln(20);

				$pdf->SetFillColor(250,250,250);

				$pdf->SetY(50+(15*$indice));

				$pdf->SetX(10);

				$pdf->Multicell(80,3,html_entity_decode($value["pregunta"]),0,'L',false);

				$pdf->SetY(50+(15*$indice));

				$pdf->SetX(100);

				if ( ($value["porcentaje"]>=85) ) {

					$pdf->SetFillColor(250,0,0);

				}	

				if ( ($value["porcentaje"]>=75)&&($value["porcentaje"]<85) ){

					$pdf->SetFillColor(250, 95, 0);

				}	

				if ( ($value["porcentaje"]>=65)&&($value["porcentaje"]<75) ){

					$pdf->SetFillColor(250,250,0);

				}   

				if ( ($value["porcentaje"]<65) ){ 

					$pdf->SetFillColor(0,250,0);

				}	

				$pdf->Cell((100*$value["porcentaje"])/100,15,$value["porcentaje"],1,1,'C',true);

				$indice++;

			}

			$preguntas_general = substr($preguntas_general, 0, -1);

			$porcentajes = number_format($w->get_percent($ids,$preguntas_general), 2);

			$pdf->SetFont('Times','B',12);

			$pdf->Cell(90,10,'Promedio general',0,0,'L');

			if ( ($porcentajes>=85) ) {
				$pdf->SetFillColor(250,0,0);
			}

			if ( ($porcentajes>=75)&&($porcentajes<85) ){
				$pdf->SetFillColor(250, 95, 0);
			}

			if ( ($porcentajes>=65)&&($porcentajes<75) ){
				$pdf->SetFillColor(250,250,0);
			}

			if ( ($porcentajes<65) ){
				$pdf->SetFillColor(0,250,0);
			}

			$pdf->Cell((100*$porcentajes)/100,15,$porcentajes,1,1,'C',true);

		}

		//
		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');

	}

	function rp_xls($id_e, $id_riesgo, $args_url, $filtros_url){

		$args_url = stripslashes($args_url);
		$args_url = urldecode($args_url );
		$args = unserialize($args_url);

		$riesgo = new Riesgo_psicosocial();

		$z = new rp_user();

		$x = new rp_tema();

		$y = new rp_pregunta();

		$w = new rp_respuesta();

		$fecha_riesgo = "RIESGO: ".$riesgo->get_fecha_x_id($id_e, $id_riesgo);

		$ids = $z->get_id_x_riesgo($args, $id_riesgo);

		$c_e=$z->get_evaluados($args,$id_riesgo);

		$temas = $x->select_all_();

		//
		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'rp'.DS.$nemp;

		$ea = new PHPExcel();

		$ea->getProperties()

		->setCreator('Alto Desempeño')

		->setTitle('Riesgo psicosocial')

		->setLastModifiedBy('Alto Desempeño')

		->setDescription('Riesgo Psicosocial')

		->setSubject('Resultados')

		->setKeywords('rp clima laboral aldesis saegth')

		->setCategory('-');

		$ews = $ea->getSheet(0);

		$ews->setTitle('Resumen general');

		$ews->setCellValue('a1', 'RIESGO PSICOSOCIAL');

		$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$ews->mergeCells('a1:g1');

		$ews->getStyle('a1')->applyFromArray($style);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = 3;

		$ews->setCellValue('a'.($indice), $fecha_riesgo);

		$ews->mergeCells('a'.($indice).':b'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$indice = $indice + 3;
		
		$ews->setCellValue('a'.($indice), 'RESULTADOS POR TEMAS');

		$ews->mergeCells('a'.($indice).':d'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = $indice + 2;
		
		$ews->setCellValue('a'.($indice), 'Evaluados en proceso: '.$c_e);

		$ews->mergeCells('a'.($indice).':b'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = $indice + 2;

		$ews->setCellValue('a'.($indice), 'Factores');

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->mergeCells('a'.($indice).':b'.($indice));

		$indice++;
		
		$count = 1;

		$preguntas = $preguntas_general = '';

		foreach ($temas as $key => $value) {

			$tema_nombre = html_entity_decode(trim(ucfirst($value['tema'])));

			$tema_id = $value['id'];

			$preguntas = $y->select_ids_x_tema($tema_id);
			
			$preguntas_general .= $preguntas.',';

			$promedio = $temas[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);

			//
			$ews->setCellValue('a'.$indice, $count);

			$ews->setCellValue('b'.$indice, $tema_nombre);

			$ews->setCellValue('c'.$indice, $promedio);

			$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

			if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

			if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

			if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

			$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

			$ews->getStyle('c'.$indice)->applyFromArray($style3);
			//
			$indice++;
			$count++;

		}

		$preguntas_general = substr($preguntas_general, 0, -1);
		
		$promedio = number_format($w->get_percent($ids,$preguntas_general), 2);

		if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

		if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

		if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

		if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}
		
		$ews->setCellValue('b'.$indice, "Promedio general");

		$ews->getStyle('b'.$indice)->applyFromArray($style2);

		$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

		$ews->getStyle('c'.$indice)->applyFromArray($style3);

		$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$ews->setCellValue('c'.$indice, $promedio);

		// RESULTADOS POR PREGUNTAS
		$indice = $indice + 3;
		
		$ews->setCellValue('a'.($indice), 'RESULTADOS POR PREGUNTAS');

		$ews->mergeCells('a'.($indice).':d'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = $indice + 2;

		foreach ($temas as $key => $value) {

			$preguntas = $y->select_x_tema_($value['id'], $ids);

			$promedio_general=array();

			$tema_nombre = html_entity_decode(trim(ucfirst($value['tema'])));

			$ews->setCellValue('b'.$indice, $tema_nombre);

			$ews->getStyle('b'.$indice)->applyFromArray($style2);

			$indice++;

			$start_row=$indice;

			$pregunta = $preguntas_general = '';

			foreach ($preguntas as $p_key => $p_value) {

				$id_p = $p_value['id'];

				$preguntas_general .= $id_p.',';

				$pregunta_nombre = html_entity_decode(trim($p_value['pregunta']));

				$ews->setCellValue('a'.$indice, $p_key+1);

				$ews->setCellValue('b'.$indice, $pregunta_nombre);

				$promedio = $p_value['porcentaje'];

				$ews->setCellValue('c'.$indice, $promedio);

				if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

				if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

				if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

				if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

				$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

				$ews->getStyle('c'.$indice)->applyFromArray($style3);

				$indice++;

			}

			$preguntas_general = substr($preguntas_general, 0, -1);
		
			$promedio = number_format($w->get_percent($ids,$preguntas_general), 2);

			if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

			if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

			if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

			if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}
			
			$ews->setCellValue('b'.$indice, "Promedio general");

			$ews->getStyle('b'.$indice)->applyFromArray($style2);

			$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$ews->getStyle('c'.$indice)->applyFromArray($style3);

			$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			$ews->setCellValue('c'.$indice, $promedio);

			$indice+=4;

		}

		$ews->getStyle('c5:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		for ($col = ord('c'); $col <= ord('g'); $col++){

			$ews->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews->getColumnDimension('a')->setWidth(3);

		$ews->getColumnDimension('b')->setWidth(130);
		//
		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$ea->setActiveSheetIndex(0);

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');      

		ob_end_clean();  

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		exit();

	}

	function rp_seg($id_e, $id_riesgo, $campo, $valor, $args_url, $filtros_url){

		$args_url = stripslashes($args_url);
		$args_url = urldecode($args_url );
		$args = unserialize($args_url);

		$filtros_url = stripslashes($filtros_url);
		$filtros_url = urldecode($filtros_url );
		$filtros = unserialize($filtros_url);
		//////////////////////////////////////////////////////////////////7
		Util::sessionStart();

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'rp'.DS.$nemp;

		$pdf = new pdf_rp();

		self::paginas_inicio_rp($pdf);

		$riesgo = new Riesgo_psicosocial();

		$fecha_riesgo = $riesgo->get_fecha_x_id($id_e, $id_riesgo);

		//PAGINA FILTROS

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"FILTROS SELECCIONADOS",0,0,'C');

		$pdf->Ln(15);

		$filtros = str_replace(" ", "+", $filtros);

		$filtros = str_replace("/", "*", $filtros);

		$filtros = str_replace("*", "/", $filtros);

		$filtros = str_replace("+", " ", $filtros);

		$filtros = ($filtros=="''") ? "Todos" : $filtros;

		foreach ($filtros as $fil_key => $fil_val) {

			$fil_true_key = explode(":", $fil_val);

			if (array_filter($fil_true_key)) {

				$pdf->SetFont('Times','B',12);

				$pdf->Ln(2);

				$pdf->Cell(60,5,$fil_true_key[0].":",0,0,'L');

				$pdf->SetFont('Times','',12);

				$fil_true_key[1] = explode(",", $fil_true_key[1]);

				foreach ($fil_true_key[1] as $ftk_key => $ftk_val) {	

					if($ftk_key!=0)

						$pdf->Cell(60,5,"",0,0,'L');

					$pdf->Cell(120,5,$ftk_val,0,0,'L');

					$pdf->Ln(5);

				}
			}
		}

		//REPORTE RESULTADOS

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(170,10,"REPORTE DE RESULTADOS",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(170,10,"RESULTADOS POR CATEGORIA",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','',8);

		$rp = new riesgo_psicosocial();

		$rp->select($id_e);

		$seg = $rp->getSegmentacion();

		$z = new rp_user();

		$x = new rp_tema();

		$y = new rp_pregunta();

		$w = new rp_respuesta();

		$ids = $z->get_id_x_segmentacion($id_e, $id_riesgo, $campo, $valor);

		$c_e=$z->get_evaluados($args,$id_riesgo);

		$temas = $x->select_all_();

		$indice = 1;

		$preguntas = $preguntas_general = '';

		foreach ($temas as $key => $value) {
			$id_t = $value['id'];
			$preguntas = $y->select_ids_x_tema($id_t);
			$preguntas_general .= $preguntas.',';
			$porcentajes = number_format($w->get_percent($ids,$preguntas), 2);
			//
			$newX = $pdf->GetX();

			$newY = $pdf->GetY();

			$pdf->SetFont('Times','',11);

			$h = $pdf->calculaHeightMulticell(85,5,ucwords(html_entity_decode($value['tema']))."\n\n".html_entity_decode($value['descripcion']),1,'L',false);

			$pdf->Cell(10,$h,$key+1,1,0,'C');

			$pdf->MultiCell(85,5,ucwords(html_entity_decode($value['tema']))."\n\n".html_entity_decode($value['descripcion']),1,'L',false);			

			$aux_newY = $pdf->GetY();

			if($aux_newY < $newY){
				$newY = $pdf->tMargin;
			}

			$pdf->setY($newY);

			$pdf->setX($newX + 95);

			$pdf->SetFillColor(250,250,250);

			if ( ($porcentajes>=85) ) {
				$pdf->SetFillColor(250,0,0);
			}

			if ( ($porcentajes>=75)&&($porcentajes<85) ){
				$pdf->SetFillColor(250, 95, 0);
			}

			if ( ($porcentajes>=65)&&($porcentajes<75) ){
				$pdf->SetFillColor(250,250,0);
			}

			if ( ($porcentajes<65) ){
				$pdf->SetFillColor(0,250,0);
			}

			//$pdf->SetTextColor(250,250,250);

			//$pdf->SetFont('Times','B',15);

			$pdf->Cell((100*$porcentajes)/100,$h,$porcentajes,1,1,'C',true);
			
			//$pdf->SetTextColor(0,0,0);

			//$pdf->SetFont('Times','',11);

		}

		$preguntas_general = substr($preguntas_general, 0, -1);
		$porcentajes = number_format($w->get_percent($ids,$preguntas_general), 2);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(95,10,'Promedio general',1,0,'L');

		if ( ($porcentajes>=85) ) {
			$pdf->SetFillColor(250,0,0);
		}

		if ( ($porcentajes>=75)&&($porcentajes<85) ){
			$pdf->SetFillColor(250, 95, 0);
		}

		if ( ($porcentajes>=65)&&($porcentajes<75) ){
			$pdf->SetFillColor(250,250,0);
		}

		if ( ($porcentajes<65) ){
			$pdf->SetFillColor(0,250,0);
		}

		$pdf->Cell((100*$porcentajes)/100,10,$porcentajes,1,1,'C',true);


		//
		$indice=0;

		foreach ($temas as $valor){

			$indice=0;

			$pdf->AddPage();

			$pdf->SetFont('Times','B',12);

			$pdf->Cell(170,10,"RESULTADOS POR PREGUNTA",0,0,'C');

			$pdf->Ln(15);

			$pdf->SetFont('Times','B',12);

			$pdf->SetX(10);

			$pdf->Cell(0,10,html_entity_decode(ucwords($valor['tema'])),0,0,'L'); 

			$pdf->Ln(15);

			$preg = $y->select_x_tema_($valor['id'], $ids);

			$pdf->SetFont('Times','',10);

			$pregunta = $preguntas_general = '';

			foreach ($preg as $key => $value) {

				$id_pregunta = $value['id'];

				$preguntas_general .= $id_pregunta.',';

				//
				if ($indice>10){

					$pdf->AddPage();

					$pdf->SetFont('Times','B',12);

					$pdf->SetX(10);

					$pdf->Cell(0,10,html_entity_decode(ucwords($valor['tema'])),0,0,'L');  

					$pdf->SetFont('Times','',10);

					$pdf->Ln(10);

					$indice=0;

				}

				$pdf->Ln(20);

				$pdf->SetFillColor(250,250,250);

				$pdf->SetY(50+(15*$indice));

				$pdf->SetX(10);

				$pdf->Multicell(80,3,html_entity_decode($value["pregunta"]),0,'L',false);

				$pdf->SetY(50+(15*$indice));

				$pdf->SetX(100);

				if ( ($value["porcentaje"]>=85) ) {

					$pdf->SetFillColor(250,0,0);

				}	

				if ( ($value["porcentaje"]>=75)&&($value["porcentaje"]<85) ){

					$pdf->SetFillColor(250, 95, 0);

				}	

				if ( ($value["porcentaje"]>=65)&&($value["porcentaje"]<75) ){

					$pdf->SetFillColor(250,250,0);

				}   

				if ( ($value["porcentaje"]<65) ){ 

					$pdf->SetFillColor(0,250,0);

				}	

				$pdf->Cell((100*$value["porcentaje"])/100,15,$value["porcentaje"],1,1,'C',true);

				$indice++;

			}

			$preguntas_general = substr($preguntas_general, 0, -1);

			$porcentajes = number_format($w->get_percent($ids,$preguntas_general), 2);

			$pdf->SetFont('Times','B',12);

			$pdf->Cell(90,10,'Promedio general',0,0,'L');

			if ( ($porcentajes>=85) ) {
				$pdf->SetFillColor(250,0,0);
			}

			if ( ($porcentajes>=75)&&($porcentajes<85) ){
				$pdf->SetFillColor(250, 95, 0);
			}

			if ( ($porcentajes>=65)&&($porcentajes<75) ){
				$pdf->SetFillColor(250,250,0);
			}

			if ( ($porcentajes<65) ){
				$pdf->SetFillColor(0,250,0);
			}

			$pdf->Cell((100*$porcentajes)/100,15,$porcentajes,1,1,'C',true);

		}

		//
		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$pdf->Output($this->dir.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');
	}

	function rp_xls_seg($id_e, $id_riesgo, $campo, $valor, $args_url, $filtros_url){

		$args_url = stripslashes($args_url);
		$args_url = urldecode($args_url );
		$args = unserialize($args_url);
		///////////////////////////////////////////////
		$riesgo = new Riesgo_psicosocial();

		$z = new rp_user();

		$x = new rp_tema();

		$y = new rp_pregunta();

		$w = new rp_respuesta();

		$fecha_riesgo = "RIESGO: ".$riesgo->get_fecha_x_id($id_e, $id_riesgo);

		$ids = $z->get_id_x_segmentacion($id_e, $id_riesgo, $campo, $valor);

		$c_e=$z->get_evaluados($args,$id_riesgo);

		$temas = $x->select_all_();

		//
		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'rp'.DS.$nemp;

		$ea = new PHPExcel();

		$ea->getProperties()

		->setCreator('Alto Desempeño')

		->setTitle('Riesgo psicosocial')

		->setLastModifiedBy('Alto Desempeño')

		->setDescription('Riesgo Psicosocial')

		->setSubject('Resultados')

		->setKeywords('rp clima laboral aldesis saegth')

		->setCategory('-');

		$ews = $ea->getSheet(0);

		$ews->setTitle('Resumen general');

		$ews->setCellValue('a1', 'RIESGO PSICOSOCIAL');

		$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$ews->mergeCells('a1:g1');

		$ews->getStyle('a1')->applyFromArray($style);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = 3;

		$ews->setCellValue('a'.($indice), $fecha_riesgo);

		$ews->mergeCells('a'.($indice).':b'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$indice = $indice + 3;
		
		$ews->setCellValue('a'.($indice), 'RESULTADOS POR TEMAS');

		$ews->mergeCells('a'.($indice).':d'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = $indice + 2;
		
		$ews->setCellValue('a'.($indice), 'Evaluados en proceso: '.$c_e);

		$ews->mergeCells('a'.($indice).':b'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = $indice + 2;

		$ews->setCellValue('a'.($indice), 'Factores');

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->mergeCells('a'.($indice).':b'.($indice));

		$indice++;
		
		$count = 1;

		$preguntas = $preguntas_general = '';

		foreach ($temas as $key => $value) {

			$tema_nombre = html_entity_decode(trim(ucfirst($value['tema'])));

			$tema_id = $value['id'];

			$preguntas = $y->select_ids_x_tema($tema_id);
			
			$preguntas_general .= $preguntas.',';

			$promedio = $temas[$key]['porcentajes'] = $w->get_percent($ids,$preguntas);

			//
			$ews->setCellValue('a'.$indice, $count);

			$ews->setCellValue('b'.$indice, $tema_nombre);

			$ews->setCellValue('c'.$indice, $promedio);

			$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

			if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

			if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

			if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

			$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

			$ews->getStyle('c'.$indice)->applyFromArray($style3);
			//
			$indice++;
			$count++;

		}

		$preguntas_general = substr($preguntas_general, 0, -1);
		
		$promedio = number_format($w->get_percent($ids,$preguntas_general), 2);

		if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

		if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

		if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

		if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}
		
		$ews->setCellValue('b'.$indice, "Promedio general");

		$ews->getStyle('b'.$indice)->applyFromArray($style2);

		$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

		$ews->getStyle('c'.$indice)->applyFromArray($style3);

		$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		$ews->setCellValue('c'.$indice, $promedio);

		// RESULTADOS POR PREGUNTAS
		$indice = $indice + 3;
		
		$ews->setCellValue('a'.($indice), 'RESULTADOS POR PREGUNTAS');

		$ews->mergeCells('a'.($indice).':d'.($indice));

		$ews->getStyle('a'.($indice))->applyFromArray($style2);

		$ews->getColumnDimension('a')->setAutoSize(true);

		$indice = $indice + 2;

		foreach ($temas as $key => $value) {

			$preguntas = $y->select_x_tema_($value['id'], $ids);

			$promedio_general=array();

			$tema_nombre = html_entity_decode(trim(ucfirst($value['tema'])));

			$ews->setCellValue('b'.$indice, $tema_nombre);

			$ews->getStyle('b'.$indice)->applyFromArray($style2);

			$indice++;

			$start_row=$indice;

			$pregunta = $preguntas_general = '';

			foreach ($preguntas as $p_key => $p_value) {

				$id_p = $p_value['id'];

				$preguntas_general .= $id_p.',';

				$pregunta_nombre = html_entity_decode(trim($p_value['pregunta']));

				$ews->setCellValue('a'.$indice, $p_key+1);

				$ews->setCellValue('b'.$indice, $pregunta_nombre);

				$promedio = $p_value['porcentaje'];

				$ews->setCellValue('c'.$indice, $promedio);

				if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

				if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

				if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

				if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}

				$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

				$style3 = array('font' => array('size'=>12,'color' => $fc),     'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);

				$ews->getStyle('c'.$indice)->applyFromArray($style3);

				$indice++;

			}

			$preguntas_general = substr($preguntas_general, 0, -1);
		
			$promedio = number_format($w->get_percent($ids,$preguntas_general), 2);

			if ( ($promedio>=85) ) {$color='00ff0000';$fc=array('rgb' => '000000');}

			if ( ($promedio>=75)&&($promedio<85) ) {$color='00ff4500';$fc=array('rgb' => '000000');}

			if ( ($promedio>=65)&&($promedio<75) ) {$color='00ffff00';$fc=array('rgb' => '000000');}

			if ( ($promedio<65) ) {$color='0000ff00';$fc=array('rgb' => '000000');}
			
			$ews->setCellValue('b'.$indice, "Promedio general");

			$ews->getStyle('b'.$indice)->applyFromArray($style2);

			$ews->getStyle('c'.$indice)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);

			$ews->getStyle('c'.$indice)->applyFromArray($style3);

			$ews->getStyle('c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

			$ews->setCellValue('c'.$indice, $promedio);

			$indice+=4;

		}

		$ews->getStyle('c5:c'.$indice)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		for ($col = ord('c'); $col <= ord('g'); $col++){

			$ews->getColumnDimension(chr($col))->setAutoSize(true);

		}

		$ews->getColumnDimension('a')->setWidth(3);

		$ews->getColumnDimension('b')->setWidth(130);

		//
		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$ea->setActiveSheetIndex(0);

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');      

		ob_end_clean();  

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		exit();
	}



	function paginas_inicio_rp($pdf){

		Util::sessionStart();

		$empresaCab =$this->Pdf->htmlprnt_win($_SESSION['Empresa']['nombre']);



		//Hoja Presentacion

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12); 

		$pdf->Ln(12);

		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'C');

		$pdf->Ln(80);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"EMPRESA:",0,0,'L');

		$pdf->Cell(100,10,"$empresaCab",0,0,'L');



		//Primera Hoja

		$pdf->AliasNbPages();



		$pdf->AddPage();

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(0,10,"CONTENIDO DEL REPORTE",0,0,'C'); 

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',10);

		$pdf->Cell(0,10,"GUIA PARA MEJOR APROVECHAMIENTO DEL REPORTE",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->Cell(0,10,"1.- RESULTADO GENERAL",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->Cell(20,10,"",0,0,'L'); 

		$pdf->SetFont('Times','',10);

		$pdf->Cell(0,10,"•	RESULTADOS POR CATEGORIA",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',10);

		$pdf->Cell(0,10,"2.- COMPORTAMIENTOS OBSERVABLES O PREGUNTAS",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->Cell(20,10,"",0,0,'L'); 

		$pdf->SetFont('Times','',10);

		$pdf->Cell(0,10,"•	RESULTADOS POR PREGUNTAS",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',10);

		$pdf->Cell(0,10,"3.- PREGUNTAS  CON PROMEDIO MÁS ALTO Y  PROMEDIO MAS BAJO, DE LOS EVALUADORES",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(0,10,"4.- DETALLE FODA SEGÚN LOS ENCUESTADOS",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(20,10,"",0,0,'L'); 

		$pdf->SetFont('Times','',10);

		$pdf->Cell(0,10,"•	FORTALEZAS",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->Cell(20,10,"",0,0,'L'); 

		$pdf->Cell(0,10,"•	OPORTUNIDADES ",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->Cell(20,10,"",0,0,'L'); 

		$pdf->Cell(0,10,"•	DEBILIDADES",0,0,'L'); 

		$pdf->Ln(10);

		$pdf->Cell(20,10,"",0,0,'L'); 

		$pdf->Cell(0,10,"•	AMENAZAS",0,0,'L'); 



		$pdf->AddPage();

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(0,10,"1.- DESCRIPCIÓN DEL RIESGO PSICOSOCIAL*",0,0,'L'); 

		$pdf->SetFont('Times','',14);

		$pdf->Ln(15);

		$pdf->Cell(0,10,"Los factores psicosociales en el trabajo son complejos y difíciles de entender, dado que",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"representan el conjunto de las percepciones y conjunto de las percepciones y experiencias",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"del trabajadory abarcan muchos  aspectos. Uno de los grandes problemas de los factores",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"psicosociales es la dificultad para encontrar dificultad para encontrar unidades de medida",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"objetiva unidades de medida objetiva.",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(0,10,"Por definición (OIT, 1986), se basan en se basan en percepciones y experiencias.",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"Los factores psicosociales en el trabajo consisten en interacciones entre el trabajo, su",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"medio ambiente, la satisfacción en eltrabajo y las condiciones organización, por una parte,",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"y por la otra, las capacidades del trabajador, sus necesidades, su cultura y su situación",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(48,10," personal fuera del trabajo, todo lo cual, a través de percepciones y experiencias, puede",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"influir en la salud, en el rendimiento y en la satisfacción en el trabajo.",0,0,'L');   

		$pdf->Ln(10);

		$pdf->Cell(0,10,"Aquellas condiciones presentes en una situación laboral directamente relacionada con",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"organización del trabajo, elcontenido del trabajo y la realización de la tarea, y que",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"se presentan con la capacidad para afectar el desarrollo del trabajo y la salud del trabajador.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(15,10,"Se pueden identificar cuatro grandes grupos de riesgos psicosociales:",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(80,10,"Exigencias psicológicas del trabajo.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(30,10,"trabajar rápido, esconder sentimientos, callar",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"opiniones, tomar decisiones difíciles.",0,0,'L');



		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(95,10,"Trabajo activo y desarrollo de habilidades.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(30,10,"autonomía, aplicar habilidades,",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"decidir pausas o descansos.",0,0,'L');



		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(115,10,"Apoyo social en la empresa y calidad de liderazgo.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(30,10,"no trabajar aislado,",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"tareas bien definidas, apoyo de superiores o compañeros.",0,0,'L');



		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(140,10,"Inseguridad en el empleo y escasas compensaciones en el trabajo.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(30,10,"reconocimiento,",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"apoyo adecuado, trato justo.",0,0,'L');



		$pdf->Ln(15);

		$pdf->Cell(0,10,"Evaluar riesgos implica identificar y medir las exposiciones laborales a factores de riesgo,",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"que aumentan la probabilidad de que aparezcan efectos nocivos entre las personas expuestas.",0,0,'L');



		$pdf->AddPage();

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(0,10,"2.- INSTRUMENTO DE MEDICIÓN UTILIZADO*",0,0,'L'); 

		$pdf->SetFont('Times','',14);

		$pdf->Ln(15);

		$pdf->Cell(0,10,"FPSICO.- Método de ER Psicosociales elaborado por el Instituto Nacional de Seguridad",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"e Higiene del Trabajo de España(INSHT) que permite obtener una evaluación nueve",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"factores. Se obtiene evaluaciones grupales de trabajadores en situaciones relativamente",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"homogéneas. La presentaciónde resultados se ofrece en 2 formatos diferentes: Perfil",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"Valorativo ".chr(40)."valora si el nivel de medida de las puntuaciones del colectivo analizado",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"en cada uno de los factores se encuentra o no en nivel de riesgo adecuado".chr(41)." y Perfil",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"Descriptivo ".chr(40)."porcentaje de elección de cada opción de respuesta, para cada factor, con",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"todos sus ítems".chr(41).". El tiempo estimado para su realización es de 35-40 minutos aprox.",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(0,10,"FACTORES EVALUADOS:",0,0,'L');

		$pdf->Ln(15);

		$pdf->Cell(60,10,"TIEMPO DE TRABAJO.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," Bajo este factor se acogen aspectos de las condiciones",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"de trabajo referentes a la capacidad y posibilidad individual del trabajador para",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"gestionar y tomar decisiones tanto sobre aspectos de la estructuración temporal de la",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"actividad laboral como sobre cuestiones de procedimiento y organización del trabajo. El",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"método recoge estos aspectos sobre lo que se proyecta la autonomía en dos grandes bloques: ",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"AUTONOMÍA TEMPORAL.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10,"Se refiere a la discreción concedida al trabajador sobre la",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"gestión de algunos aspectos de la organización temporal de la carga de trabajo y de los ",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"descansos, tales como la elección del ritmo, las posibilidades de alterarlo si fuera necesario, su",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"capacidad para distribuir descansos durante la jornada y de disfrutar de tiempo libre para",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"atender a cuestiones personales. ",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"AUTONOMÍA DECISIONAL.- ",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," Hace referencia a la capacidad de un trabajador para influir",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"en el desarrollo cotidiano de su trabajo, que se manifiesta en la posibilidad de tomar ",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"decisiones sobre las tareas a realizar, su distribución, la elección de procedimientos y métodos.",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(55,10,"CARGA DE TRABAJO.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," Por carga de trabajo se entiende en nivel de demanda de trabajo",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"a la que el trabajador ha de hacer frente, es decir, el grado de movilización requerido para",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"resolver lo que exige la actividad laboral, con independencia de la naturaleza de la carga",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"de trabajo(cognitiva, emocional). Se entiende que la carga de trabajo es elevada cuando hay",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10," mucha carga (componente cuantitativo) y es difícil (componente cualitativo).",0,0,'L');



		$pdf->AddPage();

		$pdf->Ln(10);



		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"DEMANDAS PSICOLOGICAS.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," Las demandas psicológicas se refieren a la",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"naturaleza de las distintas exigencias a las que se ha de hacer frente en el trabajo. ",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"Tales demandas suelen ser de naturaleza cognitiva y de naturaleza emocional.",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(82,10,"PARTICIPACION/SUPERVISION.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," Este factor recoge dos formas de las posibles",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"dimensiones del control sobre el trabajo; el que ejerce el trabajador a través de su",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"participación en diferentes aspectos del trabajo y el que ejerce la organización sobre",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"el trabajador a través de la supervisión de sus quehaceres.",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(122,10,"INTERES POR EL TRABAJADOR/COMPENSACION.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," El interés por el trabajador",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"hace referencia al grado en que la empresa muestra una preocupación de carácter personal",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10," y a largo plazo por el trabajador. Estas cuestiones se manifiestan en la preocupación",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"de la organización por la promoción, formación, desarrollo de carrera de sus trabajadores, ",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"por mantener informados a los trabajadores sobre tales cuestiones así como por la percepción",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"tanto de seguridad en el empleo como de la existencia de un equilibrio entre lo que el",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"trabajador aporta y la compensación que por ello obtiene.",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(57,10,"DESEMPEÑO DE ROL.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," Este factor considera los problemas que pueden derivarse de",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"de los cometidos de cada puesto de trabajo. Comprende dos aspectos fundamentales:",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(47,10,"La claridad del rol.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10,"Esta tiene que ver con la definición de funciones y responsabilidades",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"".chr(40)."qué debe hacerse, cómo, cantidad de trabajo esperada, calidad de trabajo, tiempo asignado",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10," y responsabilidad del puesto.".chr(41)." ",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(45,10,"El conflicto del rol.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10,"Hace referencia a las demandas incongruentes, incompatibles o",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"contradictorias entre sí o que pudieran suponer un conflicto de carácter ético para",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"el trabajador.",0,0,'L');



		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(82,10,"RELACIONES Y APOYO SOCIAL.-",0,0,'L');

		$pdf->SetFont('Times','',14);

		$pdf->Cell(0,10," El factor relaciones y apoyo social se refiere a",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"aquellos aspectos de las condiciones de trabajo que se derivan de las relaciones que",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"se establecen entre las personas en los entornos de trabajo. Recoge este factor el concepto",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"de 'apoyo social', entendido como factor moderador del estrés, y que el método concreta",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"estudiando la posibilidad de contar con apoyo instrumental o ayuda proveniente de otras",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"personas del entorno de trabajo (jefes, compañeros,...) para poder realizar adecuadamente",0,0,'L');

		$pdf->Ln(5);

		$pdf->Cell(0,10,"el trabajo, y por la calidad de tales relaciones.",0,0,'L');



		$pdf->AddPage();

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(0,10,"ESCALA DE INTERPRETACIÓN DE LA PRESENCIA DE RIESGO",0,0,'L'); 

		$pdf->SetFont('Times','B',10);

		$pdf->Ln(10);

		$pdf->Cell(150,10,"CODIFICACIÓN DE COLORES SEGÚN INTESIDAD DE RIESGO PSICOSOCIAL:",1,0,'L');

		$pdf->Ln(25);

		$pdf->SetFont('Times','B',14);

		$pdf->SetFillColor(250,0,0);

		$pdf->Cell(100,10,"Muy elevado",1,0,'L',true);

		$pdf->Cell(25,10,"85%",1,0,'L',true);

		$pdf->Cell(25,10,"o más",1,0,'L',true);

		$pdf->Ln(10);

		$pdf->SetFillColor(250,95,0);

		$pdf->Cell(100,10,"Elevado",1,0,'L',true);

		$pdf->Cell(25,10,"75%",1,0,'L',true);

		$pdf->Cell(25,10,"84,99%",1,0,'L',true);

		$pdf->Ln(10);

		$pdf->SetFillColor(250,250,0);

		$pdf->Cell(100,10,"Moderado",1,0,'L',true);

		$pdf->Cell(25,10,"65%",1,0,'L',true);

		$pdf->Cell(25,10,"74.99%",1,0,'L',true);

		$pdf->Ln(10);

		$pdf->SetFillColor(0,250,0);

		$pdf->Cell(100,10,"Situación adecuada",1,0,'L',true);

		$pdf->Cell(25,10,"0%",1,0,'L',true);

		$pdf->Cell(25,10,"64.99%",1,0,'L',true);

	}



	function plan_de_accion_xls(){

		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'plan_de_accion'.DS.$nemp;

		$ea = new PHPExcel();

		$ea->getProperties()->setCreator('Alto Desempeño');

		$ea->getProperties()->setTitle('Plan de Acción');

		$ea->getProperties()->setLastModifiedBy('Alto Desempeño');

		$ea->getProperties()->setDescription('Plan de Acción');

		$ea->getProperties()->setSubject('General');

		$ea->getProperties()->setKeywords('plan de accion aldesis saegth');

		$ea->getProperties()->setCategory('-');

		$ews = $ea->getSheet(0);

		$ews->setTitle('Resumen general');

		$ews->setCellValue('a1', 'PLAN DE ACCIÓN');

		$style = array('font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$style2 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$ews->mergeCells('a1:i1');

		$ews->getStyle('a1')->applyFromArray($style);

		$ews->getColumnDimension('a')->setAutoSize(true);



		$ews->setCellValue('a3', 'Nombre');

		$ews->setCellValue('b3', 'Cargo');

		$ews->setCellValue('c3', 'Departamento');

		$ews->setCellValue('d3', 'Genente');

		$ews->setCellValue('e3', 'Item a desarrollar');

		$ews->setCellValue('f3', 'Acción');

		$ews->setCellValue('g3', 'Tipo');

		$ews->setCellValue('h3', 'Medicion');

		$ews->setCellValue('i3', 'Fecha de cumplimiento');

		

		$ews->getStyle('a3:i3')->applyFromArray($style2);



		$query='SELECT lp.nombre, lp.cargo, lp.area, lp.pid_nombre, mo.cod_pregunta, mo.accion, mo.tipo, mo.medicion, me.fecha FROM multifuente_oportunidades mo JOIN multifuente_evaluado me ON mo.cod_evaluado=me.cod_evaluado join listado_personal_op lp ON me.id_personal=lp.id WHERE me.id_empresa='.$_SESSION['USER-AD']['id_empresa'].'';

		$result=$this->Pdf->query_($query);



		$indice=5;



		foreach ($result as $key => $value) {

			$ews->setCellValue('a'.$indice, $this->Pdf->htmlprnt_win($value['nombre']));

			$ews->setCellValue('b'.$indice, $this->Pdf->htmlprnt_win($value['cargo']));

			$ews->setCellValue('c'.$indice, $this->Pdf->htmlprnt_win($value['area']));

			$ews->setCellValue('d'.$indice, $this->Pdf->htmlprnt_win($value['pid_nombre']));

			$ews->setCellValue('e'.$indice, $this->Pdf->get_preg($value['cod_pregunta']));

			$ews->setCellValue('f'.$indice, $this->Pdf->htmlprnt_win($value['accion']));

			$ews->setCellValue('g'.$indice, $this->Pdf->htmlprnt_win($value['tipo']));

			$ews->setCellValue('h'.$indice, $this->Pdf->htmlprnt_win($value['medicion']));

			$ews->setCellValue('j'.$indice, $this->Pdf->print_fecha($value['fecha']));

			$indice++;

		}



		$nombre = $nemp.date('d-m-Y');

		self::makeDir($this->dir);

		$ea->setActiveSheetIndex(0);

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');      

		ob_end_clean();  

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		$writer->save('php://output');

		exit();

	}





	function scorecard($id){

		Util::sessionStart();

		$this->dir=$this->location.'scorecard';



		$lpo = new Listado_personal_op();

		$lpo->select($id);



		$pdf = new pdf_scorecard();

		$pdf->setDatos($lpo);

		self::paginas_inicio_scorecard($id,$pdf,$lpo);



		$scorecard = new Scorecard();



		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "", $nemp);



		$nombre = $this->Pdf->get_pname($id);

		$nombre = str_replace(" ", "", $nombre);



		$scorecard->select($_SESSION['USER-AD']['id_empresa']);

		$sdetalle = $scorecard->getDetalle_();

		$speriodo = $scorecard->getPeriodo();



		self::makeDir($this->dir);

		self::makeDir($this->dir.DS.$nemp);



		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(0,10,"PLANTILLA DE OBJETIVOS",0,0,'C');

		$pdf->Ln(20);

		$pdf->Cell(8,10,"#",1,0,'C');

		$pdf->Cell(70,10,"Objetivo",1,0,'C');

		$pdf->Cell(70,10,"Indicador",1,0,'C');

		$pdf->Cell(20,10,"Inverso",1,0,'C');

		$pdf->Cell(20,10,"Und.",1,0,'C');

		$pdf->Ln(10);



		$pdf->SetFont('Times','',11);

		$so = new scorer_objetivo();

		$so->setPeriodo($speriodo);

		$objetivos = $so->select_all($id);

		$pdf->SetWidths(array(8,70,70,20,20));

		$pdf->SetAligns(array("C","L","L","C","C"));

		foreach ($objetivos as $key => $value) {

			$so->cast($value);

			$data = array(

				$key+1,

				$so->getObjetivo_(), 

				$so->getIndicador_(),

				$so->getInverso(),

				$so->getUnidad()

				);

			$pdf->Row($data,8);

		}

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(0,10,"PLANTILLA DE OBJETIVOS",0,0,'C');

		$pdf->Ln(20);

		$pdf->Cell(8,10,"#",1,0,'C');

		$widths=$aligns=array();

		array_push($widths, 8);

		array_push($aligns, "C");

		$pdf->Cell(70,10,"Objetivos",1,0,'C');

		array_push($widths, 70);

		array_push($aligns, "L");

		if($sdetalle->col==1){

			$pdf->Cell(12,10,"Meta",1,0,'C');

			array_push($widths, 12);

			array_push($aligns, "C");

		}else {

			for ($i=0; $i < $sdetalle->col; $i++) { 

				$pdf->Cell(12,10,$sdetalle->vinicial + ($sdetalle->razon*$i),1,0,'C');

				array_push($widths, 12);

				array_push($aligns, "C");

			}

		}

		$pdf->Cell(25,10,"Peso %",1,0,'C');

		$pdf->Cell(25,10,"Logro real",1,0,'C');

		$pdf->Cell(25,10,"Ponderado %",1,0,'C');

		$pdf->Cell(25,10,"Puntaje %",1,0,'C');

		$pdf->SetFont('Times','',11);

		array_push($widths, 25);

		array_push($widths, 25);

		array_push($widths, 25);

		array_push($widths, 25);

		array_push($aligns, "C");

		array_push($aligns, "C");

		array_push($aligns, "C");

		array_push($aligns, "C");

		$pdf->Ln(10);

		$pdf->SetWidths($widths);

		$pdf->SetAligns($aligns);

		$ppond_array=array();

		foreach ($objetivos as $key => $value) {

			$so->cast($value);

			$obj_metas = $so->getMeta_();

			$data = array($key+1);

			array_push($data, $so->getObjetivo_());

			foreach ($obj_metas as $key_ => $value_) {

				array_push($data, $value_);

			}

			array_push($data, $so->getPeso());

			array_push($data, $so->getLreal());

			array_push($data, number_format($so->getLpond(),2,"."," "));

			array_push($data, number_format($so->getPpond(),2,"."," "));

			array_push($ppond_array, $so->getPpond());

			$pdf->Row($data,8);

		}

		$pdf->Ln(0);

		$www=8+70+(12*$sdetalle->col)+25-10;

		$pdf->setX($www);

		$pdf->Cell(70,10,"Total puntaje ponderado",1,0,'C');

		$pdf->Cell(25,10,number_format(array_sum($ppond_array),2,"."," "),1,0,'C');

		$ajuste = $so->get_ajuste($id);

		$pdf->Ln(10);

		$pdf->setX($www);

		$pdf->Cell(70,10,"Factor de ajuste",1,0,'C');

		$pdf->Cell(25,10,$ajuste,1,0,'C');

		$ajuste = $ajuste/100 + 1;

		$pdf->Ln(10);

		$pdf->setX($www);

		$pdf->Cell(70,10,"Total puntaje ponderado ajustado",1,0,'C');

		$pdf->Cell(25,10,number_format(array_sum($ppond_array)*$ajuste,2,"."," "),1,0,'C');

		$pdf->Ln(10);

		$pdf->setX($www);

		$pdf->Cell(70,10,"Puntaje Scorecard",1,0,'C');

		$pdf->Cell(25,10,$scorecard->scorer_rango($sdetalle,intval(array_sum($ppond_array)*$ajuste)),1,0,'C');

		//REVISION

		$emp = Scorer_reval::withID($id,0,0,$speriodo);

		$eval = Scorer_reval::withID($id,1,0,$speriodo);

		$emp = $emp->selectAll();

		$eval = $eval->selectAll();

		$pdf->AddPage();

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',18);

		$pdf->Cell(0,10,"COMENTARIOS DE REVISIÓN",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"COMENTARIOS DEL EMPLEADO:",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		if($emp){

			foreach ($emp as $key => $value) {

				$pdf->Cell(5,5, $key+1 .".-   ",0,0,'L');

				$pdf->MultiCell(190,5,$scorecard->htmlprnt_win($value['comentario']),0,'L');

			}

		}else{

			$pdf->Cell(190,5,"No hay comentarios",0,0,'L');

		}

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"COMENTARIOS DEL EVALUADOR:",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		if($eval){

			foreach ($eval as $key => $value) {

				$pdf->Cell(5,5, $key+1 .".-   ",0,0,'L');

				$pdf->MultiCell(190,5,$scorecard->htmlprnt_win($value['comentario']),0,'L');

			}

		}else{

			$pdf->Cell(190,5,"No hay comentarios",0,0,'L');

		}

		//EVALUACION

		$emp = Scorer_reval::withID($id,0,1,$speriodo);

		$eval = Scorer_reval::withID($id,1,1,$speriodo);

		$emp = $emp->selectAll();

		$eval = $eval->selectAll();

		$pdf->AddPage();

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',18);

		$pdf->Cell(0,10,"COMENTARIOS DE EVALUACIÓN",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"COMENTARIOS DEL EMPLEADO:",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		if($emp){

			foreach ($emp as $key => $value) {

				$pdf->Cell(5,5, $key+1 .".-   ",0,0,'L');

				$pdf->MultiCell(190,5,$scorecard->htmlprnt_win($value['comentario']),0,'L');

			}

		}else{

			$pdf->Cell(190,5,"No hay comentarios",0,0,'L');

		}

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"COMENTARIOS DEL EVALUADOR:",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		if($eval){

			foreach ($eval as $key => $value) {

				$pdf->Cell(5,5, $key+1 .".-   ",0,0,'L');

				$pdf->MultiCell(190,5,$scorecard->htmlprnt_win($value['comentario']),0,'L');

			}

		}else{

			$pdf->Cell(190,5,"No hay comentarios",0,0,'L');

		}



		//TRIPLE COMENTARIO

		$qh = new que_hacer();

		$qh->setId_personal($id);

		$qh_all1 = $qh->select_all(1);

		$qh_all2 = $qh->select_all(2);

		$qh_all3 = $qh->select_all(3);

		$pdf->AddPage();

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',18);

		$pdf->Cell(0,10,"COMENTARIOS ADICIONALES",0,0,'C');

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"COMENTARIOS \"DEJAR DE HACER\":",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		if($qh_all1){

			foreach ($qh_all1 as $key => $value) {

				$pdf->Cell(5,5, $key+1 .".-   ",0,0,'L');

				$pdf->MultiCell(190,5,$scorecard->htmlprnt_win($value['comentario']),0,'L');

			}

		}else{

			$pdf->Cell(190,5,"No hay comentarios",0,0,'L');

		}

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"COMENTARIOS \"SEGUIR HACIENDO\":",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		if($qh_all2){

			foreach ($qh_all2 as $key => $value) {

				$pdf->Cell(5,5, $key+1 .".-   ",0,0,'L');

				$pdf->MultiCell(190,5,$scorecard->htmlprnt_win($value['comentario']),0,'L');

			}

		}else{

			$pdf->Cell(190,5,"No hay comentarios",0,0,'L');

		}

		$pdf->Ln(15);

		$pdf->SetFont('Times','B',14);

		$pdf->Cell(70,10,"COMENTARIOS \"INICIAR A HACER\":",0,0,'L');

		$pdf->Ln(10);

		$pdf->SetFont('Times','',12);

		if($qh_all3){

			foreach ($qh_all3 as $key => $value) {

				$pdf->Cell(5,5, $key+1 .".-   ",0,0,'L');

				$pdf->MultiCell(190,5,$scorecard->htmlprnt_win($value['comentario']),0,'L');

			}

		}else{

			$pdf->Cell(190,5,"No hay comentarios",0,0,'L');

		}





		$pdf->AddPage();

		$pdf->Ln(10);

		$pdf->SetFont('Times','B',12);

		$pdf->Cell(0,10,"FIRMAS DE SEGUIMIENTO Y FORMALIZACIÓN DEL PROCESO.",0,0,'C');

		$pdf->Ln(40);

		$pdf->Cell(80,5,"Empleado",0,0,'L');

		$pdf->Cell(80,5,"_________________________________",0,0,'C');

		$pdf->Ln(15);

		$pdf->Cell(0,5,"Estoy de acuerdo con la Calificación de Desempeño expresada en \"Puntaje Scorecard\"",0,0,'L');

		$pdf->Ln(10);

		$pdf->Cell(155,5,"Sí ____ No ____",0,0,'R');

		$pdf->Ln(20);

		$pdf->Cell(80,5,"Supervisor Directo",0,0,'L');

		$pdf->Cell(80,5,"_________________________________",0,0,'C');

		$pdf->Ln(40);

		$pdf->Cell(80,5,"Supervisor Indirecto",0,0,'L');

		$pdf->Cell(80,5,"_________________________________",0,0,'C');

		$pdf->Ln(40);

		$pdf->Cell(80,5,"Recibido RH",0,0,'L');

		$pdf->Cell(80,5,"_________________________________",0,0,'C');

		$pdf->Ln(40);





		$pdf->Output($this->dir.DS.$nemp.DS.$nombre.'.pdf', "F" ); 

		$pdf->Output($nombre.'.pdf','D');

	}



	function paginas_inicio_scorecard($id,$pdf,$lpo){

		Util::sessionStart();

		

		$ea = new empresa_area();

		$area_path = $ea->getADS($lpo->id_area);

		$area_path = explode("***", $area_path['path']);





		$pdf->AliasNbPages();

		$empresaCab =$this->Pdf->htmlprnt_win($_SESSION['Empresa']['nombre']);



		//Hoja Presentacion

		$pdf->AddPage();

		$pdf->SetFont('Times','B',12); 

		$pdf->Ln(12);

		$pdf->Image(BASEURL.'public/img/scorecard.jpg',35,40,142,44);

		$pdf->Ln(15);

		$pdf->Cell(30,10,"",0,0,'C');

		$pdf->Ln(70);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"PERSONA:",0,0,'L');

		$pdf->Cell(100,10,$lpo->getNombre_(),0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"EMPRESA:",0,0,'L');

		$pdf->Cell(100,10, 	"$empresaCab",0,0,'L');

		foreach ($area_path as $key => $value) {

			switch ($key) {

				case 0:

				$part = "ÁREA:";

				break;

				case 1:

				$part = "DPTO.:";

				break;

				case 2:

				$part = "SECCIÓN:";

				break;

			}

			$pdf->Ln(20);

			$pdf->Cell(30,10,"",0,0,'L');

			$pdf->Cell(30,10,"$part",0,0,'L');

			$pdf->Cell(100,10,$ea->htmlprnt_win($value),0,0,'L');

		}

		$pdf->Ln(20);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"CARGO:",0,0,'L');

		$pdf->Cell(100,10,$lpo->getCargo_(),0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"LOCALIDAD:",0,0,'L');

		$pdf->Cell(100,10,$lpo->getLocal_(),0,0,'L');

		$pdf->Ln(20);

		$pdf->Cell(30,10,"",0,0,'L');

		$pdf->Cell(30,10,"SUPERIOR:",0,0,'L');

		$pdf->Cell(100,10,$lpo->getPid_nombre_(),0,0,'L');

	}



	function descarga(){

		Util::sessionStart();

		$this->location=ROOT.DS.'public'.DS.'files'.DS;

		// self::makeDir($this->location);

		// self::makeDir($this->dir.DS."resumen");

		$nemp = $_SESSION['Empresa']['nombre'];

		$nemp = str_replace(" ", "_", $nemp);

		$this->dir=$this->location.'resumen';

		// self::makeDir($this->dir);

		// self::makeDir($this->dir.DS.$nemp);

		ob_start();

		$ea = new PHPExcel();

		$ea->getProperties()

		->setCreator('Alto Desempeño')

		->setTitle('Respaldo de datos - SAEGTH')

		->setLastModifiedBy('Alto Desempeño')

		->setDescription('Respaldo de datos')

		->setSubject('resumen')

		->setKeywords('scorecard, compass 360, riesgo, clima laboral, aldesis, saegth')

		->setCategory('-');

		$s1 = array(

			'font' => array('bold' => true, 'size' => 16,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),);

		$s2 = array('font' => array('bold' => false, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

		$s3 = array('font' => array('bold' => true, 'size' => 12,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

		$style = array($s1,$s2,$s3);



		// PAGE 1

		$ews = $ea->getSheet(0);

		$ews->setTitle('Datos personales');

		$ews->setCellValue('a1', 'INFORMACION SAEGTH');

		$ews->getStyle('a1')->applyFromArray($style[0]);

		$ews->setCellValue('a3', 'DATOS ORGANIZACIONALES - PERSONALES');

		$ews->getStyle('a3')->applyFromArray($style[0]);

		$ews->mergeCells('a3:b3');



		$ews->setCellValue('a5', 'IDENTIFICACIÓN');

		$ews->mergeCells('a5:b5');

		$ews->setCellValue('c5', 'ORGANIZACIÓN');

		$ews->mergeCells('C5:O5');

		$ews->setCellValue('P5', 'DOMICILIO - CONTACTO');

		$ews->mergeCells('P5:X5');

		// $ews->setCellValue('V5', 'DATOS PERSONALES - FAMILIARES');

		// $ews->mergeCells('V5:AC5');

		$ews->getStyle('A5:X5')->applyFromArray($style[2]);



		$ews->setCellValue('A6', 'NOMBRE');

		$ews->setCellValue('B6', 'CÉDULA');

		$ews->setCellValue('C6', 'ÁREA');

		$ews->setCellValue('D6', 'DEPARTAMENTO');

		$ews->setCellValue('E6', 'SECCIÓN');

		$ews->setCellValue('F6', 'CARGO');

		$ews->setCellValue('G6', 'GRADO SALARIAL');

		$ews->setCellValue('H6', 'CARGO A QUIEN REPORTA');

		$ews->setCellValue('I6', 'SUPERIOR CARGO');

		$ews->setCellValue('J6', 'SUPERIOR JEFE');

		$ews->setCellValue('K6','TIPO DE CONTRATO');

		$ews->setCellValue('L6','FECHA DE INGRESO');

		$ews->setCellValue('M6','PAÍS');

		$ews->setCellValue('N6','CUIDAD');

		$ews->setCellValue('O6','LOCAL');

		$ews->setCellValue('P6','SECTOR');

		$ews->setCellValue('Q6','CALLES');

		$ews->setCellValue('R6','MANZANA');

		$ews->setCellValue('S6','NÚMERO DE CASA');

		$ews->setCellValue('T6','NOMBRE DE CONTACTO DE EMERGENCIA');

		$ews->setCellValue('U6','TELÉFONO DE CONTACTO DE EMERGENCIA');

		$ews->setCellValue('V6','TELÉFONO CONVENCIONAL');

		$ews->setCellValue('W6','TELÉFONO CELULAR');

		$ews->setCellValue('X6','FECHA DE NACIMIENTO');

		// $ews->setCellValue('Y6','ESTADO CIVIL');

		// $ews->setCellValue('Z6','NOMBRE CÓNYUGUE');

		// $ews->setCellValue('AA6','FECHA NACIMIENTO CÓNYUGUE');

		// $ews->setCellValue('AB6','FECHA DE MATRIMONIO');

		// $ews->setCellValue('AC6','HIJOS');

		$ews->getStyle('a6:x6')->applyFromArray($style[1]);



		$lp = new Listado_personal_op();

		$personal = $lp->select_all($_SESSION['Empresa']['id']);

		$index = 7;

		foreach ($personal as $key => $value) {

			$lp->cast($value);

			$ews->setCellValue('A'.$index, $lp->getNombre_());

			$ews->setCellValue('B'.$index, $lp->getCedula());

			$ews->setCellValue('C'.$index, $lp->getArea_f_());

			$ews->setCellValue('D'.$index, $lp->getDepartamento_());

			$ews->setCellValue('E'.$index, $lp->getArea_());

			$ews->setCellValue('F'.$index, $lp->getCargo_());

			$ews->setCellValue('G'.$index, $lp->getSalario());

			$ews->setCellValue('H'.$index, $lp->getPid_cargo_());

			$ews->setCellValue('I'.$index, $lp->getPid_cargo_());

			$ews->setCellValue('J'.$index, $lp->getPid_nombre_());

			$ews->setCellValue('K'.$index, $lp->getTcont_());

			$ews->setCellValue('L'.$index, $lp->getFecha_de_ingreso());

			$ews->setCellValue('M'.$index, $lp->getPais_());

			$ews->setCellValue('N'.$index, $lp->getCiudad_());

			$ews->setCellValue('O'.$index, $lp->getLocal_());

			$ews->setCellValue('P'.$index, $lp->getD_sector_());

			$ews->setCellValue('Q'.$index, $lp->getD_calles_());

			$ews->setCellValue('R'.$index, $lp->getD_manz_());

			$ews->setCellValue('S'.$index, $lp->getD_villa_());





			$ews->setCellValue('V'.$index, $lp->getNumero_convencional());

			$ews->setCellValue('W'.$index, $lp->getNumero_celular());

			$ews->setCellValue('X'.$index, $lp->getFecha_de_nacimiento());

			$index++;

		}

		foreach(range('A','X') as $columnID) {

			$ews->getColumnDimension($columnID)

			->setAutoSize(false);

			$ews->getColumnDimension($columnID)

			->setWidth(18);

		}



		// PAGE 2

		$ews2 = new PHPExcel_Worksheet($ea, 'Form. Académica');

		$ea->addSheet($ews2, 1);

		$ews2->setTitle('Form. Académica');

		$ews2->setCellValue('a1', 'INFORMACION SAEGTH');

		$ews2->getStyle('a1')->applyFromArray($style[0]);

		$ews2->setCellValue('a3', 'INFORMACIÓN CURRICULAR');

		$ews2->getStyle('a3')->applyFromArray($style[0]);



		$ews2->setCellValue('a5', 'IDENTIFICACIÓN');

		$ews2->mergeCells('a5:b5');

		$ews2->setCellValue('c5', 'FORMACIÓN ACADÉMICA');

		$ews2->mergeCells('C5:H5');

		$ews2->getStyle('A5:H5')->applyFromArray($style[2]);

		$ews2->setCellValue('A6', 'NOMBRE');

		$ews2->setCellValue('B6', 'CÉDULA');

		$ews2->setCellValue('C6', 'TÍTULO');

		$ews2->setCellValue('D6', 'ÁREA DE ESTUDIO');

		$ews2->setCellValue('E6', 'INSTITUCIÓN');

		$ews2->setCellValue('F6', 'PAÍS');

		$ews2->setCellValue('G6', 'CIUDAD');

		$ews2->setCellValue('H6', 'FECHA');



		$result = $lp->getEducacionFormal($_SESSION['Empresa']['id']);

		$index=7;

		foreach ($result as $key => $value) {

			$lp->cast($value);

			$ews2->setCellValue('A'.$index, $lp->getNombre_());

			$ews2->setCellValue('B'.$index, $lp->getCedula());

			$ews2->setCellValue('C'.$index, $lp->htmlprnt_win($lp->titulo));

			$ews2->setCellValue('D'.$index, $lp->htmlprnt_win($lp->area_estudio));

			$ews2->setCellValue('E'.$index, $lp->htmlprnt_win($lp->institucion));

			$ews2->setCellValue('F'.$index, $lp->htmlprnt_win($lp->pais));

			$ews2->setCellValue('G'.$index, $lp->htmlprnt_win($lp->ciudad));

			$ews2->setCellValue('H'.$index, $lp->htmlprnt_win($lp->fecha));

			$index++;

		}

		foreach(range('A','X') as $columnID) {

			$ews2->getColumnDimension($columnID)

			->setAutoSize(false);

			$ews2->getColumnDimension($columnID)

			->setWidth(18);

		}



		// PAGE 3

		$ews3 = new PHPExcel_Worksheet($ea, 'Cursos');

		$ea->addSheet($ews3, 2);

		$ews3->setTitle('Cursos');

		$ews3->setCellValue('a1', 'INFORMACION SAEGTH');

		$ews3->getStyle('a1')->applyFromArray($style[0]);

		$ews3->setCellValue('a3', 'INFORMACIÓN CURRICULAR');

		$ews3->getStyle('a3')->applyFromArray($style[0]);



		$ews3->setCellValue('a5', 'IDENTIFICACIÓN');

		$ews3->mergeCells('a5:b5');

		$ews3->setCellValue('c5', 'CURSOS');

		$ews3->mergeCells('C5:I5');

		$ews3->getStyle('A5:H5')->applyFromArray($style[2]);

		$ews3->setCellValue('A6', 'NOMBRE');

		$ews3->setCellValue('B6', 'CÉDULA');

		$ews3->setCellValue('C6', 'TÍTULO');

		$ews3->setCellValue('D6', 'INTERNO / EXTERNO');

		$ews3->setCellValue('E6', 'ÁREA DE ESTUDIO');

		$ews3->setCellValue('F6', 'INSTITUCIÓN');

		$ews3->setCellValue('G6', 'PAÍS');

		$ews3->setCellValue('H6', 'CIUDAD');

		$ews3->setCellValue('I6', 'FECHA');



		$result = $lp->getCursos($_SESSION['Empresa']['id']);

		$index=7;

		foreach ($result as $key => $value) {

			$lp->cast($value);

			$ews3->setCellValue('A'.$index, $lp->getNombre_());

			$ews3->setCellValue('B'.$index, $lp->getCedula());

			$ews3->setCellValue('C'.$index, $lp->htmlprnt_win($lp->titulo));

			$ews3->setCellValue('D'.$index, "E");

			$ews3->setCellValue('E'.$index, $lp->htmlprnt_win($lp->area_estudio));

			$ews3->setCellValue('F'.$index, $lp->htmlprnt_win($lp->institucion));

			$ews3->setCellValue('G'.$index, $lp->htmlprnt_win($lp->pais));

			$ews3->setCellValue('H'.$index, $lp->htmlprnt_win($lp->ciudad));

			$ews3->setCellValue('I'.$index, $lp->htmlprnt_win($lp->fecha));

			$index++;

		}

		$result = $lp->getCursosInternos($_SESSION['Empresa']['id']);

		foreach ($result as $key => $value) {

			$lp->cast($value);

			$ews3->setCellValue('A'.$index, $lp->getNombre_());

			$ews3->setCellValue('B'.$index, $lp->getCedula());

			$ews3->setCellValue('C'.$index, $lp->htmlprnt_win($lp->titulo));

			$ews3->setCellValue('D'.$index, $lp->donde);

			$ews3->setCellValue('E'.$index, $lp->htmlprnt_win($lp->area_estudio));

			$ews3->setCellValue('F'.$index, $lp->htmlprnt_win($lp->institucion));

			$ews3->setCellValue('G'.$index, $lp->htmlprnt_win($lp->pais));

			$ews3->setCellValue('H'.$index, $lp->htmlprnt_win($lp->ciudad));

			$ews3->setCellValue('I'.$index, $lp->htmlprnt_win($lp->fecha));

			$index++;

		}

		foreach(range('A','I') as $columnID) {

			$ews3->getColumnDimension($columnID)

			->setAutoSize(false);

			$ews3->getColumnDimension($columnID)

			->setWidth(18);

		}





		// PAGE 4

		$ews4 = new PHPExcel_Worksheet($ea, 'Historia laboral');

		$ea->addSheet($ews4, 3);

		$ews4->setTitle('Historia laboral');

		$ews4->setCellValue('a1', 'INFORMACION SAEGTH');

		$ews4->getStyle('a1')->applyFromArray($style[0]);

		$ews4->setCellValue('a3', 'INFORMACIÓN CURRICULAR');

		$ews4->getStyle('a3')->applyFromArray($style[0]);



		$ews4->setCellValue('a5', 'IDENTIFICACIÓN');

		$ews4->mergeCells('a5:b5');

		$ews4->setCellValue('c5', 'HISTORIA LABORAL');

		$ews4->mergeCells('C5:F5');

		$ews4->getStyle('A5:H5')->applyFromArray($style[2]);

		$ews4->setCellValue('A6', 'NOMBRE');

		$ews4->setCellValue('B6', 'CÉDULA');

		$ews4->setCellValue('C6', 'CARGO');

		$ews4->setCellValue('D6', 'EMPRESA');

		$ews4->setCellValue('E6', 'FECHA INICIO');

		$ews4->setCellValue('F6', 'FECHA FIN');



		$result = $lp->getHlaboral($_SESSION['Empresa']['id']);

		$index=7;

		foreach ($result as $key => $value) {

			$lp->cast($value);

			$ews4->setCellValue('A'.$index, $lp->getNombre_());

			$ews4->setCellValue('B'.$index, $lp->getCedula());

			$ews4->setCellValue('C'.$index, $lp->htmlprnt_win($lp->cargo));

			$ews4->setCellValue('D'.$index, $lp->htmlprnt_win($lp->empresa));

			$ews4->setCellValue('E'.$index, $lp->htmlprnt_win($lp->f_inicio));

			$ews4->setCellValue('F'.$index, $lp->htmlprnt_win($lp->f_fin));

			$index++;

		}

		foreach(range('A','F') as $columnID) {

			$ews4->getColumnDimension($columnID)

			->setAutoSize(false);

			$ews4->getColumnDimension($columnID)

			->setWidth(18);

		}



		// echo "PAGE 5 <br>";

		$ews5 = new PHPExcel_Worksheet($ea, 'Calif. ponder. Desemp.');

		$ea->addSheet($ews5, 4);

		$ews5->setTitle('Calif. ponder. Desemp.');

		$ews5->setCellValue('a1', 'INFORMACION SAEGTH');

		$ews5->getStyle('a1')->applyFromArray($style[0]);

		$ews5->setCellValue('a3', 'CALIFICACIÓN PONDERADA DE DESEMPEÑO:  SCORECARD-COMPASS360');

		$ews5->getStyle('a3')->applyFromArray($style[0]);



		$ews5->setCellValue('a5', 'IDENTIFICACIÓN');

		$ews5->mergeCells('a5:b5');

		// $ews5->setCellValue('c5', 'HISTORIA LABORAL');

		// $ews5->mergeCells('C5:F5');

		$ews5->getStyle('A5:B5')->applyFromArray($style[2]);

		$ews5->setCellValue('A6', 'NOMBRE');

		$ews5->setCellValue('B6', 'CÉDULA');

		$ews5->setCellValue('C6', 'SCORECARD %');

		$ews5->setCellValue('D6', 'SCORECARD');

		$ews5->setCellValue('E6', 'COMPASS');

		$ews5->setCellValue('F6', 'PONDERADO');



		$result = $_SESSION['calificacion_desemp'];

		$index=7;

		foreach ($result as $key => $value) {

			// $lp->cast($value);

			$ews5->setCellValue('A'.$index, $lp->htmlprnt_win($value['nombre']));

			$ews5->setCellValue('B'.$index, $value['cedula']);

			$ews5->setCellValue('C'.$index, $value['resultado_scorer_p']);

			$ews5->setCellValue('D'.$index, $value['resultado_scorer']);

			$ews5->setCellValue('E'.$index, $value['resultado_compass']);

			$ews5->setCellValue('F'.$index, $value['resultado_ponderado']);

			$index++;

		}

		foreach(range('A','F') as $columnID) {

			$ews5->getColumnDimension($columnID)

			->setAutoSize(false);

			$ews5->getColumnDimension($columnID)

			->setWidth(18);

		}



		// echo "PAGE 6 <br>";

		$ews6 = new PHPExcel_Worksheet($ea, 'Scorecard');

		$ea->addSheet($ews6, 5);

		$ews6->setTitle('Scorecard');

		$ews6->setCellValue('a1', 'INFORMACION SAEGTH');

		$ews6->getStyle('a1')->applyFromArray($style[0]);

		$ews6->setCellValue('a3', 'Scorecard');

		$ews6->getStyle('a3')->applyFromArray($style[0]);



		$ews6->setCellValue('a5', 'IDENTIFICACIÓN');

		$ews6->mergeCells('a5:b5');

		// $ews6->setCellValue('c5', 'HISTORIA LABORAL');

		// $ews6->mergeCells('C5:F5');

		$ews6->getStyle('A5:B5')->applyFromArray($style[2]);

		$col = 0; // A dec ascii code

		$col_index = 0;





		$scorecard = new Scorecard();

		$scorecard->get_scorer($_SESSION['Empresa']['id'],2015); // CORREGIR PERIODO

		$detalle = $scorecard->getDetalle_();

		$metas = (sizeof($detalle)) ? array("META") : $detalle ;

		$ews6->setCellValue($this->chr_($col+$col_index++).'6', 'NOMBRE');

		$ews6->setCellValue($this->chr_($col+$col_index++).'6', 'CÉDULA');

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","OBJETIVO");

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","INDICADOR");

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","INVERSO");

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","UNIDAD DE MEDIDA");

		foreach ($metas as $key => $value) {

			$ews6->setCellValue($this->chr_($col+$col_index++)."6",$value);

		}

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","PESO %");

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","LOGRO REAL");

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","LOGRO PONDERADO");

		$ews6->setCellValue($this->chr_($col+$col_index++)."6","PUNTAJE PONDERADO");





		$col_index = 0;

		$result = $lp->getScorer_objetivos($_SESSION['Empresa']['id'],2015); // CORREGIR PERIODO

		$index=7;

		$so = new Scorer_objetivo();

		foreach ($result as $key => $value) {

			$so->cast($value);

			$col_index = 0;

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $lp->htmlprnt_win($value['nombre']));

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $value['cedula']);

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getObjetivo_());

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getIndicador_());

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getInverso());

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getUnidad());

			$metas = unserialize($value['meta']);

			foreach ($metas as $key_ => $value_) {

				$ews6->setCellValue($this->chr_($col+$col_index++).$index, $value_);

			}

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getPeso());

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getLreal());

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getLpond());

			$ews6->setCellValue($this->chr_($col+$col_index++).$index, $so->getPpond());

			$index++;

		}

		foreach(range('A',$this->chr_($col+$col_index)) as $columnID) {

			$ews6->getColumnDimension($columnID)

			->setAutoSize(false);

			$ews6->getColumnDimension($columnID)

			->setWidth(18);

		}



		// echo "PAGE 7 <br>";

		$ews7 = new PHPExcel_Worksheet($ea, 'Compass resultados');

		$ea->addSheet($ews7, 6);

		$ews7->setTitle('Compass resultados');

		$ews7->setCellValue('a1', 'INFORMACION SAEGTH');

		$ews7->getStyle('a1')->applyFromArray($style[0]);

		$ews7->setCellValue('a3', 'COMPASS 360.-  Resultados por competencia');

		$ews7->getStyle('a3')->applyFromArray($style[0]);



		$col = 0; // A dec ascii code

		$index=5;

		$compass_test = $_SESSION['respaldo']['compass']['compass_test']['data'];

		foreach ($compass_test as $key => $value) {

			$col_start = $col_end = $col;

			$col_end++;

			$ews7->setCellValue($this->chr_($col).$index, $value["nombre_test"]);

			$index++;

			$ews7->setCellValue($this->chr_($col).$index, 'IDENTIFICACIÓN');

			$ews7->mergeCells($this->chr_($col_start).$index.':'.$this->chr_($col_end).$index);

			$ews7->setCellValue($this->chr_($col).($index+1), 'NOMBRE');

			$ews7->setCellValue($this->chr_($col+1).($index+1), 'CÉDULA');

			$col_start = $col_end + 1;

			$ews7->setCellValue($this->chr_($col_start).$index, 'PROMEDIO GENERAL');

			$ews7->setCellValue($this->chr_($col_start).($index+1), 'AUTO');

			$ews7->setCellValue($this->chr_($col_start+1).($index+1), 'GERENTE');

			$ews7->setCellValue($this->chr_($col_start+2).($index+1), 'PARES');

			$ews7->setCellValue($this->chr_($col_start+3).($index+1), 'SUBALTERNOS');

			$ews7->setCellValue($this->chr_($col_start+4).($index+1), 'GPS');

			$col_end+=5;

			$ews7->mergeCells($this->chr_($col_start).$index.':'.$this->chr_($col_end).$index);

			$col_start = $col_end + 1;

			$compass_temas=$value['temas']['data'];

			// var_dump($compass_temas);

			foreach ($compass_temas as $key_ => $value_) {

				$ews7->setCellValue($this->chr_($col_start).$index, $value_["tema"]);

				$ews7->setCellValue($this->chr_($col_start).($index+1), 'AUTO');

				$ews7->setCellValue($this->chr_($col_start+1).($index+1), 'GERENTE');

				$ews7->setCellValue($this->chr_($col_start+2).($index+1), 'PARES');

				$ews7->setCellValue($this->chr_($col_start+3).($index+1), 'SUBALTERNOS');

				$col_end+=4;

				$ews7->mergeCells($this->chr_($col_start).$index.':'.$this->chr_($col_end).$index);

				$col_start = $col_end + 1;



				

			}

			$ews7->getStyle($this->chr_($col).$index.':'.$this->chr_($col_end).($index+1))->applyFromArray($style[2]);

			$index+=4;

		}

		

		$nombre = $nemp.date('d-m-Y');

		$ea->setActiveSheetIndex(0);

		

		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');      

		ob_end_clean();  

		$writer->save($this->dir.DS.$nombre.".xlsx");

		header('Content-type: application/vnd.ms-excel');

		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');

		header('Cache-Control: max-age=0');

		header('Cache-Control: max-age=1');



		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); 

		header ('Cache-Control: cache, must-revalidate'); 

		header ('Pragma: public'); 

		$writer->save('php://output');

		exit();

	}



	function makeDir($path)	{

		return is_dir($path) || mkdir($path);

	}



	function chr_($val)	{

		return PHPExcel_Cell::stringFromColumnIndex($val);

	}
}