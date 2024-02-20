<?php 
Util::sessionStart();
//$evaluado_preguntas = '30ec348b'; 
$evaluado_preguntas =  $_SESSION['evaluado']['id'];

$nameCab = $_SESSION['Personal']['nombre'];
$fechaCab = $_SESSION['Persoanl']['fecha'];
//$usernameCab = 
$cargoCab = $_SESSION['Personal']['cargo'];
$departamentoCab = $_SESSION['Personal']['area'];
$empresaCab = $_SESSION['Empresa']['nombre'];

$supervisorCab = $_SESSION['Personal']['superior'];


//Hoja Presentacion
$pdf->AddPage();
$pdf->SetFont('Times','B',12); 
$pdf->Ln(12);
$pdf->Image('primera.png',45,50,112,44);
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

?>
