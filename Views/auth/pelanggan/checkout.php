<?php 
require_once '../../../app/core/assets/config.php'; 

// Cek akses
if (!isset($_SESSION['user_id']) || empty($_SESSION['final_cart'])) {
    header("Location: menu_list.php");
    exit;
}

$cart = $_SESSION['final_cart'];
$total = 0;
foreach ($cart as $item) {
    $total += $item['harga'] * $item['qty'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - e-Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        .payment-option { cursor: pointer; transition: 0.2s; }
        .payment-option:hover { background-color: #e9ecef; }
        .payment-radio:checked + label { border-color: #198754; background-color: #d1e7dd; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-cart-check"></i> Konfirmasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Ringkasan Menu</h6>
                    <ul class="list-group mb-3">
                        <?php foreach($cart as $item): ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0"><?= htmlspecialchars($item['nama']) ?></h6>
                                <small class="text-muted"><?= $item['qty'] ?> x Rp <?= number_format($item['harga'],0,',','.') ?></small>
                            </div>
                            <span class="text-muted">Rp <?= number_format($item['harga'] * $item['qty'], 0,',','.') ?></span>
                        </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span class="fw-bold">Total Pembayaran (IDR)</span>
                            <span class="fw-bold text-success">Rp <?= number_format($total, 0,',','.') ?></span>
                        </li>
                    </ul>

                    <form action="../../../app/core/controllers/PesananController.php?action=process_order" method="POST">
                        <h6 class="fw-bold mb-3">Pilih Metode Pembayaran</h6>
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="metode_pembayaran" id="qris" value="QRIS" required>
                                <label class="btn btn-outline-secondary w-100 h-100 py-3 d-flex flex-column align-items-center gap-2" for="qris">
                                    <i class="bi bi-qr-code-scan fs-1"></i>
                                    <span>QRIS</span>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="metode_pembayaran" id="tunai" value="Tunai">
                                <label class="btn btn-outline-secondary w-100 h-100 py-3 d-flex flex-column align-items-center gap-2" for="tunai">
                                    <i class="bi bi-cash-stack fs-1"></i>
                                    <span>Tunai (Kasir)</span>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="metode_pembayaran" id="ewallet" value="E-Wallet">
                                <label class="btn btn-outline-secondary w-100 h-100 py-3 d-flex flex-column align-items-center gap-2" for="ewallet">
                                    <i class="bi bi-wallet2 fs-1"></i>
                                    <span>E-Wallet (Gopay/OVO)</span>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="metode_pembayaran" id="bank" value="Transfer Bank">
                                <label class="btn btn-outline-secondary w-100 h-100 py-3 d-flex flex-column align-items-center gap-2" for="bank">
                                    <i class="bi bi-bank fs-1"></i>
                                    <span>Transfer Bank</span>
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="menu_list.php" class="btn btn-light">Kembali</a>
                            <button class="btn btn-success btn-lg px-5" type="submit">
                                Bayar Sekarang <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>