-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2020 at 07:51 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vue_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(60) NOT NULL,
  `category_description` varchar(255) DEFAULT NULL,
  `category_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`, `category_created_at`) VALUES
(1, 'Smart Phone', 'some description about Smart phone', '2020-10-27 00:19:40'),
(2, 'Laptop', NULL, '2020-10-27 00:19:40'),
(8, 'Bread', 'sasdfwhight Breadasdfsdfsdfkssdib', '2020-10-27 05:40:55'),
(15, 'Notebook', NULL, '2020-10-30 05:25:45'),
(16, 'Tab', '', '2020-11-01 10:09:14'),
(17, 'Bluetooth Head Phone ', '', '2020-11-04 16:02:15'),
(18, 'Pet', 'pet to sell', '2020-11-21 00:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `order_id` int(11) UNSIGNED NOT NULL,
  `customer_fullname` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` int(15) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(5) NOT NULL,
  `payment_method` varchar(60) NOT NULL,
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(5) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_category_id` int(5) NOT NULL,
  `product_supplier_id` int(5) NOT NULL,
  `product_description` varchar(255) DEFAULT NULL,
  `product_image` varchar(60) DEFAULT NULL,
  `product_price` int(11) NOT NULL,
  `product_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_category_id`, `product_supplier_id`, `product_description`, `product_image`, `product_price`, `product_created_at`) VALUES
(1, 'HP Notebook', 15, 14, NULL, 'uploads/1606359982.png', 70, '2020-10-30 05:28:15'),
(2, 'Nokia 5', 1, 1, NULL, NULL, 0, '2020-10-30 05:28:15'),
(3, 'Xiomi MI A1', 1, 4, NULL, NULL, 0, '2020-10-30 05:28:15'),
(5, 'iPad mini', 16, 3, 'Release in 2020', '', 599, '2020-11-01 10:23:09'),
(10, 'iPad Pro', 16, 3, 'new 2020 a14 bionic', 'uploads/1604286472.jpg', 899, '2020-11-02 03:07:52'),
(12, 'iPhone 12', 1, 3, 'A14 bianic. Good camera.', 'uploads/1604293499.jpg', 799, '2020-11-02 05:04:59'),
(13, 'Sound Bud', 17, 11, 'Good quality head phone. 9 hours of battery life.', 'uploads/1604505839.jpg', 50, '2020-11-04 16:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(60) NOT NULL,
  `supplier_description` varchar(255) DEFAULT NULL,
  `supplier_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_description`, `supplier_created_at`) VALUES
(1, 'Nokia', NULL, '2020-10-28 12:34:05'),
(2, 'Samsung', NULL, '2020-10-28 12:34:05'),
(3, 'Apple', NULL, '2020-10-28 12:34:05'),
(4, 'Xiome', NULL, '2020-10-28 12:34:05'),
(5, 'Sony', NULL, '2020-10-28 12:34:05'),
(6, 'Vivo', NULL, '2020-10-28 12:34:05'),
(7, 'LG', NULL, '2020-10-28 12:34:05'),
(8, 'MI', '', '2020-10-28 13:15:20'),
(9, 'Asus', NULL, '2020-10-28 13:16:09'),
(14, 'HP', NULL, '2020-10-30 05:26:29'),
(15, 'Logitech', 'good brand', '2020-10-30 10:53:21'),
(16, 'INTEL', 'good', '2020-10-30 10:53:51'),
(17, 'Logitech', NULL, '2020-10-30 10:55:07'),
(18, 'Logitech', NULL, '2020-10-30 10:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(99) NOT NULL,
  `email` varchar(99) NOT NULL,
  `password` varchar(99) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'sakib', 'sakib@email.com', 'sakib', '2020-10-17 04:43:21'),
(2, 'nazmos', 'nazmos@nazmos.com', 'nazmos', '2020-10-25 00:30:33'),
(3, 'BR Khan', 'khan@khan.com', 'khankhan', '2020-10-25 01:34:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
