function addToCart(id, nama, harga) {
    // Simulasi penambahan ke session via fetch
    fetch('../../app/controllers/CartHandler.php', {
        method: 'POST',
        body: JSON.stringify({ id, nama, harga })
    })
    .then(res => res.json())
    .then(data => {
        // Animasi update jumlah keranjang di navbar
        const badge = document.querySelector('.badge');
        badge.innerText = data.totalItems;
        badge.classList.add('animate__animated', 'animate__rubberBand');
        
        // Hapus class animasi setelah selesai agar bisa diulang
        setTimeout(() => badge.classList.remove('animate__rubberBand'), 1000);
    });
}