-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Aug 2019 um 23:29
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
(28, 73, 10, '2019-08-05', 1);

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
  `zone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobileNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephoneNo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianRelation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardianContact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `contactdetails`
--

INSERT INTO `contactdetails` (`id`, `userId`, `municipality`, `wardNo`, `area`, `district`, `zone`, `mobileNo`, `telephoneNo`, `guardianName`, `guardianRelation`, `guardianContact`) VALUES
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
  `faculty` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `board` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `yearOfCompletion` int(11) NOT NULL,
  `percent` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `education`
--

INSERT INTO `education` (`id`, `userId`, `level`, `faculty`, `institution`, `board`, `yearOfCompletion`, `percent`) VALUES
(43, 68, '1', '', 'AMHSS', 'SLC', 2015, '91'),
(47, 73, '1', '', 'Annapurna', 'SLC', 2013, '3.4');

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
  `rollNo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `personaldata`
--

INSERT INTO `personaldata` (`id`, `userId`, `password`, `programId`, `yearOrSemester`, `sectionId`, `dobAd`, `gender`, `nationality`, `fatherName`, `rollNo`) VALUES
(29, 68, 'studentPass', '1', 2, 6, '2019-08-21', 1, 'Nepali', '', 1),
(33, 73, 'studentPass', '1', 2, 6, '2019-08-15', 1, 'Nepali', '', 2);

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
(36, 61, 4),
(39, 61, 8),
(40, 61, 6),
(41, 61, 9),
(45, 61, 5),
(46, 60, 10),
(47, 61, 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `programId` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sectionId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `yearOrSemester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `subjects`
--

INSERT INTO `subjects` (`id`, `programId`, `name`, `details`, `sectionId`, `yearOrSemester`) VALUES
(4, 1, 'Mathematics', 'Fundamentals of Mathematics', '6', 2),
(5, 1, 'Physics', 'Electronics', '9', 1),
(6, 1, 'Chemistry', 'Fundamentals of Chemistry', '6', 2),
(7, 1, 'Physics', 'Fundamentals of Physics', '6', 2),
(8, 1, 'Biology', 'Fundamentals of Biology', '6', 2),
(9, 1, 'English', 'Basic English', '6', 2),
(10, 1, 'Web Designing', 'Fundamental of Web-design for BCA.', '9', 1),
(11, 1, 'Science', 'Fundamental of Science', '5', 2);

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
  `passwordHash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `userlogin`
--

INSERT INTO `userlogin` (`id`, `username`, `fname`, `mname`, `lname`, `email`, `passwordHash`, `role`) VALUES
(60, 'admin', 'Pradip', NULL, 'Dhakal', 'dhpradeep25@gmail.com', '7488e331b8b64e5794da3fa4eb10ad5d', 1),
(61, 'teacher', 'Pradeep', 'Prasad', 'Poudel', 'teacher@teacher.com', '41c8949aa55b8cb5dbec662f34b62df3', 2),
(68, 'SarojTripathi1620190821', 'Saroj', '', 'Tripathi', 'saroj@eversoftgroup.com', '9743084ab5d4fd710558290e466fbe57', 3),
(73, 'ArjunSubedi1620190815', 'Arjun', '', 'Subedi', 'arjun@arjun.com', '9743084ab5d4fd710558290e466fbe57', 3);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT für Tabelle `contactdetails`
--
ALTER TABLE `contactdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT für Tabelle `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT für Tabelle `personaldata`
--
ALTER TABLE `personaldata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT für Tabelle `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `subjectassign`
--
ALTER TABLE `subjectassign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT für Tabelle `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'userID for others', AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
