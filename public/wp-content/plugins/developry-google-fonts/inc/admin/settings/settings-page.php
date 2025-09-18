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
 * Display the web fonts loader page layout.
 */
function wfl_display_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	add_settings_section(
		WFL_SETTINGS_SLUG,
		'Settings',
		'',
		WFL_SETTINGS_SLUG
	);

	// Add setting field for body font family.
	add_settings_field(
		'wfl_body_font_family',
		'<label for="wfl-body-font-family">'
			. __( 'Body (p, ul, ol, etc.)', 'developry-google-fonts' )
			. '</label>',
		__NAMESPACE__ . '\wfl_display_body_font_family',
		WFL_SETTINGS_SLUG,
		WFL_SETTINGS_SLUG,
	);

	// Add setting field for heading 1.
	add_settings_field(
		'wfl_heading_1_font_family',
		'<label for="wfl-heading-1-font-family">'
			. __( 'Heading 1 (h1, .h1, .display-1)', 'developry-google-fonts' )
			. '</label>',
		__NAMESPACE__ . '\wfl_display_heading_1_font_family',
		WFL_SETTINGS_SLUG,
		WFL_SETTINGS_SLUG,
	);

	// Add setting field for heading 2.
	add_settings_field(
		'wfl_heading_2_font_family',
		'<label for="wfl-heading-2-font-family">'
			. __( 'Heading 2 (h2, .h2, .display-2)', 'developry-google-fonts' )
			. '</label>',
		__NAMESPACE__ . '\wfl_display_heading_2_font_family',
		WFL_SETTINGS_SLUG,
		WFL_SETTINGS_SLUG,
	);

	// Add setting field for heading 3.
	add_settings_field(
		'wfl_heading_3_font_family',
		'<label for="wfl-heading-3-font-family">'
			. __( 'Heading 3 (h3, .h3, .display-3)', 'developry-google-fonts' )
			. '</label>',
		__NAMESPACE__ . '\wfl_display_heading_3_font_family',
		WFL_SETTINGS_SLUG,
		WFL_SETTINGS_SLUG,
	);

	// Add setting field for heading 4.
	add_settings_field(
		'wfl_heading_4_font_family',
		'<label for="wfl-heading-4-font-family">'
			. __( 'Heading 4 (h4, .h4, .display-4)', 'developry-google-fonts' )
			. '</label>',
		__NAMESPACE__ . '\wfl_display_heading_4_font_family',
		WFL_SETTINGS_SLUG,
		WFL_SETTINGS_SLUG,
	);

	// Add setting field for heading 5.
	add_settings_field(
		'wfl_heading_5_font_family',
		'<label for="wfl-heading-5-font-family">'
			. __( 'Heading 5 (h5, .h5, .display-5)', 'developry-google-fonts' )
			. '</label>',
		__NAMESPACE__ . '\wfl_display_heading_5_font_family',
		WFL_SETTINGS_SLUG,
		WFL_SETTINGS_SLUG,
	);

	// Add setting field for heading 6.
	add_settings_field(
		'wfl_heading_6_font_family',
		'<label for="wfl-heading-6-font-family">'
			. __( 'Heading 6 (h6, .h6, .display-6)', 'developry-google-fonts' )
			. '</label>',
		__NAMESPACE__ . '\wfl_display_heading_6_font_family',
		WFL_SETTINGS_SLUG,
		WFL_SETTINGS_SLUG,
	);

		// Add setting field for compact mode.
		add_settings_field(
			'wfl_compact_mode',
			'<label for="wfl-compact_mode">'
				. __( 'Compact Mode', 'developry-google-fonts' )
				. '</label>',
			__NAMESPACE__ . '\wfl_display_compact_mode',
			WFL_SETTINGS_SLUG,
			WFL_SETTINGS_SLUG,
		);

	require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/settings/settings-main-page.php';
}
