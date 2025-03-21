<?php

namespace Ademti\WoocommerceProductFeeds\Cache\Jobs;

class ClearAllJob extends AbstractCacheRebuildJob {

	/**
	 * The action hook used for this job.
	 */
	protected string $action_hook = 'woocommerce_product_feeds_cache_clear_all';

	/**
	 * Task controller.
	 *
	 * Clear existing cache items, and queue a full rebuild.
	 */
	public function task(): void {

		global $wpdb, $table_prefix;

		// Clear existing cache items.
		$wpdb->query(
			$wpdb->prepare(
				'DELETE FROM %i',
				$table_prefix . 'wc_gpf_render_cache'
			)
		);

		// Queue a rebuild.
		as_schedule_single_action(
			time(),
			'woocommerce_product_feeds_cache_rebuild_simple',
			[
				0,
				apply_filters( 'woocommerce_product_feeds_rebuild_chunk_limit_simple', 30 ),
				[],
			],
			'woocommerce-product-feeds'
		);
		as_schedule_single_action(
			time(),
			'woocommerce_product_feeds_cache_rebuild_complex',
			[
				0,
				apply_filters( 'woocommerce_product_feeds_rebuild_chunk_limit_complex', 1 ),
				[],
			],
			'woocommerce-product-feeds'
		);
	}
}
