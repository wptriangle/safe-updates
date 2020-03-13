<?php
/**
 * Plugin Name: Safe Updates
 * Plugin URI: https://nahid.dev/project/safe-updates
 * Description: Make sure your theme and plugins are tested before updating WordPress.
 * Author: Nahid Ferdous Mohit
 * Version: 1.0.1
 * Author URI: https://nahid.dev
 * Text Domain: safe-updates
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
 * Call the plugin core file
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/core.php';
