<?php
/**
 * Plugin Name: Web Fonts Loader
 * Plugin URI: https://krasenslavov.com/
 * Description: Elevate your WordPress site with access to the complete range of Google Fonts for enhanced typography and design.
 * Version: 1.5.0
 * Author: Krasen Slavov
 * Author URI: https://developry.com/
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: developry-google-fonts
 * Domain Path: /lang
 *
 * Copyright (c) 2018 - 2025 Developry Ltd. (email: contact@developry.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301 USA
 */

namespace DEVRY\WFL;

! defined( ABSPATH ) || exit; // Exit if accessed directly.

define( __NAMESPACE__ . '\WFL_ENV', 'prod' ); // Use prod, dev options.

define( __NAMESPACE__ . '\WFL_MIN_PHP_VERSION', '7.2' );
define( __NAMESPACE__ . '\WFL_MIN_WP_VERSION', '5.0' );

define( __NAMESPACE__ . '\WFL_PLUGIN_UUID', 'wfl' );
define( __NAMESPACE__ . '\WFL_PLUGIN_TEXTDOMAIN', 'developry-google-fonts' );
define( __NAMESPACE__ . '\WFL_PLUGIN_NAME', esc_html__( 'Web Fonts Loader', 'developry-google-fonts' ) );
define( __NAMESPACE__ . '\WFL_PLUGIN_VERSION', '1.5.0' );
define( __NAMESPACE__ . '\WFL_PLUGIN_DOMAIN', 'webfontsplugin.com' );
define( __NAMESPACE__ . '\WFL_PLUGIN_DOCS', 'https://webfontsplugin.com/help' );

define( __NAMESPACE__ . '\WFL_PLUGIN_WPORG_SUPPORT', 'https://wordpress.org/support/plugin/developry-google-fonts/#new-topic' );
define( __NAMESPACE__ . '\WFL_PLUGIN_WPORG_RATE', 'https://wordpress.org/support/plugin/developry-google-fonts/reviews/#new-post' );

define( __NAMESPACE__ . '\WFL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( __NAMESPACE__ . '\WFL_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( __NAMESPACE__ . '\WFL_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

define(
	__NAMESPACE__ . '\WFL_PLUGIN_ALLOWED_HTML_ARR',
	wp_json_encode(
		array(
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'name'   => array(),
			),
			'option' => array(
				'value'    => array(),
				'selected' => array(),
			),
		)
	)
);

define(
	__NAMESPACE__ . '\WFL_OPTIONS',
	wp_json_encode(
		array(
			'wfl_body_font_family',
			'wfl_body_font_weight',
			'wfl_heading_1_font_family',
			'wfl_heading_1_font_weight',
			'wfl_heading_2_font_family',
			'wfl_heading_2_font_weight',
			'wfl_heading_3_font_family',
			'wfl_heading_3_font_weight',
			'wfl_heading_4_font_family',
			'wfl_heading_4_font_weight',
			'wfl_heading_5_font_family',
			'wfl_heading_5_font_weight',
			'wfl_heading_6_font_family',
			'wfl_heading_6_font_weight',
		)
	)
);

define(
	__NAMESPACE__ . '\WFL_GLOBAL_FONTS',
	wp_json_encode(
		array(
			'wfl_body_font_family'      => 'body *',
			'wfl_heading_1_font_family' => 'h1, h1 *, .h1, .display-1',
			'wfl_heading_2_font_family' => 'h2, h2 *, .h2, .display-2',
			'wfl_heading_3_font_family' => 'h3, h3 *, .h3, .display-3',
			'wfl_heading_4_font_family' => 'h4, h4 *, .h4, .display-4',
			'wfl_heading_5_font_family' => 'h5, h5 *, .h5, .display-5',
			'wfl_heading_6_font_family' => 'h6, h6 *, .h6, .display-6',
		)
	)
);

define(
	__NAMESPACE__ . '\WFL_SYSTEM_FONT_FAMILY',
	wp_json_encode(
		array(
			'-apple-system' => '-apple-system',
			'system-ui'     => 'system-ui',
			'georgia'       => 'Georgia',
			'helvetica'     => 'Helvetica',
			'segoe-ui'      => 'Segoe UI',
			'serif'         => 'serif',
			'sans-serif'    => 'sans-serif',
		)
	)
);

define(
	__NAMESPACE__ . '\WFL_GOOGLE_FONT_FAMILY',
	wp_json_encode(
		array(
			'roboto'                    => 'Roboto',
			'roboto-condensed'          => 'Roboto Condensed',
			'roboto-slab'               => 'Roboto Slab',
			'roboto-mono'               => 'Roboto Mono',
			'open-sans'                 => 'Open Sans',
			'lato'                      => 'Lato',
			'montserrat'                => 'Montserrat',
			'montserrat-alternates'     => 'Montserrat Alternates',
			'montserrat-subrayada'      => 'Montserrat Subrayada',
			'oswald'                    => 'Oswald',
			'source-sans-pro'           => 'Source Sans Pro',
			'source-serif-pro'          => 'Source Serif Pro',
			'source-code-pro'           => 'Source Code Pro',
			'slabo-27px'                => 'Slabo 27px',
			'slabo-13px'                => 'Slabo 13px',
			'raleway'                   => 'Raleway',
			'raleway-dots'              => 'Raleway Dots',
			'pt-sans'                   => 'PT Sans',
			'pt-sans-caption'           => 'PT Sans Caption',
			'pt-sans-narrow'            => 'PT Sans Narrow',
			'pt-serif'                  => 'PT Serif',
			'pt-serif-caption'          => 'PT Serif Caption',
			'merriweather'              => 'Merriweather',
			'merriweather-sans'         => 'Merriweather Sans',
			'ubuntu'                    => 'Ubuntu',
			'ubuntu-condensed'          => 'Ubuntu Condensed',
			'ubuntu-mono'               => 'Ubuntu Mono',
			'noto-sans'                 => 'Noto Sans',
			'noto-serif'                => 'Noto Serif',
			'poppins'                   => 'Poppins',
			'playfair-display'          => 'Playfair Display',
			'playfair-display-sc'       => 'Playfair Display SC',
			'lora'                      => 'Lora',
			'titillium-web'             => 'Titillium Web',
			'arimo'                     => 'Arimo',
			'multi'                     => 'Muli',
			'fira-sans'                 => 'Fira Sans',
			'fira-sans-condensed'       => 'Fira Sans Condensed',
			'fira-sans-extra-condensed' => 'Fira Sans Extra Condensed',
			'fira-mono'                 => 'Fira Mono',
		)
	)
);

define(
	__NAMESPACE__ . '\WFL_GOOGLE_FONT_WEIGHTS',
	wp_json_encode(
		array(
			'100' => 'Thin',
			'200' => 'Extra Light',
			'300' => 'Light',
			'400' => 'Regular',
			'500' => 'Medium',
			'600' => 'Semi Bold',
			'700' => 'Bold',
			'800' => 'Extra Bold',
			'900' => 'Black',
		)
	)
);

// URL for dev/prod for image folder.
if ( 'dev' === WFL_ENV ) {
	define( __NAMESPACE__ . '\WFL_PLUGIN_IMG_URL', WFL_PLUGIN_DIR_URL . 'assets/dev/images/' );
} else {
	define( __NAMESPACE__ . '\WFL_PLUGIN_IMG_URL', WFL_PLUGIN_DIR_URL . 'assets/dist/img/' );
}

require_once WFL_PLUGIN_DIR_PATH . 'inc/admin/admin.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/library/class-wfl-admin.php';
require_once WFL_PLUGIN_DIR_PATH . 'inc/library/class-web-fonts-loader.php';
