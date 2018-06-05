-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2018 at 12:23 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `multiversum`
--

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `product_EAN` char(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `path`, `product_EAN`) VALUES
(13, '5b1675ed65596.jpeg', '0471848768757'),
(14, '5b1675ed65683.jpeg', '0471848768757'),
(15, '5b1675ed656c5.jpeg', '0471848768757'),
(16, '5b1675ed6570d.jpeg', '0471848768757'),
(17, '5b1675ed6579a.jpeg', '0471848768757'),
(18, '5b1675ed65803.jpeg', '0471848768757'),
(19, '5b1675ed65853.jpeg', '0471848768757'),
(20, '5b1675ed658c5.jpeg', '0471848768757'),
(21, '5b16765fbd19f.jpeg', '0815820020103'),
(22, '5b167759d9483.jpeg', '0711719843757'),
(23, '5b167759d9559.jpeg', '0711719843757'),
(24, '5b167759d95db.jpeg', '0711719843757'),
(25, '5b167759d9652.jpeg', '0711719843757'),
(26, '5b167759d96d3.jpeg', '0711719843757'),
(27, '5b167759d9742.jpeg', '0711719843757'),
(28, '5b167759d9798.jpeg', '0711719843757'),
(29, '5b167759d97f6.png', '0711719843757'),
(30, '5b1677c28ec0c.jpeg', '0192018001602'),
(31, '5b1677c28ecc7.jpeg', '0192018001602'),
(32, '5b1677c28ed42.jpeg', '0192018001602'),
(33, '5b167851bc3a3.png', '0815820020004'),
(34, '5b167851bc494.png', '0815820020004'),
(35, '5b167851bc577.jpeg', '0815820020004'),
(36, '5b1678d7a6564.png', '0711719880868'),
(37, '5b1678d7a65f0.jpeg', '0711719880868'),
(38, '5b1678d7a6689.jpeg', '0711719880868'),
(39, '5b1678d7a6704.jpeg', '0711719880868'),
(40, '5b1678d7a6779.jpeg', '0711719880868'),
(41, '5b1678d7a67cf.jpeg', '0711719880868'),
(42, '5b1678d7a681d.jpeg', '0711719880868'),
(43, '5b1678d7a686d.jpeg', '0711719880868'),
(44, '5b1678d7a68c7.png', '0711719880868'),
(45, '5b167934cb9a9.png', '4718487708185'),
(46, '5b167934cba05.png', '4718487708185'),
(47, '5b167934cba39.png', '4718487708185'),
(48, '5b167934cba68.png', '4718487708185'),
(49, '5b167934cba99.png', '4718487708185'),
(50, '5b167934cbacf.png', '4718487708185'),
(51, '5b1679d3a217c.jpeg', '4015625616662'),
(52, '5b1679d3a22b1.jpeg', '4015625616662'),
(53, '5b1679d3a2338.jpeg', '4015625616662'),
(54, '5b1679d3a23ea.jpeg', '4015625616662'),
(55, '5b1679d3a2487.jpeg', '4015625616662'),
(56, '5b1679d3a2534.jpeg', '4015625616662'),
(57, '5b167a5e4a707.jpeg', '0780437918016'),
(58, '5b167a5e4a788.jpeg', '0780437918016'),
(59, '5b167a5e4a7d8.jpeg', '0780437918016'),
(60, '5b167a5e4a81a.jpeg', '0780437918016'),
(61, '5b167a5e4a85b.jpeg', '0780437918016'),
(62, '5b167a5e4a8ad.jpeg', '0780437918016'),
(63, '5b167bd42975f.png', '8806088773391'),
(64, '5b167bd4297c9.png', '8806088773391'),
(65, '5b167bd42981a.png', '8806088773391'),
(68, '5b167e7b79f26.jpeg', '0191999086226'),
(69, '5b167e7b79fa7.jpeg', '0191999086226'),
(70, '5b167e7b79ffb.jpeg', '0191999086226'),
(71, '5b167eee9ebe3.png', '4713883398558'),
(72, '5b167eee9ec5c.png', '4713883398558'),
(73, '5b167eee9ecce.png', '4713883398558');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prijs` decimal(9,2) NOT NULL,
  `voornaam` varchar(255) NOT NULL,
  `tussenvoegsel` varchar(45) DEFAULT NULL,
  `achternaam` varchar(255) NOT NULL,
  `telefoon nummer` varchar(45) DEFAULT NULL,
  `iban` varchar(34) NOT NULL,
  `aanhef` tinyint(1) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `straat` varchar(255) NOT NULL,
  `huisnummer` int(11) NOT NULL,
  `huisnummer toevoeging` varchar(10) DEFAULT NULL,
  `postcode` varchar(6) NOT NULL,
  `land` varchar(255) DEFAULT NULL,
  `stad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_has_product`
--

CREATE TABLE `order_has_product` (
  `order_id` int(11) NOT NULL,
  `product_EAN` char(13) NOT NULL,
  `aantal` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `EAN` char(13) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs` decimal(9,2) NOT NULL,
  `beschrijving` text NOT NULL,
  `merk` varchar(255) NOT NULL,
  `resolutie` varchar(100) DEFAULT NULL,
  `refresh rate` int(11) DEFAULT NULL,
  `gezichtsveld` int(3) DEFAULT NULL,
  `aansluitingen` text,
  `accessoires` text,
  `accelerometer` tinyint(1) DEFAULT NULL,
  `camera` tinyint(1) DEFAULT NULL,
  `gyroscoop` tinyint(1) DEFAULT NULL,
  `verstelbare lenzen` tinyint(1) DEFAULT NULL,
  `kleur` varchar(45) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `korting` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`EAN`, `naam`, `prijs`, `beschrijving`, `merk`, `resolutie`, `refresh rate`, `gezichtsveld`, `aansluitingen`, `accessoires`, `accelerometer`, `camera`, `gyroscoop`, `verstelbare lenzen`, `kleur`, `platform`, `korting`) VALUES
('0191999086226', 'Explorer Headset', '456.55', '', 'Lenovo', '2880x1440', 90, 110, 'USB 3.0', '', 1, 1, 1, 0, 'Zwart', 'PC', NULL),
('0192018001602', 'Windows Mixed Reality headset', '399.00', '', 'HP', '2880x1440', 90, 95, '3.5mm, HDMI, USB 3.0', 'Controller(s), Headset bedraad, Kabels', 1, 1, 1, 0, 'Zwart', 'PC', NULL),
('0471848768757', 'Vive', '599.00', '', 'HTC', '2160x1200', 90, 110, 'HDMI, USB 2.0, USB 3.0', 'Controller(s), Headset bedraad, Kabels', 1, 1, 1, 1, 'Zwart', 'PC', NULL),
('0711719843757', 'Playstation VR', '229.00', '', 'Sony', '1920x1080', 90, 100, 'HDMI, USB 2.0', 'Headset bedraad, Kabels', 1, 0, 1, 0, 'Zwart', 'PlayStation 4', NULL),
('0711719880868', 'PlayStation VR + VR Worlds + PS Camera', '249.00', '', 'Sony', '1920x180', 90, 100, 'HDMI, USB 2.0', 'Headset bedraad, Kabels', 1, 0, 1, 0, 'Zwart', 'PlayStation 4', NULL),
('0780437918016', 'Galaxy Gear VR (v2)', '59.90', '', 'Samsung', NULL, NULL, 96, '', '', 1, 0, 1, 0, 'Wit', 'Smartphone', NULL),
('0815820020004', 'Rift', '549.00', '', 'Oculus', '2160x1200', 90, 110, 'HDMI, USB 2.0, 3x USB 3.0', 'Afstandbediening, Controller(s), Kabels', 1, 0, 1, 0, 'Zwart', 'PC', NULL),
('0815820020103', 'Rift Bundle (Rift + Touch)', '449.00', '', 'Oculus', '2160x1200', 90, 110, 'HDMI, USB 2.0, 3x USB 3.0', 'Afstandbediening, Controller(s)', 1, 0, 1, 0, 'Zilver', 'PC', NULL),
('4015625616662', 'Erazer X1000 Mixed Reality Headset', '449.00', '', 'Medion', '2880x1440', 90, 110, '3.5mm, HDMI, USB 2.0', 'Controller(s), Headset bedraad', 1, 1, 1, 0, 'Blauw, Zwart', 'PC', NULL),
('4713883398558', 'Mixed Reality Headset', '389.69', '', 'Acer', '2880x1440', 90, 100, 'HDMI, USB 3.0', 'Controller(s), Headset bedraad', 1, 1, 1, 0, 'Blauw', 'PC', NULL),
('4718487708185', 'Vive pro', '879.00', '', 'HTC', '2880x1600', 90, 110, '3.5mm, USB 3.0 (Type-C)', '', 0, 1, 0, 1, 'Blauw, Zwart', 'PC', NULL),
('8806088773391', 'New Gear VR + Gear VR Controller', '121.59', '', 'Samsung', NULL, NULL, 101, '', '', 1, 0, 1, 0, 'Zwart', 'Smartphone', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_image_product_idx` (`product_EAN`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD PRIMARY KEY (`order_id`,`product_EAN`),
  ADD KEY `fk_order_has_product_product1_idx` (`product_EAN`),
  ADD KEY `fk_order_has_product_order1_idx` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`EAN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_product` FOREIGN KEY (`product_EAN`) REFERENCES `product` (`EAN`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD CONSTRAINT `fk_order_has_product_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_has_product_product1` FOREIGN KEY (`product_EAN`) REFERENCES `product` (`EAN`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
