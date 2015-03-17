<?php

/**

 * The template for displaying content in the single.php template

 *

 * @package  WordPress

 * @file     content-single.php

 * @author   FairPixels

 * @link 	 http://fairpixels.com

 */

?>



<div class="post-wrap">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	

	

	<header class="entry-header">

		<?php 

			$show_feat_img = get_post_meta($post->ID, 'fp_meta_post_add_featimg', true); 

	

			if ($show_feat_img == 1){ ?>

				<div class="entry-image">

					<?php the_post_thumbnail( 'fp770_375' ); ?>

				</div>					

			<?php 

			}

		

		$saved_img_ids = get_post_meta($post->ID, 'fp_meta_gallery_img_ids', true);

		if (!empty($saved_img_ids)) { ?>

			

			<script>

				jQuery(document).ready(function($) {

					

					$('.entry-slider').show();						  

					$('.entry-slider-main').flexslider({

						animation: "slide",

						controlNav: false,

						animationLoop: true,

						slideshow: true,

					});

				});

			</script>



			<div class="entry-slider">

				<div class="entry-slider-main flexslider">

					<ul class="slides">

						<?php $img_ids = explode(',',$saved_img_ids);

							foreach($img_ids as $img_id) { 

								if (is_numeric($img_id)) {

									$image_attributes = wp_get_attachment_image_src( $img_id, 'fp770_375');?>

									<li><img class="attachment-fp770_375" src="<?php echo $image_attributes[0]; ?>"></li>

									<?php									

								}

							}

						?>

					</ul>

				</div>				

			</div>

			

		<?php }	?>

			

		<h1><?php the_title(); ?></h1>

		 

		<?php if ( fp_get_settings( 'fp_show_post_meta' ) == 1 ){ ?>

			<div class="entry-meta">

				

				<div class="left">

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

				

				<?php if ( fp_get_settings( 'fp_show_post_social' ) == 1 ){ ?>

					<div class="social">

						<span class="fb">

							<a href="http://facebook.com/share.php?u=<?php the_permalink() ?>&amp;t=<?php the_title(); ?>" target="_blank"><i class="fa fa-facebook"></i></a>

						</span>				

						

						<span class="twitter">

							<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink();?>" target="_blank"><i class="fa fa-twitter"></i></a>				

						</span>

						

						<span class="gplus">

							<a href="https://plus.google.com/share?url=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>			

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

							<i class="fa fa-pinterest"></i>					

							</a>					

						</span>				

					</div>

				<?php } ?>

			</div>

		<?php } ?>

	</header>		

	<?php			

		$show_video = get_post_meta($post->ID, 'fp_meta_post_add_video', true); 				

		

		if ($show_video == 1){

			$video_code = get_post_meta($post->ID, 'fp_meta_post_video_code', true); ?>

			

			<div class="entry-video">

				<?php echo $video_code; ?>

			</div>					

	<?php }	?>

			

		<div class="entry-content">				

			<?php the_content(); ?>

			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'fairpixels' ) . '</span>', 'after' => '</div>' ) ); ?>

		</div><!-- /entry-content -->

		

		<div class="entry-footer">

			<div class="categories"><span class="icon"><i class="fa fa-folder"></i></span><?php the_category(' ' ); ?></div>

			<?php the_tags('<div class="tags"><span class="icon"><i class="fa fa-tags"></i></span>',' ','</div>'); ?>

		</div>

		

	<?php setPostViews(get_the_ID()); ?>

</article><!-- /post-<?php the_ID(); ?> -->



<?php if ( fp_get_settings( 'fp_show_post_author' ) == 1 ) { ?>

	<div class="entry-author">				

		<div class="author-avatar">

			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 75 ); ?>

		</div>		

		<div class="author-description">

			<h5><?php printf( __( 'About %s', 'fairpixels' ), get_the_author() ); ?></h5>

			<?php the_author_meta( 'description' ); ?>

			<div id="author-link">

				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">

					<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'fairpixels' ), get_the_author() ); ?>

				</a>

			</div>

		</div>

	</div><!-- /entry-author -->

	

	<?php } //endif; 

	

	 if ( fp_get_settings( 'fp_show_post_nav' ) == 1 ) { ?>

		<div class="entry-nav">

			<?php

				previous_post_link('

					<div class="prev-post">

						<span class="title1">

							<i class="fa fa-chevron-left"></i>

							<h5>'.__('Anterior', 'fairpixels').'</h5>

						 </span>

						  <span class="title2">

							  <h5>%link</h5>

						  </span>

					</div>'					  

				);

				

				next_post_link('

					<div class="next-post">

						<span class="title1">

							<i class="fa fa-chevron-right"></i>

							<h5>'.__('Siguiente', 'fairpixels').'</h5>

						 </span>

						  <span class="title2">

							  <h5>%link</h5>

						  </span>

					</div>'					  

				);

			?>			

		</div>

	<?php } 

		

	if ( fp_get_settings( 'fp_show_related_posts' ) == 1 ){

		get_template_part( 'includes/related-posts' );

	}

?>

</div><!-- /post-wrap -->