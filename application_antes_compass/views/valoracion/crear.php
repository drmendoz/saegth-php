  <style type="text/css">
    color1 {  background:#00FFFF;  }
    color2 {  background:#FFFF66; }
    color3 {  background:#99FF66; }
    table:not(.definition) tr > td{text-align: center;}
    table tr > td[rowspan]{text-align: left}
  </style>
  <script type="text/javascript" src="<?php echo BASEURL ?>public/js/admin/funciones.js"></script>
  <script type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var ce = $('#autoselect').val();
      console.log(ce);
      if(ce==1){
        valores();
        problemsol();
        account_f();
        var index1 = $('#z').val();
        var index2 = $('#y1').val();
        var index3 = $('#x1').val();
        $($('input:radio[name=1A]')[index1]).prop('checked',true);
        $($('input:radio[name=2A]')[index2]).prop('checked',true);
        $($('input:radio[name=3A]')[index3]).prop('checked',true);
        var index1 = $('#z2').val();
        var index2 = $('#y2').val();
        var index3 = $('#x2').val();
        $($('input:radio[name=RadioGroup2]')[index1]).prop('checked',true);
        $($('input:radio[name=RadioGroup2A]')[index2]).prop('checked',true);
        $($('input:radio[name=RadioGroup3A]')[index3]).prop('checked',true);
        document.getElementById("bb_link").href=BASEURL+'/valoracion/ver'; 
        var test = document.getElementById('_z3');
        var test_val = document.getElementById('z3');
        if(test!=null){
          test.innerText=$(test_val).val();
        }
        var test = document.getElementById('_y3');
        var test_val = document.getElementById('y3');
        if(test!=null){
          test.innerText=$(test_val).val();
        }
        var test = document.getElementById('_y4');
        var test_val = document.getElementById('y4');
        if(test!=null){
          test.innerText=$(test_val).val();
        }
        var test = document.getElementById('_x3');
        var test_val = document.getElementById('x3');
        if(test!=null){
          test.innerText=$(test_val).val();
        }
        $('#bb_link').click(function(){
          event.preventDefault();
          window.location=BASEURL+'/valoracion/ver';
        });
      }
      $('input:radio[name=1A]').click(function() {   
        var valor = $('input:radio[name=1A]:checked').val();
        $('#z').val(valor);
        valores();
        suma();
      });
      $('input:radio[name=RadioGroup2]').click(function() {   
        var valor2 = $('input:radio[name=RadioGroup2]:checked').val();
        $('#z2').val(valor2);
        valores();
        suma();
      }); 
      $('input:radio[name=2A]').click(function() {   
        var valor = $('input:radio[name=2A]:checked').val();
        $('#y1').val(valor);
        problemsol();
        valores();
        account_f();
      });

      $('input:radio[name=RadioGroup2A]').click(function() {   
        var valor2 = $('input:radio[name=RadioGroup2A]:checked').val();
        $('#y2').val(valor2);
        problemsol();
        valores();
        account_f();
      }); 
      $('input:radio[name=3A]').click(function() {   
        var valor = $('input:radio[name=3A]:checked').val();
        $('#x1').val(valor);
        account_f();
        problemsol();
        valores();
      });

      $('input:radio[name=RadioGroup3A]').click(function() {   
        var valor2 = $('input:radio[name=RadioGroup3A]:checked').val();
        $('#x2').val(valor2);
        account_f();
        problemsol();
        valores();
      }); 
    });
    function controlfinal(){
      var valor1 =$('#x3').val(); var valor2 =$('#y4').val();
      if(valor1==""){valor1=0;}
      if (valor2==""){valor2=0;}
      var final= control(valor1,valor2);
      $('#7').val(final);
    }
    function valores(){ 
      var valor1 =$('#z').val(); var valor2 =$('#z2').val();
      if(valor1==""){valor1=0;}
      if (valor2==""){valor2=0;}
      var z3 = knowhow(valor1,valor2);
      $('#z3').val(z3);
      suma();
      var lkh1 = letrasknowhowi(valor1);
      var lkh2 = letrasknowhowj(valor2);
      $('#1').val(lkh1);
      $('#2').val(lkh2);
    }
    function problemsol(){
      var valor1 =$('#y1').val();
      var valor2 =$('#y2').val();
      if(valor1==""){valor1=0;}
      if (valor2==""){valor2=0;}
      var z3 = problemsolporc(valor1,valor2);
      $('#y3').val(z3);
      var kw = parseInt($('#z3').val());
      console.log(z3);
      console.log(kw);
      var z4 = problemsoltot (z3,kw);
      $('#y4').val(z4);
      suma();
      var lkh1 = problemsoli(valor1);
      var lkh2 = problemsolj(valor2);
      $('#3').val(lkh1);
      $('#4').val(lkh2);
      //controlfinal();
    }
    function account_f(){
      var valor1 =$('#x1').val();
      var valor2 =$('#x2').val();
      if(valor1==""){valor1=0;}
      if (valor2==""){valor2=0;}
      var x3 = account(valor1,valor2);
      $('#x3').val(x3);
      suma();
      var lkh1 = accounti(valor1);
      var lkh2 = accountj(valor2);
      $('#5').val(lkh1);
      $('#6').val(lkh2);
      controlfinal();
    }
  </script>
<input type="hidden" id="autoselect" value="<?php if(isset($ent)) echo 1; else echo 0; ?>">
  <form name="form3" method="post" action="<?php echo BASEURL ?>valoracion/<?php echo $action ?>">
    <div style="width: 1300px">
      <table class="table table-bordered form-group">
        <thead>
          <tr>
            <th class="text-center">POSITION</th>
            <th class="text-center" colspan="3">KNOW HOW</th>
            <th class="text-center" colspan="4">PROBLEM SOLVING</th>
            <th class="text-center" colspan="3">ACCOUNTABILITY</th>
            <th class="text-center">Total Points</th>
            <th class="text-center">Profile</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td><input type="hidden" required="required" value="<?php if(isset($ent)) echo $ent->kh_col1 ;?>" name="z"  id="z" maxlength="3" size="2"/></td>
            <td><input type="hidden" required="required" value="<?php if(isset($ent)) echo $ent->kh_col2 ;?>" name="z2" id="z2"  maxlength="3" size="2"/></td>
            <td></td>
            <td><input type="hidden" required="required" value="<?php if(isset($ent)) echo $ent->ps_col1; ?>" name="y1" id="y1"  maxlength="3" size="2"/></td>
            <td><input type="hidden" required="required" value="<?php if(isset($ent)) echo $ent->ps_col2; ?>" name="y2" id="y2"  maxlength="3" size="2"/></td>
            <td></td>
            <td></td>
            <td><input type="hidden" required="required" value="<?php if(isset($ent)) echo $ent->ac_col1 ;?>" name="x1" id="x1"  maxlength="3" size="2"/></td>
            <td><input type="hidden" required="required" value="<?php if(isset($ent)) echo $ent->ac_col2 ;?>" name="x2" id="x2"  maxlength="3" size="2"/></td>
            <td></td>
            <td></td>
          </tr>
      <?php
        if(isset($action) && isset($id)){
          if($action=="clonar/".$id){ ?>
          <tr class="active">
            <td><?php if(isset($ent)) echo $ent->htmlprnt($ent->position) ;?></td>
            <td><?php if(isset($ent)) echo $ent->knowhowi() ;?></td>
            <td><?php if(isset($ent)) echo $ent->knowhowj() ;?></td>
            <td id="_z3" class="info"></td>
            <td><?php if(isset($ent)) echo $ent->problemsoli() ;?></td>
            <td><?php if(isset($ent)) echo $ent->problemsolj() ;?></td>
            <td id="_y3"></td>
            <td id="_y4" class="warning"></td>
            <td><?php if(isset($ent)) echo $ent->accounti() ;?></td>
            <td><?php if(isset($ent)) echo $ent->accountj() ;?></td>
            <td id="_x3" class="success"></td>
            <td><?php if(isset($ent)) echo $ent->total ;?></td>
            <td><?php if(isset($ent)) echo $ent->profile ;?></td>
          </tr>
<?php     }
        }
      ?>
          <tr>
            <td><input class="form-control" required="required" type="text" name="textfield" id="textfield" size="45" value="<?php if(isset($ent)) echo $ent->htmlprnt($ent->position) ;?>"></td>
            <td><input class="form-control" type="text" name="1"  id="1" maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->knowhowi() ;?>" /></td>
            <td><input class="form-control" type="text" name="2" id="2"  maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->knowhowj() ;?>" /></td>
            <td><input class="form-control" type="text" name="z3" id="z3"  maxlength="5" size="2" style="background: none repeat scroll 0% 0% rgb(0, 255, 255);"/></td>
            <td><input class="form-control" type="text" name="3" id="3"  maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->problemsoli() ;?>" /></td>
            <td><input class="form-control" type="text" name="4" id="4"  maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->problemsolj() ;?>" /></td>
            <td width="20">
              <div class="input-group">
                <input class="form-control" type="text" name="y3" id="y3" width="60" style="width:60px !important"  maxlength="5" size="2"/>
                <span class="input-group-addon">%</span>
              </div>
            </td>
            <td><input class="form-control" type="text" name="y4" id="y4"  maxlength="5" size="2"  style="background: none repeat scroll 0% 0% rgb(255, 255, 102);"/></td>
            <td><input class="form-control" type="text" name="5" id="5"  maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->accounti() ;?>" /></td>
            <td><input class="form-control" type="text" name="6" id="6"  maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->accountj() ;?>" /></td>
            <td><input class="form-control" type="text" name="x3" id="x3"  maxlength="5" size="2" style="background: none repeat scroll 0% 0% rgb(153, 255, 102);"/></td>
            <td><input class="form-control" type="text" name="x4" id="x4"  maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->total ;?>" /></td>
            <td><input class="form-control" type="text" name="7" id="7" maxlength="5" size="2" value="<?php if(isset($ent)) echo $ent->profile ;?>" ></td>
          </tr>
          <tr>
            <td colspan="13">
              <div class="text-center">
                <input type="submit" class="btn btn-sm btn-default" name="button" id="button" value="Grabar">
              </div>
            </td>
          </tr>
        </tbody>
        <div class="clearfix"></div>
      </table>

      <table class="table-bordered form-group definition">
        <tr>
          <td class="col-md-4">
            <strong>KNOW HOW</strong><br>DEFINICI&Oacute;N: Es el conjunto de Conocimientos, Experiencia y Habilida-des requeridas para desempeñar adecuadamente el cargo, inpendientemente de cómo se haya adquirido:  
          </td>
          <td class="col-md-4">
            <strong>TABLA GUIA PARA EVALUAR CONOCIMIENTO, EXPERIENCIA Y HABILIDADES KNOW HOW  (C.E.H.)</strong>     
          </td>
          <td class="col-md-4">
            <strong>EVALUACIÓN: </strong>Los cargos requieren combinaciones variadas de algún conocimiento sobre muchas cosas o mucho conocimiento de pocas cosas.  Lo que nos interesa evaluar es la suma total de conocimientos, experiencia y habilidad.
          </td>
        </tr>
      </table>

      <div class="col-md-12">
        <p><strong>Amplitud y profundidade de conocimientos:</strong> La clasificación se extiende desde la más simple rutina de trabajo hasta el conocimiento único y experto dentro de las disciplinas aprendidas.</p>
        <p><strong>Habilidad gerencial:</strong> Es La exigencia de coordinar e integrar diversidad de funciones y recursos para lograr resultados finales. Implica la habilidad de planificar, controlar y evaluar tanto a nivel operativo como conceptual.</p>
        <p><strong>Relaciones humanas:</strong> Es la exigencia requerida en la relacion activa y directa de persona a persona para obtener los resultados del cargo.</p>
      </div>

      <div class="form-group">
        <div class="col-md-7">
          <table border="1">
            <tr>
              <td width="536" rowspan="3" bgcolor="#33FFFF"><strong>L.  LIMITADO:  </strong>Familiaridad con rutinas simples de trabajo requeridas para llevar a cabo tareas manuales.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="0" /></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="1" /></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="2"/></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>A.  PRIMARIO:  </strong>Habilidades para realizar una variedad de rutinas que implican la o-peración de equipos o máquinas simples.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="3"/></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="4"/></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="5"/></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>B.  PRACTICAS ELEMENTALES:  </strong>Habilidades para realizar varie-dad de rutinas que implican operación de equip. simples.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="6"/></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="7"/></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="8"/></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>C.  PRACTICAS:</strong> Conocimientos de los procesos o sistemas de trabajo que puede incluir destreza para el uso de equipo especia-lizado.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="9"/></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="10" /></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="11" /></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>D.  PRACTICAS AVANZADAS:</strong> Conocimiento especializado. (ge-neralmente no teórico) adquirido en o fuera del trabajo y/o conoci-miento de los procedimientos. En un elemento funcional único adquirido a través de la experiencia.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="12" /></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="13" /></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="14" /></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>E.  ESPECIALIDAD FUNCIONAL BASICA:  </strong>Conocimiento y aplicación de una discipli-na funcional que implica la comprensión de prácticas y precedentes o de teorías y principios científicos o de ambos.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="15" /></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="16" /></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="17" /></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>F.  ESPECIALIDAD FUNCIONAL MADURA:  </strong>Conocimiento experto en una disciplina funcional que implica una vasta comprensión de sus prácticas y principios, unida a una amplia experiencia en la aplicación de dicho conocimiento.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="18" /></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="19" /></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="20" /></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>G.  ESPECIALIDAD EMPRESARIAL O MAESTRIA.-</strong> Liderazgo técni-co en una disciplina compleja o un vasto conocimiento y experiencia requeridos para la gerencia de toda la compañía o de 1 función grand</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="21" /></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="22" /></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="23" /></td>
            </tr>
            <tr>
              <td rowspan="3" bgcolor="#33FFFF"><strong>H.  MAESTRIA EXCEPCIONAL.</strong>-  Liderazgo técnico excepcional en algún campo complejo profesional o científico, reconocido fuera de los límites de la organización.</td>
              <td class="text-center" width="18">-</td>
              <td width="20"><input type="radio" required="required" name="1A" value="24" /></td>
            </tr>
            <tr>
              <td>=</td>
              <td width="20"><input type="radio" required="required" name="1A" value="25" /></td>
            </tr>
            <tr>
              <td>+</td>
              <td width="20"><input type="radio" required="required" name="1A" value="26" onClick="knowhow();"/></td>
            </tr>
          </table>
        </div>
        <div class="col-md-5">
          <table border="1">
            <tr>
              <td width="327" rowspan="3"><strong>T.    INEXISTENTE </strong>  Ejecución de una o varias tareas muy    específicas en cuanto a objetivos y contenido, donde la coordinación de estas    tares con otras es responsabilidad del supervisor del cargo.</td>
              <td width="26">1</td>
              <td width="20"><input type="radio" required="required" name="RadioGroup2" value="0" /></td>
            </tr>
            <tr>
              <td>2</td>
              <td width="20"><input type="radio" required="required" name="RadioGroup2" value="1" /></td>
            </tr>
            <tr>
              <td>3</td>
              <td width="20"><input type="radio" required="required" name="RadioGroup2" value="2" /></td>
            </tr>
            <tr>
              <td rowspan="3"><strong>I. MINIMA </strong>            Ejecución de tareas complejas o    una combinación de tareas, requiriendo el ocupante vincular su trabajo con el    de otro, o la supervisión  de    actividades específicas en cuanto a objetivos y contenido.</td>
              <td>1</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="3" /></td>
            </tr>
            <tr>
              <td>2</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="4" /></td>
            </tr>
            <tr>
              <td>3</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="5" /></td>
            </tr>
            <tr>
              <td rowspan="3"><strong>II. HOMOGENEA </strong>          Integración y    coordinación operativa o conceptual de actividades y funciones homogéneas en    naturaleza y objetivos. </td>
              <td>1</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="6" /></td>
            </tr>
            <tr>
              <td>2</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="7" /></td>
            </tr>
            <tr>
              <td>3</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="8" /></td>
            </tr>
            <tr>
              <td rowspan="3"><div align="left"><strong>III. HETEROGONEA </strong>          Integración y    coordinación operativa o conceptual de actividades y funciones heterogéneas    en naturaleza y objetivos.  Incluye la    gerencia de línea de una unidad grande y/o compleja, la gerencia de una    función de apoyo para toda la organización.</div></td>
              <td>1</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="9" /></td>
            </tr>
            <tr>
              <td>2</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="10" /></td>
            </tr>
            <tr>
              <td>3</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="11" /></td>
            </tr>
            <tr>
              <td height="71" rowspan="3"><strong>IV. AMPLIA  </strong>                    Integración    de las funciones fundamentales de la organización o la coordinación global de    una función estratégica, la cual afecta las operaciones.</td>
              <td>1</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="12" /></td>
            </tr>
            <tr>
              <td>2</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="13" /></td>
            </tr>
            <tr>
              <td>3</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="14" /></td>
            </tr>
            <tr>
              <td height="102" rowspan="3"><strong>V. GLOBAL </strong>                     Integración    global de todas las funciones de una corporación de gran tamaño.</td>
              <td>1</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="15" /></td>
            </tr>
            <tr>
              <td>2</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="16" /></td>
            </tr>
            <tr>
              <td>3</td>
              <td><input type="radio" required="required" name="RadioGroup2" value="17" /></td>
            </tr>
          </table>
        </div>
        <div class="clearfix"></div>
      </div>

      <table class="table-bordered form-group definition">
        <tr>
          <td class="col-md-4"><strong>PROBLEM SOLVING </strong><br>DEFINICIÓN: Es la calidad y autonomía del pensamiento    requerido por el puesto para identificar, definir, analizar, sintetizar,    crear y obtener soluciones adecuadas a las diversas situaciones de    trabajo.  En la medida en que el pensar    esté circunscrito, cubierto por precedentes o es referido a otros, la    &quot;Solución de Problemas&quot; disminuye.     Este factor se mide a través de dos elementos:</td>       <td class="col-md-4"><div align="center">TABLA GUIA    PARA EVALUAR SOLUCION DE PROBLEMAS  PROBLEM SOLVING (S.P.)   </div></td>
          <td class="col-md-4"><strong>EVALUACION:  </strong>Se mide la intensidad    del proceso mental con el que se emplean los Conocimientos, Experiencia y    Habilidades en analizar, evaluar, construir o crear soluciones.  &quot;Se piensa con lo que se sabe&quot;.  La materia prima del pensamiento es el    conocimiento de hechos, principios y significados. PS se evalua como un % del    uso del conocimiento.</td>
        </tr>
      </table>

      <div class="col-md-12">
        <p><strong>Marco/Ambiente de Referencia:  </strong>Es el ambiente en el cual tiene lugar el proceso intelectual.    Comprende el apoyo y/o guía disponible para la búsqueda o construcción de soluciones. </p>
        <p><strong>Exigencia/Complejidad de los Problemas: </strong>Se refiere a la complejidad del proceso mental requerido por las situaciones que se presentan en el trabajo,  desde la utilización de la memoria inmediata hasta la creatividad para descubrir problemas y soluciones. </p>
      </div>

      <div class="form-group">
        <div class="col-md-7">
          <table border="1">
            <tr>
              <td rowspan="3" bgcolor="#FFFF66"><strong>A. Rutina Estricta:  </strong>Reglas o instrucciones simples, detalladas y repetitivas.</td>
              <td width="18">-</td width="20">
                <td><input type="radio" required="required" name="2A" value="0"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="1"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#FFFF66"><strong>B. Rutina:  </strong>Rutinas o instrucciones establecidas. Permite la consideración de formas alternativas de ejecutar las tareas, de acuerdo con situaciones presentes dentro del ambiente de trabajo.</td>
                <td width="18">-</td>
                <td width="20"><input type="radio" required="required" name="2A" value="2"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="3"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#FFFF66"><strong>C. Semirutina:  </strong>Las situaciones son resueltas considerando difeentes rutinas posibles, sujeto a la guía del supervisor o a procedimientos y ejemplos bien definidos.</td>
                <td width="18">-</td>
                <td width="20"><input type="radio" required="required" name="2A" value="4"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="5"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#FFFF66"><strong>D. Estandarizado: </strong>Procedimientos diversificados. De acuerdo con las condiciones, se elige cuál de muchos procedimientos es el más adecuado dentro de gran diversidad de opciones.  Supervis. Gral.</td>
                <td width="18">-</td>
                <td width="20"><input type="radio" required="required" name="2A" value="6"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="7"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#FFFF66"><strong>E. Claramente Definido: </strong>Políticas y principios cláramente definidos. El &quot;qué&quot; está cláramente establecido; el &quot;cómo&quot; es determinado por el juicio propio del incumbente de acuerdo a politicas a seguir.</td>
                <td width="18">-</td>
                <td width="20"><input type="radio" required="required" name="2A" value="8"/></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="9"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#FFFF66"><strong>F. Definido Genéricamente: </strong>Poíticas generales y objetivos específicos.  El &quot;qué&quot; es genérico dentro de las políticas globales de la Organización.</td>
                <td width="18">-</td>
                <td width="20"><input type="radio" required="required" name="2A" value="10" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="11" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#FFFF66"><strong>G. Global:</strong> Estos cargos definen en términos generales los objetivos de la organización.</td>
                <td width="18">-</td>
                <td width="20"><input type="radio" required="required" name="2A" value="12" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="13" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#FFFF66"><strong>H. Abstracto: </strong>Leyes generales de la naturaleza o de la ciencia.  Filosofía de los negocios y patrones culturales.</td>
                <td width="18">-</td>
                <td width="20"><input type="radio" required="required" name="2A" value="14" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>+</td>
                <td width="20"><input type="radio" required="required" name="2A" value="15" /></td>
              </tr>
            </table>
          </div>
          <div class="col-md-5">
            <table class="table-bordered">
              <tr>
                <td rowspan="1"><strong>1. Memoria Selectiva:  </strong>Situaciones idénticas en las que la solución requiere una simple elección entre cosas aprendidas.  Poca necesidad de emplear juicio propio.</td>
                <td width="26"><input type="radio" required="required" name="RadioGroup2A" value="0" /></td>
              </tr>
              <tr>
                <td rowspan="1"><strong>2. Con Modelos:  </strong>Situaciones semejantes en las que la solución requiere elec-ción entre cosas aprendidas, las cuales se presentan en patrones claramente estable-cidos.</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup2A" value="1" /></td>
              </tr>
              <tr>
                <td rowspan="1"><strong>3. Interpolación:           </strong>Situaciones diferentes que presentan algún aspecto nuevo en las que la solución requiere un a-nálisis entre el conjunto de cosas aprendidas.  Permite u-na nueva solución producto de la combinación de solucio-nes anteriormente dadas.</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup2A" value="2" /></td>
              </tr>
              <tr>
                <td rowspan="1"><strong>4. Adaptación:  </strong>Situaciones diferentes en las que la solu-ción innovadora requiere un pensamiento análitico, inter-pretativo, evolutivo y/o cons-tructivo.  Se incorporan ele-mentos nuevos a la solución, exigiendo ponderar sus consecuencias.</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup2A" value="3" /></td>
              </tr>
              <tr>
                <td rowspan="1"><strong>5. Creatividad:  </strong>Situaciones de investigación o descubri-miento en las cuales tanto el método como el objeto son in-ciertos o sin precedentes y en las que la solución requiere nuevas concepciones y puntos de vista creativos. Exige confrontarse con situaciones desconocidas y originar nuevos conceptos o enfoques.</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup2A" value="4" /></td>
              </tr>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>

        <table class="table-bordered form-group definition">
          <tr>
            <td class="col-md-4"><strong>ACCOUNTABILITY.</strong><br>DEFINICION: Es la condición de responder o ser responsible por acciones, decisiones y consecuencias dentro de la organización. Su evaluación implica la medición del aporte del cargo en los    resultados finales.  Tiene tres dimensiones:</td>
            <td class="col-md-4"><strong>TABLA GUIA PARA EVALUAR RESPONSABILIDAD ACCOUNTABILITY (R)</strong></td>
            <td class="col-md-4"><strong>EVALUACIÓN:</strong> Los cargos requieren combinaciones variadas de algún conocimiento sobre muchas cosas o mucho conocimiento de pocas cosas. Lo que nos interesa evaluar es la suma total de conocimientos, experiencia y habilidad.</td>
          </tr>
        </table>

        <div class="col-md-12">
          <p><strong>Libertad para actuar:</strong> Es la autonomía para actuar que tiene el cargo establecida en el grado de control, guía, orientación y dirección que el cargo recibe.</p>
          <p><strong>Magnitud:</strong> Está deternimada por el volumen económico que el cargo afecta en su gestión. (Base anual y dinámica)</p>
          <p><strong>Impacto:</strong> Definido por la forma en que el cargo incide en el logro de los resultados de la organización dentro de su magnitud.</p>
        </div>

        <div class="form-group">
          <div class="col-md-7">
            <table class="table-bordered">
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>L.  LIMITADO:  </strong>Familiaridad con rutinas simples de trabajo requeridas para llevar a cabo tareas manuales.L. Limitada:  Instrucciones explicitas para realizar tareas simples. Supervisión contínua.       </td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="0"/></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="1"/></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="2"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>A. Prescripción:  Instrucciones directas y detalladas. Supervisión estrecha. </strong></td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="3"/></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="4"/></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="5"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>B. Control:  </strong>Rutinas de trabajo establecidas. Supervisión estrecha. </td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="6"/></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="7"/></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="8"/></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>C. Estandarización:  </strong>Instrucciones prácticas y procedimientos estan-darizados.  Supervisión sobre el avance del trabajo y sus resultados. Establecimiento de prioridades, sujetas a aprobación del superior. </td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="9"/></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="10" /></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="11" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>D. Regulación General: </strong>Planes y programas establecidos, concretos y definidos y/o prácticas y procedimientos basados en precedentes o políticas funcionales claram ente definidas.  Revisión de resultados.</td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="12" /></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="13" /></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="14" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>E.  Dirección Específica: </strong>Prácticas y procedimientos amplios cubiertos por precedentes y polítcas funcionales.  Consecución de resultados operacionales concretos. Dirección gerencial.</td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="15" /></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="16" /></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="17" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>F.  Dirección Genérica: </strong>Políticas funcionales generales, dirección gerencial amplia para el logro de metas.  Amplia discreción dentro de las políticas funcionales.  Sólo requieren de aprobación las acciones que afecten a otras áreas funcionales.</td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="18" /></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="19" /></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="20" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>G.  Orientación Amplia: </strong>Guía general por parte de la más Alta Dirección.  Determinan los resultados empresariales a alcanzar.  Son el alto nivel en la toma de decisiones en la organización.</td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="21" /></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="22" /></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="23" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>H.  Orientación Estratégica: </strong>Estrategia general de la Empresa con gran volumen de recursos. Sujetos a una guía muy general de la Junta Directiva.</td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="24" /></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="25" /></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="26" /></td>
              </tr>
              <tr>
                <td rowspan="3" bgcolor="#99FF66"><strong>I.  Guía Estratégica:  </strong>Estrategia global de grandes grupos corporativos.  Sólo sujetos a las restricciones de los accionistas o del público, en organizaciones muy grandes.</td>
                <td width="20">-</td>
                <td width="18"><input type="radio" required="required" name="3A" value="27" /></td>
              </tr>
              <tr>
                <td>=</td>
                <td width="18"><input type="radio" required="required" name="3A" value="28" /></td>
              </tr>
              <tr>
                <td>+</td>
                <td width="18"><input type="radio" required="required" name="3A" value="29" /></td>
              </tr>
            </table>
          </div>
          <div class="col-md-5">
            <table width="100%" class="table-bordered">
              <tr>
                <td rowspan="4"><strong>0                               INDETERMINADA </strong></td>
                <td width="26">R</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup3A" value="0" /></td>
              </tr>
              <tr>
                <td>C</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup3A" value="1" /></td>
              </tr>
              <tr>
                <td>S</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup3A" value="2" /></td>
              </tr>
              <tr>
                <td>P</td>
                <td width="20"><input type="radio" required="required" name="RadioGroup3A" value="3" /></td>
              </tr>
              <tr>
                <td rowspan="4"><strong>1                                                  MUY PEQUEÑA                              0 - 500 M </strong></td>
                <td width="26">R</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="4" /></td>
              </tr>
              <tr>
                <td>C</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="5" /></td>
              </tr>
              <tr>
                <td>S</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="6" /></td>
              </tr>
              <tr>
                <td>P</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="7" /></td>
              </tr>
              <tr>
                <td rowspan="4"><strong>2                                              PEQUEÑA                                        500 - 5 MM </strong></td>
                <td width="26">R</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="8" /></td>
              </tr>
              <tr>
                <td>C</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="9" /></td>
              </tr>
              <tr>
                <td>S</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="10" /></td>
              </tr>
              <tr>
                <td>P</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="11" /></td>
              </tr>
              <tr>
                <td rowspan="4"><div align="left"><strong>3                                              MEDIA                                              5 - 50 MM </strong></div></td>
                <td width="26">R</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="12" /></td>
              </tr>
              <tr>
                <td>C</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="13" /></td>
              </tr>
              <tr>
                <td>S</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="14" /></td>
              </tr>
              <tr>
                <td>P</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="15" /></td>
              </tr>
              <tr>
                <td height="71" rowspan="4"><strong>4                                              GRANDE                                              50 - 500 MM </strong></td>
                <td width="26">R</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="16" /></td>
              </tr>
              <tr>
                <td>C</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="17" /></td>
              </tr>
              <tr>
                <td>S</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="18" /></td>
              </tr>
              <tr>
                <td>P</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="19" /></td>
              </tr>
              <tr>
                <td height="102" rowspan="4"><strong>5                                              GRANDE                                              500 - 5.000 MM </strong></td>
                <td width="26">R</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="20" /></td>
              </tr>
              <tr>
                <td>C</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="21" /></td>
              </tr>
              <tr>
                <td>S</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="22" /></td>
              </tr>
              <tr>
                <td>P</td>
                <td width="18"><input type="radio" required="required" name="RadioGroup3A" value="23" /></td>
              </tr>
            </table>
          </div>
          <div class="clearfix"></div>
        </div>

      </div>
    </form>