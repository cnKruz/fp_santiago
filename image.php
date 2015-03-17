<?php
/**
 * The template for displaying image attachments.
 *
 * @package  WordPress
 * @file     image.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
<?php get_header(); ?>
<div id="content" class="image-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<header class="entry-header">
				<h1><?php the_title(); ?></h1>
				
				<?php if ( fp_get_settings( 'fp_show_post_meta' ) == 1 ){ ?>
					<div class="entry-meta">
						
						<div class="left">
							<span class="date">
								<i class="icon-calendar"></i>
								<?php echo get_the_date(); ?>
							</span>
							
							<?php if ( comments_open() ) : ?>
								<span class="comments">
									<i class="icon-comments"></i>
									<?php comments_popup_link( __('no comments', 'fairpixels'), __( '1 comment', 'fairpixels'), __('% comments', 'fairpixels')); ?>
								</span>		
							<?php endif; ?>	
							
							<span class="views">
								<i class="icon-eye-open"></i>								
								<?php echo getPostViews(get_the_ID()); ?>
							</span> 
							
							<span class="image-link">							 
								 <i class="icon-zoom-in"></i>
								<?php _e('Original Image size: ', 'fairpixels'); ?>							
								<?php
									$metadata = wp_get_attachment_metadata();
									printf( __( '<a href="%3$s" rel="lightbox">%1$s &times; %2$s</a>', 'fairpixels' ),
											$metadata['width'],
											$metadata['height'],
											esc_url( wp_get_attachment_url() )										
										);
								?>							
							</span>
													
							<?php the_tags('<span class="tags"><i class="icon-tags"></i>',' , ','</span>'); ?>
						</div>
						
						<?php if ( fp_get_settings( 'fp_show_post_social' ) == 1 ){ ?>
							<div class="social">
								<span class="fb">
									<a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;t=<?php the_title(); ?>" target="_blank"><i class=" icon-facebook-sign"></i></a>
								</span>				
								
								<span class="twitter">
									<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink();?>" target="_blank"><i class="icon-twitter"></i></a>				
								</span>
								
								<span class="gplus">
									<a href="https://plus.google.com/share?url=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank"><i class="icon-google-plus-sign"></i></a>			
								</span>
								
								<span class="pinterest">
									<?php
										$thumbnail = "";
										if (has_post_thumbnail() ){
											 $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
											 $thumbnail = $image[0];
										}
									?>
									<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo $thumbnail; ?>&amp;description=<?php the_title() ?>" target="_blank">		
									<i class="icon-pinterest"></i>					
									</a>					
								</span>				
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</header>
						<div class="entry-content">
				<div class="entry-attachment">
					<div class="attachment">
						<?php
							/**
							* Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
							* or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
							*/
							$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
							foreach ( $attachments as $k => $attachment ) {
								if ( $attachment->ID == $post->ID )
									break;
							}
							$k++;
														// If there is more than 1 attachment in a gallery
							if ( count( $attachments ) > 1 ) {
								if ( isset( $attachments[ $k ] ) )
									// get the URL of the next image attachment
									$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
								else
									// or get the URL of the first image attachment
									$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
							} else {
									// or, if there's only 1 image, get the URL of the image
									$next_attachment_url = wp_get_attachment_url();
							}
						?>
						
						<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
						<?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></a>
												<?php if ( ! empty( $post->post_excerpt ) ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>
					</div><!-- /attachment -->
									</div><!-- /entry-attachment -->
								<div class="entry-description">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'fairpixels' ) . '</span>', 'after' => '</div>' ) ); ?>
				</div><!-- /entry-description -->							
							</div><!-- /entry-content -->
						
			<nav class="nav-single">
				<span class="nav-previous"><?php previous_image_link( false, __( '&larr; Previous' , 'fairpixels' ) ); ?></span>
				<span class="nav-next"><?php next_image_link( false, __( 'Next &rarr;' , 'fairpixels' ) ); ?></span>
			</nav><!-- /nav-single -->
						
			<div class="image-post-link">
				<a href="<?php echo get_permalink($post->post_parent) ?>" title="<?php printf( __( 'Return to %s', 'fairpixels' ), esc_html( get_the_title($post->post_parent), 1 ) ) ?>" rev="attachment"><?php echo get_the_title($post->post_parent) ?></a>
			</div>		
			<?php setPostViews(get_the_ID()); ?>			
		</article><!-- /post-<?php the_ID(); ?> -->
		
		
		<?php comments_template( '', true ); ?>	
		
	<?php endwhile; // end of the loop. ?>
	</div><!-- /content -->	
<?php get_sidebar(); ?>		
<?php get_footer(); ?>