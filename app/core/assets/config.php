<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_ekantin');

// Autoload sederhana untuk memanggil class
spl_autoload_register(function ($class) {
    $paths = ['app/core/', 'app/controllers/', 'app/models/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

session_start();
?>