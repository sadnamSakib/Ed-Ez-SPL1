-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2022 at 05:42 AM
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
-- Table structure for table `assignment_classroom`
--

CREATE TABLE `assignment_classroom` (
  `assignment_id` varchar(50) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `class_code` varchar(20) NOT NULL,
  `classroom_name` text NOT NULL,
  `course_code` varchar(10) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`class_code`, `classroom_name`, `course_code`, `semester`, `archived`) VALUES
('ol8h3VeUJo', 'h', 'a', 8, 1),
('PkffqRmr4x', 'h', 'h', 9, 1),
('WYXIQtqScQ', 'Linear Algebra', 'CSE 4341', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` varchar(50) NOT NULL,
  `comment_message` text NOT NULL,
  `comment_datetime` datetime NOT NULL,
  `email` varchar(200) NOT NULL,
  `post_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_message`, `comment_datetime`, `email`, `post_id`) VALUES
('vJIed1B80T9PjIRHhBXlF9oBhhi9kAL0MKdXxamJ3h8nEPcR5t', 'New comment', '2022-10-19 05:33:45', 'e048ab739a2f106de400f8139f08aa426de8f45737d9490527866de3f786cbe985fd736b21d541cae545a589f8706e1426deb06f0d486686fcd28ed8225600fa', 'jMisUQyzyepLaSTQz0OdlEVxTxj4LziSQHG5z0DYGyHVaGbtcR');

-- --------------------------------------------------------

--
-- Table structure for table `comment_post`
--

CREATE TABLE `comment_post` (
  `comment_id` varchar(50) NOT NULL,
  `post_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` varchar(50) NOT NULL,
  `event_datetime` datetime DEFAULT NULL,
  `event_type` set('holiday','deadline') DEFAULT NULL,
  `event_title` text DEFAULT NULL
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

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `email`, `post_datetime`, `post_message`) VALUES
('jMisUQyzyepLaSTQz0OdlEVxTxj4LziSQHG5z0DYGyHVaGbtcR', 'e048ab739a2f106de400f8139f08aa426de8f45737d9490527866de3f786cbe985fd736b21d541cae545a589f8706e1426deb06f0d486686fcd28ed8225600fa', '2022-10-19 05:05:41', 'this is a post');

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
('jMisUQyzyepLaSTQz0OdlEVxTxj4LziSQHG5z0DYGyHVaGbtcR', 'PkffqRmr4x');

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
-- Table structure for table `quiz_classroom`
--

CREATE TABLE `quiz_classroom` (
  `quiz_id` varchar(50) NOT NULL,
  `class_code` varchar(20) NOT NULL
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
-- Table structure for table `resources_classroom`
--

CREATE TABLE `resources_classroom` (
  `resource_id` varchar(50) NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `email` varchar(200) NOT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`email`, `semester`) VALUES
('2e21444b94845891b0f714470a2b8c12ff69fcaed1fe33b18aa09b1ed91e4bf3f8bf59e5cb43fb73a8c66c6d84efe3709de85ecdde86c179d2327a70c18a232e', NULL);

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
('2e21444b94845891b0f714470a2b8c12ff69fcaed1fe33b18aa09b1ed91e4bf3f8bf59e5cb43fb73a8c66c6d84efe3709de85ecdde86c179d2327a70c18a232e', 'ol8h3VeUJo'),
('2e21444b94845891b0f714470a2b8c12ff69fcaed1fe33b18aa09b1ed91e4bf3f8bf59e5cb43fb73a8c66c6d84efe3709de85ecdde86c179d2327a70c18a232e', 'PkffqRmr4x'),
('2e21444b94845891b0f714470a2b8c12ff69fcaed1fe33b18aa09b1ed91e4bf3f8bf59e5cb43fb73a8c66c6d84efe3709de85ecdde86c179d2327a70c18a232e', 'WYXIQtqScQ');

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
('90dc560460a215b93c5f067672aafd855e2b1fc411e0f5aba890e170ccb75ebb8941fa653b50396ba493a3d812b1857d4d140dc6bb4d500abf773762bb49a36d', NULL),
('e048ab739a2f106de400f8139f08aa426de8f45737d9490527866de3f786cbe985fd736b21d541cae545a589f8706e1426deb06f0d486686fcd28ed8225600fa', NULL);

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
('90dc560460a215b93c5f067672aafd855e2b1fc411e0f5aba890e170ccb75ebb8941fa653b50396ba493a3d812b1857d4d140dc6bb4d500abf773762bb49a36d', 'ol8h3VeUJo'),
('90dc560460a215b93c5f067672aafd855e2b1fc411e0f5aba890e170ccb75ebb8941fa653b50396ba493a3d812b1857d4d140dc6bb4d500abf773762bb49a36d', 'PkffqRmr4x'),
('e048ab739a2f106de400f8139f08aa426de8f45737d9490527866de3f786cbe985fd736b21d541cae545a589f8706e1426deb06f0d486686fcd28ed8225600fa', 'ol8h3VeUJo'),
('e048ab739a2f106de400f8139f08aa426de8f45737d9490527866de3f786cbe985fd736b21d541cae545a589f8706e1426deb06f0d486686fcd28ed8225600fa', 'PkffqRmr4x');

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
('2e21444b94845891b0f714470a2b8c12ff69fcaed1fe33b18aa09b1ed91e4bf3f8bf59e5cb43fb73a8c66c6d84efe3709de85ecdde86c179d2327a70c18a232e', 'STUDENT', '$2y$10$oKyMVoLaGLiZrOvwJcUyT.7rhHube2GWsvNUsjbACs8nxuffJrUQa', 'IUT', '2022-10-12', NULL, NULL, NULL, NULL, 1),
('90dc560460a215b93c5f067672aafd855e2b1fc411e0f5aba890e170ccb75ebb8941fa653b50396ba493a3d812b1857d4d140dc6bb4d500abf773762bb49a36d', 'Mirza', '$2y$10$U86VAOx3GtKnrP6ubunTl.7/Stp5Kq3vrt1eaan5svI/G2Si.e91q', 'IUT', '2022-10-11', NULL, NULL, NULL, NULL, 1),
('e048ab739a2f106de400f8139f08aa426de8f45737d9490527866de3f786cbe985fd736b21d541cae545a589f8706e1426deb06f0d486686fcd28ed8225600fa', 'Mirza Mohammad Azwad', '$2y$10$uXyj7qZ/b8/XmyQX7YzUAe0fax3BUN3yWrrH/r62A5qdNZEbzjNEe', 'IUT', '2022-10-05', NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `assignment_classroom`
--
ALTER TABLE `assignment_classroom`
  ADD PRIMARY KEY (`assignment_id`,`class_code`),
  ADD KEY `fk_assignment_classroom` (`class_code`);

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
  ADD KEY `fk_comments_users` (`email`),
  ADD KEY `fk_comments_posts` (`post_id`);

--
-- Indexes for table `comment_post`
--
ALTER TABLE `comment_post`
  ADD PRIMARY KEY (`comment_id`,`post_id`),
  ADD KEY `fk_post_comments` (`post_id`);

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
-- Indexes for table `quiz_classroom`
--
ALTER TABLE `quiz_classroom`
  ADD PRIMARY KEY (`quiz_id`,`class_code`),
  ADD KEY `fk_quiz_classroom` (`class_code`);

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
-- Constraints for table `assignment_classroom`
--
ALTER TABLE `assignment_classroom`
  ADD CONSTRAINT `fk_assignment_classroom` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_assignment_classroom2` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`assignment_id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_posts` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `comment_post`
--
ALTER TABLE `comment_post`
  ADD CONSTRAINT `fk_post_comments` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_post_comments2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;

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
-- Constraints for table `quiz_classroom`
--
ALTER TABLE `quiz_classroom`
  ADD CONSTRAINT `fk_quiz_classroom` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quiz_classroom2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `resources_classroom`
--
ALTER TABLE `resources_classroom`
  ADD CONSTRAINT `fk_resources_classroom` FOREIGN KEY (`class_code`) REFERENCES `classroom` (`class_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resources_classroom2` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE;

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
