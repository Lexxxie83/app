<?php
/**
 * Child Attachment Handler
 *
 * This handles child attachment related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Attachment_Master
 */
class WC_Multistore_Image_Child extends  WC_Multistore_Abstract_Attachment_Child {

	public $idPrefix  = 1000000;

	public function __construct( $attachment ){
		if( !function_exists('media_sideload_image') ){
			require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
			require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
			require_once(ABSPATH . 'wp-admin' . '/includes/media.php');
		}

		if( is_numeric( $attachment ) ){

		}else{
			$this->data = $attachment;
			if( WOO_MULTISTORE()->settings['enable-global-image'] != 'yes' ){
				$this->attachment_id = wc_multistore_get_child_attachment_id( $this->data['ID'] );
			}
			$this->site_settings = wc_multistore_get_site_settings();
		}
	}

	public function create() {
		$this->attachment_id = media_sideload_image( $this->data['url'], 0, $this->data['post_content'],'id' );

		$args = array();
		$args['ID'] = $this->attachment_id;
		$args['post_title'] = $this->data['post_title'];
		$args['post_content'] = $this->data['post_content'];


		wp_update_post( $args );
		if ( $this->site_settings['child_inherit_changes_fields_control__product_image_alt'] == 'yes' ) {
			update_post_meta( $this->attachment_id, '_wp_attachment_image_alt', $this->data['alt'] );
		}
		update_post_meta( $this->attachment_id, '_woonet_master_attachment_id', $this->data['ID'] );
	}

	public function update(){
		$args = array();
		$args['ID'] = $this->attachment_id;
		$args['post_title'] = $this->data['post_title'];
		$args['post_content'] = $this->data['post_content'];


		wp_update_post( $args );
		if ( $this->site_settings['child_inherit_changes_fields_control_update__product_image_alt'] == 'yes' ) {
			update_post_meta( $this->attachment_id, '_wp_attachment_image_alt', $this->data['alt'] );
		}
		update_post_meta( $this->attachment_id, '_woonet_master_attachment_id', $this->data['ID'] );
	}

	public function save(){
		if( WOO_MULTISTORE()->settings['enable-global-image'] == 'yes' ){
			$child_attachment_id = $this->idPrefix . $this->data['ID'];
			if( ! is_multisite() ){
				$global_image_data     = array(
					'meta_data'    => $this->data['meta'],
					'uploads_dir'  => $this->data['wp_uploads_dir'],
					'src'          => $this->data['url'],
					'alt'          => $this->data['alt']
				);
				wc_multistore_update_global_image_metadata($this->data['ID'], $global_image_data );
			}
			return $child_attachment_id;
		}

		return parent::save();
	}

}