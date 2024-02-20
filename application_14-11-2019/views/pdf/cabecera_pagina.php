<?php
Util::sessionStart();
/**
 * @author Jorge Buestan
 * @copyright 2012
 */
//$evaluado_preguntas = '30ec348b'; 
$evaluado_preguntas =  $_SESSION['evaluado']['id'];

$nameCab = $_SESSION['Personal']['nombre'];
$fechaCab = $_SESSION['Persoanl']['fecha'];
//$usernameCab = 
$cargoCab = $_SESSION['Personal']['cargo'];
$departamentoCab = $_SESSION['Personal']['area'];
$empresaCab = $_SESSION['Empresa']['nombre'];

$supervisorCab = $_SESSION['Personal']['superior'];

$supervisorCab    = substr($supervisorCab,0,40);
$nameCab          = substr($nameCab,0,40);
$empresaCab       = substr($empresaCab,0,40);
$departamentoCab  = substr($departamentoCab,0,40);


$pdf->SetFont('Times','B',12);
//$pdf->Image('retroalimentacion.png',10,20,33);
//$pdf->Image('primera.png',10,20,33);
$pdf->SetX(80); 
$pdf->Cell(150,10,"REPORTE DE RESULTADOS ",0,0,'L');
$pdf->Ln(12);
$pdf->SetFont('Times','B',6);
$pdf->Cell(60,10,"PERSONA: $nameCab",1,0,'L');
$pdf->Cell(60,10,"CARGO: $cargoCab",1,0,'L');
$pdf->Cell(70,10,"SUPERVISOR DIRECTO: $supervisorCab",1,0,'L');
$pdf->Ln(10);
$pdf->Cell(60,10,"EMPRESA: $empresaCab",1,0,'L');
$pdf->Cell(60,10,"DEPARTAMENTO: $departamentoCab",1,0,'L');
$pdf->Cell(70,10,"FECHA DE EVALUACION: $fechaCab",1,0,'L');
$pdf->Ln(20);
?>