<?php
/**
 * General Functions to use the plugin
 *
 * @package   Ajskelton\WpPhotodex\Photodex\Util
 * @since     1.0.0
 * @author    ajskelton
 * @link      anthonyskelton.com
 * @license   GNU General Public License 2.0+
 */

namespace Ajskelton\WpPhotodex\Photodex\Util;

/**
 * Return a WP Query of all of the photodex posts, sorted by their
 * pokedex number
 *
 * @since 1.0.0
 *
 * @return \WP_Query
 */
function query_photodex_posts() {
	$config_args = array(
		'post_type'      => 'wp-photodex',
		'posts_per_page' => - 1,
		'meta_key'       => 'pokedex_number',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC'
	);

	return new \WP_Query( $config_args );
}

/**
 * Return a WP Query of a single random pokemon from the pokedex post type
 *
 * @since 1.0.0
 *
 * @return \WP_Query
 */
function query_single_random_photodex() {
	$config_args = array(
		'post_type' => 'wp-photodex',
		'posts_per_page' => 1,
		'orderby' => 'rand'
	);

	return new \WP_Query( $config_args );
}

/**
 * Take the full list of pokemon and remove all that already have posts
 * associated with them. This feeds the select field so only a single post
 * be associated with a pokemon.
 *
 * @param $pokedex
 * @param $pokedex_number
 * @param $photodex_posts
 *
 * @return mixed
 */
function remove_existing_photodex_posts($pokedex, $pokedex_number, $photodex_posts) {
	$array = [];
	foreach($photodex_posts->posts as $pokemon){
		array_push( $array, get_post_meta( $pokemon->ID, 'pokedex_number', true ) );
	}
	for($i = 0; $i < sizeof($array); $i++){
		if($array[$i] != $pokedex_number) {
			unset($pokedex[$array[$i]]);
		}
	}
	return $pokedex;
}