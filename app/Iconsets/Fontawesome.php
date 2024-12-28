<?php
/**
 * File for Fontawesome iconset.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists\Iconsets;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use nestedOrderedLists\Iconset;
use nestedOrderedLists\Iconset_Base;

/**
 * Definition for Fontawesome iconset.
 */
class Fontawesome extends Iconset_Base implements Iconset {
	/**
	 * Set type of this iconset.
	 *
	 * @var string
	 */
	protected string $type = 'fontawesome';

	/**
	 * Set slug of this iconset.
	 *
	 * @var string
	 */
	protected string $slug = 'fontawesome';

	/**
	 * Initialize the object.
	 *
	 * @return void
	 */
	public function init(): void {
		$this->label = __( 'FontAweSome', 'nested-ordered-lists-for-block-editor' );
	}

	/**
	 * Return the style-files this iconset is using.
	 *
	 * @return array
	 */
	public function get_style_files(): array {
		$files = array(
			array(
				'handle' => 'fontawesome',
				'url'    => plugins_url( '/css/fontawesome/fontawesome6.css', NOLG_PLUGIN ),
				'path'   => plugin_dir_path( NOLG_PLUGIN ) . '/css/fontawesome/fontawesome6.css',
			),
			array(
				'handle' => 'fontawesome-custom',
				'url'    => plugins_url( '/css/fontawesome.css', NOLG_PLUGIN ),
				'path'   => plugin_dir_path( NOLG_PLUGIN ) . '/css/fontawesome.css',
			),
		);

		/**
		 * Filter the files used for fontawesome.
		 *
		 * @param array $files List of the files.
		 * @since 2.0.0 Available since 2.0.0
		 */
		return apply_filters( 'nolg_fontawesome_files', $files );
	}
}
