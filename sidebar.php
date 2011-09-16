<?php
/**
 * @package WordPress
 * @subpackage RawApps iPhone Theme
 */
?>

<div id="widgets">
	<div class="layout_<?php echo get_option("rt_apporient");?>">		
		<div class="widgets_left">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('rtwid_bottomleft') ) : ?>
				
			<?php endif; ?>
		</div>
		<div class="widgets_right">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('rtwid_bottomright') ) : ?>
			<?php endif; ?>
		</div>
		<div style="clear:both;height:0px;"><!----></div>
	</div>
</div>

