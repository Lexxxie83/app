<?php

defined( 'ABSPATH' ) || exit;


if( ! function_exists('wc_multistore_get_product_class_name') ) {
	/**
	 * Gets the classname of woomultistore product based on product type and multistore type
	 * @param string $wc_multistore_type
	 * @param string $product_type
	 *
	 * @return string
	 * Returns the classname based on product type and multistore type. Ex: WC_Multistore_Product_Simple_Master
	 */
	function wc_multistore_get_product_class_name( $wc_multistore_type, $product_type ) {
		$product_type = ucfirst($product_type);
		$wc_multistore_type = ucfirst($wc_multistore_type);
		$class_name =  'WC_Multistore_Product_'. $product_type . '_' . $wc_multistore_type;

		if( ! class_exists($class_name) ){
			return false;
		}

		return $class_name;
	}
}

if( ! function_exists('wc_multistore_is_child_product') ) {
	/**
	 * Checks if a product is a multistore child product. Used on child stores
	 * @param $wc_product
	 *
	 * @return bool
	 * Return false or true if the product is a child product
	 */
	function wc_multistore_is_child_product( $wc_product ) {
		$settings = WOO_MULTISTORE()->settings;

		if( $settings['sync-by-sku'] == 'yes' ){
			$master_product = $wc_product->get_meta('_woonet_network_is_child_product_sku', true);
		}else{
			$master_product = $wc_product->get_meta('_woonet_network_is_child_product_id', true);
		}

		return ! empty( $master_product );
	}
}

if( ! function_exists('wc_multistore_product_get_master_product_id') ) {

	/**
	 * Gets the master product id by sku if sync by sku is enabled. Used on main store
	 * @param $master_product_id
	 * @param $child_product_sku
	 * @param $child_product_language
	 *
	 * @return int|mixed
	 * Returns master product id
	 */
	function wc_multistore_product_get_master_product_id( $master_product_id, $child_product_sku, $child_product_language = false ){
		$settings = WOO_MULTISTORE()->settings;

		if( $settings['sync-by-sku'] == 'yes' ){
			$master_product_id = wc_get_product_id_by_sku( $child_product_sku );
		}

		return apply_filters( 'wc_multistore_master_product_id', $master_product_id, $child_product_sku, $child_product_language );
	}
}

if( ! function_exists('wc_multistore_product_get_master_blog_id') ) {
	/**
	 * Get master product site id from a child product. Used on child stores
	 * @param $wc_product
	 *
	 * @return mixed
	 * Returns master product site id or empty
	 */
	function wc_multistore_product_get_master_blog_id( $wc_product ){
		return $wc_product->get_meta('_woonet_network_is_child_site_id', true);
	}
}

if( ! function_exists('wc_multistore_product_get_slave_product_id') ) {
	/**
	 * Get child product id. Used on child stores
	 * @param $master_product_id
	 * @param false $master_product_sku
	 * @param false $master_product_language
	 *
	 * @return string|null
	 * Returns child product id or empty
	 */
	function wc_multistore_product_get_slave_product_id( $master_product_id, $master_product_sku = false, $master_product_language = false ){
		global $wpdb;
		$settings = WOO_MULTISTORE()->settings;

		if( $settings['sync-by-sku'] == 'yes' ){
			$child_product_id = $wpdb->get_var( $wpdb->prepare("SELECT post_id from {$wpdb->prefix}postmeta WHERE meta_key='_sku' AND meta_value =%s", $master_product_sku ) );
		}else{
			$query = "SELECT post_id from {$wpdb->prefix}postmeta WHERE meta_key='_woonet_network_is_child_product_id' AND meta_value='{$master_product_id}'";
			$child_product_id = $wpdb->get_var( $query );
		}

		return apply_filters( 'wc_multistore_child_product_id', $child_product_id, $master_product_id, $master_product_sku, $master_product_language );
	}
}