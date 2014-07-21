<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($username) {
		$db = Minz_Configuration::dataBase();
		require_once(APP_PATH . '/SQL/sql.' . $db['type'] . '.php');
		
		if (defined('SQL_CREATE_TABLES')) {
			$sql = sprintf(SQL_CREATE_TABLES, $db['prefix'] . $username . '_', Minz_Translate::t('default_category'));
			$stm = $c->prepare($sql);
			$ok = $stm && $stm->execute();
		} else {
			global $SQL_CREATE_TABLES;
			if (is_array($SQL_CREATE_TABLES)) {
				$ok = true;
				foreach ($SQL_CREATE_TABLES as $instruction) {
					$sql = sprintf($instruction, '', Minz_Translate::t('default_category'));
					$stm = $c->prepare($sql);
					$ok &= ($stm && $stm->execute());
				}
			}
		}

		if ($ok) {
			return true;
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function deleteUser($username) {
		$db = Minz_Configuration::dataBase();
		require_once(APP_PATH . '/SQL/sql.' . $db['type'] . '.php');

		$sql = sprintf(SQL_DROP_TABLES, $db['prefix'] . $username . '_');
		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute()) {
			return true;
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
}
