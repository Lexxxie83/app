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

$wfl_admin = new WFL_Admin();

$has_user_cap = $wfl_admin->check_user_cap();

?>
<div class="wfl-admin">
	<div class="wfl-loading-bar"></div>
	<div class="wfl-pro">
		<h4>
			<?php echo esc_html__( 'Get the PRO version today!', 'developry-google-fonts' ); ?>
		</h4>
		<p>
			<?php echo esc_html__( 'The PRO version will unlock more features, including Google API and Block Editor integrations.', 'developry-google-fonts' ); ?>
		</p>
		<table>
			<tr>
				<th><?php echo esc_html__( 'Feature', 'developry-google-fonts' ); ?></th>
				<th><?php echo esc_html__( 'Free', 'developry-google-fonts' ); ?></th>
				<th><?php echo esc_html__( 'PRO', 'developry-google-fonts' ); ?></th>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Use Google Developer API	', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Manage Global fonts	', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes w/ custom rules', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Font manager (delete, download, & @import)	', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Classic editor support	', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Block editor support', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Load any custom fonts locally (EU/GDPR)', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'User-defined Google & system fonts', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'User-defined Gutenberg blocks', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Include Google italic fonts', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Select from supported subsets', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Font usage summary & report', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Priority email support', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'no', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'yes', 'developry-google-fonts' ); ?></td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Regular plugin updates', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'delayed', 'developry-google-fonts' ); ?></td>
				<td><?php echo esc_html__( 'first release', 'developry-google-fonts' ); ?></td>
			</tr>
		</table>
		<p class="button-group">
			<a
				class="button button-primary button-pro"
				href="https://bit.ly/4acZDd6"
				target="_blank"
			>
				<?php echo esc_html__( 'GET PRO VERSION', 'developry-google-fonts' ); ?>
			</a>
			<a
				class="button button-primary button-watch-video"
				href="https://www.youtube.com/watch?v=LEEL6ctwI_w"
				target="_blank"
			>
				<?php echo esc_html__( 'Watch Video', 'developry-google-fonts' ); ?>
			</a>
		</p>
	</div>
	<h2>
		<?php echo esc_html__( 'Web Fonts Loader', 'developry-google-fonts' ); ?>
	</h2>
	<p>
		<?php
		printf(
			wp_kses(
				__( 'Elevate your WordPress site with access to the complete range of Google Fonts for enhanced typography and design.', 'developry-google-fonts' ),
				json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
			),
		);
		?>
	</p>
	<p>
		<?php
		printf(
			wp_kses(
				/* translators: %1$s is replaced with "Classic" */
				__( 'Set or add global font styles across your site. Style content directly in the %1$s editor, overriding the global font options.', 'developry-google-fonts' ),
				json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
			),
			'<strong>' . esc_html__( 'Classic', 'developry-google-fonts' ) . '</strong>'
		);
		?>
	</p>
	<hr />
	<p>
		<?php
		printf(
			wp_kses(
				/* translators: %1$s is replaced with "Note" */
				__( '%1$s: Use the form below to assign global font options to a specific tag or class name for your entire site.', 'developry-google-fonts' ),
				json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
			),
			'<strong>' . esc_html__( 'Note', 'developry-google-fonts' ) . '</strong>'
		);
		?>
	</p>
	<form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>">
		<div id="wfl-output" class="notice is-dismissible wfl-output"></div>
		<?php settings_errors( 'wfl_settings_errors' ); ?>
		<?php wp_nonce_field( 'wfl_settings_nonce', 'wfl_wpnonce' ); ?>
		<?php
			settings_fields( WFL_SETTINGS_SLUG );
			do_settings_sections( WFL_SETTINGS_SLUG );
		?>
		<div class="submit button-group">
			<p class="submit button-group">
				<button
					type="submit"
					class="button button-primary"
					id="submit-button"
					name="submit-button"
				>
					<?php echo esc_html__( 'Save', 'developry-google-fonts' ); ?>
				</button>
				<button
					type="button"
					class="button"
					id="wfl-reset-button"
					name="wfl-reset-button"
				>
					<?php echo esc_html__( 'Reset', 'developry-google-fonts' ); ?>
				</button>
			</p>
		</div>
	</form>
	<br clear="all" />
	<hr />
	<div class="wfl-support-credits">
		<p>
			<?php
			printf(
				wp_kses(
					/* translators: %1$s is replaced with "Support Forum" */
					__( '* All styles applied via the Classic or Block editors will override the Global font options; some of the default classes are Bootstrap specific so if you have the framework loaded it will apply the selected fonts as well.', 'developry-google-fonts' ),
					json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
				),
				'<a href="' . esc_url( WFL_PLUGIN_WPORG_SUPPORT ) . '" target="_blank">' . esc_html__( 'Support Forum', 'developry-google-fonts' ) . '</a>'
			);
			?>
		</p>
		<p>
			<strong><?php echo esc_html__( 'Please rate us', 'developry-google-fonts' ); ?></strong>
			<a href="<?php echo esc_url( WFL_PLUGIN_WPORG_RATE ); ?>" target="_blank">
				<img src="<?php echo esc_url( WFL_PLUGIN_DIR_URL ); ?>assets/dist/img/rate.png" alt="Rate us @ WordPress.org" />
			</a>
		</p>
		<p>
			<strong><?php echo esc_html__( 'Having issues?', 'developry-google-fonts' ); ?></strong> 
			<a href="<?php echo esc_url( WFL_PLUGIN_WPORG_SUPPORT ); ?>" target="_blank">
				<?php echo esc_html__( 'Create a Support Ticket', 'developry-google-fonts' ); ?>
			</a>
		</p>
		<p>
			<strong><?php echo esc_html__( 'Developed by', 'developry-google-fonts' ); ?></strong>
			<a href="https://krasenslavov.com/" target="_blank">
				<?php echo esc_html__( 'Krasen Slavov @ Developry', 'developry-google-fonts' ); ?>
			</a>
		</p>
		<p>
			<small>
				<?php echo esc_html__( '* Styles applied through the Classic or Block editors will override the Global font options. Some default classes are Bootstrap-specific, so if the framework is loaded, the selected fonts will also be applied.', 'developry-google-fonts' ); ?>
			</small>
		</p>
	</div>
	<hr />
	<p>
		<small>
			<?php
			printf(
				wp_kses(
					/* translators: %1$s is replaced with "help and support me on Patreon" */
					__( '* For the price of a cup of coffee per month, you can %1$s to support the development and maintenance of my free WordPress plugins. Every bit helps and is greatly appreciated!', 'developry-google-fonts' ),
					json_decode( WFL_PLUGIN_ALLOWED_HTML_ARR, true )
				),
				'<a href="https://patreon.com/krasenslavov" target="_blank">' . esc_html__( 'help and support me on Patreon', 'developry-google-fonts' ) . '</a>'
			);
			?>
		</small>
	</p>
</div>
