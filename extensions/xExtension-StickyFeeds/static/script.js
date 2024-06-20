/* globals $ */
'use strict';

const sticky_feeds = {
	aside: null,
	tree: null,
	window: null,

	init: function () {
		if (window.matchMedia('(max-width: 840px)').matches) {
			return;
		}

		if (!window.$) {
			window.setTimeout(sticky_feeds.init, 50);
			return;
		}

		sticky_feeds.tree = $('#aside_feed .tree');
		if (sticky_feeds.tree.length > 0) {
			// Get the "real" window height: don't forget to remove the height
			// of the #nav_entries
			sticky_feeds.window = $(window);
			sticky_feeds.window.height = sticky_feeds.window.height() - $('#nav_entries').height();

			// Make the aside "sticky" and save the initial position.
			sticky_feeds.aside = $('#aside_feed');
			sticky_feeds.aside.addClass('sticky');
			sticky_feeds.aside.initial_pos = sticky_feeds.aside.position();
			sticky_feeds.tree.initial_pos = sticky_feeds.tree.position();

			// Attach the scroller method to the window scroll.
			sticky_feeds.window.on('scroll', sticky_feeds.scroller);
			sticky_feeds.scroller();
		}
	},

	scroller: function () {
		const pos_top_window = sticky_feeds.window.scrollTop();

		if (pos_top_window < sticky_feeds.aside.initial_pos.top + sticky_feeds.tree.initial_pos.top) {
			// scroll top has not reached the top of the sticky tree yet so it
			// stays in place but its height must adapted:
			// window height - sticky tree pos top + actual scroll top
			const real_tree_pos_top = sticky_feeds.aside.initial_pos.top + sticky_feeds.tree.initial_pos.top;
			sticky_feeds.tree.css('top', sticky_feeds.tree.initial_pos.top);
			sticky_feeds.tree.css('height', sticky_feeds.window.height - real_tree_pos_top + pos_top_window);
		} else {
			// Now we have to make the tree follow the window. It's quite easy
			// since its position is calculated from the parent aside.
			// The height is also easier to calculate since it's just the window
			// height.
			sticky_feeds.tree.css('top', pos_top_window - sticky_feeds.aside.initial_pos.top);
			sticky_feeds.tree.css('height', sticky_feeds.window.height);
		}
	},
};

window.onload = sticky_feeds.init;
