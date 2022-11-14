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
}

add_action( 'init', 'pga_unregister_tags_for_posts' );
function pga_unregister_tags_for_posts() {
	unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}


// TOUPDATE
// Remove post post_type in admin (sidebar, topbar, nav_menu...)
// add_filter( 'register_post_type_args', 'pga_remove_default_post_type', 0, 2 );
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



/*
* Display a custom taxonomy dropdown in admin
* @author Mike Hemberger
* @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
*/
// add_action( 'restrict_manage_posts', 'pga_filter_post_type_by_taxonomy' );
function pga_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'job'; // change to your post type
	$taxonomies = array( 'domain', 'contract', 'location' );		// change to your taxonomy
	
	if ( $typenow == $post_type ) {
		foreach ( $taxonomies as $taxonomy ) {
			$selected      = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';
			$taxonomy_object = get_taxonomy( $taxonomy );
			wp_dropdown_categories(array(
				'show_option_all' => $taxonomy_object->labels->all_items,
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'hide_empty'      => true,
			));
    }
	};
}

/**
* Filter posts by taxonomy in admin
* @author  Mike Hemberger
* @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
*/
// add_filter( 'parse_query', 'pga_convert_id_to_term_in_query' );
function pga_convert_id_to_term_in_query( $query ) {
	global $pagenow;
	$post_type = 'job'; // change to your post type
	$taxonomies = array( 'domain', 'contract', 'location' );		// change to your taxonomy

	$q_vars    = &$query->query_vars;

	foreach ( $taxonomies as $taxonomy ) {
		if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
			$term = get_term_by( 'id', $q_vars[$taxonomy], $taxonomy );
			$q_vars[$taxonomy] = $term->slug;
		}
	}
}


// TOUPDATE
// Hide the term description in taxonomy pages ( add and edit)
// add_action( 'domain_edit_form', 'pga_hide_term_description_form' );
// add_action( 'domain_add_form', 'pga_hide_term_description_form' );
// add_action( 'contract_edit_form', 'pga_hide_term_description_form' );
// add_action( 'contract_add_form', 'pga_hide_term_description_form' );
// add_action( 'location_edit_form', 'pga_hide_term_description_form' );
// add_action( 'location_add_form', 'pga_hide_term_description_form' );
// function pga_hide_term_description_form() {
// 	echo "<style> .term-description-wrap { display:none; } </style>";
// }



// Rename default post labels
add_filter( 'post_type_labels_post', 'pga_news_rename_labels' );
function pga_news_rename_labels( $labels ) {
    // Labels
    $labels->name = 'Actualités';
    $labels->singular_name = 'Actualité';
		$labels->add_new = 'Ajouter une actualité';
		$labels->add_new_item = 'Ajouter une nouvelle actualité';
		$labels->edit_item = 'Modifier l\'actualité';
		$labels->new_item = 'News';
		$labels->view_item = 'Voir l\'actualité';
	$labels->view_items = 'View News';
    $labels->search_items = 'Rechercher dans les actualités';
		$labels->not_found = 'Aucune actualité trouvée.';
		$labels->not_found_in_trash = 'Aucune actualité trouvée dans la poubelle.';
	// $labels->parent_item_colon = 'Parent news'; // Not for "post"
	// $labels->archives = 'News Archives';
	// $labels->attributes = 'News Attributes';
	// $labels->insert_into_item = 'Insert into news';
	// $labels->uploaded_to_this_item = 'Uploaded to this news';
	// $labels->featured_image = 'Featured Image';
	// $labels->set_featured_image = 'Set featured image';
	// $labels->remove_featured_image = 'Remove featured image';
	// $labels->use_featured_image = 'Use as featured image';
	// $labels->filter_items_list = 'Filter news list';
	// $labels->items_list_navigation = 'News list navigation';
	// $labels->items_list = 'News list';

    // Menu
    $labels->menu_name = 'Actualités';
    $labels->all_items = 'Toutes les actualités';
    $labels->name_admin_bar = 'Actualité';

    return $labels;
}


// Change sidebar menu order
add_filter( 'custom_menu_order', 'pga_custom_menu_order' );
add_filter( 'menu_order', 'pga_custom_menu_order' );
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



// Change the pin icon to a megaphone
add_action( 'admin_menu', 'pga_change_post_menu_icon' );
function pga_change_post_menu_icon() {
	// Access global variables.
	global $menu;

	foreach ( $menu as $key => $val ) {
		if ( 'Actualités' == $val[0] ) {
			$menu[$key][6] = 'dashicons-megaphone';
		}
	}
}