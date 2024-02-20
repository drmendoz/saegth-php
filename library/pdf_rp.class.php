<?php 
class pdf_rp extends PDF_MC_Table{

	function Header(){

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
		// $this->Ln(3); 
		// $this->Cell(20,6,"Page ".$this->PageNo()."/".++$y,0,0,'C');
		$this->Ln(3); 
		$this->Cell(180, 6, "Page " . $this->PageNo() . "/{nb}", 0, 0,"R");
	}
}
?>