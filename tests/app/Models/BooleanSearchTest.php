<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class BooleanSearchTest extends \PHPUnit\Framework\TestCase {

	public function __construct(string $name) {
		parent::__construct($name);
		if (!FreshRSS_Context::hasSystemConf()) {
			FreshRSS_Context::initSystem();
		}
	}

	/**
	 * `FreshRSS_BooleanSearch::prepend()` is used to restrict an existing search with an extra condition,
	 * such as the maximum publication date of the “mark as read → articles older than one day/week” action.
	 * @return list<array{string,string,list<string|int>}>
	 */
	public static function providePrependMaxPubdate(): array {
		return [
			['', '(e.date <= ?)', [1700000000]],
			['intitle:sale', '(e.date <= ?) AND ((e.title LIKE ?))', [1700000000, '%sale%']],
			['intitle:a OR intitle:b', '(e.date <= ?) AND ((e.title LIKE ?) OR (e.title LIKE ?))', [1700000000, '%a%', '%b%']],
		];
	}

	/** @param list<string|int> $expectedValues */
	#[DataProvider('providePrependMaxPubdate')]
	public function test_prepend_restrictsTheSearchInsteadOfWideningIt(string $input, string $expectedSql, array $expectedValues): void {
		$booleanSearch = new FreshRSS_BooleanSearch($input);
		$maxPubdate = new FreshRSS_Search('');
		$maxPubdate->setMaxPubdate(1700000000);
		$booleanSearch->prepend($maxPubdate);

		[$values, $sql] = FreshRSS_EntryDAO::sqlBooleanSearch('e.', $booleanSearch);
		self::assertSame($expectedSql, trim($sql));
		self::assertSame($expectedValues, $values);
	}

	public function test_constructor_acceptsSearchesAtTheLimits(): void {
		$input = str_repeat('a', FreshRSS_Context::systemConf()->limits['max_search_length']);
		self::assertSame($input, (string)new FreshRSS_BooleanSearch($input));
		$input = str_repeat('(', FreshRSS_Context::systemConf()->limits['max_search_parentheses_depth']) . 'ab' .
			str_repeat(')', FreshRSS_Context::systemConf()->limits['max_search_parentheses_depth']);
		self::assertSame('ab', (string)new FreshRSS_BooleanSearch($input));
	}

	/** @return list<list{string}> */
	public static function provideTooLongOrTooDeepSearches(): array {
		$tooLong = str_repeat('a', FreshRSS_Context::systemConf()->limits['max_search_length'] + 1);
		$tooDeep = str_repeat('(', FreshRSS_Context::systemConf()->limits['max_search_parentheses_depth'] + 1) . 'ab' .
			str_repeat(')', FreshRSS_Context::systemConf()->limits['max_search_parentheses_depth'] + 1);
		return [
			[$tooLong],
			[$tooDeep],
		];
	}

	#[DataProvider('provideTooLongOrTooDeepSearches')]
	public function test_constructor_rejectsTooLongOrTooDeepSearches(string $input): void {
		self::expectException(Minz_BadRequestException::class);
		new FreshRSS_BooleanSearch($input);
	}
}
