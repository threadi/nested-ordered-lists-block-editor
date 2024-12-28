<?php
/**
 * File for handling updates of this plugin.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Helper-function for updates of this plugin.
 */
class Update {
	/**
	 * Instance of this object.
	 *
	 * @var ?Update
	 */
	private static ?Update $instance = null;

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
	public static function get_instance(): Update {
		if ( ! static::$instance instanceof static ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Initialize the Updater.
	 *
	 * @return void
	 */
	public function init(): void {
		add_action( 'init', array( $this, 'run' ) );
	}

	/**
	 * Run check for updates.
	 *
	 * @return void
	 */
	public function run(): void {
		// get installed plugin-version (version of the actual files in this plugin).
		$installed_plugin_version = NOLG_VERSION;

		// get db-version (version which was last installed).
		$db_plugin_version = get_option( 'nolgVersion', '1.0.0' );

		// compare version if we are not in development-mode.
		if (
			(
				(
					function_exists( 'wp_is_development_mode' ) && false === wp_is_development_mode( 'plugin' )
				)
				|| ! function_exists( 'wp_is_development_mode' )
			)
			&& version_compare( $installed_plugin_version, $db_plugin_version, '>' )
		) {
			$this->version200();

			// save new plugin-version in DB.
			update_option( 'nolgVersion', $installed_plugin_version );
		}
	}

	/**
	 * Run on update to 2.0.0 or newer.
	 *
	 * @return void
	 */
	private function version200(): void {
		// initialize our own taxonomy during update.
		nolg_add_taxonomy();

		// add generic iconsets.
		Helper::add_generic_iconsets();
	}
}
