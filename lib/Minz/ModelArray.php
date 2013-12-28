<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_array représente le modèle interragissant avec les fichiers de type texte gérant des tableaux php
 */
class Minz_ModelArray {
	/**
	 * $array Le tableau php contenu dans le fichier $filename
	 */
	protected $array = array ();

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

		if (!file_exists($this->filename)) {
			throw new Minz_FileNotExistException($this->filename, Minz_Exception::WARNING);
		}
		elseif (($handle = $this->getLock()) === false) {
			throw new Minz_PermissionDeniedException($this->filename);
		} else {
			$this->array = include($this->filename);
			$this->releaseLock($handle);

			if ($this->array === false) {
				throw new Minz_PermissionDeniedException($this->filename);
			} elseif (!is_array($this->array)) {
				$this->array = array();
			}
		}
	}

	/**
	 * Sauve le tableau $array dans le fichier $filename
	 **/
	protected function writeFile() {
		if (!file_put_contents($this->filename, "<?php\n return " . var_export($this->array, true) . ';', LOCK_EX)) {
			throw new Minz_PermissionDeniedException($this->filename);
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
