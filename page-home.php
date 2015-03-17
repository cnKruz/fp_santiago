<?php

/**

 * Template Name: Homepage

 * Description: A Page Template to display bloag archives with the sidebar.

 *

 * @package  WordPress

 * @file     page-home.php

 * @author   FairPixels

 * @link 	 http://fairpixels.com

 */

?>

<?php get_header(); ?>



<div id="content" class="homepage">

		

	<?php 

		

		

		/*if ($paged < 2 ){

			if ( ! dynamic_sidebar( 'homepage' ) ) :

			endif;

		}

		

		$show_postlist = get_post_meta($post->ID, 'fp_meta_show_postlist', true);

		if ($show_postlist == 1) {

			get_template_part( 'includes/post-list' );				

		}*/

	?>

    



<div id="homeContent">

    <div id="slidor">

    	<?php echo do_shortcode("[rev_slider concanaco]"); ?>

    </div>

    <div class="espa">

            </div>



	<div id="rigthColum">

    	<div id="tColum">

        	<div id="loginTitle">CALENDARIO DE EVENTOS</div>

        	<?php echo do_shortcode('[do_widget id="gg_event_widget-3"]');?>

        </div>

        <div id="bColum">

        

        	<div id="postC3">
			<div id="loginTitle">&nbsp;</div>
			<?php echo do_shortcode('[do_widget id="widget-easy-twitter-feed-widget-kamn-2"]');?>              
			</div>
	        </div>
	<br></br>
    </div>

    <div id="leftColum">

    	<div id="topColum">

        	<div id="leftPost">	

            <div id="capa">

            	<div id="loginTitle" >CURSOS Y CAPACITACIÓN</div>

					<?php

                     $wp_query = new WP_Query(array('category_name' => 'Capacitacion', 'posts_per_page' => 1));

                     ?>

                <?php if ( $wp_query -> have_posts() ) : ?>	

                        

                        <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                                                            

                            <div class="miniCont">

                                <?php get_template_part( 'content', 'excerpt3' ); ?>

                            </div>

                        <?php endwhile; ?>

                    <?php endif ?>

		    <br></br>

                    <div id="puntosAbajo"></div>

		

            </div>

                </div>

            <div id="rightPost">

                    <!-- <?php echo do_shortcode("[showads ad=conca1]"); ?> -->

			 <a href="./?p=498"><img src="./wp-content/uploads/2015/02/banner-tableta.jpg" WIDTH="100%">

            </div>

            

            

    	</div>

        <div id="sectionC" style="background:url(images/azul.png); background-size:100% 100%;">

        	<div style="position:relative; left:5px; top:2px;">MULTIMEDIA</div>

        </div>

        <div id="bottomColum">

        	<div id="video1">

            	<div id="postC">

            	<div id="loginTitle2">CAPACITACIÓN</div>

            	<?php

				 $wp_query = new WP_Query(array('category_name' => 'World', 'posts_per_page' => 1));

				 ?>

			<?php if ( $wp_query -> have_posts() ) : ?>

				<div class="miniPost">	

					

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

														

						<div class="miniCont">

							<?php get_template_part( 'content', 'excerpt' ); ?>

						</div>

					<?php endwhile; ?>

				</div>

				<?php endif ?>

                </div>

            </div>

            <div id="video2">

            	<div id="postC">

                <div id="loginTitle2">GALERÍA</div>

            	<?php

				 $wp_query = new WP_Query(array('category_name' => 'Tabletas', 'posts_per_page' => 1));

				 ?>

			<?php if ( $wp_query -> have_posts() ) : ?>

				<div class="miniPost">	

					

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

														

						<div class="miniCont">

							<?php get_template_part( 'content', 'excerpt' ); ?>

						</div>

					<?php endwhile; ?>

				</div>

				<?php endif ?>

                </div>

            </div>

            <div id="video3">

            	<div id="postC2">

            	<div id="loginTitle2" style=" margin-top:6.4%; text-align:center">VIDEOS CONCANACO</div>

            	<?php

				 $wp_query = new WP_Query(array('category_name' => 'Video', 'posts_per_page' => 1));

				 ?>

			<?php if ( $wp_query -> have_posts() ) : ?>

				<div class="miniPost">	

					

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

														

						

							<?php get_template_part( 'content', 'excerpt2' ); ?>

						

					<?php endwhile; ?>

				</div>

				<?php endif ?>

                </div>

            </div>

    	</div>

    </div>

</div>





		

</div>



<?php get_sidebar(); ?>



<br></br>



<?php get_footer(); ?>