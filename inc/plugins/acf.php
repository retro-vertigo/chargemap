<?php

// ==============================================

//        ACF FUNCTIONS

// ==============================================


//  Add ACF options pages
add_action( 'acf/init', 'pga_add_acf_options' );
function pga_add_acf_options() {
	if( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => 'Options du site',
			'menu_title' => 'Options du site',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'icon_url'   => 'dashicons-admin-generic',
			'redirect'   => false
		));
	}
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
	$toolbars['Simple' ][1] = array( 'formatselect', 'styleselect', 'bold', 'underline', '|', 'alignleft', 'aligncenter', 'alignright', '|','bullist','numlist', '|', 'link', 'unlink', '|',
	'undo', 'redo', 'removeformat', 'code', );


	$toolbars['Gras uniquement' ] = array();
	$toolbars['Gras uniquement' ][1] = array( 'bold' );

	$toolbars['Liste à puces' ] = array();
	$toolbars['Liste à puces' ][1] = array( 'bullist' );


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




/////////////////////////



/* Customize Editor TinyMCE
 -------------------------------------------------------------- */

/* Customize Editor TinyMCE
-------------------------------------------------------------- */
add_filter( 'tiny_mce_before_init', 'base_custom_mce_format' );
function base_custom_mce_format( $init_array ) {

		// Add block format elements you want to show in dropdown
		$block_formats = array(
			'Paragraph=p',
			'Titre 1=h1',
			'Titre 2=h2',
			'Titre 3=h3',
			'Paragraphe=p',
			'Surtitre / Sous-titre=h5',
		);
		$init_array['block_formats'] = implode( ';', $block_formats );

		$init_array['paste_text_use_dialog'] = false;
		$init_array['paste_text_sticky'] = true;
		$init_array['paste_text_sticky_default'] = true;  

		$style_formats = array(
				array(
					'title' => 'Bouton primaire',
					'inline' => 'a',
					'selector' => 'a',
					'classes' => 'btn',
				),
				array(
					'title' => 'Bouton secondaire',
					'inline' => 'a',
					'selector' => 'a',
					'classes' => 'btn --navy'
				),
				array(
						'title' => 'Surtitre',
						'block' => 'span',
						'selector' => 'p',
						'classes' => 'suptitle'
				),
				array(
					'title' => 'Titre 1 en bleu',
					'inline' => 'span',
					'classes' => 'alt-color',
				),
				
				array(
						'title' => 'Principale',
						'inline' => 'span',
						'styles' => (object)["color" => "#48C085"]
				),
				
		);

		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $style_formats );

		return $init_array;
} 


// TinyMCE: Second line toolbar customizations
add_filter( 'mce_buttons_2', 'base_extended_editor_mce_buttons_2', 0);
function base_extended_editor_mce_buttons_2( $buttons ) {
		return array();
} 


