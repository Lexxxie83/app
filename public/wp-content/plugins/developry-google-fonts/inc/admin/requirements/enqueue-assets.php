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
 * Enqueue frontend assets below.
 */
function wfl_enqueue_frontend_assets() {
	$wfl = new Web_Fonts_Loader();

	if ( ! is_admin() ) {
		wp_enqueue_style(
			'wfl-frontend',
			WFL_PLUGIN_DIR_URL . 'assets/dist/css/wfl-frontend.min.css',
			array(),
			WFL_PLUGIN_VERSION,
			'all'
		);

		wp_enqueue_script(
			'wfl-frontend',
			WFL_PLUGIN_DIR_URL . 'assets/dist/js/wfl-frontend.min.js',
			array( 'jquery', 'wfl-webfont' ),
			WFL_PLUGIN_VERSION,
			true
		);

		wp_enqueue_script(
			'wfl-webfont',
			WFL_PLUGIN_DIR_URL . 'assets/dist/js/lib/webfont.min.js',
			array(),
			WFL_PLUGIN_VERSION,
			true
		);

		$wfl->load_frontend_fonts( 'wfl-frontend' );
	}
}

/**
 * Enqueue frontend assets after theme setup.
 */
function wfl_after_theme_setup() {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\wfl_enqueue_frontend_assets', 1001 );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\wfl_after_theme_setup' );

/**
 * Enqueue admin assets below.
 */
function wfl_enqueue_admin_assets() {
	if ( ! is_admin() ) {
		return;
	}

	$wfl = new Web_Fonts_Loader();

	// Load assets only for page page staring with prefix wfl-.
	// $current_screen = get_current_screen();
	// if ( strpos( $current_screen->id, 'wfl_' ) ) {}
	// Load some style to the TinyMCE editor as CSS file.
	// add_editor_style( WFL_PLUGIN_DIR_URL . 'assets/dist/css/wfl-admin.min.css' );

	$default_google_fonts = array( 'dgs' => '— GOOGLE FONTS —' );
	$default_system_fonts = array( 'dss' => '— SYSTEM FONTS —' );

	$default_google_fonts = array_merge( $default_google_fonts, (array) json_decode( WFL_GOOGLE_FONT_FAMILY, true ) );
	$default_system_fonts = array_merge( $default_system_fonts, (array) json_decode( WFL_SYSTEM_FONT_FAMILY, true ) );

	$default_fonts = array_merge(
		array( 'google' => $default_google_fonts ),
		array( 'system' => $default_system_fonts )
	);

	wp_enqueue_style(
		'wfl-admin',
		WFL_PLUGIN_DIR_URL . 'assets/dist/css/wfl-admin.min.css',
		array(),
		WFL_PLUGIN_VERSION,
		'all'
	);

	wp_enqueue_script(
		'wfl-admin',
		WFL_PLUGIN_DIR_URL . 'assets/dist/js/wfl-admin.min.js',
		array( 'jquery' ),
		WFL_PLUGIN_VERSION,
		true
	);

	wp_localize_script(
		'wfl-admin',
		'wfl',
		array(
			'plugin_url'                  => WFL_PLUGIN_DIR_URL,
			'plugin_domain'               => WFL_PLUGIN_DOMAIN,
			'ajax_url'                    => esc_url( admin_url( 'admin-ajax.php' ) ),
			'ajax_nonce'                  => wp_create_nonce( 'wfl_ajax_nonce' ),
			'default_fonts'               => $default_fonts,
			'google_font_weight_variants' => (array) json_decode( WFL_GOOGLE_FONT_WEIGHTS, true ),
		)
	);

	$wfl->load_global_fonts( 'wfl-admin' );

	// Add additional dynamic custom style inside the TinyMCE editor using the default, user-defined, and custom fonts.
	add_filter( 'tiny_mce_before_init', array( $wfl, 'load_tinymce_fonts' ) );

	$mce_external_plugins = function( $plugins ) {
		if ( wp_script_is( 'wfl-admin', 'enqueued' ) ) {
			$plugins['WFL'] = WFL_PLUGIN_DIR_URL . 'assets/dist/js/wfl-admin.min.js';
		}
		return $plugins;
	};

	$mce_buttons = function( $buttons ) {
		array_unshift(
			$buttons,
			'fontFamilyButton',
			'fontWeightButton',
			'cleanCustomClassesButton'
		);
		return $buttons;
	};

	// Load the following assest only for the TinyMCE editor.
	add_filter( 'mce_external_plugins', $mce_external_plugins );
	add_action( 'mce_buttons', $mce_buttons );
}
