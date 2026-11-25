-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Nov 2026 pada 07.03
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
-- Database: `dbauction`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbadmin`
--

CREATE TABLE `tbadmin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbadmin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbbarang`
--

CREATE TABLE `tbbarang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `deskripsi_barang` varchar(256) NOT NULL,
  `harga_awal` double NOT NULL,
  `harga_bids` double DEFAULT NULL,
  `harga_akhir` double DEFAULT NULL,
  `harga_buyout` double NOT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `status_lelang` varchar(50) NOT NULL DEFAULT 'pending',
  `id_pemilik` int(11) DEFAULT NULL,
  `foto_barang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbbarang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpembayaran`
--

CREATE TABLE `tbpembayaran` (
  `id_pembayaran` varchar(3) NOT NULL,
  `status_pembayaran` varchar(10) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `id_pembeli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbuser`
--

CREATE TABLE `tbuser` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_rekening` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbuser`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bid`
--

CREATE TABLE `tb_bid` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `bid_amount` decimal(50,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_bid`
--

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbadmin`
--
ALTER TABLE `tbadmin`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY (`nama`);

--
-- Indeks untuk tabel `tbbarang`
--
ALTER TABLE `tbbarang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tbbarang_tbuser` (`id_pemilik`);

--
-- Indeks untuk tabel `tbpembayaran`
--
ALTER TABLE `tbpembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `fk_tbpembayaran_tbuser` (`id_pembeli`);

--
-- Indeks untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY (`nama`);

--
-- Indeks untuk tabel `tb_bid`
--
ALTER TABLE `tb_bid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbadmin`
--
ALTER TABLE `tbadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbbarang`
--
ALTER TABLE `tbbarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_bid`
--
ALTER TABLE `tb_bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbbarang`
--
ALTER TABLE `tbbarang`
  ADD CONSTRAINT `fk_tbbarang_tbuser` FOREIGN KEY (`id_pemilik`) REFERENCES `tbuser` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbpembayaran`
--
ALTER TABLE `tbpembayaran`
  ADD CONSTRAINT `fk_tbpembayaran_tbuser` FOREIGN KEY (`id_pembeli`) REFERENCES `tbuser` (`id`);

--
-- Ketidakleluasaan untuk tabel `tb_bid`
--
ALTER TABLE `tb_bid`
  ADD CONSTRAINT `tb_bid_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tbbarang` (`id`), ADD CONSTRAINT `fk_bid_user` FOREIGN KEY (`user_id`) REFERENCES `tbuser` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
