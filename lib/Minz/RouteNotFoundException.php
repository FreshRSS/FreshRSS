<?php
class Minz_RouteNotFoundException extends Minz_Exception {
	private $route;
	
	public function __construct ($route, $code = self::ERROR) {
		$this->route = $route;
		
		$message = 'Route `' . $route . '` not found';
		
		parent::__construct ($message, $code);
	}
	
	public function route () {
		return $this->route;
	}
}
