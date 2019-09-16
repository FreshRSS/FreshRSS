<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($new_user_language = null, $insertDefaultFeeds = false) {
		require_once(APP_PATH . '/SQL/install.sql.' . $this->bd->dbType() . '.php');

		$currentLanguage = Minz_Translate::language();

		try {
			if ($new_user_language != null) {
				Minz_Translate::reset($new_user_language);
			}
			$ok = false;
			if (defined('SQL_CREATE_TABLES')) {	//E.g. MySQL
				$sql = sprintf(SQL_CREATE_TABLES . SQL_CREATE_TABLE_ENTRYTMP . SQL_CREATE_TABLE_TAGS, $this->prefix, _t('gen.short.default_category'));
				$stm = $this->bd->prepare($sql);
				$ok = $stm && $stm->execute();
			} else {	//E.g. SQLite
				global $SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS;
				if (is_array($SQL_CREATE_TABLES)) {
					$instructions = array_merge($SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS);
					$ok = !empty($instructions);
					foreach ($instructions as $instruction) {
						$sql = sprintf($instruction, $this->prefix, _t('gen.short.default_category'));
						$stm = $this->bd->prepare($sql);
						$ok &= ($stm && $stm->execute());
					}
				}
			}
			if ($ok && $insertDefaultFeeds) {
				$default_feeds = FreshRSS_Context::$system_conf->default_feeds;
				foreach ($default_feeds as $feed) {
					$sql = sprintf(SQL_INSERT_FEED, $this->prefix);
					$stm = $this->bd->prepare($sql);
					$parameters = array(
						':url' => $feed['url'],
						':name' => $feed['name'],
						':website' => $feed['website'],
						':description' => $feed['description'],
					);
					$ok &= ($stm && $stm->execute($parameters));
				}
			}
		} catch (Exception $e) {
			Minz_Log::error('Error while creating database for user: ' . $e->getMessage());
		}

		Minz_Translate::reset($currentLanguage);

		if ($ok) {
			return true;
		} else {
			$info = empty($stm) ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error(__METHOD__ . ' error: ' . $info[2]);
			return false;
		}
	}

	public function deleteUser() {
		if (defined('STDERR')) {
			fwrite(STDERR, 'Deleting SQL data for user “' . $this->current_user . "”…\n");
		}

		require_once(APP_PATH . '/SQL/install.sql.' . $this->bd->dbType() . '.php');

		$ok = false;
		if (defined('SQL_DROP_TABLES')) {	//E.g. MySQL
			$sql = sprintf(SQL_DROP_TABLES, $this->prefix);
			$stm = $this->bd->prepare($sql);
			$ok = $stm && $stm->execute();
		} else {	//E.g. SQLite
			global $SQL_DROP_TABLES;
			if (is_array($SQL_DROP_TABLES)) {
				$instructions = $SQL_DROP_TABLES;
				$ok = !empty($instructions);
				foreach ($instructions as $instruction) {
					$sql = sprintf($instruction, $this->prefix);
					$stm = $this->bd->prepare($sql);
					$ok &= ($stm && $stm->execute());
				}
			}
		}

		if ($ok) {
			return true;
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error(__METHOD__ . ' error: ' . $info[2]);
			return false;
		}
	}

	public static function exists($username) {
		return is_dir(USERS_PATH . '/' . $username);
	}

	public static function touch($username = '') {
		if (!FreshRSS_user_Controller::checkUsername($username)) {
			$username = Minz_Session::param('currentUser', '_');
		}
		return touch(USERS_PATH . '/' . $username . '/config.php');
	}

	public static function mtime($username) {
		return @filemtime(USERS_PATH . '/' . $username . '/config.php');
	}
}
