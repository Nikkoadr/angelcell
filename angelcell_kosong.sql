-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2025 at 02:56 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angelcell`
--

-- --------------------------------------------------------

--
-- Table structure for table `absenlogin`
--

CREATE TABLE `absenlogin` (
  `idabsenlogin` int(250) NOT NULL,
  `iduser` int(250) NOT NULL,
  `tanggallogin` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arsipbarangmasuk`
--

CREATE TABLE `arsipbarangmasuk` (
  `idarsipbarangmasuk` int(250) NOT NULL,
  `idbarang` int(200) NOT NULL,
  `idsupplier` int(250) NOT NULL,
  `namabarang` varchar(100) NOT NULL,
  `hargaecer` int(100) DEFAULT NULL,
  `hargagrosir` int(100) NOT NULL,
  `hargamodal` int(100) DEFAULT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `stok` int(50) DEFAULT NULL,
  `qty` int(100) NOT NULL,
  `tanggal` datetime NOT NULL,
  `namauser` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arsippenjualan`
--

CREATE TABLE `arsippenjualan` (
  `idarsippenjualan` bigint(255) NOT NULL,
  `nonota` bigint(255) NOT NULL,
  `idjenispenjualan` int(50) NOT NULL,
  `idmember` int(10) DEFAULT 0,
  `iddataservis` int(100) DEFAULT 0,
  `tanggalmasuk` datetime NOT NULL,
  `tanggalselesai` datetime NOT NULL,
  `namakasir` varchar(50) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `diskon` int(100) NOT NULL,
  `tunai` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `arsippenjualanrinci`
--

CREATE TABLE `arsippenjualanrinci` (
  `idarsippenjualanrinci` bigint(255) NOT NULL,
  `nonota` bigint(255) NOT NULL,
  `idbarang` int(10) NOT NULL,
  `namabarang` varchar(100) NOT NULL,
  `hargajual` int(100) NOT NULL,
  `hargamodal` int(200) NOT NULL,
  `qtyjual` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `idbarang` int(200) NOT NULL,
  `kodebarang` varchar(50) DEFAULT NULL,
  `namabarang` varchar(100) NOT NULL,
  `hargaecer` int(100) DEFAULT NULL,
  `hargagrosir` int(100) DEFAULT NULL,
  `hargamodal` int(100) DEFAULT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `stok` int(50) DEFAULT NULL,
  `aktif` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `idbarangmasuk` int(250) NOT NULL,
  `idbarang` int(200) NOT NULL,
  `idsupplier` int(250) NOT NULL,
  `hargabeli` int(100) DEFAULT NULL,
  `qtybeli` int(100) NOT NULL,
  `tanggalbeli` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dataservis`
--

CREATE TABLE `dataservis` (
  `iddataservis` int(250) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'diterima',
  `tanggaldikerjakan` datetime DEFAULT NULL,
  `tanggalselesai` datetime DEFAULT NULL,
  `tanggaldiambil` datetime DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nohp` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `kerusakan` varchar(200) NOT NULL,
  `kondisi` varchar(200) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `sandi` varchar(100) NOT NULL,
  `pola` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gajikaryawan`
--

CREATE TABLE `gajikaryawan` (
  `idgajikaryawan` int(250) NOT NULL,
  `iduser` int(250) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `jumlah` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenispenjualan`
--

CREATE TABLE `jenispenjualan` (
  `idjenispenjualan` int(200) NOT NULL,
  `namajenis` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenispenjualan`
--

INSERT INTO `jenispenjualan` (`idjenispenjualan`, `namajenis`) VALUES
(1, 'Eceran'),
(2, 'Grosir'),
(3, 'Servis');

-- --------------------------------------------------------

--
-- Table structure for table `keranjangbelanja`
--

CREATE TABLE `keranjangbelanja` (
  `idkeranjangbelanja` bigint(255) NOT NULL,
  `nonota` bigint(255) NOT NULL,
  `idjenispenjualan` int(10) NOT NULL,
  `idmember` int(200) DEFAULT NULL,
  `tanggalmasuk` datetime DEFAULT NULL,
  `iddataservis` int(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjangrinci`
--

CREATE TABLE `keranjangrinci` (
  `idkeranjangrinci` bigint(250) NOT NULL,
  `nonota` bigint(250) NOT NULL,
  `idbarang` int(250) DEFAULT NULL,
  `namabarang` varchar(200) DEFAULT NULL,
  `hargajual` int(100) DEFAULT NULL,
  `hargamodal` int(100) DEFAULT NULL,
  `qtyjual` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `idmember` int(250) NOT NULL,
  `namamember` varchar(200) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `nohp` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL,
  `aktif` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelianbarang`
--

CREATE TABLE `pembelianbarang` (
  `idpembelianbarang` int(200) NOT NULL,
  `idbarang` int(200) NOT NULL,
  `idsupplier` int(50) NOT NULL,
  `tanggalbeli` datetime NOT NULL,
  `hargabeli` int(10) NOT NULL,
  `qtybeli` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `idsupplier` int(200) NOT NULL,
  `namasupplier` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `nohp` varchar(100) NOT NULL,
  `aktif` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(10) NOT NULL,
  `namauser` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `nohp` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `privilege` varchar(10) NOT NULL,
  `power` int(5) NOT NULL,
  `aktif` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `namauser`, `username`, `alamat`, `nohp`, `tanggal`, `privilege`, `power`, `aktif`) VALUES
(101, 'Admin', '20032023', 'Indramayu', '082211007770', '2023-01-09', 'admin', 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absenlogin`
--
ALTER TABLE `absenlogin`
  ADD PRIMARY KEY (`idabsenlogin`);

--
-- Indexes for table `arsipbarangmasuk`
--
ALTER TABLE `arsipbarangmasuk`
  ADD PRIMARY KEY (`idarsipbarangmasuk`);

--
-- Indexes for table `arsippenjualan`
--
ALTER TABLE `arsippenjualan`
  ADD PRIMARY KEY (`idarsippenjualan`),
  ADD KEY `nonota` (`nonota`);

--
-- Indexes for table `arsippenjualanrinci`
--
ALTER TABLE `arsippenjualanrinci`
  ADD PRIMARY KEY (`idarsippenjualanrinci`),
  ADD KEY `nonota` (`nonota`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idbarang`),
  ADD UNIQUE KEY `namabarang` (`namabarang`),
  ADD UNIQUE KEY `kodebarang` (`kodebarang`);

--
-- Indexes for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`idbarangmasuk`);

--
-- Indexes for table `dataservis`
--
ALTER TABLE `dataservis`
  ADD PRIMARY KEY (`iddataservis`);

--
-- Indexes for table `gajikaryawan`
--
ALTER TABLE `gajikaryawan`
  ADD PRIMARY KEY (`idgajikaryawan`);

--
-- Indexes for table `jenispenjualan`
--
ALTER TABLE `jenispenjualan`
  ADD PRIMARY KEY (`idjenispenjualan`);

--
-- Indexes for table `keranjangbelanja`
--
ALTER TABLE `keranjangbelanja`
  ADD PRIMARY KEY (`idkeranjangbelanja`);

--
-- Indexes for table `keranjangrinci`
--
ALTER TABLE `keranjangrinci`
  ADD PRIMARY KEY (`idkeranjangrinci`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idmember`);

--
-- Indexes for table `pembelianbarang`
--
ALTER TABLE `pembelianbarang`
  ADD PRIMARY KEY (`idpembelianbarang`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`idsupplier`),
  ADD UNIQUE KEY `namasupplier` (`namasupplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absenlogin`
--
ALTER TABLE `absenlogin`
  MODIFY `idabsenlogin` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arsipbarangmasuk`
--
ALTER TABLE `arsipbarangmasuk`
  MODIFY `idarsipbarangmasuk` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arsippenjualan`
--
ALTER TABLE `arsippenjualan`
  MODIFY `idarsippenjualan` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arsippenjualanrinci`
--
ALTER TABLE `arsippenjualanrinci`
  MODIFY `idarsippenjualanrinci` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `idbarang` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `idbarangmasuk` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dataservis`
--
ALTER TABLE `dataservis`
  MODIFY `iddataservis` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gajikaryawan`
--
ALTER TABLE `gajikaryawan`
  MODIFY `idgajikaryawan` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenispenjualan`
--
ALTER TABLE `jenispenjualan`
  MODIFY `idjenispenjualan` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `keranjangbelanja`
--
ALTER TABLE `keranjangbelanja`
  MODIFY `idkeranjangbelanja` bigint(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keranjangrinci`
--
ALTER TABLE `keranjangrinci`
  MODIFY `idkeranjangrinci` bigint(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `idmember` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembelianbarang`
--
ALTER TABLE `pembelianbarang`
  MODIFY `idpembelianbarang` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `idsupplier` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
