<tr valign="top" class="wc-multistore-image-settings-row <?php echo $are_images_rows_enabled; ?>">
    <th scope="row" colspan="2"><h2 style="font-size:1em;"> Image Settings </h2></th>
    <td></td>
</tr>

<tr valign="top" class="wc-multistore-image-settings-row <?php echo $are_images_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-settings-span">
	        Publish
            <span class="tips" data-tip="These settings will have effect only when the child image is published">
	            <span class="dashicons dashicons-info"></span>
            </span>
        </div>
    </th>
    <th scope="row">
        <div class="wc-multistore-settings-span">
	        Update
            <span class="tips" data-tip="These settings will have effect only when the child image is updated">
	            <span class="dashicons dashicons-info"></span>
            </span>
        </div>
    </th>
    <td></td>
</tr>

<?php
// Image Alt
$option_name = 'child_inherit_changes_fields_control__product_image_alt';
$option_name_update = 'child_inherit_changes_fields_control_update__product_image_alt';
?>
<tr class="wc-multistore-image-settings-row <?php echo $are_images_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-image-settings <?php //echo $are_images_enabled; ?> ">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <th>
        <div class="wc-multistore-image-settings-update <?php //echo $are_images_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Alt', 'woonet' ); ?></label>
    </td>
</tr>