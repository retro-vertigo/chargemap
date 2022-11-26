<?php

// ==============================================

//        ACF BLOCKS

// ==============================================


//  Custom ACF blocks
// -----------------------------------------------

// Register ACF blocks
add_action( 'acf/init', 'pga_acf_init_blocks' );
function pga_acf_init_blocks() {

	// common params
	$enqueue_assets = 'pga_acf_block_enqueue_assets';


	pga_acf_register_block( array(
		'name'            => 'cover-image',
		'title'           => __('Couverture image'),
		'description'     => __('Couverture image et texte'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'cover-video',
		'title'           => __('Couverture vidéo'),
		'description'     => __('Couverture vidéo et texte'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'tabs',
		'title'           => __('Onglets'),
		'description'     => __('Onglets en icônes'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
		'enqueue_assets'  => $enqueue_assets,
	));

	pga_acf_register_block( array(
		'name'            => 'columns',
		'title'           => __('Trois colonnes'),
		'description'     => __('Trois colonnes'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'cta',
		'title'           => __('Call To Action'),
		'description'     => __('Call To Action'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'cta-illus',
		'title'           => __('Call To Action illustration'),
		'description'     => __('Call To Action avec boutons en illustration'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'cta-cards',
		'title'           => __('Call To Action carte'),
		'description'     => __('Call To Action avec cartes'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'logos',
		'title'           => __('Slider de logos'),
		'description'     => __('Slider de logos'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
		'enqueue_assets'  => $enqueue_assets,
	));

	pga_acf_register_block( array(
		'name'            => 'testimonial',
		'title'           => __('Slider de témoignages'),
		'description'     => __('Slider de témoignages'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
		'enqueue_assets'  => $enqueue_assets,
	));

	pga_acf_register_block( array(
		'name'            => 'anchors',
		'title'           => __('Ancres'),
		'description'     => __('Ancres en icônes'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'download',
		'title'           => __('Téléchargement'),
		'description'     => __('Téléchargement'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'timeline',
		'title'           => __('Historique'),
		'description'     => __('Historique'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));

	pga_acf_register_block( array(
		'name'            => 'press',
		'title'           => __('Presse'),
		'description'     => __('Presse'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));
	


	pga_acf_register_block( array(
		'name'            => 'image-text',
		'title'           => __('Image et texte'),
		'description'     => __('Image et texte côte à côte'),
		'icon'            => 'cover-image',
		'supports'        => array( 'anchor' => true ),
	));




	
	/*
		pga_acf_register_block( array(
			'name'            => 'side-image',
			'title'           => __('Image alignée à droite'),
			'description'     => __('Image alignée à droite'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'values',
			'title'           => __('Liste de valeurs'),
			'description'     => __('Liste de valeurs'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'gallery',
			'title'           => __('Galerie d\'images'),
			'description'     => __('Galerie d\'images'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'cta',
			'title'           => __('Call to Action'),
			'description'     => __('Call to Action'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'truc',
			'title'           => __('Truc en plus'),
			'description'     => __('Truc en plus'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'team',
			'title'           => __('Membres de l\'équipe'),
			'description'     => __('Membres de l\'équipe'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'accordion',
			'title'           => __('Accordéon'),
			'description'     => __('Accordéon'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
			'enqueue_assets'  => $enqueue_assets,
		));
		pga_acf_register_block( array(
			'name'            => 'brands',
			'title'           => __('Marques'),
			'description'     => __('Marques'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'push-news',
			'title'           => __('Dernières actualités'),
			'description'     => __('Dernières actualités'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
		));
		pga_acf_register_block( array(
			'name'            => 'push-projects',
			'title'           => __('Dernières références'),
			'description'     => __('Dernières références'),
			'icon'            => 'cover-image',
			'supports'        => array( 'anchor' => true ),
			'enqueue_assets'  => $enqueue_assets,
		));
		*/
}
 

// Add block with default params
function pga_acf_register_block( $params ) {
	$default_category = 'custom-cat';
	$default_render_callback = 'pga_acf_block_render_callback';
	$default_icon = 'edit';
	$default_background_icon = '#CFEEFA';

	if ( empty($params['category']) ) $params['category'] = $default_category;
	if ( empty($params['render_callback']) ) $params['render_callback'] = $default_render_callback;
	if ( empty($params['icon']) ) $params['icon'] = $default_icon;
	$params['icon'] = array( 'background' => $default_background_icon, 'src' => $params['icon'] );
	
	if( function_exists('acf_register_block') ) {
		acf_register_block( $params );
	}
}


// Include templates block html
function pga_acf_block_render_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
		// convert name ("acf/testimonial") into path friendly slug ("testimonial")
		$slug = str_replace( 'acf/', '', $block['name'] );
		$block['slug'] = $slug;

		//  Set common classes and id from ACF
		// -----------------------------------------------
		// Create id attribute allowing for custom "anchor" value.
		$block['uniq_id'] = trim($block['id'], 'block_');			// stocke l'id unique dans une autre variable
		$id = "{$slug}-" . $block['id']; 
		if( !empty($block['anchor']) ) $id = $block['anchor'];
		$block['id'] = $id;

		// Create class attribute allowing for custom "className" and "align" values.
		$classes = array( "block-{$slug}", "block" );
		if( !empty($block['className']) ) $classes[] = $block['className'];
		if( !empty($block['align']) ) $classes[] = 'align' . $block['align'];
		if( !empty($block['align_text']) ) $classes[] = 'align-text-' . $block['align_text'];
		if( !empty($block['align_content']) ) $classes[] = 'align-content-' . $block['align_content'];
		if( $is_preview ) $classes[] = 'is-admin';
		$block['classes'] = implode(' ', $classes);


		$context = Timber::context();

    // Store block values.
    $context['block'] = $block;

    // Store field values.  
    $context['fields'] = get_fields();
		$fields = get_fields();
		foreach ( $fields as $key => $field ) {
			$context[$key] = $field;
    }

    // Render the block.
    Timber::render( "blocks/block-{$slug}.twig", $context );
}


function pga_acf_block_enqueue_assets( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	$slug = str_replace( 'acf/', '', $block['name'] );

	// load js assets only in admin editor
	if( is_admin() ) wp_enqueue_script( "block-{$slug}", JS_URL."blocks-admin/block-{$slug}.min.js", '', null, true );
}
