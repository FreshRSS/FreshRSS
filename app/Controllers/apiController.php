<?php
declare(strict_types=1);

/**
 * This controller manage API-related features.
 */
class FreshRSS_api_Controller extends FreshRSS_ActionController {

	/**
	 * Update the user API password.
	 * Return an error message, or `false` if no error.
	 */
	public static function updatePassword(string $apiPasswordPlain): string|false {
		$username = Minz_User::name();
		if ($username == null) {
			return _t('feedback.api.password.failed');
		}

		$apiPasswordHash = FreshRSS_password_Util::hash($apiPasswordPlain);
		FreshRSS_Context::userConf()->apiPasswordHash = $apiPasswordHash;

		$feverKey = FreshRSS_fever_Util::updateKey($username, $apiPasswordPlain);
		if ($feverKey == false) {
			return _t('feedback.api.password.failed');
		}

		FreshRSS_Context::userConf()->feverKey = $feverKey;
		if (FreshRSS_Context::userConf()->save()) {
			return false;
		} else {
			return _t('feedback.api.password.failed');
		}
	}

	/**
	 * This action updates the user API password.
	 *
	 * Parameter is:
	 * - apiPasswordPlain: the new user password
	 */
	public function updatePasswordAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$return_url = ['c' => 'user', 'a' => 'profile'];

		if (!Minz_Request::isPost()) {
			Minz_Request::forward($return_url, true);
		}

		$apiPasswordPlain = Minz_Request::paramString('apiPasswordPlain', true);
		if ($apiPasswordPlain == '') {
			Minz_Request::forward($return_url, true);
		}

		$error = self::updatePassword($apiPasswordPlain);
		if (is_string($error)) {
			Minz_Request::bad($error, $return_url);
		} else {
			Minz_Request::good(_t('feedback.api.password.updated'), $return_url);
		}
	}
}
