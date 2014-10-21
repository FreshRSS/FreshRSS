<?php

/**
 * The context object handles the current configuration file and different
 * useful functions associated to the current view state.
 */
class FreshRSS_Context {
	public static $conf = null;

	public static $total_unread = 0;
	public static $total_starred = array(
		'all' => 0,
		'read' => 0,
		'unread' => 0,
	);

	public static $state = 0;
	public static $current_get = array(
		'all' => false,
		'starred' => false,
		'feed' => false,
		'category' => false,
	);
	public static $order = 'DESC';

	public static function init() {
		// Init configuration.
		$current_user = Minz_Session::param('currentUser');
		try {
			self::$conf = new FreshRSS_Configuration($current_user);
		} catch(Minz_Exception $e) {
			Minz_Log::error('Cannot load configuration file of user `' . $current_user . '`');
			die($e->getMessage());
		}

		// Init i18n.
		Minz_Session::_param('language', self::$conf->language);
		Minz_Translate::init();

		// Get the current state.
		// self::$state = self::$conf->default_view;
	}

	public static function isStateEnabled($state) {
		return self::$state & $state;
	}

	public static function getRevertState($state) {
		if (self::$state & $state) {
			return self::$state & ~$state;
		} else {
			return self::$state | $state;
		}
	}

	public static function currentGet() {
		if (self::$current_get['all']) {
			return 'a';
		} elseif (self::$current_get['starred']) {
			return 's';
		} elseif (self::$current_get['feed']) {
			return 'f_' . self::$current_get['feed'];
		} elseif (self::$current_get['category']) {
			return 'c_' . self::$current_get['category'];
		}
	}

	public static function isCurrentGet($get) {
		$type = $get[0];
		$id = substr($get, 2);

		switch($type) {
		case 'a':
			return self::$current_get['all'];
		case 's':
			return self::$current_get['starred'];
		case 'f':
			return self::$current_get['feed'] === $id;
		case 'c':
			return self::$current_get['category'] === $id;
		default:
			return false;
		}
	}

	public static function nextStep() {
		// TODO: fix this method.
		return array(
			'get' => 'a',
			'idMax' => (time() - 1) . '000000'
		);
	}
}
