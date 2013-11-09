<?php

class MinzException extends Exception {
	const ERROR = 0;
	const WARNING = 10;
	const NOTICE = 20;

	public function __construct ($message, $code = self::ERROR) {
		if ($code != MinzException::ERROR
		 && $code != MinzException::WARNING
		 && $code != MinzException::NOTICE) {
			$code = MinzException::ERROR;
		}
		
		parent::__construct ($message, $code);
	}
}

class PermissionDeniedException extends MinzException {
	public function __construct ($file_name, $code = self::ERROR) {
		$message = 'Permission is denied for `' . $file_name.'`';

		parent::__construct ($message, $code);
	}
}
class FileNotExistException extends MinzException {
	public function __construct ($file_name, $code = self::ERROR) {
		$message = 'File doesn\'t exist : `' . $file_name.'`';
		
		parent::__construct ($message, $code);
	}
}
class BadConfigurationException extends MinzException {
	public function __construct ($part_missing, $code = self::ERROR) {
		$message = '`' . $part_missing
		         . '` in the configuration file is missing or is misconfigured';
		
		parent::__construct ($message, $code);
	}
}
class ControllerNotExistException extends MinzException {
	public function __construct ($controller_name, $code = self::ERROR) {
		$message = 'Controller `' . $controller_name
		         . '` doesn\'t exist';
		
		parent::__construct ($message, $code);
	}
}
class ControllerNotActionControllerException extends MinzException {
	public function __construct ($controller_name, $code = self::ERROR) {
		$message = 'Controller `' . $controller_name
		         . '` isn\'t instance of ActionController';
		
		parent::__construct ($message, $code);
	}
}
class ActionException extends MinzException {
	public function __construct ($controller_name, $action_name, $code = self::ERROR) {
		$message = '`' . $action_name . '` cannot be invoked on `'
		         . $controller_name . '`';
		
		parent::__construct ($message, $code);
	}
}
class RouteNotFoundException extends MinzException {
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
class PDOConnectionException extends MinzException {
	public function __construct ($string_connection, $user, $code = self::ERROR) {
		$message = 'Access to database is denied for `' . $user . '`'
		         . ' (`' . $string_connection . '`)';
		
		parent::__construct ($message, $code);
	}
}
class CurrentPagePaginationException extends MinzException {
	public function __construct ($page) {
		$message = 'Page number `' . $page . '` doesn\'t exist';
		
		parent::__construct ($message, self::ERROR);
	}
}
