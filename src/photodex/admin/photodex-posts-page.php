<?php
/**
 * Customize the Photodex CPT Posts Page
 *
 * @package   Ajskelton\WpPhotodex\Photodex\Admin
 * @since     1.0.0
 * @author    ajskelton
 * @link      anthonyskelton.com
 * @license   GNU General Public License 2.0+
 */
namespace Ajskelton\WpPhotodex\Photodex\Admin;

use Ajskelton\WpPhotodex\Photodex as Photodex;
use Ajskelton\WpPhotodex\Photodex\Util as Util;

add_action( 'load-post.php', __NAMESPACE__ . '\post_meta_boxes_setup' );
add_action( 'load-post-new.php', __NAMESPACE__ . '\post_meta_boxes_setup' );
/**
 * Setup the post meta boxes for Photodex Post Type. Add the meta boxes and
 * the saving processing
 *
 * @since 1.0.0
 *
 * @return void
 */
function post_meta_boxes_setup() {
	add_action( 'add_meta_boxes', __NAMESPACE__ . '\add_post_meta_boxes' );
	add_action( 'save_post', __NAMESPACE__ . '\save_photodex_meta', 10, 2 );
}

/**
 * Add post meta boxes on the Photodex Post Type
 *
 * @since 1.0.0
 *
 * @return void
 */
function add_post_meta_boxes() {
	add_meta_box(
		'pokedex_number',
		esc_html__( 'Pokedex Number', PHOTODEX_TEXT_DOMAIN ),
		__NAMESPACE__ . '\photodex_meta_box',
		'wp-photodex',
		'normal',
		'high'
	);
}

/**
 * Write the HTML for the Photodex Meta Box
 *
 * @since 1.0.0
 *
 * @return void
 */
function photodex_meta_box() {
	$pokedex_number   = get_post_meta( get_the_ID(), 'pokedex_number', true );
	$full_pokedex     = Photodex\get_pokedex();
	$photodex_posts   = Util\query_photodex_posts();
	$filtered_pokedex = Util\remove_existing_photodex_posts( $full_pokedex, $pokedex_number, $photodex_posts );
	?>
	<?php wp_nonce_field( basename( __FILE__ ), 'wp-photodex_meta_nonce' ); ?>
    <p>
        <label for="pokedex_number">
			<?php _e( "Choose the pokemon number" ); ?>
            <br/>
            <select name="pokedex_number" id="pokedex_number">
				<?php foreach ( $filtered_pokedex as $key => $value ) : ?>
                    <option value="<?php echo $key; ?>" <?php if ( $value["number"] == $pokedex_number ) {
						echo 'selected="selected"';
					} ?>><?php echo $key . ' ' . $value["name"] ?></option>
				<?php endforeach; ?>
            </select>
        </label>
    </p>
	<?php
}

add_action( 'save_post', __NAMESPACE__ . '\save_photodex_meta', 10, 2 );
/**
 * Save/Update/Delete Post Meta for Photodex Post Type
 *
 * @since 1.0.0
 *
 * @param int $post_id
 * @param object $post
 *
 * @return mixed
 */
function save_photodex_meta( $post_id, $post ) {

	// Verify the nonce before processing
	if ( ! isset( $_POST['wp-photodex_meta_nonce'] ) || ! wp_verify_nonce( $_POST['wp-photodex_meta_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}

	// Get the post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if the current user has permission to edit the post.
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Get the posted data and sanitize it for use as an HTML class
	$new_meta_value = ( isset( $_POST['pokedex_number'] ) ? sanitize_html_class( $_POST['pokedex_number'] ) : '' );

	// Get the meta key
	$meta_key = 'pokedex_number';

	// Get the meta value of the custom field key
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	// If a new meta value was added and there was no previous value, add it.
	if ( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	} // If the new meta value does not match the old value, update it.
	elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	} // if there is no new meta value but an old value exists, delete it
	elseif ( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}
}


add_filter( 'manage_edit-wp-photodex_columns', __NAMESPACE__ . '\edit_photodex_columns' );
/**
 * Edit the admin column headers on the Photodex Post Class
 *
 * @since 1.0.0
 *
 * @return array
 */
function edit_photodex_columns() {

	$columns = array(
		'cb'             => '<input type="checkbox" />',
		'title'          => __( 'Title' ),
		'pokedex_number' => __( 'Pokedex Number' ),
		'post_id'        => __( 'Post ID' ),
		'thumbnail'      => __( 'Photo' )
	);

	return $columns;
}


add_action( 'manage_wp-photodex_posts_custom_column', __NAMESPACE__ . '\manage_photodex_columns', 10, 2 );
/**
 * Manage the admin columns on the Photodex Post Class
 *
 * @since 1.0.0
 *
 * @param array $column
 * @param int $post_id
 *
 * @return void
 */
function manage_photodex_columns( $column, $post_id ) {

	switch ( $column ) {
		case 'pokedex_number' :
			$pokedex_number = get_post_meta( $post_id, 'pokedex_number', true );

			if ( empty( $pokedex_number ) ) {
				echo __( 'Unknown' );
			} else {
				echo $pokedex_number;
			}

			break;

        case 'post_id' :
            echo $post_id;

            break;

		case 'thumbnail':
			echo the_post_thumbnail( 'thumbnail' );

			break;
	}
}

add_filter( 'manage_edit-wp-photodex_sortable_columns', __NAMESPACE__ . '\sort_columns_by_pokedex_number' );
/**
 * Tell WordPress to allow the pokedex number column to be sortable.
 *
 * @since 1.0.0
 *
 * @param array $columns
 *
 * @return mixed
 */
function sort_columns_by_pokedex_number( array $columns ) {
	$columns['pokedex_number'] = 'pokedex_number';

	return $columns;
}


add_action( 'pre_get_posts', __NAMESPACE__ . '\order_by_pokedex_number' );
/**
 * Set the pokedex_number meta key as the sortable value went sorting by the pokedex_number column
 *
 * @since 1.0.0
 *
 * @param $query
 *
 * @return void
 */
function order_by_pokedex_number( $query ) {
	if ( ! is_admin() ) {
		return;
	}

	$orderby = $query->get( 'orderby' );
	if ( 'pokedex_number' == $orderby ) {
		$query->set( 'meta_key', 'pokedex_number' );
		$query->set( 'orderby', 'meta_value_num' );
	}
}


add_action( 'do_meta_boxes', __NAMESPACE__ . '\move_featured_meta_box' );
/**
 * Move the featured image meta box from the side to the normal at the top
 *
 * @since 1.0.0
 *
 * @return void
 */
function move_featured_meta_box() {
	remove_meta_box( 'postimagediv', 'wp-photodex', 'side' );
	add_meta_box( 'postimagediv', __( 'Featured Image' ), 'post_thumbnail_meta_box', 'wp-photodex', 'normal', 'high' );
}


add_action( 'do_meta_boxes', __NAMESPACE__ . '\move_genesis_boxes_lower' );
/**
 * Remove the Genesis Powered SEO and Layout Boxes if Genesis is running
 *
 * @since 1.0.0
 *
 * @return void
 */
function move_genesis_boxes_lower() {
	if ( function_exists( 'genesis' ) ) {
		remove_meta_box( 'genesis_inpost_seo_box', 'wp-photodex', 'normal' );
		remove_meta_box( 'genesis_inpost_layout_box', 'wp-photodex', 'normal' );
	}
}