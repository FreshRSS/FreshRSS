<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($username, $new_user_language, $insertDefaultFeeds = true) {
		$db = FreshRSS_Context::$system_conf->db;
		require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

		$userPDO = new Minz_ModelPdo($username);

		$currentLanguage = Minz_Translate::language();

		try {
			Minz_Translate::reset($new_user_language);
			$ok = false;
			$bd_prefix_user = $db['prefix'] . $username . '_';
			if (defined('SQL_CREATE_TABLES')) {	//E.g. MySQL
				$sql = sprintf(SQL_CREATE_TABLES . SQL_CREATE_TABLE_ENTRYTMP . SQL_CREATE_TABLE_TAGS, $bd_prefix_user, _t('gen.short.default_category'));
				$stm = $userPDO->bd->prepare($sql);
				$ok = $stm && $stm->execute();
			} else {	//E.g. SQLite
				global $SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS;
				if (is_array($SQL_CREATE_TABLES)) {
					$instructions = array_merge($SQL_CREATE_TABLES, $SQL_CREATE_TABLE_ENTRYTMP, $SQL_CREATE_TABLE_TAGS);
					$ok = !empty($instructions);
					foreach ($instructions as $instruction) {
						$sql = sprintf($instruction, $bd_prefix_user, _t('gen.short.default_category'));
						$stm = $userPDO->bd->prepare($sql);
						$ok &= ($stm && $stm->execute());
					}
				}
			}
			if ($ok && $insertDefaultFeeds) {
				$default_feeds = FreshRSS_Context::$system_conf->default_feeds;
				foreach ($default_feeds as $feed) {
					$sql = sprintf(SQL_INSERT_FEED, $bd_prefix_user);
					$stm = $userPDO->bd->prepare($sql);
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
			Minz_Log::error('Error while creating user: ' . $e->getMessage());
		}

		Minz_Translate::reset($currentLanguage);

		if ($ok) {
			return true;
		} else {
			$info = empty($stm) ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error: ' . $info[2]);
			return false;
		}
	}

	public function deleteUser($username) {
		$db = FreshRSS_Context::$system_conf->db;
		require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

		if ($db['type'] === 'sqlite') {
			return unlink(USERS_PATH . '/' . $username . '/db.sqlite');
		} else {
			$userPDO = new Minz_ModelPdo($username);

			$sql = sprintf(SQL_DROP_TABLES, $db['prefix'] . $username . '_');
			$stm = $userPDO->bd->prepare($sql);
			if ($stm && $stm->execute()) {
				return true;
			} else {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::error('SQL error : ' . $info[2]);
				return false;
			}
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
