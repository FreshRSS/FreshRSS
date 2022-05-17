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

use SimplePie\Misc;

/**
 * Miscellaneous utilities
 *
 * @package SimplePie
 */
class CustomSimplePieMisc extends Misc
{
	public static function absolutize_url($relative, $base)
	{
		if (substr($relative, 0, 2) === '//')
		{//Protocol-relative URLs "//www.example.net"
			return 'https:' . $relative;
		}
		$iri = SimplePie_IRI::absolutize(new SimplePie_IRI($base), $relative);
		if ($iri === false)
		{
			return false;
		}
		return $iri->get_uri();
	}

	public static function atom_10_content_construct_type($attribs)
	{
		$type = '';
		if (isset($attribs['']['type']))
		{
			$type = trim($attribs['']['type']);
		}
		elseif (isset($attribs[SIMPLEPIE_NAMESPACE_ATOM_10]['type']))
		{//FreshRSS
			$type = trim($attribs[SIMPLEPIE_NAMESPACE_ATOM_10]['type']);
		}
		if ($type != '')
		{
			$type = strtolower($type);
			switch ($type)
			{
				case 'text':
					return SIMPLEPIE_CONSTRUCT_TEXT;

				case 'html':
					return SIMPLEPIE_CONSTRUCT_HTML;

				case 'xhtml':
					return SIMPLEPIE_CONSTRUCT_XHTML;
			}
			if (in_array(substr($type, -4), array('+xml', '/xml')) || substr($type, 0, 5) === 'text/')
			{
				return SIMPLEPIE_CONSTRUCT_NONE;
			}
			else
			{
				return SIMPLEPIE_CONSTRUCT_BASE64;
			}
		}

		return SIMPLEPIE_CONSTRUCT_TEXT;
	}

	/**
	 * Get the SimplePie build timestamp
	 *
	 * Uses the git index if it exists, otherwise uses the modification time
	 * of the newest file.
	 */
	public static function get_build()
	{
		$mtime = @filemtime(dirname(dirname(__FILE__)) . '/SimplePie.php');	//FreshRSS
		return $mtime ? $mtime : filemtime(__FILE__);
	}
}
