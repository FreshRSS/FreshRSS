<?php
/**
 * SimplePie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the hard work out of managing a complete RSS/Atom solution.
 *
 * Copyright (c) 2004-2017, Ryan Parman, Sam Sneddon, Ryan McCue, and contributors
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 * 	* Redistributions of source code must retain the above copyright notice, this list of
 * 	  conditions and the following disclaimer.
 *
 * 	* Redistributions in binary form must reproduce the above copyright notice, this list
 * 	  of conditions and the following disclaimer in the documentation and/or other materials
 * 	  provided with the distribution.
 *
 * 	* Neither the name of the SimplePie Team nor the names of its contributors may be used
 * 	  to endorse or promote products derived from this software without specific prior
 * 	  written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package SimplePie
 * @version 1.6.0
 * @copyright 2004-2017 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

use SimplePie\SimplePie;
/**
 * Use syslog to report HTTP requests done by SimplePie.
 * @see SimplePie::set_syslog()
 */
define('SIMPLEPIE_SYSLOG', true);	//FreshRSS

/**
 * SimplePie
 *
 * @package SimplePie
 * @subpackage API
 */
class CustomSimplePie extends SimplePie
{
	/**
	 * @var int HTTP status code
	 * @see SimplePie::status_code()
	 * @access private
	 */
	public $status_code = 0;

	/**
	 * @var array Stores the default tags to be stripped by rename_attributes().
	 * @see SimplePie::rename_attributes()
	 * @access private
	 */
	public $rename_attributes = array();

	/**
	 * Use syslog to report HTTP requests done by SimplePie.
	 * @see SimplePie::set_syslog()
	 */
	public $syslog_enabled = SIMPLEPIE_SYSLOG;

	/**
	 * Use syslog to report HTTP requests done by SimplePie.
	 */
	public function set_syslog($value = SIMPLEPIE_SYSLOG)	//FreshRSS
	{
		$this->syslog_enabled = $value == true;
	}

	function cleanMd5($rss)
	{
		//Process by chunks not to use too much memory
		if (($stream = fopen('php://temp', 'r+')) &&
			fwrite($stream, $rss) &&
			rewind($stream))
		{
			$ctx = hash_init('md5');
			while ($stream_data = fread($stream, 1048576))
			{
				hash_update($ctx, preg_replace([
					'#<(lastBuildDate|pubDate|updated|feedDate|dc:date|slash:comments)>[^<]+</\\1>#',
					'#<(media:starRating|media:statistics) [^/<>]+/>#',
					'#<!--.+?-->#s',
				], '', $stream_data));
			}
			fclose($stream);
			return hash_final($ctx);
		}
		return '';
	}

	/**
	 * Initialize the feed object
	 *
	 * This is what makes everything happen. Period. This is where all of the
	 * configuration options get processed, feeds are fetched, cached, and
	 * parsed, and all of that other good stuff.
	 *
	 * @return boolean|integer positive integer with modification time if using cache, boolean true if otherwise successful, false otherwise
	 */
	public function init()
	{
		// Check absolute bare minimum requirements.
		if (!extension_loaded('xml') || !extension_loaded('pcre'))
		{
			$this->error = 'XML or PCRE extensions not loaded!';
			return false;
		}
		// Then check the xml extension is sane (i.e., libxml 2.7.x issue on PHP < 5.2.9 and libxml 2.7.0 to 2.7.2 on any version) if we don't have xmlreader.
		elseif (!extension_loaded('xmlreader'))
		{
			static $xml_is_sane = null;
			if ($xml_is_sane === null)
			{
				$parser_check = xml_parser_create();
				xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
				xml_parser_free($parser_check);
				$xml_is_sane = isset($values[0]['value']);
			}
			if (!$xml_is_sane)
			{
				return false;
			}
		}

		// The default sanitize class gets set in the constructor, check if it has
		// changed.
		if ($this->registry->get_class('Sanitize') !== 'SimplePie_Sanitize') {
			$this->sanitize = $this->registry->create('Sanitize');
		}
		if (method_exists($this->sanitize, 'set_registry'))
		{
			$this->sanitize->set_registry($this->registry);
		}

		// Pass whatever was set with config options over to the sanitizer.
		// Pass the classes in for legacy support; new classes should use the registry instead
		$this->sanitize->pass_cache_data($this->cache, $this->cache_location, $this->cache_name_function, $this->registry->get_class('Cache'));
		$this->sanitize->pass_file_data($this->registry->get_class('File'), $this->timeout, $this->useragent, $this->force_fsockopen, $this->curl_options);

		if (!empty($this->multifeed_url))
		{
			$i = 0;
			$success = 0;
			$this->multifeed_objects = array();
			$this->error = array();
			foreach ($this->multifeed_url as $url)
			{
				$this->multifeed_objects[$i] = clone $this;
				$this->multifeed_objects[$i]->set_feed_url($url);
				$single_success = $this->multifeed_objects[$i]->init();
				$success |= $single_success;
				if (!$single_success)
				{
					$this->error[$i] = $this->multifeed_objects[$i]->error();
				}
				$i++;
			}
			return (bool) $success;
		}
		elseif ($this->feed_url === null && $this->raw_data === null)
		{
			return false;
		}

		$this->error = null;
		$this->data = array();
		$this->check_modified = false;
		$this->multifeed_objects = array();
		$cache = false;

		if ($this->feed_url !== null)
		{
			$parsed_feed_url = $this->registry->call('Misc', 'parse_url', array($this->feed_url));

			// Decide whether to enable caching
			if ($this->cache && $parsed_feed_url['scheme'] !== '')
			{
				$filename = $this->get_cache_filename($this->feed_url);
				$cache = $this->registry->call('Cache', 'get_handler', array($this->cache_location, $filename, 'spc'));
			}

			// Fetch the data via SimplePie_File into $this->raw_data
			if (($fetched = $this->fetch_data($cache)) === true)
			{
				return empty($this->data['mtime']) ? false : $this->data['mtime'];
			}
			elseif ($fetched === false) {
				return false;
			}

			list($headers, $sniffed) = $fetched;

			if (isset($this->data['md5']))
			{
				$md5 = $this->data['md5'];
			}
		}

		// Empty response check
		if(empty($this->raw_data)){
			$this->error = "A feed could not be found at `$this->feed_url`. Empty body.";
			$this->registry->call('Misc', 'error', array($this->error, E_USER_NOTICE, __FILE__, __LINE__));
			return false;
		}

		// Set up array of possible encodings
		$encodings = array();

		// First check to see if input has been overridden.
		if ($this->input_encoding !== false)
		{
			$encodings[] = strtoupper($this->input_encoding);
		}

		$application_types = array('application/xml', 'application/xml-dtd', 'application/xml-external-parsed-entity');
		$text_types = array('text/xml', 'text/xml-external-parsed-entity');

		// RFC 3023 (only applies to sniffed content)
		if (isset($sniffed))
		{
			if (in_array($sniffed, $application_types) || substr($sniffed, 0, 12) === 'application/' && substr($sniffed, -4) === '+xml')
			{
				if (isset($headers['content-type']) && preg_match('/;\x20?charset=([^;]*)/i', $headers['content-type'], $charset))
				{
					$encodings[] = strtoupper($charset[1]);
				}
				else
				{
					$encodings[] = '';	//FreshRSS: Let the DOM parser decide first
				}
			}
			elseif (in_array($sniffed, $text_types) || substr($sniffed, 0, 5) === 'text/' && substr($sniffed, -4) === '+xml')
			{
				if (isset($headers['content-type']) && preg_match('/;\x20?charset=([^;]*)/i', $headers['content-type'], $charset))
				{
					$encodings[] = strtoupper($charset[1]);
				}
				else
				{
					$encodings[] = '';	//FreshRSS: Let the DOM parser decide first
				}
				$encodings[] = 'US-ASCII';
			}
			// Text MIME-type default
			elseif (substr($sniffed, 0, 5) === 'text/')
			{
				$encodings[] = 'UTF-8';
			}
		}

		// Fallback to XML 1.0 Appendix F.1/UTF-8/ISO-8859-1
		$encodings = array_merge($encodings, $this->registry->call('Misc', 'xml_encoding', array($this->raw_data, &$this->registry)));
		$encodings[] = 'UTF-8';
		$encodings[] = 'ISO-8859-1';

		// There's no point in trying an encoding twice
		$encodings = array_unique($encodings);

		// Loop through each possible encoding, till we return something, or run out of possibilities
		foreach ($encodings as $encoding)
		{
			// Change the encoding to UTF-8 (as we always use UTF-8 internally)
			if ($utf8_data = (empty($encoding) || $encoding === 'UTF-8') ? $this->raw_data :	//FreshRSS
				$this->registry->call('Misc', 'change_encoding', array($this->raw_data, $encoding, 'UTF-8')))
			{
				// Create new parser
				$parser = $this->registry->create('Parser');

				// If it's parsed fine
				if ($parser->parse($utf8_data, empty($encoding) ? '' : 'UTF-8', $this->permanent_url))	//FreshRSS
				{
					$this->data = $parser->get_data();
					if (!($this->get_type() & ~SIMPLEPIE_TYPE_NONE))
					{
						$this->error = "A feed could not be found at `$this->feed_url`. This does not appear to be a valid RSS or Atom feed.";
						$this->registry->call('Misc', 'error', array($this->error, E_USER_NOTICE, __FILE__, __LINE__));
						return false;
					}

					if (isset($headers))
					{
						$this->data['headers'] = $headers;
					}
					$this->data['build'] = SIMPLEPIE_BUILD;
					$this->data['mtime'] = time();
					$this->data['md5'] = empty($md5) ? $this->cleanMd5($this->raw_data) : $md5;

					// Cache the file if caching is enabled
					if ($cache && !$cache->save($this))
					{
						trigger_error("$this->cache_location is not writable. Make sure you've set the correct relative or absolute path, and that the location is server-writable.", E_USER_WARNING);
					}
					return true;
				}
			}
		}

		if (isset($parser))
		{
			// We have an error, just set SimplePie_Misc::error to it and quit
			$this->error = $this->feed_url;
			$this->error .= sprintf(' is invalid XML, likely due to invalid characters. XML error: %s at line %d, column %d', $parser->get_error_string(), $parser->get_current_line(), $parser->get_current_column());
		}
		else
		{
			$this->error = 'The data could not be converted to UTF-8.';
			if (!extension_loaded('mbstring') && !extension_loaded('iconv') && !class_exists('\UConverter')) {
				$this->error .= ' You MUST have either the iconv, mbstring or intl (PHP 5.5+) extension installed and enabled.';
			} else {
				$missingExtensions = array();
				if (!extension_loaded('iconv')) {
					$missingExtensions[] = 'iconv';
				}
				if (!extension_loaded('mbstring')) {
					$missingExtensions[] = 'mbstring';
				}
				if (!class_exists('\UConverter')) {
					$missingExtensions[] = 'intl (PHP 5.5+)';
				}
				$this->error .= ' Try installing/enabling the ' . implode(' or ', $missingExtensions) . ' extension.';
			}
		}

		$this->registry->call('Misc', 'error', array($this->error, E_USER_NOTICE, __FILE__, __LINE__));

		return false;
	}

	/**
	 * Fetch the data via SimplePie_File
	 *
	 * If the data is already cached, attempt to fetch it from there instead
	 * @param SimplePie_Cache_Base|false $cache Cache handler, or false to not load from the cache
	 * @return array|true Returns true if the data was loaded from the cache, or an array of HTTP headers and sniffed type
	 */
	protected function fetch_data(&$cache)
	{
		// If it's enabled, use the cache
		if ($cache)
		{
			// Load the Cache
			$this->data = $cache->load();
			if ($cache->mtime() + $this->cache_duration > time())
			{
				$this->raw_data = false;
				return true;	// If the cache is still valid, just return true
			}
			elseif (!empty($this->data))
			{
				// If the cache is for an outdated build of SimplePie
				if (!isset($this->data['build']) || $this->data['build'] !== SIMPLEPIE_BUILD)
				{
					$cache->unlink();
					$this->data = array();
				}
				// If we've hit a collision just rerun it with caching disabled
				elseif (isset($this->data['url']) && $this->data['url'] !== $this->feed_url)
				{
					$cache = false;
					$this->data = array();
				}
				// If we've got a non feed_url stored (if the page isn't actually a feed, or is a redirect) use that URL.
				elseif (isset($this->data['feed_url']))
				{
					// If the autodiscovery cache is still valid use it.
					if ($cache->mtime() + $this->autodiscovery_cache_duration > time())
					{
						// Do not need to do feed autodiscovery yet.
						if ($this->data['feed_url'] !== $this->data['url'])
						{
							$this->set_feed_url($this->data['feed_url']);
							return $this->init();
						}

						$cache->unlink();
						$this->data = array();
					}
				}
				// Check if the cache has been updated
				else
				{
					$headers = array(
						'Accept' => 'application/atom+xml, application/rss+xml, application/rdf+xml;q=0.9, application/xml;q=0.8, text/xml;q=0.8, text/html;q=0.7, unknown/unknown;q=0.1, application/unknown;q=0.1, */*;q=0.1',
					);
					if (isset($this->data['headers']['last-modified']))
					{
						$headers['if-modified-since'] = $this->data['headers']['last-modified'];
					}
					if (isset($this->data['headers']['etag']))
					{
						$headers['if-none-match'] = $this->data['headers']['etag'];
					}

					$file = $this->registry->create('File', array($this->feed_url, $this->timeout, 5, $headers, $this->useragent, $this->force_fsockopen, $this->curl_options, $this->syslog_enabled));
					$this->status_code = $file->status_code;

					if ($file->success)
					{
						if ($file->status_code === 304)
						{
							$cache->touch();
							return true;
						}
					}
					else
					{
						$this->check_modified = false;
						$cache->touch();
						$this->error = $file->error;
						return !empty($this->data);
					}

					$md5 = $this->cleanMd5($file->body);
					if ($this->data['md5'] === $md5) {
						if ($this->syslog_enabled)
						{
							syslog(LOG_DEBUG, 'SimplePie MD5 cache match for ' . SimplePie_Misc::url_remove_credentials($this->feed_url));
						}
						$cache->touch();
						return true;	//Content unchanged even though server did not send a 304
					} else {
						if ($this->syslog_enabled)
						{
							syslog(LOG_DEBUG, 'SimplePie MD5 cache no match for ' . SimplePie_Misc::url_remove_credentials($this->feed_url));
						}
						$this->data['md5'] = $md5;
					}
				}
			}
			// If the cache is empty
			else
			{
				$cache->touch();	//To keep the date/time of the last tentative update
				$this->data = array();
			}
		}
		// If we don't already have the file (it'll only exist if we've opened it to check if the cache has been modified), open it.
		if (!isset($file))
		{
			if ($this->file instanceof SimplePie_File && $this->file->url === $this->feed_url)
			{
				$file =& $this->file;
			}
			else
			{
				$headers = array(
					'Accept' => 'application/atom+xml, application/rss+xml, application/rdf+xml;q=0.9, application/xml;q=0.8, text/xml;q=0.8, text/html;q=0.7, unknown/unknown;q=0.1, application/unknown;q=0.1, */*;q=0.1',
				);
				$file = $this->registry->create('File', array($this->feed_url, $this->timeout, 5, $headers, $this->useragent, $this->force_fsockopen, $this->curl_options, $this->syslog_enabled));
			}
		}
		$this->status_code = $file->status_code;

		// If the file connection has an error, set SimplePie::error to that and quit
		if (!$file->success && !($file->method & SIMPLEPIE_FILE_SOURCE_REMOTE === 0 || ($file->status_code === 200 || $file->status_code > 206 && $file->status_code < 300)))
		{
			$this->error = $file->error;
			return !empty($this->data);
		}

		if (!$this->force_feed)
		{
			// Check if the supplied URL is a feed, if it isn't, look for it.
			$locate = $this->registry->create('Locator', array(&$file, $this->timeout, $this->useragent, $this->max_checked_feeds, $this->force_fsockopen, $this->curl_options));

			if (!$locate->is_feed($file))
			{
				$copyStatusCode = $file->status_code;
				$copyContentType = $file->headers['content-type'];
				try
				{
					$microformats = false;
					if (class_exists('DOMXpath') && function_exists('Mf2\parse')) {
						$doc = new DOMDocument();
						@$doc->loadHTML($file->body);
						$xpath = new DOMXpath($doc);
						// Check for both h-feed and h-entry, as both a feed with no entries
						// and a list of entries without an h-feed wrapper are both valid.
						$query = '//*[contains(concat(" ", @class, " "), " h-feed ") or '.
							'contains(concat(" ", @class, " "), " h-entry ")]';
						$result = $xpath->query($query);
						$microformats = $result->length !== 0;
					}
					// Now also do feed discovery, but if microformats were found don't
					// overwrite the current value of file.
					$discovered = $locate->find($this->autodiscovery,
					                            $this->all_discovered_feeds);
					if ($microformats)
					{
						if ($hub = $locate->get_rel_link('hub'))
						{
							$self = $locate->get_rel_link('self');
							$this->store_links($file, $hub, $self);
						}
						// Push the current file onto all_discovered feeds so the user can
						// be shown this as one of the options.
						if (isset($this->all_discovered_feeds)) {
							$this->all_discovered_feeds[] = $file;
						}
					}
					else
					{
						if ($discovered)
						{
							$file = $discovered;
						}
						else
						{
							// We need to unset this so that if SimplePie::set_file() has
							// been called that object is untouched
							unset($file);
							$this->error = "A feed could not be found at `$this->feed_url`; the status code is `$copyStatusCode` and content-type is `$copyContentType`";
							$this->registry->call('Misc', 'error', array($this->error, E_USER_NOTICE, __FILE__, __LINE__));
							return false;
						}
					}
				}
				catch (SimplePie_Exception $e)
				{
					// We need to unset this so that if SimplePie::set_file() has been called that object is untouched
					unset($file);
					// This is usually because DOMDocument doesn't exist
					$this->error = $e->getMessage();
					$this->registry->call('Misc', 'error', array($this->error, E_USER_NOTICE, $e->getFile(), $e->getLine()));
					return false;
				}
				if ($cache)
				{
					$this->data = array('url' => $this->feed_url, 'feed_url' => $file->url, 'build' => SIMPLEPIE_BUILD);
					$this->data['mtime'] = time();
					$this->data['md5'] = empty($md5) ? $this->cleanMd5($file->body) : $md5;
					if (!$cache->save($this))
					{
						trigger_error("$this->cache_location is not writable. Make sure you've set the correct relative or absolute path, and that the location is server-writable.", E_USER_WARNING);
					}
					$cache = $this->registry->call('Cache', 'get_handler', array($this->cache_location, call_user_func($this->cache_name_function, $file->url), 'spc'));
				}
			}
			$this->feed_url = $file->url;
			$locate = null;
		}

		$file->body = trim($file->body);	//FreshRSS
		$this->raw_data = $file->body;
		$this->permanent_url = $file->permanent_url;
		$headers = $file->headers;
		$sniffer = $this->registry->create('Content_Type_Sniffer', array(&$file));
		$sniffed = $sniffer->get_type();

		return array($headers, $sniffed);
	}

	/**
	 * Get all links for the feed
	 *
	 * Uses `<atom:link>` or `<link>`
	 *
	 * @since Beta 2
	 * @param string $rel The relationship of links to return
	 * @return array|null Links found for the feed (strings)
	 */
	public function get_links($rel = 'alternate')
	{
		if (!isset($this->data['links']))
		{
			$this->data['links'] = array();
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'link'))
			{
				foreach ($links as $link)
				{
					if (isset($link['attribs']['']['href']))
					{
						$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
						$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
					}
				}
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'link'))
			{
				foreach ($links as $link)
				{
					if (isset($link['attribs']['']['href']))
					{
						$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
						$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));

					}
				}
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}

			$keys = array_keys($this->data['links']);
			foreach ($keys as $key)
			{
				if ($this->registry->call('Misc', 'is_isegment_nz_nc', array($key)))
				{
					if (isset($this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]))
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] = array_merge($this->data['links'][$key], $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]);
						$this->data['links'][$key] =& $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key];
					}
					else
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] =& $this->data['links'][$key];
					}
				}
				elseif (substr($key, 0, 41) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY)
				{
					$this->data['links'][substr($key, 41)] =& $this->data['links'][$key];
				}
				$this->data['links'][$key] = array_unique($this->data['links'][$key]);
			}
		}

		if (isset($this->data['headers']['link']))
		{
			$link_headers = $this->data['headers']['link'];
			if (is_array($link_headers)) {
				$link_headers = implode(',', $link_headers);
			}
			// https://datatracker.ietf.org/doc/html/rfc8288
			if (is_string($link_headers) &&
				preg_match_all('/<(?P<uri>[^>]+)>\s*;\s*rel\s*=\s*(?P<quote>"?)' . preg_quote($rel) . '(?P=quote)\s*(?=,|$)/i', $link_headers, $matches))
			{
				return $matches['uri'];
			}
		}

		if (isset($this->data['links'][$rel]))
		{
			return $this->data['links'][$rel];
		}

		return null;
	}
}
