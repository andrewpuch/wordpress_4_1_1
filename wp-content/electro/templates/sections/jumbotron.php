<?php
/**
 * Jumbotron
 *
 * @author  Transvelo
 * @package Electro/Templates
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! empty( $image ) ) {
	$image_attributes = wp_get_attachment_image_src( $image, 'full' );
}

?>
<div class="jumbotron-product-category">
	<?php if( isset( $image_attributes ) ) : ?>
	<p class="no-margin"><img class="jumbo-image wp-image-2724 alignright" src="<?php echo esc_url( $image_attributes[0] ); ?>" alt="" width="416" height="283" /></p>
	<?php endif; ?>
	<h3 class="jumbo-title"><?php echo wp_kses_post( $title ); ?></h3>
	<p class="jumbo-subtitle"><?php echo wp_kses_post( $sub_title ); ?></p>
</div>