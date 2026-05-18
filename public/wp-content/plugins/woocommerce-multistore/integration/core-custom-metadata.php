<?php
/**
 * Sync custom metadata
 *
 * @since 4.1.0
 */

defined( 'ABSPATH' ) || exit;

class WOO_MSTORE_INTEGRATION_Sync_Custom_Meta {

	private $metadata;

	private $metadata_options;

	public function __construct() {
		$this->metadata_options = get_site_option( 'wc_multistore_custom_metadata', array() );
		if ( ! empty( $this->metadata_options ) && is_array( $this->metadata_options ) ) {
			$this->metadata = array_keys( $this->metadata_options );
		}

		add_filter( 'wc_multistore_master_product_data', array( $this, 'add_metadata' ), 10, 2 );
		add_action( 'wc_multistore_child_product_saved', array( $this, 'sync_metadata' ), 10, 2 );
	}

	/**
	 * Read a meta value for sync without triggering WC notices on internal product keys (_width, _sku, etc.).
	 *
	 * @param WC_Product $wc_product Product.
	 * @param string     $meta_key Meta key.
	 * @return mixed
	 */
	private function get_product_meta_for_sync( $wc_product, $meta_key ) {
		$meta_key = trim( (string) $meta_key );

		$data_store = $wc_product->get_data_store();
		if ( $data_store && is_callable( array( $data_store, 'get_internal_meta_keys' ) ) ) {
			$internal_keys = $data_store->get_internal_meta_keys();
			if ( in_array( $meta_key, $internal_keys, true ) ) {
				$getter = 'get_' . ltrim( $meta_key, '_' );
				if ( method_exists( $wc_product, $getter ) ) {
					return $wc_product->{ $getter }();
				}
				// Internal key without a matching get_*: never use WC_Data::get_meta() (triggers wc_doing_it_wrong).
				return get_post_meta( $wc_product->get_id(), $meta_key, true );
			}
		}

		return $wc_product->get_meta( $meta_key );
	}

	/**
	 * Whether this key should be written with WC_Product setters (internal data with a matching set_*).
	 *
	 * @param WC_Product $wc_product Product.
	 * @param string     $meta_key Meta key.
	 * @return bool
	 */
	private function has_internal_meta_setter( $wc_product, $meta_key ) {
		$data_store = $wc_product->get_data_store();
		if ( ! $data_store || ! is_callable( array( $data_store, 'get_internal_meta_keys' ) ) ) {
			return false;
		}
		$internal_keys = $data_store->get_internal_meta_keys();
		if ( ! in_array( $meta_key, $internal_keys, true ) ) {
			return false;
		}
		$setter = 'set_' . ltrim( $meta_key, '_' );

		return method_exists( $wc_product, $setter );
	}

	public function add_metadata( $data, $wc_product ) {
		$metadata = array();

		if ( WOO_MULTISTORE()->settings['sync-custom-metadata'] != 'yes' ) {
			return $data;
		}

		if ( empty( $this->metadata) ) {
			return $data;
		}

		$data['_custom_metadata'] = array();

		foreach ( $this->metadata as $meta_key ) {
			$meta_value = $this->get_product_meta_for_sync( $wc_product, $meta_key );
			if ( ! empty( $meta_value ) || $meta_value === '0' || $meta_value === 0) {
				$metadata [ $meta_key ] = $meta_value;
			}
		}


		if ( ! empty( $this->metadata_options ) ) {
			foreach ( $this->metadata_options  as $key => $value ) {
				if ( is_array( $value ) ) {
					foreach ( $value as $k => $v ) {
						if ( isset( $metadata [ $key ] ) ) {
							$meta_value = $metadata [ $key ];
						} else {
							$meta_value = array();
						}

						if ( isset( $data['_custom_metadata'][ $k ] ) ) {
							$data['_custom_metadata'][ $k ][ $key ] = $meta_value;
						} else {
							$data['_custom_metadata'][ $k ]         = array();
							$data['_custom_metadata'][ $k ][ $key ] = $meta_value;
						}
					}
				}
			}
		}

		return $data;

	}

	public function sync_metadata( $wc_product, $data ) {
		if( is_multisite() ){
			$site = WOO_MULTISTORE()->sites[get_current_blog_id()];
		}else{
			$site = WOO_MULTISTORE()->site;
		}

		if ( empty( $data['_custom_metadata'] ) ) {
			return;
		}

		if ( ! isset( $data['_custom_metadata'][ $site->get_id() ] ) ) {
			return;
		}

		if ( ! empty( $data['_custom_metadata'][ $site->get_id() ] ) ) {
			$needs_save = false;
			foreach ( $data['_custom_metadata'][ $site->get_id() ] as $meta_key => $meta_value ) {
				$clear = empty( $meta_value ) && $meta_value !== 0 && $meta_value !== '0';

				if ( $this->has_internal_meta_setter( $wc_product, $meta_key ) ) {
					$setter = 'set_' . ltrim( $meta_key, '_' );
					if ( $clear ) {
						$wc_product->{ $setter }( '' );
					} else {
						$wc_product->{ $setter }( $meta_value );
					}
					$needs_save = true;
				} elseif ( $clear ) {
					delete_post_meta( $wc_product->get_id(), $meta_key );
				} else {
					update_post_meta( $wc_product->get_id(), $meta_key, $meta_value );
				}
			}
			if ( $needs_save ) {
				$wc_product->save();
			}
		}
	}
}

new WOO_MSTORE_INTEGRATION_Sync_Custom_Meta();
