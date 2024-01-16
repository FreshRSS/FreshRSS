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
		return [['intitle:word1', ['word1'], null], ['intitle:word1-word2', ['word1-word2'], null], ['intitle:word1 word2', ['word1'], ['word2']], ['intitle:"word1 word2"', ['word1 word2'], null], ["intitle:'word1 word2'", ['word1 word2'], null], ['word1 intitle:word2', ['word2'], ['word1']], ['word1 intitle:word2 word3', ['word2'], ['word1', 'word3']], ['word1 intitle:"word2 word3"', ['word2 word3'], ['word1']], ["word1 intitle:'word2 word3'", ['word2 word3'], ['word1']], ['intitle:word1 intitle:word2', ['word1', 'word2'], null], ['intitle: word1 word2', null, ['word1', 'word2']], ['intitle:123', ['123'], null], ['intitle:"word1 word2" word3"', ['word1 word2'], ['word3"']], ["intitle:'word1 word2' word3'", ['word1 word2'], ["word3'"]], ['intitle:"word1 word2\' word3"', ["word1 word2' word3"], null], ["intitle:'word1 word2\" word3'", ['word1 word2" word3'], null], ["intitle:word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']], ['intitle:word1+word2', ['word1+word2'], null]];
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
		return [['author:word1', ['word1'], null], ['author:word1-word2', ['word1-word2'], null], ['author:word1 word2', ['word1'], ['word2']], ['author:"word1 word2"', ['word1 word2'], null], ["author:'word1 word2'", ['word1 word2'], null], ['word1 author:word2', ['word2'], ['word1']], ['word1 author:word2 word3', ['word2'], ['word1', 'word3']], ['word1 author:"word2 word3"', ['word2 word3'], ['word1']], ["word1 author:'word2 word3'", ['word2 word3'], ['word1']], ['author:word1 author:word2', ['word1', 'word2'], null], ['author: word1 word2', null, ['word1', 'word2']], ['author:123', ['123'], null], ['author:"word1 word2" word3"', ['word1 word2'], ['word3"']], ["author:'word1 word2' word3'", ['word1 word2'], ["word3'"]], ['author:"word1 word2\' word3"', ["word1 word2' word3"], null], ["author:'word1 word2\" word3'", ['word1 word2" word3'], null], ["author:word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']], ['author:word1+word2', ['word1+word2'], null]];
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
		return [['inurl:word1', ['word1'], null], ['inurl: word1', [], ['word1']], ['inurl:123', ['123'], null], ['inurl:word1 word2', ['word1'], ['word2']], ['inurl:"word1 word2"', ['"word1'], ['word2"']], ['inurl:word1 word2 inurl:word3', ['word1', 'word3'], ['word2']], ["inurl:word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']], ['inurl:word1+word2', ['word1+word2'], null]];
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
		return [['date:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', 1_172_754_000, 1_210_519_800], ['date:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', 1_172_754_000, 1_210_519_799], ['date:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', 1_172_754_001, 1_210_519_800], ['date:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1], ['date:2007-03-01/', strtotime('2007-03-01'), null], ['date:/2008-05-11', null, strtotime('2008-05-12') - 1]];
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
		return [['pubdate:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', 1_172_754_000, 1_210_519_800], ['pubdate:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', 1_172_754_000, 1_210_519_799], ['pubdate:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', 1_172_754_001, 1_210_519_800], ['pubdate:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1], ['pubdate:2007-03-01/', strtotime('2007-03-01'), null], ['pubdate:/2008-05-11', null, strtotime('2008-05-12') - 1]];
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
		return [['#word1', ['word1'], null], ['# word1', null, ['#', 'word1']], ['#123', ['123'], null], ['#word1 word2', ['word1'], ['word2']], ['#"word1 word2"', ['"word1'], ['word2"']], ['#word1 #word2', ['word1', 'word2'], null], ["#word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']], ['#word1+word2', ['word1 word2'], null]];
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
		return [['author:word1 date:2007-03-01/2008-05-11 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 #word5', ['word1'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word2'], ['word3'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word4', 'word5'], null], ['word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 date:2007-03-01/2008-05-11', ['word1'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word2'], ['word3'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word4', 'word5'], ['word6']], ['word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 word7 date:2007-03-01/2008-05-11', ['word1'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word2'], ['word3'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word4', 'word5'], ['word6', 'word7']], ['word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 "word7 word8" date:2007-03-01/2008-05-11', ['word1'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word2'], ['word3'], strtotime('2007-03-01'), strtotime('2008-05-12') - 1, ['word4', 'word5'], ['word7 word8', 'word6']]];
	}

	/**
	 * @dataProvider provideParentheses
	 * @param array<string> $values
	 */
	public function test__construct_parentheses(string $input, string $sql, array $values): void {
		[$filterValues, $filterSearch] = FreshRSS_EntryDAOPGSQL::sqlBooleanSearch('e.', new FreshRSS_BooleanSearch($input));
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
