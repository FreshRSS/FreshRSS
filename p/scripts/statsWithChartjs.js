// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
"use strict";
/* globals Chart */
/* jshint esversion:6, strict:global */

function initCharts() {
	if (!window.Chart) {
		if (window.console) {
			console.log('FreshRSS is waiting for Chart.js...');
		}
		window.setTimeout(initCharts, 25);
		return;
	}

	const jsonData = document.getElementsByClassName('jsonData-stats');

	var jsonDataParsed;
	var chartConfig;

	for (var i = 0; i < jsonData.length; i++) {
		jsonDataParsed = JSON.parse(jsonData[i].innerHTML);
		switch(jsonDataParsed.charttype) {
			case 'bar':
				chartConfig = jsonChartBar(jsonDataParsed.label, jsonDataParsed.data, jsonDataParsed.xAxisLabels);
				break;
			case 'doughnut':
				chartConfig = jsonChartDoughnut(jsonDataParsed.labels, jsonDataParsed.data);
				break;
			case 'barWithAverage':
				chartConfig = jsonChartBarWithAvarage(jsonDataParsed.labelBarChart, jsonDataParsed.dataBarChart, jsonDataParsed.labelAverage, jsonDataParsed.dataAverage, jsonDataParsed.xAxisLabels);
		}

		new Chart(
			document.getElementById(jsonDataParsed.canvasID),
			chartConfig
		);
	}

	if (window.console) {
		console.log('Chart.js finished');
	}
}

function jsonChartBar(label, data, xAxisLabels = '') {
	return {
		type: 'bar',
		data: {
			datasets: [{
				label: label,
				backgroundColor: '#0062BD',
				borderColor: '#0062BD',
				data: data,
				barPercentage: 1.0,
				categoryPercentage: 1.0,
				order: 2,
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				},
				x: {
					ticks: {
						callback: function(val){
							if (xAxisLabels.length > 0) {
								return xAxisLabels[val];
							} else {
								return val;
							}
						}
					},
					grid: {
						display: false,
					}
				}
			},
			plugins: {
				tooltip: {
					callbacks: {
						title: function(tooltipitem) {
							if (xAxisLabels.length > 0) {
								return xAxisLabels[tooltipitem[0].label];
							} else {
								return tooltipitem[0].label;
							}
						}
					}
				},
				legend: {
					display: false,
				}
			}
		}
	};
}

function jsonChartDoughnut(labels, data) {
	return {
		type: 'doughnut',
		data: {
			labels: labels,
			datasets: [{
				backgroundColor: [
					'#0b84a5',  //petrol
					'#f6c85f', // sand
					'#6f4e7c', //purple
					'#9dd866', //green
					'#ca472f', //red
					'#ffa056', //orange
					'#8dddd0', // turkis
					'#f6c85f', // sand
					'#6f4e7c', //purple
					'#9dd866', //green
					'#ca472f', //red
					'#ffa056', //orange
					'#8dddd0', // turkis
				],
				data: data,
			}]
		},
		options: {
			layout: {
				padding: 20,
			},
			plugins: {
				legend: {
					position: 'bottom',
					align: 'start',
				}
			}
		}
	};
}

function jsonChartBarWithAvarage(labelBarChart, dataBarChart, labelAverage, dataAverage, xAxisLabels = '') {
	return {
		type: 'bar',
		data: {
			datasets: [
				{
					// bar chart layout
					label: labelBarChart,
					backgroundColor: '#0062BD',
					borderColor: '#0062BD',
					data: dataBarChart,
					barPercentage: 1.0,
					categoryPercentage: 1.0,
					order: 2,
				},
				{
					// average line chart
					type: 'line',
					label: labelAverage,  // Todo: i18n
					borderColor: 'rgb(192,216,0)',
					data: {
						'-30' : dataAverage,
						'-1' : dataAverage,
					},
					order: 1,
				}
			]
		},

		options: {
			scales: {
				y: {
					beginAtZero: true,
				},
				x: {
					ticks: {
						callback: function(val){
							if (xAxisLabels.length > 0) {
								return xAxisLabels[val];
							} else {
								return val;
							}
						}
					},
					grid: {
						display: false,
					}
				}
			},
			elements: {
				point: {
					radius: 0,
				}
			},
			plugins: {
				tooltip: {
					callbacks: {
						title: function(tooltipitem) {
							console.log(tooltipitem);
							if (xAxisLabels.length > 0) {
								return xAxisLabels[tooltipitem[0].dataIndex];
							} else {
								return tooltipitem[0].label;
							}
						}
					}
				},
				legend: {
					display: false,
				}
			}
		}
	};
}

initCharts();

// @license-end
