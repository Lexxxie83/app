<?php
/**
 * Bulk Sync handler.
 *
 * This handles bulk sync related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Bulk_Sync
 */
class WC_Multistore_Bulk_Sync {

	public function __construct() {
		if( ! WOO_MULTISTORE()->license->is_active() ){ return; }
		if( ! WOO_MULTISTORE()->setup->is_complete ){ return; }
		if( ! WOO_MULTISTORE()->data->is_up_to_date ){ return; }
		if( ! WOO_MULTISTORE()->permission ){ return; }

		$this->hooks();
	}

	public function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'wp_ajax_run_woomulti_bulk_sync', array( $this, 'sync' ) );
		add_action( 'wp_ajax_cancel_woomulti_bulk_sync', array( $this, 'cancel_sync' ) );

		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'add_submenu' ), 16 );
			add_action( 'admin_menu', array( $this, 'add_submenu' ), 16 );
		} elseif ( get_option( 'wc_multistore_network_type' ) == 'master' ) {
			add_action( 'admin_menu', array( $this, 'add_submenu_non_multisite' ), 16 );
		}
		add_action('admin_bar_menu', array( $this, 'add_bar_menu_page' ), 10, 1 );
	}

	public function enqueue_assets() {
		if ( is_admin() ) {
			if ( !isset( $_GET['page'] ) || $_GET['page'] != 'woonet-bulk-sync-products' ){
				return;
			}
			wp_register_style( 'wc-multistore-bulk-sync-css', WOO_MSTORE_ASSET_URL .'/assets/css/wc-multistore-bulk-sync.css', array('jquery-ui-css'), WOO_MSTORE_VERSION );
			wp_enqueue_style( 'wc-multistore-bulk-sync-css' );
			wp_enqueue_style( 'woocommerce_admin_styles' );
			wp_enqueue_style( 'jquery-ui-css', WOO_MSTORE_URL . '/assets/css/jquery-ui.css' );

			wp_register_script( 'wc-multistore-bulk-sync-js', WOO_MSTORE_ASSET_URL . '/assets/js/wc-multistore-bulk-sync.js', array('jquery-ui-progressbar'), WOO_MSTORE_VERSION );
			wp_enqueue_script( 'wc-multistore-bulk-sync-js' );

			wp_enqueue_script( 'jquery-ui-progressbar' );
			wp_enqueue_script( 'select2' );

			$WC_url = plugins_url() . '/woocommerce';
			wp_register_script( 'jquery-tiptip', $WC_url . '/assets/js/jquery-tiptip/jquery.tipTip.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'jquery-tiptip' );
		}
	}

	/**
	 * Network Admin Submenu
	 */
	public function add_submenu() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( is_network_admin() ) {
			$hookname = add_submenu_page(
				'woonet-woocommerce',
				'Bulk Sync',
				'Bulk Sync',
				'manage_woocommerce',
				'woonet-bulk-sync-products',
				array( $this, 'menu_callback_bulk_sync_all_menu' )
			);
		} else {

			$hookname = add_submenu_page(
				'woocommerce',
				'Bulk Sync',
				'Bulk Sync',
				'manage_woocommerce',
				'woonet-bulk-sync-products',
				array( $this, 'menu_callback_bulk_sync_all_menu' )
			);

		}
	}

	/**
	 * Admin Submenu
	 */
	public function add_submenu_non_multisite() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$hookname = add_submenu_page(
			'woonet-woocommerce',
			'Bulk Sync',
			'Bulk Sync',
			'manage_woocommerce',
			'woonet-bulk-sync-products',
			array( $this, 'menu_callback_bulk_sync_all_menu' )
		);
	}

	/**
	 * Admin Bar Submenu
	 */
	public function add_bar_menu_page( $admin_bar ) {
		if( ! is_multisite() && WOO_MULTISTORE()->site->get_type() != 'master' ){
			return;
		}

		$admin_bar->add_menu( array(
			'id'    => 'woonet-network-bulk-sync',
			'parent' => 'woonet-woocommerce',
			'group'  => null,
			'title' => __( 'Bulk Sync', 'woonet' ),
			'href'  => network_admin_url( 'admin.php?page=woonet-bulk-sync-products' ),
			'meta' => [
				'title' => __( 'Bulk Sync', 'woonet' ),
			]
		) );
	}

	public function menu_callback_bulk_sync_all_menu() {
		require_once WOO_MSTORE_PATH . 'includes/admin/views/html-bulk-sync.php';
	}

	public function get_ids() {
		$product_ids = get_posts(
			array(
				'post_type'   => 'product',
				'numberposts' => -1,
				'post_status' => 'publish',
				'fields'      => 'ids',
			)
		);

		return $product_ids;
	}
}