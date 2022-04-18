-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 29 Tem 2020, 12:10:00
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `siparis`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anliksiparis`
--

CREATE TABLE `anliksiparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `anliksiparis`
--

INSERT INTO `anliksiparis` (`id`, `masaid`, `urunid`, `urunad`, `urunfiyat`, `adet`) VALUES
(1, 1, 3, 'sprite', 5, 3),
(2, 1, 7, 'mercimek', 10, 5),
(3, 15, 7, 'mercimek', 10, 6),
(4, 10, 3, 'sprite', 5, 3),
(5, 7, 8, 'tonbalıklı mk', 15, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `barsiparis`
--

CREATE TABLE `barsiparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL,
  `saat` int(11) NOT NULL DEFAULT 0,
  `dakika` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `barsiparis`
--

INSERT INTO `barsiparis` (`id`, `masaid`, `urunid`, `urunad`, `adet`, `saat`, `dakika`) VALUES
(1, 1, 3, 'sprite', 3, 12, 4),
(2, 10, 3, 'sprite', 3, 12, 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doluluk`
--

CREATE TABLE `doluluk` (
  `id` int(11) NOT NULL,
  `bos` int(11) NOT NULL DEFAULT 0,
  `dolu` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `doluluk`
--

INSERT INTO `doluluk` (`id`, `bos`, `dolu`) VALUES
(1, 26, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `garson`
--

CREATE TABLE `garson` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `garson`
--

INSERT INTO `garson` (`id`, `ad`, `sifre`, `durum`) VALUES
(1, 'deneme', '1', 1),
(2, 'frodo', '1', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicimasa`
--

CREATE TABLE `gecicimasa` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `masaad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicimasa`
--

INSERT INTO `gecicimasa` (`id`, `masaid`, `masaad`, `hasilat`, `adet`) VALUES
(1, 23, 'MASA 23', 62.5, 5),
(2, 1, 'MASA 1', 827.5, 146),
(3, 15, 'MASA 15', 28, 2),
(4, 19, 'MASA 19', 384, 28),
(5, 2, 'MASA 2', 208.5, 23),
(6, 3, 'MASA 3', 391.5, 28),
(7, 10, 'MASA 10', 125, 10);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geciciurun`
--

CREATE TABLE `geciciurun` (
  `id` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `geciciurun`
--

INSERT INTO `geciciurun` (`id`, `urunid`, `urunad`, `hasilat`, `adet`) VALUES
(1, 28, 'VANİLYALI MİLKSHAKE', 162.5, 13),
(2, 29, 'MEYVELİ FROZEN', 87.5, 7),
(3, 56, 'ADANA PORSİYON', 96, 4),
(4, 27, 'ÇİKOLATALI MİLSHAKE', 162.5, 13),
(5, 37, 'KÖRİ SOSLU MAKARNA', 28, 2),
(6, 15, 'TÜRK KAHVESİ SÜVARİ', 110, 11),
(7, 33, 'ANANAS MEYVESUYU', 24, 4),
(8, 30, 'ŞEFTALİ MEYVESUYU', 18, 3),
(9, 26, 'KARADUT FRAPPE', 87.5, 7),
(10, 41, 'DÖRT MEVSİM SALATA', 42, 3),
(11, 36, 'TONBALIKLI MAKARNA', 98, 7),
(12, 88, 'KARİDES', 75, 3),
(13, 12, 'ESPRESSO KAHVE DOUBLE', 100, 8),
(14, 70, 'TÜRKİSH SPECİAL PİZZA', 78, 3),
(15, 22, 'ŞEFTALİ İCE TEA', 18, 3),
(16, 24, 'KARPUZ FRAPPE', 100, 8),
(17, 16, 'KAHVE SÜTÜ', 6, 2),
(18, 4, 'ADA ÇAYI', 37.5, 5),
(19, 11, 'ESPRESSO KAHVE', 40, 5),
(20, 34, 'KIYMA SOSLU MAKARNA', 84, 6),
(21, 62, 'STEAK HOUSE BURGER', 46, 2),
(22, 96, 'Sucuklu Omlet', 50, 2),
(23, 64, 'ROYAL BURGER', 62.5, 5),
(24, 58, 'SOĞAN HALKASI', 24, 3),
(25, 49, 'DOMATES ÇORBASI', 27, 3),
(26, 39, 'ÇOBAN SALATA', 42, 3),
(27, 1, 'ÇAY', 321, 107);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`id`, `ad`, `durum`) VALUES
(1, 'İçecek', 1),
(2, 'Makarnalar', 0),
(3, 'kahvaltı', 0),
(4, 'Çorba', 0),
(5, 'pizza', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masalar`
--

CREATE TABLE `masalar` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `masalar`
--

INSERT INTO `masalar` (`id`, `ad`, `durum`) VALUES
(1, 'MASA 1', 1),
(2, 'MASA 2', 1),
(3, 'MASA 3', 1),
(4, 'MASA 4', 0),
(5, 'MASA 5', 1),
(6, 'MASA 6', 1),
(7, 'MASA 7', 1),
(8, 'MASA 8', 0),
(9, 'MASA 9', 0),
(10, 'MASA 10', 1),
(11, 'MASA 11', 0),
(12, 'MASA 12', 0),
(13, 'MASA 13', 0),
(14, 'MASA 14', 0),
(15, 'MASA 15', 1),
(16, 'MASA 16', 1),
(17, 'MASA 17', 0),
(18, 'MASA 18', 0),
(19, 'MASA 19', 0),
(20, 'MASA 20', 0),
(21, 'MASA 21', 0),
(22, 'MASA 22', 0),
(23, 'MASA 23', 0),
(24, 'MASA 24', 0),
(25, 'MASA 25', 0),
(26, 'MASA 26', 0),
(27, 'MASA 27', 0),
(28, 'MASA 28', 0),
(29, 'MASA 29', 0),
(30, 'MASA 30', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mutfaksiparis`
--

CREATE TABLE `mutfaksiparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL,
  `saat` int(11) NOT NULL DEFAULT 0,
  `dakika` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `mutfaksiparis`
--

INSERT INTO `mutfaksiparis` (`id`, `masaid`, `urunid`, `urunad`, `adet`, `saat`, `dakika`) VALUES
(27, 3, 34, 'KIYMA SOSLU MAKARNA', 3, 20, 51),
(28, 3, 62, 'STEAK HOUSE BURGER', 2, 20, 51),
(29, 3, 96, 'Sucuklu Omlet', 2, 20, 51),
(30, 3, 64, 'ROYAL BURGER', 5, 20, 51),
(31, 3, 58, 'SOĞAN HALKASI', 3, 20, 51),
(32, 2, 49, 'DOMATES ÇORBASI', 4, 20, 51),
(33, 2, 56, 'ADANA PORSİYON', 3, 20, 51),
(34, 10, 36, 'TONBALIKLI MAKARNA', 4, 20, 51),
(35, 10, 49, 'DOMATES ÇORBASI', 3, 20, 52),
(36, 10, 39, 'ÇOBAN SALATA', 3, 20, 52),
(37, 16, 40, 'KLEOPATRA SALATA', 3, 11, 54),
(38, 1, 7, 'mercimek', 5, 12, 4),
(39, 15, 7, 'mercimek', 6, 12, 5),
(40, 7, 8, 'tonbalıklı mk', 4, 12, 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

CREATE TABLE `rapor` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`id`, `masaid`, `urunid`, `urunad`, `urunfiyat`, `adet`, `tarih`) VALUES
(39, 1, 10, 'fanta', 5.5, 3, '2020-07-05'),
(40, 1, 12, 'shcwepss tonik', 5.5, 3, '2020-07-05'),
(41, 1, 5, 'Fuse Tea şeftali', 5.5, 4, '2020-07-05'),
(42, 6, 22, 'ada çayı', 7.5, 8, '2020-07-05'),
(43, 9, 8, 'meyveli soda', 5, 2, '2020-07-05'),
(44, 2, 8, 'meyveli soda', 5, 2, '2020-07-05'),
(45, 2, 8, 'meyveli soda', 5, 2, '2020-07-05'),
(46, 5, 4, 'coca-cola zero', 5.5, 6, '2020-07-05'),
(47, 1, 8, 'meyveli soda', 5, 7, '2020-07-05'),
(48, 1, 19, 'nane-limon', 9, 6, '2020-07-05'),
(49, 2, 3, 'coca-cola', 5.5, 6, '2020-07-07'),
(50, 2, 3, 'coca-cola', 5.5, 6, '2020-07-07'),
(51, 4, 28, 'kuzu şiş karışık', 38, 2, '2020-07-07'),
(52, 6, 8, 'meyveli soda', 5, 7, '2020-07-07'),
(53, 12, 3, 'coca-cola', 5.5, 6, '2020-07-07'),
(54, 1, 2, 'ÇAY DUBLE', 5, 2, '2020-07-08'),
(55, 1, 2, 'ÇAY DUBLE', 5, 2, '2020-07-08'),
(56, 1, 2, 'ÇAY DUBLE', 5, 2, '2020-07-08'),
(57, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 5, '2020-07-08'),
(58, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 5, '2020-07-08'),
(59, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 5, '2020-07-08'),
(60, 1, 36, 'TONBALIKLI MAKARNA', 14, 2, '2020-07-08'),
(61, 1, 2, 'ÇAY DUBLE', 5, 2, '2020-07-08'),
(62, 1, 2, 'ÇAY DUBLE', 5, 2, '2020-07-08'),
(63, 1, 36, 'TONBALIKLI MAKARNA', 14, 2, '2020-07-08'),
(64, 1, 36, 'TONBALIKLI MAKARNA', 14, 2, '2020-07-08'),
(65, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-08'),
(66, 1, 2, 'ÇAY DUBLE', 5, 2, '2020-07-08'),
(67, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 5, '2020-07-08'),
(68, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 5, '2020-07-08'),
(69, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-08'),
(70, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-08'),
(71, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 5, '2020-07-08'),
(72, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-08'),
(73, 1, 36, 'TONBALIKLI MAKARNA', 14, 2, '2020-07-08'),
(74, 1, 36, 'TONBALIKLI MAKARNA', 14, 2, '2020-07-08'),
(75, 1, 36, 'TONBALIKLI MAKARNA', 14, 2, '2020-07-08'),
(76, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-08'),
(77, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 5, '2020-07-08'),
(78, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-08'),
(79, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-08'),
(80, 1, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-08'),
(81, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-08'),
(82, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-08'),
(83, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 5, '2020-07-08'),
(84, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-08'),
(85, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 5, '2020-07-08'),
(86, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-08'),
(87, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-08'),
(88, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-08'),
(89, 1, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-08'),
(90, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 5, '2020-07-08'),
(91, 1, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-08'),
(92, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 5, '2020-07-08'),
(93, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 5, '2020-07-08'),
(94, 1, 65, 'CHEDAR BURGER', 16, 5, '2020-07-08'),
(95, 1, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-08'),
(96, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-08'),
(97, 1, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-08'),
(98, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-08'),
(99, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-08'),
(100, 1, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-08'),
(101, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-08'),
(102, 1, 65, 'CHEDAR BURGER', 16, 5, '2020-07-08'),
(103, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-08'),
(104, 1, 65, 'CHEDAR BURGER', 16, 5, '2020-07-08'),
(105, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-08'),
(106, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-08'),
(107, 1, 47, 'İŞKEMBE ÇORBASI', 18, 4, '2020-07-08'),
(108, 1, 65, 'CHEDAR BURGER', 16, 5, '2020-07-08'),
(109, 1, 65, 'CHEDAR BURGER', 16, 5, '2020-07-08'),
(110, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-08'),
(111, 1, 65, 'CHEDAR BURGER', 16, 5, '2020-07-08'),
(112, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-08'),
(113, 1, 47, 'İŞKEMBE ÇORBASI', 18, 4, '2020-07-08'),
(114, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-08'),
(115, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-08'),
(116, 1, 47, 'İŞKEMBE ÇORBASI', 18, 4, '2020-07-08'),
(117, 1, 47, 'İŞKEMBE ÇORBASI', 18, 4, '2020-07-08'),
(118, 1, 47, 'İŞKEMBE ÇORBASI', 18, 4, '2020-07-08'),
(119, 1, 47, 'İŞKEMBE ÇORBASI', 18, 4, '2020-07-08'),
(120, 2, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 4, '2020-07-08'),
(121, 3, 1, 'ÇAY', 3, 2, '2020-07-08'),
(122, 1, 1, 'ÇAY', 3, 6, '2020-07-10'),
(123, 1, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 2, '2020-07-10'),
(124, 5, 13, 'FİLTRE KAHVE', 8, 3, '2020-07-10'),
(125, 18, 32, 'KARIŞIK MEYVESUYU', 6, 5, '2020-07-10'),
(126, 1, 20, 'KOLA ŞEKERSİZ', 6, 2, '2020-07-10'),
(127, 1, 29, 'MEYVELİ FROZEN', 12.5, 3, '2020-07-10'),
(128, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-11'),
(129, 1, 14, 'TÜRK KAHVESİ', 7.5, 3, '2020-07-11'),
(130, 1, 6, 'KIŞ ÇAYI', 7.5, 2, '2020-07-11'),
(131, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 3, '2020-07-11'),
(132, 1, 35, 'İTALYAN MAKARNA', 14, 3, '2020-07-11'),
(133, 1, 57, 'PATATES KIZARTMASI', 8, 9, '2020-07-11'),
(134, 1, 62, 'STEAK HOUSE BURGER', 23, 9, '2020-07-11'),
(135, 1, 95, 'AYRAN', 6, 9, '2020-07-11'),
(136, 1, 9, 'SÜTLÜ KAHVE', 8, 2, '2020-07-11'),
(137, 1, 13, 'FİLTRE KAHVE', 8, 8, '2020-07-11'),
(138, 1, 7, 'PAPATYA ÇAYI', 7.5, 1, '2020-07-11'),
(139, 1, 5, 'NANE LİMON', 7.5, 2, '2020-07-14'),
(140, 1, 10, 'AMERİCANO KAHVE', 8, 6, '2020-07-14'),
(141, 1, 86, 'HAVYAR', 55, 2, '2020-07-14'),
(142, 1, 1, 'ÇAY', 3, 1, '2020-07-14'),
(143, 2, 24, 'KARPUZ FRAPPE', 12.5, 2, '2020-07-14'),
(144, 1, 9, 'SÜTLÜ KAHVE', 8, 2, '2020-07-15'),
(145, 1, 53, 'TAVUK GÖĞSÜ', 18, 3, '2020-07-15'),
(146, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 8, '2020-07-15'),
(147, 1, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-15'),
(148, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 3, '2020-07-15'),
(149, 1, 8, 'IHLAMUR', 7.5, 9, '2020-07-15'),
(150, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 9, '2020-07-15'),
(151, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 9, '2020-07-15'),
(152, 1, 54, 'KARIŞIK IZGARA', 42, 5, '2020-07-15'),
(153, 1, 54, 'KARIŞIK IZGARA', 42, 5, '2020-07-15'),
(154, 1, 17, 'MOCHA KAHVE', 12.5, 1, '2020-07-15'),
(155, 1, 17, 'MOCHA KAHVE', 12.5, 1, '2020-07-15'),
(156, 1, 3, 'KUŞ BURNU', 7.5, 2, '2020-07-15'),
(157, 1, 3, 'KUŞ BURNU', 7.5, 2, '2020-07-15'),
(158, 1, 33, 'ANANAS MEYVESUYU', 6, 3, '2020-07-15'),
(159, 1, 33, 'ANANAS MEYVESUYU', 6, 3, '2020-07-15'),
(160, 24, 37, 'KÖRİ SOSLU MAKARNA', 14, 6, '2020-07-20'),
(161, 24, 62, 'STEAK HOUSE BURGER', 23, 5, '2020-07-20'),
(162, 1, 11, 'ESPRESSO KAHVE', 8, 2, '2020-07-20'),
(163, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 1, '2020-07-20'),
(164, 1, 17, 'MOCHA KAHVE', 12.5, 2, '2020-07-20'),
(165, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 6, '2020-07-20'),
(166, 10, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 2, '2020-07-20'),
(167, 10, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-20'),
(168, 10, 56, 'ADANA PORSİYON', 24, 2, '2020-07-20'),
(169, 3, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-20'),
(170, 6, 28, 'VANİLYALI MİLKSHAKE', 12.5, 2, '2020-07-20'),
(171, 1, 1, 'ÇAY', 3, 1, '2020-07-20'),
(172, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 1, '2020-07-20'),
(173, 21, 31, 'KAYSI MEYVESUYU', 6, 2, '2020-07-20'),
(174, 21, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-20'),
(175, 14, 29, 'MEYVELİ FROZEN', 12.5, 1, '2020-07-20'),
(176, 14, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-20'),
(177, 15, 54, 'KARIŞIK IZGARA', 42, 2, '2020-07-20'),
(178, 15, 31, 'KAYSI MEYVESUYU', 6, 3, '2020-07-20'),
(179, 15, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-20'),
(180, 5, 28, 'VANİLYALI MİLKSHAKE', 12.5, 4, '2020-07-20'),
(181, 5, 24, 'KARPUZ FRAPPE', 12.5, 2, '2020-07-20'),
(182, 12, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-20'),
(183, 12, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 2, '2020-07-20'),
(184, 12, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-20'),
(185, 12, 31, 'KAYSI MEYVESUYU', 6, 2, '2020-07-20'),
(186, 7, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 2, '2020-07-20'),
(187, 7, 29, 'MEYVELİ FROZEN', 12.5, 6, '2020-07-20'),
(188, 2, 25, 'ÇİLEK FRAPPE', 12.5, 3, '2020-07-20'),
(189, 6, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 2, '2020-07-20'),
(190, 6, 28, 'VANİLYALI MİLKSHAKE', 12.5, 2, '2020-07-20'),
(191, 6, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-20'),
(192, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-20'),
(193, 1, 11, 'ESPRESSO KAHVE', 8, 2, '2020-07-20'),
(194, 7, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-20'),
(195, 7, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 6, '2020-07-20'),
(196, 7, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 6, '2020-07-20'),
(197, 13, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 2, '2020-07-20'),
(198, 13, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-20'),
(199, 1, 1, 'ÇAY', 3, 2, '2020-07-20'),
(200, 1, 1, 'ÇAY', 3, 2, '2020-07-20'),
(201, 1, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 10, '2020-07-20'),
(202, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-20'),
(203, 1, 62, 'STEAK HOUSE BURGER', 23, 19, '2020-07-20'),
(204, 1, 66, 'TAVUK BURGER', 13, 9, '2020-07-20'),
(205, 1, 65, 'CHEDAR BURGER', 16, 8, '2020-07-20'),
(206, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 8, '2020-07-20'),
(207, 1, 36, 'TONBALIKLI MAKARNA', 14, 3, '2020-07-20'),
(208, 1, 91, 'TAVUK FAJİTA', 18, 8, '2020-07-20'),
(209, 1, 49, 'DOMATES ÇORBASI', 9, 2, '2020-07-20'),
(210, 1, 63, 'KİNG BURGER', 18, 2, '2020-07-20'),
(211, 1, 9, 'SÜTLÜ KAHVE', 8, 1, '2020-07-20'),
(212, 1, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 6, '2020-07-20'),
(213, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 10, '2020-07-20'),
(214, 1, 41, 'DÖRT MEVSİM SALATA', 14, 2, '2020-07-20'),
(215, 1, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-20'),
(216, 1, 29, 'MEYVELİ FROZEN', 12.5, 7, '2020-07-20'),
(217, 1, 95, 'AYRAN', 6, 6, '2020-07-20'),
(218, 1, 17, 'MOCHA KAHVE', 12.5, 2, '2020-07-20'),
(219, 1, 1, 'ÇAY', 3, 2, '2020-07-20'),
(220, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 2, '2020-07-21'),
(221, 17, 57, 'PATATES KIZARTMASI', 8, 2, '2020-07-21'),
(222, 17, 57, 'PATATES KIZARTMASI', 8, 2, '2020-07-21'),
(223, 17, 56, 'ADANA PORSİYON', 24, 3, '2020-07-21'),
(224, 17, 56, 'ADANA PORSİYON', 24, 3, '2020-07-21'),
(225, 17, 36, 'TONBALIKLI MAKARNA', 14, 5, '2020-07-21'),
(226, 17, 36, 'TONBALIKLI MAKARNA', 14, 5, '2020-07-21'),
(227, 24, 37, 'KÖRİ SOSLU MAKARNA', 14, 3, '2020-07-21'),
(228, 24, 37, 'KÖRİ SOSLU MAKARNA', 14, 3, '2020-07-21'),
(229, 24, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 3, '2020-07-21'),
(230, 24, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 3, '2020-07-21'),
(231, 24, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 3, '2020-07-21'),
(232, 24, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 3, '2020-07-21'),
(233, 2, 32, 'KARIŞIK MEYVESUYU', 6, 2, '2020-07-21'),
(234, 2, 57, 'PATATES KIZARTMASI', 8, 1, '2020-07-21'),
(235, 2, 82, 'ANASONLU NARGİLE', 25, 2, '2020-07-21'),
(236, 2, 40, 'KLEOPATRA SALATA', 14, 3, '2020-07-21'),
(237, 2, 90, 'ET FAJİTA', 26, 2, '2020-07-21'),
(238, 6, 58, 'SOĞAN HALKASI', 8, 2, '2020-07-21'),
(239, 6, 57, 'PATATES KIZARTMASI', 8, 1, '2020-07-21'),
(240, 6, 59, 'ÇITIR TAVUK BUT', 12, 4, '2020-07-21'),
(241, 6, 62, 'STEAK HOUSE BURGER', 23, 1, '2020-07-21'),
(242, 6, 81, 'MEYVELİ NARGİLE', 25, 1, '2020-07-21'),
(243, 6, 36, 'TONBALIKLI MAKARNA', 14, 3, '2020-07-21'),
(244, 6, 62, 'STEAK HOUSE BURGER', 23, 3, '2020-07-21'),
(245, 6, 87, 'KALAMAR', 12, 4, '2020-07-21'),
(246, 7, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-21'),
(247, 7, 34, 'KIYMA SOSLU MAKARNA', 14, 5, '2020-07-21'),
(248, 7, 36, 'TONBALIKLI MAKARNA', 14, 4, '2020-07-21'),
(249, 14, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-21'),
(250, 14, 29, 'MEYVELİ FROZEN', 12.5, 7, '2020-07-21'),
(251, 14, 62, 'STEAK HOUSE BURGER', 23, 2, '2020-07-21'),
(252, 14, 80, 'OLMECA TEQUİLA 70 CL', 210, 3, '2020-07-21'),
(253, 12, 20, 'KOLA ŞEKERSİZ', 6, 2, '2020-07-21'),
(254, 12, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-21'),
(255, 12, 41, 'DÖRT MEVSİM SALATA', 14, 3, '2020-07-21'),
(256, 12, 56, 'ADANA PORSİYON', 24, 2, '2020-07-21'),
(257, 15, 56, 'ADANA PORSİYON', 24, 3, '2020-07-21'),
(258, 15, 86, 'HAVYAR', 55, 3, '2020-07-21'),
(259, 15, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-21'),
(260, 21, 40, 'KLEOPATRA SALATA', 14, 4, '2020-07-21'),
(261, 21, 41, 'DÖRT MEVSİM SALATA', 14, 1, '2020-07-21'),
(262, 27, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-21'),
(263, 27, 26, 'KARADUT FRAPPE', 12.5, 7, '2020-07-21'),
(264, 27, 84, 'SPECİAL NARGİLE', 35, 3, '2020-07-21'),
(265, 1, 14, 'TÜRK KAHVESİ', 7.5, 3, '2020-07-21'),
(266, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 3, '2020-07-21'),
(267, 1, 11, 'ESPRESSO KAHVE', 8, 3, '2020-07-22'),
(268, 1, 97, 'mantarlı omlet', 9, 3, '2020-07-22'),
(269, 15, 21, 'MANGO İCE TEA', 6, 4, '2020-07-22'),
(270, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-22'),
(271, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-22'),
(272, 1, 62, 'STEAK HOUSE BURGER', 23, 3, '2020-07-22'),
(273, 1, 62, 'STEAK HOUSE BURGER', 23, 3, '2020-07-22'),
(274, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 6, '2020-07-22'),
(275, 1, 37, 'KÖRİ SOSLU MAKARNA', 14, 6, '2020-07-22'),
(276, 1, 36, 'TONBALIKLI MAKARNA', 14, 6, '2020-07-22'),
(277, 1, 36, 'TONBALIKLI MAKARNA', 14, 6, '2020-07-22'),
(278, 10, 41, 'DÖRT MEVSİM SALATA', 14, 3, '2020-07-23'),
(279, 10, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 4, '2020-07-23'),
(280, 10, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-23'),
(281, 10, 32, 'KARIŞIK MEYVESUYU', 6, 3, '2020-07-23'),
(282, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 3, '2020-07-23'),
(283, 1, 62, 'STEAK HOUSE BURGER', 23, 2, '2020-07-23'),
(284, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 4, '2020-07-23'),
(285, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-23'),
(286, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 4, '2020-07-23'),
(287, 1, 48, 'MANTAR ÇORBASI', 9, 3, '2020-07-23'),
(288, 1, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-23'),
(289, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-23'),
(290, 1, 48, 'MANTAR ÇORBASI', 9, 3, '2020-07-23'),
(291, 1, 34, 'KIYMA SOSLU MAKARNA', 14, 2, '2020-07-23'),
(292, 23, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-26'),
(293, 23, 29, 'MEYVELİ FROZEN', 12.5, 2, '2020-07-26'),
(294, 1, 56, 'ADANA PORSİYON', 24, 4, '2020-07-26'),
(295, 1, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 5, '2020-07-26'),
(296, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 2, '2020-07-26'),
(297, 15, 37, 'KÖRİ SOSLU MAKARNA', 14, 2, '2020-07-26'),
(298, 19, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 3, '2020-07-26'),
(299, 19, 33, 'ANANAS MEYVESUYU', 6, 4, '2020-07-26'),
(300, 19, 30, 'ŞEFTALİ MEYVESUYU', 6, 3, '2020-07-26'),
(301, 19, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-26'),
(302, 19, 26, 'KARADUT FRAPPE', 12.5, 2, '2020-07-26'),
(303, 19, 41, 'DÖRT MEVSİM SALATA', 14, 3, '2020-07-26'),
(304, 19, 36, 'TONBALIKLI MAKARNA', 14, 3, '2020-07-26'),
(305, 19, 88, 'KARİDES', 25, 3, '2020-07-26'),
(306, 19, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 2, '2020-07-26'),
(307, 19, 70, 'TÜRKİSH SPECİAL PİZZA', 26, 3, '2020-07-26'),
(308, 1, 29, 'MEYVELİ FROZEN', 12.5, 5, '2020-07-26'),
(309, 1, 22, 'ŞEFTALİ İCE TEA', 6, 3, '2020-07-26'),
(310, 1, 26, 'KARADUT FRAPPE', 12.5, 3, '2020-07-26'),
(311, 1, 24, 'KARPUZ FRAPPE', 12.5, 8, '2020-07-26'),
(312, 1, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 4, '2020-07-26'),
(313, 1, 28, 'VANİLYALI MİLKSHAKE', 12.5, 2, '2020-07-26'),
(314, 2, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 3, '2020-07-26'),
(315, 2, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 5, '2020-07-26'),
(316, 2, 16, 'KAHVE SÜTÜ', 3, 2, '2020-07-26'),
(317, 2, 4, 'ADA ÇAYI', 7.5, 5, '2020-07-26'),
(318, 2, 11, 'ESPRESSO KAHVE', 8, 5, '2020-07-26'),
(319, 2, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-26'),
(320, 3, 12, 'ESPRESSO KAHVE DOUBLE', 12.5, 3, '2020-07-26'),
(321, 3, 27, 'ÇİKOLATALI MİLSHAKE', 12.5, 4, '2020-07-26'),
(322, 3, 28, 'VANİLYALI MİLKSHAKE', 12.5, 3, '2020-07-26'),
(323, 3, 34, 'KIYMA SOSLU MAKARNA', 14, 6, '2020-07-26'),
(324, 3, 62, 'STEAK HOUSE BURGER', 23, 2, '2020-07-26'),
(325, 3, 96, 'Sucuklu Omlet', 25, 2, '2020-07-26'),
(326, 3, 64, 'ROYAL BURGER', 12.5, 5, '2020-07-26'),
(327, 3, 58, 'SOĞAN HALKASI', 8, 3, '2020-07-26'),
(328, 10, 36, 'TONBALIKLI MAKARNA', 14, 4, '2020-07-28'),
(329, 10, 49, 'DOMATES ÇORBASI', 9, 3, '2020-07-28'),
(330, 10, 39, 'ÇOBAN SALATA', 14, 3, '2020-07-28'),
(331, 1, 1, 'ÇAY', 3, 5, '2020-07-29'),
(332, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(333, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(334, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(335, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(336, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(337, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(338, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(339, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(340, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(341, 1, 1, 'ÇAY', 3, 8, '2020-07-29'),
(342, 1, 1, 'ÇAY', 3, 4, '2020-07-29'),
(343, 1, 1, 'ÇAY', 3, 4, '2020-07-29'),
(344, 1, 15, 'TÜRK KAHVESİ SÜVARİ', 10, 3, '2020-07-29'),
(345, 1, 1, 'ÇAY', 3, 2, '2020-07-29'),
(346, 1, 1, 'ÇAY', 3, 2, '2020-07-29'),
(347, 1, 1, 'ÇAY', 3, 3, '2020-07-29'),
(348, 1, 1, 'ÇAY', 3, 3, '2020-07-29'),
(349, 1, 1, 'ÇAY', 3, 2, '2020-07-29'),
(350, 1, 1, 'ÇAY', 3, 2, '2020-07-29');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `katid` int(11) NOT NULL,
  `ad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `katid`, `ad`, `fiyat`, `stok`) VALUES
(1, 1, 'kola', 5, 500),
(2, 1, 'fanta', 5, 500),
(3, 1, 'sprite', 5, 500),
(4, 3, 'sahanda yumurta', 15, 200),
(5, 5, 'karışık pizza', 25, 100),
(6, 4, 'ezo gelin', 10, 25),
(7, 4, 'mercimek', 10, 25),
(8, 2, 'tonbalıklı mk', 15, 15);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetim`
--

CREATE TABLE `yonetim` (
  `id` int(11) NOT NULL,
  `kulad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `yetki` int(11) NOT NULL DEFAULT 0,
  `aktif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetim`
--

INSERT INTO `yonetim` (`id`, `kulad`, `sifre`, `yetki`, `aktif`) VALUES
(2, 'demo', '021c6cd3a69730ac97d0b65576a9004f', 1, 0),
(9, 'frodo', '021c6cd3a69730ac97d0b65576a9004f', 0, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anliksiparis`
--
ALTER TABLE `anliksiparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `barsiparis`
--
ALTER TABLE `barsiparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `doluluk`
--
ALTER TABLE `doluluk`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `garson`
--
ALTER TABLE `garson`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicimasa`
--
ALTER TABLE `gecicimasa`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `geciciurun`
--
ALTER TABLE `geciciurun`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `masalar`
--
ALTER TABLE `masalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mutfaksiparis`
--
ALTER TABLE `mutfaksiparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `rapor`
--
ALTER TABLE `rapor`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yonetim`
--
ALTER TABLE `yonetim`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anliksiparis`
--
ALTER TABLE `anliksiparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `barsiparis`
--
ALTER TABLE `barsiparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `doluluk`
--
ALTER TABLE `doluluk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `garson`
--
ALTER TABLE `garson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `gecicimasa`
--
ALTER TABLE `gecicimasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `geciciurun`
--
ALTER TABLE `geciciurun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `masalar`
--
ALTER TABLE `masalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `mutfaksiparis`
--
ALTER TABLE `mutfaksiparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Tablo için AUTO_INCREMENT değeri `rapor`
--
ALTER TABLE `rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `yonetim`
--
ALTER TABLE `yonetim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
