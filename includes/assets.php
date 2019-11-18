<?php
/**
 * Enqueue and handle assets
 *
 * @since      1.0
 * @package    Safe Updates
 * @author     Nahid Ferdous Mohit
 */

/*
 * Admin assets
 */

function safe_updates_enqueue_admin_assets( $hook ) {

	if( $hook != 'update-core.php' ) {
		return;
    }

    wp_enqueue_script( 'safe-updates-admin-popper',  plugin_dir_url( dirname( __FILE__ ) ) . 'assets/dist/js/popper.min.js', array( 'jquery' ), '', true  );
    wp_enqueue_script( 'safe-updates-admin-bootstrap',  plugin_dir_url( dirname( __FILE__ ) ) . 'assets/dist/js/bootstrap.min.js', array( 'jquery' ), '', true  );
    wp_enqueue_script( 'safe-updates-admin-scripts',  plugin_dir_url( dirname( __FILE__ ) ) . 'assets/dist/js/main.min.js', array( 'jquery' ), '', true  );
    wp_enqueue_style( 'safe-updates-admin-styles',  plugin_dir_url( dirname( __FILE__ ) ) . 'assets/dist/css/main.min.css' );
}
add_action( 'admin_enqueue_scripts', 'safe_updates_enqueue_admin_assets' );
