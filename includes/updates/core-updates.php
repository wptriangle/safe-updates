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

                /* Check if the active theme is tested */

                $active_theme = wp_get_theme();

                if ( safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ) && safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ) != $target_core_version ) {
                    $untested_theme = true;
                } else {
                    $untested_theme = false;
                }

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

                /* Start theme display */

                if ( $untested_theme ) {

                    echo '<h4>' . __( 'Your active theme is untested with the target WordPress version:' ) . '</h4>';

                    /* Display a table of plugins which are not tested with the target core update version */

                    echo '<table class="widefat updates-table safe-updates-table"><thead><tr><th class="theme-title">' . __( 'Theme Name', 'safe-updates' ) . '</th><th>' . __( 'Tested up to', 'safe-updates' ) . '</th><th>' . __( 'Target core version', 'safe-updates' ) . '</th></tr></thead><tbody>';
                    echo '<tr>';
                    echo '<td class="theme-title"><strong>' . $active_theme[ 'Name' ] . '</strong></td>';
                    echo '<td class="tested-up-to untested">' . safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ) . '</td>';
                    echo '<td class="target-core-version">' . $target_core_version . '</td>';
                    echo '</tr>';
                    echo '</tbody></table>';
                } else {
                    echo '<h4>' . __( 'Your active theme is tested with the target WordPress version.' ) . '</h4>';
                }

                /* Start plugin display */

                if ( $untested_plugins ) {
                    if (  count( $untested_plugins ) <= 1 ) {
                        echo '<h4>' . __( 'You have a plugin that is untested with the target WordPress version:' ) . '</h4>';
                    } elseif (  count( $untested_plugins ) > 1 ) {
                        echo '<h4>' . __( 'You have plugins that are untested with the target WordPress version:' ) . '</h4>';
                    } else {
                        echo '<h4>' . __( 'All your plugins are tested with the target WordPress version.' ) . '</h4>';
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

				?>
				
				<div class="safe-updates-box">

					<div class="safe-updates-box-header">
						<h3 class="safe-updates-box-title"><?php echo __( 'Safe Updates', 'safe-updates' ); ?></h3>
						<div class="safe-updates-actions-left">
							<span class="safe-updates-tag safe-updates-tag-warning">+1</span>
						</div>
						<div class="safe-updates-actions-right"></div>
					</div>

					<div class="safe-updates-box-body">
						<div class="accordion" id="safe-updates-accordion">

							<div class="card">
								<div class="card-header" id="headingThemes" data-toggle="collapse" data-target="#collapseThemes" aria-expanded="true" aria-controls="collapseThemes">
									<p>Your active theme has been tested with the target WordPress version.</p>
								</div>
							</div>

							<div class="card untested">
								<div class="card-header" id="headingThemes" data-toggle="collapse" data-target="#collapseThemes" aria-expanded="false" aria-controls="collapseThemes">
									<p>Your active theme has not been tested with the target WordPress version.</p>
								</div>

								<div id="collapseThemes" class="collapse safe-updates-box" aria-labelledby="headingThemes"
									data-parent="#safe-updates-accordion">
									<div class="card-body safe-updates-box-body">
										<table class="safe-updates-table">
											<thead>
												<tr>
													<th><?php echo __( 'Theme Name', 'safe-updates' ); ?></th>
													<th><?php echo __( 'Tested up to', 'safe-updates' ); ?></th>
													<th><?php echo __( 'Target WordPress version', 'safe-updates' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Theme</td>
													<td><i class="fas fa-exclamation-circle"></i> 5.0</td>
													<td>5.3</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

                <?php
			}
        }

        echo '</div>';
	}
}
add_action( 'core_upgrade_preamble', 'safe_updates_core_updates_display' );
