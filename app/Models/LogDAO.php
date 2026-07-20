<?php
declare(strict_types=1);

final class FreshRSS_LogDAO {
	public static function logPath(?string $logFileName = null): string {
		if ($logFileName === null || $logFileName === '') {
			$logFileName = LOG_FILENAME;
		}
		return USERS_PATH . '/' . (Minz_User::name() ?? Minz_User::INTERNAL_USER) . '/' . $logFileName;
	}

	/** @return list<FreshRSS_Log> */
	public static function lines(?string $logFileName = null): array {
		$logs = [];
		$handle = @fopen(self::logPath($logFileName), 'r');
		if (is_resource($handle)) {
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

	public static function truncate(?string $logFileName = null): void {
		file_put_contents(self::logPath($logFileName), '');
		if (FreshRSS_Auth::hasAccess('admin')) {
			file_put_contents(ADMIN_LOG, '');
			file_put_contents(API_LOG, '');
			file_put_contents(PSHB_LOG, '');
		}
	}
}
