<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class AuthTest extends \PHPUnit\Framework\TestCase {
	private const USERS = ['phpunit-alice', 'phpunit-mallory'];

	#[\Override]
	protected function setUp(): void {
		foreach (self::USERS as $user) {
			mkdir(USERS_PATH . '/' . $user);
			file_put_contents(USERS_PATH . '/' . $user . '/config.php',
				'<?php return ' . var_export(['passwordHash' => "hash-$user", 'token' => "token-$user"], true) . ';');
		}
	}

	#[\Override]
	protected function tearDown(): void {
		foreach (self::USERS as $user) {
			recursive_unlink(USERS_PATH . '/' . $user);
		}
	}

	public function testRefusedSessionWithTokenLoadsConfigurationOfTokenUser(): void {
		FreshRSS_Context::initSystem();
		FreshRSS_Context::systemConf()->auth_type = 'form';
		Minz_Session::init('FreshRSS', volatile: true);
		Minz_Session::_params([
			Minz_User::CURRENT_USER => 'phpunit-mallory',
			'loginOk' => true,
			'passwordHash' => 'outdated',
		]);
		Minz_Request::_params(['user' => 'phpunit-alice', 'token' => 'token-phpunit-alice']);

		self::assertFalse(FreshRSS_Auth::init());
		self::assertSame('phpunit-alice', Minz_User::name());
		self::assertSame('hash-phpunit-alice', FreshRSS_Context::userConf()->passwordHash);
	}
}
