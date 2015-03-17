<?php
/**
 * The template for displaying the single column featured categories.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, displays the latest posts.
 *
 * @package  WordPress
 * @file     feat-post.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
<div id="feat-postlist" class="cat-posts-list section">
	<?php
		$cat_id = get_post_meta($post->ID, 'fp_meta_postlist_cat', true);
		$section_title = get_post_meta($post->ID, 'fp_meta_postlist_title', true);
		$section_subtitle = get_post_meta($post->ID, 'fp_meta_postlist_subtitle', true);
		
		
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		
	?>
		
		
	<?php if ($paged < 2 ){		
		
		if (!empty($section_title)) { ?>			

			<div class="section-title">
				<h4><?php echo $section_title; ?></h4>
				<?php if ($section_subtitle) { ?>
					<h6><?php echo $section_subtitle; ?></h6>
				<?php } ?>
			</div>			
		<?php }			
			
	}
	
		$args = array(
			'cat' => $cat_id,
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'paged' => $paged,
		);			
		
		$i = 0; 
		?>
		
		<div class="archive-postlist">
			<?php $wp_query = new WP_Query( $args ); ?>
			<?php if ( $wp_query -> have_posts() ) : ?>
				<?php while ( $wp_query -> have_posts() ) : $wp_query -> the_post(); ?>
					<?php								
						$post_class ="";
						if ( $i % 2 == 1 ){
							$post_class =" col-last";							
						}					
					?>								
					<div class="one-half<?php echo $post_class; ?>">
						<?php get_template_part( 'content', 'excerpt' ); ?>
					</div>
					<?php $i++; ?>
				<?php endwhile; ?>
			<?php endif; ?>				
		</div>
		<?php fp_pagination(); ?>
		<?php wp_reset_query(); ?>		
</div>