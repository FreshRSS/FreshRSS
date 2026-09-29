<?php
declare(strict_types=1);

/**
 * Manage the emails sent to the users.
 */
class FreshRSS_User_Mailer extends Minz_Mailer {

	/**
	 * @var FreshRSS_View
	 * @phpstan-ignore property.phpDocType
	 */
	protected $view;

	public function __construct() {
		parent::__construct(FreshRSS_View::class);
	}

	public function send_email_need_validation(string $username, FreshRSS_UserConfiguration $user_config): bool {
		Minz_Translate::reset($user_config->language);

		$this->view->_path('user_mailer/email_need_validation.txt.php');

		$this->view->username = $username;
		$this->view->site_title = FreshRSS_Context::systemConf()->title;
		$this->view->validation_url = Minz_Url::display(
			[
				'c' => 'user',
				'a' => 'validateEmail',
				'params' => [
					'username' => $username,
					'token' => $user_config->email_validation_token,
				],
			],
			'txt',
			true
		);

		$subject_prefix = '[' . FreshRSS_Context::systemConf()->title . ']';
		return $this->mail(
			$user_config->mail_login,
			$subject_prefix . ' ' . _t('user.mailer.email_need_validation.title')
		);
	}

	public function send_password_reset(string $username, FreshRSS_UserConfiguration $user_config, #[\SensitiveParameter] string $token): bool {
		Minz_Translate::reset($user_config->language);

		$this->view->_path('user_mailer/password_reset.txt.php');

		$this->view->username = $username;
		$this->view->site_title = FreshRSS_Context::systemConf()->title;
		$this->view->reset_url = Minz_Url::display(
			[
				'c' => 'auth',
				'a' => 'resetPassword',
				'params' => [
					'username' => $username,
					'token' => $token,
				],
			],
			'txt',
			true
		);
		$this->view->expiry_minutes = intdiv(FreshRSS_password_Util::RESET_TOKEN_LIFETIME, 60);

		$subject_prefix = '[' . FreshRSS_Context::systemConf()->title . ']';
		return $this->mail(
			$user_config->mail_login,
			$subject_prefix . ' ' . _t('user.mailer.password_reset.title')
		);
	}
}
