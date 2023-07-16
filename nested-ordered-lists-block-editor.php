<?php

/**
 * Plugin Name:       Nested Ordered Lists for Block Editor
 * Description:       Adds support for nested ordered lists in List Block.
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Version:           @@VersionNumber@@
 * Author:            Thomas Zwirner
 * Author URI:		  https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       nested-ordered-lists-block-editor
 */

/**
 * Initialize the plugin.
 *
 * @return void
 * @noinspection PhpUnused
 */
function nolg_init() {
	load_plugin_textdomain( 'nested-ordered-lists-block-editor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'nolg_init' );

/**
 * Enqueue frontend style.
 *
 * @return void
 */
function nolg_frontend_style() {
	wp_enqueue_style(
		'nolg-list-css',
		plugins_url( 'css/style.css', __FILE__ ),
		[],
		filemtime( plugin_dir_path( __FILE__ ) . 'css/style.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'nolg_frontend_style' );

/**
 * Adds JavaScript-file for Block editor to add the options.
 *
 * @return void
 * @noinspection PhpUnused
 */
function nolg_assets() {
	// add backend-js
	wp_enqueue_script(
		'nolg-backend-js',
		plugins_url( 'attributes/index.js', __FILE__ ),
		[ 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-block-editor' ],
		filemtime( plugin_dir_path( __FILE__ ) . 'attributes/index.js' )
	);

	// add backend-css
	wp_enqueue_style( 'nolg-admin-css', plugins_url( 'admin/style.css', __FILE__ ) );

	// add frontend-css
	nolg_frontend_style();

	// add translations for the backend-script
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations(
			'nolg-backend-js',
			'nested-ordered-lists-block-editor',
			plugin_dir_path( __FILE__ ) . '/languages/'
		);
	}
}
add_action( 'enqueue_block_assets', 'nolg_assets' );
