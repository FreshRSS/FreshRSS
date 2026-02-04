<?php

namespace marienfressinaud\LibOpml;

/**
 * The LibOpml class provides the methods to read and write OPML files and
 * strings. It transforms OPML files or strings to PHP arrays (or the reverse).
 *
 * How to read this file?
 *
 * The first methods are dedicated to the parsing, and the next ones to the
 * reading. The three last methods are helpful methods, but you don't have to
 * worry too much about them.
 *
 * The main methods are the public ones: parseFile, parseString and render.
 * They call the other parse* and render* methods internally.
 *
 * These three main methods are available as functions (see the src/functions.php
 * file).
 *
 * What's the array format?
 *
 * As said before, LibOpml transforms OPML to PHP arrays, or the reverse. The
 * format is pretty simple. It contains four keys:
 *
 * - version: the version of the OPML;
 * - namespaces: an array of namespaces used in the OPML, if any;
 * - head: an array of OPML head elements, where keys are the names of the
 *   elements;
 * - body: an array of arrays representing OPML outlines, where keys are the
 *   name of the attributes (the special @outlines key contains the sub-outlines).
 *
 * When rendering, only the body key is required (version will default to 2.0).
 *
 * Example:
 *
 * [
 *     version => '2.0',
 *     namespaces => [],
 *     head => [
 *         title => 'An OPML file'
 *     ],
 *     body => [
 *         [
 *             text => 'Newspapers',
 *             @outlines => [
 *                 [text => 'El País'],
 *                 [text => 'Le Monde'],
 *                 [text => 'The Guardian'],
 *                 [text => 'The New York Times'],
 *             ]
 *         ]
 *     ]
 * ]
 *
 * @see http://opml.org/spec2.opml
 *
 * @author Marien Fressinaud <dev@marienfressinaud.fr>
 * @link https://framagit.org/marienfressinaud/lib_opml
 * @license MIT
 */
class LibOpml
{
    /**
     * The list of valid head elements.
     */
    public const HEAD_ELEMENTS = [
        'title', 'dateCreated', 'dateModified', 'ownerName', 'ownerEmail',
        'ownerId', 'docs', 'expansionState', 'vertScrollState', 'windowTop',
        'windowLeft', 'windowBottom', 'windowRight'
    ];

    /**
     * The list of numeric head elements.
     */
    public const NUMERIC_HEAD_ELEMENTS = [
        'vertScrollState',
        'windowTop',
        'windowLeft',
        'windowBottom',
        'windowRight',
    ];

    /** @var boolean */
    private $strict = true;

    /** @var string */
    private $version = '2.0';

    /** @var string[] */
    private $namespaces = [];

    /**
     * @param bool $strict
     *     Set to true (default) to check for violations of the specification,
     *     false otherwise.
     */
    public function __construct($strict = true)
    {
        $this->strict = $strict;
    }

    /**
     * Parse a XML file and return the corresponding array.
     *
     * @param string $filename
     *     The XML file to parse.
     *
     * @throws \marienfressinaud\LibOpml\Exception
     *     Raised if the file cannot be read. See also exceptions raised by the
     *     parseString method.
     *
     * @return array
     *     An array reflecting the OPML (the structure is described above).
     */
    public function parseFile($filename)
    {
        $file_content = @file_get_contents($filename);

        if ($file_content === false) {
            throw new Exception("OPML file {$filename} cannot be found or read");
        }

        return $this->parseString($file_content);
    }

    /**
     * Parse a XML string and return the corresponding array.
     *
     * @param string $xml
     *     The XML string to parse.
     *
     * @throws \marienfressinaud\LibOpml\Exception
     *     Raised if the XML cannot be parsed, if version is missing or
     *     invalid, if head is missing or contains invalid (or not parsable)
     *     elements, or if body is missing, empty or contain non outline
     *     elements. The exceptions (except XML parsing errors) are not raised
     *     if strict is false. See also exceptions raised by the parseOutline
     *     method.
     *
     * @return array
     *     An array reflecting the OPML (the structure is described above).
     */
    public function parseString($xml)
    {
        $dom = new \DOMDocument();
        $dom->recover = true;
        $dom->encoding = 'UTF-8';

        try {
            $result = @$dom->loadXML($xml);
        } catch (\Exception | \Error $e) {
            $result = false;
        }

        if (!$result || !$dom->documentElement) {
            throw new Exception('OPML string is not valid XML');
        }

        $opml_element = $dom->documentElement;

        // Load the custom namespaces of the document
        $xpath = new \DOMXPath($dom);
        $this->namespaces = [];
        foreach ($xpath->query('//namespace::*') as $node) {
            if ($node->prefix === 'xml') {
                // This is the base namespace, we don't need to store it
                continue;
            }

            $this->namespaces[$node->prefix] = $node->namespaceURI;
        }

        // Get the version of the document
        $version = $opml_element->getAttribute('version');
        if (!$version) {
            $this->throwExceptionIfStrict('OPML version attribute is required');
        }

        $version = trim($version);
        if ($version === '1.1') {
            $version = '1.0';
        }

        if ($version !== '1.0' && $version !== '2.0') {
            $this->throwExceptionIfStrict('OPML supported versions are 1.0 and 2.0');
        }

        $this->version = $version;

        // Get head and body child elements
        $head_elements = $opml_element->getElementsByTagName('head');
        $child_head_elements = [];
        if (count($head_elements) === 1) {
            $child_head_elements = $head_elements[0]->childNodes;
        } else {
            $this->throwExceptionIfStrict('OPML must contain one and only one head element');
        }

        $body_elements = $opml_element->getElementsByTagName('body');
        $child_body_elements = [];
        if (count($body_elements) === 1) {
            $child_body_elements = $body_elements[0]->childNodes;
        } else {
            $this->throwExceptionIfStrict('OPML must contain one and only one body element');
        }

        $array = [
            'version' => $this->version,
            'namespaces' => $this->namespaces,
            'head' => [],
            'body' => [],
        ];

        // Load the child head elements in the head array
        foreach ($child_head_elements as $child_head_element) {
            if ($child_head_element->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            $name = $child_head_element->nodeName;
            $value = $child_head_element->nodeValue;
            $namespaced = $child_head_element->namespaceURI !== null;

            if (!in_array($name, self::HEAD_ELEMENTS) && !$namespaced) {
                $this->throwExceptionIfStrict(
                    "OPML head {$name} element is not part of the specification"
                );
            }

            if ($name === 'dateCreated' || $name === 'dateModified') {
                try {
                    $value = $this->parseDate($value);
                } catch (\DomainException $e) {
                    $this->throwExceptionIfStrict(
                        "OPML head {$name} element must be a valid RFC822 or RFC1123 date"
                    );
                }
            } elseif ($name === 'ownerEmail') {
                // Testing email validity is hard. PHP filter_var() function is
                // too strict compared to the RFC 822, so we can't use it.
                if (strpos($value, '@') === false) {
                    $this->throwExceptionIfStrict(
                        'OPML head ownerEmail element must be an email address'
                    );
                }
            } elseif ($name === 'ownerId' || $name === 'docs') {
                if (!$this->checkHttpAddress($value)) {
                    $this->throwExceptionIfStrict(
                        "OPML head {$name} element must be a HTTP address"
                    );
                }
            } elseif ($name === 'expansionState') {
                $numbers = explode(',', $value);
                $value = array_map(function ($str_number) {
                    if (is_numeric($str_number)) {
                        return intval($str_number);
                    } else {
                        $this->throwExceptionIfStrict(
                            'OPML head expansionState element must be a list of numbers'
                        );
                        return $str_number;
                    }
                }, $numbers);
            } elseif (in_array($name, self::NUMERIC_HEAD_ELEMENTS)) {
                if (is_numeric($value)) {
                    $value = intval($value);
                } else {
                    $this->throwExceptionIfStrict("OPML head {$name} element must be a number");
                }
            }

            $array['head'][$name] = $value;
        }

        // Load the child body elements in the body array
        foreach ($child_body_elements as $child_body_element) {
            if ($child_body_element->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            if ($child_body_element->nodeName === 'outline') {
                $array['body'][] = $this->parseOutline($child_body_element);
            } else {
                $this->throwExceptionIfStrict(
                    'OPML body element can only contain outline elements'
                );
            }
        }

        if (empty($array['body'])) {
            $this->throwExceptionIfStrict(
                'OPML body element must contain at least one outline element'
            );
        }

        return $array;
    }

    /**
     * Parse a XML element as an outline element and return the corresponding array.
     *
     * @param \DOMElement $outline_element
     *     The element to parse.
     *
     * @throws \marienfressinaud\LibOpml\Exception
     *     Raised if the outline contains non-outline elements, if it doesn't
     *     contain a text attribute (or if empty), if a special attribute is
     *     not parsable, or if type attribute requirements are not met. The
     *     exceptions are not raised if strict is false. The exception about
     *     missing text attribute is not raised if version is 1.0.
     *
     * @return array
     *     An array reflecting the OPML outline (the structure is described above).
     */
    private function parseOutline($outline_element)
    {
        $outline = [];

        // Load the element attributes in the outline array
        foreach ($outline_element->attributes as $outline_attribute) {
            $name = $outline_attribute->nodeName;
            $value = $outline_attribute->nodeValue;

            if ($name === 'created') {
                try {
                    $value = $this->parseDate($value);
                } catch (\DomainException $e) {
                    $this->throwExceptionIfStrict(
                        'OPML outline created attribute must be a valid RFC822 or RFC1123 date'
                    );
                }
            } elseif ($name === 'category') {
                $categories = explode(',', $value);
                $categories = array_map(function ($category) {
                    return trim($category);
                }, $categories);
                $value = $categories;
            } elseif ($name === 'isComment' || $name === 'isBreakpoint') {
                if ($value === 'true' || $value === 'false') {
                    $value = $value === 'true';
                } else {
                    $this->throwExceptionIfStrict(
                        "OPML outline {$name} attribute must be a boolean (true or false)"
                    );
                }
            } elseif ($name === 'type') {
                // type attribute is case-insensitive
                $value = strtolower($value);
            }

            $outline[$name] = $value;
        }

        if (empty($outline['text']) && $this->version !== '1.0') {
            $this->throwExceptionIfStrict(
                'OPML outline text attribute is required'
            );
        }

        // Perform additional check based on the type of the outline
        $type = $outline['type'] ?? '';
        if ($type === 'rss') {
            if (empty($outline['xmlUrl'])) {
                $this->throwExceptionIfStrict(
                    'OPML outline xmlUrl attribute is required when type is "rss"'
                );
            } elseif (!$this->checkHttpAddress($outline['xmlUrl'])) {
                $this->throwExceptionIfStrict(
                    'OPML outline xmlUrl attribute must be a HTTP address when type is "rss"'
                );
            }
        } elseif ($type === 'link' || $type === 'include') {
            if (empty($outline['url'])) {
                $this->throwExceptionIfStrict(
                    "OPML outline url attribute is required when type is \"{$type}\""
                );
            } elseif (!$this->checkHttpAddress($outline['url'])) {
                $this->throwExceptionIfStrict(
                    "OPML outline url attribute must be a HTTP address when type is \"{$type}\""
                );
            }
        }

        // Load the sub-outlines in a @outlines array
        foreach ($outline_element->childNodes as $child_outline_element) {
            if ($child_outline_element->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            if ($child_outline_element->nodeName === 'outline') {
                $outline['@outlines'][] = $this->parseOutline($child_outline_element);
            } else {
                $this->throwExceptionIfStrict(
                    'OPML body element can only contain outline elements'
                );
            }
        }

        return $outline;
    }

    /**
     * Parse a value as a date.
     *
     * @param string $value
     *
     * @throws \DomainException
     *     Raised if the value cannot be parsed.
     *
     * @return \DateTime
     */
    private function parseDate($value)
    {
        $formats = [
            \DateTimeInterface::RFC822,
            \DateTimeInterface::RFC1123,
        ];

        foreach ($formats as $format) {
            $date = date_create_from_format($format, $value);
            if ($date !== false) {
                return $date;
            }
        }

        throw new \DomainException('The argument cannot be parsed as a date');
    }

    /**
     * Render an OPML array as a string or a \DOMDocument.
     *
     * @param array $array
     *     The array to render, it must follow the structure defined above.
     * @param bool $as_dom_document
     *     Set to false (default) to return the array as a string, true to
     *     return as a \DOMDocument.
     *
     * @throws \marienfressinaud\LibOpml\Exception
     *     Raised if the `head` array contains unknown or invalid elements
     *     (i.e. not of correct type), or if the `body` array is missing or
     *     empty. The exceptions are not raised if strict is false. See also
     *     exceptions raised by the renderOutline method.
     *
     * @return string|\DOMDocument
     *     The XML string or DOM document corresponding to the given array.
     */
    public function render($array, $as_dom_document = false)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $opml_element = new \DOMElement('opml');
        $dom->appendChild($opml_element);

        // Set the version attribute of the OPML document
        $version = $array['version'] ?? '2.0';

        if ($version === '1.1') {
            $version = '1.0';
        }

        if ($version !== '1.0' && $version !== '2.0') {
            $this->throwExceptionIfStrict('OPML supported versions are 1.0 and 2.0');
        }

        $this->version = $version;
        $opml_element->setAttribute('version', $this->version);

        // Declare the namespace on the opml element
        $this->namespaces = $array['namespaces'] ?? [];
        foreach ($this->namespaces as $prefix => $namespace) {
            $opml_element->setAttributeNS(
                'http://www.w3.org/2000/xmlns/',
                "xmlns:{$prefix}",
                $namespace
            );
        }

        // Add the head element to the OPML document. $array['head'] is
        // optional but head tag will always exist in the final XML.
        $head_element = new \DOMElement('head');
        $opml_element->appendChild($head_element);
        if (isset($array['head'])) {
            foreach ($array['head'] as $name => $value) {
                $namespace = $this->getNamespace($name);

                if (!in_array($name, self::HEAD_ELEMENTS, true) && !$namespace) {
                    $this->throwExceptionIfStrict(
                        "OPML head {$name} element is not part of the specification"
                    );
                }

                if ($name === 'dateCreated' || $name === 'dateModified') {
                    if ($value instanceof \DateTimeInterface) {
                        $value = $value->format(\DateTimeInterface::RFC1123);
                    } else {
                        $this->throwExceptionIfStrict(
                            "OPML head {$name} element must be a DateTime"
                        );
                    }
                } elseif ($name === 'ownerEmail') {
                    // Testing email validity is hard. PHP filter_var() function is
                    // too strict compared to the RFC 822, so we can't use it.
                    if (strpos($value, '@') === false) {
                        $this->throwExceptionIfStrict(
                            'OPML head ownerEmail element must be an email address'
                        );
                    }
                } elseif ($name === 'ownerId' || $name === 'docs') {
                    if (!$this->checkHttpAddress($value)) {
                        $this->throwExceptionIfStrict(
                            "OPML head {$name} element must be a HTTP address"
                        );
                    }
                } elseif ($name === 'expansionState') {
                    if (is_array($value)) {
                        foreach ($value as $number) {
                            if (!is_int($number)) {
                                $this->throwExceptionIfStrict(
                                    'OPML head expansionState element must be an array of integers'
                                );
                            }
                        }

                        $value = implode(', ', $value);
                    } else {
                        $this->throwExceptionIfStrict(
                            'OPML head expansionState element must be an array of integers'
                        );
                    }
                } elseif (in_array($name, self::NUMERIC_HEAD_ELEMENTS)) {
                    if (!is_int($value)) {
                        $this->throwExceptionIfStrict(
                            "OPML head {$name} element must be an integer"
                        );
                    }
                }

                $child_head_element = new \DOMElement($name, $value, $namespace);
                $head_element->appendChild($child_head_element);
            }
        }

        // Check body is set and contains at least one element
        if (!isset($array['body'])) {
            $this->throwExceptionIfStrict('OPML array must contain a body key');
        }

        $array_body = $array['body'] ?? [];
        if (count($array_body) <= 0) {
            $this->throwExceptionIfStrict(
                'OPML body element must contain at least one outline array'
            );
        }

        // Create outline elements in the body element
        $body_element = new \DOMElement('body');
        $opml_element->appendChild($body_element);
        foreach ($array_body as $outline) {
            $this->renderOutline($body_element, $outline);
        }

        // And return the final result
        if ($as_dom_document) {
            return $dom;
        } else {
            $dom->formatOutput = true;
            return $dom->saveXML();
        }
    }

    /**
     * Transform an outline array to a \DOMElement and add it to a parent element.
     *
     * @param \DOMElement $parent_element
     *     The DOM parent element of the current outline.
     * @param array $outline
     *     The outline array to transform in a \DOMElement, it must follow the
     *     structure defined above.
     *
     * @throws \marienfressinaud\LibOpml\Exception
     *     Raised if the outline is not an array, if it doesn't contain a text
     *     attribute (or if empty), if the `@outlines` key is not an array, if
     *     a special attribute does not match its corresponding type, or if
     *     `type` key requirements are not met. The exceptions (except errors
     *     about outline or suboutlines not being arrays) are not raised if
     *     strict is false. The exception about missing text attribute is not
     *     raised if version is 1.0.
     */
    private function renderOutline($parent_element, $outline)
    {
        // Perform initial checks to verify the outline is correctly declared
        if (!is_array($outline)) {
            throw new Exception(
                'OPML outline element must be defined as an array'
            );
        }

        if (empty($outline['text']) && $this->version !== '1.0') {
            $this->throwExceptionIfStrict(
                'OPML outline text attribute is required'
            );
        }

        if (isset($outline['type'])) {
            $type = strtolower($outline['type']);

            if ($type === 'rss') {
                if (empty($outline['xmlUrl'])) {
                    $this->throwExceptionIfStrict(
                        'OPML outline xmlUrl attribute is required when type is "rss"'
                    );
                } elseif (!$this->checkHttpAddress($outline['xmlUrl'])) {
                    $this->throwExceptionIfStrict(
                        'OPML outline xmlUrl attribute must be a HTTP address when type is "rss"'
                    );
                }
            } elseif ($type === 'link' || $type === 'include') {
                if (empty($outline['url'])) {
                    $this->throwExceptionIfStrict(
                        "OPML outline url attribute is required when type is \"{$type}\""
                    );
                } elseif (!$this->checkHttpAddress($outline['url'])) {
                    $this->throwExceptionIfStrict(
                        "OPML outline url attribute must be a HTTP address when type is \"{$type}\""
                    );
                }
            }
        }

        // Create the outline element and add it to the parent
        $outline_element = new \DOMElement('outline');
        $parent_element->appendChild($outline_element);

        // Load the sub-outlines as child elements
        if (isset($outline['@outlines'])) {
            $outline_children = $outline['@outlines'];

            if (!is_array($outline_children)) {
                throw new Exception(
                    'OPML outline element must be defined as an array'
                );
            }

            foreach ($outline_children as $outline_child) {
                $this->renderOutline($outline_element, $outline_child);
            }

            // We don't want the sub-outlines to be loaded as attributes, so we
            // remove the key from the array.
            unset($outline['@outlines']);
        }

        // Load the other elements of the array as attributes
        foreach ($outline as $name => $value) {
            $namespace = $this->getNamespace($name);

            if ($name === 'created') {
                if ($value instanceof \DateTimeInterface) {
                    $value = $value->format(\DateTimeInterface::RFC1123);
                } else {
                    $this->throwExceptionIfStrict(
                        'OPML outline created attribute must be a DateTime'
                    );
                }
            } elseif ($name === 'isComment' || $name === 'isBreakpoint') {
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                } else {
                    $this->throwExceptionIfStrict(
                        "OPML outline {$name} attribute must be a boolean"
                    );
                }
            } elseif (is_array($value)) {
                $value = implode(', ', $value);
            }

            $outline_element->setAttributeNS($namespace, $name, $value);
        }
    }

    /**
     * Return wether a value is a valid HTTP address or not.
     *
     * HTTP address is not strictly defined by the OPML spec, so it is assumed:
     *
     * - it can be parsed by parse_url
     * - it has a host part
     * - scheme is http or https
     *
     * filter_var is not used because it would reject internationalized URLs
     * (i.e. with non ASCII chars). An alternative would be to punycode such
     * URLs, but it's more work to do it properly, and lib_opml needs to stay
     * simple.
     *
     * @param string $value
     *
     * @return boolean
     *     Return true if the value is a valid HTTP address, false otherwise.
     */
    public function checkHttpAddress($value)
    {
        $value = trim($value);
        $parsed_url = parse_url($value);
        if (!$parsed_url) {
            return false;
        }

        if (
            !isset($parsed_url['scheme']) ||
            !isset($parsed_url['host'])
        ) {
            return false;
        }

        if (
            $parsed_url['scheme'] !== 'http' &&
            $parsed_url['scheme'] !== 'https'
        ) {
            return false;
        }

        return true;
    }

    /**
     * Return the namespace of a qualified name. An empty string is returned if
     * the name is not namespaced.
     *
     * @param string $qualified_name
     *
     * @throws \marienfressinaud\LibOpml\Exception
     *     Raised if the namespace prefix isn't declared.
     *
     * @return string
     */
    private function getNamespace($qualified_name)
    {
        $split_name = explode(':', $qualified_name, 2);
        // count will always be 1 or 2.
        if (count($split_name) === 1) {
            // If 1, there's no prefix, thus no namespace
            return '';
        } else {
            // If 2, it means it has a namespace prefix, so we get the
            // namespace from the declared ones.
            $namespace_prefix = $split_name[0];
            if (!isset($this->namespaces[$namespace_prefix])) {
                throw new Exception(
                    "OPML namespace {$namespace_prefix} is not declared"
                );
            }

            return $this->namespaces[$namespace_prefix];
        }
    }

    /**
     * Raise an exception only if strict is true.
     *
     * @param string $message
     *
     * @throws \marienfressinaud\LibOpml\Exception
     */
    private function throwExceptionIfStrict($message)
    {
        if ($this->strict) {
            throw new Exception($message);
        }
    }
}
