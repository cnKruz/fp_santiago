<?php
/**
 * The template for displaying the related posts.
 * Gets the related posts using the same tags. 
 * If no thre are no tags, displays the latest posts.
 *
 * @package  WordPress
 * @file     related-posts.php
 * @author   FairPixels
 * @link 	 http://fairpixels.com
 * 
 **/
?>

<?php

$tags = wp_get_post_tags($post->ID);
$number = 3;
$args = array();
$args2 = array();

if ($tags) {
    $tag_ids = array();
    
	foreach($tags as $tag){
		$tag_ids[] = $tag->term_id;
	}

    $args = array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'showposts'=> $number,
    ); 
	
    if( count($args) < $number ) {
        $n = $number - count($args);
        if ($categories) {
			$category_ids = array();
			foreach($categories as $cat) $category_ids[] = $cat->term_id;

			$args2 = array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
				'showposts'=> $n,
            );      
		}
    }
    $args = array_merge( $args, $args2 );
} else {
    $categories = get_the_category($post->ID);  
    if ($categories) {
        $category_ids = array();
        foreach($categories as $cat) $category_ids[] = $cat->term_id;

        $args = array(
            'category__in' => $category_ids,
            'post__not_in' => array($post->ID),
            'showposts'=> $number,
        );      
    }
}

if($args){

	$my_query = new wp_query($args);
	
	if( $my_query->have_posts() ) {	?>
		<div class="related-posts">
			
			<ul class="list">
				<?php		
					$post_count = 0;
					while ($my_query->have_posts()) {
						$my_query->the_post();	
							$last = '';
							if (++$post_count  == 3) {
								$last = ' col-last';
							}
						?>
						<li class="<?php echo $last; ?>">
							<?php if ( has_post_thumbnail() ) {	?>
								<div class="thumbnail">
									<a href="<?php the_permalink(); ?>" >
										<?php the_post_thumbnail( 'fp370_215' ); ?>
									</a>
								</div>
							<?php } ?>
						
							<h6>								
								<a href="<?php the_permalink() ?>">
									<?php the_title(); ?>	
								</a>
							</h6>	
									
							<div class="entry-meta">
								<span class="date">
									<?php echo get_the_date(); ?>
								</span>
							</div>				
						</li>
					<?php
					}		
				?>
			</ul>		
		</div>		
		<?php		
	}
	wp_reset_query();	
}

?>