<?php
// tiré de Shaarli de Seb Sauvage
function small_hash ($txt) {
	$t = rtrim (base64_encode (hash ('crc32', $txt, true)), '=');
	$t = str_replace ('+', '-', $t); // Get rid of characters which need encoding in URLs.
	$t = str_replace ('/', '_', $t);
	$t = str_replace ('=', '@', $t);

	return $t;
}

function timestamptodate ($t, $hour = true) {
	$jour = date ('d', $t);
	$mois = date ('m', $t);
	$annee = date ('Y', $t);
	
	switch ($mois) {
	case 1:
		$mois = 'janvier';
		break;
	case 2:
		$mois = 'février';
		break;
	case 3:
		$mois = 'mars';
		break;
	case 4:
		$mois = 'avril';
		break;
	case 5:
		$mois = 'mai';
		break;
	case 6:
		$mois = 'juin';
		break;
	case 7:
		$mois = 'juillet';
		break;
	case 8:
		$mois = 'août';
		break;
	case 9:
		$mois = 'septembre';
		break;
	case 10:
		$mois = 'octobre';
		break;
	case 11:
		$mois = 'novembre';
		break;
	case 12:
		$mois = 'décembre';
		break;
	}
	
	$date = $jour . ' ' . $mois . ' ' . $annee;
	if ($hour) {
		return $date . date (' \à H\:i', $t);
	} else {
		return $date;
	}
}

function sortEntriesByDate ($entry1, $entry2) {
	return $entry2->date (true) - $entry1->date (true);
}
function sortReverseEntriesByDate ($entry1, $entry2) {
	return $entry1->date (true) - $entry2->date (true);
}

function get_domain ($url) {
	return parse_url($url, PHP_URL_HOST);
}

function opml_export ($cats) {
	$txt = '';
	
	foreach ($cats as $cat) {
		$txt .= '<outline text="' . $cat['name'] . '">' . "\n";
		
		foreach ($cat['feeds'] as $feed) {
			$txt .= "\t" . '<outline text="' . cleanText ($feed->name ()) . '" type="rss" xmlUrl="' . $feed->url () . '" htmlUrl="' . $feed->website () . '" />' . "\n";
		}
		
		$txt .= '</outline>' . "\n";
	}
	
	return $txt;
}

function cleanText ($text) {
	return preg_replace ('/&[\w]+;/', '', $text);
}

function opml_import ($xml) {
	$opml = @simplexml_load_string ($xml);

	if (!$opml) {
		return array (array (), array ());
	}

	$categories = array ();
	$feeds = array ();

	foreach ($opml->body->outline as $outline) {
		if (!isset ($outline['xmlUrl'])) {
			// Catégorie
			$title = '';
			
			if (isset ($outline['text'])) {
				$title = (string) $outline['text'];
			} elseif (isset ($outline['title'])) {
				$title = (string) $outline['title'];
			}
			
			if ($title) {
				$cat = new Category ($title);
				$categories[] = $cat;
				
				$feeds = array_merge ($feeds, getFeedsOutline ($outline, $cat->id ()));
			}
		} else {
			// Flux rss
			$feeds[] = getFeed ($outline, '');
		}
	}

	return array ($categories, $feeds);
}

/**
 * import all feeds of a given outline tag
 */
function getFeedsOutline ($outline, $cat_id) {
	$feeds = array ();
	
	foreach ($outline->children () as $child) {
		if (isset ($child['xmlUrl'])) {
			$feeds[] = getFeed ($child, $cat_id);
		} else {
			$feeds = array_merge(
				$feeds,
				getFeedsOutline ($child, $cat_id)
			);
		}
	}
	
	return $feeds;
}

function getFeed ($outline, $cat_id) {
	$url = (string) $outline['xmlUrl'];
	$feed = new Feed ($url);
	$feed->_category ($cat_id);

	return $feed;
}
