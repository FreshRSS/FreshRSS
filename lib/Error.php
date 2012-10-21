<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Error permet de lancer des erreurs HTTP
 */
class Error {
	public function __construct () { }

	/**
	* Permet de lancer une erreur
	* @param $code le type de l'erreur, par défaut 404 (page not found)
	* @param $logs logs d'erreurs découpés de la forme
	*      > $logs['error']
	*      > $logs['warning']
	*      > $logs['notice']
	*/
	public static function error ($code = 404, $logs = array ()) {
		$logs = self::processLogs ($logs);
		$error_filename = APP_PATH . '/controllers/errorController.php';
		
		if (file_exists ($error_filename)) {
			$params = array (
				'code' => $code,
				'logs' => $logs
			);
			
			Response::setHeader ($code);
			Request::forward (array (
				'c' => 'error',
				'params' => $params
			));
		} else {
			$text = '<h1>An error occured</h1>'."\n";
			
			if (!empty ($logs)) {
				$text .= '<ul>'."\n";
				foreach ($logs as $log) {
					$text .= '<li>' . $log . '</li>'."\n";
				}
				$text .= '</ul>'."\n";
			}
			
			Response::setHeader ($code);
			Response::setBody ($text);
			Response::send ();
			exit ();
		}
	}
	
	/**
	 * Permet de retourner les logs de façon à n'avoir que
	 * ceux que l'on veut réellement
	 * @param $logs les logs rangés par catégories (error, warning, notice)
	 * @return la liste des logs, sans catégorie,
	 *       > en fonction de l'environment
	 */
	private static function processLogs ($logs) {
		$env = Configuration::environment ();
		$logs_ok = array ();
		$error = array ();
		$warning = array ();
		$notice = array ();
		
		if (isset ($logs['error'])) {
			$error = $logs['error'];
		}
		if (isset ($logs['warning'])) {
			$warning = $logs['warning'];
		}
		if (isset ($logs['notice'])) {
			$notice = $logs['notice'];
		}
		
		if ($env == Configuration::PRODUCTION) {
			$logs_ok = $error;
		}
		if ($env == Configuration::DEVELOPMENT) {
			$logs_ok = array_merge ($error, $warning, $notice);
		}
		
		return $logs_ok;
	}
}
