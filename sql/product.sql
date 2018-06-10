-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 10, 2018 at 07:46 PM
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

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`EAN`, `naam`, `prijs`, `beschrijving`, `merk`, `resolutie`, `refresh rate`, `gezichtsveld`, `aansluitingen`, `accessoires`, `accelerometer`, `camera`, `gyroscoop`, `verstelbare lenzen`, `magnetometer`, `koptelefoon`, `microfoon`, `kleur`, `platform`, `korting`) VALUES
('0187774000891', 'iWear Video Headphones ', '277.44', '', 'Vuzix', '1280x720', 60, 55, 'HDMI, USB 2.0', 'Kabels', 1, 0, 1, 0, 1, 1, 1, 'Zwart', 'PC, PlayStation 4, Smartphone, Xbox One', NULL),
('0191999086226', 'Explorer Headset', '456.55', '', 'Lenovo', '2880x1440', 90, 110, 'USB 3.0', '', 1, 1, 1, 0, 1, 0, 0, 'Zwart', 'PC', NULL),
('0192018001602', 'Windows Mixed Reality headset', '399.00', '', 'HP', '2880x1440', 90, 95, '3.5mm, HDMI, USB 3.0', 'Controller(s), Headset bedraad, Kabels', 1, 1, 1, 0, 0, 0, 0, 'Zwart', 'PC', NULL),
('0471848768757', 'Vive', '599.00', '', 'HTC', '2160x1200', 90, 110, 'HDMI, USB 2.0, USB 3.0', 'Controller(s), Headset bedraad, Kabels', 1, 1, 1, 1, 0, 0, 0, 'Zwart', 'PC', NULL),
('0711719843757', 'Playstation VR', '229.00', '', 'Sony', '1920x1080', 90, 100, 'HDMI, USB 2.0', 'Headset bedraad, Kabels', 1, 0, 1, 0, 0, 0, 0, 'Zwart', 'PlayStation 4', NULL),
('0711719880868', 'PlayStation VR + VR Worlds + PS Camera', '249.00', '', 'Sony', '1920x1080', 90, 100, 'HDMI, USB 2.0', 'Headset bedraad, Kabels', 1, 0, 1, 0, 0, 0, 0, 'Zwart', 'PlayStation 4', NULL),
('0780437918016', 'Galaxy Gear VR (v2)', '59.90', '', 'Samsung', NULL, NULL, 96, '', '', 1, 0, 1, 0, 0, 0, 0, 'Wit', 'Smartphone', NULL),
('0815820020004', 'Rift', '549.00', '', 'Oculus', '2160x1200', 90, 110, 'HDMI, USB 2.0, 3x USB 3.0', 'Afstandbediening, Controller(s), Kabels', 1, 0, 1, 0, 1, 1, 0, 'Zwart', 'PC', NULL),
('0815820020103', 'Rift Bundle (Rift + Touch)', '449.00', '', 'Oculus', '2160x1200', 90, 110, 'HDMI, USB 2.0, 3x USB 3.0', 'Afstandbediening, Controller(s)', 1, 0, 1, 0, 1, 1, 0, 'Zilver', 'PC', NULL),
('0841698100029', 'Glyph', '296.00', '', 'Avegant', '1280x720', 120, 40, 'HDMI', '	Koptelefoon, Verstelbare lenzen', 0, 0, 0, 1, 0, 1, 0, 'Wit', '', NULL),
('0884116285380', 'Visor + ViIsor controllers ', '364.33', '	Windows Mixed Reality headset\r\nTe bedienen met: Motion controllers, Xbox-controller, Toetsenbord en muis, Cortana Voice.\r\n\r\nInclusief 2x Dell Visor controllers.', 'Dell', '2880x1440', 90, 110, '3.5mm, HDMI, USB 3.0', '	Headset bedraad', 1, 1, 1, 0, 1, 0, 0, '', 'PC', NULL),
('3760071190020', 'Smartphone Virtual Reality Headset', '35.00', '	Inclusief: 1 paar lenzen, 3 paar lenshouders, opbergtas, hoofdband', 'Homido', NULL, NULL, NULL, '', '1 paar lenzen, 3 paar lenshouders, opbergtas, hoofdband', 1, 0, 1, 1, 0, 0, 0, 'Zwart', 'Smartphone', NULL),
('4015625616662', 'Erazer X1000 Mixed Reality Headset', '449.00', '', 'Medion', '2880x1440', 90, 110, '3.5mm, HDMI, USB 2.0', 'Controller(s), Headset bedraad', 1, 1, 1, 0, 0, 0, 1, 'Blauw, Zwart', 'PC', NULL),
('4047865190398', 'Zeiss VR One Plus', '56.82', '	Smartphones with display size between 4.7 and 5.5 inches except LG G4 and SONY XPERIA Z5 Premium', 'Carl Zeiss', NULL, NULL, 100, '', '', 0, 0, 0, 1, 0, 0, 0, 'Wit', 'Smartphone', NULL),
('4713883398558', 'Mixed Reality Headset', '389.69', '', 'Acer', '2880x1440', 90, 100, 'HDMI, USB 3.0', 'Controller(s), Headset bedraad', 1, 1, 1, 0, 0, 0, 0, 'Blauw', 'PC', NULL),
('4718487692866', 'Vive Business Edition ', '1389.00', 'De Vive Business Edition wordt geleverd met de headset, twee draadloze controllers, een Vive Link Box, oordopjes en twee Vive-basisstations en Dedicated Business Edition customer support line.', 'HTC', '2160x1200', 90, NULL, '	HDMI, USB 2.0, USB 3.0', '	Controller(s), Headset bedraad, Kabels', 1, 1, 1, 1, 0, 0, 0, '', 'PC', NULL),
('4718487708185', 'Vive pro', '879.00', '', 'HTC', '2880x1600', 90, 110, '3.5mm, USB 3.0 (Type-C)', '', 0, 1, 0, 1, 0, 1, 1, 'Blauw, Zwart', 'PC', NULL),
('5412810223176', 'Virtual Reality ', '39.93', '', 'König', NULL, NULL, NULL, '', '', 0, 0, 0, 0, 0, 0, 0, 'Zwart', 'Smartphone', NULL),
('6941921144159', 'Hyper BoboVR Z4', '39.95', '', 'Hyper Bobo', NULL, NULL, 120, '', '', 0, 0, 0, 0, 0, 0, 0, 'Wit', 'Smartphone', NULL),
('8713439213225', 'Trust GXT 720 3D Virtual Reality Glasses', '32.99', '', 'Trust', '120x110', NULL, NULL, '', '	Controller(s)', 0, 0, 0, 0, 0, 0, 0, 'Zwart', 'Smartphone', NULL),
('8718722130593', 'VR Shinecon VR Bril Zwart ', '24.95', '', 'VR Shinecon', NULL, NULL, NULL, '', '', 0, 0, 0, 1, 0, 0, 0, 'Zwart', 'Smartphone', NULL),
('8718868990570', 'VR Gecko', '24.95', '', 'Salora', NULL, NULL, NULL, '', '', 0, 0, 0, 0, 0, 0, 0, 'Wit', 'Smartphone', NULL),
('8801643063863', 'Gear VR 4 + Gear VR Controller ', '114.95', '	Werkt met Samsung Galaxy Note 8, S8, S8 Plus of S7 Edge, S7, S6 edge Plus, S6', 'Samsung', '207x98', NULL, NULL, '', '	Controller(s)', 1, 0, 1, 0, 0, 0, 0, '	Zwart', 'Smartphone', NULL),
('8806088503141', 'Gear VR 2', '79.90', '	Geschikt voor:\r\nSamsung Galaxy S6\r\nSamsung Galaxy S6 Edge\r\nSamsung Galaxy S6 Edge+\r\nSamsung Galaxy S7\r\nSamsung Galaxy S7 Edge\r\nSamsung Galaxy Note 7', 'Samsung', '207x98', NULL, NULL, '', '', 1, 0, 1, 0, 0, 0, 0, 'Zwart', 'Smartphone', NULL),
('8806088773391', 'New Gear VR + Gear VR Controller', '121.59', '', 'Samsung', NULL, NULL, 101, '', '', 1, 0, 1, 0, 0, 0, 0, 'Zwart', 'Smartphone', NULL),
('8917164709174', 'test1', '599.00', 'dinges', 'test', '1024x1024', 90, 110, '', '', 0, 1, 1, 1, 1, 1, 1, 'dinges', 'dinges', '550.00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
