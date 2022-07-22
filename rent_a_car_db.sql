-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2022 at 03:43 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent_a_car_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `country_id` bigint(20) NOT NULL,
  `passport_number` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `country_id`, `passport_number`, `email`, `password`, `is_admin`) VALUES
(1, 'Marko', 'Markovic', 2, '457289', 'marko@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1),
(2, 'Marija', 'Ivanovic', 2, '5552324', 'marija@gmail.com', '202cb962ac59075b964b07152d234b70', 0),
(3, 'Janko', 'Jankovic', 1, '5552345', 'janko@gmail.com', '044879399025a6ac6f2c20fb8f86577d', 0),
(5, 'Vuk', 'Vukovic', 2, '222333', 'vuk@gmail.com', '5a1001075d3205d010ef24413e6a1afd', 0),
(6, 'Marija', 'Markovic', 2, '135732', 'marija123@gmail.com', 'bcbe3365e6ac95ea2c0343a2395834dd', 0),
(7, 'Milos', 'Minic', 6, '5231234', 'milos@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f', 0),
(8, 'Lazar', 'Lazarevic', 6, '2020331', 'lazar@gmail.com', '4f2a9cd22f7d4d07f62438e54684ae4a', 0);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Srbija'),
(2, 'Crna Gora'),
(6, 'BIH');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) NOT NULL,
  `vehicle_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `date_from` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_up_to` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` double NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `vehicle_id`, `client_id`, `date_from`, `date_up_to`, `price`, `is_active`) VALUES
(1, 2, 3, '2022-07-07 10:48:40', '2022-07-15 10:48:40', 270, 1),
(2, 1, 2, '2022-07-28 11:34:49', '2022-08-04 11:34:49', 200, 0),
(3, 20, 3, '2022-07-29 08:02:45', '2022-08-05 08:02:45', 300, 1),
(4, 20, 3, '2022-06-30 08:04:40', '2022-07-03 08:04:40', 100, 0),
(8, 20, 2, '2022-08-18 22:00:00', '2022-08-21 22:00:00', 75, 0),
(9, 21, 3, '2022-07-29 22:00:00', '2022-08-08 22:00:00', 370, 1),
(10, 20, 3, '2022-08-04 22:00:00', '2022-08-09 22:00:00', 125, 1),
(13, 21, 2, '2022-08-19 22:00:00', '2022-08-23 22:00:00', 148, 1),
(14, 20, 5, '2022-07-22 22:00:00', '2022-07-25 22:00:00', 75, 0),
(15, 23, 6, '2022-07-22 22:00:00', '2022-07-27 22:00:00', 350, 0),
(16, 1, 6, '2022-07-22 22:00:00', '2022-07-28 22:00:00', 210, 1),
(17, 23, 2, '2022-12-26 23:00:00', '2023-01-02 23:00:00', 490, 1),
(18, 1, 2, '2022-12-27 23:00:00', '2023-01-04 23:00:00', 364, 0),
(19, 2, 2, '2023-01-06 23:00:00', '2023-01-13 23:00:00', 210, 1),
(20, 29, 2, '2022-08-03 22:00:00', '2022-08-11 22:00:00', 152, 1),
(21, 2, 7, '2022-07-22 22:00:00', '2022-07-27 22:00:00', 150, 1),
(22, 21, 8, '2022-07-22 22:00:00', '2022-07-29 22:00:00', 259, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) NOT NULL,
  `registry_number` varchar(255) COLLATE utf8_bin NOT NULL,
  `manufacturer_id` bigint(20) NOT NULL,
  `model_id` bigint(20) NOT NULL,
  `year_released` varchar(255) COLLATE utf8_bin NOT NULL,
  `vehicle_class_id` bigint(20) NOT NULL,
  `price_per_day` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `registry_number`, `manufacturer_id`, `model_id`, `year_released`, `vehicle_class_id`, `price_per_day`) VALUES
(1, 'PG-JF-112', 1, 1, '2012', 3, 45.5),
(2, 'PG-AA-111', 2, 2, '2008', 1, 30),
(20, 'PG-JF-123', 1, 31, '2018', 3, 25),
(21, 'PG-JF-199', 5, 32, '2015', 2, 37),
(23, 'PG-JC-444', 2, 34, '2017', 1, 70),
(27, 'PG-JC-888', 1, 40, '2018', 3, 55),
(29, 'PG-JC-345', 5, 42, '2005', 2, 19);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_class`
--

CREATE TABLE `vehicle_class` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vehicle_class`
--

INSERT INTO `vehicle_class` (`id`, `name`) VALUES
(1, 'Luxury'),
(2, 'Economy'),
(3, 'Business');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_images`
--

CREATE TABLE `vehicle_images` (
  `id` bigint(20) NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  `vehicle_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vehicle_images`
--

INSERT INTO `vehicle_images` (`id`, `path`, `vehicle_id`) VALUES
(25, '../uploads/62d31f7a0a753.PNG', 21),
(26, '../uploads/62d31f7a0baf3.PNG', 21),
(40, '../uploads/62d536670edbd.PNG', 20),
(41, '../uploads/62d536670fe92.PNG', 20),
(42, '../uploads/62d5366710f95.PNG', 20),
(58, '../uploads/62d539016a26b.PNG', 2),
(59, '../uploads/62d539016acdb.PNG', 2),
(60, '../uploads/62d539016b377.PNG', 2),
(62, '../uploads/62d8000919c14.PNG', 23),
(65, '../uploads/62d8002827f1c.PNG', 23),
(67, '../uploads/62d800282af3f.PNG', 23),
(68, '../uploads/62d800282bcd2.PNG', 23),
(74, '../uploads/62da8263ca3e3.PNG', 1),
(75, '../uploads/62da8263cb813.PNG', 1),
(76, '../uploads/62da8263cc9d3.PNG', 1),
(77, '../uploads/62da83116caf6.PNG', 27),
(79, '../uploads/62da83116e996.PNG', 27),
(80, '../uploads/62da83116f56f.PNG', 27),
(84, '../uploads/62da8372353b1.PNG', 29),
(85, '../uploads/62da837236b02.PNG', 29),
(86, '../uploads/62da837237f0f.PNG', 29),
(90, '../uploads/62da880927618.PNG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_manufacturer`
--

CREATE TABLE `vehicle_manufacturer` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vehicle_manufacturer`
--

INSERT INTO `vehicle_manufacturer` (`id`, `name`) VALUES
(1, 'Audi'),
(2, 'BMW'),
(5, 'VW');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_model`
--

CREATE TABLE `vehicle_model` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `manufacturer_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `vehicle_model`
--

INSERT INTO `vehicle_model` (`id`, `name`, `manufacturer_id`) VALUES
(1, 'A6', 1),
(2, 'X6', 2),
(31, 'A4', 1),
(32, 'GOLF VII', 5),
(34, 'M4', 2),
(40, 'A8', 1),
(42, 'Golf V', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_clients_countries` (`country_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservations_clients` (`client_id`),
  ADD KEY `fk_reservations_vehicles` (`vehicle_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registry_number` (`registry_number`),
  ADD KEY `fk_vehicle_class_vehicles` (`vehicle_class_id`),
  ADD KEY `fk_vehicle_manufacturer_vehicles` (`manufacturer_id`),
  ADD KEY `fk_vehicle_vehicle_model` (`model_id`);

--
-- Indexes for table `vehicle_class`
--
ALTER TABLE `vehicle_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vehicle_images_vehicles` (`vehicle_id`);

--
-- Indexes for table `vehicle_manufacturer`
--
ALTER TABLE `vehicle_manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_model`
--
ALTER TABLE `vehicle_model`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vehicle_model_vehicle_manufacturer` (`manufacturer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `vehicle_class`
--
ALTER TABLE `vehicle_class`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `vehicle_manufacturer`
--
ALTER TABLE `vehicle_manufacturer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vehicle_model`
--
ALTER TABLE `vehicle_model`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_clients_countries` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_clients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `fk_reservations_vehicles` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `fk_vehicle_class_vehicles` FOREIGN KEY (`vehicle_class_id`) REFERENCES `vehicle_class` (`id`),
  ADD CONSTRAINT `fk_vehicle_manufacturer_vehicles` FOREIGN KEY (`manufacturer_id`) REFERENCES `vehicle_manufacturer` (`id`),
  ADD CONSTRAINT `fk_vehicle_vehicle_model` FOREIGN KEY (`model_id`) REFERENCES `vehicle_model` (`id`);

--
-- Constraints for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD CONSTRAINT `fk_vehicle_images_vehicles` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `vehicle_model`
--
ALTER TABLE `vehicle_model`
  ADD CONSTRAINT `fk_vehicle_model_vehicle_manufacturer` FOREIGN KEY (`manufacturer_id`) REFERENCES `vehicle_manufacturer` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
