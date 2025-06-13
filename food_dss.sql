-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 03:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_dss`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` varchar(10) NOT NULL,
  `nama_makanan` varchar(30) DEFAULT NULL,
  `nama_warung` varchar(30) DEFAULT NULL,
  `lokasi_warung` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_makanan`, `nama_warung`, `lokasi_warung`) VALUES
('A001', 'nasi_goreng_teri', 'nasgor_962', 'kantin_spirit'),
('A002', 'soto_mie_rempah_full_daging', 'sotomie_rempah_bang_dede', 'kantin_spirit'),
('A003', 'spaghetti_bolognise', 'mie_ayam_dan_pasta_berkah', 'kantin spirit');

--
-- Triggers `alternatif`
--
DELIMITER $$
CREATE TRIGGER `tg_alternatif_insert` BEFORE INSERT ON `alternatif` FOR EACH ROW BEGIN
  INSERT INTO table1_seq VALUES (NULL);
  SET NEW.id_alternatif = CONCAT('A', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` varchar(10) NOT NULL,
  `nama_kriteria` varchar(30) DEFAULT NULL,
  `jenis` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `jenis`) VALUES
('K001', 'harga_makanan', 'cost'),
('K002', 'jarak', 'cost'),
('K003', 'waktu_tunggu', 'cost'),
('K004', 'popularitas', 'benefit'),
('K005', 'kebersihan_makanan', 'benefit'),
('K006', 'variasi_makanan', 'benefit'),
('K007', 'kemudahan_pembayaran', 'benefit'),
('K008', 'pelengkap_makanan', 'benefit'),
('K009', 'kelengkapan_alat_makan', 'benefit');

--
-- Triggers `kriteria`
--
DELIMITER $$
CREATE TRIGGER `tg_kriteria_insert` BEFORE INSERT ON `kriteria` FOR EACH ROW BEGIN
  INSERT INTO table2_seq VALUES (NULL);
  SET NEW.id_kriteria = CONCAT('K', LPAD(LAST_INSERT_ID(), 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `nilai_alternatif_kriteria`
--

CREATE TABLE `nilai_alternatif_kriteria` (
  `no` int(11) NOT NULL,
  `id_alternatif` varchar(10) DEFAULT NULL,
  `id_kriteria` varchar(10) DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai_alternatif_kriteria`
--

INSERT INTO `nilai_alternatif_kriteria` (`no`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(1, 'A001', 'K001', 15000),
(2, 'A001', 'K002', 300),
(3, 'A001', 'K003', 10),
(4, 'A001', 'K004', 4),
(5, 'A001', 'K005', 5),
(6, 'A001', 'K006', 3),
(7, 'A001', 'K007', 4),
(8, 'A001', 'K008', 3),
(9, 'A001', 'K009', 4),
(10, 'A002', 'K001', 18000),
(11, 'A002', 'K002', 250),
(12, 'A002', 'K003', 12),
(13, 'A002', 'K004', 5),
(14, 'A002', 'K005', 4),
(15, 'A002', 'K006', 5),
(16, 'A002', 'K007', 4),
(17, 'A002', 'K008', 4),
(18, 'A002', 'K009', 3),
(19, 'A003', 'K001', 13000),
(20, 'A003', 'K002', 400),
(21, 'A003', 'K003', 8),
(22, 'A003', 'K004', 3),
(23, 'A003', 'K005', 5),
(24, 'A003', 'K006', 4),
(25, 'A003', 'K007', 5),
(26, 'A003', 'K008', 2),
(27, 'A003', 'K009', 5);

-- --------------------------------------------------------

--
-- Table structure for table `table1_seq`
--

CREATE TABLE `table1_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table1_seq`
--

INSERT INTO `table1_seq` (`id`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `table2_seq`
--

CREATE TABLE `table2_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table2_seq`
--

INSERT INTO `table2_seq` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_nilai_pivot`
-- (See below for the actual view)
--
CREATE TABLE `view_nilai_pivot` (
`id_alternatif` varchar(10)
,`harga` double
,`jarak` double
,`waktu_tunggu` double
,`popularitas` double
,`kebersihan` double
,`variasi` double
,`pembayaran` double
,`pelengkap` double
,`kelengkapan` double
);

-- --------------------------------------------------------

--
-- Structure for view `view_nilai_pivot`
--
DROP TABLE IF EXISTS `view_nilai_pivot`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_nilai_pivot`  AS SELECT `nilai_alternatif_kriteria`.`id_alternatif` AS `id_alternatif`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K001' then `nilai_alternatif_kriteria`.`nilai` end) AS `harga`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K002' then `nilai_alternatif_kriteria`.`nilai` end) AS `jarak`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K003' then `nilai_alternatif_kriteria`.`nilai` end) AS `waktu_tunggu`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K004' then `nilai_alternatif_kriteria`.`nilai` end) AS `popularitas`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K005' then `nilai_alternatif_kriteria`.`nilai` end) AS `kebersihan`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K006' then `nilai_alternatif_kriteria`.`nilai` end) AS `variasi`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K007' then `nilai_alternatif_kriteria`.`nilai` end) AS `pembayaran`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K008' then `nilai_alternatif_kriteria`.`nilai` end) AS `pelengkap`, max(case when `nilai_alternatif_kriteria`.`id_kriteria` = 'K009' then `nilai_alternatif_kriteria`.`nilai` end) AS `kelengkapan` FROM `nilai_alternatif_kriteria` GROUP BY `nilai_alternatif_kriteria`.`id_alternatif` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `nilai_alternatif_kriteria`
--
ALTER TABLE `nilai_alternatif_kriteria`
  ADD PRIMARY KEY (`no`),
  ADD KEY `FK_id_alternatif` (`id_alternatif`),
  ADD KEY `FK_id_kriteria` (`id_kriteria`);

--
-- Indexes for table `table1_seq`
--
ALTER TABLE `table1_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table2_seq`
--
ALTER TABLE `table2_seq`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nilai_alternatif_kriteria`
--
ALTER TABLE `nilai_alternatif_kriteria`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `table1_seq`
--
ALTER TABLE `table1_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `table2_seq`
--
ALTER TABLE `table2_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nilai_alternatif_kriteria`
--
ALTER TABLE `nilai_alternatif_kriteria`
  ADD CONSTRAINT `FK_id_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`),
  ADD CONSTRAINT `FK_id_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
