( function( $ ){
	"use strict";
	var PGSFile_Upload = elementor.modules.controls.BaseData.extend({
		onReady: function () {
			var $this = this,
				$el   = this.$el,
				hiddenInput = $el.find( '.pgs-file-data' ),
				mime_type;

			if ( hiddenInput.attr( 'data-mime' ) ) {
				mime_type = hiddenInput.attr( 'data-mime' );
			} else {
				mime_type = 'application/pdf';
			}

			var wpMediaOptions = { 
				multiple: false,
				library: {
					orderby: 'date',
					query: true,
					type: mime_type
				},
			};

			$el.find( '.pgs-field-file-button' ).click( function (e) {
				var pgs_file_frame = wp.media( wpMediaOptions );
					pgs_file_frame.on(
						'open',
						function() {
							var selection = pgs_file_frame.state().get( 'selection' );
							var file_data = hiddenInput.val();
							
							if ( file_data ) {
								file_data = JSON.parse( file_data );
								if ( file_data.id ) {
									var attachment = wp.media.attachment( file_data.id );
										attachment.fetch();
										selection.add( attachment ? [ attachment ] : [] );
								}
							}
						}
					);

					pgs_file_frame.on(
						'select',
						function() {
							var file = pgs_file_frame.state().get( 'selection' ).first().toJSON();

							if ( file ) {
							   var file_data = {id:file.id, url:file.url, title:file.title};
							   hiddenInput.val( JSON.stringify( file_data ) ).trigger( 'input' );
							}
							$this.render();
						}
					);
					
					pgs_file_frame.open();
			});

			$el.find( '.pgs-file-remove' ).click( function (e) {
				e.preventDefault();
				hiddenInput.val( '' ).trigger( 'input' );
				$this.render();
			});
		},
	});

	// Add Control Handlers
	elementor.addControlView( 'pgs_file_upload', PGSFile_Upload );
})( jQuery );
