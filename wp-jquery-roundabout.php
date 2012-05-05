<?php
/*
	Plugin Name: WP jQuery Roundabout
	Plugin URI: http://wordpress.org/extend/plugins/
	Description: Roundabout carousel for WordPress posts
	Author: Wylie Hobbs
	Version: 0.1-alpha
	Author URI: http://wordpress.org/extend/plugins/
	Text Domain: wp-jquery-roundabout
	Domain Path: /lang
 */


include('lib/functions.php');


// Example shortcode: [wp-rabt cat="3" type="post" show="3" order="ASC" mode="attachments" textlength="200"]
function display_carousel(){
	extract( shortcode_atts( array(
      'cat' => '',
      'type' => 'post',
      'show' => 3,
      'order' => 'DESC',
      'mode' => 'post',
      'textlength' => 200
     ), $atts ) );
     
	$class = '';
	
	if($mode == 'attachments'){
		$class='attachment-mode';
	}
	else{
		$class='default-mode';
	}
	echo '<div id="roundabout-container">';
		echo '<ul id="wp-roundabout" class="' . $class . '">';
		
	global $post;
		
		$args = array(
			'post_type' => $type,
			'numberposts' => $show
		);

	
		$posts = get_posts( $args );
		
		foreach($posts as $post){
		
			if($mode == 'attachments'){
				
				$att_args = array(
				 	'post_type' => 'attachment',
				 	'numberposts' => 2,
				 	'orderby' => 'post_date',
				 	'order' => 'DESC',
				 	'post_status' => null,
				 	'post_parent' => $post->ID
				);
	
				 $attachments = get_posts( $att_args );
				 $count = count($attachments);
				 $image = '';
				 $i = 0;
			 
				if ( $attachments && $count > 2 && $post->ID != 13 ) {
					  foreach ( $attachments as $attachment ) {
					  		echo '<li><a href="'.get_permalink($post->ID).'">';
					  		echo wp_get_attachment_image( $attachment->ID, 'full' );
					  		echo '</a></li>';
						}
					}else {
						foreach ( $attachments as $attachment ) {
					   		$image[$i] =  wp_get_attachment_image( $attachment->ID, 'full' );
					   		$i++;
						}
						if($post->ID == 13){
							echo '<li><a href="'.get_permalink($post->ID).'">'.$image[1].'</a></li>';
						}else{
							echo '<li><a href="'.get_permalink($post->ID).'">'.$image[0].'</a></li>';
						}
					}
				}
				
			else{
				echo '<li><a href="' . get_permalink($post->ID) . '">';
				
				echo '<div class="wp-rabt-image">' . get_the_post_thumbnail($post->ID) . '</div>';
				echo '<div class="wp-rabt-content">';
				echo '<h5>' . $post->post_title . '</h5>';
				echo custom_text_length($textlength, 'read more', 'content');
				echo '</div>';
				echo '</a></li>';
			}
		}
		
		
		echo '</ul>';
	echo '</div>';
	wp_reset_postdata();
	
}

add_shortcode('wp-rabt', 'display_carousel');
add_theme_support('post-thumbnails');
add_filter('get_the_content', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');


function roundabout_scripts() 
{
	wp_enqueue_script('jquery-roundabout', plugins_url('/js/jquery.roundabout.min.js', __FILE__),
		array('jquery')
	);
	wp_enqueue_script(
		'roundabout-init',
		plugins_url('/js/roundabout.js', __FILE__),
		array('jquery-roundabout')
	);
	wp_register_style($handle = 'rabt-default-css', $src = plugins_url('skins/default.css', __FILE__), $deps = array(), $ver = '1.0.0', $media = 'all');
	wp_enqueue_style('rabt-default-css');
}

add_action ('wp_enqueue_scripts', 'roundabout_scripts');


require('wp-rabt-options.php');









