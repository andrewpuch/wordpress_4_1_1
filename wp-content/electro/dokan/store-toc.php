<?php
/**
 * The Template for displaying all reviews.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );

get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<div id="primary" class="content-area dokan-single-store">
    <div id="content" class="site-content store-review-wrap woocommerce" role="main">

        <?php dokan_get_template_part( 'store-header' ); ?>

        <div id="store-toc-wrapper">
            <div id="store-toc">
                <?php
                if( isset( $store_info['store_tnc'] ) ):
                ?>
                    <h2 class="headline"><?php _e( 'Terms And Conditions', 'electro' ); ?></h2>
                    <div>
                        <?php
                        echo nl2br($store_info['store_tnc']);
                        ?>
                    </div>
                <?php
                endif;
                ?>
            </div><!-- #store-toc -->
        </div><!-- #store-toc-wrap -->

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>