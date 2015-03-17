<?php



/**

 * Tell WordPress to run fairpixels_theme_setup() when the 'after_setup_theme' hook is run.

 */

 

add_action( 'after_setup_theme', 'fairpixels_theme_setup' );



if ( ! function_exists( 'fairpixels_theme_setup' ) ):



function fairpixels_theme_setup() {



	/**

	 * Load up our required theme files.

	 */

	require( get_template_directory() . '/framework/settings/theme-options.php' );

	require( get_template_directory() . '/framework/settings/option-functions.php' );	

	require( get_template_directory() . '/framework/meta/meta_post.php' );



	/**

	 * Load our theme widgets

	 */

	require( get_template_directory() . '/framework/widgets/widget_flickr.php' );

	require( get_template_directory() . '/framework/widgets/widget_tabs.php' );

	require( get_template_directory() . '/framework/widgets/widget_video.php' );

	require( get_template_directory() . '/framework/widgets/widget_pinterest.php' );

	require( get_template_directory() . '/framework/widgets/widget_recent_comments.php' );

	require( get_template_directory() . '/framework/widgets/widget_adsingle.php' );

	require( get_template_directory() . '/framework/widgets/widget_slider.php' );

	require( get_template_directory() . '/framework/widgets/widget_social.php' );

	require( get_template_directory() . '/framework/widgets/widget_subscribe.php' );

	require( get_template_directory() . '/framework/widgets/widget_popular_categories.php' );

	require( get_template_directory() . '/framework/widgets/widget_subscribers_count.php' );

	require( get_template_directory() . '/framework/widgets/widget_recent_posts.php' );



	

	/* Add translation support.

	 * Translations can be added to the /languages/ directory.

	 */

	load_theme_textdomain( 'fairpixels', get_template_directory() . '/languages' );

	

	/**

	 * Set the content width based on the theme's design and stylesheet.

	 */

	if ( ! isset( $content_width ) )

		$content_width = 600;

		

	/** 

	 * Add default posts and comments RSS feed links to <head>.

	 */

	add_theme_support( 'automatic-feed-links' );

	

	/**

	 * This theme styles the visual editor with editor-style.css to match the theme style.

	 */

	add_editor_style();

	

	/**

	 * Register menus

	 *

	 */

	register_nav_menus( array(

		'top-menu' => __( 'Top Menu', 'fairpixels' ),

		'primary-menu' => __( 'Primary Menu', 'fairpixels' ),

		'secondary-menu' => __( 'Secondary Menu', 'fairpixels' )					

	) );

	

	/**

	 * Add support for the featured images (also known as post thumbnails).

	 */

	if ( function_exists( 'add_theme_support' ) ) { 

		add_theme_support( 'post-thumbnails' );

	}

	

	/**

	 * Add custom image sizes

	 */

	add_image_size( 'fp770_375', 770, 375, true );			//main slider

	add_image_size( 'fp520_400', 520, 400, true );			//large category

	add_image_size( 'fp370_215', 370, 215, true );			//archives

	add_image_size( 'fp240_165', 240, 165, true );			//careousel

	add_image_size( 'fp75_75', 75, 75, true );				//feat post thumbnails	

}

endif; // fairpixels_theme_setup



/**

 * A safe way of adding JavaScripts to a WordPress generated page.

 */



if (!is_admin()){

    add_action('wp_enqueue_scripts', 'fairpixels_js');

}



if (!function_exists('fairpixels_js')) {



    function fairpixels_js() {

		wp_enqueue_script('fp_hoverIntent', get_template_directory_uri().'/js/hoverIntent.js',array('jquery'),'', true);

		wp_enqueue_script('fp_superfish', get_template_directory_uri().'/js/superfish.js',array('hoverIntent'),'', true);

		

		wp_enqueue_script('fp_lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery'),'', true); 		

		wp_enqueue_script('fp_jflickrfeed', get_template_directory_uri() . '/js/jflickrfeed.min.js', array('jquery'),'', true); 

		wp_enqueue_script('fp_touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array('jquery'),'', true); 

		wp_enqueue_script('fp_mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', array('jquery'),'', true); 		

		

		wp_enqueue_script('fp_slider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '', true); 

		wp_enqueue_script('fp_res_menu', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array('jquery'), '', true); 

		wp_enqueue_script('fp_scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'),'', true);	

		

		if (is_page_template('page-home.php')){

			wp_enqueue_script('fp_carousel', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'), '', true); 

		}

    }

	

}



/**

 * Enqueues styles for the widgets.

 *

 */ 

function fairpixels_widgets_css( $hook ) {

    if ( 'widgets.php' != $hook ) {

        return;

    }

    wp_enqueue_style( 'fp-widgets', get_template_directory_uri() . '/framework/settings/css/widgets.css' );

	wp_enqueue_style( 'wp-color-picker' );        

	wp_enqueue_script( 'wp-color-picker' ); 

}

add_action( 'admin_enqueue_scripts', 'fairpixels_widgets_css' );



/**

 * Enqueues styles for front-end.

 *

 */ 

if (!function_exists('fairpixels_css')) {

	function fairpixels_css() {

		wp_enqueue_style( 'fp-style', get_stylesheet_uri() );	

		wp_enqueue_style( 'fp-font-awesome', get_template_directory_uri().'/css/fonts/font-awesome/css/font-awesome.min.css' );	

	}

}

add_action( 'wp_enqueue_scripts', 'fairpixels_css' );





/**

 * Register our sidebars and widgetized areas.

 *

 */

 

if ( function_exists('register_sidebar') ) {

	

	register_sidebar( array(

		'name' => __( 'Homepage', 'fairpixels' ),

		'id' => 'homepage',

		'description' => __( 'Homepage widgets area', 'fairpixels' ),

		'before_widget' => '<aside id="%1$s" class="section %2$s">',

		'after_widget' => '</aside>',

	) );

	

	register_sidebar( array(

		'name' => __( 'Sidebar', 'fairpixels' ),

		'id' => 'sidebar-1',

		'description' => __( 'Main sidebar area', 'fairpixels' ),

		'before_widget' => '<aside id="%1$s" class="widget %2$s">',

		'after_widget' => '</aside>',

		'before_title' => '<div class="widget-title"><h4>',

		'after_title' => '</h4></div>',

	) );

		

	register_sidebar( array(

		'name' => __( 'Footer Widget 1', 'fairpixels' ),

		'id' => 'footer-1',

		'description' => __( 'Widget 1 area in the footer', 'fairpixels' ),

		'before_widget' => '<aside id="%1$s" class="widget %2$s">',

		'after_widget' => '</aside>',

		'before_title' => '<div class="widget-title"><h4>',

		'after_title' => '</h4></div>',

	) );

	

	register_sidebar( array(

		'name' => __( 'Footer Widget 2', 'fairpixels' ),

		'id' => 'footer-2',

		'description' => __( 'Widget 2 area in the footer', 'fairpixels' ),

		'before_widget' => '<aside id="%1$s" class="widget %2$s">',

		'after_widget' => '</aside>',

		'before_title' => '<div class="widget-title"><h4>',

		'after_title' => '</h4></div>',

	) );

	

	register_sidebar( array(

		'name' => __( 'Footer Widget 3', 'fairpixels' ),

		'id' => 'footer-3',

		'description' => __( 'Widget 3 area in the footer', 'fairpixels' ),

		'before_widget' => '<aside id="%1$s" class="widget %2$s">',

		'after_widget' => '</aside>',

		'before_title' => '<div class="widget-title"><h4>',

		'after_title' => '</h4></div>',

	) );

	

	register_sidebar( array(

		'name' => __( 'Footer Widget 4', 'fairpixels' ),

		'id' => 'footer-4',

		'description' => __( 'Widget 4 area in the footer', 'fairpixels' ),

		'before_widget' => '<aside id="%1$s" class="widget %2$s">',

		'after_widget' => '</aside>',

		'before_title' => '<div class="widget-title"><h4>',

		'after_title' => '</h4></div>',

	) );

}



/**

 * Pagination for archive, taxonomy, category, tag and search results pages

 *

 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query

 * @return Prints the HTML for the pagination if a template is $paged

 */

if ( ! function_exists( 'fp_pagination' ) ) :

function fp_pagination() {

	global $wp_query;

 

	$big = 999999999; // This needs to be an unlikely integer

 

	// For more options and info view the docs for paginate_links()

	// http://codex.wordpress.org/Function_Reference/paginate_links

	$paginate_links = paginate_links( array(

		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),

		'current' => max( 1, get_query_var('paged') ),

		'total' => $wp_query->max_num_pages,

		'mid_size' => 5

	) );

 

	// Display the pagination if more than one page is found

	if ( $paginate_links ) {

		echo '<div class="pagination">';

		echo $paginate_links;

		echo '</div><!--// end .pagination -->';

	}

}

endif; // ends check for fp_pagination()