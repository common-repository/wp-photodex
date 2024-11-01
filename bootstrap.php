<?php
/**
 * WP Pokemon Photodex
 *
 * @package   Ajskelton\WpPhotodex
 * @since     1.0.0
 * @author    ajskelton
 * @link      anthonyskelton.com
 * @license   GNU General Public License 2.0+
 *
 * @wordpress-plugin
 * Plugin Name: WP Photodex
 * Plugin URI: https://anthonyskelton.com/wp-photodex
 * Description: A WordPress Plugin to share your pokemon photo collection
 * Version: 1.0.3
 * Author: ajskelton
 * Author URI: https://anthonyskelton.com
 * Text Domain: wp-photodex
 * Requires WP: 4.7
 * Requires PHP: 5.5
 *
 */
namespace Ajskelton\WpPhotodex;

if ( ! defined( 'ABSPATH' ) ) {
	exit( "Oh, silly, there's nothing to see here." );
}

define( 'PHOTODEX_PLUGIN', __FILE__ );
define( 'PHOTODEX_DIR', plugin_dir_path( __FILE__ ) );
$plugin_url = plugin_dir_url( __FILE__ );
if( is_ssl() ) {
	$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
}
define( 'PHOTODEX_URL', $plugin_url );
define( 'PHOTODEX_TEXT_DOMAIN', 'wp-photodex' );

include( __DIR__ . '/src/plugin.php' );
