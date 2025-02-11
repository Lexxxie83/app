<?php

defined( 'ABSPATH' ) || exit;

if( ! function_exists('wc_multistore_get_child_product_attribute') ) {

	function wc_multistore_get_child_product_attribute( $attribute ) {
		if( empty( $attribute ) ){
			return false;
		}

		$attribute_id = wc_multistore_get_child_product_attribute_by_id( $attribute['id'] );

		if( ! $attribute_id ){
			$attribute_id = wc_multistore_get_child_product_attribute_by_slug( $attribute['attribute_name'] );
		}

		return $attribute_id;
	}
}

if( ! function_exists('wc_multistore_get_child_product_attribute_by_id') ) {
	function wc_multistore_get_child_product_attribute_by_id( $id ) {
		if( empty( $id )  ){
			return false;
		}
		global $wpdb;

		if( ! wc_multistore_table_exists($wpdb->prefix . 'woo_multistore_attributes_relationships') ){
			return false;
		}

		return $wpdb->get_var( "SELECT child_attribute_id FROM {$wpdb->prefix}woo_multistore_attributes_relationships WHERE attribute_id = '{$id}'" );
	}
}

if( ! function_exists('wc_multistore_get_child_product_attribute_by_slug') ) {
	function wc_multistore_get_child_product_attribute_by_slug( $name ) {
		if( empty( $name ) ){
			return false;
		}

		$name = apply_filters('wc_multistore_before_get_child_attribute', $name );

		global $wpdb;

		return $wpdb->get_var( "SELECT attribute_id FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = '{$name}'" );
	}
}

if( ! function_exists('wc_multistore_create_child_product_attribute') ) {

	function wc_multistore_create_child_product_attribute( $attribute ) {
		if( empty( $attribute ) ){
			return false;
		}
		global $wpdb;

		$args = array(
			'attribute_label'   => $attribute['attribute_label'],
			'attribute_name'    => $attribute['attribute_name'],
			'attribute_type'    => $attribute['attribute_type'],
			'attribute_orderby' => $attribute['attribute_orderby'],
			'attribute_public'  => $attribute['attribute_public'],
		);

		$args = apply_filters('wc_multistore_before_create_child_attribute', $args );

		$results = $wpdb->insert(
			$wpdb->prefix . 'woocommerce_attribute_taxonomies',
			$args,
			array( '%s', '%s', '%s', '%s', '%d' )
		);

		if ( is_wp_error( $results ) ) {
			return new WP_Error(
				'cannot_create_attribute',
				$results->get_error_message(),
				array( 'status' => 400 )
			);
		}

		$id = $wpdb->insert_id;

		do_action( 'woocommerce_api_create_product_attribute', $id, $args );

		if( wc_multistore_table_exists($wpdb->prefix . 'woo_multistore_attributes_relationships') ){
			$wpdb->insert(
				$wpdb->prefix . 'woo_multistore_attributes_relationships',
				array(
					'attribute_id' => $attribute['id'],
					'child_attribute_id' => $id
				),
				array( '%d' )
			);
		}

		// Clear transients
		delete_transient( 'wc_attribute_taxonomies' );
		WC_Cache_Helper::invalidate_cache_group( 'woocommerce-attributes' );

		if ( ! taxonomy_exists( $attribute['name'] ) ) {
			register_taxonomy(
				$attribute['name'],
				array('product', 'product_variation'),
				array(
					'hierarchical' => false,
					'label'        => ucfirst( $attribute['attribute_label'] ),
					'query_var'    => true,
					'rewrite'      => array( 'slug' => sanitize_title( $attribute['name'] ) ), // The base slug
				)
			);
		}

		return $id;
	}
}


if( ! function_exists('wc_multistore_attribute_term_taxonomy') ) {
	function wc_multistore_attribute_term_taxonomy( $term_id ) {
		if( empty( $term_id ) ){
			return false;
		}

		global $wpdb;

		return $wpdb->get_var( "SELECT taxonomy FROM {$wpdb->prefix}term_taxonomy WHERE term_id = '{$term_id}'" );
	}
}

if( ! function_exists('wc_multistore_get_master_attribute') ) {
	function wc_multistore_get_master_attribute( $attribute_id ) {
		global $wpdb;

		if( empty( $attribute_id ) ){
			return false;
		}

		if( ! wc_multistore_table_exists($wpdb->prefix . 'woo_multistore_attributes_relationships') ){
			return false;
		}

		return $wpdb->get_var( "SELECT attribute_id FROM {$wpdb->prefix}woo_multistore_attributes_relationships WHERE child_attribute_id = '{$attribute_id}'" );
	}
}