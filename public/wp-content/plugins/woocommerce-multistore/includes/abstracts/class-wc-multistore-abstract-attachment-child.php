<?php
/**
 * Abstract Child Attachment Handler
 *
 * This handles abstract child attachment related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Abstract_Attachment_Child
 */
class WC_Multistore_Abstract_Attachment_Child{

	public $attachment;

	public $attachment_id = false;

	public $data;

	public $site_settings;

	public function __construct( $attachment ){
		if( is_numeric( $attachment ) ){

		}else{
			$this->data = $attachment;
			$this->attachment_id = wc_multistore_get_child_attachment_id( $this->data['ID'] );
			$this->site_settings = wc_multistore_get_site_settings();
		}
	}

	public function create(){
		$file_array         = array();
		$file_array['name'] = basename( current( explode( '?', $this->data['url'] ) ) );

		// Download file to temp location.
		$file_array['tmp_name'] = download_url( $this->data['url'] );

		// If error storing temporarily, return the error.
		if ( is_wp_error( $file_array['tmp_name'] ) ) {
			return new WP_Error('wc_multistore_invalid_remote_file_url',sprintf( __( 'Error getting remote file %s.', 'woonet' ), $this->data['url'] ) . ' '. sprintf( __( 'Error: %s', 'woonet' ), $file_array['tmp_name']->get_error_message() ), array( 'status' => 400 ) );
		}

		$this->attachment_id = media_handle_sideload( $file_array );

		$args = array();
		$args['ID'] = $this->attachment_id;
		$args['post_title'] = $this->data['post_title'];
		$args['post_content'] = $this->data['post_content'];


		wp_update_post( $args );
		update_post_meta( $this->attachment_id, '_wp_attachment_image_alt', $this->data['alt'] );
		update_post_meta( $this->attachment_id, '_woonet_master_attachment_id', $this->data['ID'] );
	}

	public function update(){
		$args = array();
		$args['ID'] = $this->attachment_id;
		$args['post_title'] = $this->data['post_title'];
		$args['post_content'] = $this->data['post_content'];


		wp_update_post( $args );
		update_post_meta( $this->attachment_id, '_wp_attachment_image_alt', $this->data['alt'] );
		update_post_meta( $this->attachment_id, '_woonet_master_attachment_id', $this->data['ID'] );
	}


	public function save(){
		if( $this->attachment_id ){
			$this->update();
		}else{
			$this->create();
		}

		return $this->attachment_id;
	}

}