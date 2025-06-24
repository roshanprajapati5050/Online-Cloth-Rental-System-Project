-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 09:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `Admin_Name` varchar(100) NOT NULL,
  `Admin_Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`Admin_Name`, `Admin_Password`) VALUES
('Roshan', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(23, 'Lehenga'),
(24, 'wedding saree'),
(25, 'Party wear'),
(26, 'Gown for girl'),
(28, 'Pant'),
(30, 'Shirt'),
(41, 'Formal dress');

-- --------------------------------------------------------

--
-- Table structure for table `clothes`
--

CREATE TABLE `clothes` (
  `cloth_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` bigint(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `clothes`
--

INSERT INTO `clothes` (`cloth_id`, `name`, `image`, `price`, `category_id`) VALUES
(16, 'shirt', '../image/shirt.jpg', 500, 30),
(17, 'pant for man', '../image/pant.jpg', 500, 28),
(18, 'Gown', '../image/gown.jpg', 1000, 26),
(19, 'wedding saree 1', '../image/wedding_saree.jpg', 1000, 24),
(20, 'Formal Dress for man', '../image/formal dress.jpg', 1000, 41),
(21, 'one pice', '../image/party_wear.jpg', 500, 25),
(25, 'Lehenga', '../image/lehenga2.jpg', 1000, 23),
(26, 'Formal Dress', '../image/formaldress.jpg', 1000, 41);

-- --------------------------------------------------------

--
-- Table structure for table `cloth_reviews`
--

CREATE TABLE `cloth_reviews` (
  `id` int(11) NOT NULL,
  `cloth_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `cloth_reviews`
--

INSERT INTO `cloth_reviews` (`id`, `cloth_id`, `user_id`, `review`, `rating`, `created_at`) VALUES
(1, 17, 10, 'Good cloth', 5, '2025-03-20 09:02:27'),
(2, 17, 10, 'nice ', 4, '2025-03-20 09:15:20'),
(4, 16, 13, 'nice shirt', 5, '2025-03-21 12:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(6, 'rushikesh', 'test@test.com', 'brvbfb', '2025-03-21 12:22:06'),
(7, 'Satyam', 'satya04@gmail.com', 'i want a kurta', '2025-03-22 16:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `register_date` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`user_id`, `full_name`, `username`, `email`, `password`, `register_date`) VALUES
(6, 'akash gupta', 'akash123', 'akash@gmail.com', '$2y$10$v6N7dyPHZSAN7ZRu8l4VH.nJ31vDeD.l0sVhv55nBgWkSI5LyIqVS', '2025-03-05'),
(8, 'saurabh kumar', 'saurabh123', 'saurabh@gmail.com', '$2y$10$Ok0XYI8ZRZwfKMuiplYqTO34qSwfK0SOfeXonO/jB67PcxGkxPV9i', '2025-03-06'),
(10, 'Rushikesh tawale', 'rushikesh1', 'rushikesh@test.com', '$2y$10$0PuQSBwyLWxKasAwyHcrK.RXJk/98SnoHkzp8keHIfMc7Kjr2HZz6', '2025-03-07'),
(11, 'Roshan prajapati', 'roshan123', 'rprrp5680@gmail.com', '$2y$10$Pc5Vq1Ai77.zQwwJCOgzwez9Mo.zGE17kAQz7eNEMHYHTjiejYZ1.', '2025-03-07'),
(12, 'sumit saroj', 'sumit123', 'prajapatiroshan764@gmail.com', '$2y$10$CtqRqsQKdUSRYlV43X9aQO4H6L28L.a4Q8fkbslpNt8fFSQLowQE6', '2025-03-15'),
(13, 'satyam jaiswal', 'satya123', 'satya04@gmail.com', '$2y$10$YjgLlezxSSF0QgY7s03aT..5dAKjIzUDjjjNnzu3V3ftLutWdccim', '2025-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `rent_id` int(11) NOT NULL,
  `cloth_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rent_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `rental_price` decimal(10,2) DEFAULT NULL,
  `method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cash on delivery',
  `payment_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `size_id` int(55) NOT NULL,
  `cloth_quantity` int(255) NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`rent_id`, `cloth_id`, `user_id`, `rent_date`, `return_date`, `rental_price`, `method`, `payment_status`, `size_id`, `cloth_quantity`, `address`, `mobile`) VALUES
(12, 17, 10, '2025-03-18', '2025-03-20', 500.00, 'cash', 'pending', 6, 1, 'Indira nagar', '9794442828'),
(13, 16, 10, '2025-03-20', '2025-03-24', 500.00, 'cash', 'paid', 4, 1, 'gbb', '9794442828'),
(16, 16, 13, '2025-03-21', '2025-03-24', 500.00, 'cash', 'pending', 4, 1, 'indira nagar', '9876543210');

-- --------------------------------------------------------

--
-- Table structure for table `return`
--

CREATE TABLE `return` (
  `id` int(255) NOT NULL,
  `status` enum('pending','approved','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rent_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `return`
--

INSERT INTO `return` (`id`, `status`, `rent_id`) VALUES
(10, 'approved', 12),
(11, 'pending', 13);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `username`, `review`, `rating`, `created_at`) VALUES
(1, 'rushikesh1', 'good cloth quality', 5, '2025-03-10 12:13:49'),
(2, 'akash123', 'Cloth quality very good', 4, '2025-03-10 12:18:45');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int(55) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `name`) VALUES
(4, 'L'),
(6, 'M'),
(8, 'XS'),
(9, 'XL'),
(11, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `cloth_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `size_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `cloth_id`, `stock`, `size_id`) VALUES
(3, 17, 1, 6),
(4, 16, 1, 4),
(5, 16, 0, 6),
(6, 17, 0, 4),
(8, 18, 1, 8),
(9, 20, 2, 6),
(10, 21, 1, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`cloth_id`);

--
-- Indexes for table `cloth_reviews`
--
ALTER TABLE `cloth_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`rent_id`);

--
-- Indexes for table `return`
--
ALTER TABLE `return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `clothes`
--
ALTER TABLE `clothes`
  MODIFY `cloth_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cloth_reviews`
--
ALTER TABLE `cloth_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `return`
--
ALTER TABLE `return`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
