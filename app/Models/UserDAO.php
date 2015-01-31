<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($username) {
		$db = FreshRSS_Context::$system_conf->db;
		require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

		$userPDO = new Minz_ModelPdo($username);

		$ok = false;
		if (defined('SQL_CREATE_TABLES')) {	//E.g. MySQL
			$sql = sprintf(SQL_CREATE_TABLES, $db['prefix'] . $username . '_', _t('gen.short.default_category'));
			$stm = $userPDO->bd->prepare($sql);
			$ok = $stm && $stm->execute();
		} else {	//E.g. SQLite
			global $SQL_CREATE_TABLES;
			if (is_array($SQL_CREATE_TABLES)) {
				$ok = true;
				foreach ($SQL_CREATE_TABLES as $instruction) {
					$sql = sprintf($instruction, '', _t('gen.short.default_category'));
					$stm = $userPDO->bd->prepare($sql);
					$ok &= ($stm && $stm->execute());
				}
			}
		}

		if ($ok) {
			return true;
		} else {
			$info = empty($stm) ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error : ' . $info[2]);
			return false;
		}
	}

	public function deleteUser($username) {
		$db = FreshRSS_Context::$system_conf->db;
		require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

		if ($db['type'] === 'sqlite') {
			return unlink(join_path(DATA_PATH, 'users', $username, 'db.sqlite'));
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

	public static function exist($username) {
		return is_dir(join_path(DATA_PATH , 'users', $username));
	}

	public static function touch($username) {
		return touch(join_path(DATA_PATH , 'users', $username, 'config.php'));
	}

	public static function mtime($username) {
		return @filemtime(join_path(DATA_PATH , 'users', $username, 'config.php'));
	}
}
