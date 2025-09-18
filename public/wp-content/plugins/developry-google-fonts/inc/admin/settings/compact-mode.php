<?php
/**
 * [Short description]
 *
 * @package    DEVRY\WFL
 * @copyright  Copyright (c) 2025, Developry Ltd.
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU Public License
 * @since      1.5
 */

namespace DEVRY\WFL;

! defined( ABSPATH ) || exit; // Exit if accessed directly.

/**
 * Display the setting.
 */
function wfl_display_compact_mode() {
	$wfl = new Web_Fonts_Loader();

	$compact_mode = get_option( 'wfl_compact_mode', $wfl->compact_mode );

	// Compact mode option if empty or non-existent then No, otherwise Yes.
	if ( 'yes' === $compact_mode ) {
		$compact_mode = 'selected';
	}

	printf(
		'<select id="wfl-compact-mode" name="wfl_compact_mode">
			<option value="">No</option>
			<option value="yes" %1$s>Yes</option>
		</select>',
		esc_attr( $compact_mode )
	);
	?>
		<p class="description">
			<small>
				<?php echo esc_html__( 'Compact mode moves the plugin access link under Appearance.', 'developry-google-fonts' ); ?>
			</small>
		</p>
	<?php
}

/**
 * Sanitize and update option.
 */
function wfl_sanitize_compact_mode( $compact_mode ) {
	// Verify the nonce.
	$_wpnonce = ( isset( $_REQUEST['wfl_wpnonce'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['wfl_wpnonce'] ) ) : '';

	if ( empty( $_wpnonce ) || ! wp_verify_nonce( $_wpnonce, 'wfl_settings_nonce' ) ) {
		return;
	}

	// Nothing selected.
	if ( empty( $compact_mode ) ) {
		return;
	}

	// Option changed and updated.
	if ( ! get_transient( 'wfl_settings_compact_mode' )
		&& get_option( 'wfl_compact_mode', '' ) !== $compact_mode ) {
		add_settings_error(
			'wfl_settings_errors',
			'wfl_settings_compact_mode',
			esc_html__( 'Compact mode option was updated successfully.', 'developry-google-fonts' ),
			'updated'
		);

		// Add transient to avoid double notice on initial Save when using settings_errors().
		set_transient( 'wfl_settings_compact_mode', true, 5 );
	}

	return sanitize_text_field( wp_unslash( $compact_mode ) );
}
