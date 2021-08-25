// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
"use strict";
/* globals Flotr, numberFormat */
/* jshint esversion:6, strict:global */

function initStats() {
	if (!window.Flotr) {
		if (window.console) {
			console.log('FreshRSS waiting for Flotr…');
		}
		window.setTimeout(initStats, 50);
		return;
	}
	const jsonStats = document.getElementById('jsonStats'),
		stats = JSON.parse(jsonStats.innerHTML);
	// Entry per day
	const avg = [];
	for (let i = -31; i <= 0; i++) {
		avg.push([i, stats.average]);
	}
	Flotr.draw(document.getElementById('statsEntryPerDay'),
		[{
			data: stats.dataCount,
			bars: {horizontal: false, show: true}
		},{
			data: avg,
			lines: {show: true},
			label: stats.average,
		}],
		{
			grid: {verticalLines: false},
			xaxis: {noTicks: 6, showLabels: false, tickDecimals: 0, min: -30.75, max: -0.25},
			yaxis: {min: 0},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function (obj) { return numberFormat(obj.y); }},
		});
	// Feed per category
	Flotr.draw(document.getElementById('statsFeedPerCategory'),
		stats.feedByCategory,
		{
			grid: {verticalLines: false, horizontalLines: false},
			pie: {explode: 10, show: true, labelFormatter: function(){return '';}},
			xaxis: {showLabels: false},
			yaxis: {showLabels: false},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function (obj) {
				return obj.series.label + ' - ' + numberFormat(obj.y) + ' (' + (obj.fraction * 100).toFixed(1) + '%)';
			}},
			legend: {container: document.getElementById('statsFeedPerCategoryLegend'), noColumns: 3}
		});
	// Entry per category
	Flotr.draw(document.getElementById('statsEntryPerCategory'),
		stats.entryByCategory,
		{
			grid: {verticalLines: false, horizontalLines: false},
			pie: {explode: 10, show: true, labelFormatter: function () { return ''; }},
			xaxis: {showLabels: false},
			yaxis: {showLabels: false},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function (obj) {
				return obj.series.label + ' - ' + numberFormat(obj.y) + ' (' + (obj.fraction * 100).toFixed(1) + '%)';
			}},
			legend: {container: document.getElementById('statsEntryPerCategoryLegend'), noColumns: 3}
		});
}
initStats();

window.addEventListener('resize', initStats);

// @license-end
