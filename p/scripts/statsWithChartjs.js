"use strict";

function initCharts() {
    if (!window.Chart) {
        if (window.console) {
            console.log('FreshRSS is waiting for Chart.js ....');
        }
        window.setTimeout(initCharts, 25);
        return;
    }

    const jsonData = document.getElementsByClassName('jsonData');

    var jsonDataParsed;

    for (var i = 0; i < jsonData.length; i++) {
        jsonDataParsed = JSON.parse(jsonData[i].innerHTML);
        new Chart(
            document.getElementById(jsonDataParsed['stats']['canvasID']),
            jsonDataParsed['stats']['config']
        );
    }

    if (window.console) {
        console.log('Chart.js finished');
    }
}

initCharts();
