<?php

// ==============================================

//        ACF FUNCTIONS

// ==============================================


//  Add ACF options pages
if( function_exists( 'acf_add_options_page' ) ) {

  acf_add_options_page( array(
    'page_title' => 'Général',
    'menu_title' => 'Options du site',
    'menu_slug'  => 'theme-general-settings',
    'capability' => 'edit_posts',
    'icon_url'   => 'dashicons-admin-generic',
    'redirect'   => false
  ));

  acf_add_options_sub_page(array(
    'page_title' 	=> 'Configuration des pages',
    'menu_title'	=> 'Configuration des pages',
    'parent_slug'	=> 'theme-general-settings',
  ));
}


add_filter( 'acf/fields/wysiwyg/toolbars', 'pga_custom_acf_toolbars' );
function pga_custom_acf_toolbars( $toolbars ) {
	// Uncomment to view format of $toolbars
	
	// echo '< pre >';
	// 	print_r($toolbars);
	// echo '< /pre >';
	// die;

	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Simple' ] = array();
	$toolbars['Simple' ][1] = array( 'formatselect', 'bold', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'link', 'pastetext', 'removeformat' );

	$toolbars['Gras uniquement' ] = array();
	$toolbars['Gras uniquement' ][1] = array( 'bold' );

	// Edit the "Full" toolbar and remove 'code'
	// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
	if( ($key = array_search( 'code' , $toolbars['Full' ][2] )) !== false )	{
	    unset( $toolbars['Full' ][2][$key] );
	}

	// remove the 'Basic' toolbar completely
	// unset( $toolbars['Basic' ] );

	// return $toolbars - IMPORTANT!
	return $toolbars;
}


// Populate ACF select field with Gravity Forms ids
add_filter( 'acf/load_field/name=gf_form_id', 'pga_load_form_list_field_choices' );
add_filter( 'acf/load_field/name=gf_single_job_form_id', 'pga_load_form_list_field_choices' );
function pga_load_form_list_field_choices( $field ) {

  if ( class_exists( 'GFFormsModel' ) ) {
		$choices = [];

		foreach ( \GFFormsModel::get_forms() as $form ) {
			$choices[ $form->id ] = $form->title;
		}

		$field['choices'] = $choices;
	}

	return $field;
}
