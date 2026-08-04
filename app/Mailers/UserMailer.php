<?php
declare(strict_types=1);

namespace FreshRss\Mailers;

use FreshRss\Minz\Mailer;
use FreshRss\Minz\Translate;
use FreshRss\Minz\Url;
use FreshRss\Models\Context;
use FreshRss\Models\UserConfiguration;
use FreshRss\Models\View;

/**
 * Manage the emails sent to the users.
 */
class UserMailer extends Mailer {

	/**
	 * @var View
	 * @phpstan-ignore property.phpDocType
	 */
	protected $view;

	public function __construct() {
		parent::__construct(View::class);
	}

	public function send_email_need_validation(string $username, UserConfiguration $user_config): bool {
		Translate::reset($user_config->language);

		$this->view->_path('user_mailer/email_need_validation.txt.php');

		$this->view->username = $username;
		$this->view->site_title = Context::systemConf()->title;
		$this->view->validation_url = Url::display(
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

		$subject_prefix = '[' . Context::systemConf()->title . ']';
		return $this->mail(
			$user_config->mail_login,
			$subject_prefix . ' ' . _t('user.mailer.email_need_validation.title')
		);
	}
}
