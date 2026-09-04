<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Tests for multi-category support added to FreshRSS_Feed model.
 * Covers: categoryIds(), _categoryIds(), categoryId() fallback behaviour.
 */
final class FeedMultiCategoryTest extends TestCase {

	// -----------------------------------------------------------------------
	// categoryIds() — getter
	// -----------------------------------------------------------------------

	public function test_categoryIds_returns_primary_when_no_join_table_ids(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryId(42);
		self::assertSame([42], $feed->categoryIds());
	}

	public function test_categoryIds_returns_empty_when_no_category_set(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		self::assertSame([], $feed->categoryIds());
	}

	public function test_categoryIds_returns_join_table_ids_when_set(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryId(1);
		$feed->_categoryIds([10, 20, 30]);
		self::assertSame([10, 20, 30], $feed->categoryIds());
	}

	public function test_categoryIds_deduplicates_ids(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryIds([5, 5, 10, 10, 15]);
		self::assertSame([5, 10, 15], $feed->categoryIds());
	}

	public function test_categoryIds_casts_to_int(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryIds([7, 8]);  // already ints
		self::assertSame([7, 8], $feed->categoryIds());
	}

	// -----------------------------------------------------------------------
	// _categoryIds() — setter side-effects
	// -----------------------------------------------------------------------

	public function test_setting_categoryIds_updates_primary_categoryId(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryId(99);
		$feed->_categoryIds([10, 20]);
		// Primary categoryId should now be first element of categoryIds
		self::assertSame(10, $feed->categoryId());
	}

	public function test_setting_empty_categoryIds_does_not_change_primary(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryId(99);
		$feed->_categoryIds([]);
		// Empty list should not override primary
		self::assertSame(99, $feed->categoryId());
	}

	public function test_setting_single_categoryId_works(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryIds([42]);
		self::assertSame([42], $feed->categoryIds());
		self::assertSame(42, $feed->categoryId());
	}

	// -----------------------------------------------------------------------
	// categoryId() — primary category fallback
	// -----------------------------------------------------------------------

	public function test_categoryId_returns_zero_when_nothing_set(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		self::assertSame(0, $feed->categoryId());
	}

	public function test_categoryId_returns_set_value(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryId(7);
		self::assertSame(7, $feed->categoryId());
	}

	public function test_categoryId_returns_first_of_categoryIds_when_set(): void {
		$feed = new FreshRSS_Feed('https://example.com/feed', false);
		$feed->_categoryIds([3, 5, 9]);
		self::assertSame(3, $feed->categoryId());
	}
}
