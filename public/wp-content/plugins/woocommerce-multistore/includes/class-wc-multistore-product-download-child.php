<?php
/**
 * Product Download Child Handler
 *
 * This handles product download child related functionality.
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class WC_Multistore_Product_Download_Child
 */
class WC_Multistore_Product_Download_Child {
	public $wc_download;

	public $data;

	public function __construct( $download ) {
		if ( is_numeric( $download ) ) {

		} else {
			$this->data = $download;
		}
	}

	public function save(){
		$this->wc_download = new WC_Product_Download();
		$this->wc_download->set_id($this->data['id']);
		$this->wc_download->set_name($this->data['name']);
		$this->wc_download->set_file($this->get_file());
	}

	public function get_file(){
		$attachment = $this->data['file'];
		$is_local = $this->data['is_local'] == 'yes';
		if( empty($attachment) || ! $is_local){
			return $attachment;
		}

		$child_attachment_id = wc_multistore_get_child_attachment_id($attachment['ID']);
		if( ! $child_attachment_id ){
			add_filter( 'upload_dir', array( $this, 'upload_dir' ) ); //filter to change folder to woocommerce
			$wc_multistore_attachment_child = new WC_Multistore_Attachment_Child($this->data['file']);
			$child_attachment_id = $wc_multistore_attachment_child->save();
			remove_filter('upload_dir', array( $this, 'upload_dir' ) );
		}

		return wp_get_attachment_url($child_attachment_id);
	}

	public function upload_dir( $pathdata ) {
		if ( empty( $pathdata['subdir'] ) ) {
			$pathdata['path']   = $pathdata['path'] . '/woocommerce_uploads';
			$pathdata['url']    = $pathdata['url'] . '/woocommerce_uploads';
			$pathdata['subdir'] = '/woocommerce_uploads';
		} else {
			$new_subdir = '/woocommerce_uploads' . $pathdata['subdir'];

			$pathdata['path']   = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['path'] );
			$pathdata['url']    = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['url'] );
			$pathdata['subdir'] = str_replace( $pathdata['subdir'], $new_subdir, $pathdata['subdir'] );
		}

		return $pathdata;
	}
}