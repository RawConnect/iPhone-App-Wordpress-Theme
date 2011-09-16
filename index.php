<?php
/**
 * @package WordPress
 * @subpackage RawApps iPhone Theme
 */
get_header();
?>

		<div class="content_appicon"><?php rt_render_appicon()?></div>

		<div class="content_body">
			<h2 class="contains">
				<?php echo get_option('rt_appdescriptiontitle'); ?><span class="highlight"><?php echo get_option('rt_appdescriptiontitle'); ?></span>
			</h2>		
			<div style="clear:both;height:0px;"><!----></div>

			<div class="description"><?php echo get_option('rt_appdescription'); ?></div>
			<div class="meta">
				<div class="details">
					<div><span>Version:</span> <?php echo get_option('rt_appversion'); ?>  </div>     
					<div><span>Author:</span> <?php echo get_option('rt_authorname'); ?>     </div>    
					<div><span>Price:</span> <?php echo get_option('rt_appprice'); ?> </div>    
				</div>
				<div class="appstore">
					<a href="<?php echo get_option('rt_ituneslink'); ?>"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/rt_appstorelink.png"></a>
				</div>
				<div style="clear:both;height:0px;"><!----></div>
			</div>

		</div>
		<div style="clear:both;height:0px;"><!----></div>
		
	</div>









<?php get_footer(); ?>
