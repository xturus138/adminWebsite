-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 01:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `isi_pesanan`
--

CREATE TABLE `isi_pesanan` (
  `no_menu` int(11) NOT NULL,
  `no_pesanan` int(11) NOT NULL,
  `jumlah` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `isi_pesanan`
--

INSERT INTO `isi_pesanan` (`no_menu`, `no_pesanan`, `jumlah`) VALUES
(2, 1, 2),
(4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `no_meja` int(11) NOT NULL,
  `status_meja` varchar(15) NOT NULL,
  `kapasitas` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `no_menu` int(11) NOT NULL,
  `status_menu` varchar(15) NOT NULL,
  `nama_menu` varchar(16) NOT NULL,
  `stok` int(3) NOT NULL,
  `harga` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`no_menu`, `status_menu`, `nama_menu`, `stok`, `harga`) VALUES
(1, 'tunda', 'Babi Bakar', 0, 30000.00),
(2, 'setuju', 'Ayam Bakar', 200, 15000.00),
(3, 'tunda', 'Soto Ayam', 0, 12000.00),
(4, 'setuju', 'Cangkalang', 100, 17000.00),
(5, 'setuju', 'Sosis Bakar', 50, 12000.00),
(6, 'setuju', 'Sayur Bakar', 3, 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `no_id` int(11) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `jabatan` varchar(10) NOT NULL,
  `password` varchar(16) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`no_id`, `no_telp`, `jabatan`, `password`, `nama`) VALUES
(12345678, '821111', 'KOKI', '12345678', 'Bajingan');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `no_pesanan` int(11) NOT NULL,
  `no_meja` int(11) NOT NULL,
  `no_id` int(11) NOT NULL,
  `total` decimal(9,2) NOT NULL,
  `tanggal` date NOT NULL,
  `status_pesanan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`no_pesanan`, `no_meja`, `no_id`, `total`, `tanggal`, `status_pesanan`) VALUES
(1, 1, 12345678, 50000.00, '2024-07-11', 'beres'),
(2, 2, 2121212, 30000.00, '2024-07-20', 'Diproses'),
(3, 3, 12345678, 40000.00, '2024-07-10', 'tunggu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`no_meja`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`no_menu`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`no_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`no_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `no_meja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `no_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `no_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12345679;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `no_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
