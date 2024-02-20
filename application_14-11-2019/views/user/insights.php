<?php $meth = new User(); ?>
<script type="text/javascript">

$( document ).ready(function() {
    $('input#aceptar').click(function(){
        console.log(valInsight(getErrorLog()));
        console.log(getErrorLog());
        if(!valInsight(getErrorLog())){
          event.preventDefault();
        }
    });
});


function valInsight(bool){
  for (i = 1; i < bool.length; i++) {
    if(!bool[i])
      return false;
  }
  return true;
}
function getErrorLog(){
  $('#i_error_log').empty();
            
        var error_log = "<ul>";
        var bool = [];
        var all = $('input:radio').size();
        var group = ((all / 7) / 4) - 1;
        for (var i = 1; i <= group; i++) {
            var el1 = $('input[name="'+i+'_1"]:checked').val();
            var el2 = $('input[name="'+i+'_2"]:checked').val();
            var el3 = $('input[name="'+i+'_3"]:checked').val();
            var el4 = $('input[name="'+i+'_4"]:checked').val();
            if((el1 == el2) || (el1 == el3) || (el1 == el4) || (el2 == el3) || (el2 == el4) || (el3 == el4)){
              error_log += "<li>Valores repetidos en el bloque: "+i+"</li>";
              bool[i]=false;
            }else if ((el1 != el2) && (el1 != el3) && (el1 != el4) && (el2 != el3) && (el2 != el4) && (el3 != el4) ){
              if( (((el1 == 'P') && (el2 != 'P') && (el3 != 'P') &&(el4 != 'P')) || ((el1 != 'P') && (el2 == 'P') && (el3 != 'P') &&(el4 != 'P')) || ((el1 != 'P') && (el2 != 'P') && (el3 == 'P') &&(el4 != 'P') )|| ((el1 != 'P') && (el2 != 'P') && (el3 != 'P') &&(el4 == 'P'))) && (((el1 == 'M') && (el2 != 'M') && (el3 != 'M') &&(el4 != 'M')) || ((el1 != 'M') && (el2 == 'M') && (el3 != 'M') &&(el4 != 'M')) || ((el1 != 'M') && (el2 != 'M') && (el3 == 'M') &&(el4 != 'M') )|| ((el1 != 'M') && (el2 != 'M') && (el3 != 'M') &&(el4 == 'M'))) ){
                      bool[i]=true;              
              }else{
                bool[i]=false;
                //console.log(el1+"->"+el2+"->"+el3+"->"+el4);
                error_log += "<li>Debe haber por lo menos 1 valor de P y de M en el bloque: "+i+"</li>";
              }             
            }

        };

        error_log += "</ul>";
        $('#i_error_log').append(error_log);  
        return bool;
}
</script>
<form name="form1" method="post" action="<?php echo BASEURL.'user/insights' ?>" >
	<input type="hidden" name="user" value="<?php echo $user; ?>" id="user" />
	<input type="hidden" name="pass" value="<?php echo $pass; ?>" id="pass" />
    <div class="row" align="center">
    	<div class="row form-group">
          <div class="col-md-6" align="center"><img src="<?php echo IMGURL ?>/insigths.jpg" width="446" height="99" alt="Insights Discovery" /></div>
          <div class="col-md-6" align="center"><p>&nbsp;</p><h1>Evaluador de Preferencias</h1></div>
      </div>
    	<div class="row form-group col-md-12">
            <div class="col-md-6" align="justify" valign="top">
            	<h3 class="form-group"><strong>Introduccion</strong></h3>
              	<p>El evaluador constituye la base de su informe insight Discovery. No se
                trata de un examen que pueda aprobar o reprobar. Simplemente permite
                registrar la percepcion de sus preferencias laborales.</p>
    			<h3 class="form-group"><strong>Instrucciones</strong></h3>
    			<p>Busque un momento y un lugar en el que no se le interrumpa.</p>
    			<p><strong>1.-</strong> En cada casilla lea atentamente las palabras de cada linea. 
                Seleccione
                la linea que mejor le describa en su entorno laboral 
                y rodee con un
                circulo la M que aparece junto a la misma.</p>
                <p><strong>2.-</strong> Entre las tres lineas restantes seleccione aquella que <strong>PEOR </strong>le describe en su entorno laboral y rodee con un circulo  la P que aparece junto a la misma.</p>
                <p><strong>3.-</strong> En las dos lineas restantes seleccione uno de los n&uacute;meros 1,2,3,4 &oacute; 5, 
                en donde 1 indica &quot;<em>no creo que me describa</em>&quot;, y 5 &quot;<em>creo que me 
                  describe bastante</em>&quot;. Le rogamos que <strong>NO</strong> escoja el mismo n&uacute;mero dos
                veces. Seleccion los valores (de 1 a 5) que usted cree que mejor
              representan su personalidad en el trabajo.</p>
        	</div>
            <div class="col-md-6" align="justify" valign="top">
    			<p align="justify"><strong>4.-</strong> Contin&uacute;e hasta cumplir las 25 casillas. Aseg&uacute;rese de haber puntuado todas ellas y de haber asignado una M, una P o un n&uacute;mero a cada una de las l&iacute;neas.</p>
    			<ul>
    				<li>Recuerde que NO se trata de un examen. NO hay respuestas &quot;correctas&quot; ni &quot;incorrectas&quot;.</li>
    				<li>Responda la evaluaci&oacute;n bas&aacute;ndose en c&oacute;mo se ve usted a si mismo. NO discuta sus respuestas con otras personas.</li>
    				<li>Seleccione r&aacute;pidamente sus respuestas ya que en el primer impulso se suele dar ua respuesta m&aacute;s sincera. A t&iacute;tulo de orientaci&oacute;n le diremos que contestar las preguntas lleva generalmente entre 10 y 20 minutos.</li>
    			</ul>
    			<p align="justify">&nbsp;</p>
    			<p align="justify"><strong>a)</strong> Se le sugiere no salir de la pagina de test hasta no haber completado el mismo ya que la clave proporcionada es unica y al momento de abandonar esta pagina no podra regresar para continuar con el Test.</p>
    			<p align="justify"><strong>b)</strong> Antes de dar click en aceptar asegurese de haber completado el Test de acuerdo a las instrucciones dadas en la parte izquierda.</p>
            </div>
    	</div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td class="bg-primary" colspan="2" align="center"><strong>Ejemplo</strong></td>
          </tr>
          <tr>
            <td class="col-xs-6">Sensible y diplomatico</td>
            <td class="col-xs-6"><?php $meth->getDemo(1); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Preciso y determinado</td>
              <td class="col-xs-6"><?php $meth->getDemo(7); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Estimulante y valorativo</td>
              <td class="col-xs-6"><?php $meth->getDemo(3); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Orientado hacia los resultados y rapido</td>
              <td class="col-xs-6"><?php $meth->getDemo(5); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">1</td>
          </tr>
          <tr>
            <td class="col-xs-6">Cuidadoso y evaluador</td>
            <td class="col-xs-6"><?php $meth->getResults(1); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Leal y amable</td>
              <td class="col-xs-6"><?php $meth->getResults(1); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Influyente y expresivo</td>
              <td class="col-xs-6"><?php $meth->getResults(1); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Estratégico y exigente</td>
              <td class="col-xs-6"><?php $meth->getResults(1); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">2</td>
          </tr>
          <tr>
            <td class="col-xs-6">Amigable y dinámico</td>
            <td class="col-xs-6"><?php $meth->getResults(2); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Confiable y moderado</td>
              <td class="col-xs-6"><?php $meth->getResults(2); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Enérgico y orientado a resultados</td>
              <td class="col-xs-6"><?php $meth->getResults(2); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Metódico y lógico</td>
              <td class="col-xs-6"><?php $meth->getResults(2); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">3</td>
          </tr>
          <tr>
            <td class="col-xs-6">Tranquilo y mediador</td>
            <td class="col-xs-6"><?php $meth->getResults(3); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Decidído y dominante</td>
              <td class="col-xs-6"><?php $meth->getResults(3); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Optimista y alegre</td>
              <td class="col-xs-6"><?php $meth->getResults(3); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Exacto y objetivo</td>
              <td class="col-xs-6"><?php $meth->getResults(3); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">4</td>
          </tr>
          <tr>
            <td class="col-xs-6">Seguro de si mismo e intenso</td>
            <td class="col-xs-6"><?php $meth->getResults(4); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Ordenado y conciso</td>
              <td class="col-xs-6"><?php $meth->getResults(4); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Estable y de trato fácil</td>
              <td class="col-xs-6"><?php $meth->getResults(4); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Conversador y simpático</td>
              <td class="col-xs-6"><?php $meth->getResults(4); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">5</td>
          </tr>
          <tr>
            <td class="col-xs-6">Estructurado y claro</td>
            <td class="col-xs-6"><?php $meth->getResults(5); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Desafiante y directo</td>
              <td class="col-xs-6"><?php $meth->getResults(5); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Leal y adaptable</td>
              <td class="col-xs-6"><?php $meth->getResults(5); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Sociable y activo</td>
              <td class="col-xs-6"><?php $meth->getResults(5); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">6</td>
          </tr>
          <tr>
            <td class="col-xs-6">Complaciente y colaborador</td>
            <td class="col-xs-6"><?php $meth->getResults(6); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Expresivo y optimista</td>
              <td class="col-xs-6"><?php $meth->getResults(6); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Enérgico y autoritario</td>
              <td class="col-xs-6"><?php $meth->getResults(6); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Pensativo y auto-controlado</td>
              <td class="col-xs-6"><?php $meth->getResults(6); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">7</td>
          </tr>
          <tr>
            <td class="col-xs-6">Efusivo y persuasivo</td>
            <td class="col-xs-6"><?php $meth->getResults(7); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Reflexivo y suspicaz</td>
              <td class="col-xs-6"><?php $meth->getResults(7); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Con iniciativa y confianza en si mismo</td>
              <td class="col-xs-6"><?php $meth->getResults(7); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Calmado y considerado con los demas</td>
              <td class="col-xs-6"><?php $meth->getResults(7); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">8</td>
          </tr>
          <tr>
            <td class="col-xs-6">Seguro de si mismo y con determinación</td>
            <td class="col-xs-6"><?php $meth->getResults(8); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Extrovertido y alegre</td>
              <td class="col-xs-6"><?php $meth->getResults(8); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Fiel y solidario</td>
              <td class="col-xs-6"><?php $meth->getResults(8); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Coherente y preciso</td>
              <td class="col-xs-6"><?php $meth->getResults(8); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">9</td>
          </tr>
          <tr>
            <td class="col-xs-6">Sensible y diplomatico</td>
            <td class="col-xs-6"><?php $meth->getResults(9); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Preciso y prudente</td>
              <td class="col-xs-6"><?php $meth->getResults(9); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Entusiasta y alentador</td>
              <td class="col-xs-6"><?php $meth->getResults(9); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Rápido y orientado a resultados</td>
              <td class="col-xs-6"><?php $meth->getResults(9); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">10</td>
          </tr>
          <tr>
            <td class="col-xs-6">Dominante y firme</td>
            <td class="col-xs-6"><?php $meth->getResults(10); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Conciliador y reservado</td>
              <td class="col-xs-6"><?php $meth->getResults(10); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Sociable y animado</td>
              <td class="col-xs-6"><?php $meth->getResults(10); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Minucioso y detallista</td>
              <td class="col-xs-6"><?php $meth->getResults(10); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">11</td>
          </tr>
          <tr>
            <td class="col-xs-6">Centrado en el equipo y espontáneo</td>
            <td class="col-xs-6"><?php $meth->getResults(11); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Exacto y racional</td>
              <td class="col-xs-6"><?php $meth->getResults(11); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Amistoso y equilibrado</td>
              <td class="col-xs-6"><?php $meth->getResults(11); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Centrado en la tarea y franco</td>
              <td class="col-xs-6"><?php $meth->getResults(11); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">12</td>
          </tr>
          <tr>
            <td class="col-xs-6">Analítico y meticuloso</td>
            <td class="col-xs-6"><?php $meth->getResults(12); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Amistoso y divertido</td>
              <td class="col-xs-6"><?php $meth->getResults(12); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Competitivo y fuerte</td>
              <td class="col-xs-6"><?php $meth->getResults(12); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Ecuánime y cooperativo</td>
              <td class="col-xs-6"><?php $meth->getResults(12); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">13</td>
          </tr>
          <tr>
            <td class="col-xs-6">De trato personal y apacible</td>
            <td class="col-xs-6"><?php $meth->getResults(13); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Abierto y empático</td>
              <td class="col-xs-6"><?php $meth->getResults(13); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Observador y formal</td>
              <td class="col-xs-6"><?php $meth->getResults(13); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Activo y controlador</td>
              <td class="col-xs-6"><?php $meth->getResults(13); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">14</td>
          </tr>
          <tr>
            <td class="col-xs-6">Resuelto y capaz de imponerse</td>
            <td class="col-xs-6"><?php $meth->getResults(14); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Perfeccionista y cuestionador</td>
              <td class="col-xs-6"><?php $meth->getResults(14); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Entusiasta y encantador</td>
              <td class="col-xs-6"><?php $meth->getResults(14); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Comprensivo y pacificador</td>
              <td class="col-xs-6"><?php $meth->getResults(14); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">15</td>
          </tr>
          <tr>
            <td class="col-xs-6">Sistemático y escrupuloso</td>
            <td class="col-xs-6"><?php $meth->getResults(15); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Popular y amante de la diversión</td>
              <td class="col-xs-6"><?php $meth->getResults(15); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Moderador y promueve el equilibrio</td>
              <td class="col-xs-6"><?php $meth->getResults(15); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Audaz y con determinación</td>
              <td class="col-xs-6"><?php $meth->getResults(15); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">16</td>
          </tr>
          <tr>
            <td class="col-xs-6">Animado y convincente</td>
            <td class="col-xs-6"><?php $meth->getResults(16); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Decidido e inmediato</td>
              <td class="col-xs-6"><?php $meth->getResults(16); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Analítico y disciplinado</td>
              <td class="col-xs-6"><?php $meth->getResults(16); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Tolerante y sosegado</td>
              <td class="col-xs-6"><?php $meth->getResults(16); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">17</td>
          </tr>
          <tr>
            <td class="col-xs-6">Paciente y empático</td>
            <td class="col-xs-6"><?php $meth->getResults(17); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Lógico y controlado</td>
              <td class="col-xs-6"><?php $meth->getResults(17); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Centrado en el trabajo y competitivo</td>
              <td class="col-xs-6"><?php $meth->getResults(17); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Platicador y espontáneo</td>
              <td class="col-xs-6"><?php $meth->getResults(17); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">18</td>
          </tr>
          <tr>
            <td class="col-xs-6">Influyente e informal</td>
            <td class="col-xs-6"><?php $meth->getResults(18); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Discreto e impulsado por valores</td>
              <td class="col-xs-6"><?php $meth->getResults(18); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Imparcial y evaluador</td>
              <td class="col-xs-6"><?php $meth->getResults(18); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Desafiante y autoritario</td>
              <td class="col-xs-6"><?php $meth->getResults(18); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">19</td>
          </tr>
          <tr>
            <td class="col-xs-6">Sistemático y preparado</td>
            <td class="col-xs-6"><?php $meth->getResults(19); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Valiente e independiente</td>
              <td class="col-xs-6"><?php $meth->getResults(19); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Imaginativo y extrovertido</td>
              <td class="col-xs-6"><?php $meth->getResults(19); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Consejero y preocupado por los demás</td>
              <td class="col-xs-6"><?php $meth->getResults(19); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">20</td>
          </tr>
          <tr>
            <td class="col-xs-6">Le gusta mandar y orientado a la acción  </td>
            <td class="col-xs-6"><?php $meth->getResults(20); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Espontáneo y animado </td>
              <td class="col-xs-6"><?php $meth->getResults(20); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Estudioso y racional </td>
              <td class="col-xs-6"><?php $meth->getResults(20); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Pacificador y armonioso</td>
              <td class="col-xs-6"><?php $meth->getResults(20); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">21</td>
          </tr>
          <tr>
            <td class="col-xs-6">Organizado y juicioso  </td>
            <td class="col-xs-6"><?php $meth->getResults(21); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Paciente y colaborador </td>
              <td class="col-xs-6"><?php $meth->getResults(21); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Fuerte y buen discutidor </td>
              <td class="col-xs-6"><?php $meth->getResults(21); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Abierto y busca relacionarse </td>
              <td class="col-xs-6"><?php $meth->getResults(21); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">22</td>
          </tr>
          <tr>
            <td class="col-xs-6">Objetivo y audaz </td>
            <td class="col-xs-6"><?php $meth->getResults(22); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Relajado y pacifico  </td>
              <td class="col-xs-6"><?php $meth->getResults(22); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Basado en los hechos y formal  </td>
              <td class="col-xs-6"><?php $meth->getResults(22); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Alegre y agradable </td>
              <td class="col-xs-6"><?php $meth->getResults(22); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">23</td>
          </tr>
          <tr>
            <td class="col-xs-6">Efusivo y entusiasta </td>
            <td class="col-xs-6"><?php $meth->getResults(23); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Vigoroso y realista  </td>
              <td class="col-xs-6"><?php $meth->getResults(23); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Compasivo y considerado  </td>
              <td class="col-xs-6"><?php $meth->getResults(23); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Disciplinado y detallista  </td>
              <td class="col-xs-6"><?php $meth->getResults(23); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">24</td>
          </tr>
          <tr>
            <td class="col-xs-6">Constante y que apoya a los demas  </td>
            <td class="col-xs-6"><?php $meth->getResults(24); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Independiente y emprendedor  </td>
              <td class="col-xs-6"><?php $meth->getResults(24); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Reflexivo y minucioso  </td>
              <td class="col-xs-6"><?php $meth->getResults(24); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Comunicativo y positivo  </td>
              <td class="col-xs-6"><?php $meth->getResults(24); ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6 no-padding">
        <table class="table col-md-12" border="0.5" cellpadding="0">
          <tr>
            <td colspan="2" align="center" bgcolor="#D6D6D6">25</td>
          </tr>
          <tr>
            <td class="col-xs-6">Cauto y preciso  </td>
            <td class="col-xs-6"><?php $meth->getResults(25); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Directo y franco </td>
              <td class="col-xs-6"><?php $meth->getResults(25); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Expresivo y optimista  </td>
              <td class="col-xs-6"><?php $meth->getResults(25); ?></td>
          </tr>
          <tr>    
              <td class="col-xs-6">Tolerante y noble  </td>
              <td class="col-xs-6"><?php $meth->getResults(25); ?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center form-group">
        <input type="submit" name="aceptar" id="aceptar" value="Aceptar" />
      </div>
    </div>
    <div class="row">
      <div id="i_error_log">
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center form-group bg-warning">
          <font style="font-family:Arial, Helvetica, sans-serif"  size="2">ASEGURESE DE HABER VALORADO TODAS Y CADA UNA DE LAS 25 CASILLAS Y DE HABER ASIGANDO UNA M, UNA P O UN NUMERO A CADA UNA DE LAS LINEAS </font>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center form-group">
          <font style="font-family:Arial, Helvetica, sans-serif"  size="-1">
            ©Derechos de autor 1992-2002 Andres Lothian, Insights. Reservados todos los derechos.<br />
            Insights, Jack Martin Way. Claverhouse Business Park, Dundee DD4 9FF, Escocia, Reino Unido<br />
            Tlf: 44-(0)1382-908050 Fax:44-(0)1382-908051</font>
      </div>
    </div>
  </form>
            
          

