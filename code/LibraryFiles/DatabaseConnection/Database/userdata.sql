-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2022 at 07:29 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user`
--

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `class_code` varchar(20) NOT NULL,
  `classroom_name` text NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `semester` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `course_credit` double NOT NULL,
  `attendance` double NOT NULL,
  `late_attendance_percentage` double DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`class_code`, `classroom_name`, `course_code`, `semester`, `active`, `course_credit`, `attendance`, `late_attendance_percentage`) VALUES
('egOysQ8rug', 'Linear Algebra', 'CSE 4341', 3, 1, 3, 10, 7),
('L9tgpnpT3o', 'Data Structures', 'CSE 4303', 3, 1, 3, 10, 7);

-- --------------------------------------------------------

--
-- Table structure for table `classroom_creator`
--

CREATE TABLE `classroom_creator` (
  `email` varchar(200) NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classroom_creator`
--

INSERT INTO `classroom_creator` (`email`, `class_code`, `creation_date`) VALUES
('36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 'egOysQ8rug', '2022-12-30 05:47:15'),
('36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 'L9tgpnpT3o', '2022-12-30 05:46:51');

-- --------------------------------------------------------

--
-- Table structure for table `classroom_frequency`
--

CREATE TABLE `classroom_frequency` (
  `class_code` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `frequency` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classroom_frequency`
--

INSERT INTO `classroom_frequency` (`class_code`, `email`, `frequency`) VALUES
('egOysQ8rug', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 58),
('egOysQ8rug', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 20),
('L9tgpnpT3o', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 30),
('L9tgpnpT3o', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 11);

-- --------------------------------------------------------

--
-- Table structure for table `classroom_session`
--

CREATE TABLE `classroom_session` (
  `class_code` varchar(20) NOT NULL,
  `session` varchar(10) NOT NULL,
  `event_id` varchar(50) NOT NULL,
  `deadline` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classroom_session`
--

INSERT INTO `classroom_session` (`class_code`, `session`, `event_id`, `deadline`) VALUES
('egOysQ8rug', 'cHn58XDXpQ', 'PtjDBdNe5c', '2022-12-30 11:43:00'),
('L9tgpnpT3o', 'juqgNePNvs', 'WsZaE1PaCq', '2022-12-30 11:38:00'),
('egOysQ8rug', 'kGoG4J5kRr', 'RKumPXchUk', '2022-12-30 12:20:00'),
('egOysQ8rug', 'plJHRE0ZNx', 'Vzevp5eQ91', '2022-12-30 11:00:00'),
('egOysQ8rug', 'q47SZBJiaX', 'aFdSTAUR82', '2022-12-30 12:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` varchar(50) NOT NULL,
  `comment_message` text NOT NULL,
  `comment_datetime` datetime NOT NULL,
  `email` varchar(200) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_message`, `comment_datetime`, `email`, `active`) VALUES
('ab6hi8vdeFQA7IzfcTSsk30RckgQQkvU1VlohyzG60FTUcI4Bk', 'commm', '2022-12-30 12:06:37', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 0),
('knb04ngP7X1HQ3OwlUkX7v9uAgBleT5WRnek81ncdGde497EOj', 'comm', '2022-12-30 11:36:12', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 0),
('WntvCxHSrZkb7kCftIiExogV4GhBV163t786WZ70gvquqBtqc1', 'comm', '2022-12-30 11:57:29', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment_post`
--

CREATE TABLE `comment_post` (
  `comment_id` varchar(50) NOT NULL,
  `post_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_post`
--

INSERT INTO `comment_post` (`comment_id`, `post_id`) VALUES
('ab6hi8vdeFQA7IzfcTSsk30RckgQQkvU1VlohyzG60FTUcI4Bk', 'F2vl0bVunMXpqKX2cwz8XeeJ1W5i98Sb8RvjuNW0YsHzPRLtSn'),
('WntvCxHSrZkb7kCftIiExogV4GhBV163t786WZ70gvquqBtqc1', 'FtBJ5D35V4GeiW00tDqYUtP49xwvFpbhBEJZniQwSOQBs1Lg7B'),
('knb04ngP7X1HQ3OwlUkX7v9uAgBleT5WRnek81ncdGde497EOj', 'Yqa85f5R10uzUICMtg6eFrfoc6TmgNF2KwgrtCChLEPRwjxx1i');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` varchar(50) NOT NULL,
  `event_start_datetime` datetime NOT NULL,
  `event_end_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_start_datetime`, `event_end_datetime`) VALUES
('aFdSTAUR82', '2022-12-30 12:00:00', '2022-12-30 13:01:00'),
('BLfxKaSwA9', '2022-12-30 10:49:39', '2023-01-02 10:49:00'),
('C8JhXPpDIQ', '2022-12-30 12:07:42', '2022-12-31 12:07:00'),
('elQmN9Yb4A', '2022-12-30 11:01:48', '2023-01-03 11:01:00'),
('fMgFa7lNjg', '2022-12-30 11:08:20', '2023-01-06 11:08:00'),
('GHj99saXqG', '2022-12-30 11:08:03', '2023-01-05 11:07:00'),
('hh584cfcYD', '2022-12-30 10:50:56', '2023-01-04 10:50:00'),
('IS4n2GehEW', '2022-12-30 10:49:18', '2023-01-01 10:49:00'),
('nVI9rZkB3Y', '2022-12-30 10:50:07', '2023-01-03 10:49:00'),
('PtjDBdNe5c', '2022-12-30 11:38:00', '2022-12-30 14:37:00'),
('RBqvXjK45S', '2022-12-30 11:01:26', '2023-01-02 11:00:00'),
('RKumPXchUk', '2022-12-30 12:09:00', '2022-12-30 13:08:00'),
('Rn5EcK0JES', '2022-12-30 10:51:22', '2023-01-05 10:51:00'),
('sRHcX0cpSH', '2022-12-30 11:00:46', '2023-01-01 11:00:00'),
('Vzevp5eQ91', '2022-12-30 10:53:00', '2022-12-30 12:51:00'),
('WC74a4XE39', '2022-12-30 10:48:59', '2022-12-31 10:48:00'),
('WsZaE1PaCq', '2022-12-30 11:04:00', '2022-12-30 13:03:00'),
('wWjsk0EUqx', '2022-12-30 11:00:25', '2022-12-31 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` varchar(50) NOT NULL,
  `filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `filename`) VALUES
('bNgcTR6Qa0vrfAlThLq5L8S5LIHxStfn44ACgp0SVx8g4wpIQr', '99 bottles of oop.pdf'),
('C3eJAf0frWIOGGCBmBlpi0PO1TansYsIg4bKhhSeimR73kv40y', '99 bottles of oop.pdf'),
('D0RsdbDwmQR3Np46iHj8DOmfXwveoSavN9B2fs3RvKuBuYu0cY', '99 bottles of oop.pdf'),
('d4vNkAk66jXI4R57jkLgWYy1eXxDHPqvpmoQXOKK9PxozutgAP', '99 bottles of oop.pdf'),
('Dm4hDOsTZRVGF7JSw5sKJbaH745AC7g2G54bKjEhczEpgGMj9n', '99 bottles of oop.pdf'),
('F6oKK0HX6AOPU4ek6Cx12RILKWFtcS0mT7UaqjUFRqXhLu5KlW', '99 bottles of oop.pdf'),
('gb1wZM1tN6izxJJJgpQ5LYXEwYAn58nhY80sTOjNdckv0fKhhq', 'Gantt-project-planner1 (1).pdf'),
('Gnb3tPuPw6TTZAZJwJQT3CsGvuXLjIKUfIBfLyDeZQSdA0nYO6', '99 bottles of oop.pdf'),
('haTWncmY854f4LV1BHLZQtCuxbL1cYU8WVgLiM9rKpvGUVQkLi', '99 bottles of oop.pdf'),
('HMLzUb1XrUpHXou41l92TyS7WxNFXlD3u2q04cjz0ACTlhhz9b', '99 bottles of oop.pdf'),
('hYWibf3h6gWlWd59R9R5uNyKvpNTeNIyXptmP6iq04OqyTT5IK', '99 bottles of oop.pdf'),
('jdtbhJlwmUqzN0dYZazGXf9XjH7eiZyzidRYuxCGH68lIMVfp7', '99 bottles of oop.pdf'),
('k73JA6F3YQs7leo49J3Xv6PDzeYno62diftrtTAJaGCxTrJeDs', '99 bottles of oop.pdf'),
('KNinDAM7yNXaYn5kyHWyr16ko0A3YGixEnGvph9eLfNjkSlBSD', '99 bottles of oop.pdf'),
('KtmeA5rnLbX0R1rK6TCGMFrslJY1jDUq4qWyxQzgzKvVpp83WX', '99 bottles of oop.pdf'),
('lgkdOwyXXeuZ70b2qzf0WPVUcuIuqEJcg6WaL4oaYKldY9TzTR', '99 bottles of oop.pdf'),
('LH6hsv38SokgdHz14uVWs5DyU5HfaG0z4rVgJ02U1eWCY1BWh1', '99 bottles of oop.pdf'),
('MpjfqBTMYp5lExEZMIEm9ns0oObm5isNSDHYWMZbV9cqN4EsHR', '99 bottles of oop.pdf'),
('NFoFzlNI2kl9JGGM8BxwKke5oElNBHqy0lj2Hyf1FB2hNhJLZD', '99 bottles of oop.pdf'),
('NxBAjgxfiMl6pWtDdKpWQCqHp9sOwGdPQdWOsImZaRA8SZKnHI', '99 bottles of oop.pdf'),
('NZ4YURM46Z4cyXxklGOXHqqiJ37gHmtsARq8LO56wOCIh12gWP', '99 bottles of oop.pdf'),
('NZ7dq3kUKbFAf9BMZlkTGsT2j6NzOYd0TREEkru3VbFFqDbreq', '99 bottles of oop.pdf'),
('ofMrCcHK5XOi9kf1Df0hGDXR2cOrXSnrdQ6equ4pa429xdUQ94', '99 bottles of oop.pdf'),
('PlHOPeZbuksOzqerEWdYlBKObiQ7pSQorsHh1BJ4os4VcQ6Qix', '99 bottles of oop.pdf'),
('PXsN83ree54saN4OG2glChyjAq0Scb0Hlmy09VATPdk9RxtKKB', '99 bottles of oop.pdf'),
('ROcXixw9tHYDRDjf7qRZJA9RtOh2FWsdyLpAJRAa0o4uNL3RiY', '99 bottles of oop.pdf'),
('SBsJqxvKIaZ3mfgDW2X1SJDDVbs4BXnafUdm8yzti2hPJEohEP', '99 bottles of oop.pdf'),
('shBPFKki14Kmj1moshmQIa5eW8j7013qqlrdbQ7I3v57Vph37N', '99 bottles of oop.pdf'),
('SLd2Z9FJbOrdZRIybnF0BLAxWUz514kooDwR0LOdwGDunVXqMZ', '99 bottles of oop.pdf'),
('tSl3Szpg8gm0AzAyvK94TQoFlvp1hWswvWLehjtcUazPGxtsKT', '99 bottles of oop.pdf'),
('uH5iyYbdrJkTAwtf1SvEDgFrU7gytK44XGBJrGMglHKSSol7ns', '99 bottles of oop.pdf'),
('uKryiHu1e3ShwsAM5Iacn9aoM3MOmeM0CPV0j8PIde1tRyUFE2', '99 bottles of oop.pdf'),
('V1MU8EKl1HLm7KhN11WGBY2PyzFlRuflJvBjLRCsYFYU5ncYVL', '99 bottles of oop.pdf'),
('v2d537gDxml5W8oBq7vMWSsnEVTtuUqo6CRYAYJWwveYXqEIXG', '99 bottles of oop.pdf'),
('vpRxh9UZ659bWxwStSaxfgC9eImBlT68Iyg8b5lkxWIkUGMsJi', '99 bottles of oop.pdf'),
('wePJgclnLIYrLnk9ZPHb5JY0I2XKU4gre8abJq3NDFCvFFMBCS', '99 bottles of oop.pdf'),
('xeRPbYhacHPve1kcNLSNGvxYUtKgOJePsSeCDzS2mZC8WtlzUP', '99 bottles of oop.pdf'),
('XstzKEUdYGXK5gyx1bEKOpA0ehgKNewwcL0JY5ugzigBVOH1xS', 'Gantt-project-planner1 (1).pdf'),
('yxN62gCnb0ptFMsVD4dGw3MPEStTRtT5a6Uuu4oBZoxk5hU3ZF', '99 bottles of oop.pdf'),
('Z0olrSxlI38ZD0YS4gGgSgp0RkI20JcyAN28dnDYQ02fpFabeQ', '99 bottles of oop.pdf'),
('zF3dBckwheJrgfMoXyvKAjwSsfoj2asmy6I84mgDn7UF4aZiuX', '99 bottles of oop.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `message` text NOT NULL,
  `notification_id` varchar(50) NOT NULL,
  `notification_datetime` datetime NOT NULL,
  `notification_type` text NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`message`, `notification_id`, `notification_datetime`, `notification_type`, `class_code`) VALUES
('A task has been posted: FinalExam in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'aPyEkifGulcPMc37IsTIHngAy29zwdxNbdcleucigSebsJujhZ', '2022-12-30 10:51:22', 'task', 'egOysQ8rug'),
('A session has been created in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'au5OcFnTz97kveiuk14QxQCuegkkaldG1ZFeykQtHC0N6FmoTb', '2022-12-30 11:37:11', 'session', 'egOysQ8rug'),
('A resource has been uploaded:  in the classroom CSE 4341: Linear Algebra by Zaara Zabeen ', 'bn7cV91JhqTDyGgPXf2MmwBX3g6xdxfCeQZ5aaG2VOu8XQUZrD', '2022-12-30 11:45:28', 'resource', 'egOysQ8rug'),
('A task has been posted: Quiz4 in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'btV6lgwy0CVWlsVjYWCKUc23t06ncEs0tL2vq3BAi8u5eIuEZJ', '2022-12-30 11:01:48', 'task', 'L9tgpnpT3o'),
('A resource has been uploaded:  in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'bZVTrmnIJ7gR64VhqFQ0AQ6DTaXTKH5mdPXoSUoaeF6c8E7fhp', '2022-12-30 11:03:58', 'resource', 'L9tgpnpT3o'),
('A task has been submitted: Quiz4 in the classroom CSE 4303: Data Structures by Zaara Zabeen   on time', 'CD1eYoyhvVg8RZvfGOBJffRYaTTEOniHiPjwWiUvZtnVh52h5Q', '2022-12-30 11:05:57', 'submit', 'L9tgpnpT3o'),
('A resource has been uploaded:  in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'cRncMzPCdeIOxcsOFDHa1LrRJVvo0cdvQbCryRtFv1Oz3UWL9E', '2022-12-30 10:52:30', 'resource', 'egOysQ8rug'),
('A session has been created in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'cVyHg7ukWmUv1E1E7SYSLnKx2Bd9uCDPgB66VrInNeIS02f4HE', '2022-12-30 10:51:57', 'session', 'egOysQ8rug'),
('A task has been submitted: Quiz3 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   on time', 'd34wDRAemrAZcc8gDTFNemms0D9AkcUivKfaWgsK5x1JpPDTk2', '2022-12-30 10:54:07', 'submit', 'egOysQ8rug'),
('A resource has been uploaded:  in the classroom CSE 4341: Linear Algebra by Zaara Zabeen ', 'gN31u3mY7E60Z5KGQmlGKl7vA3pUu5RFpisYhCM8gxZgX35Sqh', '2022-12-30 12:10:58', 'resource', 'egOysQ8rug'),
('A task has been posted: title in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'h8JzT5My9AX62bkmIWWSBjQ37dcrBHk60d98RkkC5GQ4bmTuDu', '2022-12-30 12:07:42', 'task', 'egOysQ8rug'),
('A task has been submitted: Quiz4 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   on time', 'h8M7ndS87yRyTivTuIfWRAk2a84B4WLAux6lpymXPP7cCwiMQa', '2022-12-30 10:54:14', 'submit', 'egOysQ8rug'),
('A task has been posted: ttile in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'Ha0BFta5VIRyiOxKi97PCTDj5C8B0cU8bgZhOSAgMyDtroK7st', '2022-12-30 11:57:47', 'task', 'egOysQ8rug'),
('A task has been submitted: Quiz2 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   on time', 'HaItvEjUKERMD5HQZWbxmxuZuD3wEVQ4YmpgyLUGR1JXyymFhh', '2022-12-30 10:54:01', 'submit', 'egOysQ8rug'),
('A task has been submitted: MidExam in the classroom CSE 4303: Data Structures by Zaara Zabeen   on time', 'hI6X1taDS5B2b4OC99hKhTE05Q9Xc14mdYmktmhOp3U4ZE23G6', '2022-12-30 11:06:04', 'submit', 'L9tgpnpT3o'),
('A task has been posted: Quiz2 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'i5s6kGrEOkyHfDRVEkSQAjpb6ntq5TKvmXLR8DJ48RB1RmrsBJ', '2022-12-30 10:49:18', 'task', 'egOysQ8rug'),
('A task has been submitted: title in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   on time', 'I9wV4ePQi58Qf3M24a7UCXv2VOzrRsI81ckBfomzK56OxbNXCi', '2022-12-30 12:08:55', 'submission', 'egOysQ8rug'),
('A session has been created in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'IpFGKkvPmMf9o8KsFBPejvWz8YbJ3q3e7DwyyIQdvtopt7ddA2', '2022-12-30 11:59:47', 'session', 'egOysQ8rug'),
('A task has been posted: Quiz3 in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'j0Fg3B6y9KJv3ZRGrIkY2x2qwbgQzF5u5KPvC8aPPAwJ1imp8p', '2022-12-30 11:01:26', 'task', 'L9tgpnpT3o'),
('A task has been posted: FinalExam in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'KAEpgTuhnJEAdpZ9cw4TO3graMT7kOwSHHm51J5cuiVfKNYdQX', '2022-12-30 11:08:20', 'task', 'L9tgpnpT3o'),
('A task has been posted: Quiz1 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'Kog4gYHVRdO1BJhLfSuDbOfVGcZ0JJYgoquZ0GR8B88UI3sSSu', '2022-12-30 10:48:59', 'task', 'egOysQ8rug'),
('A task has been submitted: Quiz2 in the classroom CSE 4303: Data Structures by Zaara Zabeen   on time', 'kQIdpgQKBgHCinDcasmlJ5QebeteUAQG4LNl5VQ9DvIBPb1JjV', '2022-12-30 11:05:42', 'submit', 'L9tgpnpT3o'),
('A task has been submitted: MidExam in the classroom CSE 4303: Data Structures by Zaara Zabeen   on time', 'kYXGZxKLze4df5w3m0et71Ce2uR2cHkMr4OMJ8p9CNRfl91MBD', '2022-12-30 11:23:20', 'submission', 'L9tgpnpT3o'),
('A resource has been uploaded:  in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'kZZyq8Fc1H3lsBhVLexp92g89i0tCdCbRJSfBjcWly5g97UtGR', '2022-12-30 12:01:45', 'resource', 'egOysQ8rug'),
('Attendance given by Zaara Zabeen  in the classroom CSE 4341: Linear Algebra', 'LZVd0FJ15dgHviLgg3P2fAbKPTWGFU0VaK9In5eq2j9LV3JaL0', '2022-12-30 10:53:41', 'attendance', 'egOysQ8rug'),
('A task has been posted: MidExam in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'Mi8rRfJ7tIhKp8YnpqyvAyTcVDvU8EqljUBRcjlAQ8y5UXx147', '2022-12-30 10:50:56', 'task', 'egOysQ8rug'),
('Zaara Zabeen Arpa posted in CSE 4341: Linear Algebra', 'msQRtXrSlSfhN6efcTonVGriM0itTIhiNsPMHE71U32ubycjaM', '2022-12-30 11:57:26', 'post', 'egOysQ8rug'),
('Attendance given by Zaara Zabeen  in the classroom CSE 4341: Linear Algebra', 'NpilWZIPLtkJvaPBk9wUVRr78WB5cUMeaAoR1zJksVHelfwUUN', '2022-12-30 11:38:05', 'attendance', 'egOysQ8rug'),
('A session has been created in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'nSYY0OIQ7CmKHQjEfgUQt43UxzT0sIjkgwLVCDZNOzX3549pVH', '2022-12-30 11:03:24', 'session', 'L9tgpnpT3o'),
('A task has been posted: Quiz4 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'o10VHNzBhxHnsyUjgiBMLo3S0I2vMTWUncaKNgxRa8C9JltpGM', '2022-12-30 10:50:07', 'task', 'egOysQ8rug'),
('A task has been posted: MidExam in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'OL3IuzK8DOiyiSRWHhSqFM0cnHxts5KAJkZQkUUBp2AwlVZMAD', '2022-12-30 11:08:03', 'task', 'L9tgpnpT3o'),
('A task has been posted: MidExam in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'OSrZcgyIY2iAKKRnYzCtNWtgNj4kJiKM1EuqyWWPU5UfCU0T1p', '2022-12-30 11:02:14', 'task', 'L9tgpnpT3o'),
('Zaara Zabeen Arpa posted in CSE 4341: Linear Algebra', 'p5C73F8eGGa5Gf5RxkyUSUrlC8iG8vqsBhhvVilyWg2Mn9X2zD', '2022-12-30 11:36:08', 'post', 'egOysQ8rug'),
('A task has been submitted: FinalExam in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   on time', 'PechZt3sVPCtyW6fHNOjHMiDcF23qgdvTEBIcfZlmP8F2TWUFE', '2022-12-30 10:54:30', 'submit', 'egOysQ8rug'),
('A task has been posted: aaaaa in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'pvochUhSmvCvcVDJjdpJZVNZcqC471KTJYe3cN7Ox7xHAtR0cL', '2022-12-30 11:36:43', 'task', 'egOysQ8rug'),
('Zaara Zabeen Arpa commented in CSE 4341: Linear Algebra', 'q3Ln7kmjoZXlClPPEvgGUq6rpzg5ar4DtV8ydZFHhtkJaAGG5B', '2022-12-30 12:06:37', 'comment', 'egOysQ8rug'),
('A task has been submitted: Quiz1 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   on time', 'RTl1D9kS3gRAtAe7Ff17dGJXD9nicruBqaKeO1KanBKHbQzaWI', '2022-12-30 10:53:54', 'submit', 'egOysQ8rug'),
('A task has been posted: Quiz2 in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'scg1fA4zMFaHxf98U56IPUNn0APEmu4C4HSsAghnemBbf6ymvf', '2022-12-30 11:00:46', 'task', 'L9tgpnpT3o'),
('A task has been posted: FinalExam in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'tTVq5TggwFtdVhVS4LFDjsPXzIpSSFBANtEF1RzgC2pUa052fU', '2022-12-30 11:02:32', 'task', 'L9tgpnpT3o'),
('A session has been created in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'TUi5hUAtbjRkRwbZcjuh0Q75O55XRBTxGiOZ6c183Z9UHvjMLN', '2022-12-30 12:08:31', 'session', 'egOysQ8rug'),
('Zaara Zabeen Arpa commented in CSE 4341: Linear Algebra', 'UIBVohS4CMJUzmQ0YpHzbESaCMlz39AnncXAP3wUlVHm6izp5o', '2022-12-30 11:57:29', 'comment', 'egOysQ8rug'),
('A task has been submitted: MidExam in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   on time', 'vbzhgAJOqNKWvTtNTnmMaKaSkyTsSrHSwdozmO4DoqJBBcftTE', '2022-12-30 10:54:23', 'submit', 'egOysQ8rug'),
('A task has been posted: quiz1 in the classroom CSE 4303: Data Structures by Zaara Zabeen Arpa', 'VMZNUyHjxdyNeqD9LYGWisprlJYbgeYIyzv07bIbDL2DoRIurT', '2022-12-30 11:00:25', 'task', 'L9tgpnpT3o'),
('A task has been submitted: quiz1 in the classroom CSE 4303: Data Structures by Zaara Zabeen   on time', 'w5mfQFPyGlqjtdJ7vZ5DlTMu4bzQZhC9f4GHlkoJNVRhndNLA0', '2022-12-30 11:05:35', 'submit', 'L9tgpnpT3o'),
('Zaara Zabeen Arpa posted in CSE 4341: Linear Algebra', 'WbLVt10MHJXWlB6nSpOn2v2Q5MJKVdbPeB3IJQPVacKKQhL23i', '2022-12-30 12:06:33', 'post', 'egOysQ8rug'),
('A task has been submitted: Quiz3 in the classroom CSE 4303: Data Structures by Zaara Zabeen   on time', 'WoDuie1XwJmFVvKCgmycsgr1GJUnlInaRexycAQFQrNyrzMYhA', '2022-12-30 11:05:50', 'submit', 'L9tgpnpT3o'),
('A task has been posted: Quiz3 in the classroom CSE 4341: Linear Algebra by Zaara Zabeen Arpa', 'xjN85SK116gvPppWhn6v61FigndO3vtl0rrc5iZqyNStkRuLMK', '2022-12-30 10:49:40', 'task', 'egOysQ8rug'),
('A resource has been uploaded:  in the classroom CSE 4341: Linear Algebra by Zaara Zabeen ', 'XPrk4BZxuKQZwZ92SMVeUQRzhkzb1Qj5FObQOWFpR1qjDBnyCp', '2022-12-30 11:39:52', 'resource', 'egOysQ8rug'),
('A task has been submitted: aaaaa in the classroom CSE 4341: Linear Algebra by Zaara Zabeen   late', 'xRjCceYujmSQELAI893sruLxMvWFz5ngra4trlFcMV7Hsl7Qiu', '2022-12-30 11:37:52', 'submission', 'egOysQ8rug'),
('Attendance given by Zaara Zabeen  in the classroom CSE 4341: Linear Algebra', 'xtkH5LPsXcQZSNLyBFw7Uxkpm5W1vdN9SiZOoe46b9PIJRVQxz', '2022-12-30 12:09:02', 'attendance', 'egOysQ8rug'),
('Zaara Zabeen Arpa commented in CSE 4341: Linear Algebra', 'y123bk6AdhHDJAMy8X6sMhQKdISBd3KVMSXGOzVeAOh0YHyhau', '2022-12-30 11:36:12', 'comment', 'egOysQ8rug'),
('Zaara Zabeen Arpa posted in CSE 4341: Linear Algebra', 'ZwjdL3qJTLz3ahNwS4Fxn6NiLBTklt0mgyLaUXXUsjjqzgVVZ0', '2022-12-30 12:06:50', 'post', 'egOysQ8rug');

-- --------------------------------------------------------

--
-- Table structure for table `notification_user`
--

CREATE TABLE `notification_user` (
  `notification_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification_user`
--

INSERT INTO `notification_user` (`notification_id`, `email`) VALUES
('CD1eYoyhvVg8RZvfGOBJffRYaTTEOniHiPjwWiUvZtnVh52h5Q', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('d34wDRAemrAZcc8gDTFNemms0D9AkcUivKfaWgsK5x1JpPDTk2', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('gN31u3mY7E60Z5KGQmlGKl7vA3pUu5RFpisYhCM8gxZgX35Sqh', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('h8M7ndS87yRyTivTuIfWRAk2a84B4WLAux6lpymXPP7cCwiMQa', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('Ha0BFta5VIRyiOxKi97PCTDj5C8B0cU8bgZhOSAgMyDtroK7st', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('HaItvEjUKERMD5HQZWbxmxuZuD3wEVQ4YmpgyLUGR1JXyymFhh', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('hI6X1taDS5B2b4OC99hKhTE05Q9Xc14mdYmktmhOp3U4ZE23G6', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('I9wV4ePQi58Qf3M24a7UCXv2VOzrRsI81ckBfomzK56OxbNXCi', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('IpFGKkvPmMf9o8KsFBPejvWz8YbJ3q3e7DwyyIQdvtopt7ddA2', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('kQIdpgQKBgHCinDcasmlJ5QebeteUAQG4LNl5VQ9DvIBPb1JjV', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('kYXGZxKLze4df5w3m0et71Ce2uR2cHkMr4OMJ8p9CNRfl91MBD', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('kZZyq8Fc1H3lsBhVLexp92g89i0tCdCbRJSfBjcWly5g97UtGR', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('LZVd0FJ15dgHviLgg3P2fAbKPTWGFU0VaK9In5eq2j9LV3JaL0', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('msQRtXrSlSfhN6efcTonVGriM0itTIhiNsPMHE71U32ubycjaM', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('PechZt3sVPCtyW6fHNOjHMiDcF23qgdvTEBIcfZlmP8F2TWUFE', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('q3Ln7kmjoZXlClPPEvgGUq6rpzg5ar4DtV8ydZFHhtkJaAGG5B', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('RTl1D9kS3gRAtAe7Ff17dGJXD9nicruBqaKeO1KanBKHbQzaWI', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('UIBVohS4CMJUzmQ0YpHzbESaCMlz39AnncXAP3wUlVHm6izp5o', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('vbzhgAJOqNKWvTtNTnmMaKaSkyTsSrHSwdozmO4DoqJBBcftTE', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('w5mfQFPyGlqjtdJ7vZ5DlTMu4bzQZhC9f4GHlkoJNVRhndNLA0', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('WbLVt10MHJXWlB6nSpOn2v2Q5MJKVdbPeB3IJQPVacKKQhL23i', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('WoDuie1XwJmFVvKCgmycsgr1GJUnlInaRexycAQFQrNyrzMYhA', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('xRjCceYujmSQELAI893sruLxMvWFz5ngra4trlFcMV7Hsl7Qiu', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('xtkH5LPsXcQZSNLyBFw7Uxkpm5W1vdN9SiZOoe46b9PIJRVQxz', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('ZwjdL3qJTLz3ahNwS4Fxn6NiLBTklt0mgyLaUXXUsjjqzgVVZ0', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `post_datetime` datetime DEFAULT NULL,
  `post_message` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `email`, `post_datetime`, `post_message`, `active`) VALUES
('BeQNhDnYTx2WflXo3XkMCOK0gfj1j25j1Okd12BWhovTK6y90T', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:08:03', 'A Task has been assigned: <br> Title: MidExam <br>  Deadline: 05/01/2023 11:07:00 am <br> Marks: 75 <br> Question Link: <a href=\"http://localhost/Files/wePJgclnLIYrLnk9ZPHb5JY0I2XKU4gre8abJq3NDFCvFFMBCS/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('CS7lkDC3CliegqvbKumTtFRyI4VbLEi3whZvgI0ARY6qQ6OCyl', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:00:25', 'A Task has been assigned: <br> Title: quiz1 <br>  Deadline: 31/12/2022 11:00:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/v2d537gDxml5W8oBq7vMWSsnEVTtuUqo6CRYAYJWwveYXqEIXG/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('CstXlg2H6XW47cx8jMLJV67lqXxskIBod42WfMIAHO2Em2wXiV', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 12:07:42', 'A Task has been assigned: <br> Title: title <br>  Deadline: 31/12/2022 12:07:00 pm <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/hYWibf3h6gWlWd59R9R5uNyKvpNTeNIyXptmP6iq04OqyTT5IK/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('E2aqvymNcja30pZ0AiSll5iFK23lxxJJNJWd6R7xOyxZ50ycaF', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', '2022-12-30 12:10:58', 'A Resource has been posted: <br> Title: title <br>  Posted at:2022-12-30 12:10:57 <br> Brief Description: des <br> Resource Link: <a href=\"http://localhost/Files/F6oKK0HX6AOPU4ek6Cx12RILKWFtcS0mT7UaqjUFRqXhLu5KlW/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('exfRxrI6YeUrJSDyvaxchXUPGZ20OS14oCryiDcpHVxfZFIckN', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:37:11', 'A Classroom Session Has Been Posted Session is an offline session. <br> Start Date and Time: 2022-12-30 11:38 <br> End Date and Time: 2022-12-30 14:37 <br>', 1),
('F2vl0bVunMXpqKX2cwz8XeeJ1W5i98Sb8RvjuNW0YsHzPRLtSn', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 12:06:33', 'post', 0),
('Fst7aCbg4B5Axn8RdNecUBgTqN7RXIm00hAaW6tzO8DFl3eRQ5', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', '2022-12-30 11:45:28', 'A Resource has been posted: <br> Title: title <br>  Posted at:2022-12-30 11:45:28 <br> Brief Description: description <br> Resource Link: <a href=\"http://localhost/Files/NxBAjgxfiMl6pWtDdKpWQCqHp9sOwGdPQdWOsImZaRA8SZKnHI/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('FtBJ5D35V4GeiW00tDqYUtP49xwvFpbhBEJZniQwSOQBs1Lg7B', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:57:26', 'post\r\n', 0),
('hthRfnK4EZ3TrAJQDbaMSJ7qjf6cfBugsqL1UZkp3D7UTrl34s', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:52:30', 'A Resource has been posted: <br> Title: Resource1 <br>  Posted at:2022-12-30 10:52:30 <br> Brief Description: description <br> Resource Link: <a href=\"http://localhost/Files/jdtbhJlwmUqzN0dYZazGXf9XjH7eiZyzidRYuxCGH68lIMVfp7/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('IayeDIQRUUSADCEBFbtXDCZ9qxwoXfFRhERfkbGg6o8vzftm1f', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:02:14', 'A Task has been assigned: <br> Title: MidExam <br>  Deadline: 04/01/2023 11:02:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/HMLzUb1XrUpHXou41l92TyS7WxNFXlD3u2q04cjz0ACTlhhz9b/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 0),
('iCJGkXhCSIhEyYLDX1w9AwKJmUL3tHd1ECh61eJM7cZCG80DBt', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:51:22', 'A Task has been assigned: <br> Title: FinalExam <br>  Deadline: 05/01/2023 10:51:00 am <br> Marks: 150 <br> Question Link: <a href=\"http://localhost/Files/xeRPbYhacHPve1kcNLSNGvxYUtKgOJePsSeCDzS2mZC8WtlzUP/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('KJNdTYddVJEpQ3ZzfCbyKlLPB2bChDoT1Z08g4ZEpMHe1NULFu', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:01:48', 'A Task has been assigned: <br> Title: Quiz4 <br>  Deadline: 03/01/2023 11:01:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/SBsJqxvKIaZ3mfgDW2X1SJDDVbs4BXnafUdm8yzti2hPJEohEP/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('LnTODgDrfANFDAwYphVkN1M8vgxoewFCXxA7Z8IfVU95eO6aU9', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:49:40', 'A Task has been assigned: <br> Title: Quiz3 <br>  Deadline: 02/01/2023 10:49:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/d4vNkAk66jXI4R57jkLgWYy1eXxDHPqvpmoQXOKK9PxozutgAP/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('NlurfKmrAxY8qEGGU5wiobiComaeEJ93qfsMUvtB5D8H7yulM6', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:01:26', 'A Task has been assigned: <br> Title: Quiz3 <br>  Deadline: 02/01/2023 11:00:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/C3eJAf0frWIOGGCBmBlpi0PO1TansYsIg4bKhhSeimR73kv40y/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('PlcYIzX4w5qCRRVtOUbBgqa1iR5eisnIo7kbKYR92zboSO4IqM', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:48:59', 'A Task has been assigned: <br> Title: Quiz1 <br>  Deadline: 31/12/2022 10:48:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/gb1wZM1tN6izxJJJgpQ5LYXEwYAn58nhY80sTOjNdckv0fKhhq/Gantt-project-planner1 (1).pdf\" target=\"__blank\">Link</a>', 1),
('PlHOet7LYwJmWV8qo2fHOh3FYsC4SfedZdXzsldO8M3nrMqciO', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 12:08:31', 'A Classroom Session Has Been Posted Session is an offline session. <br> Start Date and Time: 2022-12-30 12:09 <br> End Date and Time: 2022-12-30 13:08 <br>', 1),
('PLVr5e8DewdE5VS2KoEmuFIpv05zdAFOAHe2reMj2YJ9uBlBRd', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:00:46', 'A Task has been assigned: <br> Title: Quiz2 <br>  Deadline: 01/01/2023 11:00:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/KtmeA5rnLbX0R1rK6TCGMFrslJY1jDUq4qWyxQzgzKvVpp83WX/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('PxB1dOpSqPfPgyt0HldZo5qpAaUCHdNiRudmaG3G31SYOLFRpX', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 12:01:45', 'A Resource has been posted: <br> Title: titke <br>  Posted at:2022-12-30 12:01:45 <br> Brief Description: desc <br> Resource Link: <a href=\"http://localhost/Files/V1MU8EKl1HLm7KhN11WGBY2PyzFlRuflJvBjLRCsYFYU5ncYVL/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('q5tvBkOgRfjTceVy9x8NnrZo5xkcM4VMBwNYvjLu3hf2Ga3d9A', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:51:57', 'A Classroom Session Has Been Posted Session is an offline session. <br> Start Date and Time: 2022-12-30 10:53 <br> End Date and Time: 2022-12-30 12:51 <br>', 0),
('QjLG5fXJxH27Rje2p4SbHZ1sNvZznu60eKvVmwl7CFTeg2rQ7t', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:03:24', 'A Classroom Session Has Been Posted Session is an offline session. <br> Start Date and Time: 2022-12-30 11:04 <br> End Date and Time: 2022-12-30 13:03 <br>', 1),
('sfH1KnqzVAiDXYbuarSt4Ckt0R5VdsVGLBy7mBFHXdjfc85eEu', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:02:32', 'A Task has been assigned: <br> Title: FinalExam <br>  Deadline: 05/01/2023 11:02:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/bNgcTR6Qa0vrfAlThLq5L8S5LIHxStfn44ACgp0SVx8g4wpIQr/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 0),
('SX7VRrvOwhrHjqsO1a5Ye0e8IHq1ZWMbl7anT3bIRwaL199p92', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:49:18', 'A Task has been assigned: <br> Title: Quiz2 <br>  Deadline: 01/01/2023 10:49:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/XstzKEUdYGXK5gyx1bEKOpA0ehgKNewwcL0JY5ugzigBVOH1xS/Gantt-project-planner1 (1).pdf\" target=\"__blank\">Link</a>', 1),
('TgdvFn49TYCbYCRr7OawsjQN3lJlj0eKpKgYIJ9gO8YX9BFUkU', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:36:43', 'A Task has been assigned: <br> Title: aaaaa <br>  Deadline: 30/12/2022 11:37:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/MpjfqBTMYp5lExEZMIEm9ns0oObm5isNSDHYWMZbV9cqN4EsHR/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('tPXoBNOilRUtlIc7CM16Vx6Klp66wZbSeBeSEtUUysyJflrMuz', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:57:47', 'A Task has been assigned: <br> Title: ttile <br>  Deadline: 30/12/2022 11:58:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/lgkdOwyXXeuZ70b2qzf0WPVUcuIuqEJcg6WaL4oaYKldY9TzTR/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('ucEaKGbGAIYQrrjdPHB6bDgabzAaAEZS3QnqXYrE1K8x3jX1WO', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:59:47', 'A Classroom Session Has Been Posted Session is an offline session. <br> Start Date and Time: 2022-12-30 12:00 <br> End Date and Time: 2022-12-30 13:01 <br>', 1),
('WJvPCjmeEzrx379x0wJGIKysh6yhJekyvIxBUP8ibneikBbj3Z', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:50:56', 'A Task has been assigned: <br> Title: MidExam <br>  Deadline: 04/01/2023 10:50:00 am <br> Marks: 75 <br> Question Link: <a href=\"http://localhost/Files/ofMrCcHK5XOi9kf1Df0hGDXR2cOrXSnrdQ6equ4pa429xdUQ94/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('xq9ULVGTnoOlT7PhSoXYVJhiTs1E0fuNC8EsIuaXmfuuvB4gmU', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 10:50:07', 'A Task has been assigned: <br> Title: Quiz4 <br>  Deadline: 03/01/2023 10:49:00 am <br> Marks: 15 <br> Question Link: <a href=\"http://localhost/Files/haTWncmY854f4LV1BHLZQtCuxbL1cYU8WVgLiM9rKpvGUVQkLi/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('ynZMf3rjN1jiQ6yHW80bVtMzCkrWIIEFsbbvnAdkNRPtJsLP95', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:03:58', 'A Resource has been posted: <br> Title: title1 <br>  Posted at:2022-12-30 11:03:58 <br> Brief Description: description <br> Resource Link: <a href=\"http://localhost/Files/vpRxh9UZ659bWxwStSaxfgC9eImBlT68Iyg8b5lkxWIkUGMsJi/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('Yqa85f5R10uzUICMtg6eFrfoc6TmgNF2KwgrtCChLEPRwjxx1i', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:36:08', 'P_ost', 1),
('yXSX0GnBVqvr6DVqCgO8SfQwzoMWCI978xcb8JPmGiLXa1nurA', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 12:06:50', 'post', 1),
('Zco6s78qm0q37RJpd5roTKIC4ZnJpd2tAoORAA2Q1q81cWup85', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '2022-12-30 11:08:20', 'A Task has been assigned: <br> Title: FinalExam <br>  Deadline: 06/01/2023 11:08:00 am <br> Marks: 150 <br> Question Link: <a href=\"http://localhost/Files/zF3dBckwheJrgfMoXyvKAjwSsfoj2asmy6I84mgDn7UF4aZiuX/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1),
('zpCzTIpFI6vyBQhnlD3J3OAdci4IPrevr1VnCBzctdt04wiSXo', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', '2022-12-30 11:39:52', 'A Resource has been posted: <br> Title: title <br>  Posted at:2022-12-30 11:39:52 <br> Brief Description: description <br> Resource Link: <a href=\"http://localhost/Files/shBPFKki14Kmj1moshmQIa5eW8j7013qqlrdbQ7I3v57Vph37N/99 bottles of oop.pdf\" target=\"__blank\">Link</a>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_classroom`
--

CREATE TABLE `post_classroom` (
  `post_id` varchar(50) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_classroom`
--

INSERT INTO `post_classroom` (`post_id`, `class_code`) VALUES
('BeQNhDnYTx2WflXo3XkMCOK0gfj1j25j1Okd12BWhovTK6y90T', 'L9tgpnpT3o'),
('CS7lkDC3CliegqvbKumTtFRyI4VbLEi3whZvgI0ARY6qQ6OCyl', 'L9tgpnpT3o'),
('CstXlg2H6XW47cx8jMLJV67lqXxskIBod42WfMIAHO2Em2wXiV', 'egOysQ8rug'),
('E2aqvymNcja30pZ0AiSll5iFK23lxxJJNJWd6R7xOyxZ50ycaF', 'egOysQ8rug'),
('exfRxrI6YeUrJSDyvaxchXUPGZ20OS14oCryiDcpHVxfZFIckN', 'egOysQ8rug'),
('F2vl0bVunMXpqKX2cwz8XeeJ1W5i98Sb8RvjuNW0YsHzPRLtSn', 'egOysQ8rug'),
('Fst7aCbg4B5Axn8RdNecUBgTqN7RXIm00hAaW6tzO8DFl3eRQ5', 'egOysQ8rug'),
('FtBJ5D35V4GeiW00tDqYUtP49xwvFpbhBEJZniQwSOQBs1Lg7B', 'egOysQ8rug'),
('hthRfnK4EZ3TrAJQDbaMSJ7qjf6cfBugsqL1UZkp3D7UTrl34s', 'egOysQ8rug'),
('IayeDIQRUUSADCEBFbtXDCZ9qxwoXfFRhERfkbGg6o8vzftm1f', 'L9tgpnpT3o'),
('iCJGkXhCSIhEyYLDX1w9AwKJmUL3tHd1ECh61eJM7cZCG80DBt', 'egOysQ8rug'),
('KJNdTYddVJEpQ3ZzfCbyKlLPB2bChDoT1Z08g4ZEpMHe1NULFu', 'L9tgpnpT3o'),
('LnTODgDrfANFDAwYphVkN1M8vgxoewFCXxA7Z8IfVU95eO6aU9', 'egOysQ8rug'),
('NlurfKmrAxY8qEGGU5wiobiComaeEJ93qfsMUvtB5D8H7yulM6', 'L9tgpnpT3o'),
('PlcYIzX4w5qCRRVtOUbBgqa1iR5eisnIo7kbKYR92zboSO4IqM', 'egOysQ8rug'),
('PlHOet7LYwJmWV8qo2fHOh3FYsC4SfedZdXzsldO8M3nrMqciO', 'egOysQ8rug'),
('PLVr5e8DewdE5VS2KoEmuFIpv05zdAFOAHe2reMj2YJ9uBlBRd', 'L9tgpnpT3o'),
('PxB1dOpSqPfPgyt0HldZo5qpAaUCHdNiRudmaG3G31SYOLFRpX', 'egOysQ8rug'),
('q5tvBkOgRfjTceVy9x8NnrZo5xkcM4VMBwNYvjLu3hf2Ga3d9A', 'egOysQ8rug'),
('QjLG5fXJxH27Rje2p4SbHZ1sNvZznu60eKvVmwl7CFTeg2rQ7t', 'L9tgpnpT3o'),
('sfH1KnqzVAiDXYbuarSt4Ckt0R5VdsVGLBy7mBFHXdjfc85eEu', 'L9tgpnpT3o'),
('SX7VRrvOwhrHjqsO1a5Ye0e8IHq1ZWMbl7anT3bIRwaL199p92', 'egOysQ8rug'),
('TgdvFn49TYCbYCRr7OawsjQN3lJlj0eKpKgYIJ9gO8YX9BFUkU', 'egOysQ8rug'),
('tPXoBNOilRUtlIc7CM16Vx6Klp66wZbSeBeSEtUUysyJflrMuz', 'egOysQ8rug'),
('ucEaKGbGAIYQrrjdPHB6bDgabzAaAEZS3QnqXYrE1K8x3jX1WO', 'egOysQ8rug'),
('WJvPCjmeEzrx379x0wJGIKysh6yhJekyvIxBUP8ibneikBbj3Z', 'egOysQ8rug'),
('xq9ULVGTnoOlT7PhSoXYVJhiTs1E0fuNC8EsIuaXmfuuvB4gmU', 'egOysQ8rug'),
('ynZMf3rjN1jiQ6yHW80bVtMzCkrWIIEFsbbvnAdkNRPtJsLP95', 'L9tgpnpT3o'),
('Yqa85f5R10uzUICMtg6eFrfoc6TmgNF2KwgrtCChLEPRwjxx1i', 'egOysQ8rug'),
('yXSX0GnBVqvr6DVqCgO8SfQwzoMWCI978xcb8JPmGiLXa1nurA', 'egOysQ8rug'),
('Zco6s78qm0q37RJpd5roTKIC4ZnJpd2tAoORAA2Q1q81cWup85', 'L9tgpnpT3o'),
('zpCzTIpFI6vyBQhnlD3J3OAdci4IPrevr1VnCBzctdt04wiSXo', 'egOysQ8rug');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resource_id` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `resource_tag` text NOT NULL,
  `post_date_time` datetime NOT NULL,
  `file_id` text NOT NULL,
  `resource_visibility` set('private','public') NOT NULL,
  `resource_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`resource_id`, `title`, `resource_tag`, `post_date_time`, `file_id`, `resource_visibility`, `resource_description`) VALUES
('AdWK53v2ZXLggfDvRVJWas9AvRW6kIiYNJkl4AhjxJZ3xJMyZ4', 'titke', 'rtag3', '2022-12-30 12:01:45', 'V1MU8EKl1HLm7KhN11WGBY2PyzFlRuflJvBjLRCsYFYU5ncYVL', 'private', 'desc'),
('ATXgF3LZlk8AFAsYL9k5ZCDhhdpiSBEXRl2blpgEW3GI1oNg8X', 'Resource1', 'tag1', '2022-12-30 10:52:30', 'jdtbhJlwmUqzN0dYZazGXf9XjH7eiZyzidRYuxCGH68lIMVfp7', 'private', 'description'),
('BKQTmuw01CZi23MRisMNOT1qlX7xYkdr0yURKnBqLOLpWWFm8y', 'titile', 'tag11', '2022-12-30 12:01:27', 'NZ4YURM46Z4cyXxklGOXHqqiJ37gHmtsARq8LO56wOCIh12gWP', 'public', 'des'),
('IwCIxB5ywWiyV9qwdjM13C7ufzvEHNHfDHqNuE77Lp2lf7cFQ1', 'title1', 'tag2', '2022-12-30 11:40:05', 'KNinDAM7yNXaYn5kyHWyr16ko0A3YGixEnGvph9eLfNjkSlBSD', 'public', 'description'),
('nYT79BQMB9TKGfr0PnwMZGJMTby10Zwz8s8S6ZfWYBSik3nh24', 'title', 'tag2', '2022-12-30 11:45:28', 'NxBAjgxfiMl6pWtDdKpWQCqHp9sOwGdPQdWOsImZaRA8SZKnHI', 'private', 'description'),
('sczgWT8qUNZJm5kcbt662quFAUlDoSABS8hU9H9PzRrEkq1i4s', 'title', 'tag1', '2022-12-30 12:10:45', 'NZ7dq3kUKbFAf9BMZlkTGsT2j6NzOYd0TREEkru3VbFFqDbreq', 'public', 'desx'),
('XgzJO97WZQxCAYKp2qBwPncNbLgBan1w6WY7TOLH4S6fQKnCZC', 'title1', 'tag1', '2022-12-30 11:03:58', 'vpRxh9UZ659bWxwStSaxfgC9eImBlT68Iyg8b5lkxWIkUGMsJi', 'private', 'description'),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', 'title', 'tag2', '2022-12-30 12:10:57', 'F6oKK0HX6AOPU4ek6Cx12RILKWFtcS0mT7UaqjUFRqXhLu5KlW', 'private', 'des'),
('Z0N5cbrHbrcWnbYSz2f9Z4HZzrMlA1UgxX3C172qASByAmHQfB', 'Title', 'tag2', '2022-12-30 10:52:52', 'uH5iyYbdrJkTAwtf1SvEDgFrU7gytK44XGBJrGMglHKSSol7ns', 'public', 'description');

-- --------------------------------------------------------

--
-- Table structure for table `resources_classroom`
--

CREATE TABLE `resources_classroom` (
  `resource_id` varchar(50) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resources_classroom`
--

INSERT INTO `resources_classroom` (`resource_id`, `class_code`) VALUES
('AdWK53v2ZXLggfDvRVJWas9AvRW6kIiYNJkl4AhjxJZ3xJMyZ4', 'egOysQ8rug'),
('ATXgF3LZlk8AFAsYL9k5ZCDhhdpiSBEXRl2blpgEW3GI1oNg8X', 'egOysQ8rug'),
('nYT79BQMB9TKGfr0PnwMZGJMTby10Zwz8s8S6ZfWYBSik3nh24', 'egOysQ8rug'),
('XgzJO97WZQxCAYKp2qBwPncNbLgBan1w6WY7TOLH4S6fQKnCZC', 'L9tgpnpT3o'),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', 'egOysQ8rug');

-- --------------------------------------------------------

--
-- Table structure for table `resource_downvote`
--

CREATE TABLE `resource_downvote` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resource_downvote`
--

INSERT INTO `resource_downvote` (`resource_id`, `email`) VALUES
('nYT79BQMB9TKGfr0PnwMZGJMTby10Zwz8s8S6ZfWYBSik3nh24', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb');

-- --------------------------------------------------------

--
-- Table structure for table `resource_frequency`
--

CREATE TABLE `resource_frequency` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `frequency` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resource_frequency`
--

INSERT INTO `resource_frequency` (`resource_id`, `email`, `frequency`) VALUES
('AdWK53v2ZXLggfDvRVJWas9AvRW6kIiYNJkl4AhjxJZ3xJMyZ4', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 2),
('ATXgF3LZlk8AFAsYL9k5ZCDhhdpiSBEXRl2blpgEW3GI1oNg8X', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 9),
('nYT79BQMB9TKGfr0PnwMZGJMTby10Zwz8s8S6ZfWYBSik3nh24', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 1),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 4),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 0);

-- --------------------------------------------------------

--
-- Table structure for table `resource_saved`
--

CREATE TABLE `resource_saved` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resource_saved`
--

INSERT INTO `resource_saved` (`resource_id`, `email`) VALUES
('AdWK53v2ZXLggfDvRVJWas9AvRW6kIiYNJkl4AhjxJZ3xJMyZ4', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('ATXgF3LZlk8AFAsYL9k5ZCDhhdpiSBEXRl2blpgEW3GI1oNg8X', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('nYT79BQMB9TKGfr0PnwMZGJMTby10Zwz8s8S6ZfWYBSik3nh24', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f');

-- --------------------------------------------------------

--
-- Table structure for table `resource_uploaded`
--

CREATE TABLE `resource_uploaded` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resource_uploaded`
--

INSERT INTO `resource_uploaded` (`resource_id`, `email`) VALUES
('AdWK53v2ZXLggfDvRVJWas9AvRW6kIiYNJkl4AhjxJZ3xJMyZ4', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('ATXgF3LZlk8AFAsYL9k5ZCDhhdpiSBEXRl2blpgEW3GI1oNg8X', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('BKQTmuw01CZi23MRisMNOT1qlX7xYkdr0yURKnBqLOLpWWFm8y', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('IwCIxB5ywWiyV9qwdjM13C7ufzvEHNHfDHqNuE77Lp2lf7cFQ1', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('nYT79BQMB9TKGfr0PnwMZGJMTby10Zwz8s8S6ZfWYBSik3nh24', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('sczgWT8qUNZJm5kcbt662quFAUlDoSABS8hU9H9PzRrEkq1i4s', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('XgzJO97WZQxCAYKp2qBwPncNbLgBan1w6WY7TOLH4S6fQKnCZC', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb'),
('XqpY7lZS4iVsFrpJRvInNOGuCyqzDrHqU13EgS2mzuryd0Q25K', 'fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f'),
('Z0N5cbrHbrcWnbYSz2f9Z4HZzrMlA1UgxX3C172qASByAmHQfB', '36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb');

-- --------------------------------------------------------

--
-- Table structure for table `resource_upvote`
--

CREATE TABLE `resource_upvote` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `email` varchar(200) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `studentID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`email`, `semester`, `studentID`) VALUES
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 3, '200042101');

-- --------------------------------------------------------

--
-- Table structure for table `student_classroom`
--

CREATE TABLE `student_classroom` (
  `email` varchar(200) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_classroom`
--

INSERT INTO `student_classroom` (`email`, `class_code`) VALUES
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'egOysQ8rug'),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'L9tgpnpT3o');

-- --------------------------------------------------------

--
-- Table structure for table `student_classroom_session`
--

CREATE TABLE `student_classroom_session` (
  `email` varchar(200) NOT NULL,
  `session` varchar(10) NOT NULL,
  `status` set('present','late') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_classroom_session`
--

INSERT INTO `student_classroom_session` (`email`, `session`, `status`) VALUES
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'cHn58XDXpQ', 'present'),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'kGoG4J5kRr', 'present'),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'plJHRE0ZNx', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `student_task_submission`
--

CREATE TABLE `student_task_submission` (
  `email` varchar(200) NOT NULL,
  `task_id` varchar(50) NOT NULL,
  `file_id` varchar(50) NOT NULL,
  `submission_status` tinyint(1) NOT NULL DEFAULT 0,
  `marks_obtained` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_task_submission`
--

INSERT INTO `student_task_submission` (`email`, `task_id`, `file_id`, `submission_status`, `marks_obtained`) VALUES
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'ACHnvvHrEJnIHSWGZJKB10EnolWkN1ZOv4nUQkUsmQY7uBdS5Z', 'D0RsdbDwmQR3Np46iHj8DOmfXwveoSavN9B2fs3RvKuBuYu0cY', 1, 11),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'cMVH0fXuQLNA1g9VVaZv2vJbma8yx7Hj2rbxNf0PVXv4D4glhF', 'k73JA6F3YQs7leo49J3Xv6PDzeYno62diftrtTAJaGCxTrJeDs', 1, 13),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'eh2lAgrKDIllaIJH8DsB1O72jdtmHmWXwunY41uomcyask8u1A', 'SLd2Z9FJbOrdZRIybnF0BLAxWUz514kooDwR0LOdwGDunVXqMZ', 1, 15),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'hHCESWqyx7Bk8RsBSdyGIjEvYG9h1sbM9Kz4D9w5u2AnZJTtr0', 'Dm4hDOsTZRVGF7JSw5sKJbaH745AC7g2G54bKjEhczEpgGMj9n', 1, 110),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'hKScD9Q6eGoklWZc0IYdPQKsw3fNcUchSu9OIR2JrNbbpuh3e4', 'ROcXixw9tHYDRDjf7qRZJA9RtOh2FWsdyLpAJRAa0o4uNL3RiY', 1, 10),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'ILZezO5WLGBtnuC4716OYgy676iXc8e2MaUcKonAxPjMypFNow', 'Gnb3tPuPw6TTZAZJwJQT3CsGvuXLjIKUfIBfLyDeZQSdA0nYO6', 1, 14),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'JCcZ8X30hztT9LhgLu3SrvOe4aCYxtMC0Pij0xghheGZK2HofV', 'yxN62gCnb0ptFMsVD4dGw3MPEStTRtT5a6Uuu4oBZoxk5hU3ZF', 1, 14),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'MGQXhA5ermixH6Fg1RSZubMx9oEGHfllzEpBiqFGGfZewzv4tq', 'Z0olrSxlI38ZD0YS4gGgSgp0RkI20JcyAN28dnDYQ02fpFabeQ', 1, 60),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'trgcc9rtIFD1MN0QIu9u06u0XQzwcbzbr6g21CgrogLzADbocJ', 'NFoFzlNI2kl9JGGM8BxwKke5oElNBHqy0lj2Hyf1FB2hNhJLZD', 1, 60),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'uwy48Chj2fPSBEB6l7YgeXEnVcz4SYPRbMQByoSZu3xt8z4dqY', 'tSl3Szpg8gm0AzAyvK94TQoFlvp1hWswvWLehjtcUazPGxtsKT', 1, 14),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'vhMuToyZAldThWHKedJv36izFPOLG91m6YXX3tEeP3AVOT5P4j', 'PlHOPeZbuksOzqerEWdYlBKObiQ7pSQorsHh1BJ4os4VcQ6Qix', 1, 14),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'Zpk97qeJwLihWOfQP4ulB54GvTHPjn3fGXfcVhyPxEED5aWkho', 'LH6hsv38SokgdHz14uVWs5DyU5HfaG0z4rVgJ02U1eWCY1BWh1', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` varchar(50) NOT NULL,
  `task_title` text NOT NULL,
  `event_id` varchar(50) NOT NULL,
  `institution` text NOT NULL,
  `semester` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `instructions` text DEFAULT NULL,
  `file_id` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_title`, `event_id`, `institution`, `semester`, `marks`, `instructions`, `file_id`, `active`) VALUES
('ACHnvvHrEJnIHSWGZJKB10EnolWkN1ZOv4nUQkUsmQY7uBdS5Z', 'Quiz4', 'elQmN9Yb4A', 'Islamic University of Technology', 3, 15, 'instr', 'SBsJqxvKIaZ3mfgDW2X1SJDDVbs4BXnafUdm8yzti2hPJEohEP', 1),
('cMVH0fXuQLNA1g9VVaZv2vJbma8yx7Hj2rbxNf0PVXv4D4glhF', 'Quiz2', 'IS4n2GehEW', 'Islamic University of Technology', 3, 15, 'inst', 'XstzKEUdYGXK5gyx1bEKOpA0ehgKNewwcL0JY5ugzigBVOH1xS', 1),
('eh2lAgrKDIllaIJH8DsB1O72jdtmHmWXwunY41uomcyask8u1A', 'title', 'C8JhXPpDIQ', 'Islamic University of Technology', 3, 15, 'ins', 'hYWibf3h6gWlWd59R9R5uNyKvpNTeNIyXptmP6iq04OqyTT5IK', 1),
('hHCESWqyx7Bk8RsBSdyGIjEvYG9h1sbM9Kz4D9w5u2AnZJTtr0', 'FinalExam', 'Rn5EcK0JES', 'Islamic University of Technology', 3, 150, 'instr', 'xeRPbYhacHPve1kcNLSNGvxYUtKgOJePsSeCDzS2mZC8WtlzUP', 1),
('hKScD9Q6eGoklWZc0IYdPQKsw3fNcUchSu9OIR2JrNbbpuh3e4', 'Quiz3', 'RBqvXjK45S', 'Islamic University of Technology', 3, 15, 'instr', 'C3eJAf0frWIOGGCBmBlpi0PO1TansYsIg4bKhhSeimR73kv40y', 1),
('ILZezO5WLGBtnuC4716OYgy676iXc8e2MaUcKonAxPjMypFNow', 'Quiz2', 'sRHcX0cpSH', 'Islamic University of Technology', 3, 15, 'instr', 'KtmeA5rnLbX0R1rK6TCGMFrslJY1jDUq4qWyxQzgzKvVpp83WX', 1),
('JCcZ8X30hztT9LhgLu3SrvOe4aCYxtMC0Pij0xghheGZK2HofV', 'Quiz1', 'WC74a4XE39', 'Islamic University of Technology', 3, 15, 'inst', 'gb1wZM1tN6izxJJJgpQ5LYXEwYAn58nhY80sTOjNdckv0fKhhq', 1),
('m5n7uCMjOskneazI37p3qzMgFAc2SrjytqsX1pjBda8CZRO2uc', 'FinalExam', 'fMgFa7lNjg', 'Islamic University of Technology', 3, 150, 'instr', 'zF3dBckwheJrgfMoXyvKAjwSsfoj2asmy6I84mgDn7UF4aZiuX', 1),
('MGQXhA5ermixH6Fg1RSZubMx9oEGHfllzEpBiqFGGfZewzv4tq', 'MidExam', 'GHj99saXqG', 'Islamic University of Technology', 3, 75, 'instr', 'wePJgclnLIYrLnk9ZPHb5JY0I2XKU4gre8abJq3NDFCvFFMBCS', 1),
('trgcc9rtIFD1MN0QIu9u06u0XQzwcbzbr6g21CgrogLzADbocJ', 'MidExam', 'hh584cfcYD', 'Islamic University of Technology', 3, 75, 'instr', 'ofMrCcHK5XOi9kf1Df0hGDXR2cOrXSnrdQ6equ4pa429xdUQ94', 1),
('uwy48Chj2fPSBEB6l7YgeXEnVcz4SYPRbMQByoSZu3xt8z4dqY', 'Quiz4', 'nVI9rZkB3Y', 'Islamic University of Technology', 3, 15, 'inst', 'haTWncmY854f4LV1BHLZQtCuxbL1cYU8WVgLiM9rKpvGUVQkLi', 1),
('vhMuToyZAldThWHKedJv36izFPOLG91m6YXX3tEeP3AVOT5P4j', 'quiz1', 'wWjsk0EUqx', 'Islamic University of Technology', 3, 15, 'instr', 'v2d537gDxml5W8oBq7vMWSsnEVTtuUqo6CRYAYJWwveYXqEIXG', 1),
('Zpk97qeJwLihWOfQP4ulB54GvTHPjn3fGXfcVhyPxEED5aWkho', 'Quiz3', 'BLfxKaSwA9', 'Islamic University of Technology', 3, 15, 'inst', 'd4vNkAk66jXI4R57jkLgWYy1eXxDHPqvpmoQXOKK9PxozutgAP', 1);

-- --------------------------------------------------------

--
-- Table structure for table `task_classroom`
--

CREATE TABLE `task_classroom` (
  `task_id` varchar(50) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_classroom`
--

INSERT INTO `task_classroom` (`task_id`, `class_code`) VALUES
('ACHnvvHrEJnIHSWGZJKB10EnolWkN1ZOv4nUQkUsmQY7uBdS5Z', 'L9tgpnpT3o'),
('cMVH0fXuQLNA1g9VVaZv2vJbma8yx7Hj2rbxNf0PVXv4D4glhF', 'egOysQ8rug'),
('eh2lAgrKDIllaIJH8DsB1O72jdtmHmWXwunY41uomcyask8u1A', 'egOysQ8rug'),
('hHCESWqyx7Bk8RsBSdyGIjEvYG9h1sbM9Kz4D9w5u2AnZJTtr0', 'egOysQ8rug'),
('hKScD9Q6eGoklWZc0IYdPQKsw3fNcUchSu9OIR2JrNbbpuh3e4', 'L9tgpnpT3o'),
('ILZezO5WLGBtnuC4716OYgy676iXc8e2MaUcKonAxPjMypFNow', 'L9tgpnpT3o'),
('JCcZ8X30hztT9LhgLu3SrvOe4aCYxtMC0Pij0xghheGZK2HofV', 'egOysQ8rug'),
('m5n7uCMjOskneazI37p3qzMgFAc2SrjytqsX1pjBda8CZRO2uc', 'L9tgpnpT3o'),
('MGQXhA5ermixH6Fg1RSZubMx9oEGHfllzEpBiqFGGfZewzv4tq', 'L9tgpnpT3o'),
('trgcc9rtIFD1MN0QIu9u06u0XQzwcbzbr6g21CgrogLzADbocJ', 'egOysQ8rug'),
('uwy48Chj2fPSBEB6l7YgeXEnVcz4SYPRbMQByoSZu3xt8z4dqY', 'egOysQ8rug'),
('vhMuToyZAldThWHKedJv36izFPOLG91m6YXX3tEeP3AVOT5P4j', 'L9tgpnpT3o'),
('Zpk97qeJwLihWOfQP4ulB54GvTHPjn3fGXfcVhyPxEED5aWkho', 'egOysQ8rug');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `email` varchar(200) NOT NULL,
  `designation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`email`, `designation`) VALUES
('36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classroom`
--

CREATE TABLE `teacher_classroom` (
  `email` varchar(200) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_classroom`
--

INSERT INTO `teacher_classroom` (`email`, `class_code`) VALUES
('36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 'egOysQ8rug'),
('36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 'L9tgpnpT3o');

-- --------------------------------------------------------

--
-- Table structure for table `token_table`
--

CREATE TABLE `token_table` (
  `email` varchar(200) NOT NULL,
  `code` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `institution` text NOT NULL,
  `dob` date NOT NULL,
  `mobileNumber` varchar(20) DEFAULT NULL,
  `department` text DEFAULT NULL,
  `country` text DEFAULT NULL,
  `profile_picture` longblob DEFAULT NULL,
  `Verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `name`, `password`, `institution`, `dob`, `mobileNumber`, `department`, `country`, `profile_picture`, `Verified`) VALUES
('36c2578be6811c65b12f1e63dac9ce0e06dbad669b1dbe22ccc6b8ace1e1c4fd533b4d1eec55bd5aa197363293e1ecef7d7729376952165bca674cae686541eb', 'Zaara Zabeen Arpa', '$2y$10$Z.skN0jipFpqqVoho3gzzumgNKEryHhlXsJhC3VyCn0W4twjH8892', 'Islamic University of Technology', '2022-12-23', '', 'CSE', 'Bangladesh', NULL, 1),
('fae06e91f6dbdca83c8a4de97756cfd9cfbd90b6a9f4412771f1ddf2bc9c2b559e75fcd4c7f51bde29fa264848ddc39c0d2d725d03dda948052966535254116f', 'Zaara Zabeen ', '$2y$10$LC5OE.n8C7L7dVBsHUznI.qNXgxQsmd2vm.vjKNIlKK8EqzDzuWLO', 'Islamic University of Technology', '2022-12-24', '', '', '', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`class_code`),
  ADD UNIQUE KEY `class_code_2` (`class_code`),
  ADD KEY `class_code` (`class_code`);

--
-- Indexes for table `classroom_creator`
--
ALTER TABLE `classroom_creator`
  ADD PRIMARY KEY (`email`,`class_code`),
  ADD KEY `fk_classroom_creator_classroom` (`class_code`);

--
-- Indexes for table `classroom_frequency`
--
ALTER TABLE `classroom_frequency`
  ADD PRIMARY KEY (`class_code`,`email`),
  ADD KEY `fk_classroom_frequency_user2` (`email`);

--
-- Indexes for table `classroom_session`
--
ALTER TABLE `classroom_session`
  ADD PRIMARY KEY (`session`),
  ADD KEY `class_code` (`class_code`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_comments_users` (`email`);

--
-- Indexes for table `comment_post`
--
ALTER TABLE `comment_post`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_comment_post_post` (`post_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `fk_notifications_classroom` (`class_code`);

--
-- Indexes for table `notification_user`
--
ALTER TABLE `notification_user`
  ADD PRIMARY KEY (`notification_id`,`email`),
  ADD KEY `fk_notification_user_notifications2` (`email`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk_user_post` (`email`);

--
-- Indexes for table `post_classroom`
--
ALTER TABLE `post_classroom`
  ADD PRIMARY KEY (`post_id`,`class_code`),
  ADD KEY `fk_post_classroom_user` (`class_code`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `resources_classroom`
--
ALTER TABLE `resources_classroom`
  ADD PRIMARY KEY (`resource_id`,`class_code`),
  ADD KEY `fk_resources_classroom` (`class_code`);

--
-- Indexes for table `resource_downvote`
--
ALTER TABLE `resource_downvote`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `fk_resource_downvote_users` (`email`);

--
-- Indexes for table `resource_frequency`
--
ALTER TABLE `resource_frequency`
  ADD PRIMARY KEY (`resource_id`,`email`),
  ADD KEY `fk_resource_frequency_user2` (`email`);

--
-- Indexes for table `resource_saved`
--
ALTER TABLE `resource_saved`
  ADD PRIMARY KEY (`resource_id`,`email`),
  ADD KEY `fk_resource_saved_users` (`email`);

--
-- Indexes for table `resource_uploaded`
--
ALTER TABLE `resource_uploaded`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `resource_upvote`
--
ALTER TABLE `resource_upvote`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `fk_resource_upvote_users` (`email`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `student_classroom`
--
ALTER TABLE `student_classroom`
  ADD PRIMARY KEY (`email`,`class_code`),
  ADD UNIQUE KEY `email` (`email`,`class_code`),
  ADD KEY `fk_student_classroom2` (`class_code`);

--
-- Indexes for table `student_classroom_session`
--
ALTER TABLE `student_classroom_session`
  ADD PRIMARY KEY (`email`,`session`);

--
-- Indexes for table `student_task_submission`
--
ALTER TABLE `student_task_submission`
  ADD PRIMARY KEY (`task_id`,`file_id`),
  ADD UNIQUE KEY `email` (`email`,`task_id`,`file_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `fk_task_event` (`event_id`);

--
-- Indexes for table `task_classroom`
--
ALTER TABLE `task_classroom`
  ADD PRIMARY KEY (`task_id`,`class_code`),
  ADD KEY `fk_quiz_classroom` (`class_code`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `teacher_classroom`
--
ALTER TABLE `teacher_classroom`
  ADD PRIMARY KEY (`email`,`class_code`),
  ADD UNIQUE KEY `email` (`email`,`class_code`),
  ADD KEY `fk_teacher_classroom2` (`class_code`);

--
-- Indexes for table `token_table`
--
ALTER TABLE `token_table`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classroom_creator`
--
ALTER TABLE `classroom_creator`
  ADD CONSTRAINT `fk_classroom_creator_classroom` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_classroom_creator_users` FOREIGN KEY (`email`) REFERENCES `teacher` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `classroom_frequency`
--
ALTER TABLE `classroom_frequency`
  ADD CONSTRAINT `fk_classroom_frequency_user` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_classroom_frequency_user2` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `classroom_session`
--
ALTER TABLE `classroom_session`
  ADD CONSTRAINT `classroom_session_ibfk_1` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `classroom_session_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_comment_post` FOREIGN KEY (`comment_id`) REFERENCES `comment_post` (`comment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `comment_post`
--
ALTER TABLE `comment_post`
  ADD CONSTRAINT `fk_comment_post_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_classroom` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE;

--
-- Constraints for table `notification_user`
--
ALTER TABLE `notification_user`
  ADD CONSTRAINT `fk_notification_user_notifications` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notification_user_notifications2` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `post_classroom`
--
ALTER TABLE `post_classroom`
  ADD CONSTRAINT `fk_post_classroom` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_classroom2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE;

--
-- Constraints for table `resources_classroom`
--
ALTER TABLE `resources_classroom`
  ADD CONSTRAINT `fk_resources_classroom` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resources_classroom2` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE;

--
-- Constraints for table `resource_downvote`
--
ALTER TABLE `resource_downvote`
  ADD CONSTRAINT `fk_resource_downvote_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resource_downvote_users` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `resource_frequency`
--
ALTER TABLE `resource_frequency`
  ADD CONSTRAINT `fk_resource_frequency_user` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resource_frequency_user2` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `resource_saved`
--
ALTER TABLE `resource_saved`
  ADD CONSTRAINT `fk_resource_saved_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resource_saved_users` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resources_saved_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`);

--
-- Constraints for table `resource_uploaded`
--
ALTER TABLE `resource_uploaded`
  ADD CONSTRAINT `fk_resource_uploaded_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE;

--
-- Constraints for table `resource_upvote`
--
ALTER TABLE `resource_upvote`
  ADD CONSTRAINT `fk_resource_upvote_resources` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resource_upvote_users` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_users` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `student_classroom`
--
ALTER TABLE `student_classroom`
  ADD CONSTRAINT `fk_student_classroom` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_student_classroom2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE;

--
-- Constraints for table `student_task_submission`
--
ALTER TABLE `student_task_submission`
  ADD CONSTRAINT `student_task_submission_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_task_submission_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_task_submission_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_task_submission_ibfk_4` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_task_submission_ibfk_5` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk_quiz_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_task_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`) ON DELETE CASCADE;

--
-- Constraints for table `task_classroom`
--
ALTER TABLE `task_classroom`
  ADD CONSTRAINT `fk_quiz_classroom` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quiz_classroom2` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_user` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_classroom`
--
ALTER TABLE `teacher_classroom`
  ADD CONSTRAINT `fk_teacher_classroom` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_teacher_classroom2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
