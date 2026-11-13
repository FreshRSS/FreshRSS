<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

require_once LIB_PATH . '/Minz/Url.php';	// For _url()

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class entryHeaderTest extends \PHPUnit\Framework\TestCase {

	private const ARTICLE_URL = 'https://example.net/article';
	private const LINK_ITEM = '//li[contains(concat(" ", normalize-space(@class), " "), " link ")]';

	private static function renderEntryHeader(bool $titleOpensWebsite): DOMXPath {
		FreshRSS_Context::initSystem();
		Minz_Session::init('FreshRSS', volatile: true);
		FreshRSS_Context::setUserConf(clone FreshRSS_UserConfiguration::default());
		FreshRSS_Context::userConf()->title_opens_website = $titleOpensWebsite;
		Minz_Translate::init('en');

		$view = new FreshRSS_View();
		$view->_path('helpers/index/normal/entry_header.phtml');
		$view->feed = new FreshRSS_Feed('https://example.net/feed.xml', false);
		$view->entry = new FreshRSS_Entry(1, 'guid', 'Title', '', 'Content', self::ARTICLE_URL, 1700000000);
		$html = new DOMDocument();
		self::assertTrue($html->loadHTML($view->renderToString(), LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING));
		return new DOMXPath($html);
	}

	private static function countNodes(DOMXPath $xpath, string $query): int {
		$nodes = $xpath->query($query);
		self::assertNotFalse($nodes);
		return $nodes->length;
	}

	public function testLinkIconOpensOriginalWebsiteByDefault(): void {
		$xpath = self::renderEntryHeader(titleOpensWebsite: false);
		self::assertSame(1, self::countNodes($xpath, self::LINK_ITEM . '/a[@href="' . self::ARTICLE_URL . '"]'));
		self::assertSame(0, self::countNodes($xpath, self::LINK_ITEM . '/button'));
	}

	public function testLinkIconOpensArticleInFreshRSSWhenTitleOpensWebsite(): void {
		$xpath = self::renderEntryHeader(titleOpensWebsite: true);
		self::assertSame(1, self::countNodes($xpath, self::LINK_ITEM . '/button[@type="button"]'));
		self::assertSame(0, self::countNodes($xpath, self::LINK_ITEM . '/a'));
		// The title is now the way to open the original website
		self::assertSame(1, self::countNodes($xpath,
			'//a[contains(concat(" ", normalize-space(@class), " "), " title ")][@href="' . self::ARTICLE_URL . '"][@target="_blank"]'));
	}
}
