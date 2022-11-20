<?php
$rooten_download_grid_options = rooten_edd_download_grid_options();
?>

<div class="<?php echo esc_attr( apply_filters( 'rooten_edd_download_class', 'edd_download', get_the_ID(), '', '' ) ); ?>" id="edd_download_<?php the_ID(); ?>">

	<div class="tm-edd-download-inner">

		<?php

		do_action( 'rooten_edd_download_before' );

		if ( true === $rooten_download_grid_options['thumbnails'] ) {
			edd_get_template_part( 'shortcode', 'content-image' );
			do_action( 'rooten_edd_download_after_thumbnail' );
		}

		?>
		<div class="tm-edd-item-bottom-part">
			<?php

				do_action( 'rooten_edd_download_before_title' );

				if ( true === $rooten_download_grid_options['title'] ) {
					edd_get_template_part( 'shortcode', 'content-title' );
				}

				do_action( 'rooten_edd_download_after_title' );

				if ( true === $rooten_download_grid_options['excerpt'] && true !== $rooten_download_grid_options['full_content'] ) {
					edd_get_template_part( 'shortcode', 'content-excerpt' );
					do_action( 'rooten_edd_download_after_content' );
				} elseif ( true === $rooten_download_grid_options['full_content'] ) {
					edd_get_template_part( 'shortcode', 'content-full' );
					do_action( 'rooten_edd_download_after_content' );
				}

				rooten_edd_download_footer();

				do_action( 'rooten_edd_download_after' );

			?>

		</div>

	</div>
</div>
