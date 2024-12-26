<?php
/**
 * Plugin Name:       Nested Ordered Lists for Block Editor
 * Description:       Adds support for nested ordered lists in List Block.
 * Requires at least: 6.6
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

// set version.
const NOLG_VERSION = '@@VersionNumber@@';

/**
 * Enqueue frontend style.
 *
 * @return void
 */
function nolg_frontend_style(): void {
	// get the file name for the style file.
	$css_file = 'css/style.css';

	// if debug-mode is not enabled, use minified file.
	if ( ! defined( 'WP_DEBUG' ) || ( defined( 'WP_DEBUG' ) && ! WP_DEBUG ) ) {
		$css_file = str_replace( '.css', '.min.css', $css_file );
	}

	// enqueue the file.
	wp_enqueue_style(
		'nolg-list',
		plugins_url( $css_file, __FILE__ ),
		array(),
		nolg_get_file_version( plugin_dir_path( __FILE__ ) . $css_file )
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
			nolg_get_file_version( plugin_dir_path( __FILE__ ) . 'attributes/listOption.js' ),
			true
		);

		// add backend-css.
		wp_enqueue_style(
			'nolg-admin',
			plugins_url( 'admin/style.css', __FILE__ ),
			array(),
			nolg_get_file_version( plugin_dir_path( __FILE__ ) . 'admin/style.css' )
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

/**
 * Return the version of the given file.
 *
 * With WP_DEBUG or plugin-debug enabled its @filemtime().
 * Without this it's the plugin-version.
 *
 * @param string $filepath The absolute path to the requested file.
 *
 * @return string
 */
function nolg_get_file_version( string $filepath ): string {
	// check for WP_DEBUG.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		return filemtime( $filepath );
	}

	$plugin_version = NOLG_VERSION;

	/**
	 * Filter the used file version (for JS- and CSS-files which get enqueued).
	 *
	 * @since 2.0.0 Available since 2.0.0.
	 *
	 * @param string $plugin_version The plugin-version.
	 * @param string $filepath The absolute path to the requested file.
	 */
	return apply_filters( 'nolg_file_version', $plugin_version, $filepath );
}
