-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2024 at 03:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dms`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_control`
--

CREATE TABLE `access_control` (
  `access_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `access_type` enum('View Only','View and Download') DEFAULT NULL,
  `access_granted_by` int(11) DEFAULT NULL,
  `granted_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_control`
--

INSERT INTO `access_control` (`access_id`, `user_id`, `document_id`, `access_type`, `access_granted_by`, `granted_date`) VALUES
(1, 24, 30, 'View and Download', 1, '2024-08-05 13:14:03'),
(2, 25, 30, 'View and Download', 1, '2024-08-05 13:14:18'),
(3, 23, 34, 'View and Download', 1, '2024-08-05 13:14:43'),
(4, 24, 31, 'View Only', 1, '2024-08-05 13:15:03'),
(5, 23, 32, 'View Only', 1, '2024-08-05 13:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` enum('Approved','Rejected','','') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`log_id`, `user_id`, `action`, `timestamp`, `details`) VALUES
(3, 2, 'Approved', '2024-08-05 13:19:23', 'Correct format of civil paper'),
(4, 2, 'Rejected', '2024-08-05 13:19:50', 'The images are not valid');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `uploaded_by` int(11) DEFAULT NULL,
  `status` enum('Active','Archived') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `title`, `description`, `file_path`, `file_type`, `upload_date`, `uploaded_by`, `status`) VALUES
(30, 'Civil Paper', 'This is a 3rd year open elective civil paper.', '/xampp/htdocs/dms/filesTemp/Civil Paper.pdf', 'pdf', '2024-08-05 09:27:03', 1, 'Active'),
(31, 'Optimal Search', 'A star, IDA algorithm.', '/xampp/htdocs/dms/filesTemp/Optimal Search.pdf', 'pdf', '2024-08-05 09:35:45', 1, 'Active'),
(32, '3digitization', 'Image processing and vision concept.', '/xampp/htdocs/dms/filesTemp/3digitization.pdf', 'pdf', '2024-08-05 09:37:26', 1, 'Active'),
(33, 'Networking devices', 'Devices used in Computer Networks.', '/xampp/htdocs/dms/filesTemp/Networking devices.pdf', 'pdf', '2024-08-05 09:39:04', 1, 'Active'),
(34, '5 viterbi', 'Viterbi Algorithm in Speech and Natural Language Processing.', '/xampp/htdocs/dms/filesTemp/folder1/5 Viterbi.pptx', 'pptx', '2024-08-05 09:43:03', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `document_approvals`
--

CREATE TABLE `document_approvals` (
  `approval_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approval_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_approvals`
--

INSERT INTO `document_approvals` (`approval_id`, `document_id`, `approved_by`, `approval_date`, `status`) VALUES
(26, 30, 2, '2024-08-05 09:27:03', 'Approved'),
(27, 31, NULL, '2024-08-05 09:35:45', 'Pending'),
(28, 32, NULL, '2024-08-05 09:37:26', 'Pending'),
(29, 33, 2, '2024-08-05 09:39:04', 'Rejected'),
(30, 34, NULL, '2024-08-05 09:43:03', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `document_versions`
--

CREATE TABLE `document_versions` (
  `version_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `version_number` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `uploaded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `starred_documents`
--

CREATE TABLE `starred_documents` (
  `user_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `starred_documents`
--

INSERT INTO `starred_documents` (`user_id`, `document_id`) VALUES
(24, 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `srno` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `password` varchar(256) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`srno`, `username`, `email`, `type`, `password`, `date`, `status`) VALUES
(1, 'ru', 'ru@gmail.com', 'admin', '$2y$10$yl4eBezgxixhcshhG3oA2uEe7j00wrVjW.2qMXewEmuHIfgMAfP2K', '2024-07-14 16:07:02', 'active'),
(2, 'sh', 'sh@gmail.com', 'officer', '$2y$10$SdMfzlXfuuZKHmhI2cGJ/O1cRN.JNBt1CUeXqOoW9FMaMvGHKOcgC', '2024-07-14 16:55:04', 'inactive'),
(3, 'smita', 'smita@gmail.com', 'employee', '$2y$10$b/yE5qJm73O20VFonW6PXONfpcHurqq4wb.7sUTF3py4Elw6KQaFG', '2024-07-14 16:55:22', 'active'),
(4, 'sanjay', 'sanjay@gmail.com', 'employee', '$2y$10$EoaKqsl.OBQuJrXyvs/AnO/oGxGzztBknWItMy7otwOcg0SSNa7IO', '2024-07-14 16:55:49', 'active'),
(11, 'shr', 'shr@gmail.com', 'employee', '$2y$10$BIz66j2n9J5P/TPg9jOFFugQ2JHgyryvk6qvhj/SzEk/jj2jmEBLe', '2024-07-19 20:57:05', 'active'),
(12, 'anon', 'anonymous295308@gmail.com', 'employee', '$2y$10$XP/ww37BYazmPrz6CVaTPe6XbzULQxsuk2BebKJwX8.7HfhSnv4LS', '2024-07-23 21:44:48', 'active'),
(15, 'ramesh Lal', 'rameshLal@gmail.com', 'employee', '$2y$10$G2BWoMKv0..5.1do0tuRKu8cI3lwDsWEyGaNxRumUb5W.A8xUB1d6', '2024-07-24 00:36:09', 'inactive'),
(16, 'krupeshjaishankar', 'krupeshj@gmail.com', 'employee', '$2y$10$Gj9/dNwnupOqwPrVjglcFOy5sHoAs6P5kW7x5Mdv4.UNCIVBX6bru', '2024-07-24 00:36:26', 'active'),
(19, 'carry', 'carry@gmail.com', 'employee', '$2y$10$3KM4he9fSyZdIgHvkZonx.oiW5xJZu.0oQFTkf7kBbJWrBvR.lVa2', '2024-07-24 18:19:15', 'active'),
(20, 'testuser', 'testuser@gmail.com', 'admin', '$2y$10$wbBTPZevakW8jS321d83f.FCOdLzZunqrcRPV8tIY.f4a9YsKlWjW', '2024-07-24 18:30:47', 'active'),
(21, 'k', 'k@gmail.com', 'employee', '$2y$10$LbO22aKp.PPiPfLu4ldapelaqiZy7PnZ.e6V1SY6rd5lJgtXvKATC', '2024-07-30 17:18:48', 'active'),
(22, 'd', 'd@gmail.com', 'employee', '$2y$10$BhvcC3czKeyEhXXdX4FuJ.3kLGFjqMpQdzZUAU7zZpl1CcLd4sjCm', '2024-08-01 12:31:46', 'active'),
(23, 'bhai', 'bhai@gmail.com', 'employee', '$2y$10$hTDt/R/oZfygl4.mUAuLZuce1yowHDfcvEFKeB84WqhUwYxXOCNKy', '2024-08-01 22:41:30', 'active'),
(24, 'raj', 'raj@gmail.com', 'employee', '$2y$10$GX.Q3ZssSvTf7JQMX/MureCCRFp/MJRoiSnPS.WjGKB.XEpdfV0Dm', '2024-08-03 21:41:11', 'inactive'),
(25, 'shravan', 'shravanadarkar2003@gmail.com', 'employee', '$2y$10$1lbk1Ah.ChSUXp7oi5JlXuoCnJkdySQVPhS1KClp2hV8iRnrb6.lC', '2024-08-04 13:09:36', 'inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_control`
--
ALTER TABLE `access_control`
  ADD PRIMARY KEY (`access_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `access_granted_by` (`access_granted_by`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `document_approvals`
--
ALTER TABLE `document_approvals`
  ADD PRIMARY KEY (`approval_id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `document_versions`
--
ALTER TABLE `document_versions`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `starred_documents`
--
ALTER TABLE `starred_documents`
  ADD PRIMARY KEY (`user_id`,`document_id`),
  ADD KEY `document_id` (`document_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`srno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_control`
--
ALTER TABLE `access_control`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `document_approvals`
--
ALTER TABLE `document_approvals`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `document_versions`
--
ALTER TABLE `document_versions`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_control`
--
ALTER TABLE `access_control`
  ADD CONSTRAINT `access_control_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`srno`),
  ADD CONSTRAINT `access_control_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`),
  ADD CONSTRAINT `access_control_ibfk_3` FOREIGN KEY (`access_granted_by`) REFERENCES `users` (`srno`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`srno`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`srno`);

--
-- Constraints for table `document_approvals`
--
ALTER TABLE `document_approvals`
  ADD CONSTRAINT `document_approvals_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`),
  ADD CONSTRAINT `document_approvals_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`srno`);

--
-- Constraints for table `document_versions`
--
ALTER TABLE `document_versions`
  ADD CONSTRAINT `document_versions_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`),
  ADD CONSTRAINT `document_versions_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`srno`);

--
-- Constraints for table `starred_documents`
--
ALTER TABLE `starred_documents`
  ADD CONSTRAINT `starred_documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`srno`),
  ADD CONSTRAINT `starred_documents_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
