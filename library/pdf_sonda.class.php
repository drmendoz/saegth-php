<?php 
class pdf_sonda extends PDF_MC_Table{

	function Header(){
  		if (($this->PageNo())!= 1){
	        //$this->Image('header.png',155,8,33);
	        $this->Image(BASEURL.'public/img/Sonda.png',155,8,33);
	      	$this->SetFont('Arial','B',12);
	      //$this->Cell(30,10,'Title',1,0,'C');
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
	    $this->Cell(0, 5, "Page " . $this->PageNo() . "/{totalPages}", 0, 1);
    }


}
?>