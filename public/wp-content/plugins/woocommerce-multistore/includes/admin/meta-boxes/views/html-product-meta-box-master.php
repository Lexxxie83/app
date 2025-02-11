<?php
global $product_object;
if( ! $product_object ){
	return;
}

if( empty( WOO_MULTISTORE()->active_sites )  ){
	return;
}
?>

<?php if( ! $product_object->get_meta( '_woonet_network_main_product', true ) ) : ?>
    This product is not synced to any store.
<?php else: ?>
	<?php $children_data = $product_object->get_meta('_woonet_children_data'); ?>
	<?php foreach ( WOO_MULTISTORE()->active_sites as $site ):  ?>

		<?php if( ! $product_object->get_meta('_woonet_children_data') ): ?>
			<?php continue; ?>
		<?php else: ?>
            <div>
                <?php if( ! empty($children_data[$site->get_id()]) && ! empty($children_data[$site->get_id()]['edit_link']) ): ?>
				    <?php echo $site->get_name(); ?> <a href="<?php echo $children_data[$site->get_id()]['edit_link']; ?>" target="_blank">Child Product</a>
                <?php endif; ?>
            </div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
