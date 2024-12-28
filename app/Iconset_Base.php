<?php
/**
 * File for base functions for each iconset.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Define the base-functions for each iconset.
 */
class Iconset_Base {
	/**
	 * Label of the iconset.
	 *
	 * @var string
	 */
	protected string $label = '';

	/**
	 * Slug of the iconset.
	 *
	 * @var string
	 */
	protected string $slug = '';

	/**
	 * Typ of the iconset.
	 *
	 * @var string
	 */
	protected string $type = '';

	/**
	 * Instance of this object.
	 *
	 * @var ?Iconset_Base
	 */
	private static ?Iconset_Base $instance = null;

	/**
	 * Constructor for every Iconset-base-object.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Prevent cloning of this object.
	 *
	 * @return void
	 */
	private function __clone() { }

	/**
	 * Return the instance of this Singleton object.
	 */
	public static function get_instance(): Iconset_Base {
		if ( ! static::$instance instanceof static ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Return whether the iconset has a type set.
	 *
	 * @return bool
	 * @noinspection PhpUnused
	 */
	public function has_type(): bool {
		return ! empty( $this->type );
	}

	/**
	 * Initialize this object.
	 *
	 * @return void
	 */
	public function init(): void {}

	/**
	 * Return whether the iconset has a label set.
	 *
	 * @return bool
	 * @noinspection PhpUnused
	 */
	public function has_label(): bool {
		return ! empty( $this->label );
	}

	/**
	 * Return the iconset-label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->label;
	}

	/**
	 * Return the iconset-type.
	 *
	 * @return string
	 */
	public function get_type(): string {
		return $this->type;
	}

	/**
	 * Return the iconset-slug.
	 *
	 * @return string
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * Return nothing as this iconset does not use any iconset-specific styles.
	 *
	 * @return array
	 */
	public function get_style_files(): array {
		return array();
	}
}
