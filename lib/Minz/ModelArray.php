<?php

namespace Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_array représente le modèle interragissant avec les fichiers de type texte gérant des tableaux php
 */
class ModelArray {
	/**
	 * $filename est le nom du fichier
	 */
	protected $filename;

	/**
	 * Ouvre le fichier indiqué, charge le tableau dans $array et le $filename
	 * @param $filename le nom du fichier à ouvrir contenant un tableau
	 * Remarque : $array sera obligatoirement un tableau
	 */
	public function __construct ($filename) {
		$this->filename = $filename;
	}

	protected function loadArray() {
		if (!file_exists($this->filename)) {
			throw new FileNotExistException($this->filename, Minz_Exception::WARNING);
		} elseif (($handle = $this->getLock()) === false) {
			throw new PermissionDeniedException($this->filename);
		} else {
			$data = include($this->filename);
			$this->releaseLock($handle);

			if ($data === false) {
				throw new PermissionDeniedException($this->filename);
			} elseif (!is_array($data)) {
				$data = array();
			}
			return $data;
		}
	}

	/**
	 * Sauve le tableau $array dans le fichier $filename
	 **/
	protected function writeArray($array) {
		if (file_put_contents($this->filename, "<?php\n return " . var_export($array, true) . ';', LOCK_EX) === false) {
			throw new PermissionDeniedException($this->filename);
		}
		if (function_exists('opcache_invalidate')) {
			opcache_invalidate($this->filename);	//Clear PHP cache for include
		}
		return true;
	}

	private function getLock() {
		$handle = fopen($this->filename, 'r');
		if ($handle === false) {
			return false;
		}

		$count = 50;
		while (!flock($handle, LOCK_SH) && $count > 0) {
			$count--;
			usleep(1000);
		}

		if ($count > 0) {
			return $handle;
		} else {
			fclose($handle);
			return false;
		}
	}

	private function releaseLock($handle) {
		flock($handle, LOCK_UN);
		fclose($handle);
	}
}
