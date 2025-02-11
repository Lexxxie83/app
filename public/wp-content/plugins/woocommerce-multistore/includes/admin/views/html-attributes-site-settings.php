<tr valign="top" class="wc-multistore-attributes-settings-row <?php echo $are_attributes_rows_enabled; ?>">
	<th scope="row" colspan="2"><h2 style="font-size:1em;"> Attributes Settings </h2></th>
	<td></td>
</tr>

<tr valign="top" class="wc-multistore-attributes-settings-row <?php echo $are_attributes_rows_enabled; ?>">
	<th scope="row">
		<div class="wc-multistore-settings-span">
			Publish
			<span class="tips" data-tip="These settings will have effect only when the child Attribute is published">
	            <span class="dashicons dashicons-info"></span>
            </span>
		</div>
	</th>
	<th scope="row">
		<div class="wc-multistore-settings-span">
			Update
			<span class="tips" data-tip="These settings will have effect only when the child Attribute is updated">
	            <span class="dashicons dashicons-info"></span>
            </span>
		</div>
	</th>
	<td></td>
</tr>

<?php
// Attribute name
$option_name = 'child_inherit_changes_fields_control__attribute_name';
$option_name_update = 'child_inherit_changes_fields_control_update__attribute_name';
?>
<tr valign="top" class="wc-multistore-attributes-settings-row <?php echo $are_attributes_rows_enabled; ?>">
	<th scope="row">
		<div class="wc-multistore-attributes-settings <?php //echo $are_attributes_enabled; ?> ">
            <span class="tips" data-tip="<?php echo __( 'Attribute Name is required when the Attribute is published', 'woonet' ); ?>">
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
		<div class="wc-multistore-attributes-settings-update <?php //echo $are_attributes_update_enabled; ?>">
			<label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
				<span></span> </label>
			<select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
				<option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
				<option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
			</select>
		</div>
	</th>
	<td>
		<label><?php echo __( 'Attribute Name', 'woonet' ); ?></label>
	</td>
</tr>

<?php
// Attribute name
$option_name = 'child_inherit_changes_fields_control__attribute_slug';
$option_name_update = 'child_inherit_changes_fields_control_update__attribute_slug';
?>
<tr valign="top" class="wc-multistore-attributes-settings-row <?php echo $are_attributes_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-attributes-settings <?php //echo $are_attributes_enabled; ?> ">
            <span class="tips" data-tip="<?php echo __( 'Attribute Slug is required when the Attribute is published', 'woonet' ); ?>">
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
        <div class="wc-multistore-attributes-settings-update <?php //echo $are_attributes_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Attribute Slug', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Attribute Term Name
$option_name = 'child_inherit_changes_fields_control__attribute_term_name';
$option_name_update = 'child_inherit_changes_fields_control_update__attribute_term_name';
?>
<tr valign="top" class="wc-multistore-attributes-settings-row <?php echo $are_attributes_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-attributes-settings <?php //echo $are_attributes_enabled; ?> ">
            <span class="tips" data-tip="<?php echo __( 'Attribute Term Name is required when the Attribute Term is published', 'woonet' ); ?>">
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
        <div class="wc-multistore-attributes-settings-update <?php //echo $are_attributes_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Attribute Term Name', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Attribute Term Slug
$option_name = 'child_inherit_changes_fields_control__attribute_term_slug';
$option_name_update = 'child_inherit_changes_fields_control_update__attribute_term_slug';
?>
<tr valign="top" class="wc-multistore-attributes-settings-row <?php echo $are_attributes_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-attributes-settings <?php //echo $are_attributes_enabled; ?> ">
            <span class="tips" data-tip="<?php echo __( 'Attribute Term Slug is required when the Attribute Term is published', 'woonet' ); ?>">
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
        <div class="wc-multistore-attributes-settings-update <?php //echo $are_attributes_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Attribute Term Slug', 'woonet' ); ?></label>
    </td>
</tr>

<?php
// Attribute Term Description
$option_name = 'child_inherit_changes_fields_control__attribute_term_description';
$option_name_update = 'child_inherit_changes_fields_control_update__attribute_term_description';
?>
<tr valign="top" class="wc-multistore-attributes-settings-row <?php echo $are_attributes_rows_enabled; ?>">
    <th scope="row">
        <div class="wc-multistore-attributes-settings <?php //echo $are_attributes_enabled; ?> ">
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
        <div class="wc-multistore-attributes-settings-update <?php //echo $are_attributes_update_enabled; ?>">
            <label class="wc-multistore-select-switch <?php echo ( $site_settings[ $option_name_update ] == 'yes' ) ? "selected" : ""; ?>" for="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <span></span> </label>
            <select class="wc-multistore-select" name="sites[<?php echo $blog_id; ?>][<?php echo $option_name_update; ?>]">
                <option value="yes" <?php selected( $site_settings[ $option_name_update ], 'yes' ) ?>><?php echo __( 'Yes', 'woonet' ) ?></option>
                <option value="no" <?php selected( $site_settings[ $option_name_update ], 'no' ) ?>><?php echo __( 'No', 'woonet' ); ?></option>
            </select>
        </div>
    </th>
    <td>
        <label><?php echo __( 'Attribute Term Description', 'woonet' ); ?></label>
    </td>
</tr>