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

use SimplePie\Parser;

/**
 * Parses XML into something sane
 *
 *
 * This class can be overloaded with {@see SimplePie::set_parser_class()}
 *
 * @package SimplePie
 * @subpackage Parsing
 */
class CustomSimplePieParser extends Parser
{
	public function parse(&$data, $encoding, $url = '')
	{
		$xmlEncoding = '';

		if (!empty($encoding))
		{
			// Use UTF-8 if we get passed US-ASCII, as every US-ASCII character is a UTF-8 character
			if (strtoupper($encoding) === 'US-ASCII')
			{
				$this->encoding = 'UTF-8';
			}
			else
			{
				$this->encoding = $encoding;
			}

			// Strip BOM:
			// UTF-32 Big Endian BOM
			if (substr($data, 0, 4) === "\x00\x00\xFE\xFF")
			{
				$data = substr($data, 4);
			}
			// UTF-32 Little Endian BOM
			elseif (substr($data, 0, 4) === "\xFF\xFE\x00\x00")
			{
				$data = substr($data, 4);
			}
			// UTF-16 Big Endian BOM
			elseif (substr($data, 0, 2) === "\xFE\xFF")
			{
				$data = substr($data, 2);
			}
			// UTF-16 Little Endian BOM
			elseif (substr($data, 0, 2) === "\xFF\xFE")
			{
				$data = substr($data, 2);
			}
			// UTF-8 BOM
			elseif (substr($data, 0, 3) === "\xEF\xBB\xBF")
			{
				$data = substr($data, 3);
			}

			if (substr($data, 0, 5) === '<?xml' && strspn(substr($data, 5, 1), "\x09\x0A\x0D\x20") && ($pos = strpos($data, '?>')) !== false)
			{
				$declaration = $this->registry->create('XML_Declaration_Parser', array(substr($data, 5, $pos - 5)));
				if ($declaration->parse())
				{
					$xmlEncoding = strtoupper($declaration->encoding);	//FreshRSS
					$data = substr($data, $pos + 2);
					$data = '<?xml version="' . $declaration->version . '" encoding="' . $encoding . '" standalone="' . (($declaration->standalone) ? 'yes' : 'no') . '"?>' . $data;
				}
				else
				{
					$this->error_string = 'SimplePie bug! Please report this!';
					return false;
				}
			}
		}

		if ($xmlEncoding === '' || $xmlEncoding === 'UTF-8')	//FreshRSS: case of no explicit HTTP encoding, and lax UTF-8
		{
			try
			{
				$dom = new DOMDocument();
				$dom->recover = true;
				$dom->strictErrorChecking = false;
				@$dom->loadXML($data, LIBXML_NOERROR | LIBXML_NOWARNING);
				$this->encoding = $encoding = $dom->encoding = 'UTF-8';
				$data2 = $dom->saveXML();
				if (function_exists('mb_convert_encoding'))
				{
					$data2 = mb_convert_encoding($data2, 'UTF-8', 'UTF-8');
				}
				if (strlen($data2) > (strlen($data) / 2.0))
				{
					$data = $data2;
				}
				unset($data2);
			}
			catch (Exception $e)
			{
			}
		}

		$return = true;

		static $xml_is_sane = null;
		if ($xml_is_sane === null)
		{
			$parser_check = xml_parser_create();
			xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
			xml_parser_free($parser_check);
			$xml_is_sane = isset($values[0]['value']);
		}

		// Create the parser
		if ($xml_is_sane)
		{
			$xml = xml_parser_create_ns($this->encoding, $this->separator);
			xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);
			xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);
			xml_set_object($xml, $this);
			xml_set_character_data_handler($xml, 'cdata');
			xml_set_element_handler($xml, 'tag_open', 'tag_close');

			// Parse!
			$wrapper = @is_writable(sys_get_temp_dir()) ? 'php://temp' : 'php://memory';
			if (($stream = fopen($wrapper, 'r+')) &&
				fwrite($stream, $data) &&
				rewind($stream))
			{
				//Parse by chunks not to use too much memory
				do
				{
					$stream_data = fread($stream, 1048576);
					if (!xml_parse($xml, $stream_data === false ? '' : $stream_data, feof($stream)))
					{
						$this->error_code = xml_get_error_code($xml);
						$this->error_string = xml_error_string($this->error_code);
						$return = false;
						break;
					}
				} while (!feof($stream));
				fclose($stream);
			}
			else
			{
				$return = false;
			}

			$this->current_line = xml_get_current_line_number($xml);
			$this->current_column = xml_get_current_column_number($xml);
			$this->current_byte = xml_get_current_byte_index($xml);
			xml_parser_free($xml);
			return $return;
		}

		libxml_clear_errors();
		$xml = new XMLReader();
		$xml->xml($data);
		while (@$xml->read())
		{
			switch ($xml->nodeType)
			{

				case constant('XMLReader::END_ELEMENT'):
					if ($xml->namespaceURI !== '')
					{
						$tagName = $xml->namespaceURI . $this->separator . $xml->localName;
					}
					else
					{
						$tagName = $xml->localName;
					}
					$this->tag_close(null, $tagName);
					break;
				case constant('XMLReader::ELEMENT'):
					$empty = $xml->isEmptyElement;
					if ($xml->namespaceURI !== '')
					{
						$tagName = $xml->namespaceURI . $this->separator . $xml->localName;
					}
					else
					{
						$tagName = $xml->localName;
					}
					$attributes = array();
					while ($xml->moveToNextAttribute())
					{
						if ($xml->namespaceURI !== '')
						{
							$attrName = $xml->namespaceURI . $this->separator . $xml->localName;
						}
						else
						{
							$attrName = $xml->localName;
						}
						$attributes[$attrName] = $xml->value;
					}
					$this->tag_open(null, $tagName, $attributes);
					if ($empty)
					{
						$this->tag_close(null, $tagName);
					}
					break;
				case constant('XMLReader::TEXT'):

				case constant('XMLReader::CDATA'):
					$this->cdata(null, $xml->value);
					break;
			}
		}
		if ($error = libxml_get_last_error())
		{
			$this->error_code = $error->code;
			$this->error_string = $error->message;
			$this->current_line = $error->line;
			$this->current_column = $error->column;
			return false;
		}

		return true;
	}
}
