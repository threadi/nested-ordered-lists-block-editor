<?php
/**
 * File to handle installer-tasks.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Object to handle installer-tasks.
 */
class Installer {

	/**
	 * Instance of this object.
	 *
	 * @var ?Installer
	 */
	private static ?Installer $instance = null;

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
	public static function get_instance(): Installer {
		if ( ! static::$instance instanceof static ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Run during installation/activation of this plugin.
	 *
	 * @return void
	 */
	public function activation(): void {
		if ( ! get_option( 'nolgVersion', false ) ) {
			add_option( 'nolgVersion', NOLG_VERSION, '', true );
		}

		// initialize our own taxonomy during installation.
		nolg_add_taxonomy();

		// add generic iconsets.
		Helper::add_generic_iconsets();
	}

	/**
	 * Run during deactivation of this plugin.
	 *
	 * @return void
	 */
	public function deactivation(): void {}
}
