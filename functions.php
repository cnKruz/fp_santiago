<?php

/**

 * FairPixels functions and definitions.

 *

 * Sets up the theme and provides some helper functions, which are used in the

 * theme as custom template tags. Others are attached to action and filter

 * hooks in WordPress to change core functionality.

 *

 * When using a child theme (see http://codex.wordpress.org/Theme_Development

 * and http://codex.wordpress.org/Child_Themes), you can override certain

 * functions (those wrapped in a function_exists() call) by defining them first

 * in your child theme's functions.php file. The child theme's functions.php

 * file is included before the parent theme's file, so the child theme

 * functions would be used.

 *

 * Functions that are not pluggable (not wrapped in function_exists()) are

 * instead attached to a filter or action hook.

 *

 * For more information on hooks, actions, and filters,

 * see http://codex.wordpress.org/Plugin_API

 *

 * @package  WordPress

 * @file     functions.php

 * @author   FairPixels

 * @link 	 http://fairpixels.com

 */



require( get_template_directory() . '/framework/functions.php' );



/**

 * Set the format for the more in excerpt, return ... instead of [...]

 */ 

function fairpixels_excerpt_more( $more ) {

	return '...';

}

add_filter('excerpt_more', 'fairpixels_excerpt_more');



// custom excerpt length

function fairpixels_excerpt_length( $length ) {

    return 100;

}

add_filter( 'excerpt_length', 'fairpixels_excerpt_length');



/**

 * Load our homepage widgets

 */

require( get_template_directory() . '/homepage/widget_featured_cat_large.php' );	

require( get_template_directory() . '/homepage/widget_featured_cat.php' );

require( get_template_directory() . '/homepage/widget_home_carousel.php' );

	

/**

 * Template for comments and pingbacks.

 *

 * To override this walker in a child theme without modifying the comments template

 * simply create your own fairpixels_comments(), and that function will be used instead.

 *

 * Used as a callback by wp_list_comments() for displaying the comments.

 *

 */

if ( ! function_exists( 'fairpixels_comments' ) ) :

function fairpixels_comments( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

	global $post;

	

	switch ( $comment->comment_type ) :

		case '' :

		

		if($comment->user_id == $post->post_author) {

			$author_text = '<span class="author-comment main-color-bg">Author</span>';

		} else {

			$author_text = '';

		}

		

	?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

		<article id="comment-<?php comment_ID(); ?>">

		

			<div class="author-avatar">

				<a href="<?php comment_author_url()?>"><?php echo get_avatar( $comment, 60 ); ?></a>

			</div>			

		

			<div class="comment-right">

				

				<div class="comment-header">

						<h5><?php printf( __( '%s', 'fairpixels' ), sprintf( '<cite class="fn cufon">%s</cite>', get_comment_author_link() ) ); ?></h5>

						<?php echo $author_text; ?>

				</div>

					

				<div class="comment-meta">					

					

					<span class="comment-time">

						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">

						<?php

							/* translators: 1: date, 2: time */

							printf( __( '%1$s at %2$s', 'fairpixels' ), get_comment_date(),  get_comment_time() ); ?></a>

					</span>

					<span class="sep">-</span>

					<span class="reply">

						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'fairpixels' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

					</span>

				

					

					

					<?php edit_comment_link( __( '[ Edit ]', 'fairpixels' ), '<span class="edit-link">', '</span>' ); ?>

				</div><!-- /comment-meta -->

			

				<div class="comment-text">

					<?php comment_text(); ?>

				</div>

		

				<?php if ( $comment->comment_approved == '0' ) : ?>

					<p class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'fairpixels' ); ?></p>

				<?php endif; ?>



				<!-- /reply -->

		

			</div><!-- /comment-right -->

		

		</article><!-- /comment  -->



	<?php

			break;

		case 'pingback'  :

		case 'trackback' :

	?>

	<li class="post pingback">

		<p><?php _e( 'Pingback:', 'fairpixels' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '[ Edit ]', 'fairpixels' ), '<span class="edit-link">', '</span>' ); ?></p>

	<?php	

			break;

	endswitch;

}

endif;	//ends check for fairpixels_comments()



/**

 * Set the main menu fallback

 */

 

if ( ! function_exists( 'fp_main_menu_fallback' ) ) :

	

	function fp_main_menu_fallback() { ?>

		<ul class="menu">

			<?php

				wp_list_categories(array(

					'number' => 5,

					'exclude' => '1',

					'title_li' => '',

					'orderby' => 'count',

					'order' => 'DESC'  

				));

			?>  

		</ul>

    <?php

	}



endif; // ends check for fp_main_menu_fallback()



function getPostViews($postID){

    $count_key = 'post_views_count';

    $count = get_post_meta($postID, $count_key, true);

    if($count==''){

        delete_post_meta($postID, $count_key);

        add_post_meta($postID, $count_key, '0');

        return "0";

   }

   return $count;

}

 

function setPostViews($postID) {

    $count_key = 'post_views_count';

    $count = get_post_meta($postID, $count_key, true);

    if($count==''){

        $count = 0;

        delete_post_meta($postID, $count_key);

        add_post_meta($postID, $count_key, '0');

    }else{

        $count++;

        update_post_meta($postID, $count_key, $count);

    }

}



add_action( 'template_redirect', 'attachment_redirect', 1 );

/**

 * Redirect any attachment page to their parent with 301 redirection

 */

function attachment_redirect() {

  global $post;

  if ( is_attachment() AND isset( $post->post_parent) AND is_numeric( $post->post_parent ) ) {

    wp_redirect( get_permalink( $post->post_parent ), 301 );

    exit();

  }

}
//se manda a llamar desde content-excerpt.php
function get_excerpt($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  //elimina los extractos que tengan etiquetas que no deben ser visibles
  if($excerpt[0] == '['){
	$excerpt = '...';
  }
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = $excerpt.'... <div id="mas"><a class="botonMas" href="'.$permalink.'">+</a></div>';
  return $excerpt;
}

function get_excerpt2($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = $excerpt.'... <div id="mas"><a class="botonMas2" href="'.$permalink.'">+</a></div>';
  return $excerpt;
}

function get_excerpt3($count){
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
  $excerpt = $excerpt.'... <div id="mas"><a class="botonMas3" href="'.$permalink.'">+</a></div>';
  return $excerpt;
}

?>