<?php
/**
 * File for interface-object for iconsets.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Definition for requirements for iconsets.
 */
interface Iconset {
	/**
	 * Initialize the object.
	 *
	 * @return void
	 */
	public function init(): void;

	/**
	 * Return the style-files this iconset is using.
	 *
	 * @return array
	 */
	public function get_style_files(): array;
}
