<?php

class FreshRSS_Migration_20210424_GitMasterToEdge {
	public static function migrate() {
		if (!is_writable(FRESHRSS_PATH . '/.git/')) {
			return true; // not a writeable Git installation, nothing to do
		}

		exec('git branch --show-current', $output, $return);
		if ($return != 0) {
			throw new Exception('Can’t checkout to edge branch, please change branch manually.');
		}

		$line = is_array($output) ? implode('', $output) : $output;
		if ($line !== 'master' && $line !== 'dev') {
			return true; // not on master or dev, nothing to do
		}

		unset($output);
		exec('git checkout edge --guess -f', $output, $return);
		if ($return != 0) {
			throw new Exception('Can’t checkout to edge branch, please change branch manually.');
		}

		unset($output);
		exec('git reset --hard FETCH_HEAD', $output, $return);
		if ($return != 0) {
			throw new Exception('Can’t checkout to edge branch, please change branch manually.');
		}

		return true;
	}
}
