<?php

/**
 * The Minz_User class handles the user information.
 */
final class Minz_User {

	public const INTERNAL_USER = '_';

	public const CURRENT_USER = 'currentUser';

	/**
	 * @return string the name of the current user, or null if there is none
	 */
	public static function name(): ?string {
		$currentUser = trim(Minz_Session::param(Minz_User::CURRENT_USER, ''));
		return $currentUser === '' ? null : $currentUser;
	}

	/**
	 * @param string $name the name of the new user. Set to empty string to clear the user.
	 */
	public static function change(string $name = ''): void {
		$name = trim($name);
		Minz_Session::_param(Minz_User::CURRENT_USER, $name === '' ? false : $name);
	}
}
