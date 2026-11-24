<?php
declare(strict_types=1);
use FreshRss\Models\StatsDAO;
use PHPUnit\Framework\TestCase;

final class StatsDAOTest extends TestCase {

	public static function testCalculateEntryAverageFromRepartition(): void {
		self::assertSame(2.0, StatsDAO::calculateEntryAverageFromRepartition([0, 2, 4]));
	}

	public static function testCalculateEntryAverageFromEmptyRepartition(): void {
		self::assertSame(0.0, StatsDAO::calculateEntryAverageFromRepartition([]));
	}

	public static function testCalculateEntryAverageFromZeroRepartition(): void {
		self::assertSame(0.0, StatsDAO::calculateEntryAverageFromRepartition(array_fill(0, 24, 0)));
	}
}
