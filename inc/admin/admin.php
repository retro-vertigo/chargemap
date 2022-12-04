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
	add_image_size( 'standard', 564, 415, true ); 
	add_image_size( 'standard-mobile', 420, 309, true );
	add_image_size( 'webinar-zoom', 174, 174, true );
	add_image_size( 'cover-video', 504, 504, true );
	add_image_size( 'logo', 216, 120 );
}


add_filter( 'intermediate_image_sizes_advanced', 'pga_remove_default_images' );
// This will remove the default image sizes and the medium_large size. 
function pga_remove_default_images( $sizes ) {
//  unset( $sizes['medium']); // 300px
 unset( $sizes['large']); // 1024px
 unset( $sizes['medium_large']); // 768px
 return $sizes;
}


add_filter('big_image_size_threshold', '__return_false');

// Remove accents from the name of uploaded files (Thanks to: https://goo.gl/h2tYrZ)
add_filter( 'wp_handle_upload_prefilter', 'pga_sanitize_file_uploads' );
function pga_sanitize_file_uploads( $file ) {
	$file['name'] = sanitize_file_name( $file['name'] );
	$file['name'] = preg_replace( '/[^a-zA-Z0-9\_\-\.]/', '', $file['name'] );
	$file['name'] = strtolower( $file['name'] );
	add_filter( 'sanitize_file_name', 'remove_accents' );

	return $file;
}


