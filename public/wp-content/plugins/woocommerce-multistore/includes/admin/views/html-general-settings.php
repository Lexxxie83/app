<div id="tabs-general">
	<h3>General Settings</h3>

	<table class="form-table">
		<tbody>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['synchronize-by-default'] == 'yes'){ echo 'selected'; } ?>" for="synchronize-by-default">
					<span></span>
				</label>
				<select class="wc-multistore-select" id="synchronize-by-default" name="synchronize-by-default">
					<option value="yes" <?php selected( 'yes', $this->settings['synchronize-by-default'] ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( 'no', $this->settings['synchronize-by-default'] ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label>
                    <?php esc_html_e( 'Synchronize new products with all child sites by default', 'woonet' ); ?>
					<span class='tips' data-tip='<?php esc_html_e( 'When a new product is published, it is automatically synchronized with all child sites. You can still control this at a product level.', 'woonet' ); ?>'>
                            <span class="dashicons dashicons-info"></span>
                        </span>
				</label>
				<div>
					<label class="wc-multistore-checkbox-label">
						<input type="checkbox" id="inherit-by-default" name="inherit-by-default" value="yes" <?php checked( 'yes', $this->settings['inherit-by-default'] ); disabled( 'no', $this->settings['synchronize-by-default'] ); ?>>
						<span class="checkmark"></span>
					</label>
					<?php esc_html_e( 'Child product inherit Parent products changes', 'woonet' ); ?>
				</div>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['synchronize-rest-by-default'] == 'yes'){ echo 'selected'; } ?>" for="synchronize-rest-by-default">
					<span></span>
				</label>
				<select class="wc-multistore-select" id="synchronize-rest-by-default" name="synchronize-rest-by-default">
					<option value="no" <?php selected( 'no', $this->settings['synchronize-rest-by-default'] ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
					<option value="yes" <?php selected( 'yes', $this->settings['synchronize-rest-by-default'] ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Synchronize new products added via API with all child sites by default', 'woonet' ); ?>
					<span class='tips' data-tip='<?php esc_html_e( 'When a new product is published via API, it is automatically synchronized with all child sites. You can still control this at a product level.', 'woonet' ); ?>'>
                        <span class="dashicons dashicons-info"></span>
                    </span>
				</label>
				<div>
					<label class="wc-multistore-checkbox-label">
						<input type="checkbox" id="inherit-rest-by-default" name="inherit-rest-by-default" value="yes" <?php checked( 'yes', $this->settings['inherit-rest-by-default'] ); disabled( 'no', $this->settings['synchronize-rest-by-default'] ); ?>>
						<span class="checkmark"></span>
					</label>
					<?php esc_html_e( 'Child product inherit Parent products changes', 'woonet' ); ?>
				</div>

			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['synchronize-stock'] == 'yes'){ echo 'selected'; } ?>" for="synchronize-stock">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="synchronize-stock">
					<option value="yes" <?php selected( 'yes', $this->settings['synchronize-stock'] ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( 'no', $this->settings['synchronize-stock'] ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Always maintain stock synchronization for re-published products', 'woonet' ); ?>
					<span class='tips'
						data-tip='<?php esc_html_e( 'Stock updates either manually or on checkout will also change other shops that have the product.', 'woonet' ); ?>'><span
							class="dashicons dashicons-info"></span></span></label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['sync-by-sku'] == 'yes'){ echo 'selected'; } ?> <?php if( $this->settings['sync-by-sku'] == 'yes' ){ echo 'disabled'; } ?>" for="sync-by-sku">
					<span></span>
				</label>
				<select class="wc-multistore-select <?php if( $this->settings['sync-by-sku'] == 'yes' ){ echo 'disabled'; } ?>" name="sync-by-sku" >
					<option value="yes" <?php selected( $this->settings['sync-by-sku'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( $this->settings['sync-by-sku'], 'no' ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label>
					<?php esc_html_e( 'Sync by SKU', 'woonet' ); ?>
					<?php if( $this->settings['sync-by-sku'] != 'yes' ): ?>
						<span class='tips' data-tip='<?php esc_html_e( 'Choose YES if you want to switch to sync by SKU. Note that all existing product sync will be replaced by SKU sync and that any products without SKU will not sync. This choice can\'t be undone after saving.', 'woonet' ); ?>'>
                            <span class="dashicons dashicons-info"></span>
                        </span>

						<span class='tips' data-tip='WARNING! Please read the documentation on how to use this option before you change it.'>
                            <span class="dashicons dashicons-warning wc-multistore-warning-tip"></span>
                        </span>

						<span class='tips' data-tip='Sync by Sku Documentation'>
                            <a href="https://woomultistore.com/sku-sync-documentation/" target="_blank"><span class="dashicons dashicons-book wc-multistore-doc-tip"></span></a>
                        </span>
					<?php else: ?>
						<span class='tips' data-tip='Sync by sku can only be changed by resetting the plugin. All child products need to be deleted manually.'>
                            <span class="dashicons dashicons-warning wc-multistore-warning-tip"></span>
                        </span>
					<?php endif; ?>
				</label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['synchronize-trash'] == 'yes'){ echo 'selected'; } ?>" for="synchronize-trash">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="synchronize-trash">
					<option value="yes" <?php selected( 'yes', $this->settings['synchronize-trash'] ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( 'no', $this->settings['synchronize-trash'] ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Trash the child product when the parent product is trashed', 'woonet' ); ?>
					<span class='tips'
						data-tip='<?php esc_html_e( 'When parent product is trashed, trash the child products too.', 'woonet' ); ?>'><span
							class="dashicons dashicons-info"></span></span></label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['sequential-order-numbers'] == 'yes'){ echo 'selected'; } ?>" for="sequential-order-numbers">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="sequential-order-numbers">
					<option value="yes" <?php selected( 'yes', $this->settings['sequential-order-numbers'] ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( 'no', $this->settings['sequential-order-numbers'] ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label>
					<?php esc_html_e( 'Use sequential order numbers across the multisite environment', 'woonet' ); ?>
					<span class='tips' data-tip='<?php esc_html_e( 'Order numbers will be created in sequence across the network for invoices and orders.', 'woonet' ); ?>'>
                      <span class="dashicons dashicons-info"></span>
                    </span>

					<span class='tips' data-tip='<?php esc_html_e( 'WARNING! If you later deactivate this, the order numbers will revert back to the default WooCommerce order numbers.', 'woonet' ); ?>'>
                      <span class="dashicons dashicons-warning wc-multistore-warning-tip"></span>
                    </span>
				</label>
			</td>
		</tr>

		<?php if( is_multisite() ): ?>
			<tr valign="top">
				<th scope="row">
					<label class="wc-multistore-select-switch <?php if($this->settings['network-user-info'] == 'yes'){ echo 'selected'; } ?>" for="network-user-info">
						<span></span>
					</label>
					<select class="wc-multistore-select" name="network-user-info">
						<option value="yes" <?php selected( $this->settings['network-user-info'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
						<option value="no" <?php selected( $this->settings['network-user-info'], 'no' ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
					</select>
				</th>
				<td>
					<label>
						<?php esc_html_e( 'Show customers orders from all stores in My Account', 'woonet' ); ?>
						<span class='tips'
							data-tip='<?php esc_html_e( 'When enabled, customers will see orders from the whole network under My Account page.', 'woonet' ); ?>'>
										  <span class="dashicons dashicons-info"></span>
									</span>
					</label>
				</td>
			</tr>
		<?php endif; ?>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['sync-coupons'] == 'yes'){ echo 'selected'; } ?>" for="sync-coupons">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="sync-coupons">
					<option value="yes" <?php selected( $this->settings['sync-coupons'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( $this->settings['sync-coupons'], 'no' ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Sync coupons', 'woonet' ); ?>
					<span class='tips'
						data-tip='<?php esc_html_e( 'Sync coupon codes across the network.', 'woonet' ); ?>'><span
							class="dashicons dashicons-info"></span>
									</span>
				</label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['sync-custom-taxonomy'] == 'yes'){ echo 'selected'; } ?>" for="sync-custom-taxonomy">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="sync-custom-taxonomy">
					<option value="yes" <?php selected( $this->settings['sync-custom-taxonomy'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( $this->settings['sync-custom-taxonomy'], 'no' ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Sync custom taxonomy', 'woonet' ); ?>
					<span class='tips'
						data-tip='<?php esc_html_e( 'If enabled you can click a new button "Set Taxonomy". From there you can select which custom taxonomy will be synced with the child sites.', 'woonet' ); ?>'>
									<span class="dashicons dashicons-info"></span></span></label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['sync-custom-metadata'] == 'yes'){ echo 'selected'; } ?>" for="sync-custom-metadata">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="sync-custom-metadata">
					<option value="yes" <?php selected( $this->settings['sync-custom-metadata'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( $this->settings['sync-custom-metadata'], 'no' ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Sync custom metadata ', 'woonet' ); ?>
					<span class='tips' data-tip='<?php esc_html_e( 'If enabled you can click a new button "Set Metadata". From there you can select which custom metadata will be synced with the child sites.', 'woonet' ); ?>'>
                        <span class="dashicons dashicons-info"></span>
                    </span>
				</label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['enable-global-image'] == 'yes'){ echo 'selected'; } ?>" for="enable-global-image">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="enable-global-image">
					<option value="yes" <?php selected( $this->settings['enable-global-image'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( $this->settings['enable-global-image'], 'no' ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Enable global image', 'woonet' ); ?>
					<span class='tips'
						data-tip='<?php esc_html_e( 'When enabled, product images and product category images will not be uploaded on child sites. Child products and product categories will use the images uploaded on master site', 'woonet' ); ?>'><span
							class="dashicons dashicons-info"></span>
									</span>

					<span class='tips' data-tip='<?php esc_html_e( 'Global Image Documentation', 'woonet' ); ?>'>
                        <a href="https://woomultistore.com/global-images-for-woomultistore-woocommerce-multistore/" target="_blank"><span class="dashicons dashicons-book wc-multistore-doc-tip"></span></a>
                    </span>
				</label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<label class="wc-multistore-select-switch <?php if($this->settings['enable-order-import'] == 'yes'){ echo 'selected'; } ?>" for="enable-order-import">
					<span></span>
				</label>
				<select class="wc-multistore-select" name="enable-order-import">
					<option value="yes" <?php selected( $this->settings['enable-order-import'], 'yes' ); ?>><?php esc_html_e( 'Yes', 'woonet' ); ?></option>
					<option value="no" <?php selected( $this->settings['enable-order-import'], 'no' ); ?>><?php esc_html_e( 'No', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label>
					<?php esc_html_e( 'Enable order import', 'woonet' ); ?>
					<span class='tips' data-tip='<?php esc_html_e( 'If enabled, orders from the child sites will be imported to the main site.', 'woonet' ); ?>'>
                        <span class="dashicons dashicons-info"></span>
                    </span>
					<span class='tips' data-tip='<?php esc_html_e( 'Import Order Documentation', 'woonet' ); ?>'>
                        <a href="https://woomultistore.com/order-import-documentation/" target="_blank"><span class="dashicons dashicons-book wc-multistore-doc-tip"></span></a>
                    </span>
				</label>

                <div>
                    <label class="wc-multistore-checkbox-label">
                        <input type="checkbox" id="clone-products-during-import-order" name="clone-products-during-import-order" value="yes" <?php checked( 'yes', $this->settings['clone-products-during-import-order'] ); disabled( 'no', $this->settings['enable-order-import'] ); ?>>
                        <span class="checkmark"></span>
                    </label>
                    <?php esc_html_e( 'Clone Products during import order', 'woonet' ); ?>
                </div>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<select name="sync-method">
					<option value="ajax" <?php selected( 'ajax', $this->settings['sync-method'] ); ?>><?php esc_html_e( 'Ajax', 'woonet' ); ?></option>
					<option value="background" <?php selected( 'background', $this->settings['sync-method'] ); ?>><?php esc_html_e( 'Background', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Sync Method', 'woonet' ); ?>
					<span class='tips' data-tip='<?php esc_html_e( 'Ajax sync will sync the products instantly after a product update and will display a dialog in admin area. Background sync will display a dialog as well but the products will be scheduled to run in background. Stock sync from checkout or when orders are updated is instant in both cases.', 'woonet' ); ?>'>
                            <span class="dashicons dashicons-info"></span>
                        </span>
				</label>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row">
				<select name="publish-capability">
					<option value="super-admin" <?php selected( 'super-admin', $this->settings['publish-capability'] ); ?>><?php esc_html_e( 'Super Admin', 'woonet' ); ?></option>
					<option value="administrator" <?php selected( 'administrator', $this->settings['publish-capability'] ); ?>><?php esc_html_e( 'Administrator', 'woonet' ); ?></option>
					<option value="shop_manager" <?php selected( 'shop_manager', $this->settings['publish-capability'] ); ?>><?php esc_html_e( 'Shop Manager', 'woonet' ); ?></option>
				</select>
			</th>
			<td>
				<label><?php esc_html_e( 'Minimum user role to allow MultiStore Publish', 'woonet' ); ?>
					<span class='tips'
						data-tip='<?php esc_html_e( 'Set the user role that has access to Multisite features.', 'woonet' ); ?>'>
										  <span class="dashicons dashicons-info"></span>
									</span>
				</label>
			</td>
		</tr>

		</tbody>
	</table>
</div>