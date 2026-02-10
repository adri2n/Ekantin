<?php require_once '../../../app/core/assets/config.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container mt-5 animate__animated animate__fadeIn">
    <h2 class="fw-bold mb-4">🛒 Keranjang Belanja Anda</h2>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/80" class="rounded-3 me-3">
                            <div>
                                <h6 class="fw-bold mb-0">Nasi Goreng</h6>
                                <small class="text-muted">Rp 15.000 x 2</small>
                            </div>
                        </div>
                        <p class="fw-bold mb-0 text-success">Rp 30.000</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 bg-success text-white p-3">
                <h5 class="fw-bold">Ringkasan Pesanan</h5>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>Rp 30.000</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Biaya Layanan</span>
                    <span>Gratis</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span>Rp 30.000</span>
                </div>
                <button onclick="prosesCheckout()" class="btn btn-light text-success fw-bold w-100 mt-4 py-2 rounded-pill shadow">
                    Konfirmasi & Pesan Sekarang
                </button>
            </div>
        </div>
    </div>
</div>