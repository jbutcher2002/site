<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$rooten_tabs = apply_filters( 'rooten_woocommerce_product_tabs', array() );

if ( ! empty( $rooten_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="wc-tabs bdt-margin-medium-bottom" bdt-tab>
			<?php foreach ( $rooten_tabs as $rooten_key => $rooten_tab ) : ?>
				<li class="bdt-text-bold <?php echo esc_attr( $rooten_key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $rooten_key ); ?>"><?php echo apply_filters( 'rooten_woocommerce_product_' . $rooten_key . '_tab_title', esc_html( $rooten_tab['title'] ), $rooten_key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $rooten_tabs as $rooten_key => $rooten_tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $rooten_key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $rooten_key ); ?>">
				<?php call_user_func( $rooten_tab['callback'], $rooten_key, $rooten_tab ); ?>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
