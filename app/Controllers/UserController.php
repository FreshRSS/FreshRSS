<?php
declare(strict_types=1);

namespace FreshRss\Controllers;

use FreshRss\Mailers\UserMailer;
use FreshRss\Minz\ConfigurationNamespaceException;
use FreshRss\Minz\Error;
use FreshRss\Minz\Log;
use FreshRss\Minz\ModelPdo;
use FreshRss\Minz\PDOConnectionException;
use FreshRss\Minz\Request;
use FreshRss\Minz\Session;
use FreshRss\Minz\Translate;
use FreshRss\Minz\Url;
use FreshRss\Minz\User;
use FreshRss\Models\ActionController;
use FreshRss\Models\Auth;
use FreshRss\Models\Context;
use FreshRss\Models\Factory;
use FreshRss\Models\FormAuth;
use FreshRss\Models\UserConfiguration;
use FreshRss\Models\UserDAO;
use FreshRss\Models\View;
use FreshRss\Utils\FeverUtil;
use FreshRss\Utils\PasswordUtil;

/**
 * Controller to handle user actions.
 */
class UserController extends ActionController {
	/**
	 * The username is also used as folder name, file name, and part of SQL table name.
	 * '_' is a reserved internal username.
	 */
	public const USERNAME_PATTERN = '([0-9a-zA-Z_][0-9a-zA-Z_.@\-]{1,38}|[0-9a-zA-Z])';

	public static function checkUsername(string $username): bool {
		return preg_match('/^' . self::USERNAME_PATTERN . '$/', $username) === 1;
	}

	/**
	 * Validate an email address, supports internationalized addresses.
	 *
	 * @param string $email The address to validate
	 * @return bool true if email is valid, else false
	 */
	private static function validateEmailAddress(string $email): bool {
		$mailer = new \PHPMailer\PHPMailer\PHPMailer();
		$mailer->CharSet = 'utf-8';
		$punyemail = $mailer->punyencodeAddress($email);
		return \PHPMailer\PHPMailer\PHPMailer::validateAddress($punyemail, 'html5');
	}

	/**
	 * @return list<string>
	 */
	public static function listUsers(): array {
		$final_list = [];
		$base_path = join_path(DATA_PATH, 'users');
		$dir_list = array_values(array_diff(
			scandir($base_path) ?: [],
			['..', '.', User::INTERNAL_USER]
		));
		foreach ($dir_list as $file) {
			if ($file[0] !== '.' && is_dir(join_path($base_path, $file)) && file_exists(join_path($base_path, $file, 'config.php'))) {
				$final_list[] = $file;
			}
		}
		return $final_list;
	}

	public static function userExists(string $username): bool {
		$config_path = USERS_PATH . '/' . $username . '/config.php';
		if (@file_exists($config_path)) {
			return true;
		} elseif (@file_exists($config_path . '.bak.php')) {
			Log::warning('Config for user “' . $username . '” not found. Attempting to restore from backup.', ADMIN_LOG);
			if (!copy($config_path . '.bak.php', $config_path)) {
				@unlink($config_path);
				return false;
			}
			return @file_exists($config_path);
		}
		return false;
	}

	/**
	 * Return if the maximum number of registrations has been reached.
	 * Note a max_registrations of 0 means there is no limit.
	 *
	 * @return bool true if number of users >= max registrations, false otherwise.
	 */
	public static function max_registrations_reached(): bool {
		$limit_registrations = Context::systemConf()->limits['max_registrations'];
		$number_accounts = count(self::listUsers());
		return $limit_registrations > 0 && $number_accounts >= $limit_registrations;
	}

	/** @param array<string,mixed> $userConfigUpdated */
	public static function updateUser(string $user, ?string $email, string $passwordPlain, array $userConfigUpdated = []): bool {
		$userConfig = UserConfiguration::getForUser($user);
		if ($userConfig === null) {
			return false;
		}

		if ($email !== null && $userConfig->mail_login !== $email) {
			$userConfig->mail_login = $email;

			if (Context::systemConf()->force_email_validation) {
				$userConfig->email_validation_token = hash('sha256', Context::systemConf()->salt . $email . random_bytes(32));
				$mailer = new UserMailer();
				$mailer->send_email_need_validation($user, $userConfig);
			}
		}

		if ($passwordPlain != '') {
			$passwordHash = PasswordUtil::hash($passwordPlain);
			$userConfig->passwordHash = $passwordHash;
			if ($user === User::name()) {
				Context::userConf()->passwordHash = $passwordHash;
			}
		}

		foreach ($userConfigUpdated as $configName => $configValue) {
			if ($configName !== '' && $configValue !== null) {
				$userConfig->_attribute($configName, $configValue);
			}
		}

		$ok = $userConfig->save();
		return $ok;
	}

	public function updateAction(): void {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (Request::isPost()) {
			if (self::reauthRedirect()) {
				return;
			}

			$username = Request::paramString('username');
			$newPasswordPlain = User::name() !== $username ? Request::paramString('newPasswordPlain', true) : '';

			$ok = self::updateUser($username, null, $newPasswordPlain, [
				'token' => Request::paramString('token') ?: null,
			]);

			if ($ok) {
				$isSelfUpdate = User::name() === $username;
				if ($newPasswordPlain == '' || !$isSelfUpdate) {
					Request::good(
						_t('feedback.user.updated', $username),
						['c' => 'user', 'a' => 'manage'],
						showNotification: Context::userConf()->good_notification_timeout > 0
					);
				} else {
					Request::good(
						_t('feedback.profile.updated'),
						['c' => 'index', 'a' => 'index'],
						showNotification: Context::userConf()->good_notification_timeout > 0
					);
				}
			} else {
				Request::bad(_t('feedback.user.updated.error', $username), ['c' => 'user', 'a' => 'manage']);
			}
		}
	}

	/**
	 * This action displays the user profile page.
	 */
	public function profileAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		$email_not_verified = Context::userConf()->email_validation_token != '';
		$this->view->disable_aside = false;
		if ($email_not_verified) {
			$this->view->disable_aside = true;
		}

		View::prependTitle(_t('conf.profile.title') . ' · ');

		View::appendScript(Url::display('/scripts/vendor/bcrypt.js?' . @filemtime(PUBLIC_PATH . '/scripts/vendor/bcrypt.js')));

		if (Request::isPost() && User::name() != null) {
			$old_email = Context::userConf()->mail_login;

			$email = Request::paramString('email');

			$challenge = Request::paramString('challenge');
			$newPasswordPlain = '';
			if ($challenge !== '') {
				$username = User::name();
				$nonce = Session::paramString('nonce');

				$newPasswordPlain = Request::paramString('newPasswordPlain', plaintext: true);
				$confirmPasswordPlain = Request::paramString('confirmPasswordPlain', plaintext: true);

				if (!FormAuth::checkCredentials(
					$username, Context::userConf()->passwordHash, $nonce, $challenge
					) || strlen($newPasswordPlain) < 7) {
					Session::_param('open', true); // Auto-expand `change password` section
					Request::bad(
						_t('feedback.auth.login.invalid'),
						['c' => 'user', 'a' => 'profile']
					);
					return;
				}

				if ($newPasswordPlain !== $confirmPasswordPlain) {
					Session::_param('open', true); // Auto-expand `change password` section
					Request::bad(
						_t('feedback.profile.passwords_dont_match'),
						['c' => 'user', 'a' => 'profile']
					);
					return;
				}

				Session::regenerateID('FreshRSS');
			}

			if (Context::systemConf()->force_email_validation && empty($email)) {
				Request::bad(
					_t('user.email.feedback.required'),
					['c' => 'user', 'a' => 'profile']
				);
			}

			if (!empty($email) && !self::validateEmailAddress($email)) {
				Request::bad(
					_t('user.email.feedback.invalid'),
					['c' => 'user', 'a' => 'profile']
				);
			}

			$ok = self::updateUser(
				User::name(),
				$email,
				$newPasswordPlain,
				[
					'token' => Request::paramString('token'),
				]
			);

			Session::_param('passwordHash', Context::userConf()->passwordHash);

			if ($ok) {
				if (Context::systemConf()->force_email_validation && $email !== $old_email) {
					Request::good(
						_t('feedback.profile.updated'),
						['c' => 'user', 'a' => 'validateEmail'],
						showNotification: Context::userConf()->good_notification_timeout > 0
					);
				} else {
					Request::good(
						_t('feedback.profile.updated'),
						['c' => 'user', 'a' => 'profile'],
						showNotification: Context::userConf()->good_notification_timeout > 0
					);
				}
			} else {
				Request::bad(_t('feedback.profile.error'), ['c' => 'user', 'a' => 'profile']);
			}
		}
	}

	public static function reauthRedirect(): bool {
		$url_redirect = [
			'c' => 'user',
			'a' => 'manage',
			'params' => [],
		];
		$username = Request::paramStringNull('username');
		if ($username !== null) {
			$url_redirect['a'] = 'details';
			$url_redirect['params']['username'] = $username;
		}
		return Auth::requestReauth($url_redirect);
	}

	public function purgeAction(): void {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (!Request::isPost()) {
			Error::error(403);
		}

		if (self::reauthRedirect()) {
			return;
		}

		$username = Request::paramString('username');

		if (!UserDAO::exists($username)) {
			Error::error(404);
		}

		$feedDAO = Factory::createFeedDao($username);
		$feedDAO->purge();
	}

	/**
	 * This action displays the user management page.
	 */
	public function manageAction(): void {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (self::reauthRedirect()) {
			return;
		}

		View::prependTitle(_t('admin.user.title') . ' · ');

		if (Request::isPost()) {
			$action = Request::paramString('action');
			switch ($action) {
				case 'delete':
					$this->deleteAction();
					break;
				case 'update':
					$this->updateAction();
					break;
				case 'purge':
					$this->purgeAction();
					break;
				case 'promote':
					$this->promoteAction();
					break;
				case 'demote':
					$this->demoteAction();
					break;
				case 'enable':
					$this->enableAction();
					break;
				case 'disable':
					$this->disableAction();
					break;
			}
		}

		$this->view->show_email_field = Context::systemConf()->force_email_validation;
		$this->view->current_user = Request::paramString('u');

		$fast = false;
		$startTime = time();
		foreach (self::listUsers() as $user) {
			if (!$fast && (time() - $startTime >= 3)) {
				// Disable detailed user statistics if it takes too long, and will retrieve them asynchronously via JavaScript
				$fast = true;
			}
			$this->view->users[$user] = $this->retrieveUserDetails($user, $fast);
		}
	}

	/**
	 * @param array<string,mixed> $userConfigOverride
	 * @throws ConfigurationNamespaceException
	 * @throws PDOConnectionException
	 */
	public static function createUser(string $new_user_name, ?string $email, string $passwordPlain,
		array $userConfigOverride = [], bool $insertDefaultFeeds = true): bool {
		$userConfig = [];

		$customUserConfigPath = join_path(DATA_PATH, 'config-user.custom.php');
		if (file_exists($customUserConfigPath)) {
			$customUserConfig = include $customUserConfigPath;
			if (is_array($customUserConfig)) {
				$userConfig = $customUserConfig;
			}
		}

		$userConfig = array_merge($userConfig, $userConfigOverride);

		$ok = self::checkUsername($new_user_name);
		$homeDir = join_path(DATA_PATH, 'users', $new_user_name);
		// create basepath if missing
		if (!is_dir(join_path(DATA_PATH, 'users'))) {
			$ok &= mkdir(join_path(DATA_PATH, 'users'), 0770, true);
		}
		$configPath = '';

		if ($ok) {
			if (!Translate::exists(is_string($userConfig['language'] ?? null) ? $userConfig['language'] : '')) {
				$userConfig['language'] = Translate::DEFAULT_LANGUAGE;
			}

			$ok &= !in_array(strtoupper($new_user_name), array_map('strtoupper', self::listUsers()), true);	//Not an existing user, case-insensitive

			$configPath = join_path($homeDir, 'config.php');
			$ok &= !file_exists($configPath);
		}
		if ($ok) {
			// $homeDir must not exist beforehand,
			// otherwise it might be multiple remote parties racing to register one username
			$ok = mkdir($homeDir, 0770, true);
			if ($ok) {
				$ok &= (file_put_contents($configPath, "<?php\n return " . var_export($userConfig, true) . ';') !== false);
			}
		}
		if ($ok) {
			$newUserDAO = Factory::createUserDao($new_user_name);
			$ok &= $newUserDAO->createUser();

			if ($ok && $insertDefaultFeeds) {
				$opmlPath = DATA_PATH . '/opml.xml';
				if (!file_exists($opmlPath)) {
					$opmlPath = FRESHRSS_PATH . '/opml.default.xml';
				}
				$importController = new ImportExportController();
				try {
					$importController->importFile($opmlPath, $opmlPath, $new_user_name);
				} catch (\Exception $e) {
					Log::error('Error while importing default OPML for user ' . $new_user_name . ': ' . $e->getMessage());
				}
			}

			$ok &= self::updateUser($new_user_name, $email, $passwordPlain);
		}
		return (bool)$ok;
	}

	/**
	 * This action creates a new user.
	 *
	 * Request parameters are:
	 *   - new_user_language
	 *   - new_user_name
	 *   - new_user_email
	 *   - new_user_passwordPlain
	 *   - r (i.e. a redirection url, optional)
	 *
	 * @todo clean up this method. Idea: write a method to init a user with basic information.
	 */
	public function createAction(): void {
		if (!Auth::hasAccess('admin') && self::max_registrations_reached()) {
			Error::error(403);
		}

		if (Auth::hasAccess('admin') && self::reauthRedirect()) {
			return;
		}

		if (Request::isPost()) {
			$new_user_name = Request::paramString('new_user_name');
			$email = Request::paramString('new_user_email');
			$passwordPlain = Request::paramString('new_user_passwordPlain', true);
			$badRedirectUrl = [
				'c' => Request::paramString('originController') ?: 'auth',
				'a' => Request::paramString('originAction') ?: 'register',
			];

			if (!self::checkUsername($new_user_name)) {
				Request::bad(
					_t('user.username.invalid'),
					$badRedirectUrl
				);
			}

			if (UserDAO::exists($new_user_name)) {
				Request::bad(
					_t('user.username.taken', $new_user_name),
					$badRedirectUrl
				);
			}

			if (!PasswordUtil::check($passwordPlain)) {
				Request::bad(
					_t('user.password.invalid'),
					$badRedirectUrl
				);
			}

			if (!Auth::hasAccess('admin')) {
				// TODO: We may want to ask the user to accept TOS before first login
				$tos_enabled = file_exists(TOS_FILENAME);
				$accept_tos = Request::paramBoolean('accept_tos');
				if ($tos_enabled && !$accept_tos) {
					Request::bad(_t('user.tos.feedback.invalid'), $badRedirectUrl);
				}
			}

			if (Context::systemConf()->force_email_validation && empty($email)) {
				Request::bad(
					_t('user.email.feedback.required'),
					$badRedirectUrl
				);
			}

			if (!empty($email) && !self::validateEmailAddress($email)) {
				Request::bad(
					_t('user.email.feedback.invalid'),
					$badRedirectUrl
				);
			}

			$is_admin = false;
			if (Auth::hasAccess('admin')) {
				$is_admin = Request::paramBoolean('new_user_is_admin');
			}

			$ok = self::createUser($new_user_name, $email, $passwordPlain, [
				'language' => Request::paramString('new_user_language') ?: Context::userConf()->language,
				'timezone' => Request::paramString('new_user_timezone'),
				'is_admin' => $is_admin,
				'enabled' => true,
			]);
			Request::_param('new_user_passwordPlain');	//Discard plain-text password ASAP
			$_POST['new_user_passwordPlain'] = '';
			invalidateHttpCache();

			// If the user has admin access, it means he’s already logged in
			// and we don’t want to login with the new account. Otherwise, the
			// user just created its account himself so he probably wants to
			// get started immediately.
			if ($ok && !Auth::hasAccess('admin')) {
				$user_conf = UserConfiguration::getForUser($new_user_name);
				if ($user_conf !== null) {
					Session::_params([
						User::CURRENT_USER => $new_user_name,
						'passwordHash' => $user_conf->passwordHash,
						'csrf' => false,
					]);
					Auth::giveAccess();
				} else {
					$ok = false;
				}
			}

			if ($ok) {
				Request::setGoodNotification(_t('feedback.user.created', $new_user_name));
			} else {
				Request::setBadNotification(_t('feedback.user.created.error', $new_user_name));
			}
		}

		if (Auth::hasAccess('admin')) {
			$redirect_url = ['c' => 'user', 'a' => 'manage'];
		} else {
			$redirect_url = ['c' => 'index', 'a' => 'index'];
		}
		Request::forward($redirect_url, true);
	}

	public static function deleteUser(string $username): bool {
		$ok = self::checkUsername($username);
		if ($ok) {
			$default_user = Context::systemConf()->default_user;
			$ok &= (strcasecmp($username, $default_user) !== 0);	//It is forbidden to delete the default user
		}
		$user_data = join_path(DATA_PATH, 'users', $username);
		$ok &= is_dir($user_data);
		if ($ok) {
			FeverUtil::deleteKey($username);
			ModelPdo::$usesSharedPdo = false;
			$oldUserDAO = Factory::createUserDao($username);
			$ok &= $oldUserDAO->deleteUser();
			ModelPdo::$usesSharedPdo = true;
			$ok &= recursive_unlink($user_data);
			$filenames = glob(PSHB_PATH . '/feeds/*/' . $username . '.txt');
			if (!empty($filenames)) {
				array_map('unlink', $filenames);
			}
		}
		return (bool)$ok;
	}

	/**
	 * This action validates an email address, based on the token sent by email.
	 * It also serves the main page when user is blocked.
	 *
	 * Request parameters are:
	 *   - username
	 *   - token
	 *
	 * This route works with GET requests since the URL is provided by email.
	 * The security risks (e.g. forged URL by an attacker) are not very high so
	 * it’s ok.
	 *
	 * It returns 404 error if `force_email_validation` is disabled or if the
	 * user doesn’t exist.
	 *
	 * It returns 403 if user isn’t logged in and `username` param isn’t passed.
	 */
	public function validateEmailAction(): void {
		if (!Context::systemConf()->force_email_validation) {
			Error::error(404);
		}

		View::prependTitle(_t('user.email.validation.title') . ' · ');

		$username = Request::paramString('username');
		if (Auth::hasAccess()) {
			$username = User::name() ?? '';
		}
		$token = Request::paramString('token');

		if ($username !== '') {
			$user_config = UserConfiguration::getForUser($username);
		} elseif (Auth::hasAccess()) {
			$user_config = Context::userConf();
		} else {
			Error::error(403);
			return;
		}

		if (!UserDAO::exists($username) || $user_config === null) {
			Error::error(404);
			return;
		}

		if ($user_config->email_validation_token === '') {
			Request::good(
				_t('user.email.validation.feedback.unnecessary'),
				['c' => 'index', 'a' => 'index'],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		}

		if ($token != '') {
			if (!hash_equals($user_config->email_validation_token, $token)) {
				Request::bad(
					_t('user.email.validation.feedback.wrong_token'),
					['c' => 'user', 'a' => 'validateEmail']
				);
			}

			$user_config->email_validation_token = '';
			if ($user_config->save()) {
				Request::good(
					_t('user.email.validation.feedback.ok'),
					['c' => 'index', 'a' => 'index'],
					showNotification: Context::userConf()->good_notification_timeout > 0
				);
			} else {
				Request::bad(
					_t('user.email.validation.feedback.error'),
					['c' => 'user', 'a' => 'validateEmail']
				);
			}
		}
	}

	/**
	 * This action resends a validation email to the current user.
	 *
	 * It only acts on POST requests but doesn’t require any param (except the
	 * CSRF token).
	 *
	 * It returns 403 error if the user is not logged in or 404 if request is
	 * not POST. Else it redirects silently to the index if user has already
	 * validated its email, or to the user#validateEmail route.
	 */
	public function sendValidationEmailAction(): void {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}

		if (!Request::isPost()) {
			Error::error(404);
		}

		$username = User::name();

		if (Context::userConf()->email_validation_token === '') {
			Request::forward([
				'c' => 'index',
				'a' => 'index',
			], true);
		}

		$mailer = new UserMailer();
		$ok = $username != null && $mailer->send_email_need_validation($username, Context::userConf());

		$redirect_url = ['c' => 'user', 'a' => 'validateEmail'];
		if ($ok) {
			Request::good(
				_t('user.email.validation.feedback.email_sent'),
				$redirect_url,
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		} else {
			Request::bad(
				_t('user.email.validation.feedback.email_failed'),
				$redirect_url
			);
		}
	}

	/**
	 * This action delete an existing user.
	 *
	 * Request parameter is:
	 *   - username
	 *
	 * @todo clean up this method. Idea: create a User->clean() method.
	 */
	public function deleteAction(): void {
		$username = Request::paramString('username');
		$self_deletion = User::name() === $username;

		if (!Auth::hasAccess('admin') && !$self_deletion) {
			Error::error(403);
		}

		$redirect_url = ['c' => 'user', 'a' => 'manage'];

		if (Request::isPost()) {
			$ok = true;
			if ($self_deletion) {
				// We check the password if it’s a self-destruction
				$nonce = Session::paramString('nonce');
				$challenge = Request::paramString('challenge');

				$ok &= FormAuth::checkCredentials(
					$username, Context::userConf()->passwordHash,
					$nonce, $challenge
				);
				if (!$ok) {
					Request::bad(_t('feedback.auth.login.invalid'), ['c' => 'user', 'a' => 'profile']);
					return;
				}
			} elseif (self::reauthRedirect()) {
				return;
			}

			$ok &= self::deleteUser($username);

			if ($ok && $self_deletion) {
				Auth::removeAccess();
				$redirect_url = ['c' => 'index', 'a' => 'index'];
			}
			invalidateHttpCache();

			if ($ok) {
				Request::setGoodNotification(_t('feedback.user.deleted', $username));
			} else {
				Request::setBadNotification(_t('feedback.user.deleted.error', $username));
			}
		}

		Request::forward($redirect_url, true);
	}

	public function promoteAction(): void {
		$this->toggleAction('is_admin', true);
	}

	public function demoteAction(): void {
		$this->toggleAction('is_admin', false);
	}

	public function enableAction(): void {
		$this->toggleAction('enabled', true);
	}

	public function disableAction(): void {
		$this->toggleAction('enabled', false);
	}

	private function toggleAction(string $field, bool $value): void {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (!Request::isPost()) {
			Error::error(403);
		}

		if (self::reauthRedirect()) {
			return;
		}

		$username = Request::paramString('username');
		if (!UserDAO::exists($username)) {
			Error::error(404);
		}

		if (null === $userConfig = UserConfiguration::getForUser($username)) {
			Error::error(500);
			return;
		}

		if ($field === '') {
			Error::error(400, 'Invalid field name');
			return;
		}

		$userConfig->_attribute($field, $value);

		$ok = $userConfig->save();
		UserDAO::touch($username);

		if ($ok) {
			Request::good(
				_t('feedback.user.updated', $username),
				['c' => 'user', 'a' => 'manage'],
				showNotification: Context::userConf()->good_notification_timeout > 0
			);
		} else {
			Request::bad(
				_t('feedback.user.updated.error', $username),
				['c' => 'user', 'a' => 'manage']
			);
		}
	}

	public function detailsAction(): void {
		if (!Auth::hasAccess('admin')) {
			Error::error(403);
		}

		if (self::reauthRedirect()) {
			return;
		}

		$username = Request::paramString('username');
		if (!UserDAO::exists($username)) {
			Error::error(404);
		}

		if (Request::paramBoolean('ajax')) {
			$this->view->_layout(null);
		}

		$this->view->username = $username;
		$this->view->details = $this->retrieveUserDetails($username);
		View::prependTitle($username . ' · ' . _t('gen.menu.user_management') . ' · ');
	}

	/** @return array{feed_count:?int,article_count:?int,database_size:?int,language:string,mail_login:string,enabled:bool,is_admin:bool,last_user_activity:string,is_default:bool} */
	private function retrieveUserDetails(string $username, bool $fast = false): array {
		$feedDAO = $fast ? null : Factory::createFeedDao($username);
		$entryDAO = $fast ? null : Factory::createEntryDao($username);
		$databaseDAO = $fast ? null : Factory::createDatabaseDAO($username);

		$userConfiguration = UserConfiguration::getForUser($username);
		if ($userConfiguration === null) {
			throw new \Exception('Error loading user configuration!');
		}

		return [
			'feed_count' => isset($feedDAO) ? $feedDAO->count() : null,
			'article_count' => isset($entryDAO) ? $entryDAO->count() : null,
			'database_size' => isset($databaseDAO) ? $databaseDAO->size() : null,
			'language' => $userConfiguration->language,
			'mail_login' => $userConfiguration->mail_login,
			'enabled' => $userConfiguration->enabled,
			'is_admin' => $userConfiguration->is_admin,
			'last_user_activity' => date('c', UserDAO::mtime($username)) ?: '',
			'is_default' => Context::systemConf()->default_user === $username,
		];
	}
}
