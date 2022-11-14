<?php

// ==============================================

//        ENQUEUE SCRIPTS AND STYLES

// ==============================================



//  Include scripts and CSS
// -----------------------------------------------

add_action( 'wp_enqueue_scripts', 'pga_enqueue_scripts' );
function pga_enqueue_scripts() {

  // scripts
  wp_deregister_script( 'jquery' );
  wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', '', null, true );

  // lastly custom styles and JS
  wp_enqueue_style( 'main-style', CSS_URL.'main.min.css', '', filemtime( CSS_PATH.'main.min.css' ));
  wp_enqueue_script( 'main-scripts', JS_URL.'main.min.js',  array('jquery'), filemtime ( JS_PATH.'main.min.js' ), true );

  wp_localize_script( 'main-scripts', 'loadmore_params', array( 
    'ajaxurl'  => admin_url( 'admin-ajax.php' ),
    // 'security' => wp_create_nonce( 'load_more_posts' ),
  ));
}
