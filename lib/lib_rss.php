<?php
if (!function_exists('json_decode')) {
	require_once('JSON.php');
	function json_decode($var) {
		$JSON = new Services_JSON;
		return (array)($JSON->decode($var));
	}
}

if (!function_exists('json_encode')) {
	require_once('JSON.php');
	function json_encode($var) {
		$JSON = new Services_JSON;
		return $JSON->encodeUnsafe($var);
	}
}

// vérifie qu'on est connecté
function is_logged () {
	return Session::param ('mail') != false;
}

// vérifie que le système d'authentification est configuré
function login_is_conf ($conf) {
	return $conf->mailLogin () != false;
}

// tiré de Shaarli de Seb Sauvage	//Format RFC 4648 base64url
function small_hash ($txt) {
	$t = rtrim (base64_encode (hash ('crc32', $txt, true)), '=');
	return strtr ($t, '+/', '-_');
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
			$txt .= "\t" . '<outline text="' . $feed->name () . '" type="rss" xmlUrl="' . $feed->url () . '" htmlUrl="' . $feed->website () . '" />' . "\n";
		}

		$txt .= '</outline>' . "\n";
	}

	return $txt;
}

function html_only_entity_decode($text) {
	static $htmlEntitiesOnly = null;
	if ($htmlEntitiesOnly === null) {
		$htmlEntitiesOnly = array_flip(array_diff(
			get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES, 'UTF-8'),	//Decode HTML entities
			get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES, 'UTF-8')	//Preserve XML entities
		));
	}
	return strtr($text, $htmlEntitiesOnly);
}

function opml_import ($xml) {
	$xml = html_only_entity_decode($xml);	//!\ Assume UTF-8
	$opml = simplexml_load_string ($xml);

	if (!$opml) {
		throw new OpmlException ();
	}

	$catDAO = new CategoryDAO();
	$catDAO->checkDefault();
	$defCat = $catDAO->getDefault();

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
				// Permet d'éviter les soucis au niveau des id :
				// ceux-ci sont générés en fonction de la date,
				// un flux pourrait être dans une catégorie X avec l'id Y
				// alors qu'il existe déjà la catégorie X mais avec l'id Z
				// Y ne sera pas ajouté et le flux non plus vu que l'id
				// de sa catégorie n'exisera pas
				$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
				$catDAO = new CategoryDAO ();
				$cat = $catDAO->searchByName ($title);
				if ($cat === false) {
					$cat = new Category ($title);
					$values = array (
						'name' => $cat->name (),
						'color' => $cat->color ()
					);
					$cat->_id ($catDAO->addCategory ($values));
				}

				$feeds = array_merge ($feeds, getFeedsOutline ($outline, $cat->id ()));
			}
		} else {
			// Flux rss sans catégorie, on récupère l'ajoute dans la catégorie par défaut
			$feeds[] = getFeed ($outline, $defCat->id());
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
	$url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
	$title = '';
	if (isset ($outline['text'])) {
		$title = (string) $outline['text'];
	} elseif (isset ($outline['title'])) {
		$title = (string) $outline['title'];
	}
	$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
	$feed = new Feed ($url);
	$feed->_category ($cat_id);
	$feed->_name ($title);
	return $feed;
}


/* permet de récupérer le contenu d'un article pour un flux qui n'est pas complet */
function get_content_by_parsing ($url, $path) {
	require_once (LIB_PATH . '/lib_phpQuery.php');

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

/**
 * Add support of image lazy loading
 * Move content from src attribute to data-original
 * @param content is the text we want to parse
 */
function lazyimg($content) {
	return preg_replace(
		'/<img([^>]+?)src=[\'"]([^"\']+)[\'"]([^>]*)>/i',
		'<img$1src="' . Url::display('/themes/icons/grey.gif') . '" data-original="$2"$3>',
		$content
	);
}

function invalidateHttpCache() {
	file_put_contents(DATA_PATH . '/touch.txt', microtime(true));
}
