<?php
/**
 * Plugin Name:       Nested Ordered Lists for Block Editor
 * Description:       Adds support for nested ordered lists with icons in List Block.
 * Requires at least: 6.6
 * Requires PHP:      8.1
 * Version:           @@VersionNumber@@
 * Author:            Thomas Zwirner
 * Author URI:        https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       nested-ordered-lists-for-block-editor
 *
 * @package nested-ordered-lists-for-block-editor
 */

use nestedOrderedLists\Helper;
use nestedOrderedLists\Iconset_Base;
use nestedOrderedLists\Iconsets;
use nestedOrderedLists\Iconsets\Bootstrap;
use nestedOrderedLists\Iconsets\Dashicons;
use nestedOrderedLists\Iconsets\Fontawesome;
use nestedOrderedLists\Installer;
use nestedOrderedLists\Languages;
use nestedOrderedLists\Transients;
use nestedOrderedLists\Update;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

// do nothing if PHP-version is not 8.1 or newer.
if ( version_compare( PHP_VERSION, '8.1', '<' ) ) {
	return;
}

// save the plugin-path.
const NOLG_PLUGIN = __FILE__;

// set version.
const NOLG_VERSION = '@@VersionNumber@@';

// set name for transient list.
const NOLG_TRANSIENTS_LIST = 'nolg_transients';

// embed necessary files.
require_once __DIR__ . '/vendor/autoload.php';

// on activation or deactivation of this plugin.
register_activation_hook( NOLG_PLUGIN, array( Installer::get_instance(), 'activation' ) );
register_deactivation_hook( NOLG_PLUGIN, array( Installer::get_instance(), 'deactivation' ) );

// check for update of the plugin.
Update::get_instance()->init();

// initialize notices.
Transients::get_instance()->init();

// disable all further functions is block editor is disabled.
if ( ! ( function_exists( 'register_block_type' ) && ! Helper::is_plugin_active( 'classic-editor/classic-editor.php' ) ) ) {
	return;
}

/**
 * Add links in plugin list.
 *
 * @param array $links List of links on plugin in plugin list.
 *
 * @return array
 */
function nolg_add_setting_link( array $links ): array {
	// get language-dependent URL for the how-to.
	$url = 'https://github.com/threadi/nested-ordered-lists-block-editor/blob/master/docs/how_to_use.md';
	if ( Languages::get_instance()->is_german_language() ) {
		$url = 'https://github.com/threadi/nested-ordered-lists-block-editor/blob/master/docs/how_to_use_de.md';
	}

	// add the link to the list.
	$links[] = '<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html__( 'How to use', 'nested-ordered-lists-for-block-editor' ) . '</a>';

	// return resulting list of links.
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( NOLG_PLUGIN ), 'nolg_add_setting_link' );

/**
 * Register the frontend styles.
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

	// enqueue the main style file.
	wp_register_style(
		'nolg-list',
		plugins_url( $css_file, __FILE__ ),
		array(),
		Helper::get_file_version( plugin_dir_path( __FILE__ ) . $css_file )
	);

	// enqueue the iconset files.
	foreach ( Iconsets::get_instance()->get_icon_sets() as $iconset_obj ) {
		foreach ( $iconset_obj->get_style_files() as $file ) {
			// bail if handle is empty.
			if ( empty( $file['handle'] ) ) {
				continue;
			}

			// register style if path and URL are given.
			if ( ! empty( $file['path'] ) && ! empty( $file['url'] ) ) {
				wp_register_style(
					'nolg-' . $file['handle'],
					$file['url'],
					array(),
					Helper::get_file_version( $file['path'] )
				);
			}

			// register style if only dependent style name is given.
			if ( empty( $file['path'] ) && ! empty( $file['depends'] ) ) {
				wp_register_style( 'nolg-' . $file['handle'], false, $file['depends'], NOLG_VERSION );
			}
		}
	}
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
		// add editor-js.
		wp_enqueue_script(
			'nolg-list',
			plugins_url( 'attributes/list.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-block-editor' ),
			Helper::get_file_version( plugin_dir_path( __FILE__ ) . 'attributes/list.js' ),
			true
		);

		wp_enqueue_script(
			'nolg-list-item',
			plugins_url( 'attributes/listItem.js', __FILE__ ),
			array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-i18n', 'wp-block-editor' ),
			Helper::get_file_version( plugin_dir_path( __FILE__ ) . 'attributes/listItem.js' ),
			true
		);

		// add backend-css.
		wp_enqueue_style(
			'nolg-admin',
			plugins_url( 'admin/style.css', __FILE__ ),
			array(),
			Helper::get_file_version( plugin_dir_path( __FILE__ ) . 'admin/style.css' )
		);

		// add icon picker style.
		wp_enqueue_style(
			'nolg-iconpicker',
			plugins_url( 'css/iconpicker.css', __FILE__ ),
			array(),
			Helper::get_file_version( plugin_dir_path( __FILE__ ) . 'css/iconpicker.css' )
		);

		// add ja-variables for block editor.
		wp_add_inline_script(
			'nolg-list',
			'window.nolg_config = ' . wp_json_encode(
				array(
					'support_url' => Helper::get_plugin_support_url(),
				)
			),
			'before'
		);
	}

	// add frontend-css.
	nolg_frontend_style();
	wp_enqueue_style( 'nolg-list' );
	nolg_enqueue_styles_run();

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
 * Add taxonomy used with this plugin.
 * It will be visible in REST-API, also public.
 *
 * @return void
 * @noinspection PhpUnused
 */
function nolg_add_taxonomy(): void {
	// set default taxonomy-settings.
	$icon_set_array = array(
		'hierarchical'       => false,
		'labels'             => array(
			'name'          => _x( 'Nested Ordered List Iconsets', 'taxonomy general name', 'nested-ordered-lists-for-block-editor' ),
			'singular_name' => _x( 'Nested Ordered List Iconset', 'taxonomy singular name', 'nested-ordered-lists-for-block-editor' ),
			'search_items'  => __( 'Search for iconset', 'nested-ordered-lists-for-block-editor' ),
			'edit_item'     => __( 'Edit iconset', 'nested-ordered-lists-for-block-editor' ),
			'update_item'   => __( 'Update iconset', 'nested-ordered-lists-for-block-editor' ),
			'menu_name'     => __( 'Nested Ordered Lists Iconsets', 'nested-ordered-lists-for-block-editor' ),
			'add_new'       => __( 'Add new Nested Ordered List Iconset', 'nested-ordered-lists-for-block-editor' ),
			'add_new_item'  => __( 'Add new Nested Ordered List Iconset', 'nested-ordered-lists-for-block-editor' ),
			'back_to_items' => __( 'Go to Nested Ordered List Iconsets', 'nested-ordered-lists-for-block-editor' ),
		),
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_admin_column'  => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_in_rest'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capabilities'       => array(
			'manage_terms' => 'manage_options',
			'edit_terms'   => 'manage_options',
			'delete_terms' => 'manage_options',
			'assign_terms' => 'manage_options',
		),
	);

	// remove this taxonomy from views for not logged-in users.
	if ( ! is_user_logged_in() ) {
		$icon_set_array['rewrite']      = false;
		$icon_set_array['show_in_rest'] = false;
	}

	// register taxonomy.
	register_taxonomy( 'nolg_icon_set', false, $icon_set_array );
}
add_action( 'init', 'nolg_add_taxonomy' );

/**
 * Register the Bootstrap iconset.
 *
 * @param array $iconset_list The list of iconsets.
 * @return array
 */
function nolg_register_boostrap_iconset( array $iconset_list ): array {
	$iconset_list[] = Bootstrap::get_instance();
	return $iconset_list;
}
add_filter( 'nolg_register_iconset', 'nolg_register_boostrap_iconset' );

/**
 * Register the dashicons iconset.
 *
 * @param array $iconset_list The list of iconsets.
 * @return array
 */
function nolg_register_dashicons_iconset( array $iconset_list ): array {
	$iconset_list[] = Dashicons::get_instance();
	return $iconset_list;
}
add_filter( 'nolg_register_iconset', 'nolg_register_dashicons_iconset' );

/**
 * Register the fontawesome iconset.
 *
 * @param array $iconset_list The list of iconsets.
 * @return array
 */
function nolg_register_fontawesome_iconset( array $iconset_list ): array {
	$iconset_list[] = Fontawesome::get_instance();
	return $iconset_list;
}
add_filter( 'nolg_register_iconset', 'nolg_register_fontawesome_iconset' );

/**
 * Enqueue style if our block is used anywhere in the output.
 *
 * @param string $block_content The block content.
 * @param array  $block The used block.
 *
 * @return string
 */
function nolg_enqueue_styles( string $block_content, array $block ): string {
	// bail if no block name is set.
	if ( empty( $block['blockName'] ) ) {
		return $block_content;
	}

	// bail if this is not the list block.
	if ( 'core/list' !== $block['blockName'] ) {
		return $block_content;
	}

	// bail if no iconset is configured.
	if ( empty( $block['attrs']['type'] ) ) {
		return $block_content;
	}

	// get the object of the used iconset.
	$iconsets = array( Iconsets::get_instance()->get_iconset_by_slug( $block['attrs']['type'] ) );

	// enqueue the iconset.
	nolg_enqueue_styles_run( $iconsets );

	// return the block content.
	return $block_content;
}
add_action( 'render_block', 'nolg_enqueue_styles', 10, 2 );

/**
 * Run the enqueuing (used in frontend and block editor).
 *
 * @param array $iconsets List of iconsets to enqueue.
 * @return void
 */
function nolg_enqueue_styles_run( array $iconsets = array() ): void {
	// enqueue the main styles.
	wp_enqueue_style( 'nolg-list' );

	// if no iconsets are given, use all.
	if ( empty( $iconsets ) ) {
		$iconsets = Iconsets::get_instance()->get_icon_sets();
	}

	// enqueue each style of the configured iconsets.
	foreach ( $iconsets as $iconset_obj ) {
		// bail if it is not an iconset-object.
		if ( ! $iconset_obj instanceof Iconset_Base ) {
			continue;
		}

		// add the files of this iconset in frontend.
		foreach ( $iconset_obj->get_style_files() as $file ) {
			wp_enqueue_style( 'nolg-' . $file['handle'] );
		}
	}
}
