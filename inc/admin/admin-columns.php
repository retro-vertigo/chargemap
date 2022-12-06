<?php

// ==============================================

//        ADMIN COLUMNS

// ==============================================



//  Custom columns in admin posts list
// -----------------------------------------------

// Add custom columns head in admin posts list
add_filter( 'manage_post_posts_columns', 'pga_manage_post_column_head' );
add_filter( 'manage_page_posts_columns', 'pga_manage_post_column_head' );
function pga_manage_post_column_head( $columns ) {
	// remove columns
	unset( $columns['tags'] );

	// add custom columns
	$columns['lang']           = 'Lg';
  $columns['featured_image'] = 'Image à la une';
  return $columns;
}


// Reorder columns in admin posts list ('lang' column before 'title' column)
add_filter( 'manage_post_posts_columns', 'pga_order_post_column' );
add_filter( 'manage_page_posts_columns', 'pga_order_post_column' );
function pga_order_post_column( $columns ) {
  $n_columns = array();
  $move      = 'lang'; 		// what to move
  $before    = 'title'; 	// move before this

  foreach( $columns as $key => $value ) {
		if ( $key == $before ) $n_columns[$move] = $move;
    $n_columns[$key] = $value;
	}
	return $n_columns;
}


// Add custom columns content in admin posts list
add_action( 'manage_post_posts_custom_column', 'pga_manage_post_column_content', 10, 2 );
add_action( 'manage_page_posts_custom_column', 'pga_manage_post_column_content', 10, 2 );
function pga_manage_post_column_content( $column_name, $post_id ) {
	if ( $column_name == 'featured_image' ) {
		if ( get_post_type( $post_id ) == 'page' ) {
			// get hero block in page
			global $post;
			$blocks   = parse_blocks( $post->post_content );

			if ( !empty( $blocks )) {
				$block = $blocks[0];

				if ( in_array( $block['blockName'],  [ "acf/cover-image", "acf/cover-video" ] )) {
					$image_id = $block['attrs']['data']['image'];
		
					// show image
					if ( $image_id ) {
						$image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
						echo "<img src='{$image[0]}' />";
					}
				}
			}
		} 
	} else if ( $column_name == 'lang' ) {
		$lang = pl_get_post_language( $post_id );
		$image = IMAGE_URL . "flags/flag-{$lang}.png";
		echo "<img src='{$image}' class='flag-lang' />";
	} 
}





// Style admin posts / categories list columns
add_action( 'admin_head-edit.php', 'pga_style_admin_column' );
add_action( 'admin_head-edit-tags.php', 'pga_style_admin_column' );
function pga_style_admin_column() {
  echo '<style type="text/css">
			.column-featured_image { width: 100px !important; text-align: center; }
			.column-featured_image img { width: 50px; height: 50px; object-fit: cover; }

			.column-lang { width: 24px !important; }
			.column-lang .flag-lang { display: inline-block; margin-top: 6px; opacity: 0.7; }
		</style>';
}
