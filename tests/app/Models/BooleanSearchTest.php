<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class BooleanSearchTest extends \PHPUnit\Framework\TestCase {

	/**
	 * `FreshRSS_BooleanSearch::prepend()` is used to restrict an existing search with an extra condition,
	 * such as the maximum publication date of the “mark as read → articles older than one day/week” action.
	 * Sibling searches are combined by OR, so the extra condition must not end up as one more OR term.
	 * @return list<array{string,string,list<string|int>}>
	 */
	public static function providePrependMaxPubdate(): array {
		return [
			['', '(e.date <= ?)', [1700000000]],
			['intitle:sale', '(e.date <= ?)AND ((e.title LIKE ?))', [1700000000, '%sale%']],
			['intitle:a OR intitle:b', '(e.date <= ?)AND ((e.title LIKE ?) OR (e.title LIKE ?))', [1700000000, '%a%', '%b%']],
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
}
