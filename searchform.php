<?php
/**
 * The template for displaying search forms.
 *
 * @package  WordPress
 * @file     searchform.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 */
?>
	<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="search-field" name="s" id="s" placeholder="<?php esc_attr_e( 'Buscar', 'fairpixels' ); ?>" />
    	<button class="search-submit"><i class="fa fa-search"></i></button>
	</form> 