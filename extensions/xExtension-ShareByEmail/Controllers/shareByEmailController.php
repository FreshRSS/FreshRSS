<?php

declare(strict_types=1);

final class FreshExtension_shareByEmail_Controller extends Minz_ActionController {
	public ?Minz_Extension $extension;

	/** @var ShareByEmail\mailers\View */
	protected $view;

	public function __construct() {
		parent::__construct(ShareByEmail\mailers\View::class);
	}

	#[\Override]
	public function init(): void {
		$this->extension = Minz_ExtensionManager::findExtension('Share By Email');
	}

	public function shareAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}

		$id = Minz_Request::paramString('id');
		if ($id === '') {
			Minz_Error::error(404);
		}

		$entryDAO = FreshRSS_Factory::createEntryDao();
		$entry = $entryDAO->searchById($id);
		if ($entry === null) {
			Minz_Error::error(404);
			return;
		}
		$this->view->entry = $entry;

		if (!FreshRSS_Context::hasSystemConf()) {
			throw new FreshRSS_Context_Exception('System configuration not initialised!');
		}

		$username = Minz_Session::paramString('currentUser') ?: '_';
		$service_name = FreshRSS_Context::systemConf()->title;
		$service_url = FreshRSS_Context::systemConf()->base_url;

		Minz_View::prependTitle(_t('shareByEmail.share.title') . ' · ');
		if ($this->extension !== null) {
			Minz_View::appendStyle($this->extension->getFileUrl('shareByEmail.css', 'css'));
		}
		$this->view->_layout('simple');
		$this->view->to = '';
		$this->view->subject = _t('shareByEmail.share.form.subject_default');
		$this->view->content = _t(
			'shareByEmail.share.form.content_default',
			$entry->title(),
			$entry->link(),
			$username,
			$service_name,
			$service_url
		);

		if (Minz_Request::isPost()) {
			$this->view->to = $to = Minz_Request::paramString('to');
			$this->view->subject = $subject = Minz_Request::paramString('subject');
			$this->view->content = $content = Minz_Request::paramString('content');

			if ($to == "" || $subject == "" || $content == "") {
				Minz_Request::bad(_t('shareByEmail.share.feedback.fields_required'), [
					'c' => 'shareByEmail',
					'a' => 'share',
					'params' => [
						'id' => $id,
					],
				]);
			}

			$mailer = new \ShareByEmail\mailers\Share();
			$sent = $mailer->send_article($to, $subject, $content);

			if ($sent) {
				Minz_Request::good(_t('shareByEmail.share.feedback.sent'), [
					'c' => 'index',
					'a' => 'index',
				]);
			} else {
				Minz_Request::bad(_t('shareByEmail.share.feedback.failed'), [
					'c' => 'shareByEmail',
					'a' => 'share',
					'params' => [
						'id' => $id,
					],
				]);
			}
		}
	}
}
