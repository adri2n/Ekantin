<?php 
require_once '../../config.php';
$menuModel = new MenuModel();
$laporan = $menuModel->getLaporanPenjualan();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container mt-5">
    <div class="card border-0 shadow-lg animate__animated animate__fadeIn">
        <div class="card-header bg-dark text-white p-3">
            <h4 class="mb-0 fw-bold">📈 Laporan Penjualan Terlaris</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Menu</th>
                            <th class="text-center">Total Terjual</th>
                            <th class="text-end">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($laporan as $row): ?>
                        <tr class="animate__animated animate__slideInUp">
                            <td class="fw-bold text-dark"><?= $row['nama_menu'] ?></td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill"><?= $row['total_terjual'] ?> Porsi</span>
                            </td>
                            <td class="text-end fw-bold text-success">
                                Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>