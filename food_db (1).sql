-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 03:55 PM
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
-- Database: `food_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(43, 10, 51, 'Rajasthani Mirchi Bada', 180, 1, 'mirchi_bada.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(5, 0, 'zdvv', 'xzdvxcv@gmail.com', '', 'czvzc'),
(6, 0, 'zdvv', 'xzdvxcv@gmail.com', '', 'czvzc'),
(7, 0, 'zdvv', 'xzdvxcv@gmail.com', '', 'czvzc'),
(8, 0, 'sdgdfg', 'dfbdfhb@gmail.com', '', 'aefsef'),
(9, 0, 'xfgfdgh', 'zdvsf@gmail.com', 'zdfhxfgh', 'zfhfzghzf'),
(10, 0, 'xfgfdgh', 'zdvsf@gmail.com', 'zdfhxfgh', 'zfhfzghzf'),
(11, 0, 'xfxfv', 'xgxfcv@gmail.com', '', 'xfbcbf'),
(12, 0, 'xfxfv', 'xgxfcv@gmail.com', '', 'xfbcbf');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `admin_reply` varchar(255) DEFAULT NULL,
  `user_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `admin_reply`, `user_read`) VALUES
(2, 5, 'amit', '8145623791', 'amitb@gmail.com', 'credit card', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Garlic Bread (4 x 1) - Cheeseburger (8 x 1) - ', 12, '2025-05-12', 'completed', NULL, 1),
(3, 5, 'amit', '8145623791', 'amitb@gmail.com', 'credit card', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Garlic Bread (6 x 4) - Tandoori Chicken (12 x 1) - ', 36, '2025-05-14', 'completed', NULL, 1),
(4, 5, 'amit', '8145623791', 'amitb@gmail.com', 'credit card', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Tandoori Chicken (12 x 6) - ', 72, '2025-05-15', 'completed', NULL, 1),
(5, 5, 'amit', '8145623791', 'amitb@gmail.com', 'credit card', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Garlic Bread (6 x 1) - ', 6, '2025-05-18', 'completed', NULL, 1),
(6, 5, 'amit', '8145623791', 'amitb@gmail.com', 'credit card', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Garlic Bread (6 x 1) - ', 6, '2025-05-19', 'completed', 'will reach in 15 mins', 1),
(7, 5, 'amit', '8145623791', 'amitb@gmail.com', 'credit card', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Tandoori Chicken (12 x 1) - Garlic Bread (6 x 1) - Paneer Butter Masala (9 x 1) - ', 27, '2025-05-22', 'completed', NULL, 1),
(8, 5, 'amit', '8145623791', 'amitb@gmail.com', 'paytm', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Garlic Bread (6 x 1) - ', 6, '2025-05-22', 'completed', NULL, 1),
(9, 5, 'amit', '8145623791', 'amitb@gmail.com', 'credit card', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3', 'Tandoori Chicken (12 x 1) - ', 12, '2025-05-22', 'pending', NULL, 0),
(10, 10, 'Topi', '6788898767', 'topi12@gmail.com', 'cash on delivery', '22, 22, 45, 45, 55, 56, 66 - 678988', 'Amritsari Chole Kulche (210 x 1) - Bengali Shorshe Ilish (520 x 1) - Bengali Mishti Doi (180 x 1) - ', 910, '2025-05-25', 'completed', NULL, 1),
(11, 10, 'Topi', '6788898767', 'topi12@gmail.com', 'cash on delivery', '22, 22, 45, 45, 55, 56, 66 - 678988', 'Bhopali Keema Paratha (240 x 1) - Gujarati Undhiyu (390 x 1) - Bengali Mishti Doi (180 x 1) - Delhi Shikanji with Black Salt (80 x 1) - ', 890, '2025-05-25', 'completed', NULL, 0),
(12, 11, 'Jishu', '7898765789', 'jishu232@gmail.com', 'cash on delivery', '4, 5, 77, 78, 8, 99, 98 - 897678', 'Delhi Shikanji with Black Salt (80 x 1) - Hyderabadi Haleem (480 x 1) - Hyderabadi Khubani ka Meetha (200 x 1) - ', 760, '2025-05-25', 'completed', NULL, 1),
(13, 12, 'Subha', '8798878897', 'subha12@gmail.com', 'cash on delivery', '55, 78, abc, abc, xyz, xyz, aaaaa - 789995', 'Kolkata Club Kachori with Aloo Tarkari (190 x 1) - Hyderabadi Khubani ka Meetha (200 x 1) - ', 390, '2025-05-27', 'completed', NULL, 1),
(14, 10, 'Topi', '6788898767', 'topi12@gmail.com', 'cash on delivery', '22, 22, 45, 45, 55, 56, 66 - 678988', 'Kolkata Club Kachori with Aloo Tarkari (190 x 1) - ', 190, '2025-05-29', 'pending', NULL, 0),
(15, 13, 'Uttam', '8977789767', 'Uttam11@gmail.com', 'cash on delivery', '33, 33, 45, 44, 5, 55, 56 - 678889', 'Bihar Sattu Sharbat (90 x 1) - Rajasthani Mirchi Bada (180 x 1) - ', 270, '2025-05-31', 'pending', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`, `description`) VALUES
(41, 'Kolkata Club Kachori with Aloo Tarkari', 'Breakfast', 190, 'kachori_tarkari.jpeg', 'Mini kachoris filled with lentils, served with spiced potato curry'),
(42, 'Andhra Pesarattu with Ginger Chutney', 'Breakfast', 200, 'pesarattu.jpeg', 'Green moong crepes served with tangy ginger chutney'),
(43, 'Mumbai Batata Poha', 'Breakfast', 160, 'batata_poha.jpg', 'Flattened rice with spiced potatoes, mustard seeds, and peanuts'),
(44, 'Amritsari Chole Kulche', 'Breakfast', 210, 'chole_kulche.jpg', 'Soft kulchas served with spicy chickpea curry'),
(45, 'Uttarakhand Aloo Ke Gutke with Bhatt ki Churkani', 'Breakfast', 220, 'aloo_gutke.jpg', 'Pahadi-style spiced potatoes with black soybean curry'),
(46, 'Kerala Appam with Stew', 'Breakfast', 220, 'appam_stew.webp', 'Fermented rice pancakes served with mild coconut vegetable stew'),
(47, 'Bhopali Keema Paratha', 'Breakfast', 240, 'keema_paratha.jpg', 'Whole wheat paratha stuffed with spicy minced lamb'),
(48, 'Bihari Chana Ghugni with Litti', 'Breakfast', 210, 'chana_ghugni_litti.jpg', 'Roasted wheat balls served with spicy black chana curry'),
(49, 'Mysore Rava Dosa', 'Breakfast', 200, 'mysore_dosa.webp', 'Crispy semolina dosa with spicy chutney and sambar'),
(50, 'Konkani Sheera with Banana', 'Breakfast', 180, 'konkani_sheera.jpeg', 'Semolina dessert cooked in ghee with cardamom and banana'),
(51, 'Rajasthani Mirchi Bada', 'Appetizers', 180, 'mirchi_bada.jpeg', 'Stuffed green chillies fried in gram flour batter'),
(52, 'Malabar Prawn Fry', 'Appetizers', 360, 'malabar_prawn.webp', 'Spicy prawns pan-fried with coconut oil and curry leaves'),
(53, 'Assamese Chicken Bamboo Shoot', 'Appetizers', 340, 'assam_chicken.jpg', 'Tender chicken cooked with fermented bamboo shoot and mustard oil'),
(54, 'Kashmiri Nadru Tikki', 'Appetizers', 260, 'nadru_tikki.jpg', 'Crispy lotus stem patties spiced with Kashmiri masalas'),
(55, 'Indori Patte Samosa', 'Appetizers', 150, 'indori_samosa.webp', 'Flat samosas with spicy aloo masala, served with sev and chutneys'),
(56, 'Koliwada Fish Fingers', 'Appetizers', 350, 'koliwada_fish.webp', 'Mumbai-style spicy deep-fried fish fingers with red marinade'),
(57, 'Goan Prawn Caldine', 'Main Course', 460, 'prawn_caldine.webp', 'Prawns cooked in a mild coconut curry with Goan spices'),
(58, 'Hyderabadi Haleem', 'Main Course', 480, 'haleem.jpg', 'Slow-cooked lentil and meat porridge topped with fried onions'),
(59, 'Gujarati Undhiyu', 'Main Course', 390, 'undhiyu.jpg', 'Mixed winter vegetables cooked with methi muthiyas and spices'),
(60, 'Awadhi Nihari Gosht', 'Main Course', 490, 'nihari_gosht.jpg', 'Slow-braised mutton shanks in rich aromatic gravy'),
(61, 'Tamil Nadu Chettinad Veg Kurma', 'Main Course', 350, 'chettinad_kurma.jpg', 'Spicy coconut-based vegetable curry with black pepper and fennel'),
(62, 'Punjabi Dhaba Paneer Masala', 'Main Course', 380, 'paneer_dhaba.jpg', 'Soft paneer in dhaba-style spicy tomato and onion gravy'),
(63, 'Kerala Avial', 'Main Course', 360, 'avial.jpg', 'Mixed vegetables cooked in coconut and yogurt curry with curry leaves'),
(64, 'Bengali Shorshe Ilish', 'Main Course', 520, 'shorshe_ilish.jpg', 'Hilsa fish in pungent mustard gravy with green chillies'),
(65, 'Nagaland Smoked Pork Curry', 'Main Course', 490, 'nagaland_pork.jpeg', 'Pork belly cooked with bamboo shoot and Naga spices'),
(66, 'Rajasthani Gatte Ki Sabzi', 'Main Course', 340, 'gatte_ki_sabzi.jpg', 'Besan dumplings in spicy yogurt curry'),
(67, 'Bengali Mishti Doi', 'Desserts', 180, 'mishti_doi.jpg', 'Sweetened thick yogurt delicately flavored with cardamom'),
(68, 'Rajasthani Ghevar with Rabri', 'Desserts', 210, 'ghevar_rabri.webp', 'Crispy honeycomb dessert soaked in rabri and dry fruits'),
(69, 'Kerala Ada Pradhaman', 'Desserts', 190, 'ada_pradhaman.jpg', 'Payasam made with rice ada, jaggery, and coconut milk'),
(70, 'Lucknowi Malai Paan', 'Desserts', 170, 'malai_paan.webp', 'Sweet paan leaves filled with malai and gulkand'),
(71, 'Pahadi Singori', 'Desserts', 160, 'singori.jpeg', 'Khoya-based sweet wrapped in maalu leaf from Uttarakhand'),
(72, 'Hyderabadi Khubani ka Meetha', 'Desserts', 200, 'khubani_meetha.jpeg', 'Apricot compote topped with malai and nuts'),
(73, 'Punjab Phirni in Kulhad', 'Desserts', 190, 'phirni_kulhad.jpeg', 'Ground rice pudding with saffron and nuts, served chilled in earthen pots'),
(74, 'Tripura Muya Awandru', 'Desserts', 200, 'muya_awandru.jpeg', 'Delicate dessert of bamboo shoot and berma with coconut twist (veg adaptation)'),
(75, 'Bihar Sattu Sharbat', 'Drinks', 90, 'sattu_sharbat.png', 'Nutritious roasted gram drink with spices and lemon'),
(76, 'Kokum Sherbet', 'Drinks', 100, 'kokum_sherbet.jfif', 'Refreshing drink made from kokum extract, cumin, and black salt'),
(77, 'Delhi Shikanji with Black Salt', 'Drinks', 80, 'shikanji.jpg', 'North Indian lemonade with spices and mint'),
(78, 'Kashmiri Noon Chai', 'Drinks', 120, 'noon_chai.jpg', 'Salted pink tea brewed with milk and green tea leaves'),
(79, 'West Bengal Aam Pora Sharbat', 'Drinks', 90, 'aam_pora.webp', 'Smoky raw mango drink flavored with mustard seeds and mint'),
(118, 'West Bengal Aam Pora Sharbat', 'Drinks', 90, 'aam_pora.webp', 'Smoky raw mango drink flavored with mustard seeds and mint'),
(119, 'Manipur Lemon Ginger Chahao', 'Drinks', 130, 'chahao_drink.jpg', 'Drink made from black rice and lemon-ginger extract'),
(120, 'Tamil Elaneer Payasam (Cold)', 'Drinks', 140, 'elaneer_payasam.jpg', 'Chilled coconut water payasam with vermicelli and dry fruits');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reserve_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `no_of_guest` varchar(100) NOT NULL,
  `date_res` date NOT NULL,
  `time` varchar(50) NOT NULL,
  `suggestions` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_reply` text DEFAULT NULL,
  `user_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reserve_id`, `user_id`, `name`, `email`, `phone`, `no_of_guest`, `date_res`, `time`, `suggestions`, `status`, `admin_reply`, `user_read`) VALUES
(1, 5, 'amit', 'amitb@gmail.com', '5896471236', '1', '5222-02-23', '08:00am', '', 'approved', 'done', 1),
(2, 5, 'amit', 'amitb@gmail.com', '9632587412', '9', '2025-05-14', '08:00pm', '', 'approved', '', 1),
(3, 5, 'bxfgcf', 'amitb@gmail.com', 'vjgkhvkvhjkvhjk', '8', '2025-05-22', '08:00am', '', 'approved', '', 1),
(4, 5, 'ggj', 'amitb@gmail.com', ' bnbnbnnnnn', '5', '2025-05-24', '06:00pm', 'Romantic Candle Light', 'approved', '', 1),
(5, 5, 'cgxfhchcncccccccccccc', 'amitb@gmail.com', '6566565656', '1', '2025-05-12', '08:00am', '', 'approved', '', 1),
(6, 5, 'amit', 'amitb@gmail.com', '632596215521444', '6', '2025-05-24', '09:00am', 'Anniversary Special', 'approved', '', 1),
(7, 5, 'amiy', 'amitb@gmail.com', '789+222333', '1', '2025-05-24', '08:00am', 'Romantic Candle Light', 'approved', '', 1),
(8, 5, 'amit', 'amitb@gmail.com', '455555555', '9', '2025-05-24', '08:00pm', 'Anniversary Special', 'approved', '', 1),
(9, 5, 'kjjjjjj', 'amitb@gmail.com', '2222222222', '1', '2025-05-24', '05:00pm', 'Anniversary Special', 'pending', NULL, 0),
(10, 5, 'vjgvhjvjv4154', 'amitb@gmail.com', '66666', '1', '2025-05-30', '08:00am', '', 'approved', '', 1),
(11, 5, 'amghnb', 'amitb@gmail.com', '55555555555', '7', '2025-05-24', '10:00am', 'Business', 'pending', NULL, 0),
(12, 5, 'xfgcfb', 'amitb@gmail.com', 'cgnfvgnfgvn', '5', '2025-05-24', '11:00am', 'Romantic Date', 'approved', '', 1),
(13, 5, 'xfgcfb', 'amitb@gmail.com', 'cgnfvgnfgvn', '5', '2025-05-23', '08:00am', 'Engagement', 'pending', NULL, 0),
(14, 5, 'xfgcfb', 'amitb@gmail.com', 'cgnfvgnfgvn', '5', '2025-05-24', '03:00pm', 'Engagement', 'approved', '', 1),
(15, 5, 'amit', 'amitb@gmail.com', '6666666666666', '2', '2025-05-25', '08:00am', 'Anniversary', 'approved', '', 1),
(16, 10, 'Anu', 'topi12@gmail.com', '7898777675', '2', '2025-05-26', '08:00pm', 'jhgyfyui.uggvv', 'pending', NULL, 0),
(17, 11, 'abc', 'jishu232@gmail.com', '8976777867', '2', '2025-05-28', '08:00pm', 'jkgjhkvh', 'pending', NULL, 0),
(18, 12, 'abc', 'subha12@gmail.com', '7866678987', '8', '2025-05-30', '09:00pm', 'gncmhfxcbvm', 'pending', NULL, 0),
(19, 13, 'Uttam', 'Uttam11@gmail.com', '8799987897', '4', '2025-06-01', '08:00pm', 'knkn', 'pending', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(5, 'amit', 'amitb@gmail.com', '8145623791', '9b506e747b47941839697beb09ee1a22d5b89c20', ',kjk, m j , ,mbkb,   nm mn mn, .,nlknlnl, ,mn n  , bhbh - 3'),
(7, 'sujit', 'bolta@rediffmail.com', '933233', '81fe8bfe87576c3ecb22426f8e57847382917acf', ''),
(8, 'awdsasdsf', 'asdsdfs@gmail.cpm', '2111111', '43814346e21444aaf4f70841bf7ed5ae93f55a9d', ''),
(9, 'gayatri', 'g@gmail.com', '1234567896', '5243a030348e3a0c0f0706569f378afa9c57074e', ''),
(10, 'Topi', 'topi12@gmail.com', '6788898767', 'c5155a86f76ab0ab82d083bdc66a0691b0f8802c', '22, 22, 45, 45, 55, 56, 66 - 678988'),
(11, 'Jishu', 'jishu232@gmail.com', '7898765789', '394f6067ef3219a836ff9d65241cf351ae3e892a', '4, 5, 77, 78, 8, 99, 98 - 897678'),
(12, 'Subha', 'subha12@gmail.com', '8798878897', '303551c6beaba58f4e7c7d1de2a0c06fe779ab09', '55, 78, abc, abc, xyz, xyz, aaaaa - 789995'),
(13, 'Uttam', 'Uttam11@gmail.com', '8977789767', '8aebbd1ad9f7cce52bdab80e56e8da90adaf19dd', '33, 33, 45, 44, 5, 55, 56 - 678889');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reserve_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reserve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
