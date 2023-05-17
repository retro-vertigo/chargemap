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
	add_image_size( 'admin_thumbnail', 50, 50, true ); 
	add_image_size( 'standard', 564, 415, true ); 
	add_image_size( 'standard-2x', 1128, 830, true ); 
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

add_filter( 'jpeg_quality', function($arg){ return 94; });


// Remove accents from the name of uploaded files (Thanks to: https://goo.gl/h2tYrZ)
add_filter( 'wp_handle_upload_prefilter', 'pga_sanitize_file_uploads' );
function pga_sanitize_file_uploads( $file ) {
	$file['name'] = sanitize_file_name( $file['name'] );
	$file['name'] = preg_replace( '/[^a-zA-Z0-9\_\-\.]/', '', $file['name'] );
	$file['name'] = strtolower( $file['name'] );
	add_filter( 'sanitize_file_name', 'remove_accents' );

	return $file;
}


// add_filter( 'wp_img_tag_add_loading_attr', 'remove_lazy_loading_by_class', 10, 3 );
function remove_lazy_loading_by_class( $value, $image, $context ) {
	// if ( 'the_content' === $context ) {
			//  if ( false !== strpos( $image, 'no-lazy' ) ) {
						return false;
			//  }
	// }
	dump($image);
	return $value;
}


/* Disable lazy loading for single image* */
function wphelp_no_lazy_load_id( $value, $image, $context ) {
	if ( 'the_content' === $context ) {
		$image_url = wp_get_attachment_image_url( 286, 'cover-video' ); 
		if ( false !== strpos( $image, ' src="' . $image_url . '"' )) {
			return false;
		}
	}
	return $value;
}
// add_filter( 'wp_img_tag_add_loading_attr', 'wphelp_no_lazy_load_id', 36, 36 );
