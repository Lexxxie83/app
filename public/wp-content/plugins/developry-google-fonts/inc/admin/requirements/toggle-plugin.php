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
 * Activate plugin trigger.
 */
function wfl_activate_plugin( $plugin_file_path ) {
	if ( WFL_PLUGIN_BASENAME === $plugin_file_path ) {
	}
}

add_action( 'activated_plugin', __NAMESPACE__ . '\wfl_activate_plugin' );

/**
 * Deactivate plugin trigger.
 */
function wfl_deactivate_plugin( $plugin_file_path ) {
	if ( WFL_PLUGIN_BASENAME === $plugin_file_path ) {
		delete_option( 'wfl_rating_notice' );
		delete_option( 'wfl_upgrade_notice' );
	}
}

add_action( 'deactivated_plugin', __NAMESPACE__ . '\wfl_deactivate_plugin' );
