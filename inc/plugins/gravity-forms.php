<?php

// ==============================================

//        GRAVITY FORMS

// ==============================================


add_filter( 'gform_confirmation_anchor', '__return_true' );


// Customize sending form spinner
// add_filter( 'gform_ajax_spinner_url', 'custom_gf_spinner_url', 10, 2 );
function custom_gf_spinner_url( $image_src, $form ) {
  return get_stylesheet_directory_uri() . '/assets/svg/spinner.svg';
}



// Convert input submit button in button and add custom class
add_filter( 'gform_submit_button', 'gf_make_submit_input_into_a_button_element', 10, 2 );
function gf_make_submit_input_into_a_button_element( $button_input, $form ) {

  //save attribute string to $button_match[1]
  preg_match("/<input([^\/>]*)(\s\/)*>/", $button_input, $button_match);

  // remove value attribute
  $button_atts = str_replace( "value='".$form['button']['text']."' ", "", $button_match[1] );
  $button_atts = str_replace( "class='", "class='btn-circle ", $button_atts );

  // wrap button label in span
  return '<button '.$button_atts.'><span class="btn-circle__label h4">'.$form['button']['text'].'</span></button>';
}

// TODO
// Set a basic input mask for FR phone numbers (digits only)
add_filter( 'gform_input_masks', 'add_phone_format_mask' );
function add_phone_format_mask( $masks ) {
    $masks['Téléphone FR'] = '9999?99999999999999';
    return $masks;
}


// Remove underscores from input mask (and replace by blank space)
add_filter( 'gform_input_mask_script', 'set_mask_script', 10, 4 );
function set_mask_script( $script, $form_id, $field_id, $mask ) {
    $script = "jQuery('#input_{$form_id}_{$field_id}').mask('" . esc_js( $mask ) . "',{placeholder:' '}).on('keypress', function(e){if(e.which == 13){jQuery(this).blur();} } );";
 
    return $script;
}