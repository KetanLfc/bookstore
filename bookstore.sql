-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2024 at 01:58 PM
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
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `user_id`, `api_key`, `is_approved`, `created_at`) VALUES
(1, 3, '4734260bdbb0f16be4f0c534050b2533', 1, '2024-02-26 20:46:29'),
(2, 5, '5b0607ebb005e3856a15511790cc6f36', 0, '2024-02-27 09:10:06'),
(3, 6, '605b59ce1f7c7fd2a8eb2c5b9ffe2c35', 0, '2024-02-27 09:18:18'),
(4, 7, '320b7a24d90b1880097ff00e6afff7a3', 1, '2024-02-28 08:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `api_requests`
--

CREATE TABLE `api_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `api_key_id` int(11) NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_requests`
--

INSERT INTO `api_requests` (`id`, `user_id`, `api_key_id`, `request_time`) VALUES
(1, 5, 2, '2024-02-27 09:10:06'),
(2, 6, 3, '2024-02-27 09:18:18'),
(3, NULL, 1, '2024-02-27 13:44:19'),
(4, NULL, 1, '2024-02-27 13:44:53'),
(5, NULL, 1, '2024-02-27 13:52:40'),
(6, NULL, 1, '2024-02-27 13:53:09'),
(7, NULL, 1, '2024-02-27 13:54:18'),
(8, NULL, 1, '2024-02-27 15:02:02'),
(9, NULL, 1, '2024-02-27 15:02:12'),
(10, NULL, 1, '2024-02-27 15:02:18'),
(11, NULL, 1, '2024-02-27 15:04:59'),
(12, NULL, 1, '2024-02-27 15:16:03'),
(13, NULL, 1, '2024-02-27 15:16:09'),
(14, NULL, 1, '2024-02-27 15:22:05'),
(15, NULL, 1, '2024-02-27 15:22:12'),
(16, NULL, 1, '2024-02-27 15:51:16'),
(17, NULL, 1, '2024-02-27 15:51:24'),
(18, NULL, 1, '2024-02-27 15:56:44'),
(19, NULL, 1, '2024-02-27 15:57:14'),
(20, NULL, 1, '2024-02-27 15:59:04'),
(21, NULL, 1, '2024-02-27 15:59:08'),
(22, NULL, 1, '2024-02-27 15:59:25'),
(23, NULL, 1, '2024-02-27 16:01:54'),
(24, NULL, 1, '2024-02-27 16:02:18'),
(25, NULL, 1, '2024-02-27 16:02:48'),
(26, NULL, 1, '2024-02-27 16:03:00'),
(27, NULL, 1, '2024-02-27 16:03:14'),
(28, NULL, 1, '2024-02-27 16:05:37'),
(29, NULL, 1, '2024-02-27 16:05:50'),
(30, NULL, 1, '2024-02-27 16:07:39'),
(31, NULL, 1, '2024-02-27 16:09:13'),
(32, NULL, 1, '2024-02-27 16:12:53'),
(33, NULL, 1, '2024-02-27 16:12:59'),
(34, NULL, 1, '2024-02-27 16:14:32'),
(35, NULL, 1, '2024-02-27 16:14:38'),
(36, NULL, 1, '2024-02-27 16:14:48'),
(37, NULL, 1, '2024-02-27 18:06:11'),
(38, NULL, 1, '2024-02-27 18:06:19'),
(39, 7, 4, '2024-02-28 08:53:21'),
(40, NULL, 1, '2024-02-28 11:00:00'),
(41, NULL, 1, '2024-02-28 11:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` text DEFAULT NULL,
  `pub_year` year(4) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `reviews` text DEFAULT NULL,
  `best_seller` tinyint(1) DEFAULT NULL,
  `cover_photo` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `pub_year`, `description`, `language`, `isbn`, `reviews`, `best_seller`, `cover_photo`, `category`) VALUES
(1, 'To Kill a Mockingbird', 'Harper Lee', '1960', 'A novel about the childhood reflections of a girl named Scout.', 'English', '9780061120084', 'Timeless narrative', 1, 'http://localhost:8080/Assignment2/images/tokillamockingbird.jpg', 'Classic'),
(2, 'Pride and Prejudice', 'Jane Austen', '2000', 'A romantic novel of manners.', 'English', '9781936594291', 'A masterpiece of wit', 0, 'http://localhost:8080/Assignment2/images/pride-and-prejudice.jpg', 'Romance'),
(3, '1984', 'George Orwell', '1949', 'A dystopian social science fiction novel and cautionary tale.', 'English', '9780451524935', 'Profoundly disturbing', 1, 'http://localhost:8080/Assignment2/images/1984.jpg', 'Science Fiction'),
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', '1925', 'A story of the mysteriously wealthy Jay Gatsby and his love for Daisy Buchanan.', 'English', '9780743273565', 'A classic tale of American dream', 0, 'http://localhost:8080/Assignment2/images/thegreatgatsby.jpg', 'Classic'),
(5, 'Moby Dick', 'Herman Melville', '2005', 'A sailor’s narrative of the obsessive quest of Ahab.', 'English', '9781503280786', 'Epic in scale', 0, 'http://localhost:8080/Assignment2/images/mobydick.jpg', 'Adventure'),
(6, 'The Hobbit', 'J.R.R. Tolkien', '1937', 'A children\'s fantasy novel and prelude to The Lord of the Rings.', 'English', '9780547928227', 'An unexpected journey', 1, 'http://localhost:8080/Assignment2/images/thehobbit.jpg', 'Fantasy'),
(7, 'War and Peace', 'Leo Tolstoy', '2002', 'A novel that chronicles life in Russia during the Napoleonic era.', 'English', '9780307266934', 'A narrative of families', 0, 'http://localhost:8080/Assignment2/images/warandpeace.jpg', 'Historical Fiction'),
(8, 'The Catcher in the Rye', 'J.D. Salinger', '1951', 'A story about the teenage angst and alienation.', 'English', '9780316769488', 'A controversial classic', 0, 'http://localhost:8080/Assignment2/images/catcherintherye.jpg', 'Young Adult'),
(9, 'Crime and Punishment', 'Fyodor Dostoevsky', '1999', 'A psychological exploration of crime and its motives.', 'English', '9780486415871', 'A psychological thriller', 1, 'http://localhost:8080/Assignment2/images/crimeandpunishment.jpg', 'Psychological Fiction'),
(10, 'The Alchemist', 'Paulo Coelho', '1988', 'A philosophical story about an Andalusian shepherd\'s journey.', 'English', '9780061122415', 'Inspirational and magical', 1, 'http://localhost:8080/Assignment2/images/thealchemist.jpg', 'Philosophical');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
(3, 'VVD', 'vandijk@gmail.com', '$2y$10$LoUpateX9OoEvxbDI0ItQ.OVrXqHs8ZvlP.lYrU.Cd0i5p62SQOha', '2024-02-26 20:46:29', 0),
(5, 'salah', 'msalah@gmail.com', '$2y$10$BQ7wh.pPAgmmIEdFtVt8X.Nl5BVjdKvy5/j6vn5gSeaxRNVswevfu', '2024-02-27 09:10:06', 0),
(6, 'admin', 'ketanlfc8@gmail.com', '$2y$10$JYBAZHMjnXsQXvsHm5N0NOfGzi4bOK5mc0vwyS5WdsggPW1M6pN02', '2024-02-27 09:18:18', 1),
(7, 'nunez', 'darwin@gmail.com', '$2y$10$/vJ/b2ZZCSkvGXyuGtDKkOY56MnbGpj3JTcIkXuz6Ez8JMsawx.LC', '2024-02-28 08:53:21', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_key` (`api_key`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `api_requests`
--
ALTER TABLE `api_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `api_key_id` (`api_key_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `api_requests`
--
ALTER TABLE `api_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD CONSTRAINT `api_keys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `api_requests`
--
ALTER TABLE `api_requests`
  ADD CONSTRAINT `api_requests_ibfk_1` FOREIGN KEY (`api_key_id`) REFERENCES `api_keys` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
