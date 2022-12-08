-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2022 at 07:39 PM
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
(1174, 570, 'Zebra', 0),
(1175, 570, 'Lion', 1),
(1176, 570, 'Hyena', 0),
(1177, 570, 'Vulture', 0),
(1178, 571, 'hakuna,matata', 1);

-- --------------------------------------------------------

--
-- Table structure for table `choice`
--

CREATE TABLE `choice` (
  `ChoiceId` int(11) NOT NULL,
  `ResultId` int(11) NOT NULL,
  `ChoiceType` enum('Multiple Choice','Short Answer') NOT NULL,
  `QuestionText` text NOT NULL,
  `QuestionImage` text NOT NULL,
  `ChoiceText` text NOT NULL,
  `CorrectText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `choice`
--

INSERT INTO `choice` (`ChoiceId`, `ResultId`, `ChoiceType`, `QuestionText`, `QuestionImage`, `ChoiceText`, `CorrectText`) VALUES
(78, 70, 'Multiple Choice', 'dsadsaaa', '', 'dsadsa', 'Answer 1'),
(79, 71, 'Multiple Choice', 'TestTest', '637dae1caa57c.jpg', '', 'TestTestTest'),
(80, 71, 'Multiple Choice', 'TestTest', '637dae1cb0f54.png', '', 'TestTest'),
(81, 71, 'Multiple Choice', 'TestTest', '637dae1cb41cc.png', '', 'TestTestTestTest'),
(82, 72, 'Multiple Choice', 'TestTest', '637dae680d08a.jpg', '', 'TestTestTest'),
(83, 72, 'Multiple Choice', 'TestTest', '637dae6810447.png', '', 'TestTest'),
(84, 72, 'Multiple Choice', 'TestTest', '637dae6812cf0.png', '', 'TestTestTestTest'),
(85, 73, 'Multiple Choice', 'TestTest', '637dae8ed09c2.jpg', '', 'TestTestTest'),
(86, 73, 'Multiple Choice', 'TestTest', '637dae8ed3efa.png', '', 'TestTest'),
(87, 73, 'Multiple Choice', 'TestTest', '637dae8ed668f.png', '', 'TestTestTestTest'),
(88, 74, 'Multiple Choice', 'TestTest', '637daeb5929fd.jpg', 'TestTestTest', 'TestTestTest'),
(89, 74, 'Multiple Choice', 'TestTest', '637daeb6cc459.png', '', 'TestTest'),
(90, 74, 'Multiple Choice', 'TestTest', '637daeb79607e.png', '', 'TestTestTestTest'),
(91, 75, 'Short Answer', 'TestTestTest', '', 'Jam a man of fortune and j must seek its fortune', 'jam,a,man'),
(92, 76, 'Short Answer', 'TestTestTest', '', 'cunt', 'jam,a,man'),
(93, 77, 'Short Answer', 'TestTestTest', '', 'test', 'jam,a,man'),
(94, 78, 'Short Answer', 'TestTestTest', '', 'testicule', 'jam,a,man'),
(101, 83, 'Multiple Choice', 'TestTest', '637ff2de48687.jpg', 'TestTest', 'TestTestTest'),
(102, 83, 'Multiple Choice', 'TestTest', '637ff2de49b58.png', 'TestTest', 'TestTest'),
(103, 83, 'Multiple Choice', 'TestTest', '637ff2de4af9c.png', 'TestTest', 'TestTestTestTest'),
(104, 84, 'Multiple Choice', 'dsadsaaa', '', 'Answer 1', 'Answer 1'),
(105, 91, 'Multiple Choice', 'dsadasdasdsa', '6380346a633d1.png', '', 'sadsadas'),
(115, 99, 'Multiple Choice', 'Which animal is in the picture?', '6381048b25094.jpg', 'Lion', 'Lion'),
(116, 99, 'Short Answer', 'Which famous phrases is sung by this group in the Lion King movie?', '638104f37baee.jpg', 'hakuna matata', 'hakuna,matata'),
(118, 100, 'Multiple Choice', 'Which animal is in the picture?', '6381048b25094.jpg', 'Lion', 'Lion'),
(119, 100, 'Short Answer', 'Which famous phrases is sung by this group in the Lion King movie?', '638104f37baee.jpg', '', 'hakuna,matata'),
(120, 101, 'Multiple Choice', 'Which animal is in the picture?', '6381048b25094.jpg', 'Lion', 'Lion'),
(121, 101, 'Short Answer', 'Which famous phrases is sung by this group in the Lion King movie?', '638104f37baee.jpg', 'hakuna matata', 'hakuna,matata'),
(123, 102, 'Multiple Choice', 'Which animal is in the picture?', '6381048b25094.jpg', 'Lion', 'Zebra'),
(124, 102, 'Short Answer', 'Which famous phrases is sung by this group in the Lion King movie?', '638104f37baee.jpg', '', 'hakuna,matata'),
(125, 103, 'Multiple Choice', 'Which animal is in the picture?', '6381048b25094.jpg', 'Lion', 'Lion'),
(126, 103, 'Short Answer', 'Which famous phrases is sung by this group in the Lion King movie?', '638104f37baee.jpg', 'hakuna matata', 'hakuna,matata'),
(127, 104, 'Multiple Choice', 'Which animal is in the picture?', '6381048b25094.jpg', 'Lion', 'Lion'),
(128, 104, 'Short Answer', 'Which famous phrases is sung by this group in the Lion King movie?', '638104f37baee.jpg', 'hakuna matata\r\n', 'hakuna,matata');

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
(570, 273, 'Which animal is in the picture?', '6381048b25094.jpg', 'He is the king of the jungle...', 'Multiple Choice'),
(571, 273, 'Which famous phrases is sung by this group in the Lion King movie?', '638104f37baee.jpg', 'Be happy...', 'Short Answer');

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
  `QuizPrivacy` enum('0','1','2') NOT NULL,
  `QuizTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`QuizId`, `UserId`, `QuizName`, `QuizBanner`, `QuizDescription`, `QuizPrivacy`, `QuizTime`) VALUES
(273, 23, 'Animal Kingdom Quiz', '63817165c1e55.jpg', 'This is a quiz about the animal kingdom. Your knowledge about the animal kingdom will be put to the test!', '1', '00:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `ResultId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `QuizId` int(11) NOT NULL,
  `ResultName` varchar(128) NOT NULL,
  `ResultMode` enum('Practice','Exam') NOT NULL,
  `ResultImage` text NOT NULL,
  `CurrentQuestion` int(11) NOT NULL,
  `CompletedTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`ResultId`, `UserId`, `QuizId`, `ResultName`, `ResultMode`, `ResultImage`, `CurrentQuestion`, `CompletedTime`) VALUES
(99, 23, 0, 'Animal Kingdom Quiz', 'Practice', '6381048b2358a.jpg', 1, '2022-11-25 19:10:13'),
(100, 23, 0, 'Animal Kingdom Quiz', 'Exam', '6381048b2358a.jpg', 1, '2022-11-25 19:11:19'),
(101, 23, 0, 'Animal Kingdom Quiz', 'Practice', '6381048b2358a.jpg', 1, '2022-11-25 22:32:14'),
(102, 23, 0, 'Animal Kingdom Quiz', 'Practice', '6381048b2358a.jpg', 1, '2022-11-25 22:32:58'),
(103, 23, 0, 'Animal Kingdom Quiz', 'Practice', '63817165c1e55.jpg', 1, '2022-11-26 18:52:57'),
(104, 23, 0, 'Animal Kingdom Quiz', 'Practice', '63817165c1e55.jpg', 1, '2022-12-07 02:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserId` int(11) NOT NULL,
  `Username` varchar(48) NOT NULL,
  `PasswordHash` varchar(72) NOT NULL,
  `SecretKey` varchar(72) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `Username`, `PasswordHash`, `SecretKey`) VALUES
(23, 'plaincustody', '$2y$10$JQsBDxP5vrJRILp2tEmhbOJ4m.s2PHSQdTcohBEuwVdKfDtgAR8Ri', 'FHSJM5CDWFFH6JWS'),
(26, 'administrator', '$2y$10$5HAjvSCGwtywX.Yn3BInz.ppmIRuDAtoDeEhoRIaWZJHhSGmoDZ72', NULL),
(27, 'sample0', '$2y$10$oUWL5JW/1Om/RjXyI14v5eA47anLV2waevPNdflKGE07zZNz5/w3e', NULL),
(28, 'sample1', '$2y$10$tGGyH3uQEUoABdlih7Z2muOj0LdkW5JCDy1dgHV9waJh8l8m5v4AW', NULL),
(29, 'sample2', '$2y$10$Zez8fuPrevFkW9gsUHQNBuoW01aF2JnMMVpDJw7vJqE1A3jMRgVVC', NULL),
(30, 'whatface0', '$2y$10$mC4j7YxU5zDOz2xLJ6oiAumzrCJ0jDSYs9Hsj6D1xlneuW.PO00vK', NULL),
(31, 'yourmom', '$2y$10$Ks53tJDpBslWESsOfNYDhenNW/SaPKj.He1wEslufg2r.BVN89gji', NULL),
(32, 'sample4', '$2y$10$iuiAXIGSymQ6u4Mo8i5wlegls2GgIMduaGdiPMI1AzgjK3KM80QEK', NULL),
(33, 'sample5', '$2y$10$/vTrZMOBnd49HzOtIFNkCeFwD717tbHDq9UFNBfIwtfb1oh5IDi6a', NULL);

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
-- Indexes for table `choice`
--
ALTER TABLE `choice`
  ADD PRIMARY KEY (`ChoiceId`);

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
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`ResultId`),
  ADD KEY `RESULT_USERID_FK` (`UserId`);

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
  MODIFY `AnswerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1179;

--
-- AUTO_INCREMENT for table `choice`
--
ALTER TABLE `choice`
  MODIFY `ChoiceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=572;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QuizId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `ResultId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

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
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `QUESTION_QUIZID_FK` FOREIGN KEY (`QuizId`) REFERENCES `quiz` (`QuizId`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `QUIZ_USERID_FK` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`);

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `RESULT_USERID_FK` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
