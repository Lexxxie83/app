<?php

namespace Ademti\WoocommerceProductFeeds\Helpers;

/**
 * Renders templates with a given set of variables, and returns the content.
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class TemplateLoader extends GamajoTemplateLoader {

	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $filter_prefix = 'woocommerce-gpf';

	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $theme_template_directory = 'woocommerce-product-feeds';

	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * Can either be a defined constant, or a relative reference from where the subclass lives.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $plugin_directory = ''; // Set in constructor

	/**
	 * Constructor. Stores needed config.
	 */
	public function __construct() {
		$this->plugin_directory = dirname( __DIR__, 2 );
	}

	/**
	 * Get the contents of a template with variables substituted.
	 *
	 * @param string $slug The template slug (First part of filename)
	 * @param string $name The template name (Second half of filename)
	 * @param array $variables Variables to be replaced into the template.
	 *
	 * @return string             The rendered output.
	 */
	public function get_template_with_variables( $slug, $name = null, $variables = [] ) {
		ob_start();
		$path = $this->get_template_part( $slug, $name, false );
		load_template( $path, false, $variables );
		$content = ob_get_clean();
		foreach ( $variables as $key => $value ) {
			if ( ! is_array( $value ) ) {
				$content = str_replace( '{' . $key . '}', $value, $content );
			}
		}

		return $content;
	}

	/**
	 * Output the contents of a template with variables substituted.
	 *
	 * @param string $slug The template slug (First part of filename)
	 * @param string $name The template name (Second half of filename)
	 * @param array $variables Variables to be replaced into the template.
	 *
	 * @return void
	 * @uses   get_template_with_variables()
	 *
	 */
	public function output_template_with_variables( $slug, $name = null, $variables = [] ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $this->get_template_with_variables( $slug, $name, $variables );
	}
}
