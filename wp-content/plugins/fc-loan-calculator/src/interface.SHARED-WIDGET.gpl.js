
/*jslint vars: true */


/** 
* @preserve Copyright 2016-2022 Pine Grove Software, LLC
* financial-calculators.com
* interface.SHARED.js
*/


/** 
* @const 
* @nocollapse
*/
FC$ = (function ($, SC) {
	'use strict';

	// object wrappers to expose shared constants, variables & routines
	/** @const */
	var FC = SC || {};


	// add generic class for styling specificity for calcultor's modal fade in / fade out on body
	$(document.body).addClass('fc-calculator');


	// [KT] 12/31/2016 - initialize help text, already defined in HTML
	// $('#hShow').addClass("init");

	// [KT] 01/01/2017 - modal must be appended to body tag for z-index to work with background
	$('#fc-modals').appendTo('body');

	/**
	* Lightbox help event handler.
	*/
	FC.show_help = function (helpDiv) {
		$.featherlight(helpDiv, {beforeOpen: function () {
			$('body').css({'overflow-y': 'hidden'}); 
		},
		afterClose: function () {
			$('body').css({'overflow-y': 'scroll'}); 
		}});
		$('.featherlight-content').css('overflow-y', 'auto');
	};


	/**
	* Scale a calculator - with limits
	*/
	var updateZoom = function (zoom) {

		if (zoom === undefined || zoom === null) {
			FC.zoomLevel = 1;
		} else {
			FC.zoomLevel = (FC.zoomLevel + zoom > 0.50 && FC.zoomLevel + zoom < 1.50) ? FC.zoomLevel + zoom : FC.zoomLevel;
		}

		$('.calc-wrap').css({
			//transform-origin: top left,
			//zoom: zoomLevel,
			'-webkit-transform': 'scale(' + FC.zoomLevel + ')',
			'-moz-transform': 'scale(' + FC.zoomLevel + ')',
			'-ms-transform': 'scale(' + FC.zoomLevel + ')',
			'-o-transform': 'scale(' + FC.zoomLevel + ')',
			'transform': 'scale(' + FC.zoomLevel + ')'
		});
	}; // updateZoom = function (zoom)


	$('#grow-al, #grow-ln, #grow-mtg, #grow-ra, #grow-ne, #grow-rs, #grow-sv').click(function () {
		updateZoom(0.1);
	});

	$('#shrink-al, #shrink-ln, #shrink-mtg, #shrink-ra, #shrink-ne, #shrink-rs, #shrink-sv').click(function () {
		updateZoom(-0.1);
	});

	$('#original-al, #original-ln, #original-mtg, #original-ra, #original-ne, #original-rs, #original-sv').click(function () {
		updateZoom(); // no parameter - resets to original size
	});


	//
	// modal event handlers
	//

	/**
	* initialize CURRENCYDATE -- currency / date dialog
	*/
	FC.init_CURRENCYDATE_Dlg = function () {

		// document.getElementById('ccy-select').value=50;
		document.getElementById('ccy-select').value = FC.moneyConventions.ccy_format;
		document.getElementById('date-select').value = FC.dateConventions.date_format;

		$('#CURRENCYDATE').modal();

	}; // init_CURRENCYDATE_Dlg 


	$('#CURRENCYDATE_save').click(function (e) {
		e.preventDefault();

		// must pass numeric value - saves value to cookie
		FC.resetNumConventions(parseInt(document.getElementById('ccy-select').value, 10));
		FC.resetDateConventions(parseInt(document.getElementById('date-select').value, 10));

		// force page reload
		// http://stackoverflow.com/questions/3715047/how-to-reload-a-page-using-javascript

		window.location.reload(false);

	}); // #CURRENCYDATE_save


	// initialize Bootstrap tooltips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

	// https://stackoverflow.com/questions/41602487/bootstrap-tooltip-in-wrong-position-on-initial-hover-then-in-correct-position
	// $(function(){
	// 	$('[data-toggle="tooltip"]').tooltip({
	// 	 container: 'body'
	// 	});
	//   });
	// {
	// 	container: 'body',
	// 	// boundary: 'viewport'
	// }

	// resolves a focus() event problem on iOS devices
	$('input').focus(function () {
		// [KT] 06/11/2016 - added check for checkbox, radio, is a check for "button" type needed?
		if (this.type === 'checkbox' || this.type === 'radio') {
			return false; 
		} 
		this.setSelectionRange(0, 999); 
		return false; 
	}).mouseup(function () { 
		return false; 
	});


	if (document.getElementById('pop-up-help')) {
		$('#pop-up-help').addClass('pop-up');
	}

	//	$(document).ready(function () {
	//		// [KT] 01/01/2017 - modal must be appended to body tag for z-index to work with background
	//		$("#fc-modals").appendTo("body");
	//	}); // $(document).ready

	return FC;

}(jQuery, FC$));

