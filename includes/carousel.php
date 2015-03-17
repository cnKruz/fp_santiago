<?php
/**
 * The template for displaying the featured carousel on homepage.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, displays the latest posts.
 *
 * @package  WordPress
 * @file     carousel.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 * 
 **/
?>
<?php		
	$cat_id = fp_get_settings('fp_slider_cat');
		
	if (empty($slider_speed) OR (!is_numeric($slider_speed))){
		$slider_speed = 5000;
	}
	$args = array(
		'cat' => $cat_id,
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page' => 15
	);
		
?>	
	<div id="feat-carousel" class="carousel-section clearfix">

	<script>
		jQuery(document).ready(function($) {				
			$(".carousel-posts").show();
			$('.carousel-posts').bxSlider({
				minSlides: 1,
				maxSlides: 4,
				slideWidth: 270,
				slideMargin: 30,
				controls: true,
				pager: false,
				nextSelector: '.carousel-nav .carousel-next',
				prevSelector: '.carousel-nav .carousel-prev'			  
			});
		});
	</script>
	
	<?php $carousel_title = fp_get_settings('fp_carousel_title');	
	
	if ($carousel_title) { ?>
		<div class="section-title">
			<h5><?php echo $carousel_title; ?></h5>
			<div class="carousel-nav"><span class="carousel-prev"></span><span class="carousel-next"></span></div>
		</div>	
	<?php } ?>
	
	<div class="carousel-wrap">
		<ul class="carousel-posts list">
			<?php $query = new WP_Query( $args ); ?>
			<?php if ( $query -> have_posts() ) : ?>
				<?php while ( $query -> have_posts() ) : $query -> the_post(); ?>
					<?php if ( has_post_thumbnail()) { ?>				
						<li>
							<div class="thumb">
								<a href="<?php the_permalink(); ?>" >
									<?php the_post_thumbnail( 'fp270_165' ); ?>
								</a>
							</div>
								
							<div class="post-info">
																		
								<h6><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h6>
								<div class="entry-meta">
									<span class="date">
										<i class="fa fa-calendar"></i>
										<?php echo get_the_date(); ?>
									</span>																
									
									<?php if ( comments_open() ) : ?>
										<span class="comments">
											<i class="fa fa-comments"></i>
											<?php comments_popup_link( __('no comments', 'fairpixels'), __( '1 comment', 'fairpixels'), __('% comments', 'fairpixels')); ?>
										</span>		
									<?php endif; ?>
								</div>								
								
								<div class="post-excerpt">
									<p>
										<?php 
											$excerpt = get_the_excerpt();
											echo mb_substr($excerpt,0, 150);
											if (strlen($excerpt) > 149){ 
												echo '...'; 
											}
										?>
									</p>
								</div>
								
							</div>											
						</li>							
					<?php } ?>
				<?php endwhile; ?>
			<?php endif;?>
		<?php wp_reset_query();?>
		</ul>				
	</div>	
</div>