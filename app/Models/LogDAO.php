<?php

class FreshRSS_LogDAO {
	/**
	 * @return array<FreshRSS_Log>
	 */
	public static function lines(): array {
		$logs = [];
		$handle = @fopen(join_path(DATA_PATH, 'users', self::getCurrentUser(), LOG_FILENAME), 'rb');
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				if (preg_match('/^\[([^\[]+)\] \[([^\[]+)\] --- (.*)$/', $line, $matches)) {
					$myLog = new FreshRSS_Log();
					$myLog->_date($matches[1]);
					$myLog->_level($matches[2]);
					$myLog->_info($matches[3]);
					$logs[] = $myLog;
				}
			}
			fclose($handle);
		}
		return array_reverse($logs);
	}

	public static function truncate() : void {
		file_put_contents(join_path(DATA_PATH, 'users', self::getCurrentUser(), LOG_FILENAME), '');
		if (FreshRSS_Auth::hasAccess('admin')) {
			file_put_contents(ADMIN_LOG, '');
			file_put_contents(API_LOG, '');
			file_put_contents(PSHB_LOG, '');
		}
	}

	private static function getCurrentUser(): string {
		$sessionCurrentUser = '';
		if (is_string(Minz_Session::param('currentUser', '_'))) {
			$sessionCurrentUser = Minz_Session::param('currentUser', '_');
		}
		return $sessionCurrentUser;
	}
}
