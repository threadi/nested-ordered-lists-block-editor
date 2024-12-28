<?php
/**
 * File for bootstrap iconset.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists\Iconsets;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use nestedOrderedLists\Iconset;
use nestedOrderedLists\Iconset_Base;

/**
 * Definition for bootstrap iconset.
 */
class Bootstrap extends Iconset_Base implements Iconset {
	/**
	 * Set type of this iconset.
	 *
	 * @var string
	 */
	protected string $type = 'bootstrap';

	/**
	 * Set slug of this iconset.
	 *
	 * @var string
	 */
	protected string $slug = 'bootstrap';

	/**
	 * Initialize the object.
	 *
	 * @return void
	 */
	public function init(): void {
		$this->label = __( 'Bootstrap', 'nested-ordered-lists-for-block-editor' );
	}

	/**
	 * Return the style-files this iconset is using.
	 *
	 * @return array
	 */
	public function get_style_files(): array {
		$files = array(
			array(
				'handle' => 'bootstrap',
				'url'    => plugins_url( '/css/bootstrap/bootstrap-icons.css', NOLG_PLUGIN ),
				'path'   => plugin_dir_path( NOLG_PLUGIN ) . '/css/bootstrap/bootstrap-icons.css',
			),
			array(
				'handle' => 'bootstrap-custom',
				'url'    => plugins_url( '/css/bootstrap.css', NOLG_PLUGIN ),
				'path'   => plugin_dir_path( NOLG_PLUGIN ) . '/css/bootstrap.css',
			),
		);

		/**
		 * Filter the files used for bootstrap.
		 *
		 * @param array $files List of the files.
		 * @since 2.0.0 Available since 2.0.0
		 */
		return apply_filters( 'nolg_bootstrap_files', $files );
	}
}
