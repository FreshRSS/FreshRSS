<?php

/**
 * lib_opml is a free library to manage OPML format in PHP.
 *
 * By default, it takes in consideration version 2.0 but can be compatible with
 * OPML 1.0. More information on http://dev.opml.org.
 * Difference is "text" attribute is optional in version 1.0. It is highly
 * recommended to use this attribute.
 *
 * lib_opml requires SimpleXML (php.net/simplexml) and DOMDocument (php.net/domdocument)
 *
 * @author   Marien Fressinaud <dev@marienfressinaud.fr>
 * @link     https://github.com/marienfressinaud/lib_opml
 * @version  0.2
 * @license  public domain
 *
 * Usages:
 * > include('lib_opml.php');
 * > $filename = 'my_opml_file.xml';
 * > $opml_array = libopml_parse_file($filename);
 * > print_r($opml_array);
 *
 * > $opml_string = [...];
 * > $opml_array = libopml_parse_string($opml_string);
 * > print_r($opml_array);
 *
 * > $opml_array = [...];
 * > $opml_string = libopml_render($opml_array);
 * > $opml_object = libopml_render($opml_array, true);
 * > echo $opml_string;
 * > print_r($opml_object);
 *
 * You can set $strict argument to false if you want to bypass "text" attribute
 * requirement.
 *
 * If parsing fails for any reason (e.g. not an XML string, does not match with
 * the specifications), a LibOPML_Exception is raised.
 *
 * lib_opml array format is described here:
 * $array = array(
 *     'head' => array(       // 'head' element is optional (but recommended)
 *         'key' => 'value',  // key must be a part of available OPML head elements
 *     ),
 *     'body' => array(              // body is required
 *         array(                    // this array represents an outline (at least one)
 *             'text' => 'value',    // 'text' element is required if $strict is true
 *             'key' => 'value',     // key and value are what you want (optional)
 *             '@outlines' = array(  // @outlines is a special value and represents sub-outlines
 *                 array(
 *                     [...]         // where [...] is a valid outline definition
 *                 ),
 *             ),
 *         ),
 *         array(                    // other outline definitions
 *             [...]
 *         ),
 *         [...],
 *     )
 * )
 *
 */

/**
 * A simple Exception class which represents any kind of OPML problem.
 * Message should precise the current problem.
 */
class LibOPML_Exception extends Exception {}


// Define the list of available head attributes. All of them are optional.
define('HEAD_ELEMENTS', serialize(array(
	'title', 'dateCreated', 'dateModified', 'ownerName', 'ownerEmail',
	'ownerId', 'docs', 'expansionState', 'vertScrollState', 'windowTop',
	'windowLeft', 'windowBottom', 'windowRight'
)));


/**
 * Parse an XML object as an outline object and return corresponding array
 *
 * @param SimpleXMLElement $outline_xml the XML object we want to parse
 * @param bool $strict true if "text" attribute is required, false else
 * @return array corresponding to an outline and following format described above
 * @throws LibOPML_Exception
 * @access private
 */
function libopml_parse_outline($outline_xml, $strict = true) {
	$outline = array();

	// An outline may contain any kind of attributes but "text" attribute is
	// required !
	$text_is_present = false;
	foreach ($outline_xml->attributes() as $key => $value) {
		$outline[$key] = (string)$value;

		if ($key === 'text') {
			$text_is_present = true;
		}
	}

	if (!$text_is_present && $strict) {
		throw new LibOPML_Exception(
			'Outline does not contain any text attribute'
		);
	}

	if (empty($outline['text']) && isset($outline['title'])) {
		$outline['text'] = $outline['title'];
	}

	foreach ($outline_xml->children() as $key => $value) {
		// An outline may contain any number of outline children
		if ($key === 'outline') {
			$outline['@outlines'][] = libopml_parse_outline($value, $strict);
		} else {
			throw new LibOPML_Exception(
				'Body can contain only outline elements'
			);
		}
	}

	return $outline;
}


/**
 * Parse a string as a XML one and returns the corresponding array
 *
 * @param string $xml is the string we want to parse
 * @param bool $strict true if "text" attribute is required, false else
 * @return array corresponding to the XML string and following format described above
 * @throws LibOPML_Exception
 * @access public
 */
function libopml_parse_string($xml, $strict = true) {
	$dom = new DOMDocument();
	$dom->recover = true;
	$dom->strictErrorChecking = false;
	$dom->loadXML($xml);
	$dom->encoding = 'UTF-8';

	$opml = simplexml_import_dom($dom);

	if (!$opml) {
		throw new LibOPML_Exception();
	}

	$array = array(
		'version' => (string)$opml['version'],
		'head' => array(),
		'body' => array()
	);

	// First, we get all "head" elements. Head is required but its sub-elements
	// are optional.
	foreach ($opml->head->children() as $key => $value) {
		if (in_array($key, unserialize(HEAD_ELEMENTS), true)) {
			$array['head'][$key] = (string)$value;
		} else {
			throw new LibOPML_Exception(
				$key . 'is not part of OPML format'
			);
		}
	}

	// Then, we get body oulines. Body must contain at least one outline
	// element.
	$at_least_one_outline = false;
	foreach ($opml->body->children() as $key => $value) {
		if ($key === 'outline') {
			$at_least_one_outline = true;
			$array['body'][] = libopml_parse_outline($value, $strict);
		} else {
			throw new LibOPML_Exception(
				'Body can contain only outline elements'
			);
		}
	}

	if (!$at_least_one_outline) {
		throw new LibOPML_Exception(
			'Body must contain at least one outline element'
		);
	}

	return $array;
}


/**
 * Parse a string contained into a file as a XML string and returns the corresponding array
 *
 * @param string $filename should indicates a valid XML file
 * @param bool $strict true if "text" attribute is required, false else
 * @return array corresponding to the file content and following format described above
 * @throws LibOPML_Exception
 * @access public
 */
function libopml_parse_file($filename, $strict = true) {
	$file_content = file_get_contents($filename);

	if ($file_content === false) {
		throw new LibOPML_Exception(
			$filename . ' cannot be found'
		);
	}

	return libopml_parse_string($file_content, $strict);
}


/**
 * Create a XML outline object in a parent object.
 *
 * @param SimpleXMLElement $parent_elt is the parent object of current outline
 * @param array $outline array representing an outline object
 * @param bool $strict true if "text" attribute is required, false else
 * @throws LibOPML_Exception
 * @access private
 */
function libopml_render_outline($parent_elt, $outline, $strict) {
	// Outline MUST be an array!
	if (!is_array($outline)) {
		throw new LibOPML_Exception(
			'Outline element must be defined as array'
		);
	}

	$outline_elt = $parent_elt->addChild('outline');
	$text_is_present = false;
	foreach ($outline as $key => $value) {
		// Only outlines can be an array and so we consider children are also
		// outline elements.
		if ($key === '@outlines' && is_array($value)) {
			foreach ($value as $outline_child) {
				libopml_render_outline($outline_elt, $outline_child, $strict);
			}
		} elseif (is_array($value)) {
			throw new LibOPML_Exception(
				'Type of outline elements cannot be array: ' . $key
			);
		} else {
			// Detect text attribute is present, that's good :)
			if ($key === 'text') {
				$text_is_present = true;
			}

			$outline_elt->addAttribute($key, $value);
		}
	}

	if (!$text_is_present && $strict) {
		throw new LibOPML_Exception(
			'You must define at least a text element for all outlines'
		);
	}
}


/**
 * Render an array as an OPML string or a XML object.
 *
 * @param array $array is the array we want to render and must follow structure defined above
 * @param bool $as_xml_object false if function must return a string, true for a XML object
 * @param bool $strict true if "text" attribute is required, false else
 * @return string|SimpleXMLElement XML string corresponding to $array or XML object
 * @throws LibOPML_Exception
 * @access public
 */
function libopml_render($array, $as_xml_object = false, $strict = true) {
	$opml = new SimpleXMLElement('<opml></opml>');
	$opml->addAttribute('version', $strict ? '2.0' : '1.0');

	// Create head element. $array['head'] is optional but head element will
	// exist in the final XML object.
	$head = $opml->addChild('head');
	if (isset($array['head'])) {
		foreach ($array['head'] as $key => $value) {
			if (in_array($key, unserialize(HEAD_ELEMENTS), true)) {
				$head->addChild($key, $value);
			}
		}
	}

	// Check body is set and contains at least one element
	if (!isset($array['body'])) {
		throw new LibOPML_Exception(
			'$array must contain a body element'
		);
	}
	if (count($array['body']) <= 0) {
		throw new LibOPML_Exception(
			'Body element must contain at least one element (array)'
		);
	}

	// Create outline elements
	$body = $opml->addChild('body');
	foreach ($array['body'] as $outline) {
		libopml_render_outline($body, $outline, $strict);
	}

	// And return the final result
	if ($as_xml_object) {
		return $opml;
	} else {
		$dom = dom_import_simplexml($opml)->ownerDocument;
		$dom->formatOutput = true;
		$dom->encoding = 'UTF-8';
		return $dom->saveXML();
	}
}
