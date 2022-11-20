<article id="post-<?php the_ID() ?>" <?php post_class('bdt-article bdt-text-'.get_theme_mod('rooten_blog_align', 'left')) ?> data-permalink="<?php the_permalink() ?>" typeof="Article">

    <?php get_template_part( 'template-parts/download/schema-meta' ); ?>

    <div class="bdt-grid" bdt-grid>

        <div class="bdt-width-3-5@m">

            <div class="tm-edd-details-page-content">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="bdt-margin-medium-bottom tm-blog-thumbnail">
                        <?php if(is_single()) : ?>
                            <?php echo  the_post_thumbnail('large', array('class' => 'bdt-border-rounded'));  ?>
                        <?php else : ?>
                            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                                <?php echo  the_post_thumbnail('large', array('class' => 'bdt-border-rounded'));  ?>
                            </a>
                        <?php endif; ?>           
                    </div>
                <?php endif; ?>

                
                
                <?php get_template_part( 'template-parts/download/content' ); ?>

                <?php get_template_part( 'template-parts/download/read-more' ); ?>

            </div>

        </div>

        <div class="bdt-width-2-5@m">

            <div class="tm-edd-details-page-sidebar">

                <div class="tm-edd-dp-price">
                    <?php rooten_edd_price( get_the_ID() ); ?>
                </div>

                <div class="tm-edd-dpp-button">
                    <?php echo edd_get_purchase_link(['price' => false]); ?>
                </div>

                <h3><?php esc_html_e( 'Details', 'rooten' ); ?></h3>

                <ul>

                    

                    <?php
                    /**
                     * Date published.
                     */
                    ?>
                    <li class="downloadDetails-datePublished">
                        <span class="downloadDetails-name"><?php _e( 'Published:', 'rooten' ); ?></span>
                        <span class="downloadDetails-value"><?php echo rooten_edd_download_date_published(); ?></span>
                    </li>
                    

                    <?php
                    /**
                     * Sale count.
                     */
                    $rooten_sales = edd_get_download_sales_stats( $post->ID );
                    ?>
                    <li class="downloadDetails-sales">
                        <span class="downloadDetails-name"><?php _e( 'Sales:', 'rooten' ); ?></span>
                        <span class="downloadDetails-value"><?php echo $rooten_sales; ?></span>
                    </li>
                    

                    <?php
                    /**
                     * Version.
                     */
                    

                        $rooten_version = rooten_edd_download_version( $post->ID );

                        if ( $rooten_version ) : ?>
                        <li class="downloadDetails-version">
                            <span class="downloadDetails-name"><?php _e( 'Version:', 'rooten' ); ?></span>
                            <span class="downloadDetails-value"><?php echo $rooten_version; ?></span>
                        </li>
                        <?php endif; ?>
                    

                    <?php
                    /**
                     * Download categories.
                     */
                    

                        $rooten_categories = rooten_edd_download_categories( $post->ID );

                        if ( $rooten_categories ) : ?>
                        <li class="downloadDetails-categories">
                            <span class="downloadDetails-name"><?php _e( 'Categories:', 'rooten' ); ?></span>
                            <span class="downloadDetails-value"><?php echo $rooten_categories; ?></span>
                        </li>
                        <?php endif; ?>
                    

                    <?php
                    /**
                     * Download tags.
                     */
                    

                        $rooten_tags = rooten_edd_download_tags( $post->ID );

                        if ( $rooten_tags ) : ?>
                        <li class="downloadDetails-tags">
                            <span class="downloadDetails-name"><?php _e( 'Tags:', 'rooten' ); ?></span>
                            <span class="downloadDetails-value"><?php echo $rooten_tags; ?></span>
                        </li>
                        <?php endif; ?>
                    

                    

                </ul>




                <h3><?php esc_html_e( 'About Author', 'rooten' ); ?></h3>

                <?php
                /**
                 * Author avatar
                 */
                $rooten_user       = new WP_User( $post->post_author );

                ?>
                    <div class="downloadAuthor-avatar">
                        <?php echo get_avatar( $rooten_user->ID, 80, '', get_the_author_meta( 'display_name' ) ); ?>
                    
                    </div>
                

                <?php
                /**
                 * Author's store name.
                 */
                
                $rooten_store_name = get_the_author_meta( 'name_of_store', $post->post_author );
                ?>

                    <?php if ( rooten_is_edd_fes_active() && ! empty( $rooten_store_name ) ) : ?>
                    <h2 class="widget-title"><?php echo $rooten_store_name; ?></h2>
                    <?php endif; ?>

                

                <ul>

                

                <?php
                /**
                 * Author name.
                 */
                ?>

                    <li class="downloadAuthor-author">
                        <span class="downloadAuthor-name"><?php _e( 'Author:', 'rooten' ); ?></span>
                        <span class="downloadAuthor-value">
                            <?php if ( rooten_is_edd_fes_active() ) : ?>
                                <a class="vendor-url" href="<?php echo $rooten_vendor_url; ?>">
                                    <?php echo $rooten_user->display_name; ?>
                                </a>
                            <?php else : ?>
                                <?php echo $rooten_user->display_name; ?>
                            <?php endif; ?>
                        </span>
                    </li>
                

                <?php
                /**
                 * Author signup date.
                 */
                ?>

                    <li class="downloadAuthor-authorSignupDate">
                        <span class="downloadAuthor-name"><?php _e( 'Author since:', 'rooten' ); ?></span>
                        <span class="downloadAuthor-value"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $rooten_user->user_registered ) ); ?></span>
                    </li>
               

                <?php
                /**
                 * Author website.
                 */
                $rooten_website = get_the_author_meta( 'user_url', $post->post_author );

                if ( ! empty( $rooten_website ) ) : ?>

                <li class="downloadAuthor-website">
                    <span class="downloadAuthor-name"><?php _e( 'Website:', 'rooten' ); ?></span>
                    <span class="downloadAuthor-value"><a href="<?php echo esc_url( $rooten_website ); ?>" target="_blank" rel="noopener"><?php echo esc_url( $rooten_website ); ?></a></span>
                </li>
                <?php endif; ?>

                

                </ul>
            </div>


        </div>
        
    </div>

</article>