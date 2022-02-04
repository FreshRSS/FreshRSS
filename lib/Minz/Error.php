<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_Error class logs and raises framework errors
 */
class Minz_Error {
	public function __construct () { }

	/**
	* Permet de lancer une erreur
	* @param int $code le type de l'erreur, par défaut 404 (page not found)
	* @param array<string>|array<string,array<string>> $logs logs d'erreurs découpés de la forme
	*      > $logs['error']
	*      > $logs['warning']
	*      > $logs['notice']
	* @param bool $redirect indique s'il faut forcer la redirection (les logs ne seront pas transmis)
	*/
	public static function error ($code = 404, $logs = array (), $redirect = true) {
		$logs = self::processLogs ($logs);
		$error_filename = APP_PATH . '/Controllers/errorController.php';

		if (file_exists ($error_filename)) {
			Minz_Session::_params([
				'error_code' => $code,
				'error_logs' => $logs,
			]);

			Minz_Request::forward (array (
				'c' => 'error'
			), $redirect);
		} else {
			echo '<h1>An error occurred</h1>' . "\n";

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
	 * Returns filtered logs
	 * @param array<string,string>|string $logs logs sorted by category (error, warning, notice)
	 * @return array<string> list of matching logs, without the category, according to environment preferences (production / development)
	 */
	private static function processLogs ($logs) {
		$conf = Minz_Configuration::get('system');
		$env = $conf->environment;
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

		if ($env == 'production') {
			$logs_ok = $error;
		}
		if ($env == 'development') {
			$logs_ok = array_merge ($error, $warning, $notice);
		}

		return $logs_ok;
	}
}
