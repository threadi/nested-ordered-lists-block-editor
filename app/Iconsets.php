<?php
/**
 * File for general handling of iconsets.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Object for general iconset-handling.
 */
class Iconsets {
	/**
	 * Instance of this object.
	 *
	 * @var ?iconsets
	 */
	private static ?iconsets $instance = null;

	/**
	 * Constructor for Init-Handler.
	 */
	private function __construct() {}

	/**
	 * Prevent cloning of this object.
	 *
	 * @return void
	 */
	private function __clone() { }

	/**
	 * Return the instance of this Singleton object.
	 */
	public static function get_instance(): iconsets {
		if ( ! static::$instance instanceof static ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Initialize the iconset.
	 *
	 * @return void
	 */
	public function init(): void {}

	/**
	 * Get all iconsets which are registered.
	 *
	 * @return array
	 */
	public function get_icon_sets(): array {
		$list = array();

		/**
		 * Register a single iconset through adding it to the list.
		 *
		 * The iconset must be an object extending Iconset_Base and implement Iconset.
		 *
		 * @since 2.0.0 Available since 2.0.0.
		 *
		 * @param array $list The list of iconsets.
		 */
		return apply_filters( 'nolg_register_iconset', $list );
	}

	/**
	 * Get iconset based on slug.
	 *
	 * @param string $slug The slug of the iconset.
	 * @return Iconset_Base|false
	 */
	public function get_iconset_by_slug( string $slug ): Iconset_Base|false {
		foreach ( $this->get_icon_sets() as $iconset_obj ) {
			// bail if it does not match.
			if ( $slug !== $iconset_obj->get_slug() ) {
				continue;
			}

			// return this object as it matches the slug.
			return $iconset_obj;
		}
		return false;
	}
}
