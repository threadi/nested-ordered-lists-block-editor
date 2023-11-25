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

// nothing to do.
