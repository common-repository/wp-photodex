<?php
/**
 * Photodex Module Handler
 *
 * @package   Ajskelton\WpPhotodex\Photodex
 * @since     1.0.0
 * @author    ajskelton
 * @link      anthonyskelton.com
 * @license   GNU General Public License 2.0+
 */
namespace Ajskelton\WpPhotodex\Photodex;

define( 'PHOTODEX_MODULE_TEXT_DOMAIN', PHOTODEX_TEXT_DOMAIN );
define( 'PHOTODEX_MODULE_DIR', __DIR__ );
define( 'PHOTODEX_VERSION', '1.0.0' );

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\add_my_stylesheet' );
/**
 * Enqueue Styles for front end of the photodex
 *
 * @since 1.0.0
 */
function add_my_stylesheet() {
	wp_enqueue_style( 'wp-photodex', PHOTODEX_URL . '/src/photodex/assets/dist/css/style.css', false, PHOTODEX_VERSION, false  );
}

add_action( 'init', __NAMESPACE__ . '\add_photodex_thumbnail_size' );
function add_photodex_thumbnail_size() {
	add_image_size( 'photodex_thumbnail', '150', '150', true );
}

/**
 * Autoload plugin files
 *
 * @since 1.0.0
 *
 * @return void
 */
function autoload() {
	$files = array(
		'admin/photodex-posts-page.php',
		'custom/post-type.php',
		'shortcode/shortcode.php',
		'util/utility-functions.php',
		'template/helpers.php',
		'pokedex.php'
	);

	foreach ( $files as $file ) {
		include( __DIR__ . '/' . $file );
	}
}

autoload();

register_activation_hook( PHOTODEX_PLUGIN, __NAMESPACE__ . '\activate_the_plugin' );
/**
 * Initialize the rewrites for our new custom post type
 * upon activation
 *
 * @since 1.0.0
 *
 * @return void
 */
function activate_the_plugin() {
	Custom\register_photodex_custom_post_type();

	flush_rewrite_rules();
}

register_deactivation_hook( PHOTODEX_PLUGIN, __NAMESPACE__ . '\deactivate_plugin' );
/**
 * The plugin is deactivating. Delete out the rewrite rules option.
 *
 * @since 1.0.0
 *
 * @return void
 */
function deactivate_plugin() {
	delete_option( 'rewrite_rules' );
}

register_uninstall_hook( PHOTODEX_PLUGIN, __NAMESPACE__ . '\uninstall_plugin' );
/**
 * Plugin is being uninstalled. Clean up after ourselves
 *
 * @since 1.0.0
 *
 * @return void
 */
function uninstall_plugin() {
	delete_option( 'rewrite_rules' );
}
