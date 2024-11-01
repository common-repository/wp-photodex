<?php
/**
 * Add a shortcode that returns a single photo based on post id or the entire photodex
 *
 * @package   Ajskelton\WpPhotodex\Photodex\Shortcode
 * @since     1.0.0
 * @author    ajskelton
 * @link      anthonyskelton.com
 * @license   GNU General Public License 2.0+
 */
namespace Ajskelton\WpPhotodex\Photodex\Shortcode;

use Ajskelton\WpPhotodex\Photodex\Util as Util;

add_shortcode( 'photodex', __NAMESPACE__ . '\process_the_shortcode' );
/**
 * Process the Shortcode to output a single or full photodex.
 *
 * @since 1.0.0
 *
 * @param array|string $user_defined_attributes User defined attributes for this shortcode instance
 * @param string|null $content Content between the opening and closing shortcode elements
 * @param string $shortcode_name Name of the shortcode
 *
 * @return string
 */
function process_the_shortcode( $user_defined_attributes, $content, $shortcode_name ) {
	$config = get_shortcode_configuration();

	$attributes = shortcode_atts(
		$config['defaults'],
		$user_defined_attributes,
		$shortcode_name
	);

	// Typecast the random attributes into a boolean
	$attributes['random'] = 'true' === $attributes['random'];

	// Typecast the post_id into an integer
	$attributes['post_id'] = (int) $attributes['post_id'];

	// Call the view file, capture it into the output buffer, and then return it.
	ob_start();

	if( $attributes['random'] == true ) {
		render_single_photodex( $attributes, $config );
	} elseif ( $attributes['post_id'] > 0 ) {
		render_single_photodex( $attributes, $config );
	} else {
		render_photodex( $attributes, $config );
	}

	return ob_get_clean();
}


/**
 * Get the configuration for the shortcode
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_shortcode_configuration() {
	return array(
		'views'    => array(
			'container' => PHOTODEX_MODULE_DIR . '/views/container.php',
			'pokemon'   => PHOTODEX_MODULE_DIR . '/views/pokemon.php',
			'blank'     => PHOTODEX_MODULE_DIR . '/views/blank.php',
			'single'    => PHOTODEX_MODULE_DIR . '/views/single.php'
		),
		'defaults' => array(
			'post_id'        => 0,
			'thumbnail_size' => 'thumbnail',
			'random'         => false,
		)
	);
}

/**
 * Render a single photo from the photodex.
 *
 * @since 1.0.0
 *
 * @param array $attributes
 * @param array $config
 *
 * @return void
 */
function render_single_photodex( array $attributes, array $config ) {
	if(!$attributes['random']) {
		include( $config['views']['single'] );
	} else {
		$query = Util\query_single_random_photodex();
		$attributes['post_id'] = $query->post->ID;
		include( $config['views']['single'] );
	}
}

/**
 * Run the query and render the photodex
 *
 * @since 1.0.0
 *
 * @param $attributes
 * @param $config
 */
function render_photodex( $attributes, $config ) {

	$query = Util\query_photodex_posts();

	if ( ! $query->have_posts() ) {
		return;
	}

	include( $config['views']['container'] );

	wp_reset_postdata();
}

/**
 * Loop through the query and render out the pokemon
 *
 * @since 1.0.0
 *
 * @param \WP_Query $query
 * @param array $attributes
 * @param array $config
 *
 * @return void
 */
function loop_and_render_pokemon( \WP_Query $query, array $attributes, array $config ) {
	$i = 1;
	while ( $query->have_posts() ) {
		$query->the_post();

		$pokedex_number = (int) get_post_meta( get_the_ID(), 'pokedex_number' )[0];

		$thumbnail_size = $attributes['thumbnail_size'];

		while ( $pokedex_number != $i ) {
			include( $config['views']['blank'] );
			$i ++;
		}

		include( $config['views']['pokemon'] );
		$i ++;
	}
}