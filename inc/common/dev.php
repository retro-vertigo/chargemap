<?php


// add_action( 'wp_footer', 'pga_which_template_is_loaded' );
function pga_which_template_is_loaded() {
	if ( current_user_can( 'manage_options' ) ) {
		global $template;
		$output = '<div class="mb-6"><strong>Template</strong>: '.substr( $template, strpos( $template, 'themes' ) ) .'</div>';
		// $output .= '<br><strong>> CSS</strong>: '.get_theme_file_uri( 'assets/css/' );
		// $output .= '<br><strong>> js</strong>: '.get_theme_file_uri( 'assets/js/' );
		echo $output;
	}
}

// add_action( 'wp_footer', 'pga_list_conditional_tags' );
function pga_list_conditional_tags() {
	if ( current_user_can( 'manage_options' ) ) {
    $yes = '<span style="color: #a3d678;"><strong>true</strong></span>';
    $no = '<span style="color: #888888;">false</span>';
		$output = '<div class="l-container --medium mb-6">' . '<h4>Conditionnal tags</h4>';
		$output .= 'is_home() : ' . (( is_home() ) ? $yes : $no ); 
		$output .= '<br>is_front_page() : ' . (( is_front_page() ) ? $yes : $no ); 
    
		$output .= '<br>is_singular() : ' . (( is_singular() ) ? $yes : $no ); 
		$output .= '<br>is_single() : ' . (( is_single() ) ? $yes : $no ); 
		$output .= '<br>is_page() : ' . (( is_page() ) ? $yes : $no ); 
		$output .= '<br>is_page_template() : ' . (( is_page_template() ) ? $yes : $no ); 
		$output .= '<br>is_tag() : ' . (( is_tag() ) ? $yes : $no ); 
		$output .= '<br>is_tax() : ' . (( is_tax() ) ? $yes : $no ); 
		$output .= '<br>has_term() : ' . (( has_term() ) ? $yes : $no ); 
		$output .= '<br>is_archive() : ' . (( is_archive() ) ? $yes : $no ); 
		$output .= '<br>is_paged() : ' . (( is_paged() ) ? $yes : $no ); 
		$output .= '</div>';
		echo $output;
	}
}


// Debug
// add_action( 'in_admin_footer', 'pga_debug_path' );
function pga_debug_path() {
  Debug::dump(__FILE__, '__FILE__');
  Debug::dump(__DIR__, '__DIR__');

  $template_dir = get_template_directory();
  Debug::dump($template_dir, 'get_template_directory');

  $template_directory_uri = get_template_directory_uri();
  Debug::dump($template_directory_uri, 'get_template_directory_uri');
  
  $theme_file_uri = get_theme_file_uri( 'assets/css/' );
  Debug::dump($theme_file_uri, 'get_theme_file_uri');
}


// echo current url with query string
function get_current_page_url() {
  global $wp;
  return add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
}