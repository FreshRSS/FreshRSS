<?php
declare(strict_types=1);

class FreshRSS_update_Controller extends FreshRSS_ActionController {

	private const LASTUPDATEFILE = 'last_update.txt';
	private const GITHUB_LATEST_RELEASE_URL = 'https://api.github.com/repos/FreshRSS/FreshRSS/releases/latest';

	public static function isGit(): bool {
		return is_dir(FRESHRSS_PATH . '/.git/');
	}

	/**
	 * Automatic change to the new name of edge branch since FreshRSS 1.18.0,
	 * and perform checks for several git errors.
	 * @throws Minz_Exception
	 */
	public static function migrateToGitEdge(): bool {
		if (!is_writable(FRESHRSS_PATH . '/.git/config')) {
			throw new Minz_Exception('Error during git checkout: .git directory does not seem writable! ' .
				'Please git pull manually!');
		}

		if (!function_exists('exec')) {
			throw new Minz_Exception('Error during git checkout: exec() function is disabled! ' .
				'Please git pull manually!');
		}

		exec('git --version', $output, $return);
		if ($return != 0) {
			throw new Minz_Exception("Error {$return} git not found: Please update manually!");
		}

		//Note `git branch --show-current` requires git 2.22+
		exec('git symbolic-ref --short HEAD 2>&1', $output, $return);
		if ($return != 0) {
			throw new Minz_Exception("Error {$return} during git symbolic-ref: " .
				'Reapply `chown www-data:www-data -R ' . FRESHRSS_PATH . '` ' .
				'or git pull manually! ' .
				json_encode($output, JSON_UNESCAPED_SLASHES));
		}
		$line = implode('', $output);
		if ($line !== 'master' && $line !== 'dev') {
			return true;	// not on master or dev, nothing to do
		}

		Minz_Log::warning('Automatic migration to git edge branch');
		unset($output);
		exec('git checkout edge --guess -f', $output, $return);
		if ($return != 0) {
			throw new Minz_Exception("Error {$return} during git checkout to edge branch! ' .
				'Please change branch manually!");
		}

		unset($output);
		exec('git reset --hard FETCH_HEAD', $output, $return);
		if ($return != 0) {
			throw new Minz_Exception("Error {$return} during git reset! Please git pull manually!");
		}

		return true;
	}

	public static function getCurrentGitBranch(): string {
		$output = [];
		exec('git branch --show-current', $output, $return);
		if ($return === 0) {
			return 'git branch: ' . $output[0];
		} else {
			return 'git';
		}
	}

	public static function hasGitUpdate(): bool {
		$cwd = getcwd();
		if ($cwd === false) {
			Minz_Log::warning('getcwd() failed');
			return false;
		}
		chdir(FRESHRSS_PATH);
		$output = [];
		try {
			/** @throws ValueError */
			exec('git fetch --prune', $output, $return);
			if ($return == 0) {
				$output = [];
				exec('git status -sb --porcelain remote', $output, $return);
			} else {
				$line = implode('; ', $output);
				Minz_Log::warning('git fetch warning: ' . $line);
			}
		} catch (Throwable $e) {
			Minz_Log::warning('git fetch error: ' . $e->getMessage());
		}
		chdir($cwd);
		$line = implode('; ', $output);
		return $line == '' ||
			str_contains($line, '[behind') || str_contains($line, '[ahead') || str_contains($line, '[gone');
	}

	/** @return string|true */
	public static function gitPull(): string|bool {
		Minz_Log::notice(_t('admin.update.viaGit'));
		$cwd = getcwd();
		if ($cwd === false) {
			Minz_Log::warning('getcwd() failed');
			return 'getcwd() failed';
		}
		chdir(FRESHRSS_PATH);
		$output = [];
		$return = 1;
		try {
			exec('git fetch --prune', $output, $return);
			if ($return == 0) {
				$output = [];
				exec('git reset --hard FETCH_HEAD', $output, $return);
			}

			$output = [];
			self::migrateToGitEdge();
		} catch (Throwable $e) {
			Minz_Log::warning('Git error: ' . $e->getMessage());
			$output = $e->getMessage();
			$return = 1;
		}
		chdir($cwd);
		$line = is_array($output) ? implode('; ', $output) : $output;
		return $return == 0 ? true : 'Git error: ' . $line;
	}

	#[\Override]
	public function firstAction(): void {
		if (!FreshRSS_Auth::hasAccess('admin')) {
			Minz_Error::error(403);
		}

		if (FreshRSS_Auth::requestReauth()) {
			return;
		}

		include_once LIB_PATH . '/lib_install.php';

		invalidateHttpCache();

		$this->view->is_release_channel_stable = $this->is_release_channel_stable(FRESHRSS_VERSION);

		$this->view->update_to_apply = false;
		$this->view->last_update_time = 'unknown';
		$timestamp = @filemtime(join_path(DATA_PATH, self::LASTUPDATEFILE));
		if ($timestamp !== false) {
			$this->view->last_update_time = timestamptodate($timestamp);
		}
	}

	public function indexAction(): void {
		FreshRSS_View::prependTitle(_t('admin.update.title') . ' · ');

		$version = trim((string)@file_get_contents(join_path(DATA_PATH, self::LASTUPDATEFILE)));
		if ($version !== '' && self::isUpdateNeeded($version)) {
			// There is an update to apply!
			if (@touch(FRESHRSS_PATH . '/index.html')) {
				$this->view->update_to_apply = true;
				$this->view->message = [
					'status' => 'good',
					'title' => _t('gen.short.ok'),
					'body' => _t('feedback.update.can_apply', $version),
				];
			} else {
				$this->view->message = [
					'status' => 'bad',
					'title' => _t('gen.short.damn'),
					'body' => _t('feedback.update.file_is_nok', $version, FRESHRSS_PATH),
				];
			}
		}
	}

	private function is_release_channel_stable(string $currentVersion): bool {
		return !str_contains($currentVersion, 'dev') && !str_contains($currentVersion, 'edge');
	}

	/**
	 * Check whether the provided version is newer than the current one.
	 * Note that dev and edge versions are always considered to be replaced by any stable release.
	 */
	public static function isUpdateNeeded(string $nextVersion): bool {
		$versionRegex = '/^[A-Za-z0-9._-]+$/u';
		if (!preg_match($versionRegex, $nextVersion)) {
			// Only accept a version string similar to a git tag, to avoid risky content.
			return false;
		}
		if (str_ends_with(FRESHRSS_VERSION, '-dev')) {
			// A development version should be replaced by any stable release.
			return true;
		}
		return version_compare(FRESHRSS_VERSION, $nextVersion, '<');
	}

	/**
	 * Check whether there is a version currently available newer than the current one,
	 * according to the default update channel of GitHub.
	 * Via Git, if available. Else via GitHub Releases.
	 */
	public function checkAction(): void {
		if (!Minz_Request::isPost()) {
			Minz_Request::forward(['c' => 'update', 'a' => 'index'], true);
			return;
		}

		FreshRSS_View::prependTitle(_t('admin.update.title') . ' · ');
		$this->view->_path('update/index.phtml');

		$version = trim((string)@file_get_contents(join_path(DATA_PATH, self::LASTUPDATEFILE)));
		if ($version !== '') {
			// There is already an update to apply: we don't need to check
			// the webserver!
			Minz_Request::forward(['c' => 'update'], true);

			return;
		}

		$version = '';

		if (self::isGit()) {
			if (self::hasGitUpdate()) {
				$version = self::getCurrentGitBranch();
			} else {
				$this->view->message = [
					'status' => 'latest',
					'body' => _t('feedback.update.none'),
				];
				@touch(join_path(DATA_PATH, self::LASTUPDATEFILE));
				return;
			}
		} else {
			$latestReleaseUrl = self::GITHUB_LATEST_RELEASE_URL;
			$cacheFile = CACHE_PATH . '/latest_release.json';
			$fetchResult = null;
			if (!file_exists($cacheFile) || (time() - (filemtime($cacheFile) ?: 0) > 86400)) {
				$fetchResult = FreshRSS_http_Util::httpGet($latestReleaseUrl, $cacheFile, 'json');
				$json = $fetchResult['body'];
			} else {
				$json = @file_get_contents($cacheFile) ?: '';
			}

			/** @var array<string,mixed>|null $latestRelease */
			$latestRelease = json_decode($json, true);
			if (!is_array($latestRelease) || !is_string($latestRelease['tag_name'] ?? null) ||
				$latestRelease['tag_name'] === '') {
				$details = '';
				if (is_array($fetchResult)) {
					$details = ' (HTTP status ' . $fetchResult['status'] .
						($fetchResult['error'] !== '' ? '; ' . $fetchResult['error'] : '') . ')';
				}
				Minz_Log::error('Could not fetch the latest release from GitHub (' . $latestReleaseUrl . ')' . $details);
				$this->view->message = [
					'status' => 'bad',
					'body' => _t('feedback.update.server_not_found', $latestReleaseUrl),
				];
				return;
			}

			$tag = $latestRelease['tag_name'];
			if (!self::isUpdateNeeded($tag)) {
				$this->view->message = [
					'status' => 'latest',
					'body' => _t('feedback.update.none'),
				];
				@touch(join_path(DATA_PATH, self::LASTUPDATEFILE));
				return;
			}

			$version = $tag;
		}

		@file_put_contents(join_path(DATA_PATH, self::LASTUPDATEFILE), $version);
		Minz_Request::forward(['c' => 'update'], true);
	}

	public function applyAction(): void {
		$version = trim((string)@file_get_contents(join_path(DATA_PATH, self::LASTUPDATEFILE)));
		if (FreshRSS_Context::systemConf()->disable_update || $version === '' || !self::isUpdateNeeded($version) ||
			!touch(FRESHRSS_PATH . '/index.html')) {
			Minz_Request::forward(['c' => 'update'], true);
		}

		if (Minz_Request::paramBoolean('post_conf')) {
			if (!Minz_Session::paramBoolean('update_post_conf_ok')) {
				Minz_Request::forward(['c' => 'update', 'a' => 'index'], true);
				return;
			}
			Minz_Session::_param('update_post_conf_ok', false);

			if (self::isGit()) {
				$res = !self::hasGitUpdate();
			} else {
				require APP_PATH . '/update/post-update.php';
				$res = do_post_update();
			}

			Minz_ExtensionManager::callHookVoid(Minz_HookType::PostUpdate);

			if ($res === true) {
				@file_put_contents(join_path(DATA_PATH, self::LASTUPDATEFILE), '');
				Minz_Log::notice(_t('feedback.update.finished'));
				Minz_Request::good(
					_t('feedback.update.finished'),
					showNotification: FreshRSS_Context::userConf()->good_notification_timeout > 0
				);
			} else {
				Minz_Log::error(_t('feedback.update.error', 'unknown'));
				Minz_Request::bad(_t('feedback.update.error', 'unknown'), [ 'c' => 'update', 'a' => 'index' ]);
			}
		} else {
			if (!Minz_Request::isPost()) {
				Minz_Request::forward(['c' => 'update', 'a' => 'index'], true);
				return;
			}

			$res = false;

			if (self::isGit()) {
				$res = self::gitPull();
			} else {
				require_once APP_PATH . '/update/update_util.php';
				require_once APP_PATH . '/update/update.php';
				// The version is a valid git tag name, previously saved by the check action.
				$res = apply_update('https://github.com/FreshRSS/FreshRSS/archive/refs/tags/' . $version . '.zip');
			}

			if (function_exists('opcache_reset')) {
				opcache_reset();
			}

			if ($res === true) {
				// Authorise the single internal post-configuration redirect that follows.
				Minz_Session::_param('update_post_conf_ok', true);
				Minz_Request::forward([
					'c' => 'update',
					'a' => 'apply',
					'params' => ['post_conf' => '1'],
					], true);
			} else {
				Minz_Log::error(_t('feedback.update.error', $res));
				Minz_Request::bad(_t('feedback.update.error', $res), [ 'c' => 'update', 'a' => 'index' ]);
			}
		}
	}

	/**
	 * Check PHP and its extensions are well-installed.
	 *
	 * @return array<string,'ok'|'ko'|'warn'> of tested values.
	 */
	private static function check_install_php(): array {
		require_once LIB_PATH . '/lib_install.php';
		return checkRequirements(FreshRSS_Context::systemConf()->db['type'] ?? '', checkPhp: true, checkFiles: false);
	}

	/**
	 * Check different data files and directories exist.
	 * @return array<string,'ok'|'ko'|'warn'> of tested values.
	 */
	private static function check_install_files(): array {
		require_once LIB_PATH . '/lib_install.php';
		return checkRequirements(FreshRSS_Context::systemConf()->db['type'] ?? '', checkPhp: false, checkFiles: true);
	}

	/**
	 * Check database is well-installed.
	 *
	 * @return array<string,array<string,bool>|bool> of tested values.
	 */
	private static function check_install_database(): array {
		$status = [
			'connection' => true,
			'tables' => false,
			'table' => [
				'categories' => false,
				'feeds' => false,
				'entries' => false,
				'entrytmp' => false,
				'tag' => false,
				'entrytag' => false,
			],
		];

		try {
			$dbDAO = FreshRSS_Factory::createDatabaseDAO();

			$status['tables'] = $dbDAO->tablesAreCorrect();
			$status['table']['categories'] = $dbDAO->categoryIsCorrect();
			$status['table']['feeds'] = $dbDAO->feedIsCorrect();
			$status['table']['entries'] = $dbDAO->entryIsCorrect();
			$status['table']['entrytmp'] = $dbDAO->entrytmpIsCorrect();
			$status['table']['tag'] = $dbDAO->tagIsCorrect();
			$status['table']['entrytag'] = $dbDAO->entrytagIsCorrect();
		} catch (Minz_PDOConnectionException $e) {
			$status['connection'] = false;
		}

		return $status;
	}

	/**
	 * This action displays information about installation.
	 */
	public function checkInstallAction(): void {
		FreshRSS_View::prependTitle(_t('install.check._') . ' · ');

		$this->view->status_php = self::check_install_php();
		$this->view->status_files = self::check_install_files();
		$this->view->status_database = self::check_install_database();
	}
}
