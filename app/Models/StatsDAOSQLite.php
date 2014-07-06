<?php

class FreshRSS_StatsDAOSQLite extends FreshRSS_StatsDAO {

	public function calculateEntryCount() {
		return $this->convertToSerie(array());	//TODO: Implement 30-day statistics for SQLite
	}

}
