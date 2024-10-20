<?php
declare(strict_types=1);

class FreshRSS_TagDAOPGSQL extends FreshRSS_TagDAO {

	#[\Override]
	public function sqlIgnore(): string {
		return '';	//TODO
	}
}
