/**
 * -----------------------------------------------------------------------------
 * (c) 2016-2021 Pine Grove Software, LLC -- All rights reserved.
 * Contact: webmaster@financial-calculators.com
 * License: GPL2
 * www.financial-calculators.com
 * -----------------------------------------------------------------------------
 * Common code and global variables.
 * -----------------------------------------------------------------------------
 * compiled at: http://closure-compiler.appspot.com/home
 */

/* required for JSLint processing */
/*global wp: false */
/*jslint nomen: true, vars: true, sub: true */


/** 
 * @preserve Copyright 2016-2022 Pine Grove Software, LLC
 * financial-calculators.com
 * License: GPL2
 * strs.LOAN-WIDGET.gpl.js
 */

// eslint-disable-next-line no-unused-vars
var FC$ = {}; 


/** 
 * @nocollapse
 * @return {Object}
 */
FC$ = (function (FC) {
	'use strict';

	// var FC = {};

	// const {__, _x, _n, sprintf} = wp.i18n;

	FC.strs = {
		// TRANSLATORS: ISO's language code en=English
		s000: wp.i18n.__('en', 'fc-loan-calculator'),
		s001: wp.i18n.__('Please use the backspace key to delete.', 'fc-loan-calculator'),
		s002: wp.i18n.__('Left, up & down arrow keys are disabled. So are the home, end, pgup and pgdn keys.', 'fc-loan-calculator'),
		s003: wp.i18n.__('Use backspace to delete.', 'fc-loan-calculator'),
		s004: wp.i18n.__('If value is selected, just start typing new value to clear prior value.', 'fc-loan-calculator'),
		s005: wp.i18n.__('When a number is selected (value shown in inverse), use right arrow key to clear selection without clearing value. Then backspace to edit.', 'fc-loan-calculator'),
		s006: wp.i18n.__('TIP: Generally it is best to use the TAB or SHIFT-TAB keys to move from one input to the next or previous input.', 'fc-loan-calculator'),
		s007: wp.i18n.__('TIP 2: Generally, editing a value is inefficient. Since values are auto selected, just type the number you want.', 'fc-loan-calculator'),
		s008: wp.i18n.__('Do not type the thousand separator character.', 'fc-loan-calculator'),
		s009: wp.i18n.__('(If using US convention, that would be the comma.)', 'fc-loan-calculator'),
		s010: wp.i18n.__('I\'m smart enough to enter them for you!', 'fc-loan-calculator'),
		s011: wp.i18n.__('An unknown date calculation error occurred.', 'fc-loan-calculator'),
		s012: wp.i18n.__('Please provide us with your inputs and settings so that we can fix this. Thank you.', 'fc-loan-calculator'),
		s013: wp.i18n.__('Date is not valid - bad year.', 'fc-loan-calculator'),
		s014: wp.i18n.__('Jan', 'fc-loan-calculator'),
		s015: wp.i18n.__('Feb', 'fc-loan-calculator'),
		s016: wp.i18n.__('Mar', 'fc-loan-calculator'),
		s017: wp.i18n.__('Apr', 'fc-loan-calculator'),
		s018: wp.i18n.__('May', 'fc-loan-calculator'),
		s019: wp.i18n.__('Jun', 'fc-loan-calculator'),
		s020: wp.i18n.__('Jul', 'fc-loan-calculator'),
		s021: wp.i18n.__('Aug', 'fc-loan-calculator'),
		s022: wp.i18n.__('Sept', 'fc-loan-calculator'),
		s023: wp.i18n.__('Oct', 'fc-loan-calculator'),
		s024: wp.i18n.__('Nov', 'fc-loan-calculator'),
		s025: wp.i18n.__('Dec', 'fc-loan-calculator'),
		s026: wp.i18n.__('Error: dates out of sequence.', 'fc-loan-calculator'),
		s027: wp.i18n.__('Exception', 'fc-loan-calculator'),
		s028: wp.i18n.__('occurred when accessing', 'fc-loan-calculator'),
		s029: wp.i18n.__('Invalid index', 'fc-loan-calculator'),
		// from eq.LOAN-WIDGET.gpl.js
		s100: wp.i18n.__('Internal limit reached. Balance exceeds +/- 99 trillion.', 'fc-loan-calculator'),
		s101: wp.i18n.__('YTD', 'fc-loan-calculator'),
		s102: wp.i18n.__('Running Totals', 'fc-loan-calculator'),
		s103: wp.i18n.__('Normal', 'fc-loan-calculator'),
		// from sc.AUTOLOAN-WIDGET.gpl.js
		s201: wp.i18n.__('Your Personalized Loan Schedule', 'fc-loan-calculator'),
		s202: wp.i18n.__('Last payment amount decreased by', 'fc-loan-calculator'),
		s203: wp.i18n.__('due to rounding', 'fc-loan-calculator'),
		s204: wp.i18n.__('Last payment amount increased by', 'fc-loan-calculator'),
		s205: wp.i18n.__('Loan Summary', 'fc-loan-calculator'),
		// s206: wp.i18n.__('Car Price', 'fc-loan-calculator'),
		// s207: wp.i18n.__('Down Payment', 'fc-loan-calculator'),
		s208: wp.i18n.__('Loan Amount', 'fc-loan-calculator'),
		s209: wp.i18n.__('Number of Payments', 'fc-loan-calculator'),
		s210: wp.i18n.__('Annual Interest Rate', 'fc-loan-calculator'),
		s211: wp.i18n.__('Periodic Payment', 'fc-loan-calculator'),
		s212: wp.i18n.__('Loan Date', 'fc-loan-calculator'),
		s213: wp.i18n.__('1st Payment Due', 'fc-loan-calculator'),
		s214: wp.i18n.__('Payment Frequency', 'fc-loan-calculator'),
		s215: wp.i18n.__('Last Payment Due', 'fc-loan-calculator'),
		s216: wp.i18n.__('Total Interest Due', 'fc-loan-calculator'),
		s217: wp.i18n.__('Total All Payments', 'fc-loan-calculator'),
		s218: wp.i18n.__('Payment Schedule', 'fc-loan-calculator'),
		s219: wp.i18n.__('Year', 'fc-loan-calculator'),
		s220: wp.i18n.__('Date', 'fc-loan-calculator'),
		s221: wp.i18n.__('Payment', 'fc-loan-calculator'),
		s222: wp.i18n.__('Interest', 'fc-loan-calculator'),
		s223: wp.i18n.__('Principal', 'fc-loan-calculator'),
		s224: wp.i18n.__('Balance', 'fc-loan-calculator'),
		s225: wp.i18n.__('Calculation method: Normal', 'fc-loan-calculator'),
		s226: wp.i18n.__('Total Principal', 'fc-loan-calculator'),
		s227: wp.i18n.__('Total Interest', 'fc-loan-calculator'),
		s228: wp.i18n.__('Pct. of Total Payments', 'fc-loan-calculator'),
		s229: wp.i18n.__('Annual Principal and Interest Totals', 'fc-loan-calculator'),
		s230: wp.i18n.__('Accumulated Principal and Interest with Remaining Balance', 'fc-loan-calculator'),
		s231: wp.i18n.__('Total Principal and Interest', 'fc-loan-calculator'),
		s232: wp.i18n.__('Loan', 'fc-loan-calculator'),
		// interface.SHARED-WIDGET.gpl.js has no strings
		// interface.LOAN-WIDGET.gpl.js
		// s401: wp.i18n.__('One of the following: "Price", "Down Payment" or "Loan Amount" must be "0".', 'fc-loan-calculator'),
		// s402: wp.i18n.__('You may use our general purpose loan calculator if you don\'t want to consider purchase price.', 'fc-loan-calculator'),
		// s403: wp.i18n.__('Only one of the following: "Price", "Down Payment" or "Loan Amount" can be "0".', 'fc-loan-calculator'),
		// s404: wp.i18n.__('You may use our general purpose loan calculator if you don\'t want to consider purchase price.', 'fc-loan-calculator'),
		s405: wp.i18n.__('There are too many unknown values.', 'fc-loan-calculator'),
		s406: wp.i18n.__('Only one value may be "0."', 'fc-loan-calculator'),
		s407: wp.i18n.__('Enter "Loan Amount", "Number of Payments" and "Annual Interest Rate".', 'fc-loan-calculator')

	};


	return FC;
}(FC$));
