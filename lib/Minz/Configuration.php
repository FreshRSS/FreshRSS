<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Configuration permet de gérer la configuration de l'application
 */
class Minz_Configuration {
	const CONF_PATH_NAME = '/config.php';

	/**
	 * VERSION est la version actuelle de MINZ
	 */
	const VERSION = '1.3.1.freshrss';  // version spéciale FreshRSS

	/**
	 * valeurs possibles pour l'"environment"
	 * SILENT rend l'application muette (pas de log)
	 * PRODUCTION est recommandée pour une appli en production
	 *			(log les erreurs critiques)
	 * DEVELOPMENT log toutes les erreurs
	 */
	const SILENT = 0;
	const PRODUCTION = 1;
	const DEVELOPMENT = 2;

	/**
	 * définition des variables de configuration
	 * $salt une chaîne de caractères aléatoires (obligatoire)
	 * $environment gère le niveau d'affichage pour log et erreurs
	 * $base_url le chemin de base pour accéder à l'application
	 * $title le nom de l'application
	 * $language la langue par défaut de l'application
	 * $db paramètres pour la base de données (tableau)
	 *     - host le serveur de la base
	 *     - user nom d'utilisateur
	 *     - password mot de passe de l'utilisateur
	 *     - base le nom de la base de données
	 */
	private static $salt = '';
	private static $environment = Minz_Configuration::PRODUCTION;
	private static $base_url = '';
	private static $title = '';
	private static $language = 'en';
	private static $default_user = '';
	private static $allow_anonymous = false;
	private static $allow_anonymous_refresh = false;
	private static $auth_type = 'none';
	private static $api_enabled = false;
	private static $unsafe_autologin_enabled = false;

	private static $db = array (
		'type' => 'mysql',
		'host' => '',
		'user' => '',
		'password' => '',
		'base' => '',
		'prefix' => '',
	);

	/*
	 * Getteurs
	 */
	public static function salt () {
		return self::$salt;
	}
	public static function environment ($str = false) {
		$env = self::$environment;

		if ($str) {
			switch (self::$environment) {
			case self::SILENT:
				$env = 'silent';
				break;
			case self::DEVELOPMENT:
				$env = 'development';
				break;
			case self::PRODUCTION:
			default:
				$env = 'production';
			}
		}

		return $env;
	}
	public static function baseUrl () {
		return self::$base_url;
	}
	public static function title () {
		return self::$title;
	}
	public static function language () {
		return self::$language;
	}
	public static function dataBase () {
		return self::$db;
	}
	public static function defaultUser () {
		return self::$default_user;
	}
	public static function isAdmin($currentUser) {
		return $currentUser === self::$default_user;
	}
	public static function allowAnonymous() {
		return self::$allow_anonymous;
	}
	public static function allowAnonymousRefresh() {
		return self::$allow_anonymous_refresh;
	}
	public static function authType() {
		return self::$auth_type;
	}
	public static function needsLogin() {
		return self::$auth_type !== 'none';
	}
	public static function canLogIn() {
		return self::$auth_type === 'form' || self::$auth_type === 'persona';
	}
	public static function apiEnabled() {
		return self::$api_enabled;
	}
	public static function unsafeAutologinEnabled() {
		return self::$unsafe_autologin_enabled;
	}

	public static function _allowAnonymous($allow = false) {
		self::$allow_anonymous = ((bool)$allow) && self::canLogIn();
	}
	public static function _allowAnonymousRefresh($allow = false) {
		self::$allow_anonymous_refresh = ((bool)$allow) && self::allowAnonymous();
	}
	public static function _authType($value) {
		$value = strtolower($value);
		switch ($value) {
			case 'form':
			case 'http_auth':
			case 'persona':
			case 'none':
				self::$auth_type = $value;
				break;
		}
		self::_allowAnonymous(self::$allow_anonymous);
	}

	public static function _enableApi($value = false) {
		self::$api_enabled = (bool)$value;
	}
	public static function _enableAutologin($value = false) {
		self::$unsafe_autologin_enabled = (bool)$value;
	}

	/**
	 * Initialise les variables de configuration
	 * @exception Minz_FileNotExistException si le CONF_PATH_NAME n'existe pas
	 * @exception Minz_BadConfigurationException si CONF_PATH_NAME mal formaté
	 */
	public static function init () {
		try {
			self::parseFile ();
			self::setReporting ();
		} catch (Minz_FileNotExistException $e) {
			throw $e;
		} catch (Minz_BadConfigurationException $e) {
			throw $e;
		}
	}

	public static function writeFile() {
		$ini_array = array(
			'general' => array(
				'environment' => self::environment(true),
				'salt' => self::$salt,
				'base_url' => self::$base_url,
				'title' => self::$title,
				'default_user' => self::$default_user,
				'allow_anonymous' => self::$allow_anonymous,
				'allow_anonymous_refresh' => self::$allow_anonymous_refresh,
				'auth_type' => self::$auth_type,
				'api_enabled' => self::$api_enabled,
				'unsafe_autologin_enabled' => self::$unsafe_autologin_enabled,
			),
			'db' => self::$db,
		);
		@rename(DATA_PATH . self::CONF_PATH_NAME, DATA_PATH . self::CONF_PATH_NAME . '.bak.php');
		$result = file_put_contents(DATA_PATH . self::CONF_PATH_NAME, "<?php\n return " . var_export($ini_array, true) . ';');
		if (function_exists('opcache_invalidate')) {
			opcache_invalidate(DATA_PATH . self::CONF_PATH_NAME);	//Clear PHP 5.5+ cache for include
		}
		return (bool)$result;
	}

	/**
	 * Parse un fichier de configuration
	 * @exception Minz_PermissionDeniedException si le CONF_PATH_NAME n'est pas accessible
	 * @exception Minz_BadConfigurationException si CONF_PATH_NAME mal formaté
	 */
	private static function parseFile () {
		$ini_array = include(DATA_PATH . self::CONF_PATH_NAME);

		if (!is_array($ini_array)) {
			throw new Minz_PermissionDeniedException (
				DATA_PATH . self::CONF_PATH_NAME,
				Minz_Exception::ERROR
			);
		}

		// [general] est obligatoire
		if (!isset ($ini_array['general'])) {
			throw new Minz_BadConfigurationException (
				'[general]',
				Minz_Exception::ERROR
			);
		}
		$general = $ini_array['general'];

		// salt est obligatoire
		if (!isset ($general['salt'])) {
			if (isset($general['sel_application'])) {	//v0.6
				$general['salt'] = $general['sel_application'];
			} else {
				throw new Minz_BadConfigurationException (
					'salt',
					Minz_Exception::ERROR
				);
			}
		}
		self::$salt = $general['salt'];

		if (isset ($general['environment'])) {
			switch ($general['environment']) {
			case 'silent':
				self::$environment = Minz_Configuration::SILENT;
				break;
			case 'development':
				self::$environment = Minz_Configuration::DEVELOPMENT;
				break;
			case 'production':
				self::$environment = Minz_Configuration::PRODUCTION;
				break;
			default:
				if ($general['environment'] >= 0 &&
					$general['environment'] <= 2) {
					// fallback 0.7-beta
					self::$environment = $general['environment'];
				} else {
					throw new Minz_BadConfigurationException (
						'environment',
						Minz_Exception::ERROR
					);
				}
			}

		}
		if (isset ($general['base_url'])) {
			self::$base_url = $general['base_url'];
		}

		if (isset ($general['title'])) {
			self::$title = $general['title'];
		}
		if (isset ($general['language'])) {
			self::$language = $general['language'];
		}
		if (isset ($general['default_user'])) {
			self::$default_user = $general['default_user'];
		}
		if (isset ($general['auth_type'])) {
			self::_authType($general['auth_type']);
		}
		if (isset ($general['allow_anonymous'])) {
			self::$allow_anonymous = (
				((bool)($general['allow_anonymous'])) &&
				($general['allow_anonymous'] !== 'no')
			);
		}
		if (isset ($general['allow_anonymous_refresh'])) {
			self::$allow_anonymous_refresh = (
				((bool)($general['allow_anonymous_refresh'])) &&
				($general['allow_anonymous_refresh'] !== 'no')
			);
		}
		if (isset ($general['api_enabled'])) {
			self::$api_enabled = (
				((bool)($general['api_enabled'])) &&
				($general['api_enabled'] !== 'no')
			);
		}
		if (isset ($general['unsafe_autologin_enabled'])) {
			self::$unsafe_autologin_enabled = (
				((bool)($general['unsafe_autologin_enabled'])) &&
				($general['unsafe_autologin_enabled'] !== 'no')
			);
		}

		// Base de données
		if (isset ($ini_array['db'])) {
			$db = $ini_array['db'];
			if (empty($db['type'])) {
				throw new Minz_BadConfigurationException (
					'type',
					Minz_Exception::ERROR
				);
			}
			switch ($db['type']) {
				case 'mysql':
					if (empty($db['host'])) {
						throw new Minz_BadConfigurationException (
							'host',
							Minz_Exception::ERROR
						);
					}
					if (empty($db['user'])) {
						throw new Minz_BadConfigurationException (
							'user',
							Minz_Exception::ERROR
						);
					}
					if (!isset($db['password'])) {
						throw new Minz_BadConfigurationException (
							'password',
							Minz_Exception::ERROR
						);
					}
					if (empty($db['base'])) {
						throw new Minz_BadConfigurationException (
							'base',
							Minz_Exception::ERROR
						);
					}
					self::$db['host'] = $db['host'];
					self::$db['user'] = $db['user'];
					self::$db['password'] = $db['password'];
					self::$db['base'] = $db['base'];
					if (isset($db['prefix'])) {
						self::$db['prefix'] = $db['prefix'];
					}
					break;
				case 'sqlite':
					self::$db['host'] = '';
					self::$db['user'] = '';
					self::$db['password'] = '';
					self::$db['base'] = '';
					self::$db['prefix'] = '';
					break;
				default:
					throw new Minz_BadConfigurationException (
						'type',
						Minz_Exception::ERROR
					);
					break;
			}
			self::$db['type'] = $db['type'];
		}
	}

	private static function setReporting() {
		switch (self::$environment) {
			case self::PRODUCTION:
				error_reporting(E_ALL);
				ini_set('display_errors','Off');
				ini_set('log_errors', 'On');
				break;
			case self::DEVELOPMENT:
				error_reporting(E_ALL);
				ini_set('display_errors','On');
				ini_set('log_errors', 'On');
				break;
			case self::SILENT:
				error_reporting(0);
				break;
		}
	}
}
