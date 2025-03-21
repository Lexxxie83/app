<?php

/**
 * The Settings Page
 *
 * @since 6.0
 */

namespace InstagramFeed\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use InstagramFeed\Helpers\Util;
use InstagramFeed\SBI_Response;
use InstagramFeed\Integrations\WPCode;

class SBI_Global_Settings {

	/**
	 * Admin menu page slug.
	 *
	 * @since 6.0
	 *
	 * @var string
	 */
	const SLUG = 'sbi-settings';

	/**
	 * Initializing the class
	 *
	 * @since 6.0
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Determining if the user is viewing the our page, if so, party on.
	 *
	 * @since 6.0
	 */
	public function init() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_filter( 'admin_footer_text', array( $this, 'remove_admin_footer_text' ) );

		add_action( 'wp_ajax_sbi_save_settings', array( $this, 'sbi_save_settings' ) );
		add_action( 'wp_ajax_sbi_activate_license', array( $this, 'sbi_activate_license' ) );
		add_action( 'wp_ajax_sbi_deactivate_license', array( $this, 'sbi_deactivate_license' ) );
		add_action( 'wp_ajax_sbi_test_connection', array( $this, 'sbi_test_connection' ) );
		add_action( 'wp_ajax_sbi_recheck_connection', array( $this, 'sbi_recheck_connection' ) );
		add_action( 'wp_ajax_sbi_import_settings_json', array( $this, 'sbi_import_settings_json' ) );
		add_action( 'wp_ajax_sbi_export_settings_json', array( $this, 'sbi_export_settings_json' ) );
		add_action( 'wp_ajax_sbi_clear_cache', array( $this, 'sbi_clear_cache' ) );
		add_action( 'wp_ajax_sbi_clear_image_resize_cache', array( $this, 'sbi_clear_image_resize_cache' ) );
		add_action( 'wp_ajax_sbi_clear_error_log', [$this, 'sbi_clear_error_log'] );
		add_action( 'wp_ajax_sbi_retry_db', [$this, 'sbi_retry_db'] );
		add_action( 'wp_ajax_sbi_dpa_reset', array( $this, 'sbi_dpa_reset' ) );
	}

	/**
	 * SBI Save Settings
	 *
	 * This will save the data fron the settings page
	 *
	 * @since 6.0
	 *
	 * @return SBI_Response
	 */
	public function sbi_save_settings() {
		//Security Checks
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$data  = $_POST;
		$model = isset( $data['model'] ) ? $data['model'] : null;

		// return if the model is null
		if ( null === $model ) {
			return;
		}

		// get the sbi license key and extensions license key
		$sbi_license_key = sanitize_text_field( $_POST['sbi_license_key'] );

		// Only update the sbi_license_key value when it's inactive
		if ( get_option( 'sbi_license_status' ) === 'inactive' ) {
			if ( empty( $sbi_license_key ) || strlen( $sbi_license_key ) < 1 ) {
				delete_option( 'sbi_license_key' );
				delete_option( 'sbi_license_data' );
				delete_option( 'sbi_license_status' );
			} else {
				update_option( 'sbi_license_key', $sbi_license_key );
			}
		} else {
			$license_key = trim( get_option( 'sbi_license_key' ) );

			if ( empty( $sbi_license_key ) && ! empty( $license_key ) ) {
				$sbi_license_data = $this->get_license_data( $license_key, 'deactivate_license', SBI_PLUGIN_NAME );

				delete_option( 'sbi_license_key' );
				delete_option( 'sbi_license_data' );
				delete_option( 'sbi_license_status' );
			}
		}

		$model = (array) \json_decode( \stripslashes( $model ) );

		$general  = (array) $model['general'];
		$feeds    = (array) $model['feeds'];
		$advanced = (array) $model['advanced'];

		// Get the values and sanitize
		$sbi_settings = get_option( 'sb_instagram_settings', array() );

		/**
		 * General Tab
		 */
		$sbi_settings['sb_instagram_preserve_settings'] = $general['preserveSettings'];

		/**
		 * Feeds Tab
		 */
		if ( current_user_can( 'unfiltered_html' ) ) {
			$sbi_settings['sb_instagram_custom_css']    = $feeds['customCSS'];
			$sbi_settings['sb_instagram_custom_js'] 	= $feeds['customJS'];
		}
		$sbi_settings['gdpr']                    = sanitize_text_field( $feeds['gdpr'] );
		$sbi_settings['sbi_cache_cron_interval'] = sanitize_text_field( $feeds['cronInterval'] );
		$sbi_settings['sbi_cache_cron_time']     = sanitize_text_field( $feeds['cronTime'] );
		$sbi_settings['sbi_cache_cron_am_pm']    = sanitize_text_field( $feeds['cronAmPm'] );

		/**
		 * Advanced Tab
		 */
		$sbi_settings['sb_instagram_ajax_theme']     = sanitize_text_field( $advanced['sbi_ajax'] );
		$sbi_settings['sb_instagram_disable_resize'] = ! (bool) $advanced['sbi_enable_resize'];
		$sbi_settings['image_format']                = sanitize_text_field( $advanced['image_format'] );
		$sbi_settings['enqueue_js_in_head']          = (bool) $advanced['sbi_enqueue_js_in_head'];
		$sbi_settings['enqueue_css_in_shortcode']    = (bool) $advanced['sbi_enqueue_css_in_shortcode'];
		$sbi_settings['disable_js_image_loading']    = ! (bool) $advanced['sbi_enable_js_image_loading'];
		$sbi_settings['disable_admin_notice']        = ! (bool) $advanced['enable_admin_notice'];
		$sbi_settings['enable_email_report']         = (bool) $advanced['enable_email_report'];
		$sbi_settings['sb_ajax_initial']             = (bool) $advanced['sbi_ajax_initial'];
		$sbi_settings['enqueue_legacy_css']          = (bool) $advanced['enqueue_legacy_css'];

		$sbi_settings['email_notification']           = sanitize_text_field( $advanced['email_notification'] );
		$sbi_settings['email_notification_addresses'] = sanitize_text_field( $advanced['email_notification_addresses'] );

		$usage_tracking = get_option(
			'sbi_usage_tracking',
			array(
				'last_send' => 0,
				'enabled'   => sbi_is_pro_version(),
			)
		);
		if ( isset( $advanced['email_notification_addresses'] ) ) {
			$usage_tracking['enabled'] = false;
			if ( isset( $advanced['usage_tracking'] ) ) {
				if ( ! is_array( $usage_tracking ) ) {
					$usage_tracking = array(
						'enabled'   => $advanced['usage_tracking'],
						'last_send' => 0,
					);
				} else {
					$usage_tracking['enabled'] = $advanced['usage_tracking'];
				}
			}
			update_option( 'sbi_usage_tracking', $usage_tracking, false );
		}

		// Update the sbi_style_settings option that contains data for translation and advanced tabs
		update_option( 'sb_instagram_settings', $sbi_settings );

		// clear cron caches
		$this->sbi_clear_cache();

		$response = new SBI_Response(
			true,
			array(
				'cronNextCheck' => $this->get_cron_next_check(),
			)
		);
		$response->send();
	}

	/**
	 * SBI Activate License Key
	 *
	 * @since 6.0
	 *
	 * @return SBI_Response
	 */
	public function sbi_activate_license() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		// do the form validation to check if license_key is not empty
		if ( empty( $_POST['license_key'] ) ) {
			$response = new \InstagramFeed\SBI_Response(
				false,
				array(
					'message' => __( 'License key required!', 'instagram-feed' ),
				)
			);
			$response->send();
		}
		$license_key = sanitize_text_field( $_POST['license_key'] );
		// make the remote api call and get license data
		$sbi_license_data = $this->get_license_data( $license_key, 'activate_license', SBI_PLUGIN_NAME );

		// update the license data
		if ( ! empty( $sbi_license_data ) && $sbi_license_data['license'] == 'valid' ) {
			update_option( 'sbi_license_data', $sbi_license_data );
			// update the licnese key only when the license status is activated
			update_option( 'sbi_license_key', $license_key );
			// update the license status
			update_option( 'sbi_license_status', $sbi_license_data['license'] );
			// Remove the license notice
			global $sbi_notices;
			$sbi_notices->remove_notice( 'license_inactive' );
			$sbi_notices->remove_notice( 'license_expired' );
		}

		// Check if there is any error in the license key then handle it
		$sbi_license_data = $this->get_license_error_message( $sbi_license_data );

		// Send ajax response back to client end
		$data     = array(
			'licenseStatus' => $sbi_license_data['license'],
			'licenseData'   => $sbi_license_data,
		);
		$response = new SBI_Response( true, $data );
		$response->send();
	}

	/**
	 * SBI Deactivate License Key
	 *
	 * @since 6.0
	 *
	 * @return SBI_Response
	 */
	public function sbi_deactivate_license() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$license_key      = trim( get_option( 'sbi_license_key' ) );
		$sbi_license_data = $this->get_license_data( $license_key, 'deactivate_license', SBI_PLUGIN_NAME );
		// update the license data
		if ( ! empty( $sbi_license_data ) ) {
			update_option( 'sbi_license_data', $sbi_license_data );
		}
		if ( ! $sbi_license_data['success'] ) {
			$response = new SBI_Response( false, array() );
			$response->send();
		}
		// remove the license keys and update license key status
		if ( $sbi_license_data['license'] === 'deactivated' ) {
			update_option( 'sbi_license_status', 'inactive' );
			$data     = array(
				'licenseStatus' => 'inactive',
			);
			$response = new SBI_Response( true, $data );
			$response->send();
		}
	}

	/**
	 * SBI Test Connection
	 *
	 * @since 6.0
	 *
	 * @return SBI_Response
	 */
	public function sbi_test_connection() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$license_key    = get_option( 'sbi_license_key' );
		$sbi_api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license_key,
			'item_name'  => urlencode( SBI_PLUGIN_NAME ), // the name of our product in EDD
		);
		$url            = add_query_arg( $sbi_api_params, SBI_STORE_URL );
		$args           = array(
			'timeout'   => 60,
		);
		// Make the remote API request
		$request = \InstagramFeed\SBI_HTTP_Request::request( 'GET', $url, $args );
		if ( \InstagramFeed\SBI_HTTP_Request::is_error( $request ) ) {
			$response = new SBI_Response(
				false,
				array(
					'hasError' => true,
				)
			);
			$response->send();
		}

		$response = new SBI_Response(
			true,
			array(
				'hasError' => false,
			)
		);
		$response->send();
	}

	/**
	 * SBI Re-Check License
	 *
	 * @since 6.0
	 *
	 * @return SBI_Response
	 */
	public function sbi_recheck_connection() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		// Do the form validation
		$license_key = isset( $_POST['license_key'] ) ? sanitize_text_field( $_POST['license_key'] ) : '';
		$item_name   = isset( $_POST['item_name'] ) ? sanitize_text_field( $_POST['item_name'] ) : SBI_PLUGIN_NAME;
		$option_name = isset( $_POST['option_name'] ) ? sanitize_text_field( $_POST['option_name'] ) : '';
		if ( empty( $license_key ) || empty( $item_name ) ) {
			$response = new SBI_Response( false, array() );
			$response->send();
		}

		// make the remote license check API call
		$sbi_license_data = $this->get_license_data( $license_key, 'check_license', $item_name );

		// update options data
		$license_changed = $this->update_recheck_license_data( $sbi_license_data, $item_name, $option_name );

		if (
			isset($sbi_license_data['success'], $sbi_license_data['license'])
			&& $sbi_license_data['success'] === true
			&& $sbi_license_data['license'] === 'valid'
		) {
			SBI_Upgrader_Pro::check_license_upgraded($sbi_license_data, $license_key);
		}


		// send AJAX response back.
		$response = new SBI_Response(
			true,
			array(
				'license'             => $sbi_license_data['license'],
				'licenseChanged'      => $license_changed,
				'isLicenseUpgraded'   => get_option('sbi_islicence_upgraded'),
				'licenseUpgradedInfo' => get_option('sbi_upgraded_info')
			)
		);
		$response->send();
	}

	/**
	 * Update License Data
	 *
	 * @since 6.0
	 *
	 * @param array $license_data
	 * @param string $item_name
	 * @param string $option_name
	 *
	 * @return bool $license_changed
	 */
	public function update_recheck_license_data( $license_data, $item_name, $option_name ) {
		$license_changed = false;
		// if we are updating plugin's license data
		if ( SBI_PLUGIN_NAME === $item_name ) {
			// compare the old stored license status with new license status
			if ( get_option( 'sbi_license_status' ) !== $license_data['license'] ) {
				$license_changed = true;
				// make license check_api true so next time it expires it checks again
				update_option( 'sbi_check_license_api_when_expires', 'true' );
				update_option( 'sbi_check_license_api_post_grace_period', 'true' );

				if( $license_data['license'] === 'valid' ) {
					global $sbi_notices;
					$sbi_notices->remove_notice( 'license_inactive' );
					$sbi_notices->remove_notice( 'license_expired' );
				}
			}
			update_option( 'sbi_license_data', $license_data );
			update_option( 'sbi_license_status', $license_data['license'] );
		}

		// If we are updating extensions license data
		if ( SBI_PLUGIN_NAME !== $item_name ) {
			// compare the old stored license status with new license status
			if ( get_option( 'sbi_license_status_' . $option_name ) !== $license_data['license'] ) {
				$license_changed = true;
			}
			update_option( 'sbi_license_status_' . $option_name, $license_data['license'] );
		}
		// if we are updating extensions license data and it's not valid
		// then remote the extensions license status
		if ( SBI_PLUGIN_NAME !== $item_name && 'valid' !== $license_data['license'] ) {
			delete_option( 'sbi_license_status_' . $option_name );
		}

		return $license_changed;
	}

	/**
	 * SBI Import Feed Settings JSON
	 *
	 * @since 6.0
	 *
	 * @return SBI_Response
	 */
	public function sbi_import_settings_json() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		$filename = $_FILES['file']['name'];
		$ext      = pathinfo( $filename, PATHINFO_EXTENSION );
		if ( 'json' !== $ext ) {
			$response = new SBI_Response( false, array() );
			$response->send();
		}
		$imported_settings = file_get_contents( $_FILES['file']['tmp_name'] );
		// check if the file is empty
		if ( empty( $imported_settings ) ) {
			$response = new SBI_Response( false, array() );
			$response->send();
		}
		$feed_return = \InstagramFeed\Builder\SBI_Feed_Saver_Manager::import_feed( $imported_settings );
		// check if there's error while importing
		if ( ! $feed_return['success'] ) {
			$response = new SBI_Response( false, array() );
			$response->send();
		}
		// Once new feed has imported lets export all the feeds to update in front end
		$exported_feeds = \InstagramFeed\Builder\SBI_Db::feeds_query();
		$feeds          = array();
		foreach ( $exported_feeds as $feed_id => $feed ) {
			$feeds[] = array(
				'id'   => $feed['id'],
				'name' => $feed['feed_name'],
			);
		}

		$response = new SBI_Response(
			true,
			array(
				'feeds' => $feeds,
			)
		);
		$response->send();
	}

	/**
	 * SBI Export Feed Settings JSON
	 *
	 * @since 6.0
	 *
	 * @return SBI_Response
	 */
	public function sbi_export_settings_json() {
		if ( ! check_ajax_referer( 'sbi-admin', 'nonce', false ) ) {
			wp_send_json_error();
		}

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		if ( ! isset( $_GET['feed_id'] ) ) {
			return;
		}
		$feed_id   = filter_var( $_GET['feed_id'], FILTER_SANITIZE_NUMBER_INT );
		$feed      = \InstagramFeed\Builder\SBI_Feed_Saver_Manager::get_export_json( $feed_id );
		$feed_info = \InstagramFeed\Builder\SBI_Db::feeds_query( array( 'id' => $feed_id ) );
		$feed_name = strtolower( $feed_info[0]['feed_name'] );
		$filename  = 'sbi-feed-' . $feed_name . '.json';
		// create a new empty file in the php memory
		$file = fopen( 'php://memory', 'w' );
		fwrite( $file, $feed );
		fseek( $file, 0 );
		header( 'Content-type: application/json' );
		header( 'Content-disposition: attachment; filename = "' . $filename . '";' );
		fpassthru( $file );
		exit;
	}

	/**
	 * SBI Clear Cache
	 *
	 * @since 6.0
	 */
	public function sbi_clear_cache() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		// Get the updated cron schedule interval and time settings from user input and update the database
		$model = isset( $_POST['model'] ) ? sanitize_text_field( $_POST['model'] ) : null;
		if ( $model !== null ) {
			$model = (array) \json_decode( \stripslashes( $model ) );
			$feeds = (array) $model['feeds'];
		}

		// Now get the updated cron schedule interval and time values
		$sbi_settings = get_option( 'sb_instagram_settings', array() );

		$sbi_cache_cron_interval = $sbi_settings['sbi_cache_cron_interval'];
		$sbi_cache_cron_time     = $sbi_settings['sbi_cache_cron_time'];
		$sbi_cache_cron_am_pm    = $sbi_settings['sbi_cache_cron_am_pm'];

		// Clear the stored caches in the database
		$this->clear_stored_caches();

		delete_option( 'sbi_cron_report' );
		\SB_Instagram_Cron_Updater::start_cron_job( $sbi_cache_cron_interval, $sbi_cache_cron_time, $sbi_cache_cron_am_pm );

		global $sb_instagram_posts_manager;
		$sb_instagram_posts_manager->add_action_log( 'Saved settings on the configure tab.' );
		$sb_instagram_posts_manager->clear_api_request_delays();

		$response = new SBI_Response(
			true,
			array(
				'cronNextCheck' => $this->get_cron_next_check(),
			)
		);
		$response->send();
	}

	/**
	 * Clear the stored caches from the database and from other caching plugins
	 *
	 * @since 6.0
	 */
	public function clear_stored_caches() {

		global $wpdb;

		$cache_table_name = $wpdb->prefix . 'sbi_feed_caches';

		$sql = "
		UPDATE $cache_table_name
		SET cache_value = ''
		WHERE cache_key NOT IN ( 'posts_backup', 'header_backup' );";
		$wpdb->query( $sql );

		//Delete all SBI transients
		$table_name = $wpdb->prefix . 'options';
		$wpdb->query(
			"
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_sbi\_%')
                    "
		);
		$wpdb->query(
			"
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_timeout\_sbi\_%')
                    "
		);
		$wpdb->query(
			"
			        DELETE
			        FROM $table_name
			        WHERE `option_name` LIKE ('%\_transient\_&sbi\_%')
			        "
		);
		$wpdb->query(
			"
			        DELETE
			        FROM $table_name
			        WHERE `option_name` LIKE ('%\_transient\_timeout\_&sbi\_%')
			        "
		);
		$wpdb->query(
			"
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_\$sbi\_%')
                    "
		);
		$wpdb->query(
			"
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_timeout\_\$sbi\_%')
                    "
		);

		\SB_Instagram_Cache::clear_legacy( true );

		sb_instagram_clear_page_caches();
	}

	/**
	 * SBI Retry DB creating
	 *
	 * @since 6.1
	 */
	public function sbi_retry_db() {
		//Security Checks
		check_ajax_referer( 'sbi_nonce', 'sbi_nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error();
		}
		sbi_create_database_table( false );
		\SB_Instagram_Feed_Locator::create_table();
		\InstagramFeed\Builder\SBI_Db::create_tables( false );

		global $wpdb;
		$table_name = $wpdb->prefix . SBI_INSTAGRAM_POSTS_TYPE;

		if ( $wpdb->get_var( "show tables like '$table_name'" ) !== $table_name ) {
			wp_send_json_error( array( 'message' => '<div style="margin-top: 10px;">' . esc_html__( 'Unsuccessful. Try visiting our website.', 'instagram-feed' ) . '</div>' ) );
		}

		global $sbi_notices;
		$sbi_notices->remove_notice( 'database_create' );
		wp_send_json_success( array( 'message' => '<div style="margin-top: 10px;">' . esc_html__( 'Success! Try creating a feed and connecting a source.', 'instagram-feed' ) . '</div>' ) );
	}

	/**
	 * SBI Clear Image Resize Cache
	 *
	 * @since 6.0
	 */
	public function sbi_clear_image_resize_cache() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		global $sb_instagram_posts_manager;
		$sb_instagram_posts_manager->delete_all_sbi_instagram_posts();
		delete_option( 'sbi_top_api_calls' );

		$sb_instagram_posts_manager->add_action_log( 'Reset resizing tables.' );

		$this->clear_stored_caches();

		$response = new SBI_Response( true, array() );
		$response->send();
	}

	/**
	 * SBI CLear Error Log
	 *
	 * @since 6.0.2
	 */
	public function sbi_clear_error_log() {
		//Security Checks
		check_ajax_referer( 'sbi-admin', 'nonce'  );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error();
		}

		global $sb_instagram_posts_manager;

		$sb_instagram_posts_manager->remove_all_errors();

		global $sbi_notices;
		$sbi_notices->remove_notice( 'critical_error' );

		wp_send_json_success();
	}

	/**
	 * SBI Clear Image Resize Cache
	 *
	 * @since 6.0
	 */
	public function sbi_dpa_reset() {
		check_ajax_referer( 'sbi-admin', 'nonce' );

		if ( ! sbi_current_user_can( 'manage_instagram_feed_options' ) ) {
			wp_send_json_error(); // This auto-dies.
		}

		sbi_delete_all_platform_data();

		$this->clear_stored_caches();

		$response = new SBI_Response( true, array() );
		$response->send();
	}

	/**
	 * SBI Get License Data from our license API
	 *
	 * @since 6.0
	 *
	 * @param string $license_key
	 * @param string $license_action
	 *
	 * @return void|array $sbi_license_data
	 */
	public function get_license_data( $license_key, $license_action = 'check_license', $item_name = SBI_PLUGIN_NAME ) {
		$sbi_api_params = array(
			'edd_action' => $license_action,
			'license'    => $license_key,
			'item_name'  => urlencode( $item_name ), // the name of our product in EDD
		);
		$url            = add_query_arg( $sbi_api_params, SBI_STORE_URL );
		$args           = array(
			'timeout'   => 60,
		);
		// Make the remote API request
		$request = \InstagramFeed\SBI_HTTP_Request::request( 'GET', $url, $args );
		if ( \InstagramFeed\SBI_HTTP_Request::is_error( $request ) ) {
			return;
		}
		$sbi_license_data = (array) \InstagramFeed\SBI_HTTP_Request::data( $request );
		return $sbi_license_data;
	}

	/**
	 * Get license error message depending on license status
	 *
	 * @since 6.0
	 *
	 * @param array $sbi_license_data
	 *
	 * @return array $sbi_license_data
	 */
	public function get_license_error_message( $sbi_license_data ) {
		global $sbi_download_id;

		$license_key = null;
		if ( get_option( 'sbi_license_key' ) ) {
			$license_key = get_option( 'sbi_license_key' );
		}

		$upgrade_url    = sprintf( 'https://smashballoon.com/instagram-feed/pricing/?edd_license_key=%s&upgrade=true&utm_campaign=instagram-pro&utm_source=settings&utm_medium=upgrade-license', sanitize_key( $license_key ) );
		$renew_url      = sprintf( 'https://smashballoon.com/checkout/?edd_license_key=%s&download_id=%s&utm_campaign=instagram-pro&utm_source=settings&utm_medium=upgrade-license&utm_content=renew-license', sanitize_key( $license_key ), sanitize_key( $sbi_download_id ) );
		$learn_more_url = 'https://smashballoon.com/doc/my-license-key-wont-activate/?utm_campaign=instagram-pro&utm_source=settings&utm_medium=license&utm_content=learn-more';

		// Check if the license key reached max site installations
		if ( isset( $sbi_license_data['error'] ) && 'no_activations_left' === $sbi_license_data['error'] ) {
			$sbi_license_data['errorMsg'] = sprintf(
				'%s (%s/%s). %s <a href="%s" target="_blank">%s</a> %s <a href="%s" target="_blank">%s</a>',
				__( 'You have reached the maximum number of sites available in your plan', 'instagram-feed' ),
				$sbi_license_data['site_count'],
				$sbi_license_data['max_sites'],
				__( 'Learn more about it', 'instagram-feed' ),
				$learn_more_url,
				'here',
				__( 'or upgrade your plan.', 'instagram-feed' ),
				$upgrade_url,
				__( 'Upgrade', 'instagram-feed' )
			);
		}
		// Check if the license key has expired
		if (
			( isset( $sbi_license_data['license'] ) && 'expired' === $sbi_license_data['license'] ) ||
			( isset( $sbi_license_data['error'] ) && 'expired' === $sbi_license_data['error'] )
		) {
			$sbi_license_data['error']    = true;
			$expired_date                 = new \DateTime( $sbi_license_data['expires'] );
			$expired_date                 = $expired_date->format( 'F d, Y' );
			$sbi_license_data['errorMsg'] = sprintf(
				'%s %s. %s <a href="%s" target="_blank">%s</a>',
				__( 'The license expired on ', 'instagram-feed' ),
				$expired_date,
				__( 'Please renew it and try again.', 'instagram-feed' ),
				$renew_url,
				__( 'Renew', 'instagram-feed' )
			);
		}
		return $sbi_license_data;
	}

	/**
	 * Remove admin footer message
	 *
	 * @since 6.0
	 *
	 * @return string
	 */
	public function remove_admin_footer_text() {
		return '';
	}

	/**
	 * Register Menu.
	 *
	 * @since 6.0
	 */
	public function register_menu() {
		// remove admin page update footer
		add_filter( 'update_footer', array( $this, 'remove_admin_footer_text' ) );

		$cap = current_user_can( 'manage_custom_instagram_feed_options' ) ? 'manage_custom_instagram_feed_options' : 'manage_options';
		$cap = apply_filters( 'sbi_settings_pages_capability', $cap );

		$notice = '';
		global $sb_instagram_posts_manager;
		if ( $sb_instagram_posts_manager->are_critical_errors() ) {
			$notice = ' <span class="update-plugins sbi-error-alert"><span>!</span></span>';
		}

		$global_settings = add_submenu_page(
			'sb-instagram-feed',
			__( 'Settings', 'instagram-feed' ),
			__( 'Settings ' . $notice, 'instagram-feed' ),
			$cap,
			'sbi-settings',
			array( $this, 'global_settings' ),
			1
		);
		add_action( 'load-' . $global_settings, array( $this, 'builder_enqueue_admin_scripts' ) );
	}

	/**
	 * Enqueue Builder CSS & Script.
	 *
	 * Loads only for builder pages
	 *
	 * @since 6.0
	 */
	public function builder_enqueue_admin_scripts() {
		if(!Util::isIFPage()) {
			return;
		}

		global $wp_version;
		$can_install_automator_plugin = ( version_compare($wp_version,'5.3') >= 0 ) ? true : false;

		$sbi_status     = 'inactive';
		$model          = $this->get_settings_data();
		$exported_feeds = \InstagramFeed\Builder\SBI_Db::feeds_query(
			['all_feeds' => true]
		);
		$feeds          = array();
		foreach ( $exported_feeds as $feed_id => $feed ) {
			$feeds[] = array(
				'id'   => $feed['id'],
				'name' => $feed['feed_name'],
			);
		}
		$licenseErrorMsg = null;
		$license_key     = trim( get_option( 'sbi_license_key' ) );
		if ( $license_key ) {
			$license_last_check = get_option( 'sbi_license_last_check_timestamp' );
			$date               = time() - ( DAY_IN_SECONDS * 90 );
			if ( $date > $license_last_check ) {
				// make the remote api call and get license data
				$sbi_license_data = $this->get_license_data( $license_key );
				if ( ! empty( $sbi_license_data ) ) {
					update_option( 'sbi_license_data', $sbi_license_data );
				}
				update_option( 'sbi_license_last_check_timestamp', time() );
			} else {
				$sbi_license_data = get_option( 'sbi_license_data' );
			}
			// update the license data with proper error messages when necessary
			$sbi_license_data = (array) $sbi_license_data;
			$sbi_license_data = $this->get_license_error_message( $sbi_license_data );
			$sbi_status       = $sbi_license_data['license'];
			$licenseErrorMsg  = ( isset( $sbi_license_data['error'] ) && isset( $sbi_license_data['errorMsg'] ) ) ? $sbi_license_data['errorMsg'] : null;
		}

		wp_enqueue_style(
			'settings-style',
			SBI_PLUGIN_URL . 'admin/assets/css/settings.css',
			false,
			SBIVER
		);

		\InstagramFeed\Builder\SBI_Feed_Builder::global_enqueue_ressources_scripts( true );

		wp_register_script('feed-builder-svgs', SBI_PLUGIN_URL . 'assets/svgs/svgs.js');

		wp_enqueue_script(
			'settings-app',
			SBI_PLUGIN_URL . 'admin/assets/js/settings.js',
			array('feed-builder-svgs'),
			SBIVER,
			true
		);

		$current_user_id = get_current_user_id();
		$get_sb_active_plugins_info = Util::get_sb_active_plugins_info();
		$should_hide_automtor_notice = ( get_user_meta( $current_user_id, 'sbi_dismiss_automator_notice' ) ) ? true : false;

		$license_key = null;
		if ( get_option( 'sbi_license_key' ) ) {
			$license_key = get_option( 'sbi_license_key' );
		}

		$has_license_error = false;
		if (
			( isset( $sbi_license_data['license'] ) && 'expired' === $sbi_license_data['license'] ) ||
			( isset( $sbi_license_data['error'] ) && ( $sbi_license_data['error'] || 'expired' === $sbi_license_data['error'] ) )
		) {
			$has_license_error = true;
		}

		$upgrade_url          = sprintf( 'https://smashballoon.com/instagram-feed/pricing/?edd_license_key=%s&upgrade=true&utm_campaign=instagram-pro&utm_source=settings&utm_medium=upgrade-license', sanitize_key( $license_key ) );
		$usage_tracking_url   = 'https://smashballoon.com/instagram-feed/usage-tracking/';
		$feed_issue_email_url = 'https://smashballoon.com/email-report-is-not-in-my-inbox/?instagram';

		$sources_list = \InstagramFeed\Builder\SBI_Feed_Builder::get_source_list();

		// Extract only license keys and build array for extensions license keys

		$sbi_settings = array(
			'admin_url'            => admin_url(),
			'ajax_handler'         => admin_url( 'admin-ajax.php' ),
			'nonce'                => wp_create_nonce( 'sbi-admin' ),
			'supportPageUrl'       => admin_url( 'admin.php?page=sbi-support' ),
			'builderUrl'           => admin_url( 'admin.php?page=sbi-feed-builder' ),
			'links'                => $this->get_links_with_utm(),
			'uoActive'				=>  is_plugin_active( 'uncanny-automator/uncanny-automator.php' ),
			'pluginItemName'       => SBI_PLUGIN_NAME,
			'licenseType'          => 'pro',
			'licenseKey'           => $license_key,
			'licenseStatus'        => $sbi_status,
			'licenseErrorMsg'      => $licenseErrorMsg,
			'extensionsLicense'    => array(),
			'extensionsLicenseKey' => array(),
			'hasError'             => $has_license_error,
			'upgradeUrl'           => $upgrade_url,
			'model'                => $model,
			'feeds'                => $feeds,
			'sources'              => $sources_list,
			'sbiLicenseNoticeActive' => sbi_license_notices_active() ? true : false,
			'sbiLicenseInactiveState' => sbi_license_inactive_state() ? true : false,
			'isLicenseUpgraded'       => get_option('sbi_islicence_upgraded', false),
			'licenseUpgradedInfo'     => get_option('sbi_upgraded_info', []),
			'socialWallLinks'      => \InstagramFeed\Builder\SBI_Feed_Builder::get_social_wall_links(),
			'socialWallActivated'  => is_plugin_active( 'social-wall/social-wall.php' ),
			'genericText'          => \InstagramFeed\Builder\SBI_Feed_Builder::get_generic_text(),
			'legacyCSSSettings' => Util::sbi_show_legacy_css_settings(),
			'generalTab'           => array(
				'uoInstallNotice' => array(
					'notice' => __( 'Post to Instagram right from WordPress with Uncanny Automator', 'instagram-feed' ),
					'learnMore' => __( 'Learn More', 'instagram feed' ),
					'logo' => '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 13.5C9.5 13.87 9.4 14.2 9.22 14.5C8.88 13.91 8.24 13.5 7.5 13.5C6.76 13.5 6.12 13.91 5.78 14.5C5.61 14.2 5.5 13.87 5.5 13.5C5.5 12.4 6.4 11.5 7.5 11.5C8.6 11.5 9.5 12.4 9.5 13.5ZM22 13V16C22 16.55 21.55 17 21 17H20V18C20 19.11 19.11 20 18 20H4C3.46957 20 2.96086 19.7893 2.58579 19.4142C2.21071 19.0391 2 18.5304 2 18V17H1C0.45 17 0 16.55 0 16V13C0 12.45 0.45 12 1 12H2C2 8.13 5.13 5 9 5H10V3.73C9.4 3.39 9 2.74 9 2C9 0.9 9.9 0 11 0C12.1 0 13 0.9 13 2C13 2.74 12.6 3.39 12 3.73V5H13C16.87 5 20 8.13 20 12H21C21.55 12 22 12.45 22 13ZM18 15V12C18 9.24 15.76 7 13 7H9C6.24 7 4 9.24 4 12V15V18H18V15ZM14.5 11.5C13.4 11.5 12.5 12.4 12.5 13.5C12.5 13.87 12.61 14.2 12.78 14.5C13.12 13.91 13.76 13.5 14.5 13.5C15.24 13.5 15.88 13.91 16.22 14.5C16.4 14.2 16.5 13.87 16.5 13.5C16.5 12.9696 16.2893 12.4609 15.9142 12.0858C15.5391 11.7107 15.0304 11.5 14.5 11.5Z" fill="#663D00"/></svg>',
					'closeIcon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#663D00"/></svg>'
				),
				'licenseBox'   => array(
					'title'                    => __( 'License Key', 'instagram-feed' ),
					'description'              => __( 'Your license key provides access to updates and support', 'instagram-feed' ),
					'activeText'               => __( 'Your <strong>Instagram Feed Pro</strong> license is Active!', 'instagram-feed' ),
					'inactiveText'             => __( 'Your <strong>Instagram Feed Pro</strong> license is Inactive!', 'instagram-feed' ),
					'freeText'                 => __( 'Already purchased? Simply enter your license key below to activate Instagram Feed Pro.', 'instagram-feed' ),
					'inactiveFieldPlaceholder' => __( 'Paste license key here', 'instagram-feed' ),
					'upgradeText1'             => __( 'You are using the Lite version of the plugin–no license needed. Enjoy! 🙂 To unlock more features, consider <a href="' . $upgrade_url . '">Upgrading to Pro</a>.', 'instagram-feed' ),
					'upgradeText2'             => __( 'As a valued user of our Lite plugin, you receive 50% OFF - automatically applied at checkout!', 'instagram-feed' ),
					'manageLicense'            => __( 'Manage License', 'instagram-feed' ),
					'test'                     => __( 'Test Connection', 'instagram-feed' ),
					'recheckLicense'           => __( 'Recheck license', 'instagram-feed' ),
					'licenseValid'             => __( 'License valid', 'instagram-feed' ),
					'licenseExpired'           => __( 'License expired', 'instagram-feed' ),
					'connectionSuccessful'     => __( 'Connection successful', 'instagram-feed' ),
					'connectionFailed'         => __( 'Connection failed', 'instagram-feed' ),
					'viewError'                => __( 'View error', 'instagram-feed' ),
					'upgrade'                  => __( 'Upgrade', 'instagram-feed' ),
					'deactivate'               => __( 'Deactivate', 'instagram-feed' ),
					'activate'                 => __( 'Activate', 'instagram-feed' ),
				),
				'manageSource' => array(
					'title'       => __( 'Manage Sources', 'instagram-feed' ),
					'description' => __( 'Add or remove connected Instagram accounts', 'instagram-feed' ),
				),
				'preserveBox'  => array(
					'title'       => __( 'Preserve settings if plugin is removed', 'instagram-feed' ),
					'description' => __( 'This will make sure that all of your feeds and settings are still saved even if the plugin is uninstalled', 'instagram-feed' ),
				),
				'importBox'    => array(
					'title'       => __( 'Import Feed Settings', 'instagram-feed' ),
					'description' => __( 'You will need a JSON file previously exported from the Instagram Feed Plugin', 'instagram-feed' ),
					'button'      => __( 'Import', 'instagram-feed' ),
				),
				'exportBox'    => array(
					'title'       => __( 'Export Feed Settings', 'instagram-feed' ),
					'description' => __( 'Export settings for one or more of your feeds', 'instagram-feed' ),
					'button'      => __( 'Export', 'instagram-feed' ),
				),
			),
			'feedsTab'             => array(
				'localizationBox' => array(
					'title'   => __( 'Localization', 'instagram-feed' ),
					'tooltip' => '<p>This controls the language of any predefined text strings provided by Instagram. For example, the descriptive text that accompanies some timeline posts (eg: Smash Balloon created an event) and the text in the \'Like Box\' widget. To find out how to translate the other text in the plugin see <a href="https://smashballoon.com/sbi-how-does-the-plugin-handle-text-and-language-translation/">this FAQ</a>.</p>',
				),
				'timezoneBox'     => array(
					'title' => __( 'Timezone', 'instagram-feed' ),
				),
				'cachingBox'      => array(
					'title'                  => __( 'Caching', 'instagram-feed' ),
					'pageLoads'              => __( 'When the Page loads', 'instagram-feed' ),
					'inTheBackground'        => __( 'In the Background', 'instagram-feed' ),
					'inTheBackgroundOptions' => array(
						'30mins'  => __( 'Every 30 minutes', 'instagram-feed' ),
						'1hour'   => __( 'Every hour', 'instagram-feed' ),
						'12hours' => __( 'Every 12 hours', 'instagram-feed' ),
						'24hours' => __( 'Every 24 hours', 'instagram-feed' ),
					),
					'am'                     => __( 'AM', 'instagram-feed' ),
					'pm'                     => __( 'PM', 'instagram-feed' ),
					'clearCache'             => __( 'Clear All Caches', 'instagram-feed' ),
				),
				'gdprBox'         => array(
					'title'                  => __( 'GDPR', 'instagram-feed' ),
					'automatic'              => __( 'Automatic', 'instagram-feed' ),
					'yes'                    => __( 'Yes', 'instagram-feed' ),
					'no'                     => __( 'No', 'instagram-feed' ),
					'infoAuto'               => $this->get_gdpr_auto_info(),
					'infoYes'                => __( 'No requests will be made to third-party websites. To accommodate this, some features of the plugin will be limited.', 'instagram-feed' ),
					'infoNo'                 => __( 'The plugin will function as normal and load images and videos directly from Instagram', 'instagram-feed' ),
					'someInstagram'          => __( 'Some Instagram Feed features will be limited for visitors to ensure GDPR compliance, until they give consent.', 'instagram-feed' ),
					'whatLimited'            => __( 'What will be limited?', 'instagram-feed' ),
					'tooltip'                => '<p><strong>If set to “Yes”,</strong> it prevents all images and videos from being loaded directly from Instagram’s servers (CDN) to prevent any requests to external websites in your browser. To accommodate this, some features of your plugin will be disabled or limited. </p>
                    <p><strong>If set to “No”,</strong> the plugin will still make some requests to load and display images and videos directly from Instagram.</p>
                    <p><strong>If set to “Automatic”,</strong> it will only load images and videos directly from Instagram if consent has been given by one of these integrated GDPR cookie Plugins.</p>
                    <p><a href="https://smashballoon.com/doc/instagram-feed-gdpr-compliance/?instagram" target="_blank" rel="noopener">Learn More</a></p>',
					'gdprTooltipFeatureInfo' => array(
						'headline' => __( 'Features that would be disabled or limited include: ', 'instagram-feed' ),
						'features' => array(
							__( 'Only local images (not from Instagram\'s CDN) will be displayed in the feed.', 'instagram-feed' ),
							__( 'Placeholder blank images will be displayed until images are available.', 'instagram-feed' ),
							__( 'To view videos, visitors will click a link to view the video on Instagram.', 'instagram-feed' ),
							__( 'Carousel posts will only show the first image in the lightbox.', 'instagram-feed' ),
							__( 'The maximum image resolution will be 640 pixels wide in the lightbox.', 'instagram-feed' ),
						),
					),
				),
				'customCSSBox'    => array(
					'title'       => __( 'Custom CSS', 'instagram-feed' ),
					'placeholder' => __( 'Enter any custom CSS here', 'instagram-feed' ),
				),
				'customJSBox'     => array(
					'title'       => __( 'Custom JS', 'instagram-feed' ),
					'placeholder' => __( 'Enter any custom JS here', 'instagram-feed' ),
				),
				'customSnippetsDeprecation' => array(
					'title' => __('DEPRECATED', 'instagram-feed' ),
					'info' => __('The use of Custom CSS and Custom JS has been deprecated. Please use the free WP Code Plugin to add custom CSS. All your custom CSS and JavaScript will be seamlessly moved to a snippet with just one click.', 'instagram-feed' ),
					'installButton' => __('One-click Install and Migrate', 'instagram-feed'),
					'activateButton' => __('One-click Activate and Migrate', 'instagram-feed'),
					'migrateButton' => __('One-click Migrate', 'instagram-feed'),
				),
			),
			'advancedTab'          => array(
				'legacyCSSBox'     => array(
					'title'   => __( 'Use legacy CSS', 'instagram-feed' ),
					'helpText' => __( 'This would revert your CSS file for the feed to the file used in version 6.2. Enable this setting if your customizations are not working properly. ', 'instagram-feed' ) . '<a target="_blank" rel="noopener" href="https://smashballoon.com/doc/instagram-css-layout-changes/?utm_source=instagram-pro&utm_medium=settings-advanced&utm_campaign=63changes&utm_content=LearnMore">' . __('Learn More', 'instagram-feed') .'</a>',
				),
				'optimizeBox'      => array(
					'header'   => __( 'Image Optimization (Recommended)', 'instagram-feed' ),
					'helpText' => __( 'Creates multiple local copies of image in different sizes and uses smallest size based on where it is displayed. ', 'instagram-feed' ) .'<strong>' . __( 'Uses local Wordpress storage.', 'instagram-feed' ) . '</strong>',
					'reset'    => __( 'Reset Image Storage', 'instagram-feed' ),
					'title'    => __( 'Use dynamic sizes', 'instagram-feed' ),
					'formatTitle' => __( 'Default Image Format', 'instagram-feed' ),
					'formats'  => array(
						'webp' => __( 'WebP', 'instagram-feed' ),
						'jpg' => __( 'JPG', 'instagram-feed' ),
					),
				),
				'usageBox'         => array(
					'title'    => __( 'Usage Tracking', 'instagram-feed' ),
					'helpText' => __( 'This helps to prevent plugin and theme conflicts by sending a report in the background once per week about your settings and relevant site stats. It does not send sensitive information like access tokens, email addresses, or user info. This will also not affect your site performace. <a href="' . $usage_tracking_url . '" target="_blank">Learn More</a>', 'instagram-feed' ),
				),
				'resetErrorBox' => array(
					'title' => __( 'Reset Error Log', 'instagram-feed' ),
					'helpText' => __( 'Clear all errors stored in the error log.', 'instagram-feed' ),
					'reset' => __( 'Reset', 'instagram-feed' ),
				),
				'ajaxBox'          => array(
					'title'    => __( 'AJAX theme loading fix', 'instagram-feed' ),
					'helpText' => __( 'Fixes issues caused by Ajax loading themes. It can also be used to workaround JavaScript errors on the page.', 'instagram-feed' ),
				),
				'ajaxInitial'      => array(
					'title'    => __( 'Load Initial Posts with AJAX', 'instagram-feed' ),
					'helpText' => __( 'Initial posts will be loaded using AJAX instead of added to the page directly. If you use page caching, this will allow the feed to update according to the "Check for new posts every" setting on the "Configure" tab.', 'instagram-feed' ),
				),
				'enqueueHead'      => array(
					'title'    => __( 'Enqueue JavaScript in head', 'instagram-feed' ),
					'helpText' => __( 'Add the JavaScript file for the plugin in the HTML "head" instead of the footer.', 'instagram-feed' ),
				),
				'enqueueShortcode' => array(
					'title'    => __( 'Enqueue CSS only on pages with the Feed', 'instagram-feed' ),
					'helpText' => '',
				),
				'jsImages'         => array(
					'title'    => __( 'JavaScript Image Loading', 'instagram-feed' ),
					'helpText' => __( 'Load images on the client side with JS, instead of server side.', 'instagram-feed' ),
				),
				'loadAjax'         => array(
					'title'    => __( 'Fix a text shortening issue caused by some themes', 'instagram-feed' ),
					'helpText' => __( 'Initial posts will be loaded using AJAX instead of added to the page directly. If you use page caching, this will allow the feed to update according to the "Check for new posts every" setting on the "Configure" tab.', 'instagram-feed' ),
				),
				'adminErrorBox'    => array(
					'title'    => __( 'Admin Error Notice', 'instagram-feed' ),
					'helpText' => __( 'This will disable or enable the feed error notice that displays in the bottom right corner of your site for logged-in admins.', 'instagram-feed' ),
				),
				'feedIssueBox'     => array(
					'title'       => __( 'Feed Issue Email Reports', 'instagram-feed' ),
					'helpText'    => __( 'If the feed is down due to a critical issue, we will switch to a cached version and notify you based on these settings. <a href="' . $feed_issue_email_url . '" target="_blank">View Documentation</a>', 'instagram-feed' ),
					'sendReport'  => __( 'Send a report every', 'instagram-feed' ),
					'to'          => __( 'to', 'instagram-feed' ),
					'placeholder' => __( 'Enter one or more email address separated by comma', 'instagram-feed' ),
					'weekDays'    => array(
						array(
							'val'   => 'monday',
							'label' => __( 'Monday', 'instagram-feed' ),
						),
						array(
							'val'   => 'tuesday',
							'label' => __( 'Tuesday', 'instagram-feed' ),
						),
						array(
							'val'   => 'wednesday',
							'label' => __( 'Wednesday', 'instagram-feed' ),
						),
						array(
							'val'   => 'thursday',
							'label' => __( 'Thursday', 'instagram-feed' ),
						),
						array(
							'val'   => 'friday',
							'label' => __( 'Friday', 'instagram-feed' ),
						),
						array(
							'val'   => 'saturday',
							'label' => __( 'Saturday', 'instagram-feed' ),
						),
						array(
							'val'   => 'sunday',
							'label' => __( 'Sunday', 'instagram-feed' ),
						),
					),
				),
				'dpaClear'         => array(
					'title'    => __( 'Manage Data', 'instagram-feed' ),
					'helpText' => __( 'Warning: Clicking this button will permanently delete all Instagram data, including all connected accounts, cached posts, and stored images.', 'instagram-feed' ),
					'clear'    => __( 'Delete all Platform Data', 'instagram-feed' ),
				),
			),
			'codeSnippetsTab' => array(
				'activateTitle' => __('Activate WPCode to use Smash Balloon Snippet library', 'instagram-feed'),
				'installTitle' => __('Install WPCode to use Smash Balloon Snippet library', 'instagram-feed'),
				'description' => __('Using WPCode you can install Smash Balloon code snippets with 1-click directly from this page or the WPCode library inside the WordPress admin.', 'instagram-feed'),
				'installButton' => __('One-click Install WPCode', 'instagram-feed'),
				'activateButton' => __('Activate WPCode', 'instagram-feed'),
				'learnMore' => __('Learn More', 'instagram-feed'),
				'editSnippet' => __('Edit Snippet', 'instagram-feed'),
				'useSnippet' => __('Use Snippet', 'instagram-feed'),
			),
			'dialogBoxPopupScreen' => array(
				'deleteSource' => array(
					'heading'       => __( 'Delete "#"?', 'instagram-feed' ),
					'description'   => __( 'This source is being used in a feed on your site. If you delete this source then new posts can no longer be retrieved for these feeds.', 'instagram-feed' ),
					'customButtons' => array(
						'confirm' => array(
							'text'  => __( 'Confirm', 'instagram-feed' ),
							'color' => 'blue',
						),
						'cancel'  => array(
							'text'  => __( 'Cancel', 'instagram-feed' ),
							'color' => 'red',
						),
					),
				),
			),
			'selectSourceScreen'   => \InstagramFeed\Builder\SBI_Feed_Builder::select_source_screen_text(),
			'uncannyAutomatorScreen' => array(
				'heading' => __( 'Automatically post from WordPress to Instagram with the #1 automation plugin', 'instagram-feed' ),
				'description' => __( 'Uncanny Automator lets you easily automate your WordPress site.  Automatically push new blog posts to your Instagram Business account (and Facebook and Twitter too).', 'instagram-feed' ),
				'integrationLogo' => SBI_PLUGIN_URL . '/admin/assets/img/instagram-with-uncanny-automator.png',
				'installStep' => array(
					'title' => __( 'Install and activate Uncanny Automator', 'instagram-feed' ),
					'description' => __( 'The plugin is installed from the Wordpress.org repository', 'instagram-feed' ),
					'icon' => SBI_PLUGIN_URL . '/admin/assets/img/uncanny-automator-logo.png',
				),
				'setupStep' => array(
					'title' => __( 'Set up Uncanny Automator', 'instagram-feed' ),
					'description' => __( 'Connect Uncanny Automator to your Instagram account', 'instagram-feed' ),
					'icon' => SBI_PLUGIN_URL . '/admin/assets/img/setup-uncanny-automator.png',
				),
				'shouldHideAutomatorNotice' => $should_hide_automtor_notice,
				'canInstallAutomatorPlugin' => $can_install_automator_plugin,
				'isPluginInstalled' => $get_sb_active_plugins_info['is_uncanny_automator_installed'],
				'isPluginActive' => is_plugin_active($get_sb_active_plugins_info['uncanny_automator_plugin']),
				'pluginDownloadPath' => $get_sb_active_plugins_info['uncanny_automator_download_plugin'],
				'automatorPlugin' => $get_sb_active_plugins_info['uncanny_automator_plugin'],
				'installSVG' => '<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.213 3.34015C11.2019 2.51003 9.96799 1.99743 8.66634 1.86682V3.21349C9.63967 3.33349 10.5263 3.72015 11.2663 4.29349L12.213 3.34015ZM13.2863 7.83349H14.633C14.4997 6.49349 13.9663 5.27349 13.1597 4.28682L12.2063 5.23349C12.7944 5.98679 13.1676 6.88523 13.2863 7.83349ZM12.2063 11.7668L13.1597 12.7202C13.9887 11.7084 14.5012 10.4748 14.633 9.17349H13.2863C13.1663 10.1194 12.7932 11.0153 12.2063 11.7668ZM8.66634 13.7868V15.1335C10.0063 15.0002 11.2263 14.4668 12.213 13.6602L11.2597 12.7068C10.5263 13.2802 9.63967 13.6668 8.66634 13.7868ZM10.393 7.56015L8.66634 9.28015V5.16682H7.33301V9.28015L5.60634 7.55349L4.66634 8.50015L7.99967 11.8335L11.333 8.50015L10.393 7.56015ZM7.33301 13.7868V15.1335C3.96634 14.8002 1.33301 11.9602 1.33301 8.50015C1.33301 5.04015 3.96634 2.20015 7.33301 1.86682V3.21349C4.69967 3.54015 2.66634 5.78015 2.66634 8.50015C2.66634 11.2202 4.69967 13.4602 7.33301 13.7868Z" fill="white"/></svg>',
				'enableSetupStep' => is_plugin_active($get_sb_active_plugins_info['uncanny_automator_plugin']),
				'setupPage' => '/edit.php?post_type=uo-recipe&page=uncanny-automator-config&tab=premium-integrations&integration=instagram'
			),
			'nextCheck'            => $this->get_cron_next_check(),
			'loaderSVG'            => '<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve"><path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h6.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite"/></path></svg>',
			'checkmarkSVG'         => '<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>',
			'checkmarCircleSVG'		=> '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"/></svg>',
			'timesSVG' 			   => '<svg  width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path fill="#fff" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"/></svg>',
			'uploadSVG'            => '<svg class="btn-icon" width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.166748 14.6667H11.8334V13H0.166748V14.6667ZM0.166748 6.33333H3.50008V11.3333H8.50008V6.33333H11.8334L6.00008 0.5L0.166748 6.33333Z" fill="#141B38"/></svg>',
			'exportSVG'            => '<svg class="btn-icon" width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.166748 14.6667H11.8334V13H0.166748V14.6667ZM11.8334 5.5H8.50008V0.5H3.50008V5.5H0.166748L6.00008 11.3333L11.8334 5.5Z" fill="#141B38"/></svg>',
			'reloadSVG'            => '<svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.8335 3.66667L12.5002 7H15.0002C15.0002 8.32608 14.4734 9.59785 13.5357 10.5355C12.598 11.4732 11.3262 12 10.0002 12C9.16683 12 8.3585 11.7917 7.66683 11.4167L6.45016 12.6333C7.51107 13.3085 8.74261 13.667 10.0002 13.6667C11.7683 13.6667 13.464 12.9643 14.7142 11.714C15.9644 10.4638 16.6668 8.76811 16.6668 7H19.1668L15.8335 3.66667ZM5.00016 7C5.00016 5.67392 5.52695 4.40215 6.46463 3.46447C7.40231 2.52678 8.67408 2 10.0002 2C10.8335 2 11.6418 2.20833 12.3335 2.58333L13.5502 1.36667C12.4893 0.691461 11.2577 0.332984 10.0002 0.333334C8.23205 0.333334 6.53636 1.03571 5.28612 2.28596C6.03587 3.5362 3.3335 5.23189 3.3335 7H0.833496L4.16683 10.3333L7.50016 7" fill="#141B38"/></svg>',
			'tooltipHelpSvg'       => '<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.1665 8H10.8332V6.33333H9.1665V8ZM9.99984 17.1667C6.32484 17.1667 3.33317 14.175 3.33317 10.5C3.33317 6.825 6.32484 3.83333 9.99984 3.83333C13.6748 3.83333 16.6665 6.825 16.6665 10.5C16.6665 14.175 13.6748 17.1667 9.99984 17.1667ZM9.99984 2.16666C8.90549 2.16666 7.82186 2.38221 6.81081 2.801C5.79976 3.21979 4.8811 3.83362 4.10728 4.60744C2.54448 6.17024 1.6665 8.28986 1.6665 10.5C1.6665 12.7101 2.54448 14.8298 4.10728 16.3926C4.8811 17.1664 5.79976 17.7802 6.81081 18.199C7.82186 18.6178 8.90549 18.8333 9.99984 18.8333C12.21 18.8333 14.3296 17.9554 15.8924 16.3926C17.4552 14.8298 18.3332 12.7101 18.3332 10.5C18.3332 9.40565 18.1176 8.32202 17.6988 7.31097C17.28 6.29992 16.6662 5.38126 15.8924 4.60744C15.1186 3.83362 14.1999 3.21979 13.1889 2.801C12.1778 2.38221 11.0942 2.16666 9.99984 2.16666ZM9.1665 14.6667H10.8332V9.66666H9.1665V14.6667Z" fill="#434960"/></svg>',
			'resetSVG'             => '<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.668 3.33317L10.0013 5.99984H12.0013C12.0013 7.0607 11.5799 8.07812 10.8297 8.82826C10.0796 9.57841 9.06217 9.99984 8.0013 9.99984C7.33463 9.99984 6.68797 9.83317 6.13463 9.53317L5.1613 10.5065C6.01003 11.0467 6.99526 11.3335 8.0013 11.3332C9.41579 11.3332 10.7723 10.7713 11.7725 9.77107C12.7727 8.77088 13.3346 7.41432 13.3346 5.99984H15.3346L12.668 3.33317ZM4.0013 5.99984C4.0013 4.93897 4.42273 3.92156 5.17287 3.17141C5.92302 2.42126 6.94044 1.99984 8.0013 1.99984C8.66797 1.99984 9.31464 2.1665 9.86797 2.4665L10.8413 1.49317C9.99257 0.953006 9.00734 0.666224 8.0013 0.666504C6.58681 0.666504 5.23026 1.22841 4.23007 2.2286C3.22987 3.2288 2.66797 4.58535 2.66797 5.99984H0.667969L3.33464 8.6665L6.0013 5.99984" fill="#141B38"/></svg>',
			'wpCode' => array(
				'snippets' => WPCode::load_snippets(),
				'pluginInstalled' => WPCode::is_plugin_installed(),
				'pluginActive' => WPCode::is_plugin_active(),
				'isProInstalled' => WPCode::is_pro_installed(),
				'pageUrl' => admin_url('admin.php?page=wpcode'),
			)
		);

		$newly_retrieved_source_connection_data = \InstagramFeed\Builder\SBI_Source::maybe_source_connection_data();
		if ( $newly_retrieved_source_connection_data ) {
			$sbi_settings['newSourceData'] = $newly_retrieved_source_connection_data;
		}
		if ( isset( $_GET['manualsource'] ) && $_GET['manualsource'] == true ) {
			$sbi_settings['manualSourcePopupInit'] = true;
		}

		wp_localize_script(
			'settings-app',
			'sbi_settings',
			$sbi_settings
		);
	}

	/**
	 * Get Extensions License Information
	 *
	 * @since 6.0
	 *
	 * @return array
	 */
	public function get_extensions_license() {
		return;

	}

	/**
	 * Get Links with UTM
	 *
	 * @return array
	 *
	 * @since 6.0
	 */
	public static function get_links_with_utm() {
		$license_key = null;
		if ( get_option( 'sbi_license_key' ) ) {
			$license_key = get_option( 'sbi_license_key' );
		}
		$all_access_bundle_popup = sprintf( 'https://smashballoon.com/all-access/?edd_license_key=%s&upgrade=true&utm_campaign=instagram-pro&utm_source=balloon&utm_medium=all-access', sanitize_key( $license_key ) );

		return array(
			'manageLicense' => 'https://smashballoon.com/account/downloads/?utm_campaign=instagram-pro&utm_source=settings&utm_medium=manage-license',
			'popup'         => array(
				'allAccessBundle' => $all_access_bundle_popup,
				'fbProfile'       => 'https://www.instagram.com/SmashBalloon/',
				'twitterProfile'  => 'https://twitter.com/smashballoon',
			),
		);
	}

	/**
	 * The Settings Data
	 *
	 * @since 6.0
	 *
	 * @return array
	 */
	public function get_settings_data() {
		$sbi_settings            = wp_parse_args( get_option( 'sb_instagram_settings' ), $this->default_settings_options() );
		$sbi_cache_cron_interval = $sbi_settings['sbi_cache_cron_interval'];
		$sbi_cache_cron_time     = $sbi_settings['sbi_cache_cron_time'];
		$sbi_cache_cron_am_pm    = $sbi_settings['sbi_cache_cron_am_pm'];
		$usage_tracking          = get_option(
			'sbi_usage_tracking',
			array(
				'last_send' => 0,
				'enabled'   => \sbi_is_pro_version(),
			)
		);
		$sbi_ajax                = $sbi_settings['sb_instagram_ajax_theme'];
		$active_gdpr_plugin      = \SB_Instagram_GDPR_Integrations::gdpr_plugins_active();
		$sbi_preserve_setitngs   = $sbi_settings['sb_instagram_preserve_settings'];
		$custom_css = '';
		$custom_js = '';

		if ( current_user_can( 'unfiltered_html' ) ) {
			$custom_css = isset( $sbi_settings['sb_instagram_custom_css'] ) ? wp_strip_all_tags( stripslashes( $sbi_settings['sb_instagram_custom_css'] ) ) : '';
			$custom_js = isset( $sbi_settings['sb_instagram_custom_js'] ) ? stripslashes( $sbi_settings['sb_instagram_custom_js'] ) : '';
		}
		return array(
			'general'  => array(
				'preserveSettings' => $sbi_preserve_setitngs,
			),
			'feeds'    => array(
				'cachingType'  => 'background',
				'cronInterval' => $sbi_cache_cron_interval,
				'cronTime'     => $sbi_cache_cron_time,
				'cronAmPm'     => $sbi_cache_cron_am_pm,
				'gdpr'         => $sbi_settings['gdpr'],
				'gdprPlugin'   => $active_gdpr_plugin,
				'customCSS'    => $custom_css,
				'customJS'     => $custom_js,
			),
			'advanced' => array(
				'sbi_enable_resize'            => ! $sbi_settings['sb_instagram_disable_resize'],
				'image_format'                 => $sbi_settings['image_format'],
				'usage_tracking'               => $usage_tracking['enabled'],
				'sbi_ajax'                     => $sbi_ajax,
				'sbi_ajax_initial'             => $sbi_settings['sb_ajax_initial'],
				'sbi_enqueue_js_in_head'       => $sbi_settings['enqueue_js_in_head'],
				'sbi_enqueue_css_in_shortcode' => $sbi_settings['enqueue_css_in_shortcode'],
				'sbi_enable_js_image_loading'  => ! $sbi_settings['disable_js_image_loading'],
				'enqueue_legacy_css'           => $sbi_settings['enqueue_legacy_css'],

				'enable_admin_notice'          => ! $sbi_settings['disable_admin_notice'],
				'enable_email_report'          => $sbi_settings['enable_email_report'],
				'email_notification'           => $sbi_settings['email_notification'],
				'email_notification_addresses' => $sbi_settings['email_notification_addresses'],
			),
		);
	}

	/**
	 * Return the default settings options for sbi_style_settings option
	 *
	 * @since 6.0
	 *
	 * @return array
	 */
	public function default_settings_options() {
		return sbi_defaults();
	}

	/**
	 * Get GDPR Automatic state information
	 *
	 * @since 6.0
	 *
	 * @return string $output
	 */
	public function get_gdpr_auto_info() {
		$gdpr_doc_url       = 'https://smashballoon.com/doc/instagram-feed-gdpr-compliance/?instagram';
		$output             = '';
		$active_gdpr_plugin = \SB_Instagram_GDPR_Integrations::gdpr_plugins_active();
		if ( $active_gdpr_plugin ) {
			$output = $active_gdpr_plugin;
		} else {
			$output = __( 'No GDPR consent plugin detected. Install a compatible <a href="' . $gdpr_doc_url . '" target="_blank">GDPR consent plugin</a>, or manually enable the setting to display a GDPR compliant version of the feed to all visitors.', 'instagram-feed' );
		}
		return $output;
	}

	/**
	 * SBI Get cron next check time
	 *
	 * @since 6.0
	 *
	 * @return string $output
	 */
	public function get_cron_next_check() {
		$output = '';

		if ( wp_next_scheduled( 'sbi_feed_update' ) ) {
			$time_format = get_option( 'time_format' );
			if ( ! $time_format ) {
				$time_format = 'g:i a';
			}
			//
			$schedule = wp_get_schedule( 'sbi_feed_update' );
			if ( $schedule === '30mins' ) {
				$schedule = __( 'every 30 minutes', 'instagram-feed' );
			}
			if ( $schedule === 'twicedaily' ) {
				$schedule = __( 'every 12 hours', 'instagram-feed' );
			}
			$sbi_next_cron_event = wp_next_scheduled( 'sbi_feed_update' );
			$output              = '<strong>' . __( 'Next check', 'instagram-feed' ) . ': ' . date( $time_format, $sbi_next_cron_event + sbi_get_utc_offset() ) . ' (' . $schedule . ')</strong> - ' . __( 'Note: Clicking "Clear All Caches" will reset this schedule.', 'instagram-feed' );
		} else {
			$output = __( 'Nothing currently scheduled', 'instagram-feed' );
		}

		return $output;
	}

	/**
	 * Settings Page View Template
	 *
	 * @since 6.0
	 */
	public function global_settings() {
		\InstagramFeed\SBI_View::render( 'settings.index' );
	}

}
