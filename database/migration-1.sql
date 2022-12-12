-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2022 at 10:47 AM
-- Server version: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ztech_pbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `DAT_OP_BANGUNAN`
--

CREATE TABLE `DAT_OP_BANGUNAN` (
  `ID` int(11) NOT NULL,
  `WAJIB_PAJAK_ID` varchar(255) DEFAULT NULL,
  `NOP` text NOT NULL,
  `NO_FORMULIR_LSPOP` text NOT NULL,
  `THN_PAJAK` text NOT NULL,
  `NO_BNG` text NOT NULL,
  `JML_LANTAI_BNG` text NOT NULL,
  `LUAS_BNG` text NOT NULL,
  `KD_JPB` text NOT NULL,
  `THN_DIBANGUN_BNG` text NOT NULL,
  `THN_RENOVASI_BNG` text NOT NULL,
  `KONDISI_BNG` text NOT NULL,
  `JNS_KONSTRUKSI_BNG` text NOT NULL,
  `JNS_ATAP_BNG` text NOT NULL,
  `KD_DINDING` text NOT NULL,
  `KD_LANTAI` text NOT NULL,
  `KD_LANGIT_LANGIT` text NOT NULL,
  `L_AC` text NOT NULL,
  `LPH` text NOT NULL,
  `JLT_DL` text NOT NULL,
  `JLT_TL` text NOT NULL,
  `PAGAR` text NOT NULL,
  `LTB` text NOT NULL,
  `PK` text NOT NULL,
  `J_LIFT` text NOT NULL,
  `OTHERS` text NOT NULL,
  `KOLAM_RENANG` text NOT NULL,
  `KETERANGAN` text NOT NULL,
  `NILAI_INDIVIDU` text NOT NULL,
  `STATUS` varchar(255) NOT NULL DEFAULT 'MENUNGGU',
  `NO_HP` text NOT NULL,
  `EMAIL` text NOT NULL,
  `KTP` text,
  `FOTO_OBJEK` text,
  `SURAT_TANAH` text,
  `reg_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `DAT_OP_BUMI`
--

CREATE TABLE `DAT_OP_BUMI` (
  `ID` int(12) NOT NULL,
  `WAJIB_PAJAK_ID` varchar(255) DEFAULT NULL,
  `NO_SPOP` varchar(255) DEFAULT NULL,
  `TAHUN` varchar(255) DEFAULT NULL,
  `KD_PROPINSI` varchar(255) NOT NULL DEFAULT '12',
  `KD_DATI2` varchar(255) NOT NULL DEFAULT '12',
  `KD_KECAMATAN` varchar(255) DEFAULT NULL,
  `KD_KELURAHAN` varchar(255) DEFAULT NULL,
  `KD_BLOK` varchar(255) DEFAULT NULL,
  `KD_ZNT` varchar(255) DEFAULT NULL,
  `NO_URUT` varchar(255) DEFAULT NULL,
  `KODE` varchar(255) DEFAULT NULL,
  `STATUS_WP` varchar(255) DEFAULT NULL,
  `JALAN` varchar(255) DEFAULT NULL,
  `RW` varchar(255) DEFAULT NULL,
  `RT` varchar(255) DEFAULT NULL,
  `NO_PERSIL` varchar(255) DEFAULT NULL,
  `JNS_BUMI` varchar(255) DEFAULT NULL,
  `JLH_BNG` varchar(255) DEFAULT NULL,
  `LUAS_TANAH` varchar(255) DEFAULT NULL,
  `KETERANGAN` varchar(255) DEFAULT NULL,
  `STATUS` varchar(255) NOT NULL DEFAULT 'MENUNGGU',
  `NO_HP` text NOT NULL,
  `EMAIL` text NOT NULL,
  `KTP` text,
  `FOTO_OBJEK` text,
  `SURAT_TANAH` text,
  `reg_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_queues`
--

CREATE TABLE `email_queues` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` text NOT NULL,
  `message` longtext NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sent_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `esppt`
--

CREATE TABLE `esppt` (
  `ID` int(11) NOT NULL,
  `ID_WAJIB_PAJAK` varchar(255) NOT NULL,
  `NAMA_WAJIB_PAJAK` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `STATUS` varchar(255) NOT NULL DEFAULT 'MENUNGGU',
  `TAHUN` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjek_pajak`
--

CREATE TABLE `subjek_pajak` (
  `id` int(11) NOT NULL,
  `NIK` varchar(255) NOT NULL,
  `STATUS_PEKERJAAN_WP` varchar(255) NOT NULL,
  `KELURAHAN_WP` varchar(255) NOT NULL,
  `JALAN_WP` varchar(255) NOT NULL,
  `RW_WP` varchar(255) NOT NULL,
  `RT_WP` varchar(255) NOT NULL,
  `KOTA_WP` varchar(255) NOT NULL,
  `BLOK_KAV_NO_WP` varchar(255) NOT NULL,
  `KD_POS_WP` varchar(255) NOT NULL,
  `TELP_WP` varchar(255) NOT NULL,
  `NPWP` varchar(255) NOT NULL,
  `NM_WP` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reg_code` varchar(50) NOT NULL,
  `reg_status` varchar(20) NOT NULL,
  `reg_type` varchar(100) NOT NULL,
  `reg_updated_at` datetime DEFAULT NULL,
  `reg_updated_by` varchar(100) DEFAULT NULL,
  `reg_note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DAT_OP_BANGUNAN`
--
ALTER TABLE `DAT_OP_BANGUNAN`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `DAT_OP_BUMI`
--
ALTER TABLE `DAT_OP_BUMI`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `email_queues`
--
ALTER TABLE `email_queues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `esppt`
--
ALTER TABLE `esppt`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `subjek_pajak`
--
ALTER TABLE `subjek_pajak`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DAT_OP_BANGUNAN`
--
ALTER TABLE `DAT_OP_BANGUNAN`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `DAT_OP_BUMI`
--
ALTER TABLE `DAT_OP_BUMI`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `email_queues`
--
ALTER TABLE `email_queues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `esppt`
--
ALTER TABLE `esppt`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `subjek_pajak`
--
ALTER TABLE `subjek_pajak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
