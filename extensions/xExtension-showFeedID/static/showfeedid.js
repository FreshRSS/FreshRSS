'use strict';

const url = new URL(window.location);
if (url.searchParams.get('c') === 'subscription') {
	const div = document.querySelector('h1 ~ div');
	const button = document.createElement('Button');

	button.classList.add('btn');
	button.id = 'showFeedId';
	button.innerHTML = '<img class="icon" src="../themes/icons/look.svg" /> Show IDs';
	div.appendChild(button);

	document.getElementById('showFeedId').addEventListener('click', function (e) {
		const feeds = document.querySelectorAll('li.item.feed');

		let feedId;
		let feedname_elem;
		feeds.forEach(function (feed) {
			feedId = feed.dataset.feedId;
			feedname_elem = feed.getElementsByClassName('item-title')[0];
			if (feedname_elem) {
				feedname_elem.innerHTML = feedname_elem.textContent + ' (ID: ' + feedId + ')';
			}
		});

		const cats = document.querySelectorAll('div.box > ul.box-content');

		let catId;
		let catname_elem;
		cats.forEach(function (cat) {
			catId = cat.dataset.catId;
			catname_elem = cat.parentElement.querySelectorAll('div.box-title > h2')[0];
			if (catname_elem) {
				catname_elem.innerHTML = catname_elem.textContent + ' (ID: ' + catId + ')';
			}
		});
	});
}
