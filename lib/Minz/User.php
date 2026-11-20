<?php
declare(strict_types=1);

/**
 * The Minz_User class handles the user information.
 */
final class Minz_User {

	public const INTERNAL_USER = '_';

	public const CURRENT_USER = 'currentUser';

	/**
	 * Name of the user of the current request as last set by `change()` (empty string if cleared), or null if not set yet.
	 * Kept apart from the session, which is shared with concurrent requests and reloaded at each access:
	 * another request changing the current user of the session (e.g. login, logout) must not change the user of a running request.
	 */
	private static ?string $name = null;

	/**
	 * @return string the name of the current user, or null if there is none
	 */
	public static function name(): ?string {
		$currentUser = self::$name ?? trim(Minz_Session::paramString(Minz_User::CURRENT_USER));
		return $currentUser === '' ? null : $currentUser;
	}

	/**
	 * @param string $name the name of the new user. Set to empty string to clear the user.
	 */
	public static function change(string $name = ''): void {
		$name = trim($name);
		self::$name = $name;
		Minz_Session::_param(Minz_User::CURRENT_USER, $name === '' ? false : $name);
	}
}
