<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class BooleanSearchTest extends \PHPUnit\Framework\TestCase {

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

	/** @return list<list{string}> */
	public static function provideTooLongOrTooDeepSearches(): array {
		$tooLong = str_repeat('ab ', 1400);	// Long enough to exceed the maximum search length
		$tooDeep = str_repeat('(', 40) . 'ab' . str_repeat(')', 40);	// Deeper than the maximum parentheses depth
		return [
			[$tooLong],
			[$tooDeep],
		];
	}

	#[DataProvider('provideTooLongOrTooDeepSearches')]
	public function test_constructor_rejectsTooLongOrTooDeepSearches(string $input): void {
		self::expectException(Minz_BadRequestException::class);
		// Tests run at the default PHP memory limit; a brute-force 1400-deep search would consume too much memory
		new FreshRSS_BooleanSearch($input);
	}
}
