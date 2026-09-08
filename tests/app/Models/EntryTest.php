<?php
declare(strict_types=1);

final class EntryTest extends \PHPUnit\Framework\TestCase {
	public static function testAuthorsKeepsCommaContainingNameAsSingleAuthor(): void {
		$entry = new FreshRSS_Entry(authors: 'Smith, John');
		self::assertSame(['Smith, John'], $entry->authors());
	}

	public static function testAuthorsKeepsCommaSeparatedListAsSingleAuthor(): void {
		// Known trade-off: a feed genuinely listing two authors separated only by a comma
		// is now treated as one author, since comma is no longer used as a separator.
		$entry = new FreshRSS_Entry(authors: 'Alice, Bob');
		self::assertSame(['Alice, Bob'], $entry->authors());
	}

	public static function testAuthorsStillSplitsOnSemicolon(): void {
		$entry = new FreshRSS_Entry(authors: 'Alice; Bob');
		self::assertSame(['Alice', 'Bob'], $entry->authors());
	}

	public static function testAuthorsSplitsOnSemicolonWhilePreservingCommasWithinEachName(): void {
		$entry = new FreshRSS_Entry(authors: 'Smith, John; Doe, Jane');
		self::assertSame(['Smith, John', 'Doe, Jane'], $entry->authors());
	}

	public static function testAuthorsAsStringPrependsSemicolonSeparator(): void {
		$entry = new FreshRSS_Entry(authors: 'Smith, John');
		self::assertSame(';Smith, John', $entry->authors(true));
	}
}
