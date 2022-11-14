<?php

// ==============================================

//        YOAST

// ==============================================


//  Custom styles in admin
// -----------------------------------------------

// Remove Yoast columns in posts list, pages list...
add_filter ( 'manage_edit-post_columns', 'pga_remove_yoast_columns' );
add_filter ( 'manage_edit-page_columns', 'pga_remove_yoast_columns' );
add_filter ( 'manage_edit-category_columns', 'pga_remove_yoast_columns' );
add_filter ( 'manage_edit-tag_columns', 'pga_remove_yoast_columns' );
function pga_remove_yoast_columns( $columns ) {
	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-score-readability'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );
	unset( $columns['wpseo-links'] );
	unset( $columns['wpseo-linked'] );
	return $columns;
}


// Remove Yoast dropdowns / filters in posts list, pages list...
add_action( 'admin_init', 'pga_remove_yoast_admin_filters', 20 );
function pga_remove_yoast_admin_filters() {
	global $wpseo_meta_columns;
	if ( $wpseo_meta_columns  ) {
		remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown' ) );
		remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
	}
}


// Remove Yoast dashboard widget
add_action( 'wp_dashboard_setup', 'pga_remove_yoast_dashboard' );
function pga_remove_yoast_dashboard() {
  // In some cases, you may need to replace 'side' with 'normal' or 'advanced'.
  remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
}



//  Yoast
// -----------------------------------------------

// Register Custom Variable in Yoast and increase Character limit
// !!!! bug
// add_action( 'wp_head', 'add_custom_meta_description_box' );

// Get longer excerpt from post content
function custom_length_meta_desc ( $var1 ) {
  global $post;
  return substr( strip_tags( $post->post_content ), 0, 250 );
}

// Add meta variable %%longer_excerpt%% in Yoast
// add_action( 'wpseo_register_extra_replacements', 'add_yoast_custom_variable' );
function add_yoast_custom_variable () {
  wpseo_register_var_replacement( '%%longer_excerpt%%', 'custom_length_meta_desc', 'advanced', 'Auto generate meta description from the content up to 250 characters' );
}
