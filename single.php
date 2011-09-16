<?php
/**
 * @package WordPress
 * @subpackage RawApps iPhone Theme
 */
get_header();
?>
		<div class="content_appicon"><?php rt_render_appicon()?></div>

		<div class="content_body">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<h2 class="contains">
				<?php the_title(); ?><span class="highlight"><?php the_title(); ?></span>
			</h2>		
			<div style="clear:both;height:0px;"><!----></div>

			<div class="description">
			
			<?php the_content(__('(more...)')); ?>
			
			
			</div>
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
		</div>
		<div style="clear:both;height:0px;"><!----></div>
		
	</div>






<?php get_footer(); ?>
