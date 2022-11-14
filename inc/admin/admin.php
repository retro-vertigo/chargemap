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



// add_action( 'init', 'pga_enable_page_excerpt' );
// function pga_enable_page_excerpt() {
//   add_post_type_support( 'page', array( 'excerpt' ) );
// }

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'admin_list_thumbnail', 55, 55, true );
}


// Remove accents from the name of uploaded files (Thanks to: https://goo.gl/h2tYrZ)
add_filter( 'wp_handle_upload_prefilter', 'pga_sanitize_file_uploads' );
function pga_sanitize_file_uploads( $file ) {
	$file['name'] = sanitize_file_name( $file['name'] );
	$file['name'] = preg_replace( '/[^a-zA-Z0-9\_\-\.]/', '', $file['name'] );
	$file['name'] = strtolower( $file['name'] );
	add_filter( 'sanitize_file_name', 'remove_accents' );

	return $file;
}


