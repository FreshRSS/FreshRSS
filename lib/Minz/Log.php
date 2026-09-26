<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <https://www.gnu.org/licenses/>
*/

/**
 * The Minz_Log class is used to log errors and warnings
 */
class Minz_Log {
	/**
	 * Syslog priority corresponding to each value accepted by the `log_level` system setting,
	 * from the most to the least severe.
	 * @var array<string,int>
	 */
	private const LOG_LEVELS = [
		'error' => LOG_ERR,
		'warning' => LOG_WARNING,
		'notice' => LOG_NOTICE,
		'info' => LOG_INFO,
		'debug' => LOG_DEBUG,
	];

	/**
	 * Enregistre un message dans un fichier de log spécifique
	 * Message non loggué si
	 * 	- environment = SILENT
	 * 	- level est moins sévère que le seuil déterminé par `log_level`,
	 * 	  ou par défaut par `environment` (PRODUCTION ne garde que warning et error)
	 * @param string $information message d'erreur / information à enregistrer
	 * @param int $level niveau d'erreur https://www.php.net/function.syslog
	 * @param string $file_name fichier de log
	 * @throws Minz_PermissionDeniedException
	 */
	public static function record(string $information, int $level, ?string $file_name = null): void {
		// Prevent spam of empty log messages
		if (trim($information) === '') {
			return;
		}

		$env = getenv('FRESHRSS_ENV');
		$log_level = '';
		try {
			$conf = Minz_Configuration::get('system');
			$log_level = $conf->log_level;
			if ($env == '') {
				$env = $conf->environment;
			}
		} catch (Minz_ConfigurationException $e) {
			if ($env == '') {
				$env = 'production';
			}
		}
		if ($log_level === '' || !isset(self::LOG_LEVELS[$log_level])) {
			$log_level = match ($env) {
				'silent' => 'error',
				'production' => 'warning',
				default => 'debug',
			};
		}

		if (! ($env === 'silent' || $level > self::LOG_LEVELS[$log_level])) {
			$username = Minz_User::name() ?? Minz_User::INTERNAL_USER;
			if ($file_name == null) {
				$file_name = join_path(USERS_PATH, $username, LOG_FILENAME);
			}

			$level_labels = array_flip(self::LOG_LEVELS);
			if (!isset($level_labels[$level])) {
				$level = LOG_INFO;
			}
			$level_label = $level_labels[$level];

			$log = '[' . date('r') . '] [' . $level_label . '] --- ' . str_replace(["\r", "\n"], ' ', $information) . "\n";

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
	 * you call clearstatcache() in between. We won’t do do that for performance reasons.
	 *
	 * @throws Minz_PermissionDeniedException
	 */
	protected static function ensureMaxLogSize(string $file_name): void {
		$maxSize = defined('MAX_LOG_SIZE') ? MAX_LOG_SIZE : 1048576;
		if ($maxSize > 0 && @filesize($file_name) > $maxSize) {
			$fp = fopen($file_name, 'c+');
			if (is_resource($fp) && flock($fp, LOCK_EX)) {
				fseek($fp, -(int)($maxSize / 2), SEEK_END);
				$content = fread($fp, $maxSize);
				rewind($fp);
				ftruncate($fp, 0);
				fwrite($fp, $content ?: '');
				fwrite($fp, sprintf("[%s] [notice] --- Log rotate.\n", date('r')));
				fflush($fp);
				flock($fp, LOCK_UN);
			} else {
				throw new Minz_PermissionDeniedException($file_name, Minz_Exception::ERROR);
			}
			fclose($fp);
		}
	}

	/**
	 * Some helpers to Minz_Log::record() method
	 * Parameters are the same of those of the record() method.
	 * @throws Minz_PermissionDeniedException
	 */
	public static function debug(string $msg, ?string $file_name = null): void {
		self::record($msg, LOG_DEBUG, $file_name);
	}
	/** @throws Minz_PermissionDeniedException */
	public static function notice(string $msg, ?string $file_name = null): void {
		self::record($msg, LOG_NOTICE, $file_name);
	}
	/** @throws Minz_PermissionDeniedException */
	public static function warning(string $msg, ?string $file_name = null): void {
		self::record($msg, LOG_WARNING, $file_name);
	}
	/** @throws Minz_PermissionDeniedException */
	public static function error(string $msg, ?string $file_name = null): void {
		self::record($msg, LOG_ERR, $file_name);
	}
}
