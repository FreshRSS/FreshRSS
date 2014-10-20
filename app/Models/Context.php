<?php

/**
 * The context object handles the current configuration file and different
 * useful functions associated to the current view state.
 */
class FreshRSS_Context {
	public static $conf = null;
	public static $state = 0;

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
		self::$state = self::$conf->default_view;
	}

	public static function stateEnabled($state) {
		return self::$state & $state;
	}
}
