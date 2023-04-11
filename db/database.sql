-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 06:11 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inverntory`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `First` varchar(255) DEFAULT NULL,
  `Middle` varchar(255) DEFAULT NULL,
  `Last` varchar(255) DEFAULT NULL,
  `ProductId` int(11) UNSIGNED NOT NULL,
  `NumberShipped` int(11) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `Title`, `First`, `Middle`, `Last`, `ProductId`, `NumberShipped`, `OrderDate`) VALUES
(44, NULL, 'admin', NULL, 'admin', 32, 5, '0000-00-00'),
(45, NULL, 'admin', NULL, NULL, 33, 99, '0000-00-00'),
(46, NULL, 'admin', NULL, 'admin', 33, 10, '2023-02-09');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `PartNumber` varchar(255) DEFAULT NULL,
  `ProductLabel` varchar(255) DEFAULT NULL,
  `StartingInventory` int(11) DEFAULT NULL,
  `InventoryReceived` int(11) DEFAULT NULL,
  `InventoryShipped` int(11) DEFAULT NULL,
  `InventoryOnHand` int(11) DEFAULT NULL,
  `MinimumRequired` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `ProductName`, `PartNumber`, `ProductLabel`, `StartingInventory`, `InventoryReceived`, `InventoryShipped`, `InventoryOnHand`, `MinimumRequired`) VALUES
(32, 'Server Box Std.', 'SBS1', 'HP Server Box Std.', 100, 1, 3, 1, 0),
(33, 'Server Box Premium', 'SBP1', 'DELL Server Box Premium', 100, 202, 109, 93, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) UNSIGNED NOT NULL,
  `SupplierId` int(11) UNSIGNED NOT NULL,
  `ProductId` int(11) UNSIGNED NOT NULL,
  `NumberReceived` int(11) NOT NULL,
  `PurchaseDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `SupplierId`, `ProductId`, `NumberReceived`, `PurchaseDate`) VALUES
(53, 56, 32, 1, '0000-00-00'),
(54, 58, 33, 3, '0000-00-00'),
(55, 56, 33, 100, '0000-00-00'),
(56, 56, 33, 99, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) UNSIGNED NOT NULL,
  `supplier` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier`) VALUES
(56, 'HP'),
(57, 'Apple'),
(58, 'Dell');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `IsActive` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` varchar(11) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `UpdateDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `IsActive`, `email`, `level`, `CreateDate`, `UpdateDate`) VALUES
(29, 'admin', 'admin', 'admin', 1, 'admin@stock.com', 'admin', '2023-02-24 07:49:34', NULL),
(30, 'user', 'user', 'user', 1, 'user@stock.com', 'user', '2023-02-24 09:05:21', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_fk` (`ProductId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_product_fk` (`ProductId`),
  ADD KEY `purchase_supplier_fk` (`SupplierId`),
  ADD KEY `SupplierId` (`SupplierId`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_product_fk` FOREIGN KEY (`ProductId`) REFERENCES `products` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchase_product_fk` FOREIGN KEY (`ProductId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `purchase_supplier_fk` FOREIGN KEY (`SupplierId`) REFERENCES `suppliers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
