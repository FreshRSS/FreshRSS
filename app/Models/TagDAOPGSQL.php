<?php

declare(strict_types=1);

class FreshRSS_TagDAOPGSQL extends FreshRSS_TagDAO {

	public function sqlIgnore(): string {
		return '';	//TODO
	}

}
