-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2021 at 06:30 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
(3, 'Pet photos');

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
(1, 'A deer', 'https://picsum.photos/id/1003/400/400', 1, '2021-03-03 11:00:15', 3, 'this is a sample post for testing\r\n\r\nline break test\r\n\r\nanother break', 1, 1),
(2, 'Blanket Pug', 'https://picsum.photos/id/1062/400/400', 2, '2021-03-01 11:01:15', 1, 'It\'s a pug in a blanket. It\'s in category 1 and written by user 2. comments are off. I posted it on Monday March 1', 0, 1),
(3, 'Canoe', 'https://picsum.photos/id/1011/400/400', 1, '2021-03-01 11:01:15', 2, 'It\'s a person in a canoe', 1, 1),
(4, 'Canyon at Sunset', 'https://picsum.photos/id/1016/400/400', 1, '2021-03-01 11:01:15', 2, 'Look at this view!', 1, 1),
(5, 'Raspberries on a fence', 'https://picsum.photos/id/102/400/400', 2, '2021-03-11 07:31:00', 4, 'Weird place to keep your raspberries', 1, 1),
(6, 'Blanket Pug Part 2', 'https://picsum.photos/id/1025/400/400', 1, '2021-03-11 07:34:27', 2, 'Another little burrito pug', 1, 1),
(7, 'Mountain Bike', 'https://picsum.photos/id/1023/400/400', 1, '2021-03-11 07:35:25', 1, 'Going out to get some air', 1, 1),
(8, 'Aurora Borealis', 'https://picsum.photos/id/1022/400/400', 1, '2021-03-11 07:35:56', 1, 'The northern lights', 0, 1),
(9, 'Vulture', 'https://picsum.photos/id/1024/400/400', 1, '2021-03-11 07:43:37', 3, 'Pretty sure that\'s a vulture', 1, 1),
(10, 'Dream Catcher', 'https://picsum.photos/id/104/400/400', 1, '2021-03-11 07:43:37', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 0, 1),
(11, 'Long exposure at night', 'https://picsum.photos/id/1042/400/400', 2, '2021-03-11 07:43:37', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(12, 'Waves Crashing', 'https://picsum.photos/id/1053/400/400', 1, '2021-03-11 07:43:37', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(13, 'Castle', 'https://picsum.photos/id/1040/400/400', 1, '2021-03-11 07:43:37', 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(14, 'Back Alley', 'https://picsum.photos/id/1047/400/400', 1, '2021-03-11 07:43:37', 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(15, 'Flowers against the sky', 'https://picsum.photos/id/106/400/400', 2, '2021-03-11 07:35:25', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 1, 1),
(16, 'Coffee Time', 'https://picsum.photos/id/1060/400/400', 1, '2021-03-11 07:43:37', 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent risus nunc, mattis in metus quis, luctus accumsan justo. Aenean eget lacus mauris. Integer iaculis mattis ullamcorper. Nam at tristique magna, at faucibus ex. Donec ut porta turpis, sed laoreet magna. Fusce non quam vel magna cursus facilisis nec vehicula nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent eros elit, ornare ac dui porta, lobortis auctor ipsum. Proin ac metus d', 0, 1);

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
  `password` varchar(40) NOT NULL,
  `bio` varchar(1000) NOT NULL,
  `profile_pic` varchar(250) NOT NULL,
  `email` varchar(254) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `join_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `bio`, `profile_pic`, `email`, `is_admin`, `join_date`) VALUES
(1, 'Melissa', 'password', 'Hello this is my Bio!', 'https://randomuser.me/api/portraits/lego/9.jpg', 'melissacabral@gmail.com', 1, '2021-06-22 09:33:34'),
(2, 'bananas', 'newpassword123', 'This is some user\'s bio right here. I\'m not an admin!', 'https://randomuser.me/api/portraits/lego/7.jpg', 'someuser@mail.com', 0, '2021-06-22 09:35:40');

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
  MODIFY `category_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
