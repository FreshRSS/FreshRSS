<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Model_txt représente le modèle interragissant avec les fichiers de type texte
 */
class Minz_ModelTxt {
	/**
	 * $file représente le fichier à ouvrir
	 */
	protected $file;
	
	/**
	 * $filename est le nom du fichier
	 */
	protected $filename;
	
	/**
	 * Ouvre un fichier dans $file
	 * @param $nameFile nom du fichier à ouvrir
	 * @param $mode mode d'ouverture du fichier ('a+' par défaut)
	 * @exception FileNotExistException si le fichier n'existe pas
	 *          > ou ne peux pas être ouvert
	 */
	public function __construct ($nameFile, $mode = 'a+') {
		$this->filename = $nameFile;
		if (!file_exists($this->filename)) {
			throw new Minz_FileNotExistException (
				$this->filename,
				Minz_Exception::WARNING
			);
		}

		$this->file = @fopen ($this->filename, $mode);
		
		if (!$this->file) {
			throw new Minz_PermissionDeniedException (
				$this->filename,
				Minz_Exception::WARNING
			);
		}
	}
	
	/**
	 * Lit une ligne de $file
	 * @return une ligne du fichier
	 */
	public function readLine () {
		return fgets ($this->file);
	}
	
	/**
	 * Écrit une ligne dans $file
	 * @param $line la ligne à écrire
	 */
	public function writeLine ($line, $newLine = true) {
		$char = '';
		if ($newLine) {
			$char = "\n";
		}
		
		fwrite ($this->file, $line . $char);
	}
	
	/**
	 * Efface le fichier $file
	 * @return true en cas de succès, false sinon
	 */
	public function erase () {
		return ftruncate ($this->file, 0);
	}
	
	/**
	 * Ferme $file
	 */
	public function __destruct () {
		if (isset ($this->file)) {
			fclose ($this->file);
		}
	}
}
