<?php
/**
 * Variable Child Product Handler
 *
 * This handles variable child product related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Product_Variable_Child
 */
class WC_Multistore_Product_Variable_Child extends WC_Multistore_Abstract_Product_Child {

	public $variation_errors;

	public function create() {
		parent::create();

		if( $this->duplicate_sku ){
			return;
		}

		if( $this->duplicate_gtin ){
			return;
		}

		global $WC_Multistore_Product_Hooks_Master;
		global $WC_Multistore_Stock_Hooks_Child;
		global $WC_Multistore_Stock_Hooks_Master;

		remove_action('woocommerce_update_product', array( $WC_Multistore_Product_Hooks_Master,'update_master_product' ) );
		remove_action( 'woocommerce_product_set_stock', array( $WC_Multistore_Stock_Hooks_Child, 'update_child_product_stock' ) );
		remove_action( 'woocommerce_variation_set_stock', array( $WC_Multistore_Stock_Hooks_Child, 'update_child_variation_stock' ) );
		remove_action( 'woocommerce_product_set_stock', array( $WC_Multistore_Stock_Hooks_Master, 'update_child_product_stock' ) );
		remove_action( 'woocommerce_variation_set_stock', array( $WC_Multistore_Stock_Hooks_Master, 'update_child_variation_stock' ) );

		do_action( 'wc_multistore_before_child_product_save', $this->wc_product, $this->data );

		$this->wc_product->save();

		do_action( 'wc_multistore_child_product_saved', $this->wc_product, $this->data );


		add_action('woocommerce_update_product', array( $WC_Multistore_Product_Hooks_Master,'update_master_product' ), 10, 2 );
		add_action( 'woocommerce_product_set_stock', array( $WC_Multistore_Stock_Hooks_Child, 'update_child_product_stock' ) );
		add_action( 'woocommerce_variation_set_stock', array( $WC_Multistore_Stock_Hooks_Child, 'update_child_variation_stock' ) );
		add_action( 'woocommerce_product_set_stock', array( $WC_Multistore_Stock_Hooks_Master, 'update_master_product_stock' ) );
		add_action( 'woocommerce_variation_set_stock', array( $WC_Multistore_Stock_Hooks_Master, 'update_master_variation_stock' ) );

		if( $this->site_settings['child_inherit_changes_fields_control__variations'] == 'yes' ){
			$this->wc_product->set_children( $this->get_children() );
		}
	}

	public function update() {
		parent::update();
		if( $this->has_publish_changes_enabled() ){
			if( $this->site_settings['child_inherit_changes_fields_control_update__variations'] == 'yes' ){
				$this->wc_product->set_children( $this->get_children() );
			}
		}
	}

	public function get_children(){
		$variations = $this->data['variations'];
		$ids = $this->wc_product->get_children();


		if( empty( $variations ) ){
			return null;
		}

		$new_ids = array();
		foreach ( $variations as $variation ){
			$wc_multistore_product_variation_child = new WC_Multistore_Product_Variation_Child($variation);
			$wc_multistore_product_variation_child->wc_product->set_parent_id( $this->wc_product->get_id() );
			$result = $wc_multistore_product_variation_child->save();
			if( $result['status'] == 'success' ){
				$new_ids[] = $wc_multistore_product_variation_child->wc_product->get_id();
			}else{
				$this->variation_errors[] =  $result;
			}
		}

		if( ! empty( $ids ) ){
			foreach ( $ids as $id ){
				if( ! in_array( $id, $new_ids ) ){
					$variation = wc_get_product($id);
					if( $variation && $variation->get_type() == 'variation' ){
						$variation->delete(true);
					}
				}
			}
		}

		return $new_ids;
	}


	public function get_sync_data(){
		$post_type_object = get_post_type_object( 'product' );
		$data = array(
			'status' => 'success',
			'id' => $this->wc_product->get_id(),
			'sku' => $this->wc_product->get_sku('edit'),
			'language' => $this->language,
			'edit_link' => admin_url( sprintf( $post_type_object->_edit_link . '&action=edit', $this->wc_product->get_id() ) ),
			'variation_errors' => $this->variation_errors
		);

		return $data;
	}

}