-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 08, 2025 at 01:41 PM
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

--
-- Dumping data for table `Albums`
--

INSERT INTO `Albums` (`albumID`, `artistID`, `title`) VALUES
(1, 1, 'Nicky Romero Presents: Protocol ADE 2015'),
(2, 2, ' Forget the World (2014)'),
(3, 3, 'Drive'),
(4, 4, 'Gold Skies (2014)'),
(5, 5, ' Imagine (2008)'),
(6, 6, 'United We Are Remixed (2015');

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
(1, 'Nicky Romero', 'Electrohouse And Progressive House', '<div>Nicky Romero, born January 6, 1989, in the Netherlands, is a renowned Dutch DJ, producer, and founder of Protocol Recordings. Known for hits like \"Toulouse\" and \"I Could Be the One\" (with Avicii), he is a key figure in electronic dance music, performing at major festivals like Tomorrowland. Romero is celebrated for his progressive house sound and contributions to the global EDM scene.</div>', '/assets/imageArtits/artist_67e9ab3d39506.jpeg', 'Netherlands'),
(2, 'Afrojack', 'House', '<div>Afrojack, born Nick van de Wall on September 9, 1987, is a Dutch DJ, producer, and remixer. Known for hits like \"Take Over Control\", he helped shape EDM global popularity. A Grammy winner, he has collaborated with artists like David Guetta, Beyoncé, and Pitbull. Afrojack is celebrated for his energetic sets and unique production style, making him a key figure in electronic dance music.</div>', '/assets/imageArtits/artist_67e9ac576363f.jpeg', 'Netherlands'),
(3, 'Tiësto', 'Trance-Techno-Minimal-House-Electro', '<div>Tijs Michiel Verwest OON (Dutch pronunciation: [ˈtɛis miˈxil vərˈʋɛst]; born 17 January 1969), known professionally as Tiësto (/tiˈɛstoʊ/ tee-EST-oh, Dutch: [ˈtɕɛstoː]), is a Dutch DJ and record producer. He was voted \"The Greatest DJ of All Time\" by Mix magazine in a 2010/2011 poll amongst fans.[5] In 2013, he was voted by DJ Mag readers as the \"best DJ of the last 20 years\".[6] He is also regarded as the \"Godfather of EDM\" by many sources.</div>', '/assets/imageArtits/artist_67e9a804407ba.jpeg', 'Netherlands'),
(4, 'Martin Garrix', 'Dance-Electronic', '<div>Martin Garrix, born Martijn Gerard Garritsen on May 14, 1996, in Amstelveen, the Netherlands, is a celebrated DJ, record producer, and entrepreneur in the electronic dance music (EDM) scene. He burst onto the global stage in 2013 with the release of “Animals,” a track that became a dancefloor staple and catapulted him to international fame. Known for his signature energetic style and melodic hooks, Garrix has since collaborated with a wide range of artists, including Bebe Rexha</div>', '/assets/imageArtits/artist_67e9a81566b6f.jpeg', 'Netherlands'),
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
(1, '<div>Lichfabriek</div>', 1500, '06:00:00', '20:00:00', '03:00:00', '2025-07-25', 'Friday'),
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

--
-- Dumping data for table `DanceTicket`
--

INSERT INTO `DanceTicket` (`danceTicketID`, `danceTicketOrderID`, `ticketTypeID`) VALUES
(1, 1, 10),
(2, 2, 10),
(3, 3, 10),
(4, 4, 11),
(5, 5, 10),
(6, 6, 10),
(7, 7, 10),
(8, 8, 10);

-- --------------------------------------------------------

--
-- Table structure for table `DanceTicketOrder`
--

CREATE TABLE `DanceTicketOrder` (
  `DanceTicketOrderID` int(11) NOT NULL,
  `orderItemID` int(11) NOT NULL,
  `ticketQuantity` int(11) DEFAULT 1,
  `totalPrice` double DEFAULT 0,
  `status` enum('unused','used') DEFAULT 'unused'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

ALTER TABLE Order
MODIFY status ENUM('paid', 'unpaid', 'pending') NOT NULL DEFAULT 'unpaid';
--
-- Dumping data for table `DanceTicketOrder`
--

INSERT INTO `DanceTicketOrder` (`DanceTicketOrderID`, `orderItemID`, `ticketQuantity`, `totalPrice`, `status`) VALUES
(1, 1, 2, 150, 'unused'),
(2, 2, 1, 75, 'unused'),
(3, 3, 1, 75, 'unused'),
(4, 4, 1, 125, 'unused'),
(5, 5, 1, 75, 'unused'),
(6, 9, 1, 75, 'unused'),
(7, 11, 1, 75, 'unused'),
(8, 12, 1, 75, 'unused');

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTour`
--
CREATE TABLE Lorentz (
  lorentzID INT AUTO_INCREMENT PRIMARY KEY,
  picturePath VARCHAR(255) NOT NULL,
  gameDescription TEXT NOT NULL
);
INSERT INTO Lorentz (picturePath, gameDescription)
VALUES 
(
  'assets/img/lorentz/phone.jpg',
  'An exciting app that brings a world of creativity and entertainment to kids. Dive into interactive games, explore creative workshops, and embark on thrilling challenges. The Festival app is designed to ignite the imagination and keep kids engaged for hours.'
);


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
-- Table structure for table `Lorentz`
--

CREATE TABLE `Lorentz` (
  `lorentzID` int(11) NOT NULL,
  `picturePath` varchar(255) NOT NULL,
  `gameDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Lorentz`
--

INSERT INTO `Lorentz` (`lorentzID`, `picturePath`, `gameDescription`) VALUES
(1, 'assets/img/lorentz/phone.jpg', 'An exciting app that brings a world of creativity and entertainment to kids. Dive into interactive games, explore creative workshops, and embark on thrilling challenges. The Festival app is designed to ignite the imagination and keep kids engaged for hours.');

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

--
-- Dumping data for table `Order`
--

INSERT INTO `Order` (`orderID`, `userID`, `orderDate`, `status`, `total`) VALUES
(1, 1, '2025-03-25', 'unpaid', 0),
(2, 3, '2025-03-25', 'paid', 0),
(3, 4, '2025-03-26', 'unpaid', 0),
(4, 3, '2025-03-31', 'paid', 99.99),
(5, 3, '2025-03-31', 'unpaid', 0);

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

--
-- Dumping data for table `OrderItem`
--

INSERT INTO `OrderItem` (`orderItemID`, `orderID`, `price`, `bookingType`) VALUES
(1, 1, 150, 'Dance'),
(2, 2, 75, 'Dance'),
(3, 2, 75, 'Dance'),
(4, 2, 125, 'Dance'),
(5, 2, 75, 'Dance'),
(8, 2, 117.5, 'Restaurant'),
(9, 2, 75, 'Dance'),
(11, 3, 75, 'Dance'),
(12, 2, 75, 'Dance');

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `paymentID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `paymentDate` datetime NOT NULL,
  `amount` double NOT NULL,
  `paymentMethod` enum('CreditCard','iDEAL','PayPal','Cash') NOT NULL,
  `paymentStatus` enum('Successful','Failed','Pending') NOT NULL,
  `transactionID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_users`
--

CREATE TABLE `pending_users` (
  `pending_id` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `mobilePhone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'User',
  `verify_token` varchar(64) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `pending_users`
--

INSERT INTO `pending_users` (`pending_id`, `userName`, `mobilePhone`, `email`, `password`, `role`, `verify_token`, `created_at`) VALUES
(2, 'RobbenLe', '0641653777', 'lehungrobben18@gmail.com', '$2y$12$M4ukYeyZmJpEh5NGa2E4euo1ORYgS0IzpslQjyRsjeeHOikN7klyq', 'User', '80a614d4c576748e00e4c4b3411db18f', '2025-03-25 08:42:07'),
(3, 'test1', '0641653777', '707875@student.inholland.nl', '$2y$12$XZr5WBG/b8qgezWeT8OQJemDeyc0TJ85CeXsFEqjLxVrsstiBmDxC', 'User', '294179b568e2f214e0dde13ed74d2ba8', '2025-03-25 11:52:38'),
(4, 'Alex', '123232433535', 'lehungrobben1811@gmail.com', '$2y$12$6kmiuEU58/SNje7ZQh8a3.TzRqksmCQWXcodZSuiZ5aWjmLm2UgfG', 'User', '89909ebd52b9e172b19eb26f4342c092', '2025-03-26 12:34:21');

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

--
-- Dumping data for table `Reservation`
--

INSERT INTO `Reservation` (`reservationID`, `restaurantID`, `status`, `reservationDate`, `specialRequests`, `amountAdults`, `amountChildren`, `reservationFee`, `orderItemID`) VALUES
(1, 1, 'Pending', '2025-03-25', '', 2, 1, 30, 6),
(2, 1, 'Pending', '2025-03-25', '', 1, 2, 30, 7),
(3, 1, 'Pending', '2025-03-25', '', 2, 1, 30, 8),
(4, 1, 'Pending', '2025-03-25', '', 1, 2, 30, 10);

-- --------------------------------------------------------

--
-- Table structure for table `ReservationSlot`
--

CREATE TABLE `ReservationSlot` (
  `reservationSlotID` int(11) NOT NULL,
  `slotID` int(11) NOT NULL,
  `reservationID` int(11) NOT NULL,
  `reservedSeats` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `ReservationSlot`
--

INSERT INTO `ReservationSlot` (`reservationSlotID`, `slotID`, `reservationID`, `reservedSeats`) VALUES
(1, 1, 1, 0),
(2, 2, 2, 0),
(3, 1, 3, 0),
(4, 2, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Restaurant`
--

CREATE TABLE `Restaurant` (
  `restaurantID` int(11) NOT NULL,
  `restaurantName` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `cuisine` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `pricePerAdult` double DEFAULT 0,
  `pricePerChild` double DEFAULT 0,
  `latitude` decimal(10,6) NOT NULL DEFAULT 52.387400,
  `longitude` decimal(10,6) NOT NULL DEFAULT 4.646200,
  `distance_from_patronaat` double NOT NULL DEFAULT 0,
  `restaurantPicture` varchar(255) DEFAULT NULL,
  `restaurantDiningDetailPicture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Restaurant`
--

INSERT INTO `Restaurant` (`restaurantID`, `restaurantName`, `address`, `phone`, `cuisine`, `description`, `stars`, `pricePerAdult`, `pricePerChild`, `latitude`, `longitude`, `distance_from_patronaat`, `restaurantPicture`, `restaurantDiningDetailPicture`) VALUES
(1, 'Café de Roemer', 'Botermarkt 17, 2011 XL Haarlem, Nederland', NULL, 'Dutch, Fish and Seafood, European', 'Café de Roemer is a cozy café in Haarlem, offering a warm atmosphere and friendly service. It\'s a popular spot among locals, especially on weekends when the nearby market is bustling.', 4, 35, 17.5, 52.379887, 4.631878, 550, '/assets/img/dining/café_de_roemer.jpeg', '/assets/img/diningdetails/banner_cafe_de_roemer.jpg'),
(2, 'Ratatouille', 'Spaarne 96, 2011 CL Haarlem, Nederland', NULL, 'French, Fish and Seafood, European', 'Ratatouille Food & Wine offers a culinary adventure where classic flavors are reimagined with exciting twists. Chef Jozua Jaring\'s meticulous presentation and innovative techniques provide diners with a \"wow\" factor in every dish.', 4, 45, 22.5, 52.378826, 4.637459, 950, '/assets/img/dining/ratatouille.jpeg', '/assets/img/diningdetails/banner_ratatouille.jpg'),
(3, 'Restaurant ML', 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', NULL, 'Dutch, Fish and Seafood, European', 'Restaurant ML is known for its creative cuisine, blending traditional techniques with modern flavors. The establishment offers a sophisticated dining experience in the heart of Haarlem.', 4, 45, 22.5, 52.380813, 4.638327, 850, '/assets/img/dining/restaurant_ml.jpg', '/assets/img/diningdetails/banner_restaurant_ml.jpg'),
(4, 'Restaurant Fris', 'Twijnderslaan 7, 2012 BG Haarlem, Nederland', NULL, 'Dutch, French, European', 'At Restaurant Fris, French and Asian culinary worlds meet. Dishes like sea bass terrine and veal sweetbreads are prepared with classic techniques and top-quality ingredients, offering playful originality.', 4, 45, 22.5, 52.372477, 4.634248, 1500, '/assets/img/dining/restaurant_fris.jpg', '/assets/img/diningdetails/banner_restaurant_fris.jpg'),
(5, 'New Vegas', 'Koningstraat 5, 2011 TB Haarlem, Nederland', NULL, 'Vegan', 'New Vegas offers a modern dining experience with a diverse menu that caters to various tastes. Its contemporary ambiance makes it a popular choice for both locals and visitors.', 3, 35, 17.5, 52.381208, 4.634921, 550, '/assets/img/dining/new_vegas.jpeg', '/assets/img/diningdetails/banner_new_vegas.jpg'),
(6, 'Grand Cafe Brinkman', 'Grote Markt 13, 2011 RC Haarlem, Nederland', NULL, 'Dutch, European, Modern', 'Grand Café Brinkmann boasts a good beer selection with about 12 options on tap. The service is commendable, and guests can enjoy a pleasant dining experience without prior reservations.', 3, 35, 17.5, 52.381788, 4.636139, 600, '/assets/img/dining/grand_cafe_brinkman.jpg', '/assets/img/diningdetails/banner_grand_cafe_brinkman.jpg'),
(7, 'Urban Frenchy Bistro Toujours', 'Oude Groenmarkt 10-12, 2011 HL Haarlem, Nederland', NULL, 'Dutch, Fish and Seafood, European', 'Urban Frenchy Bistro Toujours combines a joyful interior with curious food and cocktails. Open seven days a week, it offers a vibrant atmosphere for lunch, dinner, or drinks.', 3, 35, 17.5, 52.380749, 4.637130, 750, '/assets/img/dining/urban_frenchy_bistro_toujours.jpg', '/assets/img/diningdetails/banner_urban_frenchy_bistro_toujours.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `RestaurantSlot`
--

CREATE TABLE `RestaurantSlot` (
  `slotID` int(11) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `restaurantID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `RestaurantSlot`
--

INSERT INTO `RestaurantSlot` (`slotID`, `startTime`, `endTime`, `capacity`, `restaurantID`) VALUES
(1, '18:00:00', '19:30:00', 37, 1),
(2, '19:30:00', '21:00:00', 35, 1),
(3, '21:00:00', '22:30:00', 35, 1),
(4, '17:00:00', '19:00:00', 52, 2),
(5, '19:00:00', '21:00:00', 52, 2),
(6, '21:00:00', '23:00:00', 52, 2),
(7, '17:00:00', '19:00:00', 60, 3),
(8, '19:00:00', '21:00:00', 60, 3),
(9, '17:30:00', '19:00:00', 45, 4),
(10, '19:00:00', '20:30:00', 45, 4),
(11, '20:30:00', '22:00:00', 45, 4),
(12, '17:00:00', '18:30:00', 36, 5),
(13, '18:30:00', '20:00:00', 36, 5),
(14, '20:00:00', '21:30:00', 36, 5),
(15, '16:30:00', '18:00:00', 100, 6),
(16, '18:00:00', '19:30:00', 100, 6),
(17, '19:30:00', '21:00:00', 100, 6),
(18, '17:30:00', '19:00:00', 48, 7),
(19, '19:00:00', '20:30:00', 48, 7),
(20, '20:30:00', '22:00:00', 48, 7);

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
  `role` enum('Admin','User','Employee') DEFAULT 'User',
  `registered_day` timestamp NULL DEFAULT current_timestamp(),
  `reset_token` varchar(128) DEFAULT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `reset_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `userName`, `password`, `mobilePhone`, `Email`, `role`, `registered_day`, `reset_token`, `verify_token`, `is_verified`, `reset_token_expires`) VALUES
(3, 'RobbenLe', '$2y$12$rCjjuXVAyTExvubsV5lDNuEoCRkVUYLEcdx/hGa5pPC/6B//eNUxa', 641653777, 'lehungrobben18@gmail.com', 'User', '2025-03-25 08:43:11', NULL, NULL, 0, NULL),
(4, 'Alex', '$2y$12$vZuFCpA8UFNhY0Vi1ZvUFO19IS7eJ4dWhVygMQMnaaKsWGi7JYeUi', 939441810, 'lehungrobben1811@gmail.com', 'Admin', '2025-03-26 12:41:23', NULL, NULL, 0, NULL);

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
  ADD PRIMARY KEY (`DanceTicketOrderID`),
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
-- Indexes for table `Lorentz`
--
ALTER TABLE `Lorentz`
  ADD PRIMARY KEY (`lorentzID`);

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
-- Indexes for table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `orderID` (`orderID`);

--
-- Indexes for table `pending_users`
--
ALTER TABLE `pending_users`
  ADD PRIMARY KEY (`pending_id`);

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
  ADD PRIMARY KEY (`slotID`),
  ADD KEY `fk_restaurantslot_restaurant` (`restaurantID`);

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
  MODIFY `albumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Artist`
--
ALTER TABLE `Artist`
  MODIFY `artistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Dance`
--
ALTER TABLE `Dance`
  MODIFY `danceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `DanceTicket`
--
ALTER TABLE `DanceTicket`
  MODIFY `danceTicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `DanceTicketOrder`
--
ALTER TABLE `DanceTicketOrder`
  MODIFY `DanceTicketOrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT for table `Lorentz`
--
ALTER TABLE `Lorentz`
  MODIFY `lorentzID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Order`
--
ALTER TABLE `Order`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `OrderItem`
--
ALTER TABLE `OrderItem`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_users`
--
ALTER TABLE `pending_users`
  MODIFY `pending_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `reservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ReservationSlot`
--
ALTER TABLE `ReservationSlot`
  MODIFY `reservationSlotID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Restaurant`
--
ALTER TABLE `Restaurant`
  MODIFY `restaurantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `RestaurantSlot`
--
ALTER TABLE `RestaurantSlot`
  MODIFY `slotID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `TicketType`
--
ALTER TABLE `TicketType`
  MODIFY `ticketTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `fk_danceticketorder` FOREIGN KEY (`danceTicketOrderID`) REFERENCES `DanceTicketOrder` (`DanceTicketOrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `DanceTicketOrder`
--
ALTER TABLE `DanceTicketOrder`
  ADD CONSTRAINT `FK_DanceTicketOrder_OrderItem` FOREIGN KEY (`orderItemID`) REFERENCES `OrderItem` (`orderItemID`) ON DELETE CASCADE;

--
-- Constraints for table `Payment`
--
ALTER TABLE `Payment`
  ADD CONSTRAINT `Payment_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `Order` (`orderID`) ON DELETE CASCADE;

--
-- Constraints for table `RestaurantSlot`
--
ALTER TABLE `RestaurantSlot`
  ADD CONSTRAINT `fk_restaurantslot_restaurant` FOREIGN KEY (`restaurantID`) REFERENCES `Restaurant` (`restaurantID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
