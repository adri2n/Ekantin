<?php
// Views/auth/logout.php

// 1. Mulai Session (agar bisa dihapus)
session_start();

// 2. Hapus semua variabel session
$_SESSION = [];

// 3. Hancurkan session cookie (jika ada)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Hancurkan session di server
session_destroy();

// 5. Redirect ke Login
header("Location: login.php");
exit;
?>