// @license magnet:?xt=urn:btih:0b31508aeb0634b347b8270c7bee4d411b5d4109&dn=agpl-3.0.txt AGPL-3.0
"use strict";
/* jshint esversion:6, strict:global */

let rendered_node = null,
	rendered_view = null,
	raw_node = null,
	raw_view = null;


function update_ui() {
	if (rendered_node.checked && !raw_node.checked) {
		rendered_view.removeAttribute('hidden');
		raw_view.setAttribute('hidden', true);
	} else if (!rendered_node.checked && raw_node.checked) {
		rendered_view.setAttribute('hidden', true);
		raw_view.removeAttribute('hidden');
	}
}

function init_afterDOM() {
	rendered_node = document.getElementById('freshrss_rendered');
	rendered_view = document.getElementById("freshrss_rendered_view");

	raw_node = document.getElementById("freshrss_raw");
	raw_view = document.getElementById("freshrss_raw_view");

	rendered_node.addEventListener('click', function (ev) {
		update_ui();
	});

	raw_node.addEventListener("click", function (ev) {
		update_ui();
	});
}


if (document.readyState && document.readyState !== 'loading') {
	init_afterDOM();
} else {
	document.addEventListener('DOMContentLoaded', function () {
			if (window.console) {
				console.log('FreshRSS waiting for DOMContentLoaded…');
			}
			init_afterDOM();
		}, false);
}
// @license-end
