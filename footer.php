<?php
/**
 * @package WordPress
 * @subpackage RawApps iPhone Theme
 */
?>
	<div class="iphone">
		<div class="iphone_bg">
			<div class="iphone_padding">
					<?php rt_render_slider(); ?>
			</div>
		</div>
	</div>
	<div style="clear:both;height:0px;"><!----></div>
</div>
</div>

</div>

<?php
get_sidebar();
echo "<div class='footer'>
	<p>
		WordPress Theme by <a href='http://www.rawappvice.com'>RawAppvice.com</a> | In Association With <a href='http://www.rawapps.com'>RawApps.com</a> | Powered by <a href='http://wordpress.org/' title='%s'>WordPress</a>
	</p>
	</div>"; 
?>
<?php
wp_footer();

echo "</body>
</html>"; 
?>