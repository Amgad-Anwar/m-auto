
/*global Cookies: false */
/*jslint vars: true */


/** 
* @preserve Copyright 2016-2022 Pine Grove Software, LLC
* financial-calculators.com
* pine-grove.com
* interface.LOAN-WIDGET.gpl.js
*/
(function ($, FC) {
	'use strict';

	// don't try to initialize the wrong calculator
	if (!document.getElementById('loan-plugin')) {
		return;
	}

	var obj = {}, // interface object to base equations
		// schedule,

		// gui controls
		pvInput,
		numPmtsInput,
		rateInput;

	/**
	* init() -- init or reset GUI's values
	*/
	function initGUI() {
		// main window

		pvInput.setValue(pvInput.getUSNumber());
		numPmtsInput.setValue(numPmtsInput.getUSNumber());
		rateInput.setValue(rateInput.getUSNumber());
		document.getElementById('selPmtMthd-ln').value = FC.pmt_method;  // PMT_MTHD.ARREARS;

		document.getElementById('edPmt-ln').value = FC.formatLocalFloat(0.0, FC.moneyConventions, 2);
		document.getElementById('edInterest-ln').value = FC.formatLocalFloat(0.0, FC.moneyConventions, 2);
		document.getElementById('edTotalPI-ln').value = FC.formatLocalFloat(0.0, FC.moneyConventions, 2);

	} // initGUI



	/**
	* clearGUI() -- reset GUI's values
	*/
	function clearGUI() {
		// main window
		pvInput.setValue(0.0);
		numPmtsInput.setValue(0);
		rateInput.setValue(0.0);
		document.getElementById('selPmtMthd-ln').value = FC.pmt_method;  //PMT_MTHD.ARREARS;

		document.getElementById('edPmt-ln').value = FC.formatLocalFloat(0.0, FC.moneyConventions, 2);
		document.getElementById('edInterest-ln').value = FC.formatLocalFloat(0.0, FC.moneyConventions, 2);
		document.getElementById('edTotalPI-ln').value = FC.formatLocalFloat(0.0, FC.moneyConventions, 2);

	} // clearGUI


	/**
	* getInputs() -- get user inputs and initialize obj equation interface object
	*/
	function getInputs() {
		var selPmtMthd;

		obj = new FC.fin_params();

		obj.pv = pvInput.getUSNumber();

		obj.n = numPmtsInput.getUSNumber();

		obj.nominalRate = rateInput.getUSNumber() / 100;

		obj.cf = 0;

		// cash flow's payment frequency
		obj.pmtFreq = FC.pmt_frequency;

		// cash flow's compound frequency
		obj.cmpFreq = FC.pmt_frequency;

		selPmtMthd = document.getElementById('selPmtMthd-ln');
		obj.pmtMthd = parseInt(selPmtMthd.value, 10);
		obj.amortMthd = 0; // normal

	} // getInputs()


	/** 
	* calc() -- initialize CashInputs data structures for equation classes
	*/
	function calc() {
		var totPI, totI, schedule;

		if (obj.pv === 0 || obj.n === 0 || obj.nominalRate === 0) {
			// alert('There are too many unknown values.\n\nEnter "Loan Amount", "Number of Payments"\nand "Annual Interest Rate".');
			alert(FC.strs.s405 + '\n\n' + FC.s407);
			return null;
		}

		if (obj.cf === 0) {
			obj.cf = FC.roundMoney(FC.CF.calc(obj));
			if (obj.cf !== Infinity) {
				document.getElementById('edPmt-ln').value = FC.formatLocalFloat(-obj.cf, FC.moneyConventions, 2);
			} else {
				obj.cf = 0;
			}
		}

		schedule = FC.LOAN_SCHEDULE.calc(obj);

		if (schedule !== null) {
			totPI = schedule[schedule.length - 1][5];
			totI = schedule[schedule.length - 1][8];

			// results to GUI
			if (obj.cf !== 0) {
				document.getElementById('edInterest-ln').value = FC.formatLocalFloat(totI, FC.moneyConventions, 2);
				document.getElementById('edTotalPI-ln').value = FC.formatLocalFloat(totPI, FC.moneyConventions, 2);
			}
		}
		return schedule;


	} // function calc()



	/**
	* Initialize modal dialogs
	*/


	//
	//	End initialize modal dialogs
	//


	$(document).ready(function () {


		// If user has a ccy_format cookie, use its value first
		// otherwise if website set default currency use it
		// otherwise use currency determined by user's locale - previously initialized
		var currency = parseInt(document.getElementById('currency-ln').value, 10);

		if (Cookies.get('ccy_format')) {
			FC.updateNumConventions(parseInt(Cookies.get('ccy_format'), 10));
			// GUI.moneyConventions = new GUI.LocalConventions(parseInt(Cookies.get('ccy_format'), 10));
			// // clones moneyConventions and sets ccy_r = '%'
			// GUI.rateConventions = GUI.moneyConventions.rateConvention(); // clones currency conventions with'%' symbol
			// GUI.numConventions = GUI.moneyConventions.numConvention(); // clones currency conventions without currency
		} else if (currency !== undefined && currency !== null && typeof currency === 'number' && currency !== 999) {
			FC.updateNumConventions(currency);
		}

		// If user has a date_format cookie, use its value first
		// otherwise if website set default date_mask use it
		// otherwise use date_mask determined by user's locale - previously initialized
		var date_mask = parseInt(document.getElementById('date_mask-ln').value, 10);

		if (Cookies.get('date_format')) {
			FC.dateConventions = new FC.LocalDateConventions(parseInt(Cookies.get('date_format'), 10));
		} else if (date_mask !== undefined && date_mask !== null && typeof date_mask === 'number' && date_mask !== 999) {
			FC.updateDateConventions(date_mask);
		}

		//
		// initialize GUI controls & dialog / modal controls here
		// attach
		//
		// only required on the financial-calculators.com site
		// here for each comment reply link of WordPress
		// $('.comment-reply-link').addClass('btn btn-primary');

		// here for the submit button of the comment reply form
		// $('#submit').addClass('btn btn-primary');

		// Style contact form submit button
		// $('.wpcf7-submit').addClass('btn btn-primary');

		// Add thumbnail styling
		// $('.wp-caption').addClass('thumbnail');

		// Now we'll add some classes for the WordPress default widgets - let's go
		// Add Bootstrap style for drop-downs
		// $('.postform').addClass('form-control');
		// end: only required on the financial-calculators.com site


		// main window
		pvInput = new FC.NE('edPV-ln', FC.moneyConventions, 2);

		numPmtsInput = new FC.NE('edNumPmts-ln', FC.numConventions, 0);

		rateInput = new FC.NE('edRate-ln', FC.rateConventions, 4);

		initGUI();

		$('#btnCalc-ln').click(function () {
			getInputs();
			calc();
		});


		$('#btnClear-ln').click(function () {
			clearGUI();  // clear and reset GUI's values
		});


		$('#btnPrint-ln').click(function () {
			//console.log("print");
			getInputs();
			calc();
			FC.print_calc();
		});


		$('#btnHelp-ln').click(function () {
			FC.show_help('#hText-ln');
		});


		$('#btnSchedule-ln').click(function () {
			var schedule;

			FC.summary.cashFlowType = 0; // loan
			getInputs();
			schedule = calc();
			FC.showLoanSchedule(FC.LOAN_SCHEDULE.calc(obj, schedule));

		});


		$('#btnCharts-ln').click(function () {
			var schedule;

			FC.summary.cashFlowType = 0; // loan
			getInputs();

			schedule = calc();
			FC.showLoanCharts(FC.LOAN_SCHEDULE.calc(obj, schedule));
		});


		$('#CCY-ln').click(function () {
			FC.init_CURRENCYDATE_Dlg();
		}); // '#btnCcyDate

	}); // $(document).ready

}(jQuery, FC$));





