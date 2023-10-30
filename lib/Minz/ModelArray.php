<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * The Minz_ModelArray class is the model to interact with text files containing a PHP array
 */
class Minz_ModelArray {
	/**
	 * $filename est le nom du fichier
	 */
	protected string $filename;

	/**
	 * Ouvre le fichier indiqué, charge le tableau dans $array et le $filename
	 * @param string $filename le nom du fichier à ouvrir contenant un tableau
	 * Remarque : $array sera obligatoirement un tableau
	 */
	public function __construct(string $filename) {
		$this->filename = $filename;
	}

	/** @return array<string,mixed> */
	protected function loadArray(): array {
		if (!file_exists($this->filename)) {
			throw new Minz_FileNotExistException($this->filename, Minz_Exception::WARNING);
		} elseif (($handle = $this->getLock()) === false) {
			throw new Minz_PermissionDeniedException($this->filename);
		} else {
			$data = include($this->filename);
			$this->releaseLock($handle);

			if ($data === false) {
				throw new Minz_PermissionDeniedException($this->filename);
			} elseif (!is_array($data)) {
				$data = array();
			}
			return $data;
		}
	}

	/**
	 * Sauve le tableau $array dans le fichier $filename
	 * @param array<string,mixed> $array
	 */
	protected function writeArray(array $array): bool {
		if (file_put_contents($this->filename, "<?php\n return " . var_export($array, true) . ';', LOCK_EX) === false) {
			throw new Minz_PermissionDeniedException($this->filename);
		}
		if (function_exists('opcache_invalidate')) {
			opcache_invalidate($this->filename);	//Clear PHP cache for include
		}
		return true;
	}

	/** @return resource|false */
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

	/** @param resource $handle */
	private function releaseLock($handle): void {
		flock($handle, LOCK_UN);
		fclose($handle);
	}
}
