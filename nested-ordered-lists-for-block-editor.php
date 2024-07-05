<?php
/**
 * Plugin Name:       Nested Ordered Lists for Block Editor
 * Description:       Adds support for nested ordered lists in List Block.
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Version:           @@VersionNumber@@
 * Author:            Thomas Zwirner
 * Author URI:        https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       nested-ordered-lists-for-block-editor
 *
 * @package nested-ordered-lists-for-block-editor
 */

/**
 * Enqueue frontend style.
 *
 * @return void
 */
function nolg_frontend_style(): void {
	wp_enqueue_style(
		'nolg-list-css',
		plugins_url( 'css/style.css', __FILE__ ),
		array(),
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
function nolg_assets(): void {
	if ( is_admin() ) {
		// add backend-js.
		wp_enqueue_script(
			'nolg-backend',
			plugins_url( 'attributes/listOption.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-block-editor' ),
			filemtime( plugin_dir_path( __FILE__ ) . 'attributes/listOption.js' ),
			true
		);

		// add backend-css.
		wp_enqueue_style(
			'nolg-admin',
			plugins_url( 'admin/style.css', __FILE__ ),
			array(),
			filemtime( plugin_dir_path( __FILE__ ) . 'admin/style.css' )
		);
	}

	// add frontend-css.
	nolg_frontend_style();

	// add translations for the backend-script.
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations(
			'nolg-backend',
			'nested-ordered-lists-for-block-editor'
		);
	}
}
add_action( 'enqueue_block_assets', 'nolg_assets' );
