<?php
require_once '../assets/config.php';

class MenuController {
    private $model;

    public function __construct() {
        $this->model = new MenuModel();
    }

    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nama' => $_POST['nama_menu'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok'],
                'kategori' => $_POST['kategori'],
                'gambar' => $_POST['gambar'] // Sederhananya kita input path teks dulu
            ];
            if ($this->model->insertMenu($data)) {
                header("Location: ../../views/admin/manage_menu.php?status=success");
            }
        }
    }

    public function hapus($id) {
        if ($this->model->deleteMenu($id)) {
            header("Location: ../../views/admin/manage_menu.php?status=deleted");
        }
    }
}

// Handler Request
$controller = new MenuController();
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $controller->hapus($_GET['id']);
} elseif (isset($_POST['tambah'])) {
    $controller->tambah();
}
?>