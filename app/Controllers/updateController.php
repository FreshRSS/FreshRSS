<?php

class FreshRSS_update_Controller extends Minz_ActionController {

	public static function isGit() {
		return is_dir(FRESHRSS_PATH . '/.git/');
	}

	public static function hasGitUpdate() {
		$cwd = getcwd();
		chdir(FRESHRSS_PATH);
		$output = array();
		try {
			exec('git fetch --prune', $output, $return);
			if ($return == 0) {
				unset($output);
				exec('git status -sb --porcelain remote', $output, $return);
			} else {
				$line = is_array($output) ? implode('; ', $output) : $output;
				Minz_Log::warning('git fetch warning:' . $line);
			}
		} catch (Exception $e) {
			Minz_Log::warning('git fetch error:' . $e->getMessage());
		}
		chdir($cwd);
		$line = is_array($output) ? implode('; ', $output) : $output;
		return strpos($line, '[behind') !== false || strpos($line, '[ahead') !== false || strpos($line, '[gone') !== false;
	}

	public static function gitPull() {
		$cwd = getcwd();
		chdir(FRESHRSS_PATH);
		$output = [];
		$return = 1;
		try {
			exec('git fetch --prune', $output, $return);
			if ($return == 0) {
				unset($output);
				exec('git reset --hard FETCH_HEAD', $output, $return);
			}

			// Automatic change to the new name of edge branch since FreshRSS 1.18.0
			if ($return == 0) {
				unset($output);
				exec('git branch --show-current', $output, $return);
			}
			if ($return == 0) {
				$line = is_array($output) ? implode('', $output) : $output;
				if ($line === 'master' || $line === 'dev') {
					Minz_Log::warning('git automatic change to renamed edge branch');
					unset($output);
					exec('git checkout edge --guess -f', $output, $return);
					if ($return == 0) {
						unset($output);
						exec('git reset --hard FETCH_HEAD', $output, $return);
					}
					if ($return != 0) {
						Minz_Log::warning('git error while changing to renamed edge branch! Please change branch manually.');
					}
				}
			}
		} catch (Exception $e) {
			Minz_Log::warning('Git error:' . $e->getMessage());
			if ($output == '') {
				$output = $e->getMessage();
			}
			$return = 1;
		}
		chdir($cwd);
		$line = is_array($output) ? implode('; ', $output) : $output;
		return $return == 0 ? true : 'Git error: ' . $line;
	}

	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		include_once(LIB_PATH . '/lib_install.php');

		invalidateHttpCache();

		$this->view->update_to_apply = false;
		$this->view->last_update_time = 'unknown';
		$timestamp = @filemtime(join_path(DATA_PATH, 'last_update.txt'));
		if ($timestamp !== false) {
			$this->view->last_update_time = timestamptodate($timestamp);
		}
	}

	public function indexAction() {
		Minz_View::prependTitle(_t('admin.update.title') . ' · ');

		if (file_exists(UPDATE_FILENAME)) {
			// There is an update file to apply!
			$version = @file_get_contents(join_path(DATA_PATH, 'last_update.txt'));
			if ($version == '') {
				$version = 'unknown';
			}
			if (is_writable(FRESHRSS_PATH)) {
				$this->view->update_to_apply = true;
				$this->view->message = array(
					'status' => 'good',
					'title' => _t('gen.short.ok'),
					'body' => _t('feedback.update.can_apply', $version),
				);
			} else {
				$this->view->message = array(
					'status' => 'bad',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.file_is_nok', $version, FRESHRSS_PATH),
				);
			}
		}
	}

	public function checkAction() {
		$this->view->_path('update/index.phtml');

		if (file_exists(UPDATE_FILENAME)) {
			// There is already an update file to apply: we don't need to check
			// the webserver!
			// Or if already check during the last hour, do nothing.
			Minz_Request::forward(array('c' => 'update'), true);

			return;
		}

		$script = '';
		$version = '';

		if (self::isGit()) {
			if (self::hasGitUpdate()) {
				$version = 'git';
			} else {
				$this->view->message = array(
					'status' => 'latest',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.none')
				);
				@touch(join_path(DATA_PATH, 'last_update.txt'));
				return;
			}
		} else {
			$auto_update_url = FreshRSS_Context::$system_conf->auto_update_url . '?v=' . FRESHRSS_VERSION;
			Minz_Log::debug('HTTP GET ' . $auto_update_url);
			$c = curl_init($auto_update_url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 2);
			$result = curl_exec($c);
			$c_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
			$c_error = curl_error($c);
			curl_close($c);

			if ($c_status !== 200) {
				Minz_Log::warning(
					'Error during update (HTTP code ' . $c_status . '): ' . $c_error
				);

				$this->view->message = array(
					'status' => 'bad',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.server_not_found', $auto_update_url)
				);
				return;
			}

			$res_array = explode("\n", $result, 2);
			$status = $res_array[0];
			if (strpos($status, 'UPDATE') !== 0) {
				$this->view->message = array(
					'status' => 'latest',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.none')
				);
				@touch(join_path(DATA_PATH, 'last_update.txt'));
				return;
			}

			$script = $res_array[1];
			$version = explode(' ', $status, 2);
			$version = $version[1];
		}

		if (file_put_contents(UPDATE_FILENAME, $script) !== false) {
			@file_put_contents(join_path(DATA_PATH, 'last_update.txt'), $version);
			Minz_Request::forward(array('c' => 'update'), true);
		} else {
			$this->view->message = array(
				'status' => 'bad',
				'title' => _t('gen.short.damn'),
				'body' => _t('feedback.update.error', 'Cannot save the update script')
			);
		}
	}

	public function applyAction() {
		if (!file_exists(UPDATE_FILENAME) || !is_writable(FRESHRSS_PATH) || Minz_Configuration::get('system')->disable_update) {
			Minz_Request::forward(array('c' => 'update'), true);
		}

		if (Minz_Request::param('post_conf', false)) {
			if (self::isGit()) {
				$res = !self::hasGitUpdate();
			} else {
				require(UPDATE_FILENAME);
				$res = do_post_update();
			}

			Minz_ExtensionManager::callHook('post_update');

			if ($res === true) {
				@unlink(UPDATE_FILENAME);
				@file_put_contents(join_path(DATA_PATH, 'last_update.txt'), '');
				Minz_Request::good(_t('feedback.update.finished'));
			} else {
				Minz_Request::bad(_t('feedback.update.error', $res), [ 'c' => 'update', 'a' => 'index' ]);
			}
		} else {
			$res = false;

			if (self::isGit()) {
				$res = self::gitPull();
			} else {
				require(UPDATE_FILENAME);
				if (Minz_Request::isPost()) {
					save_info_update();
				}
				if (!need_info_update()) {
					$res = apply_update();
				} else {
					return;
				}
			}

			if ($res === true) {
				Minz_Request::forward(array(
					'c' => 'update',
					'a' => 'apply',
					'params' => array('post_conf' => true)
				), true);
			} else {
				Minz_Request::bad(_t('feedback.update.error', $res), [ 'c' => 'update', 'a' => 'index' ]);
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
