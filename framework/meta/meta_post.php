<?php
/**
 * The file contains the functions to add meta box to post
 *
 * @package  WordPress
 * @file     meta_post.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */

function fairpixels_post_meta_settings() {
	add_meta_box("fp_meta_post_gallery", "Post Slider Settings", "fp_meta_post_gallery", "post", "normal", "high");
	add_meta_box("fp_meta_post_video", "Featured Video Settings", "fp_meta_post_video", "post", "normal", "high");
	add_meta_box("fp_meta_post_sidebar", "Sidebar Settings", "fp_meta_post_sidebar", "post", "normal", "high");
	
	
	$post_id = '';	
	if(isset($_GET['post'])){  
		$post_id = $_GET['post'];
    }
	
	if(isset($_POST['post_ID'])){
		$post_id =  $_POST['post_ID'];
    }	
	
	$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
	if ($template_file == 'page-home.php') {
		add_meta_box("fp_meta_homepage", "HomePage Settings", "fp_meta_homepage", "page", "normal", "high");
	}
	
	add_meta_box("fp_meta_post_sidebar", "Sidebar Settings", "fp_meta_post_sidebar", "page", "normal", "high");
}
add_action( 'add_meta_boxes', 'fairpixels_post_meta_settings' );


function fp_register_meta_scripts($hook_suffix) {	
		if( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {	
			wp_enqueue_script( 'fp_meta_js', get_template_directory_uri() . '/framework/meta/js/meta.js', array( 'jquery' ));
			wp_enqueue_style( 'fp_meta_css', get_template_directory_uri() . '/framework/meta/css/meta.css');
			wp_enqueue_script( 'fp_meta_select_js', get_template_directory_uri() . '/framework/settings/js/jquery.customSelect.min.js', array( 'jquery' ));
			wp_enqueue_style( 'fp-font-awesome', get_template_directory_uri().'/css/fonts/font-awesome/css/font-awesome.min.css' );	
		}
}
add_action( 'admin_enqueue_scripts', 'fp_register_meta_scripts' );

/**
 * Display Homepage Settings
 *
 */ 
function fp_meta_homepage() {
	global $post;
	wp_nonce_field( 'fairpixels_save_postmeta_nonce', 'fairpixels_postmeta_nonce' ); ?>
		
		<h4><?php _e('Slider Section', 'fairpixels'); ?></h4>
		
		<div class="meta-field field-checkbox">			
			<input name="fp_meta_show_slider" id="fp_meta_show_slider" type="checkbox" value="1" <?php checked( get_post_meta( $post->ID, 'fp_meta_show_slider', true ), 1 ); ?> /> 
			<label for="fp_meta_show_slider"><?php _e( 'Enable Slider section', 'fairpixels' ); ?></label>
		</div>
		
		<div class="meta-field">
			<label><?php _e( 'Slider Category', 'fairpixels' ); ?></label>
			<select id="fp_meta_slider_cat" name="fp_meta_slider_cat" class="styled">
				<?php 
					$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  
					$saved_cat = get_post_meta( $post->ID, 'fp_meta_slider_cat', true );
				?>
				<option <?php selected( 0 == $saved_cat ); ?> value="0"><?php _e('All Categories', 'fairpixels'); ?></option>	
				<?php
					if($categories){
						foreach ($categories as $category){?>
							<option <?php selected( $category->term_id == $saved_cat ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>							
							<?php					
						}
					}
				?>			
			</select>
			<span class="desc"><?php _e( 'Select category for slider.', 'fairpixels' ); ?></span>
		</div>
		
		<div class="meta-field">
			<?php
				$value = get_post_meta( $post->ID, 'fp_meta_slider_speed', true );
				if (empty($value)){
					$value = "5000";
				}
			?>			
			<label for="fp_meta_slider_speed"><?php _e( 'Slider Speed:', 'fairpixels' ); ?></label>
			<input name="fp_meta_slider_speed" class="compact-input" type="text" id="fp_meta_slider_speed" value="<?php echo $value; ?>" />
			<span class="desc"><?php _e( 'Enter the slider speed in milliseconds eg. 5000.', 'fairpixels' ); ?></span>
		</div>	
		
		<div class="meta-field">
			<label><?php _e( 'Right Posts Category', 'fairpixels' ); ?></label>
			<select id="fp_meta_slider_right_cat" name="fp_meta_slider_right_cat" class="styled">
				<?php 
					$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  
					$saved_cat = get_post_meta( $post->ID, 'fp_meta_slider_right_cat', true );
				?>
				<option <?php selected( 0 == $saved_cat ); ?> value="0"><?php _e('All Categories', 'fairpixels'); ?></option>	
				<?php
					if($categories){
						foreach ($categories as $category){?>
							<option <?php selected( $category->term_id == $saved_cat ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>							
							<?php					
						}
					}
				?>			
			</select>
			<span class="desc"><?php _e( 'Select category for the posts on the right column of slider section.', 'fairpixels' ); ?></span>
		</div>
		<h4><?php _e('Blog Section', 'fairpixels'); ?></h4>
		
		<div class="meta-field field-checkbox">			
			<input name="fp_meta_show_postlist" id="fp_meta_show_postlist" type="checkbox" value="1" <?php checked( get_post_meta( $post->ID, 'fp_meta_show_postlist', true ), 1 ); ?> /> 
			<label for="fp_meta_show_postlist"><?php _e( 'Blog Posts', 'fairpixels' ); ?></label>
			<span class="desc"><?php _e( 'If you want to display blog posts.', 'fairpixels' ); ?></span>
		</div>
		
		<div class="meta-field">
			<?php $value = get_post_meta( $post->ID, 'fp_meta_postlist_title', true ); ?>			
			<label for="fp_meta_postlist_title"><?php _e( 'Section Title:', 'fairpixels' ); ?></label>
			<input name="fp_meta_postlist_title" class="compact-input" type="text" id="fp_meta_postlist_title" value="<?php echo $value; ?>" />
			<span class="desc"><?php _e( 'Enter the blog section title.', 'fairpixels' ); ?></span>
		</div>	
		
		<div class="meta-field">
			<?php $value = get_post_meta( $post->ID, 'fp_meta_postlist_subtitle', true ); ?>			
			<label for="fp_meta_postlist_subtitle"><?php _e( 'Section Subtitle:', 'fairpixels' ); ?></label>
			<input name="fp_meta_postlist_subtitle" class="compact-input" type="text" id="fp_meta_postlist_subtitle" value="<?php echo $value; ?>" />
			<span class="desc"><?php _e( 'Enter the blog section subtitle.', 'fairpixels' ); ?></span>
		</div>	
		
		<div class="meta-field">
			<label><?php _e( 'Blog Category', 'fairpixels' ); ?></label>
			<select id="fp_meta_postlist_cat" name="fp_meta_postlist_cat" class="styled">
				<?php 
					$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  
					$saved_cat = get_post_meta( $post->ID, 'fp_meta_postlist_cat', true );
				?>
				<option <?php selected( 0 == $saved_cat ); ?> value="0"><?php _e('All Categories', 'fairpixels'); ?></option>	
				<?php
					if($categories){
						foreach ($categories as $category){?>
							<option <?php selected( $category->term_id == $saved_cat ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>							
							<?php					
						}
					}
				?>			
			</select>
			<span class="desc"><?php _e( 'If you want to display posts from a specific category', 'fairpixels' ); ?></span>
		</div>
		
		
	
	<?php
	}
	
/**
 * Display review settings
 *
 */ 
function fp_meta_post_gallery() {
	global $post;
	wp_nonce_field( 'fairpixels_save_postmeta_nonce', 'fairpixels_postmeta_nonce' );	?>	
		
	<div class="meta-field field-checkbox first-field">
		<input type="checkbox" name="fp_meta_post_show_gallery" id="fp_meta_post_show_gallery" value="1" <?php checked( get_post_meta( $post->ID, 'fp_meta_post_show_gallery', true ), 1 ); ?> />
		<label for="fp_meta_post_show_gallery"><?php _e( 'Add Gallery', 'fairpixels' ); ?></label>
		<div class="desc inline-desc"><?php _e( 'If you want to add image slider to the post', 'fairpixels' ); ?></div>
	</div>		
		
	<div id="fp-post-meta-images" class="meta-field">
		
		<div class="meta-field">
			<button class="upload-post-img-btn"><?php _e( 'Add image', 'fairpixels' ); ?></button>				
		</div>
		
		<div class="meta-field selected-images">
			
			<div class="image-list">
				<ul>
					<?php
						$saved_img_ids = get_post_meta($post->ID, 'fp_meta_gallery_img_ids', true );
						if (!empty($saved_img_ids)){
							$img_ids = explode(',',$saved_img_ids);
							foreach($img_ids as $img_id) {    
								if (is_numeric($img_id)) {
									$image_attributes = wp_get_attachment_image_src( $img_id );
									?>									
									<li>
										<div class="thumb">
											<img src="<?php echo $image_attributes[0]; ?>">
											<input type="hidden" name="fp_meta_gallery_img_id[]" value="<?php echo $img_id; ?>" />
										</div>
										<div class="image-settings"><span class="remove"><i class="fa fa-times"></i></span></div>
									</li>
									<?php
								}
							}
						}
					
					?>				
				</ul>
			</div>
			
		</div>
		
		<div class="meta-field image-info"><i class="fa fa-info-circle"></i><?php _e( 'You can change the order of images with drag and drop.', 'fairpixels' ); ?></div>
	</div><!-- /fp-post-meta-gallery-options -->
	
	<?php

}

/**
 * Display video settings
 *
 */ 
function fp_meta_post_video() {
	global $post;
	wp_nonce_field( 'fairpixels_save_postmeta_nonce', 'fairpixels_postmeta_nonce' ); ?>
			
		<div class="meta-field textarea-field">
			<label><?php _e( 'Featured Video:', 'fairpixels' ); ?></label>
			<textarea name="fp_meta_post_video_code" id="fp_meta_post_video_code" type="textarea" cols="100%" rows="3"><?php echo get_post_meta( $post->ID, 'fp_meta_post_video_code', true ); ?></textarea>
			
			<div class="meta-field-desc first-field"><i class="icon-info-sign"></i><?php _e( 'If you want to use featured video instead of the image, paste video embeding code. Leave blank to use standard image.', 'fairpixels' ); ?></div>
			<div class="meta-field-desc"><i class="icon-info-sign"></i><?php _e( 'Remember to use the featured image also, as that will be displayed for the small thumbnails.', 'fairpixels' ); ?></div>
		</div>
		
		<div class="meta-field field-checkbox first-field">
			<input type="checkbox" name="fp_meta_post_add_video" id="fp_meta_post_add_video" value="1" <?php checked( get_post_meta( $post->ID, 'fp_meta_post_add_video', true ), 1 ); ?> />
			<label for="fp_meta_post_add_video"><?php _e( 'Add Video in Post Also', 'fairpixels' ); ?></label>
			<div class="desc inline-desc"><?php _e( 'If you want to add the video at the top of the post also.', 'fairpixels' ); ?></div>
		</div>
		
		<div class="meta-field field-checkbox first-field">
			<input type="checkbox" name="fp_meta_post_add_featimg" id="fp_meta_post_add_featimg" value="1" <?php checked( get_post_meta( $post->ID, 'fp_meta_post_add_featimg', true ), 1 ); ?> />
			<label for="fp_meta_post_add_featimg"><?php _e( 'Add Featured image in Post Also', 'fairpixels' ); ?></label>
			<div class="desc inline-desc"><?php _e( 'If you want to add the featured image at the top of the post also.', 'fairpixels' ); ?></div>
		</div>
	
	<?php
	}
	
/**
 * Display video settings
 *
 */ 
function fp_meta_post_sidebar() {
	global $post;
	wp_nonce_field( 'fairpixels_save_postmeta_nonce', 'fairpixels_postmeta_nonce' ); ?>
	
	<div class="meta-field">
		<?php 	
			$options = get_option('fp_options');
			$sidebars = "";													
			if (isset($options['fp_custom_sidebars'])){
				$sidebars = $options['fp_custom_sidebars'] ;
			}
				
			$saved_sidebar = get_post_meta( $post->ID, 'fp_meta_post_sidebar_name', true ); 
		?>
		<label><?php _e( 'Select Sidebar:', 'fairpixels' ); ?></label>
		<select id="fp_meta_post_sidebar_name" name="fp_meta_post_sidebar_name" class="styled">
			<option <?php selected( "" == $saved_sidebar ); ?> value=""><?php _e('Default', 'fairpixels'); ?></option>	
			<?php
				if($sidebars){
					foreach ($sidebars as $sidebar){?>
						<option <?php selected( $sidebar == $saved_sidebar ); ?> value="<?php echo $sidebar; ?>"><?php echo $sidebar ?></option>							
						<?php					
					}
				}
			?>		
		</select>
		<span class="desc"><?php _e( 'You can create custom sidebars in the theme options page.', 'fairpixels' ); ?></span>		
	</div>
	
<?php 
}
	
/**
 * Save post meta box settings
 *
 */
function fp_post_meta_save_post_settings() {
	global $post;
	
	if( !isset( $_POST['fairpixels_postmeta_nonce'] ) || !wp_verify_nonce( $_POST['fairpixels_postmeta_nonce'], 'fairpixels_save_postmeta_nonce' ) )
		return;

	if( !current_user_can( 'edit_posts' ) )
		return;
	
	if ( isset( $_POST['fp_meta_show_slider'] ) && $_POST['fp_meta_show_slider'] == 1) {
		update_post_meta( $post->ID, 'fp_meta_show_slider', 1 );	
	} else {
		delete_post_meta( $post->ID, 'fp_meta_show_slider');	
	}
	
	if ( isset( $_POST['fp_meta_slider_cat'] )){
		update_post_meta( $post->ID, 'fp_meta_slider_cat', $_POST['fp_meta_slider_cat'] );	
	}
	
	if ( isset( $_POST['fp_meta_slider_right_cat'] )){
		update_post_meta( $post->ID, 'fp_meta_slider_right_cat', $_POST['fp_meta_slider_right_cat'] );
	}	
	
	if(isset($_POST['fp_meta_slider_speed'])){
		update_post_meta($post->ID, 'fp_meta_slider_speed', sanitize_text_field($_POST['fp_meta_slider_speed']));
	}
		
	if ( isset( $_POST['fp_meta_show_postlist'] ) && $_POST['fp_meta_show_postlist'] == 1) {
		update_post_meta( $post->ID, 'fp_meta_show_postlist', 1 );	
	} else {
		delete_post_meta( $post->ID, 'fp_meta_show_postlist');	
	}
	
	if(isset($_POST['fp_meta_postlist_title'])){
		update_post_meta($post->ID, 'fp_meta_postlist_title', sanitize_text_field($_POST['fp_meta_postlist_title']));
	}
	
	if(isset($_POST['fp_meta_postlist_subtitle'])){
		update_post_meta($post->ID, 'fp_meta_postlist_subtitle', sanitize_text_field($_POST['fp_meta_postlist_subtitle']));
	}
	
	if ( isset( $_POST['fp_meta_postlist_cat'] )){
		update_post_meta( $post->ID, 'fp_meta_postlist_cat', $_POST['fp_meta_postlist_cat'] );
	}	
	
	if ( isset( $_POST['fp_meta_post_show_gallery'] ) && $_POST['fp_meta_post_show_gallery'] == 1  ) {
		update_post_meta( $post->ID, 'fp_meta_post_show_gallery', 1 );	
	} else {
		delete_post_meta( $post->ID, 'fp_meta_post_show_gallery', 1 );	
	}	
	
	if ( isset( $_POST['fp_meta_gallery_img_id'] )){
		
		$image_ids_list = "";		
		foreach ($_POST['fp_meta_gallery_img_id'] as $image_id) {
			$image_ids_list .= $image_id. ',';			
		} 
		update_post_meta( $post->ID, 'fp_meta_gallery_img_ids', $image_ids_list );	
		
	}else {
		delete_post_meta( $post->ID, 'fp_meta_gallery_img_ids');	
	}
	
	if(isset($_POST['fp_meta_post_video_code'])){
		update_post_meta( $post->ID, 'fp_meta_post_video_code', $_POST['fp_meta_post_video_code'] );
	}
	
	if ( isset( $_POST['fp_meta_post_add_video'] ) && $_POST['fp_meta_post_add_video'] == 1  ) {
		update_post_meta( $post->ID, 'fp_meta_post_add_video', 1 );	
	} else {
		delete_post_meta( $post->ID, 'fp_meta_post_add_video', 1 );	
	}
	
	if ( isset( $_POST['fp_meta_post_add_featimg'] ) && $_POST['fp_meta_post_add_featimg'] == 1  ) {
		update_post_meta( $post->ID, 'fp_meta_post_add_featimg', 1 );	
	} else {
		delete_post_meta( $post->ID, 'fp_meta_post_add_featimg', 1 );	
	}
		
	if ( isset( $_POST['fp_meta_post_sidebar_name'] )){
		update_post_meta( $post->ID, 'fp_meta_post_sidebar_name', $_POST['fp_meta_post_sidebar_name'] );	
	}
	
}
add_action( 'save_post', 'fp_post_meta_save_post_settings' );