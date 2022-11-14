<?php

// ==============================================

//        MENUS SETUP

// ==============================================


//  Register menus locations
// -----------------------------------------------

add_action( 'init', 'pga_register_menus' );
function pga_register_menus() {
  register_nav_menus(
    array(
      'primary'   => __( 'Menu du header' ),
      'footer' => __( 'Menu du footer' ),
      'legal' => __( 'Menu du footer (pages légales)' ),
      'social'   => __( 'Menu des pages de réseaux sociaux' )
    )
  );
}



//  Customize list items / links
// -----------------------------------------------

// Add custom classes for menu items
add_filter( 'nav_menu_css_class', 'pga_custom_menu_item', 10, 4 );
function pga_custom_menu_item( $classes, $item, $args, $depth ) {
  global $post;

  // add custom classes for all menu items
  // ( <li class="nav-primary__item">...</li> )
  // switch ( $args->theme_location ) {
  switch ( $item->menu->theme_location ) {
    case 'primary':
      $classes[] = 'nav-primary__item';
      break;
    case 'social':
      $classes[] = 'nav-footer__social';
      break;
    case 'legal':
      $classes[] = 'nav-legal__item';
      break;
  }

  // add active class to the current menu item ( <li class="current-menu-item is-active">...</li> )
  if( in_array( 'current-menu-item', $classes ) && !is_front_page()){
    $classes[] = 'is-active';
  // if submenu
  } else if( in_array( 'current-menu-parent', $classes ) && !is_front_page()){  
    $classes[] = 'is-active';
  // if single post, highlight 'Actualités'
  } else if( in_array( 'current_page_parent', $classes ) && is_singular( 'post' )){
    $classes[] = 'is-active';
  } else if( is_singular( 'project' )){
    // *** highlight 'Project' item on single custom post types
    // Get the slug of the current post type
    $cpt = get_post_type_object( get_post_type( $post->ID ) );    // object 'project'
    $cpt_slug = ($cpt->rewrite) ? $cpt->rewrite['slug'] : '';     // 'references'
  
    // Get the URL of the menu item ('www.site.com/realisations/')
    $item_slug = strtolower( trim( $item->url ) );
  
    // If the menu item URL contains the CPT slug
    if ( $cpt_slug !== '' && strpos( $item_slug, $cpt_slug ) !== false ) {
      $classes[] = 'is-active';
    }
  }



  return $classes;
}


?>
