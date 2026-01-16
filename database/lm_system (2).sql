-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 16, 2026 at 08:48 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lm_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `category_id` int NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `available_qty` int DEFAULT '1',
  `total_qty` int DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category_id`, `isbn`, `cover_image`, `available_qty`, `total_qty`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'The Colour Purple', 'Alice Walke', 2, '9789043702997', 'img_696375b35efbf1.52166619.jpg', 100, 100, 1, '2025-12-21 09:23:56', '2026-01-16 20:13:02'),
(2, 'East of Eden', 'John Steinbeck', 6, '9781398866102', 'img_69637f34dce0c7.22610044.jpg', 80, 80, 1, '2025-12-21 09:59:09', '2026-01-15 05:04:30'),
(5, 'Murder', 'Arnold Bennett', 2, '9787929596791', 'img_6963839a3735f7.81878893.jpg', 121, 121, 1, '2026-01-07 12:45:13', '2026-01-15 05:04:30'),
(10, 'The Open Boat', 'Stephen Crane', 3, '9781988079363', 'img_696383fc0244f3.74885025.jpg', 123, 123, 1, '2026-01-08 12:21:39', '2026-01-15 05:04:30'),
(12, 'The Speckled Band', 'Sir Arthur Conan Doyle', 2, '9786459424536', 'img_69638488d69d40.58622130.jpg', 120, 120, 1, '2026-01-08 12:33:56', '2026-01-15 05:04:30'),
(15, 'The Signalman', 'Arthur Conan Doyle', 2, '9789583213946', 'img_696384ce4578d0.11207971.jpg', 123, 123, 1, '2026-01-10 12:30:33', '2026-01-15 05:04:30'),
(17, 'The Diamond as Big as the Ritz', 'F Scott Fitzgerald', 4, '9782530543332', 'img_696385352cf726.46878706.jpg', 200, 200, 1, '2026-01-10 15:58:56', '2026-01-15 05:04:30'),
(18, 'The Hostage', 'CS Forester', 5, '9786080221610', 'img_696569952d2246.96443120.jpg', 1, 1, 1, '2026-01-10 16:41:58', '2026-01-15 05:04:30'),
(26, 'check book edit', 'check author edit', 1, '9782842016906', 'img_6965322a7a8ca8.18206547.jpg', 1000, 1000, 1, '2026-01-12 17:32:41', '2026-01-16 20:13:14'),
(27, 'new book', 'new author', 3, '9782172917782', 'img_69655dffed8979.99949513.jpg', 25, 25, 1, '2026-01-12 20:47:59', '2026-01-16 20:06:08'),
(29, 'check title edit', 'check author edit', 3, '9782637946593', 'img_696570909425a7.82099644.jpg', 40, 40, 1, '2026-01-12 22:07:12', '2026-01-15 05:17:11'),
(33, 'life', 'life author', 3, '9780388803547', 'img_69661574831821.92003141.jpg', 10, 10, 1, '2026-01-13 09:50:44', '2026-01-16 20:05:51'),
(37, 'hasirama', 'senju', 6, '9782788866061', 'img_696a88cb17f4c5.89423045.jpg', 120, 120, 1, '2026-01-16 18:51:55', '2026-01-16 18:51:55'),
(38, 'feelingsss', 'maartinss', 5, '9781237545151', 'img_696a96d2da7af5.17171234.jpg', 12, 12, 1, '2026-01-16 19:51:46', '2026-01-16 20:04:36'),
(39, 'new book creates', 'new author creates', 5, '9789459299791', 'img_696a9cb3a32728.22088249.jpg', 12, 12, 1, '2026-01-16 20:16:51', '2026-01-16 20:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int NOT NULL,
  `member_id` int NOT NULL,
  `book_id` int NOT NULL,
  `issue_date` date NOT NULL,
  `last_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('borrowed','returned') DEFAULT 'borrowed',
  `fine` decimal(10,2) DEFAULT '0.00',
  `qty` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `member_id`, `book_id`, `issue_date`, `last_date`, `return_date`, `status`, `fine`, `qty`) VALUES
(1, 2, 1, '2025-12-21', '2025-12-28', '2026-01-09', 'returned', 0.00, 5),
(2, 2, 2, '2025-12-24', '2025-12-31', '2026-01-17', 'returned', 0.00, 16),
(3, 2, 2, '2025-12-25', '2026-01-01', '2026-01-10', 'returned', 0.00, 25),
(4, 2, 1, '2025-12-23', '2025-12-30', '2026-01-10', 'returned', 0.00, 12),
(5, 2, 1, '2025-12-26', '2026-01-02', '2026-01-10', 'returned', 0.00, 3),
(6, 2, 1, '2025-12-27', '2026-01-03', '2026-01-02', 'returned', 0.00, 3),
(7, 2, 1, '2025-12-25', '2026-01-01', '2026-01-14', 'returned', 0.00, 14),
(8, 2, 2, '2025-12-25', '2026-01-01', '2026-01-10', 'returned', 0.00, 12),
(9, 2, 1, '2025-12-23', '2025-12-30', '2026-01-16', 'returned', 0.00, 5),
(10, 2, 2, '2025-12-24', '2025-12-31', '2025-12-31', 'returned', 0.00, 13),
(11, 2, 1, '2025-12-24', '2025-12-31', '2026-01-08', 'returned', 0.00, 16),
(12, 2, 2, '2025-12-25', '2026-01-01', '2026-01-02', 'returned', 0.00, 21),
(13, 2, 2, '2025-12-23', '2025-12-30', '2026-01-15', 'returned', 0.00, 41),
(14, 2, 1, '2025-12-31', '2026-01-07', '2026-01-10', 'returned', 0.00, 14),
(15, 3, 1, '2025-12-25', '2026-01-01', '2026-01-10', 'returned', 0.00, 5),
(16, 4, 2, '2025-12-23', '2025-12-30', '2026-01-08', 'returned', 0.00, 7),
(17, 3, 1, '2025-12-26', '2026-01-02', '2026-01-10', 'returned', 0.00, 12),
(18, 2, 2, '2025-12-23', '2025-12-30', '2026-01-10', 'returned', 0.00, 4),
(19, 2, 1, '2025-12-25', '2026-01-01', '2026-01-08', 'returned', 0.00, 3),
(20, 3, 1, '2025-12-24', '2025-12-31', '2026-01-16', 'returned', 0.00, 10),
(21, 2, 2, '2025-12-25', '2026-01-01', '2026-01-10', 'returned', 0.00, 10),
(22, 2, 1, '2025-12-24', '2025-12-31', '2026-01-10', 'returned', 0.00, 10),
(23, 2, 1, '2025-12-26', '2026-01-02', '2026-01-10', 'returned', 0.00, 10),
(24, 3, 2, '2025-12-25', '2026-01-01', '2026-01-10', 'returned', 0.00, 2),
(25, 3, 1, '2025-12-25', '2026-01-01', '2026-01-16', 'returned', 0.00, 5),
(26, 3, 1, '2025-12-31', '2026-01-07', '2026-01-10', 'returned', 0.00, 2),
(27, 3, 2, '2025-12-24', '2025-12-31', '2026-01-10', 'returned', 0.00, 3),
(28, 2, 2, '2025-12-31', '2026-01-07', '2026-01-10', 'returned', 0.00, 4),
(29, 2, 1, '2025-12-31', '2026-01-07', '2026-01-17', 'returned', 0.00, 20),
(30, 3, 2, '2026-01-24', '2026-01-31', '2026-01-31', 'returned', 0.00, 50),
(31, 5, 1, '2026-01-28', '2026-01-03', '2026-01-24', 'returned', 0.00, 2),
(32, 5, 2, '2026-01-16', '2026-01-03', '2026-01-10', 'returned', 0.00, 5),
(33, 3, 2, '2026-01-05', '2026-01-12', '2026-01-24', 'returned', 0.00, 5),
(34, 3, 2, '2026-01-23', '2026-01-30', '2026-01-31', 'returned', 0.00, 2),
(35, 4, 2, '2026-01-23', '2026-01-30', '2026-01-31', 'returned', 0.00, 11),
(36, 4, 2, '2026-01-31', '2026-02-07', '2026-01-31', 'returned', 0.00, 22),
(37, 4, 2, '2026-01-29', '2026-02-05', '2026-01-30', 'returned', 0.00, 14),
(38, 2, 1, '2026-01-24', '2026-01-31', '2026-01-31', 'returned', 0.00, 18),
(39, 2, 1, '2026-01-10', '2026-01-17', '2026-01-31', 'returned', 0.00, 10),
(40, 2, 1, '2026-01-24', '2026-01-31', '2026-01-31', 'returned', 0.00, 18),
(41, 3, 2, '2026-01-22', '2026-01-29', '2026-01-28', 'returned', 0.00, 18),
(42, 5, 2, '2026-01-22', '2026-01-29', '2026-01-27', 'returned', 0.00, 10),
(43, 3, 1, '2026-01-22', '2026-01-29', '2026-01-23', 'returned', 0.00, 12),
(44, 4, 1, '2026-01-21', '2026-01-28', '2026-01-20', 'returned', 0.00, 4),
(45, 5, 2, '2026-01-23', '2026-01-30', '2026-01-31', 'returned', 0.00, 11),
(46, 3, 1, '2026-01-14', '2026-01-21', '2026-01-31', 'returned', 0.00, 12),
(47, 2, 1, '2026-01-21', '2026-01-28', '2026-01-31', 'returned', 0.00, 1),
(48, 3, 2, '2026-01-08', '2026-01-15', '2026-01-31', 'returned', 0.00, 12),
(49, 5, 2, '2026-01-08', '2026-01-15', '2026-02-14', 'returned', 0.00, 21),
(50, 8, 10, '2026-01-08', '2026-01-15', '2026-01-31', 'returned', 0.00, 12),
(51, 5, 10, '2026-01-31', '2026-02-07', '2026-01-31', 'returned', 0.00, 12),
(52, 2, 5, '2026-01-16', '2026-01-23', '2026-01-24', 'returned', 0.00, 12),
(53, 3, 5, '2026-01-16', '2026-01-23', '2026-01-24', 'returned', 0.00, 12),
(54, 4, 5, '2026-01-31', '2026-02-07', '2026-01-31', 'returned', 0.00, 12),
(59, 4, 1, '2026-01-23', '2026-01-30', '2026-01-31', 'returned', 0.00, 12),
(60, 3, 2, '2026-01-10', '2026-01-17', '2026-02-07', 'returned', 0.00, 12),
(62, 4, 2, '2026-01-17', '2026-01-24', '2026-01-31', 'returned', 0.00, 60),
(64, 3, 2, '2026-01-31', '2026-02-07', '2026-01-31', 'returned', 0.00, 60),
(65, 4, 1, '2026-01-10', '2026-01-17', '2026-02-21', 'returned', 0.00, 10),
(66, 4, 10, '2026-01-24', '2026-01-31', '2026-01-31', 'returned', 0.00, 123),
(68, 4, 10, '2026-01-11', '2026-01-18', '2026-02-28', 'returned', 0.00, 12),
(69, 4, 2, '2026-01-31', '2026-02-07', '2026-01-31', 'returned', 0.00, 12),
(70, 3, 2, '2026-01-31', '2026-02-07', '2026-01-22', 'returned', 0.00, 12),
(71, 4, 5, '2026-01-12', '2026-01-19', '2026-02-28', 'returned', 0.00, 12),
(72, 5, 10, '2026-01-20', '2026-01-27', '2026-01-12', 'returned', 0.00, 12),
(73, 2, 2, '2026-01-11', '2026-01-18', '2026-01-24', 'returned', 0.00, 40),
(74, 2, 2, '2026-01-11', '2026-01-18', '2026-01-31', 'returned', 0.00, 20),
(75, 2, 2, '2026-01-22', '2026-01-29', '2026-01-22', 'returned', 0.00, 12),
(76, 2, 2, '2026-01-11', '2026-01-18', '2026-01-14', 'returned', 0.00, 30),
(77, 2, 2, '2026-01-12', '2026-01-19', '2026-01-31', 'returned', 0.00, 30),
(78, 2, 5, '2026-01-17', '2026-01-24', '2026-01-31', 'returned', 0.00, 12),
(79, 3, 2, '2026-01-14', '2026-01-21', '2026-02-28', 'returned', 0.00, 12),
(82, 5, 2, '2026-01-13', '2026-01-20', '2026-01-30', 'returned', 0.00, 50),
(83, 5, 27, '2026-01-16', '2026-01-23', '2026-01-16', 'returned', 0.00, 20),
(84, 2, 18, '2026-01-13', '2026-01-20', '2026-02-07', 'returned', 0.00, 1),
(85, 5, 26, '2026-01-17', '2026-01-24', '2026-02-07', 'returned', 0.00, 26),
(86, 5, 29, '2026-01-17', '2026-01-24', '2026-01-18', 'returned', 0.00, 22),
(87, 5, 29, '2026-01-17', '2026-01-24', '2026-02-07', 'returned', 0.00, 20),
(88, 5, 29, '2026-01-17', '2026-01-24', '2026-01-31', 'returned', 0.00, 20),
(89, 5, 18, '2026-01-17', '2026-01-24', '2026-02-14', 'returned', 0.00, 1),
(90, 5, 29, '2026-01-16', '2026-01-23', '2026-02-21', 'returned', 0.00, 20),
(91, 5, 29, '2026-01-19', '2026-01-26', '2026-02-21', 'returned', 0.00, 20),
(92, 5, 10, '2026-01-22', '2026-01-29', '2026-02-14', 'returned', 0.00, 10),
(93, 5, 1, '2026-01-15', '2026-01-22', '2026-02-28', 'returned', 0.00, 12),
(94, 5, 2, '2026-01-17', '2026-01-24', '2026-02-14', 'returned', 0.00, 55),
(95, 5, 18, '2026-01-17', '2026-01-24', '2026-01-20', 'returned', 0.00, 1),
(97, 5, 2, '2026-01-17', '2026-01-24', '2026-02-14', 'returned', 0.00, 65),
(98, 27, 5, '2026-01-17', '2026-01-24', '2026-01-31', 'returned', 0.00, 12),
(99, 5, 12, '2026-01-17', '2026-01-24', '2026-01-31', 'returned', 0.00, 12),
(101, 5, 2, '2026-01-17', '2026-01-24', '2026-02-20', 'returned', 0.00, 80);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fictions', 0, '2026-01-15 05:03:09', '2026-01-16 18:11:43'),
(2, 'Crime', 1, '2026-01-15 05:03:09', '2026-01-16 18:07:17'),
(3, 'Classic', 1, '2026-01-15 05:03:09', '2026-01-15 05:03:09'),
(4, 'Science Fiction', 1, '2026-01-15 05:03:09', '2026-01-15 05:03:09'),
(5, 'Adventure', 1, '2026-01-15 05:03:09', '2026-01-16 19:48:39'),
(6, 'American Literature', 1, '2026-01-15 05:03:09', '2026-01-15 05:03:09'),
(10, 'new category', 1, '2026-01-16 19:48:55', '2026-01-16 19:48:55'),
(12, 'lolos', 0, '2026-01-16 20:32:08', '2026-01-16 20:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` int NOT NULL,
  `borrow_id` int NOT NULL,
  `member_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('nothing','pending','paid') DEFAULT 'nothing',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `paid_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `borrow_id`, `member_id`, `amount`, `status`, `created_at`, `paid_at`) VALUES
(1, 1, 2, 1200.00, 'paid', '2025-12-21 09:27:18', '2025-12-22 21:11:00'),
(2, 2, 2, 1700.00, 'paid', '2025-12-22 21:18:48', '2025-12-22 21:26:10'),
(3, 4, 2, 300.00, 'paid', '2025-12-23 14:22:29', '2025-12-23 14:43:51'),
(4, 4, 2, 1100.00, 'paid', '2025-12-23 14:25:13', '2025-12-23 14:52:27'),
(5, 3, 2, 900.00, 'paid', '2025-12-23 14:33:21', '2025-12-23 14:42:42'),
(6, 5, 2, 800.00, 'paid', '2025-12-23 14:52:59', '2025-12-23 14:53:08'),
(7, 7, 2, 1300.00, 'paid', '2025-12-23 14:56:15', '2025-12-23 14:56:25'),
(8, 8, 2, 900.00, 'paid', '2025-12-23 16:56:57', '2025-12-23 17:00:00'),
(9, 9, 2, 1700.00, 'paid', '2025-12-23 16:57:53', '2025-12-23 17:00:05'),
(10, 11, 2, 800.00, 'paid', '2025-12-23 17:04:10', '2025-12-23 17:06:19'),
(11, 12, 2, 100.00, 'paid', '2025-12-23 17:22:15', '2025-12-23 17:32:27'),
(12, 13, 2, 1600.00, 'paid', '2025-12-23 17:31:43', '2025-12-23 17:32:37'),
(13, 14, 2, 300.00, 'paid', '2025-12-23 17:32:06', '2025-12-23 17:32:42'),
(14, 15, 3, 900.00, 'paid', '2025-12-23 17:35:43', '2025-12-23 17:37:13'),
(15, 16, 4, 900.00, 'paid', '2025-12-23 17:38:07', '2025-12-23 19:10:28'),
(16, 17, 3, 800.00, 'paid', '2025-12-23 17:41:58', '2025-12-23 19:10:34'),
(17, 18, 2, 1100.00, 'paid', '2025-12-23 17:42:48', '2025-12-23 19:10:43'),
(18, 19, 2, 700.00, 'paid', '2025-12-23 17:44:03', '2025-12-23 19:10:52'),
(19, 20, 3, 1600.00, 'paid', '2025-12-23 19:08:24', '2025-12-23 19:10:58'),
(20, 21, 2, 900.00, 'paid', '2025-12-23 19:14:23', '2025-12-26 16:39:06'),
(21, 22, 2, 1000.00, 'paid', '2025-12-23 19:27:20', '2025-12-26 16:39:13'),
(22, 23, 2, 800.00, 'paid', '2025-12-23 19:28:20', '2025-12-26 19:19:10'),
(23, 24, 3, 900.00, 'paid', '2025-12-23 19:30:01', '2025-12-26 20:44:34'),
(24, 25, 3, 1500.00, 'paid', '2025-12-23 19:31:25', '2025-12-26 20:44:28'),
(25, 27, 3, 1000.00, 'paid', '2025-12-23 19:31:40', '2025-12-26 20:44:22'),
(26, 26, 3, 300.00, 'paid', '2025-12-23 19:31:54', '2025-12-26 20:44:13'),
(27, 28, 2, 300.00, 'paid', '2025-12-23 19:32:56', '2025-12-26 20:44:07'),
(28, 30, 3, 300.00, 'paid', '2025-12-26 20:32:36', '2025-12-26 20:43:59'),
(29, 29, 2, 1000.00, 'paid', '2025-12-26 20:32:45', '2025-12-26 20:43:03'),
(30, 33, 5, 1400.00, 'paid', '2025-12-26 20:33:56', '2025-12-26 20:42:54'),
(31, 32, 5, 700.00, 'paid', '2025-12-26 20:34:09', '2025-12-26 20:34:43'),
(32, 31, 5, 2100.00, 'paid', '2025-12-26 20:43:40', '2025-12-26 20:43:49'),
(33, 33, 3, 1200.00, 'paid', '2026-01-05 17:06:13', '2026-01-05 17:47:59'),
(34, 34, 3, 100.00, 'paid', '2026-01-05 17:09:46', '2026-01-05 17:47:54'),
(35, 35, 4, 100.00, 'paid', '2026-01-05 17:11:57', '2026-01-05 17:47:49'),
(36, 39, 2, 1400.00, 'paid', '2026-01-05 17:41:23', '2026-01-05 17:47:41'),
(37, 45, 5, 100.00, 'paid', '2026-01-07 10:25:35', '2026-01-07 14:14:24'),
(38, 46, 3, 1000.00, 'paid', '2026-01-07 12:19:26', '2026-01-07 14:13:52'),
(39, 47, 2, 300.00, 'paid', '2026-01-07 12:19:39', '2026-01-07 14:13:42'),
(40, 48, 3, 1600.00, 'paid', '2026-01-07 14:16:43', '2026-01-08 17:01:32'),
(41, 49, 5, 3000.00, 'paid', '2026-01-08 07:12:22', '2026-01-08 17:01:23'),
(42, 50, 8, 1600.00, 'paid', '2026-01-08 12:22:35', '2026-01-08 16:58:46'),
(43, 53, 3, 100.00, 'paid', '2026-01-08 16:28:35', '2026-01-08 16:58:39'),
(44, 52, 2, 100.00, 'paid', '2026-01-08 16:29:55', '2026-01-08 16:58:29'),
(45, 59, 4, 100.00, 'paid', '2026-01-09 14:52:14', '2026-01-10 12:35:22'),
(46, 60, 3, 2100.00, 'paid', '2026-01-10 12:34:55', '2026-01-10 12:35:27'),
(47, 62, 4, 700.00, 'paid', '2026-01-10 12:36:03', '2026-01-10 12:58:25'),
(48, 65, 4, 3500.00, 'paid', '2026-01-10 17:49:31', '2026-01-10 17:51:49'),
(49, 68, 4, 4100.00, 'paid', '2026-01-10 18:57:42', '2026-01-10 18:57:48'),
(50, 71, 4, 4000.00, 'paid', '2026-01-11 09:19:27', '2026-01-11 09:19:38'),
(51, 73, 2, 600.00, 'paid', '2026-01-11 09:24:34', '2026-01-11 09:41:17'),
(52, 74, 2, 1300.00, 'paid', '2026-01-11 09:24:43', '2026-01-11 09:41:21'),
(53, 77, 2, 1200.00, 'paid', '2026-01-11 09:41:06', '2026-01-11 09:41:25'),
(54, 78, 2, 700.00, 'paid', '2026-01-11 09:46:10', '2026-01-11 09:46:19'),
(55, 79, 3, 3800.00, 'paid', '2026-01-11 14:58:11', '2026-01-11 15:04:07'),
(56, 82, 5, 1000.00, 'paid', '2026-01-12 21:21:01', '2026-01-12 21:24:13'),
(57, 88, 5, 700.00, 'paid', '2026-01-12 22:17:28', '2026-01-12 22:21:20'),
(58, 87, 5, 1400.00, 'paid', '2026-01-12 22:18:01', '2026-01-12 22:21:24'),
(59, 85, 5, 1400.00, 'paid', '2026-01-12 22:21:08', '2026-01-12 22:21:29'),
(60, 84, 2, 1800.00, 'paid', '2026-01-12 22:29:05', '2026-01-12 23:20:29'),
(61, 91, 5, 2600.00, 'paid', '2026-01-12 23:13:38', '2026-01-12 23:20:24'),
(62, 90, 5, 2900.00, 'paid', '2026-01-12 23:13:56', '2026-01-12 23:20:20'),
(63, 92, 5, 1600.00, 'paid', '2026-01-12 23:19:07', '2026-01-12 23:20:15'),
(64, 89, 5, 2100.00, 'paid', '2026-01-12 23:19:15', '2026-01-12 23:20:09'),
(65, 93, 5, 3700.00, 'paid', '2026-01-13 08:02:11', '2026-01-13 08:02:27'),
(66, 94, 5, 2100.00, 'paid', '2026-01-13 08:39:27', '2026-01-13 08:39:40'),
(67, 97, 5, 2100.00, 'paid', '2026-01-13 10:02:33', '2026-01-13 10:05:17'),
(68, 98, 27, 700.00, 'paid', '2026-01-13 17:25:02', '2026-01-13 18:32:00'),
(69, 99, 5, 700.00, 'paid', '2026-01-13 18:23:59', '2026-01-13 18:32:05'),
(70, 101, 5, 2700.00, 'paid', '2026-01-13 20:35:50', '2026-01-13 20:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `role` enum('member','Admin') DEFAULT 'member',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `phone`, `profile_image`, `is_active`, `role`, `created_at`, `updated_at`) VALUES
(2, 'hamashudheen', 'hamas@gmail.com', '$2y$10$FmHV4sBzEBK54qL.XCuuk.21Os/NcmYvtPZQOXlRp4/fAyegCh/7.', '071234567823', 'img_696552f0ae00a7.12928845.jpg', 1, 'Admin', '2025-12-21 09:24:51', '2026-01-13 09:43:23'),
(3, 'asfasfoooo', 'fsafsa@gmail.com', '$2y$10$2qMZKHRcnB7G8h7INcJSEuQLHFuVqZ5d2ELpX/6AgZzjo52z.hhzO', '01121212123', 'img_6965534d97dc32.90306853.jpg', 1, 'member', '2025-12-23 17:34:02', '2026-01-12 20:02:21'),
(4, 'sssssss', 'ljkl@gmail.com', '$2y$10$tfUdJohwWgDpWyWpbXtM7.VzOAqVUJ060ouLDY0mthVlNP66HmovG', '23123123123', 'img_69655390ae47b6.83140241.jpg', 1, 'member', '2025-12-23 17:37:35', '2026-01-12 20:03:28'),
(5, 'Member', 'member@gmail.com', '$2y$10$BWA/JR.STRfFr4S7Y1VbTOd2Pq2SBeJzSALNmGkzBSEuGl44FbhUW', '0755754453', 'img_696553ca1d5f82.90494280.webp', 1, 'member', '2025-12-26 17:53:39', '2026-01-12 20:30:55'),
(6, 'mohammadh maayiz', 'admin@example.com', '$2y$10$UPdNdPnyeKkl0eJUJDSCbeAFBBYgRKJkrS.ldKylAiDBiCpcq5LQu', '0756481382', 'img_6965548433ceb5.93168427.jpg', 1, 'Admin', '2025-12-30 19:15:58', '2026-01-12 20:07:32'),
(8, 'sadsad', 'sdasas@gmail.com', '$2y$10$SUIfjk4Se8WftFkiGb./leZHAvife1Uri5yM6653NhcP42Ney5o32', '21321122312', 'img_6965540dc0b402.55002040.jpg', 1, 'member', '2026-01-07 15:34:59', '2026-01-12 20:05:33'),
(27, 'asdsdad', 'asdasd@gmail.com', '$2y$10$613SKQPZQvMw.r4ciRDMre9f/3FK5XnKB0C37S0jo.F..2YFvTJGe', '123123123123', 'img_69655431642982.17486768.jpg', 1, 'member', '2026-01-11 12:57:17', '2026-01-12 20:06:09'),
(28, 'asdsdawwwwww', 'asdassssssd@gmail.com', '$2y$10$zYIGuV740L/YdaN6pF/oRO1cKbDG7OmMzELehIOmhXLPhVa8atCfe', '123123123123', 'img_69639e84bff7d6.07110651.jpg', 1, 'member', '2026-01-11 12:58:44', '2026-01-11 12:58:44'),
(29, 'asddsadssds', 'asdasdaaaa@gmail.com', '$2y$10$50peCyyAIdmLuUb/Ut36tOetptnVp1LT7vU6FgaW.k83Y8cQ.VRc.', '123123123123', 'img_6963a12885c011.13575164.jpg', 1, 'member', '2026-01-11 13:10:00', '2026-01-11 13:16:53'),
(30, 'asdadasd', 'sadjhgjghj@gmail.com', '$2y$10$CRDwDNZ.4IAV.STZVqY8HeHU.HdPfJeFBSopAiKTqYdf8NGgihreG', '123213123123', 'img_6963a2face6ab2.26706167.jpg', 1, 'member', '2026-01-11 13:17:46', '2026-01-11 14:27:35'),
(32, 'muhas muhas', 'muhas@gmail.com', '$2y$10$paL5rZlTCkjEq04lhSNSausFFFFcWol4FfGdkhkEQtrGHZ.PZyaV6', '0714545454545', 'img_6963bdf7c64fd5.02792496.jpg', 1, 'member', '2026-01-11 15:12:55', '2026-01-11 15:12:55'),
(33, 'asdasd  asd      ddd', 'muhassa@gmail.com', '$2y$10$8kmHhV4XaHBu4el1bhyiLO7A6.X2iD4C/un5eT1Jf4aMAPO4F5M3W', '123123123123', 'img_6963bf15e7a699.74816937.jpg', 1, 'member', '2026-01-11 15:17:42', '2026-01-11 15:17:42'),
(34, 'asd asdas asd', 'sa@gmail.com', '$2y$10$vAbHuIMOaldR./vVScrMZOulv0nMksl9mIj60DuujzLTZlE6.8UKS', '123123123123', 'img_6963c053c4e467.53876427.jpg', 1, 'member', '2026-01-11 15:22:59', '2026-01-11 15:22:59'),
(35, 'name', 'zsasa@sadagmail.com', '$2y$10$7IqT8KOehVuS4Hw1UUqnqujrhzSnwMkNMl8rzgbmY/KF3Qtcs9OpC', '123123123123123', 'img_6963c8cd8b9de3.38800075.jpg', 1, 'member', '2026-01-11 15:57:51', '2026-01-11 16:46:25'),
(37, 'full name', 'asdasdfafafa@gmail.com', '$2y$10$wFajznor8KZ/ueXu7H06U.CKOitdX0VhcGQ8SHecgugrzUrpyQ/na', '1231231231234', 'img_6963f3e5e6f874.56491951.jpg', 1, 'member', '2026-01-11 19:03:02', '2026-01-11 19:03:02'),
(59, 'shaham', 'mohammadhsaham@gmail.com', '$2y$10$F38GhquKYr/BvBvuzmTfK.1brqhR7oP.LsABlvpl1.8qQoCB45HEu', '078259852123', 'img_696583b56513e1.45480089.jpg', 1, 'member', '2026-01-12 23:28:53', '2026-01-12 23:28:53'),
(60, 'mohammadh', 'sanas@gmail.com', '$2y$10$VJR9SN.krypsxSCtJ4JOKuTDcwyRZgmbjICwJJaaEecIwYl6ou3ri', '0784898251', 'img_6965f315389e87.20681784.jpg', 1, 'member', '2026-01-13 07:24:05', '2026-01-13 07:24:05'),
(61, 'mohammadh aiyoob', 'mohammadhaiyoob@gmail.com', '$2y$10$8wp0fLLpPcvkApPQK.ugruWOEVffTJDS0qkm1ImLN4Af1t.uLpNly', '07548689822', 'img_69661499986fa8.27903463.jpg', 1, 'member', '2026-01-13 09:47:05', '2026-01-13 09:47:05'),
(63, 'mohammadh hasan', 'mohammadhhasan@gmail.com', '$2y$10$2gEWn5pS0As2FtKXFo6FSeLDiOxaM3UgwUv7CIxAGtLjGBTU08CJC', '0754868982', 'img_696619df4e5132.59202568.jpg', 1, 'member', '2026-01-13 10:09:35', '2026-01-13 10:09:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `fk_books_category` (`category_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrow_id` (`borrow_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fines_ibfk_1` FOREIGN KEY (`borrow_id`) REFERENCES `borrowings` (`id`),
  ADD CONSTRAINT `fines_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
