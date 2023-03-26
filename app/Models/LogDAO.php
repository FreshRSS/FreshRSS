<?php

class FreshRSS_LogDAO {

	private static function logPath(): string {
		return USERS_PATH . '/' . (Minz_User::name() ?? Minz_User::INTERNAL_USER) . '/' . LOG_FILENAME;
	}

	/** @return array<FreshRSS_Log> */
	public static function lines(): array {
		$logs = array();
		$handle = @fopen(self::logPath(), 'r');
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				if (preg_match('/^\[([^\[]+)\] \[([^\[]+)\] --- (.*)$/', $line, $matches)) {
					$myLog = new FreshRSS_Log ();
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

	public static function truncate(): void {
		file_put_contents(self::logPath(), '');
		if (FreshRSS_Auth::hasAccess('admin')) {
			file_put_contents(ADMIN_LOG, '');
			file_put_contents(API_LOG, '');
			file_put_contents(PSHB_LOG, '');
		}
	}
}
