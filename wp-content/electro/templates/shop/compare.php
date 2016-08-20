<?php
/**
 * Compare Template
 *
 * @author Transvelo
 * @package electro/templates/shop
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product, $yith_woocompare, $post; ?>
    
<?php if( ! empty( $products ) ) : ?>

<div class="table-responsive">

    <table class="table table-compare compare-list">
        
        <tbody>

            <?php $fields_displayed = array(); ?>

            <?php if( isset( $fields['image'] ) && isset( $fields['title'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Product', 'electro' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td>
                    <a href="<?php echo get_permalink( $product->post->ID ); ?>" class="product">
                        <div class="product-image">
                            <div class="image">
                                <?php 
                                    if( has_post_thumbnail( $product->post->ID ) ) {
                                        echo get_the_post_thumbnail( $product->post->ID, 'shop_catalog' );
                                    } elseif( wc_placeholder_img_src() ) {
                                        echo wc_placeholder_img_src( 'shop_catalog' );
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?php echo esc_html( $product->fields['title'] ); ?></h3>
                            <?php wc_get_template( 'loop/rating.php', array( 'product', $product ) ); ?>
                        </div>
                    </a><!-- /.product -->
                </td>
                <?php 
                    $fields_displayed[] = 'image';
                    $fields_displayed[] = 'title';
                ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php if( isset( $fields['price'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Price', 'electro' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td>
                    <div class="product-price price"><?php echo wp_kses_post( $product->fields['price'] ); ?></div>
                </td>
                <?php $fields_displayed[] = 'price'; ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php if( isset( $fields['stock'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Availability', 'electro' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td><?php echo wp_kses_post( $product->fields['stock'] ); ?>
                <?php $fields_displayed[] = 'stock'; ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php if( isset( $fields['description'] ) ) : ?>
            <tr>
                <th><?php echo esc_html__( 'Description', 'electro' ); ?></th>
                <?php foreach( $products as $key => $product ) : ?>
                <td><?php echo wp_kses_post( $product->fields['description'] ); ?>
                <?php $fields_displayed[] = 'description'; ?>
                <?php endforeach; ?>
            </tr>
            <?php endif; ?>

            <?php foreach( $fields as $field => $name ) : ?>
                <?php if( ! in_array( $field, $fields_displayed ) ) : ?>
                <tr>
                    <th><?php echo wp_kses_post( $name ); ?></th>
                    <?php foreach( $products as $key => $product ) : ?>
                    <td>
                        <?php 
                            if( $field === 'add-to-cart' ) {
                                wc_get_template( 'loop/add-to-cart.php', array( 'product' => $product ) );
                            } else {
                                echo empty( $product->fields[$field] ) ? '&nbsp;' : $product->fields[$field];
                            }
                        ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ( $repeat_price == 'yes' && isset( $fields['price'] ) ) : ?>
                <tr>
                    <th><?php echo esc_html__( 'Price', 'electro' ); ?></th>
                    <?php foreach( $products as $key => $product ) : ?>
                    <td>
                        <div class="product-price price"><?php echo wp_kses_post( $product->fields['price'] ); ?></div>
                    </td>
                    <?php $fields_displayed[] = 'price'; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>

            <?php if ( $repeat_add_to_cart == 'yes' && isset( $fields['add-to-cart'] ) ) : ?>
                <tr class="add-to-cart repeated">
                    <th><?php echo wp_kses_post( $fields['add-to-cart'] ); ?></th>
                    <?php foreach( $products as $key => $product ) : ?>
                    <td><?php wc_get_template( 'loop/add-to-cart.php', array( 'product' => $product ) ); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endif; ?>

            <tr>
                <th>&nbsp;</th>
                <?php foreach( $products as $i => $product ) : ?>
                <td class="text-center">
                    <a href="<?php echo esc_url( $yith_woocompare->obj->remove_product_url( $product->id ) ); ?>" data-product_id="<?php echo esc_attr( $product->id ); ?>" class="remove-icon" title="<?php echo esc_attr( esc_html__( 'Remove', 'electro' ) ); ?>"><i class="fa fa-times"></i></a>
                </td>
                <?php endforeach ?>
            </tr>

        </tbody>
    </table>

</div><!-- /.table-responsive -->


<?php else : ?>

    <div class="outer-bottom-vs outer-top-sm compare-empty">
        <h1 class="lead-title text-center cart-empty">
            <?php esc_html_e( 'No products were added to the compare table', 'electro' ) ?>
        </h1>
        
        <p class="return-to-shop">
            <a class="wc-backward btn" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
                <i class="icon fa fa-mail-reply"></i>
                <?php esc_html_e( 'Return To Shop', 'electro' ) ?>
            </a>
        </p>
    </div>

<?php endif; ?>