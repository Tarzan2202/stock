-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 05:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Role` varchar(255) NOT NULL DEFAULT 'Users'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `Role`) VALUES
(9, '1234', '$2y$10$Zm5TelJesgdkfFPG7/bmrOJrmOEXK.bD2phVGKdX7RskWHx06Ft4C', '$2y$10$Mh1Q8JBj1WI85pDb2VhZFOA0pOK0shu/9p4RRJy2M4SBVfWsFKvTq'),
(10, 'aaaa', '$2y$10$0PrCf2Y/5nc7iGsNmUaHJ.s5lv3dvqqa8TTlGqqbFROzF8JTXxhFu', '$2y$10$8Xs/1LAOMhWMksC7CCQv.exb8CZb87GllzEYyOaqiUuR5X73PR3lG'),
(11, 'qqqq', '$2y$10$NXVz.SaV6TxhDBOX8W/l9.pyt3MU.JDv3WGeK3X1x4u0uizh7ybn2', '$2y$10$B0NyyKufXkn78rljDvlSTeRW9v7y5pSpQqg18md3vhcscZM.7EVxO'),
(13, 'zzzz', '$2y$10$FnBGMGF8xVGuUgSQbCNht.py38L4VRPwFnE34zCsPh8h.l1lWuNQu', '$2y$10$UbzKqrLLGPABh6/zLuIvI.uZrS83Cov1V/s3zgadu.9le.UYG/zEK'),
(15, 'gggg', '$2y$10$ea0Ceem.FmyoLXH6OPMReOkpr3etBf8DKprBIAENl0xKmTb.SlCIa', '$2y$10$a8ufL.T16NrMqgSZtm5DjOHDUn8jlznXWfsQA7alZJIGBpw4v8PcO'),
(16, 'kkkk', '$2y$10$XuTuE8Vygl1fkeSRWI8xm.Bdz53MI9HnnPnhf/KjNEoR./Uijr.P.', '$2y$10$hiHsp6IkzPWJKnC9jsgvxezsd38Bs3p3Nrd/aN6pXhPDbe3ZZrO52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
