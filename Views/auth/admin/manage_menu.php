<?php 
include_once '../../../app/core/assets/config.php'; 
$menuModel = new MenuModel();
$menus = $menuModel->getAllMenu();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container mt-5 animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Manajemen Stok Menu</h2>
        <button class="btn btn-primary rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Menu Baru
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($menus as $m): ?>
                    <tr class="animate__animated animate__fadeIn">
                        <td class="ps-4 fw-bold"><?= $m['nama_menu'] ?></td>
                        <td><span class="badge bg-info text-dark"><?= $m['kategori'] ?></span></td>
                        <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                        <td><?= $m['stok'] ?> porsi</td>
                        <td class="text-center">
                            <a href="../../app/controllers/MenuController.php?action=hapus&id=<?= $m['id_menu'] ?>" 
                               class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Hapus menu ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Form Tambah Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../../../app/core/controllers/MenuController.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                    </div>
                    <input type="hidden" name="gambar" value="default.jpg">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-success w-100">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>