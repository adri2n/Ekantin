<?php
// File: app/core/reset_password.php
require_once 'assets/config.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

// Password baru yang kita inginkan
$pass_baru = '123456';
// Ubah menjadi hash aman
$pass_hash = password_hash($pass_baru, PASSWORD_DEFAULT);

// Update password untuk admin dan pelanggan
$sql_admin = "UPDATE users SET password = '$pass_hash' WHERE username = 'admin_kantin'";
$sql_user = "UPDATE users SET password = '$pass_hash' WHERE username = 'budi_pelanggan'";

if ($db->query($sql_admin) === TRUE && $db->query($sql_user) === TRUE) {
    echo "<h1>Berhasil!</h1>";
    echo "Password untuk <b>admin_kantin</b> dan <b>budi_pelanggan</b> sekarang adalah: <b>123456</b>";
    echo "<br><br><a href='/ekantin/Views/auth/login.php'>Klik disini untuk Login</a>";
} else {
    echo "Gagal mengubah password: " . $db->error;
}
?>