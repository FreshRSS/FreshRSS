<?php

namespace Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Log permet de logger des erreurs
 */
class Log {
	/**
	 * Enregistre un message dans un fichier de log spécifique
	 * Message non loggué si
	 * 	- environment = SILENT
	 * 	- level = LOG_WARNING et environment = PRODUCTION
	 * 	- level = LOG_NOTICE et environment = PRODUCTION
	 * @param $information message d'erreur / information à enregistrer
	 * @param $level niveau d'erreur https://php.net/function.syslog
	 * @param $file_name fichier de log
	 * @throws PermissionDeniedException
	 */
	public static function record ($information, $level, $file_name = null) {
		try {
			$conf = Configuration::get('system');
			$env = $conf->environment;
		} catch (ConfigurationException $e) {
			$env = 'production';
		}

		if (! ($env === 'silent'
		       || ($env === 'production'
		       && ($level >= LOG_NOTICE)))) {
			if ($file_name === null) {
				$username = Session::param('currentUser', '');
				if ($username == '') {
					$username = '_';
				}
				$file_name = join_path(USERS_PATH, $username, 'log.txt');
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
				$level_label = 'unknown';
			}

			$log = '[' . date('r') . ']'
			     . ' [' . $level_label . ']'
			     . ' --- ' . $information . "\n";

			if (defined('COPY_LOG_TO_SYSLOG') && COPY_LOG_TO_SYSLOG) {
				syslog($level, '[' . $username . '] ' . $log);
			}

			self::ensureMaxLogSize($file_name);

			if (file_put_contents($file_name, $log, FILE_APPEND | LOCK_EX) === false) {
				throw new PermissionDeniedException($file_name, Minz_Exception::ERROR);
			}
		}
	}

	/**
	 * Make sure we do not waste a huge amount of disk space with old log messages.
	 *
	 * This method can be called multiple times for one script execution, but its result will not change unless
	 * you call clearstatcache() in between. We won't due do that for performance reasons.
	 *
	 * @param $file_name
	 * @throws PermissionDeniedException
	 */
	protected static function ensureMaxLogSize($file_name) {
		$maxSize = defined('MAX_LOG_SIZE') ? MAX_LOG_SIZE : 1048576;
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
				throw new PermissionDeniedException($file_name, Minz_Exception::ERROR);
			}
			if ($fp) {
				fclose($fp);
			}
		}
	}

	/**
	 * Automatise le log des variables globales $_GET et $_POST
	 * Fait appel à la fonction record(...)
	 * Ne fonctionne qu'en environnement "development"
	 * @param $file_name fichier de log
	 */
	public static function recordRequest($file_name = null) {
		$msg_get = str_replace("\n", '', '$_GET content : ' . print_r($_GET, true));
		$msg_post = str_replace("\n", '', '$_POST content : ' . print_r($_POST, true));

		self::record($msg_get, LOG_DEBUG, $file_name);
		self::record($msg_post, LOG_DEBUG, $file_name);
	}

	/**
	 * Some helpers to Log::record() method
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
