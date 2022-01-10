<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_Log class is used to log errors and warnings
 */
class Minz_Log {
	/**
	 * Enregistre un message dans un fichier de log spécifique
	 * Message non loggué si
	 * 	- environment = SILENT
	 * 	- level = LOG_WARNING et environment = PRODUCTION
	 * 	- level = LOG_NOTICE et environment = PRODUCTION
	 * @param string $information message d'erreur / information à enregistrer
	 * @param int $level niveau d'erreur https://php.net/function.syslog
	 * @param string $file_name fichier de log
	 * @throws Minz_PermissionDeniedException
	 */
	public static function record ($information, $level, $file_name = null) {
		$env = getenv('FRESHRSS_ENV');
		if ($env == '') {
			try {
				$conf = Minz_Configuration::get('system');
				$env = $conf->environment;
			} catch (Minz_ConfigurationException $e) {
				$env = 'production';
			}
		}

		if (! ($env === 'silent' || ($env === 'production' && ($level >= LOG_NOTICE)))) {
			$username = Minz_Session::param('currentUser', '');
			if ($username == '') {
				$username = '_';
			}
			if ($file_name == null) {
				$file_name = join_path(USERS_PATH, $username, 'log.txt');
			} else {
				$username = '_';
			}

			switch ($level) {
			case LOG_ERR :
				$level_label = 'error';
				break;
			case LOG_WARNING :
				$level_label = 'warning';
				break;
			case LOG_NOTICE :
				$level_label = 'notice';
				break;
			case LOG_DEBUG :
				$level_label = 'debug';
				break;
			default :
				$level = LOG_INFO;
				$level_label = 'info';
			}

			$log = '[' . date('r') . '] [' . $level_label . '] --- ' . $information . "\n";

			// @phpstan-ignore-next-line
			if (defined('COPY_LOG_TO_SYSLOG') && COPY_LOG_TO_SYSLOG) {
				syslog($level, '[' . $username . '] ' . trim($log));
			}

			self::ensureMaxLogSize($file_name);

			if (file_put_contents($file_name, $log, FILE_APPEND | LOCK_EX) === false) {
				throw new Minz_PermissionDeniedException($file_name, Minz_Exception::ERROR);
			}
		}
	}

	/**
	 * Make sure we do not waste a huge amount of disk space with old log messages.
	 *
	 * This method can be called multiple times for one script execution, but its result will not change unless
	 * you call clearstatcache() in between. We won't due do that for performance reasons.
	 *
	 * @param string $file_name
	 * @throws Minz_PermissionDeniedException
	 */
	protected static function ensureMaxLogSize($file_name) {
		$maxSize = defined('MAX_LOG_SIZE') ? MAX_LOG_SIZE : 1048576;
		// @phpstan-ignore-next-line
		if ($maxSize > 0 && @filesize($file_name) > $maxSize) {
			$fp = fopen($file_name, 'c+');
			if ($fp && flock($fp, LOCK_EX)) {
				fseek($fp, -intval($maxSize / 2), SEEK_END);
				$content = fread($fp, $maxSize);
				rewind($fp);
				ftruncate($fp, 0);
				fwrite($fp, $content ? $content : '');
				fwrite($fp, sprintf("[%s] [notice] --- Log rotate.\n", date('r')));
				fflush($fp);
				flock($fp, LOCK_UN);
			} else {
				throw new Minz_PermissionDeniedException($file_name, Minz_Exception::ERROR);
			}
			// @phpstan-ignore-next-line
			if ($fp) {
				fclose($fp);
			}
		}
	}

	/**
	 * Some helpers to Minz_Log::record() method
	 * Parameters are the same of those of the record() method.
	 */
	public static function debug($msg, $file_name = null) {
		self::record($msg, LOG_DEBUG, $file_name);
	}
	public static function notice($msg, $file_name = null) {
		self::record($msg, LOG_NOTICE, $file_name);
	}
	public static function warning($msg, $file_name = null) {
		self::record($msg, LOG_WARNING, $file_name);
	}
	public static function error($msg, $file_name = null) {
		self::record($msg, LOG_ERR, $file_name);
	}
}
