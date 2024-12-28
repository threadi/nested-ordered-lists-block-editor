<?php
/**
 * Tasks to run during uninstallation of this plugin.
 *
 * @package nested-ordered-lists-for-block-editor
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// delete the content of all taxonomies.
global $wpdb;
$terms = $wpdb->get_results(
	$wpdb->prepare(
		'SELECT ' . $wpdb->terms . '.term_id
				FROM ' . $wpdb->terms . '
				INNER JOIN
					' . $wpdb->term_taxonomy . '
					ON
					 ' . $wpdb->term_taxonomy . '.term_id = ' . $wpdb->terms . '.term_id
				WHERE ' . $wpdb->term_taxonomy . '.taxonomy = %s',
		array( 'nolg_icon_set' )
	)
);

// delete them.
foreach ( $terms as $term ) {
	$wpdb->delete(
		$wpdb->terms,
		array(
			'term_id' => $term->term_id,
		)
	);
}

// delete all taxonomy-entries.
$wpdb->delete( $wpdb->term_taxonomy, array( 'taxonomy' => 'nolg_icon_set' ), array( '%s' ) );

// cleanup options.
delete_option( 'nolg_icon_set_children' );
