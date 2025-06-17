-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 07:39 PM
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
('A001', 'nasi goreng teri', 'nasgor 962', 'kantin spirit'),
('A002', 'soto mie rempah full daging', 'sotomie rempah bang dede', 'kantin spirit'),
('A003', 'spaghetti bolognise', 'mie ayam dan pasta berkah', 'kantin spirit'),
('A004', 'somay', 'somay group', 'kantin_spirit'),
('A005', 'nasi goreng biasa', 'nasgor 962', 'kantin_spirit'),
('A006', 'nasi goreng gila', 'nasgor 962', 'kantin spirit'),
('A007', 'nasi capcay', 'nasgor 962', 'kantin_spirit'),
('A008', 'mie goreng', 'nasgor 962', 'kantin_spirit'),
('A009', 'bihun goreng', 'nasgor 962', 'kantin_spirit'),
('A010', 'kwenastel', 'nasgor 962', 'kantin spirit'),
('A011', 'mie ayam pangsit', 'mie ayam dan pasta berkah', 'kantin spirit'),
('A012', 'yamin pangsit', 'mie ayam dan pasta berkah', 'kantin spirit'),
('A013', 'fettucini bologhnise', 'mie ayam dan pasta berkah', 'kantin spirit'),
('A014', 'rawon daging', 'kedai bunda rachma', 'kantin spirit'),
('A015', 'soto ayam bololali', 'kedai bunda rachma', 'kantin spirit'),
('A016', 'bakso malang', 'bakso echo malang', 'kantin spirit'),
('A017', 'ayam goreng', 'penyetan hk', 'kantin reborn'),
('A018', 'ayam geprek', 'penyetan hk', 'kantin reborn'),
('A019', 'ayam bakar', 'penyetan hk', 'kantin reborn'),
('A020', 'ayam penyet', 'penyetan hk', 'kantin reborn'),
('A021', 'chicken gordon blue + salad + ', 'dhans japanese food', 'kantin reborn'),
('A022', 'chicken katsu + salad + nasi', 'dhans japanese food', 'kantin reborn'),
('A023', 'chicken teriyaki + salad + nas', 'dhans japanese food', 'kantin reborn'),
('A024', 'shrimp tofu + salad + nasi', 'dhans japanese food', 'kantin reborn'),
('A025', 'pepes ayam + nasi', 'aneka pepes bunda heti', 'kantin reborn'),
('A026', 'pepes ikan mas + nasi', 'aneka pepes bunda heti', 'kantin reborn'),
('A027', 'pepes tahu + nasi', 'aneka pepes bunda heti', 'kantin reborn'),
('A028', 'pepes ikan peda + nasi', 'aneka pepes bunda heti', 'kantin reborn'),
('A029', 'beef teriyaki', 'piring kecil', 'kantin reborn'),
('A030', 'beef lada hitam', 'piring kecil', 'kantin reborn'),
('A031', 'ayam asam manis', 'piring kecil', 'kantin reborn'),
('A032', 'ayam lada hitam', 'piring kecil', 'kantin reborn'),
('A033', 'udang saos tiram + nasi', 'seafood pnj', 'kantin reborn'),
('A034', 'udang saos padang + nasi', 'seafood pnj', 'kantin reborn'),
('A035', 'lele bakar/goreng + nasi + es ', 'seafood pnj', 'kantin reborn'),
('A036', 'bawal bakar/goreng + nasi', 'seafood pnj', 'kantin reborn');

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
-- Table structure for table `history_bobot`
--

CREATE TABLE `history_bobot` (
  `num` int(11) NOT NULL,
  `tipe` char(20) DEFAULT 'unik',
  `bobot_harga_makanan` decimal(4,2) DEFAULT NULL,
  `bobot_jarak` decimal(4,2) DEFAULT NULL,
  `bobot_waktu_tunggu` decimal(4,2) DEFAULT NULL,
  `bobot_popularitas` decimal(4,2) DEFAULT NULL,
  `bobot_kebersihan_makanan` decimal(4,2) DEFAULT NULL,
  `bobot_variasi_makanan` decimal(4,2) DEFAULT NULL,
  `bobot_kemudahan_pembayaran` decimal(4,2) DEFAULT NULL,
  `bobot_pelengkap_makanan` decimal(4,2) DEFAULT NULL,
  `bobot_kelengkapan_alat_makan` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_bobot`
--

INSERT INTO `history_bobot` (`num`, `tipe`, `bobot_harga_makanan`, `bobot_jarak`, `bobot_waktu_tunggu`, `bobot_popularitas`, `bobot_kebersihan_makanan`, `bobot_variasi_makanan`, `bobot_kemudahan_pembayaran`, `bobot_pelengkap_makanan`, `bobot_kelengkapan_alat_makan`) VALUES
(1, 'unik', 3.00, 3.60, 3.90, 2.30, 3.20, 4.60, 3.40, 2.40, 4.40),
(2, 'unik', 3.00, 3.60, 3.90, 2.30, 4.30, 2.10, 3.40, 4.30, 1.80),
(3, 'duplikat', 3.00, 3.60, 3.90, 2.30, 4.30, 2.10, 3.40, 4.30, 1.80),
(4, 'unik', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(5, 'duplikat', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(6, 'duplikat', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(7, 'duplikat', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(8, 'duplikat', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(9, 'duplikat', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(10, 'duplikat', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(11, 'duplikat', 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00),
(12, 'unik', 3.00, 3.00, 2.40, 3.40, 3.00, 3.00, 3.00, 3.00, 3.00),
(13, 'unik', 3.00, 3.60, 2.80, 3.00, 3.00, 2.30, 3.40, 2.00, 3.00);

--
-- Triggers `history_bobot`
--
DELIMITER $$
CREATE TRIGGER `check_duplicate_bobot` BEFORE INSERT ON `history_bobot` FOR EACH ROW BEGIN
  DECLARE is_duplicate INT;

  SELECT COUNT(*) INTO is_duplicate
  FROM history_bobot
  WHERE 
    bobot_harga_makanan = NEW.bobot_harga_makanan AND
    bobot_jarak = NEW.bobot_jarak AND
    bobot_waktu_tunggu = NEW.bobot_waktu_tunggu AND
    bobot_popularitas = NEW.bobot_popularitas AND
    bobot_kebersihan_makanan = NEW.bobot_kebersihan_makanan AND
    bobot_variasi_makanan = NEW.bobot_variasi_makanan AND
    bobot_kemudahan_pembayaran = NEW.bobot_kemudahan_pembayaran AND
    bobot_pelengkap_makanan = NEW.bobot_pelengkap_makanan AND
    bobot_kelengkapan_alat_makan = NEW.bobot_kelengkapan_alat_makan;

  IF is_duplicate > 0 THEN
    SET NEW.tipe = 'duplikat';
  END IF;
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
(27, 'A003', 'K009', 5),
(28, 'A004', 'K001', 10000),
(29, 'A004', 'K002', 80),
(30, 'A004', 'K003', 7),
(31, 'A004', 'K004', 4),
(32, 'A004', 'K005', 4),
(33, 'A004', 'K006', 3),
(34, 'A004', 'K007', 4),
(35, 'A004', 'K008', 3),
(36, 'A004', 'K009', 4),
(37, 'A005', 'K001', 13000),
(38, 'A005', 'K002', 100),
(39, 'A005', 'K003', 12),
(40, 'A005', 'K004', 5),
(41, 'A005', 'K005', 4),
(42, 'A005', 'K006', 4),
(43, 'A005', 'K007', 4),
(44, 'A005', 'K008', 4),
(45, 'A005', 'K009', 4),
(46, 'A006', 'K001', 16000),
(47, 'A006', 'K002', 100),
(48, 'A006', 'K003', 15),
(49, 'A006', 'K004', 4),
(50, 'A006', 'K005', 4),
(51, 'A006', 'K006', 4),
(52, 'A006', 'K007', 4),
(53, 'A006', 'K008', 4),
(54, 'A006', 'K009', 4),
(55, 'A007', 'K001', 15000),
(56, 'A007', 'K002', 100),
(57, 'A007', 'K003', 13),
(58, 'A007', 'K004', 3),
(59, 'A007', 'K005', 4),
(60, 'A007', 'K006', 4),
(61, 'A007', 'K007', 4),
(62, 'A007', 'K008', 4),
(63, 'A007', 'K009', 4),
(64, 'A008', 'K001', 14000),
(65, 'A008', 'K002', 100),
(66, 'A008', 'K003', 10),
(67, 'A008', 'K004', 4),
(68, 'A008', 'K005', 4),
(69, 'A008', 'K006', 4),
(70, 'A008', 'K007', 4),
(71, 'A008', 'K008', 4),
(72, 'A008', 'K009', 4),
(73, 'A009', 'K001', 14000),
(74, 'A009', 'K002', 100),
(75, 'A009', 'K003', 10),
(76, 'A009', 'K004', 3),
(77, 'A009', 'K005', 4),
(78, 'A009', 'K006', 4),
(79, 'A009', 'K007', 4),
(80, 'A009', 'K008', 4),
(81, 'A009', 'K009', 4),
(82, 'A010', 'K001', 18000),
(83, 'A010', 'K002', 100),
(84, 'A010', 'K003', 15),
(85, 'A010', 'K004', 2),
(86, 'A010', 'K005', 4),
(87, 'A010', 'K006', 4),
(88, 'A010', 'K007', 4),
(89, 'A010', 'K008', 4),
(90, 'A010', 'K009', 4),
(91, 'A011', 'K001', 15000),
(92, 'A011', 'K002', 90),
(93, 'A011', 'K003', 10),
(94, 'A011', 'K004', 5),
(95, 'A011', 'K005', 4),
(96, 'A011', 'K006', 3),
(97, 'A011', 'K007', 4),
(98, 'A011', 'K008', 4),
(99, 'A011', 'K009', 4),
(100, 'A012', 'K001', 16000),
(101, 'A012', 'K002', 90),
(102, 'A012', 'K003', 12),
(103, 'A012', 'K004', 4),
(104, 'A012', 'K005', 4),
(105, 'A012', 'K006', 3),
(106, 'A012', 'K007', 4),
(107, 'A012', 'K008', 4),
(108, 'A012', 'K009', 4),
(109, 'A013', 'K001', 20000),
(110, 'A013', 'K002', 90),
(111, 'A013', 'K003', 15),
(112, 'A013', 'K004', 3),
(113, 'A013', 'K005', 4),
(114, 'A013', 'K006', 3),
(115, 'A013', 'K007', 4),
(116, 'A013', 'K008', 3),
(117, 'A013', 'K009', 4),
(118, 'A014', 'K001', 22000),
(119, 'A014', 'K002', 120),
(120, 'A014', 'K003', 10),
(121, 'A014', 'K004', 4),
(122, 'A014', 'K005', 5),
(123, 'A014', 'K006', 2),
(124, 'A014', 'K007', 4),
(125, 'A014', 'K008', 5),
(126, 'A014', 'K009', 4),
(127, 'A015', 'K001', 18000),
(128, 'A015', 'K002', 120),
(129, 'A015', 'K003', 8),
(130, 'A015', 'K004', 4),
(131, 'A015', 'K005', 5),
(132, 'A015', 'K006', 2),
(133, 'A015', 'K007', 4),
(134, 'A015', 'K008', 5),
(135, 'A015', 'K009', 4),
(136, 'A016', 'K001', 17000),
(137, 'A016', 'K002', 110),
(138, 'A016', 'K003', 7),
(139, 'A016', 'K004', 5),
(140, 'A016', 'K005', 4),
(141, 'A016', 'K006', 3),
(142, 'A016', 'K007', 4),
(143, 'A016', 'K008', 4),
(144, 'A016', 'K009', 4),
(145, 'A017', 'K001', 15000),
(146, 'A017', 'K002', 70),
(147, 'A017', 'K003', 8),
(148, 'A017', 'K004', 4),
(149, 'A017', 'K005', 3),
(150, 'A017', 'K006', 3),
(151, 'A017', 'K007', 5),
(152, 'A017', 'K008', 4),
(153, 'A017', 'K009', 3),
(154, 'A018', 'K001', 18000),
(155, 'A018', 'K002', 70),
(156, 'A018', 'K003', 10),
(157, 'A018', 'K004', 5),
(158, 'A018', 'K005', 3),
(159, 'A018', 'K006', 3),
(160, 'A018', 'K007', 5),
(161, 'A018', 'K008', 4),
(162, 'A018', 'K009', 3),
(163, 'A019', 'K001', 20000),
(164, 'A019', 'K002', 70),
(165, 'A019', 'K003', 12),
(166, 'A019', 'K004', 4),
(167, 'A019', 'K005', 3),
(168, 'A019', 'K006', 3),
(169, 'A019', 'K007', 5),
(170, 'A019', 'K008', 4),
(171, 'A019', 'K009', 3),
(172, 'A020', 'K001', 17000),
(173, 'A020', 'K002', 70),
(174, 'A020', 'K003', 9),
(175, 'A020', 'K004', 4),
(176, 'A020', 'K005', 3),
(177, 'A020', 'K006', 3),
(178, 'A020', 'K007', 5),
(179, 'A020', 'K008', 4),
(180, 'A020', 'K009', 3),
(181, 'A021', 'K001', 25000),
(182, 'A021', 'K002', 150),
(183, 'A021', 'K003', 18),
(184, 'A021', 'K004', 4),
(185, 'A021', 'K005', 4),
(186, 'A021', 'K006', 4),
(187, 'A021', 'K007', 4),
(188, 'A021', 'K008', 5),
(189, 'A021', 'K009', 5),
(190, 'A022', 'K001', 22000),
(191, 'A022', 'K002', 150),
(192, 'A022', 'K003', 15),
(193, 'A022', 'K004', 5),
(194, 'A022', 'K005', 4),
(195, 'A022', 'K006', 4),
(196, 'A022', 'K007', 4),
(197, 'A022', 'K008', 5),
(198, 'A022', 'K009', 5),
(199, 'A023', 'K001', 23000),
(200, 'A023', 'K002', 150),
(201, 'A023', 'K003', 16),
(202, 'A023', 'K004', 4),
(203, 'A023', 'K005', 4),
(204, 'A023', 'K006', 4),
(205, 'A023', 'K007', 4),
(206, 'A023', 'K008', 5),
(207, 'A023', 'K009', 5),
(208, 'A024', 'K001', 28000),
(209, 'A024', 'K002', 150),
(210, 'A024', 'K003', 20),
(211, 'A024', 'K004', 3),
(212, 'A024', 'K005', 4),
(213, 'A024', 'K006', 4),
(214, 'A024', 'K007', 4),
(215, 'A024', 'K008', 5),
(216, 'A024', 'K009', 5),
(217, 'A025', 'K001', 15000),
(218, 'A025', 'K002', 130),
(219, 'A025', 'K003', 10),
(220, 'A025', 'K004', 4),
(221, 'A025', 'K005', 4),
(222, 'A025', 'K006', 3),
(223, 'A025', 'K007', 3),
(224, 'A025', 'K008', 4),
(225, 'A025', 'K009', 3);

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
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36);

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
-- Indexes for table `history_bobot`
--
ALTER TABLE `history_bobot`
  ADD PRIMARY KEY (`num`);

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
-- AUTO_INCREMENT for table `history_bobot`
--
ALTER TABLE `history_bobot`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `nilai_alternatif_kriteria`
--
ALTER TABLE `nilai_alternatif_kriteria`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;

--
-- AUTO_INCREMENT for table `table1_seq`
--
ALTER TABLE `table1_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
