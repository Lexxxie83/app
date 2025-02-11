<?php
/**
 * Product Attribute Term Child Handler
 *
 * This handles product attribute term child related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Product_Attribute_Term_Child
 */
class WC_Multistore_Product_Attribute_Term_Child extends WC_Multistore_Abstract_Term_Child {

	public function __construct( $term ){
		if( is_numeric( $term ) ){

		}else{
			$this->site_settings = wc_multistore_get_site_settings();

			if ( class_exists( 'SitePress' ) ) {
				global $sitepress;
				$has_wpml_filter = remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
			}

			$taxonomy_id = wc_multistore_get_child_product_attribute_by_id( $term['taxonomy_id'] );
			if( $taxonomy_id){
				$taxonomy = wc_attribute_taxonomy_name_by_id( intval( $taxonomy_id )  );
				$term['taxonomy'] = $taxonomy;
			}else{
				$taxonomy = $term['taxonomy'];
			}

			$child_term_id = wc_multistore_get_child_term_id( $term['term_id'] );
			if( $child_term_id ){
				$this->term_id = $child_term_id;
				$this->term = get_term( $child_term_id );
			}else{
				if( $term_exists = get_term_by('slug', $term['slug'], $taxonomy , ARRAY_A ) ){
					$this->term_id = $term_exists['term_id'];
					$this->term = get_term( $term_exists['term_id'] );
				}
			}

			if ( class_exists( 'SitePress' ) ) {
				if( $has_wpml_filter ){
					add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
				}
			}

			$this->data = $term;
		}
	}

	public function create(){
		if ( class_exists( 'SitePress' ) ) {
			global $sitepress;
			$has_wpml_filter = remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
		}

		$result = wp_insert_term( $this->data['name'], $this->data['taxonomy'], array( 'slug' => $this->data['slug'] ) );
		$this->term = get_term( $result['term_id'] );

		$args = array();

		if( $this->site_settings['child_inherit_changes_fields_control__attribute_term_description'] == 'yes' ){
			$args['description'] = wp_kses_post( $this->data['description'] );
		}

		$args['parent'] = wc_multistore_get_child_term_id( $this->data['parent'] );

		if( ! empty( $args ) ){
			remove_filter('pre_term_description', 'wp_filter_kses' );
			remove_filter('term_description', 'wp_kses_data' );

			if ( class_exists( 'SitePress' ) ) {
				global $sitepress;
				$has_wpml_filter = remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
			}

			wp_update_term( $this->term->term_id, $this->data['taxonomy'], $args );

			if ( class_exists( 'SitePress' ) ) {
				if( $has_wpml_filter ){
					add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
				}
			}

			add_filter('pre_term_description', 'wp_filter_kses' );
			add_filter('term_description', 'wp_kses_data' );
		}

		update_term_meta( $this->term->term_id, '_woonet_master_term_id', $this->data['term_id']);
		update_term_meta( $this->term->term_id, 'order', $this->data['order'] );

		if ( class_exists( 'SitePress' ) ) {
			if( $has_wpml_filter ){
				add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
			}
		}
	}

	public function update(){
		$args = array();

		if( $this->site_settings['child_inherit_changes_fields_control_update__attribute_term_name'] == 'yes' ){
			$args['name'] = $this->data['name'];
		}

		if( $this->site_settings['child_inherit_changes_fields_control_update__attribute_term_slug'] == 'yes' ){
			$args['slug'] = $this->data['slug'];
		}

		if( $this->site_settings['child_inherit_changes_fields_control_update__attribute_term_description'] == 'yes' ){
			$args['description'] = wp_kses_post( $this->data['description'] );
		}

		$args['parent'] = wc_multistore_get_child_term_id( $this->data['parent'] );

		if( ! empty( $args ) ){
			remove_filter('pre_term_description', 'wp_filter_kses' );
			remove_filter('term_description', 'wp_kses_data' );

			if ( class_exists( 'SitePress' ) ) {
				global $sitepress;
				$has_wpml_filter = remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
			}

			wp_update_term( $this->term->term_id, $this->data['taxonomy'], $args );

			if ( class_exists( 'SitePress' ) ) {
				if( $has_wpml_filter ){
					add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
				}
			}

			add_filter('pre_term_description', 'wp_filter_kses' );
			add_filter('term_description', 'wp_kses_data' );
		}

		update_term_meta( $this->term->term_id, '_woonet_master_term_id', $this->data['term_id']);
		update_term_meta( $this->term->term_id, 'order', $this->data['order'] );
	}
}