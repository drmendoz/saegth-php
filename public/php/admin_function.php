<?php
function if_checked ($needle,$haystack){ 
	if(isset($haystack)){
		if (array_search($needle, $haystack)){
			echo 'checked="checked"';
		}
	}
}
?>