<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/

/**
 * La classe Router gère le routage de l'application
 * Les routes sont définies dans APP_PATH.'/configuration/routes.php'
 */
class Router {
	const ROUTES_PATH_NAME = '/configuration/routes.php';

	private $routes = array ();
	
	/**
	 * Constructeur
	 * @exception FileNotExistException si ROUTES_PATH_NAME n'existe pas
	 *            et que l'on utilise l'url rewriting
	 */
	public function __construct () {
		if (Configuration::useUrlRewriting ()) {
			if (file_exists (APP_PATH . self::ROUTES_PATH_NAME)) {
				$routes = include (
					APP_PATH . self::ROUTES_PATH_NAME
				);
		
				if (!is_array ($routes)) {
					$routes = array ();
				}
				
				$this->routes = array_map (
					array ('Url', 'checkUrl'),
					$routes
				);
			} else {
				throw new FileNotExistException (
					self::ROUTES_PATH_NAME,
					MinzException::ERROR
				);
			}
		}
	}
	
	/**
	 * Initialise le Router en déterminant le couple Controller / Action
	 * Mets à jour la Request
	 * @exception RouteNotFoundException si l'uri n'est pas présente dans
	 *          > la table de routage
	 */
	public function init () {
		$url = array ();
		
		if (Configuration::useUrlRewriting ()) {
			try {
				$url = $this->buildWithRewriting ();
			} catch (RouteNotFoundException $e) {
				throw $e;
			}
		} else {
			$url = $this->buildWithoutRewriting ();
		}
		
		$url['params'] = array_merge (
			$url['params'],
			Request::fetchPOST ()
		);
		
		Request::forward ($url);
	}
	
	/**
	 * Retourne un tableau représentant l'url passée par la barre d'adresses
	 * Ne se base PAS sur la table de routage
	 * @return tableau représentant l'url
	 */
	public function buildWithoutRewriting () {
		$url = array ();
		
		$url['c'] = Request::fetchGET (
			'c',
			Request::defaultControllerName ()
		);
		$url['a'] = Request::fetchGET (
			'a',
			Request::defaultActionName ()
		);
		$url['params'] = Request::fetchGET ();
		
		// post-traitement
		unset ($url['params']['c']);
		unset ($url['params']['a']);
		
		return $url;
	}
	
	/**
	 * Retourne un tableau représentant l'url passée par la barre d'adresses
	 * Se base sur la table de routage
	 * @return tableau représentant l'url
	 * @exception RouteNotFoundException si l'uri n'est pas présente dans
	 *          > la table de routage
	 */
	public function buildWithRewriting () {
		$url = array ();
		$uri = Request::getURI ();
		$find = false;
		
		foreach ($this->routes as $route) {
			$regex = '*^' . $route['route'] . '$*';
			if (preg_match ($regex, $uri, $matches)) {
				$url['c'] = $route['controller'];
				$url['a'] = $route['action'];
				$url['params'] = $this->getParams (
					$route['params'],
					$matches
				);
				$find = true;
				break;
			}
		}
		
		if (!$find && $uri != '/') {
			throw new RouteNotFoundException (
				$uri,
				MinzException::ERROR
			);
		}
		
		// post-traitement
		$url = Url::checkUrl ($url);
		
		return $url;
	}
	
	/**
	 * Retourne l'uri d'une url en se basant sur la table de routage
	 * @param l'url sous forme de tableau
	 * @return l'uri formatée (string) selon une route trouvée
	 */
	public function printUriRewrited ($url) {
		$route = $this->searchRoute ($url);
		
		if ($route !== false) {
			return $this->replaceParams ($route, $url);
		}
		
		return '';
	}
	
	/**
	 * Recherche la route correspondante à une url
	 * @param l'url sous forme de tableau
	 * @return la route telle que spécifiée dans la table de routage,
	 *         false si pas trouvée
	 */
	public function searchRoute ($url) {
		foreach ($this->routes as $route) {
			if ($route['controller'] == $url['c']
			 && $route['action'] == $url['a']) {
				// calcule la différence des tableaux de params
				$params = array_flip ($route['params']);
				$difference_params = array_diff_key (
					$params,
					$url['params']
				);
				
				// vérifie que pas de différence
				// et le cas où $params est vide et pas $url['params']
				if (empty ($difference_params)
				&& (!empty ($params) || empty ($url['params']))) {
					return $route;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Récupère un tableau dont
	 * 	- les clés sont définies dans $params_route
	 *	- les valeurs sont situées dans $matches
	 * Le tableau $matches est décalé de +1 par rapport à $params_route
	 */
	private function getParams($params_route, $matches) {
		$params = array ();
		
		for ($i = 0; $i < count ($params_route); $i++) {
			$param = $params_route[$i];
			$params[$param] = $matches[$i + 1];
		}
	
		return $params;
	}
	
	/**
	 * Remplace les éléments de la route par les valeurs contenues dans $url
	 * TODO Fonction très sale ! À revoir (preg_replace ?)
	 */
	private function replaceParams ($route, $url) {
		$uri = '';
		$in_brackets = false;
		$backslash = false;
		$num_param = 0;
		
		// parcourt caractère par caractère
	 	for ($i = 0; $i < strlen ($route['route']); $i++) {
			// on détecte qu'on rentre dans des parenthèses
			// on va devoir changer par la valeur d'un paramètre
	 		if ($route['route'][$i] == '(' && !$backslash) {
	 			$in_brackets = true;
	 		}
			// on sort des parenthèses
			// ok, on change le paramètre maintenant
	 		if ($route['route'][$i] == ')' && !$backslash) {
	 			$in_brackets = false;
	 			$param = $route['params'][$num_param];
 				$uri .= $url['params'][$param];
 				$num_param++;
	 		}
	 		
	 		if (!$in_brackets
	 		 && ($route['route'][$i] != '\\' || $backslash)
	 		 && ($route['route'][$i] != '(' || $backslash)
	 		 && ($route['route'][$i] != ')' || $backslash)
	 		 && ($route['route'][$i] != '?' || $backslash)) {
				// on est pas dans les parenthèses
				// on recopie simplement le caractère
 				$uri .= $route['route'][$i];
	 		}
	 		
	 		// on détecte un backslash, on n'en veut pas
	 		// sauf si on en avait déjà un juste avant
	 		if ($route['route'][$i] == '\\' && !$backslash) {
	 			$backslash = true;
	 		} else {
	 			$backslash = false;
	 		}
	 	}
	 	
	 	return $uri;
	 }
}
