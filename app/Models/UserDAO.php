<?php

class FreshRSS_UserDAO extends Minz_ModelPdo {
	public function createUser($insertDefaultFeeds = false) {
		require(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');

		try {
			$sql = $SQL_CREATE_TABLES . $SQL_CREATE_TABLE_ENTRYTMP . $SQL_CREATE_TABLE_TAGS;
			$ok = $this->pdo->exec($sql) !== false;	//Note: Only exec() can take multiple statements safely.
		} catch (Exception $e) {
			Minz_Log::error('Error while creating database for user ' . $this->current_user . ': ' . $e->getMessage());
		}

		if ($ok && $insertDefaultFeeds) {
			$opmlPath = DATA_PATH . '/opml.xml';
			if (!file_exists($opmlPath)) {
				$opmlPath = FRESHRSS_PATH . '/opml.default.xml';
			}
			$importController = new FreshRSS_importExport_Controller();
			try {
				$importController->importFile($opmlPath, $opmlPath, $this->current_user);
			} catch (Exception $e) {
				Minz_Log::error('Error while importing default OPML for user ' . $this->current_user . ': ' . $e->getMessage());
			}
		}

		if ($ok) {
			return true;
		} else {
			$info = empty($stm) ? $this->pdo->errorInfo() : $stm->errorInfo();
			Minz_Log::error(__METHOD__ . ' error: ' . json_encode($info));
			return false;
		}
	}

	public function deleteUser() {
		if (defined('STDERR')) {
			fwrite(STDERR, 'Deleting SQL data for user “' . $this->current_user . "”…\n");
		}

		require(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');
		$ok = $this->pdo->exec($SQL_DROP_TABLES) !== false;

		if ($ok) {
			return true;
		} else {
			$info = $stm == null ? $this->pdo->errorInfo() : $stm->errorInfo();
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
