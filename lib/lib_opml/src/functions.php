<?php

if (!function_exists('libopml_parse_file')) {
    /**
     * Parse an OPML file and return a PHP array.
     *
     * @see \marienfressinaud\LibOpml\LibOpml::parseFile
     *
     * Note the strict parameter is false by default to be able to read most of
     * the files.
     */
    function libopml_parse_file($filename, $strict = false)
    {
        $libopml = new \marienfressinaud\LibOpml\LibOpml($strict);
        return $libopml->parseFile($filename);
    }
}

if (!function_exists('libopml_parse_string')) {
    /**
     * Parse an OPML string and return a PHP array.
     *
     * @see \marienfressinaud\LibOpml\LibOpml::parseString
     *
     * Note the strict parameter is false by default to be able to read most of
     * the strings.
     */
    function libopml_parse_string($xml, $strict = false)
    {
        $libopml = new \marienfressinaud\LibOpml\LibOpml($strict);
        return $libopml->parseString($xml);
    }
}

if (!function_exists('libopml_render')) {
    /**
     * Transform a PHP array to an OPML string.
     *
     * @see \marienfressinaud\LibOpml\LibOpml::render
     *
     * Note the strict parameter is true by default to encourage generation of
     * valid OPMLs.
     */
    function libopml_render($array, $as_dom_document = false, $strict = true)
    {
        $libopml = new \marienfressinaud\LibOpml\LibOpml($strict);
        return $libopml->render($array, $as_dom_document);
    }
}
