<?php
/**
 * Template Name: Blog
 * Description: A Page Template to display bloag archives with the sidebar.
 *
 * @package  WordPress
 * @file     page-blog.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
<?php get_header(); ?>
<div id="content" class="archive post-archive">
	
		<header class="page-header">
			<h2><?php the_title(); ?></h2>			
		</header>
			
			<?php
				if ( get_query_var('paged') ) {
					$paged = get_query_var('paged');
				} elseif ( get_query_var('page') ) {
					$paged = get_query_var('page');
				} else {
					$paged = 1;
				}		
		
				$args = array(
					'post_status' => 'publish',
					'post_type'  => 'post',
					'paged'      => $paged					
				);
			?>
			<?php $wp_query = new WP_Query( $args ); ?>
			<?php if ( $wp_query -> have_posts() ) : ?>
				<div class="archive-postlist">
					<?php $i = 0; ?>	
					
					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<?php if(function_exists('wp_print')) { print_link(); } ?>
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
				</div>
				<?php fp_pagination(); ?>
				<?php wp_reset_query();?>
				<?php else : ?>
					<article id="post-0" class="post no-results not-found">
						<header class="entry-header">
							<h1 class="entry-title"><?php _e( 'Nothing Found', 'fairpixels' ); ?></h1>
						</header><!-- /entry-header -->
						<div class="entry-content">
							<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'fairpixels' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- /entry-content -->
					</article><!-- /post-0 -->
					<?php endif; ?>
	</div><!-- /content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>