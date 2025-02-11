<?php
/**
 * Integrates the Divi shop builder Functionalities
 *
 * @since 5.3.6
 */

defined( 'ABSPATH' ) || exit;

class WOO_MSTORE_INTEGRATION_DIVI_SHOP_BUILDER {

	public function __construct() {
		$this->hooks();
	}


	public function hooks() {
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_child_store_scripts' ) );
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_main_store_scripts' ) );
	}

	// syncs stock from checkout on child stores
	public function enqueue_child_store_scripts(){
		if( WOO_MULTISTORE()->site->get_type() != 'child' ){
			return;
		}

		$page_id  = wc_get_page_id('thankyou');

		if( intval( $page_id ) > 0 && empty( $_GET['order_id'] ) || empty( $_GET['key'] ) ){
			return;
		}


		$order_id = $_GET['order_id'];
		$order = wc_get_order($order_id);

		if ( ! $order ){
			return;
		}

		$items = $order->get_items();

		$data = array();
		foreach ($items as $item){
			$wc_product = $item->get_product();

			if( ! $wc_product ){
				continue;
			}

			if( ! wc_multistore_is_child_product( $wc_product ) ){
				continue;
			}

			$classname = wc_multistore_get_product_class_name( 'child', $wc_product->get_type() );

			if( ! $classname ){
				continue;
			}

			$wc_multistore_child_product = new $classname( $wc_product );


			$data[] = $wc_multistore_child_product->get_ajax_stock_data();
		}

		if( empty( $data ) ){
			return;
		}

		wp_register_script('wc-multistore-thank-you-child-js',WOO_MSTORE_ASSET_URL . '/assets/js/wc-multistore-thank-you-child.js',	array( 'jquery' ),	false,true );
		wp_enqueue_script( 'wc-multistore-thank-you-child-js' );
		wp_localize_script(	'wc-multistore-thank-you-child-js','wc_multistore_child_stock_data',array(	'child_products' => $data ) );
	}

	// syncs stock from checkout on main store
	public function enqueue_main_store_scripts(){
		if( WOO_MULTISTORE()->site->get_type() != 'master' ){
			return;
		}

		global $wp;

		$page_id  = wc_get_page_id('thankyou');

		if( intval( $page_id ) > 0 && empty( $_GET['order_id'] ) || empty( $_GET['key'] ) ){
			return;
		}


		$order_id = $_GET['order_id'];
		$order = wc_get_order($order_id);

		if ( ! $order ){
			return;
		}

		$items = $order->get_items();

		$data = array();
		foreach ( $items as $item ){
			$wc_product = $item->get_product();
			if ( ! $wc_product ){
				continue;
			}

			$classname = wc_multistore_get_product_class_name( 'master', $wc_product->get_type() );

			if( ! $classname ){
				continue;
			}

			$wc_multistore_product_master = new $classname( $wc_product );


			$data[] = $wc_multistore_product_master->get_ajax_stock_data();
		}

		if( empty( $data ) ){
			return;
		}

		wp_register_script('wc-multistore-thank-you-master-js',WOO_MSTORE_ASSET_URL . '/assets/js/wc-multistore-thank-you-master.js',	array( 'jquery' ),	false,true );
		wp_enqueue_script( 'wc-multistore-thank-you-master-js' );
		wp_localize_script('wc-multistore-thank-you-master-js','wc_multistore_master_stock_data',array(	'master_products' => $data ) );
	}
}

new WOO_MSTORE_INTEGRATION_DIVI_SHOP_BUILDER();

