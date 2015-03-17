<?php
/**
 * The Theme Options page
 *
 * This page is implemented using the Settings API
 * http://codex.wordpress.org/Settings_API
 * 
 * @package  WordPress
 * @file     theme-options.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */

/**
 * Include scripts to the options page only
 */
function fp_theme_options_scripts(){
	
	wp_enqueue_style('thickbox');
	
	if ( ! did_action( 'wp_enqueue_media' ) ){
		wp_enqueue_media();
	}
	
	wp_enqueue_script( 'fp_colorpicker', get_template_directory_uri() . '/framework/settings/js/colorpicker.js', array( 'jquery' ));
	wp_enqueue_script('fp_upload', get_template_directory_uri() .'/framework/settings/js/upload.js', array('jquery'));
	wp_enqueue_style( 'fp-font-awesome', get_template_directory_uri().'/css/fonts/font-awesome/css/font-awesome.min.css' );	
	wp_enqueue_style( 'fp_theme_options_css', get_template_directory_uri() . '/framework/settings/css/theme-options.css');
	wp_enqueue_script( 'fp_select_js', get_template_directory_uri() . '/framework/settings/js/jquery.customSelect.min.js', array( 'jquery' ));
	wp_enqueue_script( 'fp_theme_options', get_template_directory_uri() . '/framework/settings/js/theme-options.js', array( 'jquery','fp_select_js' ));	
}

global $pagenow;

if( ( 'themes.php' == $pagenow ) && ( isset( $_GET['activated'] ) && ( $_GET['activated'] == 'true' ) ) ) :
	/**
	* Set default options on activation
	*/
	function fp_init_options() {
		//delete_option( 'fp_options' ); 
		$options = get_option( 'fp_options' );
		if ( false === $options ) {
			$options = fp_default_options();  
		}
		update_option( 'fp_options', $options );
	}
	add_action( 'after_setup_theme', 'fp_init_options', 9 );
endif;

/**
 * Register the theme options setting
 */
function fp_register_settings() {
	register_setting( 'fp_options', 'fp_options', 'fp_validate_options' );	
}
add_action( 'admin_init', 'fp_register_settings' );

/**
 * Register the options page
 */

function fp_theme_add_page() {
	$fp_options_page = add_theme_page( __( 'Theme Options', 'fairpixels' ),  __( 'Theme Options', 'fairpixels' ), 'manage_options', 'fp-options', 'fp_theme_options_page');
	
	add_action( 'admin_print_styles-' . $fp_options_page, 'fp_theme_options_scripts' );
}
add_action( 'admin_menu', 'fp_theme_add_page');


/**
 * Output the options page
 */
function fp_theme_options_page() { 
?>
	<div id="fp-options"> 		
		<div class="header">	
			<div class="main">
				<div class="left">
					<h2><?php echo _e('Theme Options', 'fairpixels'); ?></h2>
				</div>	
			
				<div class="theme-info">		
					<h3><?php _e('Santiago', 'fairpixels'); ?></h3>			
					<ul>
						<li class="support">
							<i class="fa fa-flag"></i>
							<a href="<?php echo esc_url(__('http://support.fairpixels.com/', 'fairpixels')); ?>" title="<?php _e('Theme Support', 'fairpixels'); ?>" target="_blank"><?php printf(__('Theme Support', 'fairpixels')); ?></a>
						</li>										
					</ul>
				</div>
			</div>							
		</div><!-- /header -->			
			
		<div class="options-wrap">
			
			<div class="tabs">
				<ul>
					<li class="general first"><a href="#general"><i class="fa fa-cogs"></i><?php echo _e('General', 'fairpixels'); ?></a></li>
					<li class="blog"><a href="#blog"><i class="fa fa-file-o"></i><?php echo _e('Blog', 'fairpixels'); ?></a></li>
					<li class="sidebars"><a href="#sidebars"><i class="fa fa-columns"></i><?php echo _e('Sidebars', 'fairpixels'); ?></a></li>
					<li class="styles"><a href="#styles"><i class="fa fa-th-large"></i><?php echo _e('Styles', 'fairpixels'); ?></a></li>
					<li class="typography"><a href="#typography"><i class="fa fa-pencil"></i><?php echo _e('Typography', 'fairpixels'); ?></a></li>
					<li class="footer"><a href="#footer"><i class="fa fa-desktop"></i><?php echo _e('Header and Footer', 'fairpixels'); ?></a></li>
					<li class="reset"><a href="#reset"><i class="fa fa-repeat"></i><?php echo _e('Reset', 'fairpixels'); ?></a></li>
				</ul>                           
			</div><!-- /subheader -->
					
			<div class="options-form">			
									
					<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
						<div class="updated fade"><p><?php _e('Theme settings updated successfully', 'fairpixels'); ?></p></div>
					<?php endif; ?>
				
					<form action="options.php" method="post">
						
						<?php settings_fields( 'fp_options' ); ?>
						<?php $options = get_option('fp_options'); ?>	
											
						<div class="tab_content">
							<div id="general" class="tab_block">
								<h2><?php _e('General Settings', 'fairpixels'); ?></h2>
								
								<div class="fields_wrap">
								
									<div class="field infobox">
										<p><strong><?php _e('Uploading Images', 'fairpixels'); ?></strong></p>
										<?php _e('You can specify the complete URLs for the logo and other images or you can upload the image. Please read the documentation for the image uploading instructions.', 'fairpixels'); ?>										
									</div>
									
									<h3><?php _e('Header Settings', 'fairpixels'); ?></h3>								
																											
									<div class="field field-upload">
										<label for="fp_logo_url"><?php _e('Upload logo', 'fairpixels'); ?></label>
										<input id="fp_options[fp_logo_url]" class="upload_image" type="text" name="fp_options[fp_logo_url]" value="<?php echo esc_attr($options['fp_logo_url']); ?>" />
                                        
										<input class="upload_image_button" id="fp_logo_upload_button" type="button" value="Upload" />
										<span class="description long updesc"><?php _e('Upload a logo image or specify path. Max width: 300px. Max height: 90px.', 'fairpixels'); ?>
										</span> 
									</div>	
									
									<div class="field">
										<label for="fp_favicon"><?php _e('Upload Favicon', 'fairpixels'); ?></label>
										<input id="fp_options[fp_favicon]" class="upload_image" type="text" name="fp_options[fp_favicon]" value="<?php echo esc_attr($options['fp_favicon']); ?>" />
                                        <input class="upload_image_button" id="fp_favicon_button" type="button" value="Upload" />
										<span class="description updesc"><?php _e('Upload your 16x16 px favicon or specify path.', 'fairpixels'); ?></span> 
									</div>	
									
									<div class="field">
										<label for="fp_apple_touch"><?php _e('Apple Touch Icon', 'fairpixels'); ?></label>
										<input id="fp_options[fp_apple_touch]" class="upload_image" type="text" name="fp_options[fp_apple_touch]" value="<?php echo esc_attr($options['fp_apple_touch']); ?>" />
                                        <input class="upload_image_button" id="fp_apple_touch_button" type="button" value="Upload" />
										<span class="description updesc"><?php _e('Upload your 114px by 114px icon.', 'fairpixels'); ?></span> 
									</div>	
									
									<div class="field">
										<label for="fp_options[fp_rss_url]"><?php _e('Custom RSS URL', 'fairpixels'); ?></label>
										<input id="fp_options[fp_rss_url]" name="fp_options[fp_rss_url]" type="text" value="<?php echo esc_attr($options['fp_rss_url']); ?>" />
										<span class="description long"><?php _e( 'Enter full URL of RSS Feeds link starting with <strong>http:// </strong>. Leave blank to use default RSS Feeds.', 'fairpixels' ); ?></span>
									</div>	
									<h3><?php _e('Social Links', 'fairpixels'); ?></h3>
									
									<div class="field">
										<label for="fp_options[fp_show_header_social]"><?php _e('Enable Social Links', 'fairpixels'); ?></label>
										<input id="fp_options[fp_show_header_social]" name="fp_options[fp_show_header_social]" type="checkbox" value="1" <?php isset($options['fp_show_header_social']) ? checked( '1', $options['fp_show_header_social'] ) : checked('0', '1'); ?> />				
										<span class="description chkdesc"><?php _e( 'Check to display social links in header and footer', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_twitter_url]"><?php _e('Twitter', 'fairpixels'); ?></label>
										<input id="fp_options[fp_twitter_url]" name="fp_options[fp_twitter_url]" type="text" value="<?php echo esc_attr($options['fp_twitter_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Twitter profile.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_fb_url]"><?php _e('Facebook', 'fairpixels'); ?></label>
										<input id="fp_options[fp_fb_url]" name="fp_options[fp_fb_url]" type="text" value="<?php echo esc_attr($options['fp_fb_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Facebook profile.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_gplus_url]"><?php _e('Google+', 'fairpixels'); ?></label>
										<input id="fp_options[fp_gplus_url]" name="fp_options[fp_gplus_url]" type="text" value="<?php echo esc_attr($options['fp_gplus_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Google+ profile.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_linkedin_url]"><?php _e('Linkedin', 'fairpixels'); ?></label>
										<input id="fp_options[fp_linkedin_url]" name="fp_options[fp_linkedin_url]" type="text" value="<?php echo esc_attr($options['fp_linkedin_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Linkedin profile.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_pinterest_url]"><?php _e('Pinterest', 'fairpixels'); ?></label>
										<input id="fp_options[fp_pinterest_url]" name="fp_options[fp_pinterest_url]" type="text" value="<?php echo esc_attr($options['fp_pinterest_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Pinterest profile.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_instagram_url]"><?php _e('Instagram', 'fairpixels'); ?></label>
										<input id="fp_options[fp_instagram_url]" name="fp_options[fp_instagram_url]" type="text" value="<?php echo esc_attr($options['fp_instagram_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Instagram profile.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_dribbble_url]"><?php _e('Dribbble', 'fairpixels'); ?></label>
										<input id="fp_options[fp_dribbble_url]" name="fp_options[fp_dribbble_url]" type="text" value="<?php echo esc_attr($options['fp_dribbble_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Dribbble profile.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_youtube_url]"><?php _e('Youtube', 'fairpixels'); ?></label>
										<input id="fp_options[fp_youtube_url]" name="fp_options[fp_youtube_url]" type="text" value="<?php echo esc_attr($options['fp_youtube_url']); ?>" />
										<span class="description"><?php _e( 'Enter the full URL of Youtube profile.', 'fairpixels' ); ?></span>
									</div>
									
									<h3><?php _e('Contact Details', 'fairpixels'); ?></h3>
									
									<div class="field">
										<label for="fp_options[fp_contact_address]"><?php _e('Contact Address', 'fairpixels'); ?></label>
										<input id="fp_options[fp_contact_address]" name="fp_options[fp_contact_address]" type="text" value="<?php echo esc_attr($options['fp_contact_address']); ?>" />
										<span class="description"><?php _e( 'Enter the address for the map on contact page.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_contact_email]"><?php _e('Email Address', 'fairpixels'); ?></label>
										<input id="fp_options[fp_contact_email]" name="fp_options[fp_contact_email]" type="text" value="<?php echo esc_attr($options['fp_contact_email']); ?>" />
										<span class="description long"><?php _e( 'Enter the email address where you wish to receive the contact form messages.', 'fairpixels' ); ?></span>
									</div>	
									
									<div class="field">
										<label for="fp_options[fp_contact_subject]"><?php _e('Email Subject', 'fairpixels'); ?></label>
										<input id="fp_options[fp_contact_subject]" name="fp_options[fp_contact_subject]" type="text" value="<?php echo esc_attr($options['fp_contact_subject']); ?>" />
										<span class="description"><?php _e( 'Enter the subject of the email.', 'fairpixels' ); ?></span>
									</div>
									
									<h3><?php _e('reCaptcha Settings', 'fairpixels'); ?></h3>
									<div class="field">
										<label for="fp_options[fp_recaptcha_public_key]"><?php _e('Public Key', 'fairpixels'); ?></label>
										<input id="fp_options[fp_recaptcha_public_key]" name="fp_options[fp_recaptcha_public_key]" type="text" value="<?php echo esc_attr($options['fp_recaptcha_public_key']); ?>" />
										<span class="description long"><?php _e( 'Enter the reCaptcha public key for the contact form reCaptcha. See documentation for more information', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_recaptcha_private_key]"><?php _e('Private Key', 'fairpixels'); ?></label>
										<input id="fp_options[fp_recaptcha_private_key]" name="fp_options[fp_recaptcha_private_key]" type="text" value="<?php echo esc_attr($options['fp_recaptcha_private_key']); ?>" />
										<span class="description long"><?php _e( 'Enter the reCaptcha private key for the contact form reCaptcha. See documentation for more information', 'fairpixels' ); ?></span>
									</div>
																		
								</div> <!-- /fields-wrap -->								
								
							</div><!-- /tab_block -->
														
							<div id="blog" class="tab_block">		
								<h2><?php _e('Blog Settings', 'fairpixels'); ?></h2>	
								
								<div class="fields_wrap">
								
									<div class="field infobox">
										<p><strong><?php _e('Settings for single posts, pages, images and archives', 'fairpixels'); ?></strong></p>
										<?php _e('You can adjust single posts, pages images and archive settings.', 'fairpixels'); ?>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_show_post_meta]"><?php _e('Show Post Meta', 'fairpixels'); ?></label>
										<input id="fp_options[fp_show_post_meta]" name="fp_options[fp_show_post_meta]" type="checkbox" value="1" <?php isset($options['fp_show_post_meta']) ? checked( '1', $options['fp_show_post_meta'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to show post meta in the posts.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_show_post_social]"><?php _e('Show Post Social', 'fairpixels'); ?></label>
										<input id="fp_options[fp_show_post_social]" name="fp_options[fp_show_post_social]" type="checkbox" value="1" <?php isset($options['fp_show_post_social']) ? checked( '1', $options['fp_show_post_social'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to show post social sharing links in the post meta.', 'fairpixels' ); ?></span>
									</div>
									
									
									<div class="field">
										<label for="fp_options[fp_show_related_posts]"><?php _e('Show Related Posts', 'fairpixels'); ?></label>
										<input id="fp_options[fp_show_related_posts]" name="fp_options[fp_show_related_posts]" type="checkbox" value="1" <?php isset($options['fp_show_related_posts']) ? checked( '1', $options['fp_show_related_posts'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to show related posts below single posts.', 'fairpixels' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="fp_options[fp_show_post_nav]"><?php _e('Show Post Nav', 'fairpixels'); ?></label>
										<input id="fp_options[fp_show_post_nav]" name="fp_options[fp_show_post_nav]" type="checkbox" value="1" <?php isset($options['fp_show_post_nav']) ? checked( '1', $options['fp_show_post_nav'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc long"><?php _e( 'Check if you want to show the next and previous post links.', 'fairpixels' ); ?></span>
									</div>
									
									<div class="field">
										<label for="fp_options[fp_show_post_author]"><?php _e('Show Post Author', 'fairpixels'); ?></label>
										<input id="fp_options[fp_show_post_author]" name="fp_options[fp_show_post_author]" type="checkbox" value="1" <?php isset($options['fp_show_post_author']) ? checked( '1', $options['fp_show_post_author'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to show the post author.', 'fairpixels' ); ?></span>
									</div>							
																		
								</div> <!-- /fields-wrap -->
																
							</div><!-- /tab_block -->
							
							<div id="sidebars" class="tab_block">
								<h2><?php _e('Sidebars', 'fairpixels'); ?></h2>
									<div class="fields_wrap">
										<div class="field infobox">
											<p><strong><?php _e('Unlimited Sidebars', 'fairpixels'); ?></strong></p>
											<?php _e('You can create as many sidebars you wish. Once you have created the sidebar, you can select the widgets for it from the widgets section on your WordPress dashboard.', 'fairpixels'); ?>
										</div>	
										
										<h3><?php _e('Create Sidebar', 'fairpixels'); ?></h3>
										
										<div class="field">
											<label><?php _e('Sidebar Name', 'fairpixels'); ?></label>
											<input id="fp_custom_sidebar_name" type="text" name="fp_custom_sidebar_name" class="add-sidebar" value="" />
											<input id="fp_custom_sidebar_add_button"  class="settings_button" type="button" value="Create" />
										</div>
										<div class="field">
											<ul id="fp_options_sidebar_list">
												<?php														
													$sidebars = "";													
													if (isset($options['fp_custom_sidebars'])){
														$sidebars = $options['fp_custom_sidebars'] ;
													}																
													
													if($sidebars){
														foreach ($sidebars as $sidebar) { ?>
															<li>
																<div class="sidebar-block"><?php echo $sidebar ?>  
																	<input name="fp_options[fp_custom_sidebars][]" type="hidden" value="<?php echo $sidebar ?>" /><a class="sidebar-remove"></a></div>
															</li>
														<?php }
													}													
												?>
											</ul>
										</div>
										
										<h3><?php _e('Custom Sidebars', 'fairpixels'); ?></h3>
										
										<div class="field">
											<label><?php _e('Homepage Sidebar', 'fairpixels'); ?></label>
											<select id="fp_home_sidebar" name="fp_options[fp_home_sidebar]" class="styled">
												<option <?php selected( "" == $options['fp_home_sidebar'] ); ?> value=""><?php _e('Default', 'fairpixels'); ?></option>	
												<?php
													if($sidebars){
														foreach ($sidebars as $sidebar){?>
															<option <?php selected( $sidebar == $options['fp_home_sidebar'] ); ?> value="<?php echo $sidebar; ?>"><?php echo $sidebar ?></option>	
															<?php 
														}														
													}
												?>
											</select>											
											<span class="description slcdesc"><?php _e( 'Select sidebar for homepage.', 'fairpixels' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Single Post Sidebar', 'fairpixels'); ?></label>
											<select id="fp_single_post_sidebar" name="fp_options[fp_single_post_sidebar]" class="styled">
												<option <?php selected( "" == $options['fp_single_post_sidebar'] ); ?> value=""><?php _e('Default', 'fairpixels'); ?></option>	
												<?php
													if($sidebars){
														foreach ($sidebars as $sidebar){?>
															<option <?php selected( $sidebar == $options['fp_single_post_sidebar'] ); ?> value="<?php echo $sidebar; ?>"><?php echo $sidebar ?></option>	
															<?php 
														}														
													}
												?>
											</select>											
											<span class="description slcdesc"><?php _e( 'Select sidebar for single post.', 'fairpixels' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Single Page Sidebar', 'fairpixels'); ?></label>
											<select id="fp_single_page_sidebar" name="fp_options[fp_single_page_sidebar]" class="styled">
												<option <?php selected( "" == $options['fp_single_page_sidebar'] ); ?> value=""><?php _e('Default', 'fairpixels'); ?></option>	
												<?php
													if($sidebars){
														foreach ($sidebars as $sidebar){?>
															<option <?php selected( $sidebar == $options['fp_single_page_sidebar'] ); ?> value="<?php echo $sidebar; ?>"><?php echo $sidebar ?></option>	
															<?php 
														}														
													}
												?>
											</select>											
											<span class="description slcdesc"><?php _e( 'Select sidebar for single page.', 'fairpixels' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Category Sidebar', 'fairpixels'); ?></label>
											<select id="fp_category_sidebar" name="fp_options[fp_category_sidebar]" class="styled">
												<option <?php selected( "" == $options['fp_category_sidebar'] ); ?> value=""><?php _e('Default', 'fairpixels'); ?></option>	
												<?php
													if($sidebars){
														foreach ($sidebars as $sidebar){?>
															<option <?php selected( $sidebar == $options['fp_category_sidebar'] ); ?> value="<?php echo $sidebar; ?>"><?php echo $sidebar ?></option>	
															<?php 
														}														
													}
												?>
											</select>											
											<span class="description slcdesc"><?php _e( 'Select sidebar for category archives page.', 'fairpixels' ); ?></span>
										</div><!-- /field -->
										
										
										<div class="field">
											<label><?php _e('Archive Sidebar', 'fairpixels'); ?></label>
											<select id="fp_archive_sidebar" name="fp_options[fp_archive_sidebar]" class="styled">
												<option <?php selected( "" == $options['fp_archive_sidebar'] ); ?> value=""><?php _e('Default', 'fairpixels'); ?></option>	
												<?php
													if($sidebars){
														foreach ($sidebars as $sidebar){?>
															<option <?php selected( $sidebar == $options['fp_archive_sidebar'] ); ?> value="<?php echo $sidebar; ?>"><?php echo $sidebar ?></option>	
															<?php 
														}														
													}
												?>
											</select>											
											<span class="description slcdesc"><?php _e( 'Select sidebar for archives page.', 'fairpixels' ); ?></span>
										</div><!-- /field -->

									</div>	<!-- /fields_wrap -->	
							</div>	<!-- /tab_block -->	
							
							<div id="styles" class="tab_block">
								<h2><?php _e('Styles', 'fairpixels'); ?></h2>
								
								<div class="fields_wrap">
								
									<div class="field infobox">
										<p><strong><?php _e('Custom Styles', 'fairpixels');?></strong></p>
										<?php _e('You can change the primary color for the theme. Also you can use the custom styles for the theme by entering the custom css code.', 'fairpixels'); ?>
									</div>																	
									
									<h3><?php _e('Theme Color Schemes', 'fairpixels'); ?></h3>																	
									<div class="field">
										<label><?php _e('Theme main color', 'fairpixels'); ?></label>
										<div id="fp_primary_color_selector" class="color-pic"><div style="background-color:<?php echo $options['fp_primary_color'] ; ?>"></div></div>
										<input style="width:80px; margin-right:5px;" class="color-picker" name="fp_options[fp_primary_color]" id="fp_primary_color" type="text" value="<?php echo $options['fp_primary_color'] ; ?>" />
										<span class="description chkdesc"><?php _e( 'Select primary color for the theme.', 'fairpixels' ); ?></span>
									</div>
																										
																		
									<h3><?php _e('Custom CSS Styles', 'fairpixels'); ?></h3>	
									<div class="field">
										<label for="fp_options[fp_custom_css]"><?php _e('CSS Code', 'fairpixels'); ?></label>
										<textarea id="fp_options[fp_custom_css]" class="textarea" cols="50" rows="30" name="fp_options[fp_custom_css]"><?php echo esc_attr($options['fp_custom_css']); ?></textarea>
										<span class="description long"><?php _e( 'You can enter custom CSS code. It will overwrite the default style.', 'fairpixels' ); ?></span>							
									</div>										
								</div>
															
							</div>	<!-- /tab_block -->		
							
							<div id="typography" class="tab_block">
								<h2><?php _e('Typography', 'fairpixels'); ?></h2>
									
									<div class="fields_wrap">									
									
										<div class="field infobox">
											<p><strong><?php _e('Adjust your font styles', 'fairpixels'); ?></strong></p>
											<?php _e('You can use your custom fonts styles. If you want to use the default theme fonts, leave the fields empty. <br />
											From left to right: Font size, Font style, Line height, Margin Bottom', 'fairpixels'); ?>
										</div>
									
										<h3><?php _e('Headings', 'fairpixels'); ?></h3>
										
										<div class="field">
											<label><?php _e('Heading 1', 'fairpixels'); ?></label>
											
												<select id="fp_h1_fontsize" name="fp_options[fp_h1_fontsize]" class="styled select80">
													<option value="" <?php selected( $options['fp_h1_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['fp_h1_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
												
												<select id="fp_h1_fontstyle" name="fp_options[fp_h1_fontstyle]" class="styled select120">
													<option value="" <?php selected( $options['fp_h1_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['fp_h1_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['fp_h1_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['fp_h1_fontstyle'] == 'bold');?>>Bold</option>
													<option value="bold-italic" <?php selected( $options['fp_h1_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>	
												
												<select id="fp_h1_lineheight" name="fp_options[fp_h1_lineheight]" class="styled select80">	
													<option value="" <?php selected( $options['fp_h1_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['fp_h1_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											
												<select id="fp_h1_marginbottom" name="fp_options[fp_h1_marginbottom]" class="styled select80">
													<option value="" <?php selected( $options['fp_h1_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['fp_h1_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>												
																					
										</div><!-- /field-->
										
										<div class="field">
											<label><?php _e('Heading 2', 'fairpixels'); ?></label>											
											
												<select id="fp_h2_fontsize" name="fp_options[fp_h2_fontsize]" class="styled select80">
													<option value="" <?php selected( $options['fp_h2_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['fp_h2_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											
												<select id="fp_h2_fontstyle" name="fp_options[fp_h2_fontstyle]" class="styled select120">
													<option value="" <?php selected( $options['fp_h2_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['fp_h2_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['fp_h2_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['fp_h2_fontstyle'] == 'bold');?>>Bold</option>
													<option value="bold-italic" <?php selected( $options['fp_h2_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
												
												<select id="fp_h2_lineheight" name="fp_options[fp_h2_lineheight]" class="styled select80">
													<option value="" <?php selected( $options['fp_h2_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['fp_h2_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
												
												<select id="fp_h2_marginbottom" name="fp_options[fp_h2_marginbottom]" class="styled select80">
													<option value="" <?php selected( $options['fp_h2_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['fp_h2_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Heading 3', 'fairpixels'); ?></label>
											
												<select id="fp_h3_fontsize" name="fp_options[fp_h3_fontsize]" class="styled select80">
													<option value="" <?php selected( $options['fp_h3_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['fp_h3_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											
												<select id="fp_h3_fontstyle" name="fp_options[fp_h3_fontstyle]" class="styled select120">
													<option value="" <?php selected( $options['fp_h3_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['fp_h3_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['fp_h3_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['fp_h3_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['fp_h3_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>			
																			
												<select id="fp_h3_lineheight" name="fp_options[fp_h3_lineheight]" class="styled select80">
													<option value="" <?php selected( $options['fp_h3_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['fp_h3_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											
												<select id="fp_h3_marginbottom" name="fp_options[fp_h3_marginbottom]" class="styled select80">
													<option value="" <?php selected( $options['fp_h3_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['fp_h3_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>											
										</div><!-- /feild -->
										
										<div class="field">
											<label><?php _e('Heading 4', 'fairpixels'); ?></label>
											
												<select id="fp_h4_fontsize" name="fp_options[fp_h4_fontsize]" class="styled select80">
													<option value="" <?php selected( $options['fp_h4_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['fp_h4_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
																						
												<select id="fp_h4_fontstyle" name="fp_options[fp_h4_fontstyle]" class="styled select120">
													<option value="" <?php selected( $options['fp_h4_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['fp_h4_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['fp_h4_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['fp_h4_fontstyle'] == 'bold');?>>Bold</option>
													<option value="bold-italic" <?php selected( $options['fp_h4_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>						
																																	
												<select id="fp_h4_lineheight" name="fp_options[fp_h4_lineheight]" class="styled select80">
													<option value="" <?php selected( $options['fp_h4_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['fp_h4_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
										
												<select id="fp_h4_marginbottom" name="fp_options[fp_h4_marginbottom]" class="styled select80">
													<option value="" <?php selected( $options['fp_h4_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['fp_h4_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
											
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Heading 5', 'fairpixels'); ?></label>
																				
												<select id="fp_h5_fontsize" name="fp_options[fp_h5_fontsize]" class="styled select80">
													<option value="" <?php selected( $options['fp_h5_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['fp_h5_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
												
												<select id="fp_h5_fontstyle" name="fp_options[fp_h5_fontstyle]" class="styled select120">
													<option value="" <?php selected( $options['fp_h5_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['fp_h5_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['fp_h5_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['fp_h5_fontstyle'] == 'bold');?>>Bold</option>
													<option value="bold-italic" <?php selected( $options['fp_h5_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>	
												
												<select id="fp_h5_lineheight" name="fp_options[fp_h5_lineheight]" class="styled select80">
													<option value="" <?php selected( $options['fp_h5_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['fp_h5_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											
												<select id="fp_h5_marginbottom" name="fp_options[fp_h5_marginbottom]" class="styled select80">
													<option value="" <?php selected( $options['fp_h5_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['fp_h5_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>				
																						
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Heading 6', 'fairpixels'); ?></label>
											
												<select id="fp_h6_fontsize" name="fp_options[fp_h6_fontsize]" class="styled select80">
													<option value="" <?php selected( $options['fp_h6_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['fp_h6_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											
												<select id="fp_h6_fontstyle" name="fp_options[fp_h6_fontstyle]" class="styled select120">
													<option value="" <?php selected( $options['fp_h6_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['fp_h6_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['fp_h6_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['fp_h6_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['fp_h6_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
																						
												<select id="fp_h6_lineheight" name="fp_options[fp_h6_lineheight]" class="styled select80">
													<option value="" <?php selected( $options['fp_h6_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['fp_h6_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
										
												<select id="fp_h6_marginbottom" name="fp_options[fp_h6_marginbottom]" class="styled select80">
													<option value="" <?php selected( $options['fp_h6_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['fp_h6_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>	
										
										</div><!-- /field -->
										
										<h3><?php _e('Text Font Styles', 'fairpixels'); ?></h3>
										
										<div class="field">
											<label><?php _e('Text', 'fairpixels'); ?></label>
											
												<select id="fp_text_fontsize" name="fp_options[fp_text_fontsize]" class="styled select80">
													<option value="" <?php selected( $options['fp_text_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['fp_text_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
																															
												<select id="fp_text_fontstyle" name="fp_options[fp_text_fontstyle]" class="styled select120">
													<option value="" <?php selected( $options['fp_text_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['fp_text_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['fp_text_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['fp_text_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['fp_text_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
																						
												<select id="fp_text_lineheight" name="fp_options[fp_text_lineheight]" class="styled select80">
													<option value="" <?php selected( $options['fp_text_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['fp_text_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											
											<span class="description txtfontdesc long"><?php _e( 'Select font style for text. From left to right: Font Size, Font Style, Line Height', 'fairpixels' ); ?></span>
											
										</div><!-- /field-->
										
										<h3><?php _e('Font', 'fairpixels'); ?></h3>
										<?php $fonts_list= fp_get_google_fonts(); ?>
										<div class="field">
											<label><?php _e('Headings Font', 'fairpixels'); ?></label>
												<select id="fp_headings_font_name" name="fp_options[fp_headings_font_name]" class="styled select-wide">
													<option <?php selected( "" == $options['fp_headings_font_name'] ); ?> value=""></option>
													<?php foreach( $fonts_list as $font => $font_name ){ ?>
														<option <?php selected( $font == $options['fp_headings_font_name'] ); ?> value="<?php echo $font; ?>"><?php echo $font_name ?></option>	
													<?php } ?>
												</select>
											
											<span class="description txtfontdesc"><?php _e( 'Select font for Headings.', 'fairpixels' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Text Font', 'fairpixels'); ?></label>
												<select id="fp_text_font_name" name="fp_options[fp_text_font_name]" class="styled select-wide">
													<option <?php selected( "" == $options['fp_text_font_name'] ); ?> value=""></option>
													<?php foreach( $fonts_list as $font => $font_name ){ ?>
													<option <?php selected( $font == $options['fp_text_font_name'] ); ?> value="<?php echo $font; ?>"><?php echo $font_name; ?></option>	
													<?php } ?>
												</select>
											
											<span class="description txtfontdesc"><?php _e( 'Select font for Text.', 'fairpixels' ); ?></span>
										</div><!-- /field -->
										
										<h3><?php _e('Color Schemes', 'fairpixels'); ?></h3>
																				
										<div class="field">
											<label><?php _e('Text Color', 'fairpixels'); ?></label>
											<div id="fp_text_color_selector" class="color-pic"><div style="background-color:<?php echo $options['fp_text_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="fp_options[fp_text_color]" id="fp_text_color" type="text" value="<?php echo $options['fp_text_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select the text color.', 'fairpixels' ); ?></span>
										</div>									
										
										<div class="field">
											<label><?php _e('Links Color', 'fairpixels'); ?></label>
											<div id="fp_links_color_selector" class="color-pic"><div style="background-color:<?php echo $options['fp_links_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="fp_options[fp_links_color]" id="fp_links_color" type="text" value="<?php echo $options['fp_links_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select the links color.', 'fairpixels' ); ?></span>
										</div>
										
										<div class="field">
											<label><?php _e('Links Hover Color', 'fairpixels'); ?></label>
											<div id="fp_links_hover_color_selector" class="color-pic"><div style="background-color:<?php echo $options['fp_links_hover_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="fp_options[fp_links_hover_color]" id="fp_links_hover_color" type="text" value="<?php echo $options['fp_links_hover_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select links hover color.', 'fairpixels' ); ?></span>
										</div>
										
									</div><!-- /fields_wrap -->	
																	
							</div><!-- /tab_block -->
							
							<div id="footer" class="tab_block">
								<h2><?php _e('Header and Footer Settings', 'fairpixels'); ?></h2>
									<div class="fields_wrap">
									
									<div class="field infobox">
										<p><strong><?php _e('Using Site Analytics Codes', 'fairpixels'); ?></strong></p>
										<?php _e('You can use site analytics codes in the header of footer.', 'fairpixels'); ?>
									</div>
									
									<h3><?php _e('Header Settings', 'fairpixels'); ?></h3>
									
									
									<div class="field">
										<label for="fp_options[fp_header_ad]"><?php _e('Header ad code.', 'fairpixels'); ?></label>
										<textarea id="fp_options[fp_header_ad]" class="textarea" name="fp_options[fp_header_ad]"><?php echo esc_attr($options['fp_header_ad']); ?></textarea>
										<span class="description"><?php _e( 'Enter full code for header banner. Leave blank to disable', 'fairpixels' ); ?></span>		
									</div>
									
									<div class="field">
										<label for="fp_options[fp_header_code]"><?php _e('Header code.', 'fairpixels'); ?></label>
										<textarea id="fp_options[fp_header_code]" class="textarea" name="fp_options[fp_header_code]"><?php echo esc_attr($options['fp_header_code']); ?></textarea>
										<span class="description"><?php _e( 'You can add any code, that will appear in the document head.', 'fairpixels' ); ?></span>		
									</div>
									
									<h3><?php _e('Footer Settings', 'fairpixels'); ?></h3>									
									<div class="field">
										<label for="fp_options[fp_footer_text_left]"><?php _e('Footer Text.', 'fairpixels'); ?></label>
										<textarea id="fp_options[fp_footer_text_left]" class="textarea" name="fp_options[fp_footer_text_left]"><?php echo esc_attr($options['fp_footer_text_left']); ?></textarea>
										<span class="description"><?php _e( 'Enter the footer left side text.', 'fairpixels' ); ?></span>					
									</div>								
																	
									<div class="field">
										<label for="fp_options[fp_footer_code]"><?php _e('Footer Code', 'fairpixels'); ?></label>
										<textarea id="fp_options[fp_footer_code]" class="textarea" name="fp_options[fp_footer_code]"><?php echo esc_attr($options['fp_footer_code']); ?></textarea>
										<span class="description"><?php _e( 'You can add any code eg. Google Analytics. It will appear in <strong>footer</strong> section.', 'fairpixels' ); ?></span>
									</div>
									
									</div> <!-- /fields-wrap -->
									
							</div>	<!-- /tab_block -->	
							
							<div id="reset" class="tab_block">
								<h2><?php _e('Reset Theme Settings', 'fairpixels'); ?></h2>
									<div class="fields_wrap">
										<div class="field warningbox">
											<p><strong><?php _e('Please Note', 'fairpixels'); ?></strong></p>
											<?php _e('You will lose all your theme settings and custom sidebar. The theme will restore default settings.', 'fairpixels'); ?>
										</div>
													
										<div class="field">
											<p class="reset-info"><?php _e('If you want to reset the theme settings.', 'fairpixels');?> </p>
											<input type="submit" name="fp_options[reset]" class="button-primary" value="<?php _e( 'Reset Settings', 'fairpixels' ); ?>" />
										</div>
									</div>	<!-- /fields_wrap -->	
							</div>	<!-- /tab_block -->	
					
						</div> <!-- /option_blocks -->			
						
					
		
			</div> <!-- /options-form -->
		</div> <!-- /options-wrap -->
		<div class="options-footer">
			<input type="submit" name="fp_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'fairpixels' ); ?>" />
		</div>
		</form>
	</div> <!-- /fp-options -->
	<?php
}

/**
 * Return default array of options
 */
function fp_default_options() {
	$options = array(
		'fp_logo_url' => get_template_directory_uri().'/images/logo.png',	
		'fp_favicon' => '',
		'fp_apple_touch' => '',
		'fp_rss_url' => '',		
		'fp_twitter_url' => '',
		'fp_fb_url' => '',
		'fp_gplus_url' => '',
		'fp_linkedin_url' => '',
		'fp_pinterest_url' => '',
		'fp_instagram_url' => '',
		'fp_dribbble_url' => '',		
		'fp_youtube_url' => '',
		'fp_contact_address' => '',
		'fp_contact_email' => '',	
		'fp_recaptcha_public_key' => '',
		'fp_recaptcha_private_key' => '',
		'fp_contact_subject' => '',
		'fp_custom_sidebars' => '',
		'fp_home_sidebar' => '',
		'fp_single_post_sidebar' => '',
		'fp_single_page_sidebar' => '',
		'fp_archive_sidebar' => '',	
		'fp_category_sidebar' => '',
		'fp_show_header_social' => 0,
		'fp_show_post_meta' => 1,
		'fp_show_post_social' => 1,		
		'fp_show_post_author' => 1,	
		'fp_show_post_nav' => 1,				
		'fp_show_related_posts' => 1,	
		'fp_primary_color' => '',
		'fp_h1_fontsize' => '',
		'fp_h2_fontsize' => '',
		'fp_h3_fontsize' => '',	
		'fp_h4_fontsize' => '',	
		'fp_h5_fontsize' => '',	
		'fp_h6_fontsize' => '',	
		'fp_text_fontsize' => '',	
		'fp_h1_fontstyle' => '',
		'fp_h2_fontstyle' => '',
		'fp_h3_fontstyle' => '',
		'fp_h4_fontstyle' => '',
		'fp_h5_fontstyle' => '',
		'fp_h6_fontstyle' => '',	
		'fp_text_fontstyle' => '',
		'fp_h1_lineheight' => '',
		'fp_h2_lineheight' => '',
		'fp_h3_lineheight' => '',
		'fp_h4_lineheight' => '',
		'fp_h5_lineheight' => '',
		'fp_h6_lineheight' => '',
		'fp_text_lineheight' => '',
		'fp_h1_marginbottom' => '',	
		'fp_h2_marginbottom' => '',	
		'fp_h3_marginbottom' => '',	
		'fp_h4_marginbottom' => '',	
		'fp_h5_marginbottom' => '',	
		'fp_h6_marginbottom' => '',	
		'fp_text_font_name' => '',
		'fp_headings_font_name' => '',
		'fp_text_color' => '',
		'fp_links_color' => '',
		'fp_links_hover_color' => '',		
		'fp_custom_css' => '',
		'fp_header_code' => '',		
		'fp_header_ad' => '<a href="#"><img src="'. get_template_directory_uri().'/images/banner.jpg" /></a>',		
		'fp_footer_text_left' => '&copy;'. date('Y') . ' '. get_bloginfo('name').' Designed by <a href="http://fairpixels.com">FairPixels.com</a>',
		'fp_footer_code' => ''		
	);
	return $options;
}

/**
 * Sanitize and validate options
 */
function fp_validate_options( $input ) {
	$submit = ( ! empty( $input['submit'] ) ? true : false );
	$reset = ( ! empty( $input['reset'] ) ? true : false );
	if( $submit ) :	
		
		$input['fp_logo_url'] = esc_url_raw($input['fp_logo_url']);
		$input['fp_favicon'] = esc_url_raw($input['fp_favicon']);
		$input['fp_apple_touch'] = esc_url_raw($input['fp_apple_touch']);		
		$input['fp_rss_url'] = esc_url_raw($input['fp_rss_url']);
		$input['fp_fb_url'] = esc_url_raw($input['fp_fb_url']);
		$input['fp_twitter_url'] = esc_url_raw($input['fp_twitter_url']);
		$input['fp_gplus_url'] = esc_url_raw($input['fp_gplus_url']);
		$input['fp_pinterest_url'] = esc_url_raw($input['fp_pinterest_url']);
		$input['fp_dribbble_url'] = esc_url_raw($input['fp_dribbble_url']);
		$input['fp_linkedin_url'] = esc_url_raw($input['fp_linkedin_url']);	
		$input['fp_instagram_url'] = esc_url_raw($input['fp_instagram_url']);	
		$input['fp_youtube_url'] = esc_url_raw($input['fp_youtube_url']);		
		$input['fp_contact_address'] = wp_kses_stripslashes($input['fp_contact_address']);
		$input['fp_contact_email'] = wp_filter_nohtml_kses($input['fp_contact_email']);
		$input['fp_recaptcha_public_key'] = wp_filter_nohtml_kses($input['fp_recaptcha_public_key']);
		$input['fp_recaptcha_private_key'] = wp_filter_nohtml_kses($input['fp_recaptcha_private_key']);	
		$input['fp_contact_subject'] = wp_kses_stripslashes($input['fp_contact_subject']);
		$input['fp_text_color'] = wp_filter_nohtml_kses($input['fp_text_color']);
		$input['fp_links_hover_color'] = wp_filter_nohtml_kses($input['fp_links_hover_color']);
		$input['fp_primary_color'] = wp_filter_nohtml_kses($input['fp_primary_color']);	
		$input['fp_custom_css'] = wp_kses_stripslashes($input['fp_custom_css']);		
		$input['fp_header_ad'] = wp_kses_stripslashes($input['fp_header_ad']);
		$input['fp_header_code'] = wp_kses_stripslashes($input['fp_header_code']);		
		$input['fp_footer_text_left'] = wp_kses_stripslashes($input['fp_footer_text_left']);
		$input['fp_footer_code'] = wp_kses_stripslashes($input['fp_footer_code']);		
					
		if ( ! isset( $input['fp_show_header_social'] ) )
			$input['fp_show_header_social'] = null;
		$input['fp_show_header_social'] = ( $input['fp_show_header_social'] == 1 ? 1 : 0 );
				
		if ( ! isset( $input['fp_show_post_meta'] ) )
			$input['fp_show_post_meta'] = null;
		$input['fp_show_post_meta'] = ( $input['fp_show_post_meta'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['fp_show_post_social'] ) )
			$input['fp_show_post_social'] = null;
		$input['fp_show_post_social'] = ( $input['fp_show_post_social'] == 1 ? 1 : 0 );		
		
		if ( ! isset( $input['fp_show_post_nav'] ) )
			$input['fp_show_post_nav'] = null;
		$input['fp_show_post_nav'] = ( $input['fp_show_post_nav'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['fp_show_post_author'] ) )
			$input['fp_show_post_author'] = null;
		$input['fp_show_post_author'] = ( $input['fp_show_post_author'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['fp_show_related_posts'] ) )
			$input['fp_show_related_posts'] = null;
		$input['fp_show_related_posts'] = ( $input['fp_show_related_posts'] == 1 ? 1 : 0 );	
			
		return $input;
		
	elseif( $reset ) :
		$input = fp_default_options();
		return $input;
		
	endif;
}

if ( ! function_exists( 'fp_get_settings' ) ) :
/**
 * Used to output theme options is an elegant way
 * @uses get_option() To retrieve the options array
 */
function fp_get_settings( $option ) {
	$options = get_option( 'fp_options', fp_default_options() );
	return isset($options[ $option ]) ?  $options[ $option ] : '';
}
endif;