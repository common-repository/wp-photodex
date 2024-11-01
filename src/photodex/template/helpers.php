<?php
/**
 * Template Helpers
 *
 * @package   Ajskelton\WpPhotodex\Photodex\Template;
 * @since     1.0.0
 * @author    ajskelton
 * @link      anthonyskelton.com
 * @license   GNU General Public License 2.0+
 */
namespace Ajskelton\WpPhotodex\Photodex\Template;

add_filter( 'single_template', __NAMESPACE__ . '\load_the_photodex_single_template' );
/**
 * Load the Photodex single template from the plugin.
 *
 * @since 1.0.0
 *
 * @param string $theme_single_template Full qualified path to the archive template
 *
 * @return string
 */
function load_the_photodex_single_template( $theme_single_template ) {

	if ( 'photodex' != get_post_type() ) {
		return $theme_single_template;
	}

	$plugin_archive_template = __DIR__ . '/single-photodex.php';

	if ( ! $theme_single_template ) {
		return $plugin_archive_template;
	}

	if ( strpos( $theme_single_template, '/single-photodex.php' ) === false ) {
		return $plugin_archive_template;
	}

	return $theme_single_template;
}

/**
 * Render the full size post thumbnail
 *
 * @since 1.0.0
 *
 * @return void
 */
function do_post_image() {
	echo get_the_post_thumbnail( get_the_ID(), 'full' );
}