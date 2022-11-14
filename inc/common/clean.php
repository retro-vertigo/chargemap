<?php

// ==============================================

//       CLEAN

// ==============================================


//  Head function
// -----------------------------------------------

// Remove WP version query when urls in head ( url?ver=4.9.9 )
add_filter( 'script_loader_src', 'pga_remove_version_query' );
add_filter( 'style_loader_src', 'pga_remove_version_query' );
function pga_remove_version_query( $src ) {
  if( strpos( $src, 'ver='.get_bloginfo( 'version' ) ) )
    $src = remove_query_arg( 'ver', $src );
  return $src;
}


// Clean head tags
add_action( 'init', 'pga_cleanup_head' );
function pga_cleanup_head() {
  remove_action( 'wp_head', 'wp_generator' );                     // WP version ( <meta name="generator" )
  remove_action( 'wp_head', 'rsd_link' );                         // EditURI link ( <link rel="EditURI" )
  remove_action( 'wp_head', 'wlwmanifest_link' );                 // Windows Live Writer ( <link rel="wlwmanifest" )
  remove_action( 'wp_head', 'feed_links', 2 );                    // Post and comment RSS feed links
  remove_action( 'wp_head', 'feed_links_extra', 3 );              // Category feed links
  remove_action( 'wp_head', 'index_rel_link' );                   // Index link ( <link rel="index" )
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );      // Previous link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );       // Start link
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );    // Links for adjacent posts ( <link rel="prev" )
  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );       // Shortlink ( <link rel="shortlink" )
  // remove_action( 'wp_head', 'rel_canonical', 10, 0 );              // Canonical ( <link rel="canonical" )

  // REMOVE WP EMBED
  add_filter( 'embed_oembed_discover', '__return_false' );            // Turn off oEmbed auto discovery
  remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10);  // Don't filter oEmbed results.
  // remove_action( 'rest_api_init', 'wp_oembed_register_route');        // REST API endpoint ( !!! can't embed youtube vids if set !!! )
  remove_action( 'wp_head', 'wp_oembed_add_host_js');                 // oEmbed-specific JS from the front and back-end ( <script src="wp-embed.min.js" )
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links');         // oEmbed discovery links ( <link rel="alternate" )
  remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );         // ( <link rel="https://api.w.org/" )
  remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );  // REST API links in HTTP headers ( Link: <http://example.com/path/wp-json/>; rel="https://api.w.org/" )

  // REMOVE EMOJIS
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );     // Emoji detection script ( <script src="wp-emoji-release.min.js" )
  remove_action( 'wp_print_styles', 'print_emoji_styles' );          // Emoji styles in front ( <style...> )
  remove_action( 'admin_print_styles', 'print_emoji_styles' );       // Emoji styles in admin ( <style...> )
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
}

