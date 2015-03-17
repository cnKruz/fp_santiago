<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package  WordPress
 * @file     author.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>

<?php get_header(); ?>

	<div id="content" class="post-archive<?php echo $content_class; ?>">
		<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<h3 class="archive-title">
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: %s', 'fairpixels' ), '<span>' . get_the_date() . '</span>' ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: %s', 'fairpixels' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'fairpixels' ) ) . '</span>' ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: %s', 'fairpixels' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'fairpixels' ) ) . '</span>' ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', 'fairpixels' ); ?>
					<?php endif; ?>
				</h3>
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