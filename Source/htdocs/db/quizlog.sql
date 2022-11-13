-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2022 at 09:31 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizlog`
--

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `QuestionId` int(11) NOT NULL,
  `QuizId` int(11) NOT NULL,
  `QuestionText` text NOT NULL,
  `QuestionImage` text NOT NULL,
  `QuestionHint` text NOT NULL,
  `QuestionType` enum('Multiple Choice','Short Answer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `QuizId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `QuizName` varchar(128) NOT NULL,
  `QuizBanner` text NOT NULL,
  `QuizDescription` text NOT NULL,
  `QuizPrivacy` tinyint(1) NOT NULL,
  `QuizTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`QuizId`, `UserId`, `QuizName`, `QuizBanner`, `QuizDescription`, `QuizPrivacy`, `QuizTime`) VALUES
(1, 26, 'sss', 'Array', 'ss', 0, '00:00:00'),
(2, 26, 'sss', 'Array', 'ss', 0, '00:00:00'),
(3, 26, 'sss', 'Array', 'ss', 0, '00:00:00'),
(4, 26, 'sss', 'Array', 'ss', 0, '00:00:00'),
(5, 26, 'sss', 'Array', 'ss', 0, '00:00:00'),
(6, 31, 'ssss', 'Array', 'aaa', 0, '00:00:00'),
(7, 31, 'ssss', 'Array', 'aaa', 0, '00:00:00'),
(8, 31, 'aaa', 'Array', 'aaa', 0, '00:00:00'),
(9, 31, 'aaa', 'Array', 'aaa', 0, '00:00:00'),
(10, 31, 'aaa', 'Array', 'aaa', 0, '00:00:00'),
(11, 31, 'aaa', 'Array', 'aaa', 0, '00:00:00'),
(12, 31, 'aaa', 'Array', 'aaa', 0, '00:00:00'),
(13, 31, 'aaa', 'Array', 'aaa', 0, '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserId` int(11) NOT NULL,
  `Username` varchar(48) NOT NULL,
  `PasswordHash` varchar(72) NOT NULL,
  `Bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `Username`, `PasswordHash`, `Bio`) VALUES
(23, 'plaincustody', '$2y$10$JQsBDxP5vrJRILp2tEmhbOJ4m.s2PHSQdTcohBEuwVdKfDtgAR8Ri', ''),
(26, 'administrator', '$2y$10$5HAjvSCGwtywX.Yn3BInz.ppmIRuDAtoDeEhoRIaWZJHhSGmoDZ72', ''),
(27, 'sample0', '$2y$10$oUWL5JW/1Om/RjXyI14v5eA47anLV2waevPNdflKGE07zZNz5/w3e', ''),
(28, 'sample1', '$2y$10$tGGyH3uQEUoABdlih7Z2muOj0LdkW5JCDy1dgHV9waJh8l8m5v4AW', ''),
(29, 'sample2', '$2y$10$Zez8fuPrevFkW9gsUHQNBuoW01aF2JnMMVpDJw7vJqE1A3jMRgVVC', ''),
(30, 'whatface0', '$2y$10$mC4j7YxU5zDOz2xLJ6oiAumzrCJ0jDSYs9Hsj6D1xlneuW.PO00vK', ''),
(31, 'yourmom', '$2y$10$Ks53tJDpBslWESsOfNYDhenNW/SaPKj.He1wEslufg2r.BVN89gji', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionId`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`QuizId`),
  ADD KEY `QUIZ_USERID_FK` (`UserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `QUIZ_USERID_FK` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
