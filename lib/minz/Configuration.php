<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Configuration permet de gérer la configuration de l'application
 */
class Configuration {
	const CONF_PATH_NAME = '/application.ini';

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
	 * $sel_application une chaîne de caractères aléatoires (obligatoire)
	 * $environment gère le niveau d'affichage pour log et erreurs
	 * $use_url_rewriting indique si on utilise l'url_rewriting
	 * $base_url le chemin de base pour accéder à l'application
	 * $title le nom de l'application
	 * $language la langue par défaut de l'application
	 * $cacheEnabled permet de savoir si le cache doit être activé
	 * $delayCache la limite de cache
	 * $db paramètres pour la base de données (tableau)
	 *     - host le serveur de la base
	 *     - user nom d'utilisateur
	 *     - password mot de passe de l'utilisateur
	 *     - base le nom de la base de données
	 */
	private static $sel_application = '';
	private static $environment = Configuration::PRODUCTION;
	private static $base_url = '';
	private static $use_url_rewriting = false;
	private static $title = '';
	private static $language = 'en';
	private static $cache_enabled = false;
	private static $delay_cache = 3600;
	private static $default_user = '';
	private static $current_user = '';

	private static $db = array (
		'host' => false,
		'user' => false,
		'password' => false,
		'base' => false
	);

	/*
	 * Getteurs
	 */
	public static function selApplication () {
		return self::$sel_application;
	}
	public static function environment () {
		return self::$environment;
	}
	public static function baseUrl () {
		return self::$base_url;
	}
	public static function useUrlRewriting () {
		return self::$use_url_rewriting;
	}
	public static function title () {
		return stripslashes(self::$title);
	}
	public static function language () {
		return self::$language;
	}
	public static function cacheEnabled () {
		return self::$cache_enabled;
	}
	public static function delayCache () {
		return self::$delay_cache;
	}
	public static function dataBase () {
		return self::$db;
	}
	public static function defaultUser () {
		return self::$default_user;
	}
	public static function currentUser () {
		return self::$current_user;
	}

	/**
	 * Initialise les variables de configuration
	 * @exception FileNotExistException si le CONF_PATH_NAME n'existe pas
	 * @exception BadConfigurationException si CONF_PATH_NAME mal formaté
	 */
	public static function init () {
		try {
			self::parseFile ();
			self::setReporting ();
		} catch (FileNotExistException $e) {
			throw $e;
		} catch (BadConfigurationException $e) {
			throw $e;
		}
	}

	/**
	 * Parse un fichier de configuration de type ".ini"
	 * @exception FileNotExistException si le CONF_PATH_NAME n'existe pas
	 * @exception BadConfigurationException si CONF_PATH_NAME mal formaté
	 */
	private static function parseFile () {
		if (!file_exists (DATA_PATH . self::CONF_PATH_NAME)) {
			throw new FileNotExistException (
				DATA_PATH . self::CONF_PATH_NAME,
				MinzException::ERROR
			);
		}

		$ini_array = parse_ini_file (
			DATA_PATH . self::CONF_PATH_NAME,
			true
		);

		if (!$ini_array) {
			throw new PermissionDeniedException (
				DATA_PATH . self::CONF_PATH_NAME,
				MinzException::ERROR
			);
		}

		// [general] est obligatoire
		if (!isset ($ini_array['general'])) {
			throw new BadConfigurationException (
				'[general]',
				MinzException::ERROR
			);
		}
		$general = $ini_array['general'];


		// sel_application est obligatoire
		if (!isset ($general['sel_application'])) {
			throw new BadConfigurationException (
				'sel_application',
				MinzException::ERROR
			);
		}
		self::$sel_application = $general['sel_application'];

		if (isset ($general['environment'])) {
			switch ($general['environment']) {
			case 'silent':
				self::$environment = Configuration::SILENT;
				break;
			case 'development':
				self::$environment = Configuration::DEVELOPMENT;
				break;
			case 'production':
				self::$environment = Configuration::PRODUCTION;
				break;
			default:
				throw new BadConfigurationException (
					'environment',
					MinzException::ERROR
				);
			}

		}
		if (isset ($general['base_url'])) {
			self::$base_url = $general['base_url'];
		}
		if (isset ($general['use_url_rewriting'])) {
			self::$use_url_rewriting = $general['use_url_rewriting'];
		}

		if (isset ($general['title'])) {
			self::$title = $general['title'];
		}
		if (isset ($general['language'])) {
			self::$language = $general['language'];
		}
		if (isset ($general['cache_enabled'])) {
			self::$cache_enabled = $general['cache_enabled'];
			if (CACHE_PATH === false && self::$cache_enabled) {
				throw new FileNotExistException (
					'CACHE_PATH',
					MinzException::ERROR
				);
			}
		}
		if (isset ($general['delay_cache'])) {
			self::$delay_cache = $general['delay_cache'];
		}
		if (isset ($general['default_user'])) {
			self::$default_user = $general['default_user'];
			self::$current_user = self::$default_user;
		}

		// Base de données
		$db = false;
		if (isset ($ini_array['db'])) {
			$db = $ini_array['db'];
		}
		if ($db) {
			if (!isset ($db['host'])) {
				throw new BadConfigurationException (
					'host',
					MinzException::ERROR
				);
			}
			if (!isset ($db['user'])) {
				throw new BadConfigurationException (
					'user',
					MinzException::ERROR
				);
			}
			if (!isset ($db['password'])) {
				throw new BadConfigurationException (
					'password',
					MinzException::ERROR
				);
			}
			if (!isset ($db['base'])) {
				throw new BadConfigurationException (
					'base',
					MinzException::ERROR
				);
			}

			self::$db['type'] = isset ($db['type']) ? $db['type'] : 'mysql';
			self::$db['host'] = $db['host'];
			self::$db['user'] = $db['user'];
			self::$db['password'] = $db['password'];
			self::$db['base'] = $db['base'];
			self::$db['prefix'] = isset ($db['prefix']) ? $db['prefix'] : '';
		}
	}

	private static function setReporting () {
		if (self::environment () == self::DEVELOPMENT) {
			error_reporting (E_ALL);
			ini_set ('display_errors','On');
			ini_set('log_errors', 'On');
		} elseif (self::environment () == self::PRODUCTION) {
			error_reporting(E_ALL);
			ini_set('display_errors','Off');
			ini_set('log_errors', 'On');
		} else {
			error_reporting(0);
		}
	}
}
