<?php

// ==============================================

//        ADMIN FUNCTIONS

// ==============================================


//  Theme support function
// -----------------------------------------------


add_action( 'after_setup_theme', 'pga_setup_theme_support' );
function pga_setup_theme_support() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
  add_theme_support( 'html5', array( 'script', 'style', 'search-form', 'comment-form', 'comment-list',	'gallery',	'caption' ) );
	// Use theme.json instead
	/* add_theme_support( 'editor-font-sizes', []);				// remove typography settings 
  add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'editor-color-palette' );		// remove palette
  add_theme_support( 'disable-custom-colors' ); */

}


add_action( 'after_setup_theme', 'pga_add_image_size' );
function pga_add_image_size() {
	// add_image_size( 'logos', 0, 120 ); // 300 pixels wide (and unlimited height)
}


add_action( 'after_setup_theme', 'my_custom_image_sizes' );
function my_custom_image_sizes() {
	if ( function_exists( 'add_image_size' ) ) {
		add_image_size( "grade-image", 320, 300 );
	}
}

add_filter( 'image_size_names_choose', function ( $sizes ) {
	return array_merge( $sizes, array(
		'grade-image' => __('Grade Image')
	) );
} );




// Remove accents from the name of uploaded files (Thanks to: https://goo.gl/h2tYrZ)
add_filter( 'wp_handle_upload_prefilter', 'pga_sanitize_file_uploads' );
function pga_sanitize_file_uploads( $file ) {
	$file['name'] = sanitize_file_name( $file['name'] );
	$file['name'] = preg_replace( '/[^a-zA-Z0-9\_\-\.]/', '', $file['name'] );
	$file['name'] = strtolower( $file['name'] );
	add_filter( 'sanitize_file_name', 'remove_accents' );

	return $file;
}


