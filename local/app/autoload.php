<?php
spl_autoload_register(
    function (string $className): void {
        $prefix  = 'Models\\';
        $baseDir = __DIR__ . '/Models/';

        if (strncmp($prefix, $className, strlen($prefix)) !== 0) {
            return;
        }

        $relativeClass = substr($className, strlen($prefix));
        $file = $baseDir
            . str_replace('\\', '/', $relativeClass)
            . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
);
