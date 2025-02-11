<?php
/**
 * Ajax settings master handler.
 *
 * This handles ajax settings master related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Ajax_Settings_Master
 */
class WC_Multistore_Ajax_Settings_Master {
	function __construct() {
		if ( ! defined( 'DOING_AJAX' ) ) { return; }
		if ( WOO_MULTISTORE()->site->get_type() != 'master' ){ return; }

		add_action( 'wp_ajax_wc_multistore_save_master_settings', array( $this, 'wc_multistore_save_master_settings' ) );
		add_action( 'wp_ajax_nopriv_wc_multistore_save_master_settings', array( $this, 'wc_multistore_save_master_settings' ) );

		add_action( 'wp_ajax_wc_multistore_save_master_custom_data_settings', array( $this, 'wc_multistore_save_master_custom_data_settings' ) );
		add_action( 'wp_ajax_nopriv_wc_multistore_save_master_custom_data_settings', array( $this, 'wc_multistore_save_master_custom_data_settings' ) );
	}

	public function wc_multistore_save_master_settings(){
		if ( ! isset( $_POST['nonce'] ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		$serialized_settings = $_POST['settings'];
		$settings = array();
		parse_str(wp_unslash($serialized_settings), $settings);


		// save general settings
		$sites_settings = $settings['sites'];

		$WC_Multistore_Settings = new WC_Multistore_Settings();
		$WC_Multistore_Settings->save($settings);

		$WC_Multistore_Sites = new WC_Multistore_Sites();
		$WC_Multistore_Sites->save($sites_settings);

		$result = $WC_Multistore_Settings->get_messages();


		$data = array(
			'status' => 'success',
			'messages' => $result,
		);
		echo wp_json_encode($data);
		wp_die();
	}

	public function wc_multistore_save_master_custom_data_settings(){
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mstore_form_submit_taxonomies' ) ) {
			$data = array(
				'status' => 'failed',
				'message' => 'Insufficient permissions'
			);
			echo wp_json_encode($data);
			wp_die();
		}

		$serialized_settings = $_POST['settings'];
		$settings = array();
		parse_str(wp_unslash($serialized_settings), $settings);

		if ( WOO_MULTISTORE()->settings['sync-custom-taxonomy']  == 'yes' ) {
			if ( ! empty( $settings['__wc_multistore_custom_taxonomy'] ) ) {
				update_site_option( 'wc_multistore_custom_taxonomy', $settings['__wc_multistore_custom_taxonomy'] );
			} else {
				update_site_option( 'wc_multistore_custom_taxonomy', array() );
			}
		}

		if ( WOO_MULTISTORE()->settings['sync-custom-metadata'] == 'yes' ) {
			if ( ! empty( $settings['__wc_multistore_custom_metadata'] ) ) {
				update_site_option( 'wc_multistore_custom_metadata', $settings['__wc_multistore_custom_metadata'] );
			} else {
				update_site_option( 'wc_multistore_custom_metadata', array() );
			}
		}


		$data = array(
			'status' => 'success',
			'message' => 'Settings Saved',
		);
		echo wp_json_encode($data);
		wp_die();
	}
}