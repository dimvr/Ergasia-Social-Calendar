-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost:3306
-- Χρόνος δημιουργίας: 15 Νοε 2016 στις 14:54:37
-- Έκδοση διακομιστή: 5.5.52-cll-lve
-- Έκδοση PHP: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Βάση: `diforozi_mycalendar`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `created_at`) VALUES
(1, 'Î›Î¹Î½Î±', 'Î Î±Ï€Î±Î´Î¿Ï€Î¿Ï…Î»Î¿Ï…', 'lpap13@gmai.com', 'Lina', '4cd4c5a2ea6b375daebe117c963d084b', '2016-11-15 06:47:19'),
(2, 'lina', 'papa', 'lpap13@gmail.com', 'lina', '4cd4c5a2ea6b375daebe117c963d084b', '2016-11-15 07:53:09'),
(3, 'Î”ÎµÏƒÏ€Î¿Î¹Î½Î±', 'Îœ', 'debbiek1322@yahoo.gr', 'Debbie', '202cb962ac59075b964b07152d234b70', '2016-11-15 09:26:46'),
(4, 'Dimitris', 'Vrekos', 'dimitrisvrekos@yahoo.gr', 'dimvr', '6ffa1250b3ab4c6d941b75b8f6912013', '2016-11-15 12:20:51');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
