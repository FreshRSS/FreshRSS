<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_array représente le modèle interragissant avec les fichiers de type texte gérant des tableaux php
 */
class Model_array extends Model_txt {
	/**
	 * $array Le tableau php contenu dans le fichier $nameFile
	 */
	protected $array = array ();
	
	/**
	 * Ouvre le fichier indiqué, charge le tableau dans $array et le $nameFile
	 * @param $nameFile le nom du fichier à ouvrir contenant un tableau
	 * Remarque : $array sera obligatoirement un tableau
	 */
	public function __construct ($nameFile) {
		parent::__construct ($nameFile);
		
		if (!$this->getLock ('read')) {
			throw new PermissionDeniedException ($this->filename);
		} else {
			$this->array = include ($this->filename);
			$this->releaseLock ();
		
			if (!is_array ($this->array)) {
				$this->array = array ();
			}
		
			$this->array = $this->decodeArray ($this->array);
		}
	}	
	
	/**
	 * Écrit un tableau dans le fichier $nameFile
	 * @param $array le tableau php à enregistrer
	 **/
	public function writeFile ($array) {
		if (!$this->getLock ('write')) {
			throw new PermissionDeniedException ($this->namefile);
		} else {
			$this->erase ();
		
			$this->writeLine ('<?php');
			$this->writeLine ('return ', false);
			$this->writeArray ($array);
			$this->writeLine (';');
		
			$this->releaseLock ();
		}
	}
	
	private function writeArray ($array, $profondeur = 0) {
		$tab = '';
		for ($i = 0; $i < $profondeur; $i++) {
			$tab .= "\t";
		}
		$this->writeLine ('array (');
		
		foreach ($array as $key => $value) {
			if (is_int ($key)) {
				$this->writeLine ($tab . "\t" . $key . ' => ', false);
			} else {
				$this->writeLine ($tab . "\t" . '\'' . $key . '\'' . ' => ', false);
			}
			
			if (is_array ($value)) {
				$this->writeArray ($value, $profondeur + 1);
				$this->writeLine (',');
			} else {
				if (is_numeric ($value)) {
					$this->writeLine ($value . ',');
				} else {
					$this->writeLine ('\'' . addslashes ($value) . '\',');
				}
			}
		}
		
		$this->writeLine ($tab . ')', false);
	}
	
	private function decodeArray ($array) {
		$new_array = array ();
		
		foreach ($array as $key => $value) {
			if (is_array ($value)) {
				$new_array[$key] = $this->decodeArray ($value);
			} else {
				$new_array[$key] = stripslashes ($value);
			}
		}
		
		return $new_array;
	}
	
	private function getLock ($type) {
		if ($type == 'write') {
			$lock = LOCK_EX;
		} else {
			$lock = LOCK_SH;
		}
	
		$count = 1;
		while (!flock ($this->file, $lock) && $count <= 50) {
			$count++;
		}
		
		if ($count >= 50) {
			return false;
		} else {
			return true;
		}
	}
	
	private function releaseLock () {
		flock ($this->file, LOCK_UN);
	}
}
