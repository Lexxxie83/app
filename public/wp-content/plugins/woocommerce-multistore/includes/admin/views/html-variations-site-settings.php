<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?> ">
    <th scope="row" colspan="2"><h2 style="font-size:1em;"> Variations Settings </h2></th>
    <td></td>
</tr>

<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-settings-span">Publish
            <span class="tips" data-tip="These settings will have effect only when the child Variation is published"><span class="dashicons dashicons-info"></span></span>
        </div>
    </th>
    <th scope="row">
        <div class="wc-multistore-settings-span">Update
            <span class="tips" data-tip="These settings will have effect only when the child Variation is updated"><span class="dashicons dashicons-info"></span></span>
        </div>
    </th>
    <td></td>
</tr>

<?php
// Variations Data
$option_name = 'child_inherit_changes_fields_control__variations_data';
$option_name_update = 'child_inherit_changes_fields_control_update__variations_data';
?>
<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label>
            <?php echo __( 'Data', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Data refers to all variation data with the exception of status, stock, sku, regular price and sale price which have separate settings bellow', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>

<?php
// Variations Status
$option_name = 'child_inherit_changes_fields_control__variations_status';
$option_name_update = 'child_inherit_changes_fields_control_update__variations_status';
?>
<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ); ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ); ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label>	<?php echo __( 'Status', 'woonet' ); ?> </label>
    </td>
</tr>

<?php
// Variations Stock
$option_name = 'child_inherit_changes_fields_control__variations_stock';
$option_name_update = 'child_inherit_changes_fields_control_update__variations_stock';
?>
<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label>
			<?php echo __( 'Stock', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Manage stock, stock quantity, stock status, low stock amount and allow backorders are also a part of this option', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>

<?php
// Variations Sku
$option_name = 'child_inherit_changes_fields_control__variations_sku';
$option_name_update = 'child_inherit_changes_fields_control_update__variations_sku';
?>
<?php if( $this->settings['sync-by-sku'] != 'yes' ): ?>
    <tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
        <th scope="row">
            <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
                <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                    <span></span>
                </label>
                <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                    <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                    <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
                </select>
            </div>
        </th>
        <th>
            <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
                <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                    <span></span> </label>
                <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                    <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                    <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
                </select>
            </div>
        </th>
        <td>
            <label><?php echo __( 'Sku', 'woonet' ); ?></label>
        </td>
    </tr>
<?php else: ?>
    <tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
        <th scope="row">
            <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
                <label class="wc-multistore-select-switch disabled selected" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                    <span></span>
                </label>
                <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                    <option value="yes" selected = "selected"><?php echo __( 'Yes', 'woonet' ) ?></option>
                    <option value="no"><?php echo __( 'No', 'woonet' ); ?></option>
                </select>
            </div>
        </th>
        <th>
            <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
                <label class="wc-multistore-select-switch disabled selected" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                    <span></span>
                </label>
                <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                    <option value="yes" selected = "selected"><?php echo __( 'Yes', 'woonet' ) ?></option>
                    <option value="no"><?php echo __( 'No', 'woonet' ); ?></option>
                </select>
            </div>
        </th>
        <td>
            <label>
				<?php echo __( 'Sku', 'woonet' ); ?>
                <span class="tips" data-tip="<?php echo __( 'When sync by sku is enabled, this option is enabled by default.', 'woonet' ); ?>">
                    <span class="dashicons dashicons-info wc-multistore-warning-tip"></span>
                </span>
            </label>
        </td>
    </tr>
<?php endif; ?>

<?php
// Variations gtin
$option_name = 'child_inherit_changes_fields_control__variations_gtin';
$option_name_update = 'child_inherit_changes_fields_control_update__variations_gtin';
?>
<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'GTIN, UPC, EAN, or ISBN', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Variations Regular Price
$option_name = 'child_inherit_changes_fields_control__variations_price';
$option_name_update = 'child_inherit_changes_fields_control_update__variations_price';
?>
<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label>	<?php echo __( 'Regular Price', 'woonet' ); ?> </label>
    </td>
</tr>

<?php
// Variations Sale Price
$option_name = 'child_inherit_changes_fields_control__variations_sale_price';
$option_name_update = 'child_inherit_changes_fields_control_update__variations_sale_price';
?>
<tr valign="top" class="wc-multistore-variations-settings-row <?php echo $are_variations_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-variations-settings <?php //echo $are_variations_enabled; ?> ">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-variations-settings-update <?php //echo $are_variations_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label>
		    <?php echo __( 'Sale Price', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Sale start date and sale end date are also part of this option', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>
