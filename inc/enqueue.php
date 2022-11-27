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

  // pass Polylang translations to Newsletter form JS
  $newsletter_messages = array(
    'invalid_email' => pl__( 'Newsletter - email invalide' ),
    'sending'       => pl__( 'Newsletter - message d\'envoi' ),
    'success'       => pl__( 'Newsletter - message de confirmation' ),
    'error'         => pl__( 'Newsletter - message d\'erreur' ),
    'current_lang'  => pl_current_language(),
  );
  wp_localize_script( 'main-scripts', 'newsletter_messages', $newsletter_messages );
}
