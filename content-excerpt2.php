<?php
/**
 * The template for displaying content in the archive and search results template
 *
 * @package  WordPress
 * @file     content-excerpt.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	
	
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

	
</article><!-- /post-<?php the_ID(); ?> -->
