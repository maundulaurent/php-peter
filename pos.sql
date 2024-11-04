-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 11:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(10, 'Hair', 'Hair styling products: Gel, mousse, hairspray, wax Hair color: Permanent, semi-permanent, temporary Hair accessories: Clips, bands, headbands'),
(11, 'Fragrances', 'Perfume, Cologne, Air  fresheners, Car Fresheners'),
(12, 'Skincare Tools', 'Makeup brushes, Beauty sponges, Facial rollers, Tweezers, Nail clippers'),
(13, 'Face', 'Makeup: Foundation, concealer, powder, blush, bronzer, highlighter Skincare: Cleanser, toner, moisturizer, serum, eye cream, mask, exfoliator, sunscreen'),
(16, 'Nails', 'Nail polish: Regular, gel, nail art Nail polish remover Nail care: Cuticle oil, nail hardener'),
(17, 'Hair Sprays', 'Sprays'),
(18, 'make up', 'Make up materials'),
(19, 'Sanitary Pads', 'Womens Sanitary Pads'),
(20, 'Lotion and  Perfume', 'Body Lotion'),
(27, 'For Testing', 'New testing one');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `loyalty_points` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` int(11) NOT NULL,
  `discount_type` enum('Percentage','Flat Amount') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_change` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `date_of_change` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_created` time DEFAULT curtime(),
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `method_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `quantity_available` int(11) DEFAULT 0,
  `minimum_stock_level` int(11) DEFAULT 0,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `time_added` time DEFAULT curtime(),
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `barcode`, `description`, `cost_price`, `selling_price`, `quantity_available`, `minimum_stock_level`, `status`, `time_added`, `date_added`, `supplier_id`, `image_path`) VALUES
(13, 'Jibambe', 10, '', 'jibambe Short and Long Braid', 58.00, 70.00, 18, 0, 'Active', '14:09:32', '2024-10-25 11:09:32', 23, ''),
(14, 'Makeba', 10, '', 'Makeba Long', 58.00, 70.00, 32, 0, 'Active', '14:11:47', '2024-10-25 11:11:47', 23, ''),
(15, 'Avis', 10, '', 'Avis', 66.00, 75.00, 36, 0, 'Active', '14:13:32', '2024-10-25 11:13:32', 23, ''),
(16, 'Air Freshener', 11, '', '', 150.00, 250.00, 7, 0, 'Active', '14:28:48', '2024-10-25 11:28:48', 23, ''),
(17, 'Olive Oil 250 ml', 17, '', '', 280.00, 360.00, 5, 0, 'Active', '14:32:44', '2024-10-25 11:32:44', 23, ''),
(18, 'Olive Oil 85 ml', 17, '', '', 145.00, 180.00, 3, 0, 'Active', '14:33:38', '2024-10-25 11:33:38', 23, ''),
(19, 'Radiant 100ml', 17, '', '', 145.00, 180.00, 2, 0, 'Active', '14:34:29', '2024-10-25 11:34:29', 23, ''),
(20, 'Movit 100ml', 17, '', '', 145.00, 180.00, 2, 0, 'Active', '14:35:04', '2024-10-25 11:35:04', 23, ''),
(21, 'tcb oil sheen spray', 17, '', '', 145.00, 180.00, 2, 0, 'Active', '14:36:04', '2024-10-25 11:36:04', 23, ''),
(22, 'Acetone Angelique 1 litre', 16, '', '', 360.00, 500.00, 1, 0, 'Active', '14:38:42', '2024-10-25 11:38:42', 23, ''),
(23, 'Acetone Angelique 500ml', 16, '', '', 240.00, 350.00, 3, 0, 'Active', '14:39:20', '2024-10-25 11:39:20', 23, ''),
(24, 'Surgical Sprit 1 litre', 16, '', '', 0.00, 300.00, 4, 0, 'Active', '14:40:22', '2024-10-25 11:40:22', 23, ''),
(25, 'Surgical Spirit 500 ml', 16, '', '', 0.00, 150.00, 4, 0, 'Active', '14:41:02', '2024-10-25 11:41:02', 23, ''),
(26, 'Paradise polish remover 500ml', 16, '', '', 0.00, 220.00, 3, 0, 'Active', '14:42:52', '2024-10-25 11:42:52', 23, ''),
(27, 'Bump Patrol', 12, '', '', 450.00, 500.00, 5, 0, 'Active', '14:44:32', '2024-10-25 11:44:32', 23, ''),
(28, 'Even and Lovely 50ml', 12, '', '', 0.00, 180.00, 2, 0, 'Active', '14:49:12', '2024-10-25 11:49:12', 23, ''),
(29, 'Even and Lovely 25ml', 12, '', '', 0.00, 120.00, 2, 0, 'Active', '14:49:42', '2024-10-25 11:49:42', 23, ''),
(30, 'Lanolin Cream 50ml', 12, '', '', 0.00, 150.00, 4, 0, 'Active', '14:50:33', '2024-10-25 11:50:33', 23, ''),
(31, 'Make Up Fix', 12, '', '', 0.00, 350.00, 1, 0, 'Active', '14:51:17', '2024-10-25 11:51:17', 23, ''),
(32, 'Luron Vanishing Day Cream', 12, '', '', 0.00, 200.00, 2, 0, 'Active', '14:52:18', '2024-10-25 11:52:18', 23, ''),
(33, 'DR RA SHEL BLACK PEEL OFF MASK 120grams', 12, '', '', 0.00, 400.00, 3, 0, 'Active', '14:53:28', '2024-10-25 11:53:28', 23, ''),
(34, 'Natural Matte  BB 7 in 1', 18, '', '', 0.00, 300.00, 4, 0, 'Active', '15:01:58', '2024-10-25 12:01:58', 23, ''),
(35, 'Cotton Wool 400g', 16, '', '', 0.00, 380.00, 2, 0, 'Active', '15:21:29', '2024-10-25 12:21:29', 23, ''),
(37, 'Cotton Wool 200g', 16, '', '', 0.00, 250.00, 1, 0, 'Active', '15:23:05', '2024-10-25 12:23:05', 23, ''),
(38, 'Softcare Sanitary', 19, '', '', 0.00, 80.00, 6, 0, 'Active', '15:25:02', '2024-10-25 12:25:02', 23, ''),
(39, 'Bamsi crystal fresh shampoo 5litres', 10, '', '', 0.00, 500.00, 5, 0, 'Active', '15:25:50', '2024-10-25 12:25:50', 23, ''),
(40, 'Bamsi white natural conditioner', 10, '', '', 0.00, 450.00, 1, 0, 'Active', '15:27:49', '2024-10-25 12:27:49', 23, ''),
(41, 'Neck roll', 10, '', '', 0.00, 100.00, 3, 0, 'Active', '15:30:06', '2024-10-25 12:30:06', 23, ''),
(42, 'Crazy Color', 10, '', '', 0.00, 100.00, 28, 0, 'Active', '15:30:38', '2024-10-25 12:30:38', 23, ''),
(43, 'Gloves', 16, '', '', 0.00, 50.00, 100, 0, 'Active', '15:31:15', '2024-10-25 12:31:15', 23, ''),
(44, 'nice & Lovely 200 ml', 20, '', '', 0.00, 150.00, 3, 0, 'Active', '15:41:39', '2024-10-25 12:41:39', 23, ''),
(45, 'Nice & Lovely 400g', 20, '', '', 0.00, 250.00, 4, 0, 'Active', '15:42:43', '2024-10-25 12:42:43', 23, ''),
(47, 'Amara for Men', 20, '', '', 200.00, 250.00, 3, 0, 'Active', '15:45:46', '2024-10-25 12:45:46', 23, ''),
(48, 'Amara for Men 200ml', 20, '', '', 120.00, 180.00, 5, 0, 'Active', '15:46:12', '2024-10-25 12:46:12', 23, ''),
(49, 'Zoe 200 ml', 20, '', '', 0.00, 150.00, 3, 0, 'Active', '15:47:01', '2024-10-25 12:47:01', 23, ''),
(50, 'Zoe 400ml', 20, '', '', 0.00, 250.00, 1, 0, 'Active', '15:47:27', '2024-10-25 12:47:27', 23, ''),
(52, 'Skala For men 100 ml', 20, '', '', 0.00, 60.00, 5, 0, 'Active', '15:50:42', '2024-10-25 12:50:42', 23, ''),
(53, 'Body Luxe 100ml', 20, '', '', 0.00, 130.00, 3, 0, 'Active', '15:51:34', '2024-10-25 12:51:34', 23, ''),
(54, 'Nice and Lovely 40ml', 20, '', '', 0.00, 90.00, 3, 0, 'Active', '15:53:46', '2024-10-25 12:53:46', 23, ''),
(55, 'Body Splash', 20, '', '', 0.00, 200.00, 4, 0, 'Active', '15:54:24', '2024-10-25 12:54:24', 23, ''),
(56, 'Body Splash 250ml', 20, '', '', 0.00, 500.00, 1, 0, 'Active', '15:55:03', '2024-10-25 12:55:03', 23, ''),
(58, 'test 1', 27, '12345#8', 'Descir', 10.00, 20.00, 39, 40, 'Active', '10:55:21', '2024-10-28 07:55:21', 23, ''),
(59, 'test2', 27, '12345#8', 'DEscript', 10.00, 20.00, 18, 40, 'Active', '10:56:30', '2024-10-28 07:56:30', 23, '');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `cashier_id` int(11) NOT NULL,
  `total_sale_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','Mpesa') NOT NULL,
  `discount_applied` decimal(10,2) DEFAULT 0.00,
  `tax_applied` decimal(10,2) DEFAULT 0.00,
  `sale_status` enum('Completed','Pending') DEFAULT 'Completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `sale_date`, `cashier_id`, `total_sale_amount`, `payment_method`, `discount_applied`, `tax_applied`, `sale_status`) VALUES
(9, '2024-11-04 07:34:46', 1, 20.00, 'Cash', 0.00, 0.00, 'Completed'),
(10, '2024-11-04 07:37:33', 1, 60.00, 'Mpesa', 0.00, 0.00, 'Completed'),
(11, '2024-11-04 07:40:31', 1, 140.00, 'Cash', 0.00, 0.00, 'Completed'),
(12, '2024-11-04 07:47:50', 1, 0.00, 'Cash', 0.00, 0.00, 'Completed'),
(13, '2024-11-04 07:47:52', 1, 0.00, 'Cash', 0.00, 0.00, 'Completed'),
(14, '2024-11-04 07:51:45', 1, 40.00, 'Cash', 0.00, 0.00, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `sale_detail_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `time_added` time DEFAULT curtime(),
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `contact_info`, `address`, `description`, `time_added`, `date_added`) VALUES
(23, 'none', 'con', 'add', 'Desc', '18:44:47', '2024-10-22 15:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `role` enum('Admin','Cashier','Manager') NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `first_name`, `role`, `password`, `date_added`) VALUES
(1, 'admin', 'admin', 'Admin', '$2y$10$Ttf6YMwv9hinv3E0zuoxz.vDvqxCBgBJ3jRgIFEK10As4rEY5bTye', '2024-10-22 20:31:34'),
(2, 'cashier1', 'cashier1', 'Cashier', '$2y$10$1HhAgkdca4EuFc0bJw6UD.I6g2n4Y.DrXSF1oC87K/zGGInOdDtRm', '2024-10-22 20:34:23'),
(3, 'manager1', 'manager1', 'Manager', '$2y$10$fh212iQrJry9EAUTqAtVj.YnNVQaVM1ERCe8n.xPWcnkxEMXRfcrK', '2024-10-22 20:36:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `cashier_id` (`cashier_id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`sale_detail_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `sale_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD CONSTRAINT `sales_details_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
