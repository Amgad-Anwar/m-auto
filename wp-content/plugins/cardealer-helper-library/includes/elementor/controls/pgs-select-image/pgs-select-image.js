( function( $ ){
	"use strict";

	var PGSSelectImageItemView = elementor.modules.controls.BaseData.extend({
		onReady: function () {
			var media__preview = this.$el.find( '.elementor-control-media__preview' );

			this.ui.select.on( 'change', function() {
				var current_val = $( this ).val(),
					current_img = $( this ).find(':selected').data('option_img');

				media__preview.attr( 'src', current_img );
			} );
		},

		saveValue: function () {
		},

		onBeforeDestroy: function () {
		}
	});

	// Add Control Handlers
	elementor.addControlView('pgs_select_image', PGSSelectImageItemView);
})( jQuery );
