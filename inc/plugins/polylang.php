<?php

// ==============================================

//        POLYLANG

// ==============================================


//  Polylang - string translations
// -----------------------------------------------

// Register string translations in theme with Polylang
add_action( 'init', 'pga_register_polylang_strings' );
function pga_register_polylang_strings() {
  if ( function_exists( 'pll_register_string' ) ) {
    pll_register_string( "interface", "Accueil", "theme" );
    pll_register_string( "interface", "Contactez-nous", "theme" );
    pll_register_string( "interface", "url_memberarea", "theme" );
    pll_register_string( "interface", "Se connecter", "theme" );

    
    pll_register_string( "interface", "Espace investisseurs", "theme" );
    pll_register_string( "interface", "Accueil", "theme" );      // for breadcrumbs
    pll_register_string( "interface", "En savoir plus", "theme" );
    pll_register_string( "interface", "Crédits", "theme" );
    pll_register_string( "interface", "Plus d'actualités", "theme" );
    pll_register_string( "interface", "Toute l'équipe", "theme" );
    pll_register_string( "interface", "Retour à l'accueil", "theme" );

    pll_register_string( "form", "Envoyer", "theme" );
    pll_register_string( "form", "Formulaire - email invalide", "theme" );
    pll_register_string( "form", "Formulaire - message d'envoi", "theme" );
    pll_register_string( "form", "Formulaire - message de confirmation", "theme" );
    pll_register_string( "form", "Formulaire - message d'erreur", "theme" );

    pll_register_string( "404", "Page 404", "theme" );

    pll_register_string( "bloc", "Revenir au graphique principal", "theme" );
    pll_register_string( "bloc", "Cliquez pour voir le détail", "theme" );
    
    pll_register_string( "cookie", "J'accepte", "theme" );
    pll_register_string( "cookie", "Je refuse", "theme" );
    pll_register_string( "cookie", "Texte cookie", "theme" );
    pll_register_string( "cookie", "Libellé page de politique de données", "theme" );
  }
};


//  Polylang - functions
// -----------------------------------------------

/**
 * Outputs localized string if polylang exists or  output's not translated one as a fallback
 *
 * @param $string
 *
 * @return  void
 */
function pl_e( $string = '' ) {
  if ( function_exists( 'pll_e' ) ) {
    pll_e( $string );
  } else {
    echo $string;
  }
}

/**
 * Returns translated string if polylang exists or  output's not translated one as a fallback
 *
 * @param $string
 *
 * @return string
 */
function pl__( $string = '' ) {
  if ( function_exists( 'pll__' ) ) {
    return pll__( $string );
  }
  return $string;
}

// Get current language (name / local / slug params)
function pl_current_language( $value = 'slug' ) {
  if ( function_exists( 'pll_current_language' ) ) {
    return pll_current_language( $value );
  }
  return 'no language';
}

// Gets the language of a category or post tag (name / local / slug params)
function pl_get_term_language( $term_id, $field = 'slug' ) {
  if ( function_exists( 'pll_get_term_language' ) ) {
    return pll_get_term_language( $term_id, $field );
  }
  return 'no language';
}

// Gets the language of a post or page (name / local / slug params)
function pl_get_post_language( $post_id, $field = 'slug' ) {
  if ( function_exists( 'pll_get_post_language' ) ) {
    return pll_get_post_language( $post_id, $field );
  }
  return 'no language';
}

// Displays a language switcher (name / local / slug params)
function pl_the_languages( $args ) {
  if ( function_exists( 'pll_the_languages' ) ) {
    return pll_the_languages( $args );
  }
  return 'no language';
}


// Returns the post id (or page) translation
function pl_get_post( $post_id ) {
  if ( function_exists( 'pll_get_post' ) ) {
    return pll_get_post( $post_id );
  }
  return 'no language';
}

