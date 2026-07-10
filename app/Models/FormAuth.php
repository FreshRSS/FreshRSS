<?php
declare(strict_types=1);

namespace FreshRss\Models;

use FreshRss\Controllers\UserController;
use FreshRss\Minz\Log;
use FreshRss\Minz\Session;

class FormAuth {
	public static function checkCredentials(string $username, string $hash, string $nonce, string $challenge): bool {
		if (!UserController::checkUsername($username) ||
				!ctype_graph($hash) ||
				!ctype_graph($challenge) ||
				!ctype_alnum($nonce)) {
			Log::debug("Invalid credential parameters: user={$username}, challenge={$challenge}, nonce={$nonce}");
			return false;
		}

		return password_verify($hash . $nonce, $challenge);
	}

	/** @return list<string> */
	public static function getCredentialsFromCookie(): array {
		$token = Session::getLongTermCookie('FreshRSS_login');
		if (!ctype_alnum($token)) {
			return [];
		}

		$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		$mtime = @filemtime($token_file) ?: 0;
		$limits = Context::systemConf()->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
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
			$limits = Context::systemConf()->limits;
			$cookie_duration = empty($limits['cookie_duration']) ? Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
			$expire = time() + $cookie_duration;
			Session::setLongTermCookie('FreshRSS_login', $token, $expire);
			return $token;
		}
		return false;
	}

	public static function makeCookie(string $username, string $password_hash): string|false {
		do {
			$token = hash('sha256', Context::systemConf()->salt . $username . random_bytes(32));
			$token_file = DATA_PATH . '/tokens/' . $token . '.txt';
		} while (file_exists($token_file));

		if (@file_put_contents($token_file, $username . "\t" . $password_hash) === false) {
			return false;
		}

		return self::renewCookie($token);
	}

	public static function deleteCookie(): void {
		$token = Session::getLongTermCookie('FreshRSS_login');
		if (ctype_alnum($token)) {
			Session::deleteLongTermCookie('FreshRSS_login');
			@unlink(DATA_PATH . '/tokens/' . $token . '.txt');
		}

		if (rand(0, 10) === 1) {
			self::purgeTokens();
		}
	}

	public static function purgeTokens(): void {
		$limits = Context::systemConf()->limits;
		$cookie_duration = empty($limits['cookie_duration']) ? Auth::DEFAULT_COOKIE_DURATION : $limits['cookie_duration'];
		$oldest = time() - $cookie_duration;
		foreach (new \DirectoryIterator(DATA_PATH . '/tokens/') as $file_info) {
			$extension = $file_info->getExtension();
			if ($extension === 'txt' && $file_info->getMTime() < $oldest) {
				@unlink($file_info->getPathname());
			}
		}
	}
}
