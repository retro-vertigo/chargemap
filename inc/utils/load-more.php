<?php

// ==============================================

//        AJAX LOAD MORE POSTS

// ==============================================

// load more posts with AJAX, function called in LoadMore.js class
function pga_load_more_posts() {
	// check WP_nonce validity send by Ajax
	// check_ajax_referer('load_more_posts', 'security');

	$args = array(
		'post_type'      => $_POST['post_type'],        // 'post' or 'project'
		'posts_per_page' => $_POST['posts_per_page'],
		'paged'          => $_POST['paged'],
		'order'          => 'DESC',
		'post_status'    => 'publish',
	);	

	// optional category filter
	if( isset( $_POST['term_id'] ) && !empty( $_POST['term_id'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $_POST['taxonomy'],		 // 'category' or 'cat_project'
				'field' => 'id',
				'terms' => $_POST['term_id']
			)
		);
	}
	$query = new WP_Query( $args );

	// prepare output for ajax
	$data['found_posts'] = $query->found_posts;
	$data['pages_max'] 	= $query->max_num_pages;
	$data['posts']			= array();

	if( $query->have_posts() ):
		while( $query->have_posts() ): $query->the_post();

			// Render the block.
			$context = Timber::context();
			$context["post_item"]     = new TimberPost();
			$context["animate_class"] = "reveal-init";
			$data['posts'][] = Timber::compile( "partials/". $_POST['card_partial'] .".twig", $context );			// 'card-news' or 'card-project'

		endwhile;
	endif;

	wp_reset_postdata();

	echo json_encode( $data );
	die();


			/* 	
				------ alternate sys without json_encode (remove dataType: 'json' in LoadMore.js )	------ 
			*/
			// if( $query->have_posts() ):
			// 	while( $query->have_posts() ): $query->the_post();

			// 		// Render the block.
			// 		$context = Timber::context();
			// 		$context["post_item"]     = new TimberPost();
			// 		$context["animate_class"] = "reveal-init";
			// 		Timber::render( "partials/card-news.twig", $context );

			// 	endwhile;
			// endif;

			// wp_reset_postdata();

			// die; // here we exit the script and even no wp_reset_query() required!
}
 
add_action('wp_ajax_load_more_posts', 'pga_load_more_posts'); 
add_action('wp_ajax_nopriv_load_more_posts', 'pga_load_more_posts'); 


?>
