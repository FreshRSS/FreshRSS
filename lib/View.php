<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe View représente la vue de l'application
 */
class View {
	const VIEWS_PATH_NAME = '/views';
	const LAYOUT_PATH_NAME = '/layout';
	const LAYOUT_FILENAME = '/layout.phtml';
	
	private $view_filename = '';
	private $use_layout = false;
	
	private static $title = '';
	private static $styles = array ();
	private static $scripts = array ();
	
	private static $params = array ();
	
	/**
	 * Constructeur
	 * Détermine si on utilise un layout ou non
	 */
	public function __construct () {
		$this->view_filename = APP_PATH
		                     . self::VIEWS_PATH_NAME . '/'
		                     . Request::controllerName () . '/'
		                     . Request::actionName () . '.phtml';
		
		if (file_exists (APP_PATH
		               . self::LAYOUT_PATH_NAME
		               . self::LAYOUT_FILENAME)) {
			$this->use_layout = true;
		}
		
		self::$title = Configuration::title ();
	}
	
	/**
	 * Construit la vue
	 */
	public function build () {
		if ($this->use_layout) {
			$this->buildLayout ();
		} else {
			$this->render ();
		}
	}
	
	/**
	 * Construit le layout
	 */
	public function buildLayout () {
		include (
			APP_PATH
			. self::LAYOUT_PATH_NAME
			. self::LAYOUT_FILENAME
		);
	}
	
	/**
	 * Affiche la Vue en elle-même
	 */
	public function render () {
		if (file_exists ($this->view_filename)) {
			include ($this->view_filename);
		} else {
			Log::record ('File doesn\'t exist : `'
			            . $this->view_filename . '`',
			            Log::WARNING);
		}
	}
	
	/**
	 * Ajoute un élément du layout
	 * @param $part l'élément partial à ajouter
	 */
	public function partial ($part) {
		$fic_partial = APP_PATH
		             . self::LAYOUT_PATH_NAME . '/'
		             . $part . '.phtml';
		
		if (file_exists ($fic_partial)) {
			include ($fic_partial);
		} else {
			Log::record ('File doesn\'t exist : `'
			            . $fic_partial . '`',
			            Log::WARNING);
		}
	}
	
	/**
	 * Permet de choisir si on souhaite utiliser le layout
	 * @param $use true si on souhaite utiliser le layout, false sinon
	 */
	public function _useLayout ($use) {
		$this->use_layout = $use;
	}
	
	/**
	 * Gestion du titre
	 */
	public static function title () {
		return self::$title;
	}
	public static function headTitle () {
		return '<title>' . self::$title . '</title>' . "\n";
	}
	public static function _title ($title) {
		self::$title = $title;
	}
	public static function prependTitle ($title) {
		self::$title = $title . self::$title;
	}
	public static function appendTitle ($title) {
		self::$title = self::$title . $title;
	}
	
	/**
	 * Gestion des feuilles de style
	 */
	public static function headStyle () {
		$styles = '';

		foreach(self::$styles as $style) {
			$styles .= '<link rel="stylesheet" type="text/css"';
			$styles .= ' media="' . $style['media'] . '"';
			$styles .= ' href="' . $style['url'] . '" />' . "\n";
		}

		return $styles;
	}
	public static function prependStyle ($url, $media = 'all') {
		array_unshift (self::$styles, array (
			'url' => $url,
			'media' => $media
		));
	}
	public static function appendStyle ($url, $media = 'all') {
		self::$styles[] = array (
			'url' => $url,
			'media' => $media
		);
	}
	
	/**
	 * Gestion des scripts JS
	 */
	public static function headScript () {
		$scripts = '';

		foreach (self::$scripts as $script) {
			$scripts .= '<script type="text/javascript"';
			$scripts .= ' src="' . $script['url'] . '">';
			$scripts .= '</script>' . "\n";
		}

		return $scripts;
	}
	public static function prependScript ($url) {
		array_unshift(self::$scripts, array (
			'url' => $url
		));
	}
	public static function appendScript ($url) {
		self::$scripts[] = array (
			'url' => $url
		);
	}
	
	/**
	 * Gestion des paramètres ajoutés à la vue
	 */
	public static function _param ($key, $value) {
		self::$params[$key] = $value;
	}
	public function attributeParams () {
		foreach (View::$params as $key => $value) {
			$this->$key = $value;
		}
	}
}


