<?php
/**
 * Order Data
 *
 * Displays the order data box.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Multistore_Meta_Box_Order_Data Class.
 */
class WC_Multistore_Meta_Box_Order_Data {

	protected $sites;

	protected $settings;

	protected $child_fields;

	protected $master_fields;

	public function __construct(){
		$this->sites = WOO_MULTISTORE()->active_sites;
		$this->settings = WOO_MULTISTORE()->settings;
		if( ! wc_multistore_min_user_role() ){ return; }
		if( ! WOO_MULTISTORE()->license->is_active() ){ return; }
		if( ! WOO_MULTISTORE()->setup->is_complete ){ return; }
		if( ! WOO_MULTISTORE()->data->is_up_to_date ){ return; }
		if( WOO_MULTISTORE()->site->get_type() != 'master' ){ return; }

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
	}


	public function add_meta_boxes( $wc_screen_id, $wc_order ) {
		$screen_id = wc_get_page_screen_id( 'shop-order' );

		if ( $wc_screen_id != $screen_id ) {
			return;
		}

		// Add order origin meta box
		add_meta_box(
			'woo_multistore_order_origin',
			__( 'Woo Multistore Order Origin', 'woonet' ),
			array( $this, 'order_origin_box' ),
			$screen_id,
			'side',
			'core'
		);
	}

	public function order_origin_box( $post_or_order_object ){
		require_once WOO_MSTORE_SINGLE_INCLUDES_PATH.'admin/meta-boxes/views/html-order-data-master.php';
	}

}