-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2024 at 03:33 PM
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
-- Database: `mtfrb_lucban`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `m_name` varchar(50) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `job_position` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_type` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `f_name`, `l_name`, `m_name`, `username`, `email`, `password`, `code`, `job_position`, `created_at`, `account_type`, `profile_picture`, `contact_number`, `address`) VALUES
(4, 'Neozel', 'Aiden', 'Aiden', 'Neozel', 'noblepias2021@gmail.com', '$2y$10$Egc5gQ3vVDGxMCfGDh9YwOYK4KWrCBxTwi3hRUUZXBtZk24n2oBVO', 0, 'Admin Aide 1', '2024-08-08 07:09:41', 'Admin', '3f0bda3f216f7b0b8d44bfe3a9871316.jpg', '09483556700', 'Lucban'),
(5, 'Zach', 'Aiden', 'O', 'zachky', 'neozeloblepias@gmail.com', '$2y$10$3tkyxEqvK9OvHXzAGV7cJO5Jus3.BYWQQP.ZahmWgWv..4OHp7e0.', 0, 'Admin Aide 2', '2024-08-08 07:37:57', 'Super Admin', '32c0fe4a39a5574c172d9a4695785b2c.jpg', '09483556700', 'Luisiana'),
(7, 'Juan', 'Aiden', 'Aiden', 'JAJA', 'neo@gmail.com', '$2y$10$2yEz0/4T/m9LkhwKQVgx/.X/yF5S988Isok/TOh04T0Nqo3eCjV5e', 0, 'Admin Aide 1', '2024-08-09 14:27:54', 'Admin', '6afbee2795f875cb8cdf9c292cbed62c.jpg', '0215578638775', 'Luisiana');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `content`, `image_path`, `updated_at`) VALUES
(1, 'dfdf', '', '2024-08-14 05:14:28'),
(2, 'fdffd', 'fgdfgn.png', '2024-08-14 05:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `applicationDate` varchar(50) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `contact_num` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `b_date` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `tricColor` varchar(100) NOT NULL,
  `tricType` varchar(100) NOT NULL,
  `toda` varchar(100) NOT NULL,
  `driver1_name` varchar(100) NOT NULL,
  `driver2_name` varchar(100) NOT NULL,
  `operatorsPic` varchar(255) NOT NULL,
  `operatorsPicStatus` varchar(255) DEFAULT 'For verification',
  `operatorsPicRemarks` text DEFAULT 'No remarks',
  `toda_cert` varchar(255) NOT NULL,
  `toda_certStatus` varchar(255) DEFAULT 'For verification',
  `toda_certRemarks` text DEFAULT 'No remarks',
  `valid_id` varchar(255) NOT NULL,
  `valid_idStatus` varchar(255) DEFAULT 'For verification',
  `valid_idRemarks` text DEFAULT 'No remarks',
  `sedula` varchar(255) NOT NULL,
  `sedulaStatus` varchar(255) DEFAULT 'For verification',
  `sedulaRemarks` text DEFAULT 'No remarks',
  `brgy_clr` varchar(255) NOT NULL,
  `brgy_clrStatus` varchar(255) DEFAULT 'For verification',
  `brgy_clrRemarks` text DEFAULT 'No remarks',
  `driversPic1` varchar(255) NOT NULL,
  `driversPic1Status` varchar(255) DEFAULT 'For verification',
  `driversPic1Remarks` text DEFAULT 'No remarks',
  `driversPic2` varchar(255) NOT NULL,
  `driversPic2Status` varchar(255) DEFAULT 'For verification',
  `driversPic2Remarks` text DEFAULT 'No remarks',
  `license` varchar(255) DEFAULT NULL,
  `licenseStatus` varchar(255) DEFAULT 'For verification',
  `licenseRemarks` text DEFAULT 'No remarks',
  `med_res` varchar(255) NOT NULL,
  `med_resStatus` varchar(255) DEFAULT 'For verification',
  `med_resRemarks` text DEFAULT 'No remarks',
  `cr` varchar(255) NOT NULL,
  `crStatus` varchar(255) DEFAULT 'For verification',
  `crRemarks` text DEFAULT 'No remarks',
  `or` varchar(255) NOT NULL,
  `orStatus` varchar(255) DEFAULT 'For verification',
  `orRemarks` text DEFAULT 'No remarks',
  `tricyclePics` varchar(255) NOT NULL,
  `tricyclePicsStatus` varchar(255) DEFAULT 'For verification',
  `tricyclePicsRemarks` text DEFAULT 'No remarks',
  `tric_insp` varchar(255) NOT NULL,
  `tric_inspStatus` varchar(255) DEFAULT 'For verification',
  `tric_inspRemarks` text DEFAULT 'No remarks',
  `deedSale` varchar(255) NOT NULL,
  `deedSaleStatus` varchar(255) DEFAULT 'For verification',
  `deedSaleRemarks` text DEFAULT 'No remarks',
  `is_new` tinyint(1) NOT NULL DEFAULT 1,
  `interview_sched` varchar(100) DEFAULT NULL,
  `interviewStatus` varchar(100) NOT NULL DEFAULT 'Pending',
  `applicantStatus` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `password`, `code`, `applicationDate`, `first_name`, `last_name`, `m_name`, `suffix`, `contact_num`, `email`, `sex`, `age`, `b_date`, `address`, `tricColor`, `tricType`, `toda`, `driver1_name`, `driver2_name`, `operatorsPic`, `operatorsPicStatus`, `operatorsPicRemarks`, `toda_cert`, `toda_certStatus`, `toda_certRemarks`, `valid_id`, `valid_idStatus`, `valid_idRemarks`, `sedula`, `sedulaStatus`, `sedulaRemarks`, `brgy_clr`, `brgy_clrStatus`, `brgy_clrRemarks`, `driversPic1`, `driversPic1Status`, `driversPic1Remarks`, `driversPic2`, `driversPic2Status`, `driversPic2Remarks`, `license`, `licenseStatus`, `licenseRemarks`, `med_res`, `med_resStatus`, `med_resRemarks`, `cr`, `crStatus`, `crRemarks`, `or`, `orStatus`, `orRemarks`, `tricyclePics`, `tricyclePicsStatus`, `tricyclePicsRemarks`, `tric_insp`, `tric_inspStatus`, `tric_inspRemarks`, `deedSale`, `deedSaleStatus`, `deedSaleRemarks`, `is_new`, `interview_sched`, `interviewStatus`, `applicantStatus`) VALUES
(2, '$2y$10$INALcXsfinzD41X9EUTio.AEfxQtNMLf5TgwCHaM4JQtJv1Pwg8WW', '0', '2024-08-12 13:02:41', 'Zach', 'Oblepias', 'S', '', '0948355670', 'noblepias2021@gmail.com', 'Female', 0, '2024-08-08', 'Luisiana, Laguna', 'blue', 'Tricycle', 'MMK', 'Neo', 'Neozel', 'cb428b9a3894dea90b044996d480c4db.jpg', 'Valid', '', '6b734feb86ad16d1d73a3a50cf321939.pdf', 'Valid', '', '4baaaa5b1565462915514d75c8574176.jpg', 'Valid', '', '86c9d6ea3d29f5a1bf2af79ee23e622a.jpg', 'Valid', '', '', 'For verification', 'No remarks', '6e6cdf3322e577eab0cae9e3782b7f93.jpg', 'Valid', '', '339ba7cbd3ccc76074b967ca139e14cb.jpg', 'Valid', '', '7f8671f129afa95e4c186b37464d4a72.jpg', 'Valid', '', '17f18bec02dbefb555ac5d43edb62820.pdf', 'Valid', '', '008004a02d6d3f0d5c1b8c8855088231.jpg', 'Valid', '', '86baa89da3bb30ab0360409350b740ae.jpg', 'Valid', '', '[\"3477ba286f5090dd4dcee900b9784c33.jpg\",\"fd01da0475d8440c0a33461107c27507.jpg\"]', 'Valid', '', '', 'For verification', 'No remarks', '5ef0cff26e901ca1ae77d9bde73ac10b.jpg', 'Valid', '', 0, '2024-08-13 01:20 PM', 'Pending', 'Pending'),
(3, '$2y$10$kmFyvwRefsmQANwFlYMuXOTiOguqcudjk2PF3fDljgkfjvgfcFDv6', '0', '08/12/2024 01:25 PM', 'Jon', 'Doe', 'S', '', '09483556700', 'oblepiasneozel@gmail.com', 'male', 0, '2024-08-07', 'Luisiana, Laguna', 'blue', 'Tricycle', '', 'Ako', 'Ako', 'ee84d96bb11daa236da0bee90daf0118.jpg', 'For verification', 'No remarks', 'c25a1d2b2f39f5351447904b3d501488.jpg', 'For verification', 'No remarks', 'd0e68d00b3857222b9439e6a47b4d8a3.pdf', 'For verification', 'No remarks', 'ab676641a588e991088f14f4214b3654.jpg', 'For verification', 'No remarks', '', 'For verification', 'No remarks', 'eaad4deabe067bf4b20eec2edd5ae248.jpg', 'For verification', 'No remarks', '4456a06822e49ba3de70ca9dcae128d0.jpg', 'For verification', 'No remarks', '6b086af9d9486bc61a2413f059029354.jpg', 'For verification', 'No remarks', 'dcc357b5c15474e755a38dd04893c8d9.pdf', 'For verification', 'No remarks', '5ebe007e0f2472183676392f1481047d.jpg', 'For verification', 'No remarks', '1de6326a882cab2cba9d2ae0074904d8.jpg', 'For verification', 'No remarks', '[\"ec74459bdc61097d050c51a6fc4299ec.jpg\"]', 'For verification', 'No remarks', '', 'For verification', 'No remarks', 'b6ee0337aa2ba987f659b7cf70cc01ac.jpg', 'For verification', 'No remarks', 1, '2024-08-05 10:10 AM', 'Pending', 'Pending'),
(4, '$2y$10$h4Zfdm1dokh0NrkR2r47Du9enoQODDofan0Aa7pXn016g8bJD7CQ6', '', '08/12/2024 02:09 PM', 'Aiden', 'zach', 'O', '', '0948355670', 'zach@gmail.com', '', 22, '', 'Luisiana, Laguna', 'blue', 'Tricycle', '', 'Neo', 'Neozel', '1dfde560001d84f3f409f121ecf8dab1.jpg', 'For verification', 'No remarks', '23454c7735d92ec00175fe5c6efebc3b.jpg', 'For verification', 'No remarks', '4311c2d80999a00e86154d8f88e1279c.pdf', 'For verification', 'No remarks', 'd66805a059a28c9f52759687d1e38a06.jpg', 'For verification', 'No remarks', '', 'For verification', 'No remarks', '16074db7b38578bf591ee8f8977547c9.jpg', 'For verification', 'No remarks', '7bc8f065f6dbfc840dde2952adb6659d.jpg', 'For verification', 'No remarks', '4817ceccbb4c2f0e75f7cf4f1db60850.jpg', 'For verification', 'No remarks', '4b3d17f8f7203322028ea9deb49d9800.jpg', 'For verification', 'No remarks', '73b2f97eb8333de1bb6c6bf866249db4.jpg', 'For verification', 'No remarks', 'fce30a001df9a55b285dc65f2497a962.pdf', 'For verification', 'No remarks', '[\"a491be1023b94ecd97b106fcfe9b8594.jpg\"]', 'For verification', 'No remarks', '', 'For verification', 'No remarks', 'b56725427b16d73a7fc1bec2893c493c.jpg', 'For verification', 'No remarks', 0, NULL, 'Pending', 'Verified'),
(11, '$2y$10$u3fslrokBe4KbGJqr9RVBOFgtgJI9Ecuxeg9fUL/XARNTiudK9FdC', '', '08/12/2024 04:05 PM', 'Juan', 'Cruz', 'S', '', '0948355670', 'zachky@gmail.com', 'male', 0, '2024-08-09', 'Luisiana, Laguna', 'blue', 'Tricycle', 'ONGVILLE', 'Neo', 'Neozel', 'f2589bae7edc440a5659647b494a6ea1.jpg', 'For verification', 'No remarks', '5960f8afd3b8e416a5aefd8ec4dbf5d2.jpg', 'For verification', 'No remarks', '9fc18deb7d39ba66729d7c0da97aacba.pdf', 'For verification', 'No remarks', 'ce58035baf1c2cf6d0f76bbff656d685.jpg', 'For verification', 'No remarks', '', 'For verification', 'No remarks', 'bf7ff65318f3cbd01cd7b870cc0e72de.jpg', 'For verification', 'No remarks', '3df1193bcb6d2ddbc315ab06fb1d16f6.jpg', 'For verification', 'No remarks', '52baf4a4558011e1a48f1cc58f2e576f.jpg', 'For verification', 'No remarks', 'c16b2b345d9587f2b872a6471d0980de.pdf', 'For verification', 'No remarks', '8495ad5c1e4c7c299884ba8feeb1600e.jpg', 'For verification', 'No remarks', '91a2b810f27dd454f20ab9b97b2cf2b6.pdf', 'For verification', 'No remarks', '[\"456b8dd92fa8fe7e6d618dfa74098052.jpg\"]', 'For verification', 'No remarks', '', 'For verification', 'No remarks', 'a896885280bac5e5fa6988036829d8d1.jpg', 'For verification', 'No remarks', 0, NULL, 'Pending', 'Pending'),
(12, '$2y$10$OU/9q8p2mdXFcWHfQSSwFegNIaYT9SPs/XW9.6lyoGfbaFATiK8Aa', '', '08/12/2024 04:28 PM', 'Kat', 'ruiz', 'O', '', '09483556700', 'neo@gmail.com', 'female', 0, '2024-08-08', 'Luisiana, Laguna', 'blue', 'Tricycle', 'MMD', 'Juan', 'Pedro', '1a2124e65cc7f16a1cc866f2f321cbc7.jpg', 'Valid', '', 'add6e7899cfc29d60b43f6e3016730be.jpg', 'For verification', 'No remarks', 'b84cc3928a01d0bd610768c5ff6484a7.pdf', 'Invalid', 'cvfds', 'a6f56b63a6f61bcb7cdcf5724c70faad.jpg', 'Valid', '', '', 'For verification', 'No remarks', 'ba58e8c7cb38efe82a76777bfdd3d277.jpg', 'For Verification', '', 'bbb3f5bf1c05d2d4918455924d93742e.jpg', 'Valid', '', 'e63c899772c0059bd93f3356f0911c51.jpg', 'Valid', '', '22dbfcbbde6857cd9f40db9b9bace3a7.png', 'Valid', '', '24269327663da991e0787f0e72bc8ee1.jpg', 'Valid', '', '00871ab03e0aff27541374a45089d296.jpg', 'Valid', '', '[\"515459794096c4157b45ee76d2ad6e84.jpg\",\"c237fa73975b22bff417f663ef966ab9.jpg\"]', 'For Verification', '', '', 'For verification', 'No remarks', '72790d110d35e7c9f365fa790f890b7b.jpg', 'Valid', '', 0, '2024-08-13 01:25 PM', 'Pending', 'Pending'),
(17, '$2y$10$IsKlxb3lJBLgqRoop1VzDesytV2JnwhSI0DuODyYa.Abd37kZEMK.', '', '08/14/2024 11:36 PM', 'Neozel', 'oblepias', 'O', '', '09483556700', 'gases@educ.fan', 'Female', 21, '2024-09-07', 'San Buenaventura Luisiana, Laguna', 'blue', 'Tricycle', 'NAGSIMANO', 'asw', 'Ako', '6582449d43e33b2d344286b2045ccf25.jpg', 'For verification', 'No remarks', 'e52a6e667f4c9a54acb1e3be8a59d9a0.jpg', 'For verification', 'No remarks', 'd38bd4c6310d6d0667f1bf92b25d0c83.jpg', 'For verification', 'No remarks', 'd8171767b9b06f3106dae64fc046e7fb.jpg', 'For verification', 'No remarks', '', 'For verification', 'No remarks', '01a6a08d877854390707b4a4a565ae2c.png', 'For verification', 'No remarks', '38dda43f5ee79b7b9203fecd666afc7d.jpeg', 'For verification', 'No remarks', '21a525595e4fb003e08bc76f7dabe7c1.jpeg', 'For verification', 'No remarks', '0610527d87b766b22c51cdf52ed9ca8a.jpg', 'For verification', 'No remarks', 'f647459c915540b81e421d95588c81c1.jpg', 'For verification', 'No remarks', '29c9514aacf7183219d344f47feca43e.jpg', 'For verification', 'No remarks', '[\"84bcbe0bfaed07b0416d0ee61cfe3b99.png\",\"2e4ee3c162890fe2c4a56c8917f45537.jpeg\"]', 'For verification', 'No remarks', '', 'For verification', 'No remarks', '1f60fdb7fd5a0741f33e0d1b19bfb2a6.pdf', 'For verification', 'No remarks', 0, NULL, 'Pending', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `m_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactNum` varchar(100) NOT NULL,
  `dateOfincident` varchar(20) NOT NULL,
  `descOfincident` text NOT NULL,
  `TFno` int(20) DEFAULT NULL,
  `colorOftric` varchar(100) NOT NULL,
  `madeOf` varchar(100) NOT NULL,
  `descOfdriver` text NOT NULL,
  `evidence` varchar(100) NOT NULL,
  `dtOfcontact` varchar(100) NOT NULL,
  `complaintStatus` varchar(100) NOT NULL DEFAULT 'For Validation',
  `is_new` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `last_name`, `first_name`, `m_name`, `email`, `contactNum`, `dateOfincident`, `descOfincident`, `TFno`, `colorOftric`, `madeOf`, `descOfdriver`, `evidence`, `dtOfcontact`, `complaintStatus`, `is_new`) VALUES
(6, 'oble', 'Zach', '', 'oblepiasneozel@gmail.com', '09483556700', '2024-08-20 10:50 PM', 'high fare', 1212, 'green', 'tricycle', 'asasa', 'dc0c9cb24f81cde4d0fab144381d13f3.jpg', '2024-08-13 11:50 AM', 'Resolved', 0),
(8, 'Pedro', 'Neozel', '', 'noblepias24@gmail.com', '09483556700', '2024-08-14 10:30 AM', '', 2513, 'gray', 'Tricycle', '', 'daae14e18b318961b83f69b3399fe7bb.jpg', '2024-08-15 02:29 AM', 'For Validation', 0),
(9, 'Pedro', 'Jon', '', 'noblepias24@gmail.com', '09483556700', '2024-08-15 08:36 AM', 'high fare', 2566, 'red stainless', 'Tricycle', 'tall', 'd74f3367a6980bef2e98c47190c9bfdf.mp4', '2024-08-15 02:37 AM', 'For Validation', 0),
(11, 'Oblepias', 'mare', 'dfd', 'nsoblepias@gmailcom', '09483556700', '2024-08-15 10:02 AM', 'hbvjh', 2561, 'green', 'Tricycle', 'khvgjh', 'f8ce0ff2e3457a5a4f995463ab299e25.jpg', '2024-08-29 10:03 AM', 'For Validation', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feb_operators`
--

CREATE TABLE `feb_operators` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `driversPic` varchar(255) NOT NULL,
  `tricyclePics` text DEFAULT NULL,
  `applicationDate` varchar(255) NOT NULL,
  `expDate` varchar(100) NOT NULL,
  `dayBan` varchar(100) NOT NULL,
  `violations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`violations`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feb_operators`
--

INSERT INTO `feb_operators` (`id`, `first_name`, `email`, `driversPic`, `tricyclePics`, `applicationDate`, `expDate`, `dayBan`, `violations`) VALUES
(2692, 'Zach', 'noblepias2021@gmail.com', '3ed27a4407580b51dedf05f51feb25fa.jpg', 'null', '07/25/2024 11:19 AM', '28/02/2025', 'Tuesday', '[{\"id\":43,\"ticketNo\":5643,\"violationDate\":\"2024-07-31\",\"violationType\":\"reckless driving\",\"TFno\":2692,\"penaltyCharged\":200,\"penaltyStatus\":\"To be paid\",\"offenseType\":\"1st Offense\",\"enforcer\":\"asasa\"},{\"id\":44,\"ticketNo\":965,\"violationDate\":\"2024-08-01\",\"violationType\":\"reckless driving\",\"TFno\":2692,\"penaltyCharged\":200,\"penaltyStatus\":\"To be paid\",\"offenseType\":\"2nd Offense\",\"enforcer\":\"asasa\"},{\"id\":45,\"ticketNo\":4654,\"violationDate\":\"2024-08-22\",\"violationType\":\"reckless driving\",\"TFno\":2692,\"penaltyCharged\":200,\"penaltyStatus\":\"To be paid\",\"offenseType\":\"3rd Offense\",\"enforcer\":\"asasa\"}]'),
(2702, 'Neo', 'nsoblepias@gmailcom', '214854423fd859eecdbf5bd72875869c.jpg', '[\\\"56f277928a07a3b0dfff84f6b05e8ed3.jpg\\\",\\\"a0cfd8f5f7461162be195e869608045c.png\\\"]', '07/29/2024 03:54 PM', '28/02/2025', 'Tuesday', NULL),
(2732, 'Aiden', 'nsoblepias@gmailcom', '74846252bf435c1982eb5bc8ddc7728b.png', '[\\\"52971df551ea67adb3bd19978db43f95.png\\\",\\\"26032ce299c5665dfef99b293146d9e4.png\\\"]', '08/09/2024 02:50 PM', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jan_operators`
--

CREATE TABLE `jan_operators` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `driversPic` varchar(255) NOT NULL,
  `tricyclePics` text DEFAULT NULL,
  `applicationDate` varchar(255) NOT NULL,
  `expDate` varchar(100) NOT NULL,
  `dayBan` varchar(100) NOT NULL,
  `violations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`violations`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jan_operators`
--

INSERT INTO `jan_operators` (`id`, `first_name`, `email`, `driversPic`, `tricyclePics`, `applicationDate`, `expDate`, `dayBan`, `violations`) VALUES
(2761, 'Juan ', 'juan@gmail.com', '9525e54e5a03752a2a01a3473e32777d.jpg', 'null', '08/11/2024 05:08 PM', '14/01/2025', 'Monday', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `account_type` varchar(50) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `login_status` enum('success','failed') DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `username`, `email`, `account_type`, `ip_address`, `login_status`, `user_agent`, `login_time`) VALUES
(81, 4, 'Neozel', 'noblepias2021@gmail.com', '', '127.0.0.1', 'failed', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2024-08-16 05:51:47'),
(82, 4, 'Neozel', 'noblepias2021@gmail.com', '', '127.0.0.1', 'failed', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2024-08-16 05:51:50'),
(83, 4, 'Neozel', 'noblepias2021@gmail.com', '', '127.0.0.1', 'failed', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2024-08-16 05:51:56'),
(84, 4, 'Neozel', 'noblepias2021@gmail.com', '', '127.0.0.1', 'success', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2024-08-16 05:52:26'),
(85, 4, 'Neozel', 'Admin', 'noblepias2021@gmail.com', '127.0.0.1', 'success', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2024-08-16 05:59:34'),
(86, 4, 'Neozel', 'Admin', 'noblepias2021@gmail.com', '127.0.0.1', 'success', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2024-08-16 06:05:41'),
(87, 4, 'Neozel', 'Admin', 'noblepias2021@gmail.com', '127.0.0.1', 'success', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2024-08-16 09:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `march_operators`
--

CREATE TABLE `march_operators` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `driversPic` varchar(255) NOT NULL,
  `tricyclePics` text DEFAULT NULL,
  `applicationDate` varchar(255) NOT NULL,
  `expDate` varchar(100) NOT NULL,
  `dayBan` varchar(100) NOT NULL,
  `violations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`violations`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `march_operators`
--

INSERT INTO `march_operators` (`id`, `first_name`, `email`, `driversPic`, `tricyclePics`, `applicationDate`, `expDate`, `dayBan`, `violations`) VALUES
(2533, 'Aiden', 'oblepiasneozel@gmail.com', '5624764d17e496a03ac3221699201ad2.jpg', '', '08/07/2024 10:49 AM', '7/03/2025', 'Tuesday', NULL),
(2553, 'Aiden', 'noblepias2021@gmail.com', 'be9329b25bea223f5b3c6aecf7352fd3.jpg', '[\\\"3d738928ca4b6f0ea93328414d015e9b.jpg\\\",\\\"082208381042094e303c9e2504d5adf7.jpg\\\"]', '08/10/2024 03:10 PM', '14/03/2025', 'Tuesday', NULL),
(2563, 'neozel', 'oblepiasneozel@gmail.com', '15303faa4563c84432b674b3d53b6e47.jpg', '[\"e14c108807bbc1e8743770173b711cc9.png\"]', '08/11/2024 05:42 PM', '14/03/2025', 'Tuesday', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `seen` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `type`, `seen`, `created_at`) VALUES
(0, 'Applicant mare me successfully updated their files.', 'update', 1, '2024-07-24 11:04:38'),
(0, 'Applicant lolo me successfully updated their files.', 'update', 1, '2024-07-24 11:38:49'),
(0, 'Applicant lolo me successfully updated their files.', 'update', 1, '2024-07-24 11:39:17'),
(0, 'Applicant lolo me successfully updated their files.', 'update', 1, '2024-07-24 11:40:19'),
(0, 'Applicant lolo me successfully updated their files.', 'update', 1, '2024-07-24 12:45:31'),
(0, 'Applicant Neo Oblepias successfully updated their files.', 'update', 1, '2024-07-24 14:00:21'),
(0, 'Applicant Neo Oblepias successfully updated their files.', 'update', 1, '2024-07-24 14:01:15'),
(0, 'Applicant Neo Oblepias successfully updated their files.', 'update', 1, '2024-07-24 14:09:08'),
(0, 'Applicant lol Oblepias successfully updated their files.', 'update', 1, '2024-07-25 06:36:20'),
(0, 'Applicant lol Oblepias successfully updated their files.', 'update', 1, '2024-07-25 07:30:21'),
(0, 'Applicant lol Oblepias successfully updated their files.', 'update', 1, '2024-07-25 07:31:12'),
(0, 'Applicant lol Oblepias successfully updated their files.', 'update', 1, '2024-07-25 07:33:48'),
(0, 'Applicant lol Oblepias successfully updated their files.', 'update', 1, '2024-07-25 07:33:54'),
(0, 'Applicant lol Oblepias successfully updated their files.', 'update', 1, '2024-07-25 07:33:56'),
(0, 'Applicant lol Oblepias successfully updated their files.', 'update', 1, '2024-07-25 07:37:55'),
(0, 'Applicant s Neo successfully updated their files.', 'update', 1, '2024-07-25 07:39:57'),
(0, 'Applicant s Neo successfully updated their files.', 'update', 1, '2024-07-25 07:55:43'),
(0, 'Applicant s Neo successfully updated their files.', 'update', 1, '2024-07-25 08:17:13'),
(0, 'Applicant s Neo successfully updated their files.', 'update', 1, '2024-07-25 11:02:53'),
(0, 'Applicant Neozel  Oblepias successfully updated their files.', 'update', 1, '2024-08-09 06:40:59'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:08:16'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:08:31'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:08:48'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:09:02'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:09:43'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:09:56'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:10:12'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:10:26'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:10:39'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:10:48'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:10:56'),
(0, 'Applicant   successfully updated their files.', 'update', 1, '2024-08-13 15:13:04'),
(0, 'Applicant Jon Doe successfully updated their files.', 'update', 1, '2024-08-13 15:18:57'),
(0, 'Applicant Neozel oblepias successfully updated their files.', 'update', 1, '2024-08-15 01:39:26'),
(0, 'Applicant Aiden zach successfully updated their files.', 'update', 0, '2024-08-16 05:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `violations`
--

CREATE TABLE `violations` (
  `id` int(11) NOT NULL,
  `ticketNo` int(11) NOT NULL,
  `violationDate` date NOT NULL,
  `violationType` varchar(255) NOT NULL,
  `TFno` int(11) NOT NULL,
  `penaltyCharged` int(11) NOT NULL,
  `penaltyStatus` varchar(100) NOT NULL DEFAULT 'To be paid',
  `offenseType` varchar(100) NOT NULL,
  `enforcer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violations`
--

INSERT INTO `violations` (`id`, `ticketNo`, `violationDate`, `violationType`, `TFno`, `penaltyCharged`, `penaltyStatus`, `offenseType`, `enforcer`) VALUES
(38, 5, '2024-08-07', 'reckless driving', 2513, 400, 'To be paid', '2nd Offense', 'Ramil Fortus'),
(40, 632, '2024-08-07', 'reckless driving', 2731, 200, 'Paid', '1st Offense', 'asasa'),
(41, 655, '2024-08-08', 'reckless driving', 2523, 200, 'Paid', '1st Offense', 'asasa'),
(42, 699, '2024-08-07', 'reckless driving', 2523, 200, 'Paid', '2nd Offense', 'asasa'),
(43, 5643, '2024-07-31', 'reckless driving', 2692, 200, 'Paid', '1st Offense', 'asasa'),
(45, 4654, '2024-08-22', 'reckless driving', 2692, 200, 'Paid', '3rd Offense', 'asasa'),
(46, 654, '2024-08-02', 'high fare collection', 2722, 100, 'Paid', '1st Offense', 'Ramil Fortus'),
(49, 785, '2024-08-05', 'high fare collection', 2711, 100, 'Paid', '1st Offense', 'Ramil Fortus'),
(50, 2654, '2024-07-31', 'reckless dring', 2751, 200, 'Paid', '1st Offense', 'Ramil Fortus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feb_operators`
--
ALTER TABLE `feb_operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jan_operators`
--
ALTER TABLE `jan_operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `march_operators`
--
ALTER TABLE `march_operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `violations`
--
ALTER TABLE `violations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `violations`
--
ALTER TABLE `violations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
