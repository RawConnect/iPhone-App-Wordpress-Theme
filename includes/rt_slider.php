<?php
 

 
 
function rtslider_render_slider($args)
{	
    $existing = array();
	$existing = get_option('apptheme_screens');
	echo "<div id='slider' class='".get_option("apptheme_apporient")."'><ul>";
	foreach ($existing as $value) {
		if (!$value['error']){
			echo "<li><img src='{$value['url']}' /></li";
		}
	}
	echo "</ul></div>";
}



?>
