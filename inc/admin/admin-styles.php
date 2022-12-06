<?php

// ==============================================

//        ADMIN STYLES

// ==============================================


// Remove and add top admin bar items
add_action( 'admin_bar_menu', 'pga_custom_admin_bar', 1000 );
function pga_custom_admin_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_menu( 'comments' ) ;

	if ( current_user_can( 'manage_options' )) {
		// WP Migrate DB
	  $wp_admin_bar->add_node( array(
			'id'    => 'wp_migrate_menu',
			'title' => 'WP Migrate DB',
			'href'  => admin_url( 'tools.php?page=wp-migrate-db-pro' ),
		) );

	  // ACF
	  $wp_admin_bar->add_node( array(
			'id'    => 'acf_menu',
			'title' => 'ACF',
			'href'  => admin_url( 'edit.php?post_type=acf-field-group' )
		) );
	}
}


// Custom sidebar menu
add_action( 'admin_menu', 'pga_custom_admin_sidebar' );
function pga_custom_admin_sidebar() {
	remove_menu_page( 'edit-comments.php' ); 								// Comments
}


// Remove widgets in dashboard screen
add_action( 'wp_dashboard_setup', 'pga_remove_dashboard_widgets', 999 );
function pga_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_quick_press',   'dashboard', 'side' );      // Quick Press widget (quickly write new posts)
	remove_meta_box( 'dashboard_primary',       'dashboard', 'side' );      // WordPress.com Blog
}


// Removes comments from post and pages
add_action( 'admin_init', 'pga_remove_comment_support', 10 );
function pga_remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'post', 'trackbacks' );
	remove_post_type_support( 'page', 'comments' );
	remove_post_type_support( 'page', 'featured_image' );
}

// add_action( 'init', 'pga_unregister_tags_for_posts' );
function pga_unregister_tags_for_posts() {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}


// TOUPDATE
// Remove post post_type in admin (sidebar, topbar, nav_menu...)
add_filter( 'register_post_type_args', 'pga_remove_default_post_type', 0, 2 );
function pga_remove_default_post_type( $args, $post_type ) {

  if ( 'post' === $post_type ) {
    $args['public']      = false;
    $args['has_archive'] = false;
  }
  return $args;
}

// Remove category and tags taxonomy in admin (sidebar, topbar, nav_menu...)
// add_filter( 'register_taxonomy_args', 'pga_remove_default_taxonomy', 10, 2 );
function pga_remove_default_taxonomy( $args, $taxonomy ) {

  if ( in_array( $taxonomy, array( 'category', 'post_tag', 'post_format' )) ) {
    $args['public']            = false;
    $args['show_ui']           = false;
    $args['show_admin_column'] = false;
  }
  return $args;
}


// Overwrite default favicon on admin
add_action( 'admin_head', 'pga_add_admin_favicon' );
function pga_add_admin_favicon() {
	$favicon = FAVICON_URL . "favicon-admin.svg";
	echo "<link rel='icon' href='{$favicon}'>/\n";
	
	// style top admin bar if dev environnement
	if ( ENV == 'dev' ) {
		echo '<style type="text/css">
	  #wpadminbar { background-color: #4B79AF !important; }
	  </style>';
	}
}



// Change sidebar menu order
// add_filter( 'custom_menu_order', 'pga_custom_menu_order' );
// add_filter( 'menu_order', 'pga_custom_menu_order' );
function pga_custom_menu_order( $menu_order ) {
	if ( !$menu_order ) return true;
	return array(
	 'index.php', // this represents the dashboard link
	 'edit.php', // this is the default POST admin menu 
	 'edit.php?post_type=page', // this is the default page menu
	//  'edit.php?post_type=job', // this is a custom post type menu
		//  'upload.php', 
		//  'themes.php', 
		//  'plugins.php', 
		//  'users.php', 
		//  'tools.php', 
		//  'options-general.php', 
		//  'users.php', 
	);
}
