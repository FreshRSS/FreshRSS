<?php
/**
 * SimplePie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the hard work out of managing a complete RSS/Atom solution.
 *
 * Copyright (c) 2004-2016, Ryan Parman, Sam Sneddon, Ryan McCue, and contributors
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
 * @copyright 2004-2016 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

use SimplePie\Sanitize;

/**
 * Used for data cleanup and post-processing
 *
 *
 * This class can be overloaded with {@see SimplePie::set_sanitize_class()}
 *
 * @package SimplePie
 * @todo Move to using an actual HTML parser (this will allow tags to be properly stripped, and to switch between HTML and XHTML), this will also make it easier to shorten a string while preserving HTML tags
 */
class CustomSimplePieSanitize extends Sanitize
{
	public function sanitize($data, $type, $base = '')
	{
		$data = trim($data);
		if ($data !== '' || $type & SIMPLEPIE_CONSTRUCT_IRI)
		{
			if ($type & SIMPLEPIE_CONSTRUCT_MAYBE_HTML)
			{
				$data = htmlspecialchars_decode($data, ENT_QUOTES);	//FreshRSS
				if (preg_match('/(&(#(x[0-9a-fA-F]+|[0-9]+)|[a-zA-Z0-9]+)|<\/[A-Za-z][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E]*' . SIMPLEPIE_PCRE_HTML_ATTRIBUTE . '>)/', $data))
				{
					$type |= SIMPLEPIE_CONSTRUCT_HTML;
				}
				else
				{
					$type |= SIMPLEPIE_CONSTRUCT_TEXT;
				}
			}

			if ($type & SIMPLEPIE_CONSTRUCT_BASE64)
			{
				$data = base64_decode($data);
			}

			if ($type & (SIMPLEPIE_CONSTRUCT_HTML | SIMPLEPIE_CONSTRUCT_XHTML))
			{

				if (!class_exists('DOMDocument'))
				{
					throw new SimplePie_Exception('DOMDocument not found, unable to use sanitizer');
				}
				$document = new DOMDocument();
				$document->encoding = 'UTF-8';

				$data = $this->preprocess($data, $type);

				set_error_handler(array('SimplePie_Misc', 'silence_errors'));
				$document->loadHTML($data);
				restore_error_handler();

				$xpath = new DOMXPath($document);

				// Strip comments
				if ($this->strip_comments)
				{
					$comments = $xpath->query('//comment()');

					foreach ($comments as $comment)
					{
						$comment->parentNode->removeChild($comment);
					}
				}

				// Strip out HTML tags and attributes that might cause various security problems.
				// Based on recommendations by Mark Pilgrim at:
				// http://diveintomark.org/archives/2003/06/12/how_to_consume_rss_safely
				if ($this->strip_htmltags)
				{
					foreach ($this->strip_htmltags as $tag)
					{
						$this->strip_tag($tag, $document, $xpath, $type);
					}
				}

				if ($this->rename_attributes)
				{
					foreach ($this->rename_attributes as $attrib)
					{
						$this->rename_attr($attrib, $xpath);
					}
				}

				if ($this->strip_attributes)
				{
					foreach ($this->strip_attributes as $attrib)
					{
						$this->strip_attr($attrib, $xpath);
					}
				}

				if ($this->add_attributes)
				{
					foreach ($this->add_attributes as $tag => $valuePairs)
					{
						$this->add_attr($tag, $valuePairs, $document);
					}
				}

				// Replace relative URLs
				$this->base = $base;
				foreach ($this->replace_url_attributes as $element => $attributes)
				{
					$this->replace_urls($document, $element, $attributes);
				}

				// If image handling (caching, etc.) is enabled, cache and rewrite all the image tags.
				if (isset($this->image_handler) && ((string) $this->image_handler) !== '' && $this->enable_cache)
				{
					$images = $document->getElementsByTagName('img');
					foreach ($images as $img)
					{
						if ($img->hasAttribute('src'))
						{
							$image_url = call_user_func($this->cache_name_function, $img->getAttribute('src'));
							$cache = $this->registry->call('Cache', 'get_handler', array($this->cache_location, $image_url, 'spi'));

							if ($cache->load())
							{
								$img->setAttribute('src', $this->image_handler . $image_url);
							}
							else
							{
								$file = $this->registry->create('File', array($img->getAttribute('src'), $this->timeout, 5, array('X-FORWARDED-FOR' => $_SERVER['REMOTE_ADDR']), $this->useragent, $this->force_fsockopen));
								$headers = $file->headers;

								if ($file->success && ($file->method & SIMPLEPIE_FILE_SOURCE_REMOTE === 0 || ($file->status_code === 200 || $file->status_code > 206 && $file->status_code < 300)))
								{
									if ($cache->save(array('headers' => $file->headers, 'body' => $file->body)))
									{
										$img->setAttribute('src', $this->image_handler . $image_url);
									}
									else
									{
										trigger_error("$this->cache_location is not writable. Make sure you've set the correct relative or absolute path, and that the location is server-writable.", E_USER_WARNING);
									}
								}
							}
						}
					}
				}

				// Get content node
				$div = $document->getElementsByTagName('body')->item(0)->firstChild;
				// Finally, convert to a HTML string
				$data = trim($document->saveHTML($div));

				if ($this->remove_div)
				{
					$data = preg_replace('/^<div' . SIMPLEPIE_PCRE_XML_ATTRIBUTE . '>/', '', $data);
					$data = preg_replace('/<\/div>$/', '', $data);
				}
				else
				{
					$data = preg_replace('/^<div' . SIMPLEPIE_PCRE_XML_ATTRIBUTE . '>/', '<div>', $data);
				}
			}

			if ($type & SIMPLEPIE_CONSTRUCT_IRI)
			{
				$absolute = $this->registry->call('Misc', 'absolutize_url', array($data, $base));
				if ($absolute !== false)
				{
					$data = $absolute;
				}
			}

			if ($type & (SIMPLEPIE_CONSTRUCT_TEXT | SIMPLEPIE_CONSTRUCT_IRI))
			{
				$data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
			}

			if ($this->output_encoding !== 'UTF-8')
			{
				$data = $this->registry->call('Misc', 'change_encoding', array($data, 'UTF-8', $this->output_encoding));
			}
		}
		return $data;
	}
}
