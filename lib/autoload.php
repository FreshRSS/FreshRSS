<?php

function classAutoloader($class) {
	if (strpos($class, 'FreshRSS') === 0) {
		$components = explode('_', $class);
		switch (count($components)) {
			case 1:
				include(APP_PATH . '/' . $components[0] . '.php');
				return;
			case 2:
				include(APP_PATH . '/Models/' . $components[1] . '.php');
				return;
			case 3:	//Controllers, Exceptions
				include(APP_PATH . '/' . $components[2] . 's/' . $components[1] . $components[2] . '.php');
				return;
		}
	} elseif (strpos($class, 'Minz') === 0) {
		include(LIB_PATH . '/' . str_replace('_', '/', $class) . '.php');
	} elseif (strpos($class, 'SimplePie') === 0) {
		include(LIB_PATH . '/SimplePie/' . str_replace('_', '/', $class) . '.php');
	} elseif (strpos($class, 'PHPMailer') === 0) {
		include(LIB_PATH . '/' . str_replace('\\', '/', $class) . '.php');
	}
}

spl_autoload_register('classAutoloader');
