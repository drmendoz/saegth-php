<?php 
class pdf_scorecard extends PDF_MC_Table{

	public $datos; 

	function setDatos($lpo){
		$this->datos=$lpo;
	}  

	function Header(){
		if (($this->PageNo())!= 1){
	        //$this->Image('header.png',155,8,33);
			if ($this->CurOrientation=="L") {
				$this->Image(BASEURL.'public/img/scorecard.jpg',245,8,33);
			}else{
				$this->Image(BASEURL.'public/img/scorecard.jpg',155,8,33);
			}
			$this->SetFont('Arial','',8);
			if(isset($this->datos)){
				$this->Cell(0,10,"Nombre: ".$this->datos->getNombre_()." Cargo: ".$this->datos->getCargo_()." Fecha: ".date('Y-m-d'),0,0,'L');
				$this->Ln(10);
			}
		}
	}   
   	//Pie de página
	function Footer(){
		static $y;
		$this->SetY(-24);
		$this->Image(BASEURL.'public/img/header.png',20,277,33);
		$this->SetFont('Arial','I',6);
		$this->Cell(0,6,'(C) 2010. Alto Desempeño Cia. Ltda.',0,0,'C');
		$this->Ln(3);
		$this->Cell(0,6,'Dirección: Cdla. Kennedy Vieja.- Peatonal # 206 entre "G" y "H" Condominio Deparsur, 2do Piso.',0,0,'C');
		$this->Ln(3);
		$this->Cell(0,6,'Teléfonos +(593 4) 228 5714 y +(593 4) 229 1645. eMail informacion@altodesempenio.com',0,0,'C');
		$this->Ln(3);
		$this->Cell(20,6,'',0,0,'C');
		$this->Cell(150,6,'Guayaquil - Ecuador',0,0,'C');
		$this->Ln(3); 
	    // $this->Cell(20,6,"Page ".$this->PageNo()."/".++$y,0,0,'C');
		$this->Ln(3); 
		$this->Cell(190, 5, "Page " . $this->PageNo() . "/{nb}", 0, 1, 'R');
	}


}
?>