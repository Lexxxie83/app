<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package navigatie
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 *
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function indrukwekkend_block_navigatie_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_enqueue_style(
		'indrukwekkend_blocks-navigatie-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `navigatieGlobal` object.
	wp_localize_script(
		'indrukwekkend_blocks-navigatie-block-js',
		'navigatieGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `navigatieGlobal` object.
		]
	);
}
add_action( 'init', 'indrukwekkend_block_navigatie_assets' );


function indrukwekkend_block_navigatie_editor_assets() {

	// Register block editor script for backend.
	wp_enqueue_script(
		'indrukwekkend_blocks-navigatie-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-data', 'wp-components', 'wp-core-data', 'wp-polyfill' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_enqueue_style(
		'indrukwekkend_blocks-navigatie-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'indrukwekkend_block_navigatie_editor_assets' );



include 'inc'.'/walker.php';
include 'navigatie'.'/index.php';
include 'socialmedia'.'/index.php';


