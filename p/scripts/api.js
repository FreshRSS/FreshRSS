// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
'use strict';

const check = function (url, next) {
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
};

const pass = function (output) {
	output.innerHTML = output.dataset.i18nPass;
};

const encodingSupport = function (output) {
	output.innerHTML = output.dataset.i18nEncodingSupport;
};

const invalidConfiguration = function (output) {
	output.innerHTML = output.dataset.i18nInvalidConfiguration;
};

const unknownError = function (output, message) {
	output.innerHTML = output.dataset.i18nUnknownError + message;
};

const checkGReaderAPI = function () {
	const output = document.getElementById('greaderOutput');
	const apiUrl = output.dataset.apiUrl;

	check(apiUrl + '/check/compatibility', function next(result1) {
		if (result1 === 'PASS') {
			pass(output);
		} else {
			check(apiUrl + '/check%2Fcompatibility', function next(result2) {
				if (result2 === 'PASS') {
					encodingSupport(output);
				} else {
					check('./greader.php/check/compatibility', function next(result3) {
						if (result3 === 'PASS') {
							invalidConfiguration(output);
						} else {
							unknownError(output, result1);
						}
					});
				}
			});
		}
	});
};

const checkFeverAPI = function () {
	const output = document.getElementById('feverOutput');
	const apiUrl = output.dataset.apiUrl;

	check(apiUrl + '?api', function next(result1) {
		try {
			JSON.parse(result1);
			pass(output);
		} catch (ex) {
			check('./fever.php?api', function next(result2) {
				try {
					JSON.parse(result2);
					invalidConfiguration(output);
				} catch (ex) {
					unknownError(output, result1);
				}
			});
		}
	});
};

/**
 * The API tests are done this way to simulate in a more accurate manner
 * outside requests. Since the APIs are used by third-party tools, they
 * cannot interact at the server level.
 */
checkGReaderAPI();
checkFeverAPI();
// @license-end
