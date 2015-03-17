<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package  WordPress
 * @file     sidebar.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
 ?> 
<?php
	$sidebar_name ="";	
	
	if ( is_home() ){	
		$homepage_sidebar = fp_get_settings( 'fp_home_sidebar' );
		$sidebar_name = sanitize_title( $homepage_sidebar );		
	} elseif ( is_single() ){
		$single_post_sidebar = get_post_meta($post->ID, 'fp_meta_post_sidebar_name', true);
		$sidebar_name = sanitize_title($single_post_sidebar);
		
		if (empty( $sidebar_name)){
			$single_post_sidebar = fp_get_settings( 'fp_single_post_sidebar' );
			$sidebar_name = sanitize_title( $single_post_sidebar );	
		}	
		
	} elseif( is_page() ){
		
		$single_page_sidebar = get_post_meta($post->ID, 'fp_meta_post_sidebar_name', true);
		$sidebar_name = sanitize_title($single_page_sidebar);
		
		if (empty( $sidebar_name)){
			$single_page_sidebar = fp_get_settings( 'fp_single_page_sidebar' );
			$sidebar_name = sanitize_title( $single_page_sidebar );	
		}
		
	} elseif ( is_category() ){
		$category_sidebar = fp_get_settings( 'fp_category_sidebar' );
		$sidebar_name = sanitize_title( $category_sidebar );	
	} elseif ( is_archive() ){
		$archive_sidebar = fp_get_settings( 'fp_archive_sidebar' );
		$sidebar_name = sanitize_title( $archive_sidebar );
	} else {
		$sidebar_name = 'sidebar-1';
	}
	
	if ( empty($sidebar_name) ){
		$sidebar_name = 'sidebar-1';
	}	
	?>
	<div id="sidebar">
		<?php dynamic_sidebar( $sidebar_name );	 ?>
	</div><!-- /sidebar -->