<?php
/**
 * Plugin Name: FairPixels: Recent Posts
 * Plugin URI: http://fairpixels.com/
 * Description: This widhet displays the most recent posts with thumbnails
 * Version: 1.0
 * Author: FairPixels
 * Author URI: http://fairpixels.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'fairpixels_register_recent_posts_widget' );

function fairpixels_register_recent_posts_widget() {
	register_widget( 'fairpixels_recent_posts_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class fairpixels_recent_posts_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function fairpixels_recent_posts_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_tabs', 'description' => __('Displays the recent posts with thumbnails.', 'fairpixels') );

		/* Create the widget. */
		$this->WP_Widget( 'fairpixels_recent_posts_widget', __('FairPixels: Recent Posts', 'fairpixels'), $widget_ops);
	}

	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$title = $instance['title'];		
		$entries_display = $instance['entries_display'];
		$post_cat = $instance['category'];
		
		if(empty($entries_display)){ 
			$entries_display = '5'; 
		}
		
		$args_latest = array(
			'cat' => $post_cat,
			'post_type' => 'post',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $entries_display		
		);	
		
		echo $before_widget;
		
		echo $before_title;
        echo $title;
		echo $after_title;
		
		?>
	
		<?php $latest_posts = new WP_Query( $args_latest ); ?>
		<?php if ( $latest_posts -> have_posts() ) : ?>
			<ul class="list post-list">
			<?php while ( $latest_posts -> have_posts() ) : $latest_posts -> the_post(); ?>					
				<li>
					<?php if ( has_post_thumbnail()) { ?>
					<div class="thumbnail overlay">
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'fp75_75' ); ?></a>
					</div>
					<?php } ?>
					<div class="post-right">
						<h5>
							<a href="<?php the_permalink() ?>">
								<?php 
									//display only first 50 characters in the title.	
									$short_title = mb_substr(the_title('','',FALSE),0, 50);
									echo $short_title; 
									if (strlen($short_title) > 49){ 
										echo '...'; 
									} 
								?>	
							</a>
						</h5>
						<div class="entry-meta">
							<span class="date">
								<i class="icon-calendar"></i>
								<?php echo get_the_date(); ?>
							</span>
							
							<?php $comments = get_comments_number();
								if ( $comments > 0 ) { ?>
								<span class="comments">
									<i class="icon-comments"></i>
									<?php comments_popup_link( __('0', 'fairpixels'), __( '1', 'fairpixels'), __('%', 'fairpixels')); ?>
								</span>		
							<?php } ?>									 
						</div>
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
		<?php endif;?>
		<?php wp_reset_query();?>	
			
	   <?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['entries_display'] = strip_tags($new_instance['entries_display']);
        $instance['category'] = strip_tags($new_instance['category']);
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => '', 'entries_display' => 5, 'category' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
		
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'fairpixels'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" /></p>
		
		<p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><?php _e('How many entries to display?', 'fairpixels'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" /></p>
 
		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('If you want to display specific category latest posts, enter category ids separated with a comma (e.g. - 1, 3, 8)', 'fairpixels'); ?></label>
		<input type="text" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" value="<?php echo $instance['category']; ?>" style="width:100%;" /></p>

	<?php
	}
}
?>