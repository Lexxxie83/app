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
 * Display a notice encouraging users to rate the plugin
 * on WordPress.org and provide options to dismiss the notice.
 */
function wfl_display_rating_notice() {
	$wfl_admin = new WFL_Admin();

	$current_screen = get_current_screen();

	if ( ! get_option( 'wfl_rating_notice', '' ) && strpos( $current_screen->id, 'wfl_' ) ) {
		?>
			<div class="notice notice-info is-dismissible wfl-admin">
				<h3>
					<?php echo esc_html( WFL_PLUGIN_NAME ); ?>
				</h3>
				<p>
					<?php
					printf(
						wp_kses(
							/* translators: %1$s is replaced with "by giving it 5 stars rating" */
							__( '✨💪🔌 Could you kindly support the plugin by %1$s? Thank you in advance!', 'developry-google-fonts' ),
							json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
						),
						'<strong>' . esc_html__( 'by giving it 5 stars rating', 'developry-google-fonts' ) . '</strong>'
					);
					?>
				</p>
				<div class="button-group">
					<a href="<?php echo esc_url( WFL_PLUGIN_WPORG_RATE ); ?>" target="_blank" class="button button-primary">
						<?php echo esc_html__( 'Rate us @ WordPress.org', 'developry-google-fonts' ); ?>
						<i class="dashicons dashicons-external"></i>
					</a>
					<a href="<?php echo esc_url( admin_url( $wfl_admin->admin_page . WFL_SETTINGS_SLUG . '&_wpnonce=' . wp_create_nonce( 'wfl_rating_notice_nonce' ) . '&action=wfl_dismiss_rating_notice' ) ); ?>" class="button">
						<?php echo esc_html__( 'I already did', 'developry-google-fonts' ); ?>
					</a>
					<a href="<?php echo esc_url( admin_url( $wfl_admin->admin_page . WFL_SETTINGS_SLUG . '&_wpnonce=' . wp_create_nonce( 'wfl_rating_notice_nonce' ) . '&action=wfl_dismiss_rating_notice' ) ); ?>" class="button">
						<?php echo esc_html__( "Don't show this notice again!", 'developry-google-fonts' ); ?>
					</a>
				</div>
			</div>
		<?php
	}
}
