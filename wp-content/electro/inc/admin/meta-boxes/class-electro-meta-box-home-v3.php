<?php
/**
 * Home v3 Metabox
 *
 * Displays the home v3 meta box, tabbed, with several panels covering price, stock etc.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Electro_Meta_Box_Home_v3 Class.
 */
class Electro_Meta_Box_Home_v3 {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {
		global $post, $thepostid;

		wp_nonce_field( 'electro_save_data', 'electro_meta_nonce' );

		$thepostid 		= $post->ID;
		$template_file 	= get_post_meta( $thepostid, '_wp_page_template', true );

		if ( $template_file !== 'template-homepage-v3.php' ) {
			return;
		}

		self::output_home_v3( $post );
	}

	private static function output_home_v3( $post ) {

		$home_v3 = electro_get_home_v3_meta();

		?>
		<div class="panel-wrap meta-box-home">
			<ul class="home_data_tabs ec-tabs">
			<?php
				$product_data_tabs = apply_filters( 'woocommerce_product_data_tabs', array(
					'general' => array(
						'label'  => __( 'General', 'electro' ),
						'target' => 'general_block',
						'class'  => array(),
					),
					'slider' => array(
						'label'  => __( 'Slider', 'electro' ),
						'target' => 'slider_block',
						'class'  => array(),
					),
					'features_list' => array(
						'label'  => __( 'Features List', 'electro' ),
						'target' => 'features_list',
						'class'  => array(),
					),
					'ads_block' => array(
						'label'  => __( 'Ads Block', 'electro' ),
						'target' => 'ads_block',
						'class'  => array(),
					),
					'tabs_carousel' => array(
						'label'  => __( 'Tabs Carousel', 'electro' ),
						'target' => 'tabs_carousel',
						'class'  => array(),
					),
					'products_carousel_with_image' => array(
						'label'  => __( 'Products Carousel with Image', 'electro' ),
						'target' => 'products_carousel_with_image',
						'class'  => array(),
					),
					'cards_carousel' => array(
						'label'  => __( 'Product Cards Carousel', 'electro' ),
						'target' => 'products_cards_carousel',
						'class'  => array(),
					),
					'so_block' => array(
						'label'  => __( '6-1 Products Block', 'electro' ),
						'target' => 'so_block',
						'class'  => array(),
					),
					'hlc_block' => array(
						'label'  => __( 'Categories List Block', 'electro' ),
						'target' => 'hlc_block',
						'class'  => array(),
					)
				) );
				foreach ( $product_data_tabs as $key => $tab ) {
					?><li class="<?php echo esc_attr( $key ); ?>_options <?php echo esc_attr( $key ); ?>_tab <?php echo implode( ' ' , $tab['class'] ); ?>">
						<a href="#<?php echo esc_attr( $tab['target'] ); ?>"><?php echo esc_html( $tab['label'] ); ?></a>
					</li><?php
				}
				do_action( 'electro_home_write_panel_tabs' );
			?>
			</ul>
			<div id="general_block" class="panel electro_options_panel">
				<div class="options_group">
				<?php 
					electro_wp_select( array(
						'id'		=> '_home_v3_header_style',
						'label'		=> esc_html__( 'Header Style', 'electro' ),
						'name'		=> '_home_v3[header_style]',
						'options'	=> array( '' => esc_html__( 'Normal', 'electro' ), 'v4' => esc_html__( 'Full Color Background', 'electro' ) ),
						'value'		=> isset( $home_v3['header_style'] ) ? $home_v3['header_style'] : '',
					) );
				?>
				</div>
				<div class="options_group">
					<?php 
						$home_v3_blocks = array(
							'sdr'	=> esc_html__( 'Slider', 'electro' ),
							'fl'	=> esc_html__( 'Features List', 'electro' ),
							'ad'	=> esc_html__( 'Ads Block', 'electro' ),
							'pct'	=> esc_html__( 'Tabs Carousel', 'electro' ),
							'pci'	=> esc_html__( 'Products Carousel with Image', 'electro' ),
							'pcc'	=> esc_html__( 'Product Cards Carousel', 'electro' ),
							'so'	=> esc_html__( '6-1 Products Block', 'electro' ),
							'hlc'	=> esc_html__( 'Categories List Block', 'electro' )
						);
					?>
					<table class="general-blocks-table widefat striped">
						<thead>
							<tr>
								<th><?php echo esc_html__( 'Block', 'electro' ); ?></th>
								<th><?php echo esc_html__( 'Animation', 'electro' ); ?></th>
								<th><?php echo esc_html__( 'Priority', 'electro' ); ?></th>
								<th><?php echo esc_html__( 'Enabled ?', 'electro' ); ?></th>
							</tr>	
						</thead>
						<tbody>
							<?php foreach( $home_v3_blocks as $key => $home_v3_block ) : ?>
							<tr>
								<td><?php echo esc_html( $home_v3_block ); ?></td>
								<td><?php electro_wp_animation_dropdown( array(  'id' => '_home_v3_' . $key . '_animation', 'label'=> '', 'name' => '_home_v3[' . $key . '][animation]', 'value' => isset( $home_v3['' . $key . '']['animation'] ) ? $home_v3['' . $key . '']['animation'] : '', )); ?></td>
								<td><?php electro_wp_text_input( array(  'id' => '_home_v3_' . $key . '_priority', 'label'=> '', 'name' => '_home_v3[' . $key . '][priority]', 'value' => isset( $home_v3['' . $key . '']['priority'] ) ? $home_v3['' . $key . '']['priority'] : 10, ) ); ?></td>
								<td><?php electro_wp_checkbox( array( 'id' => '_home_v3_' . $key . '_is_enabled', 'label' => '', 'name' => '_home_v3[' . $key . '][is_enabled]', 'value'=> isset( $home_v3['' . $key . '']['is_enabled'] ) ? $home_v3['' . $key . '']['is_enabled'] : '', ) ); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div><!-- /#general_block -->
			
			<div id="slider_block" class="panel electro_options_panel">
				<div class="options_group">
				<?php 
					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_sdr_shortcode', 
						'label' 		=> esc_html__( 'Shortcode', 'electro' ), 
						'placeholder' 	=> __( 'Enter the shorcode for your slider here', 'electro' ),
						'name'			=> '_home_v3[sdr][shortcode]',
						'value'			=> isset( $home_v3['sdr']['shortcode'] ) ? $home_v3['sdr']['shortcode'] : '',
					) );
				?>
				</div>
			</div><!-- /#slider_block -->

			<div id="features_list" class="panel electro_options_panel">

				<?php electro_wp_legend( esc_html__( 'Feature 1', 'electro' ) ); ?>
				
				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_1_icon',
						'label' 		=> esc_html__( 'Icon', 'electro' ), 
						'placeholder' 	=> __( 'Enter the icon for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][0][icon]',
						'value'			=> isset( $home_v3['fl'][0]['icon'] ) ? $home_v3['fl'][0]['icon'] : 'ec ec-transport',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_1_text',
						'label' 		=> esc_html__( 'Text', 'electro' ), 
						'placeholder' 	=> __( 'Enter the text for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][0][text]',
						'value'			=> isset( $home_v3['fl'][0]['text'] ) ? $home_v3['fl'][0]['text'] : wp_kses_post( __( '<strong>Free Delivery</strong> from $50', 'electro' ) ),
					) );
				?>
				</div>

				<?php electro_wp_legend( esc_html__( 'Feature 2', 'electro' ) ); ?>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_2_icon',
						'label' 		=> esc_html__( 'Icon', 'electro' ), 
						'placeholder' 	=> __( 'Enter the icon for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][1][icon]',
						'value'			=> isset( $home_v3['fl'][1]['icon'] ) ? $home_v3['fl'][1]['icon'] : 'ec ec-customers',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_2_text',
						'label' 		=> esc_html__( 'Text', 'electro' ), 
						'placeholder' 	=> __( 'Enter the text for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][1][text]',
						'value'			=> isset( $home_v3['fl'][1]['text'] ) ? $home_v3['fl'][1]['text'] : wp_kses_post( __( '<strong>99% Positive</strong> Feedbacks', 'electro' ) ),
					) );
				?>
				</div>

				<?php electro_wp_legend( esc_html__( 'Feature 3', 'electro' ) ); ?>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_3_icon',
						'label' 		=> esc_html__( 'Icon', 'electro' ), 
						'placeholder' 	=> __( 'Enter the icon for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][2][icon]',
						'value'			=> isset( $home_v3['fl'][2]['icon'] ) ? $home_v3['fl'][2]['icon'] : 'ec ec-returning',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_3_text',
						'label' 		=> esc_html__( 'Text', 'electro' ), 
						'placeholder' 	=> __( 'Enter the text for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][2][text]',
						'value'			=> isset( $home_v3['fl'][2]['text'] ) ? $home_v3['fl'][2]['text'] : wp_kses_post( __( '<strong>365 days</strong> for free return', 'electro' ) ),
					) );
				?>
				</div>

				<?php electro_wp_legend( esc_html__( 'Feature 4', 'electro' ) ); ?>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_4_icon',
						'label' 		=> esc_html__( 'Icon', 'electro' ), 
						'placeholder' 	=> __( 'Enter the icon for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][3][icon]',
						'value'			=> isset( $home_v3['fl'][3]['icon'] ) ? $home_v3['fl'][3]['icon'] : 'ec ec-payment',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_4_text',
						'label' 		=> esc_html__( 'Text', 'electro' ), 
						'placeholder' 	=> __( 'Enter the text for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][3][text]',
						'value'			=> isset( $home_v3['fl'][3]['text'] ) ? $home_v3['fl'][3]['text'] : wp_kses_post( __( '<strong>Payment</strong> Secure System', 'electro' ) ),
					) );
				?>
				</div>

				<?php electro_wp_legend( esc_html__( 'Feature 5', 'electro' ) ); ?>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_5_icon',
						'label' 		=> esc_html__( 'Icon', 'electro' ), 
						'placeholder' 	=> __( 'Enter the icon for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][4][icon]',
						'value'			=> isset( $home_v3['fl'][4]['icon'] ) ? $home_v3['fl'][4]['icon'] : 'ec ec-tag',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_fl_5_text',
						'label' 		=> esc_html__( 'Text', 'electro' ), 
						'placeholder' 	=> __( 'Enter the text for your features here', 'electro' ),
						'name'			=> '_home_v3[fl][4][text]',
						'value'			=> isset( $home_v3['fl'][4]['text'] ) ? $home_v3['fl'][4]['text'] : wp_kses_post( __( '<strong>Only Best</strong> Brands', 'electro' ) ),
					) );
				?>
				</div>
				
			</div><!-- /#features_list -->
			
			<div id="ads_block" class="panel electro_options_panel">

				<?php electro_wp_legend( esc_html__( 'Ads Block', 'electro' ) ); ?>

				<div class="options_group">
				<?php

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_1_ad_text', 
						'label' 		=> esc_html__( 'Ad Text', 'electro' ), 
						'name'			=> '_home_v3[ad][0][ad_text]',
						'value'			=> isset( $home_v3['ad'][0]['ad_text'] ) ? $home_v3['ad'][0]['ad_text'] : wp_kses_post( __( 'Catch Big <strong>Deals</strong> on the Cameras', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_1_action_text', 
						'label' 		=> esc_html__( 'Action Text', 'electro' ), 
						'name'			=> '_home_v3[ad][0][action_text]',
						'value'			=> isset( $home_v3['ad'][0]['action_text'] ) ? $home_v3['ad'][0]['action_text'] : wp_kses_post( __( 'Shop now', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_1_action_link', 
						'label' 		=> esc_html__( 'Action Link', 'electro' ), 
						'name'			=> '_home_v3[ad][0][action_link]',
						'value'			=> isset( $home_v3['ad'][0]['action_link'] ) ? $home_v3['ad'][0]['action_link'] : '#',
					) );

					electro_wp_upload_image( array(
						'id'			=> '_home_v3_ad_1_ad_image',
						'label'			=> esc_html__( 'Ad Image', 'electro' ),
						'name'			=> '_home_v3[ad][0][ad_image]',
						'value'			=> isset( $home_v3['ad'][0]['ad_image'] ) ? $home_v3['ad'][0]['ad_image'] : '',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_1_el_class', 
						'label' 		=> esc_html__( 'Extra Class', 'electro' ), 
						'name'			=> '_home_v3[ad][0][el_class]',
						'value'			=> isset( $home_v3['ad'][0]['el_class'] ) ? $home_v3['ad'][0]['el_class'] : 'col-xs-12 col-sm-4',
					) );
				?>
				</div>

				<?php electro_wp_legend( esc_html__( 'Ads Block 2', 'electro' ) ); ?>

				<div class="options_group">
				<?php

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_2_ad_text', 
						'label' 		=> esc_html__( 'Ad Text', 'electro' ), 
						'name'			=> '_home_v3[ad][1][ad_text]',
						'value'			=> isset( $home_v3['ad'][1]['ad_text'] ) ? $home_v3['ad'][1]['ad_text'] : wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_2_action_text', 
						'label' 		=> esc_html__( 'Action Text', 'electro' ), 
						'name'			=> '_home_v3[ad][1][action_text]',
						'value'			=> isset( $home_v3['ad'][1]['action_text'] ) ? $home_v3['ad'][1]['action_text'] : wp_kses_post( __( '<span class="upto"><span class="prefix">Upto</span><span class="value">70</span><span class="suffix">%</span>', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_2_action_link', 
						'label' 		=> esc_html__( 'Action Link', 'electro' ), 
						'name'			=> '_home_v3[ad][1][action_link]',
						'value'			=> isset( $home_v3['ad'][1]['action_link'] ) ? $home_v3['ad'][1]['action_link'] : '#',
					) );

					electro_wp_upload_image( array(
						'id'			=> '_home_v3_ad_2_ad_image',
						'label'			=> esc_html__( 'Ad Image', 'electro' ),
						'name'			=> '_home_v3[ad][1][ad_image]',
						'value'			=> isset( $home_v3['ad'][1]['ad_image'] ) ? $home_v3['ad'][1]['ad_image'] : '',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v3_ad_2_el_class', 
						'label' 		=> esc_html__( 'Extra Class', 'electro' ), 
						'name'			=> '_home_v3[ad][1][el_class]',
						'value'			=> isset( $home_v3['ad'][1]['el_class'] ) ? $home_v3['ad'][1]['el_class'] : 'col-xs-12 col-sm-4',
					) );
				?>
				</div>
			</div><!-- /#ads_block -->

			<div id="tabs_carousel" class="panel electro_options_panel">
				
				<div class="options_group">
				<?php 
					electro_wp_text_input( array( 
						'id'			=> '_home_v3_pct_product_limit', 
						'label' 		=>  esc_html__( 'Products Limit', 'electro' ),
						'placeholder' 	=> esc_html__( 'Enter the number of products to show', 'electro' ),
						'name'			=> '_home_v3[pct][product_limit]',
						'class'			=> 'product_limit',
						'size'			=> 2,
						'value'			=> isset( $home_v3['pct']['product_limit'] ) ? $home_v3['pct']['product_limit'] : 6,
					) );

					electro_wp_select( array( 
						'id'			=> '_home_v3_pct_product_columns', 
						'label' 		=>  esc_html__( 'Columns', 'electro' ),
						'options'		=> array(
							'2'	=> '2',
							'3'	=> '3',
							'4'	=> '4',
							'5'	=> '5',
							'6'	=> '6',
						),
						'class'			=> 'columns_select',
						'default'		=> '3',
						'name'			=> '_home_v3[pct][product_columns]',
						'value'			=> isset( $home_v3['pct']['product_columns'] ) ? $home_v3['pct']['product_columns'] : 3,
					) );
				?>
				</div>

				<div class="options_group">
				<?php	
					electro_wp_text_input( array( 
						'id'			=> '_home_v3_pct_tabs_1_title', 
						'label' 		=> esc_html__( 'Tab #1 Title', 'electro' ),
						'placeholder' 	=> esc_html__( 'Featured', 'electro' ),
						'name'			=> '_home_v3[pct][tabs][0][title]',
						'value'			=> isset( $home_v3['pct']['tabs'][0]['title'] ) ? $home_v3['pct']['tabs'][0]['title'] : esc_html__( 'Featured', 'electro' ),
					) );

					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v3_pct_tabs_1_content',
						'label'			=> esc_html__( 'Tab #1 Content', 'electro' ),
						'default'		=> 'featured_products',
						'name'			=> '_home_v3[pct][tabs][0][content]',
						'value'			=> isset( $home_v3['pct']['tabs'][0]['content'] ) ? $home_v3['pct']['tabs'][0]['content'] : '',
					) );
				?>
				</div>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id'			=> '_home_v3_pct_tabs_2_title', 
						'label' 		=> esc_html__( 'Tab #2 Title', 'electro' ),
						'placeholder' 	=> esc_html__( 'On Sale', 'electro' ),
						'name'			=> '_home_v3[pct][tabs][1][title]',
						'value'			=> isset( $home_v3['pct']['tabs'][1]['title'] ) ? $home_v3['pct']['tabs'][1]['title'] : esc_html__( 'On Sale', 'electro' ),
					) );

					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v3_pct_tabs_2_content',
						'label'			=> esc_html__( 'Tab #2 Content', 'electro' ),
						'default'		=> 'sale_products',
						'name'			=> '_home_v3[pct][tabs][1][content]',
						'value'			=> isset( $home_v3['pct']['tabs'][1]['content'] ) ? $home_v3['pct']['tabs'][1]['content'] : '',
					) );
				?>
				</div>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id'			=> '_home_v3_pct_tabs_3_title', 
						'label' 		=> esc_html__( 'Tab #3 Title', 'electro' ),
						'placeholder' 	=> esc_html__( 'Top Rated', 'electro' ),
						'name'			=> '_home_v3[pct][tabs][2][title]',
						'value'			=> isset( $home_v3['pct']['tabs'][2]['title'] ) ? $home_v3['pct']['tabs'][2]['title'] : esc_html__( 'Top Rated', 'electro' ),
					) );
					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v3_pct_tabs_3_content',
						'label'			=> esc_html__( 'Tab #3 Content', 'electro' ),
						'default'		=> 'top_rated_products',
						'name'			=> '_home_v3[pct][tabs][2][content]',
						'value'			=> isset( $home_v3['pct']['tabs'][2]['content'] ) ? $home_v3['pct']['tabs'][2]['content'] : '',
					) );
				?>
				</div>
			</div>

			<div id="products_carousel_with_image" class="panel electro_options_panel">
				
				<?php electro_wp_legend( esc_html__( 'Image Block', 'electro' ) ); ?>

				<div class="options_group">
				<?php
					electro_wp_upload_image( array(
						'id'			=> '_home_v3_pci_image_bg_img',
						'label'			=> esc_html__( 'Background Image', 'electro' ),
						'name'			=> '_home_v3[pci][image][bg_img]',
						'value'			=> isset( $home_v3['pci']['image']['bg_img'] ) ? $home_v3['pci']['image']['bg_img'] : '',
					) );

					electro_wp_upload_image( array(
						'id'			=> '_home_v3_pci_image_ad_img',
						'label'			=> esc_html__( 'Ad Image', 'electro' ),
						'name'			=> '_home_v3[pci][image][ad_img]',
						'value'			=> isset( $home_v3['pci']['image']['ad_img'] ) ? $home_v3['pci']['image']['ad_img'] : '',
					) );
				?>
				</div>

				<?php electro_wp_legend( esc_html__( 'Products Carousel Block', 'electro' ) ); ?>

				<div class="options_group">
				<?php
					electro_wp_text_input( array(
						'id'			=> '_home_v3_pci_carousel_section_title',
						'label'			=> esc_html__( 'Section Title', 'electro' ),
						'name'			=> '_home_v3[pci][carousel][section_title]',
						'value'			=> isset( $home_v3['pci']['carousel']['section_title'] ) ? $home_v3['pci']['carousel']['section_title'] : esc_html__( 'Hoodies', 'electro' ),
					) );

					electro_wp_text_input( array(
						'id'			=> '_home_v3_pci_carousel_product_limit',
						'label'			=> esc_html__( 'Limit', 'electro' ),
						'name'			=> '_home_v3[pci][carousel][product_limit]',
						'value'			=> isset( $home_v3['pci']['carousel']['product_limit'] ) ? $home_v3['pci']['carousel']['product_limit'] : 8,
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v3_pci_carousel_product_columns',
						'label'			=> esc_html__( 'Columns', 'electro' ),
						'name'			=> '_home_v3[pci][carousel][product_columns]',
						'value'			=> isset( $home_v3['pci']['carousel']['product_columns'] ) ? $home_v3['pci']['carousel']['product_columns'] : 2,
					) );

					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v3_pci_carousel_content',
						'label'			=> esc_html__( 'Products', 'electro' ),
						'default'		=> 'product_category',
						'name'			=> '_home_v3[pci][carousel][content]',
						'value'			=> isset( $home_v3['pci']['carousel']['content'] ) ? $home_v3['pci']['carousel']['content'] : '',
					) );
				?>
				</div>
			</div>
			
			<div id="products_cards_carousel" class="panel electro_options_panel">
				
				<div class="options_group">
				<?php
					electro_wp_text_input( array(
						'id'			=> '_home_v3_pcc_section_title',
						'label'			=> esc_html__( 'Section Title', 'electro' ),
						'name'			=> '_home_v3[pcc][section_title]',
						'default'		=> esc_html__( 'Best Sellers', 'electro' ),
						'value'			=> isset( $home_v3['pcc']['section_title'] ) ? $home_v3['pcc']['section_title'] : esc_html__( 'Best Sellers', 'electro' ),
						'placeholder'	=> esc_html__( 'Best Sellers', 'electro' )
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v3_pcc_product_limit',
						'label'			=> esc_html__( 'Product Limit', 'electro' ),
						'name'			=> '_home_v3[pcc][product_limit]',
						'value'			=> isset( $home_v3['pcc']['product_limit'] ) ? $home_v3['pcc']['product_limit'] : 20,
						'placeholder'	=> esc_html__( 'Enter number of products to show', 'electro' ),
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v3_pcc_product_rows',
						'label'			=> esc_html__( 'Rows', 'electro' ),
						'name'			=> '_home_v3[pcc][product_rows]',
						'value'			=> isset( $home_v3['pcc']['product_rows'] ) ? $home_v3['pcc']['product_rows'] : 2,
						'placeholder'	=> esc_html__( 'Enter number of rows to display', 'electro' ),
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v3_pcc_product_columns',
						'label'			=> esc_html__( 'Columns', 'electro' ),
						'name'			=> '_home_v3[pcc][product_columns]',
						'value'			=> isset( $home_v3['pcc']['product_columns'] ) ? $home_v3['pcc']['product_columns'] : 3,
						'placeholder'	=> esc_html__( 'Enter number of products to show', 'electro' ),
					) );
					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v3_pcc_content',
						'label'			=> esc_html__( 'Products', 'electro' ),
						'default'		=> 'best_selling_products',
						'name'			=> '_home_v3[pcc][content]',
						'value'			=> isset( $home_v3['pcc']['content'] ) ? $home_v3['pcc']['content'] : ''
					) );
				?>
				</div>
			</div><!-- /#products_cards_carousel -->

			<div id="so_block" class="panel electro_options_panel">
				
				<div class="options_group">
				<?php
					electro_wp_text_input( array(
						'id'			=> '_home_v3_so_section_title',
						'label'			=> esc_html__( 'Section Title', 'electro' ),
						'name'			=> '_home_v3[so][section_title]',
						'value'			=> isset( $home_v3['so']['section_title'] ) ? $home_v3['so']['section_title'] : esc_html__( 'Best Deals', 'electro' ),
					) );

					electro_wp_text_input( array(
						'id'			=> '_home_v3_so_cat_limit',
						'label'			=> esc_html__( 'Categories Limit', 'electro' ),
						'name'			=> '_home_v3[so][cat_limit]',
						'default'		=> 7,
						'value'			=> isset( $home_v3['so']['cat_limit'] ) ? $home_v3['so']['cat_limit'] : 7,
						'placeholder'	=> 7
					) );

					electro_wp_text_input( array(
						'id'			=> '_home_v3_so_cat_slugs',
						'label'			=> esc_html__( 'Category Slug', 'electro' ),
						'name'			=> '_home_v3[so][cat_slugs]',
						'default'		=> '',
						'value'			=> isset( $home_v3['so']['cat_slugs'] ) ? $home_v3['so']['cat_slugs'] : '',
						'placeholder'	=> esc_html__( 'Enter category slugs separated by comma', 'electro' )
					) );

					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v3_so_content',
						'label'			=> esc_html__( 'Products', 'electro' ),
						'default'		=> 'sale_products',
						'name'			=> '_home_v3[so][content]',
						'value'			=> isset( $home_v3['so']['content'] ) ? $home_v3['so']['content'] : ''
					) );
				?>
				</div>
			</div>

			<div id="hlc_block" class="panel electro_options_panel">
				
				<div class="options_group">
				<?php
					electro_wp_text_input( array(
						'id'			=> '_home_v3_hlc_section_title',
						'label'			=> esc_html__( 'Section Title', 'electro' ),
						'name'			=> '_home_v3[hlc][section_title]',
						'value'			=> isset( $home_v3['hlc']['section_title'] ) ? $home_v3['hlc']['section_title'] : esc_html__( 'Top Categories this Month', 'electro' ),
					) );

					electro_wp_text_input( array(
						'id'			=> '_home_v3_hlc_cat_slugs',
						'label'			=> esc_html__( 'Category Slug', 'electro' ),
						'name'			=> '_home_v3[hlc][cat_slugs]',
						'value'			=> isset( $home_v3['hlc']['cat_slugs'] ) ? $home_v3['hlc']['cat_slugs'] : '',
						'placeholder'	=> esc_html__( 'Enter category slugs separated by comma', 'electro' ),
					) );
				?>
				</div>
			</div>
		</div>
		<?php
	}

	public static function save( $post_id, $post ) {
		if ( isset( $_POST['_home_v3'] ) ) {
			$clean_home_v3_options = electro_clean_kses_post( $_POST['_home_v3'] );
			update_post_meta( $post_id, '_home_v3_options',  addslashes( json_encode( $clean_home_v3_options ) ) );
		}	
	}
}