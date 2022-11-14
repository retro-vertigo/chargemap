<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


include("MySite.php");

new StarterSite();



//  Static varibales / global variables
// -----------------------------------------------

$whitelist = array(
  // IPv4 address
  '127.0.0.1',
  // IPv6 address
  '::1'
);
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist ) ) {
  define( 'ENV', 'dev' );
} else {
  define( 'ENV', 'prod' );
}


//  Paths config
// -----------------------------------------------

define( 'CSS_URL', get_template_directory_uri() . '/assets/css/');
// define( 'CSS_URL', get_theme_file_uri( 'assets/css/' ));
define( 'JS_URL', get_theme_file_uri( 'assets/js/' ));
define( 'IMAGE_URL', get_theme_file_uri( 'assets/images/' ));
define( 'SVG_URL', get_theme_file_uri( 'assets/svg/' ));
define( 'FAVICON_URL', get_theme_file_uri( 'assets/favicons/' ));     // TOADD

define( 'CSS_PATH', get_theme_file_path( 'assets/css/' ));
define( 'JS_PATH', get_theme_file_path( 'assets/js/' ));
define( 'IMAGE_PATH', get_theme_file_path( 'assets/images/' ));
define( 'SVG_PATH', get_theme_file_path( 'assets/svg/' ));

define( 'TEMPLATES_BLOCKS_PATH', '/template-parts/blocks/' );



//  Require
// -----------------------------------------------

require get_theme_file_path( '/inc/Tools.php' );
require get_theme_file_path( '/inc/common/admin-login.php' );
require get_theme_file_path( '/inc/common/clean.php' );
require get_theme_file_path( '/inc/common/dev.php' );
require get_theme_file_path( '/inc/common/upload-mimes.php' );

require get_theme_file_path( '/inc/plugins/acf.php' );
require get_theme_file_path( '/inc/plugins/acf-blocks.php' );
// require get_theme_file_path( '/inc/plugins/gravity-forms.php' );
require get_theme_file_path( '/inc/plugins/polylang.php' );
// require get_theme_file_path( '/inc/plugins/yoast.php' );
// require get_theme_file_path( '/inc/plugins/misc-plugins.php' ); 

// require get_theme_file_path( '/inc/utils/Debug.php' );   
// require get_theme_file_path( '/inc/utils/misc.php' );

require get_theme_file_path( '/inc/admin/admin-styles.php' );
require get_theme_file_path( '/inc/admin/admin-columns.php' );
require get_theme_file_path( '/inc/admin/admin.php' );
require get_theme_file_path( '/inc/admin/menus.php' );
// require get_theme_file_path( '/inc/admin/cpt.php' );
require get_theme_file_path( '/inc/admin/gutenberg.php' );
//
require get_theme_file_path( '/inc/responsive-images.php' );
require get_theme_file_path( '/inc/enqueue.php' );







// Get Timber context from macros.twig file
function get_timber_context() {
	return Timber::context();
}

