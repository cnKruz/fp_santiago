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

add_action('widgets_init', 'fp_register_cat2_widget');

function fp_register_cat2_widget(){

	register_widget('fp_cat2_widget');

}



/**

 * This class handles everything that needs to be handled with the widget:

 * the settings, form, display, and update.  Nice!

 *

 */ 

class fp_cat2_widget extends WP_Widget {

	

	/**

	 * Widget setup.

	 */

	function fp_cat2_widget(){

		/* Widget settings. */	

		$widget_ops = array('classname' => 'feat-cat cat-large', 'description' => 'Displays the featured category on homepage.');

		

		/* Create the widget. */

		$this->WP_Widget('fp_cat2_widget', 'FairPixels: Homepage Category Large', $widget_ops);

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

			

		if (!empty($title)) { ?>			



			<div class="section-title">

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

			

	<?php } ?>

			

		<?php $query = new WP_Query( $query_args ); ?>

		<?php if ( $query -> have_posts() ) : ?>

			<?php $last_post  = $query -> post_count -1; ?>

			<?php while ( $query -> have_posts() ) : $query -> the_post(); 

				global $post;		?>	

				

				<?php if ( $query->current_post == 0 ) { ?>			

					<div class="main-post">

						

						<?php

							$saved_img_ids = get_post_meta($post->ID, 'fp_meta_gallery_img_ids', true);	

							$feat_video = get_post_meta( $post->ID, 'fp_meta_post_video_code', true );							

							

							if (!empty($saved_img_ids)) { ?>

				

							<script>

								jQuery(document).ready(function($) {

									

									$('.entry-slider').show();						  

									$('#<?php echo $widget_id; ?> .entry-slider-main').flexslider({

										animation: "slide",

										controlNav: false,

										animationLoop: true,

										slideshow: true,

									});

								});

							</script>



							<div class="entry-slider">

								<div class="entry-slider-main">

									<ul class="slides">

										<?php $img_ids = explode(',',$saved_img_ids);

											foreach($img_ids as $img_id) { 

												if (is_numeric($img_id)) {

													$image_attributes = wp_get_attachment_image_src( $img_id, 'fp520_400');?>

													<li><img class="attachment-fp520_400" src="<?php echo $image_attributes[0]; ?>"></li>

													<?php									

												}

											}

										?>

									</ul>

								</div>								

							</div>

							

							<?php } else if (!empty($feat_video)){ ?>

								<div class="thumb video-thumb">

									<?php echo $feat_video; ?>

								</div>

							

							<?php } else if ( has_post_thumbnail() ) {	?>

														

								<div class="thumb overlay">

									<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'fp520_400' ); ?></a>

								</div>						

					

						<?php } ?>

						

						<div class="entry-wrap">

							<header class="entry-header">

								<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>

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

									

									<span class="views">

										<span class="sep">&#47;</span>									

										<?php 

											$view_count =  getPostViews(get_the_ID()); 

											echo $view_count . ' ';

											if ($view_count > 1 ){

												_e('visitas', 'fairpixels');

											} else {

												_e('visita', 'fairpixels');

											}										

										?>

									</span>  

								</div>

							</header>	

							

							<div class="entry-excerpt">

								<?php the_excerpt(); ?>

							</div>

							

							<div class="read-more">

								<span>&mdash;</span><h6><a href="<?php the_permalink(); ?>"><?php _e('Read More', 'fairpixels'); ?></a></h6>

							</div>

						</div>

	

					</div><!-- /one-half -->

				<?php } ?>

			

				<?php if ( $query->current_post == 1 ) { ?>

					<div class="post-list">

					<?php } ?>

					

						<?php if ( $query->current_post >= 1 ) { ?>	

							<div class="item-post">

								<div class="item-wrap">

									<?php if ( has_post_thumbnail() ) {	?>

										<div class="thumb overlay">

											<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'fp240_165' ); ?></a>

										</div>

									<?php } ?>								

									

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

							</div>

						<?php } ?>

						

				<?php if (( $query->post_count  > 1) AND ( $query->post_count  < 5) AND ($query->current_post == $last_post )) { ?>

					</div><!-- /one-half -->

				<?php } ?>

				

				<?php if ( ( $query->post_count  == 5) AND ($query->current_post == $last_post )) { ?>

					</div><!-- /one-half -->

				<?php } ?>						

				

			<?php endwhile; ?>

		<?php endif; ?>		

		<?php wp_reset_query(); ?>

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

			<label for="<?php echo $this->get_field_id('cat_id'); ?>"><?php _e('Category:', 'fairpixels'); ?></label>

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