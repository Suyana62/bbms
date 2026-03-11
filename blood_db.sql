-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 11:13 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `email` text DEFAULT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `email`, `password`) VALUES
(4, 'kriti@gmail.com', '$2y$10$OGduiTEAUmby9RJi9XwTrutVh3kmgqGPQnze9.XYx3dlFi4tQQs6i'),
(5, 'suyana@gmail.com', '$2y$10$9ukxgpPXzFPsxhXKZSTJoufJWGMQ8J6/ycsBOkVAvblfmApRRW7d2');

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `bloodID` int(11) NOT NULL,
  `bloodType` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`bloodID`, `bloodType`) VALUES
(1, 'O+'),
(2, 'O-'),
(3, 'A+'),
(4, 'A-'),
(5, 'B-'),
(6, 'B+'),
(7, 'AB+'),
(8, 'AB-');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `donorID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `reqID` int(11) NOT NULL,
  `isDonated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`donorID`, `userID`, `reqID`, `isDonated`) VALUES
(24, 34, 36, 0);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `reqID` int(11) NOT NULL,
  `bloodID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `reqDate` date DEFAULT NULL,
  `ml` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`reqID`, `bloodID`, `userID`, `reqDate`, `ml`) VALUES
(36, 1, 37, '2026-03-18', '33'),
(37, 1, 35, '2026-03-27', '77');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `FullName` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` text NOT NULL,
  `bloodID` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('requester','donor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `FullName`, `email`, `password`, `bloodID`, `phone`, `role`) VALUES
(29, 'sahara kandel', 'abc@gmail.com', '$2y$10$mhI5SbRzKI5JnGuy/AG1Ue3yub1it3Xh7pnyl5q.AX2Wafo47Yw8K', NULL, '9800000001', 'requester'),
(32, 'sara sharma', 'sara@gmail.com', '$2y$10$cvjtqqkAaCiiONLUn/B6tO/vZzxD0mpwYw9sZ9ZbW8FLJNADDI//W', NULL, '9865162913', 'requester'),
(33, 'ruru', 'ruru@gmail.com', '$2y$10$JO3O9BtC9plypv636c7ebObHthoxmepoDXsjhspzXam90eFPAchHO', NULL, '9809876543', 'requester'),
(34, 'ronila dhital', 'ronila@gmail.com', '$2y$10$rNU8RUa3w4taVejJEitDDOw5srS70R432ksTU7WAyBcygWTVDBcwS', NULL, '9876543434', 'requester'),
(35, 'suyana kandel', 'suyana@gmail.com', '$2y$10$MKuvy3hez62ppoa9i0nb3.f/wxBL7I/uNN0f1OOYEZJOHhKWn9sPy', NULL, '9744258695', 'requester'),
(36, 'maya sapkota', 'maya@gmail.com', '$2y$10$Ln2YDrumzdIUagLq.jk5Ce2JcAQLCuNepxAeCar683xbtq9ZwRd9.', NULL, '9876543212', 'donor'),
(37, 'kriti gurung', 'kriti@gmail.com', '$2y$10$eYzq7Y101W/WIw4yvKnnlOh62vx3MGD1XNmEwddTW7QtrJBJ.AFn6', NULL, '9898987755', 'donor'),
(38, 'sita', 'sita@gmail.com', '$2y$10$BQhtgsxUSXz7bLtrzJd2vOaNXjiWDZPn3M3NmADm5jhtQX1.9TQq6', NULL, '9878765434', 'donor'),
(40, 'Subin kANDEL', 'subinkandel@gmail.com', '$2y$10$YuddM3MrqPg44VIadB9IjujAEpaFvunmbAemtVH2c.zVZ7ADK/wnO', 1, '9865162911', 'requester'),
(42, 'kldfkjf df', 'sudipkandel@gmail.com', '$2y$10$o74iG537JphGc2AJYHpmke.uI3pcm5MvMB9JRKyFW29AX/bk0nt3i', 7, '9865163333', 'requester');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `blood`
--
ALTER TABLE `blood`
  ADD PRIMARY KEY (`bloodID`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`donorID`),
  ADD KEY `fk_userID_donors` (`userID`),
  ADD KEY `fk_req` (`reqID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`reqID`),
  ADD KEY `fk_bloodID_req` (`bloodID`),
  ADD KEY `fk_userID_req` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `fk_bloodID` (`bloodID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blood`
--
ALTER TABLE `blood`
  MODIFY `bloodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `reqID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donors`
--
ALTER TABLE `donors`
  ADD CONSTRAINT `fk_req` FOREIGN KEY (`reqID`) REFERENCES `request` (`reqID`),
  ADD CONSTRAINT `fk_userID_donors` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `fk_bloodID_req` FOREIGN KEY (`bloodID`) REFERENCES `blood` (`bloodID`),
  ADD CONSTRAINT `fk_userID_req` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_bloodID` FOREIGN KEY (`bloodID`) REFERENCES `blood` (`bloodID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
