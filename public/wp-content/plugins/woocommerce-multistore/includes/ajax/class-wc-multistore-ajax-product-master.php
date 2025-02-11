<?php
/**
 * Ajax product master handler.
 *
 * This handles ajax product master related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Ajax_Product_Master
 */
class WC_Multistore_Ajax_Product_Master {
	function __construct() {
		if ( ! defined( 'DOING_AJAX' ) ) { return; }

		add_action( 'wp_ajax_wc_multistore_inline_save_ajax', array( $this, 'wc_multistore_inline_save_ajax' ) );
		add_action( 'wp_ajax_wc_multistore_cancel_inline_save_ajax', array( $this, 'wc_multistore_cancel_inline_save_ajax' ) );
		add_action( 'wp_ajax_wc_multistore_inline_save_background', array( $this, 'wc_multistore_inline_save_background' ) );

		add_action( 'wp_ajax_wc_multistore_ajax_sync', array( $this, 'wc_multistore_ajax_sync' ) );
		add_action( 'wp_ajax_wc_multistore_cancel_ajax_sync', array( $this, 'wc_multistore_cancel_ajax_sync' ) );

		add_action( 'wp_ajax_wc_multistore_ajax_trash', array( $this, 'wc_multistore_ajax_trash' ) );
		add_action( 'wp_ajax_wc_multistore_cancel_ajax_trash', array( $this, 'wc_multistore_cancel_ajax_trash' ) );

		add_action( 'wp_ajax_wc_multistore_ajax_untrash', array( $this, 'wc_multistore_ajax_untrash' ) );
		add_action( 'wp_ajax_wc_multistore_cancel_ajax_untrash', array( $this, 'wc_multistore_cancel_ajax_untrash' ) );

		add_action( 'wp_ajax_wc_multistore_ajax_delete', array( $this, 'wc_multistore_ajax_delete' ) );
		add_action( 'wp_ajax_wc_multistore_cancel_ajax_delete', array( $this, 'wc_multistore_cancel_ajax_delete' ) );

		add_action( 'wp_ajax_wc_multistore_set_bulk_sync_params', array( $this, 'wc_multistore_set_bulk_sync_params' ) );
		add_action( 'wp_ajax_wc_multistore_get_next_bulk_sync_product', array( $this, 'wc_multistore_get_next_bulk_sync_product' ) );
		add_action( 'wp_ajax_wc_multistore_cancel_bulk_sync', array( $this, 'wc_multistore_cancel_bulk_sync' ) );
		add_action( 'wp_ajax_wc_multistore_product_sync', array( $this, 'wc_multistore_product_sync' ) );
		add_action( 'wp_ajax_wc_multistore_cancel_product_sync', array( $this, 'wc_multistore_cancel_product_sync' ) );

		add_action( 'wp_ajax_nopriv_wc_multistore_delete_sync_data_from_master', array( $this, 'wc_multistore_delete_sync_data_from_master' ) );



		add_action( 'wp_ajax_woosl_setup_get_process_list', array( $this, 'woosl_setup_get_process_list' ) );
		add_action( 'wp_ajax_woosl_setup_process_batch', array( $this, 'woosl_setup_process_batch' ) );

	}


	public function wc_multistore_inline_save_ajax(){
		if ( empty( $_POST['sku'] ) && WOO_MULTISTORE()->settings['sync-by-sku'] == 'yes' ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Product is missing sku while sync by sku is enabled'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_inline_save_ajax' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		if( isset( $_REQUEST['post_ID'] ) ){
			$product = array(
				'post_ID' => 	$_REQUEST['post_ID'],
				'total_sites' => $_REQUEST['total_sites'],
				'selected_sites' => $_REQUEST['selected_sites']
			);
			$transient = 'wc_multistore_quick_edit_ajax_save' . uniqid();
			set_site_transient($transient, $product, 4 * HOUR_IN_SECONDS );

			if( $product['selected_sites'] > 0 ){
				$wc_product = wc_get_product($product['post_ID']);
				$current_site_id = $product['selected_sites'][0];
				$classname = wc_multistore_get_product_class_name( 'master', $wc_product->get_type() );
				$wc_multistore_master_product = new $classname($wc_product);
				$response = $wc_multistore_master_product->sync_to($product['selected_sites'][0]);

				if(empty($response)){
					$response = array(
						'status' => 'failed',
						'message' => 'failed',
						'code' => '500',
					);
				}

				unset($product['selected_sites'][0]);
				$product['selected_sites'] = array_values($product['selected_sites']);

				set_site_transient($transient, $product, 4 * HOUR_IN_SECONDS );

				if( empty( $product['selected_sites'] ) ){
					delete_site_transient($transient );

					$data = array(
						'status' => 'completed',
						'site_id' => $current_site_id,
						'result' => $response,
						'transient' => $transient,
					);
					echo wp_json_encode($data);
					wp_die();
				}else{
					$data = array(
						'status' => 'pending',
						'site_id' => $current_site_id,
						'result' => $response,
						'transient' => $transient,
						'progress' => ($product['total_sites'] - count($product['selected_sites']) ) / $product['total_sites']  * 100
					);
					echo wp_json_encode($data);
					wp_die();
				}
			}
		}else{
			$product = get_site_transient($_REQUEST['transient']);

			if( $product['selected_sites'] > 0 ){
				$wc_product = wc_get_product($product['post_ID']);
				$current_site_id = $product['selected_sites'][0];
				$classname = wc_multistore_get_product_class_name( 'master', $wc_product->get_type() );
				$wc_multistore_master_product = new $classname($wc_product);
				$response =  $wc_multistore_master_product->sync_to($product['selected_sites'][0]);

				if( empty($response) ){
					$response = array(
						'status' => 'failed',
						'message' => 'failed',
						'code' => '500',
					);
				}

				unset($product['selected_sites'][0]);
				$product['selected_sites'] = array_values($product['selected_sites']);

				set_site_transient($_REQUEST['transient'], $product, 4 * HOUR_IN_SECONDS );

				if(empty($product['selected_sites'])){
					delete_site_transient($_REQUEST['transient'] );

					$data = array(
						'status' => 'completed',
						'site_id' => $current_site_id,
						'result' => $response,
						'transient' => $_REQUEST['transient']
					);
					echo wp_json_encode($data);
					wp_die();
				}else{
					$data = array(
						'status' => 'pending',
						'site_id' => $current_site_id,
						'result' => $response,
						'transient' => $_REQUEST['transient'],
						'progress' => ($product['total_sites'] - count($product['selected_sites']) ) / $product['total_sites']  * 100
					);
					echo wp_json_encode($data);
					wp_die();
				}
			}else{
				delete_site_transient($_REQUEST['transient'] );

				$data = array(
					'status' => 'completed',
				);
				echo wp_json_encode($data);
				wp_die();
			}
		}
	}

	public function wc_multistore_cancel_inline_save_ajax(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_inline_save_ajax' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		delete_transient( $_REQUEST['transient']);
		echo wp_json_encode('success');
		wp_die();
	}

	public function wc_multistore_inline_save_background(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_inline_save_background' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		if( WOO_MULTISTORE()->settings['sync-method'] == 'background' ){
			$product_id = $_REQUEST['post_ID'];
			$wc_product = wc_get_product($product_id);

			$classname = wc_multistore_get_product_class_name( 'master', $wc_product->get_type() );
			$wc_multistore_master_product = new $classname($wc_product);
			$wc_multistore_master_product->set_scheduler('wc_multistore_scheduled_products');

			$data = array(
				'result' => 'completed'
			);
			echo wp_json_encode($data);
			wp_die();
		}
	}

	public function wc_multistore_ajax_sync(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_ajax_sync' ) ) {
			delete_transient( $_REQUEST['transient']);
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		$products = get_transient( $_REQUEST['transient'] );

		if( empty( $products ) ){
			$data = array(
				'status' => 'completed'
			);

			delete_transient( $_REQUEST['transient']);

			echo wp_json_encode($data);
			wp_die();
		}

		foreach ( $products as $product_id => $product ){

			if ( class_exists( 'SitePress' ) ) {
				if (!empty($product['language']) && !empty($product['language']['language_code'])){
					do_action( 'wpml_switch_language', $product['language']['language_code'] );
				}
			}

			if( empty( $product['sites'] ) ){
				$data = array(
					'status' => 'completed'
				);

				delete_transient( $_REQUEST['transient']);

				echo wp_json_encode($data);
				wp_die();
			}

			$sites = $product['sites'];
			$total_sites = count($sites);
			$wc_product = wc_get_product($product_id);

			$classname = wc_multistore_get_product_class_name( 'master', $wc_product->get_type() );
			$wc_multistore_master_product = new $classname($wc_product);

			foreach ( $sites as $key => $site_id ){
				$response = $wc_multistore_master_product->sync_to($site_id);

				$data = array(
					'product_id' => $product_id,
					'status' => 'success',
					'site_id' => $site_id,
					'percentage' => 1 / $total_sites * 100,
					'result' => $response
				);

				unset($products[$product_id]['sites'][$key]);

				if( empty($products[$product_id]['sites']) ){
					unset($products[$product_id]);
				}

				set_transient( $_REQUEST['transient'], $products, 4 * HOUR_IN_SECONDS );

				echo wp_json_encode($data);

				wp_die();
			}
		}
	}

	public function wc_multistore_cancel_ajax_sync(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_ajax_sync' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}


		delete_transient( $_REQUEST['transient']);
		echo wp_json_encode('success');
		wp_die();
	}

	public function wc_multistore_ajax_trash(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_ajax_trash' ) ) {
			delete_transient( $_REQUEST['transient']);
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		$products = get_transient( $_REQUEST['transient'] );

		if( empty( $products ) ){
			$data = array(
				'status' => 'completed'
			);

			delete_transient( $_REQUEST['transient']);

			echo wp_json_encode($data);
			wp_die();
		}

		foreach ( $products as $product_id => $product ){

			if( empty( $product['sites'] ) ){
				$data = array(
					'status' => 'completed'
				);

				delete_transient( $_REQUEST['transient']);

				echo wp_json_encode($data);
				wp_die();
			}

			$sites = $product['sites'];
			$total_sites = count($sites);
			foreach ( $sites as $key => $site_id ){
				$wc_product = wc_get_product($product_id);
				$classname = wc_multistore_get_product_class_name( 'master', $wc_product->get_type() );
				$wc_multistore_master_product = new $classname($wc_product);

				$response = $wc_multistore_master_product->trash_to($site_id);

				$data = array(
					'product_id' => $product_id,
					'status' => 'success',
					'percentage' => 1 / $total_sites * 100,
					'result' => $response
				);

				unset($products[$product_id]['sites'][$key]);

				if( empty($products[$product_id]['sites']) ){
					unset($products[$product_id]);
				}

				set_transient( $_REQUEST['transient'], $products, 4 * HOUR_IN_SECONDS );

				echo wp_json_encode($data);

				wp_die();
			}
		}
	}

	public function wc_multistore_cancel_ajax_trash(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_ajax_sync' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		delete_transient( $_REQUEST['transient']);
		echo wp_json_encode('success');
		wp_die();
	}

	public function wc_multistore_ajax_untrash(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_ajax_untrash' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		$products = get_transient( $_REQUEST['transient'] );

		if( empty( $products ) ){
			$data = array(
				'status' => 'completed'
			);

			delete_transient( $_REQUEST['transient']);

			echo wp_json_encode($data);
			wp_die();
		}

		foreach ( $products as $product_id => $product ){

			if( empty( $product['sites'] ) ){
				$data = array(
					'status' => 'completed'
				);

				delete_transient( $_REQUEST['transient']);

				echo wp_json_encode($data);
				wp_die();
			}

			$sites = $product['sites'];
			$total_sites = count($sites);
			foreach ( $sites as $key => $site_id ){
				$wc_product = wc_get_product($product_id);
				$classname = wc_multistore_get_product_class_name( 'master', $wc_product->get_type() );
				$wc_multistore_master_product = new $classname($wc_product);

				$response = $wc_multistore_master_product->untrash_to($site_id);

				$data = array(
					'product_id' => $product_id,
					'status' => 'success',
					'percentage' => 1 / $total_sites * 100,
					'result' => $response
				);

				unset($products[$product_id]['sites'][$key]);

				if( empty($products[$product_id]['sites']) ){
					unset($products[$product_id]);
				}

				set_transient( $_REQUEST['transient'], $products, 4 * HOUR_IN_SECONDS );

				echo wp_json_encode($data);

				wp_die();
			}
		}
	}

	public function wc_multistore_cancel_ajax_untrash(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_ajax_sync' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		delete_transient( $_REQUEST['transient']);
		echo wp_json_encode('success');
		wp_die();
	}

	public function wc_multistore_ajax_delete(){
		$products = get_transient( $_REQUEST['transient'] );

		if( empty( $products ) ){
			$data = array(
				'status' => 'completed'
			);

			delete_transient( $_REQUEST['transient']);

			echo wp_json_encode($data);
			wp_die();
		}

		foreach ( $products as $product_id => $product ){

			if( empty( $product['sites'] ) ){
				$data = array(
					'status' => 'completed'
				);

				delete_transient( $_REQUEST['transient']);

				echo wp_json_encode($data);
				wp_die();
			}

			$sites = $product['sites'];
			$total_sites = count($sites);
			foreach ( $sites as $key => $site_id ){
				if( is_multisite() ) {
					switch_to_blog( $site_id );
					$child_id = wc_multistore_product_get_slave_product_id($product_id, $product['sku'], $product['language']);
					$wc_product = wc_get_product($child_id);
					if( $wc_product ){
						$classname = wc_multistore_get_product_class_name( 'child', $wc_product->get_type() );
						$wc_multistore_child_product = new $classname($wc_product);
						$response = $wc_multistore_child_product->delete();
					}
					restore_current_blog();
				}else{
					$args = array(
						'product_id' => $product_id,
						'product_sku' => $product['sku'],
						'language' => $product['language'],
					);
					$wc_multistore_product_api_master = new WC_Multistore_Product_Api_Master();
					$response = $wc_multistore_product_api_master->send_delete_product_data_to_child($args, $site_id);
				}

				$data = array(
					'product_id' => $product_id,
					'status' => 'success',
					'percentage' => 1 / $total_sites * 100,
					'result' => $response
				);

				unset($products[$product_id]['sites'][$key]);

				if( empty($products[$product_id]['sites']) ){
					unset($products[$product_id]);
				}

				set_transient( $_REQUEST['transient'], $products, 4 * HOUR_IN_SECONDS );

				echo wp_json_encode($data);

				wp_die();
			}
		}
	}

	public function wc_multistore_cancel_ajax_delete(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc_multistore_ajax_sync' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		delete_transient( $_REQUEST['transient']);
		echo wp_json_encode('success');
		wp_die();
	}

	/**
	 * Begins a bulk sync
	 * Parameters: nonce, selected product ids, product settings
	 * Returns: bulk sync id
	 */
	public function wc_multistore_set_bulk_sync_params(){
		if ( empty($_POST['data']) ){
			$res = array(
				'status' => 'failed',
				'message' => 'empty request - 404'
			);
			echo wp_json_encode($res);
			wp_die();
		}

		$serialized_data = $_POST['data'];
		$data = array();
		parse_str(wp_unslash($serialized_data), $data);


		if ( ! isset( $data['wc-multistore-bulk-sync-nonce'] ) || ! wp_verify_nonce( $data['wc-multistore-bulk-sync-nonce'], 'wc-multistore-bulk-sync-nonce' ) ) {
			$res = array(
				'status' => 'failed',
				'message' => 'insufficient permissions - 403'
			);
			echo wp_json_encode($res);
			wp_die();
		}

		$query = new WP_Query();
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if(is_multisite()){
			switch_to_blog( (int) get_site_option('wc_multistore_master_store') );
		}
		// we can proceed with sync
		if ( ! empty( $data['select-all-products'] ) ) {
			$products = $query->query(
				array(
					'fields'         => 'ids',
					'posts_per_page' => -1,
					'post_type'      => 'product',
					'meta_query'      => array(
						array(
							'key' => '_woonet_is_clone',
							'compare' => 'NOT EXISTS'
						),
					),
				)
			);
		} else {
			$args = array(
				'fields'         => 'ids',
				'posts_per_page' => -1,
				'post_type'      => 'product',
				'tax_query'      => array(
					'relation' => 'AND'
				),
				'meta_query'      => array(
					array(
						'key' => '_woonet_is_clone',
						'compare' => 'NOT EXISTS'
					),
				),
			);

			// post_types
			if( ! empty( $data['select_product_types'] ) ){
				$args['tax_query'][] =array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => $data['select_product_types'],
					'operator' => 'IN',
				);
			}

			// categories
			if( ! empty( $data['select_categories'] ) ){
				$args['tax_query'][] =array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $data['select_categories'],
				);
			}

			// attributes
			if( ! empty( $attribute_taxonomies ) ){
				foreach ( $attribute_taxonomies as $attribute_taxonomy ){
					$attribute_input = "bulk_sync_pa_" . $attribute_taxonomy->attribute_name;
					if( ! empty( $data[$attribute_input] ) ){
						$args['tax_query'][] = array(
							'taxonomy' => 'pa_'.$attribute_taxonomy->attribute_name,
							'field'    => 'term_id',
							'terms'    => $data[$attribute_input],
						);
					}
				}
			}

			$products = $query->query($args);
		}

		if ( empty( $products ) ){
			echo json_encode(
				array(
					'status'   => 'skipped',
					'message'   => 'Sync skipped, no products found matching the criteria',
				)
			);
			die;
		}

		$transient_id = uniqid();
		$transient_id = 'wc_multistore_bulk_sync_'.$transient_id;
		$settings = $data;

		$transient_data = array(
			'settings' => $settings,
			'products' => $products
		);


		if ( empty( $settings['use-product-settings'] ) && empty( $settings['select_child_sites'] ) ){
			echo json_encode(
				array(
					'status'   => 'skipped',
					'message'   => 'Sync skipped, please select at least one child store',
				)
			);
			die;
		}

		$res = set_site_transient( $transient_id, $transient_data, 60 * 60 * 24 );

		echo json_encode(
			array(
				'status'   => 'success',
				'id' => $transient_id,
				'res' => $res,
				'total_products' => count($products)
			)
		);
		die;

    }

	/**
	 * Cancels a running bulk sync
	 * Parameters: nonce, bulk sync id
	 */
	public function wc_multistore_cancel_bulk_sync(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc-multistore-bulk-sync-nonce' ) ) {
			$res = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($res);
			wp_die();
		}

		$bulk_sync_id = $_POST['bulk_sync_id'];

		if ( is_multisite() ) {
			$get_site_ids    = get_sites();
			$current_blog_id = get_current_blog_id();

			// loop through the blog IDs and delete transient from each
			foreach ( $get_site_ids as $id ) {
				switch_to_blog( $id->blog_id );
				delete_site_transient($bulk_sync_id);
			}

			// switch to the original blog ID
			switch_to_blog( $current_blog_id );

		} else {
			delete_site_transient($bulk_sync_id);
		}

		die;
	}


	/**
	 * Gets next bulk sync product
	 * Parameters: nonce, bulk_sync_id
	 * Returns: array() with status, product id, product_img, bulk_sync_id
	 */
	public function wc_multistore_get_next_bulk_sync_product(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc-multistore-bulk-sync-nonce' ) ) {
			$res = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($res);
			wp_die();
		}

		sleep(1);

		if( is_multisite() ){
			switch_to_blog( (int) get_site_option('wc_multistore_master_store') );
		}

		$transient_id = $_POST['bulk_sync_id'];
		$data = get_site_transient( $transient_id );

		// complete bulk sync if no products
		if( empty($data) || empty($data['products'])){
			$result = array(
				'status' => 'complete',
				'bulk_sync_id' => $transient_id,
			);

			echo wp_json_encode( $result );
			wp_die();
		}

		$products = $data['products'];
		$settings = $data['settings'];
		$current_product_id = array_shift( $products );
		$product = wc_get_product($current_product_id);
		$classname = wc_multistore_get_product_class_name('master', $product->get_type() );
		$remaining = (int) count( $products );
		$next = current($products);
		$data['products'] = $products;

		// update bulk sync data
		if ( empty( $data['products'] ) ){
			delete_site_transient($transient_id);
		}else{
			set_site_transient( $transient_id, $data, 60 * 60 * 24 );
		}

		// skip if product is not supported
		if ( ! $classname ){
			$result = array(
				'status' => 'skipped',
				'product_id' => $current_product_id,
				'product_img' => ( !empty( $product->get_image_id('edit') ) ) ? wp_get_attachment_url($product->get_image_id('edit')) : esc_url( wc_placeholder_img_src() ),
				'product_name' => $product->get_name(),
				'remaining' => $remaining,
				'next' => $next,
				'bulk_sync_id' => $transient_id,
				'message' => 'Product type is not supported'
			);

			echo wp_json_encode( $result );
			wp_die();
		}

		// set product settings
		$sites_ids = array();
		if ( ! isset( $settings['use-product-settings'] ) ){
			foreach ( $settings['select_child_sites'] as $site_id ) {
				$_REQUEST[ '_woonet_publish_to_' . $site_id ]                   = 'yes';
				$_REQUEST[ '_woonet_publish_to_' . $site_id . '_child_inheir' ] = ! empty( $settings['child-sync'] ) ? $settings['child-sync'] : 'no';
				$_REQUEST[ '_woonet_' . $site_id . '_child_stock_synchronize' ] = ! empty( $settings['stock-sync'] ) ? $settings['stock-sync'] : 'no';
				$sites_ids[] = $site_id;
			}
		}

		// save settings
		$wc_multistore_master_product = new $classname( $product );
		$wc_multistore_master_product->save();

		// skip if not supposed to sync
		if ( ! $wc_multistore_master_product->is_enabled_sync){
			$result = array(
				'status' => 'skipped',
				'product_id' => $current_product_id,
				'product_img' => ( !empty( $product->get_image_id('edit') ) ) ? wp_get_attachment_url($product->get_image_id('edit')) : esc_url( wc_placeholder_img_src() ),
				'product_name' => $product->get_name(),
				'remaining' => $remaining,
				'next' => $next,
				'bulk_sync_id' => $transient_id,
				'message' => 'Product has publish settings disabled'
			);

			echo wp_json_encode( $result );
			wp_die();
		}

		// return success data
		$result = array(
			'status' => 'success',
			'product_id' => $current_product_id,
			'product_img' => ( !empty( $product->get_image_id('edit') ) ) ? wp_get_attachment_url($product->get_image_id('edit')) : esc_url( wc_placeholder_img_src() ),
			'product_name' => $product->get_name(),
			'sites_ids' => $sites_ids,
			'remaining' => $remaining,
			'next' => $next,
			'bulk_sync_id' => $transient_id,
		);

		echo wp_json_encode( $result );
		wp_die();
	}

	/**
	 * Syncs a product to child stores
	 * Parameters: nonce, product id, ids of sites to sync(optional), product_sync_id(if status is pending)
	 * Returns: array() with status, product id, product sync id, result
	 */
	public function wc_multistore_product_sync(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc-multistore-product-sync-nonce' ) ) {
			$res = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($res);
			wp_die();
		}

		if( is_multisite() ){
			switch_to_blog( (int) get_site_option('wc_multistore_master_store') );
		}

		// start new sync
		if ( ! $_POST['product_sync_id'] ){
			$product_sync_id = 'wc_multistore_product_sync_'.uniqid();
			$product_id = $_POST['id'];
			$total_sites = ( isset( $_POST['sites_ids'] ) && !empty( $_POST['sites_ids'] ) ) ? count($_POST['sites_ids']) : 0;
			$sites_ids = ( isset( $_POST['sites_ids'] ) && !empty( $_POST['sites_ids'] ) ) ? $_POST['sites_ids'] : array();
			$percentage = 0;
			$finished_sites = 0;

			$product = wc_get_product($product_id);
			$classname = wc_multistore_get_product_class_name('master', $product->get_type() );
			$wc_multistore_master_product = new $classname( $product );

			if (empty($sites_ids)){
				foreach ( WOO_MULTISTORE()->active_sites as $site ){
					if( $wc_multistore_master_product->should_publish_to( $site->get_id() ) ){
						$total_sites++;
						$sites_ids[] = $site->get_id();
					}
				}
			}

			$site_id = array_shift($sites_ids);
			$result = $wc_multistore_master_product->sync_to($site_id);
			$finished_sites++;
			$percentage = ($finished_sites / $total_sites) * 100;

			if ( $finished_sites < $total_sites){
				$product_sync_data = array(
					'product_id' => $product_id,
					'total_sites' => $total_sites,
					'sites_ids' => $sites_ids,
					'percentage' => $percentage,
					'finished_sites' => $finished_sites,
				);

				update_site_option($product_sync_id, $product_sync_data);

				$response = array(
					'status' => 'pending',
					'product_id' => $product_id,
					'percentage' => $percentage,
					'product_sync_id' => $product_sync_id,
					'result' => $result,
				);

				echo wp_json_encode( $response );
				wp_die();
			}

			if ( $finished_sites == $total_sites){
				delete_site_option($product_sync_id);

				$response = array(
					'status' => 'complete',
					'product_id' => $product_id,
					'percentage' => $percentage,
					'product_sync_id' => $product_sync_id,
					'result' => $result,
				);

				echo wp_json_encode( $response );
				wp_die();
			}
		}else{
			$product_sync_id = $_POST['product_sync_id'];
			$product_sync_data = get_site_option( $product_sync_id );
			$product_id = $product_sync_data['product_id'];
			$total_sites = $product_sync_data['total_sites'];
			$sites_ids = $product_sync_data['sites_ids'];
			$percentage = $product_sync_data['percentage'];
			$finished_sites = $product_sync_data['finished_sites'];

			$product = wc_get_product($product_id);
			$classname = wc_multistore_get_product_class_name('master', $product->get_type() );
			$wc_multistore_master_product = new $classname( $product );
			$site_id = array_shift($sites_ids);
			$result = $wc_multistore_master_product->sync_to($site_id);
			$finished_sites++;
			$percentage = ($finished_sites / $total_sites) * 100;

			if ( $finished_sites < $total_sites){
				$product_sync_data = array(
					'product_id' => $product_id,
					'total_sites' => $total_sites,
					'sites_ids' => $sites_ids,
					'percentage' => $percentage,
					'finished_sites' => $finished_sites,
				);

				update_site_option($product_sync_id, $product_sync_data);

				$response = array(
					'status' => 'pending',
					'product_id' => $product_id,
					'percentage' => $percentage,
					'product_sync_id' => $product_sync_id,
					'result' => $result,
				);

				echo wp_json_encode( $response );
				wp_die();
			}

			if ( $finished_sites == $total_sites){
				delete_site_option($product_sync_id);

				$response = array(
					'status' => 'complete',
					'product_id' => $product_id,
					'percentage' => $percentage,
					'product_sync_id' => $product_sync_id,
					'result' => $result,
				);

				echo wp_json_encode( $response );
				wp_die();
			}
		}
	}

	/**
	 * Cancels a running product sync
	 * Parameters: nonce, product sync id
	 */
	public function wc_multistore_cancel_product_sync(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'wc-multistore-product-sync-nonce' ) ) {
			$res = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($res);
			wp_die();
		}

		$product_sync_id = $_POST['product_sync_id'];

		if ( is_multisite() ) {
			$get_site_ids    = get_sites();
			$current_blog_id = get_current_blog_id();

			// loop through the blog IDs and delete transient from each
			foreach ( $get_site_ids as $id ) {
				switch_to_blog( $id->blog_id );
				delete_site_transient($product_sync_id);
			}

			// switch to the original blog ID
			switch_to_blog( $current_blog_id );

		} else {
			delete_site_transient($product_sync_id);
		}

		die;
	}

	public function wc_multistore_delete_sync_data_from_master(){
		if( empty($_REQUEST['key']) || $_REQUEST['key'] != WOO_MULTISTORE()->sites[$_REQUEST['key']]->get_id() ){
			$result = array(
				'status' => 'failed',
				'message' => 'You do not have sufficient permissions'
			);

			echo wp_json_encode( $result );
			wp_die();
		}

		if(WOO_MULTISTORE()->settings['sync-by-sku'] == 'yes'){
			$master_product_id = wc_get_product_id_by_sku( $_REQUEST['sku'] );
		}else{
			$master_product_id = $_REQUEST['id'];
		}

		$wc_product = wc_get_product($master_product_id);

		$classname = wc_multistore_get_product_class_name('master', $wc_product->get_type());
		$wc_multistore_master_product = new $classname($wc_product);
		$result = $wc_multistore_master_product->delete_sync_data( $_REQUEST['key'] );


		echo wp_json_encode($result);
		wp_die();
	}

}