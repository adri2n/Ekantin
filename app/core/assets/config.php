<?php
// Tentukan BASE_PATH agar tidak bingung dengan "../"
// Naik 3 tingkat dari: app/core/assets/ -> ke Root Folder Ekantin
define('BASE_PATH', realpath(__DIR__ . '/../../../'));

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_ekantin');

// Autoloader Pintar (Otomatis cari file class)
spl_autoload_register(function ($class) {
    // Daftar folder di mana class disimpan
    $paths = [
        BASE_PATH . '/app/core/models/',
        BASE_PATH . '/app/core/controllers/',
        BASE_PATH . '/app/core/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>