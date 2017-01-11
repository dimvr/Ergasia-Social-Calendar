-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2017 at 03:02 AM
-- Server version: 5.5.52-MariaDB-cll-lve
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `events_id` int(11) NOT NULL,
  `events_users_id` int(11) NOT NULL DEFAULT '0',
  `events_users_name` varchar(64) NOT NULL DEFAULT '',
  `events_date` date NOT NULL DEFAULT '0001-01-01',
  `events_time` time NOT NULL DEFAULT '00:00:00',
  `events_title` varchar(128) NOT NULL DEFAULT '',
  `events_description` varchar(512) NOT NULL DEFAULT '',
  `events_datetime_inserted` datetime NOT NULL DEFAULT '0001-01-01 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`events_id`, `events_users_id`, `events_users_name`, `events_date`, `events_time`, `events_title`, `events_description`, `events_datetime_inserted`) VALUES
(72, 7, 'Λίνα Παπαδοπούλου', '2017-01-11', '19:30:00', 'Ψάρεμα στη λίμνη', 'Ψάρεμα στη λίμνη Βιστωνίδα μαζί με την αντιπροσωπεία από τη Μονή Βατοπεδίου', '2017-01-08 02:49:46'),
(71, 13, 'ΧΑΡΗΣ ΧΡΥΣΟΧΟΟΥ', '2017-01-13', '23:30:00', 'Νέο δοκιμαστικό', 'Δοκιμή κοινοποίησης με τον SMTP Google ddanewcalendar@gmail.com', '2017-01-08 02:46:06'),
(64, 9, 'Tania Sikotidou', '2017-01-02', '13:00:00', 'Ονειρούπολη', 'Επίσκεψη στην Ονειρούπολη με τα παιδιά!!', '2017-01-02 09:44:14'),
(69, 13, 'ΧΑΡΗΣ ΧΡΥΣΟΧΟΟΥ', '2017-01-10', '14:30:00', 'Δοκιμαστικό Γεγονός', 'Δοκιμαστικό γεγονός του DDA Calendar', '2017-01-08 00:54:14'),
(70, 12, 'CHARIS CHRISOCHOOU', '2017-01-12', '10:00:00', 'Συναυλία Χάρη', 'Συναυλία Χάρη στο Danforth Music Hall του Toronto στον Καναδά', '2017-01-08 01:07:42'),
(67, 9, 'Tania Sikotidou', '2017-01-06', '12:30:00', 'μαθημα προγραμματισμου', 'Θα γίνει χαμός λέμε!!!', '2017-01-02 17:13:29'),
(68, 11, 'DESPOINA BASDEKI', '2017-01-06', '10:00:00', 'Δοκιμαστικό γεγονός', 'ΔΟκιμαστικο γεγονος!', '2017-01-05 20:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `events_alerts`
--

DROP TABLE IF EXISTS `events_alerts`;
CREATE TABLE `events_alerts` (
  `events_alerts_id` int(11) NOT NULL,
  `events_alerts_events_id` int(11) NOT NULL DEFAULT '0',
  `events_alerts_users_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events_alerts`
--

INSERT INTO `events_alerts` (`events_alerts_id`, `events_alerts_events_id`, `events_alerts_users_id`) VALUES
(9, 69, 12),
(2, 63, 7),
(3, 64, 7),
(4, 65, 7),
(5, 65, 9),
(6, 65, 8),
(8, 69, 7),
(10, 69, 8),
(11, 69, 9),
(12, 69, 10),
(13, 69, 11),
(14, 70, 13),
(15, 70, 7),
(16, 70, 8),
(17, 70, 9),
(18, 70, 10),
(19, 70, 11),
(20, 71, 7),
(21, 72, 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `users_logged_in` enum('0','1') NOT NULL DEFAULT '0',
  `firstname` varchar(128) NOT NULL DEFAULT '',
  `lastname` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(96) NOT NULL DEFAULT '',
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(256) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_logged_in`, `firstname`, `lastname`, `email`, `username`, `password`) VALUES
(13, '0', 'ΧΑΡΗΣ', 'ΧΡΥΣΟΧΟΟΥ', 'lebrand2009@hotmail.com', 'lebrand', '$6$rounds=5000$587170b124601$GwPl7kdrH7AOzNULVcDYiQePtGqQLyNquVQd03M4EFsVwikUV.lROFzB271VohGsJj8/YSNYm23TSga8OjowD1'),
(7, '0', 'Λίνα', 'Παπαδοπούλου', 'lpap13@gmail.com', 'lina', '$6$rounds=5000$58547c6f96020$IDEU8zMOCFoHZK4iXXvkixErIZHOeUoPp5eijr50GaZp1Y72.aV8cQIUh1XlcnixxnDExEEyfaDHJUl7ATLqL0'),
(12, '0', 'CHARIS', 'CHRISOCHOOU', 'lebrand2009@gmail.com', 'charis', '$6$rounds=5000$58716cd2db14f$xzJ1hUD5yuiHehEYVngtUyRsXhuTXtBndsCMJ7Ur7kYKwAO49y4LgnjDzGgAi01P79WZyk2nsiKkd4BLb8a1x.'),
(8, '0', 'dim', 'vr', 'jimmas26@gmail.com', 'dimvr', '$6$rounds=5000$585bfd58469ff$NGcTwd7rswvD1A6EQcsmKUv4fKWP9Yu3pLcPr2XuWQslPGVeq42DSuCLR13ycwrdRCTCHXkGfSIUh617.p/JH/'),
(9, '0', 'Tania', 'Sikotidou', 'tania@dramanet.gr', 'tania', '$6$rounds=5000$586a048515bc0$rAjR7UkVTwmOJeMth/baKJulwW5wGMf3IpSbYEdw8w/.flbUShzXS2d2lDcewwCbzB87aC5l/vNQuXkeiXFEx1'),
(10, '0', 'giannis', 'papad', 'gpap@gmail.com', 'gpap', '$6$rounds=5000$586d5d5f41330$QtC4EHmJBUQHYH.aX3s5nPzzFHKNP2BX9C08hKQNaxYOZ.vkz/diveX5CJTv37A53rY7BFJtzK35RtF4OHCaY0'),
(11, '0', 'DESPOINA', 'BASDEKI', 'debbiek1322@yahoo.gr', 'debbiek1322', '$6$rounds=5000$586e8dd78cfaf$Pxn/ThGfrQIJLeBaqa64MWeYDKDjKJidn/Fa5ghG846TaqJ.zJQCxTPAyey2pLEydIeJ6dHsE.ff9q5ezRBxC.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`events_id`);

--
-- Indexes for table `events_alerts`
--
ALTER TABLE `events_alerts`
  ADD PRIMARY KEY (`events_alerts_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `events_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `events_alerts`
--
ALTER TABLE `events_alerts`
  MODIFY `events_alerts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;