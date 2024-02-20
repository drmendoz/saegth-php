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

		if ($date_1 > $date_0) {
			echo '<div class="alert alert-info" role="alert"><h4>La evaluación ha expirado</h4></div>';
		}else{
			if ($user_rol == 8) {
				$count = $sonda_respuesta->countUser_x_test($id_user);

				if ($count > 0) {
					echo '<div class="alert alert-info" role="alert"><h4>Muchas gracias por sus respuestas. Por favor Cierre Sesión (opción de la izquierda)</h4></div>';
				}else{
					echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
					echo "<h5>La Escala de Calificación des de 1 a 5, siendo 1 la respuesta menos favorable y 5 la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo derecho de la escala de calificación.</h5>";
					echo "<h5>Su Anotimato y Confidencialidad de las respuestas están garantizadas a pesar de que la primera parte del cuestionario le pide indicar alguna información organizacional, lo cual cumple el exclusivo propósito de poder estratificar y segmentar los resultados según esos criterios demográficos y así ayudar a los clientes a tomar mejores acciones correctivas sobre su Clima Organizacional.  Gracias anticipadas por su dedicación y confianza.</h5>";
					echo "<br>";
					echo '<a class="btn btn-info btn-block" href="'.BASEURL.'temp/evaluacion">Abrir Cuestionario</a>';
				}
			}else{
				echo "<h5>Es imprescindible que responda con absoluta sinceridad y que sus respuestas se basen exclusivamente en su propia experiencia.  Encontrará más instrucciones una vez que haya ingresado su usuario y contraseña.  Este vínculo quedará desactivado una vez que haya respondiedo el cuestionario.</h5>";
				echo "<h5>La Escala de Calificación des de 1 a 5, siendo 1 la respuesta menos favorable y 5 la más favorable.  Si Usted no conoce lo suficiente como para responder de una u otra forma cualquiera de las preguntas, por favor haga click en la Opción 'No sé' que está al extremo derecho de la escala de calificación.</h5>";
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
	}
?>