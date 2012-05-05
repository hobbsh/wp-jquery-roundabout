<?php
//WP Roundabout Functions


//returns custom text length formatted according to user input
function custom_text_length($charlength, $more_link, $c_type){
	global $post;
	$text = '';
	if($c_type == 'content'){
		$raw_text = $post->post_content;
	}
	else{
		$raw_text = $post->post_content;
	}
	$link = '<a href="'.get_permalink().'">'.$more_link.'</a>';
	if ( mb_strlen( $raw_text ) > $charlength ) {
		$subex = mb_substr( $raw_text, 0, $charlength - 5 );
		$subex = '<p>'.$subex.'…'.$link.'</p>';
		return $subex;
	}
	else{
		$raw_text = '<p>'.$raw_text.'…'.$link.'<p>';
		return $raw_text;
	}
}


?>