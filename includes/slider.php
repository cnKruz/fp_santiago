<?php
/**
 * The template for displaying the featured slider on homepage.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, displays the latest posts.
 *
 * @package  WordPress
 * @file     slider.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 * 
 **/
?>
<?php		
	$slider_cat_id = get_post_meta($post->ID, 'fp_meta_slider_cat', true);
	$slider_speed = get_post_meta($post->ID, 'fp_meta_slider_speed', true);	
	
	$slider_right_cat_id = get_post_meta($post->ID, 'fp_meta_slider_right_cat', true);
	
	if (empty($slider_speed)){
		$slider_speed = 5000;
	}
	
	$args = array(
		'cat' => $slider_cat_id,
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page' => 5
	);
		
?>

<div class="section">
	<script>
			jQuery(document).ready(function($) {
				$('.slider-main').show();
				$('.slider-main').flexslider({		// slider settings
					animation: "slide",								// animation style
					controlNav: true,								// slider thumnails class
					slideshow: true,								// enable automatic sliding
					directionNav: false,								// disable nav arrows
					slideshowSpeed: <?php echo $slider_speed; ?>,   // slider speed
					smoothHeight: false,
					keyboard: true,
					mousewheel: true,
					startAt: 1,
					controlsContainer: ".slider-main-nav",
				});
			});
		</script>
	<div class="slider-main">				
		<ul class="slides">
			<?php $query = new WP_Query( $args ); ?>
				<?php if ( $query -> have_posts() ) : ?>
					<?php while ( $query -> have_posts() ) : $query -> the_post(); ?>
							<?php if ( has_post_thumbnail()) { ?>				
								<li>
									<a href="<?php the_permalink(); ?>" >
										<?php the_post_thumbnail( 'fp869_340' ); ?>
									</a>
										
									<div class="post-info">
										<?php 
											$category = get_the_category(); 
											if($category[0]){ ?>
												<div class="entry-meta">													
													<?php echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; ?>
												</div>				
										<?php } ?>
									
										<div class="title">
											<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
										</div>								
										
										<div class="post-excerpt">
											<h5>
												<?php 
													$excerpt = get_the_excerpt();
													echo mb_substr($excerpt,0, 150);
													if (strlen($excerpt) > 149){ 
														echo '...'; 
													}
												?>
											</h5>
										</div>
										
										<div class="more">
											<h6><a href="<?php the_permalink() ?>"><?php _e('Read more', 'fairpixels'); ?></a></h6>
										</div>
																	
									</div>											
								</li>					
						<?php } ?>
					<?php endwhile; ?>
				<?php endif;?>
			<?php wp_reset_query();?>	
		</ul>
		<div class="slider-main-nav"></div>
        
        
	</div>
	
	<div class="slider-right">
		<?php echo do_shortcode('[login_widget ]'); ?>
	</div>
</div>