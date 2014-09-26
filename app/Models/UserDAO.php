<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($username) {
		$db = Minz_Configuration::dataBase();
		require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

		$userPDO = new Minz_ModelPdo($username);

		$ok = false;
		if (defined('SQL_CREATE_TABLES')) {	//E.g. MySQL
			$sql = sprintf(SQL_CREATE_TABLES, $db['prefix'] . $username . '_', Minz_Translate::t('default_category'));
			$stm = $userPDO->bd->prepare($sql);
			$ok = $stm && $stm->execute();
		} else {	//E.g. SQLite
			global $SQL_CREATE_TABLES;
			if (is_array($SQL_CREATE_TABLES)) {
				$ok = true;
				foreach ($SQL_CREATE_TABLES as $instruction) {
					$sql = sprintf($instruction, '', Minz_Translate::t('default_category'));
					$stm = $userPDO->bd->prepare($sql);
					$ok &= ($stm && $stm->execute());
				}
			}
		}

		if ($ok) {
			return true;
		} else {
			$info = empty($stm) ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function deleteUser($username) {
		$db = Minz_Configuration::dataBase();
		require_once(APP_PATH . '/SQL/install.sql.' . $db['type'] . '.php');

		if ($db['type'] === 'sqlite') {
			return unlink(DATA_PATH . '/' . $username . '.sqlite');
		} else {
			$userPDO = new Minz_ModelPdo($username);

			$sql = sprintf(SQL_DROP_TABLES, $db['prefix'] . $username . '_');
			$stm = $userPDO->bd->prepare($sql);
			if ($stm && $stm->execute()) {
				return true;
			} else {
				$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
				Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
				return false;
			}
		}
	}
}
