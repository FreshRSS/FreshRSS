<?php

class FreshRSS_password_Util {
	// Will also have to be computed client side on mobile devices,
	// so do not use a too high cost
	const BCRYPT_COST = 9;

	/**
	 * Return a hash of a plain password, using BCRYPT
	 *
	 * @param string
	 * @return string
	 */
	public static function hash($passwordPlain) {
		$passwordHash = password_hash(
			$passwordPlain,
			PASSWORD_BCRYPT,
			array('cost' => self::BCRYPT_COST)
		);
		$passwordPlain = '';

		// Compatibility with bcrypt.js
		$passwordHash = preg_replace('/^\$2[xy]\$/', '\$2a\$', $passwordHash);

		return $passwordHash == '' ? '' : $passwordHash;
	}
}
