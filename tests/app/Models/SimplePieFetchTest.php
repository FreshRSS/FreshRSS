<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class SimplePieFetchTest extends \PHPUnit\Framework\TestCase {

	#[DataProvider('provideBodiesWithoutTrailingJunk')]
	public static function test_removeContentAfterRootClosingTag_whenNoTrailingJunk_leavesBodyUnchanged(string $body): void {
		self::assertSame($body, FreshRSS_SimplePieFetch::removeContentAfterRootClosingTag($body));
	}

	/** @return array<string,array{string}> */
	public static function provideBodiesWithoutTrailingJunk(): array {
		return [
			'clean RSS feed' => ['<?xml version="1.0"?><rss version="2.0"><channel><title>Test</title></channel></rss>'],
			'clean RSS feed with trailing whitespace only' => ["<rss version=\"2.0\"><channel></channel></rss>\n\n  "],
			'clean Atom feed' => ['<?xml version="1.0"?><feed xmlns="http://www.w3.org/2005/Atom"><title>Test</title></feed>'],
			'clean RDF (RSS 1.0) feed' => ['<?xml version="1.0"?><rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><channel/></rdf:RDF>'],
			'no root closing tag at all' => ['not even XML'],
		];
	}

	public static function test_removeContentAfterRootClosingTag_whenTrailingHtmlJunkAfterRss_removesJunk(): void {
		$feed = '<?xml version="1.0"?><rss version="2.0"><channel><title>Test</title></channel></rss>';
		$body = $feed . "\n<script>alert('junk')</script>\n<!-- injected by a broken proxy -->";

		self::assertSame($feed, FreshRSS_SimplePieFetch::removeContentAfterRootClosingTag($body));
	}

	public static function test_removeContentAfterRootClosingTag_whenTrailingJunkAfterAtomFeed_removesJunk(): void {
		$feed = '<?xml version="1.0"?><feed xmlns="http://www.w3.org/2005/Atom"><title>Test</title></feed>';
		$body = $feed . '<html><body>Some tracking pixel junk</body></html>';

		self::assertSame($feed, FreshRSS_SimplePieFetch::removeContentAfterRootClosingTag($body));
	}

	public static function test_removeContentAfterRootClosingTag_whenTrailingJunkAfterRdfFeedWithCustomPrefix_removesJunk(): void {
		$feed = '<?xml version="1.0"?><x:RDF xmlns:x="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><channel/></x:RDF>';
		$body = $feed . '<p>oops, some junk leaked into the response</p>';

		self::assertSame($feed, FreshRSS_SimplePieFetch::removeContentAfterRootClosingTag($body));
	}

	public static function test_removeContentAfterRootClosingTag_whenTrailingJunkAfterIso88591Feed_preservesTheOriginalBytes(): void {
		$feed = '<?xml version="1.0" encoding="ISO-8859-1"?><rss version="2.0"><channel><title>caf' . "\xE9" . '</title></channel></rss>';
		$body = $feed . '<script>junk</script>';

		self::assertSame($feed, FreshRSS_SimplePieFetch::removeContentAfterRootClosingTag($body));
	}

	public static function test_removeContentAfterRootClosingTag_whenUtf16FeedCannotBeMatched_leavesTheBodyForSimplePieToHandle(): void {
		$body = "\xFF\xFE<\0r\0s\0s\0>\0<\0/\0r\0s\0s\0>\0<\0s\0c\0r\0i\0p\0t\0>\0j\0u\0n\0k\0<\0/\0s\0c\0r\0i\0p\0t\0>\0";

		self::assertSame($body, FreshRSS_SimplePieFetch::removeContentAfterRootClosingTag($body));
	}

	public static function test_removeContentAfterRootClosingTag_whenClosingTagSubstringAppearsEarlierInCdata_usesLastRootClosingTag(): void {
		// The literal string `</rss>` legitimately appears inside a CDATA section, before the real root closing tag.
		$feed = '<?xml version="1.0"?><rss version="2.0"><channel><description><![CDATA[Example of literal text: </rss>]]></description></channel></rss>';
		$body = $feed . '<div>trailing junk that must be discarded</div>';

		self::assertSame($feed, FreshRSS_SimplePieFetch::removeContentAfterRootClosingTag($body));
	}
}
