-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Feb 2026 pada 00.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ekantin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `jumlah` int(5) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_menu`, `jumlah`, `subtotal`) VALUES
(3, 1, 1, 2, 30000.00),
(4, 3, 2, 1, 5000.00),
(5, 3, 4, 1, 18000.00),
(6, 4, 6, 1, 18000.00),
(7, 4, 5, 1, 18000.00),
(8, 5, 5, 1, 18000.00),
(9, 5, 6, 1, 18000.00),
(10, 5, 2, 1, 5000.00),
(11, 6, 1, 1, 15000.00),
(12, 6, 2, 1, 5000.00),
(13, 6, 7, 1, 5000.00),
(14, 7, 1, 1, 15000.00),
(15, 7, 2, 1, 5000.00),
(16, 7, 7, 1, 5000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(5) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `stok`, `gambar`, `kategori`) VALUES
(1, 'Nasi Goreng Kantin', 15000.00, 48, 'default.jpg', 'Makanan'),
(2, 'Es Teh Manis', 5000.00, 96, 'default.jpg', 'Minuman'),
(4, 'Nasi Ayam', 18000.00, 9, 'default.jpg', 'Makanan'),
(5, 'Nasi Ayam Bakar', 18000.00, 18, 'default.jpg', 'Makanan'),
(6, 'ikan bakar', 18000.00, 18, 'default.jpg', 'Makanan'),
(7, 'Air Mineral', 5000.00, 98, NULL, 'Minuman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tgl_pesanan` datetime DEFAULT NULL,
  `total_bayar` decimal(10,2) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `status` enum('pending','proses','siap','selesai','batal') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `tgl_pesanan`, `total_bayar`, `metode_pembayaran`, `status`) VALUES
(1, 1, '2026-02-11 03:54:05', 30000.00, NULL, 'selesai'),
(2, 1, '2026-02-11 03:54:15', 30000.00, NULL, 'selesai'),
(3, 2, '2026-02-10 23:28:50', 23000.00, 'QRIS', 'selesai'),
(4, 2, '2026-02-11 00:00:21', 36000.00, 'Tunai', 'selesai'),
(5, 3, '2026-02-11 00:07:45', 41000.00, 'E-Wallet', 'selesai'),
(6, 3, '2026-02-11 00:25:41', 25000.00, 'Transfer Bank', 'selesai'),
(7, 4, '2026-02-11 00:33:50', 25000.00, 'QRIS', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin_kantin', '$2y$10$oZTUdCfJMdkzl/plW3xJregp.WkJBoV4MQYOu0Yi/xugPjpsHZnsW', 'admin'),
(2, 'Budi', '$2y$10$Sqj0umPwH5kgAqfcrBPXrei/5HJTzHRmBGDZn.oM7c7/JXSyod0ci', 'pelanggan'),
(3, 'Sarah', '$2y$10$tz4utRvgpOuk0/CkXFqc9e3mJA5BOukTVts0u3br264U84yWpI3Py', 'pelanggan'),
(4, 'farhan', '$2y$10$YooyOVDj7zZoZcT.PZayUeaher/gC5sGIMCmjHrV6IieKQVmtfpPi', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
