<?php
declare(strict_types=1);

use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Models\Context;
use FreshRss\Models\UserConfiguration;
use FreshRss\Models\View;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

require_once LIB_PATH . '/Minz/Url.php';	// For _url()

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class javascriptVarsTest extends \PHPUnit\Framework\TestCase {

	/** @return Traversable<string,array{bool}> */
	public static function provideTitleOpensWebsite(): Traversable {
		yield 'title opens the article in FreshRSS' => [false];
		yield 'title opens the original website' => [true];
	}

	#[DataProvider('provideTitleOpensWebsite')]
	public function testContextTellsWhetherTitleOpensWebsite(bool $titleOpensWebsite): void {
		Context::initSystem();
		Session::init('FreshRSS', volatile: true);
		Context::setUserConf(clone UserConfiguration::default());
		Context::userConf()->title_opens_website = $titleOpensWebsite;
		Translate::init('en');

		$view = new View();
		$view->_path('helpers/javascript_vars.phtml');
		$vars = json_decode($view->renderToString(), true);
		self::assertIsArray($vars);
		self::assertIsArray($vars['context'] ?? null);
		self::assertSame($titleOpensWebsite, $vars['context']['title_opens_website'] ?? null);
	}
}
