<?php

$timebeforerevote = 1;
/*
add_action('wp_ajax_my_function', 'ajaxdata');

add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');
*/
//wp_enqueue_script('like_post', get_template_directory_uri().'/js/scripts.js', array('jquery'), '1.0', 1 );


function post_like(){
	$nonce = $_POST['nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
		
	if(isset($_POST['post_like']))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_POST['post_id'];
		
		$meta_IP = get_post_meta($post_id, "voted_IP");

		$voted_IP = $meta_IP[0];
		if(!is_array($voted_IP))
			$voted_IP = array();
		
		$meta_count = get_post_meta($post_id, "votes_count", true);

		if(!hasAlreadyVoted($post_id))
		{
			$voted_IP[$ip] = time();

			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);
			
			echo $meta_count;
		}
		else
			echo "already";
	}
	exit;
}

function hasAlreadyVoted($post_id){
	global $timebeforerevote;

	$meta_IP = get_post_meta($post_id, "voted_IP");
	$voted_IP = $meta_IP[0];
	if(!is_array($voted_IP))
		$voted_IP = array();
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if(in_array($ip, array_keys($voted_IP)))
	{
		$time = $voted_IP[$ip];
		$now = time();
		
		if(round(($now - $time) / 60) > $timebeforerevote)
			return false;
			
		return true;
	}
	
	return false;
}

function fp_display_rating($post_id){
	$output = "";

	$vote_count = get_post_meta($post_id, "votes_count", true);
	
	$output .= '<div class="post-rating" data-post-id="'.$post_id.'">';
	
	//if ( $vote_count < 1 ){
		$output  .= '<a href="#" data-value="1"><i class="fa fa-star-o"></i></a>';
		$output  .= '<a href="#" data-value="2"><i class="fa fa-star-o"></i></a>';
		$output  .= '<a href="#" data-value="3"><i class="fa fa-star-o"></i></a>';
		$output  .= '<a href="#" data-value="4"><i class="fa fa-star-o"></i></a>';
		$output  .= '<a href="#" data-value="5"><i class="fa fa-star-o"></i></a>';
	//}

	$output .= '</div>';
	
	/*
	$output = '<p class="post-like">';
	if(hasAlreadyVoted($post_id))
		$output .= ' <span title="'.__('I like this article', $themename).'" class="qtip like alreadyvoted"></span>';
	else
		//show the existing rating
		
		$output .= '<a href="#" data-post-id="'.$post_id.'"><i class="fa fa-star-o"></i></a>';		
		
		$output .= '<a href="#" data-post_id="'.$post_id.'">
					<span  title="'.__('I like this article', $themename).'"class="qtip like"></span>
				</a>';
	$output .= '<span class="count">'.$vote_count.'</span></p>';*/
	
	return $output;
}

function fp_rating_already_voted(){
	$voters_list = get_post_meta($id, 'fp_rating_voters', true);
	$voters = explode(",", $voters_list);
	//http://bavotasan.com/2009/simple-voting-for-wordpress-with-php-and-jquery/
	foreach($voters as $voter) {
		if($voter == $user_ID) {
			return true;
		}
			
		
	}
	
	
}

function fp_rating_process(){ 
	$nonce = $_POST['nonce'];
	
	if ( !is_user_logged_in() ){
		_e('You must be logged in to vote', 'fairpixels');
		die;
	}
	
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ){
		_e('An error occured, please try again later', 'fairpixels');
		die;
	}
	
	if ( fp_rating_already_voted($post_id) ){
		_e('You have already voted', 'fairpixels');
		die;
	}
	
	if(isset($_POST['rate_post'])){
		$post_id = $_POST['post_id'];
		$new_rating = $_POST['post_rating'];
	
		$rating_votes = get_post_meta($post_id, "fp_rating_votes", true);
		$rating_average = get_post_meta($post_id, "fp_rating_average", true);
		
		$new_rating_votes = $rating_votes + 1;
		$new_average_score = (( $rating_average * $rating_votes ) + $new_rating ) / $new_rating_votes;
		
		update_post_meta($post_id, "fp_rating_votes", $new_rating_votes);
		update_post_meta($post_id, "fp_rating_average", $new_average_score);
		
		//set cookie
		setcookie( 'fp_rating', 'true', time() + 2592000, '/');
		echo $new_average_score;
	}
        
		
	//echo $nonce;
	//update_post_meta(4, "fp_rating_average", 96);
    die(); 
}

add_action('wp_ajax_nopriv_rate-post', 'fp_rating_process');	//executed when logged out
add_action('wp_ajax_rate-post', 'fp_rating_process'); 			//executed when logged in


	   
	   

/*===================*/
function fp_likes_display(){
	
}

function fp_likes_process(){

}

function fp_likes_already_done(){

}