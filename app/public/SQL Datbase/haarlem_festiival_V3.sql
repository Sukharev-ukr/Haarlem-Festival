-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 18, 2025 at 09:51 AM
-- Server version: 11.5.2-MariaDB-ubu2404
-- PHP Version: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `haarlem_festival_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `Albums`
--

CREATE TABLE `Albums` (
  `albumID` int(11) NOT NULL,
  `artistID` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Artist`
--

CREATE TABLE `Artist` (
  `artistID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `style` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `origin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Artist`
--

INSERT INTO `Artist` (`artistID`, `name`, `style`, `description`, `picture`, `origin`) VALUES
(1, 'Nicky Romero', 'Electrohouse And Progressive House', 'Nicky Romero, born January 6, 1989, in the Netherlands, is a renowned Dutch DJ, producer, and founder of Protocol Recordings. Known for hits like \"Toulouse\" and \"I Could Be the One\" (with Avicii), he is a key figure in electronic dance music, performing at major festivals like Tomorrowland. Romero is celebrated for his progressive house sound and contributions to the global EDM scene.', 'assets/imageArtits/NickyRomero.jpeg', 'Netherlands'),
(2, 'Afrojack', 'House', 'Afrojack, born Nick van de Wall on September 9, 1987, is a Dutch DJ, producer, and remixer. Known for hits like \"Take Over Control\", he helped shape EDM global popularity. A Grammy winner, he has collaborated with artists like David Guetta, Beyoncé, and Pitbull. Afrojack is celebrated for his energetic sets and unique production style, making him a key figure in electronic dance music.', 'assets/imageArtits/Afrojack.jpeg', 'Netherlands'),
(3, 'Tiësto', 'Trance-Techno-Minimal-House-Electro', 'Tijs Michiel Verwest OON (Dutch pronunciation: [ˈtɛis miˈxil vərˈʋɛst]; born 17 January 1969), known professionally as Tiësto (/tiˈɛstoʊ/ tee-EST-oh, Dutch: [ˈtɕɛstoː]), is a Dutch DJ and record producer. He was voted \"The Greatest DJ of All Time\" by Mix magazine in a 2010/2011 poll amongst fans.[5] In 2013, he was voted by DJ Mag readers as the \"best DJ of the last 20 years\".[6] He is also regarded as the \"Godfather of EDM\" by many sources.', 'assets/imageArtits/Tiesto.webp', 'Netherlands'),
(4, 'Martin Garrix', 'Dance-Electronic', 'Martin Garrix, born Martijn Gerard Garritsen on May 14, 1996, in Amstelveen, the Netherlands, is a celebrated DJ, record producer, and entrepreneur in the electronic dance music (EDM) scene. He burst onto the global stage in 2013 with the release of “Animals,” a track that became a dancefloor staple and catapulted him to international fame. Known for his signature energetic style and melodic hooks, Garrix has since collaborated with a wide range of artists, including Bebe Rexha', 'assets/imageArtits/MarinGarrix.jpeg', 'Netherlands'),
(5, 'Armin van Buuren', 'Trance-Techno', 'Armin van Buuren, born on December 25, 1976, in Leiden, the Netherlands, is a world-renowned DJ and music producer celebrated for his influential role in the trance music scene. He has hosted the weekly radio show A State of Trance (ASOT) for over two decades, uniting fans across the globe and shaping the genre’s evolution. Widely recognized for his uplifting beats and dynamic performances.', 'assets/imageArtits/Armin.jpeg', 'Netherlands'),
(6, 'Hardwell', 'Dance-House', 'Hardwell, born Robbert van de Corput, is a Dutch DJ and producer renowned for his adrenaline-pumping big room house sound and energetic festival performances. Hailing from Breda in the Netherlands, he first gained global attention through successful tracks like “Spaceman” and collaborations such as “Never Say Goodbye” with Dyro. In 2013 and 2014, he was crowned the world’s No. 1 DJ by DJ Mag—recognition that confirmed his status as a major force in electronic dance music.', 'assets/imageArtits/HardWell.jpeg', 'Netherlands');

-- --------------------------------------------------------

--
-- Table structure for table `Dance`
--

CREATE TABLE `Dance` (
  `danceID` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `danceCapacity` int(11) NOT NULL,
  `duration` time NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `danceDate` date NOT NULL,
  `day` enum('Friday','Saturday','Sunday') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Dance`
--

INSERT INTO `Dance` (`danceID`, `location`, `danceCapacity`, `duration`, `startTime`, `endTime`, `danceDate`, `day`) VALUES
(1, 'Lichfabriek', 1500, '06:00:00', '20:00:00', '03:00:00', '2025-07-25', 'Friday'),
(2, 'Slachthuis', 200, '01:30:00', '22:00:00', '23:30:00', '2025-07-25', 'Friday'),
(3, 'Jopenkerk', 300, '01:30:00', '23:00:00', '12:30:00', '2025-07-25', 'Friday'),
(4, 'XO the Club', 200, '01:30:00', '22:00:00', '23:30:00', '2025-07-25', 'Friday'),
(5, 'Puncher comedy club', 200, '01:30:00', '22:00:00', '23:30:00', '2025-07-25', 'Friday'),
(6, 'Caprera Openluchttheater', 2000, '09:00:00', '14:00:00', '23:00:00', '2025-07-26', 'Saturday'),
(7, 'Jopenkerk', 300, '01:30:00', '22:00:00', '23:30:00', '2025-07-26', 'Saturday'),
(8, 'Lichtfabriek', 1500, '04:00:00', '21:00:00', '01:00:00', '2025-07-26', 'Saturday'),
(9, 'Slachthuis', 200, '01:30:00', '23:00:00', '12:30:00', '2025-07-26', 'Saturday'),
(10, 'Caprera Openluchttheater', 2000, '09:00:00', '14:00:00', '23:00:00', '2025-07-27', 'Sunday'),
(11, 'Jopenkerk', 300, '01:30:00', '19:00:00', '20:30:00', '2025-07-27', 'Sunday'),
(12, 'XO the Club', 1500, '01:30:00', '21:00:00', '22:30:00', '2025-07-27', 'Sunday'),
(13, 'Slachthuis', 200, '01:30:00', '18:00:00', '19:30:00', '2025-07-27', 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `DanceArtist`
--

CREATE TABLE `DanceArtist` (
  `danceID` int(11) NOT NULL,
  `artistID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `DanceArtist`
--

INSERT INTO `DanceArtist` (`danceID`, `artistID`) VALUES
(1, 1),
(9, 1),
(10, 1),
(1, 2),
(7, 2),
(10, 2),
(2, 3),
(8, 3),
(10, 3),
(5, 4),
(6, 4),
(13, 4),
(4, 5),
(6, 5),
(11, 5),
(3, 6),
(6, 6),
(12, 6);

-- --------------------------------------------------------

--
-- Table structure for table `DanceTicket`
--

CREATE TABLE `DanceTicket` (
  `danceTicketID` int(11) NOT NULL,
  `danceTicketOrderID` int(11) NOT NULL,
  `ticketTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DanceTicketOrder`
--

CREATE TABLE `DanceTicketOrder` (
  `DanceTicketOrderID` int(11) NOT NULL,
  `orderItemID` int(11) NOT NULL,
  `ticketQuantity` int(11) DEFAULT 1,
  `totalPrice` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTour`
--

CREATE TABLE `HistoryTour` (
  `historyTourID` int(11) NOT NULL,
  `orderItemID` int(11) DEFAULT NULL,
  `historyLocation` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `language` enum('Chinese','English','Dutch') DEFAULT 'English',
  `duration` time DEFAULT NULL,
  `maxParticipants` int(11) DEFAULT 12,
  `minParticipants` int(11) DEFAULT 1,
  `priceRegular` double DEFAULT 17.5,
  `priceFamily` double DEFAULT 80
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTourReservation`
--

CREATE TABLE `HistoryTourReservation` (
  `reservationID` int(11) NOT NULL,
  `sessionID` int(11) NOT NULL,
  `orderItemID` int(11) DEFAULT NULL,
  `numParticipants` int(11) DEFAULT 1,
  `price` double DEFAULT 0,
  `availableSpots` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTourSession`
--

CREATE TABLE `HistoryTourSession` (
  `sessionID` int(11) NOT NULL,
  `historyTourID` int(11) NOT NULL,
  `startTime` datetime DEFAULT NULL,
  `language` enum('Chinese','English','Dutch') DEFAULT 'English',
  `duration` time DEFAULT NULL,
  `maxParticipants` int(11) DEFAULT 12
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE `Order` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `orderDate` date DEFAULT NULL,
  `status` enum('paid','unpaid') DEFAULT 'unpaid',
  `total` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OrderItem`
--

CREATE TABLE `OrderItem` (
  `orderItemID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `price` double DEFAULT 0,
  `bookingType` enum('History','Restaurant','Dance') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PersonalProgram`
--

CREATE TABLE `PersonalProgram` (
  `programID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `programName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PersonalProgramItem`
--

CREATE TABLE `PersonalProgramItem` (
  `programItemID` int(11) NOT NULL,
  `programID` int(11) NOT NULL,
  `orderItemID` int(11) DEFAULT NULL,
  `itemType` enum('Dance','History','Restaurant') NOT NULL,
  `reservationID` int(11) DEFAULT NULL,
  `sessionTime` enum('Morning','Afternoon','Evening') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `reservationID` int(11) NOT NULL,
  `restaurantID` int(11) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `reservationDate` date DEFAULT NULL,
  `specialRequests` varchar(255) DEFAULT NULL,
  `amountAdults` int(11) DEFAULT 0,
  `amountChildren` int(11) DEFAULT 0,
  `reservationFee` double DEFAULT 10,
  `orderItemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ReservationSlot`
--

CREATE TABLE `ReservationSlot` (
  `reservationSlotID` int(11) NOT NULL,
  `slotID` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Restaurant`
--

CREATE TABLE `Restaurant` (
  `restaurantID` int(11) NOT NULL,
  `restaurantName` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `cuisine` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `pricePerAdult` double DEFAULT 0,
  `pricePerChild` double DEFAULT 0,
  `latitude` decimal(10,6) NOT NULL DEFAULT 52.387400,
  `longitude` decimal(10,6) NOT NULL DEFAULT 4.646200,
  `distance_from_patronaat` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Restaurant`
--

INSERT INTO `Restaurant` (`restaurantID`, `restaurantName`, `address`, `phone`, `cuisine`, `description`, `stars`, `pricePerAdult`, `pricePerChild`, `latitude`, `longitude`, `distance_from_patronaat`) VALUES
(1, 'Café de Roemer', 'Botermarkt 17, 2011 XL Haarlem, Nederland', NULL, 'Dutch, Fish and Seafood, European', NULL, 4, 35, 17.5, 52.379887, 4.631878, 550),
(2, 'Ratatouille', 'Spaarne 96, 2011 CL Haarlem, Nederland', NULL, 'French, Fish and Seafood, European', NULL, 4, 45, 22.5, 52.378826, 4.637459, 950),
(3, 'Restaurant ML', 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', NULL, 'Dutch, Fish and Seafood, European', NULL, 4, 45, 22.5, 52.380813, 4.638327, 850),
(4, 'Restaurant Fris', 'Twijnderslaan 7, 2012 BG Haarlem, Nederland', NULL, 'Dutch, French, European', NULL, 4, 45, 22.5, 52.372477, 4.634248, 1500),
(5, 'New Vegas', 'Koningstraat 5, 2011 TB Haarlem, Nederland', NULL, 'Vegan', NULL, 3, 35, 17.5, 52.381208, 4.634921, 550),
(6, 'Grand Cafe Brinkman', 'Grote Markt 13, 2011 RC Haarlem, Nederland', NULL, 'Dutch, European, Modern', NULL, 3, 35, 17.5, 52.381788, 4.636139, 600),
(7, 'Urban Frenchy Bistro Toujours', 'Oude Groenmarkt 10-12, 2011 HL Haarlem, Nederland', NULL, 'Dutch, Fish and Seafood, European', NULL, 3, 35, 17.5, 52.380749, 4.637130, 750);

-- --------------------------------------------------------

--
-- Table structure for table `RestaurantSlot`
--

CREATE TABLE `RestaurantSlot` (
  `slotID` int(11) NOT NULL,
  `startTime` date DEFAULT NULL,
  `endTime` date DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TicketType`
--

CREATE TABLE `TicketType` (
  `ticketTypeID` int(11) NOT NULL,
  `type` enum('Regular','All Access Friday','All Access Saturday','All Access Sunday','All Access All Days') DEFAULT NULL,
  `price` double NOT NULL,
  `danceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `TicketType`
--

INSERT INTO `TicketType` (`ticketTypeID`, `type`, `price`, `danceID`) VALUES
(10, 'Regular', 75, 1),
(11, 'All Access Friday', 125, 1),
(12, 'All Access All Days', 250, 1),
(13, 'Regular', 60, 2),
(14, 'All Access Friday', 125, 2),
(15, 'All Access All Days', 250, 2),
(16, 'Regular', 60, 3),
(17, 'All Access Friday', 125, 3),
(18, 'All Access All Days', 250, 3),
(19, 'Regular', 60, 4),
(20, 'All Access Friday', 125, 4),
(21, 'All Access All Days', 250, 4),
(22, 'Regular', 60, 5),
(23, 'All Access Friday', 125, 5),
(24, 'All Access All Days', 250, 5),
(25, 'Regular', 110, 6),
(26, 'All Access Saturday', 150, 6),
(27, 'All Access All Days', 250, 6),
(28, 'Regular', 60, 7),
(29, 'All Access Saturday', 150, 7),
(30, 'All Access All Days', 250, 7),
(31, 'Regular', 75, 7),
(32, 'All Access Saturday', 150, 7),
(33, 'All Access All Days', 250, 7),
(34, 'Regular', 75, 8),
(35, 'All Access Saturday', 150, 8),
(36, 'All Access All Days', 250, 8),
(37, 'Regular', 60, 9),
(38, 'All Access Saturday', 150, 9),
(39, 'All Access All Days', 250, 9),
(40, 'Regular', 110, 10),
(41, 'All Access Sunday', 150, 10),
(42, 'All Access All Days', 250, 10),
(43, 'Regular', 60, 11),
(44, 'All Access Sunday', 150, 11),
(45, 'All Access All Days', 250, 11),
(46, 'Regular', 90, 12),
(47, 'All Access Sunday', 150, 12),
(48, 'All Access All Days', 250, 12),
(49, 'Regular', 60, 13),
(50, 'All Access Sunday', 150, 13),
(51, 'All Access All Days', 250, 13);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mobilePhone` int(11) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `role` enum('Admin','User') DEFAULT 'User',
  `registered_day` timestamp NULL DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `userName`, `password`, `mobilePhone`, `Email`, `role`, `registered_day`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Alice Johnson', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 641653766, 'alice.johnson@example.com', 'User', '2025-03-16 09:21:44', NULL, NULL),
(2, 'Robben', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 939441810, 'robben@gmail.com', 'User', '2025-03-16 09:28:45', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Albums`
--
ALTER TABLE `Albums`
  ADD PRIMARY KEY (`albumID`),
  ADD KEY `artistID` (`artistID`);

--
-- Indexes for table `Artist`
--
ALTER TABLE `Artist`
  ADD PRIMARY KEY (`artistID`);

--
-- Indexes for table `Dance`
--
ALTER TABLE `Dance`
  ADD PRIMARY KEY (`danceID`);

--
-- Indexes for table `DanceArtist`
--
ALTER TABLE `DanceArtist`
  ADD PRIMARY KEY (`danceID`,`artistID`),
  ADD KEY `artistID` (`artistID`);

--
-- Indexes for table `DanceTicket`
--
ALTER TABLE `DanceTicket`
  ADD PRIMARY KEY (`danceTicketID`),
  ADD KEY `fk_danceticketorder` (`danceTicketOrderID`),
  ADD KEY `fk_ticketType` (`ticketTypeID`);

--
-- Indexes for table `DanceTicketOrder`
--
ALTER TABLE `DanceTicketOrder`
  ADD PRIMARY KEY (`DanceTicketOrderID`,`orderItemID`),
  ADD KEY `FK_DanceTicketOrder_OrderItem` (`orderItemID`);

--
-- Indexes for table `HistoryTour`
--
ALTER TABLE `HistoryTour`
  ADD PRIMARY KEY (`historyTourID`);

--
-- Indexes for table `HistoryTourReservation`
--
ALTER TABLE `HistoryTourReservation`
  ADD PRIMARY KEY (`reservationID`,`sessionID`),
  ADD KEY `FK_HistoryTourReservation_Session` (`sessionID`),
  ADD KEY `FK_HistoryTourReservation_OrderItem` (`orderItemID`);

--
-- Indexes for table `HistoryTourSession`
--
ALTER TABLE `HistoryTourSession`
  ADD PRIMARY KEY (`sessionID`),
  ADD KEY `FK_HistoryTourSession_Tour` (`historyTourID`);

--
-- Indexes for table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FK_Order_User` (`userID`);

--
-- Indexes for table `OrderItem`
--
ALTER TABLE `OrderItem`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `FK_OrderItem_Order` (`orderID`);

--
-- Indexes for table `PersonalProgram`
--
ALTER TABLE `PersonalProgram`
  ADD PRIMARY KEY (`programID`),
  ADD KEY `FK_PersonalProgram_User` (`userID`);

--
-- Indexes for table `PersonalProgramItem`
--
ALTER TABLE `PersonalProgramItem`
  ADD PRIMARY KEY (`programItemID`),
  ADD KEY `FK_PPItem_Program` (`programID`),
  ADD KEY `FK_PPItem_OrderItem` (`orderItemID`),
  ADD KEY `FK_PPItem_Reservation` (`reservationID`);

--
-- Indexes for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`reservationID`),
  ADD KEY `FK_Reservation_Restaurant` (`restaurantID`),
  ADD KEY `fk_reservation_orderItem` (`orderItemID`);

--
-- Indexes for table `ReservationSlot`
--
ALTER TABLE `ReservationSlot`
  ADD PRIMARY KEY (`reservationSlotID`),
  ADD KEY `FK_ReservationSlot_Slot` (`slotID`),
  ADD KEY `FK_ReservationSlot_Reservation` (`reservationID`);

--
-- Indexes for table `Restaurant`
--
ALTER TABLE `Restaurant`
  ADD PRIMARY KEY (`restaurantID`);

--
-- Indexes for table `RestaurantSlot`
--
ALTER TABLE `RestaurantSlot`
  ADD PRIMARY KEY (`slotID`);

--
-- Indexes for table `TicketType`
--
ALTER TABLE `TicketType`
  ADD PRIMARY KEY (`ticketTypeID`),
  ADD KEY `danceID` (`danceID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Albums`
--
ALTER TABLE `Albums`
  MODIFY `albumID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Artist`
--
ALTER TABLE `Artist`
  MODIFY `artistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Dance`
--
ALTER TABLE `Dance`
  MODIFY `danceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `DanceTicket`
--
ALTER TABLE `DanceTicket`
  MODIFY `danceTicketID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `HistoryTour`
--
ALTER TABLE `HistoryTour`
  MODIFY `historyTourID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `HistoryTourSession`
--
ALTER TABLE `HistoryTourSession`
  MODIFY `sessionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Order`
--
ALTER TABLE `Order`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OrderItem`
--
ALTER TABLE `OrderItem`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PersonalProgram`
--
ALTER TABLE `PersonalProgram`
  MODIFY `programID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PersonalProgramItem`
--
ALTER TABLE `PersonalProgramItem`
  MODIFY `programItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `reservationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ReservationSlot`
--
ALTER TABLE `ReservationSlot`
  MODIFY `reservationSlotID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Restaurant`
--
ALTER TABLE `Restaurant`
  MODIFY `restaurantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `RestaurantSlot`
--
ALTER TABLE `RestaurantSlot`
  MODIFY `slotID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TicketType`
--
ALTER TABLE `TicketType`
  MODIFY `ticketTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Albums`
--
ALTER TABLE `Albums`
  ADD CONSTRAINT `Albums_ibfk_1` FOREIGN KEY (`artistID`) REFERENCES `Artist` (`artistID`) ON DELETE CASCADE;

--
-- Constraints for table `DanceArtist`
--
ALTER TABLE `DanceArtist`
  ADD CONSTRAINT `DanceArtist_ibfk_1` FOREIGN KEY (`danceID`) REFERENCES `Dance` (`danceID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `DanceArtist_ibfk_2` FOREIGN KEY (`artistID`) REFERENCES `Artist` (`artistID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `DanceTicket`
--
ALTER TABLE `DanceTicket`
  ADD CONSTRAINT `fk_danceticketorder` FOREIGN KEY (`danceTicketOrderID`) REFERENCES `DanceTicketOrder` (`DanceTicketOrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ticketType` FOREIGN KEY (`ticketTypeID`) REFERENCES `TicketType` (`ticketTypeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `DanceTicketOrder`
--
ALTER TABLE `DanceTicketOrder`
  ADD CONSTRAINT `FK_DanceTicketOrder_DanceTicket` FOREIGN KEY (`DanceTicketOrderID`) REFERENCES `DanceTicket` (`danceTicketID`),
  ADD CONSTRAINT `FK_DanceTicketOrder_OrderItem` FOREIGN KEY (`orderItemID`) REFERENCES `OrderItem` (`orderItemID`);

--
-- Constraints for table `HistoryTourReservation`
--
ALTER TABLE `HistoryTourReservation`
  ADD CONSTRAINT `FK_HistoryTourReservation_OrderItem` FOREIGN KEY (`orderItemID`) REFERENCES `OrderItem` (`orderItemID`),
  ADD CONSTRAINT `FK_HistoryTourReservation_Reservation` FOREIGN KEY (`reservationID`) REFERENCES `Reservation` (`reservationID`),
  ADD CONSTRAINT `FK_HistoryTourReservation_Session` FOREIGN KEY (`sessionID`) REFERENCES `HistoryTourSession` (`sessionID`);

--
-- Constraints for table `HistoryTourSession`
--
ALTER TABLE `HistoryTourSession`
  ADD CONSTRAINT `FK_HistoryTourSession_Tour` FOREIGN KEY (`historyTourID`) REFERENCES `HistoryTour` (`historyTourID`);

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `FK_Order_User` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`);

--
-- Constraints for table `OrderItem`
--
ALTER TABLE `OrderItem`
  ADD CONSTRAINT `FK_OrderItem_Order` FOREIGN KEY (`orderID`) REFERENCES `Order` (`orderID`);

--
-- Constraints for table `PersonalProgram`
--
ALTER TABLE `PersonalProgram`
  ADD CONSTRAINT `FK_PersonalProgram_User` FOREIGN KEY (`userID`) REFERENCES `User` (`userID`);

--
-- Constraints for table `PersonalProgramItem`
--
ALTER TABLE `PersonalProgramItem`
  ADD CONSTRAINT `FK_PPItem_OrderItem` FOREIGN KEY (`orderItemID`) REFERENCES `OrderItem` (`orderItemID`),
  ADD CONSTRAINT `FK_PPItem_Program` FOREIGN KEY (`programID`) REFERENCES `PersonalProgram` (`programID`),
  ADD CONSTRAINT `FK_PPItem_Reservation` FOREIGN KEY (`reservationID`) REFERENCES `Reservation` (`reservationID`);

--
-- Constraints for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `FK_Reservation_Restaurant` FOREIGN KEY (`restaurantID`) REFERENCES `Restaurant` (`restaurantID`),
  ADD CONSTRAINT `fk_reservation_orderItem` FOREIGN KEY (`orderItemID`) REFERENCES `OrderItem` (`orderItemID`) ON DELETE CASCADE;

--
-- Constraints for table `ReservationSlot`
--
ALTER TABLE `ReservationSlot`
  ADD CONSTRAINT `FK_ReservationSlot_Reservation` FOREIGN KEY (`reservationID`) REFERENCES `Reservation` (`reservationID`),
  ADD CONSTRAINT `FK_ReservationSlot_Slot` FOREIGN KEY (`slotID`) REFERENCES `RestaurantSlot` (`slotID`);

--
-- Constraints for table `TicketType`
--
ALTER TABLE `TicketType`
  ADD CONSTRAINT `TicketType_ibfk_1` FOREIGN KEY (`danceID`) REFERENCES `Dance` (`danceID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
