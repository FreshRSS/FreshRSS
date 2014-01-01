<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($username) {
		require_once(APP_PATH . '/sql.php');
		$db = Minz_Configuration::dataBase();

		$sql = sprintf(SQL_CREATE_TABLES, $db['prefix'] . $username . '_');
		$stm = $this->bd->prepare($sql, array(PDO::ATTR_EMULATE_PREPARES => true));
		$values = array(
			'catName' => Minz_Translate::t('default_category'),
		);
		if ($stm && $stm->execute($values)) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}

	public function deleteUser($username) {
		require_once(APP_PATH . '/sql.php');
		$db = Minz_Configuration::dataBase();

		$sql = sprintf(SQL_DROP_TABLES, $db['prefix'] . $username . '_');
		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute()) {
			return true;
		} else {
			$info = $stm->errorInfo();
			Minz_Log::record ('SQL error : ' . $info[2], Minz_Log::ERROR);
			return false;
		}
	}
}
