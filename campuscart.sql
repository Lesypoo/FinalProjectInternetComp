-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2025 at 06:35 PM
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
-- Database: `campuscart`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_database`
--

CREATE TABLE `book_database` (
  `book_id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `condition` enum('new','used') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_database`
--

INSERT INTO `book_database` (`book_id`, `title`, `author`, `isbn`, `course`, `price`, `condition`) VALUES
(1, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', '9780590353427', 'Fantasy Literature', 12.99, 'new'),
(2, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', '9780439064873', 'Fantasy Literature', 13.99, 'used'),
(3, 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', '9780439136365', 'Fantasy Literature', 14.50, 'new'),
(4, 'Harry Potter and the Goblet of Fire', 'J.K. Rowling', '9780439139601', 'Fantasy Literature', 15.99, 'used'),
(5, 'Harry Potter and the Order of the Phoenix', 'J.K. Rowling', '9780439358071', 'Fantasy Literature', 16.99, 'new'),
(6, 'Divergent', 'Veronica Roth', '9780062024039', 'Dystopian Fiction', 10.99, 'new'),
(7, 'Insurgent', 'Veronica Roth', '9780062024046', 'Dystopian Fiction', 11.99, 'used'),
(8, 'Allegiant', 'Veronica Roth', '9780062024060', 'Dystopian Fiction', 12.99, 'new'),
(10, 'The Giver', 'Lois Lowry', '9780544336261', 'Dystopian Fiction', 8.99, 'new'),
(11, 'Gathering Blue', 'Lois Lowry', '9780547904146', 'Dystopian Fiction', 9.50, 'used'),
(12, 'Messenger', 'Lois Lowry', '9780547995670', 'Dystopian Fiction', 9.75, 'new'),
(13, 'Son', 'Lois Lowry', '9780547887203', 'Dystopian Fiction', 10.00, 'new'),
(14, 'Harry Potter and the Half-Blood Prince', 'J.K. Rowling', '9780439785969', 'Fantasy Literature', 16.50, 'new'),
(15, 'Harry Potter and the Deathly Hallows', 'J.K. Rowling', '9780545010221', 'Fantasy Literature', 17.99, 'used');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_database`
--
ALTER TABLE `book_database`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_database`
--
ALTER TABLE `book_database`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book_database` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
