<?php

require_once(LIB_PATH . '/lib_date.php');

class ContextTest extends \PHPUnit_Framework_TestCase {

	private $context;

	public function setUp() {
		$this->context = new FreshRSS_Context();
	}

	public function testParseSearch_whenEmpty_returnsEmptyArray() {
		$this->assertCount(0, $this->context->parseSearch());
	}

	/**
	 * @dataProvider provideMultipleKeywordSearch
	 * @param string $search
	 * @param string $expected_values
	 */
	public function testParseSearch_whenMultipleKeywords_returnArrayWithMultipleValues($search, $expected_values) {
		FreshRSS_Context::$search = $search;
		$parsed_search = $this->context->parseSearch();
		$this->assertEquals($expected_values, $parsed_search);
	}

	/**
	 * @return array
	 */
	public function provideMultipleKeywordSearch() {
		return array(
		    array(
			'intitle:word1 author:word2',
			array(
			    'intitle' => 'word1',
			    'author' => 'word2',
			),
		    ),
		    array(
			'author:word2 intitle:word1',
			array(
			    'intitle' => 'word1',
			    'author' => 'word2',
			),
		    ),
		    array(
			'author:word1 inurl:word2',
			array(
			    'author' => 'word1',
			    'inurl' => 'word2',
			),
		    ),
		    array(
			'inurl:word2 author:word1',
			array(
			    'author' => 'word1',
			    'inurl' => 'word2',
			),
		    ),
		    array(
			'date:2008-01-01/2008-02-01 pubdate:2007-01-01/2007-02-01',
			array(
			    'min_date' => '1199163600',
			    'max_date' => '1201928399',
			    'min_pubdate' => '1167627600',
			    'max_pubdate' => '1170392399',
			),
		    ),
		    array(
			'pubdate:2007-01-01/2007-02-01 date:2008-01-01/2008-02-01',
			array(
			    'min_date' => '1199163600',
			    'max_date' => '1201928399',
			    'min_pubdate' => '1167627600',
			    'max_pubdate' => '1170392399',
			),
		    ),
		    array(
			'inurl:word1 author:word2 intitle:word3 pubdate:2007-01-01/2007-02-01 date:2008-01-01/2008-02-01 hello world',
			array(
			    'inurl' => 'word1',
			    'author' => 'word2',
			    'intitle' => 'word3',
			    'min_date' => '1199163600',
			    'max_date' => '1201928399',
			    'min_pubdate' => '1167627600',
			    'max_pubdate' => '1170392399',
			    'search' => 'hello world',
			),
		    ),
		);
	}

	/**
	 * @dataProvider provideIntitleSearch
	 * @param string $search
	 * @param string $expected_value
	 */
	public function testParseSearch_whenIntitleKeyword_returnArrayWithIntitleValue($search, $expected_value) {
		FreshRSS_Context::$search = $search;
		$parsed_search = $this->context->parseSearch();
		$this->assertEquals($expected_value, $parsed_search['intitle']);
	}

	/**
	 * @return array
	 */
	public function provideIntitleSearch() {
		return array(
		    array('intitle:word1', 'word1'),
		    array('intitle:word1 word2', 'word1'),
		    array('intitle:"word1 word2"', 'word1 word2'),
		    array("intitle:'word1 word2'", 'word1 word2'),
		    array('word1 intitle:word2', 'word2'),
		    array('word1 intitle:word2 word3', 'word2'),
		    array('word1 intitle:"word2 word3"', 'word2 word3'),
		    array("word1 intitle:'word2 word3'", 'word2 word3'),
		    array('intitle:word1 intitle:word2', 'word1'),
		    array('intitle: word1 word2', ''),
		    array('intitle:123', '123'),
		    array('intitle:"word1 word2" word3"', 'word1 word2'),
		    array("intitle:'word1 word2' word3'", 'word1 word2'),
		    array('intitle:"word1 word2\' word3"', "word1 word2' word3"),
		    array("intitle:'word1 word2\" word3'", 'word1 word2" word3'),
		);
	}

	/**
	 * @dataProvider provideAuthorSearch
	 * @param string $search
	 * @param string $expected_value
	 */
	public function testParseSearch_whenAuthorKeyword_returnArrayWithAuthorValue($search, $expected_value) {
		FreshRSS_Context::$search = $search;
		$parsed_search = $this->context->parseSearch();
		$this->assertEquals($expected_value, $parsed_search['author']);
	}

	/**
	 * @return array
	 */
	public function provideAuthorSearch() {
		return array(
		    array('author:word1', 'word1'),
		    array('author:word1 word2', 'word1'),
		    array('author:"word1 word2"', 'word1 word2'),
		    array("author:'word1 word2'", 'word1 word2'),
		    array('word1 author:word2', 'word2'),
		    array('word1 author:word2 word3', 'word2'),
		    array('word1 author:"word2 word3"', 'word2 word3'),
		    array("word1 author:'word2 word3'", 'word2 word3'),
		    array('author:word1 author:word2', 'word1'),
		    array('author: word1 word2', ''),
		    array('author:123', '123'),
		    array('author:"word1 word2" word3"', 'word1 word2'),
		    array("author:'word1 word2' word3'", 'word1 word2'),
		    array('author:"word1 word2\' word3"', "word1 word2' word3"),
		    array("author:'word1 word2\" word3'", 'word1 word2" word3'),
		);
	}

	/**
	 * @dataProvider provideInurlSearch
	 * @param string $search
	 * @param string $expected_value
	 */
	public function testParseSearch_whenInurlKeyword_returnArrayWithInurlValue($search, $expected_value) {
		FreshRSS_Context::$search = $search;
		$parsed_search = $this->context->parseSearch();
		$this->assertEquals($expected_value, $parsed_search['inurl']);
	}

	/**
	 * @return array
	 */
	public function provideInurlSearch() {
		return array(
		    array('inurl:word1', 'word1'),
		    array('inurl: word1', ''),
		    array('inurl:123', '123'),
		    array('inurl:word1 word2', 'word1'),
		    array('inurl:"word1 word2"', '"word1'),
		);
	}

	/**
	 * @dataProvider provideDateSearch
	 * @param string $search
	 * @param string $expected_min_value
	 * @param string $expected_max_value
	 */
	public function testParseSearch_whenDateKeyword_returnArrayWithDateValues($search, $expected_min_value, $expected_max_value) {
		FreshRSS_Context::$search = $search;
		$parsed_search = $this->context->parseSearch();
		$this->assertEquals($expected_min_value, $parsed_search['min_date']);
		$this->assertEquals($expected_max_value, $parsed_search['max_date']);
	}

	/**
	 * @return array
	 */
	public function provideDateSearch() {
		return array(
		    array('date:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', '1172754000', '1210519800'),
		    array('date:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', '1172754000', '1210516199'),
		    array('date:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', '1172757601', '1210519800'),
		    array('date:2007-03-01/2008-05-11', '1172725200', '1210564799'),
		    array('date:2007-03-01/', '1172725200', ''),
		    array('date:/2008-05-11', '', '1210564799'),
		);
	}

	/**
	 * @dataProvider providePubdateSearch
	 * @param string $search
	 * @param string $expected_min_value
	 * @param string $expected_max_value
	 */
	public function testParseSearch_whenPubdateKeyword_returnArrayWithPubdateValues($search, $expected_min_value, $expected_max_value) {
		FreshRSS_Context::$search = $search;
		$parsed_search = $this->context->parseSearch();
		$this->assertEquals($expected_min_value, $parsed_search['min_pubdate']);
		$this->assertEquals($expected_max_value, $parsed_search['max_pubdate']);
	}

	/**
	 * @return array
	 */
	public function providePubdateSearch() {
		return array(
		    array('pubdate:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', '1172754000', '1210519800'),
		    array('pubdate:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', '1172754000', '1210516199'),
		    array('pubdate:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', '1172757601', '1210519800'),
		    array('pubdate:2007-03-01/2008-05-11', '1172725200', '1210564799'),
		    array('pubdate:2007-03-01/', '1172725200', ''),
		    array('pubdate:/2008-05-11', '', '1210564799'),
		);
	}

}
