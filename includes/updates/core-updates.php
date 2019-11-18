<?php
/**
 * Handle core updates
 *
 * @since      1.0
 * @package    Safe Updates
 * @author     Nahid Ferdous Mohit
 */

/*
 * Core updates display
 */

function safe_updates_core_updates_display() {

    /* Check if core updates are available */

    $core_updates = get_core_updates();
	if ( $core_updates ) {

        /* Find the target core update version */

		foreach ( $core_updates as $core_update ) {
			if ( isset( $core_update->response ) || 'upgrade' == $core_update->response ) {

                $target_core_version = $core_update->version;

                /* Create an array of activated plugins */

                $active_plugins = get_option( 'active_plugins' );
                $all_plugins = get_plugins();
                $activated_plugins = array();
                
                foreach ( $active_plugins as $active_plugin ) {           
                    if( isset( $all_plugins[ $active_plugin ] ) ){
                        array_push( $activated_plugins, $all_plugins[ $active_plugin ] );
                    }           
                }

                /* Display a table of plugins which are not tested with the target core update version */

                echo '<table id="safe-updates-core"><tr><th>Plugin Name</th><th>Tested up to</th></tr>';
                foreach( $activated_plugins as $activated_plugin ) {
                    if ( safe_updates_tested_up_to( 'plugin', $activated_plugin[ 'TextDomain' ] ) && safe_updates_tested_up_to( 'plugin', $activated_plugin[ 'TextDomain' ] ) != $target_core_version ) {
                        echo '<tr>';
                        echo '<td>' . $activated_plugin[ 'Name' ] . '</td>';
                        echo '<td>' . safe_updates_tested_up_to( 'plugin', $activated_plugin[ 'TextDomain' ] ) . '</td>';
                        echo '</tr>';
                    }
                }
                echo '</table>';
			}
        }
	}
}
add_action( 'core_upgrade_preamble', 'safe_updates_core_updates_display' );
