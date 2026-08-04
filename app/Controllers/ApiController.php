<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Minz\Error;
use FreshRss\Minz\Request;
use FreshRss\Minz\User;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Utils\FeverUtil;
use FreshRss\Utils\PasswordUtil;

/**
 * This controller manage API-related features.
 */
class ApiController extends ActionController {

	/**
	 * Update the user API password.
	 * Return an error message, or `false` if no error.
	 */
	public static function updatePassword(string $apiPasswordPlain): string|false {
		$username = User::name();
		if ($username == null) {
			return _t('feedback.api.password.failed');
		}

		$apiPasswordHash = PasswordUtil::hash($apiPasswordPlain);
		Context::userConf()->apiPasswordHash = $apiPasswordHash;

		$feverKey = FeverUtil::updateKey($username, $apiPasswordPlain);
		if ($feverKey == false) {
			return _t('feedback.api.password.failed');
		}

		Context::userConf()->feverKey = $feverKey;
		if (Context::userConf()->save()) {
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
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		$return_url = ['c' => 'user', 'a' => 'profile'];

		if (!Request::isPost()) {
			Request::forward($return_url, true);
		}

		$apiPasswordPlain = Request::paramString('apiPasswordPlain', true);
		if ($apiPasswordPlain == '') {
			Request::forward($return_url, true);
		}

		$error = self::updatePassword($apiPasswordPlain);
		if (is_string($error)) {
			Request::bad($error, $return_url);
		} else {
			Request::good(
				_t('feedback.api.password.updated'),
				$return_url,
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}
	}
}
