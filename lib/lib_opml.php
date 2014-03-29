<?php

/* *
 * lib_opml is a free library to manage OPML format in PHP.
 * It takes in consideration only version 2.0 (http://dev.opml.org/spec2.html).
 * Basically it means "text" attribute for outline elements is required.
 *
 * lib_opml requires SimpleXML (http://php.net/manual/en/book.simplexml.php)
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
 * If parsing fails for any reason (e.g. not an XML string, does not match with
 * the specifications), a LibOPML_Exception is raised.
 *
 * Author: Marien Fressinaud <dev@marienfressinaud.fr>
 * Url: https://github.com/marienfressinaud/lib_opml
 * Version: 0.1
 * Date: 2014-03-29
 * License: public domain
 *
 * */

class LibOPML_Exception extends Exception {}


// These elements are optional
define('HEAD_ELEMENTS', serialize(array(
	'title', 'dateCreated', 'dateModified', 'ownerName', 'ownerEmail',
	'ownerId', 'docs', 'expansionState', 'vertScrollState', 'windowTop',
	'windowLeft', 'windowBottom', 'windowRight'
)));


function libopml_parse_outline($outline_xml) {
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

	if (!$text_is_present) {
		throw new LibOPML_Exception(
			'Outline does not contain any text attribute'
		);
	}

	foreach ($outline_xml->children() as $key => $value) {
		// An outline may contain any number of outline children
		if ($key === 'outline') {
			$outline['@outlines'][] = libopml_parse_outline($value);
		} else {
			throw new LibOPML_Exception(
				'Body can contain only outline elements'
			);
		}
	}

	return $outline;
}


function libopml_parse_string($xml) {
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
			$array['body'][] = libopml_parse_outline($value);
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


function libopml_parse_file($filename) {
	$file_content = file_get_contents($filename);

	if ($file_content === false) {
		throw new LibOPML_Exception(
			$filename . ' cannot be found'
		);
	}

	return libopml_parse_string($file_content);
}


function libopml_render_outline($parent_elt, $outline) {
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
				libopml_render_outline($outline_elt, $outline_child);
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

	if (!$text_is_present) {
		throw new LibOPML_Exception(
			'You must define at least a text element for all outlines'
		);
	}
}


function libopml_render($array, $as_xml_object = false) {
	$opml = new SimpleXMLElement('<opml version="2.0"></opml>');

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
		libopml_render_outline($body, $outline);
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
