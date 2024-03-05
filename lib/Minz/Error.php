<?php
declare(strict_types=1);

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_Error class logs and raises framework errors
 */
class Minz_Error {
	public function __construct() { }

	/**
	* Permet de lancer une erreur
	* @param int $code le type de l'erreur, par défaut 404 (page not found)
	* @param string|array<'error'|'warning'|'notice',array<string>> $logs logs d'erreurs découpés de la forme
	*      > $logs['error']
	*      > $logs['warning']
	*      > $logs['notice']
	* @param bool $redirect indique s'il faut forcer la redirection (les logs ne seront pas transmis)
	*/
	public static function error(int $code = 404, $logs = [], bool $redirect = true): void {
		$logs = self::processLogs($logs);
		$error_filename = APP_PATH . '/Controllers/errorController.php';

		if (file_exists($error_filename)) {
			Minz_Session::_params([
				'error_code' => $code,
				'error_logs' => $logs,
			]);

			Minz_Request::forward(['c' => 'error'], $redirect);
		} else {
			echo '<h1>An error occurred</h1>' . "\n";

			if (!empty($logs)) {
				echo '<ul>' . "\n";
				foreach ($logs as $log) {
					echo '<li>' . $log . '</li>' . "\n";
				}
				echo '</ul>' . "\n";
			}

			exit();
		}
	}

	/**
	 * Returns filtered logs
	 * @param string|array<'error'|'warning'|'notice',array<string>> $logs logs sorted by category (error, warning, notice)
	 * @return array<string> list of matching logs, without the category, according to environment preferences (production / development)
	 */
	private static function processLogs($logs): array {
		if (is_string($logs)) {
			return [$logs];
		}

		$error = [];
		$warning = [];
		$notice = [];

		if (isset($logs['error']) && is_array($logs['error'])) {
			$error = $logs['error'];
		}
		if (isset($logs['warning']) && is_array($logs['warning'])) {
			$warning = $logs['warning'];
		}
		if (isset($logs['notice']) && is_array($logs['notice'])) {
			$notice = $logs['notice'];
		}

		switch (Minz_Configuration::get('system')->environment) {
			case 'development':
				return array_merge($error, $warning, $notice);
			case 'production':
			default:
					return $error;
		}
	}
}
