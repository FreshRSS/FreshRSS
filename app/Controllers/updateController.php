<?php

class FreshRSS_update_Controller extends Minz_ActionController {
	public function firstAction() {
		$current_user = Minz_Session::param('currentUser', '');
		if (!$this->view->loginOk && Minz_Configuration::isAdmin($current_user)) {
			Minz_Error::error(
				403,
				array('error' => array(_t('access_denied')))
			);
		}

		invalidateHttpCache();

		Minz_View::prependTitle(_t('update_system') . ' · ');
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
		if (file_exists(UPDATE_FILENAME) && !is_writable(FRESHRSS_PATH)) {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('damn'),
				'body' => _t('file_is_nok', FRESHRSS_PATH)
			);
		} elseif (file_exists(UPDATE_FILENAME)) {
			// There is an update file to apply!
			$this->view->update_to_apply = true;
			$this->view->message = array(
				'status' => 'good',
				'title' => _t('ok'),
				'body' => _t('update_can_apply')
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
				'title' => _t('damn'),
				'body' => _t('update_server_not_found', FRESHRSS_UPDATE_WEBSITE)
			);
			return;
		}

		$res_array = explode("\n", $result, 2);
		$status = $res_array[0];
		if (strpos($status, 'UPDATE') !== 0) {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('damn'),
				'body' => _t('no_update')
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
				'title' => _t('damn'),
				'body' => _t('update_problem', 'Cannot save the update script')
			);
		}
	}

	public function applyAction() {
		if (!file_exists(UPDATE_FILENAME) || !is_writable(FRESHRSS_PATH)) {
			Minz_Request::forward(array('c' => 'update'), true);
		}

		require(UPDATE_FILENAME);

		if (Minz_Request::isPost()) {
			save_info_update();
		}

		if (!need_info_update()) {
			$res = apply_update();

			if ($res === true) {
				@unlink(UPDATE_FILENAME);
				@file_put_contents(DATA_PATH . '/last_update.txt', time());

				Minz_Request::good(_t('update_finished'));
			} else {
				Minz_Request::bad(_t('update_problem', $res),
				                  array('c' => 'update', 'a' => 'index'));
			}
		}
	}
}
