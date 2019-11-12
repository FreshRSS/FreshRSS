<?php

namespace Minz;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Allow to send emails.
 *
 * The Mailer class must be inherited by classes under app/Mailers.
 * They work similarly to the ActionControllers in the way they have a view to
 * which you can pass params (eg. $this->view->foo = 'bar').
 *
 * The view file is not determined automatically, so you have to select one
 * with, for instance:
 *
 * ```
 * $this->view->_path('user_mailer/email_need_validation.txt')
 * ```
 *
 * Mailer uses the PHPMailer library under the hood. The latter requires
 * PHP >= 5.5 to work. If you instantiate a Mailer with PHP < 5.5, a
 * warning will be logged.
 *
 * The email is sent by calling the `mail` method.
 */
class Mailer {
	/**
	 * The view attached to the mailer.
	 * You should set its file with `$this->view->_path($path)`
	 *
	 * @var View
	 */
	protected $view;

	/**
	 * Constructor.
	 *
	 * If PHP version is < 5.5, a warning is logged.
	 */
	public function __construct () {
		if (version_compare(PHP_VERSION, '5.5') < 0) {
			Log::warning('Minz_Mailer cannot be used with a version of PHP < 5.5.');
		}

		$this->view = new View();
		$this->view->_layout(false);
		$this->view->attributeParams();

		$conf = Configuration::get('system');
		$this->mailer = $conf->mailer;
		$this->smtp_config = $conf->smtp;

		// According to https://github.com/PHPMailer/PHPMailer/wiki/SMTP-Debugging#debug-levels
		// we should not use debug level above 2 unless if we have big trouble
		// to connect.
		if ($conf->environment === 'development') {
			$this->debug_level = 2;
		} else {
			$this->debug_level = 0;
		}
	}

	/**
	 * Send an email.
	 *
	 * @param string $to The recipient of the email
	 * @param string $subject The subject of the email
	 *
	 * @return bool true on success, false if a SMTP error happens
	 */
	public function mail($to, $subject) {
		ob_start();
		$this->view->render();
		$body = ob_get_contents();
		ob_end_clean();

		PHPMailer::$validator = 'html5';

		$mail = new PHPMailer(true);
		try {
			// Server settings
			$mail->SMTPDebug = $this->debug_level;
			$mail->Debugoutput = 'error_log';

			if ($this->mailer === 'smtp') {
				$mail->isSMTP();
				$mail->Hostname = $this->smtp_config['hostname'];
				$mail->Host = $this->smtp_config['host'];
				$mail->SMTPAuth = $this->smtp_config['auth'];
				$mail->Username = $this->smtp_config['username'];
				$mail->Password = $this->smtp_config['password'];
				$mail->SMTPSecure = $this->smtp_config['secure'];
				$mail->Port = $this->smtp_config['port'];
			} else {
				$mail->isMail();
			}

			// Recipients
			$mail->setFrom($this->smtp_config['from']);
			$mail->addAddress($to);

			// Content
			$mail->isHTML(false);
			$mail->CharSet = 'utf-8';
			$mail->Subject = $subject;
			$mail->Body = $body;

			$mail->send();
			return true;
		} catch (Exception $e) {
			Log::error('Minz_Mailer cannot send a message: ' . $mail->ErrorInfo);
			return false;
		}
	}
}
