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
 * Display the setting.
 */
function wfl_display_heading_5_font_family() {
	$wfl = new Web_Fonts_Loader();

	$heading_5_font_family = $wfl->load_admin_global_font_options( 'font-family', get_option( 'wfl_heading_5_font_family', $wfl->heading_5_font_family ) );
	$heading_5_font_weight = $wfl->load_admin_global_font_options( 'font-weight', get_option( 'wfl_heading_5_font_weight', $wfl->heading_5_font_weight ) );

	printf(
		'<select id="wfl-heading-5-font-family" name="wfl_heading_5_font_family">
			<option value="">- Select Font Family -</option>
			%1$s
		</select>',
		wp_kses( $heading_5_font_family, json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true ) )
	);

	printf(
		'&nbsp;<select id="wfl-heading-5-font-weight" name="wfl_heading_5_font_weight">
			<option value="">- Select Font Weight -</option>
			%1$s
		</select>',
		wp_kses( $heading_5_font_weight, json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true ) )
	);
	?>
	<p class="description">
		<small>
			<?php echo esc_html__( 'Add the Heading 5 font family and weight settings in the global space for unified typography.', 'developry-google-fonts' ); ?>
		</small>
	</p>
	<?php
}

/**
 * Sanitize and update option.
 */
function wfl_sanitize_heading_5_font_family( $heading_5_font_family ) {
	// Verify the nonce.
	$_wpnonce = ( isset( $_REQUEST['wfl_wpnonce'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['wfl_wpnonce'] ) ) : '';

	if ( empty( $_wpnonce ) || ! wp_verify_nonce( $_wpnonce, 'wfl_settings_nonce' ) ) {
		return;
	}

	// Nothing selected.
	if ( empty( $heading_5_font_family ) ) {
		return;
	}

	// Option changed and updated.
	if ( ! get_transient( 'wfl_settings_heading_5_font_family' )
		&& get_option( 'wfl_heading_5_font_family' ) !== $heading_5_font_family ) {
		add_settings_error(
			'wfl_settings_errors',
			'wfl_settings_heading_5_font_family',
			esc_html__( 'Heading 5 font family option was updated successfully.', 'developry-google-fonts' ),
			'updated'
		);

		// Add transient to avoid double notice on initial Save when using settings_errors().
		set_transient( 'wfl_settings_heading_5_font_family', true, 5 );
	}

	return sanitize_text_field( wp_unslash( $heading_5_font_family ) );
}

/**
 * Sanitize and update option.
 */
function wfl_sanitize_heading_5_font_weight( $heading_5_font_weight ) {
	// Verify the nonce.
	$_wpnonce = ( isset( $_REQUEST['wfl_wpnonce'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['wfl_wpnonce'] ) ) : '';

	if ( empty( $_wpnonce ) || ! wp_verify_nonce( $_wpnonce, 'wfl_settings_nonce' ) ) {
		return;
	}

	// Nothing selected.
	if ( empty( $heading_5_font_weight ) ) {
		return;
	}

	// Option changed and updated.
	if ( ! get_transient( 'wfl_settings_heading_5_font_weight' )
		&& get_option( 'wfl_heading_5_font_weight' ) !== $heading_5_font_weight ) {
		add_settings_error(
			'wfl_settings_errors',
			'wfl_settings_heading_5_font_weight',
			esc_html__( 'Heading 5 font weight option was updated successfully.', 'developry-google-fonts' ),
			'updated'
		);

		// Add transient to avoid double notice on initial Save when using settings_errors().
		set_transient( 'wfl_settings_heading_5_font_weight', true, 5 );
	}

	return sanitize_text_field( wp_unslash( $heading_5_font_weight ) );
}
