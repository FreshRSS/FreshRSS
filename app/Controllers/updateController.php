<?php

define('UPDATE_FILE', DATA_PATH . '/latest-release.json');

class FreshRSS_update_Controller extends Minz_ActionController {

	public static function isGit() {
		return is_dir(FRESHRSS_PATH . '/.git/');
	}

	public static function isUpdateNeeded($newVersion) {
		if (substr_compare(FRESHRSS_VERSION, '-dev', -4) === 0) {
			return true;
		}
		return version_compare(FRESHRSS_VERSION, $newVersion, '<');
	}

	public static function hasGitUpdate(&$isGitOk) {
		$isGitOk = false;
		$cwd = getcwd();
		chdir(FRESHRSS_PATH);
		$output = array();
		try {
			exec('git fetch', $output, $return);
			if ($return == 0) {
				exec('git status -sb --porcelain remote', $output, $return);
				if ($return == 0) {
					$isGitOk = true;
				}
			} else {
				$line = is_array($output) ? implode('; ', $output) : '' . $output;
				Minz_Log::warning('git fetch warning:' . $line);
			}
		} catch (Exception $e) {
			Minz_Log::warning('git fetch error:' . $e->getMessage());
		}
		chdir($cwd);
		$line = is_array($output) ? implode('; ', $output) : '' . $output;
		return strpos($line, '[behind') !== false;
	}

	public static function gitPull() {
		$cwd = getcwd();
		chdir(FRESHRSS_PATH);
		$output = array();
		$return = 1;
		try {
			exec('git clean -f -d -f', $output, $return);
			if ($return == 0) {
				exec('git pull --ff-only', $output, $return);
			} else {
				$line = is_array($output) ? implode('; ', $output) : '' . $output;
				Minz_Log::warning('git clean warning:' . $line);
			}
		} catch (Exception $e) {
			Minz_Log::warning('git pull error:' . $e->getMessage());
		}
		chdir($cwd);
		$line = is_array($output) ? implode('; ', $output) : '' . $output;
		return $return == 0 ? true : 'Git error: ' . $line;
	}

	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		invalidateHttpCache();

		$this->view->update_to_apply = false;
		$timestamp = @filemtime(UPDATE_FILE);
		$this->view->last_update_time = $timestamp ? timestamptodate($timestamp) : 'unknown';
	}

	public function indexAction() {
		Minz_View::prependTitle(_t('admin.update.title') . ' · ');
		if (self::isGit()) {
			$version = 'git';
		} else {
			$updateInfo = @file_get_contents(UPDATE_FILE);
			$json = json_decode($updateInfo, true);
			$version = empty($json['tag_name']) ? '0' : $json['tag_name'];
		}
		$isGitOk = false;
		if (($version === 'git' && self::hasGitUpdate($isGitOk)) ||
			($version !== 'git' && self::isUpdateNeeded($version))) {
			if (($version !== 'git' || $isGitOk) && is_writable(FRESHRSS_PATH)) {
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
		$this->view->change_view('update', 'index');
		$version = '';

		if (self::isGit()) {
			$isGitOk = false;
			if (self::hasGitUpdate($isGitOk) && $isGitOk) {
				$version = 'git';
				Minz_Request::forward(array('c' => 'update'), true);
			} else {
				$this->view->message = array(
					'status' => 'latest',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.none')
				);
				@touch(UPDATE_FILE);
				return;
			}
		} else {
			$check_release_url = 'https://api.github.com/repos/FreshRSS/FreshRSS/releases/latest';
			Minz_Log::debug('HTTP GET ' . $check_release_url);
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $check_release_url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTPHEADER => array('Accept: application/json'),
				CURLOPT_USERAGENT => FRESHRSS_USERAGENT,
			));
			$result = curl_exec($ch);
			$c_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$c_error = curl_error($ch);
			curl_close($ch);

			if ($c_status !== 200) {
				Minz_Log::warning('Error during update (HTTP code ' . $c_status . '): ' . $c_error);
				$this->view->message = array(
					'status' => 'bad',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.server_not_found', $check_release_url)
				);
				return;
			}

			$json = json_decode($result, true);
			if ($json == null || empty($json['tag_name'])) {
				Minz_Log::warning('GitHub API error while retrieving the latest release');
				$this->view->message = array(
					'status' => 'bad',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.server_not_found', $check_release_url)
				);
				return;
			}
			$version = $json['tag_name'];

			if (!self::isUpdateNeeded($version)) {
				$this->view->message = array(
					'status' => 'latest',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.none')
				);
				@touch(UPDATE_FILE);
				return;
			}

			if (file_put_contents(UPDATE_FILE, $result)) {
				Minz_Request::forward(array('c' => 'update'), true);
			}
		}
	}

	public function applyAction() {
		if (!is_writable(FRESHRSS_PATH) || Minz_Configuration::get('system')->disable_update) {
			Minz_Request::forward(array('c' => 'update'), true);
		}

		if (function_exists('opcache_reset')) {
			opcache_reset();
		}
		require_once(APP_PATH . '/update/update_util.php');
		require_once(APP_PATH . '/update/update.php');

		$updateInfo = @file_get_contents(UPDATE_FILE);
		if ($updateInfo != '') {
			$json = json_decode($updateInfo, true);
			$zipUrl = empty($json['zipball_url']) ? '0' : $json['zipball_url'];
		}
		if ($zipUrl == '') {
			unlink(UPDATE_FILE);
			Minz_Request::bad(_t('feedback.update.error', $res), array('c' => 'update', 'a' => 'index'));
			return;
		}

		if (Minz_Request::param('post_conf', false)) {
			//File from the new version
			require_once(APP_PATH . '/update/post-update.php');

			if (self::isGit()) {
				$res = !self::hasGitUpdate();
			} else {
				$res = do_post_update();
			}

			Minz_ExtensionManager::callHook('post_update');

			if ($res === true) {
				@file_put_contents(UPDATE_FILE, '');
				Minz_Request::good(_t('feedback.update.finished'));
			} else {
				Minz_Request::bad(_t('feedback.update.error', $res),
				                  array('c' => 'update', 'a' => 'index'));
			}
		} else {
			$res = false;

			if (self::isGit()) {
				$res = self::gitPull();
			} else {
				if (Minz_Request::isPost()) {
					save_info_update();
				}
				if (!need_info_update()) {
					$res = apply_update($zipUrl);
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
