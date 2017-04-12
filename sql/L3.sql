-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 12 Avril 2017 à 19:24
-- Version du serveur: 5.5.54-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `L3`
--

-- --------------------------------------------------------

--
-- Structure de la table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `Question`
--

CREATE TABLE IF NOT EXISTS `Question` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `points` int(10) NOT NULL,
  `date` int(10) NOT NULL,
  `reported` int(10) NOT NULL,
  `subject_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `Question`
--

INSERT INTO `Question` (`id`, `title`, `content`, `points`, `date`, `reported`, `subject_id`, `user_id`) VALUES
(2, 'Ma question 1', 'azaefdzedfv', 0, 1490798650, 1, 6, 51),
(5, 'azeeaz', 'azeaz''', 0, 1490968960, 0, 6, 51),
(6, 'reztttrez', 'aerhjgrerzreryfjtdrerzrthrerzeze????''', 0, 1490968993, 1, 6, 51),
(7, 'Emploi à bordeaux', 'du travail encore du travail', 0, 1492001665, 0, 6, 51),
(8, 'azerghjg', 'erzretghjvgfrez', 0, 1492002307, 0, 2, 51),
(9, 'azerghjg', 'erzretghjvgfrez', 0, 1492002652, 1, 2, 51),
(10, 'azerghjg', 'erzretghjvgfrez', 0, 1492002761, 1, 2, 51),
(11, 'eazrtyh', 'eztyjghyer', 0, 1492002765, 0, 2, 51),
(12, 'eazrtyh', 'eztyjghyer', 0, 1492002863, 0, 2, 51),
(13, 'aezrejfhhdrtezaezrjh', 'erzaezrtyjfjtrye', 0, 1492005597, 0, 2, 51),
(14, 'aaaaaaaa', 'bbbbbbbbb', 0, 1492005880, 1, 2, 51),
(15, 'azetrsjr', 'zrertyjretrzethgjerzghe', 0, 1492005934, 0, 2, 51),
(16, 'éeze', 'azezaeaz', 0, 1492005971, 0, 2, 51),
(17, 'ezrtrsgt', 'zeqehjgf', 0, 1492006012, 0, 2, 51),
(18, 'revbnterhjretfherezdffsd', '', 0, 1492006186, 0, 2, 51),
(20, 'eazertjhrez', 'zerthrtezae', 0, 1492006918, 0, 2, 51);

-- --------------------------------------------------------

--
-- Structure de la table `Response`
--

CREATE TABLE IF NOT EXISTS `Response` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 NOT NULL,
  `points` int(10) NOT NULL,
  `date` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `question_id` int(10) NOT NULL,
  `reported` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `Reponse_ibfk_1` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `Response`
--

INSERT INTO `Response` (`id`, `content`, `points`, `date`, `user_id`, `question_id`, `reported`) VALUES
(6, '"', 0, 1490969091, 51, 6, 0),
(7, '''', 0, 1490969096, 51, 6, 0),
(9, 'Bonjour voila', 0, 1491137374, 51, 2, 1),
(10, 'oui ca va', 0, 1491137380, 51, 2, 0),
(11, 'saluuuuuuuuuuut', 0, 1492008786, 51, 17, 0),
(12, 'zeaefdsddf', 0, 1492008818, 51, 17, 0),
(13, 'ezrrgf', 0, 1492008822, 51, 17, 0),
(14, 'zerghgredg', 0, 1492009717, 51, 14, 1),
(15, 'ezrhhgr', 0, 1492009719, 51, 14, 1),
(16, 'zrertyjdg', 0, 1492009720, 51, 14, 1),
(17, 'zertjfyhtr', 0, 1492009722, 51, 14, 1),
(18, 'ertgdfs', 0, 1492009724, 51, 14, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Service`
--

CREATE TABLE IF NOT EXISTS `Service` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `date_start` int(20) NOT NULL,
  `date_end` int(20) NOT NULL,
  `reported` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `category_id_2` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `Service`
--

INSERT INTO `Service` (`id`, `user_id`, `name`, `description`, `date_start`, `date_end`, `reported`, `category_id`) VALUES
(1, 0, 'aide de domicile', 'hahahahahha', 2017, 2017, 0, 1),
(2, 0, 'test', 'gggggg', 2017, 2017, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ServiceStatus`
--

CREATE TABLE IF NOT EXISTS `ServiceStatus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `service_id` int(10) NOT NULL,
  `status_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `ServiceStatus`
--

INSERT INTO `ServiceStatus` (`id`, `service_id`, `status_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Status`
--

CREATE TABLE IF NOT EXISTS `Status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `Status`
--

INSERT INTO `Status` (`id`, `name`) VALUES
(1, 'Testeur');

-- --------------------------------------------------------

--
-- Structure de la table `Subject`
--

CREATE TABLE IF NOT EXISTS `Subject` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `Subject`
--

INSERT INTO `Subject` (`id`, `name`) VALUES
(2, 'Santé'),
(3, 'Aide à domicile'),
(6, 'Emploi'),
(7, 'azerfgr'),
(11, 'sujet 2'),
(15, 'azereqsd');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(30) CHARACTER SET utf8 NOT NULL,
  `firstname` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(64) CHARACTER SET utf8 NOT NULL,
  `isadmin` int(1) NOT NULL DEFAULT '0',
  `isbanned` int(1) DEFAULT '0',
  `phone` int(10) DEFAULT NULL,
  `email` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`id`, `lastname`, `firstname`, `password`, `username`, `isadmin`, `isbanned`, `phone`, `email`) VALUES
(37, 'Teneur', 'Clovis', 'Test', '', 0, 0, NULL, NULL),
(50, 'riou', 'max', '$2y$10$.rkB02E2QY9YbLNBQqXPuuaFAPQUEu5TMLN4ik5ou8bTM7b4DO9Iu', 'max.riou', 0, 1, NULL, NULL),
(51, 'root', 'root', '$2y$10$A1f8EHKqGnWhhhhYRG8x9.bH07WzBSAX5ccq3A0GOYTz5L1HQ.fWC', 'root.root', 1, 0, NULL, NULL),
(52, 'name', 'user3', '$2y$10$lKbCp4R31.nQzOdSUgRycuQdWuvpk2e6ALLK4LLdoFXcwVVo90zMm', 'user3.name', 0, 1, NULL, NULL),
(53, 'name', 'user4', '$2y$10$.nIehQiEi5CQE5bc3j0e..oq0IWKzrDvLEkEQ1/6ae2bpmg5v3kR2', 'user4.name', 0, 1, NULL, NULL),
(54, 'name', 'user5', '$2y$10$lyUSiuS1gTGCzuHX3Wc3R.LOdNf4RIkb7JVFpMN72pW61TmL73bQi', 'user5.name', 0, 1, NULL, NULL),
(56, 'riit', 'riit', '$2y$10$hp6sr6syK9zdVvjpdFsi3eB4JNvqqkY6xmWC6Warz.ue1onGS8.EO', 'riit.riit', 0, 0, NULL, NULL),
(77, 'maxence', 'riou', '$2y$10$A1f8EHKqGnWhhhhYRG8x9.bH07WzBSAX5ccq3A0GOYTz5L1HQ.fWC', 'riou.maxence', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `UserService`
--

CREATE TABLE IF NOT EXISTS `UserService` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `service_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `UserStatus`
--

CREATE TABLE IF NOT EXISTS `UserStatus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `status_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `statut_id` (`status_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `UserStatus`
--

INSERT INTO `UserStatus` (`id`, `user_id`, `status_id`) VALUES
(1, 37, 1),
(2, 56, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `Question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Question_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `Subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Response`
--
ALTER TABLE `Response`
  ADD CONSTRAINT `Reponse_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Response_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Service`
--
ALTER TABLE `Service`
  ADD CONSTRAINT `Service_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ServiceStatus`
--
ALTER TABLE `ServiceStatus`
  ADD CONSTRAINT `ServiceStatus_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `Service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ServiceStatus_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `Status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `UserService`
--
ALTER TABLE `UserService`
  ADD CONSTRAINT `UserService_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserService_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `Service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `UserStatus`
--
ALTER TABLE `UserStatus`
  ADD CONSTRAINT `UserStatus_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserStatus_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `Status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
