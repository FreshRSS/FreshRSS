<?php

interface FreshRSS_Searchable {

	/**
	 * @param int|string $id
	 * @return Minz_Model
	 */
	public function searchById($id);
}
