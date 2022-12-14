( function( $ ) {
	"use strict";

	// Collapse Tab
	$('.redux-container .redux-group-menu .redux-group-tab-link-li.hasSubSections').each( function() {
		var tab      = $(this),
			tab_link = tab.find('> .redux-group-tab-link-a');
			console.log( tab_link );

		$( tab_link ).click( function( event ) {
			if ( tab.hasClass('cdhl-inactive') ) {
				tab.find( 'ul.subsection' ).slideUp( 'fast', function() {
					// tab.removeClass( 'active' ).removeClass( 'activeChild' ).addClass( 'cdhl-inactive' );
					tab.addClass( 'activeChild' ).removeClass( 'cdhl-inactive' ).find( 'ul.subsection' ).slideDown();
				} );
			} else if ( tab.hasClass('activeChild') ) {
				console.log( event );
				tab.find( 'ul.subsection' ).slideUp( 'fast', function() {
					tab.removeClass( 'active' ).removeClass( 'activeChild' ).addClass( 'cdhl-inactive' );
				} );
			}
		} );
	});

})( jQuery );
