<?php

/**

 * Plugin Name: FairPixels Homepage Featured Category

 * Description: This widget allows to display latest posts on the homepage

 * Version: 1.0

 * Author: FairPixels

 * Author URI: http://fairpixels.com

 *

 */



/**

 * Add function to widgets_init that'll load our widget.

 */

add_action('widgets_init', 'fp_register_home_carousel_widget');

function fp_register_home_carousel_widget(){

	register_widget('fp_home_carousel_widget');

}



/**

 * This class handles everything that needs to be handled with the widget:

 * the settings, form, display, and update.  Nice!

 *

 */ 

class fp_home_carousel_widget extends WP_Widget {

	

	/**

	 * Widget setup.

	 */

	function fp_home_carousel_widget(){

		/* Widget settings. */	

		$widget_ops = array('classname' => 'feat-carousel', 'description' => 'Displays the carousel on homepage.');

		

		/* Create the widget. */

		$this->WP_Widget('fp_home_carousel_widget', 'FairPixels: Homepage Carousel', $widget_ops);

	}

	

	/**

	 * display the widget on the screen.

	 */

	function widget($args, $instance){	

		 		

		extract($args);

		$widget_id = $args['widget_id'];

		

		echo $before_widget;				

		$cat_id = isset($instance['cat_id']) ? $instance['cat_id'] : '';

		$title = isset($instance['title']) ? $instance['title'] : '';

		$subtitle = isset($instance['subtitle']) ? $instance['subtitle'] : '';		

						

		$query_args = array(

				'showposts' => 4,

				'cat' => $cat_id,

				'post_type' => 'post',

				'post_status' => 'publish',

				'ignore_sticky_posts' => 1

			);

		global $paged;

		

		if (!empty($title)) { ?>			

			

			<div class="section-title">

				<span class="carousel-prev"></span>

				<div class="title-wrap">

					<?php if (empty($title)){ 

						$cat_url = get_category_link($cat_id );

						$cat_name = get_cat_name($cat_id);	?>

						<h4><a href="<?php echo $cat_url; ?>"><?php echo $cat_name; ?></a></h4>

					<?php } else{ ?>

						<h4><?php echo $title; ?></h4>

					<?php } ?>

					<?php if ($subtitle) { ?>

						<h6><?php echo $subtitle; ?></h6>

					<?php } ?>

				</div>

				<span class="carousel-next"></span>

			</div>

			

	<?php } ?>

		<script>

			jQuery(document).ready(function($) {				

				$(".carousel-posts").show();

				$('#<?php echo $widget_id; ?> .carousel-posts').bxSlider({

					minSlides: 1,

					maxSlides: 4,

					slideWidth: 240,

					slideMargin: 22,

					controls: true,

					adaptiveHeight: false,

					pager: false,

					nextSelector: '#<?php echo $widget_id; ?> .carousel-next',

					prevSelector: '#<?php echo $widget_id; ?> .carousel-prev'			  

				});

			});

		</script>

		<ul class="carousel-posts list">

		<?php $query = new WP_Query( $query_args ); ?>

		<?php if ( $query -> have_posts() ) : ?>			

			<?php $last_post  = $query -> post_count -1; ?>

			<?php while ( $query -> have_posts() ) : $query -> the_post(); 

				global $post;		?>	

				

				<?php if ( has_post_thumbnail()) { ?>				

						<li>

							<div class="thumb overlay">

								<a href="<?php the_permalink(); ?>" >

									<?php the_post_thumbnail( 'fp240_165' ); ?>

								</a>

							</div>

								

							<div class="post-info">

																		

								<h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>

								<div class="entry-meta">

									<span class="date">

										<?php echo get_the_date(); ?>

									</span>																

									

									<?php if ( comments_open() ) : ?>

										<span class="sep">&#47;</span>

										<span class="comments">

											<?php comments_popup_link( __('no comments', 'fairpixels'), __( '1 comment', 'fairpixels'), __('% comments', 'fairpixels')); ?>

										</span>		

									<?php endif; ?>

								</div>									

								

							</div>											

						</li>							

					<?php } ?>				

				

			<?php endwhile; ?>

		<?php endif; ?>		

		<?php wp_reset_query();?>

			</ul>				

			<?php

		echo $after_widget;

	}

	

	/**

	 * update widget settings

	 */

	function update($new_instance, $old_instance){

		$instance = $old_instance;	

		$instance['title'] = $new_instance['title'];

		$instance['subtitle'] = $new_instance['subtitle'];		

		$instance['cat_id'] = $new_instance['cat_id'];

		

		return $instance;

	}

	

	/**

	 * Displays the widget settings controls on the widget panel.

	 * Make use of the get_field_id() and get_field_name() function

	 * when creating your form elements. This handles the confusing stuff.

	 */	

	function form($instance){

		$defaults = array('title' => '', 'subtitle' => '', 'cat_id' => '');

		$instance = wp_parse_args((array) $instance, $defaults); ?>

		

		<div class="widget-field">			

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'fairpixels'); ?></label>

			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />

			<p class="desc"><?php _e('Enter the section title', 'fairpixels'); ?></p>

		</div>

		

		<div class="widget-field">			

			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e('Subtitle:', 'fairpixels'); ?></label>

			<input type="text" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" value="<?php echo $instance['subtitle']; ?>" />

			<p class="desc"><?php _e('Enter the section subtitle', 'fairpixels'); ?></p>

		</div>

		

		<div class="widget-field">	

			<label for="<?php echo $this->get_field_id('cat_id'); ?>"><?php _e('Categoria:', 'fairpixels'); ?></label>

			<select id="<?php echo $this->get_field_id('cat_id'); ?>" name="<?php echo $this->get_field_name('cat_id'); ?>" class="widefat categories">

				<option value='' <?php if ('' == $instance['cat_id']) echo 'selected="selected"'; ?>><?php _e('All categories', 'fairpixels'); ?></option>

				<?php $categories = get_categories('hide_empty=1'); ?>

				<?php foreach($categories as $category) { ?>

				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['cat_id']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>

				<?php } ?>

			</select>

		</div>

		

		

	<?php }

}

?>