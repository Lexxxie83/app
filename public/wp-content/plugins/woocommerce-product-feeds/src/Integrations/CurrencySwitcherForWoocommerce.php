<?php

namespace Ademti\WoocommerceProductFeeds\Integrations;

use Ademti\WoocommerceProductFeeds\Configuration\FeedConfigFactory;
use Ademti\WoocommerceProductFeeds\Helpers\TemplateLoader;
use Exception;
use function get_woocommerce_currencies;
use function get_woocommerce_currency;

/**
 * Integration class for:
 * https://woocommerce.com/products/currency-switcher-for-woocommerce/
 */
class CurrencySwitcherForWoocommerce {

	// Dependencies.
	protected FeedConfigFactory $feed_config_factory;
	protected TemplateLoader $template_loader;

	/**
	 * @var string
	 */
	private $currency = '';

	/**
	 * Constructor.
	 *
	 * @param FeedConfigFactory $feed_config_factory
	 * @param TemplateLoader $template_loader
	 */
	public function __construct(
		FeedConfigFactory $feed_config_factory,
		TemplateLoader $template_loader
	) {
		$this->feed_config_factory = $feed_config_factory;
		$this->template_loader     = $template_loader;
	}

	/**
	 * Capture the currency requested. Add hooks / filters.
	 */
	public function run(): void {
		add_action( 'woocommerce_gpf_feed_edit_page', [ $this, 'render_feed_edit_page' ], 10, 2 );
		add_filter( 'woocommerce_gpf_feed_config_valid_extra_keys', [ $this, 'register_config_key' ] );
		add_filter( 'wp', [ $this, 'maybe_trigger_integration' ] );
		add_filter( 'woocommerce_gpf_feed_list_columns', [ $this, 'add_feed_list_column' ] );
		add_filter( 'woocommerce_gpf_feed_list_column_callback', [ $this, 'register_column_callback' ], 10, 2 );
	}

	/**
	 * @return void
	 */
	public function maybe_trigger_integration() {
		$feed_config = $this->feed_config_factory->create_from_request();
		if ( empty( $feed_config ) ) {
			return;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$this->currency = sanitize_text_field( $_GET['currency'] ) ?? $feed_config->currency;
		if ( empty( $this->currency ) ) {
			return;
		}
		$_GET['currency'] = $this->currency;
		add_filter( 'woocommerce_gpf_cache_name', [ $this, 'granularise_cache_name' ], 10, 1 );
		add_filter( 'woocommerce_gpf_feed_item', [ $this, 'add_currency_arg_to_product_permalinks' ], 10, 2 );
		add_filter( 'woocommerce_gpf_store_info_currency', [ $this, 'fix_currency' ], 10, 2 );
	}

	/**
	 * @param $columns
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function add_feed_list_column( $columns ) {
		$pos = array_search( 'categories', array_keys( $columns ), true );

		return array_merge(
			array_slice( $columns, 0, $pos ),
			[
				'currency' => __( 'Currency', 'woocommerce_gpf' ),
			],
			array_slice( $columns, $pos, null )
		);
	}

	/**
	 * @param $callback
	 * @param $column
	 *
	 * @return array|null
	 */
	public function register_column_callback( $callback, $column ) {
		if ( 'currency' === $column ) {
			return [ $this, 'column_currency' ];
		}

		return $callback;
	}

	/**
	 * @param $item
	 * @param $column_name
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 * @throws Exception
	 */
	// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	public function column_currency( $item, $column_name ): void {
		$currency = $item->currency;
		if ( empty( $currency ) ) {
			$currency = '-';
		}
		echo esc_html( $currency );
	}
	// phpcs:enable Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed

	/**
	 * Render the currency dropdown on the manage feed page for a feed.
	 *
	 * @param $feed
	 * @param $template_vars
	 */
	public function render_feed_edit_page( $feed, $template_vars ): void {
		$template_vars['currency']   = $feed['currency'] ?? '';
		$template_vars['currencies'] = $this->get_currencies();
		$this->template_loader->output_template_with_variables(
			'woo-gpf',
			'admin-feed-edit-woocommerce-multicurrency',
			$template_vars
		);
		$base_dir = dirname( __DIR__, 2 );
		wp_enqueue_script(
			'woo-gpf-admin-feed-edit-woocommerce-multicurrency',
			plugins_url( basename( $base_dir ) ) . '/js/admin-feed-edit-woocommerce-multicurrency.js',
			[ 'jquery' ],
			WOOCOMMERCE_GPF_VERSION,
			true
		);
	}

	/**
	 * @return array
	 */
	private function get_currencies(): array {

		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		global $WCCS;
		$results = [];
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		if ( ! is_callable( [ $WCCS, 'wccs_get_currencies' ] ) ) {
			return $results;
		}
		$wc_currencies    = get_woocommerce_currencies();
		$default_currency = get_woocommerce_currency();
		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		$currencies = $WCCS->wccs_get_currencies();
		// Put WooCommerce's default at the top of the list so it is the default.
		$results[ $default_currency ] = $wc_currencies[ $default_currency ] ?? $default_currency;

		// Add in the other enabled currencies.
		foreach ( array_keys( $currencies ) as $currency_code ) {
			if ( $currency_code === $default_currency ) {
				continue;
			}
			$results[ $currency_code ] = $wc_currencies[ $currency_code ] ?? $currency_code;
		}

		return $results;
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	public function granularise_cache_name( $name ) {
		return $name . '_' . $this->currency;
	}

	/**
	 * @param $feed_item
	 * @param $wc_product
	 *
	 * @return mixed
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	public function add_currency_arg_to_product_permalinks( $feed_item, $wc_product ) {
		$feed_item->purchase_link = add_query_arg(
			[
				'currency' => $this->currency,
			],
			$feed_item->purchase_link
		);

		return $feed_item;
	}
	// phpcs:enable Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed

	/**
	 * Register our key with the config class.
	 *
	 * @param $keys
	 *
	 * @return mixed
	 */
	public function register_config_key( $keys ) {
		$keys[] = 'currency';

		return $keys;
	}

	/**
	 * We filter this late since the Currency Switcher extension doesn't update
	 * the currency until after the StoreInfo class is instantiated.
	 * @param $currency
	 *
	 * @return string
	 */
	public function fix_currency( $currency ) {
		static $currency = null;
		if ( $currency === null ) {
			$currency = get_woocommerce_currency();
		}

		return $currency;
	}
}
