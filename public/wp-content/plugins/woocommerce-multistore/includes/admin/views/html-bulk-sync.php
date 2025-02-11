<?php

defined( 'ABSPATH' ) || exit;

if( is_multisite() ){
	switch_to_blog( (int) get_site_option('wc_multistore_master_store') );
}

$all_product_types = wc_get_product_types();

$all_categories = get_categories(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
	)
);
$attribute_taxonomies = wc_get_attribute_taxonomies();

if( is_multisite() ){
	restore_current_blog();
}
?>

<div class='woomulti-bulk-sync-page'>
	<h1> Sync all products in your network. </h1>

	<p> Normally, you would be using the regular sync page as that offers more control. However, when you are setting up the plugin for the first time, you may have a lot of products that you want to sync with your child sites. Or you may need to sync all product data again if you have added product data.
	</p>

	<form id='bulk-sync-form' action='#' method='POST'>
        <div class="wc-multistore-bulk-sync-section">
            <div>
                <label class="wc-multistore-checkbox-label">
                    <input class='select-all-products' type='checkbox' name='select-all-products' checked='checked' value='1' />
                    <span class="checkmark"></span>
                </label>
                <label> Select All Products </label> <br />
                <p> Deselect All Products if you need to choose specific products</p>
            </div>

            <div class="wc-multistore-bulk-sync-advanced-container closed">
                <div class="box">
                    <h2> Select Product Types </h2>
                    <select style="width:250px;" class="wc-multistore-select2 wc-enhanced-select" name="select_product_types[]" multiple="multiple">
			            <?php foreach ($all_product_types as $product_type => $product_type_label): ?>
                            <option value='<?php echo $product_type; ?>'><?php echo $product_type_label;  ?></option>
			            <?php endforeach; ?>
                    </select>
                </div>

                <div class="box">
                    <h2> Select Categories </h2>
                    <select style="width:250px;" class="wc-multistore-select2 wc-enhanced-select" name="select_categories[]" multiple="multiple">
                        <?php foreach ($all_categories as $cat): ?>
                            <option value='<?php echo $cat->term_id; ?>'><?php echo $cat->name . '('. $cat->count . ')'  ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if( ! empty( $attribute_taxonomies ) ): ?>
                    <?php foreach ( $attribute_taxonomies as $attribute_taxonomy ): ?>
                        <?php $args = array(
                            'taxonomy'   => 'pa_'. wc_sanitize_taxonomy_name( $attribute_taxonomy->attribute_name),
                            'hide_empty' => false,
                        ); ?>
                        <?php $terms = get_terms($args); ?>
		                <?php if( ! empty( $terms ) ): ?>
                        <div class="box">
                        <h2>Select <?php echo $attribute_taxonomy->attribute_label; ?> attribute</h2>
                            <select style="width:250px;" class="wc-multistore-select2 wc-enhanced-select" name="bulk_sync_pa_<?php echo $attribute_taxonomy->attribute_name; ?>[]" multiple="multiple">
                                <?php foreach ( $terms as $term ): ?>
                                    <option value='<?php echo $term->term_id; ?>'><?php echo $term->name . '('. $term->count . ')'  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>


        <div class="wc-multistore-bulk-sync-section">
            <div class="wc-multistore-bulk-sync-default-product-settings-container ">
                <label class="wc-multistore-checkbox-label">
                    <input class='use-product-settings' type='checkbox' name='use-product-settings' checked='checked' value='1' />
                    <span class="checkmark"></span>
                </label>
                <label> Use Product Settings
                <span class="tips" data-tip="Uses already defined product settings. Skips products that do not have publish setting enabled">
                    <span class="dashicons dashicons-info"></span>
                </span>
                </label> <br />
                <p> Deselect Product Settings If you want to control the product settings</p>
            </div>

            <div class="wc-multistore-bulk-sync-advanced-product-settings-container closed">
                <h2> Select Child Sites </h2>
                <p> Select all the sites you want to sync with. </p>
                <?php
                $sites = WOO_MULTISTORE()->active_sites;
                ?>

                <div class="woonet-checkbox-list">
                    <label class="wc-multistore-checkbox-label">
                        <input type='checkbox' class='select-all' value='' />
                        <span class="checkmark"></span>
                    </label>
                    <label> Select/Deselect All </label> <br />
                    <?php
                    foreach ( $sites as $site ) {
                        ?>
                        <label class="wc-multistore-checkbox-label">
                            <input type='checkbox' class='select-child-sites child-sites-id-<?php echo $site->get_id(); ?>' name='select_child_sites[]' value='<?php echo $site->get_id(); ?>' />
                            <span class="checkmark"></span>
                        </label>
                        <label> <?php echo $site->get_url(); ?> </label> <br />
                        <?php
                    } ?>
                </div>


                <h2> Product Settings </h2>
                <p> Change product stock and update settings. </p>
                <?php
                $sync_options = array(
                    'child-sync' => array(
                        'label' => 'Child product inherit Parent products changes',
                        'value' => 'yes',
                    ),

                    'stock-sync' => array(
                        'label' => 'If checked, any stock change will synchronize across product tree',
                        'value' => 'yes',
                    ),
                );

                foreach ( $sync_options as $key => $value ) {
                    ?>
                    <label class="wc-multistore-checkbox-label">
                        <input checked='checked' type='checkbox' class='select-sync-settings <?php echo $key; ?>' name='<?php echo $key; ?>' value='<?php echo $value['value']; ?>' />
                        <span class="checkmark"></span>
                    </label>
                    <label> <?php echo $value['label']; ?> </label> <br />
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="wc-multistore-bulk-sync-section">
            <div class="wc-multistore-bulk-sync-form-error-container"></div>
        </div>

        <div class="wc-multistore-bulk-sync-section">

            <div class="wc-multistore-bulk-sync-container">
                <div class="wc-multistore-product-sync-container">

                </div>
            </div>
        </div>

        <div class="wc-multistore-bulk-sync-section">
            <div class="wc-multistore-bulk-sync-progress-container">
                <div class="wc-multistore-bulk-sync-progress-bar"></div>
                <div class="wc-multistore-bulk-sync-progress">
                    <div>
                        <span class="finished"></span>
                        <span class="total"></span>
                    </div>
                    <div class="skipped"></div>
                    <div class="status"></div>
                </div>
            </div>
        </div>

        <div class="wc-multistore-bulk-sync-section">
            <div class="wc-multistore-bulk-sync-actions-container">
                <?php wp_nonce_field( 'wc-multistore-bulk-sync-nonce', 'wc-multistore-bulk-sync-nonce' ); ?>
                <?php wp_nonce_field( 'wc-multistore-product-sync-nonce', 'wc-multistore-product-sync-nonce' ); ?>

                <button type='submit' id='bulk-sync-button' class='button-primary'> Sync Selected Products </button>
                <span class="spinner"></span>
                <button type='button' id='bulk-sync-cancel-button' class='button-primary' style="visibility: hidden;"> Cancel </button>
                <button type='button' id='bulk-sync-start-new-button' data-attr='<?php echo network_admin_url() . 'admin.php?page=woonet-bulk-sync-products'; ?>'  class='button-primary' style="visibility: hidden;"> Start new sync </button>
            </div>
        </div>
	</form>
</div>
