<?php

// ==============================================

//        OTHERS PLUGINS

// ==============================================


//  Plugin Radio buttons for taxonomies
// -----------------------------------------------

// Disable "no term" radio button on 'XXXmy-cptXXX' choices
add_filter( "radio_buttons_for_taxonomies_no_term_domain", "__return_FALSE" );
add_filter( "radio_buttons_for_taxonomies_no_term_location", "__return_FALSE" );
add_filter( "radio_buttons_for_taxonomies_no_term_contract", "__return_FALSE" );
