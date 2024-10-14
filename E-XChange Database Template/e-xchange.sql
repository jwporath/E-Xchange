-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 12:14 AM
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
-- Database: `e-xchange`
--

-- --------------------------------------------------------

--
-- Table structure for table `equivalence`
--

CREATE TABLE `equivalence` (
  `EquivalenceID` int(11) NOT NULL,
  `Post1ID` int(11) NOT NULL,
  `Post2ID` int(11) NOT NULL,
  `Equivalence` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partnerships`
--

CREATE TABLE `partnerships` (
  `PartnershipID` int(11) NOT NULL,
  `User1ID` int(11) NOT NULL,
  `User2ID` int(11) NOT NULL,
  `Confirmed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ItemName` varchar(64) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Value` int(11) NOT NULL,
  `DesiredItem` varchar(64) NOT NULL,
  `DesiredQuantity` int(11) NOT NULL,
  `PartnershipID` int(11) DEFAULT NULL,
  `HasMatch` tinyint(1) NOT NULL,
  `PartnerIsRecipient` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `TransactionID` int(11) NOT NULL,
  `HashKey` varchar(64) NOT NULL,
  `LeadingHalf` varchar(32) NOT NULL,
  `TrailingHalf` varchar(32) NOT NULL,
  `Status` int(11) NOT NULL,
  `EquivalenceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(64) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `AddressLine1` varchar(64) NOT NULL,
  `AddressLine2` varchar(64) DEFAULT NULL,
  `City` varchar(64) NOT NULL,
  `State` varchar(64) NOT NULL,
  `Zipcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equivalence`
--
ALTER TABLE `equivalence`
  ADD PRIMARY KEY (`EquivalenceID`),
  ADD KEY `FK_Post1ID` (`Post1ID`),
  ADD KEY `FK_Post2ID` (`Post2ID`);

--
-- Indexes for table `partnerships`
--
ALTER TABLE `partnerships`
  ADD PRIMARY KEY (`PartnershipID`),
  ADD KEY `FK_User1ID` (`User1ID`),
  ADD KEY `FK_User2ID` (`User2ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `FK_PartnershipID` (`PartnershipID`),
  ADD KEY `FK_UserID` (`UserID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD UNIQUE KEY `UN_LeadingHalf` (`LeadingHalf`),
  ADD UNIQUE KEY `UN_TrailingHalf` (`TrailingHalf`),
  ADD UNIQUE KEY `UN_HashKey` (`HashKey`),
  ADD KEY `FK_EquivalenceID` (`EquivalenceID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UN_Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equivalence`
--
ALTER TABLE `equivalence`
  MODIFY `EquivalenceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partnerships`
--
ALTER TABLE `partnerships`
  MODIFY `PartnershipID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equivalence`
--
ALTER TABLE `equivalence`
  ADD CONSTRAINT `FK_Post1ID` FOREIGN KEY (`Post1ID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Post2ID` FOREIGN KEY (`Post2ID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `partnerships`
--
ALTER TABLE `partnerships`
  ADD CONSTRAINT `FK_User1ID` FOREIGN KEY (`User1ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_User2ID` FOREIGN KEY (`User2ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `FK_EquivalenceID` FOREIGN KEY (`EquivalenceID`) REFERENCES `equivalence` (`EquivalenceID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
