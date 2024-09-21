-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jul 2024 pada 09.45
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
-- Database: `restoran_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detiltransaksi`
--

CREATE TABLE `detiltransaksi` (
  `id` int(11) NOT NULL,
  `idtransaksi` int(11) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detiltransaksi`
--

INSERT INTO `detiltransaksi` (`id`, `idtransaksi`, `idmenu`, `jumlah`) VALUES
(1, 1, 2, 2),
(2, 1, 8, 2),
(3, 2, 1, 3),
(4, 2, 10, 2),
(5, 3, 2, 1),
(6, 3, 7, 1),
(7, 4, 3, 2),
(8, 5, 1, 2),
(9, 5, 6, 2),
(10, 6, 2, 4),
(11, 6, 6, 1),
(12, 6, 7, 2),
(13, 6, 8, 1),
(14, 7, 3, 5),
(15, 7, 6, 1),
(16, 7, 8, 2),
(17, 7, 9, 1),
(18, 7, 10, 1),
(19, 8, 4, 10),
(20, 8, 6, 2),
(21, 8, 7, 1),
(22, 8, 8, 5),
(23, 8, 9, 2),
(24, 9, 5, 2),
(25, 9, 6, 2),
(26, 10, 1, 1),
(27, 10, 5, 1),
(28, 10, 10, 2),
(29, 11, 2, 1),
(30, 11, 4, 1),
(31, 11, 9, 2),
(32, 12, 3, 3),
(33, 12, 4, 1),
(34, 12, 8, 4),
(35, 13, 4, 5),
(36, 13, 6, 5),
(37, 14, 2, 5),
(38, 14, 3, 5),
(39, 14, 4, 5),
(40, 14, 6, 10),
(41, 14, 7, 1),
(42, 14, 8, 2),
(43, 14, 9, 2),
(44, 15, 1, 1),
(45, 15, 2, 1),
(46, 15, 5, 2),
(47, 15, 7, 2),
(48, 15, 10, 2),
(49, 16, 3, 4),
(50, 16, 6, 2),
(51, 16, 8, 2),
(52, 17, 5, 2),
(53, 17, 6, 2),
(54, 18, 1, 2),
(55, 18, 2, 2),
(56, 18, 3, 2),
(57, 18, 4, 2),
(58, 18, 5, 2),
(59, 18, 6, 4),
(60, 18, 8, 4),
(61, 18, 9, 2),
(62, 19, 3, 2),
(63, 19, 6, 2),
(64, 21, 1, 2),
(65, 21, 2, 2),
(66, 21, 6, 2),
(67, 21, 7, 2),
(68, 22, 1, 2),
(69, 22, 7, 2),
(70, 23, 2, 1),
(71, 23, 3, 1),
(72, 23, 9, 2),
(73, 24, 1, 2),
(74, 24, 6, 2),
(75, 25, 1, 2),
(76, 25, 6, 2),
(77, 26, 3, 1),
(78, 26, 8, 1),
(79, 27, 8, 1),
(80, 28, 1, 2),
(81, 28, 6, 2),
(82, 29, 1, 2),
(83, 29, 2, 2),
(84, 29, 8, 4),
(85, 30, 7, 6),
(86, 31, 3, 1),
(87, 31, 8, 1),
(88, 32, 3, 2),
(89, 32, 8, 2),
(90, 33, 1, 4),
(91, 33, 2, 1),
(92, 33, 3, 4),
(93, 33, 6, 4),
(94, 33, 7, 1),
(95, 33, 8, 4),
(96, 34, 4, 10),
(97, 34, 6, 5),
(98, 34, 8, 4),
(99, 34, 9, 1),
(100, 35, 3, 2),
(101, 35, 8, 2),
(102, 36, 1, 2),
(103, 36, 2, 2),
(104, 36, 7, 4),
(105, 37, 7, 2),
(106, 38, 1, 2),
(107, 38, 7, 2),
(108, 39, 1, 2),
(109, 39, 6, 2),
(110, 40, 2, 2),
(111, 40, 7, 2),
(112, 41, 8, 1),
(113, 42, 2, 2),
(114, 43, 2, 2),
(115, 43, 6, 2),
(116, 44, 1, 2),
(117, 44, 7, 2),
(118, 45, 2, 2),
(119, 46, 3, 2),
(120, 46, 8, 2),
(121, 47, 1, 1),
(122, 47, 2, 1),
(123, 47, 8, 1),
(124, 48, 2, 1),
(125, 49, 4, 2),
(126, 50, 1, 1),
(127, 50, 2, 2),
(128, 50, 5, 1),
(129, 50, 6, 3),
(130, 50, 7, 1),
(131, 50, 8, 3),
(132, 51, 1, 2),
(133, 51, 8, 2),
(134, 52, 2, 1),
(135, 52, 9, 1),
(136, 53, 2, 1),
(137, 53, 7, 1),
(138, 54, 2, 1),
(139, 54, 7, 1),
(140, 55, 2, 2),
(141, 55, 7, 2),
(142, 56, 1, 2),
(143, 56, 8, 2),
(144, 57, 2, 2),
(145, 57, 7, 2),
(146, 59, 4, 2),
(147, 59, 9, 2),
(148, 60, 1, 2),
(149, 60, 7, 2),
(150, 61, 2, 2),
(151, 61, 6, 2),
(152, 62, 1, 1),
(153, 62, 6, 1),
(154, 63, 1, 1),
(155, 63, 2, 2),
(156, 63, 4, 1),
(157, 63, 6, 1),
(158, 63, 8, 2),
(159, 64, 1, 2),
(160, 64, 6, 2),
(161, 65, 2, 1),
(162, 65, 6, 1),
(163, 66, 1, 2),
(164, 66, 6, 2),
(165, 67, 1, 2),
(166, 67, 9, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` enum('makanan','minuman') NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(10) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `nama`, `kategori`, `harga`, `stok`, `gambar`) VALUES
(1, 'Nasi rames', 'makanan', 10000.00, 25, 'images/nasi_rames.jpg'),
(2, 'Rice Bowl Black Paper', 'makanan', 18000.00, 25, 'images/ricebowl_blackpaper.jpg'),
(3, 'Ayam Nashville', 'makanan', 25000.00, 25, 'images/ayam_nashville.jpg'),
(4, 'Nasi Ayam Katsu', 'makanan', 22000.00, 25, 'images/nasi_ayam_katsu.jpg'),
(5, 'Mie Ayam', 'makanan', 15000.00, 25, 'images/mieayam.jpg'),
(6, 'Es Teh', 'minuman', 5000.00, 25, 'images/es_teh.jpg'),
(7, 'Air Es', 'minuman', 3000.00, 25, 'images/air_es.jpg'),
(8, 'Es Milo', 'minuman', 9000.00, 25, 'images/es_milo.jpg'),
(9, 'Es Nutrisari Anggur', 'minuman', 8000.00, 25, 'images/es_nutrisari_anggur.jpg'),
(10, 'Es Teh Leci', 'minuman', 10000.00, 25, 'images/es_teh_leci.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('diproses','selesai') NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `status`, `total`) VALUES
(1, '2024-06-23', 'selesai', 60000.00),
(2, '2024-06-23', 'selesai', 66000.00),
(3, '2024-06-23', 'selesai', 21000.00),
(4, '2024-06-23', 'selesai', 50000.00),
(5, '2024-06-24', 'selesai', 50000.00),
(6, '2024-06-24', 'selesai', 92000.00),
(7, '2024-06-24', 'selesai', 166000.00),
(8, '2024-06-24', 'selesai', 294000.00),
(9, '2024-06-24', 'selesai', 40000.00),
(10, '2024-06-25', 'selesai', 55000.00),
(11, '2024-06-25', 'selesai', 56000.00),
(12, '2024-06-25', 'selesai', 133000.00),
(13, '2024-06-25', 'selesai', 135000.00),
(14, '2024-06-25', 'selesai', 412000.00),
(15, '2024-06-25', 'selesai', 94000.00),
(16, '2024-06-25', 'selesai', 128000.00),
(17, '2024-06-25', 'selesai', 40000.00),
(18, '2024-06-25', 'selesai', 272000.00),
(19, '2024-06-25', 'selesai', 60000.00),
(20, '2024-06-25', 'selesai', 0.00),
(21, '2024-06-25', 'selesai', 92000.00),
(22, '2024-06-26', 'selesai', 46000.00),
(23, '2024-06-26', 'selesai', 59000.00),
(24, '2024-06-26', 'selesai', 50000.00),
(25, '2024-06-27', 'selesai', 50000.00),
(26, '2024-06-27', 'selesai', 34000.00),
(27, '2024-06-27', 'selesai', 9000.00),
(28, '2024-06-27', 'selesai', 50000.00),
(29, '2024-06-27', 'selesai', 112000.00),
(30, '2024-06-27', 'selesai', 18000.00),
(31, '2024-06-27', 'selesai', 34000.00),
(32, '2024-07-01', 'selesai', 68000.00),
(33, '2024-07-01', 'selesai', 257000.00),
(34, '2024-07-01', 'selesai', 289000.00),
(35, '2024-07-01', 'selesai', 68000.00),
(36, '2024-07-01', 'selesai', 88000.00),
(37, '2024-07-01', 'selesai', 6000.00),
(38, '2024-07-01', 'selesai', 46000.00),
(39, '2024-07-01', 'selesai', 50000.00),
(40, '2024-07-02', 'selesai', 42000.00),
(41, '2024-07-03', 'selesai', 9000.00),
(42, '2024-07-03', 'selesai', 36000.00),
(43, '2024-07-03', 'selesai', 46000.00),
(44, '2024-07-04', 'selesai', 46000.00),
(45, '2024-07-04', 'selesai', 36000.00),
(46, '2024-07-04', 'selesai', 68000.00),
(47, '2024-07-04', 'selesai', 47000.00),
(48, '2024-07-04', 'selesai', 18000.00),
(49, '2024-07-04', 'selesai', 44000.00),
(50, '2024-07-04', 'selesai', 116000.00),
(51, '2024-07-04', 'selesai', 58000.00),
(52, '2024-07-04', 'selesai', 26000.00),
(53, '2024-07-04', 'selesai', 21000.00),
(54, '2024-07-04', 'selesai', 21000.00),
(55, '2024-07-04', 'selesai', 42000.00),
(56, '2024-07-04', 'selesai', 58000.00),
(57, '2024-07-04', 'selesai', 42000.00),
(58, '2024-07-04', 'diproses', 0.00),
(59, '2024-07-04', 'selesai', 60000.00),
(60, '2024-07-04', 'selesai', 46000.00),
(61, '2024-07-04', 'selesai', 46000.00),
(62, '2024-07-04', 'selesai', 25000.00),
(63, '2024-07-04', 'selesai', 101000.00),
(64, '2024-07-04', 'selesai', 50000.00),
(65, '2024-07-04', 'selesai', 23000.00),
(66, '2024-07-06', 'selesai', 30000.00),
(67, '2024-07-08', 'selesai', 36000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('kasir','manager','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'kasir', '123', 'kasir'),
(2, 'manager', '123', 'manager'),
(3, 'customer', '123', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detiltransaksi`
--
ALTER TABLE `detiltransaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtransaksi` (`idtransaksi`),
  ADD KEY `idmenu` (`idmenu`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detiltransaksi`
--
ALTER TABLE `detiltransaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detiltransaksi`
--
ALTER TABLE `detiltransaksi`
  ADD CONSTRAINT `detiltransaksi_ibfk_1` FOREIGN KEY (`idtransaksi`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `detiltransaksi_ibfk_2` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
