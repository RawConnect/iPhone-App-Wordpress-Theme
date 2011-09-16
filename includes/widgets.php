<?php
/**
 * @package WordPress
 * @subpackage RawApps iPhone Theme
 */
function rt_widget_testimonials($args)
{	
	extract($args);
	echo $before_widget;
	echo $before_title;
	echo 'Reviews';
	echo $after_title;
	rt_render_testimonials();
	echo $after_widget;
}
function rt_widget_posts()
{
	$options = get_option("rt_widget_posts");

	query_posts('cat='.$options['category_id']); 

	if (have_posts()) : while (have_posts()) :global $post; the_post(); 
	?>

				
				<div class="post_thumb"><img src="<?php echo get_post_meta($post->ID, 'rt_thumb', TRUE); ?>"</div>
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<div class="summary">
						<?php the_excerpt(); ?>
					</div>
				</div>

 
				<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php 
	endif; 

}
function rt_new_excerpt_more($post) {
	return '... <p class="excerpt"><a href="'. get_permalink($post->ID) . '">' . 'Continue Reading' . '</a></p>';
}
add_filter('excerpt_more', 'rt_new_excerpt_more');


function rt_widget_posts_control(){
	$options = get_option("rt_widget_posts");
	if (!is_array( $options )){
		$options = array(
		'category_id' => 0
      );
  }
 
  if ($_POST['rt_widget_posts_submit'])
  {
    $options['category_id'] = $_POST['rt_widget_posts_category'];
    update_option("rt_widget_posts", $options);
  }
 
?>
  <p>
    <label for="myHelloWorld-WidgetTitle">Use Posts from Category: </label>
	<?php wp_dropdown_categories('hide_empty=0&name=rt_widget_posts_category&id=rt_widget_posts_category&show_option_none=Select Category&selected='.$options['category_id']); ?>
    <input type="hidden" id="rt_widget_posts_submit" name="rt_widget_posts_submit" value="1" />
  </p>
<?php

}
function rt_widgets_init()
{
	wp_register_sidebar_widget("rt_widget_testimonials","RawApps Testimonials", 'rt_widget_testimonials');
	wp_register_sidebar_widget("rt_widget_posts","RawApps Posts", 'rt_widget_posts');
	wp_register_widget_control("rt_widget_posts","RawApps Posts", 'rt_widget_posts_control');

}

add_action("init", "rt_widgets_init");

?>


