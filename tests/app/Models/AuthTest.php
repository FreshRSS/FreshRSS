<?php
declare(strict_types=1);

use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\User;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
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
		Context::initSystem();
		Context::systemConf()->auth_type = 'form';
		Session::init('FreshRSS', volatile: true);
		Session::_params([
			User::CURRENT_USER => 'phpunit-mallory',
			'loginOk' => true,
			'passwordHash' => 'outdated',
		]);
		Request::_params(['user' => 'phpunit-alice', 'token' => 'token-phpunit-alice']);

		self::assertFalse(Auth::init());
		self::assertSame('phpunit-alice', User::name());
		self::assertSame('hash-phpunit-alice', Context::userConf()->passwordHash);
	}
}
