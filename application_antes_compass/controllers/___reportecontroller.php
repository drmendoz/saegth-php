
<?php

class ReporteController extends Controller {

	protected $link;
	protected $dir;
	protected $location;
	
	function __construct($model, $controller, $action, $type = 0) {

		parent::__construct($model, $controller, $action, $type);

		$this->link = $this->Reporte->getDBHandle();
		$this->location=ROOT.DS.'public'.DS.'files'.DS;
	}



	function respaldo(){
		$this->haySession();
		$this->set('rol',$_SESSION['USER-AD']['user_rol']);
		if (!($_SESSION['USER-AD']['user_rol']<2)) {
			$this->set('custom_warning',"No tiene el permiso par navegar esta sección ".$_SESSION['USER-AD']['user_rol']);
			$this->set('denied',true);
		}else{
			$this->set('denied',false);

			$se = new Scorer_estado();
			$this->set('count',$se->count());
		}
	}

	function calificacion_desemp($lim,$per){
		$this->haySession();
		$se = new Scorer_estado(); 
		$res = $se->select_all("LIMIT ".$lim.",10");
		$final = array();

		$scorecard = new Scorecard();
		$scorer = $scorecard->get_scorer($_SESSION['Empresa']['id'],$per);
		$fecha = $scorer['periodo'];
		$scorer = $scorer['detalle'];
		foreach ($res as $key => $value) {
			$r_scorer = $this->Reporte->get_ScorecardRes($value['id_personal'],$fecha);
			$resultado_scorer_p = number_format($r_scorer,2,"."," ").'%';  
			$r_score = $scorecard->scorer_rango($scorer,intval($r_scorer)); 
			$compass = round($this->Reporte->getAvg_test_eval($this->Reporte->get_codEval($value['id_personal'])),2); 
			$p_score = $scorer->p_score;
			$resultado_ponderado = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
			$arr = array(
				'id' => $value['id_personal'],
				'nombre' => $se->htmlprnt_win($value['nombre']),
				'cedula' => $value['cedula'],
				'resultado_scorer_p' => $resultado_scorer_p,
				'resultado_scorer' => $r_score,
				'resultado_compass' => $compass,
				'resultado_ponderado' => $resultado_ponderado
				);
			array_push($_SESSION['calificacion_desemp'], $arr);
		}
	}
/*
	function compass_test($lim,$per){
		$this->haySession();
		$se = new Scorer_estado(); 
		$res = $se->select_all("LIMIT ".$lim.",10");
		$final = array();

		$mt = new multifuente_test();
		foreach ($compass_test as $key => $value) {
			$col_start = $col_end = $col;
			$col_end++;
			$ews7->setCellValue($this->chr_($col).$index, $mt->htmlprnt_win($value["nombre_test"]));
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
			$compass_temas=$mt->getTemas($value["cod_test"]);
			foreach ($compass_temas as $key_ => $value_) {
				$ews7->setCellValue($this->chr_($col_start).$index, $mt->htmlprnt_win($value_["tema"]));
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

		$mt = new multifuente_test();
		$compass_test = $mt->getTest($_SESSION['Empresa']['id']);
		foreach ($compass_test as $key => $value) {
			$compass_temas=$mt->getTemas($value["cod_test"]);
			foreach ($compass_temas as $key_ => $value_) {
			}
		}

		$scorer = $scorecard->get_scorer($_SESSION['Empresa']['id'],$per);
		$fecha = $scorer['periodo'];
		$scorer = $scorer['detalle'];
		foreach ($res as $key => $value) {
			$r_scorer = $this->Reporte->get_ScorecardRes($value['id_personal'],$fecha);
			$resultado_scorer_p = number_format($r_scorer,2,"."," ").'%';  
			$r_score = $scorecard->scorer_rango($scorer,intval($r_scorer)); 
			$compass = round($this->Reporte->getAvg_test_eval($this->Reporte->get_codEval($value['id_personal'])),2); 
			$p_score = $scorer->p_score;
			$resultado_ponderado = ($r_score * $p_score / 100)+($compass * (100-$p_score) /100);
			$arr = array(
				'id' => $value['id_personal'],
				'nombre' => $se->htmlprnt_win($value['nombre']),
				'cedula' => $value['cedula'],
				'resultado_scorer_p' => $resultado_scorer_p,
				'resultado_scorer' => $r_score,
				'resultado_compass' => $compass,
				'resultado_ponderado' => $resultado_ponderado
				);
			array_push($_SESSION['calificacion_desemp'], $arr);
		}
	}
*/
	function descarga(){
		Util::sessionStart();
		$this->location=ROOT.DS.'public'.DS.'files'.DS;
		self::makeDir($this->location);
		self::makeDir($this->dir.DS."resumen");
		$nemp = $_SESSION['Empresa']['nombre'];
		$nemp = str_replace(" ", "_", $nemp);
		$this->dir=$this->location.'resumen';
		self::makeDir($this->dir);
		self::makeDir($this->dir.DS.$nemp);

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
/*

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
		$mt = new multifuente_test();
		$compass_test = $mt->getTest($_SESSION['Empresa']['id']);
		foreach ($compass_test as $key => $value) {
			$col_start = $col_end = $col;
			$col_end++;
			$ews7->setCellValue($this->chr_($col).$index, $mt->htmlprnt_win($value["nombre_test"]));
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
			$compass_temas=$mt->getTemas($value["cod_test"]);
			// var_dump($compass_temas);
			foreach ($compass_temas as $key_ => $value_) {
				$ews7->setCellValue($this->chr_($col_start).$index, $mt->htmlprnt_win($value_["tema"]));
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
*/
		$nombre = $nemp.date('d-m-Y');
		$ea->setActiveSheetIndex(0);
		
		$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');      
		ob_end_clean();  
		$writer->save($this->dir.DS.$nombre.".xlsx");
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="'.$nombre.'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit();
		/**/
	}



	function makeDir($path)	{
		return is_dir($path) || mkdir($path);
	}

	function chr_($val)	{
		return PHPExcel_Cell::stringFromColumnIndex($val);
	}


	function haySession(){
		Util::sessionStart();
		if (!isset($_SESSION['USER-AD'])){
			$this->logout();
			exit;	
		}
		return true;
	}


	function logout(){
		Util::sessionLogout();
		$this->Sonda->disconnect();
		$this->_template = new Template('Void','render');
		$dispatch = new InicioController('Inicio','inicio','principal',0);
		$dispatch->principal(true);
	}

}






