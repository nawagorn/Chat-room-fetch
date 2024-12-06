-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 04:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id_comment` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id_comment`, `room_id`, `name`, `message`, `created_at`) VALUES
(80, 1, 'เจ้าหน้าที่กรมทางหลวง', 'ได้รับรายงานว่ามีต้นไม้ใหญ่กีดขวางการจราจรบริเวณถนนสายหลัก อยากทราบว่าทางหน่วยป่าไม้สามารถช่วยดำเนินการได้ไหมครับ?', '2024-12-06 02:03:56'),
(81, 1, 'เจ้าหน้าที่ป่าไม้', 'ทางเราต้องตรวจสอบว่าต้นไม้ดังกล่าวอยู่ในพื้นที่รับผิดชอบของป่าไม้หรือไม่ ขอทราบตำแหน่งที่แน่นอนด้วยครับ', '2024-12-06 02:04:28'),
(82, 1, 'เจ้าหน้าที่กรมทางหลวง', 'พิกัดคือบริเวณ กม.10 ถนนสาย 304 ครับ มีผลต่อการสัญจรค่อนข้างมากในช่วงเวลาเร่งด่วน', '2024-12-06 02:04:39'),
(83, 1, 'เจ้าหน้าที่ป่าไม้', 'เข้าใจปัญหาครับ เราจะส่งเจ้าหน้าที่ไปสำรวจและประเมินสถานการณ์ภายใน 2 วัน', '2024-12-06 02:04:55'),
(84, 2, 'เจ้าหน้าที่เทศบาล', 'ทางเราพบว่ามีขยะถูกทิ้งริมถนนเป็นจำนวนมาก อยากขอความร่วมมือจากชุมชนช่วยกันรักษาความสะอาดครับ', '2024-12-06 02:06:14'),
(85, 2, 'ชาวบ้าน', 'เราเห็นบางคนแอบมาทิ้งตอนกลางคืน ถ้ามีกล้องวงจรปิดน่าจะช่วยได้เยอะเลยค่ะ', '2024-12-06 02:06:22'),
(86, 2, 'เจ้าหน้าที่เทศบาล', 'เดี๋ยวทางเราจะประสานติดตั้งป้ายเตือนและกล้องวงจรปิด รวมถึงจัดเจ้าหน้าที่ตรวจตราพื้นที่เพิ่มเติมครับ', '2024-12-06 02:06:30'),
(87, 2, 'ชาวบ้าน', 'ถ้ามีจุดทิ้งขยะเฉพาะหรือเก็บขยะบ่อยขึ้น น่าจะช่วยลดปัญหาขยะริมถนนได้ค่ะ', '2024-12-06 02:06:38'),
(92, 1, 'พี่แท็กทีมสุดหล่อ', 'สวัสดี', '2024-12-06 02:53:34'),
(93, 1, 'พี่แท็กทีมสุดหล่อ', 'มาครับ', '2024-12-06 02:53:47'),
(94, 1, 'plagad', 'hello', '2024-12-06 02:53:58'),
(95, 1, 'ดิว', 'ดีครับ', '2024-12-06 02:54:03'),
(96, 1, 'พี่แท็กทีมสุดหล่อ', 'Hello', '2024-12-06 02:54:16');

-- --------------------------------------------------------

--
-- Table structure for table `roomdetails`
--

CREATE TABLE `roomdetails` (
  `id` int(11) NOT NULL,
  `room_code` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('รอรับเรื่อง','ดำเนินการ','ส่งต่อ','เสร็จสิ้น','ไม่พอใจการแก้ไข','พอใจการแก้ไข') DEFAULT 'รอรับเรื่อง',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roomdetails`
--

INSERT INTO `roomdetails` (`id`, `room_code`, `title`, `status`, `created_at`) VALUES
(1, '12345', 'ต้นไม้กีดขวางทาง', 'ดำเนินการ', '2024-11-29 08:50:52'),
(2, '123456', 'ทิ้งขยะริมถนน', 'รอรับเรื่อง', '2024-12-04 08:45:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `roomdetails`
--
ALTER TABLE `roomdetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `roomdetails`
--
ALTER TABLE `roomdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `roomdetails` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
