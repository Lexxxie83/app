<?php

namespace Ademti\WoocommerceProductFeeds\Configuration;

use Ademti\WoocommerceProductFeeds\Helpers\TermDepthRepository;
use Exception;
use Throwable;
use function version_compare;

/**
 * Configuration class.
 *
 * Holds the config about what fields are available.
 */
class Configuration {

	// Dependencies.
	protected TermDepthRepository $term_depth_repository;

	/**
	 * The field config array.
	 *
	 * The full list of available fields.
	 *
	 * @var array
	 */
	public array $product_fields = [];

	/**
	 * The plugin settings.
	 *
	 * What settings have been chosen for each field, as well as non-field
	 * specific settings.
	 *
	 * @var array
	 */
	private array $settings = [];

	/**
	 * The array of available feed types.
	 *
	 * @var array.
	 */
	private array $feed_types = [];

	/**
	 * @param TermDepthRepository $term_depth_repository
	 */
	public function __construct( TermDepthRepository $term_depth_repository ) {
		$this->term_depth_repository = $term_depth_repository;
	}

	/**
	 * Initialise the class.
	 *
	 * Load the settings.
	 * Set up the available product fields.
	 * Set up the available feed types.
	 */
	public function initialise(): void {
		$this->settings       = get_option( 'woocommerce_gpf_config' );
		$base_dir             = dirname( __DIR__, 2 );
		$base_url             = plugins_url( basename( $base_dir ) );
		$this->product_fields = apply_filters(
			'woocommerce_gpf_all_product_fields',
			[
				'title'                               => [
					'desc'                   => __( 'Title', 'woocommerce_gpf' ),
					'full_desc'              => __( 'What to send as the title for this product in the feed.', 'woocommerce_gpf' ),
					'can_prepopulate'        => true,
					'feed_types'             => [ 'google', 'googlelocalproducts', 'bing' ],
					'mandatory'              => true,
					'skip_on_category_pages' => true,
					'callback'               => 'render_title',
					'google_len'             => 150,
					'ui_group'               => 'common',
				],
				'description'                         => [
					'desc'                   => __( 'Product description', 'woocommerce_gpf' ),
					'full_desc'              => __( 'Which description text to send in the feed for products.', 'woocommerce_gpf' ),
					'callback'               => 'render_description',
					'can_prepopulate'        => true,
					'feed_types'             => [ 'google', 'googlelocalproducts', 'bing' ],
					'mandatory'              => true,
					'skip_on_product_pages'  => true,
					'skip_on_category_pages' => true,
					'ui_group'               => 'common',
				],
				'availability_instock'                => [
					'desc'             => __( 'Availability (in stock products)', 'woocommerce_gpf' ),
					'full_desc'        => __( 'What status to send for in stock items.', 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'can_default'      => true,
					'mandatory'        => true,
					'feed_types'       => [ 'google', 'googleinventory', 'googlelocalproductinventory', 'bing' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::availability_options',
					'ui_group'         => 'common',
				],
				'availability_backorder'              => [
					'desc'             => __( 'Availability (backordered products)', 'woocommerce_gpf' ),
					'full_desc'        => __( 'What status to send for items on backorder.', 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'can_default'      => true,
					'mandatory'        => true,
					'feed_types'       => [ 'google', 'googleinventory', 'googlelocalproductinventory', 'bing' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::availability_options',
					'ui_group'         => 'common',
				],
				'availability_outofstock'             => [
					'desc'             => __( 'Availability (out of stock products)', 'woocommerce_gpf' ),
					'full_desc'        => __( 'What status to send for out of stock items.', 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'can_default'      => true,
					'mandatory'        => true,
					'feed_types'       => [ 'google', 'googleinventory', 'googlelocalproductinventory', 'bing' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::availability_options',
					'ui_group'         => 'common',
				],
				'certification'                       => [
					'desc'                   => __( 'Certification', 'woocommerce_gpf' ),
					'full_desc'              => __( 'Certifications, such as energy efficiency ratings, associated with your product. Use this field to provide a valid code for products from the EU EPREL database.', 'woocommerce_gpf' ),
					'feed_types'             => [ 'google' ],
					'can_prepopulate'        => false,
					'callback'               => 'render_certification',
					'skip_on_bulk_edit'      => true,
					'skip_on_category_pages' => true,
					'ui_group'               => 'advanced',
				],
				'is_bundle'                           => [
					'desc'             => __( 'Bundle indicator (is_bundle)', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Allows you to indicate whether a product is a "bundle" of products.', 'woocommerce_gpf' ),
					'callback'         => 'render_is_bundle',
					'feed_types'       => [ 'google' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::is_bundle_options',
					'ui_group'         => 'advanced',
				],
				'availability_date'                   => [
					'desc'       => __( 'Availability date', 'woocommerce_gpf' ),
					'full_desc'  => __( 'If you are accepting orders for products that are available for preorder or are on backorder, use this attribute to indicate when the product becomes available for delivery.', 'woocommerce_gpf' ),
					'callback'   => 'render_availability_date',
					'feed_types' => [ 'google' ],
					'ui_group'   => 'advanced',
				],
				'condition'                           => [
					'desc'             => __( 'Condition', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Condition or state of items', 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'can_default'      => true,
					'feed_types'       => [ 'google', 'googlelocalproducts', 'bing' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::condition_options',
					'ui_group'         => 'common',
				],
				'brand'                               => [
					'desc'            => __( 'Brand', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Brand of the items', 'woocommerce_gpf' ),
					'can_default'     => true,
					'can_prepopulate' => true,
					'feed_types'      => [ 'google', 'googlelocalproducts', 'bing' ],
					'google_len'      => 70,
					'max_values'      => 1,
					'ui_group'        => 'common',
				],
				'mpn'                                 => [
					'desc'            => __( 'Manufacturer Part Number (MPN)', 'woocommerce_gpf' ),
					'full_desc'       => __( 'This code uniquely identifies the product to its manufacturer', 'woocommerce_gpf' ),
					'feed_types'      => [ 'google', 'googlelocalproducts', 'bing' ],
					'can_prepopulate' => true,
					'google_len'      => 70,
					'max_values'      => 1,
					'ui_group'        => 'common',
				],
				'product_type'                        => [
					'desc'                 => __( 'Product Type', 'woocommerce_gpf' ),
					'full_desc'            => __( 'Your category of the items', 'woocommerce_gpf' ),
					'callback'             => 'render_product_type',
					'can_default'          => true,
					'can_prepopulate'      => true,
					'feed_types'           => [ 'google' ],
					'google_len'           => 750,
					'max_values'           => 5,
					'google_single_output' => ',',
					'ui_group'             => 'common',
				],
				'google_product_category'             => [
					'desc'        => __( 'Google Product Category', 'woocommerce_gpf' ),
					'full_desc'   => __( "Google's category of the item", 'woocommerce_gpf' ),
					'callback'    => 'render_product_type',
					'can_default' => true,
					'feed_types'  => [ 'google', 'googlelocalproducts' ],
					'google_len'  => 750,
					'ui_group'    => 'common',
				],
				'tax_category'                        => [
					'desc'            => __( 'Tax Category (US stores only)', 'woocommerce_gpf' ),
					'full_desc'       => __( 'The tax_category attribute allows you to organize your products according to custom tax rules.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'google_len'      => 100,
					'ui_group'        => 'advanced',
				],
				'gtin'                                => [
					'desc'            => __( 'Global Trade Item Number (GTIN)', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Global Trade Item Numbers (GTINs) for your items. These identifiers include UPC (in North America), EAN (in Europe), JAN (in Japan), and ISBN (for books)', 'woocommerce_gpf' ),
					'feed_types'      => [ 'google', 'googlelocalproducts', 'bing' ],
					'can_prepopulate' => true,
					'google_len'      => 50,
					'multiple'        => true,
					'ui_group'        => 'common',
				],
				'short_title'                         => [
					'desc'                   => __( 'Short title', 'woocommerce_gpf' ),
					'full_desc'              => __( 'Use this to briefly and clearly identify the product you’re selling. In contrast to the title attribute, the value you submit for the short title should be concise and will only be used in certain contexts where a short title is more user-frinedly, such as Discovery campaigns.', 'woocommerce_gpf' ),
					'can_prepopulate'        => true,
					'feed_types'             => [ 'google', 'googlelocalproducts' ],
					'skip_on_category_pages' => true,
					'google_len'             => 150,
					'max_values'             => 1,
					'ui_group'               => 'common',
				],
				'gender'                              => [
					'desc'             => __( 'Gender', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Target gender for the item', 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'can_default'      => true,
					'feed_types'       => [ 'google', 'googlelocalproducts' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::gender_options',
					'ui_group'         => 'advanced',
				],
				'age_group'                           => [
					'desc'             => __( 'Age Group', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Target age group for the item', 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'can_default'      => true,
					'feed_types'       => [ 'google', 'googlelocalproducts' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::age_group_options',
					'ui_group'         => 'advanced',
				],
				'color'                               => [
					'desc'                 => __( 'Colour', 'woocommerce_gpf' ),
					'full_desc'            => __( "Item's Colour", 'woocommerce_gpf' ),
					'feed_types'           => [ 'google', 'googlelocalproducts' ],
					'can_prepopulate'      => true,
					'google_len'           => 100,
					'google_single_output' => ' / ',
					'ui_group'             => 'common',
				],
				'size'                                => [
					'desc'            => __( 'Size', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Size of the items', 'woocommerce_gpf' ),
					'feed_types'      => [ 'google', 'googlelocalproducts' ],
					'can_prepopulate' => true,
					'google_len'      => 100,
					'ui_group'        => 'common',
				],
				'size_type'                           => [
					'desc'             => __( 'Size type', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Size type of the items', 'woocommerce_gpf' ),
					'feed_types'       => [ 'google' ],
					'can_default'      => true,
					'callback'         => 'render_generic_select',
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::size_type_options',
					'ui_group'         => 'common',
				],
				'size_system'                         => [
					'desc'             => __( 'Size system', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Size system', 'woocommerce_gpf' ),
					'feed_types'       => [ 'google' ],
					'can_default'      => true,
					'callback'         => 'render_generic_select',
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::size_system_options',
					'ui_group'         => 'common',
				],
				'unit_pricing_measure'                => [
					'desc'            => __( 'Unit pricing measure', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use this to define the measure and dimension of your product.', 'woocommerce_gpf' ),
					'feed_types'      => [ 'google', 'googlelocalproducts' ],
					'can_default'     => true,
					'can_prepopulate' => true,
					'callback'        => 'render_textfield',
					'ui_group'        => 'advanced',
				],
				'unit_pricing_base_measure'           => [
					'desc'            => __( 'Unit pricing base measure', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use this to include the denominator for your unit price. For example, you might be selling 150ml of perfume, but users are interested in seeing the price per 100ml.', 'woocommerce_gpf' ),
					'feed_types'      => [ 'google', 'googlelocalproducts' ],
					'can_default'     => true,
					'can_prepopulate' => true,
					'callback'        => 'render_textfield',
					'ui_group'        => 'advanced',
				],
				'multipack'                           => [
					'desc'            => __( 'Multipack', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use the multipack attribute to indicate that you\'ve grouped multiple identical products for sale as one item.', 'woocommerce_gpf' ),
					'feed_types'      => [ 'google' ],
					'can_default'     => true,
					'can_prepopulate' => true,
					'callback'        => 'render_textfield',
					'ui_group'        => 'advanced',
				],
				'installment'                         => [
					'desc'              => __( 'Installment', 'woocommerce_gpf' ),
					'full_desc'         => __( 'Use this to tell users the details of a monthly instalment plan that you offer to pay for your product.', 'woocommerce_gpf' ),
					'feed_types'        => [ 'google' ],
					'can_prepopulate'   => false,
					'callback'          => 'render_installment',
					'skip_on_bulk_edit' => true,
					'ui_group'          => 'advanced',
				],
				'material'                            => [
					'desc'                 => __( 'Material', 'woocommerce_gpf' ),
					'full_desc'            => __( "Item's material", 'woocommerce_gpf' ),
					'feed_types'           => [ 'google' ],
					'can_prepopulate'      => true,
					'google_len'           => 200,
					'google_single_output' => ' / ',
					'ui_group'             => 'advanced',
				],
				'pattern'                             => [
					'desc'            => __( 'Pattern', 'woocommerce_gpf' ),
					'full_desc'       => __( "Item's pattern", 'woocommerce_gpf' ),
					'feed_types'      => [ 'google' ],
					'can_prepopulate' => true,
					'google_len'      => 100,
					'ui_group'        => 'advanced',
				],
				'adult'                               => [
					'desc'             => __( 'Adult content', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Whether the product contains nudity or sexually suggestive content', 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'can_default'      => true,
					'feed_types'       => [ 'google' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::adult_options',
					'ui_group'         => 'advanced',
				],
				'identifier_exists'                   => [
					'desc'              => __( 'Identifier exists flag', 'woocommerce_gpf' ),
					'full_desc'         => __( "Whether to include 'Identifier exists - false' when products don't have the relevant identifiers", 'woocommerce_gpf' ),
					'callback'          => 'render_i_exists',
					'can_default'       => true,
					'feed_types'        => [ 'google' ],
					'skip_on_bulk_edit' => true,
					'ui_group'          => 'advanced',
				],
				'adwords_grouping'                    => [
					'desc'        => __( 'Adwords grouping filter', 'woocommerce_gpf' ),
					'full_desc'   => __( 'Used to group products in an arbitrary way. It can be used for Product Filters to limit a campaign to a group of products or Product Targets, to bid differently for a group of products. This is a required field if the advertiser wants to bid differently to different sub-sets of products in the CPC or CPA % version. It can only hold one value.', 'woocommerce_gpf' ),
					'can_default' => true,
					'feed_types'  => [ 'google' ],
					'ui_group'    => 'advanced',
				],
				'adwords_labels'                      => [
					'desc'            => __( 'Adwords labels', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Very similar to adwords_grouping, but it will only work on CPC. You can enter multiple values here, separating them with a comma (,). e.g. "widget,box".', 'woocommerce_gpf' ),
					'can_default'     => true,
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'multiple'        => true,
					'ui_group'        => 'advanced',
				],
				'bing_category'                       => [
					'desc'            => __( 'Bing Category', 'woocommerce_gpf' ),
					'full_desc'       => __( "Bing's category of the item", 'woocommerce_gpf' ),
					'callback'        => 'render_b_category',
					'can_default'     => true,
					'can_prepopulate' => true,
					'feed_types'      => [ 'bing' ],
					'ui_group'        => 'advanced',
				],
				'delivery_label'                      => [
					'desc'            => __( 'Delivery label', 'woocommerce_gpf' ),
					'full_desc'       => __( 'You can use this to control which shipping rules from your Merchant Centre account are applied to this product.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'can_prepopulate' => true,
					'callback'        => 'render_textfield',
					'feed_types'      => [ 'google' ],
					'google_len'      => 100,
					'ui_group'        => 'common',
				],
				'disclosure_date'                     => [
					'desc'            => __( 'Disclosure date', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use the disclosure date attribute to tell Google when a product should become visible in search results across Google’s YouTube surfaces only.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'can_prepopulate' => false,
					'callback'        => 'render_textfield',
					'feed_types'      => [ 'google' ],
					'google_len'      => 25,
					'ui_group'        => 'advanced',
				],
				'expiration_date'                     => [
					'desc'            => __( 'Expiration date', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use the expiry date attribute to stop showing a product on a specific date. For example, you can use this attribute for limited stock or seasonal products.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'can_prepopulate' => false,
					'callback'        => 'render_textfield',
					'feed_types'      => [ 'google' ],
					'google_len'      => 25,
					'ui_group'        => 'advanced',
				],
				'ships_from_country'                  => [
					'desc'             => __( 'Ships from country', 'woocommerce_gpf' ),
					'full_desc'        => __( 'You can use this to indicate which country products will typically be shipped from.', 'woocommerce_gpf' ),
					'can_default'      => true,
					'can_prepopulate'  => false,
					'callback'         => 'render_generic_select',
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::country_options',
					'feed_types'       => [ 'google' ],
					'ui_group'         => 'advanced',
				],
				'shopping_ads_excluded_country'       => [
					'desc'             => __( 'Shopping ads excluded countries', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Use this attribute to stop a product from showing in certain countries, while still allowing it to show in a primary country.', 'woocommerce_gpf' ),
					'can_default'      => true,
					'can_prepopulate'  => false,
					'callback'         => 'render_generic_multi_select',
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::country_options',
					'feed_types'       => [ 'google' ],
					'ui_group'         => 'advanced',
					'multiple'         => true,
					'import_as_array'  => true,
				],
				'transit_time_label'                  => [
					'desc'            => __( 'Transit time label', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Label that you assign to a product to help assign different transit times in Merchant Center account settings.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'can_prepopulate' => true,
					'callback'        => 'render_textfield',
					'feed_types'      => [ 'google' ],
					'google_len'      => 100,
					'ui_group'        => 'advanced',
				],
				'min_handling_time'                   => [
					'desc'        => __( 'Minimum handling time', 'woocommerce_gpf' ),
					'full_desc'   => __( 'The minimum handling time is the shortest amount of time (in days) between when an order is placed and when the product is dispatched.', 'woocommerce_gpf' ),
					'can_default' => true,
					'callback'    => 'render_textfield',
					'feed_types'  => [ 'google' ],
					'google_len'  => 5,
					'ui_group'    => 'advanced',
				],
				'max_handling_time'                   => [
					'desc'        => __( 'Maximum handling time', 'woocommerce_gpf' ),
					'full_desc'   => __( 'The maximum handling time is the longest amount of time (in days) between when an order is placed and when the product is dispatched.', 'woocommerce_gpf' ),
					'can_default' => true,
					'callback'    => 'render_textfield',
					'feed_types'  => [ 'google' ],
					'google_len'  => 5,
					'ui_group'    => 'advanced',
				],
				'energy_efficiency_class'             => [
					'desc'             => __( 'Energy efficiency class', 'woocommerce_gpf' ),
					'full_desc'        => __( "Your product's energy label", 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'feed_types'       => [ 'google', 'googlelocalproducts' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::energy_efficiency_class_options',
					'ui_group'         => 'advanced',
				],
				'min_energy_efficiency_class'         => [
					'desc'             => __( 'Minimum energy efficiency class', 'woocommerce_gpf' ),
					'full_desc'        => __( "Your product's minimum energy efficiency label", 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'feed_types'       => [ 'google', 'googlelocalproducts' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::energy_efficiency_class_options',
					'ui_group'         => 'advanced',
				],
				'max_energy_efficiency_class'         => [
					'desc'             => __( 'Maximum energy efficiency class', 'woocommerce_gpf' ),
					'full_desc'        => __( "Your product's maximum energy efficiency label", 'woocommerce_gpf' ),
					'callback'         => 'render_generic_select',
					'feed_types'       => [ 'google', 'googlelocalproducts' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::energy_efficiency_class_options',
					'ui_group'         => 'advanced',
				],
				'energy_label_image_link'             => [
					'desc'            => __( 'Energy label image link', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Image displayed when users click on the energy efficiency class, this image will be displayed [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'google_len'      => 2000,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
					'deprecated'      => true,
				],
				'cost_of_goods_sold'                  => [
					'desc'            => __( 'Cost of goods sold', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use this when reporting conversions with basket data to get additional reporting on gross profit. You should enter a value and currency, e.g. "8.08 USD"', 'woocommerce_gpf' ),
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'google_len'      => 50,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'included_destination'                => [
					'desc'            => __( 'Included destination', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use the included destination attribute to control the type of ads your products participate in. ', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => false,
					'feed_types'      => [ 'google' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'excluded_destination'                => [
					'desc'            => __( 'Excluded destination', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Use the excluded destination attribute to control the type of ads your products participate in.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => false,
					'feed_types'      => [ 'google' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'consumer_notice'                     => [
					'desc'              => __( 'Consumer notice(s)', 'woocommerce_gpf' ),
					'full_desc'         => __( 'Provide legally required warnings or disclosures [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'callback'          => 'render_consumer_notice',
					'can_prepopulate'   => false,
					'feed_types'        => [ 'google' ],
					'skip_on_bulk_edit' => true,
					'ui_group'          => 'advanced',
					'deprecated'        => true,
				],
				'product_highlight'                   => [
					'desc'              => __( 'Product highlight(s)', 'woocommerce_gpf' ),
					'full_desc'         => __( 'The most relevant highlights of your products', 'woocommerce_gpf' ),
					'callback'          => 'render_product_highlight',
					'can_prepopulate'   => false,
					'feed_types'        => [ 'google' ],
					'skip_on_bulk_edit' => true,
					'ui_group'          => 'advanced',
					'import_as_array'   => true,
				],
				'product_detail'                      => [
					'desc'              => __( 'Product detail(s)', 'woocommerce_gpf' ),
					'full_desc'         => __( 'Technical specifications or additional details of your product [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'callback'          => 'render_product_detail',
					'can_prepopulate'   => false,
					'feed_types'        => [ 'google' ],
					'skip_on_bulk_edit' => true,
					'ui_group'          => 'advanced',
					'deprecated'        => true,
				],
				'consumer_datasheet'                  => [
					'desc'              => __( 'Consumer datasheet', 'woocommerce_gpf' ),
					'full_desc'         => __( 'Use this attribute to provide regulatory product data [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'callback'          => 'render_consumer_datasheet',
					'can_prepopulate'   => false,
					'feed_types'        => [ 'google' ],
					'skip_on_bulk_edit' => true,
					'ui_group'          => 'advanced',
					'deprecated'        => true,
				],
				'product_fee'                         => [
					'desc'              => __( 'Product fee', 'woocommerce_gpf' ),
					'full_desc'         => __( 'Use this attribute to provide additional fees that must be paid when purchasing your product, for example government-imposed recycling fees or copyright fees [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'callback'          => 'render_product_fee',
					'can_prepopulate'   => false,
					'feed_types'        => [ 'google' ],
					'skip_on_bulk_edit' => true,
					'ui_group'          => 'advanced',
					'deprecated'        => true,
				],
				'sell_on_google_quantity'             => [
					'desc'            => __( 'Sell On Google Quantity', 'woocommerce_gpf' ),
					'full_desc'       => __( 'The total number of items available to sell on Google [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'google_len'      => 10,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
					'deprecated'      => true,
				],
				'pause'                               => [
					'desc'             => __( 'Pause', 'woocommerce_gpf' ),
					'full_desc'        => __(
						'Use to tell Google when you want to temporarily stop products from showing in all ads or Shopping destinations for up to 14 days.',
						'woocommerce_gpf'
					),
					'can_default'      => true,
					'callback'         => 'render_generic_select',
					'can_prepopulate'  => false,
					'feed_types'       => [ 'google' ],
					'max_values'       => 1,
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::pause_options',
					'ui_group'         => 'advanced',
				],
				'purchase_quantity_limit'             => [
					'desc'            => __( 'Purchase quantity limit', 'woocommerce_gpf' ),
					'full_desc'       => __(
						'The limit on the number of items your customers can buy in a single order

 [for Shopping Actions integration]',
						'woocommerce_gpf'
					),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'google_len'      => 10,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'google_funded_promotion_eligibility' => [
					'desc'             => __( 'Google-funded promotion eligibility', 'woocommerce_gpf' ),
					'full_desc'        => __( "Eligibility for participating in Google's promotions. [for shopping actions integration]", 'woocommerce_gpf' ),
					'feed_types'       => [ 'google' ],
					'can_default'      => true,
					'callback'         => 'render_generic_select',
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::google_funded_promotion_eligibility_options',
					'ui_group'         => 'advanced',
					'deprecated'       => true,
				],
				'return_address_label'                => [
					'desc'            => __( 'Return address label', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Specify the identifier of a specific return address [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
					'deprecated'      => true,
				],
				'return_policy_label'                 => [
					'desc'            => __( 'Return policy label', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Specify the identifier of a specific return policy [for Shopping Actions integration]', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
					'deprecated'      => true,
				],
				'pickup_method'                       => [
					'desc'             => __( 'Pickup method', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Specify the store pickup option for items [for Local Product integration]', 'woocommerce_gpf' ),
					'can_default'      => true,
					'callback'         => 'render_generic_select',
					'can_prepopulate'  => false,
					'feed_types'       => [ 'google' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::pickup_method_options',
					'ui_group'         => 'advanced',
				],
				'pickup_sla'                          => [
					'desc'             => __( 'Pickup SLA', 'woocommerce_gpf' ),
					'full_desc'        => __( 'When will an order be ready for pickup, relative to when the order is placed [for Local Product integration]', 'woocommerce_gpf' ),
					'can_default'      => true,
					'callback'         => 'render_generic_select',
					'can_prepopulate'  => false,
					'feed_types'       => [ 'google' ],
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::pickup_sla_options',
					'ui_group'         => 'advanced',
				],
				'custom_label_0'                      => [
					'desc'            => __( 'Custom label 0', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Can be used to segment your products when setting up shopping campaigns in Adwords.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google', 'bing' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'custom_label_1'                      => [
					'desc'            => __( 'Custom label 1', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Can be used to segment your products when setting up shopping campaigns in Adwords.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google', 'bing' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'custom_label_2'                      => [
					'desc'            => __( 'Custom label 2', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Can be used to segment your products when setting up shopping campaigns in Adwords.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google', 'bing' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'custom_label_3'                      => [
					'desc'            => __( 'Custom label 3', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Can be used to segment your products when setting up shopping campaigns in Adwords.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google', 'bing' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'custom_label_4'                      => [
					'desc'            => __( 'Custom label 4', 'woocommerce_gpf' ),
					'full_desc'       => __( 'Can be used to segment your products when setting up shopping campaigns in Adwords.', 'woocommerce_gpf' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google', 'bing' ],
					'google_len'      => 100,
					'max_values'      => 1,
					'ui_group'        => 'advanced',
				],
				'promotion_id'                        => [
					'desc'            => __( 'Promotion ID', 'woocommerce_gpf' ),
					'full_desc'       => __( 'The unique ID of a promotion.' ),
					'can_default'     => true,
					'callback'        => 'render_promotion_id',
					'can_prepopulate' => true,
					'feed_types'      => [ 'google' ],
					'ui_group'        => 'advanced',
					'multiple'        => true,
				],
				'bing_promotion_id'                   => [
					'desc'            => __( 'Promotion ID [Bing]', 'woocommerce_gpf' ),
					'full_desc'       => __( 'The unique ID of a promotion.' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => true,
					'feed_types'      => [ 'bing' ],
					'ui_group'        => 'advanced',
				],
				'shippingprice'                       => [
					'desc'            => __( 'Bing shipping info (price only)', 'woocommerce_gpf' ),
					'full_desc'       => __( 'The shipping field is required for Bing feed for Germany only. The format of the value is &quot;price&quot;, for example : 6.49' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => false,
					'feed_types'      => [ 'bing' ],
					'ui_group'        => 'advanced',
				],
				'shippingcountryprice'                => [
					'desc'            => __( 'Bing shipping info (country and price)', 'woocommerce_gpf' ),
					'full_desc'       => __( 'The shipping field is required for Bing feed for Germany only. The format of the value is &quot;country:price&quot;, for example : DE:6.49' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => false,
					'feed_types'      => [ 'bing' ],
					'ui_group'        => 'advanced',
				],
				'shippingcountryserviceprice'         => [
					'desc'            => __( 'Bing shipping info (country, service and price)', 'woocommerce_gpf' ),
					'full_desc'       => __( 'The shipping field is required for Bing feed for Germany only. The format of the value is &quot;country:service:price&quot;, for example : DE:Standard:6.49' ),
					'can_default'     => true,
					'callback'        => 'render_textfield',
					'can_prepopulate' => false,
					'feed_types'      => [ 'bing' ],
					'ui_group'        => 'advanced',
				],
				'ondisplaytoorder'                    => [
					'desc'             => __( 'On display to order (for local inventory)', 'woocommerce_gpf' ),
					'full_desc'        => __( 'Use this flag to show products in your local inventory feeds that are displayed in your store but are not available for immediate purchase, for example, large furniture. For any products where this is set to "yes" your WooCommerce inventory level will be ignored for the local product feed, and the product simply set as on display to order.', 'woocommerce_gpf' ),
					'can_default'      => true,
					'callback'         => 'render_generic_select',
					'options_callback' => '\\Ademti\\WoocommerceProductFeeds\\Configuration\\FieldOptions::ondisplaytoorder_options',
					'can_prepopulate'  => false,
					'feed_types'       => [ 'googlelocalproductinventory' ],
					'ui_group'         => 'advanced',
				],
			]
		);
		/**
		 * name: public facing name of the feed
		 * icon: icon to use in the UI
		 * class: class resonsible for formatting an item
		 */
		$this->feed_types = apply_filters(
			'woocommerce_gpf_feed_types',
			[
				'google'                      => [
					'name'        => __( 'Google merchant centre product feed', 'woocommerce_gpf' ),
					'plural_name' => __( 'Google merchant centre product feeds', 'woocommerce_gpf' ),
					'icon'        => $base_url . '/images/google.png',
					'class'       => 'GoogleProductFeed',
					'type'        => 'product',
					'url_args'    => [],
					'legacy'      => false,
					'cacheable'   => true,
				],
				'googlereview'                => [
					'name'        => __( 'Google merchant centre product review feed', 'woocommerce_gpf' ),
					'plural_name' => __( 'Google merchant centre product review feeds', 'woocommerce_gpf' ),
					'icon'        => $base_url . '/images/google.png',
					'class'       => 'ReviewProductInfo',
					'type'        => 'review',
					'url_args'    => [],
					'legacy'      => false,
					'cacheable'   => true,
				],
				'bing'                        => [
					'name'        => __( 'Bing merchant centre feed', 'woocommerce_gpf' ),
					'plural_name' => __( 'Bing merchant centre feeds', 'woocommerce_gpf' ),
					'icon'        => $base_url . '/images/bing.png',
					'class'       => 'BingFeed',
					'type'        => 'product',
					'url_args'    => [
						'f' => 'f.txt',
					],
					'legacy'      => false,
					'cacheable'   => true,
				],
				'googlelocalproductinventory' => [
					'name'        => __( 'Google merchant centre local product inventory feed', 'woocommerce_gpf' ),
					'plural_name' => __( 'Google merchant centre local product inventory feeds', 'woocommerce_gpf' ),
					'icon'        => $base_url . '/images/google.png',
					'class'       => 'GoogleLocalProductInventoryFeed',
					'type'        => 'product',
					'url_args'    => [],
					'legacy'      => false,
					'cacheable'   => true,
				],
				'googlelocalproducts'         => [
					'name'        => __( 'Google merchant centre local products feed (legacy)', 'woocommerce_gpf' ),
					'plural_name' => __( 'Google merchant centre local products feeds (legacy)', 'woocommerce_gpf' ),
					'icon'        => $base_url . '/images/google.png',
					'class'       => 'GoogleLocalProductFeed',
					'type'        => 'product',
					'url_args'    => [],
					'legacy'      => true,
					'cacheable'   => true,
				],
				'googleinventory'             => [
					'name'        => __( 'Google merchant centre product inventory feed (legacy)', 'woocommerce_gpf' ),
					'plural_name' => __( 'Google merchant centre product inventory feeds (legacy)', 'woocommerce_gpf' ),
					'icon'        => $base_url . '/images/google.png',
					'class'       => 'GoogleInventoryFeed',
					'type'        => 'product',
					'url_args'    => [],
					'legacy'      => true,
					'cacheable'   => true,
				],
				'googlepromotions'            => [
					'name'        => __( 'Google merchant centre promotion feed', 'woocommerce_gpf' ),
					'plural_name' => __( 'Google merchant centre promotion feeds', 'woocommerce_gpf' ),
					'icon'        => $base_url . '/images/google.png',
					'class'       => 'PromotionFeed',
					'type'        => 'promotion',
					'url_args'    => [],
					'legacy'      => false,
					'cacheable'   => false,
				],
			]
		);
		add_action( 'plugins_loaded', [ $this, 'late_filtering' ], 999 );
	}

	/**
	 * Provides a second chance to filter the fields and settings.
	 *
	 * Supports integrations that aren't instantiated until later in the plugins_loaded hook cycle than
	 * the initialisation() call above. Filter name varies to avoid duplicate work.
	 *
	 * @return void
	 */
	public function late_filtering(): void {
		$this->product_fields = apply_filters(
			'woocommerce_gpf_all_product_fields_late_filtering',
			$this->product_fields
		);
		$this->settings       = apply_filters(
			'woocommerce_gpf_configuration_settings',
			$this->settings
		);
	}

	/**
	 * Accessor.
	 *
	 * @return array
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Get all the configured feed types.
	 *
	 * @return array  The feed type configs for all feed types, keyed by feed
	 *                type identifier.
	 */
	public function get_feed_types(): array {
		return $this->feed_types;
	}

	/**
	 * Get the configured prepopulations.
	 * @return array
	 */
	public function get_prepopulations(): array {
		// Get a list of pre-populations chosen for fields.
		$prepopulations = array_filter( $this->settings['product_prepopulate'] ?? [] );
		// Find out which fields are enabled.
		$product_fields = array_filter(
			$this->settings['product_fields'],
			static function ( $value ) {
				return $value === 'on';
			},
			0
		);
		// Filter the required pre-populations to only those that exist on enabled fields.
		return array_intersect_key( $prepopulations, $product_fields );
	}

	/**
	 * Get the defaults that apply to a product.
	 *
	 * @param int $product_id The product ID.
	 * @param string $feed_format The feed type being generated.
	 *
	 * @return array
	 */
	public function get_defaults_for_product( $product_id, string $feed_format = 'all' ) {
		$defaults = array_merge(
			$this->get_store_default_values(),
			$this->get_category_values_for_product( $product_id )
		);
		$defaults = $this->remove_blanks( $defaults );
		if ( 'all' !== $feed_format ) {
			$defaults = $this->remove_other_feeds( $defaults, $feed_format );
		}

		return $defaults;
	}

	/**
	 * Generate a list of choices for the "prepopulate" options.
	 *
	 * @string $key   Whether to fetch options for a specific key.
	 *
	 * @return array  An array of preopulate choices.
	 *
	 * @param null|string $key
	 */
	public function get_prepopulate_options( ?string $key = null ) {
		$options = [];
		if ( 'description' === $key ) {
			$options = $this->get_description_prepopulate_options();
		}
		$options = array_merge( $options, $this->get_prepopulate_fields() );
		$options = array_merge( $options, $this->get_available_taxonomies() );
		$options = array_merge( $options, $this->get_available_custom_attributes() );
		$options = array_merge( $options, $this->get_prepopulate_meta() );

		return apply_filters( 'woocommerce_gpf_prepopulate_options', $options, $key );
	}

	/**
	 * Helper function to remove blank array elements
	 *
	 * @access private
	 *
	 * @param array $array The array of elements to filter
	 *
	 * @return array The array with blank elements removed
	 */
	public function remove_blanks( $array, bool $remove_disabled = true ) {
		if ( empty( $array ) || ! is_array( $array ) ) {
			return $array;
		}
		foreach ( array_keys( $array ) as $key ) {
			if ( is_array( $array[ $key ] ) ) {
				$array[ $key ] = $this->remove_blanks( $array[ $key ], false );
				if ( empty( $array[ $key ] ) ) {
					unset( $array[ $key ] );
					continue;
				}
			}
			if ( '' === $array[ $key ] ||
				is_null( $array[ $key ] ) ||
				( empty( $this->settings['product_fields'][ $key ] ) && $remove_disabled )
			) {
				unset( $array[ $key ] );
				continue;
			}
		}

		return $array;
	}

	/**
	 * @param $field
	 *
	 * @return bool
	 *
	 * @psalm-param 'promotion_id' $field
	 */
	public function is_field_enabled( string $field ) {
		return ! empty( $this->settings['product_fields'][ $field ] );
	}

	/**
	 * Helper function to remove items not needed in this feed type
	 *
	 * @access private
	 *
	 * @param array $array The list of fields to be filtered
	 * @param string $feed_format The feed format that should have its fields maintained
	 *
	 * @return array The list of fields filtered to only contain elements that apply to the selected $feed_format
	 */
	public function remove_other_feeds( $array, $feed_format ) {
		if ( empty( $array ) || ! is_array( $array ) ) {
			return $array;
		}
		foreach ( array_keys( $array ) as $key ) {
			if ( empty( $this->product_fields[ $key ] )
				|| ! in_array( $feed_format, $this->product_fields[ $key ]['feed_types'], true )
			) {
				unset( $array[ $key ] );
			}
		}

		return $array;
	}

	/**
	 * Get the store defaults.
	 */
	public function get_store_default_values(): array {
		if ( ! isset( $this->settings['product_defaults'] ) ) {
			$this->settings['product_defaults'] = [];
		}

		return $this->remove_blanks( $this->settings['product_defaults'] );
	}

	/**
	 * Retrieve the category level defaults for a product.
	 *
	 * @param int $product_id The product ID.
	 *
	 * @return array
	 */
	public function get_category_values_for_product( $product_id ) {
		// Get the categories, ordered by "depth".
		$categories = get_the_terms( $product_id, 'product_cat' );
		if ( false === $categories ) {
			return [];
		}
		$categories = $this->term_depth_repository->order_terms_by_depth( $categories );

		$values = [];
		foreach ( $categories as $category ) {
			$category_id       = $category->term_id;
			$category_settings = $this->get_values_for_category( $category_id );
			$category_settings = $this->remove_blanks( $category_settings );
			$values            = array_merge( $values, $category_settings );
		}

		return $this->remove_blanks( $values );
	}

	/**
	 * Make sure that each element does not contain more values than it should.
	 *
	 * @param array $data The data for a product / category.
	 *
	 * @return  array          The modified data array.
	 */
	public function limit_max_values( $data ) {
		foreach ( $this->product_fields as $key => $element_settings ) {
			if ( empty( $element_settings['max_values'] ) ||
				empty( $data[ $key ] ) ||
				! is_array( $data[ $key ] ) ) {
				continue;
			}
			$limit        = intval( $element_settings['max_values'] );
			$data[ $key ] = array_slice( $data[ $key ], 0, $limit );
		}

		return $data;
	}

	/**
	 * Retrieve category defaults for a specific category
	 *
	 * @access public
	 *
	 * @param int $category_id The category ID to retrieve information for
	 *
	 * @return array            The category data
	 */
	private function get_values_for_category( $category_id ) {
		if ( ! $category_id ) {
			return [];
		}
		$values = get_term_meta( $category_id, '_woocommerce_gpf_data', true );
		if ( ! is_array( $values ) ) {
			return [];
		}

		return $values;
	}

	/**
	 * Get a list of the available fields to use for prepopulation.
	 *
	 * @return array  Array of the available fields.
	 * @throws Exception
	 */
	private function get_prepopulate_fields() {
		$fields = [
			'field:backorders'       => __( '"Allow backorders" setting', 'woocommerce_gpf' ),
			'field:product_title'    => __( 'Product title', 'woocommerce_gpf' ),
			'field:sku'              => __( 'SKU', 'woocommerce_gpf' ),
			'field:stock_qty'        => __( 'Stock Qty', 'woocommerce_gpf' ),
			'field:stock_status'     => __( 'Stock Status', 'woocommerce_gpf' ),
			'field:tax_class'        => __( 'Tax class', 'woocommerce_gpf' ),
			'field:weight'           => __( 'Weight (raw value, no units)', 'woocommerce_gpf' ),
			'field:weight_with_unit' => __( 'Weight (with units)', 'woocommerce_gpf' ),
			'field:variation_title'  => __( 'Variation title', 'woocommerce_gpf' ),
		];
		// @TODO - remove version check when minimum supported version is 9.2 or higher.
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '9.2.0', 'ge' ) ) {
			$fields['field:global_unique_id'] =
				__( '"GTIN, UPC, EAN or ISBN" field', 'woocommerce_gpf' );
		}
		asort( $fields );

		return array_merge(
			[
				'disabled:fields' => __( '- Product fields -', 'woo_gpf' ),
			],
			$fields
		);
	}

	/**
	 * Get a list of the available taxonomies.
	 *
	 * @return array Array of available product taxonomies.
	 */
	private function get_available_taxonomies() {
		$taxonomies = get_object_taxonomies( 'product' );
		$taxes      = [];
		$attributes = [];
		foreach ( $taxonomies as $taxonomy ) {
			$tax_details = get_taxonomy( $taxonomy );
			if ( taxonomy_is_product_attribute( $taxonomy ) ) {
				$attributes[ 'tax:' . $taxonomy ] = $tax_details->labels->name;
				continue;
			}
			if ( $tax_details->hierarchical ) {
				$taxes[ 'taxhierarchy:' . $taxonomy ] = sprintf(
				// Translators: %s is a taxonomy name
					__( '%s (full hierarchy)', 'woocommerce_gpf' ),
					$tax_details->labels->name
				);
			}
			$taxes[ 'tax:' . $taxonomy ] = $tax_details->labels->name;
		}
		asort( $taxes );
		asort( $attributes );

		return array_merge(
			[
				'disabled:attributes' => __( '- Global attributes -', 'woo_gpf' ),
			],
			$attributes,
			[
				'disabled:taxes' => __( '- Taxonomies -', 'woo_gpf' ),
			],
			$taxes
		);
	}

	/**
	 * Allow people to register custom attributes for use as pre-population options.
	 *
	 * @return array
	 */
	private function get_available_custom_attributes() {
		$attributes     = [];
		$attribute_keys = apply_filters( 'woocommerce_gpf_custom_attributes_for_prepopulation', [] );
		foreach ( $attribute_keys as $key ) {
			$attributes[ 'cattribute:' . $key ] = $key;
		}

		if ( ! empty( $attributes ) ) {
			$attributes = array_merge(
				[
					'disabled:cattributes' => __( '- Custom attributes -', 'woo_gpf' ),
				],
				$attributes
			);
		}

		return $attributes;
	}

	private function get_prepopulate_meta() {
		global $wpdb;
		// Try and get it from the transient if possible.
		$fields = get_transient( 'woocommerce_gpf_meta_prepopulate_options' );
		if ( false !== $fields ) {
			return $fields;
		}
		// If not, query for it and store it for later.
		$fields    = [];
		$meta_keys = $wpdb->get_col(
			$wpdb->prepare(
				'SELECT DISTINCT( %i.meta_key ) AS meta_key
				          FROM %i
					 LEFT JOIN %i
					        ON %i.ID = %i.post_id
						 WHERE %i.post_type IN ( "product", "product_variation" )
						 ORDER BY meta_key ASC',
				$wpdb->postmeta,
				$wpdb->posts,
				$wpdb->postmeta,
				$wpdb->posts,
				$wpdb->postmeta,
				$wpdb->posts,
			)
		);
		foreach ( $meta_keys as $meta_key ) {
			// Skip internal meta values that start with an _
			if ( stripos( $meta_key, '_' ) === 0 ) {
				continue;
			}
			$fields[ 'meta:' . $meta_key ] = $meta_key;
		}
		// Add a grouping header if we have some results.
		if ( ! empty( $fields ) ) {
			$fields = array_merge(
				[
					'disabled:meta' => __( '- Custom fields -', 'woo_gpf' ),
				],
				$fields
			);
		}
		$fields = apply_filters( 'woocommerce_gpf_custom_field_list', $fields );
		set_transient( 'woocommerce_gpf_meta_prepopulate_options', $fields, MONTH_IN_SECONDS );

		return $fields;
	}

	/**
	 * Get the prepopulate options specific to the description field.
	 *
	 * @return array
	 */
	public function get_description_prepopulate_options() {
		return [
			'disabled:descriptions' =>
				__( '- Descriptions -', 'woo_gpf' ),
			'description:fullvar'   =>
				__( 'Main product description (full preferred) plus variation description', 'woo_gpf' ),
			'description:shortvar'  =>
				__( 'Main product description (short preferred) plus variation description', 'woo_gpf' ),
			'description:full'      =>
				__( 'Main product description only (full preferred)', 'woo_gpf' ),
			'description:short'     =>
				__( 'Main product description only (short preferred)', 'woo_gpf' ),
			'description:varfull'   =>
				__( 'Variation description only, fallback to main description (full preferred)', 'woo_gpf' ),
			'description:varshort'  =>
				__( 'Variation description only, fallback to main description (short preferred)', 'woo_gpf' ),
		];
	}

	/**
	 * Only for tests.
	 *
	 * @param $settings
	 */
	public function set_settings( $settings ): void {
		$this->settings = $settings;
	}

	/**
	 * @return TermDepthRepository
	 */
	public function get_term_depth_repository() {
		return $this->term_depth_repository;
	}

	/**
	 * Get the list of taxonomy locales for the store's base location.
	 *
	 * @return array
	 */
	public function get_google_taxonomy_locales() {
		$country_locales = [
			// Argentina is en-US rather than es-ES per https://support.google.com/merchants/answer/6324436?hl=es-419
			'AR' => [], // Argentina
			'AU' => [ 'en-AU' ], // Australia
			'AT' => [ 'de-DE' ], // Austria
			'BH' => [], // Bahrain - no specific mapping clear
			'BY' => [ 'ru-RU' ], // Belarus
			'BE' => [ 'fr-FR', 'de-DE', 'nl-NL' ], // Belgium
			'BR' => [ 'pt-BR' ], // Brazil
			'CA' => [ 'fr-FR' ], // Canada
			// Chile is en-US rather than es-ES per https://support.google.com/merchants/answer/6324436?hl=es-419
			'CL' => [], // Chile
			'CN' => [ 'zh-CN' ], // China
			// Colombia is en-US rather than es-ES per https://support.google.com/merchants/answer/6324436?hl=es-419
			'CO' => [], // Colombia
			'CZ' => [ 'cs-CZ' ], // Czech Republic
			'DK' => [ 'da-DK' ], // Denmark
			// Ecuador is en-US rather than es-ES per https://support.google.com/merchants/answer/6324436?hl=es-419
			'EC' => [], // Ecuador
			'EG' => [ 'ar-SA' ], // Egypt
			'FI' => [ 'fi-FI', 'sv-SE' ], // Finland
			'FR' => [ 'fr-FR' ], // France
			'GE' => [], // Georgian not currently supported language
			'DE' => [ 'de-DE' ], // Germany
			'GR' => [], // Greek not currently supported
			'HK' => [ 'zh-CN' ], // Hong-Kong
			'HU' => [], // Hungarian not currently supported
			'IN' => [], // India
			'ID' => [], // Indonesia
			'IE' => [ 'en-GB' ], // Ireland
			'IL' => [], // Israel
			'IT' => [ 'it-IT' ], // Italy
			'JP' => [ 'ja-JP' ], // Japan
			'JO' => [ 'ar-SA' ], // Jordan
			'KZ' => [ 'ru-RU' ], // Kazakhstan
			'KW' => [ 'ar-SA' ], // Kuwait
			'LB' => [ 'ar-SA' ], // Lebanon
			'MY' => [], // Malaysia
			'MX' => [], // Mexico
			'NL' => [ 'nl-NL' ], // Netherlands
			'NZ' => [], // New Zealand
			'NO' => [ 'no-NO' ], // Norway
			'OM' => [ 'ar-SA' ], // Oman
			'PY' => [], // Paraguay
			'PE' => [], // Peru
			'PH' => [], // Philippines
			'PL' => [ 'pl-PL' ], // Poland
			'PT' => [ 'pt-BR' ], // Portugal
			'RO' => [ '' ], // Romania
			'RU' => [ 'ru-RU' ], // Russia
			'SG' => [], // Singapore
			'SK' => [], // Slovakia
			'ZA' => [], // South Africa
			'ES' => [ 'es-ES' ], // Spain
			'SE' => [ 'sv-SE' ], // Sweden
			'CH' => [ 'de-DE', 'fr-FR', 'it-IT' ], // Switzerland
			'TW' => [], // Taiwan
			'TR' => [ 'tr-TR' ], // Turkey
			'AE' => [ 'ar-SA' ], // United Arab Emirates
			'GB' => [ 'en-GB' ], // United Kingdom
			'US' => [], // United States of America
			'UY' => [], // Uruguay
			'UZ' => [], // Uzbekistan
			'VN' => [ 'vi-VN' ], // Vietnam
		];

		$base_country = WC()->countries->get_base_country();
		$locales      = $country_locales[ $base_country ] ?? [];
		if ( ! in_array( 'en-US', $locales, true ) && ! in_array( 'en-GB', $locales, true ) ) {
			$locales[] = 'en-US';
		}

		return apply_filters( 'woocommerce_gpf_google_taxonomy_locales', $locales );
	}

	public function get_ui_group_name( string $group ): string {
		switch ( $group ) {
			case 'common':
				return _x( 'Common fields', 'Grouping header for settings', 'woocommerce_gpf' );
				break;
			case 'advanced':
				return _x( 'Advanced fields', 'Grouping header for settings', 'woocommerce_gpf' );
				break;
			default:
				return ucfirst( $group );
				break;
		}
	}
}
