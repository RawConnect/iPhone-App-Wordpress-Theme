<?php
/**
 * @package WordPress
 * @subpackage RawApps iPhone Theme
 */

automatic_feed_links(); 



//LOAD DEFAULTS IF NONE PRESENT
  if(get_option('rt_appname') == NULL){
	update_option('rt_appname','YOUR APP NAME');
  }
  if(get_option('rt_appdescriptiontitle') == NULL){
	update_option('rt_appdescriptiontitle','HEADLINE');
  }
  if(get_option('rt_appdescription') == NULL){
	update_option('rt_appdescription','Use the <a href="/wp-admin/admin.php?page=rt_handle">settings page</a> on the wordpress admin panel to customize your new theme!');
  }  
  if(get_option('rt_bannerenable') == NULL){
	update_option('rt_bannerenable','text');
  }
  if(get_option('rt_bannertext') == NULL){
	update_option('rt_bannertext','LOGO TEXT');
  }
  if(get_option('rt_apporient') == NULL){
	update_option('rt_apporient','vert');
  }  
  if(get_option('rt_icon') == NULL){
	update_option('rt_icon','');
  }  
  if(get_option('rt_banner') == NULL){
	update_option('rt_banner','');
  }  
  if(get_option('rt_screens') == NULL){
	update_option('rt_screens','');
  }  


include(dirname(__FILE__) .'/includes/widgets.php');
if ( function_exists('register_sidebar') ){
	register_sidebar(array(
		'name' => 'Bottom Left',
		'id' => 'rtwid_bottomleft',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'Bottom Right',
		'id' => 'rtwid_bottomright',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));	
	}
	
	
	
	
if ( is_admin() ){
  add_action('save_post', 'rt_save_thumbnail', 1, 2);

  add_action('admin_menu', 'rt_menu');
  add_action('admin_menu', 'rt_add_uploadbox');
  add_action('admin_init', 'rt_settings');
  add_action('template_redirect', 'rt_templates');
  

  if($_GET['reset']){
	update_option( 'rt_testimonial', null);  
  }
  
  if($_GET['delete']){
	$existing = get_option('rt_screens');
	if (!empty($existing)) {
		foreach ($existing as &$value) {	    
			if ($value['hash'] == $_GET['delete']) {			
				unset($existing[array_search($value,$existing)]);
			}
		}
	}
	update_option( 'rt_screens', $existing );  
	
  }
  if($_GET['tdelete']){
	$existing = get_option('rt_testimonial');
	if (!empty($existing)) {
		foreach ($existing as &$value) {
			if ($value['hash'] == $_GET['tdelete']){			
				unset($existing[array_search($value,$existing)]);
			}
		}
	}
	update_option( 'rt_testimonial', $existing );  
	
  }
  if($_GET['createcontact']){
	$contact_page = get_page_by_title('Contact','ARRAY_A');
	if ($contact_page === null){
		rt_generate_contactpage();
	}elseif($contact_page['post_status'] == "trash"){
		wp_delete_post( $contact_page['ID'], true );
		rt_generate_contactpage();
	}
  }
  if($_GET['deletecontact']){
	$contact_page = get_page_by_title('Contact','ARRAY_A');
	if ($contact_page !== null){
		wp_delete_post( $contact_page['ID'], true );
	}
  }
  if($_GET['updated']){
  }
  
  
} else {

}



function rt_save_thumbnail($post_id, $post) { 

	if ( !wp_verify_nonce( $_POST['rt_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post->ID ))
		return $post->ID;
	} else {
		if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	}

	$pdata = $_POST['rt_thumb'];
	echo $pdata;
	if( $post->post_type == 'revision' ) return;
	if(get_post_meta($post->ID, 'rt_thumb', FALSE)) {
		update_post_meta($post->ID, 'rt_thumb', $pdata);
	} else {
		add_post_meta($post->ID, 'rt_thumb', $pdata);
	}

}
function rt_templates() { 
	include(TEMPLATEPATH . '/contact.php');
	exit;
}


function rt_settings() {
  register_setting( 'rt_options', 'rt_appname' );
  register_setting( 'rt_options', 'rt_authorname' );
  register_setting( 'rt_options', 'rt_authorcontact' );
  register_setting( 'rt_options', 'rt_authortwitter' );
  register_setting( 'rt_options', 'rt_appversion' );
  register_setting( 'rt_options', 'rt_appprice' );
  register_setting( 'rt_options', 'rt_appdescription' );
  register_setting( 'rt_options', 'rt_appdescriptiontitle' );
  register_setting( 'rt_options', 'rt_apporient' );
  register_setting( 'rt_options', 'rt_appmediatype' );
  register_setting( 'rt_options', 'rt_bannerenable' );
  register_setting( 'rt_options', 'rt_bannertext' );
  register_setting( 'rt_options', 'rt_ituneslink','rt_validate_itunes' );
  register_setting( 'rt_options', 'rt_displaycat' );
  register_setting( 'rt_options', 'rt_theme' );
  register_setting( 'rt_video', 'rt_embedcode' );
  register_setting( 'rt_icon', 'rt_icon', 'rt_upload_validate' );
  register_setting( 'rt_banner', 'rt_banner', 'rt_validate_banner' );
  register_setting( 'rt_screens', 'rt_screens', 'rt_upload_screens' );
  register_setting( 'rt_testimonial', 'rt_testimonial', 'rt_validate_testimonial' );
  register_setting( 'rt_testimonial', 'rt_testimonialsource' );
 
}





function rt_head() {
	echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>' . "\n";
	echo '<script type="text/javascript" src="'.get_bloginfo("template_directory").'/javascript/rt_slideshow.js"></script>' . "\n";
}

function rt_menu() {
  add_menu_page('apptheme','RAWapps.com', 8, 'rt_handle', rt_options);
  add_submenu_page('rt_handle', 'General Settings', 'Settings', 8, 'rt_handle', rt_options); 
  add_submenu_page('rt_handle', 'Application Media', 'Media', 8, 'rt_handle_images', rt_options_images); 
  add_submenu_page('rt_handle', 'Manage Testimonials', 'Testimonials', 8, 'rt_handle_testimonials', rt_options_testimonials); 

}








function rt_generate_contactpage() {
  if (function_exists('wpcf7')){
	  $contact_vars = array();
	  $contact_vars['post_title'] = 'Contact';
	  $contact_vars['post_content'] = '[contact-form 1 "Contact form 1"]';
	  $contact_vars['post_status'] = 'publish';
	  $contact_vars['post_author'] = 1;
	  $contact_vars['post_type'] = 'page';
	  wp_insert_post( $contact_vars );
 }
}


function rt_upload_gettext($optname = 'rt_icon') {
    $options = get_option($optname);
    if ($file = $options['file']) {
        // var_dump($file);
		if(!strstr($file['error'],'Unable to create directory')){
        echo "<img src='{$file['url']}' />";
		}else{
		echo "There was an error in uploading files to the wp-content folder, please check the folder permissions and try again.";
		}
    }
}


function rt_upload_getinput($optname = 'rt_icon') {
    echo '<input type="file" name="'.$optname.'" size="40" />';
}



function rt_add_uploadbox() {
	if( function_exists( 'add_meta_box' )) {
		add_meta_box( 'rt_post_uploadbox', 'Post Thumbnail', 'rt_post_uploadbox', 'post', 'normal', 'high' );
	}
}

function rt_post_uploadbox() {
	global $post;

	echo '<input type="hidden" name="rt_noncename" id="rt_noncename" value="' .
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	?>
	<p>
	<label for="rt_thumb">Thumbnail URL</label>
	<input style="width:99%;" class="code" type="text" id="rt_thumb" name="rt_thumb" value="<?php echo get_post_meta($post->ID, 'rt_thumb', true); ?>" />
	<p><a href="media-upload.php?type=image&amp;TB_iframe=true" id="add_image" class="thickbox" title="Add an Image" onclick="return false;">Upload an image</a></strong> and paste the URL here.</p>
	</p>
	<?php
}
//DISPLAY FUNCTIONS
function rt_render_appicon(){
    $options = get_option('rt_icon');
    if ($file = $options['file']) { 
        echo "<img src='{$file['url']}' />";
		}
		else{
		echo "<div style='width:73px;height:73px;display:inline;'>&nbsp;</div>";
		}
}
function rt_render_banner(){
    $options = get_option('rt_banner');
    if ($file = $options['file']) { 
        echo "<img src='{$file['url']}' />";
		}
}

function rt_render_slider() {
    $existing = array();
	$existing = get_option('rt_screens');
	echo "<div id='slider' class='".get_option("rt_apporient")."'><ul>";
	if (!empty($existing)) {
		foreach ($existing as $value) {
			if (!$value['error']){
				echo "<li><img src='{$value['url']}' /></li";
			}
		}
	}
	echo "</ul></div>";
}
function rt_render_testimonials() {
    $existing = array();
	$existing = get_option('rt_testimonial');
	if (!empty($existing)) {
		$value = $existing[array_rand($existing, 1)];
		echo '<div class="rt_testimonial_text">"'.$value["text"].'"</div>';
		echo '<div class="rt_testimonial_src"> - '.$value["source"].'</div>';
	}
}
function rt_preview_screens() {
    $existing = array();
	$existing = get_option('rt_screens');
	if (!empty($existing)) {
		foreach ($existing as $value) {
			if (!$value['error']){
				echo "<div style='float:left;border:1px solid #ddd;padding:10px;background-color:white;margin-right:6px;'><img style='height:135px;width:90px;' src='{$value['url']}' /><div style='text-align:center;height:11px;'><a href='admin.php?page=".$_GET['page']."&delete={$value['hash']}'>Delete</a></div></div>";
			}
		}
	}

}function rt_preview_testimonials() {
    $existing = array();
	$existing = get_option('rt_testimonial');
	if (!empty($existing)) {
		foreach ($existing as $value) {
			echo '<tr valign="top">';
			echo '<th scope="row">'.$value["source"].'</th>';
			echo '<td>'.$value["text"].'<div><a href="admin.php?page='.$_GET['page'].'&tdelete='.$value['hash'].'">Delete</a></div></td>';
			echo '</tr>';
		}
	}
}
//VALIDATION FUNCTIONS
function rt_validate_testimonial($input) {
     $new = array();
	 $new['source'] = $_POST['rt_testimonialsource'];
	 $new['text'] = $_POST['rt_testimonial'];
	 $new['hash'] = substr(base64_encode($new['text']), -8, 6);
	 
	if (get_option('rt_testimonial')){
		$testimonials = get_option('rt_testimonial');
	}else{
		$testimonials = array();
	}
	array_push($testimonials, $new);
	//var_dump($input);
	return $testimonials;
}

function rt_upload_validate($input,$optname = 'rt_icon') {
    $newinput = array();
    if ($_FILES[$optname]) {
        $overrides = array('test_form' => false); 
        $file = wp_handle_upload($_FILES[$optname], $overrides);

        $newinput['file'] = $file;
    }
	return $newinput;
}

function rt_validate_banner($input,$optname = 'rt_banner') {
    $newinput = array();
    if ($_FILES[$optname]) {
        $overrides = array('test_form' => false); 
        $file = wp_handle_upload($_FILES[$optname], $overrides);

        $newinput['file'] = $file;
    }
	return $newinput;
}
function rt_validate_itunes($input) {
	$link = $input; 
	if(substr($link,0,7) == "http://"){	
		return $link;
	}else{
		return "http://".$link;
	}
}

function rt_upload_screens() {
    
	if (get_option('rt_screens')){
		$existing = get_option('rt_screens');
	}else{
		$existing = array();
	}
	
    if ($_FILES['rt_screens']) {
        $overrides = array('test_form' => false); 
        $file = wp_handle_upload($_FILES['rt_screens'], $overrides);
		if (!$file['error']){
			$file['hash'] = substr(base64_encode($file['url']), -8, 6);
			array_push($existing, $file);
		}
		
    }
	return $existing;
}


function rt_options() {
  ?>
	<div class="wrap">
		<h2>Theme Options</h2>
		<p><img src="http://www.rawapps.com/wp-content/uploads/promoimages/themebanner.jpg"></p>
		<p>This is the general settings for the RawApps iPhone theme, this and the other settings pages will help you configure your theme with all the available options.</p>
		<form method="post" enctype="multipart/form-data" action="options.php">
			<table class="form-table">			
				<tr valign="top">
					<th scope="row">Application Name </th>
					<td><input class="regular-text" type="text" name="rt_appname" value="<?php echo get_option('rt_appname'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Author Name </th>
					<td><input class="regular-text" type="text" name="rt_authorname" value="<?php echo get_option('rt_authorname'); ?>" /></td>
				</tr>

				<tr valign="top">
					<th scope="row">Headline</th>
					<td><input class="regular-text" type="text" name="rt_appdescriptiontitle" value="<?php echo get_option('rt_appdescriptiontitle'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Description</th>
					<td><textarea class="large-text"  cols="50" rows="6" name="rt_appdescription"><?php echo get_option('rt_appdescription'); ?></textarea></td>
				</tr>
			</table>
			<h3>Application Details</h3>
			<p>Details about your actual application that will be used to better present your app.</p>
			<table class="form-table">			
				<tr valign="top">
					<th scope="row">Application Price </th>
					<td><input type="text" name="rt_appprice" value="<?php echo get_option('rt_appprice'); ?>" /></td>
				</tr>					
				<tr valign="top">
					<th scope="row">Application Version </th>
					<td><input type="text" name="rt_appversion" value="<?php echo get_option('rt_appversion'); ?>" /></td>
				</tr>

				<tr valign="top">
					<th scope="row">iTunes Link</th>
					<td><input class="regular-text"  type="text" name="rt_ituneslink" value="<?php echo get_option('rt_ituneslink'); ?>" /></td>
				</tr>
			</table>
			<h3>Theme Settings</h3>
			<p>Theme specific settings to customize the presentation and layout of your theme.</p>
			<table class="form-table">			
				<tr valign="top">
					<th scope="row">iPhone Orientation</th>
					<td>
						<select class="postform" id="rt_apporient" name="rt_apporient">
							<option <?php if (get_option('rt_apporient') == 'vert'): ?>selected="selected"<?php endif;?> value="vert" >Vertical</option>
						</select>					
					</td>
				</tr>					
				<tr valign="top">
					<th scope="row">Header Type</th>
					<td>
						<select class="postform" id="rt_bannerenable" name="rt_bannerenable">
							<option <?php if (get_option('rt_bannerenable') == 'text'): ?>selected="selected"<?php endif;?> value="text" >Text Title</option>
							<option <?php if (get_option('rt_bannerenable') == 'image'): ?>selected="selected"<?php endif;?> value="image" >Image Logo</option>
						</select>					
					</td>
				</tr>					
				<tr valign="top">
					<th scope="row">Header Text</th>
					<td>
						<input type="text" class="regular-text" name="rt_bannertext" value="<?php echo get_option('rt_bannertext'); ?>" /> 
						<p>If your Header Type is set to Image Logo, you can upload an image on the <a href="admin.php?page=rt_handle_images">media page</a>.</p>
					</td>
				</tr>					
				<tr valign="top">
					<th scope="row">iPhone Display</th>
					<td>
						<select class="postform" id="rt_appmediatype" name="rt_appmediatype">
								<option <?php if (get_option('rt_appmediatype') == 'slider'): ?>selected="selected"<?php endif;?> value="vslide" >Screenshot Slideshow</option>
						</select>	
						<p>You can upload screenshots on the <a href="admin.php?page=rt_handle_images">media page</a>.</p>
					</td>
				</tr>					

			</table>
				<h3>Contact Form 7 Settings</h3>
				<p>Contact Form 7 is a very powerful and customizeable contact form. In order to use it's features you must <a href="http://wordpress.org/extend/plugins/contact-form-7/">download and install</a> the plugin seperately, it is not included in the theme by default. (Don't worry, it's free!)</p>
				<?php if (function_exists('wpcf7')) { ?>
				<table class="form-table">	
					<?php $contact_page = get_page_by_title('Contact','ARRAY_A');
					if ($contact_page === null || $contact_page['post_status'] == "trash"){?>
					<tr valign="top">
						<th scope="row">Create Contact Page</th>
						<td>	
							<p>If you do not already have a Contact Page, Apptheme can automatically attempt to create one for you with the default settings. You can later customize it to suit your needs with the very flexible Contact Form 7 plugin.</p>
							<p>Ready? <a href="admin.php?page=<?php echo $_GET['page'];?>&createcontact=true">Create a Contact Page</a></p>
						</td>
					</tr>					
					<?php }else{?>
					<tr valign="top">
						<th scope="row">Delete Contact Page</th>
						<td>	
							<p>It seems you have a contact page already set up, Apptheme can automatically delete your contact page if you no longer want it.</p>
							<p><a href="admin.php?page=<?php echo $_GET['page'];?>&deletecontact=true">Delete my Contact Page</a> </p>
							<p>NOTE: You can recreate the page, but custom modifications may be lost.</p>
						</td>
					</tr>					
					<?php }?>
					<tr valign="top">
						<th scope="row">Manage Contact Page</th>
						<td>	
							<p>The Contact Form 7 plugin is very customizeable and has its own configuration page you can use to edit the form.</p>
							<p><a href="admin.php?page=wpcf7">Contact Form 7 Configuration</a> </p>
						</td>
					</tr>					
				</table>
				<?php }else{?>
				<table class="form-table">	
					<tr valign="top">
						<th scope="row">Install Plugin</th>
						<td>	
							You must <a href="http://wordpress.org/extend/plugins/contact-form-7/">download and install</a> the Contact Form 7 plugin in order to use this feature.						
						</td>
					</tr>					
				</table>
				<?php }?>
			<?php settings_fields('rt_options'); ?>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
			</p>
		</form>		
	</div>	
<?php		
}
function rt_options_images() {
  ?>
	<div class="wrap">
		<h2>Theme Media</h2>
		<p><img src="http://www.rawapps.com/wp-content/uploads/promoimages/themebanner.jpg"></p>
		<form method="post" enctype="multipart/form-data" action="options.php">
			<h3>Application Icon</h3>
			<p>Your application icon is display on every page to the left of the content, it is automatically adjusted to 73 x 73 pixels. We recommend using an image this size or larger for best quality.</p>
			<table class="form-table"><tbody><tr valign="top"><th scope="row">Change Application Icon</th><td><?php rt_upload_getinput(); ?><p><?php rt_upload_gettext(); ?></p></td></tr></tbody></table>	
			<?php settings_fields('rt_icon'); ?>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Update Icon') ?>" />
			</p>
		</form>		
		<form method="post" enctype="multipart/form-data" action="options.php">
			<h3>Page Logo</h3>
			<p>By default the area above the navigation uses text for the logo, you can upload an image here to use instead of the text.</p>
			<table class="form-table"><tbody><tr valign="top"><th scope="row">Change Image</th><td><?php rt_upload_getinput('rt_banner'); ?><p><?php rt_upload_gettext('rt_banner'); ?></p></td></tr></tbody></table>	
			<?php settings_fields('rt_banner'); ?>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Update Logo') ?>" />
			</p>
		</form>
		<form method="post" enctype="multipart/form-data" action="options.php">
			<h3>Screenshots</h3>
			<p>Uploading Screenshots adds them to the slideshow that appears on the iPhone, you can delete individual screenshots by clicking the delete label underneath.</p>
			
				<table class="form-table"><tbody><tr valign="top"><th scope="row">Add Screenshot</th><td><?php rt_upload_getinput('rt_screens'); ?><p><?php rt_preview_screens(); ?></p></td></tr></tbody></table>	
				<?php settings_fields('rt_screens'); ?>
				<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Add Screenshot') ?>" />
				</p>
		</form>
	</div>
  <?php
}
function rt_options_testimonials() {
  ?>
	<div class="wrap">
		<h2>Manage Testimonials</h2>
		<p><img src="http://www.rawapps.com/wp-content/uploads/promoimages/themebanner.jpg"></p>
		<p>Use this page to add and manage rotating testimonials that can be used with the testimonials widget or inserted in other locations.</p>

		<form method="post" enctype="multipart/form-data" action="options.php">
			<h3>Add Additional Testimonials</h3>
			<p>Testimonials added with this form are automatically included in the rotation.</p>
			<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">Testimonial</th>
					<td><textarea class="regular-text"  cols="50" rows="6" name="rt_testimonial"></textarea></td>
				</tr>	
				<tr valign="top">
					<th scope="row">Source</th>
					<td><input class="regular-text" type="text" name="rt_testimonialsource" value="" /></td>
				</tr>	
			</tbody>
			</table>	
			<?php settings_fields('rt_testimonial'); ?>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Add Testimonial') ?>" />
			</p>
		</form>
			<h3>Manage Testimonials</h3>
			<p>A list of your active testimonials, click the delete label to permanently remove the testimonial.</p>
			<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><b>Source</b></th>
					<td><b>Testimonial</b></td>
				</tr>	
					<?php rt_preview_testimonials();?>
			</tbody>
			</table>	
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Add Testimonial') ?>" />
			</p>

	</div>
  <?php
}

add_action('wp_head', 'rt_head');
?>
