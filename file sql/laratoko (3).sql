-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2022 at 08:46 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laratoko`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2022_07_20_165938_create_stock_table', 1),
(3, '2022_07_20_165406_create_transaction_table', 2),
(4, '2022_07_22_123500_create_cart_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `diblokir` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_bergabung` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama_lengkap`, `email`, `password`, `foto`, `superadmin`, `diblokir`, `tanggal_bergabung`) VALUES
('ADM1809251', 'Nuzul', 'miqbal.admin@email.com', '$2y$10$unsKNzWw/QYFD.dZXQtMd.gztNCpV4uHUiZXD7FsG17Kw5F7oZAS6', 'muhammad_iqbal.jpg', 1, 0, '2018-09-25 20:28:55'),
('ADM1810162', 'Dimas Wahyu Pamungkas', 'dimas.admin@email.com', '$2y$10$we4e8UkfpCXeXpWc6/HuTuHKUzsRymBNb2SBrByvpy2GL50gCs4Ue', 'default.png', 0, 0, '2018-10-16 12:08:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_barang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_merk` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_barang` text COLLATE utf8mb4_unicode_ci,
  `berat_barang` double DEFAULT NULL,
  `harga_satuan` int(11) DEFAULT NULL,
  `stok_barang` int(11) DEFAULT NULL,
  `foto_barang` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_barang`, `nama_barang`, `id_kategori`, `id_merk`, `deskripsi_barang`, `berat_barang`, `harga_satuan`, `stok_barang`, `foto_barang`, `tanggal_masuk`) VALUES
('BRG2207211', 'Jagung', 'KTG2207211', 'MRK2207211', NULL, NULL, 12500, 11, NULL, '2022-07-21 13:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_pengguna`
--

CREATE TABLE `tbl_detail_pengguna` (
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_rumah` text COLLATE utf8mb4_unicode_ci,
  `no_telepon` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kecamatan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_detail_pengguna`
--

INSERT INTO `tbl_detail_pengguna` (`id_pengguna`, `nama_lengkap`, `jenis_kelamin`, `alamat_rumah`, `no_telepon`, `id_kecamatan`) VALUES
('PGN1809201', 'Iqbal', 'Pria', 'Jl Karimata Gg. Kaca Piring', '082298277709', 2084),
('PGN2206022', 'Nuzul Zaif Mahdiono R', 'Pria', 'Jl Trunojoyo', '089675925082', 2084);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`, `foto`) VALUES
('KTG2207211', 'Bahan Pokok', 'sembako.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lupa_password`
--

CREATE TABLE `tbl_lupa_password` (
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_dibuat` date NOT NULL,
  `tanggal_dihapus` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_merk`
--

CREATE TABLE `tbl_merk` (
  `id_merk` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_merk` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_merk`
--

INSERT INTO `tbl_merk` (`id_merk`, `nama_merk`) VALUES
('MRK2207211', 'Rose Brand');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int(11) NOT NULL,
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` text COLLATE utf8mb4_unicode_ci,
  `tanggal_bergabung` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `id_pengguna`, `email`, `password`, `remember_token`, `tanggal_bergabung`) VALUES
(1, 'PGN2206022', 'business.mynddigital@gmail.com', '$2y$10$jGiMd.uNqR2KWku1GvRtxeUhPg6pMUwflcaW8HFZ7i5wN0.PDZ6T.', NULL, '2022-06-02 14:38:49'),
(2, 'PGN1809201', 'miqbal.pengguna@email.com', '$2y$10$s71/P0ScgkVsBzLgZq7phO7vYcBrhNJHvTlq0vTvHB/Pbk8.MFe.y', NULL, '2018-09-20 19:00:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock`
--

CREATE TABLE `tbl_stock` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_stok` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_stock`
--

INSERT INTO `tbl_stock` (`id`, `nama`, `tipe_stok`, `jumlah_stok`) VALUES
(1, 'Jagung', 'Barang Mentah', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pesanan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_product` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`id`, `id_pesanan`, `id_pengguna`, `id_product`, `type`, `qty`, `total_bayar`, `created_at`, `updated_at`) VALUES
(1, 'PSN2207221', 'ADM1809251', 'BRG2207211', 'Transaksi Masuk', 1, 12500, '2022-07-22 08:12:11', NULL),
(2, 'PSN2207222', 'ADM1809251', 'BRG2207211', 'Transaksi Keluar', 2, 25000, '2022-07-22 08:19:31', '2022-07-22 08:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verifikasi_akun`
--

CREATE TABLE `tbl_verifikasi_akun` (
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_website`
--

CREATE TABLE `tbl_website` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_website`
--

INSERT INTO `tbl_website` (`id`, `name`, `value`) VALUES
(1, 'title', 'Meubel Jaya'),
(2, 'favicon', 'logo-wa.png'),
(3, 'meta_description', 'KelolaMutasi, Aplikasi Mutasi'),
(4, 'meta_keywords', 'KelolaMutasi, Aplikasi Mutasi'),
(5, 'meta_title', 'Kelola Mutasi Pembayaran'),
(9, 'address', 'Jl Karimata'),
(10, 'phone', '+6289675925082'),
(11, 'email', 'business.mynddigital@gmail.com'),
(12, 'facebook', 'https://facebook.com/'),
(13, 'logo', 'logo-baru.png'),
(14, 'short_description', 'Meubel eStore adalah'),
(15, 'about', '<p>Kelola Mutasi adalah</p>'),
(16, 'jam_kerja', 'Senin - Kamis\r\n10:00 s/d 15:00'),
(17, 'biaya_cod', '12000'),
(18, 'kota', '133'),
(19, 'kurir', '5|2|1|6|3'),
(20, 'payment_transfer', '1'),
(21, 'payment_midtrans', '0'),
(22, 'midtrans_server', 'SB-Mid-server-6Q8_B3pCZ9WowgogE7wXmQWN'),
(23, 'midtrans_client', 'SB-Mid-client-OMZajeYGrYfz-IC9'),
(24, 'midtrans_snap', 'https://app.sandbox.midtrans.com/snap/snap.js'),
(25, 'background-home', 'background.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `tbl_admin_email_unique` (`email`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `tbl_barang_id_kategori_index` (`id_kategori`),
  ADD KEY `id_merk` (`id_merk`);

--
-- Indexes for table `tbl_detail_pengguna`
--
ALTER TABLE `tbl_detail_pengguna`
  ADD UNIQUE KEY `tbl_detail_pengguna_id_pengguna_unique` (`id_pengguna`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_lupa_password`
--
ALTER TABLE `tbl_lupa_password`
  ADD UNIQUE KEY `tbl_lupa_password_email_unique` (`email`);

--
-- Indexes for table `tbl_merk`
--
ALTER TABLE `tbl_merk`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_pengguna_email_unique` (`email`);

--
-- Indexes for table `tbl_stock`
--
ALTER TABLE `tbl_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_stock`
--
ALTER TABLE `tbl_stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
