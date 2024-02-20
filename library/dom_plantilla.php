<?php

/**
 * Plantilla
 */
class Dom_Plantilla extends Dompdf
{
	public $hmt_inicio;
	public $hmt_fin;
	public $head;
	public $header;
	public $footer;
	public $body_inicio;
	public $body_fin;
	public $main;
	public $body_fin;
	public $style;
	public $html;
	public $nombreArchivo;

	function html_inicio()
	{
		$this->html += '<html>';
	}

	function head()
	{
		$this->html += '<head>
						<style>
							@page {
								margin: 0cm 0cm;
							}
							
							body {
							margin-top: 2cm;
							margin-left: 2cm;
							margin-right: 2cm;
							margin-bottom: 2cm;
							}

							header {
							position: fixed;
							top: 0cm;
							left: 0cm;
							right: 0cm;
							height: 1cm;
							color: white;
							text-align: center;
							line-height: 1.5cm;
							}

							footer {
							position: fixed;
							bottom: 0cm;
							left: 0cm;
							right: 0cm;
							height: 1.7cm;
							color: black;
							text-align: center;
							font-size: 8px;
							line-height: 2px;
							}

							.parent {
							  margin: 0;
							  padding: 0;
							  text-align: center;
							}
							.child {
							  display: inline-block;
							  padding: 1px 10px;
							  vertical-align: middle;
							}
						</style>
					</head>';
	}

	function body_inicio()
	{
		$this->html += '<body>';	
	}

	function body_fin()
	{
		$this->html += '</body>';	
	}

	function header()
	{
		$this->html += '<header>
							<img src="'.BASEURL.'public/img/header.png" alt="header" align="right" style="width:120px; height:30px; margin-right:20px;">
						</header>';
	}

	function footer()
	{
		$img = BASEURL.'public/img/header.png';
		
		$this->html += "<footer>
							<div class='parent'>
								<div class='child'><img src="C:\xampp\htdocs\aldes\public\img\header.png" alt="Girl in a jacket" style="width:120px; height:30px;"></div>
								<div class='child'><p>(C) 2010. Alto Desempeño Cia. Ltda.</p>
										<p>Dirección: Cdla. Kennedy Vieja.- Peatonal # 206 entre "G" y "H" Condominio Deparsur, 2do Piso.</p>
										<p>Teléfonos +(593 4) 228 5714 y +(593 4) 229 1645. eMail informacion@altodesempenio.com</p>
										<p>Guayaquil - Ecuador</p>
										<p>Page 1/1</p></div>
							</div>
						</footer>";
	}

	function html_fin()
	{
		$this->html += '</html>';
	}

	function setMain($lpo){
		$this->html += '<main>';
		$this->html += $lpo;
		$this->html += '</main>';
	}

	function iniciarPDF()
	{
		$this->html_inicio();
		$this->head();
		$this->body_inicio();
		$this->header();
		$this->footer();
	}

	function finPDF()
	{
		$this->body_fin();
		$this->html_fin();
	}

	function generarPDF($main)
	{
		$this->iniciarPDF();
		$this->setMain($main);
		$this->finPDF();

		$this->load_html($this->html);
		$this->render();
		$this->stream($this->nombreArchivo);
	}
}

?>