<?php
declare(strict_types=1);

class FreshRSS_UserDAO extends Minz_ModelPdo {

	public function createUser(): bool {
		require(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');

		try {
			$sql = $GLOBALS['SQL_CREATE_TABLES'];
			$ok = $this->pdo->exec($sql) !== false;	//Note: Only exec() can take multiple statements safely.
		} catch (Exception $e) {
			$ok = false;
			Minz_Log::error('Error while creating database for user ' . $this->current_user . ': ' . $e->getMessage());
		}

		if ($ok) {
			return true;
		} else {
			$info = $this->pdo->errorInfo();
			Minz_Log::error(__METHOD__ . ' error: ' . json_encode($info));
			return false;
		}
	}

	public function deleteUser(): bool {
		if (defined('STDERR')) {
			fwrite(STDERR, 'Deleting SQL data for user “' . $this->current_user . "”…\n");
		}

		require(APP_PATH . '/SQL/install.sql.' . $this->pdo->dbType() . '.php');
		$ok = $this->pdo->exec($GLOBALS['SQL_DROP_TABLES']) !== false;

		if ($ok) {
			return true;
		} else {
			$info = $this->pdo->errorInfo();
			Minz_Log::error(__METHOD__ . ' error: ' . json_encode($info));
			return false;
		}
	}

	public static function exists(string $username): bool {
		return is_dir(USERS_PATH . '/' . $username);
	}

	public static function touch(string $username = ''): bool {
		if (!FreshRSS_user_Controller::checkUsername($username)) {
			$username = Minz_User::name() ?? Minz_User::INTERNAL_USER;
		}
		return touch(USERS_PATH . '/' . $username . '/config.php');
	}

	public static function mtime(string $username): int {
		return @(int)filemtime(USERS_PATH . '/' . $username . '/config.php');
	}
}
