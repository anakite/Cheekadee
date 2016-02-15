<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package BSWP
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bswp_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'bswp_body_classes' );

/**
 * Custom Read More Button
 */
function modify_read_more_link() {

	$read_txt = bswp_option('read_more_text', 'Read More');
	$btn_block = (bswp_option('read_more_block') == '1' ? 'btn-block' : '');
	$btn_size = 'btn-' . bswp_option('read_more_size');
	$btn_color = 'btn-' . bswp_option('read_more_color');


	return '<p><a class="more-link btn '. $btn_color .' '. $btn_size .' '. $btn_block .'" href="' . get_permalink() . '">'. $read_txt .'</a></p>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

/**
 * Custom Edit Button
 */
function custom_edit_post_link($output) {

 $output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-danger btn-xs"', $output);
 return $output;
}
add_filter('edit_post_link', 'custom_edit_post_link');
