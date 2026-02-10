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
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top shadow-sm py-2">
    <div class="container">
        <a class="navbar-brand fw-bold fs-6" href="#">
            <i class="bi bi-shop-window me-1"></i>e-Kantin
        </a>
        
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-light position-relative rounded-pill px-3 py-1 btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                <i class="bi bi-cart3" id="cartIcon" style="display: inline-block;"></i> 
                <span class="d-none d-md-inline ms-1 small">Keranjang</span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark border border-light" id="cartCount">
                    0
                </span>
            </button>
            <a href="../login.php" class="btn btn-link text-white ms-2" title="Keluar">
                <i class="bi bi-box-arrow-right"></i>
            </a>
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
                            <button class="btn-add shadow-sm" onclick="addToCartJS(<?= $m['id_menu'] ?>, '<?= htmlspecialchars($m['nama_menu']) ?>', <?= $m['harga'] ?>)">
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
        <button class="btn btn-success w-100 rounded-pill shadow-sm" id="btnCheckout" disabled>
            Checkout Sekarang
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // --- LOGIC KERANJANG (JAVASCRIPT) ---
    let cart = [];

    // 1. Tambah ke Keranjang (Dari Menu)
    function addToCartJS(id, nama, harga) {
        let item = cart.find(i => i.id === id);
        if (item) {
            item.qty++;
        } else {
            cart.push({ id, nama, harga, qty: 1 });
        }
        updateCartUI();
        triggerShakeAnimation();
    }

    // 2. Ubah Jumlah (+/-)
    function changeQty(id, delta) {
        let item = cart.find(i => i.id === id);
        if (item) {
            item.qty += delta;
            if (item.qty <= 0) {
                removeFromCart(id); // Hapus jika 0
            } else {
                updateCartUI();
            }
        }
    }

    // 3. Hapus Item (Sampah)
    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        updateCartUI();
    }

    // 4. Update Tampilan Keranjang
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
                
                // HTML Item Keranjang dengan Tombol +/-/Hapus
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
                </div>
                `;
            });
        }
        
        badge.innerText = count;
        totalLabel.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    // 5. Animasi Shake Ikon Keranjang
    function triggerShakeAnimation() {
        const icon = document.getElementById('cartIcon');
        const badge = document.getElementById('cartCount');
        
        icon.classList.remove('cart-animate');
        badge.classList.remove('animate__animated', 'animate__bounceIn');
        
        void icon.offsetWidth; // Trigger reflow
        
        icon.classList.add('cart-animate');
        badge.classList.add('animate__animated', 'animate__bounceIn');
    }

    // 6. Filter Menu (Pencarian)
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

    <?php
require_once __DIR__ . '/../assets/config.php';

class PesananController {
    private $pesananModel;
    private $menuModel;

    public function __construct() {
        $this->pesananModel = new PesananModel();
        $this->menuModel = new MenuModel();
    }

    // 1. Simpan Keranjang JS ke Session PHP
    public function preCheckout() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!empty($data['cart'])) {
            $_SESSION['final_cart'] = $data['cart']; // Simpan ke session
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Keranjang kosong']);
        }
    }

    // 2. Proses Pesanan Akhir (Dari Halaman Checkout)
    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id']) || empty($_SESSION['final_cart'])) {
                header("Location: ../../../Views/auth/pelanggan/menu_list.php");
                exit;
            }

            $id_user = $_SESSION['user_id'];
            $cart = $_SESSION['final_cart'];
            $metode = $_POST['metode_pembayaran']; // Ambil dari form
            $total_bayar = 0;

            foreach ($cart as $item) {
                $total_bayar += $item['harga'] * $item['qty'];
            }

            // Simpan ke DB dengan Metode Pembayaran
            $id_pesanan = $this->pesananModel->createPesanan($id_user, $total_bayar, $metode);

            if ($id_pesanan) {
                foreach ($cart as $item) {
                    $subtotal = $item['harga'] * $item['qty'];
                    $this->pesananModel->createDetail($id_pesanan, $item['id'], $item['qty'], $subtotal);
                    $this->menuModel->updateStok($item['id'], $item['qty']);
                }
                
                // Hapus session keranjang
                unset($_SESSION['final_cart']);
                
                // Redirect Sukses
                echo "<script>
                        alert('Pesanan Berhasil! Metode: $metode');
                        window.location = '../../../Views/auth/pelanggan/menu_list.php';
                      </script>";
            }
        }
    }
}

// Router Sederhana
if (isset($_GET['action'])) {
    $controller = new PesananController();
    if ($_GET['action'] == 'pre_checkout') {
        $controller->preCheckout();
    } elseif ($_GET['action'] == 'process_order') {
        $controller->processOrder();
    }
}
?>
</script>

</body>
</html>