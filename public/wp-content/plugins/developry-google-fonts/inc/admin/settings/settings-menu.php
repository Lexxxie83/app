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
 * Add the block editor search & replace page to the admin menu.
 */
function wfl_add_menu() {
	$wfl = new Web_Fonts_Loader();

	if ( '' === $wfl->compact_mode ) {
		add_menu_page(
			esc_html__( 'Web Fonts Loader', 'developry-google-fonts' ),
			esc_html__( 'Web Fonts Loader', 'developry-google-fonts' ),
			'manage_options',
			WFL_SETTINGS_SLUG,
			__NAMESPACE__ . '\wfl_display_page',
			'dashicons-editor-textcolor',
			59.999
		);
	} else {
		add_submenu_page(
			'themes.php',
			esc_html__( 'Web Fonts Loader', 'developry-google-fonts' ),
			esc_html__( 'Web Fonts Loader', 'developry-google-fonts' ),
			'manage_options',
			WFL_SETTINGS_SLUG,
			__NAMESPACE__ . '\wfl_display_page'
		);
	}
}

add_action( 'admin_menu', __NAMESPACE__ . '\wfl_add_menu', 1000 );
