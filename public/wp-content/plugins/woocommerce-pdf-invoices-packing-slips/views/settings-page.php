<?php defined( 'ABSPATH' ) or exit; ?>
<?php

if ( ! wp_verify_nonce( $nonce, 'wp_wcpdf_settings_page_nonce' ) ) {
	wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'woocommerce-pdf-invoices-packing-slips' ) );
}

$review_url        = 'https://wordpress.org/support/plugin/woocommerce-pdf-invoices-packing-slips/reviews/#new-post';
$review_link       = sprintf( '<a href="%s">★★★★★</a>', $review_url );
$review_invitation = sprintf(
	/* translators: ★★★★★ (5-star) */
	__( 'If you like <strong>PDF Invoices & Packing Slips for WooCommerce</strong> please leave us a %s rating. A huge thank you in advance!', 'woocommerce-pdf-invoices-packing-slips' ),
	$review_link
);
$active_tab        = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : $default_tab;
$active_section    = isset( $_GET['section'] ) ? sanitize_text_field( wp_unslash( $_GET['section'] ) ) : '';
?>
<script type="text/javascript">
	jQuery( function( $ ) {
		$("#footer-thankyou").html('<?php echo wp_kses_post( $review_invitation ); ?>');
	});
</script>
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2><?php esc_html_e( 'PDF Invoices & Packing Slips for WooCommerce', 'woocommerce-pdf-invoices-packing-slips' ); ?></h2>
	<h2 class="nav-tab-wrapper">
	<?php
	foreach ( $settings_tabs as $tab_slug => $tab_data ) {
		$tab_title = is_array( $tab_data ) ? esc_html( $tab_data['title'] ) : esc_html( $tab_data );
		$tab_link  = esc_url( "?page=wpo_wcpdf_options_page&tab={$tab_slug}" );
		$tab_beta  = isset( $tab_data['beta'] ) ? true : false;
		if ( $tab_beta ) {
			$tab_title .= ' <sup class="wcpdf_beta">beta</sup>';
		}
		printf(
			'<a href="%1$s" class="nav-tab nav-tab-%2$s %3$s">%4$s</a>',
			esc_url( $tab_link ),
			esc_attr( $tab_slug ),
			( ( $active_tab === $tab_slug ) ? 'nav-tab-active' : '' ),
			wp_kses_post( $tab_title )
		);
	}
	?>
	</h2>

	<?php
	do_action( 'wpo_wcpdf_before_settings_page', $active_tab, $active_section, $nonce );

	// save or check option to hide extensions ad
	if ( isset( $_REQUEST['wpo_wcpdf_hide_extensions_ad'] ) && isset( $_REQUEST['_wpnonce'] ) ) {
		// validate nonce
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'hide_extensions_ad_nonce' ) ) {
			wcpdf_log_error( 'You do not have sufficient permissions to perform this action: wpo_wcpdf_hide_extensions_ad' );
			$hide_ad = false;
		} else {
			update_option( 'wpo_wcpdf_hide_extensions_ad', true );
			$hide_ad = true;
		}
	} else {
		$hide_ad = get_option( 'wpo_wcpdf_hide_extensions_ad' );
	}

	// to improve later: https://github.com/wpovernight/woocommerce-pdf-invoices-packing-slips/issues/677
	// if ( ! $hide_ad && ! ( class_exists( 'WooCommerce_PDF_IPS_Pro' ) && class_exists( 'WooCommerce_PDF_IPS_Templates' ) && class_exists( 'WooCommerce_Ext_PrintOrders' ) ) ) {
	// 	include( 'extensions.php' );
	// }

	// special temporary promo
	include( 'promo.php' );

	$preview_states      = isset( $settings_tabs[ $active_tab ]['preview_states'] ) ? $settings_tabs[ $active_tab ]['preview_states'] : 1;
	$preview_states_lock = $preview_states == 3 ? false : true;
	?>
	<div id="wpo-wcpdf-preview-wrapper" class="<?php echo esc_attr( $active_tab ); ?>" data-preview-states="<?php echo esc_attr( $preview_states ); ?>" data-preview-state="closed" data-from-preview-state="" data-preview-states-lock="<?php echo esc_attr( $preview_states_lock ); ?>">

		<div class="sidebar">
			<?php $excluded_sections = apply_filters( 'wpo_wcpdf_settings_form_excluded_sections', array( 'tools' ) ); // tools have their own forms ?>
			<?php if ( ! in_array( $active_section, $excluded_sections ) ) : ?>
				<form method="post" action="options.php" id="wpo-wcpdf-settings" class="<?php echo esc_attr( "{$active_tab} {$active_section}" ); ?>">
			<?php endif; ?>
				<?php
					do_action( 'wpo_wcpdf_before_settings', $active_tab, $active_section, $nonce );
					if ( has_action( "wpo_wcpdf_settings_output_{$active_tab}" ) ) {
						do_action( "wpo_wcpdf_settings_output_{$active_tab}", $active_section, $nonce );
					} else {
						// legacy settings
						settings_fields( "wpo_wcpdf_{$active_tab}_settings" );
						do_settings_sections( "wpo_wcpdf_{$active_tab}_settings" );

						submit_button();
					}
					do_action( 'wpo_wcpdf_after_settings', $active_tab, $active_section, $nonce );
				?>
			<?php if ( ! in_array( $active_section, $excluded_sections ) ) : ?>
				</form>
			<?php endif; ?>
			<?php do_action( 'wpo_wcpdf_after_settings_form', $active_tab, $active_section, $nonce ); ?>
		</div>

		<div class="gutter">
			<div class="slider slide-left"><span class="gutter-arrow arrow-left"></span></div>
			<div class="slider slide-right"><span class="gutter-arrow arrow-right"></span></div>
		</div>

		<div class="preview-document">
			<?php
				$documents     = WPO_WCPDF()->documents->get_documents( 'enabled', 'any' );
				$document_type = 'invoice';

				if ( ! empty( $_REQUEST['section'] ) ) {
					$document_type = sanitize_text_field( wp_unslash( $_REQUEST['section'] ) );
				} elseif ( ! empty( $_REQUEST['preview'] ) ) {
					$document_type = sanitize_text_field( wp_unslash( $_REQUEST['preview'] ) );
				}
			?>
			<div class="preview-data-wrapper">
				<div class="save-settings"><?php submit_button(); ?></div>
				<div class="preview-data preview-order-data">
					<div class="preview-order-search-wrapper">
						<input type="text" name="preview-order-search" id="preview-order-search" placeholder="<?php esc_html_e( 'ID, email or name', 'woocommerce-pdf-invoices-packing-slips' ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'wpo_wcpdf_preview' ) ); ?>">
						<img class="preview-order-search-clear" src="<?php echo esc_url( WPO_WCPDF()->plugin_url() . '/assets/images/reset-input.svg' ); ?>" alt="<?php esc_html_e( 'Clear search text', 'woocommerce-pdf-invoices-packing-slips' ); ?>">
					</div>
					<p class="last-order"><?php esc_html_e( 'Currently showing last order', 'woocommerce-pdf-invoices-packing-slips' ); ?><span class="arrow-down">&#9660;</span></p>
					<p class="order-search"><span class="order-search-label"><?php esc_html_e( 'Search for an order', 'woocommerce-pdf-invoices-packing-slips' ); ?></span><span class="arrow-down">&#9660;</span></p>
					<ul>
						<li class="last-order"><?php esc_html_e( 'Show last order', 'woocommerce-pdf-invoices-packing-slips' ); ?></li>
						<li class="order-search"><?php esc_html_e( 'Search for an order', 'woocommerce-pdf-invoices-packing-slips' ); ?></li>
					</ul>
					<div id="preview-order-search-results"><!-- Results populated with JS --></div>
				</div>
				<?php if ( $active_tab != 'documents' ) : ?>
				<div class="preview-data preview-document-type">
					<?php
						if ( $document_type ) {
							$document = WPO_WCPDF()->documents->get_document( $document_type, null );
							if ( ! empty( $document ) ) {
								echo '<p class="current"><span class="current-label">'.esc_html( $document->get_title() ).'</span><span class="arrow-down">&#9660;</span></p>';
							}
						} else {
							echo '<p class="current"><span class="current-label">'.esc_html__( 'Invoice', 'woocommerce-pdf-invoices-packing-slips' ).'</span><span class="arrow-down">&#9660;</span></p>';
						}
					?>
					<ul class="preview-data-option-list" data-input-name="document_type">
						<?php
							foreach ( $documents as $document ) {
								printf(
									/* translators: 1. document type, 2. document title */
									'<li data-value="%1$s">%2$s</li>',
									esc_attr( $document->get_type() ),
									esc_html( $document->get_title() )
								);
							}
						?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
			<input type="hidden" name="document_type" data-default="<?php echo esc_attr( $document_type ); ?>" value="<?php echo esc_attr( $document_type ); ?>">
			<input type="hidden" name="output_format" value="<?php echo esc_attr( sanitize_text_field( wp_unslash( ( isset( $_REQUEST['output_format'] ) && ! empty( $_REQUEST['output_format'] ) ) ? $_REQUEST['output_format'] : 'pdf' ) ) ); ?>">
			<input type="hidden" name="order_id" value="">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'wpo_wcpdf_preview' ) ); ?>">
			<div class="preview"></div>
		</div>

	</div>

	<?php do_action( 'wpo_wcpdf_after_settings_page', $active_tab, $active_section, $nonce ); ?>

</div>
