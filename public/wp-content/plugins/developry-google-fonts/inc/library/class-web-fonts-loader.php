<?php
/**
 * [Short description]
 *
 * @package    DEVRY\WFL
 * @copyright  Copyright (c) 2025, Developry Ltd.
 * @license    https://www.gnu.org/licenses/gpl-3.0.html GNU Public License
 * @since      1.3
 */

namespace DEVRY\WFL;

! defined( ABSPATH ) || exit; // Exit if accessed directly.

if ( ! class_exists( 'Web_Fonts_Loader' ) ) {

	class Web_Fonts_Loader {
		/**
		 * Used to keep track the HTML output inside array_walk() function.
		 */
		public $fonts_output;

		public $body_font_family;
		public $body_font_weight;
		public $heading_1_font_family;
		public $heading_1_font_weight;
		public $heading_2_font_family;
		public $heading_2_font_weight;
		public $heading_3_font_family;
		public $heading_3_font_weight;
		public $heading_4_font_family;
		public $heading_4_font_weight;
		public $heading_5_font_family;
		public $heading_5_font_weight;
		public $heading_6_font_family;
		public $heading_6_font_weight;

		/**
		 * Add compact mode for options.
		 */
		public $compact_mode;

		public $global_fonts;

		/**
		 * Consturtor.
		 */
		public function __construct() {
			$this->fonts_output = '';

			// Use some defaults for the Options, for initial plugin usage.
			$this->body_font_family      = ''; // Empty
			$this->body_font_weight      = ''; // Empty
			$this->heading_1_font_family = ''; // Empty
			$this->heading_1_font_weight = ''; // Empty
			$this->heading_2_font_family = ''; // Empty
			$this->heading_2_font_weight = ''; // Empty
			$this->heading_3_font_family = ''; // Empty
			$this->heading_3_font_weight = ''; // Empty
			$this->heading_4_font_family = ''; // Empty
			$this->heading_4_font_weight = ''; // Empty
			$this->heading_5_font_family = ''; // Empty
			$this->heading_5_font_weight = ''; // Empty
			$this->heading_6_font_family = ''; // Empty
			$this->heading_6_font_weight = ''; // Empty

			$this->compact_mode = ''; // No

			// Retrieve from options, if available; otherwise, use the default values.
			$this->body_font_family      = get_option( 'wfl_body_font_family', $this->body_font_family );
			$this->body_font_weight      = get_option( 'wfl_body_font_weight', $this->body_font_weight );
			$this->heading_1_font_family = get_option( 'wfl_heading_1_font_family', $this->heading_1_font_family );
			$this->heading_1_font_weight = get_option( 'wfl_heading_1_font_weight', $this->heading_1_font_weight );
			$this->heading_2_font_family = get_option( 'wfl_heading_2_font_family', $this->heading_2_font_family );
			$this->heading_2_font_weight = get_option( 'wfl_heading_2_font_weight', $this->heading_2_font_weight );
			$this->heading_3_font_family = get_option( 'wfl_heading_3_font_family', $this->heading_3_font_family );
			$this->heading_3_font_weight = get_option( 'wfl_heading_3_font_weight', $this->heading_3_font_weight );
			$this->heading_4_font_family = get_option( 'wfl_heading_4_font_family', $this->heading_4_font_family );
			$this->heading_4_font_weight = get_option( 'wfl_heading_4_font_weight', $this->heading_4_font_weight );
			$this->heading_5_font_family = get_option( 'wfl_heading_5_font_family', $this->heading_5_font_family );
			$this->heading_5_font_weight = get_option( 'wfl_heading_5_font_weight', $this->heading_5_font_weight );
			$this->heading_6_font_family = get_option( 'wfl_heading_6_font_family', $this->heading_6_font_family );
			$this->heading_6_font_weight = get_option( 'wfl_heading_6_font_weight', $this->heading_6_font_weight );

			$this->compact_mode = get_option( 'wfl_compact_mode', $this->compact_mode );
		}

		/**
		 * Initializor.
		 */
		public function init() {
			add_action( 'wp_loaded', array( $this, 'on_loaded' ) );
		}

		/**
		 * Plugin loaded.
		 */
		public function on_loaded() {}

		/**
		 * [GLOBAL] Load the select options for the admin Global Fonts page.
		 */
		public function load_admin_global_font_options( $type, $selected_option ) {
			$this->global_fonts = '';

			$fonts = array();

			$default_google_fonts = array( 'dgf' => '&mdash; GOOGLE FONTS &mdash;' );
			$default_system_fonts = array( 'dsf' => '&mdash; SYSTEM FONTS &mdash;' );

			if ( 'font-family' === $type ) {
				$default_google_fonts = array_merge( $default_google_fonts, (array) json_decode( WFL_GOOGLE_FONT_FAMILY, true ) );
				$default_system_fonts = array_merge( $default_system_fonts, (array) json_decode( WFL_SYSTEM_FONT_FAMILY, true ) );

				$fonts = array_merge( $default_google_fonts, $default_system_fonts );
			} elseif ( 'font-weight' === $type ) {
				$fonts = (array) json_decode( WFL_GOOGLE_FONT_WEIGHTS, true );
			}

			array_walk(
				$fonts,
				function ( &$value, $key, $selected_option ) {
					$value = trim( $value );

					if ( $selected_option === $value ) {
						$this->global_fonts .= '<option value="' . esc_attr( $value ) . '" selected>' . esc_html( $value ) . '</option>';
					} else {
						$this->global_fonts .= '<option value="' . esc_attr( $value ) . '">' . esc_html( $value ) . '</option>';
					}
				},
				$selected_option
			);

			return $this->global_fonts;
		}

		/**
		 * Load selected web fonts on the frontend (both default, user-defined and custom).
		 */
		public function load_frontend_fonts( $section ) {
			if ( ! $section ) {
				return;
			}

			$font_css = '';

			$global_fonts = $this->get_global_fonts( $section ) ?? array();
			$post_fonts   = $this->get_post_fonts( $section ) ?? array();

			$fonts            = array_merge_recursive( $global_fonts, $post_fonts );
			$structured_fonts = $this->get_font_weight_by_family( $fonts );

			// Load fonts on the frontend using webfont.js
			$output = 'var WFL = WFL || {}; WFL.webFonts = [';

			foreach ( $structured_fonts as $font_family => $font_weights ) {
				if ( $font_family ) {
					$font_weight = ( ! empty( $font_weights ) ) ? ':' . implode( ',', $font_weights ) : '';

					$output .= "'{$font_family}{$font_weight}',";
				}
			}

			$output .= '];';

			wp_add_inline_script( $section, $output, 'before' );
		}

		/**
		 * Get used default and custom fonts from the Global Fonts page.
		 * Apply the styles to target list elements, tags and classes.
		 */
		public function get_global_fonts( $section ) {
			global $wpdb;

			if ( ! $section ) {
				return;
			}

			$font_css = '';

			$global_fonts           = array();
			$default_global_fonts   = (array) json_decode( WFL_GLOBAL_FONTS, true );
			$default_global_weights = (array) json_decode( WFL_GOOGLE_FONT_WEIGHTS, true );

			// Get default global font options and apply then on the frontend.
			for ( $i = 0; $i <= 6; $i++ ) {
				if ( 0 === $i ) {
					$font_family = get_option( 'wfl_body_font_family', '' );
					$font_weight = get_option( 'wfl_body_font_weight', '' );
				} else {
					$font_family = get_option( "wfl_heading_{$i}_font_family", '' );
					$font_weight = get_option( "wfl_heading_{$i}_font_weight", '' );
				}

				if ( $font_family || $font_weight ) {
					$font_id = strtolower( preg_replace( '/\s+/', '-', preg_replace( '/[^A-Za-z0-9\s]/', '', trim( $font_family ) ) ) );
					// Get target tags and classes from defined hard-coded variable.
					if ( 0 === $i ) {
						$font_target_list = $default_global_fonts['wfl_body_font_family'];
					} else {
						$font_target_list = $default_global_fonts[ "wfl_heading_{$i}_font_family" ];
					}

					// Add some default value for font-weight if left empty
					if ( '' === $font_weight ) {
						$font_weight = 400;
					}

					// Get the 100, 200, 300 from Thin, Extra Thun, Light etc. stored in DB.
					if ( 400 !== $font_weight ) {
						$font_weight = array_search( $font_weight, $default_global_weights, true );
					}

					// Get both font-family and font-weight into an array.
					$global_fonts[] = array(
						'font-family' => $font_family,
						'font-weight' => $font_weight,
					);

					$font_css .= "$font_target_list { font-family: '{$font_family}', system-ui !important; font-weight: {$font_weight} !important; }";
				}
			}

			wp_add_inline_style( $section, $font_css );

			return $global_fonts;
		}

		/**
		 * Get strucutred array with font family and weight variantsfr.
		 */
		public function get_font_weight_by_family( $fonts ) {
			$structured_fonts = array();

			foreach ( $fonts as $font ) {
				$font_family = $font['font-family'];
				$font_weight = $font['font-weight'];

				// Skip empty font-weight values
				if ( ! empty( $font_weight ) ) {
					$structured_fonts[ $font_family ][] = $font_weight;
				}

				// Initialize array for families even if they have no weights yet
				if ( empty( $structured_fonts[ $font_family ] ) ) {
					$structured_fonts[ $font_family ] = array();
				}
			}

			// Optional: Remove duplicate weights and sort the weights
			foreach ( $structured_fonts as $font_family => $font_weights ) {
				$structured_fonts[ $font_family ] = array_unique( $font_weights );
				sort( $structured_fonts[ $font_family ] );
			}

			return $structured_fonts;
		}

		/**
		 * Get used fonts in the post content from either Classic or Block editor styled content.
		 * Apply the styles to target list elements, classes.
		 */
		public function get_post_fonts( $section ) {
			global $post;

			if ( ! $section ) {
				return;
			}

			$font_css   = '';
			$post_fonts = array();

			$post_classic_fonts = array();
			$post_block_fonts   = array();

			if ( null !== $post && property_exists( $post, 'post_content' ) ) {
				$post_classic_fonts = $this->get_editor_fonts( $post->post_content, 'classic' );

				if ( ! empty( $post_classic_fonts ) ) {
					// Generate and add inline font CSS to style the used fonts from the Classic editor.
					foreach ( $post_classic_fonts as $font ) {
						$font_family = $font['font-family'];
						$font_weight = ( $font['font-weight'] ) ? $font['font-weight'] : '';

						// Get font id e.g. Roboto => roboto, Open Sans => open-sans.
						$font_id = strtolower( preg_replace( '/\s+/', '-', preg_replace( '/[^A-Za-z0-9\s]/', '', trim( $font_family ) ) ) );

						if ( '' !== $font_weight ) {
							$font_css .= ".mce-user-font-family-{$font_id}.mce-google-font-weight-{$font_weight} { font-family: '{$font_family}', system-ui !important; font-weight: {$font_weight} !important; }";
						} else {
							$font_css .= ".mce-user-font-family-{$font_id} { font-family: '{$font_family}', system-ui !important; }";
						}
					}
				}

				// Combine all font family arrays and remove repeating values.
				$post_fonts = array_merge( $post_fonts, $post_classic_fonts );

				wp_add_inline_style( $section, $font_css );
			}

			return $post_fonts;
		}

		/**
		 * Use RegEx to extract post style fonts from post content (Classic or Block editor) into a structured array.
		 */
		public function get_editor_fonts( $post_content ) {
			$structured_fonts = array();

			// Regex for Classic editor content font family and font weight.
			$font_pattern = '/(?:mce-user-font-family-([a-zA-Z-]+))?(?:\s*)?(?:mce-google-font-weight-([0-9]+))?/';

			// Match font families and weights.
			preg_match_all( $font_pattern, $post_content, $matches, PREG_SET_ORDER );

			foreach ( $matches as $match ) {
				if ( '' !== trim( $match[0] ) && ', ' !== trim( $match[0] ) && ',' !== trim( $match[0] ) ) {
					// Use captured value or default to an empty string if not present.
					$font_family = ! empty( $match[1] ) ? ucwords( str_replace( '-', ' ', $match[1] ) ) : '';
					$font_weight = ! empty( $match[2] ) ? $match[2] : '';

					$structured_fonts[] = array(
						'font-family' => $font_family,
						'font-weight' => $font_weight,
					);
				}
			}

			if ( empty( $structured_fonts ) ) {
				return array();
			}

			return $structured_fonts;
		}

		/**
		 * Load default Goolge and system fonts on the Golab Fonts settings page.
		 */
		public function load_global_fonts( $section ) {
			$font_css    = '';
			$font_import = '';

			$default_google_fonts = (array) json_decode( WFL_GOOGLE_FONT_FAMILY, true );
			$default_system_fonts = (array) json_decode( WFL_SYSTEM_FONT_FAMILY, true );

			// Handle default Google fonts.
			if ( ! empty( $default_google_fonts ) ) {
				$font_variants = $this->get_font_variants();

				foreach ( $default_google_fonts as $font_id => $font_family ) {
					$font_import .= "@import url('https://fonts.googleapis.com/css2?family=" . urlencode( $font_family ) . "{$font_variants[0]}&display=swap');";
					$font_css    .= "option[value='" . esc_attr( $font_family ) . "'] { font-family: '" . esc_attr( $font_family ) . "', system-ui !important; }";
				}
			}

			if ( ! empty( $default_system_fonts ) ) {
				foreach ( $default_system_fonts as $font_id => $font_family ) {
					$font_css .= ".mce-user-font-family-{$font_id}, option[value='" . esc_attr( $font_family ) . "'] { font-family: '" . esc_attr( $font_family ) . "', system-ui !important; }";
				}
			}

			wp_register_style( $section, false, array(), WFL_PLUGIN_VERSION );
			wp_enqueue_style( $section );
			wp_add_inline_style( $section, $font_import . $font_css );
		}

		/**
		 * Add google fonts to the TinyMCE / Classic editor both default, user-defined, and custom.
		 */
		public function load_tinymce_fonts( $init ) {
			$font_inline_css = $this->get_tinymce_fonts();

			wp_register_style( 'wfl-load-tinymce-fonts', false, array(), WFL_PLUGIN_VERSION );
			wp_enqueue_style( 'wfl-load-tinymce-fonts' );
			wp_add_inline_style( 'wfl-load-tinymce-fonts', $font_inline_css );

			if ( ! empty( $font_inline_css ) ) {
				$init['content_style'] = isset( $init['content_style'] ) ? $init['content_style'] . " {$font_inline_css}" : $font_inline_css;
			}

			return $init;
		}

		/**
		 * Get default and user-defined Google and System fonts and add inline CSS to style to the Classic Editor.
		 */
		public function get_tinymce_fonts() {
			$font_variants = array();
			$font_import   = '';
			$font_css      = '';

			$default_google_fonts = (array) json_decode( WFL_GOOGLE_FONT_FAMILY, true );
			$default_system_fonts = (array) json_decode( WFL_SYSTEM_FONT_FAMILY, true );

			// Handle default Google fonts.
			if ( ! empty( $default_google_fonts ) ) {
				$font_variants = $this->get_font_variants();

				foreach ( $default_google_fonts as $font_id => $font_family ) {
					$font_import .= "@import url('https://fonts.googleapis.com/css2?family=" . urlencode( $font_family ) . "{$font_variants[0]}&display=swap');";
					$font_css    .= ".mce-user-font-family-{$font_id}, option[value='" . esc_attr( $font_family ) . "'] { font-family: '" . esc_attr( $font_family ) . "', system-ui !important; }";
				}
			}

			// Handle default System fonts.
			foreach ( $default_system_fonts as $font_id => $font_family ) {
				$font_css .= ".mce-user-font-family-{$font_id}, option[value='" . esc_attr( $font_family ) . "'] { font-family: '" . esc_attr( $font_family ) . "', system-ui !important; }";
			}

			$font_variants_css = ( ! empty( $font_variants[1] ) ) ? $font_variants[1] : '';

			return ( $font_import . $font_css . $font_variants_css );
		}

		/**
		 * Generate font variants based on the user Options and defaults.
		 */
		public function get_font_variants() {
			$font_weight = (array) json_decode( WFL_GOOGLE_FONT_WEIGHTS, true );

			if ( empty( $font_weight ) ) {
				return array( '', '' );
			}

			$font_css      = '';
			$font_variants = '';

			foreach ( $font_weight as $variant_id => $variant_name ) {
				$font_variants .= "0,{$variant_id};";
				$font_css      .= ".mce-google-font-weight-{$variant_id}, option[value='" . esc_attr( $variant_name ) . "'] { font-weight: {$variant_id} !important; }";
			}

			$font_variants = rtrim( $font_variants, ';' );

			if ( ! empty( $font_variants ) ) {
				$font_variants = ':ital,wght@' . $font_variants;
			}

			return array( $font_variants, $font_css );
		}

	}

	$wfl = new Web_Fonts_Loader();
	$wfl->init();
}
