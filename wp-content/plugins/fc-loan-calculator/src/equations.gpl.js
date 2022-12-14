/* required for JSLint processing */
/*global alert: false, LIB$: false*/

/*jslint sub: true, vars: true, nomen: true*/


/** 
* @preserve Copyright 2016 Pine Grove Software, LLC
* financial-calculators.com
* pine-grove.com
* equations.js
*/

/** @const */
var EQ$ = (function (LIB) {
	'use strict';

	var EQ = LIB || {},
		periodType = LIB.INITIAL_PERIOD_TYPE.REGULAR,
		// if a regular length 1st period or true if cash flow at beginning of period
		isRegular,
		// interest rate cannot be changed, thus rate vars are here.
		periodicRate,
		periodLen,
		schedule1 = [],
		DECEM = 12, // december, NOT 0 based. 1..12

		// index (columns) values for 2 dimensional schedule array
		EVENT_DATE = 0, // YYYYMMDD, used for sorting
		LOAN_NO = 1,
		ROW_TYPE = 2,
		PER_STR = 3,
		DATE_STR = 4,
		CF = 5, // cash flow
		CREDIT = 6,
		DEBIT = 7,
		INT = 8,
		PRIN = 9,
		NET = 10, // net change
		BAL = 11,
		MONTH = 12,
		YEAR = 13;


	/** @nocollapse */
	EQ.roundingMethod = 0; // payment

	// local amortization methods
	EQ.AMORT_MTHD_EXT = {NORMAL: 0};

	EQ.AMORT_MTHD_STRS_EXT = ['Normal'];

	EQ.schedule = {
		schedule1: 1
	};

	/**
	* details about current cash flow
	* exported values for schedule & charts
	*/
	EQ.summary = {
		cf: [], // cash flow amount, payment, deposit etc
		firstDebitDateStr: "",
		firstCreditDateStr: "",
		lastDebitDateStr: [],
		lastCreditDateStr: [],
		totalNDebits: [],
		totalNCredits: [],
		totalInterest: [],
		totalPmts: [],
		nominalRate: [],
		NYears: 0,
		pointsPct: 0,
		pointsMoney: 0,
		amortMthd: 0,
		DIY: 0,
		unadjustedBalance: 0,
		roundingMethod: EQ.roundingMethod,
		cashFlowType: 0, // loan
		xPmtTotal: 0
	};



	/**
	* Parameter object to initialize all financial equations
	* @constructor
	* @param {Object=} obj (optional)
	*/
	EQ.fin_params = function (obj) {
		var o = obj || {};
		this.nominalRate = (o.nominalRate !== undefined) ? o.nominalRate : null;
		this.n = o.n || null; // number of cash flows
		this.cf = o.cf || 0.0; // cash flow / pmt amount
		this.pv = o.pv || 0.0;
		this.fv = o.fv || 0.0;
		this.pmtMthd = (o.pmtMthd !== undefined) ? o.pmtMthd : null; // Excel's "type" advance = 0 / arrears = 1
		this.amortMthd = (o.amortMthd !== undefined) ? o.amortMthd : EQ.AMORT_MTHD_EXT.NORMAL;
		this.oDate = o.oDate || new Date(0); // uninitialized origination date obj
		this.fDate = o.fDate || new Date(0); // first cash flow date
		this.lDate = o.lDate || new Date(0); // last cash flow date
	};

	// clone the initialization object
	EQ.fin_params.prototype.clone = function () {
		var o = {
			nominalRate: this.nominalRate,
			n: this.n,
			cf: this.cf,
			pv: this.pv,
			fv: this.fv,
			pmtFreq: this.pmtFreq,
			cmpFreq: this.cmpFreq,
			daysPerYear: this.daysPerYear,
			pmtMthd: this.pmtMthd,
			amortMthd: this.amortMthd,
			oDate: new Date(this.oDate.valueOf()),
			fDate: new Date(this.fDate.valueOf()),
			lDate: new Date(this.lDate.valueOf())
		};
		return new EQ.fin_params(o);
	};


	/**
	* initFirstPeriod()
	* @param {Object} obj (required)
	*/
	function initFirstPeriod(obj) {
		var periods = 0;
		periodType = LIB.INITIAL_PERIOD_TYPE.REGULAR;
		if (obj.oDate.valueOf() !== obj.fDate.valueOf()) {
			periods = 1;
		}
		return periods;
	} // initFirstPeriod(obj)


	/**
	* calcRates(obj)
	* periodic rate is nominalRate / periods per year
	* @param {Object} obj (required)
	*/
	function calcRates(obj) {
		periodicRate = obj.nominalRate / LIB.PPY[obj.cmpFreq];
		return periodicRate;
	}


	/**
	* calcInt_periodicRate
	* calculate interest on an amount (pv) for X periods
	*/
	function calcInt_periodicRate(pv, periods) {
		var s, fv;
		fv = pv;
		if (periodicRate !== 0) {
			// regular periods of the cash flow from fDate
			s = Math.pow(1 + periodicRate, periods);
			fv = fv * s; // * (s - 1.0) * (1.0 + periodicRate) / periodicRate; // note negative result

		}
		return fv - pv; // interest

	} // calcInt_periodicRate


	/**
	* isValid(obj)
	* Validate the inputs common to all equations
	* @param {Object} obj (required)
	*/
	function isValid(obj) {

		// set default dates
		// start date default to 1st of next month
		if (obj.oDate.valueOf() === 0) {
			obj.oDate.setTime(LIB.dateMath.getFirstNextMonth(new Date()));
		}

		// if first cash flow date not initialized then set 1 pmtFreq unit after start date
		if (obj.pmtMthd === LIB.pmt_method) {
			obj.fDate.setTime(LIB.dateMath.addPeriods(obj.oDate, 1));
		} else {
			obj.fDate.setTime(obj.oDate.getTime());
		}
		return true;
	}



	/**
	* Calc cash flow amount - loan payment
	* Cash flow amounts will not change
	* Interest rate will not change
	*/
	EQ.CF = {

		/**
		* EQ.CF.calc()
		* Validates the user inputs
		* Calculates an optimized / level cash flow amount
		* @param {Object} obj (required)
		*/
		calc: function (obj) {
			var r, s, cf;
			// classic loan payment formula : http://www.financeformulas.net/Loan_Payment_Formula.html
			r = calcRates(obj);
			if (obj.pmtMthd === EQ.pmt_method) {
				cf = r * obj.pv;
				cf = -(cf / (1 - Math.pow(1 + r, -obj.n)));
			} else {
				s = 1 + r;
				cf = (1 - Math.pow(s, -obj.n + 1)) / r;
				cf = -(obj.pv / (cf + 1));
			}

			return cf;
		} // calc: function (obj)

	};  // EQ.CF


////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////// END EQUATIONS - BUILD SCHEDULE ARRAY
////////////////////////////////////////////////////////////////////////////////////////


	/**
	* insertSubTotals()
	* Insert subtotals into schedule based on declared fiscal year end
	* Last month of year, i.e. before total rows 1..12
	*/
	function insertSubTotals(schedule, whichSchedule) {
		var i, ytdCF = 0.0, ytdCredit = 0.0, ytdDebit = 0.0, ytdInterest = 0.0, ytdPrincipal = 0.0, ytdNetChange = 0.0, ytdXPmt = 0.0, runningCF = 0.0, runningCredit = 0.0, runningDebit = 0.0, runningInterest = 0.0, runningPrincipal = 0.0, runningNetChange = 0.0, runningXPmt = 0.0, totals = [];

		if (whichSchedule === undefined || whichSchedule === null) {
			whichSchedule = LIB.schedule.schedule1;
		}

		i = 0;
		do {

			i += 1; // totals can only be inserted after array row 1
			
			// this test may be needed
			// if (schedule[i - 1][ROW_TYPE] === 1) {
			// note, pick up values from last row after loop exit
			ytdCF = LIB.roundMoney(schedule[i - 1][CF] + ytdCF);
			ytdCredit = LIB.roundMoney(schedule[i - 1][CREDIT] + ytdCredit);
			ytdDebit = LIB.roundMoney(schedule[i - 1][DEBIT] + ytdDebit);
			ytdInterest = LIB.roundMoney(schedule[i - 1][INT] + ytdInterest);
			ytdPrincipal = LIB.roundMoney(schedule[i - 1][PRIN] + ytdPrincipal);
			//ytdXPmt = LIB.roundMoney(schedule[i - 1][PRIN] + ytdXPmt);
			ytdNetChange = LIB.roundMoney(schedule[i - 1][NET] + ytdNetChange);
			runningCF = LIB.roundMoney(schedule[i - 1][CF] + runningCF);
			runningCredit = LIB.roundMoney(schedule[i - 1][CREDIT] + runningCredit);
			runningDebit = LIB.roundMoney(schedule[i - 1][DEBIT] + runningDebit);
			runningInterest = LIB.roundMoney(schedule[i - 1][INT] + runningInterest);
			runningPrincipal = LIB.roundMoney(schedule[i - 1][PRIN] + runningPrincipal);
			//runningXPmt = LIB.roundMoney(schedule[i - 1][PRIN] + runningXPmt);
			runningNetChange = LIB.roundMoney(schedule[i - 1][NET] + runningNetChange);
			if (schedule[i - 1][PER_STR].toUpperCase() === 'XPMT') {
				ytdXPmt = LIB.roundMoney(schedule[i - 1][PRIN] + ytdXPmt);
				runningXPmt = LIB.roundMoney(schedule[i - 1][PRIN] + runningXPmt);
			}

			// one test for when consecutive cash flows are in different calendar year and another test when cash flows are in same calendar year
			if (((schedule[i - 1][YEAR] !== schedule[i][YEAR] && (schedule[i - 1][MONTH] <= DECEM || schedule[i][MONTH] > DECEM))) || ((schedule[i - 1][YEAR] === schedule[i][YEAR] && (schedule[i - 1][MONTH] <= DECEM && DECEM < schedule[i][MONTH])))) {

				// insert the 2 total rows into schedule at fiscal year end
				totals = [];
				totals[EVENT_DATE] = schedule[i - 1][EVENT_DATE];
				totals[EVENT_DATE] = totals[EVENT_DATE].substr(0, totals[EVENT_DATE].length - 3) + '-99';
				totals[LOAN_NO] = whichSchedule;
				totals[ROW_TYPE] = LIB.ROW_TYPES.ANNUAL_TOTALS; // YTD total row marker
				totals[PER_STR] = schedule[i - 1][YEAR] + ' YTD:';
				totals[DATE_STR] = null;
				totals[CF] = ytdCF;
				totals[CREDIT] = ytdCredit;
				totals[DEBIT] = ytdDebit;
				totals[INT] = ytdInterest;
				totals[NET] = ytdNetChange;
				totals[PRIN] = ytdPrincipal;
				totals[BAL] = null;
				totals[MONTH] = DECEM; // schedule[i - 1][MONTH];
				totals[YEAR] = schedule[i - 1][YEAR];

				// reset year-to-date
				ytdCF = 0;
				ytdCredit = 0.0;
				ytdDebit = 0.0;
				ytdInterest = 0.0; // schedule[0][INT];
				ytdPrincipal = 0.0;
				ytdNetChange = 0.0;
				ytdXPmt = 0.0;

				schedule.splice(i, 0, totals);
				i += 1; // increment for row just insert

				totals = [];
				totals[EVENT_DATE] = schedule[i - 1][EVENT_DATE];
				totals[EVENT_DATE] = totals[EVENT_DATE].substr(0, totals[EVENT_DATE].length - 3) + '-99';
				totals[LOAN_NO] = whichSchedule;
				totals[ROW_TYPE] = LIB.ROW_TYPES.RUNNING_TOTALS; // running total row marker
				totals[PER_STR] = 'Running Totals:';
				totals[DATE_STR] = null;
				totals[CF] = runningCF;
				totals[CREDIT] = runningCredit;
				totals[DEBIT] = runningDebit;
				totals[INT] = runningInterest;
				totals[NET] = runningNetChange;
				totals[PRIN] = runningPrincipal;
				totals[BAL] = null;
				totals[MONTH] = DECEM; // schedule[i - 1][MONTH];
				totals[YEAR] = schedule[i - 1][YEAR];

				schedule.splice(i, 0, totals);
				i += 1; // increment for row just insert
			}
		} while (i < schedule.length - 1);

		if (schedule[schedule.length - 1][ROW_TYPE] !== LIB.ROW_TYPES.RUNNING_TOTALS) {
			// pick up the values from the last row
			ytdCF = LIB.roundMoney(schedule[schedule.length - 1][CF] + ytdCF);
			ytdCredit = LIB.roundMoney(schedule[schedule.length - 1][CREDIT] + ytdCredit);
			ytdDebit = LIB.roundMoney(schedule[schedule.length - 1][DEBIT] + ytdDebit);
			ytdInterest = LIB.roundMoney(schedule[schedule.length - 1][INT] + ytdInterest);
			ytdPrincipal = LIB.roundMoney(schedule[schedule.length - 1][PRIN] + ytdPrincipal);
			ytdNetChange = LIB.roundMoney(schedule[schedule.length - 1][NET] + ytdNetChange);
			runningCF = LIB.roundMoney(schedule[schedule.length - 1][CF] + runningCF);
			runningCredit = LIB.roundMoney(schedule[schedule.length - 1][CREDIT] + runningCredit);
			runningDebit = LIB.roundMoney(schedule[schedule.length - 1][DEBIT] + runningDebit);
			runningInterest = LIB.roundMoney(schedule[schedule.length - 1][INT] + runningInterest);
			runningPrincipal = LIB.roundMoney(schedule[schedule.length - 1][PRIN] + runningPrincipal);
			runningNetChange = LIB.roundMoney(schedule[schedule.length - 1][NET] + runningNetChange);
			if (schedule[schedule.length - 1][PER_STR].toUpperCase() === 'XPMT') {
				ytdXPmt = LIB.roundMoney(schedule[schedule.length - 1][PRIN] + ytdXPmt);
				runningXPmt = LIB.roundMoney(schedule[schedule.length - 1][PRIN] + runningXPmt);
			}

			// add final set of total rows
			totals = [];
			totals[EVENT_DATE] = schedule[i][EVENT_DATE];
			totals[EVENT_DATE] = totals[EVENT_DATE].substr(0, totals[EVENT_DATE].length - 3) + '-99';
			totals[LOAN_NO] = whichSchedule;
			totals[ROW_TYPE] = LIB.ROW_TYPES.ANNUAL_TOTALS; // YTD total row marker
			totals[PER_STR] = schedule[schedule.length - 1][YEAR] + ' YTD:';
			totals[DATE_STR] = null;
			totals[CF] = ytdCF;
			totals[CREDIT] = ytdCredit;
			totals[DEBIT] = ytdDebit;
			totals[INT] = ytdInterest;
			totals[PRIN] = ytdPrincipal;
			totals[NET] = ytdNetChange;
			totals[BAL] = null;
			totals[MONTH] = DECEM; // schedule[schedule.length - 1][MONTH];
			totals[YEAR] = schedule[schedule.length - 1][YEAR];
			schedule.push(totals);

			totals = [];
			totals[EVENT_DATE] = schedule[i][EVENT_DATE];
			totals[EVENT_DATE] = totals[EVENT_DATE].substr(0, totals[EVENT_DATE].length - 3) + '-99';
			totals[LOAN_NO] = whichSchedule;
			totals[ROW_TYPE] = LIB.ROW_TYPES.RUNNING_TOTALS; // running total row marker
			totals[PER_STR] = 'Running Totals:';
			totals[DATE_STR] = null;
			totals[CF] = runningCF;
			totals[CREDIT] = runningCredit;
			totals[DEBIT] = runningDebit;
			totals[INT] = runningInterest;
			totals[PRIN] = runningPrincipal;
			totals[NET] = runningNetChange;
			totals[BAL] = null;
			totals[MONTH] = DECEM; // schedule[schedule.length - 1][MONTH];
			totals[YEAR] = schedule[schedule.length - 1][YEAR];
			schedule.push(totals);
		}

		EQ.summary.totalInterest[whichSchedule] = runningInterest;
		EQ.summary.totalPmts[whichSchedule] = runningCF;
		return null;

	} // insertSubTotals()



	/**
	* initLoanScheduleArray()
	* @param {Object} obj (required)
	*/
	function initLoanScheduleArray(obj) {
		var L, balance, pmt, deposit, withdrawal, scheduledDateStr, sortDateStr, periodYearString, periods, nDays, nYears = 1, interestAccrued = 0, principalPaid = 0, fixedPrincipal = 0.0, trans = [], priorDate = new Date(0), transDate = new Date(0), intDenom = 0.0, totalInterestDue = 0.0, runningInterest = 0.0, schedule = [];

		var whichSchedule = LIB.schedule.schedule1;

		if (isValid(obj)) {
			EQ.summary.nominalRate[whichSchedule] = obj.nominalRate;
			EQ.summary.pmtFreq = obj.pmtFreq;
			EQ.summary.cmpFreq = obj.cmpFreq;
			EQ.summary.amortMthd = obj.amortMthd;
			calcRates(obj);

			// Assume regular length.
			periods = initFirstPeriod(obj);

			pmt = 0; // no payment with origination row, but first payment may be same date, however, in next schedule row

			balance = obj.pv;
			deposit = balance;
			withdrawal = null;

			// process origination
			priorDate.setTime(obj.oDate.getTime());
			scheduledDateStr = LIB.dateMath.dateToDateStr(priorDate, LIB.dateConventions);
			EQ.summary.firstDebitDateStr = scheduledDateStr;
			sortDateStr = LIB.dateMath.dateToDateStr(priorDate, LIB.sortConventions);
			L = 0;
			periodYearString = L + ':' + nYears;

			schedule.push([sortDateStr, whichSchedule, LIB.ROW_TYPES.DETAIL, periodYearString, scheduledDateStr, pmt, deposit, withdrawal, interestAccrued, principalPaid, null, balance, priorDate.getMonth() + 1, priorDate.getFullYear(), priorDate, priorDate.valueOf()]);

			// process 1st cash flow as special case...may not be regular length period
			L = 1;
			periodYearString = L + ':' + nYears;
			pmt = -obj.cf; // payments are passed as debits, i.e. negative
			transDate.setTime(obj.fDate.getTime());
			scheduledDateStr = LIB.dateMath.dateToDateStr(transDate, LIB.dateConventions);
			EQ.summary.firstCreditDateStr = scheduledDateStr;
			sortDateStr = LIB.dateMath.dateToDateStr(transDate, LIB.sortConventions);

			withdrawal = obj.cf;
			deposit = null;

			// 1 period of interest
			interestAccrued = LIB.roundMoney(calcInt_periodicRate(balance, periods));
			interestAccrued = LIB.roundMoney(interestAccrued);
			principalPaid = LIB.roundMoney(pmt - interestAccrued);
			balance = LIB.roundMoney(balance + interestAccrued + obj.cf);

			schedule.push([sortDateStr, whichSchedule, LIB.ROW_TYPES.DETAIL, periodYearString, scheduledDateStr, pmt, deposit, withdrawal, interestAccrued, principalPaid, null, balance, transDate.getMonth() + 1, transDate.getFullYear(), transDate, transDate.valueOf()]);


			// process from the first regular cash flow until balance is 0 or less or for number of user assigned periods (balloon)
			L = 2;
			// all remaining periods have to be pmtFreq length
			periods = 1;
			do {

				priorDate.setTime(transDate.getTime());
				transDate.setTime(LIB.dateMath.addPeriods(transDate, 1));

				scheduledDateStr = LIB.dateMath.dateToDateStr(transDate, LIB.dateConventions);
				sortDateStr = LIB.dateMath.dateToDateStr(transDate, LIB.sortConventions);

				if (L % LIB.PPY[obj.pmtFreq] === 1) {
					nYears += 1;
				}
				periodYearString = L + ':' + nYears;

				// 1 period of interest
				interestAccrued = LIB.roundMoney(calcInt_periodicRate(balance, periods));
				interestAccrued = LIB.roundMoney(interestAccrued);
				principalPaid = LIB.roundMoney(pmt - interestAccrued);
				balance = LIB.roundMoney(balance + interestAccrued + obj.cf);

				// record type 1, detail schedule row
				schedule.push([sortDateStr, whichSchedule, LIB.ROW_TYPES.DETAIL, periodYearString, scheduledDateStr, pmt, deposit, withdrawal, interestAccrued, principalPaid, null, balance, transDate.getMonth() + 1, transDate.getFullYear(), transDate, transDate.valueOf()]);

				// [KT] 11/13/2016 - add arbitrary overflow check, 99 trillion
				if (Math.abs(balance) > 99999999999995.50) {
					alert('Internal limit reached. Balance exceeds +/- 99 trillion.');
					schedule = [];
					schedule1 = schedule;
					return schedule1;
				}
				L += 1;
			} while (L <= obj.n && balance > 0);

			trans = schedule[schedule.length - 1];
			EQ.summary.unadjustedBalance = trans[BAL];
			EQ.summary.cf[whichSchedule] = trans[CF]; // prior to any rounding
			trans[CF] = trans[CF] + EQ.summary.unadjustedBalance;
			trans[BAL] = trans[BAL] - EQ.summary.unadjustedBalance;
			trans[PRIN] = trans[PRIN] + EQ.summary.unadjustedBalance;
			EQ.summary.totalNDebits[whichSchedule] = L - 1;
			EQ.summary.totalNCredits[whichSchedule] = 1;
			EQ.summary.lastDebitDateStr[whichSchedule] = schedule[0][DATE_STR]; // loan date
			EQ.summary.lastCreditDateStr[whichSchedule] = trans[DATE_STR];

			insertSubTotals(schedule, whichSchedule);
			schedule1 = schedule;
			return schedule1;
		} // if (isValid(obj))
		return null; // error

	} // initLoanScheduleArray(obj)



	/**
	* Calc loan schedule
	*/
	EQ.LOAN_SCHEDULE = {

		/**
		* EQ.LOAN_SCHEDULE.calc()
		* Validates the user inputs
		* @param {Object} obj (required)
		*/
		calc: function (obj) {
			initLoanScheduleArray(obj);
			return schedule1;
		}

	};  // EQ.LOAN_SCHEDULE


	return EQ;

}(LIB$));

