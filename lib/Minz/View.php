<?php
/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe View représente la vue de l'application
 */
class Minz_View {
	const VIEWS_PATH_NAME = '/views';
	const LAYOUT_PATH_NAME = '/layout';
	const LAYOUT_FILENAME = '/layout.phtml';

	private $view_filename = '';
	private $use_layout = null;

	private static $title = '';
	private static $styles = array ();
	private static $scripts = array ();

	private static $params = array ();

	/**
	 * Constructeur
	 * Détermine si on utilise un layout ou non
	 */
	public function __construct () {
		$this->change_view(Minz_Request::controllerName(),
		                   Minz_Request::actionName());
		self::$title = Minz_Configuration::title ();
	}

	/**
	 * Change le fichier de vue en fonction d'un controller / action
	 */
	public function change_view($controller_name, $action_name) {
		$this->view_filename = APP_PATH
		                     . self::VIEWS_PATH_NAME . '/'
		                     . $controller_name . '/'
		                     . $action_name . '.phtml';
	}

	/**
	 * Construit la vue
	 */
	public function build () {
		if ($this->use_layout === null) {	//TODO: avoid file_exists and require views to be explicit
			$this->use_layout = file_exists (APP_PATH . self::LAYOUT_PATH_NAME . self::LAYOUT_FILENAME);
		}
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
		if ((include($this->view_filename)) === false) {
			Minz_Log::record ('File not found: `'
			            . $this->view_filename . '`',
			            Minz_Log::NOTICE);
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

		if ((include($fic_partial)) === false) {
			Minz_Log::record ('File not found: `'
			            . $fic_partial . '`',
			            Minz_Log::WARNING);
		}
	}

	/**
	 * Affiche un élément graphique situé dans APP./views/helpers/
	 * @param $helper l'élément à afficher
	 */
	public function renderHelper ($helper) {
		$fic_helper = APP_PATH
		            . '/views/helpers/'
		            . $helper . '.phtml';

		if ((include($fic_helper)) === false) {;
			Minz_Log::record ('File not found: `'
			            . $fic_helper . '`',
			            Minz_Log::WARNING);
		}
	}

	/**
	 * Retourne renderHelper() dans une chaîne
	 * @param $helper l'élément à traîter
	 */
	public function helperToString($helper) {
		ob_start();
		$this->renderHelper($helper);
		return ob_get_clean();
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
			$cond = $style['cond'];
			if ($cond) {
				$styles .= '<!--[if ' . $cond . ']>';
			}

			$styles .= '<link rel="stylesheet" ' .
				($style['media'] === 'all' ? '' : 'media="' . $style['media'] . '" ') .
				'href="' . $style['url'] . '" />';

			if ($cond) {
				$styles .= '<![endif]-->';
			}

			$styles .= "\n";
		}

		return $styles;
	}
	public static function prependStyle ($url, $media = 'all', $cond = false) {
		array_unshift (self::$styles, array (
			'url' => $url,
			'media' => $media,
			'cond' => $cond
		));
	}
	public static function appendStyle ($url, $media = 'all', $cond = false) {
		self::$styles[] = array (
			'url' => $url,
			'media' => $media,
			'cond' => $cond
		);
	}

	/**
	 * Gestion des scripts JS
	 */
	public static function headScript () {
		$scripts = '';

		foreach (self::$scripts as $script) {
			$cond = $script['cond'];
			if ($cond) {
				$scripts .= '<!--[if ' . $cond . ']>';
			}

			$scripts .= '<script src="' . $script['url'] . '"';
			if ($script['defer']) {
				$scripts .= ' defer="defer"';
			}
			if ($script['async']) {
				$scripts .= ' async="async"';
			}
			$scripts .= '></script>';

			if ($cond) {
				$scripts .= '<![endif]-->';
			}

			$scripts .= "\n";
		}

		return $scripts;
	}
	public static function prependScript ($url, $cond = false, $defer = true, $async = true) {
		array_unshift(self::$scripts, array (
			'url' => $url,
			'cond' => $cond,
			'defer' => $defer,
			'async' => $async,
		));
	}
	public static function appendScript ($url, $cond = false, $defer = true, $async = true) {
		self::$scripts[] = array (
			'url' => $url,
			'cond' => $cond,
			'defer' => $defer,
			'async' => $async,
		);
	}

	/**
	 * Gestion des paramètres ajoutés à la vue
	 */
	public static function _param ($key, $value) {
		self::$params[$key] = $value;
	}
	public function attributeParams () {
		foreach (Minz_View::$params as $key => $value) {
			$this->$key = $value;
		}
	}
}


