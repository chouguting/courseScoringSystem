-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-12-28 18:33:29
-- 伺服器版本： 10.4.22-MariaDB
-- PHP 版本： 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `coursescoringsystem`
--

-- --------------------------------------------------------

--
-- 資料表結構 `comment`
--

CREATE TABLE `comment` (
  `course_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `course`
--

CREATE TABLE `course` (
  `course_id` varchar(20) NOT NULL,
  `course_name` varchar(20) NOT NULL,
  `course_status` varchar(3) NOT NULL,
  `semester` varchar(3) DEFAULT NULL,
  `instructor_id` int(30) NOT NULL,
  `department_name` varchar(20) DEFAULT NULL,
  `course_location` varchar(20) DEFAULT NULL,
  `course_time` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_status`, `semester`, `instructor_id`, `department_name`, `course_location`, `course_time`) VALUES
('B5721M97', '微積分', 'on', '1', 2, '資訊工程學系', '資工B10', '101 102 103');

-- --------------------------------------------------------

--
-- 資料表結構 `department`
--

CREATE TABLE `department` (
  `department_name` varchar(30) NOT NULL,
  `department_website` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `department`
--

INSERT INTO `department` (`department_name`, `department_website`) VALUES
('資訊工程學系', 'https://cse.ntou.edu.tw/'),
('電機工程學系', 'https://ee.ntou.edu.tw/');

-- --------------------------------------------------------

--
-- 資料表結構 `instructor`
--

CREATE TABLE `instructor` (
  `instructor_id` int(30) NOT NULL,
  `instructor_name` varchar(20) NOT NULL,
  `department_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `instructor`
--

INSERT INTO `instructor` (`instructor_id`, `instructor_name`, `department_name`) VALUES
(1, '蔡國煇', '資訊工程學系'),
(2, '許玉平', '資訊工程學系');

-- --------------------------------------------------------

--
-- 資料表結構 `rating`
--

CREATE TABLE `rating` (
  `rating` decimal(2,0) NOT NULL,
  `impression` varchar(500) DEFAULT NULL,
  `course_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `rating_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `user_id` int(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `display_name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_level` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`user_id`, `username`, `display_name`, `password`, `user_level`) VALUES
(1, 'chouguting', 'Gordon', '20010122', 's'),
(3, '', '', '', 'u'),
(4, '', '', '', 'u');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`user_id`,`course_id`,`comment_time`);

--
-- 資料表索引 `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`,`instructor_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `department_name` (`department_name`);

--
-- 資料表索引 `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_name`);

--
-- 資料表索引 `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`instructor_id`),
  ADD KEY `department_name` (`department_name`);

--
-- 資料表索引 `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`user_id`,`course_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `instructor`
--
ALTER TABLE `instructor`
  MODIFY `instructor_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`department_name`) REFERENCES `department` (`department_name`);

--
-- 資料表的限制式 `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`department_name`) REFERENCES `department` (`department_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
