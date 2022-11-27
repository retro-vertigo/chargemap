<?php

// ==============================================

//        GUTENBERG EDITOR

// ==============================================



//  Custom editor
// -----------------------------------------------

// Add embeded custom stylesheet inline for blocks editor
add_action( 'after_setup_theme', 'pga_setup_editor_styles' );
function pga_setup_editor_styles() {
  add_theme_support( 'editor-styles' );
  add_editor_style( 'assets/css/custom-editor-inline.min.css' );
}


// Add external custom stylesheet in blocks editor only
add_action( 'enqueue_block_editor_assets', 'pga_block_editor_styles' );
function pga_block_editor_styles() {
  wp_enqueue_style( 'site-block-editor-styles', CSS_URL.'custom-editor.min.css', '', filemtime( CSS_PATH.'custom-editor.min.css' ));
  // deny list for embed core blocks
  wp_enqueue_script( 'deny-list-blocks', JS_URL . '/deny-list-blocks.min.js', array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ));
}


// Embed svg icons in admin
add_action( 'in_admin_header', 'pga_embed_sprites_icon' );
function pga_embed_sprites_icon() {
  // add hidden styles in admin when svg sprite contains svgs with mask
  // echo '<style type="text/css">
  // .visually-hidden {
  //   clip: rect(0 0 0 0);
  //   clip-path: inset(50%);
  //   height: 1px;
  //   overflow: hidden;
  //   position: absolute;
  //   white-space: nowrap;
  //   width: 1px;
  // }
  // </style>';
  // if( get_page_template_slug( $post ) == 'templates/template-home.php' ) {
  echo file_get_contents( SVG_PATH.'sprite.svg' );
}



//  Blocks
// -----------------------------------------------

// Restrict default blocks
add_filter( 'allowed_block_types_all', 'pga_allow_block_types', 10, 2 );
function pga_allow_block_types( $allowed_blocks, $editor_context ) {
  
  if ( !empty( $editor_context->post ) ) {
    $post = $editor_context->post;

    // Default ACF blocks
    $custom_blocks = array(
      'acf/cover-image',
      'acf/cover-video',
      'acf/tabs',
      'acf/columns',
      'acf/cta',
      'acf/cta-illus',
      'acf/cta-cards',
      'acf/logos',
      'acf/testimonial',
      'acf/anchors',
      'acf/download',
      'acf/timeline',
      'acf/press',
      'acf/guide',

      'acf/image-text',
    );

     // No blocks for page contact and page actualités (blog page)
     if( get_page_template_slug( $post ) == 'template-contact.php' || $post->ID == get_option( 'page_for_posts' )) {
      $custom_blocks = array();
    }
/* 
     // Only some WP blocks for page legal
     if( get_page_template_slug( $post ) == 'template-legal.php') {
      $custom_blocks = array(
        'core/heading',
        'core/paragraph',
        'core/list',
      );
    }

    // Only some WP blocks for single post and single project
    if( $post->post_type == 'post' || $post->post_type == 'project' ) {
      $custom_blocks = array(
        'core/heading',
        'core/paragraph',
        'core/list',
        'core/image',
        'core/embed'
      );
    } */
    
    $allowed_blocks = $custom_blocks;
  }
  return $allowed_blocks;
}




// Add custom block category
add_filter( 'block_categories_all', 'pga_add_block_categories', 10, 2 );
function pga_add_block_categories( $categories, $post ) {
  // if ( $post->post_type !== 'post' ) {
  //     return $categories;
  // }
  return array_merge(
      $categories,
      array(
          array(
              'slug' => 'custom-cat',
              'title' => __( 'Blocs du thème', 'my-plugin' ),
              'icon'  => 'star-empty',
          ),
      )
  );
}


// Disable fullscren mode editor mode
add_action( 'enqueue_block_editor_assets', 'pga_disable_editor_fullscreen_by_default' );
function pga_disable_editor_fullscreen_by_default() {
	$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
	wp_add_inline_script( 'wp-blocks', $script );
}


// Remove default Gutenberg block styles
function pga_remove_wp_block_library_css(){
  wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'pga_remove_wp_block_library_css', 100 );
