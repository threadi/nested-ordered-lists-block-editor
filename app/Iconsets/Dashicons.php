<?php
/**
 * File for dashicons iconset.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists\Iconsets;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use nestedOrderedLists\Iconset;
use nestedOrderedLists\Iconset_Base;

/**
 * Definition for dashicons iconset.
 */
class Dashicons extends Iconset_Base implements Iconset {
	/**
	 * Set type of this iconset.
	 *
	 * @var string
	 */
	protected string $type = 'dashicons';

	/**
	 * Set slug of this iconset.
	 *
	 * @var string
	 */
	protected string $slug = 'dashicons';

	/**
	 * Initialize the object.
	 *
	 * @return void
	 */
	public function init(): void {
		$this->label = __( 'Dashicons', 'nested-ordered-lists-for-block-editor' );
	}

	/**
	 * Return the style-files this iconset is using.
	 *
	 * @return array
	 */
	public function get_style_files(): array {
		$files = array(
			array(
				'handle'  => 'dashicons',
				'depends' => array( 'dashicons' ),
			),
			array(
				'handle' => 'dashicons-custom',
				'url'    => plugins_url( '/css/dashicons.css', NOLG_PLUGIN ),
				'path'   => plugin_dir_path( NOLG_PLUGIN ) . '/css/dashicons.css',
			),
		);

		/**
		 * Filter the files used for dashicons.
		 *
		 * @param array $files List of the files.
		 * @since 2.0.0 Available since 2.0.0
		 */
		return apply_filters( 'nolg_dashicons_files', $files );
	}
}
