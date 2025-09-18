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
 * Register the Options form fields.
 */
function wfl_register_options_fields() {
	// Register settings option groups.
	register_setting( WFL_SETTINGS_SLUG, 'wfl_body_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_body_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_1_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_1_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_2_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_2_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_3_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_3_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_4_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_4_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_5_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_5_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_6_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_6_font_weight' );

	// Register settings sanititze methods.
	register_setting( WFL_SETTINGS_SLUG, 'wfl_body_font_family', __NAMESPACE__ . '\wfl_sanitize_body_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_body_font_weight', __NAMESPACE__ . '\wfl_sanitize_body_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_1_font_family', __NAMESPACE__ . '\wfl_sanitize_heading_1_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_1_font_weight', __NAMESPACE__ . '\wfl_sanitize_heading_1_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_2_font_family', __NAMESPACE__ . '\wfl_sanitize_heading_2_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_2_font_weight', __NAMESPACE__ . '\wfl_sanitize_heading_2_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_3_font_family', __NAMESPACE__ . '\wfl_sanitize_heading_3_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_3_font_weight', __NAMESPACE__ . '\wfl_sanitize_heading_3_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_4_font_family', __NAMESPACE__ . '\wfl_sanitize_heading_4_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_4_font_weight', __NAMESPACE__ . '\wfl_sanitize_heading_4_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_5_font_family', __NAMESPACE__ . '\wfl_sanitize_heading_5_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_5_font_weight', __NAMESPACE__ . '\wfl_sanitize_heading_5_font_weight' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_6_font_family', __NAMESPACE__ . '\wfl_sanitize_heading_6_font_family' );
	register_setting( WFL_SETTINGS_SLUG, 'wfl_heading_6_font_weight', __NAMESPACE__ . '\wfl_sanitize_heading_6_font_weight' );

	// Register addtional settings sanitize methods.
	register_setting( WFL_SETTINGS_SLUG, 'wfl_compact_mode', __NAMESPACE__ . '\wfl_sanitize_compact_mode' );
}

add_action( 'admin_init', __NAMESPACE__ . '\wfl_register_options_fields' );
