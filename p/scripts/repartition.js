"use strict";
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
				tickFormatter: function(x) {
					var x = parseInt(x);
					return x + 1;
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
				tickFormatter: function(x) {
					var x = parseInt(x);
					return stats.days[x];
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
				tickFormatter: function(x) {
					var x = parseInt(x);
					return stats.months[(x - 1)];
				},
				min: 0.1,
				max: 12.9,
				tickDecimals: 0},
			yaxis: {min: 0},
			mouse: {relative: true, track: true, trackDecimals: 0, trackFormatter: function(obj) {return numberFormat(obj.y);}}
		});

}
initStats();
