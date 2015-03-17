<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package  WordPress
 * @file     author.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
<?php get_header(); ?>

	<div id="content" class="post-archive author-archive">
		<?php if ( have_posts() ) : ?>
			<?php
				/* Queue the first post, that way we know
			     * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>

			<header class="archive-header">
				<h3 class="archive-title"><?php printf( __( 'Author Archives: %s', 'fairpixels' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h3>
			</header>

			<?php
				/* Since we called the_post() above, we need to
			 	 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php
				// If a user has filled out their description, show a bio on their entries.
				if ( get_the_author_meta( 'description' )) {?>
					<div class="archive-desc">							
						<div class="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 68 ); ?>
						</div>	
					
						<div class="author-description">								
							<h4><?php printf( __( 'About %s', 'fairpixels' ), get_the_author() ); ?></h4>
								<?php the_author_meta( 'description' ); ?>																		
						</div><!-- /author-description -->
					</div><!-- /author-info -->
			<?php } ?>
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
				</header><!-- .entry-header -->
				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'fairpixels' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</article><!-- /post-0 -->

		<?php endif; ?>
	</div><!-- /content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>