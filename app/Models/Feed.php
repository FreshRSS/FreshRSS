<?php

class FreshRSS_Feed extends Minz_Model {
	private $id = 0;
	private $url;
	private $category = 1;
	private $nbEntries = -1;
	private $nbNotRead = -1;
	private $entries = null;
	private $name = '';
	private $website = '';
	private $description = '';
	private $lastUpdate = 0;
	private $priority = 10;
	private $pathEntries = '';
	private $httpAuth = '';
	private $error = false;
	private $keep_history = -2;

	public function __construct ($url, $validate=true) {
		if ($validate) {
			$this->_url ($url);
		} else {
			$this->url = $url;
		}
	}

	public function id () {
		return $this->id;
	}

	public function hash() {
		return hash('crc32b', Minz_Configuration::salt() . $this->url);
	}

	public function url () {
		return $this->url;
	}
	public function category () {
		return $this->category;
	}
	public function entries () {
		if (!is_null ($this->entries)) {
			return $this->entries;
		} else {
			return array ();
		}
	}
	public function name () {
		return $this->name;
	}
	public function website () {
		return $this->website;
	}
	public function description () {
		return $this->description;
	}
	public function lastUpdate () {
		return $this->lastUpdate;
	}
	public function priority () {
		return $this->priority;
	}
	public function pathEntries () {
		return $this->pathEntries;
	}
	public function httpAuth ($raw = true) {
		if ($raw) {
			return $this->httpAuth;
		} else {
			$pos_colon = strpos ($this->httpAuth, ':');
			$user = substr ($this->httpAuth, 0, $pos_colon);
			$pass = substr ($this->httpAuth, $pos_colon + 1);

			return array (
				'username' => $user,
				'password' => $pass
			);
		}
	}
	public function inError () {
		return $this->error;
	}
	public function keepHistory () {
		return $this->keep_history;
	}
	public function nbEntries () {
		if ($this->nbEntries < 0) {
			$feedDAO = new FreshRSS_FeedDAO ();
			$this->nbEntries = $feedDAO->countEntries ($this->id ());
		}

		return $this->nbEntries;
	}
	public function nbNotRead () {
		if ($this->nbNotRead < 0) {
			$feedDAO = new FreshRSS_FeedDAO ();
			$this->nbNotRead = $feedDAO->countNotRead ($this->id ());
		}

		return $this->nbNotRead;
	}
	public function faviconPrepare() {
		$file = DATA_PATH . '/favicons/' . $this->hash() . '.txt';
		if (!file_exists ($file)) {
			$t = $this->website;
			if (empty($t)) {
				$t = $this->url;
			}
			file_put_contents($file, $t);
		}
	}
	public static function faviconDelete($hash) {
		$path = DATA_PATH . '/favicons/' . $hash;
		@unlink($path . '.ico');
		@unlink($path . '.txt');
	}
	public function favicon () {
		return Minz_Url::display ('/f.php?' . $this->hash());
	}

	public function _id ($value) {
		$this->id = $value;
	}
	public function _url ($value, $validate=true) {
		if ($validate) {
			$value = checkUrl($value);
		}
		if (empty ($value)) {
			throw new FreshRSS_BadUrl_Exception ($value);
		}
		$this->url = $value;
	}
	public function _category ($value) {
		$this->category = $value;
	}
	public function _name ($value) {
		if (is_null ($value)) {
			$value = '';
		}
		$this->name = $value;
	}
	public function _website ($value, $validate=true) {
		if ($validate) {
			$value = checkUrl($value);
		}
		if (empty ($value)) {
			$value = '';
		}
		$this->website = $value;
	}
	public function _description ($value) {
		if (is_null ($value)) {
			$value = '';
		}
		$this->description = $value;
	}
	public function _lastUpdate ($value) {
		$this->lastUpdate = $value;
	}
	public function _priority ($value) {
		$value = intval($value);
		$this->priority = $value >= 0 ? $value : 10;
	}
	public function _pathEntries ($value) {
		$this->pathEntries = $value;
	}
	public function _httpAuth ($value) {
		$this->httpAuth = $value;
	}
	public function _error ($value) {
		$this->error = (bool)$value;
	}
	public function _keepHistory ($value) {
		$value = intval($value);
		$value = min($value, 1000000);
		$value = max($value, -2);
		$this->keep_history = $value;
	}
	public function _nbNotRead ($value) {
		$this->nbNotRead = intval($value);
	}
	public function _nbEntries ($value) {
		$this->nbEntries = intval($value);
	}

	public function load () {
		if (!is_null ($this->url)) {
			if (CACHE_PATH === false) {
				throw new Minz_FileNotExistException (
					'CACHE_PATH',
					Minz_Exception::ERROR
				);
			} else {
				$feed = new SimplePie ();
				$feed->set_useragent(Minz_Translate::t ('freshrss') . '/' . FRESHRSS_VERSION . ' (' . PHP_OS . '; ' . FRESHRSS_WEBSITE . ') ' . SIMPLEPIE_NAME . '/' . SIMPLEPIE_VERSION);
				$url = htmlspecialchars_decode ($this->url, ENT_QUOTES);
				if ($this->httpAuth != '') {
					$url = preg_replace ('#((.+)://)(.+)#', '${1}' . $this->httpAuth . '@${3}', $url);
				}

				$feed->set_feed_url ($url);
				$feed->set_cache_location (CACHE_PATH);
				$feed->set_cache_duration(1500);
				$feed->strip_htmltags (array (
					'base', 'blink', 'body', 'doctype', 'embed',
					'font', 'form', 'frame', 'frameset', 'html',
					'input', 'marquee', 'meta', 'noscript',
					'object', 'param', 'plaintext', 'script', 'style',
				));
				$feed->strip_attributes(array_merge($feed->strip_attributes, array(
					'autoplay', 'onload', 'onunload', 'onclick', 'ondblclick', 'onmousedown', 'onmouseup',
					'onmouseover', 'onmousemove', 'onmouseout', 'onfocus', 'onblur',
					'onkeypress', 'onkeydown', 'onkeyup', 'onselect', 'onchange', 'seamless')));
				$feed->add_attributes(array(
					'img' => array('lazyload' => ''),	//http://www.w3.org/TR/resource-priorities/
					'audio' => array('preload' => 'none'),
					'iframe' => array('postpone' => '', 'sandbox' => 'allow-scripts allow-same-origin'),
					'video' => array('postpone' => '', 'preload' => 'none'),
				));
				$feed->set_url_replacements(array(
					'a' => 'href',
					'area' => 'href',
					'audio' => 'src',
					'blockquote' => 'cite',
					'del' => 'cite',
					'form' => 'action',
					'iframe' => 'src',
					'img' => array(
						'longdesc',
						'src'
					),
					'input' => 'src',
					'ins' => 'cite',
					'q' => 'cite',
					'source' => 'src',
					'track' => 'src',
					'video' => array(
						'poster',
						'src',
					),
				));
				$feed->init ();

				if ($feed->error ()) {
					throw new FreshRSS_Feed_Exception ($feed->error . ' [' . $url . ']');
				}

				// si on a utilisé l'auto-discover, notre url va avoir changé
				$subscribe_url = $feed->subscribe_url ();
				if (!is_null ($subscribe_url) && $subscribe_url != $this->url) {
					if ($this->httpAuth != '') {
						// on enlève les id si authentification HTTP
						$subscribe_url = preg_replace ('#((.+)://)((.+)@)(.+)#', '${1}${5}', $subscribe_url);
					}
					$this->_url ($subscribe_url);
				}

				$title = htmlspecialchars(html_only_entity_decode($feed->get_title()), ENT_COMPAT, 'UTF-8');
				$this->_name (!is_null ($title) ? $title : $this->url);

				$this->_website(html_only_entity_decode($feed->get_link()));
				$this->_description(html_only_entity_decode($feed->get_description()));

				// et on charge les articles du flux
				$this->loadEntries ($feed);
			}
		}
	}
	private function loadEntries ($feed) {
		$entries = array ();

		foreach ($feed->get_items () as $item) {
			$title = html_only_entity_decode (strip_tags ($item->get_title ()));
			$author = $item->get_author ();
			$link = $item->get_permalink ();
			$date = @strtotime ($item->get_date ());

			// gestion des tags (catégorie == tag)
			$tags_tmp = $item->get_categories ();
			$tags = array ();
			if (!is_null ($tags_tmp)) {
				foreach ($tags_tmp as $tag) {
					$tags[] = html_only_entity_decode ($tag->get_label ());
				}
			}

			$content = html_only_entity_decode ($item->get_content ());

			$elinks = array();
			foreach ($item->get_enclosures() as $enclosure) {
				$elink = $enclosure->get_link();
				if (array_key_exists($elink, $elinks)) continue;
				$elinks[$elink] = '1';
				$mime = strtolower($enclosure->get_type());
				if (strpos($mime, 'image/') === 0) {
					$content .= '<br /><img src="' . $elink . '" alt="" />';
				}
			}

			$entry = new FreshRSS_Entry (
				$this->id (),
				$item->get_id (),
				!is_null ($title) ? $title : '',
				!is_null ($author) ? html_only_entity_decode ($author->name) : '',
				!is_null ($content) ? $content : '',
				!is_null ($link) ? $link : '',
				$date ? $date : time ()
			);
			$entry->_tags ($tags);
			// permet de récupérer le contenu des flux tronqués
			$entry->loadCompleteContent($this->pathEntries());

			$entries[] = $entry;
		}

		$this->entries = $entries;
	}
}
