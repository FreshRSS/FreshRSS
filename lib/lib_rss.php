<?php
// vérifie qu'on est connecté
function is_logged () {
	return Session::param ('mail') != false;
}

// vérifie que le système d'authentification est configuré
function login_is_conf ($conf) {
	return $conf->mailLogin () != false;
}

// tiré de Shaarli de Seb Sauvage
function small_hash ($txt) {
	$t = rtrim (base64_encode (hash ('crc32', $txt, true)), '=');
	$t = str_replace ('+', '-', $t); // Get rid of characters which need encoding in URLs.
	$t = str_replace ('/', '_', $t);
	$t = str_replace ('=', '@', $t);

	return $t;
}

function timestamptodate ($t, $hour = true) {
	$month = Translate::t (date('M', $t));
	if ($hour) {
		$date = Translate::t ('format_date_hour', $month);
	} else {
		$date = Translate::t ('format_date', $month);
	}

	return date ($date, $t);
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
			$txt .= "\t" . '<outline text="' . cleanText ($feed->name ()) . '" type="rss" xmlUrl="' . htmlentities ($feed->url ()) . '" htmlUrl="' . htmlentities ($feed->website ()) . '" />' . "\n";
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
				$catDAO = new CategoryDAO ();
				$cat = $catDAO->searchByName ($title);
				if ($cat === false) {
					$cat = new Category ($title);
				}
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


/* permet de récupérer le contenu d'un article pour un flux qui n'est pas complet */
function get_content_by_parsing ($url, $path) {
	$html = file_get_contents ($url);
	
	if ($html) {
		$doc = phpQuery::newDocument ($html);
		$content = $doc->find ($path);
		$content->find ('*')->removeAttr ('style')
		                    ->removeAttr ('id')
		                    ->removeAttr ('class')
		                    ->removeAttr ('onload')
		                    ->removeAttr ('target');
		$content->removeAttr ('style')
		        ->removeAttr ('id')
		        ->removeAttr ('class')
		        ->removeAttr ('onload')
		        ->removeAttr ('target');
		return $content->__toString ();
	} else {
		throw new Exception ();
	}
}
