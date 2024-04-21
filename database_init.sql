-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 21 avr. 2024 à 23:06
-- Version du serveur : 8.0.31
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `webproject_library`
--
CREATE DATABASE IF NOT EXISTS `webproject_library` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `webproject_library`;

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `publication_year` int NOT NULL,
  `category` varchar(255) NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`book_id`, `title`, `author`, `editor`, `publication_year`, `category`, `stock`) VALUES
(1, 'Super titre', 'Moi', 'Padéditeur', 1975, 'Roman', 2),
(2, 'Les Misérables', 'Victor Hugo', 'Gallimard', 1862, 'Roman classique', 3),
(3, '1984', 'George Orwell', 'Secker & Warburg', 1949, 'Science-fiction', 5),
(4, 'Le Seigneur des Anneaux', 'J.R.R. Tolkien', 'Allen & Unwin', 1954, 'Fantasy', 3),
(5, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'Reynal & Hitchcock', 1943, 'Conte philosophique', 4),
(6, 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', 'Bloomsbury', 1997, 'Jeunesse', 5),
(7, 'Crime et Châtiment', 'Fiodor Dostoïevski', 'The Russian Messenger', 1866, 'Roman psychologique', 3),
(8, 'Orgueil et Préjugés', 'Jane Austen', 'T. Egerton, Whitehall', 1813, 'Roman romantique', 4),
(9, 'L\'Étranger', 'Albert Camus', 'Gallimard', 1942, 'Roman philosophique', 5),
(10, 'Guerre et Paix', 'Léon Tolstoï', 'The Russian Messenger', 1869, 'Roman historique', 2),
(11, 'Le Parfum', 'Patrick Süskind', 'Diogenes Verlag', 1985, 'Roman noir', 3),
(12, 'Les Trois Mousquetaires', 'Alexandre Dumas', 'Baudry', 1844, 'Roman d\'aventure', 3),
(13, 'Anna Karénine', 'Léon Tolstoï', 'The Russian Messenger', 1877, 'Roman réaliste', 2),
(14, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', 'Pétion', 1844, 'Roman d\'aventure', 3),
(15, 'Fahrenheit 451', 'Ray Bradbury', 'Ballantine Books', 1953, 'Science-fiction', 5),
(16, 'Don Quichotte', 'Miguel de Cervantes', 'Francisco de Robles', 1605, 'Roman de chevalerie', 2),
(17, 'Les Hauts de Hurlevent', 'Emily Brontë', 'Thomas Cautley Newby', 1847, 'Roman gothique', 4),
(18, 'Le Portrait de Dorian Gray', 'Oscar Wilde', 'Ward, Lock and Company', 1890, 'Roman fantastique', 5),
(19, 'Le Vieil Homme et la Mer', 'Ernest Hemingway', 'Charles Scribner\'s Sons', 1952, 'Roman philosophique', 5),
(20, 'Les Raisins de la colère', 'John Steinbeck', 'The Viking Press', 1939, 'Roman réaliste', 1),
(21, 'Voyage au bout de la nuit', 'Louis-Ferdinand Céline', 'Éditions Denoël', 1932, 'Roman noir', 3),
(22, 'Les Frères Karamazov', 'Fiodor Dostoïevski', 'The Russian Messenger', 1880, 'Roman philosophique', 4),
(23, 'Vingt mille lieues sous les mers', 'Jules Verne', 'Pierre-Jules Hetzel', 1870, 'Roman d\'aventure', 5),
(24, 'Le Tour du monde en quatre-vingts jours', 'Jules Verne', 'Pierre-Jules Hetzel', 1873, 'Roman d\'aventure', 5),
(25, 'Les Quatre Filles du docteur March', 'Louisa May Alcott', 'Roberts Brothers', 1868, 'Roman jeunesse', 3),
(26, 'Le Nom de la rose', 'Umberto Eco', 'Bompiani', 1980, 'Roman historique', 4),
(27, 'Moby Dick', 'Herman Melville', 'Richard Bentley', 1851, 'Roman d\'aventure', 4),
(28, 'Autant en emporte le vent', 'Margaret Mitchell', 'Macmillan Publishers', 1936, 'Roman historique', 3),
(29, 'Les Piliers de la Terre', 'Ken Follett', 'William Morrow and Company', 1989, 'Roman historique', 4),
(30, 'Le Journal d\'Anne Frank', 'Anne Frank', 'Contact Publishing', 1947, 'Journal intime', 2),
(31, 'Matilda', 'Roald Dahl', 'Jonathan Cape', 1988, 'Jeunesse', 5),
(32, 'Les Aventures de Tom Sawyer', 'Mark Twain', 'Charles L. Webster And Company', 1876, 'Roman jeunesse', 4),
(33, 'Les Aventures d\'Alice au pays des merveilles', 'Lewis Carroll', 'Macmillan', 1865, 'Roman jeunesse', 4),
(34, 'Les Enfants du capitaine Grant', 'Jules Verne', 'Pierre-Jules Hetzel', 1868, 'Roman d\'aventure', 4),
(35, 'La Guerre et la Paix', 'Léon Tolstoï', 'The Russian Messenger', 1869, 'Roman historique', 2);

-- --------------------------------------------------------

--
-- Structure de la table `bookloan`
--

DROP TABLE IF EXISTS `bookloan`;
CREATE TABLE IF NOT EXISTS `bookloan` (
  `book_id` int NOT NULL,
  `consumer_id` int NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  KEY `FK_bookloan_to_book` (`book_id`),
  KEY `FK_bookloan_to_consumer` (`consumer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bookloan`
--

INSERT INTO `bookloan` (`book_id`, `consumer_id`, `date_start`, `date_end`) VALUES
(1, 1, '2024-04-14', '2024-04-30');

-- --------------------------------------------------------

--
-- Structure de la table `consumer`
--

DROP TABLE IF EXISTS `consumer`;
CREATE TABLE IF NOT EXISTS `consumer` (
  `consumer_id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`consumer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `consumer`
--

INSERT INTO `consumer` (`consumer_id`, `firstname`, `lastname`, `birthdate`, `mail`, `password`) VALUES
(1, 'Michel', 'Samba', '1946-01-31', 'michel.samba@gmiel.com', '$2y$10$pSNKCsO.PpTjJhot.f7Yd.Gpl0ZDNpvfcnoVAt0RcEBcwU9CbJ4dq');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
