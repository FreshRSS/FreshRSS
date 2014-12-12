<?php

class FreshRSS_update_Controller extends Minz_ActionController {
	public function firstAction() {
		$current_user = Minz_Session::param('currentUser', '');
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		invalidateHttpCache();

		$this->view->update_to_apply = false;
		$this->view->last_update_time = 'unknown';
		$this->view->check_last_hour = false;
		$timestamp = (int)@file_get_contents(DATA_PATH . '/last_update.txt');
		if (is_numeric($timestamp) && $timestamp > 0) {
			$this->view->last_update_time = timestamptodate($timestamp);
			$this->view->check_last_hour = (time() - 3600) <= $timestamp;
		}
	}

	public function indexAction() {
		Minz_View::prependTitle(_t('admin.update.title') . ' · ');

		if (file_exists(UPDATE_FILENAME) && !is_writable(FRESHRSS_PATH)) {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('gen.short.damn'),
				'body' => _t('feedback.update.file_is_nok', FRESHRSS_PATH)
			);
		} elseif (file_exists(UPDATE_FILENAME)) {
			// There is an update file to apply!
			$this->view->update_to_apply = true;
			$this->view->message = array(
				'status' => 'good',
				'title' => _t('gen.short.ok'),
				'body' => _t('feedback.update.can_apply')
			);
		}
	}

	public function checkAction() {
		$this->view->change_view('update', 'index');

		if (file_exists(UPDATE_FILENAME) || $this->view->check_last_hour) {
			// There is already an update file to apply: we don't need to check
			// the webserver!
			// Or if already check during the last hour, do nothing.
			Minz_Request::forward(array('c' => 'update'));

			return;
		}

		$c = curl_init(FRESHRSS_UPDATE_WEBSITE);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
		$result = curl_exec($c);
		$c_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
		$c_error = curl_error($c);
		curl_close($c);

		if ($c_status !== 200) {
			Minz_Log::error(
				'Error during update (HTTP code ' . $c_status . '): ' . $c_error
			);

			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('gen.short.damn'),
				'body' => _t('feedback.update.server_not_found', FRESHRSS_UPDATE_WEBSITE)
			);
			return;
		}

		$res_array = explode("\n", $result, 2);
		$status = $res_array[0];
		if (strpos($status, 'UPDATE') !== 0) {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('gen.short.damn'),
				'body' => _t('feedback.update.none')
			);

			@file_put_contents(DATA_PATH . '/last_update.txt', time());

			return;
		}

		$script = $res_array[1];
		if (file_put_contents(UPDATE_FILENAME, $script) !== false) {
			Minz_Request::forward(array('c' => 'update'));
		} else {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('gen.short.damn'),
				'body' => _t('feedback.update.error', 'Cannot save the update script')
			);
		}
	}

	public function applyAction() {
		if (!file_exists(UPDATE_FILENAME) || !is_writable(FRESHRSS_PATH)) {
			Minz_Request::forward(array('c' => 'update'), true);
		}

		require(UPDATE_FILENAME);

		if (Minz_Request::param('post_conf', false)) {
			$res = do_post_update();

			if ($res === true) {
				@unlink(UPDATE_FILENAME);
				@file_put_contents(DATA_PATH . '/last_update.txt', time());
				Minz_Request::good(_t('feedback.update.finished'));
			} else {
				Minz_Request::bad(_t('feedback.update.error', $res),
				                  array('c' => 'update', 'a' => 'index'));
			}
		}

		if (Minz_Request::isPost()) {
			save_info_update();
		}

		if (!need_info_update()) {
			$res = apply_update();

			if ($res === true) {
				Minz_Request::forward(array(
					'c' => 'update',
					'a' => 'apply',
					'params' => array('post_conf' => true)
				), true);
			} else {
				Minz_Request::bad(_t('feedback.update.error', $res),
				                  array('c' => 'update', 'a' => 'index'));
			}
		}
	}

	/**
	 * This action displays information about installation.
	 */
	public function checkInstallAction() {
		Minz_View::prependTitle(_t('admin.check_install.title') . ' · ');

		$this->view->status_php = check_install_php();
		$this->view->status_files = check_install_files();
		$this->view->status_database = check_install_database();
	}
}
