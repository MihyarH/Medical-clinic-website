-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 08, 2023 at 11:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WDFP`
--

-- --------------------------------------------------------

--
-- Table structure for table `Appointments`
--

CREATE TABLE `Appointments` (
  `id` int(11) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Appointments`
--

INSERT INTO `Appointments` (`id`, `doctor_name`, `patient_name`, `email`, `date`, `time`) VALUES
(76, '3', 'Mihyar Al Hariri', 'mihyar@gmail.com', '2023-06-14', '11:57:00'),
(77, '3', 'Ungureanu Raul', 'raul@gmail.com', '2023-06-22', '01:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `user_type`) VALUES
(1, 'Mihyar Al Hariri', 'mihyar@gmail.com', '$2y$10$qOrPMr2YlywVyhoGhcR2R.29dl9D4aMUeEPMC8mynziYuIQ3Ajo12', 'patient'),
(3, 'Dr. Patrick Soon Shiong', 'patrick@gmail.com', '$2y$10$hJkfCEL9paLGqij6THWwE.dBbQ2SRTbBkGT/qi/Oa9bIPfeVVpNGi', 'doctor'),
(4, 'Ungureanu Raul', 'raul@gmail.com', '$2y$10$.nxH2Jam8B7J0J/ZYMybue9hHbR9UVYmJQdtezgNRVRFl91nagDbK', 'patient'),
(5, 'Dr. Myles. B. Abbott, M.D.', 'myles@gmail.com', '$2y$10$mQIT/fTwOihfL0zBFgRPze9jgJYCnifXVZwrk1fZmcr0nzE8KQsZe', 'doctor'),
(6, 'Dr. Khalid Abbed, M.D.', 'khalid@gmail.com', '$2y$10$LrcGcxDKXasmFokAjTVA9.TAdVt.GyeBV.HPuBoeQBbvK821ivZCa', 'doctor'),
(7, 'soon', 'soon@gmail.com', '$2y$10$o.MRLyx3Hw3ylBcVb5qVHOAddXCFnvzxqHm/C/O6XvSV2QNmBjhc6', 'doctor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Appointments`
--
ALTER TABLE `Appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Appointments`
--
ALTER TABLE `Appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
