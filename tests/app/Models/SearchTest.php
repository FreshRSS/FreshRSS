<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

require_once(LIB_PATH . '/lib_date.php');

class SearchTest extends PHPUnit\Framework\TestCase {

	#[DataProvider('provideEmptyInput')]
	public static function test__construct_whenInputIsEmpty_getsOnlyNullValues(string $input): void {
		$search = new FreshRSS_Search($input);
		self::assertSame('', $search->getRawInput());
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
	public static function provideEmptyInput(): array {
		return [
			[''],
			[' '],
		];
	}

	/**
	 * @param array<string>|null $intitle_value
	 * @param array<string>|null $search_value
	 */
	#[DataProvider('provideIntitleSearch')]
	public static function test__construct_whenInputContainsIntitle_setsIntitleProperty(string $input, ?array $intitle_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($intitle_value, $search->getIntitle());
		self::assertSame($search_value, $search->getSearch());
	}

	/**
	 * @return list<list<mixed>>
	 */
	public static function provideIntitleSearch(): array {
		return [
			['intitle:word1', ['word1'], null],
			['intitle:word1-word2', ['word1-word2'], null],
			['intitle:word1 word2', ['word1'], ['word2']],
			['intitle:"word1 word2"', ['word1 word2'], null],
			["intitle:'word1 word2'", ['word1 word2'], null],
			['word1 intitle:word2', ['word2'], ['word1']],
			['word1 intitle:word2 word3', ['word2'], ['word1', 'word3']],
			['word1 intitle:"word2 word3"', ['word2 word3'], ['word1']],
			["word1 intitle:'word2 word3'", ['word2 word3'], ['word1']],
			['intitle:word1 intitle:word2', ['word1', 'word2'], null],
			['intitle: word1 word2', null, ['word1', 'word2']],
			['intitle:123', ['123'], null],
			['intitle:"word1 word2" word3"', ['word1 word2'], ['word3"']],
			["intitle:'word1 word2' word3'", ['word1 word2'], ["word3'"]],
			['intitle:"word1 word2\' word3"', ["word1 word2' word3"], null],
			["intitle:'word1 word2\" word3'", ['word1 word2" word3'], null],
			["intitle:word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']],
			['intitle:word1+word2', ['word1+word2'], null],
		];
	}

	/**
	 * @param array<string>|null $intext_value
	 * @param array<string>|null $search_value
	 */
	#[DataProvider('provideIntextSearch')]
	public static function test__construct_whenInputContainsIntext(string $input, ?array $intext_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($intext_value, $search->getIntext());
		self::assertSame($search_value, $search->getSearch());
	}

	/**
	 * @return list<list<mixed>>
	 */
	public static function provideIntextSearch(): array {
		return [
			['intext:word1', ['word1'], null],
			['intext:"word1 word2"', ['word1 word2'], null],
		];
	}

	/**
	 * @param array<string>|null $author_value
	 * @param array<string>|null $search_value
	 */
	#[DataProvider('provideAuthorSearch')]
	public static function test__construct_whenInputContainsAuthor_setsAuthorValue(string $input, ?array $author_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($author_value, $search->getAuthor());
		self::assertSame($search_value, $search->getSearch());
	}

	/**
	 * @return list<list<mixed>>
	 */
	public static function provideAuthorSearch(): array {
		return [
			['author:word1', ['word1'], null],
			['author:word1-word2', ['word1-word2'], null],
			['author:word1 word2', ['word1'], ['word2']],
			['author:"word1 word2"', ['word1 word2'], null],
			["author:'word1 word2'", ['word1 word2'], null],
			['word1 author:word2', ['word2'], ['word1']],
			['word1 author:word2 word3', ['word2'], ['word1', 'word3']],
			['word1 author:"word2 word3"', ['word2 word3'], ['word1']],
			["word1 author:'word2 word3'", ['word2 word3'], ['word1']],
			['author:word1 author:word2', ['word1', 'word2'], null],
			['author: word1 word2', null, ['word1', 'word2']],
			['author:123', ['123'], null],
			['author:"word1 word2" word3"', ['word1 word2'], ['word3"']],
			["author:'word1 word2' word3'", ['word1 word2'], ["word3'"]],
			['author:"word1 word2\' word3"', ["word1 word2' word3"], null],
			["author:'word1 word2\" word3'", ['word1 word2" word3'], null],
			["author:word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']],
			['author:word1+word2', ['word1+word2'], null],
		];
	}

	/**
	 * @param array<string>|null $inurl_value
	 * @param array<string>|null $search_value
	 */
	#[DataProvider('provideInurlSearch')]
	public static function test__construct_whenInputContainsInurl_setsInurlValue(string $input, ?array $inurl_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($inurl_value, $search->getInurl());
		self::assertSame($search_value, $search->getSearch());
	}

	/**
	 * @return list<list<mixed>>
	 */
	public static function provideInurlSearch(): array {
		return [
			['inurl:word1', ['word1'], null],
			['inurl: word1', null, ['word1']],
			['inurl:123', ['123'], null],
			['inurl:word1 word2', ['word1'], ['word2']],
			['inurl:"word1 word2"', ['word1 word2'], null],
			['inurl:word1 word2 inurl:word3', ['word1', 'word3'], ['word2']],
			["inurl:word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']],
			['inurl:word1+word2', ['word1+word2'], null],
		];
	}

	#[DataProvider('provideDateSearch')]
	public static function test__construct_whenInputContainsDate_setsDateValues(string $input, ?int $min_date_value, ?int $max_date_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($min_date_value, $search->getMinDate());
		self::assertSame($max_date_value, $search->getMaxDate());
	}

	/**
	 * @return list<list<mixed>>
	 */
	public static function provideDateSearch(): array {
		return [
			['date:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', 1172754000, 1210519800],
			['date:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', 1172754000, 1210519799],
			['date:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', 1172754001, 1210519800],
			['date:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1],
			['date:2007-03-01/', strtotime('2007-03-01'), null],
			['date:/2008-05-11', null, strtotime('2008-05-12') - 1],
		];
	}

	#[DataProvider('providePubdateSearch')]
	public static function test__construct_whenInputContainsPubdate_setsPubdateValues(string $input, ?int $min_pubdate_value, ?int $max_pubdate_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($min_pubdate_value, $search->getMinPubdate());
		self::assertSame($max_pubdate_value, $search->getMaxPubdate());
	}

	/**
	 * @return list<list<mixed>>
	 */
	public static function providePubdateSearch(): array {
		return [
			['pubdate:2007-03-01T13:00:00Z/2008-05-11T15:30:00Z', 1172754000, 1210519800],
			['pubdate:2007-03-01T13:00:00Z/P1Y2M10DT2H30M', 1172754000, 1210519799],
			['pubdate:P1Y2M10DT2H30M/2008-05-11T15:30:00Z', 1172754001, 1210519800],
			['pubdate:2007-03-01/2008-05-11', strtotime('2007-03-01'), strtotime('2008-05-12') - 1],
			['pubdate:2007-03-01/', strtotime('2007-03-01'), null],
			['pubdate:/2008-05-11', null, strtotime('2008-05-12') - 1],
		];
	}

	/**
	 * @param array<string>|null $tags_value
	 * @param array<string>|null $search_value
	 */
	#[DataProvider('provideTagsSearch')]
	public static function test__construct_whenInputContainsTags_setsTagsValue(string $input, ?array $tags_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($tags_value, $search->getTags());
		self::assertSame($search_value, $search->getSearch());
	}

	/**
	 * @return list<list<string|list<string>|null>>
	 */
	public static function provideTagsSearch(): array {
		return [
			['#word1', ['word1'], null],
			['# word1', null, ['#', 'word1']],
			['#123', ['123'], null],
			['#word1 word2', ['word1'], ['word2']],
			['#"word1 word2"', ['word1 word2'], null],
			['#word1 #word2', ['word1', 'word2'], null],
			["#word1 'word2 word3' word4", ['word1'], ['word2 word3', 'word4']],
			['#word1+word2', ['word1 word2'], null]
		];
	}

	/**
	 * @param array<string>|null $author_value
	 * @param array<string> $intitle_value
	 * @param array<string>|null $inurl_value
	 * @param array<string>|null $tags_value
	 * @param array<string>|null $search_value
	 */
	#[DataProvider('provideMultipleSearch')]
	public static function test__construct_whenInputContainsMultipleKeywords_setsValues(string $input, ?array $author_value, ?int $min_date_value,
			?int $max_date_value, ?array $intitle_value, ?array $inurl_value, ?int $min_pubdate_value,
			?int $max_pubdate_value, ?array $tags_value, ?array $search_value): void {
		$search = new FreshRSS_Search($input);
		self::assertSame($author_value, $search->getAuthor());
		self::assertSame($min_date_value, $search->getMinDate());
		self::assertSame($max_date_value, $search->getMaxDate());
		self::assertSame($intitle_value, $search->getIntitle());
		self::assertSame($inurl_value, $search->getInurl());
		self::assertSame($min_pubdate_value, $search->getMinPubdate());
		self::assertSame($max_pubdate_value, $search->getMaxPubdate());
		self::assertSame($tags_value, $search->getTags());
		self::assertSame($search_value, $search->getSearch());
		self::assertSame($input, $search->getRawInput());
	}

	/** @return list<list<mixed>> */
	public static function provideMultipleSearch(): array {
		return [
			[
				'author:word1 date:2007-03-01/2008-05-11 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 #word5',
				['word1'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word2'],
				['word3'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word4', 'word5'],
				null
			],
			[
				'word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 date:2007-03-01/2008-05-11',
				['word1'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word2'],
				['word3'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word4', 'word5'],
				['word6']
			],
			[
				'word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 word7 date:2007-03-01/2008-05-11',
				['word1'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word2'],
				['word3'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word4', 'word5'],
				['word6', 'word7']
			],
			[
				'word6 intitle:word2 inurl:word3 pubdate:2007-03-01/2008-05-11 #word4 author:word1 #word5 "word7 word8" date:2007-03-01/2008-05-11',
				['word1'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word2'],
				['word3'],
				strtotime('2007-03-01'),
				strtotime('2008-05-12') - 1,
				['word4', 'word5'],
				['word7 word8', 'word6']
			]
		];
	}

	#[DataProvider('provideAddOrParentheses')]
	public static function test__addOrParentheses(string $input, string $output): void {
		self::assertSame($output, FreshRSS_BooleanSearch::addOrParentheses($input));
	}

	/** @return list<list{string,string}> */
	public static function provideAddOrParentheses(): array {
		return [
			['ab', 'ab'],
			['ab cd', 'ab cd'],
			['!ab -cd', '!ab -cd'],
			['ab OR cd', '(ab) OR (cd)'],
			['!ab OR -cd', '(!ab) OR (-cd)'],
			['ab cd OR ef OR "gh ij"', '(ab cd) OR (ef) OR ("gh ij")'],
			['ab (!cd)', 'ab (!cd)'],
			['"ab" (!"cd")', '"ab" (!"cd")'],
		];
	}

	#[DataProvider('provideconsistentOrParentheses')]
	public static function test__consistentOrParentheses(string $input, string $output): void {
		self::assertSame($output, FreshRSS_BooleanSearch::consistentOrParentheses($input));
	}

	/** @return list<list{string,string}> */
	public static function provideconsistentOrParentheses(): array {
		return [
			['ab cd ef', 'ab cd ef'],
			['(ab cd ef)', '(ab cd ef)'],
			['("ab cd" ef)', '("ab cd" ef)'],
			['"ab cd" (ef gh) "ij kl"', '"ab cd" (ef gh) "ij kl"'],
			['ab (!cd)', 'ab (!cd)'],
			['ab !(cd)', 'ab !(cd)'],
			['(ab) -(cd)', '(ab) -(cd)'],
			['ab cd OR ef OR "gh ij"', 'ab cd OR ef OR "gh ij"'],
			['"plain or text" OR (cd)', '("plain or text") OR (cd)'],
			['(ab) OR cd OR ef OR (gh)', '(ab) OR (cd) OR (ef) OR (gh)'],
			['(ab (cd OR ef)) OR gh OR ij OR (kl)', '(ab (cd OR ef)) OR (gh) OR (ij) OR (kl)'],
			['(ab (cd OR ef OR (gh))) OR ij', '(ab ((cd) OR (ef) OR (gh))) OR (ij)'],
			['(ab (!cd OR ef OR (gh))) OR ij', '(ab ((!cd) OR (ef) OR (gh))) OR (ij)'],
			['(ab !(cd OR ef OR !(gh))) OR ij', '(ab !((cd) OR (ef) OR !(gh))) OR (ij)'],
			['"ab" OR (!"cd")', '("ab") OR (!"cd")'],
		];
	}

	/**
	 * @param array<string> $values
	 */
	#[DataProvider('provideParentheses')]
	public function test__parentheses(string $input, string $sql, array $values): void {
		[$filterValues, $filterSearch] = FreshRSS_EntryDAOPGSQL::sqlBooleanSearch('e.', new FreshRSS_BooleanSearch($input));
		self::assertSame(trim($sql), trim($filterSearch));
		self::assertSame($values, $filterValues);
	}

	/** @return list<list<mixed>> */
	public static function provideParentheses(): array {
		return [
			[
				'f:1 (f:2 OR f:3 OR f:4) (f:5 OR (f:6 OR f:7))',
				' ((e.id_feed IN (?) )) AND ((e.id_feed IN (?) ) OR (e.id_feed IN (?) ) OR (e.id_feed IN (?) )) AND' .
					' (((e.id_feed IN (?) )) OR ((e.id_feed IN (?) ) OR (e.id_feed IN (?) ))) ',
				[1, 2, 3, 4, 5, 6, 7]
			],
			[
				'c:1 OR c:2,3',
				' (e.id_feed IN (SELECT f.id FROM `_feed` f WHERE f.category IN (?)) ) OR (e.id_feed IN (SELECT f.id FROM `_feed` f WHERE f.category IN (?,?)) ) ',
				[1, 2, 3]
			],
			[
				'#tag Hello OR (author:Alice inurl:example) OR (f:3 intitle:World) OR L:12',
				" ((TRIM(e.tags) || ' #' LIKE ? AND (e.title LIKE ? OR e.content LIKE ?) )) OR ((e.author LIKE ? AND e.link LIKE ? )) OR" .
					' ((e.id_feed IN (?) AND e.title LIKE ? )) OR ((e.id IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (?)) )) ',
				['%tag #%', '%Hello%', '%Hello%', '%Alice%', '%example%', 3, '%World%', 12]
			],
			[
				'#tag Hello (author:Alice inurl:example) (f:3 intitle:World) label:Bleu',
				" ((TRIM(e.tags) || ' #' LIKE ? AND (e.title LIKE ? OR e.content LIKE ?) )) AND" .
					' ((e.author LIKE ? AND e.link LIKE ? )) AND' .
					' ((e.id_feed IN (?) AND e.title LIKE ? )) AND' .
					' ((e.id IN (SELECT et.id_entry FROM `_entrytag` et, `_tag` t WHERE et.id_tag = t.id AND t.name IN (?)) )) ',
				['%tag #%', '%Hello%', '%Hello%', '%Alice%', '%example%', 3, '%World%', 'Bleu']
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
				'intitle:"(test)"',
				'(e.title LIKE ? )',
				['%(test)%'],
			],
			[
				'intitle:\'"hello world"\'',
				'(e.title LIKE ? )',
				['%"hello world"%'],
			],
			[
				'intext:\'"hello world"\'',
				'(e.content LIKE ? )',
				['%"hello world"%'],
			],
			[
				'(ab) OR (cd) OR (ef)',
				'(((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%'],
			],
			[
				'("plain or text") OR (cd)',
				'(((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) ))',
				['%plain or text%', '%plain or text%', '%cd%', '%cd%'],
			],
			[
				'"plain or text" OR cd',
				'((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) )',
				['%plain or text%', '%plain or text%', '%cd%', '%cd%'],
			],
			[
				'"plain OR text" OR cd',
				'((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) ) ',
				['%plain OR text%', '%plain OR text%', '%cd%', '%cd%'],
			],
			[
				'ab OR cd OR (ef)',
				'(((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) )) ',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%'],
			],
			[
				'ab OR cd OR ef',
				'((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) )',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%'],
			],
			[
				'(ab) cd OR ef OR (gh)',
				'(((e.title LIKE ? OR e.content LIKE ?) )) AND (((e.title LIKE ? OR e.content LIKE ?) )) ' .
					'OR (((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%', '%gh%', '%gh%'],
			],
			[
				'(ab) OR cd OR ef OR (gh)',
				'(((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) )) ' .
					'OR (((e.title LIKE ? OR e.content LIKE ?) )) OR (((e.title LIKE ? OR e.content LIKE ?) ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%', '%gh%', '%gh%'],
			],
			[
				'ab OR (!(cd OR ef))',
				'(((e.title LIKE ? OR e.content LIKE ?) )) OR (NOT (((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) )))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%'],
			],
			[
				'ab !(cd OR ef)',
				'(((e.title LIKE ? OR e.content LIKE ?) )) AND NOT (((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%'],
			],
			[
				'ab OR !(cd OR ef)',
				'(((e.title LIKE ? OR e.content LIKE ?) )) OR NOT (((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%'],
			],
			[
				'(ab (!cd OR ef OR (gh))) OR !(ij OR kl)',
				'((((e.title LIKE ? OR e.content LIKE ?) )) AND (((e.title NOT LIKE ? AND e.content NOT LIKE ? )) OR (((e.title LIKE ? OR e.content LIKE ?) )) ' .
					'OR (((e.title LIKE ? OR e.content LIKE ?) )))) OR NOT (((e.title LIKE ? OR e.content LIKE ?) ) OR ((e.title LIKE ? OR e.content LIKE ?) ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%', '%gh%', '%gh%', '%ij%', '%ij%', '%kl%', '%kl%'],
			],
			[
				'"ab" "cd" ("ef") intitle:"gh" !"ij" -"kl"',
				'(((e.title LIKE ? OR e.content LIKE ?) AND (e.title LIKE ? OR e.content LIKE ?) )) AND (((e.title LIKE ? OR e.content LIKE ?) )) ' .
					'AND ((e.title LIKE ? AND e.title NOT LIKE ? AND e.content NOT LIKE ? AND e.title NOT LIKE ? AND e.content NOT LIKE ? ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%', '%gh%', '%ij%', '%ij%', '%kl%', '%kl%']
			],
			[
				'&quot;ab&quot; &quot;cd&quot; (&quot;ef&quot;) intitle:&quot;gh&quot; !&quot;ij&quot; -&quot;kl&quot;',
				'(((e.title LIKE ? OR e.content LIKE ?) AND (e.title LIKE ? OR e.content LIKE ?) )) AND (((e.title LIKE ? OR e.content LIKE ?) )) ' .
					'AND ((e.title LIKE ? AND e.title NOT LIKE ? AND e.content NOT LIKE ? AND e.title NOT LIKE ? AND e.content NOT LIKE ? ))',
				['%ab%', '%ab%', '%cd%', '%cd%', '%ef%', '%ef%', '%gh%', '%ij%', '%ij%', '%kl%', '%kl%']
			],
			[
				'/^(ab|cd) [(] \\) (ef|gh)/',
				'((e.title ~ ? OR e.content ~ ?) )',
				['^(ab|cd) [(] \\) (ef|gh)', '^(ab|cd) [(] \\) (ef|gh)']
			],
			[
				'!/^(ab|cd)/',
				'(NOT e.title ~ ? AND NOT e.content ~ ? )',
				['^(ab|cd)', '^(ab|cd)']
			],
			[
				'intitle:/^(ab|cd)/',
				'(e.title ~ ? )',
				['^(ab|cd)']
			],
			[
				'intext:/^(ab|cd)/',
				'(e.content ~ ? )',
				['^(ab|cd)']
			],
			[
				'L:1 L:2',
				'(e.id IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (?)) AND ' .
					'e.id IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (?)) )',
				[1, 2]
			],
			[
				'L:1,2',
				'(e.id IN (SELECT et.id_entry FROM `_entrytag` et WHERE et.id_tag IN (?,?)) )',
				[1, 2]
			],
		];
	}

	/**
	 * @dataProvider provideRegexPostreSQL
	 * @param array<string> $values
	 */
	public function test__regex_postgresql(string $input, string $sql, array $values): void {
		[$filterValues, $filterSearch] = FreshRSS_EntryDAOPGSQL::sqlBooleanSearch('e.', new FreshRSS_BooleanSearch($input));
		self::assertSame(trim($sql), trim($filterSearch));
		self::assertSame($values, $filterValues);
	}

	/** @return list<list<mixed>> */
	public static function provideRegexPostreSQL(): array {
		return [
			[
				'intitle:/^ab$/',
				'(e.title ~ ? )',
				['^ab$']
			],
			[
				'intitle:/^ab$/i',
				'(e.title ~* ? )',
				['^ab$']
			],
			[
				'intitle:/^ab$/m',
				'(e.title ~ ? )',
				['(?m)^ab$']
			],
			[
				'intitle:/^ab\\M/',
				'(e.title ~ ? )',
				['^ab\\M']
			],
			[
				'intext:/^ab\\M/',
				'(e.content ~ ? )',
				['^ab\\M']
			],
			[
				'author:/^ab$/',
				"(REPLACE(e.author, ';', '\n') ~ ? )",
				['^ab$']
			],
			[
				'inurl:/^ab$/',
				'(e.link ~ ? )',
				['^ab$']
			],
			[
				'/^ab$/',
				'((e.title ~ ? OR e.content ~ ?) )',
				['^ab$', '^ab$']
			],
			[
				'!/^ab$/',
				'(NOT e.title ~ ? AND NOT e.content ~ ? )',
				['^ab$', '^ab$']
			],
			[
				'#/^a(b|c)$/im',
				"(REPLACE(REPLACE(e.tags, ' #', '#'), '#', '\n') ~* ? )",
				['(?m)^a(b|c)$']
			],
			[	// Not a regex
				'inurl:https://example.net/test/',
				'(e.link LIKE ? )',
				['%https://example.net/test/%']
			],
			[	// Not a regex
				'https://example.net/test/',
				'((e.title LIKE ? OR e.content LIKE ?) )',
				['%https://example.net/test/%', '%https://example.net/test/%']
			],
		];
	}

	/**
	 * @dataProvider provideRegexMariaDB
	 * @param array<string> $values
	 */
	public function test__regex_mariadb(string $input, string $sql, array $values): void {
		FreshRSS_DatabaseDAO::$dummyConnection = true;
		FreshRSS_DatabaseDAO::setStaticVersion('11.4.3-MariaDB-ubu2404');
		[$filterValues, $filterSearch] = FreshRSS_EntryDAO::sqlBooleanSearch('e.', new FreshRSS_BooleanSearch($input));
		self::assertSame(trim($sql), trim($filterSearch));
		self::assertSame($values, $filterValues);
	}

	/** @return list<list<mixed>> */
	public static function provideRegexMariaDB(): array {
		return [
			[
				'intitle:/^ab$/',
				"(e.title REGEXP ? )",
				['(?-i)^ab$']
			],
			[
				'intitle:/^ab$/i',
				"(e.title REGEXP ? )",
				['(?i)^ab$']
			],
			[
				'intitle:/^ab$/m',
				"(e.title REGEXP ? )",
				['(?-i)(?m)^ab$']
			],
			[
				'intext:/^ab$/m',
				'(UNCOMPRESS(e.content_bin) REGEXP ?) )',
				['(?-i)(?m)^ab$']
			],
		];
	}

	/**
	 * @dataProvider provideRegexMySQL
	 * @param array<string> $values
	 */
	public function test__regex_mysql(string $input, string $sql, array $values): void {
		FreshRSS_DatabaseDAO::$dummyConnection = true;
		FreshRSS_DatabaseDAO::setStaticVersion('9.0.1');
		[$filterValues, $filterSearch] = FreshRSS_EntryDAO::sqlBooleanSearch('e.', new FreshRSS_BooleanSearch($input));
		self::assertSame(trim($sql), trim($filterSearch));
		self::assertSame($values, $filterValues);
	}

	/** @return list<list<mixed>> */
	public static function provideRegexMySQL(): array {
		return [
			[
				'intitle:/^ab$/',
				"(REGEXP_LIKE(e.title,?,'c') )",
				['^ab$']
			],
			[
				'intitle:/^ab$/i',
				"(REGEXP_LIKE(e.title,?,'i') )",
				['^ab$']
			],
			[
				'intitle:/^ab$/m',
				"(REGEXP_LIKE(e.title,?,'mc') )",
				['^ab$']
			],
			[
				'intext:/^ab$/m',
				"(REGEXP_LIKE(UNCOMPRESS(e.content_bin),?,'mc')) )",
				['^ab$']
			],
		];
	}

	/**
	 * @dataProvider provideRegexSQLite
	 * @param array<string> $values
	 */
	public function test__regex_sqlite(string $input, string $sql, array $values): void {
		[$filterValues, $filterSearch] = FreshRSS_EntryDAOSQLite::sqlBooleanSearch('e.', new FreshRSS_BooleanSearch($input));
		self::assertSame(trim($sql), trim($filterSearch));
		self::assertSame($values, $filterValues);
	}

	/** @return list<list<mixed>> */
	public static function provideRegexSQLite(): array {
		return [
			[
				'intitle:/^ab$/',
				"(e.title REGEXP ? )",
				['/^ab$/']
			],
			[
				'intitle:/^ab$/i',
				"(e.title REGEXP ? )",
				['/^ab$/i']
			],
			[
				'intitle:/^ab$/m',
				"(e.title REGEXP ? )",
				['/^ab$/m']
			],
			[
				'intitle:/^ab\\b/',
				'(e.title REGEXP ? )',
				['/^ab\\b/']
			],
			[
				'intext:/^ab\\b/',
				'(e.content REGEXP ? )',
				['/^ab\\b/']
			],
		];
	}
}
