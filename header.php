<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package  WordPress
 * @file     header.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
<!DOCTYPE html>

<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>

<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;
	wp_title( '|', true, 'right' );
	// Add the blog name.
	bloginfo( 'name' );
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	// Add a page number if necessary: 
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'fairpixels' ), max( $paged, $page ) );
	?>
</title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
	<div id="container" class="hfeed">
		<header id="header">	
			<div class="logo-section">
				<div class="logo">			
					<?php if (fp_get_settings( 'fp_logo_url' )) { ?>
						<h1>
							<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
								<img src="<?php echo fp_get_settings( 'fp_logo_url' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
							</a>
						</h1>	
					<?php } else {?>
						<h1 class="site-title">
							<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
								<?php bloginfo('name'); ?>
							</a>
						</h1>					
					<?php } ?>	
				</div>
                <div id="searchysocial">
                <form method="get" id="searchform" class="search-form" action="http://www.multimediacorp.net/concanaco/">
		<input type="text" class="search-field" name="s" id="s" placeholder="Buscar"  style="width:70%; position:relative; left:25%;"/>
    	<button class="search-submit"><i class="fa fa-search"></i></button>
	</form>
				<?php if ( fp_get_settings( 'fp_show_header_social' ) == 1 ){ ?>
				<div class="social">
					<ul class="list">
                        <li class="twitter" style="margin-top:13px;"><h6>Siguenos<h6></li>
						<?php if (fp_get_settings( 'fp_twitter_url' )){ ?>
							<li class="twitter"><a href="<?php echo fp_get_settings( 'fp_twitter_url' ); ?>"><i class="fa fa-twitter"></i></a></li>
						<?php } ?>
						<?php if (fp_get_settings( 'fp_fb_url' )){ ?>
							<li class="fb"><a href="<?php echo fp_get_settings( 'fp_fb_url' ); ?>"><i class="fa fa-facebook"></i></a></li>

						<?php } ?>
						<?php if (fp_get_settings( 'fp_gplus_url' )){ ?>
							<li class="gplus"><a href="<?php echo fp_get_settings( 'fp_gplus_url' ); ?>"><i class="fa fa-google-plus"></i></a></li>
						<?php } ?>
						<?php if (fp_get_settings( 'fp_linkedin_url' )){ ?>
							<li class="twitter"><a href="<?php echo fp_get_settings( 'fp_linkedin_url' ); ?>"><i class="fa fa-linkedin"></i></a></li>
						<?php } ?>
						<?php if (fp_get_settings( 'fp_pinterest_url' )){ ?>
							<li class="pinterest"><a href="<?php echo fp_get_settings( 'fp_pinterest_url' ); ?>"><i class="fa fa-pinterest"></i></a></li>
						<?php } ?>
						<?php if (fp_get_settings( 'fp_instagram_url' )){ ?>
							<li class="instagram"><a href="<?php echo fp_get_settings( 'fp_instagram_url' ); ?>"><i class="fa fa-instagram"></i></a></li>
						<?php } ?>
						<?php if (fp_get_settings( 'fp_dribbble_url' )){ ?>
							<li class="dribbble"><a href="<?php echo fp_get_settings( 'fp_dribbble_url' ); ?>"><i class="fa fa-dribbble"></i></a></li>
						<?php } ?>
						<?php if (fp_get_settings( 'fp_youtube_url' )){ ?>
							<li class="youtube"><a href="<?php echo fp_get_settings( 'fp_youtube_url' ); ?>"><i class="fa fa-youtube"></i></a></li>
						<?php } ?>
						<?php if (fp_get_settings( 'fp_rss_url' )){ ?>
							<li class="rss"><a href="<?php echo fp_get_settings( 'fp_rss_url' ); ?>"><i class="fa fa-rss"></i></a></li>
						<?php } ?>
					</ul>
				</div>						
			<?php } ?>
			</div>
            </div>
			<div class="menu-section clearfix">

				<nav class="primary-menu clearfix">

					<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '0', 'menu_class' => 'sf-menu', 'fallback_cb' => 'fp_main_menu_fallback') ); ?>

				</nav>

			</div>
            <div class="espa">

            </div>

            <div class="showForex">
                <div id="dolar" style=" width:26%; height:100%; float:left;">

                	<div id="tit" style="width:48%; height:100%; float:left; border-right:1px solid #CCC; text-align:right; font-weight:bold;">
                    	<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%;">
                        	<span style="margin-right:10px;">DÓLAR</span>
                        </div>
                        <div id="b" style="height:50%; width:100%;">
                        	<span style="margin-right:10px;">INTERBANCARIO</span>
                        </div>
                	</div>
                    <div id="comp" style="width:25%; height:100%; float:left; border-right:1px solid #CCC; text-align:center;">
                    	<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%;">
                        	<span style="font-size:12px;">compra</span>
                        </div>
                        <div id="b" style="height:50%; width:100%;">
				13.2400
                        </div>
                	</div>
                    <div id="vent" style="width:25%; height:100%; float:left; border-right:1px solid #CCC; text-align:center;">
                    	<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%;">
                        	<span style="font-size:12px;">venta</span>
                        </div>
                        <div id="b" style="height:50%; width:100%;">
				13.8400
                        </div>
                	</div>
                </div>
                <div id="euro" style="width:20%; height:100%; float:left;">
                	<div id="tit" style="width:32%; height:100%; float:left; border-right:1px solid #CCC; border-right:1px solid #CCC; text-align:right; font-weight:bold;">
                    	<div id="tt" style="height:0%; width:100%;">
                        </div>
                    	<div id="t" style="height:33%; width:100%;">
                        </div>
                        <div id="b" style="height:67%; width:100%;">
                        	<span style="margin-right:10px;">EURO</span>
                        </div>
                	</div>
                    <div id="comp" style="width:32%; height:100%; float:left; border-right:1px solid #CCC; text-align:center;">
                    	<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%;">
                        	<span style="font-size:12px;">compra</span>
                        </div>
                        <div id="b" style="height:50%; width:100%;">
				16.7365
                        </div>
                	</div>
                    <div id="vent" style="width:32%; height:100%; float:left; border-right:1px solid #CCC; text-align:center;">
                    	<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%;">
                        	<span style="font-size:12px;">venta</span>
                        </div>
                        <div id="b" style="height:50%; width:100%;">
				17.1940
                        </div>
                	</div>
                </div>
                <div id="ipc" style="width:14%; height:100%; float:left; border-right:1px solid #CCC;">
                		<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%; text-align:center; font-weight:bold;">
                        	<span>IPC</span>
                        </div>
                        <div id="b" style="height:50%; width:100%; text-align:center;">
                        	<span style="margin-right:10px;">353.96&nbsp;&nbsp;<img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/arrowGreen.png" width="11px"/></span>
                        </div>
                </div>
                <div id="dowjones" style="width:13%; height:100%; float:left; border-right:1px solid #CCC;">
                		<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%; text-align:center; font-weight:bold;">
                        	<span>DOW JONES</span>
                        </div>
                        <div id="b" style="height:50%; width:100%; text-align:center; ">
                        	<span style="margin-right:10px;">17,684.10&nbsp;&nbsp;<img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/arrowGreen.png" width="11px"/></span>
                        </div>
                </div>
                <div id="nasqad" style="width:13%; height:100%; float:left; border-right:1px solid #CCC;">
                		<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%; text-align:center; font-weight:bold;">
                        	<span>NASQAT</span>
                        </div>
                        <div id="b" style="height:50%; width:100%; text-align:center;">
                        	<span style="margin-right:10px;">4,692.43&nbsp;&nbsp;<img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/arrowGreen.png" width="11px"/></span>
                        </div>
                </div>
                <div id="act" style="width:13%; height:100%; float:left; text-align:center; font-weight:bold;">
                		<div id="tt" style="height:15%; width:100%;">
                        </div>
                    	<div id="t" style="height:35%; width:100%;">
                        	<span style="font-size:12px;">Actualizado a las 10:00</span>
                        </div>
                        <div id="b" style="height:50%; width:100%;">
                        </div>
                </div>
            </div>
<script type="text/javascript">

	$('.showForex').load('http://www.google.com');

</script>
		</header>
	<div id="main">	
		<?php
			/*if ( get_query_var('paged') ) {
				$paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
				$paged = get_query_var('page');
			} else {
				$paged = 1;
			}
			if (is_page_template('page-home.php')&& ($paged < 2 )){
				$fp_show_slider = get_post_meta($post->ID, 'fp_meta_show_slider', true);
				if ( $fp_show_slider == 1 ){				
					get_template_part( 'includes/slider' );				
				}

			}*/
		?>

	<div class="content-wrap">	