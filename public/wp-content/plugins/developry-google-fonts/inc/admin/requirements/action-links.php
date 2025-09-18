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
 * Add settings link after plugin activation under Plugins.
 */
function wfl_add_action_links( $links, $file_path ) {
	$wfl_admin = new WFL_Admin();

	if ( WFL_PLUGIN_BASENAME === $file_path ) {
		$links['wfl-settings'] = '<a href="'
			. esc_url( admin_url( $wfl_admin->admin_page . WFL_SETTINGS_SLUG ) ) . '">'
			. esc_html__( 'Settings', 'developry-google-fonts' )
			. '</a>';

		$links['wfl-upgrade'] = '<a href="https://bit.ly/48SENi6" target="_blank">'
		. esc_html__( 'Go Pro', 'developry-google-fonts' )
		. '</a>';

		return array_reverse( $links );
	}

	return $links;
}
