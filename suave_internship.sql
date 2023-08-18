-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2023 at 01:20 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suave_internship`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `c_email` varchar(50) NOT NULL,
  `c_phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`c_id`, `c_name`, `c_email`, `c_phone`) VALUES
(13, 'Lin Dan', 'lindan@gmail.com', '02421121777'),
(14, 'Abdullah Ahmad', 'aak606@gmail.com', '03314160816');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(10) NOT NULL,
  `c_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `c_id`) VALUES
(37, 13),
(38, 14);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `o_item_id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `p_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`o_item_id`, `o_id`, `p_id`, `p_quantity`) VALUES
(6, 37, 3, 1),
(7, 37, 10, 1),
(8, 38, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(10) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_description` varchar(255) NOT NULL,
  `p_price` int(10) NOT NULL,
  `p_picture_filename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_description`, `p_price`, `p_picture_filename`) VALUES
(2, 'T Shirt', 'very cool relaxin t shirt, made of nylon just for lahori summers', 400, 'tshirt.jpg'),
(3, 'Trousers', 'Wear the most comfortable trousers ever made in Pakistan. Get your cotton and denim jeans and trousers now, and feel like a boss!', 1100, 'trousers.jpg'),
(4, 'Socks', 'Thin, comfy cotton socks just for you! Try now at Al Karam Studios.', 300, 'socks.jpg'),
(5, 'Shorts', 'Tight fit shorts to make sure those fit legs are on display all the time. Adidas shorts on bulk sale.', 500, 'shorts.jpg'),
(6, 'Shoes', 'Relaxed fitting shoes which will shape themselves to fit your sole. Never complain of toe pain again!', 1200, 'shoes.jpg'),
(7, 'Paint Box', 'Berger premium paints, special emulsion assorted in all colors just for you. One box of 200 ml.', 2500, 'paint-box.jpg'),
(8, 'Dress Shirt', 'If you\'ve run out of affordable items to wear to your office, this shirt is just the right one for you!', 800, 'full-sleeve-shirt.jpg'),
(9, 'Badminton Shuttles Box', 'Wecan shuttles imported from Wuhan of China. Extremely good quality, durable and fun to play with. 1 box of 12 shuttles.', 3200, 'badminton-shuttles-box.jpg'),
(10, 'Badminton Racquet', 'Yonex Arcsaber 9000, crafted from graphite and high-end carbon with the latest technologies.', 4500, 'badminton-racquet.jpg'),
(11, 'Badminton Net (Portable)', 'Tired of having to set up poles and net every time you play? Well, now you can just carry these 2 poles  + their attached net anywhere you want to play.', 6500, 'badminton-net.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stock_products`
--

CREATE TABLE `stock_products` (
  `p_id` int(11) NOT NULL,
  `p_stock_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_products`
--

INSERT INTO `stock_products` (`p_id`, `p_stock_quantity`) VALUES
(2, 0),
(3, 2),
(4, 19),
(5, 20),
(6, 20),
(7, 19),
(8, 15),
(9, 20),
(10, 18),
(11, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`o_item_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `o_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
