/**
 * Safe Updates Main JS
 *
 */

/*
 * Safe Updates Main Sass File
 */

import '../sass/main.scss';

/*
 * Core updates display location
 */

( function( $ ) {
	$( document ).ready( function() {
		$( '#safe-updates-core' ).prependTo( 'ul.core-updates' );
	} );
} )( jQuery );
