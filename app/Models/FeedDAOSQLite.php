<?php

class FreshRSS_FeedDAOSQLite extends FreshRSS_FeedDAO {

	public function updateCachedValues() {	//For one single feed, call updateLastUpdate($id)
		$sql = 'UPDATE `' . $this->prefix . 'feed` '
		     . 'SET cache_nbEntries=(SELECT COUNT(e1.id) FROM `' . $this->prefix . 'entry` e1 WHERE e1.id_feed=`' . $this->prefix . 'feed`.id),'
		     . 'cache_nbUnreads=(SELECT COUNT(e2.id) FROM `' . $this->prefix . 'entry` e2 WHERE e2.id_feed=`' . $this->prefix . 'feed`.id AND e2.is_read=0)';
		$stm = $this->bd->prepare($sql);
		if ($stm && $stm->execute()) {
			return $stm->rowCount();
		} else {
			$info = $stm == null ? array(2 => 'syntax error') : $stm->errorInfo();
			Minz_Log::error('SQL error updateCachedValues: ' . $info[2]);
			return false;
		}
	}

}
