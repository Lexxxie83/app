<?php
/**
 * External Child Product Handler
 *
 * This handles external child product related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Product_External_Child
 */
class WC_Multistore_Product_External_Child extends WC_Multistore_Abstract_Product_Child {
	public function create() {
		parent::create();

		$this->wc_product->set_product_url($this->data['product_url']);
		$this->wc_product->set_button_text($this->data['button_text']);
	}

	public function update() {
		parent::update();

		if ( $this->has_publish_changes_enabled() ) {
			$this->wc_product->set_product_url($this->data['product_url']);
			$this->wc_product->set_button_text($this->data['button_text']);
		}
	}
}