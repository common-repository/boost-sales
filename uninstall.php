<?php
/**
 * Plugin uninstall file
 *
 * @since      1.0.0
 * @author     Beeketing
 */

// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

require_once('boost-sales.php');

BoostSales::instance()->plugin_uninstall();