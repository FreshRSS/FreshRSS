<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class entryHeaderTest extends \PHPUnit\Framework\TestCase {
	/** @return Traversable<string,array{string,bool}> */
	public static function provideWebsiteModes(): Traversable {
		foreach (['full', 'full-below', 'name', 'icon', 'none'] as $mode) {
			foreach ([true, false] as $favicons) {
				yield $mode . ($favicons ? ' with favicon' : ' without favicon') => [$mode, $favicons];
			}
		}
	}

	#[DataProvider('provideWebsiteModes')]
	public function testWebsitePlacementAndPersistence(string $mode, bool $favicons): void {
		FreshRSS_Context::initSystem();
		Minz_Translate::init('en');
		Minz_Url::display('/');
		$previous = FreshRSS_Context::hasUserConf() ? FreshRSS_Context::userConf() : null;
		$configFile = tempnam(sys_get_temp_dir(), 'freshrss-header-');
		self::assertIsString($configFile);
		file_put_contents($configFile, '<?php return [];');
		try {
			FreshRSS_UserConfiguration::register(__CLASS__, $configFile, FRESHRSS_PATH . '/config-user.default.php');
			$config = FreshRSS_UserConfiguration::get(__CLASS__);
			self::assertSame('full', $config->topline_website);
			$config->topline_website = $mode;
			$config->show_favicons = $favicons;
			self::assertTrue($config->save());
			FreshRSS_UserConfiguration::register(__CLASS__, $configFile, FRESHRSS_PATH . '/config-user.default.php');
			$config = FreshRSS_UserConfiguration::get(__CLASS__);
			self::assertSame($mode, $config->topline_website);
			FreshRSS_Context::setUserConf($config);

			$view = new FreshRSS_View();
			$view->feed = new FreshRSS_Feed('https://example.net/feed', false);
			$view->feed->_id(42);
			$view->feed->_name('Test feed');
			$view->entry = new FreshRSS_Entry(42, 'guid', 'Test article', '', 'Summary', 'https://example.net/article', 1700000000);
			$view->_path('helpers/index/normal/entry_header.phtml');
			$html = new DOMDocument();
			// libxml's HTML4 parser does not recognise the existing HTML5 <time> element.
			self::assertTrue($html->loadHTML($view->renderToString(), LIBXML_NONET | LIBXML_NOERROR));
			$xpath = new DOMXPath($html);
			self::assertSame($mode === 'none' ? 0.0 : 1.0, $xpath->evaluate('count(//*[@class="item website"])'));
			$parent = $mode === 'full-below' ? 'li[@class="item titleAuthorSummaryDate"]/div' : 'ul/li';
			self::assertSame($mode === 'none' ? 0.0 : 1.0, $xpath->evaluate('count(//' . $parent . '[@class="item website"])'));
			self::assertSame($favicons && !in_array($mode, ['name', 'none'], true) ? 1.0 : 0.0,
				$xpath->evaluate('count(//img[@class="favicon"])'));
			self::assertSame(in_array($mode, ['icon', 'none'], true) ? 0.0 : 1.0,
				$xpath->evaluate('count(//span[@class="websiteName"])'));
			if ($mode === 'full-below') {
				self::assertSame(1.0, $xpath->evaluate('count(//a[contains(@class,"title")]/following-sibling::div[@class="item website"])'));
				$config->topline_summary = true;
				self::assertTrue($html->loadHTML($view->renderToString(), LIBXML_NONET | LIBXML_NOERROR));
				$xpath = new DOMXPath($html);
				self::assertSame(1.0, $xpath->evaluate('count(//*[@class="item website"])'));
				self::assertSame(1.0, $xpath->evaluate('count(//a[contains(@class,"title")]/following-sibling::*[1][@class="item website"]'
					. '/following-sibling::*[1][@class="summary"])'));
				self::assertSame(_url('index', 'index', 'get', 'f_42'), $xpath->evaluate('string(//*[@class="item website"]/a/@href)'));
			}
		} finally {
			FreshRSS_Context::setUserConf($previous);
			unlink($configFile);
			if (is_file($configFile . '.bak.php')) {
				unlink($configFile . '.bak.php');
			}
		}
	}
}
