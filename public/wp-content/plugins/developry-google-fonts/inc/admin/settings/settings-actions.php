<?php
/**
 * [Short description]
 *
 * @package    DEVRY\WFL
 * @copyright  Copyright (c) 2025, Developry Ltd.
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU Public License
 * @since      1.3
 */

namespace DEVRY\WFL;

! defined( ABSPATH ) || exit; // Exit if accessed directly.

/**
 * [AJAX] Reset all the options on the their default values.
 */
function wfl_reset_options_default() {
	$wfl_admin = new WFL_Admin();

	$wfl_admin->get_invalid_nonce_token();
	$wfl_admin->get_invalid_user_cap();

	delete_option( 'wfl_body_font_family' );
	delete_option( 'wfl_body_font_weight' );
	delete_option( 'wfl_heading_1_font_family' );
	delete_option( 'wfl_heading_1_font_weight' );
	delete_option( 'wfl_heading_2_font_family' );
	delete_option( 'wfl_heading_2_font_weight' );
	delete_option( 'wfl_heading_3_font_family' );
	delete_option( 'wfl_heading_3_font_weight' );
	delete_option( 'wfl_heading_4_font_family' );
	delete_option( 'wfl_heading_4_font_weight' );
	delete_option( 'wfl_heading_5_font_family' );
	delete_option( 'wfl_heading_5_font_weight' );
	delete_option( 'wfl_heading_6_font_family' );
	delete_option( 'wfl_heading_6_font_weight' );

	// Additional settings.
	delete_option( 'wfl_compact_mode' );

	$wfl_admin->print_json_message(
		1,
		__( 'All options have been successfully reset to their default values.', 'developry-google-fonts' )
	);
}

add_action( 'wp_ajax_wfl_reset_options_default', __NAMESPACE__ . '\wfl_reset_options_default' );
