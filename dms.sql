-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 06:29 PM
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
(18, 3, 24, 'View and Download', 1, '2024-08-01 19:51:13'),
(19, 23, 25, 'View and Download', 1, '2024-08-02 06:47:21'),
(20, 3, 25, 'View Only', 1, '2024-08-02 06:47:42'),
(21, 23, 26, 'View Only', 1, '2024-08-02 06:49:44'),
(22, 12, 25, 'View Only', 1, '2024-08-02 07:23:32'),
(23, 24, 27, 'View Only', 1, '2024-08-03 16:15:36'),
(24, 24, 28, 'View and Download', 1, '2024-08-03 16:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(24, 'TWPE', 'TWPE Excercise', '/xampp/htdocs/dms/filesTemp/TWPE Excercise.pdf', 'pdf', '2024-08-01 16:18:07', 1, 'Active'),
(25, 'Taigman', 'Deep face learning research paper', '/xampp/htdocs/dms/filesTemp/taigman_cvpr14.pdf', 'pdf', '2024-08-01 16:19:20', 1, 'Active'),
(26, 'IP Paper', 'Third Year IP Papers 2019 Batch', '/xampp/htdocs/dms/filesTemp/user2/TE1257.pdf', 'pdf', '2024-08-02 03:19:26', 1, 'Active'),
(27, 'Civil Papers', 'asdasdad', '/xampp/htdocs/dms/filesTemp/user3/Civil Paper.pdf', 'pdf', '2024-08-03 12:44:17', 1, 'Active'),
(28, 'Air pollution', 'sfdsssssscd', '/xampp/htdocs/dms/filesTemp/user3/Air Pollution- U4 (OE).pdf', 'pdf', '2024-08-03 12:45:13', 1, 'Active');

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
(20, 24, NULL, '2024-08-01 16:18:07', 'Pending'),
(21, 25, NULL, '2024-08-01 16:19:20', 'Pending'),
(22, 26, NULL, '2024-08-02 03:19:26', 'Pending'),
(23, 27, NULL, '2024-08-03 12:44:17', 'Pending'),
(24, 28, NULL, '2024-08-03 12:45:13', 'Pending');

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
(24, 27);

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
(1, 'ru', 'ru@gmail.com', 'admin', '$2y$10$yl4eBezgxixhcshhG3oA2uEe7j00wrVjW.2qMXewEmuHIfgMAfP2K', '2024-07-14 16:07:02', 'inactive'),
(2, 'sh', 'sh@gmail.com', 'officer', '$2y$10$SdMfzlXfuuZKHmhI2cGJ/O1cRN.JNBt1CUeXqOoW9FMaMvGHKOcgC', '2024-07-14 16:55:04', 'active'),
(3, 'smita', 'smita@gmail.com', 'employee', '$2y$10$b/yE5qJm73O20VFonW6PXONfpcHurqq4wb.7sUTF3py4Elw6KQaFG', '2024-07-14 16:55:22', 'inactive'),
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
(24, 'raj', 'raj@gmail.com', 'employee', '$2y$10$GX.Q3ZssSvTf7JQMX/MureCCRFp/MJRoiSnPS.WjGKB.XEpdfV0Dm', '2024-08-03 21:41:11', 'inactive');

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
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `document_approvals`
--
ALTER TABLE `document_approvals`
  MODIFY `approval_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `document_versions`
--
ALTER TABLE `document_versions`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
