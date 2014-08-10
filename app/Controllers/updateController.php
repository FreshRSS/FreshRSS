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

		Minz_View::prependTitle(_t('update_system') . ' · ');
		$this->view->last_update_time = 'unknown';  // TODO
	}

	public function indexAction() {
		if (file_exists(UPDATE_FILENAME)) {
			// There is an update file to apply!
			$this->view->message = array(
				'status' => 'good',
				'title' => _t('ok'),
				'body' => _t('update_can_apply', _url('update', 'apply'))
			);

			return;
		}
	}

	public function checkAction() {
		$this->view->change_view('update', 'index');

		if (file_exists(UPDATE_FILENAME)) {
			// There is already an update file to apply: we don't need to check
			// the webserver!
			$this->view->message = array(
				'status' => 'good',
				'title' => _t('ok'),
				'body' => _t('update_can_apply', _url('update', 'apply'))
			);

			return;
		}

		$c = curl_init(FRESHRSS_UPDATE_WEBSITE);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($c);

		if (curl_getinfo($c, CURLINFO_HTTP_CODE) == 200) {
			$res_array = explode("\n", $result, 2);
			$status = $res_array[0];

			if (strpos($status, 'UPDATE') === 0) {
				$script = $res_array[1];
				if (file_put_contents(UPDATE_FILENAME, $script) !== false) {
					$this->view->message = array(
						'status' => 'good',
						'title' => _t('ok'),
						'body' => _t('update_can_apply', _url('update', 'apply'))
					);
				} else {
					$this->view->message = array(
						'status' => 'bad',
						'title' => _t('damn'),
						'body' => _t('update_problem', 'Cannot save the update script')
					);
				}
			} else {
				$this->view->message = array(
					'status' => 'bad',
					'title' => _t('damn'),
					'body' => _t('no_update')
				);
			}
		} else {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('damn'),
				'body' => _t('update_server_not_found', FRESHRSS_UPDATE_WEBSITE)
			);
		}

		curl_close($c);
	}

	public function applyAction() {
		if (!file_exists(UPDATE_FILENAME)) {
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

				// TODO: record last update

				Minz_Session::_param('notification', array(
					'type' => 'good',
					'content' => Minz_Translate::t('update_finished')
				));

				Minz_Request::forward(array(), true);
			} else {
				Minz_Session::_param('notification', array(
					'type' => 'bad',
					'content' => Minz_Translate::t('update_problem', $res)
				));

				Minz_Request::forward(array('c' => 'update'), true);
			}
		}
	}
}
