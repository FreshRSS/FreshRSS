<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class indexControllerTest extends \PHPUnit\Framework\TestCase {

	public function testUnknownViewModeIsEncodedInNotification(): void {
		FreshRSS_Context::initSystem();
		FreshRSS_Context::setUserConf(clone FreshRSS_UserConfiguration::default());
		FreshRSS_Context::userConf()->view_mode = '<form action="https://example.net/">';
		Minz_Translate::init('en');

		(new FreshRSS_index_Controller())->indexAction();

		$notification = Minz_Request::getNotification();
		self::assertNotNull($notification);
		self::assertStringContainsString('&lt;form action=&quot;https://example.net/&quot;&gt;', $notification['content']);
		self::assertStringNotContainsString('<', $notification['content']);
	}
}
