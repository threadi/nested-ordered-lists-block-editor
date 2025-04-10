<?php
/**
 * File with helper-functions for this plugin.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use WP_Post;
use WP_Post_Type;

/**
 * Helper-method.
 */
class Helper {
	/**
	 * Add generic iconsets, if they do not exist atm.
	 *
	 * @return void
	 */
	public static function add_generic_iconsets(): void {
		// add predefined iconsets to taxonomy if they do not exist.
		foreach ( Iconsets::get_instance()->get_icon_sets() as $iconset_obj ) {
			// bail if iconset has not our base-class.
			if ( ! ( $iconset_obj instanceof Iconset_Base ) ) {
				continue;
			}

			// bail if one necessary setting is missing.
			if ( false === $iconset_obj->has_label() || false === $iconset_obj->has_type() ) {
				continue;
			}

			// check if this term already exists.
			if ( ! term_exists( $iconset_obj->get_label(), 'nolg_icon_set' ) ) {
				// no, it does not exist. then add it now.
				$term = wp_insert_term(
					$iconset_obj->get_label(),
					'nolg_icon_set',
					array(
						'slug' => $iconset_obj->get_slug(),
					)
				);
			} else {
				$term_obj = get_term_by( 'slug', $iconset_obj->get_slug(), 'nolg_icon_set' );
				$term     = array(
					'term_id' => $term_obj->term_id,
				);
			}

			// bail on error.
			if ( is_wp_error( $term ) ) {
				continue;
			}

			// save the type for this term.
			update_term_meta( $term['term_id'], 'type', $iconset_obj->get_type() );
		}
	}

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
	public static function get_file_version( string $filepath ): string {
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

	/**
	 * Checks whether a given plugin is active.
	 *
	 * Used because WP's own function is_plugin_active() is not accessible everywhere.
	 *
	 * @param string $plugin Path to the requested plugin relative to plugin-directory.
	 * @return bool
	 */
	public static function is_plugin_active( string $plugin ): bool {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true );
	}

	/**
	 * Return the name of this plugin.
	 *
	 * @return string
	 */
	public static function get_plugin_name(): string {
		$plugin_data = get_plugin_data( NOLG_PLUGIN );
		if ( ! empty( $plugin_data ) && ! empty( $plugin_data['Name'] ) ) {
			return $plugin_data['Name'];
		}
		return '';
	}

	/**
	 * Get current URL in frontend and backend.
	 *
	 * @return string
	 */
	public static function get_current_url(): string {
		if ( is_admin() && ! empty( $_SERVER['REQUEST_URI'] ) ) {
			return admin_url( basename( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) );
		}

		// set return value for page url.
		$page_url = '';

		// get actual object.
		$object = get_queried_object();
		if ( $object instanceof WP_Post_Type ) {
			$page_url = get_post_type_archive_link( $object->name );
		}
		if ( $object instanceof WP_Post ) {
			$page_url = get_permalink( $object->ID );
		}

		// return result.
		return $page_url;
	}

	/**
	 * Return the plugin support url: the forum on WordPress.org.
	 *
	 * @return string
	 */
	public static function get_plugin_support_url(): string {
		return 'https://wordpress.org/support/plugin/nested-ordered-lists-for-block-editor/';
	}
}
