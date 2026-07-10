<?php
declare(strict_types=1);

use FreshRss\Minz\Session;
use FreshRss\Minz\User;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class UserTest extends \PHPUnit\Framework\TestCase {

	public function testNameFollowsSessionUntilChanged(): void {
		Session::init('FreshRSS', volatile: true);
		self::assertNull(User::name());
		$_SESSION[User::CURRENT_USER] = 'alice';
		self::assertSame('alice', User::name());
	}

	public function testNameOfRunningRequestSurvivesSessionChange(): void {
		Session::init('FreshRSS', volatile: true);
		User::change('alice');
		self::assertSame('alice', Session::paramString(User::CURRENT_USER));
		// What reloading the session gives when a concurrent request has changed its current user meanwhile
		$_SESSION[User::CURRENT_USER] = 'bob';
		self::assertSame('alice', User::name());

		User::change();
		$_SESSION[User::CURRENT_USER] = 'bob';
		self::assertNull(User::name());
	}
}
