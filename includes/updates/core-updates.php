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
			if ( isset( $core_update->response ) && 'upgrade' == $core_update->response ) {

                $target_core_version = $core_update->version;

                /* Check if the active theme is tested */

                $active_theme = wp_get_theme();

                if ( safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ) < $target_core_version ) {
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
                    if ( safe_updates_tested_up_to( 'plugin', $activated_plugin[ 'TextDomain' ] ) < $target_core_version ) {
                        array_push( $untested_plugins, $activated_plugin );
                    }
                }

				?>
				
				<div class="safe-updates-box">

					<div class="safe-updates-box-header">
						<h3 class="safe-updates-box-title"><?php echo __( 'Safe Updates', 'safe-updates' ); ?></h3>
						<div class="safe-updates-actions-left">
                            <?php
                                $theme_count = ( $untested_theme ? 1 : 0 );
                                $plugin_count= count( $untested_plugins );
                            ?>
							<span class="safe-updates-tag <?php echo ( $theme_count + $plugin_count < 1 ? 'safe-updates-tag-success' : 'safe-updates-tag-error' ); ?>"><?php echo $theme_count + $plugin_count; ?></span>
						</div>
						<div class="safe-updates-actions-right">
                            <?php
                                $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/safe-updates/safe-updates.php' );
                            ?>
                            <span class="plugin-version"><?php echo __( 'v', 'safe-updates' ) . $plugin_data[ 'Version' ]; ?></span>
                        </div>
					</div>

					<div class="safe-updates-box-body">
						<div class="accordion" id="safe-updates-accordion">

                            <?php
                                if ( ! $untested_theme && ! $untested_plugins ) {
                                    ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <p><?php echo __( 'Your active theme and plugins have been tested with the target WordPress version.', 'safe-updates' ); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }

                                if ( $untested_theme ) {
                                    ?>
                                    <div class="card untested">
                                        <div class="card-header" id="headingThemes" data-toggle="collapse" data-target="#collapseThemes" aria-expanded="false" aria-controls="collapseThemes">
                                            <p><?php echo __( 'Your active theme has not been tested with the target WordPress version.', 'safe-updates' ); ?></p>
                                            <button class="open-card"><i class="fas fa-angle-down"></i></button>
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
                                                            <td><?php echo $active_theme[ 'Name' ]; ?></td>
                                                            <td><i class="fas fa-exclamation-circle"></i> <?php echo safe_updates_tested_up_to( 'theme', $active_theme->get( 'TextDomain' ) ); ?></td>
                                                            <td><?php echo $target_core_version; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif ( ! $untested_theme && $untested_plugins ) {
                                    ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <p><?php echo __( 'Your active theme has been tested with the target WordPress version.', 'safe-updates' ); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }

                                if ( $untested_plugins ) {
                                    ?>
                                    <div class="card untested">
                                        <div class="card-header" id="headingPlugins" data-toggle="collapse" data-target="#collapsePlugins" aria-expanded="false" aria-controls="collapsePlugins">
                                            <p>
                                                <?php
                                                    if (  count( $untested_plugins ) <= 1 ) {
                                                        echo __( 'One of your active plugins has not been tested with the target WordPress version:' );
                                                    } elseif (  count( $untested_plugins ) > 1 ) {
                                                        echo __( 'Some of your active plugins have not been tested with the target WordPress version:' );;
                                                    }
                                                ?>
                                            </p>
                                            <button class="open-card"><i class="fas fa-angle-down"></i></button>
                                        </div>

                                        <div id="collapsePlugins" class="collapse safe-updates-box" aria-labelledby="headingPlugins"
                                            data-parent="#safe-updates-accordion">
                                            <div class="card-body safe-updates-box-body">
                                                <table class="safe-updates-table">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo __( 'Plugin Name', 'safe-updates' ); ?></th>
                                                            <th><?php echo __( 'Tested up to', 'safe-updates' ); ?></th>
                                                            <th><?php echo __( 'Target WordPress version', 'safe-updates' ); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach( $untested_plugins as $untested_plugin ) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $untested_plugin[ 'Name' ]; ?></td>
                                                                <td><i class="fas fa-exclamation-circle"></i> <?php echo safe_updates_tested_up_to( 'plugin', $untested_plugin[ 'TextDomain' ] ); ?></td>
                                                                <td><?php echo $target_core_version; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif ( $untested_theme && ! $untested_plugins ) {
                                    ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <p><?php echo __( 'Your active plugins have been tested with the target WordPress version.', 'safe-updates' ); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>

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
