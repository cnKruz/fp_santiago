<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package  WordPress
 * @file     index.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
<?php get_header(); ?>

<div id="content" class="homepage">
	<?php if ( have_posts() ) : ?>		
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
		</header>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'fairpixels' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</article><!-- /post-0 -->
			
	<?php endif; ?>		
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>