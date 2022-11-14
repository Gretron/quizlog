-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2022 at 03:41 PM
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
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `AnswerId` int(11) NOT NULL,
  `QuestionId` int(11) NOT NULL,
  `AnswerText` text NOT NULL,
  `AnswerCorrect` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`AnswerId`, `QuestionId`, `AnswerText`, `AnswerCorrect`) VALUES
(34, 29, 'sadasd', 0),
(35, 29, 'sdadsad', 1),
(36, 29, 'asdasd', 0),
(42, 32, 'dada', 0),
(43, 32, 'adad', 1),
(44, 32, 'adad', 0),
(48, 34, 'sadsa', 1),
(49, 34, 'dsadas', 0),
(59, 38, 'nope', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `QuizId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`QuestionId`, `QuizId`, `QuestionText`, `QuestionImage`, `QuestionHint`, `QuestionType`) VALUES
(29, 40, 'sdadsa', 'Array', 'dsadsa', 'Multiple Choice'),
(32, 42, 'dada', 'Array', 'dadada', 'Multiple Choice'),
(34, 46, 'dsad', 'Array', 'sdadsa', 'Multiple Choice'),
(38, 49, 'Do you like my sword?', 'Array', 'My Iron Sword..?', 'Short Answer');

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
(40, 26, 'sdxsadsa', 'Array', 'dsadsa', 1, '00:00:00'),
(42, 26, 'adada', 'Array', 'dadad', 0, '13:13:00'),
(44, 26, 'dfsda', 'Array', 'sdadsa', 0, '00:00:00'),
(45, 26, 'sdad', 'Array', 'sdadsad', 0, '00:00:00'),
(46, 26, 'Borgir', 'Array', 'sdsad', 0, '00:00:00'),
(49, 23, 'Borgir', 'Array', 'sdsad', 0, '01:00:00');

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
(31, 'yourmom', '$2y$10$Ks53tJDpBslWESsOfNYDhenNW/SaPKj.He1wEslufg2r.BVN89gji', ''),
(32, 'sample4', '$2y$10$iuiAXIGSymQ6u4Mo8i5wlegls2GgIMduaGdiPMI1AzgjK3KM80QEK', ''),
(33, 'sample5', '$2y$10$/vTrZMOBnd49HzOtIFNkCeFwD717tbHDq9UFNBfIwtfb1oh5IDi6a', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`AnswerId`),
  ADD KEY `ANSWER_QUESTIONID_FK` (`QuestionId`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD KEY `BOOKMARK_QUIZ_FK` (`QuizId`),
  ADD KEY `BOOKMARK_USER_FK` (`UserId`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`QuestionId`),
  ADD KEY `QUESTION_QUIZID_FK` (`QuizId`);

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
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `AnswerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `ANSWER_QUESTIONID_FK` FOREIGN KEY (`QuestionId`) REFERENCES `question` (`QuestionId`);

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `BOOKMARK_QUIZ_FK` FOREIGN KEY (`QuizId`) REFERENCES `quiz` (`QuizId`),
  ADD CONSTRAINT `BOOKMARK_USER_FK` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `QUESTION_QUIZID_FK` FOREIGN KEY (`QuizId`) REFERENCES `quiz` (`QuizId`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `QUIZ_USERID_FK` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
