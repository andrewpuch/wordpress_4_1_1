<?php
/**
 * Home v2 Metabox
 *
 * Displays the home v2 meta box, tabbed, with several panels covering price, stock etc.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Electro_Meta_Box_Home_v2 Class.
 */
class Electro_Meta_Box_Home_v2 {

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

		if ( $template_file !== 'template-homepage-v2.php' ) {
			return;
		}

		self::output_home_v2( $post );
	}
	
	private static function output_home_v2( $post ) {

		$home_v2 = electro_get_home_v2_meta();

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
					'deals_carousel' => array(
						'label'  => __( 'Deals Carousel', 'electro' ),
						'target' => 'deals_carousel',
						'class'  => array(),
					),
					'cards_carousel' => array(
						'label'  => __( 'Product Cards Carousel', 'electro' ),
						'target' => 'products_cards_carousel',
						'class'  => array(),
					),
					'banner' => array(
						'label'  => __( 'Banner', 'electro' ),
						'target' => 'banner_data',
						'class'  => array(),
					),
					'products_carousel' => array(
						'label'  => __( 'Products Carousel', 'electro' ),
						'target' => 'products_carousel',
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
						$home_v2_blocks = array(
							'sdr'	=> esc_html__( 'Slider', 'electro' ),
							'ad'	=> esc_html__( 'Ads Block', 'electro' ),
							'pct'	=> esc_html__( 'Tabs Carousel', 'electro' ),
							'dow'	=> esc_html__( 'Deals Carousel', 'electro' ),
							'pcc'	=> esc_html__( 'Product Cards Carousel', 'electro' ),
							'bd'	=> esc_html__( 'Banner', 'electro' ),
							'pc'	=> esc_html__( 'Products Carousel', 'electro' ),
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
							<?php foreach( $home_v2_blocks as $key => $home_v2_block ) : ?>
							<tr>
								<td><?php echo esc_html( $home_v2_block ); ?></td>
								<td><?php electro_wp_animation_dropdown( array(  'id' => '_home_v2_' . $key . '_animation', 'label'=> '', 'name' => '_home_v2[' . $key . '][animation]', 'value' => isset( $home_v2['' . $key . '']['animation'] ) ? $home_v2['' . $key . '']['animation'] : '', )); ?></td>
								<td><?php electro_wp_text_input( array(  'id' => '_home_v2_' . $key . '_priority', 'label'=> '', 'name' => '_home_v2[' . $key . '][priority]', 'value' => isset( $home_v2['' . $key . '']['priority'] ) ? $home_v2['' . $key . '']['priority'] : 10, ) ); ?></td>
								<td><?php electro_wp_checkbox( array( 'id' => '_home_v2_' . $key . '_is_enabled', 'label' => '', 'name' => '_home_v2[' . $key . '][is_enabled]', 'value'=> isset( $home_v2['' . $key . '']['is_enabled'] ) ? $home_v2['' . $key . '']['is_enabled'] : '', ) ); ?></td>
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
						'id' 			=> '_home_v2_sdr_shortcode', 
						'label' 		=> esc_html__( 'Shortcode', 'electro' ), 
						'placeholder' 	=> __( 'Enter the shorcode for your slider here', 'electro' ),
						'name'			=> '_home_v2[sdr][shortcode]',
						'value'			=> isset( $home_v2['sdr']['shortcode'] ) ? $home_v2['sdr']['shortcode'] : '',
					) );
				?>
				</div>
			</div><!-- /#slider_block -->
			
			<div id="ads_block" class="panel electro_options_panel">

				<?php electro_wp_legend( esc_html__( 'Ads Block', 'electro' ) ); ?>

				<div class="options_group">
				<?php

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_1_ad_text', 
						'label' 		=> esc_html__( 'Ad Text', 'electro' ), 
						'name'			=> '_home_v2[ad][0][ad_text]',
						'value'			=> isset( $home_v2['ad'][0]['ad_text'] ) ? $home_v2['ad'][0]['ad_text'] : wp_kses_post( __( 'Catch Big <strong>Deals</strong> on the Cameras', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_1_action_text', 
						'label' 		=> esc_html__( 'Action Text', 'electro' ), 
						'name'			=> '_home_v2[ad][0][action_text]',
						'value'			=> isset( $home_v2['ad'][0]['action_text'] ) ? $home_v2['ad'][0]['action_text'] : wp_kses_post( __( 'Shop now', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_1_action_link', 
						'label' 		=> esc_html__( 'Action Link', 'electro' ), 
						'name'			=> '_home_v2[ad][0][action_link]',
						'value'			=> isset( $home_v2['ad'][0]['action_link'] ) ? $home_v2['ad'][0]['action_link'] : '#',
					) );

					electro_wp_upload_image( array(
						'id'			=> '_home_v2_ad_1_ad_image',
						'label'			=> esc_html__( 'Ad Image', 'electro' ),
						'name'			=> '_home_v2[ad][0][ad_image]',
						'value'			=> isset( $home_v2['ad'][0]['ad_image'] ) ? $home_v2['ad'][0]['ad_image'] : '',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_1_el_class', 
						'label' 		=> esc_html__( 'Extra Class', 'electro' ), 
						'name'			=> '_home_v2[ad][0][el_class]',
						'value'			=> isset( $home_v2['ad'][0]['el_class'] ) ? $home_v2['ad'][0]['el_class'] : 'col-xs-12 col-sm-4',
					) );
				?>
				</div>

				<?php electro_wp_legend( esc_html__( 'Ads Block 2', 'electro' ) ); ?>

				<div class="options_group">
				<?php

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_2_ad_text', 
						'label' 		=> esc_html__( 'Ad Text', 'electro' ), 
						'name'			=> '_home_v2[ad][1][ad_text]',
						'value'			=> isset( $home_v2['ad'][1]['ad_text'] ) ? $home_v2['ad'][1]['ad_text'] : wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_2_action_text', 
						'label' 		=> esc_html__( 'Action Text', 'electro' ), 
						'name'			=> '_home_v2[ad][1][action_text]',
						'value'			=> isset( $home_v2['ad'][1]['action_text'] ) ? $home_v2['ad'][1]['action_text'] : wp_kses_post( __( '<span class="upto"><span class="prefix">Upto</span><span class="value">70</span><span class="suffix">%</span>', 'electro' ) ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_2_action_link', 
						'label' 		=> esc_html__( 'Action Link', 'electro' ), 
						'name'			=> '_home_v2[ad][1][action_link]',
						'value'			=> isset( $home_v2['ad'][1]['action_link'] ) ? $home_v2['ad'][1]['action_link'] : '#',
					) );

					electro_wp_upload_image( array(
						'id'			=> '_home_v2_ad_2_ad_image',
						'label'			=> esc_html__( 'Ad Image', 'electro' ),
						'name'			=> '_home_v2[ad][1][ad_image]',
						'value'			=> isset( $home_v2['ad'][1]['ad_image'] ) ? $home_v2['ad'][1]['ad_image'] : '',
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_ad_2_el_class', 
						'label' 		=> esc_html__( 'Extra Class', 'electro' ), 
						'name'			=> '_home_v2[ad][1][el_class]',
						'value'			=> isset( $home_v2['ad'][1]['el_class'] ) ? $home_v2['ad'][1]['el_class'] : 'col-xs-12 col-sm-4',
					) );
				?>
				</div>
			</div><!-- /#ads_block -->

			<div id="tabs_carousel" class="panel electro_options_panel">
				
				<div class="options_group">
				<?php 
					electro_wp_text_input( array( 
						'id'			=> '_home_v2_pct_product_limit', 
						'label' 		=>  esc_html__( 'Products Limit', 'electro' ),
						'placeholder' 	=> esc_html__( 'Enter the number of products to show', 'electro' ),
						'name'			=> '_home_v2[pct][product_limit]',
						'class'			=> 'product_limit',
						'size'			=> 2,
						'value'			=> isset( $home_v2['pct']['product_limit'] ) ? $home_v2['pct']['product_limit'] : 6,
					) );

					electro_wp_select( array( 
						'id'			=> '_home_v2_pct_product_columns', 
						'label' 		=>  esc_html__( 'Columns', 'electro' ),
						'options'		=> array(
							'2'	=> '2',
							'3'	=> '3',
							'4'	=> '4',
						),
						'class'			=> 'columns_select',
						'default'		=> '3',
						'name'			=> '_home_v2[pct][product_columns]',
						'value'			=> isset( $home_v2['pct']['product_columns'] ) ? $home_v2['pct']['product_columns'] : 3,
					) );
				?>
				</div>

				<div class="options_group">
				<?php	
					electro_wp_text_input( array( 
						'id'			=> '_home_v2_pct_tabs_1_title', 
						'label' 		=> esc_html__( 'Tab #1 Title', 'electro' ),
						'placeholder' 	=> esc_html__( 'Featured', 'electro' ),
						'name'			=> '_home_v2[pct][tabs][0][title]',
						'value'			=> isset( $home_v2['pct']['tabs'][0]['title'] ) ? $home_v2['pct']['tabs'][0]['title'] : esc_html__( 'Featured', 'electro' ),
					) );

					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v2_pct_tabs_1_content',
						'label'			=> esc_html__( 'Tab #1 Content', 'electro' ),
						'default'		=> 'featured_products',
						'name'			=> '_home_v2[pct][tabs][0][content]',
						'value'			=> isset( $home_v2['pct']['tabs'][0]['content'] ) ? $home_v2['pct']['tabs'][0]['content'] : '',
					) );
				?>
				</div>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id'			=> '_home_v2_pct_tabs_2_title', 
						'label' 		=> esc_html__( 'Tab #2 Title', 'electro' ),
						'placeholder' 	=> esc_html__( 'On Sale', 'electro' ),
						'name'			=> '_home_v2[pct][tabs][1][title]',
						'value'			=> isset( $home_v2['pct']['tabs'][1]['title'] ) ? $home_v2['pct']['tabs'][1]['title'] : esc_html__( 'On Sale', 'electro' ),
					) );

					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v2_pct_tabs_2_content',
						'label'			=> esc_html__( 'Tab #2 Content', 'electro' ),
						'default'		=> 'sale_products',
						'name'			=> '_home_v2[pct][tabs][1][content]',
						'value'			=> isset( $home_v2['pct']['tabs'][1]['content'] ) ? $home_v2['pct']['tabs'][1]['content'] : '',
					) );
				?>
				</div>

				<div class="options_group">
				<?php
					electro_wp_text_input( array( 
						'id'			=> '_home_v2_pct_tabs_3_title', 
						'label' 		=> esc_html__( 'Tab #3 Title', 'electro' ),
						'placeholder' 	=> esc_html__( 'Top Rated', 'electro' ),
						'name'			=> '_home_v2[pct][tabs][2][title]',
						'value'			=> isset( $home_v2['pct']['tabs'][2]['title'] ) ? $home_v2['pct']['tabs'][2]['title'] : esc_html__( 'Top Rated', 'electro' ),
					) );
					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v2_pct_tabs_3_content',
						'label'			=> esc_html__( 'Tab #3 Content', 'electro' ),
						'default'		=> 'top_rated_products',
						'name'			=> '_home_v2[pct][tabs][2][content]',
						'value'			=> isset( $home_v2['pct']['tabs'][2]['content'] ) ? $home_v2['pct']['tabs'][2]['content'] : '',
					) );
				?>
				</div>
			</div>
			
			<div id="deals_carousel" class="panel electro_options_panel">
				
				<div class="options_group">
				<?php

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_dow_block_title', 
						'label' 		=> esc_html__( 'Deal Block Title', 'electro' ), 
						'placeholder' 	=> __( 'Special Offer', 'electro' ),
						'name'			=> '_home_v2[dow][title]',
						'value'			=> isset( $home_v2['dow']['title'] ) ? $home_v2['dow']['title'] : esc_html__( 'Special Offer', 'electro' ),
					) );

					electro_wp_text_input( array( 
						'id' 			=> '_home_v2_dow_product_limit', 
						'label' 		=> esc_html__( 'Products Limit', 'electro' ), 
						'placeholder' 	=> 4,
						'name'			=> '_home_v2[dow][product_limit]',
						'value'			=> isset( $home_v2['dow']['product_limit'] ) ? $home_v2['dow']['product_limit'] : 4,
					) );

					electro_wp_select( array(
						'id'			=> '_home_v2_dow_product_choice',
						'label'			=> esc_html__( 'Product Choice', 'electro' ),
						'options'		=> array(
							'random'	=> esc_html__( 'Random On Sale Products', 'electro' ),
							'recent'	=> esc_html__( 'Recent On Sale Products', 'electro' ),
							'specific'	=> esc_html__( 'Specify by IDs', 'electro' ),
						),
						'class'			=> 'show_hide_select',
						'name'			=> '_home_v2[dow][product_choice]',
						'value'			=> isset( $home_v2['dow']['product_choice'] ) ? $home_v2['dow']['product_choice'] : 'random',
					) );
					
					electro_wp_text_input( array( 
						'id'			=> '_home_v2_dow_product_ids', 
						'label' 		=>  esc_html__( 'Deal Product IDs', 'electro' ),
						'name'			=> '_home_v2[dow][product_ids]',
						'wrapper_class'	=> 'show_if_specific hide',
						'value'			=> isset( $home_v2['dow']['product_ids'] ) ? $home_v2['dow']['product_ids'] : '',
						'placeholder'	=> esc_html__( 'Enter product IDs separated by comma', 'electro' ),
					) );	
				?>
				</div>				
			</div><!-- /#deals_and_tabs_data -->

			<div id="products_cards_carousel" class="panel electro_options_panel">
				
				<div class="options_group">
				<?php
					electro_wp_text_input( array(
						'id'			=> '_home_v2_pcc_section_title',
						'label'			=> esc_html__( 'Section Title', 'electro' ),
						'name'			=> '_home_v2[pcc][section_title]',
						'default'		=> esc_html__( 'Best Sellers', 'electro' ),
						'value'			=> isset( $home_v2['pcc']['section_title'] ) ? $home_v2['pcc']['section_title'] : esc_html__( 'Best Sellers', 'electro' ),
						'placeholder'	=> esc_html__( 'Best Sellers', 'electro' )
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v2_pcc_product_limit',
						'label'			=> esc_html__( 'Product Limit', 'electro' ),
						'name'			=> '_home_v2[pcc][product_limit]',
						'value'			=> isset( $home_v2['pcc']['product_limit'] ) ? $home_v2['pcc']['product_limit'] : 20,
						'placeholder'	=> esc_html__( 'Enter number of products to show', 'electro' ),
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v2_pcc_product_rows',
						'label'			=> esc_html__( 'Rows', 'electro' ),
						'name'			=> '_home_v2[pcc][product_rows]',
						'value'			=> isset( $home_v2['pcc']['product_rows'] ) ? $home_v2['pcc']['product_rows'] : 2,
						'placeholder'	=> esc_html__( 'Enter number of rows to display', 'electro' ),
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v2_pcc_product_columns',
						'label'			=> esc_html__( 'Columns', 'electro' ),
						'name'			=> '_home_v2[pcc][product_columns]',
						'value'			=> isset( $home_v2['pcc']['product_columns'] ) ? $home_v2['pcc']['product_columns'] : 3,
						'placeholder'	=> esc_html__( 'Enter number of products to show', 'electro' ),
					) );
					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v2_pcc_content',
						'label'			=> esc_html__( 'Products', 'electro' ),
						'default'		=> 'best_selling_products',
						'name'			=> '_home_v2[pcc][content]',
						'value'			=> isset( $home_v2['pcc']['content'] ) ? $home_v2['pcc']['content'] : ''
					) );
				?>
				</div>
				<div class="options_group">
				<?php
					electro_wp_text_input( array(
						'id'			=> '_home_v2_pcc_cat_limit',
						'label'			=> esc_html__( 'Categories Limit', 'electro' ),
						'name'			=> '_home_v2[pcc][cat_limit]',
						'default'		=> 3,
						'value'			=> isset( $home_v2['pcc']['cat_limit'] ) ? $home_v2['pcc']['cat_limit'] : 3,
						'placeholder'	=> 3
					) );

					electro_wp_text_input( array(
						'id'			=> '_home_v2_pcc_cat_slugs',
						'label'			=> esc_html__( 'Category Slug', 'electro' ),
						'name'			=> '_home_v2[pcc][cat_slugs]',
						'default'		=> '',
						'value'			=> isset( $home_v2['pcc']['cat_slugs'] ) ? $home_v2['pcc']['cat_slugs'] : '',
						'placeholder'	=> esc_html__( 'Enter category slugs separated by comma', 'electro' )
					) );
				?>
				</div>
			</div><!-- /#products_cards_carousel -->
			
			<div id="banner_data" class="panel electro_options_panel">
			
				<div class="options_group">
				<?php 
					electro_wp_upload_image( array(
						'id'			=> '_home_v2_bd_image',
						'label'			=> esc_html__( 'Banner Image', 'electro' ),
						'name'			=> '_home_v2[bd][image]',
						'value'			=> isset( $home_v2['bd']['image'] ) ? $home_v2['bd']['image'] : '',
					) );
					
					electro_wp_text_input( array(
						'id'			=> '_home_v2_bd_link',
						'label'			=> esc_html__( 'Link', 'electro' ),
						'name'			=> '_home_v2[bd][link]',
						'value'			=> isset( $home_v2['bd']['link'] ) ? $home_v2['bd']['link'] : '#',
					) );
				?>
				</div>
			</div><!-- /#banner_data -->
			
			<div id="products_carousel" class="panel electro_options_panel">
				<div class="options_group">
				<?php
					electro_wp_text_input( array(
						'id'			=> '_home_v2_pc_section_title',
						'label'			=> esc_html__( 'Section Title', 'electro' ),
						'name'			=> '_home_v2[pc][section_title]',
						'value'			=> isset( $home_v2['pc']['section_title'] ) ? $home_v2['pc']['section_title'] : esc_html__( 'Recently Added', 'electro' ),
					) );

					electro_wp_text_input( array(
						'id'			=> '_home_v2_pc_product_limit',
						'label'			=> esc_html__( 'Limit', 'electro' ),
						'name'			=> '_home_v2[pc][product_limit]',
						'value'			=> isset( $home_v2['pc']['product_limit'] ) ? $home_v2['pc']['product_limit'] : 20,
					) );
					electro_wp_text_input( array(
						'id'			=> '_home_v2_pc_product_columns',
						'label'			=> esc_html__( 'Columns', 'electro' ),
						'name'			=> '_home_v2[pc][product_columns]',
						'value'			=> isset( $home_v2['pc']['product_columns'] ) ? $home_v2['pc']['product_columns'] : 5,
					) );

					electro_wp_wc_shortcode( array( 
						'id' 			=> '_home_v2_pc_content',
						'label'			=> esc_html__( 'Products', 'electro' ),
						'default'		=> 'recent_products',
						'name'			=> '_home_v2[pc][content]',
						'value'			=> isset( $home_v2['pc']['content'] ) ? $home_v2['pc']['content'] : '',
					) );
				?>
				</div>
			</div>
		</div>
		<?php
	}

	public static function save( $post_id, $post ) {
		if ( isset( $_POST['_home_v2'] ) ) {
			$clean_home_v2_options = electro_clean_kses_post( $_POST['_home_v2'] );
			update_post_meta( $post_id, '_home_v2_options',  addslashes( json_encode( $clean_home_v2_options ) ) );
		}	
	}
}