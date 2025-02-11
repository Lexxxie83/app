<tr valign="top">
    <th scope="row" colspan="2"><h2 style="font-size:1em;"> Product Settings </h2></th>
    <td>Bellow you can customize which data should be inherited by the child products.</td>
</tr>

<tr valign="top">
    <th scope="row">
        <div class="wc-multistore-settings-span">
            Publish
            <span class="tips" data-tip="These settings will have effect only when the child product is published">
		        <span class="dashicons dashicons-info"></span>
	        </span>
        </div>
    </th>
    <th scope="row">
        <div class="wc-multistore-settings-span">
            Update <span class="tips" data-tip="These settings will have effect only when the child product is updated">
                <span class="dashicons dashicons-info"></span>
            </span>
        </div>
    </th>
    <td></td>
</tr>


<?php
// Product Name
$option_name        = 'child_inherit_changes_fields_control__title';
$option_name_update = 'child_inherit_changes_fields_control_update__title';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Title', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Slug
$option_name        = 'child_inherit_changes_fields_control__slug';
$option_name_update = 'child_inherit_changes_fields_control_update__slug';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Slug', 'woonet' ); ?></label>
    </td>
</tr>


<?php
// Product Status
$option_name = 'child_inherit_changes_fields_control__status';
$option_name_update = 'child_inherit_changes_fields_control_update__status';
$is_product_status_publish_enabled = ($site_settings[ $option_name ] == 'yes') ? 'hidden' : '' ;
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-product-status-settings-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Status', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Product status can be: Published, Pending Review, Draft or custom product status.', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>

<?php
// Product Default Status
$option_name = 'child_inherit_changes_fields_control__default_status';
?>
<tr class="wc-multistore-default-product-status-row <?php echo $is_product_status_publish_enabled; ?>">
    <th colspan="2" scope="row">
        <select class="wc-multistore-site-settings-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="draft" <?php selected( $site_settings[ $option_name ], 'draft' ) ?>><?php echo __( 'Draft', 'woonet' ) ?></option>
            <option value="pending" <?php selected( $site_settings[ $option_name ], 'pending' ) ?>><?php echo __( 'Pending Review', 'woonet' ) ?></option>
            <option value="publish" <?php selected( $site_settings[ $option_name ], 'publish' ) ?>><?php echo __( 'Published', 'woonet' ); ?></option>
            <option value="private" <?php selected( $site_settings[ $option_name ], 'private' ) ?>><?php echo __( 'Private', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Default Status', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Choose the default product status that will be used when product will be published.', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>


<?php
// Product Description
$option_name = 'child_inherit_changes_fields_control__description';
$option_name_update = 'child_inherit_changes_fields_control_update__description';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Description', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Short Description
$option_name = 'child_inherit_changes_fields_control__short_description';
$option_name_update = 'child_inherit_changes_fields_control_update__short_description';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Short Description', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Featured
$option_name = 'child_inherit_changes_fields_control__featured';
$option_name_update = 'child_inherit_changes_fields_control_update__featured';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Featured', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Catalogue Visibility
$option_name = 'child_inherit_changes_fields_control__catalogue_visibility';
$option_name_update = 'child_inherit_changes_fields_control_update__catalogue_visibility';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Catalogue Visibility', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Price
$option_name = 'child_inherit_changes_fields_control__price';
$option_name_update = 'child_inherit_changes_fields_control_update__price';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Price', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Sale Price
$option_name = 'child_inherit_changes_fields_control__sale_price';
$option_name_update = 'child_inherit_changes_fields_control_update__sale_price';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Sale Price', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Sale start date and sale end date are also part of this option', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>

<?php
// Product tag
$option_name = 'child_inherit_changes_fields_control__product_tag';
$option_name_update = 'child_inherit_changes_fields_control_update__product_tag';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Tags', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Default Variations
$option_name = 'child_inherit_changes_fields_control__default_variations';
$option_name_update = 'child_inherit_changes_fields_control_update__default_variations';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label>
            <?php echo __( 'Default Form Values ( Default Attributes )', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Default attributes for variable products.', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>


<?php
// Product sku
$option_name = 'child_inherit_changes_fields_control__sku';
$option_name_update = 'child_inherit_changes_fields_control_update__sku';
?>

<?php if( $this->settings['sync-by-sku'] != 'yes' ): ?>
    <tr>
        <th scope="row">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </th>
        <th>
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </th>
        <td>
            <label><?php echo __( 'Sku', 'woonet' ); ?></label>
        </td>
    </tr>
<?php else: ?>
    <tr>
        <th scope="row">
            <label class="wc-multistore-select-switch disabled selected" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" selected = "selected"><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no"><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </th>
        <th>
            <label class="wc-multistore-select-switch disabled selected" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" selected = "selected"><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no"><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
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
// Product gtin
$option_name = 'child_inherit_changes_fields_control__gtin';
$option_name_update = 'child_inherit_changes_fields_control_update__gtin';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span>
        </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'GTIN, UPC, EAN, or ISBN', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product gallery
$option_name = 'child_inherit_changes_fields_control__product_gallery';
$option_name_update = 'child_inherit_changes_fields_control_update__product_gallery';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Gallery', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product reviews
$option_name = 'child_inherit_changes_fields_control__reviews';
$option_name_update = 'child_inherit_changes_fields_control_update__reviews';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Reviews', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product purchase note
$option_name = 'child_inherit_changes_fields_control__purchase_note';
$option_name_update = 'child_inherit_changes_fields_control_update__purchase_note';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Purchase Note', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product shipping class
$option_name = 'child_inherit_changes_fields_control__shipping_class';
$option_name_update = 'child_inherit_changes_fields_control_update__shipping_class';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Shipping Class', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product upsells
$option_name = 'child_inherit_changes_fields_control__upsell';
$option_name_update = 'child_inherit_changes_fields_control_update__upsell';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Upsells', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product cross sells
$option_name = 'child_inherit_changes_fields_control__cross_sells';
$option_name_update = 'child_inherit_changes_fields_control_update__cross_sells';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Cross Sells', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Allow Backorders
$option_name = 'child_inherit_changes_fields_control__allow_backorders';
$option_name_update = 'child_inherit_changes_fields_control_update__allow_backorders';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Allow Backorders', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Menu Order
$option_name = 'child_inherit_changes_fields_control__menu_order';
$option_name_update = 'child_inherit_changes_fields_control_update__menu_order';
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Menu Order', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Product Image
$option_name = 'child_inherit_changes_fields_control__product_image';
$option_name_update = 'child_inherit_changes_fields_control_update__product_image';
$are_images_enabled = ($site_settings[ $option_name ] == 'yes') ? "" : 'hidden' ;
$are_images_update_enabled = ($site_settings[ $option_name_update ] == 'yes') ? "" : 'hidden' ;
$are_images_rows_enabled = ( $site_settings[ $option_name ] == 'yes' || $site_settings[ $option_name_update ] == 'yes' ) ? "" : 'hidden' ;
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-image-settings-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-image-settings-update-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label>
		    <?php echo __( 'Image', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Enable or disable Image. When enabled a section for Image settings will be displayed bellow', 'woonet' ); ?>">
                    <span class="dashicons dashicons-info"></span>
                </span>
        </label>
    </td>
</tr>

<?php
// Product Attributes
$option_name = 'child_inherit_changes_fields_control__attributes';
$option_name_update = 'child_inherit_changes_fields_control_update__attributes';
$are_attributes_enabled = ($site_settings[ $option_name ] == 'yes') ? '' : 'hidden' ;
$are_attributes_update_enabled = ($site_settings[ $option_name_update ] == 'yes') ? "" : 'hidden' ;
$are_attributes_rows_enabled = ( $site_settings[ $option_name ] == 'yes' || $site_settings[ $option_name_update ] == 'yes' ) ? "" : 'hidden' ;
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-attributes-settings-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-attributes-settings-update-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label>
		    <?php echo __( 'Attributes', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Enable or disable Attributes. When enabled a section for Attributes settings will be displayed bellow', 'woonet' ); ?>">
                    <span class="dashicons dashicons-info"></span>
                </span>
        </label>
    </td>
</tr>

<?php
// Product Variations
$option_name = 'child_inherit_changes_fields_control__variations';
$option_name_update = 'child_inherit_changes_fields_control_update__variations';
$are_variations_enabled = ($site_settings[ $option_name ] == 'yes') ? "" : 'hidden' ;
$are_variations_update_enabled = ($site_settings[ $option_name_update ] == 'yes') ? "" : 'hidden' ;
$are_variations_rows_enabled = ( $site_settings[ $option_name ] == 'yes' || $site_settings[ $option_name_update ] == 'yes' ) ? "" : 'hidden' ;
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-variations-settings-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-variations-settings-update-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label>
		    <?php echo __( 'Variations', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Enable or disable Variations. When enabled a section for Variations settings will be displayed bellow', 'woonet' ); ?>">
                    <span class="dashicons dashicons-info"></span>
                </span>
        </label>
    </td>
</tr>

<?php
// Product Categories
$option_name = 'child_inherit_changes_fields_control__product_cat';
$option_name_update = 'child_inherit_changes_fields_control_update__product_cat';
$are_categories_enabled = ($site_settings[ $option_name ] == 'yes') ? '' : 'hidden' ;
$are_categories_update_enabled = ($site_settings[ $option_name_update ] == 'yes') ? '' : 'hidden' ;
$are_categories_rows_enabled = ( $site_settings[ $option_name ] == 'yes' || $site_settings[ $option_name_update ] == 'yes' ) ? "" : 'hidden' ;
?>
<tr>
    <th scope="row">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-categories-settings-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <th>
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <span></span> </label>
        <select class="wc-multistore-select wc-multistore-categories-settings-update-switch" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label>
		    <?php echo __( 'Categories', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Enable or disable Categories. When enabled a section for Categories settings will be displayed bellow', 'woonet' ); ?>">
                    <span class="dashicons dashicons-info"></span>
                </span>
        </label>
    </td>
</tr>

