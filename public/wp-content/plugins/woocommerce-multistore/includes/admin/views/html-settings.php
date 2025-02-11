<div class="wrap">
    <div id="icon-settings" class="icon32"></div>
    <h2 class='woonet-general-setitngs-header'><?php esc_html_e( 'General Settings', 'woonet' ); ?></h2>

    <div class='woonet-additional-settings'>
		<?php if ( $this->settings['sync-custom-taxonomy'] == 'yes' ) : ?>
            <a class='button button-primary' href="<?php echo esc_url( network_admin_url( 'admin.php?page=woonet-set-taxonomy' ) ); ?>" class='Shipping options'>Set Taxonomy</a>
		<?php endif; ?>
		<?php if ( $this->settings['sync-custom-metadata'] == 'yes' ) : ?>
            <a class='button button-primary' href="<?php echo esc_url( network_admin_url( 'admin.php?page=woonet-set-taxonomy#sec-metadata' ) ); ?>" class='Shipping options'>Set Metadata</a>
		<?php endif; ?>
    </div>

    <form id="form_data" name="form" method="post">
        <br/>
		<?php

		// Sort sites
		if ( isset( $this->settings['blog_tab_order'] ) && $this->sites ) {
			$blog_tab_order = array();
			foreach ( $this->settings['blog_tab_order'] as $key => $blog_id ) {
				$blog_tab_order[ $blog_id ] = $blog_id;
			}
			//$this->sites = array_replace( $blog_tab_order, $this->sites );
		}
        ?>

		<div id="fields-control">
		    <ul>
                <li>
                    <a href="#tabs-general">General Settings</a>
                    <input type="hidden" name="general_settings" value="general_settings" />
                </li>
                <?php if ( $this->sites ): ?>
                    <?php foreach ( $this->sites as $site ): ?>
                        <?php if( ! $site->is_active() ){ continue; } ?>
                        <li class="sortable">
                            <a href="#tabs-<?php echo $site->get_id(); ?>"><?php echo $site->get_name(); ?> Settings </a>
                            <input type="hidden" name="blog_tab_order[]" value="<?php echo $site->get_id(); ?>" />
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
		    </ul>

            <?php require_once WOO_MSTORE_PATH . 'includes/admin/views/html-general-settings.php'; ?>

            <?php if ( $this->sites ) : ?>
                <?php foreach ( $this->sites as $site ) : ?>
                    <?php if( ! $site->is_active() ){ continue; } ?>

                    <?php $blog_id       = $site->get_id(); ?>
                    <?php $blog_name     = $site->get_name(); ?>
                    <?php $site_settings = $site->get_settings(); ?>

                    <div id="tabs-<?php echo $site->get_id(); ?>">
                        <h3><?php echo $site->get_name(); ?> Settings</h3>
                        <table class="form-table">
                            <tbody>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-product-site-settings.php'; ?>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-image-site-settings.php'; ?>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-attributes-site-settings.php'; ?>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-variations-site-settings.php'; ?>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-categories-site-settings.php'; ?>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-rest-api-site-settings.php'; ?>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-import-order-site-settings.php'; ?>
                                <?php require WOO_MSTORE_PATH . 'includes/admin/views/html-override-general-site-settings.php'; ?>
                                <?php do_action( 'woo_mstore/options/options_output/child_inherit_changes_fields_control', $blog_id ); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

		<?php do_action( 'woo_mstore/options/options_output' ); ?>

        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_html_e( 'Save Settings', 'woonet' ); ?>">
            <span class="spinner"></span>
        </p>

		<?php wp_nonce_field( 'mstore_form_submit', 'mstore_form_nonce' ); ?>
        <input type="hidden" name="wc_multistore_form_submit" value="true"/>

    </form>
    <div class="wc-multistore-settings-notices"></div>
</div>