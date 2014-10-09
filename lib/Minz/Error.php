<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Error permet de lancer des erreurs HTTP
 */
class Minz_Error {
	public function __construct () { }

	/**
	* Permet de lancer une erreur
	* @param $code le type de l'erreur, par défaut 404 (page not found)
	* @param $logs logs d'erreurs découpés de la forme
	*      > $logs['error']
	*      > $logs['warning']
	*      > $logs['notice']
	* @param $redirect indique s'il faut forcer la redirection (les logs ne seront pas transmis)
	*/
	public static function error ($code = 404, $logs = array (), $redirect = false) {
		$logs = self::processLogs ($logs);
		$error_filename = APP_PATH . '/Controllers/errorController.php';

		switch ($code) {
			case 200 :
				header('HTTP/1.1 200 OK');
				break;
			case 403 :
				header('HTTP/1.1 403 Forbidden');
				break;
			case 404 :
				header('HTTP/1.1 404 Not Found');
				break;
			case 500 :
				header('HTTP/1.1 500 Internal Server Error');
				break;
			case 503 :
				header('HTTP/1.1 503 Service Unavailable');
				break;
			default :
				header('HTTP/1.1 500 Internal Server Error');
		}

		if (file_exists ($error_filename)) {
			$params = array (
				'code' => $code,
				'logs' => $logs
			);

			if ($redirect) {
				Minz_Request::forward (array (
					'c' => 'error'
				), true);
			} else {
				Minz_Request::forward (array (
					'c' => 'error',
					'params' => $params
				), false);
			}
		} else {
			echo '<h1>An error occured</h1>' . "\n";

			if (!empty ($logs)) {
				echo '<ul>' . "\n";
				foreach ($logs as $log) {
					echo '<li>' . $log . '</li>' . "\n";
				}
				echo '</ul>' . "\n";
			}

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
		$env = Minz_Configuration::environment ();
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

		if ($env == Minz_Configuration::PRODUCTION) {
			$logs_ok = $error;
		}
		if ($env == Minz_Configuration::DEVELOPMENT) {
			$logs_ok = array_merge ($error, $warning, $notice);
		}

		return $logs_ok;
	}
}
