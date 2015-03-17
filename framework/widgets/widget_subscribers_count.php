<?php
/**
 * Plugin Name: FairPixels: Subscribers Counter
 * Plugin URI: http://fairpixels.com
 * Description: Displays Facebook and Twitter subscribers number.
 * Version: 1.0
 * Author: FairPixels
 * Author URI: http://fairpixels.com
 *
 */
 
/**
 * Include required files
 */
require_once 'lib/tmhOAuth.php';
require_once 'lib/tmhUtilities.php';

 /**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init','fairpixels_social_subscribers_widgets');

function fairpixels_social_subscribers_widgets() {
	register_widget('fairpixels_social_subscribers_widget');
	}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class fairpixels_social_subscribers_widget extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function fairpixels_social_subscribers_widget() {
		
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget_followers','description' => __('Displays Facebook and Twitter subscribers number.', 'fairpixels'));
		
		/* Create the widget. */
		$this->WP_Widget('fairpixels_social_subscribers_widget',__('FairPixels: Subscribers Counter', 'fairpixels'),$widget_ops);

	}
	
	/**
	 * display the widget on the screen.
	 */	
	function widget( $args, $instance ) {
		extract( $args );
		//user settings.		
		$fp_rss_url = $instance['fp_rss_url'];
		$fp_twitter_id = $instance['fp_twitter_id'];
		$fp_facebook_id = $instance['fp_facebook_id'];
		$fp_consumer_key = $instance['fp_consumer_key'];
		$fp_consumer_secret = $instance['fp_consumer_secret'];
		$fp_access_token = $instance['fp_access_token'];
		$fp_access_secret = $instance['fp_access_secret'];		

		echo $before_widget;
		
		//twitter
		if (!empty($fp_twitter_id)){
			$interval = 600;					
			$follower_count = 0;
			
			if($_SERVER['REQUEST_TIME'] > get_option('fairpixels_twitter_cache_time')) {
				
				$tmhOAuth = new tmhOAuth(
					array(
						'consumer_key' => $fp_consumer_key,
						'consumer_secret' => $fp_consumer_secret,
						'user_token' => $fp_access_token,
						'user_secret' => $fp_access_secret,
						'curl_ssl_verifypeer' => false 
					)
				);
		
				$request_array = array();
				$request_array['screen_name'] = $fp_twitter_id;
				$code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/users/show.json'), $request_array);
				
				if ($code == 200) {
					$follower_count = json_decode($tmhOAuth->response['response'])->followers_count;
					
					if ($follower_count > 0 ) {
						update_option('fairpixels_twitter_cache_time', $_SERVER['REQUEST_TIME'] + $interval);
						update_option('fairpixels_twitter_followers', $follower_count);
					}
				}			
			}	 
		}
		
		//facebook
		if (!empty($fp_facebook_id)){
			$interval = 600;
			$fb_likes = 0;
			
			if($_SERVER['REQUEST_TIME'] > get_option('fairpixels_facebook_cache_time')) {
				
				$api = wp_remote_get('http://graph.facebook.com/' . $fp_facebook_id);
				
				if (!is_wp_error($api)) {
					
					$json = json_decode($api['body']);
					$fb_likes = $json->likes;
					
					if ($fb_likes > 0 ) {
						update_option('fairpixels_facebook_cache_time', $_SERVER['REQUEST_TIME'] + $interval);
						update_option('fairpixels_facebook_followers', $fb_likes);
						update_option('fairpixels_facebook_link', $json->link);
					}
				
				}				
				
			}
		}
			
		?>
		<div class="wrap">
			<ul class="list">
								
				<?php if (!empty($fp_facebook_id)){ ?>
					<li class="facebook">
						<div class="icon"><a target="_blank" href="<?php echo get_option('fairpixels_facebook_link'); ?>"><i class="fa fa-facebook"></i></a></div>
						<div class="right">				
							<div class="count"><h4><a target="_blank" href="<?php echo get_option('fairpixels_facebook_link'); ?>"><?php echo get_option('fairpixels_facebook_followers'); ?></a></h4></div>
							<div class="text"><?php _e('Likes', 'fairpixels');?></div>				
						</div>
					</li><!-- /facebook -->
				<?php } ?>
				
				<?php if (!empty($fp_twitter_id)){ ?>
					<li class="twitter">
						<div class="icon"><a target="_blank" href="http://twitter.com/<?php echo $fp_twitter_id; ?>"><i class="fa fa-twitter"></i></a></div>
						<div class="right">
							<div class="count"><h4><a target="_blank" href="http://twitter.com/<?php echo $fp_twitter_id; ?>"><?php echo get_option('fairpixels_twitter_followers'); ?></a></h4></div>
							<div class="text"><?php _e('Followers', 'fairpixels');?></div>
						</div>
					</li> <!-- /twitter -->
				<?php } ?>
				
				
				<?php if (!empty($fp_rss_url)){ ?>
					<li class="rss">
						<div class="icon"><a href="<?php echo $fp_rss_url; ?>"><i class="fa fa-rss"></i></a></div>
						<div class="right">
							<div class="subscribe"><h4><a target="_blank" href="<?php echo $fp_rss_url; ?>"><?php _e('Subscribe', 'fairpixels'); ?></a></h4></div>
							<div class="text"><?php _e('RSS Feeds', 'fairpixels'); ?></div>		
						</div>				
					</li>
				<?php } ?>
				
			</ul>
				
		</div><!-- /wrap -->			
		<?php 
		echo $after_widget;
	}
	
	/**
	 * update widget settings
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;		
		$instance['fp_rss_url'] = $new_instance['fp_rss_url'];
		$instance['fp_twitter_id'] = $new_instance['fp_twitter_id'];
		$instance['fp_facebook_id'] = $new_instance['fp_facebook_id'];
		$instance['fp_consumer_key'] = $new_instance['fp_consumer_key'];	
		$instance['fp_consumer_secret'] = $new_instance['fp_consumer_secret'];	
		$instance['fp_access_token'] = $new_instance['fp_access_token'];	
		$instance['fp_access_secret'] = $new_instance['fp_access_secret'];
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(			
			'fp_rss_url' => get_bloginfo('rss2_url'),
			'fp_twitter_id' => '',
			'fp_facebook_id' => '',
			'fp_consumer_key' => '',	
			'fp_consumer_secret' => '',	
			'fp_access_token' => '',	
			'fp_access_secret' => ''
 		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'fp_rss_url' ); ?>"><?php _e('RSS URL', 'fairpixels'); ?></label>
			<input id="<?php echo $this->get_field_id( 'fp_rss_url' ); ?>" name="<?php echo $this->get_field_name( 'fp_rss_url' ); ?>" value="<?php echo $instance['fp_rss_url']; ?>" class="widefat" />
		</p>
				
		<p>
			<label for="<?php echo $this->get_field_id( 'fp_facebook_id' ); ?>"><?php _e('Facebook Page ID:', 'fairpixels'); ?></label>
			<input id="<?php echo $this->get_field_id( 'fp_facebook_id' ); ?>" name="<?php echo $this->get_field_name( 'fp_facebook_id' ); ?>" value="<?php echo $instance['fp_facebook_id']; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'fp_twitter_id' ); ?>"><?php _e('Twitter Name', 'fairpixels'); ?></label>
			<input id="<?php echo $this->get_field_id( 'fp_twitter_id' ); ?>" name="<?php echo $this->get_field_name( 'fp_twitter_id' ); ?>" value="<?php echo $instance['fp_twitter_id']; ?>" class="widefat" />
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'fp_consumer_key' ); ?>"><?php _e('Consumer key', 'fairpixels') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fp_consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'fp_consumer_key' ); ?>" value="<?php echo $instance['fp_consumer_key']; ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'fp_consumer_secret' ); ?>"><?php _e('Consumer secret', 'fairpixels') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fp_consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'fp_consumer_secret' ); ?>" value="<?php echo $instance['fp_consumer_secret']; ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'fp_access_token' ); ?>"><?php _e('Access token', 'fairpixels'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fp_access_token' ); ?>" name="<?php echo $this->get_field_name( 'fp_access_token' ); ?>" value="<?php echo $instance['fp_access_token']; ?>" />			
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'fp_access_secret' ); ?>"><?php _e('Access token secret', 'fairpixels'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fp_access_secret' ); ?>" name="<?php echo $this->get_field_name( 'fp_access_secret' ); ?>" value="<?php echo $instance['fp_access_secret']; ?>" />			
		</p>


	<?php 
	}
} //end class