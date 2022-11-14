<?php

// ==============================================

//        MISC HOOKS

// ==============================================

//  Navigation
// -----------------------------------------------

// Format string at the end of the excerpt
// add_filter( 'excerpt_more', 'custom_excerpt_more' );
function custom_excerpt_more( $more ) {
  return sprintf( '...' );
  // return sprintf( '...<br><a class="link-read-more" href="%1$s">%2$s</a>', get_the_permalink(), 'Lire la suite' );
}


// TOUPDATE
// Set excerpt length before truncature (apply only to auto-generated excerpts)
// add_filter( 'excerpt_length', 'pga_custom_excerpt_length', 999 );
function pga_custom_excerpt_length( $length ) {
  // if ( is_front_page() ) {
  //   return 20;
  // }
  return 10;
}



?>
