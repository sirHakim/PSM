-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2021 at 05:41 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spp_fsktm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id_bidang` int(11) NOT NULL,
  `nama_bidang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id_bidang`, `nama_bidang`) VALUES
(1, 'Data Mining'),
(2, 'Machine Learning');

-- --------------------------------------------------------

--
-- Table structure for table `bidang_penyelia`
--

CREATE TABLE `bidang_penyelia` (
  `id_bidang` int(11) NOT NULL,
  `id_penyelia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bidang_penyelia`
--

INSERT INTO `bidang_penyelia` (`id_bidang`, `id_penyelia`) VALUES
(2, '03408'),
(1, '03408');

-- --------------------------------------------------------

--
-- Table structure for table `pelajar`
--

CREATE TABLE `pelajar` (
  `id_pelajar` varchar(10) NOT NULL,
  `nama_pelajar` varchar(100) NOT NULL,
  `kod_program` varchar(5) NOT NULL,
  `kata_laluan` varchar(50) NOT NULL,
  `nombor_telefon` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelajar`
--

INSERT INTO `pelajar` (`id_pelajar`, `nama_pelajar`, `kod_program`, `kata_laluan`, `nombor_telefon`) VALUES
('DI190015', 'MUHAMMAD HAKIM BIN BORHANUDDIN', 'BIT', '123', '0197739848');

-- --------------------------------------------------------

--
-- Table structure for table `penyelaras`
--

CREATE TABLE `penyelaras` (
  `id_penyelaras` varchar(10) NOT NULL,
  `nama_penyelaras` varchar(100) NOT NULL,
  `kod_program` varchar(5) NOT NULL,
  `kata_laluan` varchar(50) NOT NULL,
  `nombor_telefon` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penyelia`
--

CREATE TABLE `penyelia` (
  `id_penyelia` varchar(10) NOT NULL,
  `nama_penyelia` varchar(100) NOT NULL,
  `kod_program` varchar(5) NOT NULL,
  `kata_laluan` varchar(50) NOT NULL,
  `nombor_telefon` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyelia`
--

INSERT INTO `penyelia` (`id_penyelia`, `nama_penyelia`, `kod_program`, `kata_laluan`, `nombor_telefon`) VALUES
('03408', 'AHMAD BIN ISMAIL', 'BIT', 'TEST', '01234567891');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_diselia`
--

CREATE TABLE `permintaan_diselia` (
  `id_permintaan` int(11) NOT NULL,
  `id_pelajar` varchar(10) NOT NULL,
  `id_penyelia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_tajuk`
--

CREATE TABLE `permintaan_tajuk` (
  `id_permintaan` int(11) NOT NULL,
  `id_tajuk_penyelia` int(11) NOT NULL,
  `id_pelajar` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `kod_program` varchar(5) NOT NULL,
  `nama_program` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`kod_program`, `nama_program`) VALUES
('BIT', 'BACHELOR OF INFORMATION TECHNOLOGY WITH HONOURS');

-- --------------------------------------------------------

--
-- Table structure for table `tajuk_pelajar`
--

CREATE TABLE `tajuk_pelajar` (
  `id_tajuk_pelajar` int(11) NOT NULL,
  `nama_tajuk` varchar(100) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_pelajar` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tajuk_pelajar`
--

INSERT INTO `tajuk_pelajar` (`id_tajuk_pelajar`, `nama_tajuk`, `id_bidang`, `id_pelajar`) VALUES
(1, '', 2, 'DI190015');

-- --------------------------------------------------------

--
-- Table structure for table `tajuk_penyelia`
--

CREATE TABLE `tajuk_penyelia` (
  `id_tajuk_penyelia` int(11) NOT NULL,
  `id_penyelia` varchar(10) NOT NULL,
  `nama_tajuk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tajuk_penyelia`
--

INSERT INTO `tajuk_penyelia` (`id_tajuk_penyelia`, `id_penyelia`, `nama_tajuk`) VALUES
(1, '03408', 'SMART AUTOGATE SYSTEM WITH CAR VERIFICATION');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id_bidang`);

--
-- Indexes for table `bidang_penyelia`
--
ALTER TABLE `bidang_penyelia`
  ADD KEY `penyelia` (`id_penyelia`),
  ADD KEY `bidang` (`id_bidang`);

--
-- Indexes for table `pelajar`
--
ALTER TABLE `pelajar`
  ADD PRIMARY KEY (`id_pelajar`),
  ADD KEY `pelajad_program` (`kod_program`);

--
-- Indexes for table `penyelaras`
--
ALTER TABLE `penyelaras`
  ADD PRIMARY KEY (`id_penyelaras`),
  ADD KEY `penyelaras_program` (`kod_program`);

--
-- Indexes for table `penyelia`
--
ALTER TABLE `penyelia`
  ADD PRIMARY KEY (`id_penyelia`),
  ADD KEY `penyelia_program` (`kod_program`);

--
-- Indexes for table `permintaan_diselia`
--
ALTER TABLE `permintaan_diselia`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `pelajar_permintaan` (`id_pelajar`),
  ADD KEY `penyelia_permintaan` (`id_penyelia`);

--
-- Indexes for table `permintaan_tajuk`
--
ALTER TABLE `permintaan_tajuk`
  ADD PRIMARY KEY (`id_permintaan`),
  ADD KEY `pelajar_tajuk_penyelia` (`id_pelajar`),
  ADD KEY `tajuk_penyelia` (`id_tajuk_penyelia`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`kod_program`);

--
-- Indexes for table `tajuk_pelajar`
--
ALTER TABLE `tajuk_pelajar`
  ADD PRIMARY KEY (`id_tajuk_pelajar`),
  ADD KEY `pelajar_tajuk` (`id_pelajar`),
  ADD KEY `bidang_tajuk` (`id_bidang`);

--
-- Indexes for table `tajuk_penyelia`
--
ALTER TABLE `tajuk_penyelia`
  ADD PRIMARY KEY (`id_tajuk_penyelia`),
  ADD KEY `penyelia_tajuk` (`id_penyelia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id_bidang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permintaan_diselia`
--
ALTER TABLE `permintaan_diselia`
  MODIFY `id_permintaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permintaan_tajuk`
--
ALTER TABLE `permintaan_tajuk`
  MODIFY `id_permintaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tajuk_pelajar`
--
ALTER TABLE `tajuk_pelajar`
  MODIFY `id_tajuk_pelajar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tajuk_penyelia`
--
ALTER TABLE `tajuk_penyelia`
  MODIFY `id_tajuk_penyelia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bidang_penyelia`
--
ALTER TABLE `bidang_penyelia`
  ADD CONSTRAINT `bidang` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`),
  ADD CONSTRAINT `penyelia` FOREIGN KEY (`id_penyelia`) REFERENCES `penyelia` (`id_penyelia`);

--
-- Constraints for table `pelajar`
--
ALTER TABLE `pelajar`
  ADD CONSTRAINT `pelajad_program` FOREIGN KEY (`kod_program`) REFERENCES `program` (`kod_program`);

--
-- Constraints for table `penyelaras`
--
ALTER TABLE `penyelaras`
  ADD CONSTRAINT `penyelaras_program` FOREIGN KEY (`kod_program`) REFERENCES `program` (`kod_program`);

--
-- Constraints for table `penyelia`
--
ALTER TABLE `penyelia`
  ADD CONSTRAINT `penyelia_program` FOREIGN KEY (`kod_program`) REFERENCES `program` (`kod_program`);

--
-- Constraints for table `permintaan_diselia`
--
ALTER TABLE `permintaan_diselia`
  ADD CONSTRAINT `pelajar_permintaan` FOREIGN KEY (`id_pelajar`) REFERENCES `pelajar` (`id_pelajar`),
  ADD CONSTRAINT `penyelia_permintaan` FOREIGN KEY (`id_penyelia`) REFERENCES `penyelia` (`id_penyelia`);

--
-- Constraints for table `permintaan_tajuk`
--
ALTER TABLE `permintaan_tajuk`
  ADD CONSTRAINT `pelajar_tajuk_penyelia` FOREIGN KEY (`id_pelajar`) REFERENCES `pelajar` (`id_pelajar`),
  ADD CONSTRAINT `tajuk_penyelia` FOREIGN KEY (`id_tajuk_penyelia`) REFERENCES `tajuk_penyelia` (`id_tajuk_penyelia`);

--
-- Constraints for table `tajuk_pelajar`
--
ALTER TABLE `tajuk_pelajar`
  ADD CONSTRAINT `bidang_tajuk` FOREIGN KEY (`id_bidang`) REFERENCES `bidang` (`id_bidang`),
  ADD CONSTRAINT `pelajar_tajuk` FOREIGN KEY (`id_pelajar`) REFERENCES `pelajar` (`id_pelajar`);

--
-- Constraints for table `tajuk_penyelia`
--
ALTER TABLE `tajuk_penyelia`
  ADD CONSTRAINT `penyelia_tajuk` FOREIGN KEY (`id_penyelia`) REFERENCES `penyelia` (`id_penyelia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
