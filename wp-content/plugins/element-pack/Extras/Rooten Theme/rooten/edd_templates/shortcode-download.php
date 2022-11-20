<?php
/**
 * A single download inside of the [downloads] shortcode.
 *
 * @since 2.9.0
 *
 * @package EDD
 * @category Template
 * @author Easy Digital Downloads
 * @version 1.0.0
 */

global $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i;

$rooten_download_grid_options = rooten_edd_download_grid_options( $edd_download_shortcode_item_atts );
?>

<div class="<?php echo esc_attr( apply_filters( 'rooten_edd_download_class', 'edd_download', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>" id="edd_download_<?php the_ID(); ?>">

	<div class="<?php echo esc_attr( apply_filters( 'rooten_edd_download_inner_class', 'edd_download_inner', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>">

		<?php
			do_action( 'rooten_edd_download_before' );

			if ( true === $rooten_download_grid_options['thumbnails'] ) {
				edd_get_template_part( 'shortcode', 'content-image' );
				do_action( 'rooten_edd_download_after_thumbnail' );
			}

			/**
			 * Used by rooten_edd_download_meta_before_title()
			 */
			do_action( 'rooten_edd_download_before_title' );

			if ( true === $rooten_download_grid_options['title'] ) {
				edd_get_template_part( 'shortcode', 'content-title' );
			}

			do_action( 'rooten_edd_download_after_title' );
			
			if ( true === $rooten_download_grid_options['excerpt'] && true !== $rooten_download_grid_options['full_content'] ) {
				// Show the excerpt.
				edd_get_template_part( 'shortcode', 'content-excerpt' );

				do_action( 'rooten_edd_download_after_content' );
			} elseif ( true === $rooten_download_grid_options['full_content'] ) {
				// Show the full content.
				edd_get_template_part( 'shortcode', 'content-full' );
				
				do_action( 'rooten_edd_download_after_content' );
			}

			/**
			 * Download footer
			 */
			rooten_edd_download_footer( $edd_download_shortcode_item_atts );

			do_action( 'rooten_edd_download_after' );

		?>
	</div>

</div>
