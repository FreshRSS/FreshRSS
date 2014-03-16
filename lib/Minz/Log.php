<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Log permet de logger des erreurs
 */
class Minz_Log {
	/**
	 * Les différents niveau de log
	 * ERROR erreurs bloquantes de l'application
	 * WARNING erreurs pouvant géner le bon fonctionnement, mais non bloquantes
	 * NOTICE erreurs mineures ou messages d'informations
	 * DEBUG Informations affichées pour le déboggage
	 */
	const ERROR = 2;
	const WARNING = 4;
	const NOTICE = 8;
	const DEBUG = 16;

	/**
	 * Enregistre un message dans un fichier de log spécifique
	 * Message non loggué si
	 * 	- environment = SILENT
	 * 	- level = WARNING et environment = PRODUCTION
	 * 	- level = NOTICE et environment = PRODUCTION
	 * @param $information message d'erreur / information à enregistrer
	 * @param $level niveau d'erreur
	 * @param $file_name fichier de log, par défaut LOG_PATH/application.log
	 */
	public static function record ($information, $level, $file_name = null) {
		$env = Minz_Configuration::environment ();

		if (! ($env === Minz_Configuration::SILENT
		       || ($env === Minz_Configuration::PRODUCTION
		       && ($level >= Minz_Log::NOTICE)))) {
			if ($file_name === null) {
				$file_name = LOG_PATH . '/' . Minz_Session::param('currentUser', '_') . '.log';
			}

			switch ($level) {
			case Minz_Log::ERROR :
				$level_label = 'error';
				break;
			case Minz_Log::WARNING :
				$level_label = 'warning';
				break;
			case Minz_Log::NOTICE :
				$level_label = 'notice';
				break;
			case Minz_Log::DEBUG :
				$level_label = 'debug';
				break;
			default :
				$level_label = 'unknown';
			}

			$log = '[' . date('r') . ']'
			     . ' [' . $level_label . ']'
			     . ' --- ' . $information . "\n";

			if (file_put_contents($file_name, $log, FILE_APPEND | LOCK_EX) === false) {
				throw new Minz_PermissionDeniedException($file_name, Minz_Exception::ERROR);
			}
		}
	}

	/**
	 * Automatise le log des variables globales $_GET et $_POST
	 * Fait appel à la fonction record(...)
	 * Ne fonctionne qu'en environnement "development"
	 * @param $file_name fichier de log, par défaut LOG_PATH/application.log
	 */
	public static function recordRequest($file_name = null) {
		$msg_get = str_replace("\n", '', '$_GET content : ' . print_r($_GET, true));
		$msg_post = str_replace("\n", '', '$_POST content : ' . print_r($_POST, true));

		self::record($msg_get, Minz_Log::DEBUG, $file_name);
		self::record($msg_post, Minz_Log::DEBUG, $file_name);
	}

	/**
	 * Some helpers to Minz_Log::record() method
	 * Parameters are the same of those of the record() method.
	 */
	public static function debug($msg, $file_name = null) {
		self::record($msg, Minz_Log::DEBUG, $file_name);
	}
	public static function notice($msg, $file_name = null) {
		self::record($msg, Minz_Log::NOTICE, $file_name);
	}
	public static function warning($msg, $file_name = null) {
		self::record($msg, Minz_Log::WARNING, $file_name);
	}
	public static function error($msg, $file_name = null) {
		self::record($msg, Minz_Log::ERROR, $file_name);
	}
}
