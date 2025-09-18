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

! defined( ABSPATH ) || exit; // Exit if accessed directly

/**
 * Don't allow to have both Free and Pro active at the same time.
 */
function wfl_check_pro_plugin() {
	// Deactitve the Pro version if active.
	if ( is_plugin_active( 'web-fonts-loader-pro/web-fonts-loader.php' ) ) {
		deactivate_plugins( 'web-fonts-loader-pro/web-fonts-loader.php', true );
	}
}

register_activation_hook( WFL_PLUGIN_BASENAME, __NAMESPACE__ . '\wfl_check_pro_plugin' );

/**
 * Display a promotion for the pro plugin.
 */
function wfl_display_upgrade_notice() {
	$wfl_admin = new WFL_Admin();

	if ( get_option( 'wfl_upgrade_notice', '' ) && get_transient( 'wfl_upgrade_plugin' ) ) {
		return;
	}
	?>
		<div class="notice notice-success is-dismissible wfl-admin">
			<!-- <p class="wfl-upgrade-notice-discount"> -->
				<?php
					// printf(
					// 	wp_kses(
					// 		/* translators: %1$s is replaced with "WFL10" */
					// 		/* translators: %2$s is replaced with "10% off" */
					// 		__( 'Use the %1$s promo code and get %2$s your purchase!', 'developry-google-fonts' ),
					// 		json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
					// 	),
					// 	'<code>' . esc_html__( 'WFL10', 'developry-google-fonts' ) . '</code>',
					// 	'<strong>' . esc_html__( '10% off', 'developry-google-fonts' ) . '</strong>'
					// );
				?>
			<!-- </p> -->
			<h3>
				<?php echo esc_html__( 'Web Fonts Loader PRO 🚀', 'developry-google-fonts' ); ?>
			</h3>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %1$s is replaced with "Found the free version helpful" */
						/* translators: %2$s is replaced with "Web Fonts Loader Pro" */
						__( '✨🎉📢 %1$s? Would you like to learn more about the benefits of upgrading to %2$s?', 'developry-google-fonts' ),
						json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
					),
					'<strong>' . esc_html__( 'Found the free version helpful', 'developry-google-fonts' ) . '</strong>',
					'<strong>' . esc_html__( 'Web Fonts Loader Pro', 'developry-google-fonts' ) . '</strong>'
				);
				?>
			</p>
			<div class="button-group">
				<a href="https://bit.ly/3vlhkIm" target="_blank" class="button button-primary button-success">
					<?php echo esc_html__( 'Go Pro', 'developry-google-fonts' ); ?>
					<i class="dashicons dashicons-external"></i>
				</a>
				<a href="<?php echo esc_url( admin_url( $wfl_admin->admin_page . WFL_SETTINGS_SLUG . '&_wpnonce=' . wp_create_nonce( 'wfl_upgrade_notice_nonce' ) . '&action=wfl_dismiss_upgrade_notice' ) ); ?>" class="button">
					<?php echo esc_html__( 'I already did', 'developry-google-fonts' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( $wfl_admin->admin_page . WFL_SETTINGS_SLUG . '&_wpnonce=' . wp_create_nonce( 'wfl_upgrade_notice_nonce' ) . '&action=wfl_dismiss_upgrade_notice' ) ); ?>" class="button">
					<?php echo esc_html__( "Don't show this notice again!", 'developry-google-fonts' ); ?>
				</a>
			</div>
		</div>
	<?php
	delete_option( 'wfl_upgrade_notice' );

	// Set the transient to last for 30 days.
	set_transient( 'wfl_upgrade_plugin', true, 30 * DAY_IN_SECONDS );
}
