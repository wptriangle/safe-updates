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

        /* Start display */

        echo '<div id="safe-updates-core">';

        /* Find the target core update version */

		foreach ( $core_updates as $core_update ) {
			if ( isset( $core_update->response ) || 'upgrade' == $core_update->response ) {

                $target_core_version = $core_update->version;

                /* Display a table of plugins which are not tested with the target core update version */

                $active_theme = wp_get_theme();

                echo '<table class="widefat updates-table safe-updates-table"><thead><tr><th class="theme-title">' . __( 'Theme Name', 'safe-updates' ) . '</th><th>' . __( 'Tested up to', 'safe-updates' ) . '</th><th>' . __( 'Target core version', 'safe-updates' ) . '</th></tr></thead><tbody>';
                if ( safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ) && safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ) != $target_core_version ) {
                    echo '<tr>';
                    echo '<td class="theme-title"><strong>' . $active_theme[ 'Name' ] . '</strong></td>';
                    echo '<td class="tested-up-to untested">' . safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ) . '</td>';
                    echo '<td class="target-core-version">' . $target_core_version . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';

                /* Create an array of activated plugins */

                $active_plugins = get_option( 'active_plugins' );
                $all_plugins = get_plugins();
                $activated_plugins = array();
                
                foreach ( $active_plugins as $active_plugin ) {           
                    if( isset( $all_plugins[ $active_plugin ] ) ){
                        array_push( $activated_plugins, $all_plugins[ $active_plugin ] );
                    }
                }

                /* Create an array of untested plugins */

                $untested_plugins = array();

                foreach( $activated_plugins as $activated_plugin ) {
                    if ( safe_updates_tested_up_to( 'plugin', $activated_plugin[ 'TextDomain' ] ) && safe_updates_tested_up_to( 'plugin', $activated_plugin[ 'TextDomain' ] ) != $target_core_version ) {
                        array_push( $untested_plugins, $activated_plugin );
                    }
                }

                /* Display a table of plugins which are not tested with the target core update version */

                echo '<table class="widefat updates-table safe-updates-table"><thead><tr><th class="plugin-title">' . __( 'Plugin Name', 'safe-updates' ) . '</th><th>' . __( 'Tested up to', 'safe-updates' ) . '</th><th>' . __( 'Target core version', 'safe-updates' ) . '</th></tr></thead><tbody>';
                foreach( $untested_plugins as $untested_plugin ) {
                    if ( safe_updates_tested_up_to( 'plugin', $untested_plugin[ 'TextDomain' ] ) && safe_updates_tested_up_to( 'plugin', $untested_plugin[ 'TextDomain' ] ) != $target_core_version ) {
                        echo '<tr>';
                        echo '<td class="plugin-title"><strong>' . $untested_plugin[ 'Name' ] . '</strong></td>';
                        echo '<td class="tested-up-to untested">' . safe_updates_tested_up_to( 'plugin', $untested_plugin[ 'TextDomain' ] ) . '</td>';
                        echo '<td class="target-core-version">' . $target_core_version . '</td>';
                        echo '</tr>';
                    }
                }
                echo '</tbody></table>';
			}
        }

        echo '</div>';
	}
}
add_action( 'core_upgrade_preamble', 'safe_updates_core_updates_display' );
