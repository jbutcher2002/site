<?php
/**
 * Is EDD active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_active() {
    return class_exists( 'Easy_Digital_Downloads' );
}

/**
 * Is EDD Software Licensing active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_sl_active() {
    return class_exists( 'EDD_Software_Licensing' );
}

/**
 * Is EDD Recurring active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_recurring_active() {
    return class_exists( 'EDD_Recurring' );
}

/**
 * Is EDD Frontend Submissions active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_fes_active() {
    return class_exists( 'EDD_Front_End_Submissions' );
}

/**
 * Is EDD Recommended Products active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_recommended_products_active() {
    return class_exists( 'EDDRecommendedDownloads' );
}

/**
 * Is EDD Cross-sell & Upsell active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_cross_sell_upsell_active() {
    return class_exists( 'EDD_Cross_Sell_And_Upsell' );
}

/**
 * Is EDD Coming Soon active?
 *
 * @since 1.0.2
 * @return bool
 */
function rooten_is_edd_coming_soon_active() {
    return class_exists( 'EDD_Coming_Soon' );
}

/**
 * Is EDD Points and Rewards active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_points_and_rewards_active() {
    return function_exists( 'edd_points_plugin_loaded' );
}

/**
 * Is EDD Reviews active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_edd_reviews_active() {
    return class_exists( 'EDD_Reviews' );
}

/**
 * Is AffiliateWP active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_affiliatewp_active() {
    return class_exists( 'Affiliate_WP' );
}

/**
 * Is the subtitles plugin active?
 *
 * @since 1.0.0
 * @return bool
 */
function rooten_is_subtitles_active() {
    return class_exists( 'Subtitles' );
}

/**
 * Download grid options.
 *
 * Used by all download grids:
 * 
 * via the [downloads] shortcode
 * archive-download.php
 * taxonomy-download_category.php
 * taxonomy-download_tag.php
 *
 * @since 1.0.0
 * 
 * @param array $atts Attributes from [downloads] shortcode (if passed in).
 * 
 * @return array $options Download grid options
 */
function rooten_edd_download_grid_options( $atts = array() ) {

    /**
     * Do some homekeeping on the [downloads] shortcode.
     * 
     * Converts the various "yes", "no, "true" etc into a format that the $options array uses.
     */
    if ( ! empty( $atts ) ) {
        
        // Buy button.
        if ( isset( $atts['buy_button'] ) && 'yes' === $atts['buy_button'] ) {
            $atts['buy_button'] = true;
        }

        // Price.
        if ( isset( $atts['price'] ) && 'yes' === $atts['price'] ) {
            $atts['price'] = true;
        }

        // Excerpt.
        if ( isset( $atts['excerpt'] ) && 'yes' === $atts['excerpt'] ) {
            $atts['excerpt'] = true;
        }

        // Full content.
        if ( isset( $atts['full_content'] ) && 'yes' === $atts['full_content'] ) {
            $atts['full_content'] = true;
        }

        // Thumbnails.
        if ( isset( $atts['thumbnails'] ) ) {
            if ( 'true' === $atts['thumbnails'] || 'yes' === $atts['thumbnails'] ) {
                $atts['thumbnails'] = true;
            }
        }

    }

    // Options.
    $options = array(
        'title'        => true, // This is unique to Themedd.
        'excerpt'      => true,
        'full_content' => false,
        'price'        => true,
        'buy_button'   => true,
        'columns'      => 3,
        'thumbnails'   => true,
        'pagination'   => true,
        'number'       => 9,
        'order'        => 'DESC',
        'orderby'      => 'post_date'
    );

    // Merge the arrays.
    $options = wp_parse_args( $atts, $options );

    // Return the options.
    return apply_filters( 'rooten_edd_download_grid_options', $options );

}

/**
 * The download footer
 *
 * Appears at the bottom of a download in the download grid.
 * The download grid appears:
 *
 * 1. Wherever the [downloads] shortcode is used.
 * 2. The custom post type archive page (/downloads), unless it has been disabled.
 * 3. archive-download.php
 * 4. taxonomy-download_category.php
 * 5. taxonomy-download_tag.php
 *
 * @param array $atts Attributes from [downloads] shortcode.
 * @since 1.0.0
 */
function rooten_edd_download_footer( $atts = array() ) {

    // Pass the shortcode options into the download grid options.
    $download_grid_options = rooten_edd_download_grid_options( $atts );

    // Get the download ID.
    $download_id = get_the_ID();

    /**
     * Show the download footer.
     *
     * The download footer will be shown if one of the following is true:
     * 
     * - The price is shown.
     * - The buy button is shown.
     * - The download meta is loaded into the download footer.
     * - The rooten_edd_download_footer filter hook has been set to true.
     */
    if (
        true === $download_grid_options['buy_button']                                ||
        true === $download_grid_options['price']                                     ||
        true === apply_filters( 'rooten_edd_download_footer', false, $download_id ) ||
        'after' === rooten_edd_download_meta_position()
    ) : 
    ?>

    <div class="downloadFooter">
        <?php

        /**
         * Fires at the start of the download footer.
         *
         * @since 1.0.2
         * @since 1.0.3 Added $download_id
         * 
         * @param int $download_id The ID of the download.
         */
        do_action( 'rooten_edd_download_footer_start', $download_id );

        /**
         * Show the price.
         */
        if ( true === $download_grid_options['price'] ) :
            edd_get_template_part( 'shortcode', 'content-price' );
            do_action( 'rooten_edd_download_after_price', $download_id );
        endif;

        /**
         * Show the buy button.
         */
        if ( true === $download_grid_options['buy_button'] ) {
            edd_get_template_part( 'shortcode', 'content-cart-button' );
        }

        /**
         * Fires at the end of the download footer.
         *
         * @since 1.0.2
         * @since 1.0.3 Added $download_id
         * 
         * @param int $download_id The ID of the download.
         */
        do_action( 'rooten_edd_download_footer_end', $download_id );

        ?>
    </div>
    <?php endif; ?>

    <?php
}

/**
 * Download price
 *
 * @since 1.0.0
 */
function rooten_edd_price( $download_id ) {

    // Return early if price enhancements has been disabled.
    if ( false === rooten_edd_price_enhancements() ) {
        return;
    }

    if ( edd_is_free_download( $download_id ) ) {
        $price = '<span id="edd_price_' . get_the_ID() . '" class="edd_price">' . __( 'Free', 'rooten' ) . '</span>';
    } elseif ( edd_has_variable_prices( $download_id ) ) {
        $price = '<span id="edd_price_' . get_the_ID() . '" class="edd_price">' . __( 'From', 'rooten' ) . '&nbsp;' . edd_currency_filter( edd_format_amount( edd_get_lowest_price_option( $download_id ) ) ) . '</span>';
    } else {
        $price = edd_price( $download_id, false );
    }

    echo $price;

}
add_action( 'rooten_edd_download_info', 'rooten_edd_price', 10, 1 );

/**
 * EDD Price Enhancements
 *
 * While enabled:
 *
 * 1. Prices from purchase buttons are removed
 * 2. Prices are automatically shown when using the [downloads] shortcode (unless "price" is set to "no")
 *
 * @since 1.0.0
 *
 * @return boolean true
 */
function rooten_edd_price_enhancements() {
    return apply_filters( 'rooten_edd_price_enhancements', true );
}


/**
 * Get the download categories of a download, given its ID
 *
 * @since 1.0.0
 */
function rooten_edd_download_categories( $download_id = 0, $before = '', $sep = ', ', $after = '' ) {

    if ( ! $download_id ) {
        return false;
    }

    $categories = get_the_term_list( $download_id, 'download_category', $before, $sep, $after );

    if ( $categories ) {
        return $categories;
    }

    return false;

}


/**
 * Get the download tags of a download, given its ID.
 *
 * @since 1.0.0
 */
function rooten_edd_download_tags( $download_id = 0, $before = '', $sep = ', ', $after = '' ) {

    if ( ! $download_id ) {
        return false;
    }

    $tags = get_the_term_list( $download_id, 'download_tag', $before, $sep, $after );

    if ( $tags ) {
        return $tags;
    }

    return false;

}

/**
 * Get the version number of a download, given its ID.
 *
 * @since 1.0.0
 */
function rooten_edd_download_version( $download_id = 0 ) {

    if ( ! $download_id ) {
        return false;
    }

    if ( rooten_is_edd_sl_active() && (new Themedd_EDD_Software_Licensing)->has_licensing_enabled() ) {
        // Get version number from EDD Software Licensing.
        return get_post_meta( $download_id, '_edd_sl_version', true );
    }

    return false;

}

/**
 * Date published
 *
 * @since 1.0.0
 */
function rooten_edd_download_date_published() {

    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( 'c' ) ),
        esc_html( get_the_modified_date() )
    );

    return $time_string;

}