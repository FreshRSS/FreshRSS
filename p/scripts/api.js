"use strict";
/* jshint esversion:6, strict:global */

function check(url, next) {
	if (!url || !next) {
		return;
	}
	const req = new XMLHttpRequest();
	req.open('GET', url, true);
	req.setRequestHeader('Authorization', 'GoogleLogin auth=test/1');
	req.onerror = function (e) {
			next('FAIL: HTTP ' + e);
		};
	req.onload = function () {
		if (this.status == 200) {
			next(this.response);
		} else {
			next('FAIL: HTTP error ' + this.status + ' ' + this.statusText);
		}
	};
	req.send();
}

const jsonVars = JSON.parse(document.getElementById('jsonVars').innerHTML);

check(jsonVars.greader + '/check/compatibility', function next(result1) {
		const greaderOutput = document.getElementById('greaderOutput');
		if (result1 === 'PASS') {
			greaderOutput.innerHTML = '✔️ ' + result1;
		} else {
			check(jsonVars.greader + '/check%2Fcompatibility', function next(result2) {
				if (result2 === 'PASS') {
					greaderOutput.innerHTML = '⚠️ WARN: no <code>%2F</code> support, so some clients will not work!';
				} else {
					check('./greader.php/check/compatibility', function next(result3) {
						if (result3 === 'PASS') {
							greaderOutput.innerHTML = '⚠️ WARN: Probable invalid base URL in ./data/config.php';
						} else {
							greaderOutput.innerHTML = '❌ ' + result1;
						}
					});
				}
			});
		}
	});

check(jsonVars.fever + '?api', function next(result1) {
		const feverOutput = document.getElementById('feverOutput');
		try {
			JSON.parse(result1);
			feverOutput.innerHTML = '✔️ PASS';
		} catch (ex) {
			check('./fever.php?api', function next(result2) {
					try {
						JSON.parse(result2);
						feverOutput.innerHTML = '⚠️ WARN: Probable invalid base URL in ./data/config.php';
					} catch (ex) {
						feverOutput.innerHTML = '❌ ' + result1;
					}
				});
		}
	});
