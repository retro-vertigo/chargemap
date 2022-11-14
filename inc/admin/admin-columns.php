<?php

// ==============================================

//        ADMIN COLUMNS

// ==============================================



//  Custom columns in admin posts list
// -----------------------------------------------

// Add custom columns head in admin posts list
add_filter( 'manage_post_posts_columns', 'pga_manage_post_column_head' );
add_filter( 'manage_page_posts_columns', 'pga_manage_post_column_head' );
add_filter( 'manage_project_posts_columns', 'pga_manage_post_column_head' );
function pga_manage_post_column_head( $columns ) {
	// remove columns
	unset( $columns['tags'] );

	// add custom columns
  $columns['featured_image'] = 'Image à la une';
  return $columns;
}


// Add custom columns content in admin posts list
add_action( 'manage_post_posts_custom_column', 'pga_manage_post_column_content', 10, 2 );
add_action( 'manage_page_posts_custom_column', 'pga_manage_post_column_content', 10, 2 );
add_action( 'manage_project_posts_custom_column', 'pga_manage_post_column_content', 10, 2 );
function pga_manage_post_column_content( $column_name, $post_id ) {
	if ( $column_name == 'featured_image' ) {
		if( has_post_thumbnail( $post_id ) ){
			$post_thumbnail_img = get_the_post_thumbnail( $post_id, 'admin_list_thumbnail' );
			echo $post_thumbnail_img;
		} 
	} 
}


//  Custom columns in admin taxonomy list
// -----------------------------------------------

// Remove description column in admin custom taxonomy list
add_filter( 'manage_edit-domain_columns', 'pga_manage_taxonomy_column_head' );
function pga_manage_taxonomy_column_head( $columns ) {
	// remove columns
	unset( $columns['description'] );
  return $columns;
}



// Style admin posts / categories list columns
add_action( 'admin_head-edit.php', 'pga_style_admin_column' );
add_action( 'admin_head-edit-tags.php', 'pga_style_admin_column' );
function pga_style_admin_column() {
  echo '<style type="text/css">
			.column-featured_image { width: 100px !important; text-align: center; }
		</style>';
}




//  Sortable columns in posts  list
// -----------------------------------------------

// Add sortable columns in admin posts list
add_filter( 'manage_edit-job_sortable_columns', 'pga_sort_column' );
function pga_sort_column( $columns ) {
	$columns['taxonomy-domain']   = 'domain';
	$columns['taxonomy-contract'] = 'contract';
	$columns['taxonomy-location'] = 'location';
	return $columns;
};

// Sort columns by custom taxonomy
add_filter( 'posts_clauses', 'pga_sort_taxonomy_column', 10, 2 );
function pga_sort_taxonomy_column( $clauses, $wp_query ) {
	global $wpdb;
	//array of sortable taxonomies
	$taxonomies = array( 'location', 'contract', 'domain' );

	if ( isset( $wp_query->query['orderby'] ) && in_array( $wp_query->query['orderby'], $taxonomies )) {
		$clauses['join'] .= "
		LEFT OUTER JOIN {$wpdb->term_relationships} AS rel2 ON {$wpdb->posts}.ID = rel2.object_id
		LEFT OUTER JOIN {$wpdb->term_taxonomy} AS tax2 ON rel2.term_taxonomy_id = tax2.term_taxonomy_id
		LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
		";
		$clauses['where'] .= " AND (taxonomy = '{$wp_query->query['orderby']}' OR taxonomy IS NULL)";
		$clauses['groupby'] = "rel2.object_id";
		$clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
		$clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
	}
	return $clauses;
}

