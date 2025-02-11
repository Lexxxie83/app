<?php
/**
 * Product Attribute Child Handler
 *
 * This handles product attribute child related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Product_Attribute_Child
 */
class WC_Multistore_Product_Attribute_Child extends WC_Multistore_Abstract_Term_Child {


	public $wc_attribute;

	public $wc_attribute_id = false;

	public $data;
	
	public $site_settings;

	public function __construct( $attribute ){
		$attribute = apply_filters( 'wc_multistore_attribute_data', $attribute );

		if( is_numeric( $attribute ) ){

		}else{
			if( isset( $attribute['id'] ) && $attribute['id'] > 0 ) {
				$this->wc_attribute_id = wc_multistore_get_child_product_attribute( $attribute );
			}
			$this->site_settings = wc_multistore_get_site_settings();
			$this->data = $attribute;
		}

	}

	public function create(){
		if( isset( $this->data['id'] ) && $this->data['id'] > 0 ){
			$this->wc_attribute_id = wc_multistore_create_child_product_attribute($this->data);
			$this->wc_attribute = new WC_Product_Attribute();
			$this->wc_attribute->set_id($this->wc_attribute_id);
			$this->wc_attribute->set_name( $this->data['name'] );
			$this->wc_attribute->set_options( $this->get_options() );
			$this->wc_attribute->set_position( $this->data['position'] );
			$this->wc_attribute->set_variation( $this->data['variation'] );
			$this->wc_attribute->set_visible( $this->data['visible'] );

			global $wpdb;
			if( wc_multistore_table_exists($wpdb->prefix . 'woo_multistore_attributes_relationships') && ! wc_multistore_get_child_product_attribute_by_id( $this->data['id'] ) ){
				$wpdb->insert(
					$wpdb->prefix . 'woo_multistore_attributes_relationships',
					array(
						'attribute_id' => $this->data['id'],
						'child_attribute_id' => $this->wc_attribute->get_id()
					),
					array( '%d' )
				);
			}
		}else{
			$this->wc_attribute = new WC_Product_Attribute();
			$this->wc_attribute->set_id( 0 );
			$this->wc_attribute->set_name( $this->data['name'] );
			$this->wc_attribute->set_options( $this->data['terms'] );
			$this->wc_attribute->set_position( $this->data['position'] );
			$this->wc_attribute->set_variation( $this->data['variation'] );
			$this->wc_attribute->set_visible( $this->data['visible'] );
		}
	}


	public function update(){
		$this->wc_attribute = new WC_Product_Attribute();
		$this->wc_attribute->set_id($this->wc_attribute_id);

		$args = array(
			'attribute_type'    => $this->data['attribute_type'],
			'type'              => $this->data['attribute_type'],
			'attribute_orderby' => $this->data['attribute_orderby'],
			'has_archives'      => $this->data['attribute_public'],
		);

		if ( $this->site_settings['child_inherit_changes_fields_control_update__attribute_name'] == 'yes' ) {
			$args['name'] = $this->data['attribute_label'];
		}

		if ( $this->site_settings['child_inherit_changes_fields_control_update__attribute_slug'] == 'yes' ) {
			$this->wc_attribute->set_name( $this->data['name'] );
			$args['slug'] = $this->data['attribute_name'];
		}else{
			$child_attribute = wc_get_attribute($this->wc_attribute_id);
			$this->wc_attribute->set_name( $child_attribute->slug );
		}

		wc_update_attribute( $this->wc_attribute->get_id(), $args );

		// register taxonomy if slug changed
		if ( ! taxonomy_exists($this->data['name']) ){
			register_taxonomy(
				$this->data['name'],
				array( 'product', 'product_variation' ),
				array(
					'hierarchical' => false,
					'label'        => ucfirst( $this->data['attribute_label'] ),
					'query_var'    => true,
					'rewrite'      => array( 'slug' => sanitize_title( $this->data['name'] ) )
				)
			);
		}

		$this->wc_attribute->set_options( $this->get_options() );
		$this->wc_attribute->set_position( $this->data['position'] );
		$this->wc_attribute->set_visible( $this->data['visible'] );
		$this->wc_attribute->set_variation( $this->data['variation'] );


		global $wpdb;
		if( wc_multistore_table_exists($wpdb->prefix . 'woo_multistore_attributes_relationships') && ! wc_multistore_get_child_product_attribute_by_id( $this->data['id'] ) ){
			$wpdb->insert(
				$wpdb->prefix . 'woo_multistore_attributes_relationships',
				array(
					'attribute_id' => $this->data['id'],
					'child_attribute_id' => $this->wc_attribute->get_id()
				),
				array( '%d' )
			);
		}
	}


	public function save(){
		if( ! $this->wc_attribute_id ){
			$this->create();
		}else{
			$this->update();
		}

		do_action('wc_multistore_child_attribute_saved', $this->wc_attribute, $this->data );

		return $this->wc_attribute;
	}

	public function get_options(){
		if( empty( $this->data['terms'] )  ){
			return array();
		}

		$terms   = array();

		foreach ( $this->data['terms'] as $product_term ) {
			$wc_multistore_attribute_child = new WC_Multistore_Product_Attribute_Term_Child($product_term);
			$wc_multistore_attribute_child->save();

			if ( $wc_multistore_attribute_child->term->term_id ) {
				$terms[] = $wc_multistore_attribute_child->term->term_id;
			}
		}

		return $terms;
	}
}