<?php

$rooten_cart_items = edd_get_cart_contents();
$rooten_count      = (int) edd_get_option( 'edd_rp_suggestion_count', 3 );

?>

<?php if ( $rooten_cart_items ) :
	$rooten_post_ids = wp_list_pluck( $rooten_cart_items, 'id' );
	$rooten_user_id = ( is_user_logged_in() ) ? get_current_user_id() : false;
	$rooten_suggestion_data = edd_rp_get_multi_suggestions( $rooten_post_ids, $rooten_user_id );

	if ( is_array( $rooten_suggestion_data ) && !empty( $rooten_suggestion_data ) ) :
	$rooten_suggestions = array_keys( $rooten_suggestion_data );

	$rooten_suggested_downloads = new WP_Query( array( 'post__in' => $rooten_suggestions, 'post_type' => 'download' ) );

	if ( $rooten_suggested_downloads->have_posts() ) :
		
		$rooten_cart_items_text = _n( 'this item', 'these items', count( $rooten_post_ids ), 'rooten' );
		?>
		<div id="edd-rp-checkout-wrapper">
			<h5 id="edd-rp-checkout-header"><?php echo sprintf( __( 'Users who purchased %s, also purchased:', 'rooten' ), $rooten_cart_items_text ); ?></h5>
			<div id="edd-rp-items-wrapper" class="mb-xs-2 edd-rp-checkout edd_downloads_list edd_download_columns_<?php echo $rooten_count; ?>">
				<?php while ( $rooten_suggested_downloads->have_posts() ) : ?>
					<?php $rooten_suggested_downloads->the_post();	?>
					<div class="edd_download edd-rp-item <?php echo ( ! current_theme_supports( 'post-thumbnails' ) ) ? 'edd-rp-nothumb' : ''; ?>">
						<div class="edd_download_inner">

							<?php do_action( 'rooten_edd_rp_item_before' ); ?>

							<?php if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( get_the_ID() ) ) :?>
								<div class="edd_download_image">
									<a href="<?php the_permalink(); ?>">
									<?php echo get_the_post_thumbnail( get_the_ID() ); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php do_action( 'rooten_edd_rp_item_after_thumbnail' ); ?>

							<h3 class="edd_download_title">
								<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							</h3>

							<?php do_action( 'rooten_edd_rp_item_after_title' ); ?>

							<?php if ( ! edd_has_variable_prices( get_the_ID() ) ) : ?>
								<?php edd_price( get_the_ID() ); ?>
							<?php endif; ?>

							<?php do_action( 'rooten_edd_rp_item_after_price' ); ?>

							<div class="edd_download_buy_button">
								<?php
								$rooten_purchase_link_args = array(
									'download_id' => get_the_ID(),
									'price' => false,
									'direct' => false,
								);
								$rooten_purchase_link_args = apply_filters( 'rooten_edd_rp_purchase_link_args', $rooten_purchase_link_args );
								echo edd_get_purchase_link( $rooten_purchase_link_args );
								?>
							</div>
						</div>
						<?php do_action( 'rooten_edd_rp_item_after' ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

	<?php endif; ?>

<?php endif; ?>
