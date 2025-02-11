<tr valign="top" class="wc-multistore-categories-settings-row <?php echo $are_categories_rows_enabled; ?>">
    <th scope="row" colspan="2"><h2 style="font-size:1em;"> Categories Settings </h2></th>
    <td></td>
</tr>

<tr valign="top" class="wc-multistore-categories-settings-row <?php echo $are_categories_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-settings-span">Publish
            <span class="tips" data-tip="These settings will have effect only when the child Category is published"><span class="dashicons dashicons-info"></span></span>
        </div>
    </th>
    <th scope="row">
        <div class="wc-multistore-settings-span">Update
            <span class="tips" data-tip="These settings will have effect only when the child Category is updated"><span class="dashicons dashicons-info"></span></span>
        </div>
    </th>
    <td></td>
</tr>

<?php
// Category Name
$option_name = 'child_inherit_changes_fields_control__category_name';
$option_name_update = 'child_inherit_changes_fields_control_update__category_name';
?>
<tr valign="top" class="wc-multistore-categories-settings-row <?php echo $are_categories_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-categories-settings <?php //echo $are_categories_enabled; ?> ">
            <span class="tips" data-tip="<?php echo __( 'Category Name is required when the Category is published', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
            <label class="wc-multistore-select-switch selected disabled" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" selected="selected"><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no"><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-categories-settings-update <?php //echo $are_categories_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Name', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Category Slug
$option_name = 'child_inherit_changes_fields_control__category_slug';
$option_name_update = 'child_inherit_changes_fields_control_update__category_slug';
?>
<tr valign="top" class="wc-multistore-categories-settings-row <?php echo $are_categories_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-categories-settings <?php //echo $are_categories_enabled; ?> ">
            <span class="tips" data-tip="<?php echo __( 'Category Slug is required when the Category is published', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
            <label class="wc-multistore-select-switch selected disabled" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span>
            </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" selected="selected"><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no"><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-categories-settings-update <?php //echo $are_categories_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Slug', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Category Description
$option_name = 'child_inherit_changes_fields_control__category_description';
$option_name_update = 'child_inherit_changes_fields_control_update__category_description';
?>
<tr valign="top" class="wc-multistore-categories-settings-row <?php echo $are_categories_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-categories-settings <?php //echo $are_categories_enabled; ?> ">
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
        <div class="wc-multistore-categories-settings-update <?php //echo $are_categories_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Description', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Category Image
$option_name = 'child_inherit_changes_fields_control__category_image';
$option_name_update = 'child_inherit_changes_fields_control_update__category_image';
?>
<tr valign="top" class="wc-multistore-categories-settings-row <?php echo $are_categories_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-categories-settings <?php //echo $are_categories_enabled; ?> ">
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
        <div class="wc-multistore-categories-settings-update <?php //echo $are_categories_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Image', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Category Meta
$option_name = 'child_inherit_changes_fields_control__category_meta';
$option_name_update = 'child_inherit_changes_fields_control_update__category_meta';
?>
<tr valign="top" class="wc-multistore-categories-settings-row <?php echo $are_categories_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-categories-settings <?php //echo $are_categories_enabled; ?> ">
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
        <div class="wc-multistore-categories-settings-update <?php //echo $are_categories_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Meta data', 'woonet' ); ?></label>
    </td>
</tr>