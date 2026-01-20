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
	public function __construct() {}

	/**
	* Permet de lancer une erreur
	* @param int $code le type de l'erreur, par défaut 404 (page not found)
	* @param string|array<'error'|'warning'|'notice',list<string>> $logs logs d'erreurs découpés de la forme
	*      > $logs['error']
	*      > $logs['warning']
	*      > $logs['notice']
	* @param bool $redirect indique s'il faut forcer la redirection (les logs ne seront pas transmis)
	*/
	public static function error(int $code = 404, string|array $logs = [], bool $redirect = true): void {
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
	 * @param string|array<'error'|'warning'|'notice',list<string>> $logs logs sorted by category (error, warning, notice)
	 * @return list<string> list of matching logs, without the category, according to environment preferences (production / development)
	 */
	private static function processLogs(string|array $logs): array {
		if (is_string($logs)) {
			return [$logs];
		}

		$error = [];
		$warning = [];
		$notice = [];

		if (is_array($logs['error'] ?? null)) {
			$error = $logs['error'];
		}
		if (is_array($logs['warning'] ?? null)) {
			$warning = $logs['warning'];
		}
		if (is_array($logs['notice'] ?? null)) {
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
