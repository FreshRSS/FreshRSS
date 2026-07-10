<?php
declare(strict_types=1);

use FreshRss\Minz\BadRequestException;
use FreshRss\Models\BooleanSearch;
use FreshRss\Models\Context;
use FreshRss\Models\EntryDAO;
use FreshRss\Models\Search;
use PHPUnit\Framework\Attributes\DataProvider;

final class BooleanSearchTest extends \PHPUnit\Framework\TestCase {

	#[\Override]
	protected function setUp(): void {
		if (!Context::hasSystemConf()) {
			Context::initSystem();
		}
	}

	/**
	 * `BooleanSearch::prepend()` is used to restrict an existing search with an extra condition,
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
		$booleanSearch = new BooleanSearch($input);
		$maxPubdate = new Search('');
		$maxPubdate->setMaxPubdate(1700000000);
		$booleanSearch->prepend($maxPubdate);

		[$values, $sql] = EntryDAO::sqlBooleanSearch('e.', $booleanSearch);
		self::assertSame($expectedSql, trim($sql));
		self::assertSame($expectedValues, $values);
	}

	public function test_constructor_acceptsSearchesAtTheLimits(): void {
		$input = str_repeat('a', Context::systemConf()->limits['max_search_length']);
		self::assertSame($input, (string)new BooleanSearch($input));
		$input = str_repeat('(', Context::systemConf()->limits['max_search_parentheses_depth']) . 'ab' .
			str_repeat(')', Context::systemConf()->limits['max_search_parentheses_depth']);
		self::assertSame('ab', (string)new BooleanSearch($input));
	}

	/** @return list<list{string}> */
	public static function provideTooLongOrTooDeepSearches(): array {
		if (!Context::hasSystemConf()) {
			Context::initSystem();
		}
		$tooLong = str_repeat('a', Context::systemConf()->limits['max_search_length'] + 1);
		$tooDeep = str_repeat('(', Context::systemConf()->limits['max_search_parentheses_depth'] + 1) . 'ab' .
			str_repeat(')', Context::systemConf()->limits['max_search_parentheses_depth'] + 1);
		return [
			[$tooLong],
			[$tooDeep],
		];
	}

	#[DataProvider('provideTooLongOrTooDeepSearches')]
	public function test_constructor_rejectsTooLongOrTooDeepSearches(string $input): void {
		self::expectException(BadRequestException::class);
		new BooleanSearch($input);
	}
}
