<?php
declare(strict_types=1);

class FreshRSS_FormAuth {
	public const MIN_PASSWORD_LENGTH = 7; // Only to be enforced when setting new passwords.
	public const MAX_PASSWORD_LENGTH = 72;

	/**
	 * @param array{enforceMinLength?: bool} $options
	 */
	public static function passwordRequirementsMet(#[\SensitiveParameter] string $passwordPlain, array $options = []): bool {
		$enforceMinLength = ($options['enforceMinLength'] ?? true) === true;
		if (strlen($passwordPlain) > self::MAX_PASSWORD_LENGTH) {
			return false;
		}
		if ($enforceMinLength && strlen($passwordPlain) < self::MIN_PASSWORD_LENGTH) {
			return false;
		}
		return true;
	}

	public static function checkCredentials(string $username, #[\SensitiveParameter] string $hash, #[\SensitiveParameter] string $passwordPlain): bool {
		if (!FreshRSS_user_Controller::checkUsername($username) || !ctype_graph($hash)) {
			Minz_Log::debug("Invalid credential parameters: user={$username}");
			return false;
		}

		// Expecting bcrypt format, see: https://en.wikipedia.org/wiki/Bcrypt#Description
		// FreshRSS has not historically used any other algorithm for password hash generation,
		// so no upgrades are required.
		if (!preg_match('/^\$2[aby]\$(0[4-9]|10)\$[.\/0-9A-Za-z]{53}$/', $hash)) {
			Minz_Log::debug("Invalid hash format: user={$username}");
			return false;
		}

		if (strlen($passwordPlain) > self::MAX_PASSWORD_LENGTH) {
			Minz_Log::warning("Exceeded maximum allowed password length during authentication: user={$username}");
			return false;
		}

		// https://www.php.net/manual/function.password-verify.php
		if (password_verify($passwordPlain, $hash)) {
			if ($passwordPlain === '') {
				Minz_Log::warning("Refusing authentication with empty zero-length password: user={$username}");
				return false;
			}
			return true;
		}

		return false;
	}

	/** @return list<string> */
	public static function getCredentialsFromCookie(): array {
		$token = Minz_Session::getLongTermCookie('FreshRSS_login');
		if (!ctype_alnum($token)) {
			return [];
		}

		$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		$mtime = @filemtime($token_file) ?: 0;
		$limits = FreshRSS_Context::systemConf()->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? FreshRSS_Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
		if ($mtime + $cookie_duration < time()) {
			// Token has expired (> cookie_duration) or does not exist.
			@unlink($token_file);
			return [];
		}

		$credentials = @file_get_contents($token_file);
		if ($credentials !== false && self::renewCookie($token) != false) {
			return explode("\t", $credentials, 2);
		}
		return [];
	}

	private static function renewCookie(string $token): string|false {
		$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		if (touch($token_file)) {
			$limits = FreshRSS_Context::systemConf()->limits;
			$cookie_duration = empty($limits['cookie_duration']) ? FreshRSS_Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
			$expire = time() + $cookie_duration;
			Minz_Session::setLongTermCookie('FreshRSS_login', $token, $expire);
			return $token;
		}
		return false;
	}

	public static function makeCookie(string $username, #[\SensitiveParameter] string $password_hash): string|false {
		do {
			$token = hash('sha256', FreshRSS_Context::systemConf()->salt . $username . random_bytes(32));
			$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		} while (file_exists($token_file));

		if (@file_put_contents($token_file, $username . "\t" . $password_hash) === false) {
			return false;
		}

		return self::renewCookie($token);
	}

	public static function deleteCookie(): void {
		$token = Minz_Session::getLongTermCookie('FreshRSS_login');
		if (ctype_alnum($token)) {
			Minz_Session::deleteLongTermCookie('FreshRSS_login');
			@unlink(DATA_PATH . '/tokens/' . $token . '.txt');
		}

		if (rand(0, 10) === 1) {
			self::purgeTokens();
		}
	}

	public static function purgeTokens(): void {
		$limits = FreshRSS_Context::systemConf()->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? FreshRSS_Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
		$oldest = time() - $cookie_duration;
		foreach (new DirectoryIterator(DATA_PATH . '/tokens/') as $file_info) {
			$extension = $file_info->getExtension();
			if ($extension === 'txt' && $file_info->getMTime() < $oldest) {
				@unlink($file_info->getPathname());
			}
		}
	}
}
