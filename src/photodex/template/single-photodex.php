<?php
/**
 * Photodex Single Template
 *
 * @package   Ajskelton\WpPhotodex\Photodex\Template
 * @since     1.0.0
 * @author    ajskelton
 * @link      anthonyskelton.com
 * @license   GNU General Public License 2.0+
 */

namespace Ajskelton\WpPhotodex\Photodex\Template;

// Basic template if theme is running Genesis
if ( function_exists( 'genesis' ) ) {

	// Remove the Post Date and Author Information
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

	// Add the featured Image
	add_action( 'genesis_entry_content', __NAMESPACE__ . '\do_post_image' );

	genesis();
}

// Basic template for themes not using Genesis
get_header(); ?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post(); ?>

                    <header class="entry-header">
						<?php
						the_title( '<h1 class="entry-title">', '</h1>' );
						?>
                    </header><!-- .entry-header -->
                    <div class="entry-content">
						<?php
						do_post_image();
						?>
                    </div><!-- .entry-content -->
					<?php

					the_post_navigation( array(
						'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title</span>',
					) );

				endwhile; // End of the loop.

				?>

            </main><!-- #main -->
        </div><!-- #primary -->
		<?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
