<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class UserTest extends \PHPUnit\Framework\TestCase {

	public function testNameFollowsSessionUntilChanged(): void {
		Minz_Session::init('FreshRSS', volatile: true);
		self::assertNull(Minz_User::name());
		$_SESSION[Minz_User::CURRENT_USER] = 'alice';
		self::assertSame('alice', Minz_User::name());
	}

	public function testNameOfRunningRequestSurvivesSessionChange(): void {
		Minz_Session::init('FreshRSS', volatile: true);
		Minz_User::change('alice');
		self::assertSame('alice', Minz_Session::paramString(Minz_User::CURRENT_USER));
		// What reloading the session gives when a concurrent request has changed its current user meanwhile
		$_SESSION[Minz_User::CURRENT_USER] = 'bob';
		self::assertSame('alice', Minz_User::name());

		Minz_User::change();
		$_SESSION[Minz_User::CURRENT_USER] = 'bob';
		self::assertNull(Minz_User::name());
	}
}
