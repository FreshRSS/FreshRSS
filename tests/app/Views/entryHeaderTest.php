<?php
declare(strict_types=1);

use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Models\Context;
use FreshRss\Models\Entry;
use FreshRss\Models\Feed;
use FreshRss\Models\UserConfiguration;
use FreshRss\Models\View;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

require_once LIB_PATH . '/Minz/Url.php';	// For _url()

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class entryHeaderTest extends \PHPUnit\Framework\TestCase {

	private const ARTICLE_URL = 'https://example.net/article';
	private const LINK_ITEM = '//li[contains(concat(" ", normalize-space(@class), " "), " link ")]';

	private static function renderEntryHeader(bool $titleOpensWebsite): Dom\XPath {
		Context::initSystem();
		Session::init('FreshRSS', volatile: true);
		Context::setUserConf(clone UserConfiguration::default());
		Context::userConf()->title_opens_website = $titleOpensWebsite;
		Translate::init('en');

		$view = new View();
		$view->_path('helpers/index/normal/entry_header.phtml');
		$view->feed = new Feed('https://example.net/feed.xml', false);
		$view->entry = new Entry(1, 'guid', 'Title', '', 'Content', self::ARTICLE_URL, 1700000000);
		// Fragment of a page, so prefix with `<!DOCTYPE html>`
		$doc = Dom\HTMLDocument::createFromString('<!DOCTYPE html>' . $view->renderToString(), Dom\HTML_NO_DEFAULT_NS);
		return new Dom\XPath($doc);
	}

	private static function countNodes(Dom\XPath $xpath, string $query): int {
		return $xpath->query($query)->length;
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
