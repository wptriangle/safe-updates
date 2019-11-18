<?php
/**
 * Common functions
 *
 * @since      1.0
 * @package    Safe Updates
 * @author     Nahid Ferdous Mohit
 */

/*
 * Function to determine "Tested up to" version of a plugin/theme
 */

function safe_updates_tested_up_to( $component, $slug ) {

    if ( $component == 'plugin' ) {
        $component_dir = WP_PLUGIN_DIR;
    } elseif ( $component == 'theme' ) {
        $component_dir = WP_THEME_DIR;
    } else {
        return __( 'Component not defined', 'safe-updates' );
    }

    $readme_file = $component_dir . '/' . $slug . '/readme.txt';

	if ( file_exists( $readme_file ) ) {
		$component_data = get_file_data(
			$readme_file,
			array(
				'tested_up_to' => 'Tested up to',
			)
		);

		return $component_data[ 'tested_up_to' ];
	}
}
