<?php
declare(strict_types=1);

class FreshRSS_TagDAOSQLite extends FreshRSS_TagDAO {

	public function sqlIgnore(): string {
		return 'OR IGNORE';
	}

}
