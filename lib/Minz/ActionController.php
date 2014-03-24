<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe ActionController représente le contrôleur de l'application
 */
class Minz_ActionController {
	protected $view;

	/**
	 * Constructeur
	 */
	public function __construct () {
		$this->view = new Minz_View ();
		$this->view->attributeParams ();
	}

	/**
	 * Getteur
	 */
	public function view () {
		return $this->view;
	}
	
	/**
	 * Méthodes à redéfinir (ou non) par héritage
	 * firstAction est la première méthode exécutée par le Dispatcher
	 * lastAction est la dernière
	 */
	public function init () { }
	public function firstAction () { }
	public function lastAction () { }
}


