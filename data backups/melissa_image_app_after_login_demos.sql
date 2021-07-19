-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2021 at 05:09 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `melissa_image_app`
--
CREATE DATABASE IF NOT EXISTS `melissa_image_app` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `melissa_image_app`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` mediumint(9) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Portraits'),
(2, 'Landscapes'),
(3, 'Pet photos'),
(4, 'Macro Photos'),
(5, 'Black and White');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `body` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `user_id`, `body`, `date`, `post_id`, `is_approved`) VALUES
(1, 1, 'Melissa is commenting on the first post', '2021-06-22 09:44:23', 1, 1),
(2, 2, 'second user commenting on second post', '2021-06-22 09:44:23', 2, 1),
(4, 1, 'testing on Friday', '2021-06-25 10:02:20', 1, 1),
(5, 1, 'hello\r\n', '2021-06-25 10:44:24', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` mediumint(9) NOT NULL,
  `title` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `date` datetime NOT NULL,
  `category_id` mediumint(9) NOT NULL,
  `body` varchar(500) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `image`, `user_id`, `date`, `category_id`, `body`, `allow_comments`, `is_published`) VALUES
(17, 'Yellow abstract', 'b7b8eddb6384b78d33cdf14de06872e35462c1a6', 1, '2021-07-18 22:13:58', 2, 'It&#39;s a balloon', 1, 1),
(18, 'Mosaic Tile', 'f282a3d6c22ea8f609e214f331039e41c1b4537f', 1, '2021-07-18 22:14:24', 1, 'Good colors', 1, 1),
(19, 'Gradient', '37d5b859fb8b68998a58c9a3f58e43f9eb07d4bc', 1, '2021-07-18 22:15:22', 4, 'Blurry colors', 1, 1),
(20, 'Speeding Train', 'f6fa46f2eda8d79cf22319701b65d25b50adc97d', 1, '2021-07-18 22:18:23', 4, 'Going fast', 1, 1),
(21, 'Video Camera', 'ece5052c1860166daec8966c0a6f67e38c7eba18', 1, '2021-07-18 22:18:44', 1, 'Foggy Atmosphere', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `tag_id` mediumint(9) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `name`) VALUES
(1, 'happy'),
(2, 'pets');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` mediumint(9) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` varchar(1000) NOT NULL,
  `profile_pic` varchar(250) NOT NULL,
  `email` varchar(254) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `join_date` datetime NOT NULL,
  `access_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `bio`, `profile_pic`, `email`, `is_admin`, `join_date`, `access_token`) VALUES
(1, 'Melissa', '$2y$10$Cc0KHyJQzrkKJ9O16lwrTOkkVFRMYGy4tLW8awEwGbN3FEDpv1L3S', 'Hello this is my Bio!', 'https://randomuser.me/api/portraits/lego/9.jpg', 'melissacabral@gmail.com', 1, '2021-06-22 09:33:34', 'bd0dab4813b25b0145a8c73a651b2ffbde2c5b742f692a7d98e4dff13992'),
(2, 'bananas', '$2y$10$Cc0KHyJQzrkKJ9O16lwrTOkkVFRMYGy4tLW8awEwGbN3FEDpv1L3S', 'This is some user\'s bio right here. I\'m not an admin!', 'https://randomuser.me/api/portraits/lego/7.jpg', 'someuser@mail.com', 0, '2021-06-22 09:35:40', ''),
(4, 'New User', '$2y$10$Cc0KHyJQzrkKJ9O16lwrTOkkVFRMYGy4tLW8awEwGbN3FEDpv1L3S', '', 'images/default.png', 'newish@gmail.com', 0, '2021-07-18 22:13:17', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
