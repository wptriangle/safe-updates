<?php
/**
 * Core plugin file
 *
 * @since      1.0
 * @package    Safe Updates
 * @author     Nahid Ferdous Mohit
 */

/*
 * If this file is called directly, abort.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Enqueue CSS and JS assets
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/assets.php';

/*
 * Common functions
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/commons.php';

/*
 * Handle core updates
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/updates/core-updates.php';
