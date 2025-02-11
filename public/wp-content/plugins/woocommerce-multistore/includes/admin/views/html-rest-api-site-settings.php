<tr valign="top">
    <th scope="row" colspan="2">
        <h2 style='font-size:1em;'> REST API Settings </h2>
    </th>
    <td>
    </td>
</tr>
<?php
$option_name = 'child_inherit_changes_fields_control__synchronize_rest_by_default';
?>

<tr valign="top">
    <th scope="row" colspan="2">
        <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <span></span>
        </label>
        <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name; ?>]">
            <option value="yes" <?php selected( $site_settings[ $option_name ], 'yes' ); ?> ><?php echo __( 'Yes', 'woonet' ); ?></option>
            <option value="no" <?php selected( $site_settings[ $option_name ], 'no' ); ?> ><?php echo __( 'No', 'woonet' ); ?></option>
        </select>
    </th>
    <td>
        <label><?php echo __( 'Synchronize new products added via API', 'woonet' ); ?>
            <span class="tips" data-tip="<?php echo __( 'Enable or disable this global option for this site.', 'woonet' ); ?>">
                <span class="dashicons dashicons-info"></span>
            </span>
        </label>
    </td>
</tr>