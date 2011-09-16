<?php
/**
 * @package WordPress
 * @subpackage RawApps iPhone Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php wp_title('&laquo;', true, 'right'); ?><?php echo get_option('rt_appname'); ?></title>

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php wp_head(); ?>

	
</head>

<body <?php body_class(); ?>>


<div id="content">
<div class="center_container layout_<?php echo get_option("rt_apporient");?>">
	<div class="content_left">
		<div class="header">
				
				
			<?php if( get_option('rt_bannerenable') != 'image'){ ?>
				<a title="<?php echo get_option('rt_bannertext'); ?>" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php echo get_option('rt_bannertext'); ?></a>
			<?php }else{ ?>
				<a title="<?php echo get_option('rt_bannertext'); ?>" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php rt_render_banner()?></a>
			<?php } ?>
		</div>
		<div class="nav">
			
		<div class="menu">
			<ul>
			<li>
				<a title="Home" href="<?php bloginfo('url'); ?>">Home</a>
			</li>
			<?php 
			  $pages = get_pages(); 
			  $count = 0;
			  foreach ($pages as $pagg) {
				if($count == 3){				
					echo '</ul>';
					echo '</div>';
					echo '<div class="more"><ul><li class="last">+<ul class="menu">';
				}
				echo '<li class="page_item page-item-'.$pagg->ID.'">';
				echo '<a title="'.$pagg->post_title.'" href="'.get_page_link($pagg->ID).'">'.$pagg->post_title.'</a>';
				echo '</a>';				
				echo '</li>';


				$count = $count +1;
				
			  }
			  if($count > 3){				
					echo '</ul>';
					echo '</li>';
			  }

			?>
			<div style="clear:both;height:0px;"><!----></div>
			</ul>
		</div>	
			
			


			
			
		</div>


<!-- end header -->
