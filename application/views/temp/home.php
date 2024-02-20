<?php
	$id_user = $_SESSION['USER-AD']['id'];
	$user_rol = $_SESSION['USER-AD']['user_rol'];

	if ($user_rol == 4 || $user_rol == 5 || $user_rol == 8) {
		$sonda = new Sonda();
		$sonda_respuesta = new Sonda_respuesta();
		$sonda->setId_empresa($_SESSION['Empresa']['id']);
		$sonda->test_x_user($id_user);
		$id_test = $sonda->getId();
		$id_e = $_SESSION["Empresa"]["id"];

		$sonda->select_($id_e,$id_test);
		$date_0 = date_create($sonda->fecha);
		$date_1 = date_create(date('Y-m-d'));
		$nuevos_criterios = $sonda->getNuevosCriterios();
		
		$criterios_escala = $sonda->getCriteriosEscala();
		$rango_escala = '';
		$rango_inicio = '';
		$rango_fin = '';


		if (is_array($criterios_escala)) {
			$rango_inicio = $criterios_escala[1]['escala_valor'];
			foreach ($criterios_escala as $key => $value) {
				$rango_fin = $criterios_escala[$key]['escala_valor'];
			}

			$rango_escala = $rango_inicio . ' a ' . $rango_fin;
		}

		if($sonda->getNuevosCriterios() == 0)
		{
			$rango_escala = '1 a 5';
			$rango_inicio = '1';
			$rango_fin = '5';
		}

		if ($date_1 > $date_0) {
			echo '<div class="alert alert-info" role="alert"><h4>La evaluación ha expirado</h4></div>';
		}else{
			if ($user_rol == 8) {
				$count = $sonda_respuesta->countUser_x_test($id_user);

				if ($count > 0) {
					echo '<div class="alert alert-info" role="alert"><h4>Muchas gracias por sus respuestas. Por favor Cierre Sesión (opción de la izquierda)</h4></div>';
				}else{
					echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
					echo "<h5>La Escala de Calificación des de 1 a 5, siendo 1 la respuesta menos favorable y 5 la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo izquierdo de la escala de calificación.</h5>";
					echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</h5>";
					echo "<br>";
					echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
				}
			}else{
				echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
				echo "<h5>La Escala de Calificación desde ".$rango_escala.", siendo ".$rango_inicio." la respuesta menos favorable y ".$rango_fin." la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo izquierdo de la escala de calificación.</h5>";
				echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</h5>";
				echo "<br>";
				echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
			}
		}
	}elseif ($user_rol == 6 || $user_rol == 7 || $user_rol == 9) {
		$riesgo = new Riesgo_psicosocial();
		$riesgo_respuesta = new rp_respuesta();
		$riesgo->setId_empresa($_SESSION['Empresa']['id']);
		$riesgo->test_x_user($id_user);
		$id_test = $riesgo->getId();
		$id_e = $_SESSION["Empresa"]["id"];

		$riesgo->select_x_id($id_e,$id_test);
		$date_0 = date_create($riesgo->fecha);
		$date_1 = date_create(date('Y-m-d'));

		if ($date_1 > $date_0) {
			echo '<div class="alert alert-info" role="alert"><h4>La evaluación ha expirado</h4></div>';
		}else{
			if ($user_rol == 9) {
				$count = $riesgo_respuesta->countUser_x_test($id_user);

				if ($count > 0) {
					echo '<div class="alert alert-info" role="alert"><h4>Muchas gracias por sus respuestas. Por favor Cierre Sesión (opción de la izquierda)</h4></div>';
				}else{
					echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
					echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Riesgo de Stress Psicosocial.  Gracias anticipadas por su dedicación y confianza.</h5>";
					echo "<br>";
					echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
				}
			}else{
				echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
				echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Riesgo de Stress Psicosocial.  Gracias anticipadas por su dedicación y confianza.</h5>";
				echo "<br>";
				echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
			}
		}
	}elseif ($user_rol == 10 || $user_rol == 11 || $user_rol == 12) {
		$sonda = new Efectividad_departamental();
		$sonda_respuesta = new Sonda_respuesta();
		$sonda->setId_empresa($_SESSION['Empresa']['id']);
		$sonda->test_x_user($id_user);
		$id_test = $sonda->getId();
		$id_e = $_SESSION["Empresa"]["id"];

		$sonda->select_($id_e,$id_test);
		$date_0 = date_create($sonda->fecha);
		$date_1 = date_create(date('Y-m-d'));
		$nuevos_criterios = $sonda->getNuevosCriterios();
		
		$criterios_escala = $sonda->getCriteriosEscala();
		$rango_escala = '';
		$rango_inicio = '';
		$rango_fin = '';


		if (is_array($criterios_escala)) {
			$rango_inicio = $criterios_escala[1]['escala_valor'];
			foreach ($criterios_escala as $key => $value) {
				$rango_fin = $criterios_escala[$key]['escala_valor'];
			}

			$rango_escala = $rango_inicio . ' a ' . $rango_fin;
		}

		if($sonda->getNuevosCriterios() == 0)
		{
			$rango_escala = '1 a 5';
			$rango_inicio = '1';
			$rango_fin = '5';
		}

		if ($date_1 > $date_0) {
			echo '<div class="alert alert-info" role="alert"><h4>La evaluación ha expirado</h4></div>';
		}else{
			if ($user_rol == 12) {
				$count = $sonda_respuesta->countUser_x_test($id_user);

				if ($count > 0) {
					echo '<div class="alert alert-info" role="alert"><h4>Muchas gracias por sus respuestas. Por favor Cierre Sesión (opción de la izquierda)</h4></div>';
				}else{
					echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
					echo "<h5>La Escala de Calificación des de 1 a 5, siendo 1 la respuesta menos favorable y 5 la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo izquierdo de la escala de calificación.</h5>";
					echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</h5>";
					echo "<br>";
					echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
				}
			}else{
				echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
				echo "<h5>La Escala de Calificación desde ".$rango_escala.", siendo ".$rango_inicio." la respuesta menos favorable y ".$rango_fin." la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo izquierdo de la escala de calificación.</h5>";
				echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</h5>";
				echo "<br>";
				echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
			}
		}
	}elseif ($user_rol == 13 || $user_rol == 14 || $user_rol == 15) {
		$sonda = new Evaluacion_desempenio();
		$sonda_respuesta = new Evaluacion_respuesta();
		$sonda->setId_empresa($_SESSION['Empresa']['id']);
		$sonda->test_x_user($id_user);
		$id_test = $sonda->getId();
		$id_e = $_SESSION["Empresa"]["id"];

		$sonda->select_($id_e,$id_test);
		$date_0 = date_create($sonda->fecha);
		$date_1 = date_create(date('Y-m-d'));
		
		$criterios_escala = $sonda->getCriteriosEscala();
		$rango_escala = '';
		$rango_inicio = '';
		$rango_fin = '';


		if (is_array($criterios_escala)) {
			$rango_inicio = $criterios_escala[0]['escala_valor'];
			foreach ($criterios_escala as $key => $value) {
				$rango_fin = $criterios_escala[$key]['escala_valor'];
			}

			$rango_escala = $rango_inicio . ' a ' . $rango_fin;
		}

		if ($date_1 > $date_0) {
			echo '<div class="alert alert-info" role="alert"><h4>La evaluación ha expirado</h4></div>';
		}else{
			if ($user_rol == 15) {
				$count = $sonda_respuesta->countUser_x_test($id_user);

				if ($count > 0) {
					echo '<div class="alert alert-info" role="alert"><h4>Muchas gracias por sus respuestas. Por favor Cierre Sesión (opción de la izquierda)</h4></div>';
				}else{
					echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
					echo "<h5>La Escala de Calificación des de 1 a 5, siendo 1 la respuesta menos favorable y 5 la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo izquierdo de la escala de calificación.</h5>";
					echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</h5>";
					echo "<br>";
					echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
				}
			}else{
				echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
				echo "<h5>La Escala de Calificación desde ".$rango_escala.", siendo ".$rango_inicio." la respuesta menos favorable y ".$rango_fin." la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo izquierdo de la escala de calificación.</h5>";
				echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</h5>";
				echo "<br>";
				echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
			}
		}
	}
?>