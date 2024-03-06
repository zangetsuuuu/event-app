-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2024 at 11:55 AM
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
-- Database: `db_event`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `registration_deadline` datetime NOT NULL,
  `max_participants` int(11) NOT NULL,
  `registration_fee` float(10,2) NOT NULL,
  `organizer_name` varchar(100) NOT NULL,
  `organizer_email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `user_id`, `event_name`, `event_description`, `event_date`, `event_location`, `event_image`, `registration_deadline`, `max_participants`, `registration_fee`, `organizer_name`, `organizer_email`, `created_at`, `modified_at`) VALUES
(23, 4, 'Cosplay Event', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat vero adipisci, debitis vitae accusamus aliquid repudiandae explicabo suscipit quis corrupti.', '2024-02-23 00:00:00', 'Bekasi', '65d4be1781c57.jpg', '2024-02-21 00:00:00', 200, 0.00, 'Rafif Athallah', 'rafifathallah99@gmail.com', '2024-02-20 14:58:31', '2024-02-22 07:09:05'),
(24, 4, 'Seminar Pemasaran Digital', 'Bergabunglah dalam seminar kami untuk belajar tentang strategi pemasaran digital terbaru.', '2024-03-20 00:00:00', 'Living Plaza, Jakarta', '65d6ea088106e.jpg', '2024-03-15 00:00:00', 300, 50000.00, 'Rafif Athallah', 'rafifathallah99@gmail.com', '2024-02-20 16:01:03', '2024-02-22 06:32:16'),
(25, 4, 'Pelatihan Desain Grafis', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Odio amet magni iure aut illum nostrum blanditiis officia quisquam dolore earum dolores consequatur maiores, nesciunt hic eligendi enim ex aliquid distinctio.', '2024-03-09 00:00:00', 'Bandung', '65d4cf40aba70.jpg', '2024-03-07 00:00:00', 400, 40000.00, 'Rafif Athallah', 'rafifathallah99@gmail.com', '2024-02-20 16:11:44', '2024-02-20 16:11:44'),
(26, 5, 'Sesi Diskusi Kesehatan Mental', 'Sesi diskusi komunitas tentang kesehatan mental, dengan topik-topik seperti stres, kecemasan, dan cara mengelola kesehatan jiwa sehari-hari.', '2024-02-28 15:00:00', 'Summarecon, Bekasi', '65d5f62580dc1.jpg', '2024-02-27 20:00:00', 300, 50000.00, 'Galva Al Ghozali', 'galvaalghazali@gmail.com', '2024-02-21 13:09:57', '2024-02-25 07:41:02'),
(28, 4, 'Mobile Legend Tournament', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque voluptates ea nisi eum quos aliquid, officia dolor quisquam error? Voluptate cupiditate iure molestias magnam sequi commodi, consectetur voluptatem nostrum ratione.', '2024-03-01 00:00:00', 'Teras Caffe', '65d6e89f87937.jpg', '2024-02-29 00:00:00', 100, 10000.00, 'Rafif Athallah', 'rafifathallah99@gmail.com', '2024-02-22 06:24:31', '2024-02-22 06:24:31'),
(30, 6, 'Nobar Godzilla X Kong', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magnam sit et laudantium ex accusantium, molestiae reiciendis odit, unde vitae quod error nemo inventore eum sequi totam natus earum exercitationem repudiandae.', '2024-03-31 00:00:00', 'Living Plaza, Jakarta', '65d9c96837a6e.jpg', '2024-03-29 00:00:00', 100, 50000.00, 'Gultom Alexander', 'alexmania77@gmail.com', '2024-02-24 10:48:08', '2024-02-24 10:52:22'),
(31, 4, 'tes', 'aaaaaaaaaa', '2024-02-29 00:00:00', 'mana aja', '65da12e216dfc.jpg', '2024-02-27 00:00:00', 50, 0.00, 'Rafif Athallah', 'rafifathallah99@gmail.com', '2024-02-24 16:01:38', '2024-02-28 02:09:00'),
(32, 5, 'Event Apa aja dah', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi illum consequatur maxime corrupti impedit alias dolorum autem. Eaque illo vel animi sit, adipisci odit temporibus quisquam a tenetur, architecto corrupti.', '2024-02-26 19:00:00', 'Yogyakarta', '65dac3aa93d06.jpg', '2024-02-24 12:00:00', 100, 0.00, 'Galva Al Ghozali', 'galvaalghazali@gmail.com', '2024-02-25 04:35:54', '2024-02-25 07:47:26'),
(34, 6, 'Camping', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsum, reiciendis? Placeat nam beatae excepturi tempore laudantium error, aut explicabo perferendis.', '2024-03-10 08:30:00', 'Solo', '65dcbc7dcbb7b.jpg', '2024-03-08 00:00:00', 200, 80000.00, 'Gultom Alexander', 'alexmania77@gmail.com', '2024-02-26 16:29:49', '2024-02-26 16:29:49'),
(35, 5, 'Nobar El Classico', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, doloribus harum delectus tempora quidem ratione ea iste molestias quos aliquam placeat porro tenetur deleniti quis eius atque molestiae maiores sed?', '2024-03-10 01:12:00', 'Teras Caffe', '65de96ce565d5.jpg', '2024-03-08 00:00:00', 200, 0.00, 'Galva Al Ghozali', 'galvaalghazali@gmail.com', '2024-02-28 02:13:34', '2024-02-28 02:13:34'),
(36, 8, 'Testing Aja Ges, LALALALALALALALALA', '-', '2024-03-09 17:34:00', 'Summarecon, Bekasi', '65e05dc95c13f.jpg', '2024-03-08 17:34:00', 200, 0.00, 'Hilman Amrullah', 'hilman123@gmail.com', '2024-02-29 10:34:49', '2024-02-29 10:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `participant_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`participant_id`, `event_id`, `user_id`, `registration_date`) VALUES
(14, 26, 4, '2024-02-23 15:13:36'),
(15, 28, 5, '2024-02-23 15:38:14'),
(16, 28, 6, '2024-02-23 16:01:15'),
(17, 24, 6, '2024-02-24 10:45:26'),
(18, 25, 6, '2024-02-24 10:45:33'),
(19, 28, 7, '2024-02-24 11:16:38'),
(20, 25, 7, '2024-02-24 11:16:57'),
(21, 31, 6, '2024-02-24 16:15:34'),
(22, 23, 5, '2024-02-24 16:36:13'),
(23, 30, 4, '2024-02-25 10:36:36'),
(24, 25, 5, '2024-02-26 16:13:38'),
(25, 34, 4, '2024-02-27 12:07:06'),
(26, 30, 5, '2024-02-27 13:22:42'),
(28, 24, 5, '2024-02-28 02:05:10'),
(29, 35, 4, '2024-02-28 02:16:36'),
(31, 36, 4, '2024-02-29 12:11:56'),
(33, 24, 9, '2024-03-01 11:02:22'),
(34, 30, 10, '2024-03-06 03:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `created_at`) VALUES
(4, 'Rafif Athallah', 'rafifathallah99@gmail.com', '$2y$10$FkGX6FdGCW/ImkXs3reBSuDMalTCqKNfnM/QLPysw39X/iY8gWmjy', '2024-02-16 14:11:44'),
(5, 'Galva Al Ghozali', 'galvaalghazali@gmail.com', '$2y$10$kE4jA8.1H5udj/uU9Fs.XOjNNMLSt700zVtt0huEONnzDsvhqfGqm', '2024-02-19 01:08:51'),
(6, 'Gultom Alexander', 'alexmania77@gmail.com', '$2y$10$0IkKpeeeNboSMM5YGF/s3O5eR3ARQRmwBsDt2XDlH2AMrEgbaJcN6', '2024-02-23 15:54:27'),
(7, 'Indra Styawantoro', 'indra.styawantoro@gmail.com', '$2y$10$8TyUMUPrnAN9PutdzqdLaek1z43ztWMsBufl0W/cVZMQ2SSJp6tiK', '2024-02-24 11:16:16'),
(8, 'Hilman Amrullah', 'hilman123@gmail.com', '$2y$10$iDtFlDdmLRCA/mWwzAnwdO4bGXKMdme1MF9BMlXapF1EOr1goa7oq', '2024-02-29 10:14:21'),
(9, 'Wisnu Ikhwan', 'wisnu12@gmail.com', 'wisnu123', '2024-03-01 03:32:05'),
(10, 'Bagas', 'bagasaurus11@gmail.com', '$2y$10$euJ3ZJ7944A78gW/h5qfruC0OSGA6DUesdm.xJ0X4zaChh8cnXOe.', '2024-03-04 09:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`user_id`, `username`, `bio`, `profile_image`, `date_of_birth`, `address`) VALUES
(4, 'rafthllh', 'No Blood, No Bone, No Ash', '65e1dd4e7b302.jpg', '2004-12-20', 'Bekasi, Jawa Barat'),
(5, 'vienaaa', 'raaaaaaaaaaaah', '', '2002-11-08', ''),
(6, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `participant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
