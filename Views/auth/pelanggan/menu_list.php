<?php 
require_once '../../../app/core/assets/config.php'; 

if (class_exists('MenuModel')) {
    $menuModel = new MenuModel();
    $menus = $menuModel->getAllMenu();
} else {
    $menus = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu - e-Kantin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../app/core/assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm py-2">
    <div class="container">
        <a class="navbar-brand fw-bold fs-6" href="#">
            <i class="bi bi-shop-window me-1"></i>e-Kantin
        </a>
        
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-light position-relative rounded-pill px-3 py-1 btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                <i class="bi bi-cart3" id="cartIcon"></i> 
                <span class="d-none d-md-inline ms-1 small">Keranjang</span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark border border-light" id="cartCount">0</span>
            </button>

            <div class="dropdown">
                <a href="#" class="btn btn-link text-white text-decoration-none dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                    <div class="bg-white text-success rounded-circle d-flex justify-content-center align-items-center me-1" style="width: 30px; height: 30px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="d-none d-md-inline small fw-bold">
                        <?= htmlspecialchars($_SESSION['username'] ?? 'Akun') ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                    <li>
                        <a class="dropdown-item py-2" href="profile.php">
                            <i class="bi bi-gear me-2 text-secondary"></i> Edit Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item py-2 text-danger" href="../login.php">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            </div>
    </div>
</nav>

<div class="hero-banner animate__animated animate__fadeIn">
    <div class="container text-center">
        <h1 class="hero-title mb-2">Mau Makan Apa?</h1>
        <p class="small mb-3 opacity-75">Pesan makanan favoritmu tanpa antre.</p>
        <div class="row justify-content-center search-container">
            <div class="col-md-6 col-lg-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text border-0"><i class="bi bi-search text-success"></i></span>
                    <input type="text" id="txtSearch" class="form-control border-0" placeholder="Cari menu..." onkeyup="filterMenu()">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="d-flex justify-content-center mb-4 gap-2">
        <button class="btn btn-success rounded-pill px-3 py-1 btn-sm shadow-sm" onclick="filterCategory('all')">Semua</button>
        <button class="btn btn-light text-secondary rounded-pill px-3 py-1 btn-sm shadow-sm border" onclick="filterCategory('Makanan')">Makanan</button>
        <button class="btn btn-light text-secondary rounded-pill px-3 py-1 btn-sm shadow-sm border" onclick="filterCategory('Minuman')">Minuman</button>
    </div>

    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3" id="menuContainer">
        <?php if(empty($menus)): ?>
            <div class="col-12 text-center py-5"><h6 class="text-muted">Menu kosong.</h6></div>
        <?php else: ?>
            <?php foreach($menus as $m): ?>
            <div class="col menu-item animate__animated animate__fadeInUp" data-category="<?= htmlspecialchars($m['kategori']) ?>">
                <div class="card card-menu shadow-sm h-100">
                    <span class="badge-category"><?= htmlspecialchars($m['kategori']) ?></span>
                    <img src="https://placehold.co/300x200/e67e22/ffffff?text=<?= urlencode($m['nama_menu']) ?>&font=roboto" class="card-img-top">
                    
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title text-truncate"><?= htmlspecialchars($m['nama_menu']) ?></h6>
                        <p class="text-muted small mb-2" style="font-size: 0.75rem;">Stok: <?= $m['stok'] ?></p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="price-tag small">Rp <?= number_format($m['harga'], 0, ',', '.') ?></span>
                            
                            <button class="btn-add shadow-sm" onclick="addToCartJS(<?= $m['id_menu'] ?>, '<?= htmlspecialchars($m['nama_menu'], ENT_QUOTES) ?>', <?= $m['harga'] ?>)">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-cart" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header p-3">
        <h5 class="offcanvas-title fs-6"><i class="bi bi-basket me-2"></i>Keranjang Pesanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div id="emptyCartMsg" class="text-center py-5 text-muted">
            <i class="bi bi-cart-x fs-1 opacity-25"></i>
            <p class="small mt-2">Belum ada pesanan.</p>
        </div>
        <div id="cartList" class="pb-5"></div>
    </div>
    <div class="p-3 border-top bg-white">
        <div class="d-flex justify-content-between mb-3">
            <span class="fw-bold">Total:</span>
            <span class="fw-bold text-success" id="cartTotal">Rp 0</span>
        </div>
        <button class="btn btn-success w-100 rounded-pill shadow-sm" id="btnCheckout" onclick="processCheckout()" disabled>
            Checkout Sekarang <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // --- Javascript Logic ---
    let cart = [];

    // Fungsi Tambah ke Keranjang
    function addToCartJS(id, nama, harga) {
        let item = cart.find(i => i.id === id);
        if (item) {
            item.qty++;
        } else {
            cart.push({ id, nama, harga, qty: 1 });
        }
        updateCartUI();
        triggerShakeAnimation();
        
        // Opsional: Buka otomatis keranjang saat tambah
        // var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasCart'));
        // bsOffcanvas.show();
    }

    function changeQty(id, delta) {
        let item = cart.find(i => i.id === id);
        if (item) {
            item.qty += delta;
            if (item.qty <= 0) removeFromCart(id);
            else updateCartUI();
        }
    }

    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        updateCartUI();
    }

    function updateCartUI() {
        const list = document.getElementById('cartList');
        const emptyMsg = document.getElementById('emptyCartMsg');
        const badge = document.getElementById('cartCount');
        const totalLabel = document.getElementById('cartTotal');
        const btnCheckout = document.getElementById('btnCheckout');
        
        list.innerHTML = '';
        let total = 0;
        let count = 0;

        if (cart.length === 0) {
            emptyMsg.style.display = 'block';
            btnCheckout.disabled = true;
        } else {
            emptyMsg.style.display = 'none';
            btnCheckout.disabled = false;

            cart.forEach(item => {
                total += item.harga * item.qty;
                count += item.qty;
                
                list.innerHTML += `
                <div class="cart-item d-flex align-items-center gap-3 animate__animated animate__fadeIn">
                    <img src="https://placehold.co/100x100/e67e22/ffffff?text=${encodeURI(item.nama)}" class="cart-item-img">
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-bold text-truncate small">${item.nama}</div>
                        <div class="text-success small fw-bold">Rp ${item.harga.toLocaleString('id-ID')}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        ${item.qty === 1 
                            ? `<button class="btn-qty btn-trash text-danger border-danger" onclick="removeFromCart(${item.id})"><i class="bi bi-trash"></i></button>`
                            : `<button class="btn-qty" onclick="changeQty(${item.id}, -1)"><i class="bi bi-dash"></i></button>`
                        }
                        <span class="small fw-bold" style="width:15px; text-align:center">${item.qty}</span>
                        <button class="btn-qty" onclick="changeQty(${item.id}, 1)"><i class="bi bi-plus"></i></button>
                    </div>
                </div>`;
            });
        }
        badge.innerText = count;
        totalLabel.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    function triggerShakeAnimation() {
        const icon = document.getElementById('cartIcon');
        icon.classList.remove('cart-animate');
        void icon.offsetWidth; 
        icon.classList.add('cart-animate');
    }

    // Fungsi Checkout (Pindah Halaman)
    function processCheckout() {
        const btn = document.getElementById('btnCheckout');
        
        if (cart.length === 0) {
            Swal.fire('Ups!', 'Keranjang masih kosong.', 'warning');
            return;
        }

        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengalihkan...';
        btn.disabled = true;

        // Kirim data ke PHP Session lalu Redirect
        fetch('/ekantin/app/core/controllers/PesananController.php?action=pre_checkout', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cart: cart })
        })
        .then(response => {
            // Cek jika respon bukan OK (misal 404 atau 500)
            if (!response.ok) {
                throw new Error('Terjadi kesalahan server: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                window.location.href = 'checkout.php';
            } else {
                throw new Error(data.message || 'Gagal memproses checkout');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Tampilkan pesan error agar tahu apa masalahnya
            Swal.fire('Gagal!', 'Terjadi error: ' + error.message, 'error');
            
            // Kembalikan tombol seperti semula
            btn.disabled = false;
            btn.innerHTML = 'Checkout Sekarang <i class="bi bi-arrow-right ms-2"></i>';
        });
    }

    // Filter
    function filterMenu() {
        let input = document.getElementById('txtSearch').value.toLowerCase();
        let items = document.getElementsByClassName('menu-item');
        for (let item of items) {
            let title = item.querySelector('.card-title').innerText.toLowerCase();
            item.style.display = title.includes(input) ? "" : "none";
        }
    }
    function filterCategory(cat) {
        let items = document.getElementsByClassName('menu-item');
        for (let item of items) {
            let itemCat = item.getAttribute('data-category');
            item.style.display = (cat === 'all' || itemCat === cat) ? "" : "none";
        }
    }
</script>

</body>
</html>