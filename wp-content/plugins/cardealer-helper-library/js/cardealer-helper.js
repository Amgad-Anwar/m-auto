jQuery(document).ready(function($) {
	// Check element exists.
	$.fn.exists = function () {
		return this.length > 0;
	};

	// Code for search filter box
	jQuery( document ).on( 'change', '.search-filters-box', function(){
		var $this = jQuery(this);
		var attributes = {};
		var taxAttrs = {};
		var total_vehicles = 0;
		var tab_condition = $this.attr('data-tid');
		var parent = $this.parents('.vehicle-search-section').addClass('parentsssss');
		var matching_vehicles = jQuery(this).parents('.cardealer-tabcontent').find('p.matching-vehicles');

		jQuery('.search-filters-box.'+tab_condition).each(function(){
			var tid      = jQuery(this).attr('data-id');
			if (tid) {

				attributes[tid] = jQuery(this).parents('.cardealer-tabcontent').find('select[data-id='+tid+']');
			}
		});

		jQuery.each( attributes, function(taxonomy, attr){
			taxAttrs[taxonomy] = jQuery(attr).val();
		});

		var paramData = {
			action: 'cdhl_get_search_attr',
			tax_data: taxAttrs,
			term_tax: $this.data('id'),
			term_value: $this.val(),
			condition: $this.parents('.cardealer-tabcontent').data('condition')
		};
		jQuery.ajax({
			url : cardealer_js.ajaxurl,
			type:'post',
			dataType:'json',
			data: paramData,
			beforeSend: function(){
				jQuery(parent).find('.filter-loader').html('<span class="filter-loader"><i class="cd-loader"></i></span>');
				jQuery(parent).find('.pagination-loader').html('<span class="pagination-loader"><i class="cd-loader"></i></span>');
				jQuery(parent).find('.search-filters-box').prop('disabled',true);
				jQuery(parent).find('.csb-submit-btn').prop('disabled',true);
			},
			success: function(response){
				if( response.status == true ){
					if( response.attr_array.length > 0 ){
						jQuery(response.attr_array).each( function(index, attr){
							jQuery(attributes[attr.taxonomy]).html(jQuery("<option />").val('').text(attr.tax_label));
							total_vehicles = attr.vehicles_matched;
							jQuery(attr.tax_terms).each( function(index, terms){
								if( index == 0 && taxAttrs[attr.taxonomy] != '' ){
									jQuery(attributes[attr.taxonomy]).append(jQuery("<option />").attr('selected','selected').val(terms.slug).text(terms.name));
								} else {
									jQuery(attributes[attr.taxonomy]).append(jQuery("<option />").val(terms.slug).text(terms.name));
								}
							});
							jQuery(attributes[attr.taxonomy]).prop('disabled',false);
							jQuery(attributes[attr.taxonomy]).niceSelect('update');
						});
						matching_vehicles.html(total_vehicles);
					}
				}
				//console.log(response);
			},
			complete: function(){
				jQuery(parent).find('.filter-loader').html('');
                jQuery(parent).find('.pagination-loader').html('');
                jQuery(parent).find('.search-filters-box').prop('disabled',false);
                jQuery(parent).find('.csb-submit-btn').prop('disabled',false);
			},
			error: function(){
				console.log('Something went wrong!');
			}
		});
	});

	if ( $( '.widget.widget-vehicle-categories select.vehicle-categories-dropdown' ).exists() ) {
		$( document ).on( 'change', '.widget.widget-vehicle-categories select.vehicle-categories-dropdown', function ( event ) {
			if ( $(this).val() != '' ) {
				window.location.href = $(this).find(':selected').data('uri');
			}
		} );
	}

	cdhl_vehicles_search();

	// video slider shortcode scripts starts
	cdhl_video_slider();

	//bind our event here, it gets the current slide and pauses the video before each slide changes.
	jQuery(".sliderMain").on("beforeChange", function(event, slick, currentSlide) {
      var slideType, player, command;
	  currentSlide = jQuery(slick.$slider).find(".slick-current");
      console.log('currentSlide :'+currentSlide);
      //determine which type of slide this, via a class on the slide container. This reads the second class, you could change this to get a data attribute or something similar if you don't want to use classes.
      slideType = currentSlide.attr("class").split(" ")[1];

      //get the iframe inside this slide.
      player = currentSlide.find("iframe").get(0);

      if (slideType == "vimeo") {
        command = {
          "method": "pause",
          "value": "true"
        };
      } else {
        command = {
          "event": "command",
          "func": "pauseVideo"
        };
      }

      //check if the player exists.
      if (player != undefined) {
        //post our command to the iframe.
        player.contentWindow.postMessage(JSON.stringify(command), "*");
      }
    });
	// video slider shortcode scripts ends

	cdhl_vehicles_conditions_tabs();
});

// Make sure you run this code under Elementor.
jQuery( window ).on( 'elementor/frontend/init', function () {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/cdhl_video-slider.default', cdhl_video_slider );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/cdhl_vehicles-conditions-tabs.default', cdhl_vehicles_conditions_tabs );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/cdhl_vehicles-search.default', cdhl_vehicles_search );
	elementorFrontend.hooks.addAction( 'frontend/element_ready/cdhl_vehicles-by-type.default', cdhl_vehicles_by_stype );
} );

function cdhl_vehicles_by_stype(){
	cdhl_vehicles_conditions_tabs();
}

// Code for search filter box
function cdhl_vehicles_search(){

	if ( jQuery( 'select.cd-select-box' ).length ) {
		jQuery( 'select.cd-select-box' ).niceSelect();
	}

	cdhl_vehicles_conditions_tabs();

	jQuery( 'select.search-filters-box' ).prop( 'selectedIndex', 0 );
	jQuery( 'select.search-filters-box' ).niceSelect( 'update' );
	jQuery( '.cardealer-tabs input.vehicle_location' ).val( '' );

	// Submit filters
	jQuery( '.vehicle-search-section form' ).each (function( index ) {
		var search_form = jQuery( this ),
			search_btn  = jQuery( search_form ).find( '.csb-submit-btn' );

		jQuery( search_btn ).on( 'click', function(){
			jQuery( search_form ).trigger( 'submit' );
		});

		jQuery( search_form ).on( 'submit', function(e){
			validated = true;
			jQuery( search_form ).find( 'input, select' ).each( function() {
				if ( jQuery( this ).val() == '' ) {
					jQuery( this ).attr( 'disabled', 'disabled' );
				}
			});
			jQuery( search_form ).attr( 'action', cars_price_slider_params.cars_form_url );
			if ( validated ) {
				jQuery( search_form ).unbind( 'submit' ).submit();
			}
		});
	});
}

function cdhl_vehicles_conditions_tabs(){
	// shortcode tabs
	if ( jQuery( '.cardealer-tabs li[data-tabs]' ).length ) {
		jQuery( '.cardealer-tabs' ).each( function() {
			var currentTabSection = jQuery( this );
			var $tabsdata         = jQuery( this ).find( 'li[data-tabs]' );
			var $tabscontent      = jQuery( this ).find( '.cardealer-tabcontent' ),

			$tabsnav = jQuery( this ).find( '.tabs li' );
			$tabsdata.on( 'click', function () {
				$tabsdata.removeClass( 'active' );
				$tabscontent.hide();
				var tab = jQuery( this ).data( 'tabs' );
				jQuery( this ).addClass( 'active' );
				jQuery( '#' + tab ).fadeIn().show();
			});
			$tabsnav.on( 'click', function () {
				var  cur = $tabsnav.index(this);
				var elm = jQuery( currentTabSection ).find( '.cardealer-tabcontent:eq(' + cur + ')' );

				elm.addClass( 'pulse' );
				setTimeout( function() {
					elm.removeClass( 'pulse' );
				}, 220 );
			});

			$tabscontent.hide().filter( ':first' ).addClass( 'test' ).show();

			jQuery( currentTabSection).find( '.tabs_wrapper' ).each( function( index ) {
				jQuery( this ).find( '.cardealer-tabcontent' ).hide().filter( ':first' ).show();
			});
			jQuery( currentTabSection ).find( '.tabs_wrapper li[data-tabs]' ).on( 'click', function () {
				var tabs_parent = jQuery( this ).closest( '.tabs_wrapper' );
				jQuery( tabs_parent ).find( 'li[data-tabs]' ).removeClass( 'active' );
				jQuery( tabs_parent ).find( '.cardealer-tabcontent' ).hide();
				var tab = jQuery( this ).data( 'tabs' );
				jQuery( this ).addClass( 'active' );
				jQuery( '#' + tab ).fadeIn().show();
			});
			jQuery( currentTabSection ).find( '.tabs li' ).click( function() {
				var cur = jQuery( this ).index( this );
				var elm = jQuery( currentTabSection ).find( '.cardealer-tabcontent:eq(' + cur + ')' );
				elm.addClass( 'pulse' );
				setTimeout( function() {
					elm.removeClass( 'pulse' );
				}, 220 );
			});
		});
	}
}

function cdhl_video_slider(){
	if ( jQuery( '.sliderMain' ).length > 0 ) {
		if ( ! jQuery( '.sliderMain' ).hasClass( 'slick-initialized' ) ) {
			jQuery( '.sliderMain' ).slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				asNavFor: '.sliderSidebar',
				autoplay: false,
				autoplaySpeed: 3000
			});
		}

		if ( ! jQuery( '.sliderSidebar' ).hasClass( 'slick-initialized' ) ) {
			jQuery( '.sliderSidebar' ).slick({
				slidesToShow: 5,
				slidesToScroll: 1,
				asNavFor: '.sliderMain',
				dots: false,
				centerMode: false,
				focusOnSelect: true,
				vertical: false,
				arrows: true,
				responsive: [{
					breakpoint: 980, // tablet breakpoint
					settings: {
						slidesToShow: 4,
						slidesToScroll: 4
					}
				},
				{
					breakpoint: 480, // mobile breakpoint
					settings: {
						slidesToShow: 3,
						slidesToScroll: 3
					}
				}]
			});
		}
	}
}
