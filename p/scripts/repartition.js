"use strict";
/* globals Flotr, numberFormat */
/* jshint globalstrict: true */

function initStats() {
	if (!window.Flotr) {
		if (window.console) {
			console.log('FreshRSS waiting for Flotr…');
		}
		window.setTimeout(initStats, 50);
		return;
	}
	var jsonRepartition = document.getElementById('jsonRepartition'),
		stats = JSON.parse(jsonRepartition.innerHTML);
	jsonRepartition.outerHTML = '';
	// Entry per hour
	Flotr.draw(document.getElementById('statsEntryPerHour'),
		[{
			data: stats.repartitionHour,
			bars: {horizontal: false, show: true}
		}],
		{
			grid: {verticalLines: false},
			xaxis: {noTicks: 23,
				tickFormatter: function(x1) {
					return 1 + parseInt(x1);
				},
				min: -0.9,
				max: 23.9,
				tickDecimals: 0},
			yaxis: {min: 0},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function(obj) {return numberFormat(obj.y);}}
		});
	// Entry per day of week
	Flotr.draw(document.getElementById('statsEntryPerDayOfWeek'),
		[{
			data: stats.repartitionDayOfWeek,
			bars: {horizontal: false, show: true}
		}],
		{
			grid: {verticalLines: false},
			xaxis: {noTicks: 6,
				tickFormatter: function(x2) {
					return stats.days[parseInt(x2)];
				},
				min: -0.9,
				max: 6.9,
				tickDecimals: 0},
			yaxis: {min: 0},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function(obj) {return numberFormat(obj.y);}}
		});
	// Entry per month
	Flotr.draw(document.getElementById('statsEntryPerMonth'),
		[{
			data: stats.repartitionMonth,
			bars: {horizontal: false, show: true}
		}],
		{
			grid: {verticalLines: false},
			xaxis: {noTicks: 12,
				tickFormatter: function(x3) {
					return stats.months[parseInt(x3) - 1];
				},
				min: 0.1,
				max: 12.9,
				tickDecimals: 0},
			yaxis: {min: 0},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function(obj) {return numberFormat(obj.y);}}
		});

}
initStats();
