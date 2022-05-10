-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2022 at 11:23 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookdeets`
--

CREATE TABLE `bookdeets` (
  `book_id` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(15) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `description` varchar(9000) NOT NULL,
  `publication_date` date NOT NULL,
  `bookimg_dir` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookdeets`
--

INSERT INTO `bookdeets` (`book_id`, `title`, `author`, `isbn`, `publisher`, `description`, `publication_date`, `bookimg_dir`, `genre`) VALUES
(1, 'The Blue Umbrella', 'Ruskin Bond', '9788171673407', 'Rupa Publication', 'The Blue Umbrella is a 1980 Indian novel written by Ruskin Bond. It was adapted into 2005 Hindi film by the same name, directed by Vishal Bhardwaj', '1992-01-07', 'book1.jpg', 'fiction'),
(2, 'The Silent Patient', 'Raynor Winn; Alex Michaelides; Candice Carty-Williams', '125030170X', 'Penguin/Orion/Trapeze', 'The Silent Patient is a shocking psychological thriller of a womans act of violence against her husband—and of the therapist obsessed with uncovering her motive. Alicia Berensons life is seemingly perfect.', '2019-02-05', 'book2.jpg', 'thriller');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookdeets`
--
ALTER TABLE `bookdeets`
  ADD PRIMARY KEY (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookdeets`
--
ALTER TABLE `bookdeets`
  MODIFY `book_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
