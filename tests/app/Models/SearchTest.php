<?php
declare(strict_types=1);
require_once(LIB_PATH . '/lib_date.php');

class SearchTest extends PHPUnit\Framework\TestCase {

	/**
	 * @dataProvider provideEmptyInput
	 */
	public function test__construct_whenInputIsEmpty_getsOnlyNullValues(string $input): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals('', $search->getRawInput());
		self::assertNull($search->getIntitle());
		self::assertNull($search->getMinDate());
		self::assertNull($search->getMaxDate());
		self::assertNull($search->getMinPubdate());
		self::assertNull($search->getMaxPubdate());
		self::assertNull($search->getAuthor());
		self::assertNull($search->getTags());
		self::assertNull($search->getSearch());
	}

	/**
	 * Return an array of values for the search object.
	 * Here is the description of the values
	 * @return array{array{''},array{' '}}
	 */
	public function provideEmptyInput(): array {
		return [
			[''],
			[' '],
		];
	}

	/**
	 * @dataProvider provideIntitleSearch
	 * @param array<string>|null $intitle_value
	 * @param array<string>|null $search_value
	 */
	public function test__construct_whenInputContainsIntitle_setsIntitleProperty(string $input, ?array $intitle_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals($intitle_value, $search->getIntitle());
		self::assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array<array<mixed>>
	 */
	public function provideIntitleSearch(): array {
		return array(
			array('intitle:word1', array('word1'), null),
			array('intitle:word1-word2', array('word1-word2'), null),
			array('intitle:word1 word2', array('word1'), array('word2')),
			array('intitle:"word1 word2"', array('word1 word2'), null),
			array("intitle:'word1 word2'", array('word1 word2'), null),
			array('word1 intitle:word2', array('word2'), array('word1')),
			array('word1 intitle:word2 word3', array('word2'), array('word1', 'word3')),
			array('word1 intitle:"word2 word3"', array('word2 word3'), array('word1')),
			array("word1 intitle:'word2 word3'", array('word2 word3'), array('word1')),
			array('intitle:word1 intitle:word2', array('word1', 'word2'), null),
			array('intitle: word1 word2', null, array('word1', 'word2')),
			array('intitle:123', array('123'), null),
			array('intitle:"word1 word2" word3"', array('word1 word2'), array('word3"')),
			array("intitle:'word1 word2' word3'", array('word1 word2'), array("word3'")),
			array('intitle:"word1 word2\' word3"', array("word1 word2' word3"), null),
			array("intitle:'word1 word2\" word3'", array('word1 word2" word3'), null),
			array("intitle:word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
			['intitle:word1+word2', ['word1+word2'], null],
		);
	}

	/**
	 * @dataProvider provideAuthorSearch
	 * @param array<string>|null $author_value
	 * @param array<string>|null $search_value
	 */
	public function test__construct_whenInputContainsAuthor_setsAuthorValue(string $input, ?array $author_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals($author_value, $search->getAuthor());
		self::assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array<array<mixed>>
	 */
	public function provideAuthorSearch(): array {
		return array(
			array('author:word1', array('word1'), null),
			array('author:word1-word2', array('word1-word2'), null),
			array('author:word1 word2', array('word1'), array('word2')),
			array('author:"word1 word2"', array('word1 word2'), null),
			array("author:'word1 word2'", array('word1 word2'), null),
			array('word1 author:word2', array('word2'), array('word1')),
			array('word1 author:word2 word3', array('word2'), array('word1', 'word3')),
			array('word1 author:"word2 word3"', array('word2 word3'), array('word1')),
			array("word1 author:'word2 word3'", array('word2 word3'), array('word1')),
			array('author:word1 author:word2', array('word1', 'word2'), null),
			array('author: word1 word2', null, array('word1', 'word2')),
			array('author:123', array('123'), null),
			array('author:"word1 word2" word3"', array('word1 word2'), array('word3"')),
			array("author:'word1 word2' word3'", array('word1 word2'), array("word3'")),
			array('author:"word1 word2\' word3"', array("word1 word2' word3"), null),
			array("author:'word1 word2\" word3'", array('word1 word2" word3'), null),
			array("author:word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
			['author:word1+word2', ['word1+word2'], null],
		);
	}

	/**
	 * @dataProvider provideInurlSearch
	 * @param array<string>|null $inurl_value
	 * @param array<string>|null $search_value
	 */
	public function test__construct_whenInputContainsInurl_setsInurlValue(string $input, ?array $inurl_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals($inurl_value, $search->getInurl());
		self::assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array<array<mixed>>
	 */
	public function provideInurlSearch(): array {
		return array(
			array('inurl:word1', array('word1'), null),
			array('inurl: word1', array(), array('word1')),
			array('inurl:123', array('123'), null),
			array('inurl:word1 word2', array('word1'), array('word2')),
			array('inurl:"word1 word2"', array('"word1'), array('word2"')),
			array('inurl:word1 word2 inurl:word3', array('word1', 'word3'), array('word2')),
			array("inurl:word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
			['inurl:word1+word2', ['word1+word2'], null],
		);
	}

	/**
	 * @dataProvider provideDateSearch
	 */
	public function test__construct_whenInputContainsDate_setsDateValues(string $input, ?int $min_date_value, ?int $max_date_value): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals($min_date_value, $search->getMinDate());
		self::assertEquals($max_date_value, $search->getMaxDate());
	}

	/**
	 * @return array<array<mixed>>
	 */
	public function provideDateSearch(): array {
		return array(
			array('date:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', 1172754000, 1210519800),
			array('date:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', 1172754000, 1210519799),
			array('date:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', 1172754001, 1210519800),
			array('date:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1),
			array('date:2007-03-01/', strtotime('2007-03-01'), null),
			array('date:/2008-05-11', null, strtotime('2008-05-12') - 1),
		);
	}

	/**
	 * @dataProvider providePubdateSearch
	 */
	public function test__construct_whenInputContainsPubdate_setsPubdateValues(string $input, ?int $min_pubdate_value, ?int $max_pubdate_value): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals($min_pubdate_value, $search->getMinPubdate());
		self::assertEquals($max_pubdate_value, $search->getMaxPubdate());
	}

	/**
	 * @return array<array<mixed>>
	 */
	public function providePubdateSearch(): array {
		return array(
			array('pubdate:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', 1172754000, 1210519800),
			array('pubdate:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', 1172754000, 1210519799),
			array('pubdate:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', 1172754001, 1210519800),
			array('pubdate:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1),
			array('pubdate:2007-03-01/', strtotime('2007-03-01'), null),
			array('pubdate:/2008-05-11', null, strtotime('2008-05-12') - 1),
		);
	}

	/**
	 * @dataProvider provideTagsSearch
	 * @param array<string>|null $tags_value
	 * @param array<string>|null $search_value
	 */
	public function test__construct_whenInputContainsTags_setsTagsValue(string $input, ?array $tags_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals($tags_value, $search->getTags());
		self::assertEquals($search_value, $search->getSearch());
	}

	/**
	 * @return array<array<string|array<string>|null>>
	 */
	public function provideTagsSearch(): array {
		return array(
			array('#word1', array('word1'), null),
			array('# word1', null, array('#', 'word1')),
			array('#123', array('123'), null),
			array('#word1 word2', array('word1'), array('word2')),
			array('#"word1 word2"', array('"word1'), array('word2"')),
			array('#word1 #word2', array('word1', 'word2'), null),
			array("#word1 'word2 word3' word4", array('word1'), array('word2 word3', 'word4')),
			['#word1+word2', ['word1 word2'], null],
		);
	}

	/**
	 * @dataProvider provideMultipleSearch
	 * @param array<string>|null $author_value
	 * @param array<string> $intitle_value
	 * @param array<string>|null $inurl_value
	 * @param array<string>|null $tags_value
	 * @param array<string>|null $search_value
	 */
	public function test__construct_whenInputContainsMultipleKeywords_setsValues(string $input, ?array $author_value, ?int $min_date_value,
			?int $max_date_value, ?array $intitle_value, ?array $inurl_value, ?int $min_pubdate_value,
			?int $max_pubdate_value, ?array $tags_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertEquals($author_value, $search->getAuthor());
		self::assertEquals($min_date_value, $search->getMinDate());
		self::assertEquals($max_date_value, $search->getMaxDate());
		self::assertEquals($intitle_value, $search->getIntitle());
		self::assertEquals($inurl_value, $search->getInurl());
		self::assertEquals($min_pubdate_value, $search->getMinPubdate());
		self::assertEquals($max_pubdate_value, $search->getMaxPubdate());
		self::assertEquals($tags_value, $search->getTags());
		self::assertEquals($search_value, $search->getSearch());
		self::assertEquals($input, $search->getRawInput());
	}

	/** @return array<array<mixed>> */
	public function provideMultipleSearch(): array {
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

	/**
	 * @dataProvider provideParentheses
	 * @param array<string> $values
	 */
	public function test__construct_parentheses(string $input, string $sql, array $values): void {
		list($filterValues, $filterSearch) = FreshRSS_EntryDAOPGSQL::sqlBooleanSearch('e.', new FreshRSS_BooleanSearch($input));
		self::assertEquals($sql, $filterSearch);
		self::assertEquals($values, $filterValues);
	}

	/** @return array<array<mixed>> */
	public function provideParentheses(): array {
		return [
			[
				'f:1 (f:2 OR f:3 OR f:4) (f:5 OR (f:6 OR f:7))',
				' ((e.id_feed IN (?) )) AND ((e.id_feed IN (?) ) OR (e.id_feed IN (?) ) OR (e.id_feed IN (?) )) AND' .
					' (((e.id_feed IN (?) )) OR ((e.id_feed IN (?) ) OR (e.id_feed IN (?) ))) ',
				['1', '2', '3', '4', '5', '6', '7']
			],
			[
				'#tag Hello OR (author:Alice inurl:example) OR (f:3 intitle:World) OR L:12',
				" ((TRIM(e.tags) || ' #' LIKE ? AND (e.title LIKE ? OR e.content LIKE ?) )) OR ((e.author LIKE ? AND e.link LIKE ? )) OR" .
					' ((e.id_feed IN (?) AND e.title LIKE ? )) OR ((e.id IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (?)) )) ',
				['%tag #%','%Hello%', '%Hello%', '%Alice%', '%example%', '3', '%World%', '12']
			],
			[
				'#tag Hello (author:Alice inurl:example) (f:3 intitle:World) label:Bleu',
				" ((TRIM(e.tags) || ' #' LIKE ? AND (e.title LIKE ? OR e.content LIKE ?) )) AND" .
					' ((e.author LIKE ? AND e.link LIKE ? )) AND' .
					' ((e.id_feed IN (?) AND e.title LIKE ? )) AND' .
					' ((e.id IN (SELECT et.id_entry FROM `_entrytag` et, `_tag` t WHERE et.id_tag = t.id AND t.name IN (?)) )) ',
				['%tag #%', '%Hello%', '%Hello%', '%Alice%', '%example%', '3', '%World%', 'Bleu']
			],
			[
				'!((author:Alice intitle:hello) OR (author:Bob intitle:world))',
				' NOT (((e.author LIKE ? AND e.title LIKE ? )) OR ((e.author LIKE ? AND e.title LIKE ? ))) ',
				['%Alice%', '%hello%', '%Bob%', '%world%'],
			],
			[
				'(author:Alice intitle:hello) !(author:Bob intitle:world)',
				' ((e.author LIKE ? AND e.title LIKE ? )) AND NOT ((e.author LIKE ? AND e.title LIKE ? )) ',
				['%Alice%', '%hello%', '%Bob%', '%world%'],
			],
			[
				'intitle:"\\(test\\)"',
				'(e.title LIKE ? )',
				['%(test)%'],
			],
		];
	}
}
