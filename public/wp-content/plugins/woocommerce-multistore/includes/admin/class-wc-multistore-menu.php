<?php
/**
 * Menu Handler
 *
 * This handles menu related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Menu
 */
class WC_Multistore_Menu {

	/**
	 * Constructor
	 */
	public function __construct(){
		$this->hooks();
	}

	/**
	 * Hooks
	 */
	public function hooks(){
		if( ! WOO_MULTISTORE()->permission ){ return; }

		if( is_multisite() ){
			add_action( 'network_admin_menu', array( $this, 'add_menu_page' ) );
		}else{
			add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		}
		add_action('admin_bar_menu', array( $this, 'add_bar_menu_page' ), 500, 1 );

		add_action( 'admin_enqueue_scripts', array( $this, 'wc_multistore_admin_scripts' ) );
	}

	/**
	 * Network Admin Menu and Admin Menu
	 */
	public function add_menu_page(){
		add_menu_page( __( 'Multistore', 'woonet' ), __( 'Multistore', 'woonet' ), 'manage_woocommerce', 'woonet-woocommerce', null, 'dashicons-networking', '55.5' );
	}

	/**
	 * Admin Bar Menu
	 */
	public function add_bar_menu_page($admin_bar){
		$admin_bar->add_menu( array(
			'id'    => 'woonet-woocommerce',
			'parent' => null,
			'group'  => null,
			'title' => '<span class="ab-icon" aria-hidden="true"></span><span class="ab-label">' . __( 'Multistore', 'woonet' ) . '</span>',
			'href'  => network_admin_url( 'admin.php?page=woonet-woocommerce' ),
			'meta' => [
				'title' => __( 'Multistore', 'woonet' ),
			]
		) );
	}

	public function wc_multistore_admin_scripts(){
		wp_enqueue_style( 'woonet_admin', WOO_MSTORE_URL . '/assets/css/wc-multistore-admin.css' );
	}
}