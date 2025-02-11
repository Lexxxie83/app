<?php
/**
 * Plugin Name: Blok - Navigatie - Indrukwekkend
 * Plugin URI: https://github.com/indrukwekkend/
 * Description: php navigatie om de oude WP navigatie als block te kunnen plaatsen in de nieuwe block editor
 * Author: Hans-Peter Hioolen
 * Author URI: https://indrukwekkend.nl
 * Version: 0.0.5
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';
