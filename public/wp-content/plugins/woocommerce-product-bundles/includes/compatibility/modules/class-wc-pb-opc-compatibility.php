<?php
/**
 * WC_PB_OPC_Compatibility class
 *
 * @package  WooCommerce Product Bundles
 * @since    4.11.4
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * One Page Checkout Compatibility.
 *
 * @version  6.21.0
 */
class WC_PB_OPC_Compatibility {

	/**
	 * Initialize the class.
	 */
	public static function init() {

		// OPC support.
		add_action( 'wcopc_bundle_add_to_cart', array( __CLASS__, 'opc_single_add_to_cart_bundle' ) );
		add_filter( 'wcopc_allow_cart_item_modification', array( __CLASS__, 'opc_disallow_bundled_cart_item_modification' ), 10, 4 );
	}

	/**
	 * OPC Single-product bundle-type add-to-cart template.
	 *
	 * @param  int $opc_post_id The post ID of the OPC page.
	 * @return void
	 */
	public static function opc_single_add_to_cart_bundle( $opc_post_id ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found

		global $product;

		// Enqueue script.
		wp_enqueue_script( 'wc-add-to-cart-bundle' );
		wp_enqueue_style( 'wc-bundle-css' );

		if ( $product->is_purchasable() ) {

			$bundled_items = $product->get_bundled_items();
			$form_classes  = array( 'layout_' . $product->get_layout(), 'group_mode_' . $product->get_group_mode() );

			if ( ! empty( $bundled_items ) ) {

				ob_start();

				wc_get_template(
					'single-product/add-to-cart/bundle.php',
					array(
						'bundled_items'     => $bundled_items,
						'product'           => $product,
						/**
						 * Filter the classes to apply to the form.
						 *
						 * @since 6.7.6
						 * @param array $form_classes The classes to apply to the form.
						 * @param WC_Product_Bundle $product The product object.
						 */
						'classes'           => implode( ' ', apply_filters( 'woocommerce_bundle_form_classes', $form_classes, $product ) ),
						// Back-compat.
						'product_id'        => $product->get_id(),
						'availability_html' => wc_get_stock_html( $product ),
						'bundle_price_data' => $product->get_bundle_form_data(),
					),
					false,
					WC_PB()->plugin_path() . '/templates/'
				);

				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo str_replace( array( '<form method="post" enctype="multipart/form-data"', '</form>' ), array( '<div', '</div>' ), ob_get_clean() );
			}
		}
	}

	/**
	 * Prevent OPC from managing bundled items.
	 *
	 * @param  bool   $allow     Whether to allow the cart item to be modified.
	 * @param  array  $cart_item The cart item.
	 * @param  string $cart_item_key The cart item key.
	 * @param  string $opc_id The OPC ID.
	 * @return bool
	 */
	public static function opc_disallow_bundled_cart_item_modification( $allow, $cart_item, $cart_item_key, $opc_id ) {  // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
		if ( wc_pb_is_bundled_cart_item( $cart_item ) ) {
			$allow = false;
		}
		return $allow;
	}
}

WC_PB_OPC_Compatibility::init();
