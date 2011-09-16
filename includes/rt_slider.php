<?php
function rtslider_render_slider($args)
{	
    $existing = array();
	$existing = get_option('apptheme_screens');
	echo "<div id='slider' class='".get_option("apptheme_apporient")."'>";
	if (!empty($existing)) {
		foreach ($existing as $value) {
			if (!$value['error']){
				echo "<img src='{$value['url']}'  class=active/>";
			}
		}
	}
	echo "</div>";
}
?>