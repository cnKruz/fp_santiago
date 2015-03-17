<?php/**
 * The template for displaying content in the archive and search results template
 *
 * @package  WordPress
 * @file     content-excerpt.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>		
	<?php		
		$feat_video = get_post_meta( $post->ID, 'fp_meta_post_video_code', true );
		
		if (!empty($feat_video)){ ?>
			<div class="thumb-wrap video-thumb">
				<?php echo $feat_video; ?>
			</div>
		
		<?php } else if ( has_post_thumbnail() ) {	?>
		
			<div class="thumb overlay">
				<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'fp370_215' ); ?></a>
			</div>	
	<?php } ?>
	<header class="entry-header">
		<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
		<div class="entry-meta">
			<span class="date">
				<?php echo get_the_date(); ?>
			</span>						
			<?php if ( comments_open() ) : ?>
				<span class="sep">&#47;</span>
				<span class="comments">										
					<?php comments_popup_link( __('no comments', 'fairpixels'), __( '1 comment', 'fairpixels'), __('% comments', 'fairpixels')); ?>
				</span>
			<?php endif; ?>
			<span class="views">
				<span class="sep">&#47;</span>									
				<?php 
					$view_count =  getPostViews(get_the_ID()); 
					echo $view_count . ' ';
					if ($view_count > 1 ){
						_e('visitas', 'fairpixels');
					} else {
						_e('visita', 'fairpixels');
					}										
				?>
			</span>  
		</div>
	</header>
	
	<div class="entry-excerpt">
		<?php echo get_excerpt(250); ?>
	</div>
	
</article><!-- /post-<?php the_ID(); ?> -->