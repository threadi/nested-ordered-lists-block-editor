<?php
/**
 * This file contains the handling of transients for this plugin in wp-admin.
 *
 * @package nested-ordered-lists-for-block-editor
 */

namespace nestedOrderedLists;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

/**
 * Initialize the transients-object.
 */
class Transients {
	/**
	 * Instance of actual object.
	 *
	 * @var Transients|null
	 */
	private static ?Transients $instance = null;

	/**
	 * Constructor, not used as this a Singleton object.
	 */
	private function __construct() {}

	/**
	 * Prevent cloning of this object.
	 *
	 * @return void
	 */
	private function __clone() { }

	/**
	 * Return instance of this object as singleton.
	 *
	 * @return Transients
	 */
	public static function get_instance(): Transients {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize the transients.
	 *
	 * @return void
	 */
	public function init(): void {
		// enable our own notices.
		add_action( 'admin_notices', array( $this, 'init_notices' ) );
	}

	/**
	 * Initialize the visibility of any transients as notices.
	 *
	 * Only visible for users with capability to manage settings of this plugin.
	 *
	 * @return void
	 */
	public function init_notices(): void {
		// return if user has no capability for this.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// check the transients.
		$this->check_transients();
	}

	/**
	 * Adds a single transient.
	 *
	 * @return Transient
	 */
	public function add(): Transient {
		// create new object and return it directly.
		return new Transient();
	}

	/**
	 * Get all known transients as objects.
	 *
	 * @return array[Transient]
	 */
	public function get_transients(): array {
		$transients = array();

		// get list of our own transients from DB as array.
		$transients_from_db = get_option( NOLG_TRANSIENTS_LIST, array() );
		if ( ! is_array( $transients_from_db ) ) {
			$transients_from_db = array();
		}

		// loop through the list and create the corresponding transient-objects.
		foreach ( $transients_from_db as $transient ) {
			// create the object from setting.
			$transient_obj = new Transient( $transient );

			// add object to list.
			$transients[ $transient ] = $transient_obj;
		}

		// return the resulting list as array.
		return $transients;
	}

	/**
	 * Check if a given transient is known to this handler.
	 *
	 * @param string $transient_name The requested transient-name.
	 *
	 * @return bool
	 */
	public function is_transient_set( string $transient_name ): bool {
		$transients = $this->get_transients();
		return ! empty( $transients[ $transient_name ] );
	}

	/**
	 * Add new transient to list of our plugin-specific transients.
	 *
	 * @param Transient $transient_obj The transient-object to add.
	 *
	 * @return void
	 */
	public function add_transient( Transient $transient_obj ): void {
		// get actual known transients as array.
		$transients = $this->get_transients();

		// bail if transient is already on list.
		if ( ! empty( $transients[ $transient_obj->get_name() ] ) ) {
			return;
		}

		// add the new one to the list.
		$transients[ $transient_obj->get_message() ] = $transient_obj;

		// transform list to simple array for options-table.
		$transients_in_db = array();
		foreach ( $transients as $transient ) {
			$transients_in_db[] = $transient->get_name();
		}

		// update the transients-list in db.
		update_option( NOLG_TRANSIENTS_LIST, $transients_in_db );
	}

	/**
	 * Delete single transient from our own list.
	 *
	 * @param Transient $transient_to_delete_obj The transient-object to delete.
	 *
	 * @return void
	 */
	public function delete_transient( Transient $transient_to_delete_obj ): void {
		// get actual known transients as array.
		$transients = $this->get_transients();

		// bail if transient is not in our list.
		if ( empty( $transients[ $transient_to_delete_obj->get_name() ] ) ) {
			return;
		}

		// remove it from the list.
		unset( $transients[ $transient_to_delete_obj->get_name() ] );

		// transform list to simple array with transient names for options-table.
		$transients_in_db = array();
		foreach ( $transients as $transient ) {
			$transients_in_db[] = $transient->get_name();
		}
		update_option( NOLG_TRANSIENTS_LIST, $transients_in_db );
	}

	/**
	 * Check all known transients to show them.
	 *
	 * @return void
	 */
	public function check_transients(): void {
		$transients = $this->get_transients();
		/**
		 * Filter the transients used and managed by this plugin.
		 *
		 * Hint: with help of this hook you could hide all transients this plugin is using. Simple return an empty array.
		 *
		 * @since 2.0.0 Available since 2.0.0.
		 *
		 * @param array $transients List of transients.
		 */
		foreach ( apply_filters( 'nolg_get_transients_for_display', $transients ) as $transient_obj ) {
			// bail if transient is not set.
			if ( ! $transient_obj->is_set() ) {
				continue;
			}

			// show this transient hint.
			$transient_obj->display();
		}
	}

	/**
	 * Return a specific transient by its internal name.
	 *
	 * @param string $transient The transient-name we search.
	 *
	 * @return Transient
	 */
	public function get_transient_by_name( string $transient ): Transient {
		return new Transient( $transient );
	}
}
