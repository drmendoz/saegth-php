/**

 * Projet Name : Dynamic Form Processing with PHP

 * URL: http://techstream.org/Web-Development/PHP/Dynamic-Form-Processing-with-PHP

 *

 * Licensed under the MIT license.

 * http://www.opensource.org/licenses/mit-license.php

 * 

 * Copyright 2013, Tech Stream

 * http://techstream.org

 */





 var base_url = window.location.origin;

 if(base_url.search('localhost')!=-1	)

 	base_url += '/aldes';

 var BASEURL = base_url;

 var AJAX = base_url+'/ajax/';

 var URLIMG = base_url+'/public/img/';



 function addRow(tableID, args) {

 	var table = document.getElementById(tableID);

 	var rowCount = table.rows.length;

 	args = args || false;

 	if (true) {

 		var e = 0;

 		if (tableID == "scorer") {

 			e = rowCount - 4;

 		} else {

 			e = rowCount;

 		} 

 		var row = table.insertRow(e);

 		var colCount = table.rows[1].cells.length;

 		for (var i = 0; i < colCount; i++) {

 			var newcell = row.insertCell(i);

 			if (i == 0 && args) {

 				newcell.innerHTML = table.rows[1].cells[i].innerHTML + rowCount;

 			} else {

 				newcell.innerHTML = table.rows[1].cells[i].innerHTML;

 			}

 			var element = jQuery(newcell).find('input');

 			element.removeAttr('value');

 			if (element.hasClass('nivel-area')) {

 				element.val(jQuery(newcell).parent().siblings().children().children('input.nivel-area').val());

 			}

 			if (element.hasClass('lc_chk')) {

 				var result = jQuery(newcell).parent().siblings().children().children('input.lc_chk').val().split(',');

 				result = result[0] + ',0';

 				element.val(result);

 			}

 			if (element.hasClass('id_chk')) {

 				element.val(jQuery(newcell).parent().siblings().children().children('input.id_chk').val());

 			}

 			if (element.hasClass('p_chk')) {

 				var i = counter();

 				element.val(i);

 				element.attr("name", i);

 			}

 			if (element.hasClass('input_date')) {

 				$('.input_date').datepicker({

 					setDate: new Date(),

 					changeMonth: true,

 					changeYear: true,

 					yearRange: "1960:2015"

 				});

 			}



 			var counter = jQuery(newcell).children('p.counter');

 			if (counter.length) {

 				newcell.innerHTML = "<p class='counter'>" + rowCount + "</p>";

 			}

 			var element = jQuery(newcell).find('textarea');

 			if (element.size()) {

 				element.empty();

 			}

 		}

 		if (tableID != "scorer") {

 			var foc = jQuery(row).find('input').last();

 		} else {

 			var foc = jQuery(row).find('textarea').first();

 		}

 		foc.focus();

 		if (args) {

 			var cell_ = $.find('p.counter');

 			$.each(cell_, function(index, value) {

 				jQuery(value).empty();

 				index++;

 				jQuery(value).context.innerText = index.toString();

 			});

 		}

 		//$().toastmessage('showNoticeToast', 'Se ha agregado una fila');

 	} else {

 		alert("Maximum Passenger per ticket is 5.");

 	}

 }





 function makeCounter() {

 	var count = 0;

 	return function() {

 		count++;

 		return count;

 	};

 };



 var counter = makeCounter();



 function deleteRow(tableID) {

 	var table = document.getElementById(tableID);

 	var rowCount = table.rows.length;

	if ((rowCount - 1) <= 1) { // limit the user from removing all the fields

		alert("Debe existir por lo menos un campo");

	} else {

		table.deleteRow(rowCount - 1);



		$().toastmessage('showNoticeToast', 'Se ha eliminado una fila');

	}

}



function _deleteRow(tableID, obj) {

	console.log(tableID);

	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	if ((rowCount - 1) <= 1) { // limit the user from removing all the fields

		alert("Debe existir por lo menos una fila");

	} else {

		table.deleteRow(obj.parentNode.parentNode.rowIndex);



		$().toastmessage('showNoticeToast', 'Se ha eliminado una fila');

	}



	var cell_ = $.find('p.counter');

	$.each(cell_, function(index, value) {

		jQuery(value).empty();

		index++;

		jQuery(value).context.innerText = index.toString();

	});

}



function _deleteRow_(tableID, obj) {

	console.log(tableID);

	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	if ((rowCount) <= 3) { // limit the user from removing all the fields

		alert("Debe existir por lo menos una fila");

	} else {

		table.deleteRow(obj.parentNode.parentNode.rowIndex);



		$().toastmessage('showNoticeToast', 'Se ha eliminado una fila');

	}

}



function notification(){

	$.get(AJAX + "notification", function(data) {

		var x = JSON.parse(data)

		x.directo = parseInt(x.directo) 

		x.indirecto = parseInt(x.indirecto)		 

		x.pendiente = parseInt(x.pendiente)		 

		x.pendientes_general = parseInt(x.pendientes_general)		 

		//
		if(x.directo || x.indirecto || x.pendientes_general){

			$('#sp_compass').empty().append('<i style="color: red; font-size: 20px; margin-left: 10px;" class="fa fa-bell-o"></i>')

		}else{	

			$('#sp_compass').empty()

		}
		//

		$('#navbar_directo').empty()

		if(x.directo){

			$('#navbar_directo').append(x.directo)

		}

		$('#navbar_indirecto').empty()

		if(x.indirecto){

			$('#navbar_indirecto').append(x.indirecto)

		}

		

		if(x.indirecto || x.directo){

			$('#navbar_aprovacion').empty().append('<i class="fa fa-flag"></i>')

		}else{	

			$('#navbar_aprovacion').empty()

		}



		$('#navbar_pendiente').empty()

		if(x.pendiente){

			$('#navbar_pendiente').append(x.pendiente)

		}



	});

}



$(document).ready(function() {



	var url = window.location.href



	$('#status').fadeOut();

	notification()

	$('#preloader').delay(350).fadeOut('slow',function(){$(this).addClass('preloader_').empty()}); // will fade out the white DIV that covers the website.

	$('body').delay(350).css({

		'overflow': 'visible'

	});



	var el = $('a[href="'+url+'"]')

	if(el){

		el.addClass('active').parents('ul.dropdown-menu').siblings('a.dropdown-toggle').addClass('active-parent active')

		$('.dropdown-toggle.active').dropdown("toggle");

	}



	setInterval(function(){ 

		notification()

	}, 10000);



	$('.compass_empresa').click(function(event) {

		var holder = 'compass_empresa';

		var campo = $(this).parent().siblings('.campo').children('input').val();

		var chkd;

		if ($(this).is(':checked')) {

			chkd = 1;

		} else {

			chkd = 0;

		}

		$.post(AJAX + holder, {

			id: $(this).val(),

			valor: chkd,

			campo: campo,

		}, function(response) {



			setTimeout("_finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});

	});



	$('.eval_revi').click(function(event) {

		var holder = 'eval_revi';

		var campo = $(this).parent().siblings('.campo').children('input').val();

		var chkd;

		if ($(this).is(':checked')) {

			chkd = 1;

		} else {

			chkd = 0;

		}

		$.post(AJAX + holder, {

			id: $(this).val(),

			valor: chkd,

			campo: campo,

		}, function(response) {

			$('#bloqueo').val(response);

			if(response==1)

				$($('#revision textarea')).attr('readonly', true);

			else

				$($('#revision textarea')).attr('readonly', false);

		});

	});



	$('.compass_personal').click(function(event) {

		var holder = 'compass_personal';

		var campo = $(this).parent().siblings('.campo').children('input').val();

		var chkd;

		if ($(this).is(':checked')) {

			chkd = 1;

		} else {

			chkd = 0;

		}

		$.post(AJAX + holder, {

			id: $(this).val(),

			valor: chkd,

			campo: campo,

		}, function(response) {

			console.log(response)

			setTimeout("_finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});

	});



	$('.scorer_estado').click(function(event) {

		var holder = 'scorer_estado';

		var campo = $(this).parent().siblings('.campo').children('input').val();

		var chkd;

		if ($(this).is(':checked')) {

			chkd = 1;

		} else {

			chkd = 0;

		}

		$.post(AJAX + holder, {

			id: $(this).val(),

			valor: chkd,

			campo: campo,

		}, function(response) {



			setTimeout("_finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});

	});



	bg_color("oportunidades");

	bg_color("fortalezas");



	$('#terminar').click(function(event) {

		//event.preventDefault();

		var all = $('input:radio').size();

		for (var i = 0; i <= all; i++) {

			$($('input[name="' + i + '_multi"]')).attr('required', true);

		};

		$($('textarea')).attr('required', true);

	});



	$('#guardar').click(function(event) {

		//event.preventDefault();

		var all = $('input:radio').size();

		for (var i = 0; i <= all; i++) {

			$($('input[name="' + i + '_multi"]')).attr('required', false);

		};

	});



	$('div.radio.hid-s').click(function(event) {

		$(".hid-sel").hide();

		$(this).parent().siblings().slideDown("slow").stop();

		event.stopPropagation();

	});



	$('#hijos').click(function(event) {

		$(".hid-sel").hide();

		$(this).parent().siblings().slideDown("slow").stop();

		event.stopPropagation();

	});



	$('#b_hijos').click(function(event) {

		$("#hijos").slideToggle("slow");

		if ($("#b_hijos").prop('checked')) {

			$("#hijos").find('input').attr("required", true);

		} else {

			$("#hijos").find('input').attr("required", false);

		}

		event.stopPropagation();

	});





	jQuery("input[name='pd_ci']").blur(function() {

		var value = $(this).val();

		if (!validCi(value) == value.length > 4) {

			jQuery(this).addClass("Red");

			alert("Por favor corrija el número de cédula.")

			jQuery(this).focus().select();

		} else {

			jQuery(this).removeClass("Red");

		}

	});



	$('#ps').click(function(event) {

		console.log('yo');

		$(this).parent().append('<img src="' + URLIMG + 'loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" />');

		var personal = $(this).parent().siblings().children('input#search').val();

		var exclude = $(this).parent().siblings().children('input#exc').val();

		var id_input = ($('#mode').val() == 'edit') ? 'id_per_edit' : 'id_per';

		var holder = 'personal_search';





		if ($('.errmsg')) {

			$('.errmsg').remove();

		}

		$('#holder').children().last().children().children().fadeOut("slow");

		$.post(AJAX + holder, {

			holder: holder,

			personal: personal,

			exclude: exclude,

			id_input : id_input

		}, function(response) {



			setTimeout("p_finishAjax('holder', '" + escape(response) + "')", 400);

		});

		//$('#loader').remove();

		return false;

	});



	$('.area-select').click(function(event) {

		var link = $(this).attr("href");

		link = link.replace('#', '');

		$('#area-select').val(link);





		$(this).append('<img src="' + URLIMG + 'loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" />');

		//

		var holder = $(this).parentsUntil('fieldset').parent().parent().attr('id');

		var table = $(this).parentsUntil('fieldset').parent().siblings().children('input.table_name').val();



		$(this).parentsUntil(holder).find('.holder').fadeOut("slow");

		$(this).parentsUntil(holder).find('.holder').remove();



		$.post(AJAX + holder, {

			table_name: table,

			id: link,

			holder: holder,

		}, function(response) {



			setTimeout("finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});



		return false;

	});



	$('.cargo-select').livequery('change', function() {



		$(this).append('<img src="' + URLIMG + 'loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" />');

		//

		var holder = $(this).parentsUntil('form').parent().children().children('div').attr('id');

		var table = $(this).parentsUntil('form').parent().children().children('input.table_name').val();

		var j = $(this).parent().siblings().children('input.step').val();

		step = j.split(",");





		$(this).parentsUntil(holder).find('.holder').fadeOut("slow");

		$(this).parentsUntil(holder).find('.holder').remove();

		$.post(AJAX + holder, {

			table_name: table,

			emp_id: step[1],

			per_id: step[0],

			cargo_id: $(this).val(),

			holder: holder,

		}, function(response) {



			setTimeout("_finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});



		return false;

	});



	$('#hijos').click(function(event) {

		$(".hid-sel").hide();

		$(this).parent().siblings().slideDown("slow").stop();

		event.stopPropagation();

	});



	$('.empresa-select').livequery('change', function() {



		var holder = $(this).parentsUntil('form').parent().children().attr('id');

		var table = $(this).parentsUntil('form').parent().children().children('input.table_name').val();

		$('#' + holder + ' fieldset').append('<img src="' + URLIMG + 'ajax-loader.gif" class="center-block" style="margin-top: 17px;" id="loader" alt="" />');



		$(this).parentsUntil(holder).find('.holder').fadeOut("slow");

		$(this).parentsUntil(holder).find('.holder').remove();

		$.post(AJAX + holder, {

			table_name: table,

			emp_id: $(this).val(),

			holder: holder,

		}, function(response) {



			setTimeout("finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});

		return false;

	});



	$('.test-select').livequery('change', function() {





		var holder = $(this).parentsUntil('.stop').parent().children().attr('id');

		var table = $(this).parentsUntil('.stop').parent().children().children('input.table_name').val();

		$(this).append('<img src="' + URLIMG + 'loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" />');

		//



		$(this).parentsUntil(holder).find('.holder').fadeOut("slow");

		$(this).parentsUntil(holder).find('.holder').remove();

		$.post(AJAX + holder, {

			table_name: table,

			emp_id: $(this).val(),

			holder: holder,

		}, function(response) {



			setTimeout("finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});



		return false;

	});



	$('.cargo-selectr').livequery('change', function() {



		$(this).append('<img src="' + URLIMG + 'loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" />');

		//

		var holder = $(this).parentsUntil('.stop').parent().children().attr('id');

		var table = $(this).parentsUntil('.stop').parent().children().children('input.table_name').val();

		$(this).parent().parent().nextAll().remove();



		$.post(AJAX + holder, {

			table_name: table,

			crg_id: $(this).val(),

			holder: holder,

		}, function(response) {

			setTimeout("finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});



		return false;

	});



	$('.parent').livequery('change', function() {



		$(this).parent().parent().nextAll().remove();



		$(this).append('<img src="' + URLIMG + 'loader.gif" style="float:left; margin-top:7px;" id="loader" alt="" />');



		var holder = $(this).parent().parent().parent().parent().attr('id');

		var table = $(this).parent().parent().parent().siblings().children('input.table_name').val();

		var step = $(this).parent().siblings().children('input.step').val();





		$.post(AJAX + holder, {

			table_name: table,

			parent_id: $(this).val(),

			name: $(this).attr('name'),

			holder: holder,

			step: step,

		}, function(response) {



			setTimeout("finishAjax('" + holder + "', '" + escape(response) + "')", 400);

		});



		return false;

	});



	var textbox = '#ThousandSeperator_commas';

	var hidden = '#ThousandSeperator_num';

	$(textbox).keyup(function() {

		var num = $(textbox).val();

		var comma = /,/g;

		num = num.replace(comma, '');

		$(hidden).val(num);

		var numCommas = addCommas(num);

		$(textbox).val(numCommas);

	});

});

/* SECRET */





function addCommas(nStr) {

	nStr += '';

	var comma = /,/g;

	nStr = nStr.replace(comma, '');

	x = nStr.split('.');

	x1 = x[0];

	x2 = x.length > 1 ? '.' + x[1] : '';

	var rgx = /(\d+)(\d{3})/;

	while (rgx.test(x1)) {

		x1 = x1.replace(rgx, '$1' + ',' + '$2');

	}

	return x1 + x2;

}



function _finishAjax(id, response) {

	$('#loader').remove();



	$('#' + id + '').closest('fieldset').append(unescape(response)).hide().fadeIn('slow');

}



function p_finishAjax(id, response) {

	$('#loader').remove();



	$('#' + id + '').children().last().children().append(unescape(response)).hide().fadeIn('slow');

}



function finishAjax(id, response) {

	$('#loader').remove();



	$('#' + id + ' fieldset').append(unescape(response)).hide().fadeIn('slow');

}



function ini_ub() {



	var lat = $(document.getElementById('longlat')).val();

	if (lat != undefined){



		lat = lat.split(',');

		var Gye = new google.maps.LatLng(parseFloat(lat[0]), parseFloat(lat[1]));

		var map = new google.maps.Map(document.getElementById('map-canvas'), {

			mapTypeId: google.maps.MapTypeId.ROADMAP,

			zoom: 12,

			center: Gye,

		});

		map.setOptions({

			draggable: false,

			zoomControl: false, 

			scrollwheel: false, 

			disableDoubleClickZoom: true

		});

		markers = [];

		placeMarker(Gye, map);

		var dir = [];

		$.get(

			"http://maps.googleapis.com/maps/api/geocode/json?latlng=" + parseFloat(lat[0]) + ',' + parseFloat(lat[1]) + "&components=administrative_area|country&sensor=true"

			).done(function(data) {

				data = data.results;

				$.each(data[0]['address_components'], function(index, value) {

					if ((value['types'][0] == 'country') || (value['types'][0] == 'locality')) {

						dir.push(value['long_name']);

					}

				});

				var ciudad = $(document.getElementById('ciudad'));

				var pais = $(document.getElementById('pais'));

				var local = $(document.getElementById('localidad'));

				ciudad.html(dir[0]);

				pais.html(dir[1]);

				local.html(dir[0] + " - " + dir[1]);

			});

		}

	}



	function initialize(coord) {

		var cord = coord || {

			'lat': -2.1685562,

			'lng': -79.9279774

		};

		var Gye = new google.maps.LatLng(parseFloat(cord.lat), parseFloat(cord.lng));

		var map = new google.maps.Map(document.getElementById('map-canvas'), {

			mapTypeId: google.maps.MapTypeId.ROADMAP,

			zoom: 12,

			center: Gye,

		});

		markers = [];

	/*

	var defaultBounds = new google.maps.LatLngBounds(

	new google.maps.LatLng(-2.173701, -80.0784229),

	new google.maps.LatLng(-2.2499566, -79.9805052));

	map.fitBounds(defaultBounds);

	*/





	// Create the search box and link it to the UI element.

	var input = /** @type {HTMLInputElement} */ (

		document.getElementById('pac-input'));

	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



	var searchBox = new google.maps.places.SearchBox(

		/** @type {HTMLInputElement} */

		(input));



	// Listen for the event fired when the user selects an item from the

	// pick list. Retrieve the matching places for that item.

	google.maps.event.addListener(searchBox, 'places_changed', function() {

		var places = searchBox.getPlaces();



		var bounds = new google.maps.LatLngBounds();



		for (var i = 0, place; place = places[i]; i++) {

			var image = {

				url: place.icon,

				size: new google.maps.Size(25, 25),

				origin: new google.maps.Point(0, 0),

				anchor: new google.maps.Point(17, 34),

				scaledSize: new google.maps.Size(12, 12)

			};



			bounds.extend(place.geometry.location);

		}



		map.fitBounds(bounds);

		var listener = google.maps.event.addListener(map, "idle", function() {

			if (map.getZoom() > 16) map.setZoom(16);

			google.maps.event.removeListener(listener);

		});

	});



	// Bias the SearchBox results towards places that are within the bounds of the

	// current map's viewport.

	google.maps.event.addListener(map, 'bounds_changed', function() {

		var bounds = map.getBounds();

		searchBox.setBounds(bounds);

	});



	google.maps.event.addListener(map, 'click', function(event) {

		placeMarker(event.latLng, map);

	});



	placeMarker(Gye, map);

}



function placeMarker(location, map) {

	clearMarkers();

	var marker = new google.maps.Marker({

		position: location,

		map: map

	});

	markers.push(marker);

	$('#u_googlemaps').val(location);

	/*

	var infowindow = new google.maps.InfoWindow({

	content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()

	});

	infowindow.open(map,marker);

	*/

}



function setAllMap(map) {

	for (var i = 0; i < markers.length; i++) {

		markers[i].setMap(map);

	}

}



function clearMarkers() {

	setAllMap(null);

}







function validCi(value) {

	var isValid = true;



	var valstr = value.toString();



	if (!(jQuery.isNumeric(value)) && (value != '')) {

		//alert("Ingresar valores numericos");

		isValid = false;

	} else {

		var imp = 0;

		var par = 0;



		for (var i = 0; i < 9; i++) {

			var n = parseInt(valstr[i], 10);

			if (((i % 2) != 0)) {

				par += n;

			} else {

				n = n * 2;

				if (n > 9) {

					n = n - 9;

				}

				imp += n;

			}

			var sum = imp + par;

		}



		var dec = ((parseInt(sum / 10)) + 1) * 10;



		var val = dec - sum;



		if (val == 10) {

			val = 0;

		}



		if (valstr.length == 10) {

			if (!(val == parseInt(valstr[9], 10))) {

				//alert("Numero de cedula invalido")

				isValid = false;

			}

		} else {

			if ((parseInt(valstr[10], 10) != 0) || (parseInt(valstr[11], 10) != 0) || (parseInt(valstr[12], 10) != 1)) {

				//alert("Ruc invalido")

				isValid = false;

			}

		}

	}

	return isValid;

}



function bg_color(id) {

	var sig = document.getElementById(id);

	var colors = ['#00CC00', '#00CC99', '#0099CC', '#C266E0', '#FF6600', '#CCFFFF', '#FFFF00', '#FF9933', '#FF99CC', '#99FF99', '#33CCFF', '#669999', '#CC33FF'];

	if (sig) {

		var inp = $(sig).find('input');

		var values = [];

		var repeated_values = [];

		$.each(inp, function(index, value) {

			if ($.inArray($(value).val(), values) != -1) {

				repeated_values.push($(value).val())

			} else {

				values.push($(value).val());

			}

		});

		var c = 0;

		$.each(repeated_values, function(index, value) {

			for (var i = inp.length - 1; i >= 0; i--) {

				if (($(inp[i]).val()) == value) {

					$(inp[i]).parent().css('background-color', colors[c]);

				}

			};

			c++;

		});

	}

}





function stuff(obj) {

	value = $(obj).val();

	if (value == 100) {

		$('.peso').val("0");

		$(obj).val("100");

	}

	if (isNaN(value) || value >= 101) {

		setError();

	} else {

		removeError();

	}

	getPeso();

}



function setError(elem) {

	elem = elem || this;

	$(elem).css("border", "red solid 1px");

	$(elem).addClass("bg-danger");

}



function removeError(elem) {

	elem = elem || this;

	$(elem).css("border", "1px solid #ccc");

	$(elem).removeClass("bg-danger");

}



function p_scorecard(ajuste) {

	var aj = ajuste || 0;

	var holder = 'p_scorecard';

	var id = $('#id').val();

	var spon = parseFloat($('#sum_ponderado').val());

	if (aj != 0)

		spon += spon * (aj / 100);

	var val = spon;

	$('#p_ajustado').val(val);

	$.post(AJAX + holder, {

		id: id,

		val: val,

	}, function(response) {

		$('#p_scorecard').val(response);

	});

	return false;

}



function getPeso() {

	var elems = $('.peso');

	var sum = 0;

	for (var i = 0; i < elems.length; i++) {

		sum += parseInt($(elems[i]).val());

	}

	var total = document.getElementById('sum_peso');

	total.value = sum;

	if (sum != 100) {

		setError(total);

		$(total).css("color", "red");

	} else if (!isNaN(sum)) {

		$(total).css("color", "black");

		removeError(total);

	} else {

		total.value = "NaN";

	}

}





function getPpond(obj) {

	var peso = $(obj).parent().parent().parent().children('td').children('div').children('.peso');

	var ponderado = $(obj).parent().parent().parent().children('td').children('div').children('.l_pond');

	var peso_s = $(obj).parent().parent().parent().children('td').children('div').children('.peso');

	var ponderado_s = $(obj).parent().parent().parent().children('td').children('div').children('.l_pond');

	wval = $(peso).val();

	pval = $(ponderado).val();

	if (!isNaN(wval) && !isNaN(pval)) {

		removeError(obj);

		$(obj).val(wval * (pval / 100));

		getPsum();

	} else {

		setError(obj);

		$(obj).val("NaN");

	}

}





function getPsum() {

	var elems = $('.p_pond');

	var sum = 0;

	for (var i = 0; i < elems.length; i++) {

		sum += parseFloat($(elems[i]).val());

	}

	var total = document.getElementById('sum_ponderado');

	total.value = sum;

	if (isNaN(sum)) {

		setError(total);

		$(total).css("color", "red");

	} else if (!isNaN(sum)) {

		$(total).css("color", "black");

		removeError(total);

	} else {

		total.value = "NaN";

	}

}



function valMetas(obj) {

	var metas = $(obj).parent().parent().children('td').children('.meta');

	var metashow = $(obj).parent().parent().children('td').children('.meta');

	var $emptyFields = $(metas).filter(function() {

		return $.trim(this.value) === "";

	});

	removeError($(metashow));

	if (!$emptyFields.length) {

		var outs = [],

		L = metas.length,

		i = 0,

		prev, next;

		while (i < (L - 1)) {

			if (metas[i].type == "date") {

				prev = new Date($(metas[i]).val());

				next = new Date($(metas[++i]).val());

			} else {

				prev = parseInt($(metas[i]).val());

				next = parseInt($(metas[++i]).val());

			}

			if (next < prev) outs.push(i);

		}

		if (outs.length == (L - 1)) return 1;

		outs = [];

		i = 0;

		while (i < (L - 1)) {

			if (metas[i].type == "date") {

				prev = new Date($(metas[i]).val());

				next = new Date($(metas[++i]).val());

			} else {

				prev = parseInt($(metas[i]).val());

				next = parseInt($(metas[++i]).val());

			}

			if (next > prev) outs.push(i);

		}

		if (outs.length == (L - 1)) return 2;

		else {

			setError($(metashow));

			return 0;

		}

	}

	return 666;

}



function processReal(obj, inv) {

	var inverse = inv || valMetas(obj);

	var vinicial = parseInt($('#vinicial').val());

	var razon = parseInt($('#razon').val());

	var value = $(obj).parent().parent().children('td').children('.l_real').val();

	var metas = $(obj).parent().parent().children('td').children('.meta');

	var ponderado = $(obj).parent().parent().children('td').children('div').children('.l_pond');

	var ppond = $(obj).parent().parent().children('td').children('div').children('.p_pond');

	var und = $(obj).parent().parent().children('td').children('.und').val();

	var single=$('#col').val();

	if(single=="1"){

		inverse = parseInt($(obj).parent().parent().children('td').children('.inv').val());

	}





	if (und == 2) {

		value = new Date(value);

		var min = new Date($(metas[0]).val());

		var max = new Date($(metas[metas.length - 1]).val());

	} else {

		value = parseInt(value);

		var min = parseInt($(metas[0]).val());

		var max = parseInt($(metas[metas.length - 1]).val());

	}

	// console.log("Inverse "+inverse);

	removeError(ponderado);

	if(single != 1){

		if (inverse == 1) {

			for (var i = 0; i < metas.length; i++) {

				if (und == 2) {

					//console.log(value);

					var bot = new Date($(metas[i]).val());

					var top = new Date($(metas[i + 1]).val()) || max;

				} else {

					var bot = parseInt($(metas[i]).val());

					var top = parseInt($(metas[i + 1]).val()) || max;

					//console.log(value);

				}

				if ((value <= bot) && (value > top)) {

					var result = vinicial + (razon * i);

					ponderado.val(result);

				} else if (value > min) {

					// JPazmino - 17/11/2020
					//ponderado.val(0);
					
					ponderado.val(vinicial);

				} else if (value < max) {

					var result = vinicial + (razon * i);

					ponderado.val(result);

				} else if ((value == 0 && max == 0)) {

					var result = vinicial + (razon * i);

					ponderado.val(result);

				}

			}

		} else if (inverse == 2) {

			for (var i = 0; i < metas.length; i++) {

				if (und == 2) {

					//console.log(value);

					var bot = new Date($(metas[i]).val());

					var top = new Date($(metas[i + 1]).val()) || max;

				} else {

					//console.log(value);

					var bot = parseInt($(metas[i]).val());

					var top = parseInt($(metas[i + 1]).val()) || max;

				}

				if ((value >= bot) && (value < top)) {

					var result = vinicial + (razon * i);

					ponderado.val(result);

				} else if (value < min) {

					ponderado.val(0);

				} else if (value >= max) {

					var result = vinicial + (razon * i);

					ponderado.val(result);

				}

			}

		}

	}else{

		if (und == 2) {

			var met = new Date($(metas).val());

		} else {

			var met = parseInt($(metas).val());

		}



		if(inverse==1){

			var x = met*100/value;

		}else if(inverse==0){

			var x = value*100/met;

		}

		ponderado.val(x);

	}

	if (isNaN(value) || inverse == 666) {

		value = NaN;

		setError(ponderado);

		ponderado.val(value);

	}

	getPpond(ppond);

}



function ajaxmailer(tipo, id) {

	holder = "mailer"

	$.post(AJAX + holder, {

		tipo: tipo,

		id: id,

	}, function(response) {

		return response;

	});

}



function saveform(obj, alt) {

	alt = alt !== false;

	var $btn = $(obj).button('loading');

	var ajuste = $(document.getElementById('f_ajuste')).val();

	var periodo = $(document.getElementById('periodo')).val();
	var total = $(document.getElementById('total')).val();
	var sel_pa = $(document.getElementById('sel_pa')).val();
	var no_reg = $(document.getElementById('no_reg')).val();

	// if($('#scorer').find('input#sum_peso').hasClass('bg-danger')){

	//   event.preventDefault();

	//   alert("La suma porcentual de peso no puede sobre pasar a 100%");

	//   $btn.button('reset');

	//   return false;

	// }else{

		var rows = document.getElementById('scorer').rows;

		rows[0] = null;

		var obj = [],

		ind = [],

		und = [],

		meta = [],

		peso = [],

		lreal = [],

		lpond = [],

		ppond = [];

		inv = [];
		padre = [];
		padre_sup = [];
		idobj = [];
		var sel=0;

		for (var i = 1; i < (rows.length - 1); i++) {

			obj[i - 1] = $($(rows[i]).find('.obj')).val();

			ind[i - 1] = $($(rows[i]).find('.ind')).val();

			und[i - 1] = $($(rows[i]).find('.und')).val();

			peso[i - 1] = $(rows[i]).find('.peso').val();

			lreal[i - 1] = $(rows[i]).find('.l_real').val();

			lpond[i - 1] = $(rows[i]).find('.l_pond').val();

			ppond[i - 1] = $(rows[i]).find('.p_pond').val();

			inv[i - 1] = $(rows[i]).find('.inv').val();

			var metas = $(rows[i]).find('.meta');

			meta[i - 1] = [];
			    padre[i - 1] = $(rows[i]).find('.padre').val();
			 padre_sup[i - 1] = $(rows[i]).find('.padre_sup').val();
			 idobj[i - 1] = $(rows[i]).find('.idobj').val();
			 
			 if ($(rows[i]).find('.sel').attr('checked'))
			{
			  sel = i;
			  
			}

			for (var e = 0; e < metas.length; e++) {

				meta[i - 1][e] = $(metas[e]).val();

			}

		}

		/*AJAX*/

		var holder = 'scorer_obj';

		var id = $('#id').val();

		$.post(AJAX + holder, {

			id: id,

			guardar: true,

			obj: obj,

			ind: ind,

			und: und,

			meta: meta,

			peso: peso,

			lreal: lreal,

			lpond: lpond,

			ppond: ppond,

			alt: alt,

			inv: inv,

			ajuste: ajuste,

			periodo: periodo,
			padre: padre,
			padre_sup: padre_sup,
			sel: sel,
			total: total,
			sel_pa: sel_pa,
			no_reg: no_reg,
			idobj: idobj,

		}, function(response) {

			$btn.button('reset');

			if(response.trim()=="1")

				$().toastmessage('showSuccessToast', "Se ha guardado con éxito");

			else

				//$().toastmessage('showErrorToast', "Ocurrio un error<br> vuelva a intentarlo");
				$().toastmessage('showSuccessToast', "Se ha guardado con éxito");






			if (alt)

				alert('Se han guardado los datos con éxito.');

		});

		return true;

	// }

}



function saveeval(obj, alt) {

	alt = alt !== false;

	var $btn = $(obj).button('loading');

	if(alt){

		var reval = 0;

		var tab1 = 'revision_emp';

		var tab2 = 'revision_eval';

	}else{

		var reval = 1;

		var tab1 = 'evaluacion_emp';

		var tab2 = 'evaluacion_eval';

	}



	var cmn=[];

	var cmn_evaluador=[];

	var cmn_fecha=[];

	var cmn_evaluador_fecha=[];

	var empleado=$("#"+tab1).find('.empleado');

	var fecha_empleado=$("#"+tab1).find('.fecha_empleado');

	$.each(empleado,function(index,value){

		cmn[index]=$(value).val();

		cmn_fecha[index]=$($(fecha_empleado)[index]).val();

	});

	var evaluador=$("#"+tab2).find('.evaluador');

	var fecha_evaluador=$("#"+tab2).find('.fecha_evaluador');

	$.each(evaluador,function(index,value){

		cmn_evaluador[index]=$(value).val();

		cmn_evaluador_fecha[index]=$($(fecha_evaluador)[index]).val();

	});

	/*AJAX*/

	var holder = 'revision_save';

	var id = $('#id').val();

	

	console.log($('#fecha2').val());



	$.post(AJAX + holder, {

		id: id,

		periodo: $('#fecha2').val(),

		comentario:cmn,

		com_e:cmn_evaluador,

		cmn_fecha: cmn_fecha,

		cmn_evaluador_fecha: cmn_evaluador_fecha,

		tipo:reval,

	}, function(response) {

		$btn.button('reset');

		$().toastmessage('showSuccessToast', "Se ha guardado con éxito");

		$('#response').empty();

		console.log(response);

		// ajaxmailer((reval+3),id);

	});

	return true;

}



function inDate(obj) {

	if ($(obj).val() == 2) {

		var metas = $(obj).parent().parent().children('td').children('.meta');

		$.each(metas, function(index, value) {

			value.setAttribute("type", "date");

		});

		var lreal = $(obj).parent().parent().children('td').children('.l_real');

		$.each(lreal, function(index, value) {

			value.setAttribute("type", "date");

		});

	} else {

		var metas = $(obj).parent().parent().children('td').children('.meta');

		$.each(metas, function(index, value) {

			value.setAttribute("type", "text");

		});

		var lreal = $(obj).parent().parent().children('td').children('.l_real');

		$.each(lreal, function(index, value) {

			value.setAttribute("type", "text");

		});

	}

}





$('#scorer').on('change', '.und', function() {

	inDate(this);

});



$('#scorer').on('keyup', '.peso', function() {

	stuff(this);

	processReal($(this).parent());



	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('keyup', '.l_real', function() {

	processReal(this);



	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('change', '.peso', function() {

	stuff(this);

	processReal($(this).parent());

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('change', '.l_real', function() {

	processReal(this);

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('change', '.inv', function() {

	console.log("hey");

	processReal(this);

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('click', '.inv', function() {

	console.log("hey");

	processReal(this);

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('keyup', '.meta', function() {

	stuff($(this).parent().parent().children('td').children('div').children('.peso'));

	var metas = valMetas(this);

	processReal($(this).parent().parent().children('td').children('.l_real'), metas);

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('change', '.meta', function() {

	stuff($(this).parent().parent().children('td').children('div').children('.peso'));

	var metas = valMetas(this);

	processReal($(this).parent().parent().children('td').children('div').children('.l_real'), metas);

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('keyup', '#f_ajuste', function() {

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('change', '#f_ajuste', function() {

	var ajuste = document.getElementById('f_ajuste');

	if ($(ajuste).val() == "") $(ajuste).val(0);

	if (isNaN($(ajuste).val())) {

		setError(this);

	}

	p_scorecard($(ajuste).val());

});



$('#scorer').on('click', '.elim', function() {

	_deleteRow('scorer', this);

	getPeso();

	getPsum();

	p_scorecard();

});



$('#scorer').on('click', '.ag_plan', function() {

	event.preventDefault();

	var $btn = $(this).button('loading');

	var holder = "scorer_oportunidades";

	var holder2 = "agregar_plan";

	var id = $('#id').val();

	var objetivo = $(this).parent().parent().children('td').children('.obj').val();

	$.post(AJAX + holder2, {

		id_personal: id,

		objetivo:objetivo,

	}, function(data) {

		console.log(data);

		if(data){

			$().toastmessage('showNoticeToast', "Se ha agregado objetivo al plan de acción");

			$('#plan tbody').append(data);

		}

	});

});



$('#plan').on('click', '.addm', function() {

	addRow_plan('plan',this);

});



$('#plan').on('click', '.elim', function() {

	_deleteRow('plan',this);

	var uori = $(this).siblings().children('.uori').val();

	var id = $(this).siblings().children('.id').val();

	var evaluacion = $(this).siblings().children('.evaluacion').val();

	var holder = "eliminar_plan";

	console.log(uori);

	console.log(id);

	console.log(evaluacion);

	if(uori=="update"){

		$.post(AJAX + holder, {

			id: id,

			evaluacion:evaluacion,

		}, function(data) {

			// if(data==1)

			console.log(data);

				// $().toastmessage('showNoticeToast', "Se ha agregado objetivo al plan de acción");

			});		

	}

});



$('#esp_carrera').on('click', '.elim', function() {

	_deleteRow('esp_carrera',this);

});



function addRow_plan(tableID,obj) {

	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	var thisrow = $(obj).parent().parent().index();

	var row = table.insertRow();

	var colCount = table.rows[1].cells.length;

	for (var i = 0; i < colCount; i++) {

		var newcell = row.insertCell(i);

		newcell.innerHTML = table.rows[thisrow].cells[i].innerHTML;

	}

	$(newcell).parent().children().children('input,textarea,select').val("");

	$(newcell).parent().children().children().children('.uori').val("insert");

	$(newcell).parent().children().children().children('.uori').attr("value","insert");

	var foc = jQuery(row).find('textarea').first();

	foc.focus();



	$().toastmessage('showNoticeToast', 'Se ha agregado una fila');

}



function addRow_grado(tableID) {

	var table = document.getElementById(tableID);

	var rowCount = table.rows.length;

	// var thisrow = $(obj).parent().parent().index();

	var row = table.insertRow();

	var colCount = table.rows[1].cells.length;

	for (var i = 0; i < colCount; i++) {

		var newcell = row.insertCell(i);

		newcell.innerHTML = table.rows[1].cells[i].innerHTML;

	}

	$(newcell).parent().children().children('input[type="text"]').val("");

	$(newcell).parent().children().children().children('.uori').val("insert");

	$(newcell).parent().children().children().children('.uori').attr("value","insert");

	var foc = jQuery(row).find('input').first();

	foc.focus();



	$().toastmessage('showNoticeToast', 'Se ha agregado una fila');

}



var specialKeys = new Array();

specialKeys.push(8); //Backspace

function IsNumeric(e) {

	var keyCode = e.which ? e.which : e.keyCode

	var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);



	var fval = ret ? $(e.target).val().replace(/[^\0-9]/ig, "") : $(e.target).val();

	$(e.target).val(fval);

	return ret;

}



$('#scorer').on('keypress', 'input[type=text]', function() {



	IsNumeric(event);

});



$('#main').on('click', 'a.ajax_link', function() {

	event.preventDefault();

	var ref = this.href;

	var ref = ref.replace(base_url+"/", "");

	var main = ref.split('/');

	var holder = "page_load";

	var controller = main.shift();

	var action = main.shift();

	var args = main;

	console.log(ref);

	

	$('#preloader').css('display','block').append('<div style="position:absolute;left:50%;top:50%;color:white"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');

	$.post(AJAX + holder, {

		controller:controller,

		action:action,

		args:args,

	}, function(response) {

		$('#preloader').delay(50).css('display','none');

		$('#ajax-content').html(response).fadeIn(2000);

	});

});



$('#main').on('click', 'a.ajaxlink', function() {

	event.preventDefault();

	var ref = this.href;

	ref = ref.split('#');

	var main = ref[1].split('/');

	var id = main.shift();

	if(window.location.pathname.search("user/home")==-1){

		console.log(base_url+main);

		window.location.assign(base_url+"/"+main.join("/"));

	}else{

		var holder = "page_load";

		var controller = main.shift();

		var action = main.shift();

		var args = main;

		$('#preloader').css('display','block').append('<div style="position:absolute;left:50%;top:50%;color:white"><i class="fa fa-spinner fa-pulse fa-5x"></i></div>');

		$.post(AJAX + holder, {

			controller:controller,

			action:action,

			args:args,

		}, function(response) {

			$('#preloader').delay(50).css('display','none');

			$("#"+id).empty();

			$("#"+id).append(response).fadeIn(2000);

		});

	}

});





$('#main').on('click', 'a.ajaxlink_navbar', function() {

	event.preventDefault();

	var ref = this.href;

	ref = ref.split('#');

	var holder = "page_load";

	var main = ref[1].split('/');

	console.log($('#tabs a[href="#'+ main[1] +'"]').length);

	if(window.location.pathname.search("user/home")!=-1 && $('#tabs a[href="#'+ main[1] +'"]').length > 0){

		$('#tabs a[href="#'+ main[1] +'"]').tab('show');

	}else{

		window.location.assign(base_url+"/user/home/"+main[1]);

	}

});



$('#sidebar-left').on('click', '.denied', function() {

	alert('No tiene habilitada esta evaluación');

});



function loadAsync(src, callback, relative){

    // var baseUrl = new String(BASEURL);

    // baseUrl = baseUrl.toString()

    var script = document.createElement('script');

    if(relative === true){

        script.src = src;  

    }else{

        script.src = src; 

    }



    console.log(script.src)

    console.log(src)



    if(callback !== null){

        if (script.readyState) { // IE, incl. IE9

            script.onreadystatechange = function() {

                if (script.readyState == "loaded" || script.readyState == "complete") {

                    script.onreadystatechange = null;

                    callback();

                }

            };

        } else {

            script.onload = function() { // Other browsers

                callback();

            };

        }

    }

    document.getElementsByTagName('head')[0].appendChild(script);

}