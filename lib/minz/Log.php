<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Log permet de logger des erreurs
 */
class Log {
	/**
	 * Les différents niveau de log
	 * ERROR erreurs bloquantes de l'application
	 * WARNING erreurs pouvant géner le bon fonctionnement, mais non bloquantes
	 * NOTICE messages d'informations, affichés pour le déboggage
	 */
	const ERROR = 0;
	const WARNING = 10;
	const NOTICE = 20;
	
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
		$env = Configuration::environment ();
		
		if (! ($env == Configuration::SILENT
		       || ($env == Configuration::PRODUCTION
		       && ($level == Log::WARNING || $level == Log::NOTICE)))) {
			if (is_null ($file_name)) {
				$file_name = LOG_PATH . '/application.log';
			}
			
			switch ($level) {
			case Log::ERROR :
				$level_label = 'error';
				break;
			case Log::WARNING :
				$level_label = 'warning';
				break;
			case Log::NOTICE :
				$level_label = 'notice';
				break;
			default :
				$level_label = 'unknown';
			}
			
			if ($env == Configuration::PRODUCTION) {
				$file = @fopen ($file_name, 'a');
			} else {
				$file = fopen ($file_name, 'a');
			}
			
			if ($file !== false) {
				$log = '[' . date('r') . ']';
				$log .= ' [' . $level_label . ']';
				$log .= ' --- ' . $information . "\n";
				fwrite ($file, $log); 
				fclose ($file);
			} else {
				Error::error (
					500,
					array ('error' => array (
						'Permission is denied for `'
						. $file_name . '`')
					)
				);
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

		self::record($msg_get, Log::NOTICE, $file_name);
		self::record($msg_post, Log::NOTICE, $file_name);
	}
}
