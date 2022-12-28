-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2022 at 08:47 AM
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
  `attendance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classroom_creator`
--

CREATE TABLE `classroom_creator` (
  `email` varchar(200) NOT NULL,
  `class_code` varchar(20) NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `event_start_datetime` datetime NOT NULL,
  `event_end_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` varchar(50) NOT NULL,
  `filename` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `message` text NOT NULL,
  `notification_id` varchar(50) NOT NULL,
  `notification_datetime` datetime NOT NULL,
  `notification_type` set('resource','task','session','submit') NOT NULL,
  `class_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification_user`
--

CREATE TABLE `notification_user` (
  `notification_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resource_id` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `resource_tag` text DEFAULT NULL,
  `post_date_time` datetime DEFAULT NULL,
  `file_id` text DEFAULT NULL,
  `resource_visibility` set('private','public') DEFAULT NULL,
  `resource_description` text NOT NULL
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
-- Table structure for table `resource_downvote`
--

CREATE TABLE `resource_downvote` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resource_saved`
--

CREATE TABLE `resource_saved` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resource_uploaded`
--

CREATE TABLE `resource_uploaded` (
  `resource_id` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `student_classroom_session`
--

CREATE TABLE `student_classroom_session` (
  `email` varchar(200) NOT NULL,
  `session` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `task_classroom`
--

CREATE TABLE `task_classroom` (
  `task_id` varchar(50) NOT NULL,
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
-- Indexes for table `resource_saved`
--
ALTER TABLE `resource_saved`
  ADD PRIMARY KEY (`resource_id`),
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
