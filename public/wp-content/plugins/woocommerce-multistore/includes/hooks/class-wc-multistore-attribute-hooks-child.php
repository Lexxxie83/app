<?php

/**
 * Child attribute hooks handler.
 *
 * This handles child attribute hooks related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Attribute_Hooks_Child
 **/
class WC_Multistore_Attribute_Hooks_Child {

	public $settings;

	public function __construct() {
		if ( ! WOO_MULTISTORE()->license->is_active() ) {
			return;
		}
		if ( ! WOO_MULTISTORE()->setup->is_complete ) {
			return;
		}
		if ( ! WOO_MULTISTORE()->data->is_up_to_date ) {
			return;
		}
		if ( WOO_MULTISTORE()->site->get_type() == 'master' ) {
			return;
		}
		$this->settings = WOO_MULTISTORE()->settings;

		$this->hooks();
	}

	public function hooks() {
		add_action( 'woocommerce_attribute_deleted', array( $this, 'delete_attribute_relationship' ), 10, 3 );
	}

	public function delete_attribute_relationship( $id, $name, $taxonomy ) {
		if ( WOO_MULTISTORE()->site->get_type() == 'master' ) {
			return;
		}

		global $wpdb;

		if( wc_multistore_table_exists($wpdb->prefix . 'woo_multistore_attributes_relationships') ){
			$wpdb->delete(
				$wpdb->prefix . 'woo_multistore_attributes_relationships',
				array(
					'child_attribute_id' => $id
				),
				array( '%d' )
			);
		}
	}

}