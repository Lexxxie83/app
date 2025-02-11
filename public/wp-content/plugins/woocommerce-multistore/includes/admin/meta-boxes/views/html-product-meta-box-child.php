<?php
global $product_object;
if ( ! $product_object ) {
	return;
}
?>

<?php if( ! $product_object->get_meta( '_woonet_network_is_child_product_url', true ) ): ?>
    This product is not part of the network
<?php else: ?>
    <a href="<?php echo  $product_object->get_meta('_woonet_network_is_child_product_url'); ?>" target="_blank">Parent product</a>
<?php endif; ?>
