-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 22, 2024 at 05:44 PM
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
-- Database: `abel_expert`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(100, 'dafam', '$2y$10$gdAhCrN4Z6WfUz1ajJwBI.KZX.jEyHgp/oceA5SmXqV...', 'dafamabelnansak@gmail.com');

-- --------------------------------------------------------
--password admin123
--
-- Table structure for table `diagnoses`
--

CREATE TABLE `diagnoses` (
  `id` int(11) NOT NULL,
  `diagnosis_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnoses`
--

INSERT INTO `diagnoses` (`id`, `diagnosis_description`) VALUES
(1, 'Low RAM or CPU overload'),
(2, 'Corrupt system files'),
(3, 'Faulty cooling system'),
(4, 'Hardware driver issues'),
(5, 'Power supply issue'),
(6, 'Sound driver problem'),
(7, 'Network adapter failure'),
(8, 'Hardware failure'),
(9, 'Software compatibility issues'),
(10, 'Virus or malware infection'),
(11, 'Malware Infection'),
(12, 'Cooling System Failure'),
(13, 'Hard Drive Issues'),
(14,'Software Conflicts'),
(15,'Hardware Failure'),
(16, 'File System Corruption'),
(17, 'Adware or PUP'),
(18, 'Network Driver Issues'),
(19, 'Resource Overutilization'),
(20, 'Faulty Power Supply Unit (PSU)');

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_rules`
--

CREATE TABLE `diagnosis_rules` (
  `id` int(11) NOT NULL,
  `symptom_id` int(11) DEFAULT NULL,
  `diagnosis_id` int(11) DEFAULT NULL,
  `rule_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnosis_rules`
--

INSERT INTO `diagnosis_rules` (`id`, `symptom_id`, `diagnosis_id`, `rule_description`) VALUES
(1, 1, 1, 'Check RAM usage in Task Manager and close unnecessary applications.'),
(2, 2, 2, 'Run System File Checker (sfc /scannow) to repair corrupt files.'),
(3, 3, 3, 'Inspect cooling fans and clean dust from vents.'),
(4, 4, 4, 'Update or reinstall hardware drivers.'),
(5, 5, 5, 'Test the power supply unit (PSU) using a multimeter.'),
(6, 6, 6, 'Check audio settings and reinstall sound drivers.'),
(7, 7, 7, 'Troubleshoot network settings and reset the network adapter.'),
(8, 8, 8, 'Run hardware diagnostics to check for failing components.'),
(9, 9, 9, 'Uninstall conflicting software and check for updates.'),
(10, 10, 10, 'Run a full antivirus scan to detect and remove malware.'),
(11, 11, 11, 'Run Antivirus Scan'),
(12, 12, 12, 'Check Cooling Components'),
(13, 13, 13, 'Run Disk Check Utility'),
(14, 14, 14, 'Update Software'),
(15, 15, 15, 'Check Event Viewer Logs'),
(16, 16, 16, 'Run File Repair Tools'),
(17, 17, 17, 'Adware Removal Tools'),
(18, 18, 18, 'Update Network Drivers'),
(19, 19, 19, 'Monitor Resource Usage'),
(20, 20, 20, 'Test Power Supply');

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE `symptoms` (
  `id` int(11) NOT NULL,
  `symptom_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `symptoms`
--

INSERT INTO `symptoms` (`id`, `symptom_description`) VALUES
(1, 'Computer is slow'),
(2, 'Computer keeps freezing'),
(3, 'Overheating'),
(4, 'Blue screen of death (BSOD)'),
(5, 'Unexpected shutdown'),
(6, 'No sound from speakers'),
(7, 'Can’t connect to the internet'),
(8, 'Strange noises from the computer'),
(9, 'Programs crashing frequently'),
(10,'Files are missing or corrupted'),
(11,'System Freezes'),
(12,'Overheating'),
(13, 'Slow Boot Times'),
(14, 'Application Crashes'),
(15, 'Blue Screen of Death (BSOD)'),
(16, 'Corrupted Files'),
(17, 'Frequent Pop-ups'),
(18, 'Network Connectivity Issues'),
(19, 'Inconsistent Performance'),
(20, 'Power Supply Issues');



-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'Helen Micah', '4297f44b13955235245b2497399d7a93', 'helen@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `diagnoses`
--
ALTER TABLE `diagnoses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis_rules`
--
ALTER TABLE `diagnosis_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `symptom_id` (`symptom_id`),
  ADD KEY `diagnosis_id` (`diagnosis_id`);

--
-- Indexes for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `diagnoses`
--
ALTER TABLE `diagnoses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `diagnosis_rules`
--
ALTER TABLE `diagnosis_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `symptoms`
--
ALTER TABLE `symptoms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diagnosis_rules`
--
ALTER TABLE `diagnosis_rules`
  ADD CONSTRAINT `diagnosis_rules_ibfk_1` FOREIGN KEY (`symptom_id`) REFERENCES `symptoms` (`id`),
  ADD CONSTRAINT `diagnosis_rules_ibfk_2` FOREIGN KEY (`diagnosis_id`) REFERENCES `diagnoses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    symptom_id INT NOT NULL,
    additional_info TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (symptom_id) REFERENCES symptoms(id)
);

