-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2022 at 10:58 AM
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
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignment_id` varchar(50) NOT NULL,
  `event_id` varchar(50) DEFAULT NULL,
  `institution` text DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `question_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `class_code` varchar(20) NOT NULL,
  `classroom_name` text NOT NULL,
  `course_code` varchar(10) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` varchar(50) NOT NULL,
  `post_id` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` varchar(50) NOT NULL,
  `event_datetime` datetime DEFAULT NULL,
  `event_type` set('holiday','deadline') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` varchar(50) NOT NULL,
  `event_id` varchar(50) DEFAULT NULL,
  `holiday_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `post_datetime` datetime DEFAULT NULL,
  `post_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post_classroom`
--

CREATE TABLE `post_classroom` (
  `post_id` varchar(50) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` varchar(50) NOT NULL,
  `event_id` varchar(50) DEFAULT NULL,
  `institution` text DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `question_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resource_id` varchar(50) NOT NULL,
  `resource_tag` varchar(100) DEFAULT NULL,
  `post_date_time` datetime DEFAULT NULL,
  `file_url` text DEFAULT NULL,
  `resource_visibility` set('private','public') DEFAULT NULL,
  `institution` text DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `email` varchar(200) NOT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_classroom`
--

CREATE TABLE `student_classroom` (
  `email` varchar(200) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `email` varchar(200) NOT NULL,
  `designation` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_classroom`
--

CREATE TABLE `teacher_classroom` (
  `email` varchar(200) NOT NULL,
  `class_code` varchar(20) NOT NULL
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
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`class_code`),
  ADD UNIQUE KEY `class_code_2` (`class_code`),
  ADD KEY `class_code` (`class_code`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`);

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
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`resource_id`);

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
  ADD KEY `email_2` (`email`,`class_code`),
  ADD KEY `fk_student_classroom2` (`class_code`);

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
  ADD UNIQUE KEY `email_2` (`email`,`class_code`),
  ADD KEY `email_3` (`email`,`class_code`),
  ADD KEY `fk_teacher_classroom2` (`class_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_post` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `post_classroom`
--
ALTER TABLE `post_classroom`
  ADD CONSTRAINT `fk_post_classroom` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_classroom2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_classroom_user` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_student_classroom2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_classroom_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_classroom_ibfk_2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_teacher_classroom2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_classroom_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_classroom_ibfk_2` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
