	<label for="_woocommerce_gpf_data[{key}][{subidx}][notice_type]"><?php esc_html_e( 'Notice type:', 'woocommerce_gpf' ); ?></label><br>
	<select name="_woocommerce_gpf_data[{key}][{subidx}][notice_type]" class="woocommerce-gpf-store-default">
		<option value=""><?php esc_html_e( '-- Select notice type --', 'woocommerce_gpf' ); ?></option>
		<option value="US_CA_PROP_65" {US_CA_PROP_65_selected}>US_CA_PROP_65</option>
		<option value="safety_warning" {safety_warning_selected}><?php esc_html_e( 'Safety warning', 'woocommerce_gpf' ); ?></option>
		<option value="legal_disclaimer" {legal_disclaimer_selected}><?php esc_html_e( 'Legal disclaimer', 'woocommerce_gpf' ); ?></option>
	</select><br>
	<label for="_woocommerce_gpf_data[{key}][{subidx}][notice_message]"><?php esc_html_e( 'Notice message:', 'woocommerce_gpf' ); ?></label><br>
	<textarea name="_woocommerce_gpf_data[{key}][{subidx}][notice_message]" class="woocommerce-gpf-store-default" cols="80" rows="3">{notice_message}</textarea><br>
