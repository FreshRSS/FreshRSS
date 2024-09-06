<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Allow to send emails.
 *
 * The Minz_Mailer class must be inherited by classes under app/Mailers.
 * They work similarly to the ActionControllers in the way they have a view to
 * which you can pass params (eg. $this->view->foo = 'bar').
 *
 * The view file is not determined automatically, so you have to select one
 * with, for instance:
 *
 * ```
 * $this->view->_path('user_mailer/email_need_validation.txt.php')
 * ```
 *
 * The email is sent by calling the `mail` method.
 */
class Minz_Mailer {
	/**
	 * The view attached to the mailer.
	 * You should set its file with `$this->view->_path($path)`
	 *
	 * @var Minz_View
	 */
	protected $view;

	private string $mailer;
	/** @var array{'hostname':string,'host':string,'auth':bool,'username':string,'password':string,'secure':string,'port':int,'from':string} */
	private array $smtp_config;
	private int $debug_level;

	/**
	 * @phpstan-param class-string|'' $viewType
	 * @param string $viewType Name of the class (inheriting from Minz_View) to use for the view model
	 * @throws Minz_ConfigurationException
	 */
	public function __construct(string $viewType = '') {
		$view = null;
		if ($viewType !== '' && class_exists($viewType)) {
			$view = new $viewType();
			if (!($view instanceof Minz_View)) {
				$view = null;
			}
		}
		$this->view = $view ?? new Minz_View();
		$this->view->_layout(null);
		$this->view->attributeParams();

		$conf = Minz_Configuration::get('system');
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
	 * @return bool true on success, false if a SMTP error happens
	 */
	public function mail(string $to, string $subject): bool {
		ob_start();
		$this->view->render();
		$body = ob_get_contents() ?: '';
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
			Minz_Log::error('Minz_Mailer cannot send a message: ' . $mail->ErrorInfo);
			return false;
		}
	}
}
