<ul class="woo-multistore-order-origin">
	<?php
	global $theorder;
	$text = $theorder->get_meta( 'WOONET_PARENT_ORDER_ORIGIN_TEXT', true, 'edit' );
	$parent_id = $theorder->get_meta( 'WOONET_PARENT_ORDER_ORIGIN_ID', true, 'edit' );
	$url = $theorder->get_meta( 'WOONET_PARENT_ORDER_ORIGIN_URL', true, 'edit' ) . '/wp-admin/post.php?post='.$parent_id.'&action=edit';
    ?>
    <li>
        <a target='_blank' href='<?php echo $url; ?>'><?php echo $text; ?></a>
    </li>
</ul>