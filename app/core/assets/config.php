<?php
// Tentukan Path Root (Folder Utama Ekantin)
// Jika config.php ada di folder: app/core/assets/
// Maka kita perlu naik 3 level: assets -> core -> app -> Root
define('BASE_PATH', dirname(__DIR__, 3)); 

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_ekantin');

// Autoload yang lebih pintar (Menggunakan Absolute Path)
spl_autoload_register(function ($class) {
    // Daftar folder tempat class Anda disimpan (Sesuai struktur file Anda)
    $paths = [
        BASE_PATH . '/app/core/models/',      // Untuk MenuModel, PesananModel
        BASE_PATH . '/app/core/controllers/', // Untuk MenuController
        BASE_PATH . '/app/core/'              // Untuk Auth, Database
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