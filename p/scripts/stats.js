"use strict";
function initStats() {
	if (!window.Flotr) {
		if (window.console) {
			console.log('FreshRSS waiting for Flotr…');
		}
		window.setTimeout(initStats, 50);
		return;
	}
	var jsonStats = document.getElementById('jsonStats'),
		stats = JSON.parse(jsonStats.innerHTML);
	jsonStats.outerHTML = '';
	// Entry per day
	var avg = [];
	for (var i = -31; i <= 0; i++) {
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
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function(obj) {return numberFormat(obj.y);}}
		});
	// Feed per category
	Flotr.draw(document.getElementById('statsFeedPerCategory'),
		stats.feedByCategory,
		{
			grid: {verticalLines: false, horizontalLines: false},
			pie: {explode: 10, show: true, labelFormatter: function(){return '';}},
			xaxis: {showLabels: false},
			yaxis: {showLabels: false},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function(obj) {return obj.series.label + ' - '+ numberFormat(obj.y) + ' ('+ (obj.fraction * 100).toFixed(1) + '%)';}},
			legend: {container: document.getElementById('statsFeedPerCategoryLegend'), noColumns: 3}
		});
	// Entry per category
	Flotr.draw(document.getElementById('statsEntryPerCategory'),
		stats.entryByCategory,
		{
			grid: {verticalLines: false, horizontalLines: false},
			pie: {explode: 10, show: true, labelFormatter: function(){return '';}},
			xaxis: {showLabels: false},
			yaxis: {showLabels: false},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function(obj) {return obj.series.label + ' - '+ numberFormat(obj.y) + ' ('+ (obj.fraction * 100).toFixed(1) + '%)';}},
			legend: {container: document.getElementById('statsEntryPerCategoryLegend'), noColumns: 3}
		});
}
initStats();
