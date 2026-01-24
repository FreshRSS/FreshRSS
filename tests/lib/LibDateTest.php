<?php
declare(strict_types=1);

require_once LIB_PATH . '/lib_date.php';

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Tests for lib_date.php functions
 */
class LibDateTest extends \PHPUnit\Framework\TestCase {

	/**
	 * Test parseDateInterval function with various ISO 8601 interval formats
	 *
	 * @param string $interval
	 * @param int|null|false $expectedMin
	 * @param int|null|false $expectedMax
	 */
	#[DataProvider('provideDateIntervals')]
	public function test_parseDateInterval(string $interval, $expectedMin, $expectedMax): void {
		$result = parseDateInterval($interval);
		self::assertIsArray($result);
		self::assertCount(2, $result);
		self::assertSame($expectedMin, $result[0], "Min timestamp mismatch for interval: $interval");
		self::assertSame($expectedMax, $result[1], "Max timestamp mismatch for interval: $interval");
	}

	/** @return list<array{string,int|null|false,int|null|false}> */
	public static function provideDateIntervals(): array {
		return [
			['', null, null], // Empty string

			// Year intervals
			['2014', strtotime('2014-01-01 00:00:00'), strtotime('2014-12-31 23:59:59')],
			[' 2015 ', strtotime('2015-01-01 00:00:00'), strtotime('2015-12-31 23:59:59')],	// With whitespace to be trimmed

			// Year-month intervals
			['2014-03', strtotime('2014-03-01 00:00:00'), strtotime('2014-03-31 23:59:59')],
			['2016-02', strtotime('2016-02-01 00:00:00'), strtotime('2016-02-29 23:59:59')],	// Leap year
			['2014-02', strtotime('2014-02-01 00:00:00'), strtotime('2014-02-28 23:59:59')],	// Non-leap year
			['201404', strtotime('2014-04-01 00:00:00'), strtotime('2014-04-30 23:59:59')],	// Without hyphen

			// Specific dates
			['2014-03-30', strtotime('2014-03-30 00:00:00'), strtotime('2014-03-30 23:59:59')],
			['2014-05-30T13', strtotime('2014-05-30 13:00:00'), strtotime('2014-05-30 13:59:59')],
			['2014-05-30T13:30', strtotime('2014-05-30 13:30:00'), strtotime('2014-05-30 13:30:59')],

			// Date ranges with explicit end dates
			['2014-02/2014-04', strtotime('2014-02-01 00:00:00'), strtotime('2014-04-30 23:59:59')],
			['2014-02--2014-04', strtotime('2014-02-01 00:00:00'), strtotime('2014-04-30 23:59:59')],	// Same with -- separator
			['2014-02/04', strtotime('2014-02-01 00:00:00'), strtotime('2014-04-30 23:59:59')],
			['2014-02-03/05', strtotime('2014-02-03 00:00:00'), strtotime('2014-02-05 23:59:59')],

			// Time ranges within same day
			['2014-02-03T22:00/22:15', strtotime('2014-02-03 22:00:00'), strtotime('2014-02-03 22:15:59')],
			['2014-02-03T22:00/15', strtotime('2014-02-03 22:00:00'), strtotime('2014-02-03 22:15:59')],

			// Open intervals
			['2014-03/', strtotime('2014-03-01 00:00:00'), null],
			['/2014-03', null, strtotime('2014-03-31 23:59:59')],

			// Period-based intervals
			['2014-03/P1W', strtotime('2014-03-01 00:00:00'), strtotime('2014-03-07 23:59:59')],
			['P1W/2014-05-25T23:59:59', strtotime('2014-05-19 00:00:00'), strtotime('2014-05-25 23:59:59')],

			// Fixed date periods with known anchors
			['2014-01-01/P1Y', strtotime('2014-01-01 00:00:00'), strtotime('2014-12-31 23:59:59')],
			['2014-06-15/P6M', strtotime('2014-06-15 00:00:00'), strtotime('2014-12-14 23:59:59')],
			['2014-03-01/P2W', strtotime('2014-03-01 00:00:00'), strtotime('2014-03-14 23:59:59')],
			['2014-12-25/P10D', strtotime('2014-12-25 00:00:00'), strtotime('2015-01-03 23:59:59')],
			['2014-01-01T12:00/PT6H', strtotime('2014-01-01 12:00:00'), strtotime('2014-01-01 17:59:59')],
			['2014-01-01 12:00/PT6H', strtotime('2014-01-01 12:00:00'), strtotime('2014-01-01 17:59:59')],	// Space instead of T
			['2014-01-01T12:00/PT6h', strtotime('2014-01-01 12:00:00'), strtotime('2014-01-01 17:59:59')],	// Lowercase h
			['2014-05-01T10:30/PT90M', strtotime('2014-05-01 10:30:00'), strtotime('2014-05-01 11:59:59')],
			['2014-07-04T14:15:30/PT45S', strtotime('2014-07-04 14:15:30'), strtotime('2014-07-04 14:16:14')],

			// Reverse periods
			['P1M/2014-02-28', strtotime('2014-01-28 00:00:01'), strtotime('2014-02-28 00:00:00')],
			['P3D/2014-01-10T23:59:59', strtotime('2014-01-08 00:00:00'), strtotime('2014-01-10 23:59:59')],
			['PT12H/2014-06-01T12:00', strtotime('2014-06-01 00:00:01'), strtotime('2014-06-01 12:00:00')],
		];
	}
}
