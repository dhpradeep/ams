-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Sep 2019 um 19:00
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ams`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `attendance`
--

INSERT INTO `attendance` (`id`, `userId`, `subjectId`, `date`, `status`) VALUES
(1, 68, 4, '2019-08-24', 1),
(4, 4, 4, '2019-08-24', 1),
(5, 5, 4, '2019-08-24', 1),
(7, 4, 6, '2019-08-22', 1),
(8, 68, 4, '2019-08-22', 0),
(10, 68, 4, '2019-08-15', 1),
(12, 68, 9, '2019-08-25', 1),
(14, 68, 8, '2019-08-25', 0),
(16, 68, 9, '2019-08-24', 1),
(18, 68, 6, '2019-08-24', 0),
(20, 68, 6, '2019-08-15', 1),
(22, 68, 8, '2019-08-15', 0),
(24, 68, 7, '2019-08-25', 1),
(25, 73, 7, '2019-08-25', 1),
(26, 73, 10, '2019-08-01', 1),
(27, 73, 10, '2019-08-02', 1),
(28, 73, 10, '2019-08-05', 1),
(29, 68, 10, '2019-09-07', 0),
(30, 73, 10, '2019-09-07', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contactdetails`
--

CREATE TABLE `contactdetails` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `municipality` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wardNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobileNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephoneNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianRelation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianContact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contactdetails`
--

INSERT INTO `contactdetails` (`id`, `userId`, `municipality`, `wardNo`, `area`, `district`, `province`, `mobileNo`, `telephoneNo`, `guardianName`, `guardianRelation`, `guardianContact`) VALUES
(25, 68, 'Lekhnath', '9', 'Mohoriya', 'Kaski', 'Gandaki', '7678', '', '', '', ''),
(29, 73, 'Pokhara', '9', 'Bagar', 'Kaski', 'Gandaki', '9888666553', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbolNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `institution` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `board` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `yearOfCompletion` int(11) NOT NULL,
  `percent` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `education`
--

INSERT INTO `education` (`id`, `userId`, `level`, `symbolNo`, `institution`, `board`, `yearOfCompletion`, `percent`) VALUES
(43, 68, '1', '22334', 'AMHSS', 'SLC', 2015, '91'),
(47, 73, '1', '66', 'Annapurna', 'SLC', 2013, '3.4');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `personaldata`
--

CREATE TABLE `personaldata` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `programId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `yearOrSemester` int(11) NOT NULL,
  `sectionId` int(11) NOT NULL,
  `dobAd` date NOT NULL,
  `gender` tinyint(11) NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Nepali',
  `fatherName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rollNo` bigint(20) NOT NULL,
  `status` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `personaldata`
--

INSERT INTO `personaldata` (`id`, `userId`, `password`, `programId`, `yearOrSemester`, `sectionId`, `dobAd`, `gender`, `nationality`, `fatherName`, `rollNo`, `status`) VALUES
(29, 68, 'studentPass', '1', 1, 9, '2019-08-21', 1, 'Nepali', '', 1, 'true'),
(33, 73, 'studentPass', '1', 1, 9, '2019-08-15', 1, 'Nepali', '', 2, 'true');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yearOrSemester` tinyint(1) NOT NULL,
  `noOfYearOrSemester` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `program`
--

INSERT INTO `program` (`id`, `name`, `details`, `yearOrSemester`, `noOfYearOrSemester`) VALUES
(1, 'Science', 'Science Stream', 0, 2),
(2, 'BCA', '', 1, 8),
(4, 'Management', '+2 Morning Section Management', 0, 2),
(6, 'Hotel Management', 'Hotel Management Bachelor Level', 1, 8);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `review` varchar(255) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `review`
--

INSERT INTO `review` (`id`, `teacherId`, `studentId`, `review`, `date`) VALUES
(4, 60, 68, 'He is the best. He has to improve himself. I havenot seen him since long time.', '2019-09-07');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `programId` int(11) NOT NULL,
  `yearOrSemester` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `section`
--

INSERT INTO `section` (`id`, `programId`, `yearOrSemester`, `name`, `details`) VALUES
(1, 1, 2, 'Section A', 'Hello Section'),
(2, 2, 5, 'Section C', ''),
(5, 1, 2, 'Section C', ''),
(6, 1, 2, 'Section B', 'Another one'),
(9, 1, 1, 'Section B', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjectassign`
--

CREATE TABLE `subjectassign` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `subjectId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `subjectassign`
--

INSERT INTO `subjectassign` (`id`, `userId`, `subjectId`) VALUES
(26, 60, 7),
(34, 60, 11),
(35, 61, 11),
(39, 61, 8),
(40, 61, 6),
(41, 61, 9),
(45, 61, 5),
(46, 60, 10),
(47, 61, 10),
(49, 61, 13),
(53, 61, 26),
(65, 61, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `programId` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sectionId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `yearOrSemester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `programId`, `name`, `details`, `sectionId`, `yearOrSemester`) VALUES
(4, 'MA-01', 1, 'Mathematics', 'Fundamentals of Mathematics', '6', 2),
(5, NULL, 1, 'Physics', 'Electronics', '9', 1),
(6, NULL, 1, 'Chemistry', 'Fundamentals of Chemistry', '6', 2),
(7, NULL, 1, 'Physics', 'Fundamentals of Physics', '6', 2),
(8, NULL, 1, 'Biology', 'Fundamentals of Biology', '6', 2),
(9, NULL, 1, 'English', 'Basic English', '6', 2),
(10, NULL, 1, 'Web Designing', 'Fundamental of Web-design for BCA.', '9', 1),
(11, NULL, 1, 'Science', 'Fundamental of Science', '5', 2),
(13, NULL, 2, 'dfasd', '', '2', 5),
(22, NULL, 1, 'cyxv', '', '9', 1),
(23, NULL, 1, 'cyxv', '', '9', 1),
(24, NULL, 1, 'cyxv', '', '9', 1),
(26, NULL, 1, 'Hello wWorld', '', '1', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userlogin`
--

CREATE TABLE `userlogin` (
  `id` int(11) NOT NULL COMMENT 'userID for others',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobileNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passwordHash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `userlogin`
--

INSERT INTO `userlogin` (`id`, `username`, `fname`, `mname`, `lname`, `email`, `mobileNo`, `passwordHash`, `role`) VALUES
(60, 'admin', 'Pradip', NULL, 'Dhakal', 'dhpradeep25@gmail.com', '', '7488e331b8b64e5794da3fa4eb10ad5d', 1),
(61, 'teacher', 'Pradeep', 'Prasad', 'Poudel', 'teacher@teacher.com', '', '8d788385431273d11e8b43bb78f3aa41', 2),
(68, 'SarojTripathi1920190821', 'Saroj', '', 'Tripathi', 'saroj@eversoftgroup.com', '', '9743084ab5d4fd710558290e466fbe57', 3),
(73, 'ArjunSubedi1920190815', 'Arjun', '', 'Subedi', 'arjun@arjun.com', '', '9743084ab5d4fd710558290e466fbe57', 3),
(74, 'saroj22322', 'Saroj', '', 'Tripathi', 'sar@dad.cc', '987665544', 'e10adc3949ba59abbe56e057f20f883e', 2);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `contactdetails`
--
ALTER TABLE `contactdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `personaldata`
--
ALTER TABLE `personaldata`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `subjectassign`
--
ALTER TABLE `subjectassign`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `contactdetails`
--
ALTER TABLE `contactdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT für Tabelle `personaldata`
--
ALTER TABLE `personaldata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT für Tabelle `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `subjectassign`
--
ALTER TABLE `subjectassign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT für Tabelle `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT für Tabelle `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'userID for others', AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
