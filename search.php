<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package  WordPress
 * @file     search.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
<?php get_header(); ?>
	<div id="content" class="post-archive">
			<div class="archive">
				
					<?php if ( have_posts() ) : ?>

						<header class="archive-header">
							<h2 class="archive-title">
								<?php printf( __( 'Resultados: %s', 'fairpixels' ), '<span>' . get_search_query() . '</span>' ); ?>
							</h2>
						</header>
				
						<div class="archive-postlist">
							<?php $i = 0; ?>				
							<?php while ( have_posts() ) : the_post(); ?>
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
					
					<?php else : ?>

						<article id="post-0" class="post no-results not-found">
							<header class="archive-header">
								<h3 class="archive-title">								
									<?php _e( 'Nothing Found', 'fairpixels' ); ?>
								</h3>
							</header><!-- /entry-header -->

							<div class="entry-content">
								<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'fairpixels' ); ?></p>
								<div class="box-550">
									<?php get_search_form(); ?>
								</div>
							</div><!-- /entry-content -->
						</article><!-- /post-0 -->

					<?php endif; ?>
				</div><!-- /search-results -->
		</div><!-- /content -->

<?php get_sidebar('left'); ?>		
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>