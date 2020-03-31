<?php

require_once(LIB_PATH . '/lib_date.php');

class SearchTest extends PHPUnit\Framework\TestCase {

	/**
	 * @dataProvider provideEmptyInput
	 * @param string|null $input
	 */
	public function test__construct_whenInputIsEmpty_getsOnlyNullValues($input) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals('', $search->getRawInput());
		$this->assertNull($search->getIntitle());
		$this->assertNull($search->getMinDate());
		$this->assertNull($search->getMaxDate());
		$this->assertNull($search->getMinPubdate());
		$this->assertNull($search->getMaxPubdate());
		$this->assertNull($search->getAuthor());
		$this->assertNull($search->getTags());
		$this->assertNull($search->getSearch());
	}

	/**
	 * Return an array of values for the search object.
	 * Here is the description of the values
	 * @return array
	 */
	public function provideEmptyInput() {
		return array(
			array(''),
			array(null),
		);
	}

	/**
	 * @dataProvider provideIntitleSearch
	 * @param string $input
	 * @param string $intitle_value
	 * @param string|null $search_value
	 */
	public function test__construct_whenInputContainsIntitle_setsIntitlePropery($input, $intitle_value, $search_value) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals($intitle_value, $search->getIntitle());
		$this->assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array
	 */
	public function provideIntitleSearch() {
		return array(
			array('intitle:word1', array('word1'), null),
			array('intitle:word1 word2', array('word1'), array('word2')),
			array('intitle:"word1 word2"', array('word1 word2'), null),
			array("intitle:'word1 word2'", array('word1 word2'), null),
			array('word1 intitle:word2', array('word2'), array('word1')),
			array('word1 intitle:word2 word3', array('word2'), array('word1', 'word3')),
			array('word1 intitle:"word2 word3"', array('word2 word3'), array('word1')),
			array("word1 intitle:'word2 word3'", array('word2 word3'), array('word1')),
			array('intitle:word1 intitle:word2', array('word1', 'word2'), null),
			array('intitle: word1 word2', array(), array('word1', 'word2')),
			array('intitle:123', array('123'), null),
			array('intitle:"word1 word2" word3"', array('word1 word2'), array('word3"')),
			array("intitle:'word1 word2' word3'", array('word1 word2'), array("word3'")),
			array('intitle:"word1 word2\' word3"', array("word1 word2' word3"), null),
			array("intitle:'word1 word2\" word3'", array('word1 word2" word3'), null),
			array("intitle:word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
		);
	}

	/**
	 * @dataProvider provideAuthorSearch
	 * @param string $input
	 * @param string $author_value
	 * @param string|null $search_value
	 */
	public function test__construct_whenInputContainsAuthor_setsAuthorValue($input, $author_value, $search_value) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals($author_value, $search->getAuthor());
		$this->assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array
	 */
	public function provideAuthorSearch() {
		return array(
			array('author:word1', array('word1'), null),
			array('author:word1 word2', array('word1'), array('word2')),
			array('author:"word1 word2"', array('word1 word2'), null),
			array("author:'word1 word2'", array('word1 word2'), null),
			array('word1 author:word2', array('word2'), array('word1')),
			array('word1 author:word2 word3', array('word2'), array('word1', 'word3')),
			array('word1 author:"word2 word3"', array('word2 word3'), array('word1')),
			array("word1 author:'word2 word3'", array('word2 word3'), array('word1')),
			array('author:word1 author:word2', array('word1', 'word2'), null),
			array('author: word1 word2', array(), array('word1', 'word2')),
			array('author:123', array('123'), null),
			array('author:"word1 word2" word3"', array('word1 word2'), array('word3"')),
			array("author:'word1 word2' word3'", array('word1 word2'), array("word3'")),
			array('author:"word1 word2\' word3"', array("word1 word2' word3"), null),
			array("author:'word1 word2\" word3'", array('word1 word2" word3'), null),
			array("author:word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
		);
	}

	/**
	 * @dataProvider provideInurlSearch
	 * @param string $input
	 * @param string $inurl_value
	 * @param string|null $search_value
	 */
	public function test__construct_whenInputContainsInurl_setsInurlValue($input, $inurl_value, $search_value) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals($inurl_value, $search->getInurl());
		$this->assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array
	 */
	public function provideInurlSearch() {
		return array(
			array('inurl:word1', array('word1'), null),
			array('inurl: word1', array(), array('word1')),
			array('inurl:123', array('123'), null),
			array('inurl:word1 word2', array('word1'), array('word2')),
			array('inurl:"word1 word2"', array('"word1'), array('word2"')),
			array('inurl:word1 word2 inurl:word3', array('word1', 'word3'), array('word2')),
			array("inurl:word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
		);
	}

	/**
	 * @dataProvider provideDateSearch
	 * @param string $input
	 * @param string $min_date_value
	 * @param string $max_date_value
	 */
	public function test__construct_whenInputContainsDate_setsDateValues($input, $min_date_value, $max_date_value) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals($min_date_value, $search->getMinDate());
		$this->assertEquals($max_date_value, $search->getMaxDate());
	}

	/**
	 * @return array
	 */
	public function provideDateSearch() {
		return array(
			array('date:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', '1172754000', '1210519800'),
			array('!date:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', '1210519800', '1172754000'),
			array('date:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', '1172754000', '1210519799'),
			array('date:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', '1172754001', '1210519800'),
			array('date:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1),
			array('date:2007-03-01/', strtotime('2007-03-01'), ''),
			array('date:/2008-05-11', '', strtotime('2008-05-12') - 1),
		);
	}

	/**
	 * @dataProvider providePubdateSearch
	 * @param string $input
	 * @param string $min_pubdate_value
	 * @param string $max_pubdate_value
	 */
	public function test__construct_whenInputContainsPubdate_setsPubdateValues($input, $min_pubdate_value, $max_pubdate_value) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals($min_pubdate_value, $search->getMinPubdate());
		$this->assertEquals($max_pubdate_value, $search->getMaxPubdate());
	}

	/**
	 * @return array
	 */
	public function providePubdateSearch() {
		return array(
			array('pubdate:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', '1172754000', '1210519800'),
			array('!pubdate:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', '1210519800', '1172754000'),
			array('pubdate:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', '1172754000', '1210519799'),
			array('pubdate:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', '1172754001', '1210519800'),
			array('pubdate:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1),
			array('pubdate:2007-03-01/', strtotime('2007-03-01'), ''),
			array('pubdate:/2008-05-11', '', strtotime('2008-05-12') - 1),
		);
	}

	/**
	 * @dataProvider provideTagsSearch
	 * @param string $input
	 * @param string $tags_value
	 * @param string|null $search_value
	 */
	public function test__construct_whenInputContainsTags_setsTagsValue($input, $tags_value, $search_value) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals($tags_value, $search->getTags());
		$this->assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array
	 */
	public function provideTagsSearch() {
		return array(
			array('#word1', array('word1'), null),
			array('# word1', array(), array('#', 'word1')),
			array('#123', array('123'), null),
			array('#word1 word2', array('word1'), array('word2')),
			array('#"word1 word2"', array('"word1'), array('word2"')),
			array('#word1 #word2', array('word1', 'word2'), null),
			array("#word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
		);
	}

	/**
	 * @dataProvider provideMultipleSearch
	 * @param string $input
	 * @param string $author_value
	 * @param string $min_date_value
	 * @param string $max_date_value
	 * @param string $intitle_value
	 * @param string $inurl_value
	 * @param string $min_pubdate_value
	 * @param string $max_pubdate_value
	 * @param array $tags_value
	 * @param string|null $search_value
	 */
	public function test__construct_whenInputContainsMultipleKeywords_setsValues($input, $author_value, $min_date_value, $max_date_value, $intitle_value, $inurl_value, $min_pubdate_value, $max_pubdate_value, $tags_value, $search_value) {
		$search = new FreshRSS_Search($input);
		$this->assertEquals($author_value, $search->getAuthor());
		$this->assertEquals($min_date_value, $search->getMinDate());
		$this->assertEquals($max_date_value, $search->getMaxDate());
		$this->assertEquals($intitle_value, $search->getIntitle());
		$this->assertEquals($inurl_value, $search->getInurl());
		$this->assertEquals($min_pubdate_value, $search->getMinPubdate());
		$this->assertEquals($max_pubdate_value, $search->getMaxPubdate());
		$this->assertEquals($tags_value, $search->getTags());
		$this->assertEquals($search_value, $search->getSearch());
		$this->assertEquals($input, $search->getRawInput());
	}

	public function provideMultipleSearch() {
		return array(
			array(
				'author:word1 date:2007-03-01/2008-05-11 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 #word5',
				array('word1'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word2'),
				array('word3'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word4', 'word5'),
				null,
			),
			array(
				'word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 date:2007-03-01/2008-05-11',
				array('word1'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word2'),
				array('word3'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word4', 'word5'),
				array('word6'),
			),
			array(
				'word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 word7 date:2007-03-01/2008-05-11',
				array('word1'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word2'),
				array('word3'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word4', 'word5'),
				array('word6', 'word7'),
			),
			array(
				'word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 "word7 word8" date:2007-03-01/2008-05-11',
				array('word1'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word2'),
				array('word3'),
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				array('word4', 'word5'),
				array('word7 word8', 'word6'),
			),
		);
	}

}
