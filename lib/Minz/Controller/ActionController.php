<?php

namespace Minz\Controller;

use Minz\Request;
use Minz\View;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe ActionController représente le contrôleur de l'application
 */
class ActionController {
	protected $view;
	private $csp_policies = array(
		'default-src' => "'self'",
	);

	/**
	 * Constructeur
	 */
	public function __construct () {
		$this->view = new View();
		$view_path = Request::controllerName() . '/' . Request::actionName() . '.phtml';
		$this->view->_path($view_path);
		$this->view->attributeParams ();
	}

	/**
	 * Getteur
	 */
	public function view () {
		return $this->view;
	}

	/**
	 * Set CSP policies.
	 *
	 * A default-src directive should always be given.
	 *
	 * References:
	 * - https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
	 * - https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/default-src
	 *
	 * @param array $policies An array where keys are directives and values are sources.
	 */
	protected function _csp($policies) {
		if (!isset($policies['default-src'])) {
			$action = Request::controllerName() . '#' . Request::actionName();
			Log::warning(
				"Default CSP policy is not declared for action {$action}.",
				ADMIN_LOG
			);
		}
		$this->csp_policies = $policies;
	}

	/**
	 * Send HTTP Content-Security-Policy header based on declared policies.
	 */
	public function declareCspHeader() {
		$policies = [];
		foreach ($this->csp_policies as $directive => $sources) {
			$policies[] = $directive . ' ' . $sources;
		}
		header('Content-Security-Policy: ' . implode('; ', $policies));
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
