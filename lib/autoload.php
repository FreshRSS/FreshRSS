<?php

class ClassLoader {
    private $searchPath = [];

    /**
     * Register path in which to look for a class.
     */
    public function registerPath($path) {
        if (is_string($path)) {
            $this->searchPath[] = $path;
        }
        if (is_array($path)) {
            array_push($this->searchPath, ...$path);
        }
    }

    /**
     * Load class file if found.
     */
    public function loadClass($class)
    {
        if ($file = $this->findFile($class)) {
            require $file;
        }
    }

    /**
     * Find the file containing the class definition.
     */
    public function findFile($class) {
        // This match most of classes directly
        foreach ($this->searchPath as $path) {
            $file = $path . DIRECTORY_SEPARATOR . str_replace(['\\', '_'], DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                return $file;
            }
        }

        // This match FRSS model classes
        $freshrssClass = str_replace('FreshRSS_', '', $class);
        foreach ($this->searchPath as $path) {
            $file = $path . DIRECTORY_SEPARATOR . str_replace(['\\', '_'], DIRECTORY_SEPARATOR, $freshrssClass) . '.php';
            if (file_exists($file)) {
                return $file;
            }
        }

        // This match FRSS other classes
        list(, $classType) = explode('_', $freshrssClass);
        foreach ($this->searchPath as $path) {
            $file = $path . DIRECTORY_SEPARATOR . $classType . 's' . DIRECTORY_SEPARATOR . str_replace('_', '', $freshrssClass) . '.php';
            if (file_exists($file)) {
                return $file;
            }
        }
    }

    /**
     * Register the current loader in the autoload queue.
     */
    public function register($prepend = false) {
        spl_autoload_register([$this, 'loadClass'], true, $prepend);
    }
}

$loader = new ClassLoader();
$loader->registerPath([
    APP_PATH,
    APP_PATH . DIRECTORY_SEPARATOR . 'Models',
    LIB_PATH,
    LIB_PATH . DIRECTORY_SEPARATOR . 'SimplePie',
]);
$loader->register();
