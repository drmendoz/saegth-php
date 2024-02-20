<?php

class DomPdfController extends Controller {

	protected $link;
	protected $grafica;
	protected $location;
	protected $dir;

	function __construct($model, $controller, $action, $type = 0) {
		parent::__construct($model, $controller, $action, $type);
		$this->link = $this->Dompdf->getDBHandle();
		$this->location=ROOT.DS.'public'.DS.'files'.DS;
	}

	function estatus_proceso_pdf($filtro)
	{
		Util::sessionStart();

		$dompdf = new Dom_Plantilla();

		$main = '';

		$dompdf->generarPDF($main);
	}
}

?>