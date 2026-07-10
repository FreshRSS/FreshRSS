<?php
declare(strict_types=1);

use FreshRss\Controllers\IndexController;
use FreshRss\Minz\Request;
use FreshRss\Minz\Translate;
use FreshRss\Models\Context;
use FreshRss\Models\UserConfiguration;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class indexControllerTest extends \PHPUnit\Framework\TestCase {

	public function testUnknownViewModeIsEncodedInNotification(): void {
		Context::initSystem();
		Context::setUserConf(clone UserConfiguration::default());
		Context::userConf()->view_mode = '<form action="https://example.net/">';
		Translate::init('en');

		(new IndexController())->indexAction();

		$notification = Request::getNotification();
		self::assertNotNull($notification);
		self::assertStringContainsString('&lt;form action=&quot;https://example.net/&quot;&gt;', $notification['content']);
		self::assertStringNotContainsString('<', $notification['content']);
	}
}
