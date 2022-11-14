<?php

// ==============================================

//        CUSTOM LOGIN PAGE

// ==============================================


//  Custom login page
// -----------------------------------------------

// Override styles on login page
add_action( 'login_enqueue_scripts', 'pga_enqueue_login_stylesheet' );
function pga_enqueue_login_stylesheet() {
  wp_enqueue_style( 'custom-login', CSS_URL.'custom-login.min.css', '', filemtime( CSS_PATH.'custom-login.min.css' ));
}


// Replace WP logo link with site url on login page
add_filter( 'login_headerurl', 'pga_replace_login_logo_url' );
function pga_replace_login_logo_url() {
  return home_url();
}


// Replace WP logo link text with site title on login page
add_filter( 'login_headertext', 'pga_replace_login_logo_url_title' );
function pga_replace_login_logo_url_title() {
  return get_option( 'blogname' );
}
