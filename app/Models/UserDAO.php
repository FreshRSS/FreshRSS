<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($new_user_language = null, $insertDefaultFeeds = false) {
		require_once(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');

		$currentLanguage = Minz_Translate::language();

		try {
			if ($new_user_language != null) {
				Minz_Translate::reset($new_user_language);
			}
			$ok = false;
			global $SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS;
			if (is_array($SQL_CREATE_TABLES)) {
				$instructions = array_merge($SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS);
				$ok = true;
				foreach ($instructions as $sql) {
					$ok &= ($this->pdo->exec($sql) !== false);
				}
			}
			if ($ok && $insertDefaultFeeds) {
				$default_feeds = FreshRSS_Context::$system_conf->default_feeds;
				$stm = $this->pdo->prepare(SQL_INSERT_FEED);
				foreach ($default_feeds as $feed) {
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

		require_once(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');

		$ok = false;
		global $SQL_DROP_TABLES;
		if (is_array($SQL_DROP_TABLES)) {
			$ok = true;
			foreach ($SQL_DROP_TABLES as $sql) {
				$ok &= ($this->pdo->exec($sql) !== false);
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
