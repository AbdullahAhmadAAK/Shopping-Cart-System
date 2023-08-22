-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2023 at 03:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internship_abdullah_ahmad`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`c_id`, `c_name`, `c_email`, `c_phone`) VALUES
(13, 'Lin Dan', 'lindan@gmail.com', '02421121777'),
(17, 'Mozaywala', 'mozay@store.com', '12345678910'),
(18, 'Lin Dan', 'dan@gmail.com', '12341234123'),
(19, 'Customer One', 'one@gmail.com', '11112222123'),
(20, 'Customer Four', 'four@gmail.com', '44444444444'),
(21, 'Customer Five', 'five@gmail.com', '55555555555'),
(22, 'Customer Six', 'six@gmail.com', '66666666666'),
(23, 'Customer Seven', 'seven@gmail.com', '77777777777'),
(24, 'Customer Eight', 'eight@gmail.com', '88888888888'),
(25, 'Customer Nine', '9!@gmail.com', '99999999999'),
(26, 'Customer Ten', '10@gmail.com', '10101010101'),
(27, 'Customer Two', 'asnkasl@gmail.com', '11112222345'),
(28, 'Rich', 'rich@gmail.com', '43214321432'),
(29, 'Lee Chong Wei', 'lee@gmail.com', '43214321431'),
(30, 'Shabbir', 'shabbir@gm.com', '12345123450');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `name`, `department_id`, `designation`, `salary`) VALUES
(8, '', 0, '', 0),
(9, 'Adnan Aziz', 3, 'Software Engineer', 10000),
(10, 'JohnAhmad', 4, 'SoftwareEngineer', 10000),
(11, 'Abdullah Ahmad', 5, 'Software Engineer', 10000),
(12, 'Adnan Aziz', 2, 'Software Engineer', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(10) NOT NULL,
  `c_id` int(10) NOT NULL,
  `o_bill` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `c_id`, `o_bill`) VALUES
(72, 26, 300),
(74, 26, 4500),
(75, 26, 300),
(78, 26, 3100);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `o_item_id` int(11) NOT NULL,
  `o_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `p_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`o_item_id`, `o_id`, `p_id`, `p_quantity`) VALUES
(76, 72, 4, 1),
(79, 74, 10, 1),
(80, 75, 4, 1),
(89, 78, 3, 1),
(90, 78, 4, 1),
(91, 78, 5, 1),
(92, 78, 6, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(8, 'Dress Shirt', "If you've run out of affordable items to wear to your office, this shirt is just the right one for you!", 800, 'full-sleeve-shirt.jpg'),
(9, 'Badminton Shuttles Box', 'Wecan shuttles imported from Wuhan of China. Extremely good quality, durable and fun to play with. 1 box of 12 shuttles.', 3200, 'badminton-shuttles-box.jpg'),
(10, 'Badminton Racquet', 'Yonex Arcsaber 9000, crafted from graphite and high-end carbon with the latest technologies.', 4500, 'badminton-racquet.jpg'),
(27, 'Badminton Net', 'ass sa sasa assa', 8000, 'badminton-net.jpg'),
(29, 'Test Shoes', 'fake shoes, not really real. this is a scam', 100, 'shoes.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stock_products`
--

CREATE TABLE `stock_products` (
  `p_id` int(11) NOT NULL,
  `p_stock_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_products`
--

INSERT INTO `stock_products` (`p_id`, `p_stock_quantity`) VALUES
(2, 12),
(3, 0),
(4, 0),
(5, 7),
(6, 2),
(7, 2),
(8, 9),
(9, 12),
(10, 6),
(18, 12),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(27, 1),
(29, 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

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
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `o_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
